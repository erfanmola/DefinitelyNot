<?php

if (isset($result['channel_post']) || isset($result['edited_message'])) {
	$result['message'] = $result['channel_post'] ?? $result['edited_message'];
}

if (isset($result['message'])) {
	$messageData = &$result['message'];

	$forward_from   = &assignReferenceIfNotNull($messageData['forward_from']['id']);
	$forward_sender = &assignReferenceIfNotNull($messageData['forward_sender_name']);
	$forward_date   = &assignReferenceIfNotNull($messageData['forward_date']);
	$date           = &assignReferenceIfNotNull($messageData['date']);
	$msg_entities   = &assignReferenceIfNotNull($messageData['entities']);

	$from          = &$messageData['from'] ?? [];
	$from_id       = &assignReferenceIfNotNull($from['id']);
	$from_name     = &assignReferenceIfNotNull($from['first_name']);
	$from_lastname = &assignReferenceIfNotNull($from['last_name']);
	$from_fullname = htmlspecialchars(trim(($from['first_name'] ?? '') . ' ' . ($from['last_name'] ?? '')));
	$from_username = &assignReferenceIfNotNull($from['username']);
	$from_language_code = &assignReferenceIfNotNull($from['language_code']);

	$from['full_name'] = $from_fullname;

	$chat          = &$messageData['chat'] ?? [];
	$chat_id       = &assignReferenceIfNotNull($chat['id']);
	$chat_type     = &assignReferenceIfNotNull($chat['type']);
	$chat_username = &assignReferenceIfNotNull($chat['username']);

	$msg_id        = &assignReferenceIfNotNull($messageData['message_id']);
	$text          = &assignReferenceIfNotNull($messageData['text'], $messageData['caption']);
	$via_bot       = &assignReferenceIfNotNull($messageData['via_bot']);

	if (isset($messageData['reply_to_message'])) {
		$reply = &$messageData['reply_to_message'];
		$reply_from = &$reply['from'] ?? [];
		$reply_to_message_id = &assignReferenceIfNotNull($reply['message_id']);
		$reply_to_message_text = &assignReferenceIfNotNull($reply['text']);
		$reply_to_message_from_id = &assignReferenceIfNotNull($reply_from['id']);
		$reply_to_message_from_name = &assignReferenceIfNotNull($reply_from['first_name']);
		$reply_to_message_from_lastname = &assignReferenceIfNotNull($reply_from['last_name']);
		$reply_to_message_from_fullname = htmlspecialchars(trim(($reply_from['first_name'] ?? '') . ' ' . ($reply_from['last_name'] ?? '')));
		$reply_to_message_from_username = &assignReferenceIfNotNull($reply_from['username']);
		$reply_to_message_from_bot = &assignReferenceIfNotNull($reply_from['is_bot']);

		$reply_from['full_name'] = $reply_to_message_from_fullname;
	}
} elseif (isset($result['callback_query'])) {
	$callback = &$result['callback_query'];

	$callback_data = &assignReferenceIfNotNull($callback['data']);
	$callback_id = &assignReferenceIfNotNull($callback['id']);

	$callback_from = &$callback['from'] ?? [];
	$callback_from_id = &assignReferenceIfNotNull($callback_from['id']);
	$callback_from_name = &assignReferenceIfNotNull($callback_from['first_name']);
	$callback_from_lastname = &assignReferenceIfNotNull($callback_from['last_name']);
	$callback_from_fullname = htmlspecialchars(trim(($callback_from['first_name'] ?? '') . ' ' . ($callback_from['last_name'] ?? '')));
	$callback_from_username = &assignReferenceIfNotNull($callback_from['username']);

	$callback_from['full_name'] = $callback_from_fullname;

	$callback_message = &$callback['message'] ?? [];
	$callback_msg_id = &assignReferenceIfNotNull($callback_message['message_id']);
	$callback_msg_text = &assignReferenceIfNotNull($callback_message['text']);
	$callback_chat_id = &assignReferenceIfNotNull($callback_message['chat']['id']);
	$callback_msg_reply_markup = &assignReferenceIfNotNull($callback_message['reply_markup']);

	$callback_inline_message_id = &assignReferenceIfNotNull($callback['inline_message_id']);
} elseif (isset($result['inline_query'])) {
	$inline_query = &$result['inline_query'];

	$inline_query_id = &assignReferenceIfNotNull($inline_query['id']);
	$inline_query_text = &assignReferenceIfNotNull($inline_query['query']);
	$inline_query_offset = &assignReferenceIfNotNull($inline_query['offset']);

	$inline_query_from = &$inline_query['from'] ?? [];
	$inline_query_from_id = &assignReferenceIfNotNull($inline_query_from['id']);
	$inline_query_from_name = &assignReferenceIfNotNull($inline_query_from['first_name']);
	$inline_query_from_lastname = &assignReferenceIfNotNull($inline_query_from['last_name']);
	$inline_query_from_fullname = htmlspecialchars(trim(($inline_query_from['first_name'] ?? '') . ' ' . ($inline_query_from['last_name'] ?? '')));
	$inline_query_from_username = &assignReferenceIfNotNull($inline_query_from['username']);

	$inline_query_from['full_name'] = $inline_query_from_fullname;
} elseif (isset($result['chosen_inline_result'])) {
	$chosen_inline_result = &$result['chosen_inline_result'];

	$chosen_inline_result_from = &$chosen_inline_result['from'] ?? [];
	$chosen_inline_result_from_id = &assignReferenceIfNotNull($chosen_inline_result_from['id']);
	$chosen_inline_result_from_name = &assignReferenceIfNotNull($chosen_inline_result_from['first_name']);
	$chosen_inline_result_from_lastname = &assignReferenceIfNotNull($chosen_inline_result_from['last_name']);
	$chosen_inline_result_from_fullname = htmlspecialchars(trim(($chosen_inline_result_from['first_name'] ?? '') . ' ' . ($chosen_inline_result_from['last_name'] ?? '')));
	$chosen_inline_result_from_username = &assignReferenceIfNotNull($chosen_inline_result_from['username']);
	$chosen_inline_result_query = &assignReferenceIfNotNull($chosen_inline_result['query']);
	$chosen_inline_result_result_id = &assignReferenceIfNotNull($chosen_inline_result['result_id']);
	$chosen_inline_result_msg_id = &assignReferenceIfNotNull($chosen_inline_result['inline_message_id']);

	$chosen_inline_result_from['full_name'] = $chosen_inline_result_from_fullname;
}
