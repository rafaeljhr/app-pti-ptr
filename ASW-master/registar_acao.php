<?php
session_start();

include "openconn.php";

$id=$_SESSION["ID"];

$nome=utf8_decode(htmlspecialchars($_POST["nome_acao"]));
$freguesia=utf8_decode(htmlspecialchars($_POST["freguesia_acao"]));
$concelho=utf8_decode(htmlspecialchars($_POST["concelho_acao"]));
$distrito=utf8_decode(htmlspecialchars($_POST["distrito_acao"]));
$funcao=utf8_decode(htmlspecialchars($_POST["funcao_acao"]));
$vagas=utf8_decode(htmlspecialchars($_POST["vagas_acao"]));
$ativo = utf8_decode(htmlspecialchars($_POST['acao_ativa_inativa'][0]));

$registar_acao = "INSERT INTO `PL_Inst_Acoes` (`inst_id`,`nome`, `distrito`, `concelho`, `freguesia`, `funcao`, `numero_vagas`, `Ativo`)
VALUES ($id, '$nome', '$distrito', '$concelho', '$freguesia', '$funcao', $vagas, '$ativo')";

$resultado_registar_acao = mysqli_query($conn, $registar_acao);

$saber_id_da_acao_recem_criada = "SELECT acao_id FROM PL_Inst_Acoes 
                                  WHERE inst_id='$id' AND nome='$nome' AND distrito='$distrito' 
								  AND concelho='$concelho' AND freguesia='$freguesia' AND funcao='$funcao' 
								  AND numero_vagas='$vagas' AND Ativo='$ativo'";

$resultado_id_da_acao_recem_criada = mysqli_query($conn, $saber_id_da_acao_recem_criada);

if (mysqli_num_rows($resultado_id_da_acao_recem_criada)>=1) {
    
    $row = mysqli_fetch_row($resultado_id_da_acao_recem_criada);
    
    $acao_id = $row[0];
}

#daqui pra baixo, registar áreas de interesse, populações alvo e horários

$array_areas = $_POST["area_adicionar_volun"];
$array_pop_alvo = $_POST["populacao_adicionar_volun"];
$array_horario_dias = $_POST["hora_adicionar_volun"];
$array_horario_periodos = $_POST["periodo_adicionar_volun"];

#registar todas as áreas de interesse
foreach ($array_areas as $id_area_interesse){
	$query_area_interesse = "INSERT INTO PL_Inst_Interesse VALUES ($acao_id, $id_area_interesse)";
	mysqli_query($conn, $query_area_interesse);
}

#registar todas as populações alvo
foreach ($array_pop_alvo as $id_pop_alvo){
	$query_populacao_alvo = "INSERT INTO PL_Inst_Popul_Alvo VALUES ($acao_id, $id_pop_alvo)";
	mysqli_query($conn, $query_populacao_alvo);
}

#registar todos os horários da ação
for ($i = 0; $i < count($array_horario_dias); ++$i){
	
	$dia = utf8_decode($array_horario_dias[$i]);
	$periodo = utf8_decode($array_horario_periodos[$i]);
	
	$query_horario = "INSERT INTO PL_Acoes_Horario (acao_id, dia, periodo) VALUES ($acao_id, '$dia', '$periodo')";
	$resultado_registar_acao= mysqli_query($conn, $query_horario);

}

header("Location: acoes_das_instituicoes.php");

mysqli_close($conn);

?>  