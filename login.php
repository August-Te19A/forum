<!DOCTYPE html>
<html>
<body>


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

$_SESSION["login"] = FALSE;
$login_success = false;
$full_name = "";
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		if($row["username"] == $_POST["username"] &&
					$row["password"] == $_POST["password"]) {
			$login_success = true;
		}	
	}
} 

if($login_success) {
	$_SESSION["username"] = $_POST["username"];
    $_SESSION["login"] = TRUE;
	echo "login success \n";
	echo("<button onclick=\"location.href='index.php'\">Startpage</button>");
}
else{
	echo "login failed \n ";
	echo("<button onclick=\"location.href='login.html'\">Login again</button>");
}

$conn->close();
?>