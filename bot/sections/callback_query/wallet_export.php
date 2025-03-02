<?php

[,, $wallet_id] = splitPipe($callback_data);

$wallet_index = array_search($wallet_id, array_column($user['wallets'], 'id'));

if ($wallet_index > -1) {
	$wallet = $user['wallets'][$wallet_index];

	EditMessageText($callback_chat_id, $callback_msg_id, td(
		t('callback_query.wallet_export.text', $user['locale']),
		[

			'type'       => $wallet['type'],
			'type_emoji' => blockchain_emoji[$wallet['type']],
			'address'    => $wallet['address'],
			'public'     => $wallet['public_key'],
			'secret'     => $wallet['secret_key'],
			'mnemonic'   => joinLine(
				...array_map(
					fn($word, $index) => "{$index}. <tg-spoiler>{$word}</tg-spoiler>",
					$wallet['mnemonic'],
					array_map(fn($item) => str_pad($item, 2, "0", STR_PAD_LEFT), range(1, count($wallet['mnemonic']))),
				),
			),
		]
	), null, [
		'reply_markup' => [
			'inline_keyboard' => [
				[
					[
						'text' => t('general.back', $user['locale']),
						'callback_data' => joinPipe('wallet', 'info', $wallet['id']),
					],
				],
			],
		],
	]);

	$answer = t('callback_query.wallet_export.answer', $user['locale']);

	syncWalletsBalanceDeferred([$wallet]);
}
