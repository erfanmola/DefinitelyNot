<?php

require_once __DIR__ . "/../i18n/en.php";
require_once __DIR__ . "/../i18n/fa.php";

function t(string $path, $language): string
{
	$path = explode('.', $path);
	$data = match ($language) {
		'fa'    => i18n_fa,
		default => i18n_en,
	};

	foreach ($path as $index) {
		if (is_array($data) && isset($data[$index])) {
			if (is_string($data[$index])) {
				return $data[$index];
			} else {
				$data = $data[$index];
			}
		}
	}

	if ($language !== 'en') {
		return t(implode('.', $path), 'en');
	}

	return 'Undefined String';
}

function td(string $text, array $params = []): string
{
	return str_ireplace(array_map(fn($key) => "%$key%", array_keys($params)), array_values($params), $text);
}
