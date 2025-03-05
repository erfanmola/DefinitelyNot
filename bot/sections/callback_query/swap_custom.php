<?php

[,, $wallet_id] = splitPipe($callback_data);

$wallet_index = array_search($wallet_id, array_column($user['wallets'], 'id'));

if ($wallet_index > -1) {
	$wallet = $user['wallets'][$wallet_index];
	$blockchain = $wallet['type'];

	EditMessageReplyMarkup($callback_chat_id, $callback_msg_id, [
		'inline_keyboard' => [],
	]);

	$answer = td(t('callback_query.custom_asset.answer', $user['locale']), [
		'type' => $blockchain,
	]);
	$show_alert = true;

	setState($callback_from_id, $redis, joinPipe('swap', 'custom'), [
		'blockchain' => $blockchain,
	]);

	SendMessage($callback_chat_id, td(t('callback_query.custom_asset.answer', $user['locale']), [
		'type' => $blockchain,
	]), $callback_msg_id);
}
