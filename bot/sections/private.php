<?php

$flooding = IsUserFlooding($result['message']['from']['id'], 8, 60);

if ($flooding === false) {
	require __DIR__ . "/../pipelines/define_user_private.php";

	SendMessage($result['message']['from']['id'], t('private.start.message.text', $user['locale']));
} else if ($flooding) {
	SendMessage($result['message']['from']['id'], t('private.flood.message', $user['locale']));
}
