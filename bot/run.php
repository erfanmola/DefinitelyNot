<?php

OpenSwoole\Runtime::enableCoroutine();
OpenSwoole\Coroutine::set(['hook_flags' => SWOOLE_HOOK_ALL]);

use OpenSwoole\WebSocket\Server;
use OpenSwoole\Http\Request;
use OpenSwoole\Http\Response;
use OpenSwoole\Timer;

require_once __DIR__ . "/autoload.php";

$server = new Server($_ENV['BOT_HOST'], $_ENV['BOT_PORT']);

$server->set([
	'reactor_num' => config['PROCESS_REACTOR_NUM'],
	'worker_num' => config['PROCESS_WORKER_NUM'],
]);

$server->on("start", function (Server $server) use (&$cacheTableBalance) {
	echo "Bot Started";
	ReportToAdmin("<b>Server has started/reloaded</b>");

	$cacheTableBalance->initCleanpTimer();

	$scheduler = Timer::tick(60_000, function () {
		require __DIR__ . "/events/schedule.php";
	});
});

$server->on("request", function (Request $SwooleRequest, Response $SwooleResponse) use (&$server, &$cacheTableBalance, &$cacheTableAssetsBalance, &$tableNative, &$tableJettons, &$tableTokens, &$tableConditions, &$tableAlerts, &$predefinedJettons, &$predefinedTokens) {
	$SwooleResponse->end();

	$result = $SwooleRequest->getContent();

	if ($result === 'shutdown') {
		$server->shutdown();
	} else {
		$result = json_decode($result, true);

		if ($result) {
			$mysqli = ConnectionPoolManager::getMySQLiConnection();
			$redis  = ConnectionPoolManager::getRedisConnection();

			require __DIR__ . "/pipelines/define_update_variables.php";

			try {
				require __DIR__ . "/bot.php";
			} catch (Exception $e) {
				/* Nothing, just a regular exit */
			} finally {
				ConnectionPoolManager::releaseMySQLiConnection($mysqli);
				ConnectionPoolManager::releaseRedisConnection($redis);
			}
		}
	}
});

$server->on("message", function (Server $ws, $frame) use (&$tableNative, &$tableJettons, &$tableTokens, &$tableConditions, &$tableAlerts, &$predefinedJettons, &$predefinedTokens) {
	$result = json_decode($frame->data, true);
	if (!$result && isset($result['type'])) return;

	if ($result['type'] === 'rates') {
		require __DIR__ . "/events/rates.php";
		require __DIR__ . "/events/alerts.php";
	} else if ($result['type'] === 'init') {
		require __DIR__ . "/events/init.php";
	}
});

$server->start();
