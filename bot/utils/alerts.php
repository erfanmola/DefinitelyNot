<?php

function getAlerts(int|string $user_id, mixed &$conn): array | null
{
	return DPXDBQuery('alerts', '*', ['user_id' => $user_id], casts: [
		'id'        => 'number',
		'user_id'   => 'number',
		'type'      => 'number',
		'price'     => 'double',
		'status'    => 'number',
	], single_result: false, conn: $conn);
}

function getAlertsByStatus(int|string $user_id, int $status, mixed &$conn): array | null
{
	return DPXDBQuery('alerts', '*', ['user_id' => $user_id, 'status' => $status], casts: [
		'id'        => 'number',
		'user_id'   => 'number',
		'type'      => 'number',
		'price'     => 'double',
		'status'    => 'number',
	], single_result: false, conn: $conn);
}

function createAlert(array $params, mixed &$conn)
{
	SyncDBInsert('alerts', $params, $conn);

	if ($conn->insert_id) {
		global $tableAlerts;

		$tableAlerts->set($conn->insert_id, [
			'user_id'    => (int)$params['user_id'],
			'type'       => (int)$params['type'],
			'price'      => (float)$params['price'],
			'blockchain' => (string)$params['blockchain'],
			'asset'      => (string)$params['asset'],
			'status'     => 0,
		]);
	}
}

function deleteAlert(int $alert_id, mixed &$conn)
{
	DPXDBDelete('alerts', ['id' => $alert_id], conn: $conn);

	global $tableAlerts;
	$tableAlerts->del($alert_id);
}
