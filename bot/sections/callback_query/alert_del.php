<?php

require __DIR__ . "/../../pipelines/define_user_alerts.php";

[,, $alert_id] = splitPipe($callback_data);

$alert_index = array_search($alert_id, array_column($user['alerts'], 'id'));

if ($alert_index > -1) {
	$alert = $user['alerts'][$alert_index];

	$keyboard = array_fill(0, 25, [
		'text' => '⏺️',
		'callback_data' => joinPipe('alert', 'info', $alert['id']),
	]);
	$keyboard[mt_rand(0, 25)] = [
		'text' => '⏹️',
		'callback_data' => joinPipe('alert', 'delete', $alert['id']),
	];

	EditMessageText($callback_chat_id, $callback_msg_id, td(
		t('callback_query.alerts.delete.text', $user['locale']),
		[
			'alert' => generateAlertsListText([$alert], $user['locale']),
		]
	), null, [
		'reply_markup' => [
			'inline_keyboard' => array_chunk($keyboard, 5),
		],
	]);

	$answer = t('callback_query.alerts.delete.answer', $user['locale']);
}
