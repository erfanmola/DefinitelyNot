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
		]), $msg_id);

		// TODO: execute the order
	}
} else {
	SendMessage($from_id, t('callback_query.swap.set.errors.amount_invalid', $user['locale']), $msg_id);
}
