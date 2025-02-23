<?php

$flooding = IsUserFlooding($from_id, 8, 60);

if ($flooding === false) {
	require __DIR__ . "/../pipelines/define_user_params.php";

	require __DIR__ . "/private/default.php";
} else if ($flooding) {
	SendMessage($from_id, "🚫 Stop flooding, I'm gonna pretend that i'm angry and will not respond to you for some time.");
}
