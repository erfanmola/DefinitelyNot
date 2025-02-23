<?php

EditMessageText($callback_chat_id, $callback_msg_id, generateMessageDefaultText($user), null, [
	'reply_markup' => [
		'inline_keyboard' => generateMessageDefaultButtons($user),
	],
]);

$answer = t("callback_query.{$callback_data}", $user['locale']);

syncWalletsBalanceDeferred($user['wallets']);
