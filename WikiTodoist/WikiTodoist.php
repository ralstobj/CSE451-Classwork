<?php 
require "key.php";
require "WikiTodoistModel.php";

session_start();
if (isset($_REQUEST['logout'])) {
  unset($_SESSION['tokenWiki']);
      }

if (!isset($_SESSION['tokenWiki'])) {
  header("Location: https://todoist.com/oauth/authorize?client_id=$clientIDWiki&scope=data:read_write,data:delete&state=scott");
}
?>
<html>
<head>
<style>
img {
float: left;
}
div {
overflow: auto;
}
</style>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

</head>
<body>
<h1>Wikipedia</h1>
<?php
$arr = getProjects();
foreach ($arr as $article) { ?>
    <div>
	<h3><?php print $article["title"];?></h3>
	<?php if($article["summary"] != "Not Found") { ?>
	<p><img src="<?php print $article["thumbnailSrc"];?>"style="width:<?php print $aricle["thumbnailW"];?>px;height:<?php print $aricle["thumbnailH"];?>px;margin-right:15px;"><?php print $article["summary"];?></p>
	<a href="<?php print $article["url"];?>"><?php print $article["url"];?></a>
	<?php } else { ?>
	<p>This page was not found.</p>
	<?php } ?>
    </div>
    <br>
<?php } ?>
</body>
</html>
<?php
$log  = "User: ".$_SESSION['tokenWiki'].' | Event: Page Loaded | '.
	date("F j, Y, g:i a").PHP_EOL.
        "-------------------------".PHP_EOL;
file_put_contents('WikiTodist.log', $log, FILE_APPEND);
?>
