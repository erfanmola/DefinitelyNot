<?php

[,, $blockchain] = splitPipe($callback_data);

EditMessageReplyMarkup($callback_chat_id, $callback_msg_id, [
	'inline_keyboard' => [],
]);

$answer = td(t('callback_query.custom_asset.answer', $user['locale']), [
	'type' => $blockchain,
]);
$show_alert = true;

setState($callback_from_id, $redis, joinPipe('alert', 'custom'), [
	'blockchain' => $blockchain,
]);

SendMessage($callback_chat_id, td(t('callback_query.custom_asset.answer', $user['locale']), [
	'type' => $blockchain,
]), $callback_msg_id);
