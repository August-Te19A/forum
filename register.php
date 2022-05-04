<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$databas = "webbserverprogramering";

$conn = new mysqli($servername, $username, $password, $databas);


$select = mysqli_query($conn, "SELECT * FROM forumaccounts WHERE username = '".$_POST['username']."'");
if(mysqli_num_rows($select)) {
    echo ('This username already exists');
}

else if (isset($_POST["username"])){
    $sql =  $conn->prepare("INSERT INTO forumaccounts (username, password) VALUES (?, ?)");
    $sql->bind_param("ss", $_POST['username'], $_POST['password']);
    $sql->execute();
    $_SESSION['username'] = $_POST['username'];
    header("location: index.php");
}

echo "<h2>Register success</h2>";

echo '<form action="login.html" method="post"> <button type="submit">Goto Login</button> </form>';


$conn->close();

?>
<script> // fixar så att det inte skickas in flera register när man uppdaterar sidan
      if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
      }
    </script>
