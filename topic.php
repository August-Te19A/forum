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


$sql = $conn->prepare("SELECT * FROM forumthreads WHERE id=?");
$sql->bind_param("s", $id);
$sql->execute();
$result = $sql->get_result();

if ($result->num_rows == 0) {
    return false;
  }

$thread = $result->fetch_assoc();
echo "<h2>".  $thread['thr_name'] ."</h2>";

$sql = $conn->prepare("SELECT * FROM forumtopic WHERE id=?");
$sql->bind_param("s", $id);
$sql->execute();
$result = $sql->get_result();



if ($result->num_rows > 0) { 
    while($row = $result->fetch_assoc()) {
        echo '<hr> '. 'From: ' . $row['UserID'] . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . 'Time: ' . $row['date'] . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $row['comment'];
        $topicid = $row["id"];
        echo "<input type='hidden' name='topicid' value='$topicid'>";
        
      }
}
else{
    echo "no posts yet";
}

$conn->close();



?>