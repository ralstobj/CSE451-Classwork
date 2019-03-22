<?php
$jsonData=array();
try {
  $rawData = file_get_contents("php://input");
  $jsonData = json_decode($rawData,true);
  if ($rawData !== "" && $jsonData==NULL) {
    $ret=array("status"=>"FAIL","msg"=>"invalid json");
  }
} catch (Exception $e) {
};
$log  = "User: ".$jsonData['initiator']['full_name'].' | Event: '.$jsonData['event_name'].' | Content: '.
	$jsonData['event_data']['content'].' | Project Id: '.$jsonData['event_data']['project_id'].' | '.
	date("F j, Y, g:i a").PHP_EOL.
        "-------------------------".PHP_EOL;
file_put_contents('WikiTodist.log', $log, FILE_APPEND);
?>

