<?php

$asset = match ($sdata['blockchain']) {
	'TON' => $tableJettons->get($sdata['asset_address']),
	'SOL' => $tableTokens->get($sdata['asset_address']),
};

if ($asset && $asset['symbol'] && $asset['price']) {
	$wallet_index = array_search($sdata['wallet_id'], array_column($user['wallets'], 'id'));

	if ($wallet_index > -1) {
		$wallet = $user['wallets'][$wallet_index];

		switch ($sdata['type']) {
			case 'limit':
				require __DIR__ . "/trade_process_limit.php";
				break;
			case 'tp':
				require __DIR__ . "/trade_process_tp.php";
				break;
			case 'sl':
				require __DIR__ . "/trade_process_sl.php";
				break;
		}
	}
}
