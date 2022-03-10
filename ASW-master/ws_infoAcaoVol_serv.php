<?php

require_once "lib/nusoap.php";

function InfoAcaoVol($inst_id, $volun_id) {

	$dbhost="appserver-01.alunos.di.fc.ul.pt";
	$dbuser="asw020";	
	$dbpass="aswrumoao20";	
	$dbname="asw020";

	//Cria a ligação à BD
	$conn=mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
	
	mysqli_set_charset($conn,"utf8");

	//Verifica a ligação à BD
	if(mysqli_connect_error()){die("Database connection failed:".mysqli_connect_error());}

	$sql="SELECT ia.acao_id, ia.inst_id, ia.nome, ia.distrito, ia.concelho, ia.freguesia, ia.funcao, ia.numero_vagas, ia.Ativo
    FROM PL_Inst_Acoes ia, PL_Instituicao i
    WHERE ia.Ativo='sim' AND i.inst_id='$inst_id' AND i.inst_id=ia.inst_id
    GROUP BY ia.acao_id";

	$result=mysqli_query($conn,$sql);

	if (mysqli_num_rows($result)>=1) {
		
		$acoes_instituicoes = array();
	
		while ($row_acoes_instituicoes = mysqli_fetch_array($result, MYSQLI_NUM)) {
			$acoes_instituicoes[] = $row_acoes_instituicoes;
		}
	
		$HTML_todas_acoes_instituicoes = '
		<button type="button" id="fechar_sobre_empresa" class="btn-close" aria-label="Close" onclick="fechar_sobre_empresa()"></button>
		<br>
		<h2>
		<div class="container text-center w-75">
		<div class="row">

			<div class="col">
			<div class="form-check">
				<input type="checkbox" class="form-check-input big-checkbox2" id="infos_da_empresa2" onclick="onlyOneChecked5(); construir_apresentacao_empresa('.$inst_id.');">
				<label for="infos_da_empresa2" class="form-check-label textoCheckbox3">PERFIL DA EMPRESA</label>
			</div>
			</div>

			<div id="coluna2" class="col">
			<div class="form-check">
				<input type="checkbox" class="form-check-input big-checkbox2" id="todas_acoes_da_empresa2" checked="checked" onclick="onlyOneChecked6();">
				<label for="todas_acoes_da_empresa2" class="form-check-label textoCheckbox3">AÇÕES DE VOLUNTARIADO DA EMPRESA</label>
			</div>
			</div>

		</div>
		</div>
		</h2>
		<br>

		<div id="conjunto_ações_perfil_empresa">
		';
	
		foreach ($acoes_instituicoes as $acao){
	
			// Obter avatar da instituição da ação
			$query_avatar = "SELECT nome, foto FROM PL_Instituicao WHERE inst_id='$acao[1]'";
	
			$resultado_avatar = mysqli_query($conn, $query_avatar);
	
			if (mysqli_num_rows($resultado_avatar)>=1) {
				$row = mysqli_fetch_row($resultado_avatar);
				$nome_da_empresa = $row[0];
				$foto = $row[1];
			}
	
			
			// Obter areas interesse da acao
			$query_acoes_instituicao_areas_interesse = "SELECT ai.nome
														FROM PL_Inst_Interesse ii, PL_Areas_Interesse ai
														WHERE ii.acao_id='$acao[0]' AND ii.area_int = ai.area_int";
			
			$resultado_acoes_instituicao_areas_interesse = mysqli_query($conn, $query_acoes_instituicao_areas_interesse);
	
			if (mysqli_num_rows($resultado_acoes_instituicao_areas_interesse)>=1) {
	
				$acoes_instituicao_areas_interesse = array();
	
				while ($row_acoes_instituicao_areas_interesse = mysqli_fetch_array($resultado_acoes_instituicao_areas_interesse, MYSQLI_NUM)) {
					$acoes_instituicao_areas_interesse[] = $row_acoes_instituicao_areas_interesse;
				}
	
			}
	
			// Obter populacoes alvo da acao
			$query_acoes_instituicao_populacoes_alvo = "SELECT pa.nome
														FROM PL_Inst_Popul_Alvo ipa, PL_Populacao_Alvo pa
														WHERE ipa.acao_id='$acao[0]' AND ipa.id_popul_alvo = pa.id_populacao_alvo";
	
			$resultado_acoes_instituicao_populacoes_alvo = mysqli_query($conn, $query_acoes_instituicao_populacoes_alvo);
	
			if (mysqli_num_rows($resultado_acoes_instituicao_populacoes_alvo)>=1) {
	
				$acoes_instituicao_populacoes_alvo = array();
	
				while ($row_acoes_instituicao_populacoes_alvo = mysqli_fetch_array($resultado_acoes_instituicao_populacoes_alvo, MYSQLI_NUM)) {
					$acoes_instituicao_populacoes_alvo[] = $row_acoes_instituicao_populacoes_alvo;
				}
	
			}
	
			// Obter horarios da acao
			$query_acoes_instituicao_horarios = "SELECT dia, periodo
												 FROM PL_Acoes_Horario
												 WHERE acao_id='$acao[0]'";
	
			$resultado_acoes_instituicao_horarios = mysqli_query($conn, $query_acoes_instituicao_horarios);
	
			if (mysqli_num_rows($resultado_acoes_instituicao_horarios)>=1) {
	
				$acoes_instituicao_horarios = array();
	
				while ($row_acoes_instituicao_horarios = mysqli_fetch_array($resultado_acoes_instituicao_horarios, MYSQLI_NUM)) {
					$acoes_instituicao_horarios[] = $row_acoes_instituicao_horarios;
				}
	
			}
	
			// saber se o voluntário já se candidatou a esta ação
			if ($volun_id != "None"){
				$ja_candidatou = "SELECT candidatura_id FROM PL_Inst_Acoes_Volun_Candidato WHERE volun_id = '$volun_id' AND acao_id = '$acao[0]'";
				$resultado_ja_candidatou = mysqli_query($conn, $ja_candidatou);
			}
	
			// Construção de cada caixa onde fica a ação no HTML
	
			$HTML_acao_instituicao = "";
	
			$HTML_acao_instituicao .= '<div class="container caixa_da_acao"><br>';

			if ($volun_id != "None"){
				if (mysqli_num_rows($resultado_ja_candidatou)>=1) {
					$HTML_acao_instituicao .= '
					<form action="voluntario_quer_cancelar_candidatura.php" method="post">
						<div class="text-center zona_do_botao">
							<input class="btn btn-secondary btn-lg texto_botao" type="submit" value="CANCELAR CANDIDATURA À AÇÃO!" name="'.($acao[0]).'">
						</div>
					</form><br>
				';
				} else {
					$HTML_acao_instituicao .= '
					<form action="voluntario_quer_participar_na_acao.php" method="post">
						<div class="text-center zona_do_botao">
							<input class="btn btn-primary btn-lg texto_botao" type="submit" value="QUERO PARTICIPAR NESTA AÇÃO!" name="'.($acao[0]).'">
						</div>
					</form><br>
					';
				}
			}
			
			$HTML_acao_instituicao .= '		
				<div class="participar_nome_da_empresa">
	
					<img id="' .($acao[1]). '" class="avatar" src="' . $foto . '" alt="Avatar">
	
					<div class="titulos">
						<h4 class="nome_da_empresa">Empresa: '.$nome_da_empresa.'</h4>
						<button id="sobre_a_empresa" class="btn btn-dark sobre_empresa" onclick="mostrar_sobre_empresa(); construir_apresentacao_empresa('.($acao[1]).')">SOBRE A EMPRESA</button>';
			if ($volun_id != "None"){
				$HTML_acao_instituicao .= '<img class="chat" src="imagens/chat.png" alt="Avatar" onclick="mostrar_chat()">';
			}
						
						
			$HTML_acao_instituicao .= '</div>
	
				</div>
	
				<div class="container zona_infos_principais">
	
					<h6 class="texto_titulo_acao">Ação: '.($acao[2]).'</h6>
	
					<br>
	
					<div> 
	
						<span class="form-control" id="areas_interesse" class="texto_input_span" role="textbox" readonly> 
							Distrito: '.($acao[3]).', Concelho: '.($acao[4]).', Freguesia: '.($acao[5]).', Função: '.($acao[6]).', Número de vagas: '.($acao[7]).'
						</span>
	
					</div>
	
	
				</div>
	
				<hr class="my-4">
	
				<div class="container zona_areas_interesse">
	
					<h5 class="texto_subtitulo_acao">Áreas de interesse</h5>
	
					<span class="form-control" id="areas_interesse" class="input" role="textbox" readonly>
	
			';
	
			$numero_areas_interesse = count($acoes_instituicao_areas_interesse);
	
			$a = 1;
			foreach ($acoes_instituicao_areas_interesse as $area_interesse) {
				if ($a == $numero_areas_interesse) {
					$HTML_acao_instituicao .= ($area_interesse[0]);
				} else {
					$HTML_acao_instituicao .= ($area_interesse[0]) . ', ';
				}
				$a++;
			}
	
			$HTML_acao_instituicao .= '
				</span>
	
			</div>
	
			<hr class="my-4">
	
			<div class="container zona_populacoes_alvo">
				<h5 class="texto_subtitulo_acao">Populações alvo</h5>
	
				<span class="form-control" id="populacoes_alvo" class="input" role="textbox" readonly>
			';
	
			$numero_populacoes_alvo = count($acoes_instituicao_populacoes_alvo);
	
			$b = 1;
			foreach ($acoes_instituicao_populacoes_alvo as $populacao_alvo) {
				if ($b == $numero_populacoes_alvo) {
					$HTML_acao_instituicao .= ($populacao_alvo[0]);
				} else {
					$HTML_acao_instituicao .= ($populacao_alvo[0]) . ', ';
				}
				$b++;
			}
	
			$HTML_acao_instituicao .= '
				</span>
	
			</div>
	
			<hr class="my-4">
	
			<div class="container zona_horarios">
					<h5 class="texto_subtitulo_acao">Horários da ação</h5>';
	
			$c = 1;
			foreach ($acoes_instituicao_horarios as $horario) {
				
				$HTML_acao_instituicao .= '
				<div class="row">
				<div class="col">
					<label for="dia_da_semana'.$c.'" class="form-label">Dia: </label>
					<input class="form-control" id="dia_da_semana'.$c.'" type="text" value="'.($horario[0]).'" readonly>
				</div>
	
				<div class="col">
					<label  for="hora_inicio'.$c.'" class="form-label">Periodo:</label>
					<input class="form-control" id="hora_inicio'.$c.'" type="text" value="'.($horario[1]).'" readonly>
				</div></div><br>';
	
				$c++;
			}
	
			$HTML_acao_instituicao .= '
				
						
				</div>
	
				<br>
	
			</div>
			';
	
			$HTML_todas_acoes_instituicoes .= $HTML_acao_instituicao;
			
	
		}

		$HTML_todas_acoes_instituicoes .= '</div>';
	
	} else {
		$HTML_todas_acoes_instituicoes = '';
	}

	mysqli_close($conn);


	if ($HTML_todas_acoes_instituicoes != '') {
	
		return  $HTML_todas_acoes_instituicoes;
	
	} else {
	
		return  '<p>Não existem ações que correspondam às suas áreas de interesse / populações alvo / disponibilidades!</p>';
	
	}
}


$server = new soap_server();

$server->configureWSDL('cumpwsdl', 'urn:cumpwsdl');

$server->register("InfoAcaoVol", // nome metodo
array('inst_id' => 'xsd:string', 'volun_id' => 'xsd:string'), // input
array('return' => 'xsd:string'), // output
	'uri:cumpwsdl', // namespace
	'urn:cumpwsdl#InfoAcaoVol', // SOAPAction
	'rpc', // estilo
	'encoded' // uso
);

@$server->service(file_get_contents("php://input"));
?>