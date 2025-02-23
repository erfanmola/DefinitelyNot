<?php

use OpenSwoole\Coroutine;
use OpenSwoole\Core\Coroutine\WaitGroup;

class PromiseAll
{
	/**
	 * Executes an array of callables concurrently and returns their results.
	 *
	 * If not already in a coroutine, it wraps the tasks in a coroutine context.
	 *
	 * @param callable[] $tasks An array of functions to run concurrently.
	 * @return array The results of the executed tasks.
	 */
	public static function all(array $tasks): array
	{
		// Check if we are in a coroutine context.
		if (Coroutine::getCid() < 0) {
			// Not in a coroutine context, so start one.
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
					// Execute the task and store its result.
					$results[$key] = $task();
				} catch (\Throwable $e) {
					// Optionally handle exceptions by storing the error.
					$results[$key] = $e;
				}
				$wg->done();
			});
		}

		// Wait for all tasks to finish.
		$wg->wait();
		return $results;
	}
}
