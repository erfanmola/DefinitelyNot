<?php

function joinEmpty(...$items)
{
	return implode("", $items);
}

function joinLine(...$items)
{
	return implode("\n", $items);
}

function joinDoubleLine(...$items)
{
	return implode("\n\n", $items);
}

function joinSpace(...$items)
{
	return implode(" ", $items);
}

function joinUnderline(...$items)
{
	return implode("_", $items);
}

function joinDash(...$items)
{
	return implode("-", $items);
}

function joinPipe(...$items)
{
	return implode("|", $items);
}

function splitUnderline(string $string)
{
	return explode('_', $string);
}

function splitPipe(string $string)
{
	return explode('|', $string);
}

function priceFormat(string|int|float $price, int $decimals = 9, string $prefix = '$')
{
	return joinEmpty($prefix, round($price, $decimals));
}

function tableFormatText(string $text, string $split_by): string
{
	$lines = explode("\n", trim($text));
	$rows = [];
	$columnWidths = [0, 0];

	foreach ($lines as $line) {
		$columns = array_map('trim', explode($split_by, $line, 2));
		if (count($columns) < 2) continue;

		$rows[] = $columns;

		foreach ($columns as $index => $column) {
			$columnWidths[$index] = max($columnWidths[$index], mb_strwidth($column, 'UTF-8'));
		}
	}

	$border = "+-" . str_repeat("-", $columnWidths[0]) . "-+-" . str_repeat("-", $columnWidths[1]) . "-+\n";
	$table = $border;

	foreach ($rows as $row) {
		$table .= "| " . mb_str_pad($row[0], $columnWidths[0]) .
			" | " . mb_str_pad($row[1], $columnWidths[1]) . " |\n";
	}

	$table .= $border;
	return $table;
}
