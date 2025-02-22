<?php

$user = getUser($from_id, '*', $mysqli);

if (!$user) {
	DPXDBInsert('users', [
		'user_id'    => $from_id,
		'first_name' => $from_name,
		'last_name'  => $from_lastname,
		'username'   => $from_username,
		'locale'     => $from_language_code ?? 'en',
	], $mysqli);

	$user = getUser($from_id, '*', $mysqli);
}
