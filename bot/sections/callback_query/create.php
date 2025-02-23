<?php

EditMessageText($callback_chat_id, $callback_msg_id, t('callback_query.create.text', $user['locale']), null, [
	'reply_markup' => [
		'inline_keyboard' => [
			[
				...array_map(fn($emoji, $type) => [
					'text' => joinSpace($emoji, $type),
					'callback_data' => joinPipe('create', 'wallet', $type),
				], blockchain_emoji, array_keys(blockchain_emoji)),
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

$answer = t('callback_query.create.answer', $user['locale']);
