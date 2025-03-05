<?php

use OpenSwoole\Coroutine;

[,, $wallet_id, $trade_type] = splitPipe($callback_data);

$wallet_index = array_search($wallet_id, array_column($user['wallets'], 'id'));

if ($wallet_index > -1) {
	$wallet = $user['wallets'][$wallet_index];

	EditMessageReplyMarkup($callback_chat_id, $callback_msg_id, [
		'inline_keyboard' => [],
	]);

	$answer = td(t('callback_query.trade_custom.answer', $user['locale']), [
		'type' => $wallet['type'],
	]);
	$show_alert = true;

	setState($callback_from_id, $redis, joinPipe('trade', 'custom'), [
		'type' => $trade_type,
		'wallet_id' => $wallet['id'],
		'blockchain' => $wallet['type'],
	]);

	SendMessage($callback_chat_id, td(t('callback_query.trade_custom.answer', $user['locale']), [
		'type' => $wallet['type'],
	]), $callback_msg_id);
}
