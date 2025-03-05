<?php

defined('i18n_en') or define('i18n_en', [
	'private' => [
		'default' => [
			'text' => joinDoubleLine(
				"Welcome to <b>%bot_title%</b> 🙅‍♂️",
				"I'm Definitely Not the best bot you can get with almost zero experience with blockchain.",
				"%prices%",
				"👛 Here are your wallets:",
				"%wallets%",
				"💡 For more info on your wallet and to retrieve your private key, tap the wallets button.",
				"🔑 You can also import your existing wallets and bet on whether you will be scammed or Not, perhaps? %bot_title%!",
				"🫰 For testing purposes, you can create orders with zero balance in the wallet.",
			),
			'buttons' => [
				'wallets'    => '💳 Wallets',
				'refresh'    => '🔄 Refresh',
				'swap'       => '⚡️ Instant Swap',
				'conditions' => '🗒 Conditions List',
				'alerts'     => '🔔 Alerts',
				'import'     => '🔑 Import Wallet',
				'copy'       => '👁‍🗨 Copy Trade',
				'trade'      => '💸 Trade Conditions',
				'languages'  => 'Language',
				'rates'      => '📊 Track Rates',
			],
		],
		'custom_asset' => [
			'invalid_address' => 'Please send a valid <b>%type%</b> asset address. You can use /start to cancel.',
			'processing' => '⏳ Please wait while we process the asset...',
			'invalid_asset' => '❌ Unfortunately we are unable to process this asset.',
			'inactive' => '🚫 This asset is currently not available in the DEX.',
		],
	],
	'inline_query' => [
		'price' => "The current price of <b>%symbol%</b> is <b>%price%</b>.",
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
		'conditions' => [
			'answer' => '🗒 Trade Conditions 🗒',
			'text'   => joinDoubleLine(
				"💡 You have <b>%count%</b> pending trade conditions (Max: %max%)",
				"%conditions%",
				"⚙️ You can manage each condition by clicking the buttons below"
			),
			'delete' => [
				'answer' => '❌ Condition Delete ❌',
				'text' => joinDoubleLine(
					"<b>Are you sure of deleting this condition?</b>",
					'%condition%',
					"If you aren't drunk, then click on the ⏹️ button to delete the condition.",
				),
			],
			'info' => [
				'answer' => '🗒 Condition Info 🗒',
				'text' => joinDoubleLine(
					'🗒 Here is your condition:',
					'%condition%',
					'⚙️ You can manage condition by clicking the buttons below.',
				),
				'buttons' => [
					'delete' => '❌ Delete Condition',
				],
			],
			'errors' => [
				'max' => '🚫 You already have reached the limit of <b>%max%</b> number of active trade conditions, please delete some before you continue.',
			],
			'trigger' => "🗒 Your <b>%type%</b> for <b>%amount% %symbol%</b> on <b>%price%</b> is triggered and you will be notified of the result of order.",
		],
		'create' => [
			'answer' => '🔗 Create Wallet 🔗',
			'text' => '🔗 What kind of wallet would you like to create?',
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
				"Also note that by deleting the wallet, all trade orders for the wallet will be wiped out.",
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
		'trade' => [
			'answer' => '💸 Trade Conditions 💸',
			'text'   => joinDoubleLine(
				'💡 You can automate your trades based on conditions.',
				"%wallets%",
				'💳 Please select a wallet to set trading conditions:',
			),
		],
		'custom_asset' => [
			'answer' => 'Please send the contract address of the asset on %type% blockchain. You can use /start to cancel.',
			'buttons' => [
				'custom' => 'Custom Address',
			],
		],
		'trade_info' => [
			'answer' => '💸 Trade Conditions 💸',
			'text'   => joinDoubleLine(
				'💡 You can automate your trades based on conditions.',
				"%wallet%",
			),
			'buttons' => [
				'limit' => '💢 Limit Order',
				'tp'    => '💰 Take Profit',
				'sl'    => '🛑 Stop Loss',
			],
		],
		'trade_limit' => [
			'answer' => '💢 Limit Order 💢',
			'text'   => joinDoubleLine(
				"🎯 Please choose the target asset you would like to buy with your <b>%type%</b>. If your target asset is not listed below, you can choose custom address address.",
				"%wallet%",
			),
			'condition' => [
				'text' => joinDoubleLine(
					"<b>💢 Limit Order</b>",
					joinLine(
						"🪙 %name% (<b>%symbol%</b>) (<b>%price%</b>)",
						"<code>%address%</code>"
					),
					"%wallet%",
					"💸 You have <b>%balance% %symbol%</b>",
				),
				'price' => 'Please enter the price target for buying <b>%symbol%</b> by <b>%type%</b> in <b>USD</b> (eg: <code>%price%</code>):',
				'amount' => 'Please enter the amount of <b>%type%</b> to swap for <b>%symbol%</b> when <b>%symbol%</b> reaches <b>%price%</b>:',
				'success' => '✅ Your Limit Order for swapping <b>%amount% %type%</b> to <b>%symbol%</b> when it reaches <b>%price%</b> has been placed successfully. You can use /start to continue.',
				'errors' => [
					'price_invalid' => 'The price you entered is not a valid numeric price. Please enter a valid price. You can use /start to cancel.',
					'price_higher'  => 'The price you entered is already higher than the current <b>%price%</b>, you can use instant trade. Please enter a valid price. You can use /start to cancel.',
					'amount_invalid' => 'The amount you entered is not a valid numeric amount. Please enter a valid amount. You can use /start to cancel.',
				],
			],
		],
		'trade_tp' => [
			'answer' => '💰 Take Profit 💰',
			'text'   => joinDoubleLine(
				"🎯 Please choose the target asset you would like to sell and receive <b>%type%</b>. If your target asset is not listed below, you can choose custom address address.",
				"%wallet%",
			),
			'condition' => [
				'text' => joinDoubleLine(
					"<b>💰 Take Profit</b>",
					joinLine(
						"🪙 %name% (<b>%symbol%</b>) (<b>%price%</b>)",
						"<code>%address%</code>"
					),
					"%wallet%",
					"💸 You have <b>%balance% %symbol%</b>",
				),
				'price' => 'Please enter the price target for selling <b>%symbol%</b> in <b>USD</b> and receiving <b>%type%</b> (eg: <code>%price%</code>):',
				'amount' => 'Please enter the amount of <b>%symbol%</b> to sell when it reaches <b>%price%</b>:',
				'success' => '✅ Your Take Profit for selling <b>%amount% %symbol%</b> when <b>%symbol%</b> reaches <b>%price%</b> has been placed successfully. You can use /start to continue.',
				'errors' => [
					'price_invalid'  => 'The price you entered is not a valid numeric price. Please enter a valid price. You can use /start to cancel.',
					'price_lower'    => 'The price you entered is already lower than the current <b>%price%</b>, you can set Stop Loss for it. Please enter a valid price. You can use /start to cancel.',
					'amount_invalid' => 'The amount you entered is not a valid numeric amount. Please enter a valid amount. You can use /start to cancel.',
				],
			],
		],
		'trade_sl' => [
			'answer' => '🛑 Stop Loss 🛑',
			'text'   => joinDoubleLine(
				"🎯 Please choose the target asset you would like to sell and receive <b>%type%</b>. If your target asset is not listed below, you can choose custom address address.",
				"%wallet%",
			),
			'condition' => [
				'text' => joinDoubleLine(
					"<b>🛑 Stop Loss</b>",
					joinLine(
						"🪙 %name% (<b>%symbol%</b>) (<b>%price%</b>)",
						"<code>%address%</code>"
					),
					"%wallet%",
					"💸 You have <b>%balance% %symbol%</b>",
				),
				'price' => 'Please enter the price target for selling <b>%symbol%</b> in <b>USD</b> and receiving <b>%type%</b> (eg: <code>%price%</code>):',
				'amount' => 'Please enter the amount of <b>%symbol%</b> to sell when it drops to <b>%price%</b>:',
				'success' => '✅ Your Stop Loss for selling <b>%amount% %symbol%</b> when <b>%symbol%</b> drops to <b>%price%</b> has been placed successfully. You can use /start to continue.',
				'errors' => [
					'price_invalid'  => 'The price you entered is not a valid numeric price. Please enter a valid price. You can use /start to cancel.',
					'price_higher'   => 'The price you entered is already higher than the current <b>%price%</b>, you can set Take Profit for it. Please enter a valid price. You can use /start to cancel.',
					'amount_invalid' => 'The amount you entered is not a valid numeric amount. Please enter a valid amount. You can use /start to cancel.',
				],
			],
		],
		'alerts' => [
			'answer' => '🔔 Alerts 🔔',
			'text'   => joinDoubleLine(
				"💡 You have <b>%count%</b> active alerts (Max: %max%)",
				"%alerts%",
				"⚙️ You can manage each alert by clicking the buttons below."
			),
			'buttons' => [
				'new' => 'Create New Alert',
			],
			'create' => [
				'answer' => '🔗 Choose Blockchain 🔗',
				'text' => '🔗 What blockchain would you like to watch?',
			],
			'choose' => [
				'answer' => '🎯 Choose Target 🎯',
				'text'   => "🎯 Please choose the target asset you would like to track. If your target asset is not listed below, you can choose custom address address.",
			],
			'type' => [
				'answer' => '📊 Choose Type 📊',
				'text' => '📊 What type of price movement for <b>%symbol%</b> would you like to be notified about—an increase or a decrease?',
				'buttons' => [
					'increase' => '📈 Increase',
					'decrease' => '📉 Decrease',
				],
			],
			'set' => [
				'answer' => '💲 Enter Price 💲',
				'price' => 'Please enter the price threshold for <b>%symbol%</b> in <b>USD</b> (eg: <code>%price%</code>):',
				'success_0' => '📉 Your Alert for <b>%symbol%</b> price movement lower than <b>%price%</b> has been set successfully. You can use /start to continue.',
				'success_1' => '📈 Your Alert for <b>%symbol%</b> price movement higher than <b>%price%</b> has been set successfully. You can use /start to continue.',
				'errors' => [
					'price_invalid'  => 'The price you entered is not a valid numeric price. Please enter a valid price. You can use /start to cancel.',
				],
			],
			'delete' => [
				'answer' => '❌ Alert Delete ❌',
				'text' => joinDoubleLine(
					"<b>Are you sure of deleting this alert?</b>",
					'%alert%',
					"If you aren't drunk, then click on the ⏹️ button to delete the alert.",
				),
			],
			'info' => [
				'answer' => '🗒 Alert Info 🗒',
				'text' => joinDoubleLine(
					'🗒 Here is your alert:',
					'%alert%',
					'⚙️ You can manage alert by clicking the buttons below.',
				),
				'buttons' => [
					'delete' => '❌ Delete Alert',
				],
			],
			'errors' => [
				'max' => '🚫 You already have reached the limit of <b>%max%</b> number of active alerts, please delete some before you continue.',
			],
			'notify' => [
				'0' => '📉 Price of <b>%symbol%</b> dropped below <b>%price%</b>.',
				'1' => '📈 Price of <b>%symbol%</b> rise above <b>%price%</b>.',
			],
		],
		'swap' => [
			'answer' => '⚡️ Instant Swap ⚡️',
			'create' => [
				'answer' => '🔗 Choose Wallet 🔗',
				'text' => joinDoubleLine(
					"<b>⚡️ Instant Swap ⚡️</b>",
					"%wallets%",
					'💳 Please select a wallet to continue',
				),
			],
			'choose' => [
				'answer' => '🎯 Choose Target 🎯',
				'text'   => "🎯 Please choose the target asset you would like to swap. If your target asset is not listed below, you can choose custom address address.",
			],
			'type' => [
				'answer' => '↔️ Choose Type ↔️',
				'text' => '↔️ What type of swap for <b>%symbol% (%price%)</b> would you like to place?',
				'buttons' => [
					'buy' => '📥 Buy',
					'sell' => '📤 Sell',
				],
			],
			'set' => [
				'answer' => '💲 Enter Amount 💲',
				'amount_0' => 'Please enter the amount of <b>%type%</b> to swap for <b>%symbol% (%price%)</b>:',
				'amount_1' => 'Please enter the amount of <b>%symbol% (%price%)</b> you would like to sell:',
				'success_0' => '📥 Your Buy Order for swapping <b>%amount% %type%</b> to <b>%symbol% (%price%)</b> has been placed successfully. You will be notified from the result of swap. You can use /start to continue.',
				'success_1' => '📤 Your Sell Order for <b>%amount% %symbol% (%price%)</b> has been placed successfully. You will be notified from the result of swap. You can use /start to continue.',
				'errors' => [
					'amount_invalid'  => 'The amount you entered is not a valid numeric amount. Please enter a valid amount. You can use /start to cancel.',
				],
			],
			'transaction' => [
				'success' => '✅ Swap transaction from <b>%from%</b> to <b>%to%</b> succeeded.',
				'failed' => '❌ Swap transaction from <b>%from%</b> to <b>%to%</b> failed.',
			],
		],
		'general' => [
			'buttons' => [
				'price' => 'Enter Price',
			],
			'expired' => '⚠️ This message is expired, please use the latest message for interactions.',
		],
	],
	'general' => [
		'balance' => 'Balance',
		'address' => 'Address',
		'back'    => '🔙 Back',
		'copy'    => 'Copy',
	],
]);
