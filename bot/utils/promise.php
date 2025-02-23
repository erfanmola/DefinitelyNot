<?php

use OpenSwoole\Coroutine;
use OpenSwoole\Core\Coroutine\WaitGroup;

class PromiseAll
{
	public static function all(array $tasks): array
	{
		if (Coroutine::getCid() < 0) {
			return Coroutine::run(function () use ($tasks) {
				return self::all($tasks);
			});
		}

		$results = [];
		$wg = new WaitGroup();

		foreach ($tasks as $key => $task) {
			$wg->add();
			Coroutine::create(function () use ($task, &$results, $key, $wg) {
				try {
					$results[$key] = $task();
				} catch (\Throwable $e) {
					$results[$key] = $e;
				}
				$wg->done();
			});
		}

		$wg->wait();
		return $results;
	}
}
