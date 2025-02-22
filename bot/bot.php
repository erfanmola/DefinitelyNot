<?php

if (isset($result['edited_message'])) {
	$result['message'] = $result['edited_message'];
}

if (isset($result['message'])) {
	if ($chat_type === 'private') {
		require __DIR__ . "/sections/private.php";
	} else if ($chat_type === 'group' || $chat_type === 'supergroup') {
		LeaveChat($chat_id);
	}
} else if (isset($result['channel_post'])) {
	$chat_id = $result['channel_post']['chat']['id'];
	$msg_id = $result['channel_post']['message_id'];

	LeaveChat($chat_id);
} else if ($callback) {
	require __DIR__ . "/sections/callback_query.php";
} else if ($inline_query) {
	require __DIR__ . "/sections/inline_query.php";
}
