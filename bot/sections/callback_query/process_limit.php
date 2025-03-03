<?php

[,, $wallet_id, $asset_address] = splitPipe($callback_data);

$wallet_index = array_search($wallet_id, array_column($user['wallets'], 'id'));

if ($wallet_index > -1) {
	$wallet = $user['wallets'][$wallet_index];

	$asset = match ($wallet['type']) {
		'TON' => $tableJettons->get($asset_address),
		'SOL' => $tableTokens->get($asset_address),
	};

	EditMessageReplyMarkup($callback_chat_id, $callback_msg_id, [
		'inline_keyboard' => [],
	]);

	$answer = t('callback_query.trade_limit.answer', $user['locale']);

	syncWalletsBalanceDeferred([$wallet]);

	setState($callback_from_id, $redis, joinUnderline('trade', 'process'), [
		'type' => 'limit',
		'state' => 'price',
		'wallet_id' => $wallet['id'],
		'blockchain' => $wallet['type'],
	]);

	SendMessage($callback_chat_id, td(t('callback_query.trade_limit.condition.price', $user['locale']), [
		'symbol' => $asset['symbol'],
		'price' => priceFormat($asset['price'], prefix: ''),
		'type' => $wallet['type'],
	]), $callback_msg_id);
}
