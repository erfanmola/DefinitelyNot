<?php

$flooding = IsUserFlooding($callback_from_id, 16, 30, 'callback_query');

if ($flooding === false) {
	require __DIR__ . "/../pipelines/define_user_params.php";
	require __DIR__ . "/../pipelines/define_user_wallets.php";

	$active_msg_id = $redis->get(joinPipe($callback_from_id, 'recent', 'msg', 'id'));

	if ((int)$active_msg_id === (int)$callback_msg_id) {
		switch ($callback_data) {
			case 'default':
			case 'refresh':
				require __DIR__ . "/callback_query/refresh.php";
				break;

			case 'wallets':
				require __DIR__ . "/callback_query/wallets.php";
				break;

			case 'conditions':
				require __DIR__ . "/callback_query/conditions.php";
				break;

			case 'create':
				require __DIR__ . "/callback_query/create.php";
				break;
			case 'create|alert':
				require __DIR__ . "/callback_query/create_alert.php";
				break;
			case 'copytrade':
				require __DIR__ . "/callback_query/copytrade.php";
				break;

			case 'trade':
				require __DIR__ . "/callback_query/trade.php";
				break;

			case 'languages':
				require __DIR__ . "/callback_query/languages.php";
				break;

			case 'alerts':
				require __DIR__ . "/callback_query/alerts.php";
				break;

			case 'import|wallet':
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

				// Conditions Operations
				if (str_starts_with($callback_data, joinPipe('condition', 'info', ''))) {
					require __DIR__ . "/callback_query/conditions_info.php";
				} else if (str_starts_with($callback_data, joinPipe('condition', 'del', ''))) {
					require __DIR__ . "/callback_query/conditions_del.php";
				} else if (str_starts_with($callback_data, joinPipe('condition', 'delete', ''))) {
					require __DIR__ . "/callback_query/conditions_delete.php";
				}

				// Alerts Operations
				if (preg_match("/^alert\|(TON|SOL)\|.*\|\d+$/", $callback_data)) {
					require __DIR__ . "/callback_query/alert_set.php";
				} else if (preg_match("/^alert\|(TON|SOL)\|.*$/", $callback_data)) {
					require __DIR__ . "/callback_query/alert_type.php";
				} else if (str_starts_with($callback_data, joinPipe('alert', 'create', ''))) {
					require __DIR__ . "/callback_query/alert_create.php";
				} else if (str_starts_with($callback_data, joinPipe('alert', 'addr', ''))) {
					require __DIR__ . "/callback_query/alert_custom.php";
				} else if (str_starts_with($callback_data, joinPipe('alert', 'info', ''))) {
					require __DIR__ . "/callback_query/alert_info.php";
				} else if (str_starts_with($callback_data, joinPipe('alert', 'del', ''))) {
					require __DIR__ . "/callback_query/alert_del.php";
				} else if (str_starts_with($callback_data, joinPipe('alert', 'delete', ''))) {
					require __DIR__ . "/callback_query/alert_delete.php";
				}

				// Trade Operations
				if (str_starts_with($callback_data, joinPipe('ex', 'info', ''))) {
					require __DIR__ . "/callback_query/trade_info.php";
				} else if (str_starts_with($callback_data, joinPipe('ex', 'addr', ''))) {
					require __DIR__ . "/callback_query/trade_custom.php";
				}

				// Trade Limit
				if (preg_match("/^ex\|lim\|\d+\|.*$/", $callback_data)) {
					require __DIR__ . "/callback_query/condition_limit.php";
				} else if (str_starts_with($callback_data, joinPipe('ex', 'lim', ''))) {
					require __DIR__ . "/callback_query/trade_limit.php";
				} else if (str_starts_with($callback_data, joinPipe('ex', 'plim', ''))) {
					require __DIR__ . "/callback_query/process_limit.php";
				}

				// Trade TP
				if (preg_match("/^ex\|tp\|\d+\|.*$/", $callback_data)) {
					require __DIR__ . "/callback_query/condition_tp.php";
				} else if (str_starts_with($callback_data, joinPipe('ex', 'tp', ''))) {
					require __DIR__ . "/callback_query/trade_tp.php";
				} else if (str_starts_with($callback_data, joinPipe('ex', 'ptp', ''))) {
					require __DIR__ . "/callback_query/process_tp.php";
				}

				// Trade SL
				if (preg_match("/^ex\|sl\|\d+\|.*$/", $callback_data)) {
					require __DIR__ . "/callback_query/condition_sl.php";
				} else if (str_starts_with($callback_data, joinPipe('ex', 'sl', ''))) {
					require __DIR__ . "/callback_query/trade_sl.php";
				} else if (str_starts_with($callback_data, joinPipe('ex', 'psl', ''))) {
					require __DIR__ . "/callback_query/process_sl.php";
				}

				// Language Operations
				if (str_starts_with($callback_data, joinPipe('language', 'set', ''))) {
					require __DIR__ . "/callback_query/language_set.php";
				}
				break;
		}
	} else {
		EditMessageReplyMarkup($callback_chat_id, $callback_msg_id, [
			'inline_keyboard' => [],
		]);

		$answer = t('callback_query.general.expired', $user['locale']);
		$show_alert = true;
	}
} else if ($flooding) {
	$answer = "Stop spamming the buttons you retarded piece of shit";
	$show_alert = true;
} else {
	// If we don't answer the callback_query, Telegram assumes the bot is down and throttles updates.
	$show_alert = true;
}

AnswerCallbackQuery($callback_id, $answer ?? t('callback_query.fallback', $user['locale'] ?? 'en'), $show_alert ?? false, $cache_time ?? 0);
