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

function createWallet(int|string $user_id, string $blockchain, mixed &$conn): array | null
{
	$blockchain = strtoupper($blockchain);
	$result = requestController('/wallet/create', [
		'type' => $blockchain,
	]);

	if (isset($result['wallet'])) {
		SyncDBInsert('wallets', [
			'user_id'     => $user_id,
			'type'        => $blockchain,
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

function getWalletBalance(string $blockchain, string $address, mixed &$conn): float
{
	global $cacheTableBalance;

	return $cacheTableBalance->get(joinPipe($blockchain, substr($address, 0, 12)), function () use (&$blockchain, &$address, &$conn) {
		$blockchain = strtoupper($blockchain);
		$result = requestController('/wallet/balance', [
			'type'    => $blockchain,
			'address' => $address,
		]);

		$balance = (float)($result['balance'] ?? 0);

		$oldBalance = (float)DPXDBQuery(
			'wallets',
			['balance'],
			['address' => $address, 'type' => $blockchain],
			casts: ['balance' => 'double'],
			conn: $conn
		)['balance'] ?? 0;

		if ($balance < 0) {
			return $oldBalance;
		}

		if ($balance !== $oldBalance) {
			SyncDBUpdate(
				'wallets',
				[
					'balance' => $balance,
				],
				['address' => $address, 'type' => $blockchain],
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

function deleteWallet(string $blockchain, string $address, mixed &$conn): void
{
	$blockchain = strtoupper($blockchain);

	$wallet = DPXDBQuery('wallets', ['user_id', 'id'], [
		'type' => $blockchain,
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
		'type' => $blockchain,
		'address' => $address,
	], conn: $conn);
}

function getWalletAssetBalance(string $blockchain, string $address, string $asset): float
{
	global $cacheTableAssetsBalance;

	return $cacheTableAssetsBalance->get(joinPipe($blockchain, substr($address, 0, 12), substr($asset, 0, 12)), function () use (&$blockchain, &$address, &$asset) {
		$blockchain = strtoupper($blockchain);
		$result = requestController('/wallet/assets', [
			'type'    => $blockchain,
			'address' => $address,
			'assets'  => [
				$asset,
			]
		]);

		return $result['assets'][$asset] ?? 0;
	}, config['CACHE_TABLE_ASSETS_BALANCE_TIME']);
}

function swapAsset(int|string $user_id, string $blockchain, string $address, string $secret, string $offer, float $offer_amount, string $ask)
{
	Coroutine::defer(function () use (&$user_id, &$blockchain, &$address, &$secret, &$offer, &$offer_amount, &$ask) {
		$result = requestController('/assets/swap', [
			'type' => $blockchain,
			'swap' => [
				'offerAddress' => $offer,
				'askAddress'   => $ask,
				'offerUnits'   => $offer_amount,
				'walletCredentials' => [
					'address' => $address,
					'secret'  => $secret,
				],
			]
		]);

		global $tableJettons, $tableTokens;

		$offer_symbol = match ($offer) {
			'TON' => 'TON',
			'SOL' => 'SOL',
			default => match ($blockchain) {
				'TON' => $tableJettons->get($offer, 'symbol') ?? null,
				'SOL' => $tableTokens->get($offer, 'symbol') ?? null,
			},
		} ?? truncateWalletAddress($offer, 3, 3);

		$ask_symbol = match ($ask) {
			'TON' => 'TON',
			'SOL' => 'SOL',
			default => match ($blockchain) {
				'TON' => $tableJettons->get($ask, 'symbol') ?? null,
				'SOL' => $tableTokens->get($ask, 'symbol') ?? null,
			},
		} ?? truncateWalletAddress($ask, 3, 3);

		$params = [
			'from' => joinSpace($offer_amount, $offer_symbol),
			'to' => $ask_symbol,
		];

		if ($result && isset($result['swap']) && $result['swap'] === true) {
			SendMessage($user_id, td(t('callback_query.swap.transaction.success', 'en'), $params));
		} else {
			SendMessage($user_id, td(t('callback_query.swap.transaction.failed', 'en'), $params));
		}
	});
}
