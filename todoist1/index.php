<?php
require "key.php";
require "todoistModel.php";

session_start();
if (isset($_REQUEST['logout'])) {
  unset($_SESSION['token']);
      }

if (!isset($_SESSION['token'])) {
  header("Location: https://todoist.com/oauth/authorize?client_id=$clientID&scope=data:read,data:delete&state=scott");
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
</body>
</html>

