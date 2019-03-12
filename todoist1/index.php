<?php
require "key.php";
require "todoistModel.php";

session_start();
if (isset($_REQUEST['logout'])) {
  unset($_SESSION['token']);
      }

if (!isset($_SESSION['token'])) {
  header("Location: https://todoist.com/oauth/authorize?client_id=$clientID&scope=data:read_write,data:delete&state=scott");
}
if(isset($_POST['taskInfo']))
{
   addNewTask($_POST["taskInfo"]);
} 
?>
<html>
<head>
</head>
<body>
cse451Project1
<br>
Here are the Tasks:
<ul>
<?php 
$a=getProjects();
foreach ($a as $i) {
  print "<li>" . $i . "</li>";
}

?>
</ul>
<form method="post" action="index.php">
  <div>
    <label for="taskInfo">Task</label>
    <input type="text" class="form-control" id="taskInfo" name="taskInfo">
  </div>
  <button type="submit">Add Task</button>
</form>
</body>
</html>

