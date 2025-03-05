<?php

use OpenSwoole\Coroutine;

$valid_address = preg_match(patterns['wallet'][$sdata['blockchain']], $text);

if ($valid_address) {
	setState($from_id, $redis);

	[$sent_msg_id, $asset] = PromiseAll::all([
		function () use (&$from_id, &$user, &$msg_id) {
			$sent_message_id = SendMessage(
				$from_id,
				t('private.custom_asset.processing', $user['locale']),
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

	$redis->set(joinPipe($from_id, 'recent', 'msg', 'id'), $sent_msg_id);

	if ($asset) {
		if ($asset['active'] && $asset['price']) {

			EditMessageText($from_id, $sent_msg_id, td(
				t('callback_query.alerts.type.text', $user['locale']),
				[
					'symbol' => $asset['symbol'] ?? truncateWalletAddress($text, 3, 3),
				]
			), null, [
				'reply_markup' => [
					'inline_keyboard' => [
						[
							[
								'text' => t('callback_query.alerts.type.buttons.decrease', $user['locale']),
								'callback_data' => joinPipe('alert', $sdata['blockchain'], $asset['address'], '0'),
							],
							[
								'text' => t('callback_query.alerts.type.buttons.increase', $user['locale']),
								'callback_data' => joinPipe('alert', $sdata['blockchain'], $asset['address'], '1'),
							],
						],
					],
				],
			]);
		} else {

			EditMessageText(
				$from_id,
				$sent_msg_id,
				t('private.custom_asset.inactive', $user['locale']),
			);
		}
	} else {
		EditMessageText($from_id, $sent_msg_id, t('private.custom_asset.invalid_asset', $user['locale']));
	}
} else {
	SendMessage($from_id, td(t('private.custom_asset.invalid_address', $user['locale']), [
		'type' => $sdata['blockchain'],
	]), $msg_id);
}
