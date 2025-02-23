<?php

$user = getUser($from_id ?? $callback_from_id, '*', $mysqli);
$user_params = [
	'user_id'    => $from_id ?? $callback_from_id,
	'first_name' => $from_name ?? $callback_from_name,
	'last_name'  => $from_lastname ?? $callback_from_lastname ?? null,
	'username'   => $from_username ?? $callback_from_username ?? null,
	// 'locale'     => $from_language_code ?? $callback_from['language_code'] ?? 'en',
];

if ($user) {
	$user_params_diff = array_filter(array_keys($user_params), function ($index) use ($user_params, $user) {
		return $user_params[$index] != $user[$index];
	});

	if (count($user_params_diff) > 0) {
		updateUser(
			$from_id ?? $callback_from_id,
			array_combine($user_params_diff, array_map(fn($index) => $user_params[$index], $user_params_diff)),
			$mysqli
		);

		foreach ($user_params_diff as $index) {
			$user[$index] = $user_params[$index];
		}
	}
} else {
	$user = createUser($user_params, $mysqli);
	$user['locale'] = 'en';
}

$user['wallets'] = getWallets($user['user_id'], $mysqli);

if (empty($user['wallets'])) {
	$user['wallets'] = [
		createWallet($user['user_id'], 'TON', $mysqli),
		createWallet($user['user_id'], 'SOL', $mysqli),
	];
}
