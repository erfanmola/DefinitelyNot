<?php

function generateMessageDefaultText(mixed $user): string
{
	return td(t('private.default.text', $user['locale']), [
		'bot_title' => 'Definitely Not',
		'wallets'   => generateWalletsListText($user['wallets'], $user['locale']),
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
				'text' => t('private.default.buttons.copy', $user['locale']),
				'callback_data' => 'copytrade',
			],
			[
				'text' => t('private.default.buttons.limit', $user['locale']),
				'callback_data' => 'limit',
			],
		],
		[
			[
				'text' => joinSpace(language_flags[$user['locale']], t('private.default.buttons.languages', $user['locale'])),
				'callback_data' => 'languages',
			],
			[
				'text' => t('private.default.buttons.alerts', $user['locale']),
				'callback_data' => 'alerts',
			],
		],
		[
			[
				'text' => t('private.default.buttons.import', $user['locale']),
				'callback_data' => 'import_wallet',
			],
		],
	];
}

function generateWalletsListText(array $wallets, string $locale)
{
	return joinDoubleLine(...array_map(
		fn($wallet) => joinLine(
			joinSpace(
				blockchain_emoji[$wallet['type']],
				joinEmpty(
					t('general.balance', $locale),
					": <b>{$wallet['balance']} {$wallet['type']}</b>",
				),
			),
			"<code>{$wallet['address']}</code>",
		),
		$wallets
	));
}
