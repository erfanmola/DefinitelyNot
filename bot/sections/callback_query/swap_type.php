<?php

[, $blockchain, $asset_address] = splitPipe($callback_data);

$asset = match ($blockchain) {
	'TON' => $tableJettons->get($asset_address),
	'SOL' => $tableTokens->get($asset_address),
};

if ($asset) {
	EditMessageText($callback_chat_id, $callback_msg_id, td(
		t('callback_query.swap.type.text', $user['locale']),
		[
			'symbol' => $asset['symbol'] ?? truncateWalletAddress($asset_address, 3, 3),
			'price'  => priceFormat($asset['price'] ?? '???'),
		]
	), null, [
		'reply_markup' => [
			'inline_keyboard' => [
				[
					[
						'text' => t('callback_query.swap.type.buttons.buy', $user['locale']),
						'callback_data' => joinPipe('swap', $blockchain, $asset_address, '0'),
					],
					[
						'text' => t('callback_query.swap.type.buttons.sell', $user['locale']),
						'callback_data' => joinPipe('swap', $blockchain, $asset_address, '1'),
					],
				],
			],
		],
	]);

	$answer = t('callback_query.swap.type.answer', $user['locale']);
}
