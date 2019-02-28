<?php
$mysqli = mysqli_connect("ceclnx01.cec.miamioh.edu", "exam","password","exam");
//Bailey Ralston
//CSE451
//Exam1
//2/28/19
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content=
  "width=device-width, initial-scale=1">
  <title>Exam 1 Question 2</title>
  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body>
<table class='table'>
                <thead>
                    <tr>
                    <th>pk</th>
                    <th>name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $res = mysqli_query($mysqli, "SELECT * FROM test");
                    if (!$res) {
                        echo "error on sql - $mysqli->error";
                    } else {
                        while($row = mysqli_fetch_assoc($res)) { ?>
                          <tr>
                              <td><?php print($row['pk']);?></td>
                              <td><?php print($row['name']);?></td>
                          </tr>
                        <?php }
                        
                    }
                      ?>
                </tbody>
            </table>
</body>
</html>
