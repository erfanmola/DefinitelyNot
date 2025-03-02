<?php

if (count($user['wallets']) < config['TOTAL_WALLETS_MAX']) {
	[,, $type] = splitPipe($callback_data);

	$wallet = createWallet($user['user_id'], $type, $mysqli);

	if ($wallet) {
		EditMessageText($callback_chat_id, $callback_msg_id, td(
			t('callback_query.create_wallet.text', $user['locale']),
			[
				'wallet' => generateWalletsListText([$wallet], $user['locale']),
			]
		), null, [
			'reply_markup' => [
				'inline_keyboard' => [
					[
						[
							'text' => t('general.back', $user['locale']),
							'callback_data' => 'wallets',
						],
					],
				],
			],
		]);

		$answer = t('callback_query.create_wallet.answer', $user['locale']);
	}
} else {
	$answer = td(t('callback_query.create_wallet.answer_max', $user['locale']), [
		'max' => config['TOTAL_WALLETS_MAX'],
	]);
	$show_alert = true;
}
