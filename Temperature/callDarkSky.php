<?php
/*
 * Bailey Ralston
 * */


require __DIR__ . '/../vendor/autoload.php';
require_once("key.php");

use GuzzleHttp\Client;

$uri = "https://api.darksky.net/forecast/$key/";

$client = new Client([
	'base_uri' => $uri,
	'timeout'  => 2.0,
]);

function temperature($latlong) {
	global $client;
	try {
		$response = $client->request('get',"$latlong");
	} catch (Exception $e) {
		print_r($e);
		return "Error on getting data";
	}
	$body = (string) $response->getBody();
	$jbody = json_decode($body);
	if (!$jbody) {
		return "error on decoding json";
	}

	return $jbody->currently->temperature;
}

