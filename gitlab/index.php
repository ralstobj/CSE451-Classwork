<?php
require "key.php";
require "gitlabModel.php";

session_start();
if (isset($_REQUEST['logout'])) {
  unset($_SESSION['gitToken']);
      }

if (!isset($_SESSION['gitToken'])) {
  header("Location: https://gitlab.csi.miamioh.edu/oauth/authorize?client_id=".$appID."&redirect_uri=".$callBack."&response_type=code&state=bailey");
}
?>
<html>
<head>
</head>
<body>
Your Gitlab projects
<ul>
<?php 
$a=getProjects();
if(isset($a)){
foreach ($a as $i) {
  print "<li>" . $i->name . "</li>";
}
}

?>
</ul>
</body>
</html>

