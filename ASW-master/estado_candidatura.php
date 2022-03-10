<?php

session_start();

include "openconn.php";

mysqli_set_charset($conn,"utf8");

$acao_id = htmlspecialchars($_GET["acao_id"]);
$volun_id = $_SESSION["ID"];

$sql="SELECT estado FROM PL_Inst_Acoes_Volun_Candidato WHERE volun_id = $volun_id AND acao_id = $acao_id";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result)>=1) {

	$estado = mysqli_fetch_array($result, MYSQLI_NUM);

	if ($estado[0] == "pendente"){
		echo '<br><div class="estado_candidatura_volun">
				Estado: Pendente
			</div>';
	}
	else if($estado[0] == "rejeitado"){
		echo '<br><div class="estado_candidatura_volun">
				Estado Final: Rejeitado Pela Instituição
			</div>';
	}
	else if($estado[0] == "aceite"){
		echo '<br><div class="estado_candidatura_volun">
				Estado: Aceite Pela Instituição
				<br><br><div class="btn-group" role="group">
				  <button type="button" class="btn btn-success" onclick="aceitar_cand_volun('.$acao_id.')">Aceitar</button>
				  <button type="button" class="btn btn-danger" onclick="rejeitar_cand_volun('.$acao_id.')">Recusar</button>
				</div>
			</div>';
	}
	else if($estado[0] == "aceite-aceite"){
		echo '<br><div class="estado_candidatura_volun">
				Estado Final: Aceite
			</div>';
	}
	else if($estado[0] == "aceite-recusado"){
		echo '<br><div class="estado_candidatura_volun">
				Estado Final: Recusado
			</div>';
	}
	else if($estado[0] == "nao_aceite"){
		echo '<br><div class="estado_candidatura_volun">
				Estado Final: Não Aceite
			</div>';
	}
}

?>