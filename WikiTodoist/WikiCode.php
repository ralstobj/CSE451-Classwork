<?php
session_start();
/*
 * Bailey Ralston
 * Code to recieve todoist redirect.
 * */


//this calls in all autoload packages installed via composer
require __DIR__ . '/../vendor/autoload.php'; 
require "key.php";

//bring guzzle client into code
use GuzzleHttp\Client;

//base uri -> it is important it end in /
$uri = "https://todoist.com/oauth/access_token";


//create a new client
$client = new Client([
    // Base URI is used with relative requests
    'base_uri' => $uri,
    // You can set any number of default request options.
    'timeout'  => 2.0,
]);
 $code =htmlspecialchars($_REQUEST['code']);

try {
  $data = array("client_id"=>$clientIDWiki,"client_secret"=>$clientSecretWiki,"code"=>$code,'redirect_uri'=>'https://ralstobj.451.csi.miamioh.edu/cse451-ralstobj-web/WikiTodoist/WikiTodoist.php');
  $response = $client->request('POST',"",['form_params'=>$data]);
} catch (Exception $e) {
  print "There was an error getting the token from todoist";
//  header("content-type: text/plain",true);
 // print_r($e);
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

$_SESSION['tokenWiki'] = $jbody->access_token;

header("location: WikiTodoist.php");
?>
