<!DOCTYPE html>
<html>
<body>

<?php 
session_start(); 
$sql = "SELECT * FROM forumlogin";

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
		if($row["UserID"] == $_POST["username"] &&
					$row["PASSWORD"] == $_POST["password"]) {
			$login_success = true;
			
			}		
	}
} 

if($login_success) {
	$_SESSION["username"] = $_POST["username"];
    echo "login success";
}




$conn->close();

?>



</body>
</html>