<?php

require_once "lib/nusoap.php";

$inst_id = utf8_decode(htmlspecialchars($_GET["inst_id"]));
$volun_id = utf8_decode(htmlspecialchars($_GET["volun_id"]));

$client = new nusoap_client(
    'http://appserver-01.alunos.di.fc.ul.pt/~asw020/projetoASW/ws_infoAcaoVol_serv.php'
);

$error = $client->getError();
$result = $client->call('InfoAcaoVol', array('inst_id' => $inst_id, 'volun_id' => $volun_id));	//handle errors

if ($client->fault)
{   //check faults
}
else {    $error = $client->getError();		 //handle errors
   		 echo "<h2>$result</h2>";
}

?>