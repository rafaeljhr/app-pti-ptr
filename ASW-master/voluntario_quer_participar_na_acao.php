<?php
session_start();

include "openconn.php";
mysqli_set_charset($conn,"utf8");


$volun_id = $_SESSION["ID"];
$acao_id = key($_POST);


include "openconn.php";

$ja_candidatou = "SELECT candidatura_id FROM PL_Inst_Acoes_Volun_Candidato WHERE volun_id = '$volun_id' AND acao_id = '$acao_id'";
$resultado_ja_candidatou = mysqli_query($conn, $ja_candidatou);

if (mysqli_num_rows($resultado_ja_candidatou)==0) {
    $query = "INSERT INTO `PL_Inst_Acoes_Volun_Candidato` (`volun_id`, `acao_id`, `estado`)
    VALUES ('$volun_id', '$acao_id', 'pendente')";
                
    $resultado = mysqli_query($conn, $query);

    if ($resultado) {

        header("Location: acoes_das_instituicoes.php");

    } else {
    echo "Erro: insert failed" . $query . "<br>" . mysqli_error($conn);
    }
}else {
    header("Location: acoes_das_instituicoes.php");
}

mysqli_close($conn);

?>