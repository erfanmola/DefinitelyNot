<?php

if ($user) {
	$user['wallets'] = getWallets($user['user_id'], $mysqli);

	if (empty($user['wallets'])) {
		$user['wallets'] = [
			createWallet($user['user_id'], 'TON', $mysqli),
			createWallet($user['user_id'], 'SOL', $mysqli),
		];
	}
}
