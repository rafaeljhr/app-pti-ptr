<?php
session_start();

include "openconn.php";

$usernameLogado = $_SESSION["utilizador"];

$info_atual_utilizaodor = "SELECT * FROM PL_Voluntario v WHERE v.username = '$usernameLogado'";

$resultado_info_atual = mysqli_query($conn, $info_atual_utilizaodor);

if (mysqli_num_rows($resultado_info_atual)>=1) {
    
    $row = mysqli_fetch_row($resultado_info_atual);
    
    $atual_username = $row[1];
    $atual_senha = $row[2];
    $atual_email = $row[3];
    $atual_telefone = $row[4];
    $atual_cartao_cidadao = $row[5];
    $atual_carta_conducao = $row[6];
    $atual_genero = $row[7];
    $atual_nome = $row[8];
    $atual_freguesia = $row[9];
    $atual_concelho = $row[10];
    $atual_distrito = $row[11];
    $atual_nascimento = $row[12];
    $atual_foto = $row[13];

} else {
echo "Erro: Problema ao obter perfil do voluntário " . $info_atual_utilizaodor . "<br>" . mysqli_error($conn);
}

$username = utf8_decode(htmlspecialchars($_POST["alterar_username"]));
$email = utf8_decode(htmlspecialchars($_POST["alterar_email"]));
$telefone = utf8_decode(htmlspecialchars($_POST["alterar_telefone"]));
$cartao_cidadao = utf8_decode(htmlspecialchars($_POST["alterar_cartao_cidadao"]));
$carta_conducao = utf8_decode(htmlspecialchars($_POST['simOuNao'][0]));
$genero = utf8_decode(htmlspecialchars($_POST['masculinoFeminino'][0]));
$nome = utf8_decode(htmlspecialchars($_POST["alterar_nome"]));
$freguesia = utf8_decode(htmlspecialchars($_POST["alterar_freguesia"]));
$concelho = utf8_decode(htmlspecialchars($_POST["alterar_concelho"]));
$distrito = utf8_decode(htmlspecialchars($_POST["alterar_distrito"]));
$data_nascimento = utf8_decode(htmlspecialchars($_POST["alterar_data_nascimento"]));
$foto = utf8_decode($atual_foto);

// Encripta a password
$password = password_hash(htmlspecialchars($_POST["password_voluntario"]), PASSWORD_DEFAULT);

if ($_POST['simOuNao'][0] == "") { $carta_conducao =  $atual_carta_conducao ;}
if ($_POST['masculinoFeminino'][0] == "") { $genero =  $atual_genero ;}

//ULPLOAD DA IMAGEM DE PERFIL
if ($_FILES['alterar_file_voluntario']['size'] != 0) {

    $file = $_FILES['alterar_file_voluntario'];
    $fileName = $_FILES['alterar_file_voluntario']['name'];
    $fileTmpName = $_FILES['alterar_file_voluntario']['tmp_name'];
    $fileSize = $_FILES['alterar_file_voluntario']['size'];
    $fileError = $_FILES['alterar_file_voluntario']['error'];
    $fileType = $_FILES['alterar_file_voluntario']['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png');

    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            $fileNameNew = uniqid().".".$fileActualExt;
            $fileDestination = __DIR__.'/imagens/fotosUtilizadores/'.$fileNameNew;
                
            move_uploaded_file($_FILES['alterar_file_voluntario']['tmp_name'], $fileDestination);

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

$query = "UPDATE PL_Voluntario
SET username='$username', email='$email', telefone='$telefone', cartao_cidadao='$cartao_cidadao',
carta_conducao='$carta_conducao', genero='$genero', nome='$nome', freguesia='$freguesia',
concelho='$concelho', distrito='$distrito', senha='$password', nascimento='$data_nascimento', 
foto='$foto'
WHERE username = '$usernameLogado'";
               
$resultado = mysqli_query($conn, $query);

if ($resultado) {
    $_SESSION["utilizador"] = $username;
    $_SESSION["voluntario_ou_empresa"] = "perfil_voluntario.php";
    header("Location: perfil_voluntario.php");
} else {
echo "Erro: update failed " . $query . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);


?>