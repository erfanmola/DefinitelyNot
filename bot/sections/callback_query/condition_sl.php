<?php

use OpenSwoole\Coroutine;

[,, $wallet_id, $asset_address] = splitPipe($callback_data);

$wallet_index = array_search($wallet_id, array_column($user['wallets'], 'id'));

if ($wallet_index > -1) {
	$wallet = $user['wallets'][$wallet_index];

	$asset = match ($wallet['type']) {
		'TON' => $tableJettons->get($asset_address),
		'SOL' => $tableTokens->get($asset_address),
	};

	Coroutine::defer(function () use (&$callback_chat_id, &$callback_msg_id, &$user, &$asset, &$wallet, &$asset_address) {
		EditMessageText($callback_chat_id, $callback_msg_id, td(
			t('callback_query.trade_sl.condition.text', $user['locale']),
			[
				...$asset,
				'price' => priceFormat($asset['price']),
				'wallet' => generateWalletsListText([$wallet], $user['locale']),
				'balance' => number_format(getWalletAssetBalance($wallet['type'], $wallet['address'], $asset_address)),
			]
		), null, [
			'reply_markup' => [
				'inline_keyboard' => [
					[
						[
							'text' => t('callback_query.general.buttons.price', $user['locale']),
							'callback_data' => joinPipe('ex', 'psl', $wallet['id'], $asset_address),
						],
					],
				],
			],
		]);
	});

	$answer = t('callback_query.trade_sl.answer', $user['locale']);

	syncWalletsBalanceDeferred([$wallet]);
}
