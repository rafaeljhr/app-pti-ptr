<?php
session_start();


if(!isset($_SESSION["mostrar_todas_as_acoes_ativas"])){
    $_SESSION["mostrar_todas_as_acoes_ativas"] = "sim";
}

if ($_SESSION["mostrar_todas_as_acoes_ativas"] == "nao") {
    $_SESSION["mostrar_todas_as_acoes_ativas"] = "sim";
}
    
header("Location: acoes_das_instituicoes.php");

?>