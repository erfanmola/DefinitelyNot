<?php

foreach ($result['native'] as $key => $value) {
	$tableNative->set($key, ['price' => (float)$value]);
}

foreach ($result['assets']['jettons']['stonfi'] as $asset) {
	if (isset($asset['dex_usd_price'])) {
		tableUpdate($tableJettons, $asset['contract_address'], [
			'price' => (float)$asset['dex_usd_price'],
			'active' => 1,
		]);
	} else {
		tableUpdate($tableJettons, $asset['contract_address'], [
			'active' => 0,
		]);
	}
}

foreach ($result['assets']['tokens']['raydium'] as $asset) {
	if (isset($asset['price'])) {
		tableUpdate($tableTokens, $asset['address'], [
			'price' => (float)$asset['price'],
			'active' => 1,
		]);
	} else {
		tableUpdate($tableTokens, $asset['address'], [
			'active' => 0,
		]);
	}
}

$updated_assets = [
	'TON' => array_column($result['assets']['jettons']['stonfi'], 'contract_address'),
	'SOL' => array_column($result['assets']['tokens']['raydium'], 'address'),
];
