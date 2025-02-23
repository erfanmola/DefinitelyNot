<?php

defined('i18n_en') or define('i18n_en', [
	'private' => [
		'default' => [
			'text' => implode("\n", [
				"Welcome to <b>%bot_title%</b> 🙅‍♂️",
				"I'm the best trading bot you can get with 2-3 days of work and almost zero experience with blockchain.\n",
				"👛 Here are your wallets:\n\n%wallets%\n",
				"💡 For more info on your wallet and to retrieve your private key, tap the wallets button.\n",
				"🔑 You can also import your existing wallets and bet on whether you will be scammed or Not, perhaps? %bot_title%!",
			]),
			'buttons' => [
				'wallets'   => '💳 Wallets',
				'refresh'   => '🔄 Refresh',
				'alerts'    => '🔔 Alerts',
				'import'    => '🔑 Import Wallet',
				'copy'      => '👁‍🗨 Copy Trade',
				'limit'     => '💢 Limit Order',
				'languages' => 'Language',
			],
		],
		'flood' => [
			'message' => "🚫 Stop flooding, I'm gonna pretend that i'm angry and will not respond to you for some time.",
		],
	],
	'inline_query' => [
		'notfound' => [
			'title' => 'Not Found',
			'message' => "We can't find any result matching your query."
		],
	],
	'callback_query' => [
		'fallback' => 'Silence is gold',
		'refresh'  => '🔄 Data has been updated 🔄',
	],
	'general' => [
		'balance' => 'Balance',
		'address' => 'Address',
	],
]);
