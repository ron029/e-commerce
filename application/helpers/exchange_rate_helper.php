<?php
function get_api_response($url, $headers = [])
{
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	$response = curl_exec($ch);
	curl_close($ch);

	return json_decode($response, true);
}
