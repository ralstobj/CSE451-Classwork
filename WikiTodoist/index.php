<?php
require "key.php";


session_start();
if (isset($_REQUEST['logout'])) {
  unset($_SESSION['token']);
      }

if (!isset($_SESSION['token'])) {
  header("Location: https://todoist.com/oauth/authorize?client_id=$clientID&scope=data:read_write,data:delete&state=baliey");
}
?>
<html lang="en">
	<head>
		<meta name="description" content="Assignment Week 4">
        	<meta charset="utf-8">
        	<title>WikiTodoist</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		<script src="script.js"></script>
		<script>
			var token = "<?php print $_SESSION['token']?>";
		</script>
	</head>
	<body>
<h1>cse451Project1</h1>
<br>
<h3>Here are the Tasks:</h3>
<ul id="unorderedList">
</ul>
<form method="post" id="addTask">
  <div>
   <label for="taskInfo">Task</label>
    <input type="text" class="form-control" id="taskInfo" name="taskInfo">
  </div>
  <button class="btn btn-primary"  type="submit">Add Task</button>
</form>
<button type="button" class="btn btn-primary" id="refresh">Refresh</button>
</body>
</html>

