<?php

$sdata['amount'] = (float)$text;

if ($sdata['amount']) {
	$asset = match ($sdata['blockchain']) {
		'TON' => $tableJettons->get($sdata['asset']),
		'SOL' => $tableTokens->get($sdata['asset']),
	};

	if ($asset) {
		setState($from_id, $redis);

		SendMessage($from_id, td(t('callback_query.swap.set.success_' . $sdata['type'], $user['locale']), [
			'symbol' => $asset['symbol'],
			'price'  => priceFormat($asset['price'] ?? '???'),
			'amount' => $sdata['amount'],
			'type'   => $sdata['blockchain'],
		]), $msg_id);

		$wallet = $user['wallets'][array_search($sdata['wallet_id'], array_column($user['wallets'], 'id'))];

		$offer = match ($sdata['type']) {
			'0' => $sdata['blockchain'],
			'1' => $sdata['asset'],
		};

		$ask = match ($sdata['type']) {
			'0' => $sdata['asset'],
			'1' => $sdata['blockchain'],
		};

		swapAsset($from_id, $sdata['blockchain'], $wallet['address'], $wallet['secret_key'], $offer, $sdata['amount'], $ask);
	}
} else {
	SendMessage($from_id, t('callback_query.swap.set.errors.amount_invalid', $user['locale']), $msg_id);
}
