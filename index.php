<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Forum</title>
    <link rel="stylesheet" href= "index.css">
  </head>
  <body>
    <h1>Forum</h1>
    <p>Hejsan och välkommen</p>
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

//kollar om man inte är inloggad
if (!isset($_SESSION["username"])){
  echo "<button onclick=window.location.assign('login.php')>Login</button> <button onclick=window.location.assign('register.php')>Register</button>";
}

//kollar om man är inloggad 
if (isset($_SESSION["username"])){
  echo "<a href=profile.php?name=" . $_SESSION['username'] .">" . $_SESSION['username']. "</a>\n"; 
  echo "<a href='logout.php' class='btn btn-secondary btn-lg active' role='button' aria-pressed='true'>Logout</a>\n";
  echo "<form action='index.php' method='post'><br>Topic <br><textarea cols='50' rows='1' name='name' id='name' ></textarea><br/>Question<br><textarea cols='50' rows='6' name='topic' id='topic' /></textarea><br><input type='submit' value='Submit' name='submit' /></form>";
  //kollar om man skickar något man har skrivit
  if (isset($_POST['submit'])){
    $sql =  $conn->prepare("INSERT INTO forumthreads (thread_topic, thread_username, thread_date) VALUES (?, ?, ?)");
    $sql->bind_param("sss", htmlspecialchars($_POST['name']), $_SESSION['username'], $_POST['thread_date'], );
    $sql->execute();
    //sparar ner det senaste id:t 
    $id = mysqli_insert_id($conn);
    $sql =  $conn->prepare("INSERT INTO forumtopics (topic_username, topic_date, topic_comment, id) VALUES (?, ?, ?, ?)");
    $sql->bind_param("ssss", $_SESSION['username'], $_POST['thread_date'], htmlspecialchars($_POST['topic']), $id);
    $sql->execute();
    header("location: topic.php?id=".$id);
}
} 

//skriver ut alla trådar 
if ($result->num_rows > 0) {  
    while($row = $result->fetch_assoc()) {
        echo '<hr><h2> <a href=topic.php?id=' . $row['id'] .'>'. $row['thread_topic']. " </a></h2>  From:  <a href=profile.php?name=" . $row['thread_username'] . ">" . $row['thread_username'] . '</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Time: ' . $row['thread_date'];
        $topicid = $row["id"];
        echo "<input type='hidden' name='topicid' value='$topicid'>";
      }
}

$conn->close();
?>