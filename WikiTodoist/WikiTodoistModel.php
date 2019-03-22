<?php
/*
 * Bailey Ralston
 * wikipedia and todoist
 * */
//this calls in all autoload packages installed via composer
require __DIR__ . '/../vendor/autoload.php'; 
//bring guzzle client into code
use GuzzleHttp\Client;

//base uri -> it is important it end in /
$todoistUri = "https://beta.todoist.com/API/v8/";
$wikipediaUri = "https://en.wikipedia.org/api/rest_v1/";


//create a new client
$client = new Client(['base_uri' => $todoistUri,'timeout'  => 2.0]);
$client2 = new Client(['base_uri'=> $wikipediaUri, 'timeout'=> 2.0]);
function getProjects() {
  global $client;
    try {
        $header = array("Authorization"=>"Bearer " . $_SESSION['tokenWiki']);
        $response = $client->request('get',"projects",['headers'=>$header]);
    } catch (Exception $e) {
        print "There was an error getting the projects from todoist";
        logError($e);
    }
    $body = (string) $response->getBody();
    $jbody = json_decode($body);
    if (!$jbody) {
        error_log("no json");
        exit;
    }

    foreach($jbody as $i) {
        $projectName = $i->name;
        if($projectName == "Wikipedia"){
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
        $header = array("Authorization"=>"Bearer " . $_SESSION['tokenWiki']);
        $response = $client->request('get',"tasks",['headers'=>$header]);
    } catch (Exception $e) {
        print "There was an error getting the tasks from todoist";
        logError($e);
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
                $res = getArticleData($taskName);
		array_push($tasks, $res);
            }
	}
	return $tasks;

}
function getArticleData($articleName){
	 global $client2;
    try {
        $response = $client2->request('get',"page/summary/".$articleName);
    } catch (Exception $e) {
        return array("title"=>$articleName, "summary"=>"Not Found");
    }
    $body = (string) $response->getBody();
    $jbody = json_decode($body);
        if (!$jbody) {
            error_log("no json");
            exit;
    }
    $data = array("title"=>$jbody->title, "thumbnailSrc"=>$jbody->thumbnail->source, "thumbnailW"=>$jbody->thumbnail->width,"thumbnailH"=>$jbody->thumbnail->height,"url"=>$jbody->content_urls->desktop->page, "summary"=>$jbody->extract);
    return $data;
}

function createNewProject(){
    global $client;
    try {
        $header = array("Authorization"=>"Bearer " . $_SESSION['tokenWiki'], "Content-Type"=>"application/json");
        $response = $client->request('post',"projects",['headers'=>$header,GuzzleHttp\RequestOptions::JSON=> ['name' => 'Wikipedia']]);
    } catch (Exception $e) {
        print "There was an error adding project to todoist";
        logError($e);
    }
        $body = (string) $response->getBody();
        $jbody = json_decode($body);
        if (!$jbody) {
                error_log("no json");
                exit;
        }
}
function logError($e){
    header("content-type: text/plain",true);
    print_r($e);
    $a=print_r($e,true);
    error_log($a);
    exit;
}
?>

