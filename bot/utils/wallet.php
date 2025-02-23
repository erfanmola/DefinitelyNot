<?php

function getWallets(int|string $user_id, mixed $conn): array | null
{
	return DPXDBQuery('wallets', '*', ['user_id' => $user_id], casts: [
		'id'       => 'number',
		'user_id'  => 'number',
		'mnemonic' => 'array',
		'balance'  => 'double',
	], single_result: false, conn: $conn);
}

function createWallet(int|string $user_id, string $type, mixed $conn): array | null
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

function getWalletBalance(int|string $user_id, string $type, string $address, mixed $conn): float
{
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
}
