<?php

[, $blockchain, $asset_address] = splitPipe($callback_data);

if ($asset_address === '~') {
	$asset = ['symbol' => $blockchain];
} else {
	$asset = match ($blockchain) {
		'TON' => $tableJettons->get($asset_address),
		'SOL' => $tableTokens->get($asset_address),
	};
}

EditMessageText($callback_chat_id, $callback_msg_id, td(
	t('callback_query.alerts.type.text', $user['locale']),
	[
		'symbol' => $asset['symbol'] ?? truncateWalletAddress($asset_address, 3, 3),
	]
), null, [
	'reply_markup' => [
		'inline_keyboard' => [
			[
				[
					'text' => t('callback_query.alerts.type.buttons.decrease', $user['locale']),
					'callback_data' => joinPipe('alert', $blockchain, $asset_address, '0'),
				],
				[
					'text' => t('callback_query.alerts.type.buttons.increase', $user['locale']),
					'callback_data' => joinPipe('alert', $blockchain, $asset_address, '1'),
				],
			],
		],
	],
]);

$answer = t('callback_query.alerts.type.answer', $user['locale']);
