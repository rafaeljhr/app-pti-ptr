<?php
session_start();
//print_r($_SESSION);
include "openconn.php";

$acao = $_GET['acao'];
$volun = $_GET['volun'];
$estado = $_GET['estado'];

$query = "UPDATE PL_Inst_Acoes_Volun_Candidato SET estado = '$estado' WHERE volun_id = $volun AND acao_id = $acao";
mysqli_query($conn, $query);
				
?>
