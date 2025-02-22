<?php

if (isset($result['channel_post']) || isset($result['edited_message'])) {
	$result['message'] = $result['channel_post'] ?? $result['edited_message'];
}

if (isset($result['message'])) {
	$messageData = $result['message'];

	$forward_from   = $messageData['forward_from']['id'] ?? null;
	$forward_sender = $messageData['forward_sender_name'] ?? null;
	$forward_date   = $messageData['forward_date'] ?? null;
	$date           = $messageData['date'] ?? null;
	$msg_entities   = $messageData['entities'] ?? null;

	$from          = $messageData['from'] ?? [];
	$from_id       = $from['id'] ?? null;
	$from_name     = $from['first_name'] ?? null;
	$from_lastname = $from['last_name'] ?? null;
	$from_fullname = htmlspecialchars(trim(($from['first_name'] ?? '') . ' ' . ($from['last_name'] ?? '')));
	$from_username = $from['username'] ?? null;
	$from_language_code = $from['language_code'] ?? null;

	$chat          = $messageData['chat'] ?? [];
	$chat_id       = $chat['id'] ?? null;
	$chat_type     = $chat['type'] ?? null;
	$chat_username = $chat['username'] ?? null;

	$msg_id        = $messageData['message_id'] ?? null;
	$text          = $messageData['text'] ?? $messageData['caption'] ?? null;
	$via_bot       = $messageData['via_bot'] ?? false;

	$result['message']['from']['full_name'] = $from_name;

	if (isset($messageData['reply_to_message'])) {
		$reply = $messageData['reply_to_message'];
		$reply_from = $reply['from'] ?? [];
		$reply_to_message_id = $reply['message_id'] ?? null;
		$reply_to_message_text = $reply['text'] ?? null;
		$reply_to_message_from_id = $reply_from['id'] ?? null;
		$reply_to_message_from_name = $reply_from['first_name'];
		$reply_to_message_from_lastname = $reply_from['last_name'] ?? null;
		$reply_to_message_from_fullname = htmlspecialchars(trim(($reply_from['first_name'] ?? '') . ' ' . ($reply_from['last_name'] ?? '')));
		$reply_to_message_from_username = $reply_from['username'] ?? null;
		$reply_to_message_from_bot = $reply_from['is_bot'] ?? false;
	}
} elseif (isset($result['callback_query'])) {
	$callback = $result['callback_query'];

	$callback_data = $callback['data'] ?? null;
	$callback_id = $callback['id'] ?? null;

	$callback_from = $callback['from'] ?? [];
	$callback_from_id = $callback_from['id'] ?? null;
	$callback_from_name = $callback_from['first_name'];
	$callback_from_lastname = $callback_from['last_name'] ?? null;
	$callback_from_fullname = htmlspecialchars(trim(($callback_from['first_name'] ?? '') . ' ' . ($callback_from['last_name'] ?? '')));
	$callback_from_username = $callback_from['username'] ?? null;

	$callback_message = $callback['message'] ?? [];
	$callback_msg_id = $callback_message['message_id'] ?? null;
	$callback_msg_text = $callback_message['text'] ?? null;
	$callback_chat_id = $callback_message['chat']['id'] ?? null;
	$callback_msg_reply_markup = $callback_message['reply_markup'] ?? null;
} elseif (isset($result['inline_query'])) {
	$inline_query = $result['inline_query'];

	$inline_query_id = $inline_query['id'] ?? null;
	$inline_query_text = $inline_query['query'] ?? null;
	$inline_query_offset = $inline_query['offset'] ?? null;

	$inline_query_from = $inline_query['from'] ?? [];
	$inline_query_from_id = $inline_query_from['id'] ?? null;
	$inline_query_from_name = $inline_query_from['first_name'];
	$inline_query_from_lastname = $inline_query_from['last_name'] ?? null;
	$inline_query_from_fullname = htmlspecialchars(trim(($inline_query_from['first_name'] ?? '') . ' ' . ($inline_query_from['last_name'] ?? '')));
	$inline_query_from_username = $inline_query_from['username'] ?? null;
} elseif (isset($result['chosen_inline_result'])) {
	$chosen_inline_result = $result['chosen_inline_result'];

	$chosen_inline_result_from = $chosen_inline_result['from'] ?? [];
	$chosen_inline_result_from_id = $chosen_inline_result_from['id'] ?? null;
	$chosen_inline_result_from_name = $chosen_inline_result_from['first_name'];
	$chosen_inline_result_from_lastname = $chosen_inline_result_from['last_name'] ?? null;
	$chosen_inline_result_from_fullname = htmlspecialchars(trim(($chosen_inline_result_from['first_name'] ?? '') . ' ' . ($chosen_inline_result_from['last_name'] ?? '')));
	$chosen_inline_result_from_username = $chosen_inline_result_from['username'] ?? null;
	$chosen_inline_result_query = $chosen_inline_result['query'] ?? null;
	$chosen_inline_result_result_id = $chosen_inline_result['result_id'] ?? null;
	$chosen_inline_result_msg_id = $chosen_inline_result['inline_message_id'] ?? null;
}
