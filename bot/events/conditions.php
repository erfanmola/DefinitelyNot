<?php

use OpenSwoole\Coroutine;

$trigger = [];

foreach ($tableConditions as $id => $condition) {
	if (in_array($condition['asset'], $updated_assets[$condition['blockchain']])) {

		$asset = match ($condition['blockchain']) {
			'TON' => $tableJettons->get($condition['asset']) ?? null,
			'SOL' => $tableTokens->get($condition['asset']) ?? null,
		};

		$price = (float) ($asset['price'] ?? -1);

		if ($price && $asset['symbol']) {
			switch ($condition['type']) {
				// Limit Order Buy Asset
				case 0:
					if ($price <= $condition['price'] && $condition['status'] === 0) {
						$trigger[] = $id;
					}
					break;

				// Stop Loss Sell Asset
				case 1:
					if ($price <= $condition['price'] && $condition['status'] === 0) {
						$trigger[] = $id;
					}
					break;

				// Take Profit Sell Asset
				case 2:
					if ($price >= $condition['price'] && $condition['status'] === 0) {
						$trigger[] = $id;
					}
					break;
			}
		}
	}
}

if ($trigger) {
	foreach ($trigger as $id) {
		tableUpdate($tableConditions, $id, [
			'status' => 1
		]);
	}

	$mysqli = ConnectionPoolManager::getMySQLiConnection();

	DPXDBUpdate('trade_conditions', [
		'status' => 1,
	], joinEmpty("`id` IN (", implode(",", $trigger), ")"), $mysqli);

	Coroutine::defer(function () use ($trigger, &$tableConditions, &$tableJettons, &$tableTokens) {
		foreach ($trigger as $id) {
			$condition = $tableConditions->get($id);

			// TODO: Implement actual flow
			SendMessage($condition['user_id'], ['CONDITION MUST BE EXECUTED', $condition]);
			Coroutine::usleep(250_000);
		}
	});

	ConnectionPoolManager::releaseMySQLiConnection($mysqli);
}
