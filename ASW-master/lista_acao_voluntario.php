<?php
session_start();
//print_r($_SESSION);
include "openconn.php";

$acao = $_GET['acao'];
$acao_id = $_GET['acao_id'];

$inst_id = $_SESSION["ID"];

$texto = $_GET['texto'];
$procura = $_GET['procura'];
$carta = $_GET['carta'];

$query_voluntario = "SELECT volun_id FROM PL_Voluntario WHERE";

$query_areas = "SELECT vi.volun_id FROM PL_Volun_Interesse vi, PL_Areas_Interesse ai WHERE ai.area_int = vi.area_int AND ai.nome IN ("; 
$query_pop_alvo = "SELECT vp.volun_id FROM PL_Volun_Populacao_Alvo vp, PL_Populacao_Alvo pa WHERE vp.id_populacao_alvo = pa.id_populacao_alvo AND pa.nome IN ("; 
$query_horario = "SELECT volun_id FROM PL_Volun_Horario WHERE";
$query_procura_vol = "";

if ($texto != ""){
	$query_procura_vol .= " AND $procura LIKE '%$texto%'";
}
if ($carta != ""){
	$query_procura_vol .= " AND carta_conducao = '$carta'";
}

$acao = json_decode($acao);

for($i = 0; $i < count($acao); $i++){
	
	switch($i){	
		case 0:
			foreach($acao[$i] as $value){
				$area = utf8_decode($value); 
				$query_areas .= "'$area',";
			}
			$query_areas = substr($query_areas, 0, -1);
			$query_areas .= ") GROUP BY vi.volun_id HAVING count(vi.volun_id) = " . count($acao[$i]);
			break;
			
		case 1:
			foreach($acao[$i] as $value){
				$alvo = utf8_decode($value);
				$query_pop_alvo .= "'$alvo',";
			}
			$query_pop_alvo = substr($query_pop_alvo, 0, -1);
			$query_pop_alvo .= ") GROUP BY vp.volun_id HAVING count(vp.volun_id) = " . count($acao[$i]);
			break;
			
		case 2:
			
			$query = "SELECT volun_id FROM PL_Volun_Horario WHERE ";
			for($j = 0; $j < count($acao[$i]); $j++){
				$dia_array = $acao[$i][$j][0];
				$periodo_array = $acao[$i][$j][1];

				$query .= "volun_id IN (SELECT volun_id FROM PL_Volun_Horario WHERE dia = '".utf8_decode($dia_array)."' AND periodo = '".utf8_decode($periodo_array)."') ";

				if ($j != count($acao[$i])-1){
					$query .= "OR ";
				}
			}
			break;
	}
}

$acao = json_encode($acao);

if ($procura == ""){
	echo '<button type="button" id="button_close" class="btn-close" aria-label="Close" style="float: right;" onclick="fechar_convidar_voluntarios()"></button>';

	echo '<div class="container text-center">
					<div class="form-check form-check-inline">
					  <input type="text" class="form-control" id="procura_nome" onkeyup="atualizar_volun('.$acao_id.','.htmlspecialchars($acao).')">
					</div>&nbsp;&nbsp;
					<div class="form-check form-check-inline">
					  <input class="form-check-input" type="radio" name="procura_form" id="nome" value="nome" checked onclick="atualizar_volun('.$acao_id.','.htmlspecialchars($acao).')">
					  <label class="form-check-label" for="nome">Nome</label>
					</div>
					<div class="form-check form-check-inline">
					  <input class="form-check-input" type="radio" name="procura_form" id="email" value="email" onclick="atualizar_volun('.$acao_id.','.htmlspecialchars($acao).')">
					  <label class="form-check-label" for="email">Email</label>
					</div>
					<div class="form-check form-check-inline">
					  <input class="form-check-input" type="radio" name="procura_form" id="freguesia" value="freguesia" onclick="atualizar_volun('.$acao_id.','.htmlspecialchars($acao).')">
					  <label class="form-check-label" for="freguesia">Freguesia</label>
					</div>
					<div class="form-check form-check-inline">
					  <input class="form-check-input" type="radio" name="procura_form" id="concelho" value="concelho" onclick="atualizar_volun('.$acao_id.','.htmlspecialchars($acao).')">
					  <label class="form-check-label" for="concelho">Concelho</label>
					</div>
					<div class="form-check form-check-inline">
					  <input class="form-check-input" type="radio" name="procura_form" id="distrito" value="distrito" onclick="atualizar_volun('.$acao_id.','.htmlspecialchars($acao).')">
					  <label class="form-check-label" for="distrito">Distrito</label>
					</div>
					
					<br><br>
					<b>Carta de Condução:</b> &nbsp;&nbsp;
					<div class="form-check form-check-inline">
					  <input class="form-check-input" type="radio" name="carta_form" id="carta_Ambos" value="" checked onclick="atualizar_volun('.$acao_id.','.htmlspecialchars($acao).')">
					  <label class="form-check-label" for="carta_Ambos">Sim/Não</label>
					</div>
					<div class="form-check form-check-inline">
					  <input class="form-check-input" type="radio" name="carta_form" id="carta_sim" value="sim" onclick="atualizar_volun('.$acao_id.','.htmlspecialchars($acao).')">
					  <label class="form-check-label" for="carta_sim">Sim</label>
					</div>
					<div class="form-check form-check-inline">
					  <input class="form-check-input" type="radio" name="carta_form" id="carta_nao" value="nao" onclick="atualizar_volun('.$acao_id.','.htmlspecialchars($acao).')">
					  <label class="form-check-label" for="carta_nao">Não</label>
					</div>
				</div> <hr>';

	echo "<div id = 'conv_volun_div'>";
	
}

$query_voluntario .= " volun_id IN (".$query_areas.") AND volun_id IN (".$query_pop_alvo.")".$query_procura_vol;

$resultado_volun = mysqli_query($conn, $query_voluntario);

if (mysqli_num_rows($resultado_volun)>=1) {

    while ($volun_id = mysqli_fetch_array($resultado_volun, MYSQLI_NUM)) {
		
		$query_info_voluntario = "SELECT nome, genero, email, telefone, carta_conducao, freguesia, concelho, distrito, nascimento, foto
								FROM PL_Voluntario WHERE volun_id = '$volun_id[0]'";
								
		$resultado_voluntario = mysqli_query($conn, $query_info_voluntario);		
		
		while ($voluntario = mysqli_fetch_array($resultado_voluntario, MYSQLI_NUM)) {
			$input .=", Concelho: ".utf8_encode($voluntario[6]);
					 
			echo "<div><div class='container input-group p-2' style='height: 110px;'>
					<div class='row'>
						<div class='col-1 d-flex align-items-center justify-content-center'>
						  <img src='".utf8_encode($voluntario[9])."'class='rounded-circle border border-dark imagem_volun'>
						  <img src='imagens/chat.png' class='chat_volun' onclick='criar_nova_conversa(".$inst_id.",".$volun_id[0].")'>
						</div>
						<div class='col-5 border bg-light d-flex align-items-center justify-content-center' style='height: 100%;'>
							<div class='row' style='width: 100%; height: 100%;'>
								<div class='col d-flex align-items-center justify-content-center' style='width: 100%; height: 50%;'>
									<b>Nome:</b>&nbsp; ".utf8_encode($voluntario[0])." &nbsp;&nbsp;|&nbsp;&nbsp; <b>Telefone:</b>&nbsp; ".utf8_encode($voluntario[3])."
								</div>

								<!-- Force next columns to break to new line at md breakpoint and up -->
								<div class='w-100 d-none d-md-block border bg-light'></div>

								<div class='col d-flex align-items-center justify-content-center' style='width: 100%; height: 50%;'>
									<b>Género:</b>&nbsp; ".utf8_encode($voluntario[1])." &nbsp;&nbsp;|&nbsp;&nbsp; <b>Carta de Condução:</b>&nbsp; ".utf8_encode($voluntario[4])."
								</div>
							</div>
						</div>
						<div class='col-6 border bg-light d-flex align-items-center justify-content-center'>
							<div class='row' style='width: 100%; height: 100%;'>
								<div class='col d-flex align-items-center justify-content-center' style='width: 100%; height: 50%;'>
									
									<b>Email:</b>&nbsp; ".utf8_encode($voluntario[2])." &nbsp;&nbsp;|&nbsp;&nbsp; <b>Nascimento:</b>&nbsp; ".utf8_encode($voluntario[8])."
								</div>

								<!-- Force next columns to break to new line at md breakpoint and up -->
								<div class='w-100 d-none d-md-block border bg-light'></div>

								<div class='col d-flex align-items-center justify-content-center' style='width: 100%; height: 50%;'>
									<b>Distrito:</b>&nbsp; ".utf8_encode($voluntario[7])." &nbsp;|&nbsp; <b>Freguesia:</b>&nbsp; ".utf8_encode($voluntario[5])."&nbsp;|&nbsp;
									<b>Concelho:</b>&nbsp; ".utf8_encode($voluntario[6])."
								</div>
							</div>
						</div>
					  </div>
					</div><hr class='my-4'></div>";			 
		}
    }
	
}
if ($procura == ""){
	echo "</div>";
}		
?>
