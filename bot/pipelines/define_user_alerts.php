<?php

if ($user) {
	$user['alerts'] = getAlerts($user['user_id'], $mysqli);

	foreach ($user['alerts'] as $key => $alert) {

		$alert['asset_address'] = $alert['asset'];
		$alert['asset'] = match ($alert['blockchain']) {
			'TON' => $tableJettons->get($alert['asset_address']),
			'SOL' => $tableTokens->get($alert['asset_address']),
		};

		$user['alerts'][$key] = $alert;
	}
}
