<?php

session_start();
include "openconn.php";
mysqli_set_charset($conn,"utf8");

$inst_id = htmlspecialchars($_GET["inst_id"]);
$volun_id = htmlspecialchars($_GET["volun_id"]);
$mensagem = htmlspecialchars($_GET["mensagem"]);

if($_SESSION["voluntario_ou_empresa"] == "perfil_empresa.php") {
    $sender = 'inst';
        
} else {
    $sender = 'volun';
}

$query = "INSERT INTO PL_Chat (mensagem, volun_id, inst_id, sender) VALUES ('$mensagem', '$volun_id', '$inst_id', '$sender')";
   
$resultado = mysqli_query($conn, $query);

?>