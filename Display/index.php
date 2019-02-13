<!-- Bailey Ralston -->
<!-- CSE 451 -->
<!-- week2-php -->
<!-- 02/07/2019 -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Week2 PHP</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>
    <body>
        <?php
	    session_start();
            require_once("info.php");
            if(isset($_POST['key']) && isset($_POST['value']) && isset($_POST['password'])){  /stc -> good
                $key = htmlspecialchars($_POST['key']);
                $value = htmlspecialchars($_POST['value']);
                $password = htmlspecialchars($_POST['password']);
                $result = add($key, $value, $password);
                if($result != "OK"){ ?>
            <div id="error" class="alert alert-danger" role="alert">Invalid password</div>    //stc -> you did display a user message but in general I would look for the message nearer the form where I put in the data.
		<?php } else { ?>
		<div id="info" class="alert alert-info" role="alert">Added successfully!</div>
		<?php
            }
}
        ?>

        <div class="container-fluid">
        <h1>Display Keys and Values
        <table class="table">
            <thead>
                <tr>
                    <th>Key</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody id="keyTable">
                <?php
                    $keys = getKeys();
                    if($keys != NULL){
                        foreach($keys as $key) {
                        ?> <tr> <td><?php print $key; ?></td> 
                        <td><?php print getValue($key); ?></td> </tr>
                        
                        <?php
                        }
                    }
                ?>

            </tbody>
        </table>
        </div>
        <div class="container-fluid">
            <h2>Add new key/value pair</h2>
            <div id="formDiv" class="container-fluid center-block">
            <form method="post" action="index.php">
                <div class="form-group">
                    <label for="key">Key:</label> <input type="text" name="key" class="form-control" id="key">
                </div>
                <div class="form-group">
                    <label for="value">Value:</label> <input type="text" name="value" class="form-control" id="value">
                </div>
                <div class="form-group">
                    <label for="password">Password:</label> <input type="password" name="password" class="form-control" id="password">
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" value="Submit" class="form-control">
                </div>
            </form>
        </div>
        <footer>
        <div>
            <p>Bailey Ralston CSE451 week2-php 02/7/2019 </p>
        </div>
      </footer>

    </body>
</html>
