<?php

require_once __DIR__ . "/utils/string.php";
require_once __DIR__ . "/utils/i18n.php";
require_once __DIR__ . "/utils/user.php";
require_once __DIR__ . "/utils/wallet.php";
require_once __DIR__ . "/utils/conditions.php";
require_once __DIR__ . "/utils/alerts.php";
require_once __DIR__ . "/utils/controller.php";
require_once __DIR__ . "/utils/promise.php";
require_once __DIR__ . "/utils/message.php";
require_once __DIR__ . "/utils/cache.php";
require_once __DIR__ . "/utils/state.php";
require_once __DIR__ . "/utils/table.php";

require_once __DIR__ . "/information/balance.php";
require_once __DIR__ . "/information/assets.php";
require_once __DIR__ . "/information/alerts.php";
require_once __DIR__ . "/information/conditions.php";

function &assignReferenceIfNotNull(&$reference, &$fallback = null)
{
	if ($reference) {
		return $reference;
	}

	return $fallback;
}
