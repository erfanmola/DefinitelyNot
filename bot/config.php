<?php

defined('config') or define('config', [
	'PROCESS_WORKER_NUM'  => 4,
	'PROCESS_REACTOR_NUM' => 4,
	'MYSQL_CONNECTION_POOL_SIZE_MAX' => 8,
	'REDIS_CONNECTION_POOL_SIZE_MAX' => 8,
	'TOTAL_WALLETS_MIN' => 1,
	'TOTAL_WALLETS_MAX' => 4,
	'CACHE_TABLE_BALANCE_SIZE' => 1024,
	'CACHE_TABLE_BALANCE_TIME' => 30, // Seconds
]);
