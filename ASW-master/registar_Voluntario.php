<?php
session_start();

$username = utf8_decode(htmlspecialchars($_POST["username"]));
$email = utf8_decode(htmlspecialchars($_POST["email"]));
$telefone = utf8_decode(htmlspecialchars($_POST["telefone"]));
$cartao_cidadao = utf8_decode(htmlspecialchars($_POST["cartao_cidadao"]));
$carta_conducao =utf8_decode( htmlspecialchars($_POST['simOuNao'][0]));
$genero = utf8_decode(htmlspecialchars($_POST['masculinoFeminino'][0]));
$nome =utf8_decode(htmlspecialchars($_POST["nome"]));
$freguesia = utf8_decode(htmlspecialchars($_POST["freguesia"]));
$concelho = utf8_decode(htmlspecialchars($_POST["concelho"]));
$distrito = utf8_decode(htmlspecialchars($_POST["distrito"]));
$data_nascimento = utf8_decode(htmlspecialchars($_POST["data_nascimento"]));
$foto = utf8_decode(htmlspecialchars($_POST["file"]));

// Encriptar a password
$password = password_hash(htmlspecialchars($_POST["password"]), PASSWORD_DEFAULT);

//ULPLOAD DA IMAGEM DE PERFIL
if ($_FILES['file']['size'] != 0) {

    $file = $_FILES['file'];
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png');

    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            $fileNameNew = uniqid().".".$fileActualExt;
            $fileDestination = __DIR__.'/imagens/fotosUtilizadores/'.$fileNameNew;
                
            move_uploaded_file($_FILES['file']['tmp_name'], $fileDestination);

            $foto = './imagens/fotosUtilizadores/'.$fileNameNew;

        } else {
            echo "Houve um erro a fazer upload do ficheiro, tente novamente!";
            $foto = './imagens/fotosUtilizadores/default_voluntario.png';
        }

    } else {
        echo "Não pode enviar ficheiros com esta extensão!";
        $foto = './imagens/fotosUtilizadores/default_voluntario.png';
    } 
} else {
    echo "Não foi dado upload de nenhuma foto <br>";
    $foto = './imagens/fotosUtilizadores/default_voluntario.png';
}


include "openconn.php";

$query = "INSERT INTO `PL_Voluntario` (`username`, `email`, `telefone`, `cartao_cidadao`, `carta_conducao`, `genero`, `nome`, `freguesia`, `concelho`, `distrito`, `senha`, `nascimento`, `foto`) 
VALUES ('$username', '$email', '$telefone', '$cartao_cidadao', '$carta_conducao', '$genero', '$nome', '$freguesia', '$concelho', '$distrito', '$password', '$data_nascimento', '$foto')";
               
$resultado = mysqli_query($conn, $query);

if ($resultado) {

    # saber id do voluntario recem registado
    $query_saber_id = "SELECT u.volun_id FROM PL_Voluntario u WHERE u.username='$username'";
    $resultado_saber_id = mysqli_query($conn, $query_saber_id);

    if (mysqli_num_rows($resultado_saber_id)>=1) {

        $row = mysqli_fetch_row($resultado_saber_id);
        $_SESSION["ID"] = $row[0];
        $_SESSION["utilizador"] = $username;
        $_SESSION["voluntario_ou_empresa"] = "perfil_voluntario.php";
        
        echo "ID: ".$_SESSION["ID"]. "<br>";
        echo "utilizador: ".$_SESSION["utilizador"]. "<br>";
        echo "voluntario_ou_empresa: ".$_SESSION["voluntario_ou_empresa"]. "<br>";
        header("Location: index.php");


    } else {

        echo "Houve um erro ao tentar obter o id do voluntário";

    }

} else {
echo "Erro: insert failed" . $query . "<br>" . mysqli_error($conn);
}
    
mysqli_close($conn);


?>