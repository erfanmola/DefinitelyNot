<?php

use OpenSwoole\Coroutine;

$valid_address = match ($sdata['blockchain']) {
	'TON' => preg_match("/^(EQ|Ef)[0-9A-Za-z_-]{46}$/", $text),
	'SOL' => preg_match("/^[1-9A-HJ-NP-Za-km-z]{44}$/", $text),
};

if ($valid_address) {
	setState($from_id, $redis);

	$wallet_index = array_search($sdata['wallet_id'], array_column($user['wallets'], 'id'));

	if ($wallet_index > -1) {
		$wallet = $user['wallets'][$wallet_index];

		[$sent_msg_id, $asset] = PromiseAll::all([
			function () use (&$from_id, &$user, &$msg_id) {
				$sent_message_id = SendMessage(
					$from_id,
					t('private.trade_custom.processing', $user['locale']),
					$msg_id,
					response: true,
				)['result']['message_id'] ?? 0;

				return $sent_message_id;
			},
			function () use (&$tableJettons, &$tableTokens, &$sdata, &$text) {
				$asset = match ($sdata['blockchain']) {
					'TON' => $tableJettons->get($text),
					'SOL' => $tableTokens->get($text),
				};

				if ($asset && $asset['symbol'] && $asset['price']) {
					return $asset;
				} else {
					$assets = requestController('/assets/track', [
						'assets' => [
							[
								'type'    => $sdata['blockchain'],
								'address' => $text,
							],
						],
					]);

					if ($assets && (count($assets['jettons']) || count($assets['tokens']))) {
						foreach ($assets['jettons'] as $jetton) {
							tableUpdate($tableJettons, $jetton['address'], $jetton);
						}

						foreach ($assets['tokens'] as $token) {
							tableUpdate($tableTokens, $token['address'], $token);
						}

						$tries = 0;

						do {
							$asset = match ($sdata['blockchain']) {
								'TON' => $tableJettons->get($text),
								'SOL' => $tableTokens->get($text),
							};

							$tries++;

							Coroutine::usleep(100_000);
						} while (!$asset['price'] && $tries <= 30);

						return $asset;
					}

					return null;
				}
			},
		]);

		$redis->set(joinUnderline($from_id, 'recent', 'msg', 'id'), $sent_msg_id);

		if ($asset) {
			if ($asset['active'] && $asset['price']) {

				EditMessageText($from_id, $sent_msg_id, td(
					t(match ($sdata['type']) {
						'lim' => 'callback_query.trade_limit.condition.text',
						'tp'  => 'callback_query.trade_tp.condition.text',
						'sl'  => 'callback_query.trade_sl.condition.text',
					}, $user['locale']),
					[
						...$asset,
						'price' => priceFormat($asset['price']),
						'wallet' => generateWalletsListText([$wallet], $user['locale']),
						'balance' => number_format(getWalletAssetBalance($wallet['type'], $wallet['address'], $asset['address'])),
					]
				), null, [
					'reply_markup' => [
						'inline_keyboard' => [
							[
								[
									'text' => t('callback_query.general.buttons.price', $user['locale']),
									'callback_data' => joinPipe('ex', joinEmpty('p', $sdata['type']), $wallet['id'], $asset['address']),
								],
							],
						],
					],
				]);
			} else {

				EditMessageText($from_id, $sent_msg_id, joinDoubleLine(
					td(
						t(match ($sdata['type']) {
							'lim' => 'callback_query.trade_limit.condition.text',
							'tp'  => 'callback_query.trade_tp.condition.text',
							'sl'  => 'callback_query.trade_sl.condition.text',
						}, $user['locale']),
						[
							...$asset,
							'price' => '???',
							'wallet' => generateWalletsListText([$wallet], $user['locale']),
							'balance' => number_format(getWalletAssetBalance($wallet['type'], $wallet['address'], $asset['address'])),
						]
					),
					t('private.trade_custom.inactive', $user['locale']),
				));
			}
		} else {
			EditMessageText($from_id, $sent_msg_id, t('private.trade_custom.invalid_asset', $user['locale']));
		}
	}
} else {
	SendMessage($from_id, td(t('private.trade_custom.invalid_address', $user['locale']), [
		'type' => $sdata['blockchain'],
	]), $msg_id);
}
