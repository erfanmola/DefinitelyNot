<?php

$untracked_assets = requestController('/assets/track', [
	'assets' => $untracked_assets,
]);

if ($untracked_assets) {
	foreach ($untracked_assets['jettons'] as $jetton) {
		tableUpdate($tableJettons, $jetton['address'], $jetton);
	}

	foreach ($untracked_assets['tokens'] as $token) {
		tableUpdate($tableTokens, $token['address'], $token);
	}
}
