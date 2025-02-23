<?php

function getUser(int|string $user_id, array | string $fields = '*', mixed $conn): array | null
{
	return DPXDBQuery('users', $fields, ['user_id' => $user_id], casts: [
		'id'      => 'number',
		'user_id' => 'number',
	], conn: $conn);
}

function createUser(array $fields, mixed $conn): array
{
	DPXDBInsert('users', $fields, $conn);
	return getUser($fields['user_id'], '*', $conn);
}

function updateUser(int|string $user_id, array $fields, mixed $conn): void
{
	DPXDBUpdate('users', [
		...$fields,
		'updated_at' => date("Y-m-d H:i:s"),
	], ['user_id' => $user_id], $conn);
}
