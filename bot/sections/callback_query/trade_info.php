<?php

[,, $wallet_id] = splitPipe($callback_data);

$wallet_index = array_search($wallet_id, array_column($user['wallets'], 'id'));

if ($wallet_index > -1) {
	$wallet = $user['wallets'][$wallet_index];

	EditMessageText($callback_chat_id, $callback_msg_id, td(
		t('callback_query.trade_info.text', $user['locale']),
		[
			'wallet' => generateWalletsListText([$wallet], $user['locale']),
		]
	), null, [
		'reply_markup' => [
			'inline_keyboard' => [
				[
					[
						'text' => t('callback_query.trade_info.buttons.limit', $user['locale']),
						'callback_data' => joinPipe('ex', 'lim', $wallet['id']),
					],
				],
				[
					[
						'text' => t('callback_query.trade_info.buttons.tp', $user['locale']),
						'callback_data' => joinPipe('ex', 'tp', $wallet['id']),
					],
					[
						'text' => t('callback_query.trade_info.buttons.sl', $user['locale']),
						'callback_data' => joinPipe('ex', 'sl', $wallet['id']),
					],
				],
				[
					[
						'text' => t('general.back', $user['locale']),
						'callback_data' => 'trade',
					],
				],
			],
		],
	]);

	$answer = t('callback_query.trade_info.answer', $user['locale']);

	syncWalletsBalanceDeferred([$wallet]);
}
