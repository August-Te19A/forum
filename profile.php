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

echo "<h1>" . htmlspecialchars($_GET["name"]) . "</h1>";

$sql = $conn->prepare("SELECT * FROM forumaccounts where username=?");
$sql -> bind_param("s",$_GET["name"]);
$sql -> execute();
$result = $sql -> get_result();
$row = $result -> fetch_assoc();

echo "Account created: " . $row['accountcreate'];

$sql = $conn->prepare("SELECT * FROM forumthreads where thread_username=?");
$sql -> bind_param("s",$_GET["name"]);
$sql -> execute();
$result = $sql -> get_result();

session_start();

//Kollar om man är profilen man går in på är ens egen
if (isset($_SESSION["username"]) and $_GET["name"] == $_SESSION["username"]){
  echo "<form method='post'><br><br>Change password<br>Old password: <input type='text' name='oldpassword'></input><br>New password: <input type='text' name='newpassword'></input><br><br><button>Change password </button></p></form>";
  if (isset($_POST['oldpassword'])){
    if (password_verify($_POST['oldpassword'],$row['password'] )){
      mysqli_query($conn, "UPDATE forumaccounts set password='" . password_hash($_POST["newpassword"], PASSWORD_DEFAULT) . "' WHERE username='" . $_SESSION["username"] . "'");
      echo "<script> alert('Password update success') </script>";
    }  
    else{
      echo "<script> alert('Wrong password') </script>";
    }
  } 
}

echo "<br><button onclick=window.location.assign('index.php')> Back </button><br>";

if ($result->num_rows > 0) {  
  while($row = $result->fetch_assoc()) {
      echo '<hr><h2> <a href=topic.php?id=' . $row['id'] .'>'. htmlspecialchars($row['thread_topic']). " </a></h2>  From:  <a href=profile.php?name=" . htmlspecialchars($row['thread_username']) . ">" . htmlspecialchars($row['thread_username']) . '</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Time: ' . $row['thread_date'];
      $topicid = $row["id"];
      echo "<input type='hidden' name='topicid' value='$topicid'>";
    }
}

$conn->close();





?>