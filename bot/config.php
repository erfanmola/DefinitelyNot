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
	'CACHE_TABLE_ASSETS_BALANCE_SIZE' => 2048,
	'CACHE_TABLE_ASSETS_BALANCE_TIME' => 30, // Seconds
	'TABLE_JETTONS_SIZE' => 128,
	'TABLE_TOKENS_SIZE' => 128,
	'TABLE_ALERTS_SIZE' => 1024, // value of 1_000_000 would be nice for production, ~91MB Memory per 1M Items
	'TABLE_CONDITIONS_SIZE' => 1024, // value of 1_000_000 would be nice for production, ~107MB Memory per 1M Items
	'TRADE_CONDITIONS_PENDING_MAX' => 10,
	'ALERTS_ACTIVE_MAX' => 10,
]);
