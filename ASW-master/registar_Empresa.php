<?php
session_start();

$nome_empresa = utf8_decode(htmlspecialchars($_POST["nome_empresa"]));
$telefone_empresa = utf8_decode(htmlspecialchars($_POST["telefone_empresa"]));
$email_empresa = utf8_decode(htmlspecialchars($_POST["email_empresa"]));
$email_representante_empresa = utf8_decode(htmlspecialchars($_POST["email_representante_empresa"]));
$nome_representante_empresa = utf8_decode(htmlspecialchars($_POST["nome_representante_empresa"]));
$descricao_empresa = utf8_decode(htmlspecialchars($_POST["descricao_empresa"]));
$morada_empresa = utf8_decode(htmlspecialchars($_POST["morada_empresa"]));
$distrito_empresa = utf8_decode(htmlspecialchars($_POST["distrito_empresa"]));
$concelho_empresa = utf8_decode(htmlspecialchars($_POST["concelho_empresa"]));
$freguesia_empresa = utf8_decode(htmlspecialchars($_POST["freguesia_empresa"]));

// Encriptar a password
$password_empresa = password_hash(htmlspecialchars($_POST["password_empresa"]), PASSWORD_DEFAULT);

$website_empresa = htmlspecialchars($_POST["website_empresa"]);
$foto_empresa = htmlspecialchars($_POST["file_empresa"]);


//ULPLOAD DA IMAGEM DE PERFIL
if ($_FILES['file_empresa']['size'] != 0) {

    $file = $_FILES['file_empresa'];
    $fileName = $_FILES['file_empresa']['name'];
    $fileTmpName = $_FILES['file_empresa']['tmp_name'];
    $fileSize = $_FILES['file_empresa']['size'];
    $fileError = $_FILES['file_empresa']['error'];
    $fileType = $_FILES['file_empresa']['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png');

    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            $fileNameNew = uniqid().".".$fileActualExt;
            $fileDestination = __DIR__.'/imagens/fotosUtilizadores/'.$fileNameNew;
                
            move_uploaded_file($_FILES['file_empresa']['tmp_name'], $fileDestination);

            $foto_empresa = './imagens/fotosUtilizadores/'.$fileNameNew;

        } else {
            echo "Houve um erro a fazer upload do ficheiro, tente novamente!";
            $foto_empresa = './imagens/fotosUtilizadores/default_empresa.jpg';
        }

    } else {
        echo "Não pode enviar ficheiros com esta extensão!";
        $foto_empresa = './imagens/fotosUtilizadores/default_empresa.jpg';
    } 
} else {
    echo "Não foi dado upload de nenhuma foto <br>";
    $foto_empresa = './imagens/fotosUtilizadores/default_empresa.jpg';
}


include "openconn.php";

$query = "INSERT INTO `PL_Instituicao` (`nome`, `telefone`, `email`, `email_representante`, `nome_representante`, `descricao`, `morada`, `distrito`, `concelho`, `freguesia`, `senha`, `website`, `foto`) 
VALUES ('$nome_empresa', '$telefone_empresa', '$email_empresa', '$email_representante_empresa', '$nome_representante_empresa', '$descricao_empresa', '$morada_empresa', '$distrito_empresa', '$concelho_empresa', '$freguesia_empresa', '$password_empresa', '$website_empresa', '$foto_empresa')";
               
$resultado = mysqli_query($conn, $query);

if ($resultado) {

    # saber id da empresa recem registada
    $query_saber_id = "SELECT e.inst_id FROM PL_Instituicao e WHERE e.nome='$nome_empresa'";
    $resultado_saber_id = mysqli_query($conn, $query_saber_id);

    if (mysqli_num_rows($resultado_saber_id)>=1) {

        $row = mysqli_fetch_row($resultado_saber_id);
        $_SESSION["ID"] = $row[0];
        $_SESSION["utilizador"] = $nome_empresa;
        $_SESSION["voluntario_ou_empresa"] = "perfil_empresa.php";
        header("Location: index.php");

    } else {

        echo "Houve um erro ao tentar obter o id do voluntário";

    }
} else {
echo "Erro: insert failed" . $query . "<br>" . mysqli_error($conn);
}
    
mysqli_close($conn);


?>