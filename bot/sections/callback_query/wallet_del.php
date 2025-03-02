<?php

[,, $wallet_id] = splitPipe($callback_data);

$wallet_index = array_search($wallet_id, array_column($user['wallets'], 'id'));

if ($wallet_index > -1) {
	$wallet = $user['wallets'][$wallet_index];

	$keyboard = array_fill(0, 25, [
		'text' => '⏺️',
		'callback_data' => joinPipe('wallet', 'info', $wallet['id']),
	]);
	$keyboard[mt_rand(0, 25)] = [
		'text' => '⏹️',
		'callback_data' => joinPipe('wallet', 'delete', $wallet['id']),
	];

	EditMessageText($callback_chat_id, $callback_msg_id, td(
		t('callback_query.wallet_del.text', $user['locale']),
		[
			'wallet' => generateWalletsListText([$wallet], $user['locale']),
		]
	), null, [
		'reply_markup' => [
			'inline_keyboard' => array_chunk($keyboard, 5),
		],
	]);

	$answer = t('callback_query.wallet_del.answer', $user['locale']);

	syncWalletsBalanceDeferred([$wallet]);
}
