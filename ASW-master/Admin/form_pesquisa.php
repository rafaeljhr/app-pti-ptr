<?php
	include "openconn.php";

	$alvo = htmlspecialchars($_GET['alvo']);
	$restricao = htmlspecialchars($_GET['restricao']);
	$tabela = htmlspecialchars($_GET['tabela']);
	$faixa_etaria = htmlspecialchars($_GET['faixa_etaria']);
	$atividade = htmlspecialchars($_GET['atividade']);
	
	if ($tabela == "Voluntario" or $tabela == ""){
		$sql = "SELECT volun_id, username, email, telefone, cartao_cidadao, carta_conducao, genero, 
			nome, freguesia, concelho, distrito, nascimento FROM PL_Voluntario";
			
		$html[] = "<thead class='thead-light'><tr> <th scope='col'>ID</th> <th scope='col'>Username</th> <th scope='col'>Email</th> <th scope='col'>Telefone</th> 
			<th scope='col'>Cartao de Cidadão</th> <th scope='col'>Carta de Conducão</th> <th scope='col'>Género</th><th scope='col'>Nome</th>
			<th scope='col'>Freguesia</th> <th scope='col'>Concelho</th> <th scope='col'>Distrito</th> <th scope='col'>Nascimento</th></tr></thead><tbody>";
	}
	else if($tabela == "Instituicao"){
		$sql = "SELECT inst_id, nome, telefone, email, nome_representante, email_representante, morada, 
			distrito, concelho, freguesia FROM PL_Instituicao";
			
		$html[] = "<thead class='thead-light'><tr> <th scope='col'>ID</th> <th scope='col'>Nome</th> <th scope='col'>Telefone</th> <th scope='col'>Email</th> 
		<th scope='col'>Nome Representante</th> <th scope='col'>Email Representante</th> <th scope='col'>Morada</th> <th scope='col'>Distrito</th> 
		<th scope='col'>Concelho</th> <th scope='col'>Freguesia</th></tr></thead><tbody>";
	}
	else if($tabela == "Acao"){
		$sql = "SELECT acao.acao_id, inst.nome, acao.nome, acao.distrito, acao.concelho, acao.freguesia, acao.funcao, 
			acao.numero_vagas, acao.ativo FROM PL_Inst_Acoes acao, PL_Instituicao inst WHERE inst.inst_id = acao.inst_id";
			
		$html[] = "<thead class='thead-light'><tr> <th scope='col'>ID</th> <th scope='col'>Instituição</th> <th scope='col'>Nome</th> <th scope='col'>Distrito</th> 
		<th scope='col'>Concelho</th> <th scope='col'>Freguesia</th> <th scope='col' style='word-wrap: break-word;max-width: 150px;'>Função</th> <th scope='col'>Vagas</th> 
		<th scope='col'>Ativo</th></tr></thead><tbody>";
	}
	
	if ($alvo != "" and $restricao != "faixa_etaria" and $tabela != "Acao"){
		$procura = "%".$alvo."%";
		
		$sql .=" WHERE $restricao LIKE '$procura'";
			
	}
	else if($alvo != "" and $restricao != "faixa_etaria" and $tabela = "Acao"){
		$procura = "%".$alvo."%";	
		$sql .=" AND acao.$restricao LIKE '$procura'";
	}

	else if ($restricao == "faixa_etaria" and $faixa_etaria != "" and $tabela == "Voluntario"){
		$pesquisa = explode("-", $faixa_etaria);
		$sql .=" WHERE TIMESTAMPDIFF(YEAR, nascimento, CURDATE()) > '$pesquisa[0]' AND TIMESTAMPDIFF(YEAR,nascimento, CURDATE()) < '$pesquisa[1]'";
	}
	
	if ($atividade != "" and $tabela == "Acao" and $atividade != "Ambos"){

		$sql .=" AND acao.ativo = '$atividade'";
	}
		
	$result = mysqli_query($conn, $sql);

	while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
		$linha = [];
		
		foreach ($row as $valor) {
			array_push($linha, utf8_encode($valor));
		}
		
		$html[] = "<tr><td>" .
		implode("</td><td>", $linha) .
		"</td></tr>";
		
	}
		
	#Criacao da tabela + style
	$html = "<table class='table table-bordered'>" . implode("\n", $html) . "</tbody></table>";

	echo $html;
?>