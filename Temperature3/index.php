<?php
require __DIR__ . '/../vendor/autoload.php';
require_once("config.php");
session_start();
// Initialize phpCAS from settings in config.php
phpCAS::client(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context);

phpCAS::setNoCasServerValidation();  // disables ssl server verification - ok for testing and required for now

// force CAS authentication -> this is where the system does the CAS authentication.
phpCAS::forceAuthentication();

// If we get here then the user has been authenticated by the CAS server
// and the user's login name can be read with phpCAS::getUser().

$user = phpCAS::getUser();
$_SESSION['userName'] = $user;
//Write action to txt log
    $log  = "Login Successful".PHP_EOL.
	    "User: ".$user.' - '.date("F j, Y, g:i a").PHP_EOL.
            "-------------------------".PHP_EOL;
    //-
    file_put_contents('temp.log', $log, FILE_APPEND);
// logout if desired
if (isset($_REQUEST['logout'])) {
    phpCAS::logout();
}

?>

<!-- Bailey Ralston -->
<!--CSE 451-->
<!-- REST PHP WEEK 4-->
<!-- 02/22/2019-->
<!DOCTYPE html>

<html lang="en">
	<head>
		<meta name="description" content="Assignment Week 4">
        	<meta charset="utf-8">
        	<title>Bailey Ralston</title>
        	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
			<link href="style.css" rel="stylesheet">
	</head>
<body>
	<div class="container-fluid center-block">
        <h1>Current Temperature Around The US</h1>
			<br id="beforeTemp">
			<div class="alert alert-danger hidden" role="alert" id="alert">
					Error retrieving Temperature
			</div>	
		    <form method='get' action="javascript: getTemperature();">
			<div class="form-group">
   				<label for="city">City</label>
  			 	<select class="form-control col-sm-5" id="city" name="city">
				<option value="0" >New York</option>
				 <option value="1">Los Angeles</option>
				 <option value="2">Seattle</option>
				 <option value="3">Miami</option>
				 <option value="4">Oxford</option>
				     				</select>
  			</div>
 			<button type="submit" class="btn btn-primary">Submit</button>
		</form>
		<footer>
       			<div>
            			<p>Bailey Ralston CSE451 week3-rest-calls  02/18/2019 </p>
        		</div>
      		</footer>
	</div>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="script.js"></script>
</body>
</html>


