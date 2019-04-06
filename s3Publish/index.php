<?php
include 's3.php';
?>
<!Doctype html>
<html>
	<head>
		<title>S3 Publish</title>
	</head>
	<body>
		<h1>S3 Publishing</h1>
		<?php
		if (isset($_POST['wiki'], $_POST['wiki1'], $_POST['wiki2'], $_POST['password'])) {
        		$wiki = htmlspecialchars($_POST['wiki']);
        		$wiki1 = htmlspecialchars($_POST['wiki1']);
        		$wiki2 = htmlspecialchars($_POST['wiki2']);
        		$articles = [$wiki , $wiki1 , $wiki2];
			$password = htmlspecialchars($_POST['password']);
        		if($password != 'class'){ ?>
        			<h1>invalid password</h1>
        		<?php } else {
        			$result = generatePage($articles);
        		}
		} ?>
		
		<form method='post' action='index.php'>
			<p>Name of Wikipedia Article to Include</p>
			</br>
			<input type='text' name='wiki' value=""></br>
			<input type='text' name='wiki1' value=""></br>
			<input type='text' name='wiki2' value=""></br>
			</br>
			<p>Password</p>
			</br>
			<input type='password' name='password'>
			</br>
			<input type='submit'>
		</form>
		<?php if(isset($result)){
                        if($result){ ?>
                                <h1><a href ="<?php print publish(); ?>" >Link To Page</a></h1>
                  <?php }else { ?>
                                <h1>Could not find one of the pages</h1>
                <?php }} ?>

	</body>
</html>
