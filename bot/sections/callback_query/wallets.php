<?php

EditMessageText($callback_chat_id, $callback_msg_id, td(t('callback_query.wallets.text', $user['locale']), [
	'count'   => count($user['wallets']),
	'max'     => config['TOTAL_WALLETS_MAX'],
	'wallets' => generateWalletsListText($user['wallets'], $user['locale']),
]), null, [
	'reply_markup' => [
		'inline_keyboard' => [
			...array_map(fn($wallet) => [
				[
					'text' => joinSpace(blockchain_emoji[$wallet['type']], truncateWalletAddress($wallet['address'])),
					'callback_data' => joinPipe('wallet', 'info', $wallet['id']),
				],
				[
					'text' => t('callback_query.wallets.buttons.copy', $user['locale']),
					'copy_text' => [
						'text' => $wallet['address'],
					],
				],
			], $user['wallets']),
			[
				[
					'text' => t('callback_query.wallets.buttons.new', $user['locale']),
					'callback_data' => 'create'
				],
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

$answer = t('callback_query.wallets.answer', $user['locale']);

syncWalletsBalanceDeferred($user['wallets']);
