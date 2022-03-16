<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Forum</title>
  </head>
  <body>
    <h1>Forum</h1>
    <p>Hejsan och välkommen</p>
    <button onclick="window.location.href='login.html'">Login</button>
    <button onclick="window.location.href='register.html'">Register</button>
  </body>
</html>

<?php

$servername = "localhost";
$username = "root";
$password = "";
$databas = "webbserverprogramering";

$conn = new mysqli($servername, $username, $password, $databas);

$result = $conn->query("SELECT * FROM forumthreads");

$login_success = false;


if ($result->num_rows > 0) {  
    while($row = $result->fetch_assoc()) {
        echo '<hr><h2> <a href=topic.php?id=' . $row['id'] .'>'. $row['thr_name']. ' </a></h2>' .  'From: ' . $row['thr_creator'] . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . 'Time: ' . $row['thr_date'];
        $topicid = $row["id"];
        echo "<input type='hidden' name='topicid' value='$topicid'>";
        
      }
}


$conn->close();


?>