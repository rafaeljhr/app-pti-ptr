<?php

require_once "lib/nusoap.php";

function VolCandAcao($IDVol, $utilizador, $password, $IDAcao)  {

	$dbhost="appserver-01.alunos.di.fc.ul.pt";
	$dbuser="asw020";	
	$dbpass="aswrumoao20";	
	$dbname="asw020";

	//Cria a ligação à BD
	$conn=mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

	//Verifica a ligação à BD
	if(mysqli_connect_error()){die("Database connection failed:".mysqli_connect_error());}

	$sql="SELECT estado FROM PL_Inst_Acoes_Volun_Candidato WHERE volun_id = $IDVol AND acao_id = $IDAcao";

	$result=mysqli_query($conn,$sql);

	if (mysqli_num_rows($result)>=1) {
		
		$estado = mysqli_fetch_array($result, MYSQLI_NUM);
		
		if ($estado[0] == "aceite"){
			$sql="SELECT numero_vagas, Ativo FROM PL_Inst_Acoes WHERE acao_id = $IDAcao";
			$result=mysqli_query($conn,$sql);
			$acao = mysqli_fetch_array($result, MYSQLI_NUM);
			if ($acao[0] > 0 AND $acao[1] == "sim"){
			
				$vagas = $acao[0]-1;
				
				$sql = "UPDATE PL_Inst_Acoes_Volun_Candidato SET estado='aceite-aceite' WHERE volun_id = $IDVol AND acao_id = $IDAcao";
				$sql2 = "UPDATE PL_Inst_Acoes SET numero_vagas=$vagas WHERE acao_id = $IDAcao";
				
				$resultado = mysqli_query($conn, $sql);
				$resultado = mysqli_query($conn, $sql2);
				
				return "aceite";
			}
			else{
				$sql = "UPDATE PL_Inst_Acoes_Volun_Candidato SET estado='nao_aceite' WHERE volun_id = $IDVol AND acao_id = $IDAcao";
				$resultado = mysqli_query($conn, $sql);
			}
		}
	}
	return "Não Aceite";
}


$server = new soap_server();

$server->configureWSDL('cumpwsdl', 'urn:cumpwsdl');

$server->register("VolCandAcao", // nome metodo
array('acao_id' => 'xsd:string'), // input
array('return' => 'xsd:string'), // output
	'uri:cumpwsdl', // namespace
	'urn:cumpwsdl#VolCandAcao', // SOAPAction
	'rpc', // estilo
	'encoded' // uso
);

@$server->service(file_get_contents("php://input"));
?>