<?php

require_once "lib/nusoap.php";

include "openconn.php";


session_start();

$volun_id = $_SESSION["ID"];

$dbhost="appserver-01.alunos.di.fc.ul.pt";
$dbuser="asw020";	
$dbpass="aswrumoao20";	
$dbname="asw020";

$conn=mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

mysqli_set_charset($conn,"utf8");

$sql="SELECT username, senha FROM PL_Voluntario WHERE volun_id = $volun_id";

$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_array($result, MYSQLI_NUM);

$acao_id = htmlspecialchars($_GET["acao_id"]);

$utilizador = $row[0];
$senha = $row[1];

$client = new nusoap_client(
    'http://appserver-01.alunos.di.fc.ul.pt/~asw020/54956/Teste/ws_estado_candidatura_serv.php'
);

$error = $client->getError();
$result = $client->call('VolCandAcao', array('IDVol' => $volun_id, 'utilizador' => $utilizador, 'password' => $senha, 'IDAcao' => $acao_id));	//handle errors

if ($client->fault)
{   //check faults
}
else {    $error = $client->getError();		 //handle errors
   		// echo "Estado Final: $result";
}

?>