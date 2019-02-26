<?php
/*
Bailey Ralston
cse451
spring 2019
Week3

this file create the database and tables and create some basic data.

Run this first

*/

ini_set('register_argc_argv', 0);  

if (!isset($argc) || is_null($argc))
{ 
    echo 'Not CLI mode';
	die;
}


//create database -connect directly to mysql

require_once("password.php");
$mysqli = mysqli_connect("localhost", $user,$pass,"mysql");
if (mysqli_connect_errno($mysqli)) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	die;
}

print "connected\n";
print "droping db\n";
$r = $mysqli->query("drop database if exists " . $db);
print_r($r);
print $mysqli->error;
$mysqli->query("create database " . $db);
print $mysqli->error;
$mysqli->close();


require_once("cache.php");
createCacheTable();
?>
