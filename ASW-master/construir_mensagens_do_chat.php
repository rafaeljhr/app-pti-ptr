<?php

session_start();
include "openconn.php";
mysqli_set_charset($conn,"utf8");

if ($_SESSION["voluntario_ou_empresa"] == "perfil_empresa.php") {
	$me = "inst";
}else{
	$me = "volun";
}

$inst_id = htmlspecialchars($_GET["inst_id"]);
$volun_id = htmlspecialchars($_GET["volun_id"]);
$estado = htmlspecialchars($_GET["estado"]);

// Obter avatar e nome do voluntario
$query_avatar_voluntario = "SELECT username, foto FROM PL_Voluntario WHERE volun_id='$volun_id'";

$resultado_avatar_voluntario = mysqli_query($conn, $query_avatar_voluntario);

if (mysqli_num_rows($resultado_avatar_voluntario)>=1) {
    $row = mysqli_fetch_row($resultado_avatar_voluntario);
    $nome_voluntario = $row[0];
    $foto_voluntario = $row[1];
}

// Obter avatar e nome da instituicao
$query_avatar_instituicao = "SELECT nome, foto FROM PL_Instituicao WHERE inst_id='$inst_id'";

$resultado_avatar_instituicao = mysqli_query($conn, $query_avatar_instituicao);

if (mysqli_num_rows($resultado_avatar_instituicao)>=1) {
    $row = mysqli_fetch_row($resultado_avatar_instituicao);
    $nome_instituicao = $row[0];
    $foto_instituicao = $row[1];
}

$query = "SELECT id_mensagem, mensagem, sender
        FROM PL_Chat
        WHERE volun_id = '$volun_id' AND inst_id = '$inst_id' AND mensagem IS NOT NULL AND sender IS NOT NULL
        ORDER BY id_mensagem ASC";

$resultado = mysqli_query($conn, $query);



if ($estado == "inicial"){

	$html .= '<div class="cabecalho">';
	
	if ($_SESSION["voluntario_ou_empresa"] == "perfil_empresa.php") {
		$html .= '<h4 class="nome_da_pessoa_na_conversa">Chat com: '.$nome_voluntario.'</h4>';
	} else {
		$html .= '<h4 class="nome_da_pessoa_na_conversa">Chat com: '.$nome_instituicao.'</h4>';
	}
	$html .= '<button type="button" id="fechar_chat" class="btn-close" aria-label="Close" onclick="fechar_zona_conversa()"></button>';
	$html .= "</div><hr>";
	$html .= "<div id = 'div_chat_msg' class='chat_msg'><ul id='msg_chat'>";
}

if (mysqli_num_rows($resultado)>=1) {
    while ($row = mysqli_fetch_array($resultado, MYSQLI_NUM)) {

		
		
		if ($row[2] == $me){
			$html .= "<li class='me'>".$row[1]."</li>";
		}else{
			$html .= "<li class='him'>".$row[1]."</li>";
		}
    }
	if ($estado == "inicial"){
		$html .= "</ul></div>";
		$html .= '<div class="row h-20">
			<input type="text" id="mensagem_a_enviar">
			<img src="imagens/envio_msg.png" id="icon_envio_mensagem" onclick="enviar_mensagem (' . $inst_id . ', ' . $volun_id . ')">
		</div>';
	}
	
} else if ($estado == "inicial"){
    
    $html .= "<ul id='msg_chat'></ul></div>";
	$html .= '<div class="row h-20">
			<input type="text" id="mensagem_a_enviar">
			<img src="imagens/envio_msg.png" id="icon_envio_mensagem" onclick="enviar_mensagem (' . $inst_id . ', ' . $volun_id . ')">
		</div>';
}

echo $html;

?>