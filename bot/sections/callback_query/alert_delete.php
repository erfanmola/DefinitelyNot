<?php

require __DIR__ . "/../../pipelines/define_user_alerts.php";

[,, $alert_id] = splitPipe($callback_data);

$alert_index = array_search($alert_id, array_column($user['alerts'], 'id'));

if ($alert_index > -1) {
	$alert = $user['alerts'][$alert_index];

	deleteAlert($alert['id'], $mysqli);
	$callback_data = 'alerts';

	require __DIR__ . "/../callback_query.php";
}
