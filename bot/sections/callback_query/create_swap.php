<?php

EditMessageText($callback_chat_id, $callback_msg_id, td(t('callback_query.swap.create.text', $user['locale']), [
	'wallets' => generateWalletsListText($user['wallets'], $user['locale']),
]), null, [
	'reply_markup' => [
		'inline_keyboard' => [
			...array_map(fn($wallet) => [
				[
					'text' => joinSpace(blockchain_emoji[$wallet['type']], truncateWalletAddress($wallet['address'])),
					'callback_data' => joinPipe('swap', 'create', $wallet['id']),
				],
			], $user['wallets']),
			[
				[
					'text' => t('general.back', $user['locale']),
					'callback_data' => 'default',
				],
			],
		],
	],
]);

$answer = t('callback_query.swap.create.answer', $user['locale']);
