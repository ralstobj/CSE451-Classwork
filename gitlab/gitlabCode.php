<?php
session_start();
/*
 * Bailey Ralston
 * Code to recieve gitlab redirect.
 * */


//this calls in all autoload packages installed via composer
require __DIR__ . '/../vendor/autoload.php'; 
require "key.php";

//bring guzzle client into code
use GuzzleHttp\Client;

//base uri -> it is important it end in /
$uri = "https://gitlab.csi.miamioh.edu/oauth/token";


//create a new client
$client = new Client([
    // Base URI is used with relative requests
    'base_uri' => $uri,
    // You can set any number of default request options.
    'timeout'  => 2.0,
]);
$code =htmlspecialchars($_REQUEST['code']);
try {
//$param = "client_id=".$appID."&client_secret=".$clientSecret."&code=".$code."&grant_type=authorization_code&redirect_uri=".$callBack;
 $data = array("client_id"=>$appID,"client_secret"=>$clientSecret,"code"=>$code,"grant_type"=>'authorization_code','redirect_uri'=>$callBack);  
$response = $client->request('POST',"",['form_params'=>$data]);

} catch (Exception $e) {
  print "There was an error getting the token from gitlab";
  $a=print_r($e,true);
  error_log($a);
  exit;
}
$body = (string) $response->getBody();
$jbody = json_decode($body);
if (!$jbody) {
  error_log("no json");
  exit;
}

$_SESSION['gitToken'] = $jbody->access_token;

header("location: index.php");
?>
