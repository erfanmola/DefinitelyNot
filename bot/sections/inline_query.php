<?php

require __DIR__ . "/../pipelines/define_user_params.php";

$results = [];

require __DIR__ . "/inline_query/prices.php";

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

$offset = (int)($inline_query['offset'] ?? 0);
$results = array_slice($results, $offset, 50);
$next_offset = $offset + count($results);

AnswerInlineQuery($inline_query_id, $results ?? [], $is_personal ?? false, $cache_time ?? 300, $next_offset ?? null, $switch_pm_text ?? null, $switch_pm_parameter ?? null, $button ?? null, $sync ?? null);
