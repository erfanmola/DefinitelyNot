<?php

function generateMessageDefaultText(mixed $user): string
{
	return td(t('private.default.text', $user['locale']), [
		'bot_title' => 'Definitely Not',
		'wallets'   => implode("\n\n", array_map(
			fn($wallet) => implode("\n", [
				t('general.balance') . ": <b>{$wallet['balance']} {$wallet['type']}</b>",
				"<code>{$wallet['address']}</code>",
			]),
			$user['wallets']
		)),
	]);
}

function generateMessageDefaultButtons(mixed $user): array
{
	return [
		[
			[
				'text' => t('private.default.buttons.wallets'),
				'callback_data' => 'wallets',
			],
			[
				'text' => t('private.default.buttons.refresh'),
				'callback_data' => 'refresh',
			],
		],
		[
			[
				'text' => t('private.default.buttons.copy'),
				'callback_data' => 'copy',
			],
			[
				'text' => t('private.default.buttons.limit'),
				'callback_data' => 'limit',
			],
		],
		[
			[
				'text' => language_flags[$user['locale']] . ' ' . t('private.default.buttons.languages'),
				'callback_data' => 'languages',
			],
			[
				'text' => t('private.default.buttons.alerts'),
				'callback_data' => 'alerts',
			],
		],
		[
			[
				'text' => t('private.default.buttons.import'),
				'callback_data' => 'import',
			],
		],
	];
}
