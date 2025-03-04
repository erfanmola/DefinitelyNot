<?php

[,, $wallet_id] = splitPipe($callback_data);

$wallet_index = array_search($wallet_id, array_column($user['wallets'], 'id'));

if ($wallet_index > -1) {
	$wallet = $user['wallets'][$wallet_index];

	$keyboard = [];

	switch ($wallet['type']) {
		case 'TON':
			foreach ($tableJettons as $jetton) {
				if ($jetton['active'] && $jetton['symbol'] && $prefdefinedJettons->exists($jetton['address'])) {
					$keyboard[] = [
						'text' => $jetton['symbol'],
						'callback_data' => joinPipe('ex', 'tp', $wallet['id'], $jetton['address']),
					];
				}
			}
			break;
		case 'SOL':
			foreach ($tableTokens as $token) {
				if ($token['active'] && $token['symbol'] && $prefdefinedTokens->exists($token['address'])) {
					$keyboard[] = [
						'text' => $token['symbol'],
						'callback_data' => joinPipe('ex', 'tp', $wallet['id'], $token['address']),
					];
				}
			}
			break;
	}

	EditMessageText($callback_chat_id, $callback_msg_id, td(
		t('callback_query.trade_tp.text', $user['locale']),
		[
			'type'   => $wallet['type'],
			'wallet' => generateWalletsListText([$wallet], $user['locale']),
		]
	), null, [
		'reply_markup' => [
			'inline_keyboard' => [
				...array_chunk($keyboard, 3),
				[
					[
						'text' => t('callback_query.trade_custom.buttons.custom', $user['locale']),
						'callback_data' => joinPipe('ex', 'addr', $wallet['id'], 'tp'),
					],
				],
				[
					[
						'text' => t('general.back', $user['locale']),
						'callback_data' => joinPipe('ex', 'info', $wallet['id']),
					],
				],
			],
		],
	]);

	$answer = t('callback_query.trade_tp.answer', $user['locale']);

	syncWalletsBalanceDeferred([$wallet]);
}
