<?php

require __DIR__ . "/../../pipelines/define_user_alerts.php";

[,, $alert_id] = splitPipe($callback_data);

$alert_index = array_search($alert_id, array_column($user['alerts'], 'id'));

if ($alert_index > -1) {
	$alert = $user['alerts'][$alert_index];

	EditMessageText($callback_chat_id, $callback_msg_id, td(
		t('callback_query.alerts.info.text', $user['locale']),
		[
			'alert' => generateAlertsListText([$alert], $user['locale']),
		]
	), null, [
		'reply_markup' => [
			'inline_keyboard' => [
				[
					[
						'text' => t('callback_query.alerts.info.buttons.delete', $user['locale']),
						'callback_data' => joinPipe('alert', 'del', $alert['id']),
					],
				],
				[
					[
						'text' => t('general.back', $user['locale']),
						'callback_data' => 'alerts',
					],
				],
			],
		],
	]);

	$answer = t('callback_query.alerts.info.answer', $user['locale']);
}
