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
