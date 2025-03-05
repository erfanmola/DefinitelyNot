<?php

require __DIR__ . "/../../pipelines/define_user_conditions.php";

[,, $condition_id] = splitPipe($callback_data);

$condition_index = array_search($condition_id, array_column($user['conditions'], 'id'));

if ($condition_index > -1) {
	$condition = $user['conditions'][$condition_index];

	$keyboard = array_fill(0, 25, [
		'text' => '⏺️',
		'callback_data' => joinPipe('condition', 'info', $condition['id']),
	]);
	$keyboard[mt_rand(0, 25)] = [
		'text' => '⏹️',
		'callback_data' => joinPipe('condition', 'delete', $condition['id']),
	];

	EditMessageText($callback_chat_id, $callback_msg_id, td(
		t('callback_query.conditions.delete.text', $user['locale']),
		[
			'condition' => generateTradeConditionsListText([$condition], $user['locale']),
		]
	), null, [
		'reply_markup' => [
			'inline_keyboard' => array_chunk($keyboard, 5),
		],
	]);

	$answer = t('callback_query.conditions.delete.answer', $user['locale']);
}
