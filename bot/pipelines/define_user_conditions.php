<?php

if ($user) {
	$user['conditions'] = getTradeConditions($user['user_id'], $mysqli);

	foreach ($user['conditions'] as $key => $condition) {
		$condition['wallet'] = $user['wallets'][array_search($condition['wallet_id'], array_column($user['wallets'], 'id'))] ?? null;

		if ($condition['wallet']) {
			$condition['asset_address'] = $condition['asset'];
			$condition['asset'] = match ($condition['wallet']['type']) {
				'TON' => $tableJettons->get($condition['asset_address']),
				'SOL' => $tableTokens->get($condition['asset_address']),
			};
		}

		$user['conditions'][$key] = $condition;
	}
}
