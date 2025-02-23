<?php

defined('i18n_en') or define('i18n_en', [
	'private' => [
		'default' => [
			'text' => joinDoubleLine(
				"Welcome to <b>%bot_title%</b> 🙅‍♂️",
				"I'm the best trading bot you can get with 2-3 days of work and almost zero experience with blockchain.",
				"👛 Here are your wallets:",
				"%wallets%",
				"💡 For more info on your wallet and to retrieve your private key, tap the wallets button.",
				"🔑 You can also import your existing wallets and bet on whether you will be scammed or Not, perhaps? %bot_title%!",
			),
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
	],
	'inline_query' => [
		'notfound' => [
			'title' => 'Not Found',
			'message' => "We can't find any result matching your query."
		],
	],
	'callback_query' => [
		'fallback' => 'Silence is gold',
		'refresh' => '🔄 Data has been updated 🔄',
		'default' => '✔️',
		'wallets' => [
			'answer' => '💳 Wallets List 💳',
			'text'   => joinDoubleLine(
				"💡 You have <b>%count%</b> active wallets (Max: %max%)",
				"%wallets%",
				"⚙️ You can manage each wallet by clicking the buttons below."
			),
			'buttons' => [
				'new' => 'Create new wallet',
				'copy' => 'Copy Address',
			],
		],
		'create' => [
			'answer' => '🔗 Create Wallet 🔗',
			'text' => '🔗 What kind of wallet do you like to create?',
		],
		'create_wallet' => [
			'answer' => '⛓️ Wallet Created ⛓️',
			'answer_max' => '🚫 You already have %max%/%max% active wallets.',
			'text' => joinDoubleLine(
				'⛓️ Here is your new wallet:',
				'%wallet%',
			),
		],
		'import_wallet' => [
			'answer' => 'Soon, or probably not',
		],
		'wallet_info' => [
			'answer' => '💳 Wallet Info 💳',
			'text' => joinDoubleLine(
				'💳 Here is your wallet:',
				'%wallet%',
				'⚙️ You can manage wallet by clicking the buttons below.',
			),
			'buttons' => [
				'export' => '📤 Export Wallet',
				'delete' => '❌ Delete Wallet',
			],
		],
		'wallet_del' => [
			'answer' => '❌ Wallet Delete ❌',
			'answer_min' => '🚫 You must have at least %min% active wallets.',
			'text' => joinDoubleLine(
				"<b>Are you the hell certain of deleting this wallet?</b> There is no way to restore it if you haven't exported it and saved it yourself.",
				'%wallet%',
				"If you aren't drunk, then click on the ⏹️ button to delete the wallet.",
			),
		],
		'wallet_export' => [
			'answer' => '📤 Wallet Export 📤',
			'text' => joinDoubleLine(
				"🔐 Please keep the information below safe.",
				"%type_emoji% Blockchain: %type%",
				joinLine("<b>⛓️ Address:</b>", "<code>%address%</code>"),
				joinLine("<b>🔓 Public Key:</b>", "<code>%public%</code>"),
				joinLine("<b>🔐 Secret Key:</b>", "<code>%secret%</code>"),
				joinLine("<b>🔏 Mnemonic:</b>", "%mnemonic%"),
				"⚠️ Don't be an idiot by sharing your wallet secret to someone who is promising to make you rich.",
			),
		],
		'languages' => [
			'answer' => 'Languages',
			'text'   => 'Please select your desired language:',
		],
	],
	'general' => [
		'balance' => 'Balance',
		'address' => 'Address',
		'back'    => '🔙 Back',
		'copy'    => 'Copy',
	],
]);
