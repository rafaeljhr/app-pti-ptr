<!doctype html>
<?php 
	session_start();
	if (!isset($_SESSION["Admin"]) || $_SESSION["Admin"] == ""){
		header("Location: logout_admin.php");
	}
?>

<html lang="pt">
    
	<head>
		<title>Admin</title>
		<meta charset="UTF-8" />
		
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" 
		integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" 
		crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="css/admin.css">
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" 
		integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" 
		integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" 
		integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
		<script type="text/javascript" src="js/admin_panel.js"></script>
	</head>

	<body>
		
		<a href="logout_admin.php"><button type="button" class="btn btn-secondary butao_logout">Sair</button></a>
		
		<form class="form-pesquisa" method="post">
			<div class="form-check form-check-inline">
			  <input class="form-check-input" type="radio" id="Procura_Vol" value="Voluntario" name="tabela_procura" required checked>
			  <label class="form-check-label" for="Procura_Vol">Voluntário</label>
			</div>
			<div class="form-check form-check-inline">
			  <input class="form-check-input" type="radio" id="Procura_Inst" value="Instituicao" name="tabela_procura">
			  <label class="form-check-label" for="Procura_Inst">Instituição</label>
			</div>
			<div class="form-check form-check-inline">
			  <input class="form-check-input" type="radio" id="Procura_Acao" value="Acao" name="tabela_procura">
			  <label class="form-check-label" for="Procura_Acao">Ações</label>
			</div>
			<br><br>
			<div class="form-group">
				<input type="text" class="form-control" name="alvo_procura" placeholder="" id="alvo_procura">
			</div>
			<div class="form-check form-check-inline">
			  <input class="form-check-input" type="radio" id="inlineRadio1" value="nome" name="opcao" required checked>
			  <label class="form-check-label" for="inlineRadio1">Nome</label>
			</div>
			<div class="form-check form-check-inline">
			  <input class="form-check-input" type="radio" id="inlineRadio2" value="email" name="opcao">
			  <label class="form-check-label" for="inlineRadio2">Email</label>
			</div>
			<div class="form-check form-check-inline">
			  <input class="form-check-input" type="radio" id="inlineRadio3" value="concelho" name="opcao">
			  <label class="form-check-label" for="inlineRadio3">Concelho</label>
			</div>
			<div class="form-check form-check-inline">
			  <input class="form-check-input" type="radio" id="inlineRadio4" value="distrito" name="opcao">
			  <label class="form-check-label" for="inlineRadio4">Distrito</label>
			</div>
			<br><br>
			<div class="form-check form-check-inline" id="Form_Faixa_Etaria" style="display: none;">
				<input class="form-check-input" type="radio" id="inlineRadio5" value="faixa_etaria" name="opcao">
			    <label class="form-check-label" for="inlineRadio5">Faixa Etária</label>
				&nbsp;&nbsp;
				<select class="form-check-input" name="faixa_etaria" id="faixa_etaria">
					<option value="18-30">18-30</option>
					<option value="31-40">31-40</option>
					<option value="41-50">41-50</option>
					<option value="51-60">51-60</option>
					<option value="61-70">61-70</option>
					<option value="71-80">71-80</option>
					<option value="81+">81+</option>
				</select>
			</div>
			<div id = "acao_atividade" style="display: none">
				<div class="form-check form-check-inline">
				  <input class="form-check-input" type="radio" id="acao_ativo" value="Sim" name="opcao_atividade" required checked>
				  <label class="form-check-label" for="acao_ativo">Ativo</label>
				</div>
				<div class="form-check form-check-inline">
				  <input class="form-check-input" type="radio" id="acao_inativo" value="Nao" name="opcao_atividade">
				  <label class="form-check-label" for="acao_inativo">Inativo</label>
				</div>
				<div class="form-check form-check-inline">
				  <input class="form-check-input" type="radio" id="acao_ativo_inativo" value="Ambos" name="opcao_atividade">
				  <label class="form-check-label" for="acao_ativo_inativo">Ativo/Inativo</label>
				</div>
			</div>
			<br><br>
			<button type="submit" class="btn btn-primary btn-block" name="submit">Procurar</button>
		</form>
		<div class="div_resultado">
			<div class="resultado_procura" id="resultado_procura">
					
			</div>
		</div>
	</body>
</html>