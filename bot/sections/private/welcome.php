<?php

use OpenSwoole\Coroutine;

$sent_message = SendMessage($from_id, joinLine(...not_art['empty']), $msg_id, response: true);

if (isset($sent_message['result']['message_id'])) {
	for ($i = 1; $i <= 9; $i++) {
		Coroutine::usleep(250_000);

		EditMessageText($from_id, $sent_message['result']['message_id'], joinLine(
			...array_slice(not_art['art'], 0, ($i * 2 + 3)),
			...array_slice(not_art['empty'], ($i * 2 + 3), 21 - ($i * 2 + 3)),
		), response: true);
	}
}
