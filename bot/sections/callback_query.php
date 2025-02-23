<?php

$flooding = IsUserFlooding($callback_from_id, 8, 30, 'callback_query');

if ($flooding === false) {
	require __DIR__ . "/../pipelines/define_user_params.php";

	switch ($callback_data) {
		case 'default':
		case 'refresh':
			require __DIR__ . "/callback_query/refresh.php";
			break;

		case 'wallets':
			require __DIR__ . "/callback_query/wallets.php";
			break;

		case 'create':
			require __DIR__ . "/callback_query/create.php";
			break;

		case 'copytrade':
			require __DIR__ . "/callback_query/copytrade.php";
			break;

		case 'limit':
			require __DIR__ . "/callback_query/limit_order.php";
			break;

		case 'languages':
			require __DIR__ . "/callback_query/languages.php";
			break;

		case 'alerts':
			require __DIR__ . "/callback_query/alerts.php";
			break;

		case 'import_wallet':
			require __DIR__ . "/callback_query/import_wallet.php";
			break;

		default:
			if (str_starts_with($callback_data, joinPipe('create', 'wallet', ''))) {
				require __DIR__ . "/callback_query/create_wallet.php";
			}

			// Wallet Operations
			if (str_starts_with($callback_data, joinPipe('wallet', 'info', ''))) {
				require __DIR__ . "/callback_query/wallet_info.php";
			} else if (str_starts_with($callback_data, joinPipe('wallet', 'del', ''))) {
				require __DIR__ . "/callback_query/wallet_del.php";
			} else if (str_starts_with($callback_data, joinPipe('wallet', 'delete', ''))) {
				require __DIR__ . "/callback_query/wallet_delete.php";
			} else if (str_starts_with($callback_data, joinPipe('wallet', 'export', ''))) {
				require __DIR__ . "/callback_query/wallet_export.php";
			}

			// Language Operations
			if (str_starts_with($callback_data, joinPipe('language', 'set', ''))) {
				require __DIR__ . "/callback_query/language_set.php";
			}
			break;
	}
} else if ($flooding) {
	$answer = "Stop spamming the buttons you retarded piece of shit";
	$show_alert = true;
} else {
	// If we don't answer the callback_query, Telegram assumes the bot is down and throttles updates.
	$show_alert = true;
}

AnswerCallbackQuery($callback_id, $answer ?? t('callback_query.fallback', $user['locale']), $show_alert ?? false, $cache_time ?? 0);
