<?php
session_start();
//print_r($_SESSION);

$utilizador = $_SESSION["utilizador"];

include "openconn.php";
                
$query = "SELECT * FROM PL_Voluntario v WHERE v.username = '$utilizador'";

$resultado = mysqli_query($conn, $query);

if (mysqli_num_rows($resultado)>=1) {

    $row = mysqli_fetch_row($resultado);

    $username = utf8_encode($row[1]);
    $senha = utf8_encode($row[2]);
    $email = utf8_encode($row[3]);
    $telefone = utf8_encode($row[4]);
    $cartao_cidadao = utf8_encode($row[5]);
    $carta_conducao = utf8_encode($row[6]);
    $genero = utf8_encode($row[7]);
    $nome = utf8_encode($row[8]);
    $freguesia = utf8_encode($row[9]);
    $concelho = utf8_encode($row[10]);
    $distrito = utf8_encode($row[11]);
    $nascimento = utf8_encode($row[12]);
    $foto = utf8_encode($row[13]);
        
} else {
    echo "Erro: " . $query . "<br>" . mysqli_error($conn);

}

?>