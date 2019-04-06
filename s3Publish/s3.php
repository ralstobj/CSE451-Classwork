<?php
require "../vendor/autoload.php";
include "basePage.php";
use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Aws\Credentials\CredentialProvider;
use Aws\Common\Exception\MultipartUploadException;
use Aws\S3\MultipartUploader;
use GuzzleHttp\Client;
$profile = 'class'; 
$path = '/var/www/.aws/credentials';

$wikipediaUri = "https://en.wikipedia.org/api/rest_v1/";
$provider = CredentialProvider::ini($profile, $path);
$provider = CredentialProvider::memoize($provider);
$client = new Client(['base_uri'=> $wikipediaUri, 'timeout'=> 2.0]);

$s3Client = new S3Client([
    'region' => 'us-east-1',
    'version' => 'latest',
    'credentials' => $provider
]);
function generatePage($articles){
	global $start;
	global $end;
	$fullPage = $start;
	foreach ($articles as $article) {
    		$data = getArticleData($article);
		$fullPage.= '<div>';
		$fullPage.='<h3>'.$data["title"].'</h3>';
		if($data["summary"] == "Not Found") {
			return false;
		}
		$fullPage.='<p><img src="'.$data["thumbnailSrc"].'" style=width:'.$data["thumbnailW"].'px;height:'.$data["thumbnailH"].'px;margin-right:15px; alt="'.$data["title"].'">'. $data["summary"].'</p>';
		$fullPage.='<a href='.$data["url"].'>'.$data["url"].'</a></div><br>';
	}
	$fullPage.=$end;
	file_put_contents('index.html', $fullPage);
	return true;
}
function publish(){
	global $s3Client;
	$bucket = 'campbest-451-s19-wikipedia';
	$keyname = 'temp/index.html';
	$contentType = "text/html";
	// Prepare the upload parameters.
	$uploader = new MultipartUploader($s3Client, 'index.html', [
    		'bucket' => $bucket,
    		'key'    => $keyname,
		'ACL' => 'public-read',
		'ContentType' => $contentType
	]);

	// Perform the upload.
	try {
    		$result = $uploader->upload();
    		return $result['ObjectURL'];
	} catch (MultipartUploadException $e) {
    		echo $e->getMessage() . PHP_EOL;
	}
	return "error";
}
function getArticleData($articleName){
	global $client;
    	try {
        	$response = $client->request('get',"page/summary/".$articleName);
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

?>
