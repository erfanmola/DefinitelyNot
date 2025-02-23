<?php

function requestController(string $path, array $params): array | null
{
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, implode('', [$_ENV['CONTROLLER_HOST'], ':', $_ENV['CONTROLLER_PORT'], $path]));
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
	curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: Application/JSON']);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TCP_FASTOPEN, true);

	$result = json_decode(curl_exec($ch), true);

	if (is_array($result) && isset($result['status']) && $result['status'] === 'success') {
		return $result['result'];
	}

	return null;
}
