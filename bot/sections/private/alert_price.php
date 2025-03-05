<?php

$sdata['price'] = (float)$text;

if ($sdata['price']) {
	$asset = match ($sdata['blockchain']) {
		'TON' => $tableJettons->get($sdata['asset']),
		'SOL' => $tableTokens->get($sdata['asset']),
	};

	if ($asset) {
		setState($from_id, $redis);

		createAlert([
			'user_id'    => $from_id,
			'blockchain' => $sdata['blockchain'],
			'type'       => $sdata['type'],
			'price'      => $sdata['price'],
			'asset'      => $sdata['asset'],
		], $mysqli);

		SendMessage($from_id, td(t('callback_query.alerts.set.success_' . strtolower(alert_types[$sdata['type']]), $user['locale']), [
			'symbol' => $asset['symbol'],
			'price' => priceFormat($sdata['price']),
		]), $msg_id);
	}
} else {
	SendMessage($from_id, t('callback_query.alerts.set.errors.price_invalid', $user['locale']), $msg_id);
}
