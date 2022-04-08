<!DOCTYPE html>
<html>
<body>


</body>
</html>

<?php 
$sql = "SELECT * FROM forumaccounts";

require_once "session.php";

$servername = "localhost";
$username = "root";
$password = "";
$databas = "webbserverprogramering";

$conn = new mysqli($servername, $username, $password, $databas);
$result = $conn->query($sql);


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
    $_SESSION["username"] = TRUE;
	header("location: dashboard.php");
	echo "login success \n";
	
	echo("<button onclick=\"location.href='index.php'\">Startpage</button>"); //ta bort 
	exit;
}
else{
	$_SESSION["username"] = null;
	echo "login failed \n ";
	echo("<button onclick=\"location.href='login.html'\">Login again</button>");
}

$conn->close();
?>