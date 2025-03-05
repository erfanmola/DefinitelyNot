<?php

[, $wallet_id, $asset_address, $type] = splitPipe($callback_data);

$wallet_index = array_search($wallet_id, array_column($user['wallets'], 'id'));

if ($wallet_index > -1) {
	$wallet = $user['wallets'][$wallet_index];
	$blockchain = $wallet['type'];

	$asset = match ($blockchain) {
		'TON' => $tableJettons->get($asset_address),
		'SOL' => $tableTokens->get($asset_address),
	};

	if ($asset) {
		EditMessageText($callback_chat_id, $callback_msg_id, td(
			t('callback_query.swap.set.amount_' . $type, $user['locale']),
			[
				...$asset,
				'price' => priceFormat($asset['price'] ?? '???'),
				'type'  => $blockchain,
			]
		), null, [
			'reply_markup' => [
				'inline_keyboard' => [],
			],
		]);

		$answer = t('callback_query.swap.set.answer', $user['locale']);

		setState($callback_from_id, $redis, joinPipe('swap', 'amount'), [
			'wallet_id'  => $wallet_id,
			'blockchain' => $blockchain,
			'asset'      => $asset_address,
			'type'       => $type,
		]);
	}
}
