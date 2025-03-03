<?php

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
