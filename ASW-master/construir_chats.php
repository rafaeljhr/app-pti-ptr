<?php

session_start();

include "openconn.php";

mysqli_set_charset($conn,"utf8");

$inst_id = htmlspecialchars($_GET["inst_id"]);
$volun_id = htmlspecialchars($_GET["volun_id"]);

if($_SESSION["voluntario_ou_empresa"] == "perfil_empresa.php") {
    $query = "SELECT volun_id
        FROM PL_Chat
        WHERE inst_id = '$inst_id' GROUP BY volun_id";
        
} else {
    $query = "SELECT inst_id
        FROM PL_Chat
        WHERE volun_id = '$volun_id' GROUP BY inst_id";
}

$resultado = mysqli_query($conn, $query);

if (mysqli_num_rows($resultado)>=1) {

    $chats = array();

    while ($row = mysqli_fetch_array($resultado, MYSQLI_NUM)) {
        array_push($chats, $row[0]);
    }
	
	if($_SESSION["voluntario_ou_empresa"] == "perfil_empresa.php") {
		if( !in_array( $volun_id , $chats ) ) {

			array_push($chats, $volun_id);
			
			$query3 = "INSERT INTO PL_Chat (volun_id, inst_id) VALUES ('$volun_id', '$inst_id')";

			$resultado3 = mysqli_query($conn, $query3);
		} 
	}
	else{
		if( !in_array( $inst_id , $chats ) ) {

			array_push($chats, $inst_id);
			
			$query3 = "INSERT INTO PL_Chat (volun_id, inst_id) VALUES ('$volun_id', '$inst_id')";

			$resultado3 = mysqli_query($conn, $query3);
		} 
	}
    $html ='';

    foreach ($chats as $chat) {

        if($_SESSION["voluntario_ou_empresa"] == "perfil_empresa.php") {
            // Obter avatar e nome
            $query_avatar = "SELECT volun_id, username, foto FROM PL_Voluntario WHERE volun_id='$chat'";
            
            $resultado_avatar = mysqli_query($conn, $query_avatar);

            if (mysqli_num_rows($resultado_avatar)>=1) {
                $row = mysqli_fetch_row($resultado_avatar);
                $id_a_usar = $row[0];
                $nome = $row[1];
                $foto = $row[2];
            }

            $html .= '<div class="container conversa" onclick="contruir_a_conversa('.$inst_id.', '.$id_a_usar.');">
                    <div class="infos_janela_chat">
                        <img class="avatar_conversa" src="'.$foto.'">
                        <p class="nome_da_empresa_chat">'.$nome.'</p>
                    </div>
                </div>';
                
        } else {
            // Obter avatar e nome
            $query_avatar = "SELECT inst_id, nome, foto FROM PL_Instituicao WHERE inst_id='$chat'";

            $resultado_avatar = mysqli_query($conn, $query_avatar);

            if (mysqli_num_rows($resultado_avatar)>=1) {
                $row = mysqli_fetch_row($resultado_avatar);
                $id_a_usar = $row[0];
                $nome = $row[1];
                $foto = $row[2];
            }

            $html .= '<div class="container conversa" onclick="contruir_a_conversa('.$id_a_usar.', '.$volun_id.');">
                    <div class="infos_janela_chat">
                        <img class="avatar_conversa" src="'.$foto.'">
                        <p class="nome_da_empresa_chat">'.$nome.'</p>
                    </div>
                </div>';
        }

        
    }

    echo $html;

} else {

    $query2 = "INSERT INTO PL_Chat (volun_id, inst_id) VALUES ('$volun_id', '$inst_id')";
   
    $resultado2 = mysqli_query($conn, $query2);

    if($_SESSION["voluntario_ou_empresa"] == "perfil_empresa.php") {
        // Obter avatar e nome
        $query_avatar = "SELECT username, foto FROM PL_Voluntario WHERE volun_id='$volun_id'";

        $resultado_avatar = mysqli_query($conn, $query_avatar);

        if (mysqli_num_rows($resultado_avatar)>=1) {
            $row = mysqli_fetch_row($resultado_avatar);
            $nome = $row[0];
            $foto = $row[1];
        }
            
    } else {
        // Obter avatar e nome
        $query_avatar = "SELECT nome, foto FROM PL_Instituicao WHERE inst_id='$inst_id'";

        $resultado_avatar = mysqli_query($conn, $query_avatar);

        if (mysqli_num_rows($resultado_avatar)>=1) {
            $row = mysqli_fetch_row($resultado_avatar);
            $nome = $row[0];
            $foto = $row[1];
        }
    }

    $html = '<div class="container conversa" onclick="contruir_a_conversa('.$inst_id.', '.$volun_id.');">
                    <div class="infos_janela_chat">
                        <img class="avatar_conversa" src="'.$foto.'">
                        <p class="nome_da_empresa_chat">'.$nome.'</p>
                    </div>
                </div>';

    echo $html;
}

?>