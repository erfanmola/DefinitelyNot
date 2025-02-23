<?php

$sent_message = SendMessage($from_id, generateMessageDefaultText($user), $msg_id, [
	'reply_markup' => [
		'inline_keyboard' => generateMessageDefaultButtons($user),
	],
], true);

$balances = PromiseAll::all(
	array_map(
		fn($wallet) => fn() => [
			'type'    => $wallet['type'],
			'address' => $wallet['address'],
			'balance' => getWalletBalance($wallet['type'], $wallet['address'], $mysqli)
		],
		$user['wallets']
	)
);

$balance_changed = false;

foreach ($balances as $walletData) {
	foreach ($user['wallets'] as $key => $wallet) {
		if (! ($wallet['address'] === $walletData['address']
			&& $wallet['type'] === $walletData['type'])) continue;

		if ($user['wallets'][$key]['balance'] !== $walletData['balance']) {
			$balance_changed = true;
			$user['wallets'][$key]['balance'] = $walletData['balance'];
		}
	}
}

if ($balance_changed) {
	EditMessageText($chat_id, $sent_message['result']['message_id'], generateMessageDefaultText($user), null, [
		'reply_markup' => [
			'inline_keyboard' => generateMessageDefaultButtons($user),
		],
	]);
}
