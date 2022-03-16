<?php


if (isset($_POST["submit"])){

	include "openconn.php";
	
	$user = htmlspecialchars($_POST["user"]);
	$password = htmlspecialchars($_POST["password"]);
					
	$sql = "SELECT username, senha FROM PL_Admin WHERE username='$user' and senha='$password'";
	
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);

	if ($row){
		session_start();
		$_SESSION["Admin"] = $user;
		header("Location: admin_panel.php");
	}
	else{
		header("Location: index.php");
	}		
}

?>