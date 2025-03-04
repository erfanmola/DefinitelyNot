<?php

function generateMessageDefaultText(mixed $user): string
{
	return td(t('private.default.text', $user['locale']), [
		'bot_title' => 'Definitely Not',
		'wallets'   => generateWalletsListText($user['wallets'], $user['locale']),
		'prices'    => generateNativePricesText(),
	]);
}

function generateMessageDefaultButtons(mixed $user): array
{
	return [
		[
			[
				'text' => t('private.default.buttons.wallets', $user['locale']),
				'callback_data' => 'wallets',
			],
			[
				'text' => t('private.default.buttons.refresh', $user['locale']),
				'callback_data' => 'refresh',
			],
		],
		[
			[
				'text' => t('private.default.buttons.trade', $user['locale']),
				'callback_data' => 'trade',
			],
			[
				'text' => t('private.default.buttons.conditions', $user['locale']),
				'callback_data' => 'conditions',
			],
		],
		[
			[
				'text' => t('private.default.buttons.swap', $user['locale']),
				'callback_data' => 'swap',
			],
			[
				'text' => t('private.default.buttons.alerts', $user['locale']),
				'callback_data' => 'alerts',
			],
		],
		[
			[
				'text' => joinSpace(language_flags[$user['locale']], t('private.default.buttons.languages', $user['locale'])),
				'callback_data' => 'languages',
			],
			[
				'text' => t('private.default.buttons.rates', $user['locale']),
				'url' => joinEmpty("https://t.me/", $_ENV['RATES_CHANNEL_USERNAME']),
			],
		],
		[
			[
				'text' => t('private.default.buttons.import', $user['locale']),
				'callback_data' => 'import_wallet',
			],
			[
				'text' => t('private.default.buttons.copy', $user['locale']),
				'callback_data' => 'copytrade',
			],
		],
	];
}

function generateWalletsListText(array $wallets, string $locale): string
{
	return joinDoubleLine(...array_map(
		fn($wallet) => joinLine(
			joinSpace(
				blockchain_emoji[$wallet['type']],
				joinEmpty(
					t('general.balance', $locale),
					": <b>" . ((float)$wallet['balance'] ? rtrim((number_format($wallet['balance'], 9))) : 0) . " {$wallet['type']}</b>",
				),
			),
			"<code>{$wallet['address']}</code>",
		),
		$wallets
	));
}

function generateTradeConditionsListText(array $conditions): string
{
	return joinDoubleLine(...array_map(
		fn($condition) => joinLine(
			joinSpace(
				blockchain_emoji[$condition['wallet']['type']],
				trade_condition_types_symbol[$condition['type']],
				'|',
				number_format($condition['amount']),
				$condition['asset']['symbol'] ?? truncateWalletAddress($condition['asset_address'], 3, 3),
				'|',
				joinEmpty("<b>", priceFormat($condition['price']), "</b>"),
			),
			"<code>{$condition['wallet']['address']}</code>",
		),
		$conditions
	));
}

function generateNativePricesText(): string
{
	global $tableNative;

	$items = [];

	foreach (['TON', 'SOL'] as $type) {
		$price = $tableNative->get($type, 'price');

		if ($price) {
			$string = match ($type) {
				'TON' => '💎',
				'SOL' => '🧬',
			};
			$string .= " <b>{$type}: " . priceFormat($price, 4) . "</b>";
			$items[] = $string;
		}
	}

	return joinLine(...$items);
}

function generateAssetPricesText(string $type, string $emoji = ''): string
{
	$items = [];

	switch ($type) {
		case 'TON':
			global $tableJettons, $predefinedJettons;

			foreach ($tableJettons as $jetton) {
				if ($jetton['active'] && $jetton['price'] && $jetton['symbol'] && $predefinedJettons->exists($jetton['address'])) {
					$items[] = $jetton;
				}
			}
			break;

		case 'SOL':
			global $tableTokens, $predefinedTokens;

			foreach ($tableTokens as $token) {
				if ($token['active'] && $token['price'] && $token['symbol'] && $predefinedTokens->exists($token['address'])) {
					$items[] = $token;
				}
			}
			break;
	}

	$items = array_map(
		fn($item) =>
		joinSpace(
			$emoji,
			joinEmpty($item['symbol'], ':'),
			priceFormat($item['price'], 6),
		),
		$items
	);

	return joinLine(...$items);
}
