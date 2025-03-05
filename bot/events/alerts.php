<?php

use OpenSwoole\Coroutine;

$trigger = [];
$reactivate = [];

foreach ($tableAlerts as $id => $alert) {
	if ($alert['asset'] === '~' || in_array($alert['asset'], $updated_assets[$alert['blockchain']])) {

		$price = (float) match ($alert['asset']) {
			'~' => $tableNative->get($alert['blockchain'], 'price') ?? -1,
			default => match ($alert['blockchain']) {
				'TON' => $tableJettons->get($alert['asset'], 'price') ?? -1,
				'SOL' => $tableTokens->get($alert['asset'], 'price') ?? -1,
			},
		};

		if ($price) {
			$active = (bool) match ($alert['asset']) {
				'~' => true,
				default => match ($alert['blockchain']) {
					'TON' => $tableJettons->get($alert['asset'], 'symbol') ?? false,
					'SOL' => $tableTokens->get($alert['asset'], 'symbol') ?? false,
				},
			};

			if ($active) {
				switch ($alert['type']) {
					// Decrease
					case 0:
						if ($price < $alert['price'] && $alert['status'] === 0) {
							$trigger[] = $id;
						} else if ($price > $alert['price'] && $alert['status'] === 1) {
							$reactivate[] = $id;
						}
						break;

					// Increase
					case 1:
						if ($price > $alert['price'] && $alert['status'] === 0) {
							$trigger[] = $id;
						} else if ($price < $alert['price'] && $alert['status'] === 1) {
							$reactivate[] = $id;
						}
						break;
				}
			}
		}
	}
}

if ($trigger) {
	foreach ($trigger as $id) {
		tableUpdate($tableAlerts, $id, [
			'status' => 1
		]);
	}

	$mysqli = ConnectionPoolManager::getMySQLiConnection();

	SyncDBUpdate('alerts', [
		'status' => 1,
	], joinEmpty("`id` IN (", implode(",", $trigger), ")"), $mysqli);

	Coroutine::defer(function () use ($trigger, &$tableAlerts, &$tableNative, &$tableJettons, &$tableTokens) {
		foreach ($trigger as $id) {
			$alert = $tableAlerts->get($id);

			SendMessage($alert['user_id'], td(t('callback_query.alerts.notify.' . $alert['type'], 'en'), [
				'price' => priceFormat($alert['price']),
				'symbol' => match ($alert['asset']) {
					'~' => $alert['blockchain'],
					default => match ($alert['blockchain']) {
						'TON' => $tableJettons->get($alert['asset'], 'symbol'),
						'SOL' => $tableTokens->get($alert['asset'], 'symbol'),
					},
				},
			]));
			Coroutine::usleep(250_000);
		}
	});

	ConnectionPoolManager::releaseMySQLiConnection($mysqli);
}

if ($reactivate) {
	foreach ($reactivate as $id) {
		tableUpdate($tableAlerts, $id, [
			'status' => 0,
		]);
	}

	$mysqli = ConnectionPoolManager::getMySQLiConnection();

	SyncDBUpdate('alerts', [
		'status' => 0,
	], joinEmpty("`id` IN (", implode(",", $reactivate), ")"), $mysqli);

	ConnectionPoolManager::releaseMySQLiConnection($mysqli);
}
