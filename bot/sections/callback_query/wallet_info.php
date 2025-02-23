<?php

[,, $address] = splitPipe($callback_data);

$wallet_index = array_search($address, array_column($user['wallets'], 'address'));

if ($wallet_index > -1) {
	$wallet = $user['wallets'][$wallet_index];

	EditMessageText($callback_chat_id, $callback_msg_id, td(
		t('callback_query.wallet_info.text', $user['locale']),
		[
			'wallet' => generateWalletsListText([$wallet], $user['locale']),
		]
	), null, [
		'reply_markup' => [
			'inline_keyboard' => [
				[
					[
						'text' => t('callback_query.wallet_info.buttons.export', $user['locale']),
						'callback_data' => joinPipe('wallet', 'export', $wallet['address']),
					],
				],
				[
					[
						'text' => t('callback_query.wallet_info.buttons.delete', $user['locale']),
						'callback_data' => joinPipe('wallet', 'del', $wallet['address']),
					],
				],
				[
					[
						'text' => t('general.back', $user['locale']),
						'callback_data' => 'wallets',
					],
				],
			],
		],
	]);

	$answer = t('callback_query.wallet_info.answer', $user['locale']);

	syncWalletsBalanceDeferred([$wallet]);
}
