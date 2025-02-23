<?php

if (count($user['wallets']) > config['TOTAL_WALLETS_MIN']) {
	[,, $address] = splitPipe($callback_data);

	$wallet_index = array_search($address, array_column($user['wallets'], 'address'));

	if ($wallet_index > -1) {
		$wallet = $user['wallets'][$wallet_index];

		deleteWallet($wallet['type'], $wallet['address'], $mysqli);
		$callback_data = 'wallets';

		require __DIR__ . "/../callback_query.php";
	}
} else {
	$answer = td(t('callback_query.wallet_del.answer_min', $user['locale']), [
		'min' => config['TOTAL_WALLETS_MIN'],
	]);
	$show_alert = true;
}
