<?php

session_start();

$username = htmlspecialchars($_POST["username"]);
$password = htmlspecialchars($_POST["password"]);

include "openconn.php";
                
$query = "SELECT v.senha, v.volun_id FROM PL_Voluntario v WHERE v.username = '$username'";

$resultado = mysqli_query($conn, $query);

if (mysqli_num_rows($resultado)>=1) {
    
    $row = mysqli_fetch_row($resultado);
    
    $db_hash = $row[0];
	$id = $row[1];
	
    if (password_verify($password, $db_hash)) {
        $_SESSION["utilizador"] = $username;
        $_SESSION["voluntario_ou_empresa"] = "perfil_voluntario.php";
		$_SESSION["ID"] = $id;
		
		if (isset($_SESSION["erro"])){
			unset($_SESSION['erro']);
		}
		
        header("Location: index.php");
    } else {
		$_SESSION["erro"] = "Utilizador e/ou password incorretos";
		header("Location: zonaLoginRegistar.php");
    }
        
} else {
    $_SESSION["erro"] = "Utilizador e/ou password incorretos";
	header("Location: zonaLoginRegistar.php");
}

mysqli_close($conn);


?>