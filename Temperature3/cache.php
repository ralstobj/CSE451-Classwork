<?php
/*
   Bailey Ralston
   cache data model

pasword.php must have:
$user, $pass, $db and $addPass

 */

require_once("password.php");
require("cities.php");
require_once("callDarkSky.php");
$mysqli = mysqli_connect("localhost", $user,$pass,$db);
if (mysqli_connect_errno($mysqli)) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	die;
}

function getTemperatureFromCache($cityId) {
	global $mysqli;
	global $cities;
	$stmt = $mysqli->prepare("select temperature,updateTime from cache where cityName=?");
	if (!$stmt) {
		error_log("Error on getValue " . $mysqli->error);
		return null;
	}

	$stmt->bind_param("s",$cities[$cityId]);
	if (!$stmt->execute()) {
		error_log("execute error");
		error_log($mysqli->error);
		return null;
	}

	$stmt->bind_result($temp,$updateTime);
	if ($stmt->fetch() === false) {
		error_log( "fetch error");
		error_log($mysqli->error);
		return null;
	}

	return array('temp'=>$temp,'updateTime'=>$updateTime);
}


function add($cityId,$temp) {
	global $mysqli;
	global $cities;
	global $mysqli;
	$mysqli->query("lock tables cache write");

	deleteCityName($cityId);

	$stmt = $mysqli->prepare("insert into cache (cityName,temperature,updateTime) values (?,?,?)");
	if (!$stmt) {
		$mysqli->query("unlock tables");
		error_log("error on add " . $mysqli->error);
		return "error";
	}

	$now = time();
	$stmt->bind_param("sss",$cities[$cityId],$temp,$now);
	$stmt->execute();

	$mysqli->query("unlock tables");
	return "OK";

}

function deleteCityName($cityId) {
	global $mysqli;
	global $cities;
	$stmt = $mysqli->prepare("delete from cache where cityName=?");
	 if (!$stmt) {
                error_log("error on delete " . $mysqli->error);
                return "error";
        }

        $stmt->bind_param("s",$cities[$cityId]);
        $stmt->execute();
        return "OK";
}

function createCacheTable() {
	global $mysqli;
	print "creating db\n";
	$r = $mysqli->query("CREATE TABLE `cache` (
  	`pk` int(11) NOT NULL AUTO_INCREMENT,
  	`cityName` text NOT NULL,
  	`temperature` text NOT NULL,
  	`updateTime` int,
  	PRIMARY KEY (`pk`)
	)");
	print $mysqli->error;
}

?>
