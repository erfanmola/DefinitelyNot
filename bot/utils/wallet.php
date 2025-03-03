<?php

use OpenSwoole\Coroutine;

function getWallets(int|string $user_id, mixed &$conn): array | null
{
	return DPXDBQuery('wallets', '*', ['user_id' => $user_id], casts: [
		'id'       => 'number',
		'user_id'  => 'number',
		'mnemonic' => 'array',
		'balance'  => 'double',
	], single_result: false, conn: $conn);
}

function createWallet(int|string $user_id, string $type, mixed &$conn): array | null
{
	$type = strtoupper($type);
	$result = requestController('/wallet/create', [
		'type' => $type,
	]);

	if (isset($result['wallet'])) {
		DPXDBInsert('wallets', [
			'user_id'     => $user_id,
			'type'        => $type,
			'address'     => $result['wallet']['address'],
			'public_key'  => $result['wallet']['publicKey'],
			'secret_key'  => $result['wallet']['secretKey'],
			'mnemonic'    => $result['wallet']['mnemonic'],
		], $conn);

		return [
			...$result['wallet'],
			'balance' => 0,
		];
	}

	return null;
}

function getWalletBalance(string $type, string $address, mixed &$conn): float
{
	global $cacheTableBalance;

	return $cacheTableBalance->get(joinPipe($type, $address), function () use (&$type, &$address, &$conn) {
		$type = strtoupper($type);
		$result = requestController('/wallet/balance', [
			'type'    => $type,
			'address' => $address,
		]);

		$balance = (float)($result['balance'] ?? 0);

		$oldBalance = (float)DPXDBQuery(
			'wallets',
			['balance'],
			['address' => $address, 'type' => $type],
			casts: ['balance' => 'double'],
			conn: $conn
		)['balance'] ?? 0;

		if ($balance < 0) {
			return $oldBalance;
		}

		if ($balance !== $oldBalance) {
			DPXDBUpdate(
				'wallets',
				[
					'balance' => $balance,
				],
				['address' => $address, 'type' => $type],
				$conn
			);
		}

		return $balance;
	}, config['CACHE_TABLE_BALANCE_TIME']);
}

function truncateWalletAddress($address, $firstLength = 6, $lastLength = 4)
{
	$length = strlen($address);

	if ($length <= ($firstLength + $lastLength)) {
		return $address;
	}

	$firstPart = substr($address, 0, $firstLength);
	$lastPart = substr($address, -$lastLength);

	return $firstPart . '...' . $lastPart;
}

function syncWalletsBalanceDeferred(array $wallets)
{
	Coroutine::defer(function () use (&$wallets) {
		$mysqli = ConnectionPoolManager::getMySQLiConnection();
		foreach ($wallets as $wallet) {
			getWalletBalance($wallet['type'], $wallet['address'], $mysqli);
		}
		ConnectionPoolManager::releaseMySQLiConnection($mysqli);
	});
}

function deleteWallet(string $type, string $address, mixed &$conn): void
{
	$type = strtoupper($type);

	$wallet = DPXDBQuery('wallets', ['user_id', 'id'], [
		'type' => $type,
		'address' => $address,
	], conn: $conn);

	if ($wallet) {
		$conditions = DPXDBQuery('trade_conditions', ['id'], [
			'wallet_id' => $wallet['id']
		], single_result: false, conn: $conn);

		foreach ($conditions as $condition) {
			deleteTradeCondition($condition['id'], $conn);
		}
	}

	DPXDBDelete('wallets', [
		'type' => $type,
		'address' => $address,
	], conn: $conn);
}
