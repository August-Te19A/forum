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
session_start();


$servername = "localhost";
$username = "root";
$password = "";
$databas = "webbserverprogramering";

$conn = new mysqli($servername, $username, $password, $databas);

$result = $conn->query("SELECT * FROM forumthreads");



//kollar om man är inloggad 
if (isset($_SESSION["username"])){

  echo $_SESSION["username"];
  echo "<a href='logout.php' class='btn btn-secondary btn-lg active' role='button' aria-pressed='true'>Logout</a>\n";

} 


if ($result->num_rows > 0) {  
    while($row = $result->fetch_assoc()) {
        echo '<hr><h2> <a href=topic.php?id=' . $row['id'] .'>'. $row['thread_topic']. ' </a></h2>' .  'From: ' . $row['thread_username'] . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . 'Time: ' . $row['thread_date'];
        $topicid = $row["id"];
        echo "<input type='hidden' name='topicid' value='$topicid'>";
        
      }
}


$conn->close();


?>