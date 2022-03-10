<?php
session_start();

include "openconn.php";

$id_volun = $_SESSION["ID"]; 
$array_areas = $_POST["area_adicionar_volun"];
$array_pop_alvo = $_POST["populacao_adicionar_volun"];
$array_horario_dias = $_POST["hora_adicionar_volun"];
$array_horario_periodos = $_POST["periodo_adicionar_volun"];

$delete_interesses = "DELETE FROM PL_Volun_Interesse WHERE volun_id = $id_volun";
$delete_pop_alvo = "DELETE FROM PL_Volun_Populacao_Alvo WHERE volun_id = $id_volun";
$delete_horario = "DELETE FROM PL_Volun_Horario WHERE volun_id = $id_volun";

mysqli_query($conn, $delete_interesses);
mysqli_query($conn, $delete_pop_alvo);
mysqli_query($conn, $delete_horario);

foreach ($array_areas as $id_area_interesse){
	$query_area_interesse = "INSERT INTO PL_Volun_Interesse VALUES ($id_area_interesse, $id_volun)";
	mysqli_query($conn, $query_area_interesse);
}

foreach ($array_pop_alvo as $id_pop_alvo){
	$query_populacao_alvo = "INSERT INTO PL_Volun_Populacao_Alvo VALUES ($id_pop_alvo, $id_volun)";
	mysqli_query($conn, $query_populacao_alvo);
}

for ($i = 0; $i < count($array_horario_dias); ++$i){
	
	$dia = utf8_decode($array_horario_dias[$i]);
	$periodo = utf8_decode($array_horario_periodos[$i]);
	
	$query_horario = "INSERT INTO PL_Volun_Horario (volun_id, dia, periodo) VALUES ($id_volun, '$dia', '$periodo')";
	mysqli_query($conn, $query_horario);
}

header("Location: areas_interesse_voluntario.php");

mysqli_close($conn);

?>