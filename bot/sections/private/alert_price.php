<?php

require __DIR__ . "/../../pipelines/define_user_alerts.php";

$sdata['price'] = (float)$text;

if ($sdata['price']) {
	if ($sdata['asset'] === '~') {
		$asset = [
			'symbol' => $sdata['blockchain'],
		];
	} else {
		$asset = match ($sdata['blockchain']) {
			'TON' => $tableJettons->get($sdata['asset']),
			'SOL' => $tableTokens->get($sdata['asset']),
		};
	}

	if ($asset) {
		setState($from_id, $redis);

		if (count($user['alerts']) < config['ALERTS_ACTIVE_MAX']) {

			createAlert([
				'user_id'    => $from_id,
				'blockchain' => $sdata['blockchain'],
				'type'       => $sdata['type'],
				'price'      => $sdata['price'],
				'asset'      => $sdata['asset'],
			], $mysqli);

			SendMessage($from_id, td(t('callback_query.alerts.set.success_' . $sdata['type'], $user['locale']), [
				'symbol' => $asset['symbol'],
				'price' => priceFormat($sdata['price']),
			]), $msg_id);
		} else {

			SendMessage($from_id, td(t('callback_query.alerts.errors.max', $user['locale']), [
				'max' => config['ALERTS_ACTIVE_MAX'],
			]), $msg_id);
		}
	}
} else {
	SendMessage($from_id, t('callback_query.alerts.set.errors.price_invalid', $user['locale']), $msg_id);
}
