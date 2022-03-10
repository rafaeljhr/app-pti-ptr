<?php

session_start();

include "openconn.php";

mysqli_set_charset($conn,"utf8");

$acao_id = htmlspecialchars($_GET["acao_id"]);
$volun_id = $_SESSION["ID"];

$sql = "UPDATE PL_Inst_Acoes_Volun_Candidato SET estado='aceite-recusado' WHERE volun_id = $volun_id AND acao_id = $acao_id";

$resultado = mysqli_query($conn, $sql);

?>