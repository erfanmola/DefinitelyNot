<?php

function getUser(int|string $user_id, array | string $fields = '*', mixed $conn): array | null
{
	return DPXDBQuery('users', $fields, ['user_id' => $user_id], conn: $conn);
}
