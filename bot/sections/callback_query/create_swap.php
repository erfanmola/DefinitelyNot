<?php

EditMessageText($callback_chat_id, $callback_msg_id, t('callback_query.swap.create.text', $user['locale']), null, [
	'reply_markup' => [
		'inline_keyboard' => [
			[
				...array_map(fn($emoji, $type) => [
					'text' => joinSpace($emoji, $type),
					'callback_data' => joinPipe('swap', 'create', $type),
				], blockchain_emoji, array_keys(blockchain_emoji)),
			],
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
