<?php
include "openconn.php";

$data = [];

// Voluntario
$Volun_info = [];

$email = [];
$cartao_cidadao = [];
$username = [];
$telefone = [];

$query = "SELECT email, cartao_cidadao, username, telefone FROM PL_Voluntario";

$resultado = mysqli_query($conn, $query);

while($row = mysqli_fetch_assoc($resultado)) {
	array_push($email, utf8_encode($row["email"]));
	array_push($cartao_cidadao, utf8_encode($row["cartao_cidadao"]));
	array_push($username, utf8_encode($row["username"]));
	array_push($telefone, utf8_encode($row["telefone"]));
}

array_push($Volun_info, $email, $cartao_cidadao, $username, $telefone);

// Instituicao
$Inst_info = [];

$nome = [];
$telefone_inst = [];
$email_inst = [];
$email_repre_inst = [];

$query = "SELECT nome, telefone, email, email_representante FROM PL_Instituicao";

$resultado = mysqli_query($conn, $query);

while($row = mysqli_fetch_assoc($resultado)) {
	array_push($nome, utf8_encode($row["nome"]));
	array_push($telefone_inst, utf8_encode($row["telefone"]));
	array_push($email_inst, utf8_encode($row["email"]));
	array_push($email_repre_inst, utf8_encode($row["email_representante"]));
}

array_push($Inst_info, $nome, $telefone_inst, $email_inst, $email_repre_inst);

array_push($data, $Volun_info, $Inst_info);

$data = json_encode($data);

?>