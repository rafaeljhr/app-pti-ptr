<?php
session_start();
// print_r($_SESSION);
$_SESSION["Estado_Horario"] = "";
$_SESSION["Estado_Area_Interesse"] = "";
$_SESSION["Estado_Populacao_Alvo"] = "";

?>

<!doctype html>
<html lang="pt">
    
  <head>
    <!-- Aceder ao site: http://appserver-01.alunos.di.fc.ul.pt/~asw020/projetoASW/ -->
    <!-- Aceder à base de dados: http://appserver-01.alunos.di.fc.ul.pt/phpmyadmin/ -->

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style-editar_criar_acoes_voluntariado.css" type="text/css">
    <link rel="stylesheet" href="css/style-cssPartilhado.css" type="text/css">

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <script src="js/script-editar_criar_acoes_voluntariado.js"> </script>

    <link rel="icon" type="image/png" href="imagens/logo.png">
    <title>VoluntárioCOVID19</title>
  </head>

  <body>

    <!-- Container onde fica a barra de nav -->
    <?php

      include "template_navbar.php" ;

    ?>

    <!-- As propriedades da classe corpo constam em style-cssPartilhado.css -->
    <div id="corpo">

        <div id="divImagem">
            <img src="imagens/4.jpg" id="imagem4">

            <form class="form-container" action="registar_acao.php" id="form_criar_acao" method="post" onsubmit="return verificar_inputs()">

                <div class="container w-75">

                    <h4>Informações Gerais da Ação de Voluntariado</h4>
                    <br>
                    <label for="nome_Acao" class="form-label">Nome da Ação: </label>
                    <input class="form-control" id="nome_Acao" type="text" name="nome_acao" required><br>

                    <label for="freguesia" class="form-label">Freguesia: </label>
                    <input class="form-control" id="freguesia" type="text" name="freguesia_acao" required><br>

                    <label for="concelho" class="form-label">Concelho: </label>
                    <input class="form-control" id="concelho" type="text" name="concelho_acao" required><br>

                    <label for="distrito" class="form-label">Distrito: </label>
                    <input class="form-control" id="distrito" type="text" name="distrito_acao" required><br>

                    <hr class="my-4">

                    <br>

                    <h4>Definir a Função principal da Ação de Voluntariado</h4>

                    <br>

                    <label for="funcao" class="form-label">Função da Ação: </label>
                    <input class="form-control" id="funcao" type="text" name="funcao_acao" required><br>

                    <hr class="my-4">

                    <h4>Número de Vagas Disponíveis</h4>

                    <br>

                    <div class="form-group">
                    <label for="quantidade"> Quantidade de Vagas </label><br>
                    <input type="number" name ="vagas_acao" class="form-control" min="1">
                    </div>

                    <br>

                    <hr class="my-4">

                    <h4>Deseja colocar a ação ativa ou inativa?</h4>

                    <br>
                    <br>

                    <div class="container d-flex justify-content-start">
                        <div class="row">

                            <div class="col">
                                <div class="form-check">
                                <input type="checkbox" class="form-check-input big-checkbox" name="acao_ativa_inativa[]" id="acao_ativa" value="sim" checked="checked">
                                <label class="form-check-label textoCheckbox">AÇÃO ATIVA</label>
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-check">
                                <input type="checkbox" class="form-check-input big-checkbox" name="acao_ativa_inativa[]" id="acao_inativa" value="nao">
                                <label class="form-check-label textoCheckbox">AÇÃO INATIVA</label>
                                </div>
                            </div>

                        </div>
                    </div>

                    <br>

                    <hr>

                    <h4>Definir as áreas de interesse da Ação de Voluntariado</h4>

                    <br>

                    <label for="area_interesse1" class="form-label">Área de interesse<a class="symbol">*</a></label>
                    <select name="areas_interesses" class='form-select' id="areas_interesses">
					<?php
						include "areas_interesse.php";
					?>
					</select>
					<br>
					<button type="button" class="float-right btn btn-success" name="add_area" id="add_area">Adicionar</button>
					<br><br>
					<div id = "areas_adicionadas" class="d-grid gap-3">
						<!-- areas adicionadas -->
					</div>
                    <small class="smalls" id = "area_interesse_nao_selecionada">Tem de adicionar pelo menos 1 área de interesse!</small>
                    <br>

                </div>

                <hr class="my-4"> 

                <div class="container w-75">

                    <h4>Definir a população alvo da Ação de Voluntariado</h4> 
                    
                    <br>

                    <label for="populacao_alvo1" class="form-label">População alvo<a class="symbol">*</a></label>
                   <select name="populacao_alvo" class='form-select' id="populacao_alvo">
					<?php
						include "populacao_alvo.php";
					?>
					</select>
					<br>
					<button type="button" class="float-right btn btn-success" name="add_populacao" id="add_populacao">Adicionar</button>
					<br><br>
					<div id = "populacoes_adicionadas" class="d-grid gap-3">
						<!-- Populacoes adicionadas -->
					</div>
                    <small class="smalls" id = "populacao_alvo_nao_selecionada">Tem de selecionar pelo menos 1 população alvo!</small>

                </div>

                <hr class="my-4"> 

                <div class="container w-75">

                    <h4>Definir data da Ação de Voluntariado</h4> 

                    <br>

                    <label class="form-label">Dia da semana <a class="symbol">*</a></label>
                    <?php
						$_SESSION["Estado_Horario"] = "options";
						include "horario.php";
					?>
					<br>
					<small class="smalls" id = "horarios_iguais">Não pode ter 2 horarios iguais!</small>
					<button type="button" class="float-right btn btn-success" name="add_horario" id="add_horario">Adicionar</button>
					</br></br>
					<div id = "horarios_adicionados" class="d-grid gap-3">

					</div>
					<small class="smalls" id = "horario_nao_adicionado">Tem de adicionar pelo menos 1 horário!</small>

                    <br>

                </div>

                <br>
                <br>

                <div class="zona_dos_botoes container d-flex justify-content-around">

                    <button class="btn btn-primary btn-lg" id="guardar">GUARDAR</button>

                </div>

            </form>
        
            </div>

        </div>   
    
    </div>
    
    <!-- As propriedades de footer desta página constam em style-cssPartilhado.css -->
    <div class="footer">
        <p><em> Voluntário COVID19 <br>  Desenvolvido por: Grupo 20 - Rafael Ribeiro, António Pereira, Gonçalo Miguel | <strong>Copyright©2021</strong> <br>
        Aplicação desenvolvida como parte integrante de um projeto FCUL.</em></p>
    </div>

  </body>

</html>