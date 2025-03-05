<?php

$items = [];

foreach (['TON', 'SOL'] as $type) {
	$price = $tableNative->get($type, 'price');

	if ($price) {
		$items[] = [
			'symbol' => $type,
			'price'  => $price,
			'emoji'  => native_asset_emoji[$type],
		];
	}
}

foreach ($tableJettons as $jetton) {
	if ($jetton['active'] && $jetton['price'] && $jetton['symbol'] && $predefinedJettons->exists($jetton['address'])) {
		$items[] = [
			'symbol' => $jetton['symbol'],
			'price'  => $jetton['price'],
			'emoji'  => asset_emoji['TON'],
		];
	}
}

foreach ($tableTokens as $token) {
	if ($token['active'] && $token['price'] && $token['symbol'] && $predefinedTokens->exists($token['address'])) {
		$items[] = [
			'symbol' => $token['symbol'],
			'price'  => $token['price'],
			'emoji'  => asset_emoji['SOL'],
		];
	}
}

$results = [
	...$results,
	...array_map(fn($item) => [
		'type'        => 'article',
		'id'          => joinPipe('price', $item['symbol'], $item['emoji']),
		'title'       => joinSpace($item['emoji'], $item['symbol']),
		'description' => priceFormat($item['price']),
		'input_message_content' => [
			'message_text' => td(t('inline_query.price', $user['locale']), [
				'symbol' => $item['symbol'],
				'price'  => priceFormat($item['price']),
			]),
			'parse_mode' => 'HTML',
		],
	], $items),
];
