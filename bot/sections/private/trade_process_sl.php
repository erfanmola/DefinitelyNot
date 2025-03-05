<?php

switch ($sdata['state']) {
	case 'price':
		$sdata['price'] = (float)$text;

		if ($sdata['price']) {
			if ($sdata['price'] >= $asset['price']) {
				SendMessage($from_id, td(t('callback_query.trade_sl.condition.errors.price_higher', $user['locale']), [
					'price' => priceFormat($asset['price']),
				]), $msg_id);
			} else {
				$sdata['state'] = 'amount';
				setState($from_id, $redis, joinPipe('trade', 'process'), $sdata);

				SendMessage($from_id, td(t('callback_query.trade_sl.condition.amount', $user['locale']), [
					'symbol' => $asset['symbol'],
					'price' => priceFormat($sdata['price']),
				]), $msg_id);
			}
		} else {
			SendMessage($from_id, t('callback_query.trade_sl.condition.errors.price_invalid', $user['locale']), $msg_id);
		}

		break;

	case 'amount':
		$sdata['amount'] = (int)str_replace([' ', ',', '-', '_'], '', $text);

		if ($sdata['amount']) {
			setState($from_id, $redis);

			if (count(getTradeConditionsByStatus($from_id, 0, $mysqli)) < config['TRADE_CONDITIONS_PENDING_MAX']) {

				createTradeCondition([
					'user_id'    => $from_id,
					'wallet_id'  => $sdata['wallet_id'],
					'blockchain' => $sdata['blockchain'],
					'type'       => 1,
					'price'      => $sdata['price'],
					'amount'     => $sdata['amount'],
					'asset'      => $sdata['asset_address'],
				], $mysqli);

				SendMessage($from_id, td(t('callback_query.trade_sl.condition.success', $user['locale']), [
					'amount' => number_format($sdata['amount']),
					'symbol' => $asset['symbol'],
					'price'  => priceFormat($sdata['price']),
				]), $msg_id);
			} else {

				SendMessage($from_id, td(t('callback_query.conditions.errors.max', $user['locale']), [
					'max' => config['TRADE_CONDITIONS_PENDING_MAX'],
				]), $msg_id);
			}
		} else {
			SendMessage($from_id, t('callback_query.trade_sl.condition.errors.amount_invalid', $user['locale']), $msg_id);
		}

		break;
}
