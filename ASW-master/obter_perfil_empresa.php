<?php
session_start();
//print_r($_SESSION);

$utilizador = $_SESSION["utilizador"];

include "openconn.php";
                
$query = "SELECT * FROM PL_Instituicao e WHERE e.nome = '$utilizador'";

$resultado = mysqli_query($conn, $query);

if (mysqli_num_rows($resultado)>=1) {

    $row = mysqli_fetch_row($resultado);

    $nome = utf8_encode($row[1]);
    $telefone = utf8_encode($row[2]);
    $email = utf8_encode($row[3]);
    $email_representante = utf8_encode($row[4]);
    $nome_representante = utf8_encode($row[5]);
    $descricao = utf8_encode($row[6]);
    $morada = utf8_encode($row[7]);
    $distrito = utf8_encode($row[8]);
    $concelho = utf8_encode($row[9]);
    $freguesia = utf8_encode($row[10]);
    $senha = utf8_encode($row[11]);
    $website = utf8_encode($row[12]);
    $foto = utf8_encode($row[13]);
        
} else {
    echo "Erro: " . $query . "<br>" . mysqli_error($conn);

}

?>