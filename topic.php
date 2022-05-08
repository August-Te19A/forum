<?php

$servername = "localhost";
$username = "root";
$password = "";
$databas = "webbserverprogramering";

$conn = new mysqli($servername, $username, $password, $databas);

if (!isset($_GET["id"])){
    die("Du skickade inget id");
}
$id = $_GET["id"];

session_start();

$sql = $conn->prepare("SELECT * FROM forumthreads WHERE id=?");
$sql->bind_param("s", $id);
$sql->execute();
$result = $sql->get_result();

if ($result->num_rows == 0) {
    return false;
  }

$thread = $result->fetch_assoc();
echo "<h2>".  $thread['thread_topic'] ."</h2>";

//kollar om man är inloggad 
if (isset($_SESSION["username"])){
  echo "<form method='post'>Question<input type='text' name='question' id='question' /><br /><input type='submit' value='Submit' name='submit' /></form>";
  if (isset($_POST['submit'])){
    $sql =  $conn->prepare("INSERT INTO forumtopics (topic_username, topic_date, topic_comment, id) VALUES (?, ?, ?, ?)");
    $sql->bind_param("ssss", $_SESSION['username'], $_POST['thread_date'], $_POST['question'], $id);
    $sql->execute();
    header("Refresh:0");
}
} 

$sql = $conn->prepare("SELECT * FROM forumtopics WHERE id=?");
$sql->bind_param("s", $id);
$sql->execute();
$result = $sql->get_result();


//skriver ut medelanden
if ($result->num_rows > 0) { 
    while($row = $result->fetch_assoc()) {
        echo '<hr> '. 'From: ' . $row['topic_username'] . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . 'Time: ' . $row['topic_date'] . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $row['topic_comment'];
        $topicid = $row["id"];
        echo "<input type='hidden' name='topicid' value='$topicid'>";
        
      }
}
else{
    echo "no posts yet";
}

$conn->close();
?>