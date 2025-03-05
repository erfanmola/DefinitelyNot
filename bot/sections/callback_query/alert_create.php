<?php

[,, $blockchain] = splitPipe($callback_data);

$keyboard = [];

switch ($blockchain) {
	case 'TON':
		foreach ($tableJettons as $jetton) {
			if ($jetton['active'] && $jetton['symbol'] && $predefinedJettons->exists($jetton['address'])) {
				$keyboard[] = [
					'text' => $jetton['symbol'],
					'callback_data' => joinPipe('alert', $blockchain, $jetton['address']),
				];
			}
		}
		break;
	case 'SOL':
		foreach ($tableTokens as $token) {
			if ($token['active'] && $token['symbol'] && $predefinedTokens->exists($token['address'])) {
				$keyboard[] = [
					'text' => $token['symbol'],
					'callback_data' => joinPipe('alert', $blockchain, $token['address']),
				];
			}
		}
		break;
}

EditMessageText(
	$callback_chat_id,
	$callback_msg_id,
	t('callback_query.alerts.choose.text', $user['locale']),
	null,
	[
		'reply_markup' => [
			'inline_keyboard' => [
				...array_chunk($keyboard, 3),
				[
					[
						'text' => t('callback_query.custom_asset.buttons.custom', $user['locale']),
						'callback_data' => joinPipe('alert', 'addr', $blockchain),
					],
				],
				[
					[
						'text' => t('general.back', $user['locale']),
						'callback_data' => joinPipe('create', 'alert'),
					],
				],
			],
		],
	]
);

$answer = t('callback_query.alerts.choose.answer', $user['locale']);
