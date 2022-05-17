<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
  </head>
<body>
<h1>Login to forum</h1>
    <form action="login.php" method="post" id="loginform">
      Username:<br />
      <input type="text" name="username" />
      <br />
      Password:<br />
      <input type="password" name="password" />
      <br />
      <input type="submit" value="Submit" />
    </form>
</body>
</html>

<?php 
session_start();

$sql = "SELECT * FROM forumaccounts";

$servername = "localhost";
$username = "root";
$password = "";
$databas = "webbserverprogramering";

$conn = new mysqli($servername, $username, $password, $databas);
$result = $conn->query($sql);

//kollar om username är satt annars kör den inte resterande kod
if (!isset($_POST['username'])){
	return;
  }

$login_success = false;

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		if($row["username"] == $_POST["username"] && password_verify($_POST["password"], $row["password"])) {
			$login_success = true;
		}	
	}
} 

if($login_success) {
	$_SESSION["username"] = $_POST["username"];
	header("location: index.php");
}
else{
	$_SESSION["username"] = null;
	echo "<script> alert('Failed to login') </script>";
}

$conn->close();
?>