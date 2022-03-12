<?php
session_start();


if(!isset($_SESSION["mostrar_acoes_filtradas"])){
    $_SESSION["mostrar_acoes_filtradas"] = "nao";
}

if ($_SESSION["mostrar_acoes_filtradas"] == "sim") {
    $_SESSION["mostrar_acoes_filtradas"] = "nao";
}
    
header("Location: acoes_das_instituicoes.php");

?>