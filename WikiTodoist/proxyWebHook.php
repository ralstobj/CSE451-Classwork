<?php
session_start();
/*
 * Bailey Ralston
 * Code to recieve todoist redirect.
 * */
require __DIR__ . '/../vendor/autoload.php'; 
require "key.php";

//bring guzzle client into code
use GuzzleHttp\Client;

//base uri -> it is important it end in /
$uri = "https://ralstobj.451.csi.miamioh.edu/cse451-ralstobj-web/WikiTodoist/";


//create a new client
$client = new Client([
    // Base URI is used with relative requests
    'base_uri' => $uri,
    // You can set any number of default request options.
    'timeout'  => 2.0,
]);


$jsonData=array();
try {
  $rawData = file_get_contents("php://input");
  $jsonData = json_decode($rawData,true);
  if ($rawData !== "" && $jsonData==NULL) {
    $ret=array("status"=>"FAIL","msg"=>"invalid json");
  }
} catch (Exception $e) {
};

$headers = getallheaders();
$valid = false;			
if (isset($headers['X-Todoist-Hmac-Sha256'])) {
  //check header
  $check = $headers['X-Todoist-Hmac-Sha256'];
  $check1 = base64_encode(hash_hmac("sha256",$rawData,$clientSecretWiki,true));
  if ($check == $check1) { //if two strings match, it came from todoist
    $valid = true;
  }
} else {
  $check = "null";
  $check1="null";
}

if ($valid == true){
try {
        $header = array("Content-Type"=>"application/json");
        $response = $client->request('post',"log.php",['headers'=>$header,GuzzleHttp\RequestOptions::JSON=>$jsonData]);
    } catch (Exception $e) {
        print "There was an error sending data";
        header("content-type: text/plain",true);
 	print_r($e);
  	$a=print_r($e,true);
  	error_log($a);
  	exit;
    }
}
?>

