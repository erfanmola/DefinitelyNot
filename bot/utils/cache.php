<?php

use OpenSwoole\Table;
use OpenSwoole\Timer;

class CacheTable
{
	private Table $cacheTable;

	public function __construct(int $size = 1024, int $valueSize = 1024)
	{
		$this->cacheTable = new Table($size);
		$this->cacheTable->column('value', Table::TYPE_STRING, $valueSize);
		$this->cacheTable->column('expire_at', Table::TYPE_INT, 8);
		$this->cacheTable->create();
	}

	public function get(string $cacheId, callable $valueFunction, int $expire): string
	{
		$currentTime = time();

		if ($this->cacheTable->exists($cacheId)) {
			$data = $this->cacheTable->get($cacheId);
			if ($data['expire_at'] > $currentTime) {
				return $data['value'];
			}
		}

		$newValue = $valueFunction();
		$this->cacheTable->set($cacheId, [
			'value' => (string)$newValue,
			'expire_at' => $currentTime + $expire
		]);
		return $newValue;
	}

	private function cleanup(): void
	{
		$currentTime = time();
		foreach ($this->cacheTable as $key => $row) {
			if ($row['expire_at'] <= $currentTime) {
				$this->cacheTable->del($key);
			}
		}
	}

	public function initCleanpTimer(int $interval = 1000): void
	{
		Timer::tick($interval, function () {
			$this->cleanup();
		});
	}
}
