<?php

[,, $wallet_id] = splitPipe($callback_data);

$wallet_index = array_search($wallet_id, array_column($user['wallets'], 'id'));

if ($wallet_index > -1) {
	$wallet = $user['wallets'][$wallet_index];
	$blockchain = $wallet['type'];

	$keyboard = [];

	switch ($blockchain) {
		case 'TON':
			foreach ($tableJettons as $jetton) {
				if ($jetton['active'] && $jetton['symbol'] && $predefinedJettons->exists($jetton['address'])) {
					$keyboard[] = [
						'text' => $jetton['symbol'],
						'callback_data' => joinPipe('swap', $wallet_id, $jetton['address']),
					];
				}
			}
			break;
		case 'SOL':
			foreach ($tableTokens as $token) {
				if ($token['active'] && $token['symbol'] && $predefinedTokens->exists($token['address'])) {
					$keyboard[] = [
						'text' => $token['symbol'],
						'callback_data' => joinPipe('swap', $wallet_id, $token['address']),
					];
				}
			}
			break;
	}

	EditMessageText(
		$callback_chat_id,
		$callback_msg_id,
		t('callback_query.swap.choose.text', $user['locale']),
		null,
		[
			'reply_markup' => [
				'inline_keyboard' => [
					...array_chunk($keyboard, 3),
					[
						[
							'text' => t('callback_query.custom_asset.buttons.custom', $user['locale']),
							'callback_data' => joinPipe('swap', 'addr', $wallet_id),
						],
					],
					[
						[
							'text' => t('general.back', $user['locale']),
							'callback_data' => 'swap',
						],
					],
				],
			],
		]
	);

	$answer = t('callback_query.swap.choose.answer', $user['locale']);
}
