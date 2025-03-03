<?php

function setState(int|string $user_id, mixed &$redis, string | null $state = null, mixed $data = null)
{
	$redis->set(joinUnderline('state', $user_id), json_encode([
		's' => $state,
		'd' => $data,
	]));
}

function getState(int|string $user_id, mixed &$redis): array
{
	$data = $redis->get(joinUnderline('state', $user_id));

	if (!$data) {
		$data = [
			's' => null,
			'd' => null,
		];
	} else {
		$data = json_decode($data, true);
	}

	return [
		'state' => $data['s'],
		'sdata' => $data['d'],
	];
}
