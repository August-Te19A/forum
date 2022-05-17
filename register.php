<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register</title>
  </head>
  <body>
    <h1>Register to forum</h1>
    <form action="register.php" method="post">
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

$servername = "localhost";
$username = "root";
$password = "";
$databas = "webbserverprogramering";

$conn = new mysqli($servername, $username, $password, $databas);

//kollar om username är satt annars kör den inte resterande kod
if (!isset($_POST['username'])){
  return;
}
//kollar om användare redan finns med det valda användarnamnet 
$select = mysqli_query($conn, "SELECT * FROM forumaccounts WHERE username = '".$_POST['username']."'");
if(mysqli_num_rows($select)) {
    echo "<script> alert('This username already exists') </script>";
}
//gör en profil 
else if (isset($_POST["username"])){
    $sql =  $conn->prepare("INSERT INTO forumaccounts (username, password) VALUES (?, ?)");
    $sql->bind_param("ss", htmlspecialchars($_POST['username']), password_hash($_POST['password'], PASSWORD_DEFAULT));
    $sql->execute();
    $_SESSION['username'] = $_POST['username'];
    header("location: index.php");
}


$conn->close();

?>
<script> // fixar så att det inte skickas in flera register när man uppdaterar sidan
      if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
      }
    </script>
