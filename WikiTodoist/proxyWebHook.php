<?php
require "key.php";
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
$log  = "User: ".$jsonData['initiator']['full_name'].' | Event: '.$jsonData['event_name'].' | Content: '.
	$jsonData['event_data']['content'].' | Project Id: '.$jsonData['event_data']['project_id'].' | '.
	date("F j, Y, g:i a").PHP_EOL.
        "-------------------------".PHP_EOL;
file_put_contents('todoist.log', $log, FILE_APPEND);

}

?>
