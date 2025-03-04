<?php

$mysqli = ConnectionPoolManager::getMySQLiConnection();

// Initialize jettons table with predefined jettons that we support
foreach ($result['jettons'] as $jetton) {
	$predefinedJettons->set($jetton['address'], []);
	tableUpdate($tableJettons, $jetton['address'], $jetton);
}

// Initialize tokens table with predefined tokens that we support
foreach ($result['tokens'] as $token) {
	$predefinedTokens->set($token['address'], []);
	tableUpdate($tableTokens, $token['address'], $token);
}

$untracked_assets = [];

// Initialize conditions table
foreach (DPXDBQuery('trade_conditions', single_result: false, conn: $mysqli) as $condition) {
	switch ($condition['blockchain']) {
		case 'TON':
			if (!$predefinedJettons->exists($condition['asset'])) {
				$untracked_assets[] = [
					'type'    => $condition['blockchain'],
					'address' => $condition['asset'],
				];
			}
			break;
		case 'SOL':
			if (!$predefinedTokens->exists($condition['asset'])) {
				$untracked_assets[] = [
					'type'    => $condition['blockchain'],
					'address' => $condition['asset'],
				];
			}
			break;
	}

	$tableConditions->set($condition['id'], [
		'user_id'    => (int)$condition['user_id'],
		'wallet_id'  => (int)$condition['wallet_id'],
		'type'       => (int)$condition['type'],
		'price'      => (float)$condition['price'],
		'amount'     => (float)$condition['amount'],
		'blockchain' => (string)$condition['blockchain'],
		'asset'      => (string)$condition['asset'],
	]);
}

require __DIR__ . "/../pipelines/track_assets.php";

ConnectionPoolManager::releaseMySQLiConnection($mysqli);
