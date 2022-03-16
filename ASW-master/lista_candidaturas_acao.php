<?php
session_start();
//print_r($_SESSION);
include "openconn.php";

$acao_id = $_GET['acao_id'];

$texto = $_GET['texto'];
$procura = $_GET['procura'];
$carta = $_GET['carta'];


$query_voluntario = "SELECT volun_id FROM PL_Inst_Acoes_Volun_Candidato WHERE acao_id = $acao_id AND estado = 'pendente'";

if ($texto != ""){
	$query_voluntario .= " AND volun_id IN (SELECT volun_id FROM PL_Voluntario WHERE $procura LIKE '%$texto%')";
}
if ($carta != ""){
	$query_voluntario .= " AND volun_id IN (SELECT volun_id FROM PL_Voluntario WHERE carta_conducao = '$carta')";
}

$resultado_volun = mysqli_query($conn, $query_voluntario);

if ($procura == ""){
	echo '<button type="button" id="button_close" class="btn-close" aria-label="Close" style="float: right;" onclick="fechar_convidar_voluntarios()"></button>';

	echo '<div class="container text-center">
					<div class="form-check form-check-inline">
					  <input type="text" class="form-control" id="procura_nome" onkeyup="atualizar_cand('.$acao_id.')">
					</div>&nbsp;&nbsp;
					<div class="form-check form-check-inline">
					  <input class="form-check-input" type="radio" name="procura_form" id="nome" value="nome" checked onclick="atualizar_cand('.$acao_id.')">
					  <label class="form-check-label" for="nome">Nome</label>
					</div>
					<div class="form-check form-check-inline">
					  <input class="form-check-input" type="radio" name="procura_form" id="email" value="email" onclick="atualizar_cand('.$acao_id.')">
					  <label class="form-check-label" for="email">Email</label>
					</div>
					<div class="form-check form-check-inline">
					  <input class="form-check-input" type="radio" name="procura_form" id="freguesia" value="freguesia" onclick="atualizar_cand('.$acao_id.')">
					  <label class="form-check-label" for="freguesia">Freguesia</label>
					</div>
					<div class="form-check form-check-inline">
					  <input class="form-check-input" type="radio" name="procura_form" id="concelho" value="concelho" onclick="atualizar_cand('.$acao_id.')">
					  <label class="form-check-label" for="concelho">Concelho</label>
					</div>
					<div class="form-check form-check-inline">
					  <input class="form-check-input" type="radio" name="procura_form" id="distrito" value="distrito" onclick="atualizar_cand('.$acao_id.')">
					  <label class="form-check-label" for="distrito">Distrito</label>
					</div>
					
					<br><br>
					<b>Carta de Condução:</b> &nbsp;&nbsp;
					<div class="form-check form-check-inline">
					  <input class="form-check-input" type="radio" name="carta_form" id="carta_Ambos" value="" checked onclick="atualizar_cand('.$acao_id.')">
					  <label class="form-check-label" for="carta_Ambos">Sim/Não</label>
					</div>
					<div class="form-check form-check-inline">
					  <input class="form-check-input" type="radio" name="carta_form" id="carta_sim" value="sim" onclick="atualizar_cand('.$acao_id.')">
					  <label class="form-check-label" for="carta_sim">Sim</label>
					</div>
					<div class="form-check form-check-inline">
					  <input class="form-check-input" type="radio" name="carta_form" id="carta_nao" value="nao" onclick="atualizar_cand('.$acao_id.')">
					  <label class="form-check-label" for="carta_nao">Não</label>
					</div>	
				</div> <hr>';

	echo "<div id = 'conv_volun_div'>";
	
}

if (mysqli_num_rows($resultado_volun)>=1) {

    while ($volun_id = mysqli_fetch_array($resultado_volun, MYSQLI_NUM)) {
		
		$query_info_voluntario = "SELECT nome, genero, email, telefone, carta_conducao, freguesia, concelho, distrito, nascimento, foto
								FROM PL_Voluntario WHERE volun_id = '$volun_id[0]'";
								
		$resultado_voluntario = mysqli_query($conn, $query_info_voluntario);		
		
		while ($voluntario = mysqli_fetch_array($resultado_voluntario, MYSQLI_NUM)) {
			$input .=", Concelho: ".utf8_encode($voluntario[6]);
					 
			echo "<div class='container input-group p-2' style='height: 110px;'>
					<div class='row'>
						<div class='col-1 d-flex align-items-center justify-content-center'>
						  <img style='width: 100%;' src='".utf8_encode($voluntario[9])."'class='rounded-circle border border-dark'>
						</div>
						<div class='col-4 border bg-light d-flex align-items-center justify-content-center' style='height: 100%;'>
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
						<div class='col-1 d-flex align-items-center justify-content-center'>
							<div class='row' style='width: 100%; height: 100%;'>
								<div class='col d-flex align-items-center justify-content-center' style='width: 100%; height: 50%;'>
									<button class='btn btn-outline-success' type='button' onclick='aceitar_candidatura($volun_id[0], $acao_id, this)'>Aceitar</button>
								</div>
								<div class='w-100 d-none d-md-block'></div>
								<div class='col d-flex align-items-center justify-content-center' style='width: 100%; height: 50%;'>
									<button class='btn btn-outline-danger' type='button' onclick='rejeitar_candidatura($volun_id[0], $acao_id, this)'>Rejeitar</button>
								</div>
							</div>
						</div>
					  </div>
					</div><hr class='my-4' id='".$volun_id[0]."'>";			 
		}
    }
	echo "</div>";
}else{
	echo "<div style='text-align: center;'>
			Não existem candidaturas de momento!
		</div>";	
}
				
?>
