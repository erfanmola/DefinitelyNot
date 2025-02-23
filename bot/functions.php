<?php

require_once __DIR__ . "/utils/string.php";
require_once __DIR__ . "/utils/i18n.php";
require_once __DIR__ . "/utils/user.php";
require_once __DIR__ . "/utils/wallet.php";
require_once __DIR__ . "/utils/controller.php";
require_once __DIR__ . "/utils/promise.php";
require_once __DIR__ . "/utils/message.php";
require_once __DIR__ . "/utils/cache.php";

$cacheTableBalance = new CacheTable(config['CACHE_TABLE_BALANCE_SIZE'], 32);
