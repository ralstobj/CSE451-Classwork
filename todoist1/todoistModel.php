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
$uri = "https://beta.todoist.com/API/v8/";


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
        $header = array("Authorization"=>"Bearer " . $_SESSION['token']);
        $response = $client->request('get',"projects",['headers'=>$header]);
    } catch (Exception $e) {
        print "There was an error getting the projects from todoist";
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
$flag = 0;
foreach($jbody as $i) {
    $projectName = $i->name;
    if($projectName == "cse451Project1"){
        $flag = $i->id;
	$_SESSION['id'] = $flag;
    }
}  
  if($flag != 0){
      return  getTasks($flag);
  }else{
     return createNewProject();
  }
}

function getTasks($id){
    global $client;
    try {
        $header = array("Authorization"=>"Bearer " . $_SESSION['token']);
        $response = $client->request('get',"tasks",['headers'=>$header]);
    } catch (Exception $e) {
        print "There was an error getting the tasks from todoist";
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
	$tasks = array();
	foreach($jbody as $j) {
    		$projectId = $j->project_id;
    		if($projectId == $id){
			$taskName = $j->content;
			array_push($tasks, $taskName);
    		}
	}
	return $tasks;

}
function createNewProject(){
    global $client;
    try {
        $header = array("Authorization"=>"Bearer " . $_SESSION['token'], "Content-Type"=>"application/json");
        $response = $client->request('post',"projects",['headers'=>$header,GuzzleHttp\RequestOptions::JSON=> ['name' => 'cse451Project1']]);
    } catch (Exception $e) {
        print "There was an error adding project from todoist";
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
	
	return getTasks($jbody->id);

}
function addNewTask($data){
    global $client;
    try {
        $header = array("Authorization"=>"Bearer " . $_SESSION['token'], "Content-Type"=>"application/json");
        $response = $client->request('post',"tasks",['headers'=>$header,GuzzleHttp\RequestOptions::JSON=> ['content' => $data, 'project_id'=>$_SESSION['id']]]);
    } catch (Exception $e) {
        print "There was an error adding project from todoist";
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
	
}

?>
