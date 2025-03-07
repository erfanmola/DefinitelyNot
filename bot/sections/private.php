<?php

$flooding = IsUserFlooding($from_id, 16, 60);

if ($flooding === false) {
	require __DIR__ . "/../pipelines/define_user_params.php";
	require __DIR__ . "/../pipelines/define_user_wallets.php";

	if ($state && !str_starts_with($text, '/start')) {
		switch ($state) {
			case 'trade|custom':
				require __DIR__ . "/private/trade_custom.php";
				break;
			case 'trade|process':
				require __DIR__ . "/private/trade_process.php";
				break;
			case 'alert|custom':
				require __DIR__ . "/private/alert_custom.php";
				break;
			case 'alert|price':
				require __DIR__ . "/private/alert_price.php";
				break;
			case 'swap|custom':
				require __DIR__ . "/private/swap_custom.php";
				break;
			case 'swap|amount':
				require __DIR__ . "/private/swap_amount.php";
				break;
		}
	} else {
		require __DIR__ . "/private/default.php";

		if (isset($user['new'])) {
			require __DIR__ . "/private/welcome.php";
		}
	}
} else if ($flooding) {
	SendMessage($from_id, "🚫 Stop flooding, I'm gonna pretend that i'm angry and will not respond to you for some time.");
}
