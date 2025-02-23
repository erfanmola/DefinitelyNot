<?php

$results = [];

if ($results === []) {

	$results[] = [
		'type'        => 'article',
		'id'          => 'NotFound',
		'title'       => t('inline_query.notfound.title', $user['locale']),
		'description' => t('inline_query.notfound.message', $user['locale']),
		'input_message_content' => [
			'message_text' => t('inline_query.notfound.message', $user['locale']),
			'parse_mode' => 'HTML',
		],
	];
}

AnswerInlineQuery($inline_query_id, $results ?? [], $is_personal ?? false, $cache_time ?? 300, $next_offset ?? null, $switch_pm_text ?? null, $switch_pm_parameter ?? null, $button ?? null, $sync ?? null);
