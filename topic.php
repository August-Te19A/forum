<html>
  <head>
  </head>
</html>

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
echo "Created by: ". htmlspecialchars($thread['thread_username']) . '<br> Date: ' . $thread['thread_date']. '<br>';
echo "<button onclick=window.location.assign('index.php')> Back </button>";

//kollar om man är inloggad 
if (isset($_SESSION["username"])){
  echo "<form method='post'><hr>Reply<br><textarea cols='50' rows='6' type='text' name='question' id='question' /></textarea><br><input type='submit' value='Submit' name='submit' /></form>";
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
        echo "<hr><a href=profile.php?name=" . htmlspecialchars($row['topic_username']) .'><br>' . htmlspecialchars($row['topic_username']) . '</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <br>Time: ' . $row['topic_date'] ."<br><br>". htmlspecialchars($row['topic_comment']);
        $topicid = $row["id"];
        echo "<input type='hidden' name='topicid' value='$topicid'>";
      }
}
else{
    echo "<hr> no posts yet";
}

$conn->close();
?>