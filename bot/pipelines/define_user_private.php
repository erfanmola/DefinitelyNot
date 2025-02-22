<?php

$user = getUser($from_id, '*', $mysqli);
$user_params = [
	'user_id'    => $from_id,
	'first_name' => $from_name,
	'last_name'  => $from_lastname,
	'username'   => $from_username,
	'locale'     => $from_language_code ?? 'en',
];

if ($user) {
	$user_params_diff = array_filter(array_keys($user_params), function ($index) use ($user_params, $user) {
		return $user_params[$index] != $user[$index];
	});

	if (count($user_params_diff) > 0) {
		updateUser(
			$from_id,
			array_combine($user_params_diff, array_map(fn($index) => $user_params[$index], $user_params_diff)),
			$mysqli
		);

		foreach ($user_params_diff as $index) {
			$user[$index] = $user_params[$index];
		}
	}
} else {
	$user = createUser($user_params, $mysqli);
}
