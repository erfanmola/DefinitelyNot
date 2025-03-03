<?php

function getTradeConditions(int|string $user_id, mixed &$conn): array | null
{
	return DPXDBQuery('trade_conditions', '*', ['user_id' => $user_id], casts: [
		'id'        => 'number',
		'user_id'   => 'number',
		'wallet_id' => 'number',
		'type'      => 'number',
		'price'     => 'double',
		'amount'    => 'double',
		'status'    => 'number',
	], single_result: false, conn: $conn);
}

function getTradeConditionsByStatus(int|string $user_id, int $status, mixed &$conn): array | null
{
	return DPXDBQuery('trade_conditions', '*', ['user_id' => $user_id, 'status' => $status], casts: [
		'id'        => 'number',
		'user_id'   => 'number',
		'wallet_id' => 'number',
		'type'      => 'number',
		'price'     => 'double',
		'amount'    => 'double',
		'status'    => 'number',
	], single_result: false, conn: $conn);
}

function createTradeCondition(array $params, mixed &$conn)
{
	// TODO: push to the current active table
	DPXDBInsert('trade_conditions', $params, $conn);
}

function deleteTradeCondition(int $condition_id, mixed &$conn)
{
	// TODO: remove from the current active table
	DPXDBDelete('trade_conditions', ['id' => $condition_id], conn: $conn);
}
