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
function getRecentTemperature($cityId) {
	global $mysqli;
	global $coord;
	global $cities;

	$stmt = $mysqli->prepare("select temperature, timestamp as time from cache where cityName=? AND UNIX_TIMESTAMP(timestamp) >= UNIX_TIMESTAMP()-3600");
	if (!$stmt) {
		error_log("Error on getRecentTemperature " . $mysqli->error);
		return null;
	}

	$stmt->bind_param("s",$cities[$cityId]);
	$stmt->execute();
	$stmt->bind_result($temperature);
	$stmt->fetch();
	

	if($temperature->num_rows == 0){
		$passValue =  $coord[$cityId];	
		deleteCityName($cityId);		
		$temp = temperature($passValue);
		add($cityId, $temp);
		$temperature = array("temperature"=>"$temp", "time"=>"current time");
	}
	
	return $temperature;


}


function add($cityId,$temperature) {
	global $mysqli;
	global $cities;
	$stmt = $mysqli->prepare("insert into cache (cityName,temperature) values (?,?)");
	if (!$stmt) {
		error_log("error on add " . $mysqli->error);
		return "error";
	}

	$stmt->bind_param("ss",$cities[$cityId],$temperature);
	$stmt->execute();

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
	$mysqli->query("drop table if exists cache");
	print $mysqli->error;
print "creating db\n";
$r = $mysqli->query("CREATE TABLE `cache` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `cityName` text NOT NULL,
  `temperature` float NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`pk`)
)");
print_r($r);


	print $mysqli->error;
}



?>
