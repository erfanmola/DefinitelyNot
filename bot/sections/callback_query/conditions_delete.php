<?php

require __DIR__ . "/../../pipelines/define_user_conditions.php";

[,, $condition_id] = splitPipe($callback_data);

$condition_index = array_search($condition_id, array_column($user['conditions'], 'id'));

if ($condition_index > -1) {
	$condition = $user['conditions'][$condition_index];

	deleteTradeCondition($condition['id'], $mysqli);
	$callback_data = 'conditions';

	require __DIR__ . "/../callback_query.php";
}
