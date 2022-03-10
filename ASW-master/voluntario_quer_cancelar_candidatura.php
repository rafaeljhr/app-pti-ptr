<?php
session_start();

include "openconn.php";
mysqli_set_charset($conn,"utf8");


$volun_id = $_SESSION["ID"];
$acao_id = key($_POST);


include "openconn.php";

$query = "DELETE FROM `PL_Inst_Acoes_Volun_Candidato` WHERE volun_id = '$volun_id' AND acao_id = '$acao_id'";
            
$resultado = mysqli_query($conn, $query);

if ($resultado) {

    header("Location: acoes_das_instituicoes.php");

} else {
echo "Erro: delete failed" . $query . "<br>" . mysqli_error($conn);
}


mysqli_close($conn);

?>