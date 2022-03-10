<?php
session_start();

include "openconn.php";

$usernameLogado = $_SESSION["utilizador"];

$info_atual_empresa = "SELECT * FROM PL_Instituicao i WHERE i.nome = '$usernameLogado'";

$resultado_info_atual = mysqli_query($conn, $info_atual_empresa);

if (mysqli_num_rows($resultado_info_atual)>=1) {

    $row = mysqli_fetch_row($resultado_info_atual);
    
    $atual_nome = $row[1];
    $atual_telefone = $row[2];
    $atual_email = $row[3];
    $atual_email_representante = $row[4];
    $atual_nome_representante = $row[5];
    $atual_descricao = $row[6];
    $atual_morada = $row[7];
    $atual_distrito = $row[8];
    $atual_concelho = $row[9];
    $atual_freguesia = $row[10];
    $atual_senha = $row[11];
    $atual_website = $row[12];
    $atual_foto = $row[13];

} else {
echo "Erro: Problema ao obter perfil da empresa " . $info_atual_empresa . "<br>" . mysqli_error($conn);
}


$nome = utf8_decode(htmlspecialchars($_POST["alterar_nome_empresa"]));
$telefone = utf8_decode(htmlspecialchars($_POST["alterar_telefone_empresa"]));
$email = utf8_decode(htmlspecialchars($_POST["alterar_email_empresa"]));
$email_representante = utf8_decode(htmlspecialchars($_POST["alterar_email_representante_empresa"]));
$nome_representante = utf8_decode(htmlspecialchars($_POST['alterar_nome_representante_empresa']));
$descricao = utf8_decode(htmlspecialchars($_POST['alterar_descricao_empresa']));
$morada =utf8_decode(htmlspecialchars($_POST["alterar_morada_empresa"]));
$distrito = utf8_decode(htmlspecialchars($_POST["alterar_distrito_empresa"]));
$concelho = utf8_decode(htmlspecialchars($_POST["alterar_concelho_empresa"]));
$freguesia = utf8_decode(htmlspecialchars($_POST["alterar_freguesia_empresa"]));
$website = utf8_decode(htmlspecialchars($_POST["alterar_website_empresa"]));
$foto = utf8_decode($atual_foto);

// Encripta a password
$password = password_hash(htmlspecialchars($_POST["password_empresa_registo"]), PASSWORD_DEFAULT);

if ($_POST["alterar_nome_empresa"] == "") { $nome =  $atual_nome; }
if ($_POST["alterar_telefone_empresa"] == "") { $telefone =  $atual_telefone; }
if ($_POST["alterar_email_empresa"] == "") { $email =  $atual_email; }
if ($_POST["alterar_email_representante_empresa"] == "") { $email_representante =  $atual_email_representante; }
if ($_POST["alterar_nome_representante_empresa"] == "") { $nome_representante =  $atual_nome_representante; }
if ($_POST["alterar_descricao_empresa"] == "") { $descricao =  $atual_descricao; }
if ($_POST["alterar_morada_empresa"] == "") { $morada =  $atual_morada; }
if ($_POST["alterar_distrito_empresa"] == "") { $distrito =  $atual_distrito; }
if ($_POST["alterar_concelho_empresa"] == "") { $concelho =  $atual_concelho; }
if ($_POST["alterar_freguesia_empresa"] == "") { $freguesia =  $atual_freguesia; }
if ($_POST["alterar_website_empresa"] == "") { $website =  $atual_website; }
if ($_POST["password_empresa_registo"] == "") { $password =  $atual_senha; }

//ULPLOAD DA IMAGEM DE PERFIL
if ($_FILES['alterar_file_empresa']['size'] != 0) {

    $file = $_FILES['alterar_file_empresa'];
    $fileName = $_FILES['alterar_file_empresa']['name'];
    $fileTmpName = $_FILES['alterar_file_empresa']['tmp_name'];
    $fileSize = $_FILES['alterar_file_empresa']['size'];
    $fileError = $_FILES['alterar_file_empresa']['error'];
    $fileType = $_FILES['alterar_file_empresa']['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png');

    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            $fileNameNew = uniqid().".".$fileActualExt;
            $fileDestination = __DIR__.'/imagens/fotosUtilizadores/'.$fileNameNew;
                
            move_uploaded_file($_FILES['alterar_file_empresa']['tmp_name'], $fileDestination);

            $foto = './imagens/fotosUtilizadores/'.$fileNameNew;

        } else {
            echo "Houve um erro a fazer upload do ficheiro, tente novamente!";
        }

    } else {
        echo "Não pode enviar ficheiros com esta extensão!";
    } 
} else {
    echo "Não foi dado upload de nenhuma foto <br>";
}


$query = "UPDATE PL_Instituicao
SET nome='$nome', telefone='$telefone', email='$email', email_representante='$email_representante',
nome_representante='$nome_representante', descricao='$descricao', morada='$morada', distrito='$distrito',
concelho='$concelho', freguesia='$freguesia', senha='$password', website='$website', foto='$foto'
WHERE nome = '$usernameLogado'";
               
$resultado = mysqli_query($conn, $query);

if ($resultado) {
    $_SESSION["utilizador"] = $nome;
    $_SESSION["voluntario_ou_empresa"] = "perfil_empresa.php";
    header("Location: perfil_empresa.php");
} else {
echo "Erro: update failed" . $query . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);


?>