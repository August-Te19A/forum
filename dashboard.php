<?php

session_start();

echo "hejsjkdfjsf";

if (!isset($_SESSION["username"]) || $_SESSION["username"] !== true){
  header("location: index.php");
  exit;
  

}

echo "<a href='logout.php' class='btn btn-secondary btn-lg active' role='button' aria-pressed='true'>Logout</a>";

?>