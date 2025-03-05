<?php

defined('i18n_de') or define('i18n_de', [
	'private' => [
		'default' => [
			'text' => joinDoubleLine(
				"Willkommen bei <b>%bot_title%</b> 🙅‍♂️",
				"Ich bin definitiv nicht der beste Bot, den man mit fast null Erfahrung im Blockchain-Bereich bekommen kann.",
				"%prices%",
				"👛 Hier sind deine Wallets:",
				"%wallets%",
				"💡 Für weitere Informationen zu deinem Wallet und um deinen privaten Schlüssel abzurufen, tippe auf den Wallet-Button.",
				"🔑 Du kannst auch deine bestehenden Wallets importieren und darauf wetten, ob du betrogen wirst oder nicht, vielleicht? %bot_title%!",
				"🫰 Zum Testen kannst du Bestellungen mit einem Nullsaldo im Wallet erstellen.",
			),
			'buttons' => [
				'wallets'    => '💳 Wallets',
				'refresh'    => '🔄 Aktualisieren',
				'swap'       => '⚡️ Sofortiger Swap',
				'conditions' => '🗒 Bedingungsliste',
				'alerts'     => '🔔 Benachrichtigungen',
				'import'     => '🔑 Wallet importieren',
				'copy'       => '👁‍🗨 Copy Trading',
				'trade'      => '💸 Handelsbedingungen',
				'languages'  => 'Sprache',
				'rates'      => '📊 Preise verfolgen',
			],
		],
		'custom_asset' => [
			'invalid_address' => 'Bitte sende eine gültige <b>%type%</b> Asset-Adresse. Du kannst /start verwenden, um abzubrechen.',
			'processing' => '⏳ Bitte warte, während wir das Asset verarbeiten...',
			'invalid_asset' => '❌ Leider können wir dieses Asset nicht verarbeiten.',
			'inactive' => '🚫 Dieses Asset ist derzeit im DEX nicht verfügbar.',
		],
	],
	'inline_query' => [
		'price' => "Der aktuelle Preis von <b>%symbol%</b> ist <b>%price%</b>.",
		'notfound' => [
			'title' => 'Nicht gefunden',
			'message' => "Wir können kein Ergebnis finden, das deiner Anfrage entspricht."
		],
	],
	'callback_query' => [
		'fallback' => 'Stille ist Gold',
		'refresh' => '🔄 Daten wurden aktualisiert 🔄',
		'default' => '✔️',
		'wallets' => [
			'answer' => '💳 Wallet-Liste 💳',
			'text'   => joinDoubleLine(
				"💡 Du hast <b>%count%</b> aktive Wallets (Max: %max%)",
				"%wallets%",
				"⚙️ Du kannst jedes Wallet verwalten, indem du auf die untenstehenden Schaltflächen klickst."
			),
			'buttons' => [
				'new' => 'Neues Wallet erstellen',
				'copy' => 'Adresse kopieren',
			],
		],
		'conditions' => [
			'answer' => '🗒 Handelsbedingungen 🗒',
			'text'   => joinDoubleLine(
				"💡 Du hast <b>%count%</b> ausstehende Handelsbedingungen (Max: %max%)",
				"%conditions%",
				"⚙️ Du kannst jede Bedingung verwalten, indem du auf die untenstehenden Schaltflächen klickst."
			),
			'delete' => [
				'answer' => '❌ Bedingung löschen ❌',
				'text' => joinDoubleLine(
					"<b>Bist du sicher, dass du diese Bedingung löschen möchtest?</b>",
					'%condition%',
					"Wenn du nicht betrunken bist, klicke auf die ⏹️-Schaltfläche, um die Bedingung zu löschen.",
				),
			],
			'info' => [
				'answer' => '🗒 Bedingungsinfo 🗒',
				'text' => joinDoubleLine(
					'🗒 Hier ist deine Bedingung:',
					'%condition%',
					'⚙️ Du kannst die Bedingung verwalten, indem du auf die untenstehenden Schaltflächen klickst.',
				),
				'buttons' => [
					'delete' => '❌ Bedingung löschen',
				],
			],
			'errors' => [
				'max' => '🚫 Du hast bereits das Limit von <b>%max%</b> aktiven Handelsbedingungen erreicht, bitte lösche einige, bevor du fortfährst.',
			],
			'trigger' => "🗒 Deine <b>%type%</b> für <b>%amount% %symbol%</b> bei <b>%price%</b> wurde ausgelöst und du wirst über das Ergebnis der Bestellung benachrichtigt.",
		],
		'create' => [
			'answer' => '🔗 Wallet erstellen 🔗',
			'text' => '🔗 Welche Art von Wallet möchtest du erstellen?',
		],
		'create_wallet' => [
			'answer' => '⛓️ Wallet erstellt ⛓️',
			'answer_max' => '🚫 Du hast bereits %max%/%max% aktive Wallets.',
			'text' => joinDoubleLine(
				'⛓️ Hier ist dein neues Wallet:',
				'%wallet%',
			),
		],
		'import_wallet' => [
			'answer' => 'Bald oder wahrscheinlich nicht',
		],
		'wallet_info' => [
			'answer' => '💳 Wallet-Info 💳',
			'text' => joinDoubleLine(
				'💳 Hier ist dein Wallet:',
				'%wallet%',
				'⚙️ Du kannst das Wallet verwalten, indem du auf die untenstehenden Schaltflächen klickst.',
			),
			'buttons' => [
				'export' => '📤 Wallet exportieren',
				'delete' => '❌ Wallet löschen',
			],
		],
		'wallet_del' => [
			'answer' => '❌ Wallet löschen ❌',
			'answer_min' => '🚫 Du musst mindestens %min% aktive Wallets haben.',
			'text' => joinDoubleLine(
				"<b>Bist du dir sicher, dass du dieses Wallet löschen möchtest?</b> Es gibt keine Möglichkeit, es wiederherzustellen, wenn du es nicht exportiert und selbst gespeichert hast.",
				"Beachte auch, dass durch das Löschen des Wallets alle Handelsaufträge für dieses Wallet gelöscht werden.",
				'%wallet%',
				"Wenn du nicht betrunken bist, klicke auf die ⏹️-Schaltfläche, um das Wallet zu löschen.",
			),
		],
		'wallet_export' => [
			'answer' => '📤 Wallet exportieren 📤',
			'text' => joinDoubleLine(
				"🔐 Bitte bewahre die folgenden Informationen sicher auf.",
				"%type_emoji% Blockchain: %type%",
				joinLine("<b>⛓️ Adresse:</b>", "<code>%address%</code>"),
				joinLine("<b>🔓 Öffentlicher Schlüssel:</b>", "<code>%public%</code>"),
				joinLine("<b>🔐 Privater Schlüssel:</b>", "<code>%secret%</code>"),
				joinLine("<b>🔏 Mnemonic:</b>", "%mnemonic%"),
				"⚠️ Sei kein Idiot und teile deinen Wallet-Schlüssel nicht mit jemandem, der dir verspricht, dich reich zu machen.",
			),
		],
		'languages' => [
			'answer' => 'Sprachen',
			'text'   => 'Bitte wähle deine gewünschte Sprache:',
		],
		'trade' => [
			'answer' => '💸 Handelsbedingungen 💸',
			'text'   => joinDoubleLine(
				'💡 Du kannst deine Trades basierend auf Bedingungen automatisieren.',
				"%wallets%",
				'💳 Bitte wähle ein Wallet, um Handelsbedingungen festzulegen:',
			),
		],
		'custom_asset' => [
			'answer' => 'Bitte sende die Vertragsadresse des Assets auf der %type% Blockchain. Du kannst /start verwenden, um abzubrechen.',
			'buttons' => [
				'custom' => 'Benutzerdefinierte Adresse',
			],
		],
		'trade_info' => [
			'answer' => '💸 Handelsbedingungen 💸',
			'text'   => joinDoubleLine(
				'💡 Du kannst deine Trades basierend auf Bedingungen automatisieren.',
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
				"🎯 Bitte wähle das Ziel-Asset, das du mit deinem <b>%type%</b> kaufen möchtest. Wenn dein Ziel-Asset nicht unten aufgeführt ist, kannst du eine benutzerdefinierte Adresse wählen.",
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
					"💸 Du hast <b>%balance% %symbol%</b>",
				),
				'price' => 'Bitte gib den Preis für den Kauf von <b>%symbol%</b> mit <b>%type%</b> in <b>USD</b> an (z.B.: <code>%price%</code>):',
				'amount' => 'Bitte gib die Menge von <b>%type%</b> an, die du für <b>%symbol%</b> tauschen möchtest, wenn <b>%symbol%</b> den Preis von <b>%price%</b> erreicht:',
				'success' => '✅ Dein Limit-Order für den Tausch von <b>%amount% %type%</b> in <b>%symbol%</b> bei <b>%price%</b> wurde erfolgreich platziert. Du kannst /start verwenden, um fortzufahren.',
				'errors' => [
					'price_invalid' => 'Der eingegebene Preis ist kein gültiger numerischer Preis. Bitte gib einen gültigen Preis an. Du kannst /start verwenden, um abzubrechen.',
					'price_higher'  => 'Der eingegebene Preis ist bereits höher als der aktuelle <b>%price%</b>, du kannst einen sofortigen Tausch durchführen. Bitte gib einen gültigen Preis an. Du kannst /start verwenden, um abzubrechen.',
					'amount_invalid' => 'Die eingegebene Menge ist keine gültige numerische Menge. Bitte gib eine gültige Menge an. Du kannst /start verwenden, um abzubrechen.',
				],
			],
		],
		'trade_tp' => [
			'answer' => '💰 Take Profit 💰',
			'text'   => joinDoubleLine(
				"🎯 Bitte wähle das Ziel-Asset, das du verkaufen und mit <b>%type%</b> empfangen möchtest. Wenn dein Ziel-Asset nicht unten aufgeführt ist, kannst du eine benutzerdefinierte Adresse wählen.",
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
					"💸 Du hast <b>%balance% %symbol%</b>",
				),
				'price' => 'Bitte gib den Zielpreis an, um <b>%symbol%</b> zu verkaufen und <b>%type%</b> zu erhalten (z.B.: <code>%price%</code>):',
				'amount' => 'Bitte gib die Menge von <b>%symbol%</b> an, die du verkaufen möchtest, wenn sie <b>%price%</b> erreicht:',
				'success' => '✅ Dein Take Profit für den Verkauf von <b>%amount% %symbol%</b> wenn <b>%symbol%</b> <b>%price%</b> erreicht, wurde erfolgreich platziert. Du kannst /start verwenden, um fortzufahren.',
				'errors' => [
					'price_invalid'  => 'Der eingegebene Preis ist kein gültiger numerischer Preis. Bitte gib einen gültigen Preis an. Du kannst /start verwenden, um abzubrechen.',
					'price_lower'    => 'Der eingegebene Preis ist bereits niedriger als der aktuelle <b>%price%</b>, du kannst Stop Loss dafür setzen. Bitte gib einen gültigen Preis an. Du kannst /start verwenden, um abzubrechen.',
					'amount_invalid' => 'Die eingegebene Menge ist keine gültige numerische Menge. Bitte gib eine gültige Menge an. Du kannst /start verwenden, um abzubrechen.',
				],
			],
		],
		'trade_sl' => [
			'answer' => '🛑 Stop Loss 🛑',
			'text'   => joinDoubleLine(
				"🎯 Bitte wähle das Ziel-Asset, das du verkaufen und mit <b>%type%</b> empfangen möchtest. Wenn dein Ziel-Asset nicht unten aufgeführt ist, kannst du eine benutzerdefinierte Adresse wählen.",
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
					"💸 Du hast <b>%balance% %symbol%</b>",
				),
				'price' => 'Bitte gib den Zielpreis an, um <b>%symbol%</b> in <b>USD</b> zu verkaufen und <b>%type%</b> zu erhalten (z.B.: <code>%price%</code>):',
				'amount' => 'Bitte gib die Menge von <b>%symbol%</b> an, die du verkaufen möchtest, wenn der Preis auf <b>%price%</b> fällt:',
				'success' => '✅ Dein Stop Loss für den Verkauf von <b>%amount% %symbol%</b> wenn <b>%symbol%</b> auf <b>%price%</b> fällt, wurde erfolgreich platziert. Du kannst /start verwenden, um fortzufahren.',
				'errors' => [
					'price_invalid'  => 'Der eingegebene Preis ist kein gültiger numerischer Preis. Bitte gib einen gültigen Preis an. Du kannst /start verwenden, um abzubrechen.',
					'price_higher'   => 'Der eingegebene Preis ist bereits höher als der aktuelle <b>%price%</b>, du kannst Take Profit dafür setzen. Bitte gib einen gültigen Preis an. Du kannst /start verwenden, um abzubrechen.',
					'amount_invalid' => 'Die eingegebene Menge ist keine gültige numerische Menge. Bitte gib eine gültige Menge an. Du kannst /start verwenden, um abzubrechen.',
				],
			],
		],
		'alerts' => [
			'answer' => '🔔 Benachrichtigungen 🔔',
			'text'   => joinDoubleLine(
				"💡 Du hast <b>%count%</b> aktive Benachrichtigungen (Max: %max%)",
				"%alerts%",
				"⚙️ Du kannst jede Benachrichtigung verwalten, indem du auf die untenstehenden Schaltflächen klickst."
			),
			'buttons' => [
				'new' => 'Neue Benachrichtigung erstellen',
			],
			'create' => [
				'answer' => '🔗 Blockchain wählen 🔗',
				'text' => '🔗 Welche Blockchain möchtest du beobachten?',
			],
			'choose' => [
				'answer' => '🎯 Ziel wählen 🎯',
				'text'   => "🎯 Bitte wähle das Ziel-Asset, das du verfolgen möchtest. Wenn dein Ziel-Asset nicht unten aufgeführt ist, kannst du eine benutzerdefinierte Adresse wählen.",
			],
			'type' => [
				'answer' => '📊 Typ wählen 📊',
				'text' => '📊 Welchen Preisbewegungstyp für <b>%symbol%</b> möchtest du benachrichtigt werden—eine Erhöhung oder eine Verringerung?',
				'buttons' => [
					'increase' => '📈 Erhöhung',
					'decrease' => '📉 Verringerung',
				],
			],
			'set' => [
				'answer' => '💲 Preis eingeben 💲',
				'price' => 'Bitte gib den Preisgrenzwert für <b>%symbol%</b> in <b>USD</b> an (z.B.: <code>%price%</code>):',
				'success_0' => '📉 Deine Benachrichtigung für die Preisbewegung von <b>%symbol%</b> unter <b>%price%</b> wurde erfolgreich gesetzt. Du kannst /start verwenden, um fortzufahren.',
				'success_1' => '📈 Deine Benachrichtigung für die Preisbewegung von <b>%symbol%</b> über <b>%price%</b> wurde erfolgreich gesetzt. Du kannst /start verwenden, um fortzufahren.',
				'errors' => [
					'price_invalid'  => 'Der eingegebene Preis ist kein gültiger numerischer Preis. Bitte gib einen gültigen Preis an. Du kannst /start verwenden, um abzubrechen.',
				],
			],
			'delete' => [
				'answer' => '❌ Benachrichtigung löschen ❌',
				'text' => joinDoubleLine(
					"<b>Bist du sicher, dass du diese Benachrichtigung löschen möchtest?</b>",
					'%alert%',
					"Wenn du nicht betrunken bist, klicke auf die ⏹️-Schaltfläche, um die Benachrichtigung zu löschen.",
				),
			],
			'info' => [
				'answer' => '🗒 Benachrichtigungsinfo 🗒',
				'text' => joinDoubleLine(
					'🗒 Hier ist deine Benachrichtigung:',
					'%alert%',
					'⚙️ Du kannst die Benachrichtigung verwalten, indem du auf die untenstehenden Schaltflächen klickst.',
				),
				'buttons' => [
					'delete' => '❌ Benachrichtigung löschen',
				],
			],
			'errors' => [
				'max' => '🚫 Du hast bereits das Limit von <b>%max%</b> aktiven Benachrichtigungen erreicht, bitte lösche einige, bevor du fortfährst.',
			],
			'notify' => [
				'0' => '📉 Der Preis von <b>%symbol%</b> ist unter <b>%price%</b> gefallen.',
				'1' => '📈 Der Preis von <b>%symbol%</b> ist über <b>%price%</b> gestiegen.',
			],
		],
		'swap' => [
			'answer' => '⚡️ Sofortiger Swap ⚡️',
			'create' => [
				'answer' => '🔗 Wallet wählen 🔗',
				'text' => joinDoubleLine(
					"<b>⚡️ Sofortiger Swap ⚡️</b>",
					"%wallets%",
					'💳 Bitte wähle ein Wallet, um fortzufahren',
				),
			],
			'choose' => [
				'answer' => '🎯 Ziel wählen 🎯',
				'text'   => "🎯 Bitte wähle das Ziel-Asset, das du tauschen möchtest. Wenn dein Ziel-Asset nicht unten aufgeführt ist, kannst du eine benutzerdefinierte Adresse wählen.",
			],
			'type' => [
				'answer' => '↔️ Typ wählen ↔️',
				'text' => '↔️ Welchen Swap-Typ für <b>%symbol% (%price%)</b> möchtest du platzieren?',
				'buttons' => [
					'buy' => '📥 Kaufen',
					'sell' => '📤 Verkaufen',
				],
			],
			'set' => [
				'answer' => '💲 Betrag eingeben 💲',
				'amount_0' => 'Bitte gib die Menge von <b>%type%</b> an, die du für <b>%symbol% (%price%)</b> tauschen möchtest:',
				'amount_1' => 'Bitte gib die Menge von <b>%symbol% (%price%)</b> an, die du verkaufen möchtest:',
				'success_0' => '📥 Dein Kaufauftrag für den Tausch von <b>%amount% %type%</b> in <b>%symbol% (%price%)</b> wurde erfolgreich platziert. Du wirst über das Ergebnis des Tauschs benachrichtigt. Du kannst /start verwenden, um fortzufahren.',
				'success_1' => '📤 Dein Verkaufsauftrag für <b>%amount% %symbol% (%price%)</b> wurde erfolgreich platziert. Du wirst über das Ergebnis des Tauschs benachrichtigt. Du kannst /start verwenden, um fortzufahren.',
				'errors' => [
					'amount_invalid'  => 'Die eingegebene Menge ist keine gültige numerische Menge. Bitte gib eine gültige Menge an. Du kannst /start verwenden, um abzubrechen.',
				],
			],
			'transaction' => [
				'success' => '✅ Swap-Transaktion von <b>%from%</b> nach <b>%to%</b> erfolgreich.',
				'failed' => '❌ Swap-Transaktion von <b>%from%</b> nach <b>%to%</b> fehlgeschlagen.',
			],
		],
		'general' => [
			'buttons' => [
				'price' => 'Preis eingeben',
			],
			'expired' => '⚠️ Diese Nachricht ist abgelaufen, bitte verwende die neueste Nachricht für Interaktionen.',
		],
	],
	'general' => [
		'balance' => 'Balance',
		'address' => 'Adresse',
		'back'    => '🔙 Zurück',
		'copy'    => 'Kopieren',
	],
]);
