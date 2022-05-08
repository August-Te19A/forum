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
    <button onclick="window.location.href='login.php'">Login</button>
    <button onclick="window.location.href='register.php'">Register</button>
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
  echo "<form action='index.php' method='post'>Topic<input type='text' name='name' id='name' /><br />Question<input type='text' name='email' id='email' /><input type='submit' value='Submit' name='submit' /></form>";
  //kollar om man skickar något man har skrivit
  if (isset($_POST['submit'])){
    $sql =  $conn->prepare("INSERT INTO forumthreads (thread_topic, thread_username, thread_date, id) VALUES (?, ?, ?, ?)");
    $sql->bind_param("ssss", $_POST['name'], $_SESSION['username'], $_POST['thread_date'], $_POST['id']);
    $sql->execute();
    header("location: index.php");
}
} 

//skriver ut alla trådar 
if ($result->num_rows > 0) {  
    while($row = $result->fetch_assoc()) {
        echo '<hr><h2> <a href=topic.php?id=' . $row['id'] .'>'. $row['thread_topic']. ' </a></h2>' .  'From: ' . $row['thread_username'] . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . 'Time: ' . $row['thread_date'];
        $topicid = $row["id"];
        echo "<input type='hidden' name='topicid' value='$topicid'>";
        
      }
}

$conn->close();
?>