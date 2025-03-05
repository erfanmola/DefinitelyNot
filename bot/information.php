<?php

define('token', $_ENV['BOT_TOKEN']);

define('TDXToken', token);
define('TDXResponse', false);
define('TDXBotAPIServer', $_ENV['BOT_API_SERVER']);
define('TDXAdmin', $_ENV['BOT_REPORT_ADMIN_ID']);

define('languages', [
	'en' => 'English',
	'fa' => 'فارسی',
	// 'ru' => 'Русский',
	// 'ar' => 'العربية',
	// 'de' => 'Deutsch',
	// 'hi' => 'हिंदी'
]);

define('language_flags', [
	'en' => '🇺🇸',
	'fa' => '🇮🇷',
	'ru' => '🇷🇺',
	'ar' => '🇸🇦',
	'de' => '🇩🇪',
	'hi' => '🇮🇳',
]);

define('blockchain_emoji', [
	'TON' => '🔵',
	'SOL' => '🟣',
]);

define('native_asset_emoji', [
	'TON' => '💎',
	'SOL' => '🧬',
]);

define('asset_emoji', [
	'TON' => '💙',
	'SOL' => '💜',
]);

define('trade_condition_types', [
	0 => 'limit',
	1 => 'sl',
	2 => 'tp',
]);

define('trade_condition_types_symbol', [
	0 => 'LIM',
	1 => 'SL',
	2 => 'TP',
]);

define('alert_types', [
	0 => 'DEC',
	1 => 'INC',
]);

define('swap_types', [
	0 => 'Buy',
	1 => 'Sell',
]);

define('patterns', [
	'wallet' => [
		'TON' => "/^(EQ|Ef)[0-9A-Za-z_-]{46}$/",
		'SOL' => "/^[1-9A-HJ-NP-Za-km-z]{44}$/",
	],
]);

define('not_art', [
	'art' => [
		'⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️',
		'⬛️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬛️',
		'⬛️⬜️🔳⬜️⬜️⬜️🔳⬜️⬛️',
		'⬛️⬜️🔳🔳⬜️⬜️🔳⬜️⬛️',
		'⬛️⬜️🔳⬜️🔳⬜️🔳⬜️⬛️',
		'⬛️⬜️🔳⬜️⬜️🔳🔳⬜️⬛️',
		'⬛️⬜️🔳⬜️⬜️⬜️🔳⬜️⬛️',
		'⬛️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬛️',
		'⬛️⬜️⬜️🔳🔳🔳⬜️⬜️⬛️',
		'⬛️⬜️🔳⬜️⬜️⬜️🔳⬜️⬛️',
		'⬛️⬜️🔳⬜️⬜️⬜️🔳⬜️⬛️',
		'⬛️⬜️🔳⬜️⬜️⬜️🔳⬜️⬛️',
		'⬛️⬜️⬜️🔳🔳🔳⬜️⬜️⬛️',
		'⬛️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬛️',
		'⬛️⬜️🔳🔳🔳🔳🔳⬜️⬛️',
		'⬛️⬜️⬜️⬜️🔳⬜️⬜️⬜️⬛️',
		'⬛️⬜️⬜️⬜️🔳⬜️⬜️⬜️⬛️',
		'⬛️⬜️⬜️⬜️🔳⬜️⬜️⬜️⬛️',
		'⬛️⬜️⬜️⬜️🔳⬜️⬜️⬜️⬛️',
		'⬛️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬛️',
		'⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️',
	],
	'empty' => [
		'⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️',
		'⬛️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬛️',
		'⬛️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬛️',
		'⬛️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬛️',
		'⬛️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬛️',
		'⬛️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬛️',
		'⬛️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬛️',
		'⬛️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬛️',
		'⬛️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬛️',
		'⬛️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬛️',
		'⬛️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬛️',
		'⬛️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬛️',
		'⬛️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬛️',
		'⬛️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬛️',
		'⬛️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬛️',
		'⬛️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬛️',
		'⬛️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬛️',
		'⬛️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬛️',
		'⬛️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬛️',
		'⬛️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬛️',
		'⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️',
	]
]);

date_default_timezone_set('UTC');
