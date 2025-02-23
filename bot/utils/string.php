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
