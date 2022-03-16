<?php
session_start();

include "openconn.php";

$utilizador = $_SESSION["utilizador"];
$volun_id = $_SESSION["ID"];

$inst_id = utf8_decode(htmlspecialchars($_GET["inst_id"]));

$query = "SELECT * FROM PL_Instituicao WHERE inst_id = '$inst_id'";

$resultado = mysqli_query($conn, $query);

if (mysqli_num_rows($resultado)>=1) {

    $row = mysqli_fetch_row($resultado);

    $nome = utf8_encode($row[1]);
    $telefone = utf8_encode($row[2]);
    $email = utf8_encode($row[3]);
    $email_representante = utf8_encode($row[4]);
    $nome_representante = utf8_encode($row[5]);
    $descricao = utf8_encode($row[6]);
    $morada = utf8_encode($row[7]);
    $distrito = utf8_encode($row[8]);
    $concelho = utf8_encode($row[9]);
    $freguesia = utf8_encode($row[10]);
    $senha = utf8_encode($row[11]);
    $website = utf8_encode($row[12]);
    $foto = utf8_encode($row[13]);
        
} else {
    echo "Erro: " . $query . "<br>" . mysqli_error($conn);

}

$html = '

    <button type="button" id="fechar_sobre_empresa" class="btn-close" aria-label="Close" onclick="fechar_sobre_empresa()"></button>

    <br>

    <div class="container text-center">
      <img id="avatarUtilizador" src="' . $foto . '" alt="Avatar">
    </div>

    <br><br>

    <div class="container text-center w-75">
      <div class="row">

        <div class="col-md-auto">
          <div class="form-check">
            <input type="checkbox" class="form-check-input big-checkbox" id="infos_da_empresa" checked="checked" onclick="onlyOneChecked5();">
            <label for="infos_da_empresa" class="form-check-label textoCheckbox2">PERFIL DA EMPRESA</label>
          </div>
        </div>

        <div id="coluna2" class="col-md-auto">
          <div class="form-check">
            <input type="checkbox" class="form-check-input big-checkbox" id="todas_acoes_da_empresa" onclick="onlyOneChecked6(); construir_apresentacao_acoes_empresa('.$inst_id.','.$volun_id.');">
            <label for="todas_acoes_da_empresa" class="form-check-label textoCheckbox2">AÇÕES DE VOLUNTARIADO DA EMPRESA</label>
          </div>
        </div>

      </div>
    </div>

    <br>

    <div class="container w-75">

      <h4>Dados principais</h4><br>

      <label for="nome_empresa" class="form-label">Nome da Empresa: </label>
      <input class="form-control" id="nome_empresa" type="text" value='.$nome.' readonly><br>

      <label for="email_empresa" class="form-label">Email da Empresa: </label>
      <input class="form-control" id="email_empresa" type="text" value='.$email.' readonly><br>

    </div>

    <hr class="my-4"> 

    <div class="container w-75">

      <h4>Dados da empresa</h4> <br>

      <label for="nome_representante_empresa" class="form-label">Nome Completo do representante da Empresa: </label>
      <input class="form-control" id="nome_representante_empresa" type="text" value='.$nome_representante.' readonly><br>

      <label for="email_representante_empresa" class="form-label">Email do representante da Empresa: </label>
      <input class="form-control" id="email_representante_empresa" type="text" value='.$email_representante.' readonly><br>

      <label for="telefone_empresa" class="form-label">Telefone da Empresa: </label>
      <input class="form-control" id="telefone_empresa" type="text" value='.$telefone.' readonly><br>

      <label for="descricao_empresa" class="form-label">Descrição da Empresa: </label>
      <input class="form-control" id="descricao_empresa" type="text" value='.$descricao.' readonly><br>

      <label for="morada_empresa" class="form-label">Morada da Empresa: </label>
      <input class="form-control" id="morada_empresa" type="text" value='.$morada.' readonly><br>

      <label for="distrito_empresa" class="form-label">Distrito da Empresa: </label>
      <input class="form-control" id="distrito_empresa" type="text" value='.$distrito.' readonly><br>

      <label for="concelho_empresa" class="form-label">Concelho da Empresa: </label>
      <input class="form-control" id="concelho_empresa" type="text" value='.$concelho.' readonly><br>

      <label for="freguesia_empresa" class="form-label">Freguesia da Empresa: </label>
      <input class="form-control" id="freguesia_empresa" type="text" value='.$freguesia.' readonly><br>

      <label for="website_empresa" class="form-label">Website da Empresa: </label>
      <input class="form-control" id="website_empresa" type="text" value='.$website.' readonly><br>

    </div>

    <br>

';

echo $html;

?>