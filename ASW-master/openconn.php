<?php
$dbhost = "20.91.202.89";
$dbuser = "oAdminDestaSituacao";
$dbpass = "uma Password mesmo muito forte 123!";
$dbname = "asw020";
// Cria a ligação à BD
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// Verifica a ligação à BD
if (mysqli_connect_error()) {
  die("Database connection failed: " . mysqli_connect_error());
}
?>