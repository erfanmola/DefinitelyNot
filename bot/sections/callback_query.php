<?php

$flooding = IsUserFlooding($callback_from_id, 8, 30, 'callback_query');

if ($flooding === false) {
	require __DIR__ . "/../pipelines/define_user_params.php";

	if ($callback_data === 'refresh') {
		require __DIR__ . "/callback_query/refresh.php";
	}
} else if ($flooding) {
	$answer = "Stop spamming the buttons you retarded piece of shit";
	$show_alert = true;
} else {
	// If we don't answer the callback_query, Telegram assumes the bot is down and throttles updates.
	$show_alert = true;
}

AnswerCallbackQuery($callback_id, $answer ?? t('callback_query.fallback'), $show_alert ?? false, $cache_time ?? 0);
