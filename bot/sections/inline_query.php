<?php

$results = [];

if ($results === []) {

	$results[] = [
		'type'        => 'article',
		'id'          => 'NotFound',
		'title'       => t('inline_query.notfound.title'),
		'description' => t('inline_query.notfound.message'),
		'input_message_content' => [
			'message_text' => t('inline_query.notfound.message'),
			'parse_mode' => 'HTML',
		],
	];
}

AnswerInlineQuery($inline_query_id, $results ?? [], $is_personal ?? false, $cache_time ?? 300, $next_offset ?? null, $switch_pm_text ?? null, $switch_pm_parameter ?? null, $button ?? null, $sync ?? null);
