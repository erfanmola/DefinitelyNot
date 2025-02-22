<?php

require_once __DIR__ . "/vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();

require_once __DIR__ . "/config.php";

// https://github.com/erfanmola/TDXLib
require_once __DIR__ . "/lib/TDXLib.php";
require_once __DIR__ . "/lib/DPXDBQuery.php";

require_once __DIR__ . "/information.php";
require_once __DIR__ . "/functions.php";
require_once __DIR__ . "/database.php";
