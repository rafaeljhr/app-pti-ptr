<?php

	$alvo = htmlspecialchars($_POST['alvo_procura']);
	$restricao = htmlspecialchars($_POST['opcao']);
	$tabela = htmlspecialchars($_POST['tabela_procura']);
	$faixa_etaria = htmlspecialchars($_POST['faixa_etaria']);
	
	$_SESSION["tabela_procura"] = $tabela;
	$_SESSION["opcao"] = $restricao;
	
	echo $_SESSION["opcao"];
	
	if ($tabela == "Voluntario" or $tabela == ""){
		$sql = "SELECT volun_id, username, email, telefone, cartao_cidadao, carta_conducao, genero, 
			nome, freguesia, concelho, distrito, nascimento FROM PL_Voluntario";
			
		$html[] = "<thead class='thead-light'><tr> <th scope='col'>ID</th> <th scope='col'>Username</th> <th scope='col'>Email</th> <th scope='col'>Telefone</th> 
			<th scope='col'>Cartao Cidadao</th> <th scope='col'>Carta Conducao</th> <th scope='col'>Genero</th><th scope='col'>Nome</th>
			<th scope='col'>Freguesi</th> <th scope='col'>Concelho</th> <th scope='col'>Distrito</th> <th scope='col'>Nascimento</th></tr></thead><tbody>";
	}
	else if($tabela == "Instituicao"){
		$sql = "SELECT inst_id, nome, telefone, email, nome_representante, email_representante, morada, 
			distrito, concelho, freguesia FROM PL_Instituicao";
			
		$html[] = "<thead class='thead-light'><tr> <th scope='col'>ID</th> <th scope='col'>Nome</th> <th scope='col'>Telefone</th> <th scope='col'>Email</th> 
		<th scope='col'>Nome Representante</th> <th scope='col'>Email Representante</th> <th scope='col'>Morada</th> <th scope='col'>Distrito</th> 
		<th scope='col'>Concelho</th> <th scope='col'>Freguesia</th></tr></thead><tbody>";
	}
	
	if ($alvo != "" and $restricao != "faixa_etaria"){
		$procura = "%".$alvo."%";
		
		$sql .=" WHERE $restricao LIKE '$procura'";
			
	}
	
	else if ($restricao == "faixa_etaria" and $faixa_etaria != ""){
		$pesquisa = explode("-", $faixa_etaria);
		$sql .=" WHERE TIMESTAMPDIFF(YEAR, nascimento, CURDATE()) > '$pesquisa[0]' AND TIMESTAMPDIFF(YEAR,nascimento, CURDATE()) < '$pesquisa[1]'";
	}


	include "openconn.php";
				
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
			
	echo $_SESSION["html"];
?>