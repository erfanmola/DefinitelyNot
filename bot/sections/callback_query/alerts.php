<?php

require __DIR__ . "/../../pipelines/define_user_alerts.php";

EditMessageText($callback_chat_id, $callback_msg_id, td(t('callback_query.alerts.text', $user['locale']), [
	'count'   => count($user['alerts']),
	'max'     => config['ALERTS_ACTIVE_MAX'],
	'alerts' => generateAlertsListText($user['alerts'], $user['locale']),
]), null, [
	'reply_markup' => [
		'inline_keyboard' => [
			...array_map(fn($alert) => [
				[
					'text' => joinSpace(
						blockchain_emoji[$alert['blockchain']],
						alert_types[$alert['type']],
						'|',
						($alert['asset_address'] === '~')
							? ($alert['blockchain'])
							: ($alert['asset']['symbol'] ?? truncateWalletAddress($alert['asset_address'], 3, 3)),
						'|',
						priceFormat($alert['price']),
					),
					'callback_data' => joinPipe('alert', 'info', $alert['id']),
				],
			], $user['alerts']),
			[
				[
					'text' => t('callback_query.alerts.buttons.new', $user['locale']),
					'callback_data' => joinPipe('create', 'alert'),
				],
			],
			[
				[
					'text' => t('general.back', $user['locale']),
					'callback_data' => 'default',
				],
			],
		],
	],
]);

$answer = t('callback_query.alerts.answer', $user['locale']);
