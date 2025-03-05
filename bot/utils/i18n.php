<?php

require_once __DIR__ . "/../i18n/en.php";
require_once __DIR__ . "/../i18n/fa.php";
require_once __DIR__ . "/../i18n/ar.php";
require_once __DIR__ . "/../i18n/de.php";
require_once __DIR__ . "/../i18n/hi.php";
require_once __DIR__ . "/../i18n/ru.php";

function t(string $path, $language): string
{
	$path = explode('.', $path);
	$data = match ($language) {
		'fa'    => i18n_fa,
		'ar'    => i18n_ar,
		'de'    => i18n_de,
		'hi'    => i18n_hi,
		'ru'    => i18n_ru,
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
