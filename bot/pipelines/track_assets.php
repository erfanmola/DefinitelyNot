<?php

// TODO: fetch addresses that are not natively supported
$assets = [];

$assets = requestController('/assets/track', [
	'assets' => $assets,
]);

if ($assets) {
	foreach ($assets['jettons'] as $jetton) {
		tableUpdate($tableJettons, $jetton['address'], $jetton);
	}

	foreach ($assets['tokens'] as $token) {
		tableUpdate($tableTokens, $token['address'], $token);
	}
}
