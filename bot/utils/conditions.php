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
	SyncDBInsert('trade_conditions', $params, $conn);

	if ($conn->insert_id) {
		global $tableConditions;

		$tableConditions->set($conn->insert_id, [
			'user_id'    => (int)$params['user_id'],
			'wallet_id'  => (int)$params['wallet_id'],
			'type'       => (int)$params['type'],
			'price'      => (float)$params['price'],
			'amount'     => (float)$params['amount'],
			'blockchain' => (string)$params['blockchain'],
			'asset'      => (string)$params['asset'],
		]);
	}
}

function deleteTradeCondition(int $condition_id, mixed &$conn)
{
	DPXDBDelete('trade_conditions', ['id' => $condition_id], conn: $conn);

	global $tableConditions;
	$tableConditions->del($condition_id);
}
