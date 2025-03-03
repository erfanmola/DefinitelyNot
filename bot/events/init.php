<?php

// Initialize jettons table with predefined jettons that we support
foreach ($result['jettons'] as $jetton) {
	tableUpdate($tableJettons, $jetton['address'], $jetton);
}

// Initialize tokens table with predefined tokens that we support
foreach ($result['tokens'] as $token) {
	tableUpdate($tableTokens, $token['address'], $token);
}

require __DIR__ . "/../pipelines/track_assets.php";
