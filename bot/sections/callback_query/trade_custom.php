<?php

[,, $wallet_id] = splitPipe($callback_data);

$wallet_index = array_search($wallet_id, array_column($user['wallets'], 'id'));

if ($wallet_index > -1) {
	$wallet = $user['wallets'][$wallet_index];

	SendMessage($callback_chat_id, td(t('callback_query.trade_custom.answer', $user['locale']), [
		'type' => $wallet['type'],
	]), $callback_msg_id);

	$answer = td(t('callback_query.trade_custom.answer', $user['locale']), [
		'type' => $wallet['type'],
	]);
	$show_alert = true;

	// TODO: set the state and manage it onwards
}
