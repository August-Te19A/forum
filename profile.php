<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profile</title>
  </head>
  <body>

  </body>
</html>

<?php

$servername = "localhost";
$username = "root";
$password = "";
$databas = "webbserverprogramering";

$conn = new mysqli($servername, $username, $password, $databas);

$sql = $conn->prepare("SELECT * FROM forumthreads where thread_username=?");
$sql -> bind_param("s",$_GET["name"]);
$sql -> execute();
$result = $sql -> get_result();

session_start();

echo "<h1>" . $_GET["name"] . "</h1>";

echo "<button onclick=window.location.assign('index.php')> Back </button>";


if ($result->num_rows > 0) {  
  while($row = $result->fetch_assoc()) {
      echo '<hr><h2> <a href=topic.php?id=' . $row['id'] .'>'. $row['thread_topic']. " </a></h2>  From:  <a href=profile.php?name=" . $row['thread_username'] . ">" . $row['thread_username'] . '</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Time: ' . $row['thread_date'];
      $topicid = $row["id"];
      echo "<input type='hidden' name='topicid' value='$topicid'>";
    }
}

$conn->close();





?>