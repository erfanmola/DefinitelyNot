<?php

require __DIR__ . "/../../pipelines/define_user_conditions.php";

EditMessageText($callback_chat_id, $callback_msg_id, td(t('callback_query.conditions.text', $user['locale']), [
	'count'      => count($user['conditions']),
	'max'        => config['TRADE_CONDITIONS_PENDING_MAX'],
	'conditions' => generateTradeConditionsListText($user['conditions']),
]), null, [
	'reply_markup' => [
		'inline_keyboard' => [
			...array_map(fn($condition) => [
				[
					'text' => joinSpace(
						blockchain_emoji[$condition['wallet']['type']],
						trade_condition_types_symbol[$condition['type']],
						'|',
						number_format($condition['amount']),
						$condition['asset']['symbol'] ?? truncateWalletAddress($condition['asset_address'], 3, 3),
						'|',
						priceFormat($condition['price']),
					),
					'callback_data' => joinPipe('condition', 'info', $condition['id']),
				],
			], $user['conditions']),
			[
				[
					'text' => t('general.back', $user['locale']),
					'callback_data' => 'default',
				],
			],
		],
	],
]);

$answer = t('callback_query.conditions.answer', $user['locale']);

syncWalletsBalanceDeferred($user['wallets']);
