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

	SyncDBUpdate('trade_conditions', [
		'status' => 1,
	], joinEmpty("`id` IN (", implode(",", $trigger), ")"), $mysqli);

	Coroutine::defer(function () use ($trigger, &$tableConditions, &$tableJettons, &$tableTokens) {
		foreach ($trigger as $id) {
			$condition = $tableConditions->get($id);

			$condition['asset_address'] = $condition['asset'];
			$condition['asset'] = match ($condition['blockchain']) {
				'TON' => $tableJettons->get($condition['asset_address']),
				'SOL' => $tableTokens->get($condition['asset_address']),
			};

			SendMessage($condition['user_id'], td(t('callback_query.conditions.trigger', 'en'), [
				'type'   => trade_condition_types_symbol[$condition['type']],
				'amount' => $condition['amount'],
				'symbol' => $condition['asset']['symbol'] ?? truncateWalletAddress($condition['asset_address'], 3, 3),
				'price'  => priceFormat($condition['price']),
			]));

			$mysqli = ConnectionPoolManager::getMySQLiConnection();
			$wallets = getWallets($condition['user_id'], $mysqli);
			ConnectionPoolManager::releaseMySQLiConnection($mysqli);
			$wallet = $wallets[array_search($condition['wallet_id'], array_column($wallets, 'id'))];

			switch ($condition['type']) {
				// Limit Order Buy Asset
				case 0:
					$offer = $condition['blockchain'];
					$ask = $condition['asset_address'];
					break;

				// Stop Loss Sell Asset
				case 1:
					$ask = $condition['blockchain'];
					$offer = $condition['asset_address'];
					break;

				// Take Profit Sell Asset
				case 2:
					$ask = $condition['blockchain'];
					$offer = $condition['asset_address'];
					break;
			}

			swapAsset($condition['user_id'], $condition['blockchain'], $wallet['address'], $wallet['secret_key'], $offer, $condition['amount'], $ask);

			Coroutine::usleep(250_000);
		}
	});

	ConnectionPoolManager::releaseMySQLiConnection($mysqli);
}
