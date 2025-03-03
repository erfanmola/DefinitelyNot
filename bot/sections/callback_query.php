<?php

$flooding = IsUserFlooding($callback_from_id, 16, 30, 'callback_query');

if ($flooding === false) {
	require __DIR__ . "/../pipelines/define_user_params.php";
	require __DIR__ . "/../pipelines/define_user_wallets.php";

	$active_msg_id = $redis->get(joinUnderline($callback_from_id, 'recent', 'msg', 'id'));

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

				// Conditions Operations
				if (str_starts_with($callback_data, joinPipe('condition', 'info', ''))) {
					require __DIR__ . "/callback_query/conditions_info.php";
				} else if (str_starts_with($callback_data, joinPipe('condition', 'del', ''))) {
					require __DIR__ . "/callback_query/conditions_del.php";
				} else if (str_starts_with($callback_data, joinPipe('condition', 'delete', ''))) {
					require __DIR__ . "/callback_query/conditions_delete.php";
				}

				// Trade Operations
				if (str_starts_with($callback_data, joinPipe('ex', 'info', ''))) {
					require __DIR__ . "/callback_query/trade_info.php";
				} else if (preg_match("/^ex\|lim\|\d+\|.*$/", $callback_data)) {
					require __DIR__ . "/callback_query/condition_limit.php";
				} else if (str_starts_with($callback_data, joinPipe('ex', 'lim', ''))) {
					require __DIR__ . "/callback_query/trade_limit.php";
				} else if (str_starts_with($callback_data, joinPipe('ex', 'plim', ''))) {
					require __DIR__ . "/callback_query/process_limit.php";
				} else if (str_starts_with($callback_data, joinPipe('ex', 'addr', ''))) {
					require __DIR__ . "/callback_query/trade_custom.php";
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
