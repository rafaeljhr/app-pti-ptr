<?php
session_start();


if(!isset($_SESSION["mostrar_acoes_filtradas"])){
    $_SESSION["mostrar_acoes_filtradas"] = "sim";
}

if ($_SESSION["mostrar_acoes_filtradas"] == "nao") {
    $_SESSION["mostrar_acoes_filtradas"] = "sim";
}
    
header("Location: acoes_das_instituicoes.php");

?>