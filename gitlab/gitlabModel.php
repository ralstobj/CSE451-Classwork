<?php
//Bailey Ralston
//CSE 451
//Todoist model
//3-12-19
//this calls in all autoload packages installed via composer
require __DIR__ . '/../vendor/autoload.php'; 
require "key.php";

//bring guzzle client into code
use GuzzleHttp\Client;

//base uri -> it is important it end in /
$uri = "https://gitlab.csi.miamioh.edu/api/v4/";


//create a new client
$client = new Client([
    // Base URI is used with relative requests
    'base_uri' => $uri,
    // You can set any number of default request options.
    'timeout'  => 2.0,
]);

function getProjects() {

  global $client;
	try {
        $header = array("Authorization"=>"Bearer " . $_SESSION['gitToken']);
        $response1 = $client->request('get',"user",['headers'=>$header]);
    } catch (Exception $e) {
        print "There was an error getting the projects from gitlab";
        header("content-type: text/plain",true);
        print_r($e);
        $a=print_r($e,true);
        error_log($a);
        exit;
    }
$body1 = (string) $response1->getBody();
$jbody1 = json_decode($body1);
if (!$jbody1) {
  error_log("no json");
  exit;
}
$id = $jbody1->id;
error_log($id);
    try {
        $header = array("Authorization"=>"Bearer " . $_SESSION['gitToken']);
        $response = $client->request('get',"users/".$id."/projects",['headers'=>$header]);
    } catch (Exception $e) {
        print "There was an error getting the projects from gitlab";
        header("content-type: text/plain",true);
        print_r($e);
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
return $jbody;
}


?>
