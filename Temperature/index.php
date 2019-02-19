
<!---Bailey Ralton -->
<!--<CSE 451-->
<!-- REST PHP WEEK 3-->
<!-- 02/18/2019-->
<!DOCTYPE html>
<?php
session_start();
require_once('cities.php');
require_once('cache.php');
if (isset($_GET['city'])) {
	$cityId=htmlspecialchars($_GET['city']);
//	$temperature = getCurrentTemperature($cityId);
}

?>

<html lang="en">
	<head>
		<meta name="description" content="Assignment Week 3">
        	<meta charset="utf-8">
        	<title>Bailey Ralston</title>
        	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
        	<link href="style.css" rel="stylesheet">
	</head>
<body>
	<div class="container-fluid center-block">
		<h1>Current Temperature Around The US</h1>
		<?php if(isset($cityId)){?>
		<?php $temp = getRecentTemperature($cityId)?>
		<h3> The temperature of <?php echo $cities[$cityId] ?> is <?php echo $temp['temperature'] ?>°F at <?php echo $temp['time'] ?></h3>
		<?php } ?>
		<form method='get' action="index.php">
			<div class="form-group">
   				<label for="city">City</label>
  			 	<select class="form-control col-sm-5" id="city" name="city">
				<?php
					foreach ($cities as $id=>$city) {
					?><option value="<?php echo $id?>"<?php if($cityId==$id){?>selected <?php } ?>><?php echo $city ?></option>
				 <?php } ?>
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
	<script src="week2.js"></script>
</body>
</html>
