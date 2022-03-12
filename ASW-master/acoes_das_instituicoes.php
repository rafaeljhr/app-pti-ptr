<?php
session_start();
// print_r($_SESSION);

?>

<!doctype html>
<html lang="pt">
    
  <head>
    <!-- Aceder ao site: -->
    <!-- Aceder à base de dados: http://appserver-01.alunos.di.fc.ul.pt/phpmyadmin/ -->

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    
    <link rel="stylesheet" href="css/style-acoes_das_instituicoes.css" type="text/css">
    <link rel="stylesheet" href="css/style-cssPartilhado.css" type="text/css">

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <script src="js/script-acoes_das_instituicoes.js"> </script>

    <link rel="icon" type="image/png" href="imagens/logo.png">
    <title>VoluntárioCOVID19</title>
  </head>

  <body>

    <!-- Container onde fica a barra de nav -->
    <?php

      include "template_navbar.php" ;

    ?>
    
	<!-- Image loader -->
	<div id='loader' style="display:none;">
		<img id="loader_img" src='imagens/load.gif'>
	</div>

    <div id="divImagem">
        <img src="imagens/6.jpg" id="imagem6">

        <div class="body_container">


			<div id="conjunto_ações">

				<!-- Filtrar as ações apresentadas -->
				<form class="filtrar_acoes_apresentadas" id="filtrar_acoes_apresentadas" method="post" onsubmit="return false">
							   
						<div class="row">
							<div class="col">
								<label for="freguesia" class="form-label">Freguesia: </label>
								<input class="form-control" id="freguesia" type="text" name="freguesia" onchange='filtrar_acoes_apresentadas()'>
							</div>

							<div class="col">
								<label for="concelho" class="form-label">Concelho: </label>
								<input class="form-control" id="concelho" type="text" name="concelho" onchange='filtrar_acoes_apresentadas()'>
							</div>

							<div class="col">
								<label for="distrito" class="form-label">Distrito: </label>
								<input class="form-control" id="distrito" type="text" name="distrito" onchange='filtrar_acoes_apresentadas()'>
							</div>

						</div>

						<div class="row">

							<div class="col">
								<label for="area_interesse" class="form-label mt-3">Áreas de Interesse</label>
								<select name="area_interesse" class="form-select" id="area_interesse" onchange='filtrar_acoes_apresentadas()'>
									<?php
										$_SESSION["Estado_Area_Interesse"] = "apresentar_default";
										include "areas_interesse.php";
									?>
								</select>
							</div>

							<div class="col">
								<label for="populacao_alvo" class="form-label mt-3">População alvo</label>
								<select name="populacao_alvo" class="form-select" id="populacao_alvo" onchange='filtrar_acoes_apresentadas()'>
								<?php
									$_SESSION["Estado_Populacao_Alvo"] = "apresentar_default";
									include "populacao_alvo.php";
								?>
								</select>
							</div>

							<div class="col">
								<?php
									$_SESSION["Estado_Horario"] = "apresentar_default";
									include "horario.php";
								?>

								<small class="smalls" id = "dia_da_semana_nao_definido">Ao escolher 1 período, tem de escolher 1 dia da semana!</small>
								<small class="smalls" id = "periodo_nao_definido">Ao escolher 1 dia da semana, tem de escolher 1 período!</small>
							</div>

						</div>

						<br>

						<!-- <div class="text-center zona_do_botao" id="botao_submeter_filtros">
							<input class="btn btn-primary btn-lg texto_botao" type="submit" value="APLICAR FILTROS!" onclick="filtrar_acoes_apresentadas()">
							<small class="smalls" id = "nenhum_filtro_selecionado">Não selecionou nenhum filtro!</small>
						</div> -->

				</form>

				<?php
					if ($_SESSION["utilizador"]) {
					
						if ($_SESSION["voluntario_ou_empresa"] == "perfil_voluntario.php") {

							if ($_SESSION["mostrar_acoes_filtradas"] == "nao") {
								echo '
									<form class="escolher_quais_acoes_mostrar" action="mostrar_filtradas_as_acoes.php" id="filtro_acoes2" method="post">
										<div class="container d-flex justify-content-around">
											<div class="row">

												<div class="col">
													<div class="form-check">
													<input type="checkbox" class="form-check-input big-checkbox" name="acoes_para_si" id="acoes_para_si2">
													<label class="form-check-label textoCheckbox">AÇÕES PARA SI</label>
													</div>
												</div>

												<div class="col">
													<div class="form-check">
													<input type="checkbox" class="form-check-input big-checkbox" name="todas_acoes" id="todas_acoes2" checked="checked">
													<label class="form-check-label textoCheckbox">TODAS AS AÇÕES</label>
													</div>
												</div>

												<div class="col mais_filtros">
													<div class="form-check">
													<input type="checkbox" class="form-check-input big-checkbox" id="mais_filtros2">
													<label class="form-check-label textoCheckbox">+ FILTROS</label>
													</div>
												</div>

											</div>
										</div>
									</form>
					
								';

								echo "<div id='acoes_mostradas'>";
								include 'construir_apresentacao_das_acoes_todas.php';
								echo "</div>";
								

							}
							else{
								echo '

									<form class="escolher_quais_acoes_mostrar" action="mostrar_todas_as_acoes.php" id="filtro_acoes" method="post">
										<div class="container d-flex justify-content-center">
											<div class="row">

												<div class="col">
													<div class="form-check">
													<input type="checkbox" class="form-check-input big-checkbox" name="acoes_para_si" id="acoes_para_si" checked="checked">
													<label class="form-check-label textoCheckbox">AÇÕES PARA SI</label>
													</div>
												</div>

												<div class="col">
													<div class="form-check">
													<input type="checkbox" class="form-check-input big-checkbox" name="todas_acoes" id="todas_acoes">
													<label class="form-check-label textoCheckbox">TODAS AS AÇÕES</label>
													</div>
												</div>

												<div class="col mais_filtros">
													<div class="form-check">
													<input type="checkbox" class="form-check-input big-checkbox" id="mais_filtros">
													<label class="form-check-label textoCheckbox">+ FILTROS</label>
													</div>
												</div>

											</div>
										</div>
									</form>
					
								';
								
								echo "<div id='acoes_mostradas'>";
								include 'construir_apresentacao_das_acoes_filtradas.php';
								echo "</div>";
							}

						} elseif ($_SESSION["voluntario_ou_empresa"] == "perfil_empresa.php") {

							if ($_SESSION["mostrar_todas_as_acoes_ativas"] == "nao") {
								echo '
									<form class="acoes_ativas_inativas" action="mostrar_acoes_ativas.php" id="filtro_acoes_empresa2" method="post">
										<div class="container d-flex justify-content-center">
											<div class="row">

												<div class="col">
													<div class="form-check">
													<input type="checkbox" class="form-check-input big-checkbox" id="acoes_ativas2">
													<label class="form-check-label textoCheckbox">AÇÕES ATIVAS</label>
													</div>
												</div>

												<div class="col">
													<div class="form-check">
													<input type="checkbox" class="form-check-input big-checkbox" id="acoes_inativas2" checked="checked">
													<label class="form-check-label textoCheckbox">AÇÕES INATIVAS</label>
													</div>
												</div>

												<div class="col mais_filtros">
													<div class="form-check">
													<input type="checkbox" class="form-check-input big-checkbox" id="mais_filtros2">
													<label class="form-check-label textoCheckbox">+ FILTROS</label>
													</div>
												</div>

											</div>
										</div>
									</form>

									<br>
									<br>
					
								';
				
								// Ações individuais
								include 'acoes_da_instituicao.php';

							} else {

								echo '
									<form class="acoes_ativas_inativas" action="mostrar_acoes_inativas.php" id="filtro_acoes_empresa" method="post">
										<div class="container d-flex justify-content-center">
											<div class="row">

												<div class="col">
													<div class="form-check">
													<input type="checkbox" class="form-check-input big-checkbox" name="acoes_ativas" id="acoes_ativas" checked="checked">
													<label class="form-check-label textoCheckbox">AÇÕES ATIVAS</label>
													</div>
												</div>

												<div class="col">
													<div class="form-check">
													<input type="checkbox" class="form-check-input big-checkbox" name="acoes_inativas" id="acoes_inativas">
													<label class="form-check-label textoCheckbox">AÇÕES INATIVAS</label>
													</div>
												</div>

												<div class="col mais_filtros">
													<div class="form-check">
													<input type="checkbox" class="form-check-input big-checkbox" id="mais_filtros">
													<label class="form-check-label textoCheckbox">+ FILTROS</label>
													</div>
												</div>

											</div>
										</div>
									</form>

									<br>
									<br>
					
								';
				
								// Ações individuais
								include 'acoes_da_instituicao.php';
							}
			
						}
					} else {
						echo "<div id='acoes_mostradas'>";
						include 'todas_acoes_bd.php';
						echo "</div>";
					}
            ?>
			</div>		
        </div>

		<div id="convidar_voluntarios" class="convidar_voluntarios" style="display: none;">
			
		</div>

		<div id="sobre_a_empresa_box" class="sobre_a_empresa_box" style="display: none;">
				
		</div>

		<div id="zona_do_chat" class="zona_do_chat" style="display: none;">
			<button type="button" id="fechar_chat" class="btn-close" aria-label="Close" onclick="fechar_chat()"></button>

			<div class='text-center chats'>
				<h3>OS SEUS CHATS</h3>
			</div>

			<div class='conversas' id='conversas'>

			</div>
				
		</div>

		<div id='zona_da_conversa' style="display: none;">
			

		</div>
        
    </div>

    <!-- As propriedades de footer desta página constam em style-cssPartilhado.css -->
    <div class="footer">
        <p id="footerP"><em> Voluntário COVID19 <br>  Desenvolvido por: Grupo 20 - Rafael Ribeiro, António Pereira, Gonçalo Miguel | <strong>Copyright©2021</strong> <br>
        Aplicação desenvolvida como parte integrante de um projeto FCUL.</em></p>
    </div>
    
  </body>

</html>