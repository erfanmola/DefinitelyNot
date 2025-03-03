<?php

require __DIR__ . "/../../pipelines/define_user_conditions.php";

[,, $condition_id] = splitPipe($callback_data);

$condition_index = array_search($condition_id, array_column($user['conditions'], 'id'));

if ($condition_index > -1) {
	$condition = $user['conditions'][$condition_index];

	EditMessageText($callback_chat_id, $callback_msg_id, td(
		t('callback_query.condition_info.text', $user['locale']),
		[
			'condition' => generateTradeConditionsListText([$condition], $user['locale']),
		]
	), null, [
		'reply_markup' => [
			'inline_keyboard' => [
				[
					[
						'text' => t('callback_query.condition_info.buttons.delete', $user['locale']),
						'callback_data' => joinPipe('condition', 'del', $condition['id']),
					],
				],
				[
					[
						'text' => t('general.back', $user['locale']),
						'callback_data' => 'conditions',
					],
				],
			],
		],
	]);

	$answer = t('callback_query.condition_info.answer', $user['locale']);
}
