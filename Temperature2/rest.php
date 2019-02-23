<?php
// The REST API for week4 assignment
// Bailey Ralston
// CSE451
// Week 4 rest
// 2/22/2019
require_once("callDarkSky.php");
require_once("cache.php");
//returns data as json
function retJson($data) {
    header('content-type: application/json');
    print json_encode($data);
    exit;
}


$method = strtolower($_SERVER['REQUEST_METHOD']);
if (isset($_SERVER['PATH_INFO']))
    $path  = $_SERVER['PATH_INFO'];
else $path = "";

$pathParts = explode("/",$path);
if (count($pathParts) <2) {
    error_log( "Path: ". $path ." || Count: ". count($pathParts) );
    $ret = array('status'=>'FAIL','msg'=>'Invalid URL');
    retJson($ret);
}

//get json data if any
$jsonData =array();
try {
  $rawData = file_get_contents("php://input");
  $jsonData = json_decode($rawData,true);
  if ($rawData !== "" && $jsonData==NULL) {
    $ret=array("status"=>"FAIL","msg"=>"invalid json");
    retJson($ret);
  }
} catch (Exception $e) {
};


// Get Temperature - rest.php/v1/temperature
if ($method==="post" && count($pathParts) == 3 && $pathParts[1] === "v1" && $pathParts[2] === "temperature") {

    // make sure we have the correct JSON information we need to make the updated
if ( !isset($jsonData['cityId'])) {
        $ret = array('status'=>'FAIL','msg'=>'json is invalid');
        retJson($ret);
    }
	$temp = getTemp($jsonData['cityId']);
    $ret = array('status'=>'OK','temp'=>$temp['temp'],'updateTime'=>$temp['updateTime']);
    retJson($ret);
}

if ($method==="delete" && count($pathParts) == 3 && $pathParts[1] === "v1" && $pathParts[2] === "temperature") {

    // make sure we have the correct JSON information we need to make the updated
if ( !isset($jsonData['cityId'])) {
        $ret = array('status'=>'FAIL','msg'=>'json is invalid');
        retJson($ret);
    }
    deleteCityName($cityId);    
    $ret = array('status'=>'OK');
    retJson($ret);
}

// If we hit this point then they did not provide a valid call to the API
$ret = array('status'=>'FAIL','msg'=>'Invalid url or version');
retJson($ret);

?>
