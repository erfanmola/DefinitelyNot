<?php
/*
    Author: Erfan Mola
    https://Developix.ir
    Version: 1.0.4
*/

function DPXDBQuery(string $table, array|string $fields = '*', array|string $conditions = [], array|string $orders = [], int $limit = -1, int $offset = -1, bool $count_only = false, bool $single_result = true, array $json_fields = [], array $casts = [], &$conn = null): array|int
{

	global $DPXDBQueryLock;

	if ($DPXDBQueryLock) {

		while ($DPXDBQueryLock->get() === 1) {

			usleep(1000);
		}

		$DPXDBQueryLock->set(1);
	}

	if (!($conn)) {

		global $conn;
	}

	$fields = is_array($fields) ? '`' . implode('`, `', $fields) . '`' : $fields;

	if ($count_only) {

		$query = "SELECT COUNT(*) FROM `{$table}`";
	} else {

		$query = "SELECT {$fields} FROM `{$table}`";
	}

	if (is_array($conditions) && !(empty($conditions))) {

		$query .= ' WHERE ' . DPXDBQueryGenerateConditions($conditions, $conn);
	} else if (is_string($conditions) && strlen($conditions)) {

		$query .= " WHERE {$conditions}";
	}

	if (is_array($orders) && !(empty($orders))) {

		$query .= ' ORDER BY ';

		$counter = 0;

		foreach ($orders as $key => $value) {

			if (is_string($key)) {

				$query .= ($counter !== 0 ? ', ' : '') . "`{$key}` {$value}";
			} else {

				$query .= ($counter !== 0 ? ', ' : '') . "`{$value}` ASC";
			}

			$counter++;
		}
	} else if (is_string($orders) && strlen($orders)) {

		$query .= " ORDER BY {$orders}";
	}

	if ($limit >= 0) {

		$query .= " LIMIT {$limit}";
	}

	if ($offset >= 0) {

		$query .= " OFFSET {$offset}";
	}

	if ($count_only) {

		$return = (int)$conn->query($query)->fetch_assoc()['COUNT(*)'];
	} else {

		$result = (array)$conn->query($query)->fetch_all(MYSQLI_ASSOC);

		if (!(empty($json_fields))) {

			foreach ($result as $key => $value) {

				foreach ($json_fields as $field) {

					if (isset($result[$key][$field])) {
						$decoded = json_decode($result[$key][$field], true);
						if (is_array($decoded)) {
							$result[$key][$field] = $decoded;
						} else {
							$result[$key][$field] = json_decode(stripslashes($result[$key][$field]), true);
						}
					}
				}
			}
		}

		if (!(empty($casts))) {

			foreach ($result as $key => $value) {

				foreach ($casts as $field => $cast) {

					if (isset($result[$key][$field])) {

						switch ($cast) {
							case 'number':
								$result[$key][$field] = (int)$result[$key][$field];
								break;
							case 'double':
								$result[$key][$field] = (float)$result[$key][$field];
								break;
							case 'float':
								$result[$key][$field] = (float)$result[$key][$field];
								break;
							case 'string':
								$result[$key][$field] = (string)$result[$key][$field];
								break;
							case 'boolean':
								$result[$key][$field] = (bool)$result[$key][$field];
								break;
							case 'array':
								$decoded = json_decode($result[$key][$field], true);
								if (is_array($decoded)) {
									$result[$key][$field] = $decoded;
								} else {
									$result[$key][$field] = json_decode(stripslashes($result[$key][$field]), true);
								}
								break;
						}
					}
				}
			}
		}

		if (isset($result[1]) || !($single_result)) {

			$return = (array)$result;
		} else {

			$return = (array)($result[0] ?? []);
		}
	}

	if ($DPXDBQueryLock) {

		$DPXDBQueryLock->set(0);
	}

	return $return;
}

function DPXDBQueryGenerateConditions(array $conditions, &$conn)
{

	$condition = '';

	$counter = 0;

	foreach ($conditions as $key => $value) {

		if (is_int($key)) {

			$condition .= ($counter !== 0 ? ' OR (' : '(') . DPXDBQueryGenerateConditions($value, $conn) . ')';
		} else {

			if (!(is_array($value))) {

				$condition .= ($counter !== 0 ? ' AND ' : '') . " `{$key}` = " . full_mysqli_real_escape_string($value);
			} else {

				if (!(is_array(reset($value)))) {

					$condition .= ($counter !== 0 ? ' AND ' : '') . " `{$key}` {$value[1]} " . full_mysqli_real_escape_string($value[0]);

					if (isset($value[3])) {

						$condition .= " AND `{$key}` {$value[3]} " . full_mysqli_real_escape_string($value[2]);
					}
				}
			}
		}

		$counter++;
	}

	return $condition;
}

function DPXDBRawQuery(string $query, &$conn = null, bool $async = false)
{

	global $DPXDBQueryLock;

	if ($DPXDBQueryLock) {

		while ($DPXDBQueryLock->get() === 1) {

			usleep(1000);
		}

		$DPXDBQueryLock->set(1);
	}

	if (!($conn)) {

		global $conn;
	}

	$return = $conn->query($query, $async ? MYSQLI_ASYNC : MYSQLI_STORE_RESULT);

	if ($DPXDBQueryLock) {

		$DPXDBQueryLock->set(0);
	}

	return $return;
}

function SyncDBInsert(string $table, array $fields, &$conn = null, bool $async = false)
{

	if (!($conn)) {

		global $conn;
	}

	$query = "INSERT INTO `$table`";

	if (!(is_array(reset($fields)))) {

		$fields = [$fields];
	}

	$query .= '(`' . implode('`, `', array_keys($fields[0])) . '`) VALUES';

	$i = 0;

	foreach ($fields as $data) {

		$query .= ($i !== 0 ? ',' : '') . ' (';

		$j = 0;

		foreach ($data as $value) {

			$query .= ($j !== 0 ? ',' : '') . " " . full_mysqli_real_escape_string(is_array($value) ? addslashes(json_encode($value)) : $value);
			$j++;
		}

		$query .= ')';

		$i++;
	}

	return $conn->query($query, $async ? MYSQLI_ASYNC : MYSQLI_STORE_RESULT);
}

function SyncDBUpdate(string $table, array $fields, array|string $conditions = [], &$conn = null, bool $async = false)
{

	if (!($conn)) {

		global $conn;
	}

	$query = "UPDATE `$table` SET";

	if (!(is_array(reset($fields)))) {

		$fields = [$fields];
	}

	$i = 0;

	foreach ($fields as $data) {

		$query .= ($i !== 0 ? ',' : '') . ' ';

		$j = 0;

		foreach ($data as $key => $value) {

			$query .= ($j !== 0 ? ',' : '') . " `$key` = " . full_mysqli_real_escape_string(is_array($value) ? addslashes(json_encode($value)) : $value);
			$j++;
		}

		$i++;
	}

	if (is_array($conditions)) {

		$query .= ' WHERE ' . DPXDBQueryGenerateConditions($conditions, $conn);
	} else {

		if (strlen($conditions)) {

			$query .= " WHERE {$conditions}";
		}
	}

	return $conn->query($query, $async ? MYSQLI_ASYNC : MYSQLI_STORE_RESULT);
}

function SyncDBDelete(string $table, array|string $conditions = [], int $limit = -1, int $offset = -1, &$conn = null, bool $async = false)
{

	if (!($conn)) {

		global $conn;
	}

	$query = "DELETE FROM `{$table}`";

	if (is_array($conditions)) {

		$query .= ' WHERE ' . DPXDBQueryGenerateConditions($conditions, $conn);
	} else {

		if (strlen($conditions)) {

			$query .= " WHERE {$conditions}";
		}
	}

	if ($limit >= 0) {

		$query .= " LIMIT {$limit}";
	}

	if ($offset >= 0) {

		$query .= " OFFSET {$offset}";
	}

	return $conn->query($query, $async ? MYSQLI_ASYNC : MYSQLI_STORE_RESULT);
}

if (defined('SWOOLE_BASE')) {

	Co::set(['hook_flags' => SWOOLE_HOOK_ALL]);

	$DPXDBQueryLock = new Swoole\Atomic(0);

	function DPXDBInsert(string $table, array $fields, &$conn = null, bool $async = false)
	{

		global $DPXDBQueryLock;

		if ($DPXDBQueryLock->get() === 0) {

			if (count(Swoole\Coroutine::list()) > 0) {

				go(function () use (&$table, &$fields, &$conn, &$DPXDBQueryLock, &$async) {

					$DPXDBQueryLock->set(1);

					SyncDBInsert($table, $fields, $conn, $async);

					$DPXDBQueryLock->set(0);
				});
			} else {

				$DPXDBQueryLock->set(1);

				SyncDBInsert($table, $fields, $conn, $async);

				$DPXDBQueryLock->set(0);
			}
		} else {

			Swoole\Timer::after(1, "DPXDBInsert", $table, $fields, $conn, $async);
		}
	}

	function DPXDBUpdate(string $table, array $fields, array|string $conditions = [], &$conn = null, bool $async = false)
	{

		global $DPXDBQueryLock;

		if ($DPXDBQueryLock->get() === 0) {

			if (count(Swoole\Coroutine::list()) > 0) {

				go(function () use (&$table, &$fields, &$conditions, &$conn, &$DPXDBQueryLock, &$async) {

					$DPXDBQueryLock->set(1);

					SyncDBUpdate($table, $fields, $conditions, $conn, $async);

					$DPXDBQueryLock->set(0);
				});
			} else {

				$DPXDBQueryLock->set(1);

				SyncDBUpdate($table, $fields, $conditions, $conn, $async);

				$DPXDBQueryLock->set(0);
			}
		} else {

			Swoole\Timer::after(1, "DPXDBUpdate", $table, $fields, $conditions, $conn, $async);
		}
	}

	function DPXDBDelete(string $table, array|string $conditions = [], int $limit = -1, int $offset = -1, &$conn = null, bool $async = false)
	{

		global $DPXDBQueryLock;

		if ($DPXDBQueryLock->get() === 0) {

			if (count(Swoole\Coroutine::list()) > 0) {

				go(function () use (&$table, &$conditions, &$limit, &$offset, &$conn, &$DPXDBQueryLock, &$async) {

					$DPXDBQueryLock->set(1);

					SyncDBDelete($table, $conditions, $limit, $offset, $conn, $async);

					$DPXDBQueryLock->set(0);
				});
			} else {

				$DPXDBQueryLock->set(1);

				SyncDBDelete($table, $conditions, $limit, $offset, $conn, $async);

				$DPXDBQueryLock->set(0);
			}
		} else {

			Swoole\Timer::after(1, "DPXDBDelete", $table, $conditions, $limit, $offset, $conn, $async);
		}
	}
} else {

	function DPXDBInsert(string $table, array $fields, &$conn = null, bool $async = false)
	{

		return SyncDBInsert($table, $fields, $conn, $async);
	}

	function DPXDBUpdate(string $table, array $fields, array|string $conditions = [], &$conn = null, bool $async = false)
	{

		return SyncDBUpdate($table, $fields, $conditions, $conn, $async);
	}

	function DPXDBDelete(string $table, array|string $conditions = [], int $limit = -1, int $offset = -1, &$conn = null, bool $async = false)
	{

		return SyncDBDelete($table, $conditions, $limit, $offset, $conn, $async);
	}
}

function full_mysqli_real_escape_string(string | null $string): string
{
	$map = [
		"\x00" => "\\0",  // NUL byte
		"\n"   => "\\n",  // newline
		"\r"   => "\\r",  // carriage return
		"\\"   => "\\\\", // backslash
		"'"    => "\\'",  // single quote
		'"'    => '\\"',  // double quote
		"\x1a" => "\\Z"   // Ctrl+Z
	];

	// For common single-byte charsets (including utf8/utf8mb4) we can use strtr.
	// (Note: For utf8/utf8mb4, even though they are multi-byte, none of the
	// bytes in a valid sequence conflict with the escape sequences above.)
	return is_null($string) ? 'NULL' : ("'" . strtr($string, $map) . "'");
}
