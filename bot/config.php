<?php

defined('config') or define('config', [
	'PROCESS_WORKER_NUM'  => 4,
	'PROCESS_REACTOR_NUM' => 4,
	'MYSQL_CONNECTION_POOL_SIZE_MAX' => 8,
	'REDIS_CONNECTION_POOL_SIZE_MAX' => 8,
]);
