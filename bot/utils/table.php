<?php

use OpenSwoole\Table;

function tableUpdate(Table &$table, string $index, array $values)
{
	$item = $table->get($index) ?? [];

	foreach ($values as $key => $value) {
		$item[$key] = $value;
	}

	$table->set($index, $item);
}
