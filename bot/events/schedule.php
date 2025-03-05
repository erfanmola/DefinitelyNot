<?php

// Every 5 minute
if ((int)date('i') % 5 === 0) {
	$channel_message_text  = joinDoubleLine(
		generateNativePricesText(),
		generateAssetPricesText('TON', asset_emoji['TON']),
		generateAssetPricesText('SOL', asset_emoji['SOL']),
		joinSpace(date('M d, H:i'), 'UTC'),
	);

	SendMessage(joinEmpty('@', $_ENV['RATES_CHANNEL_USERNAME']), $channel_message_text);
}
