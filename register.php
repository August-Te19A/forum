<?php
$servername = "localhost";
$username = "root";
$password = "";
$databas = "webbserverprogramering";

$conn = new mysqli($servername, $username, $password, $databas);


if (isset($_POST["username"])){
    $sql =  $conn->prepare("INSERT INTO forumaccounts (username, password) VALUES (?, ?)");
    $sql->bind_param("ss", $_POST['username'], $_POST['password']);
    $sql->execute();
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
