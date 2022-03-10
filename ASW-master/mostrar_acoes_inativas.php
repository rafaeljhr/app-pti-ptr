<?php
session_start();


if(!isset($_SESSION["mostrar_todas_as_acoes_ativas"])){
    $_SESSION["mostrar_todas_as_acoes_ativas"] = "nao";
}

if ($_SESSION["mostrar_todas_as_acoes_ativas"] == "sim") {
    $_SESSION["mostrar_todas_as_acoes_ativas"] = "nao";
}
    
header("Location: acoes_das_instituicoes.php");

?>