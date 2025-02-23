<?php

EditMessageText($callback_chat_id, $callback_msg_id, t('callback_query.languages.text', $user['locale']), null, [
	'reply_markup' => [
		'inline_keyboard' => [
			...array_chunk(array_map(fn($lang) => [
				'text' => joinSpace(language_flags[$lang], languages[$lang]),
				'callback_data' => joinPipe('language', 'set', $lang),
			], array_keys(languages)), 2),
			[
				[
					'text' => t('general.back', $user['locale']),
					'callback_data' => 'default',
				],
			],
		],
	],
]);

$answer = t('callback_query.languages.answer', $user['locale']);
