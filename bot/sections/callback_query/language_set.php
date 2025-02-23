<?php

[,, $lang] = splitPipe($callback_data);

if (array_key_exists($lang, languages)) {
	$user['locale'] = $lang;

	updateUser($callback_from_id, [
		'locale' => $lang,
	], $mysqli);

	$callback_data = 'default';

	require __DIR__ . "/../callback_query.php";
}
