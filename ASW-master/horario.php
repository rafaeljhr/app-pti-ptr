<?php
session_start();
//print_r($_SESSION);

include "openconn.php";

if ($_SESSION["voluntario_ou_empresa"] == "perfil_voluntario.php"){
	
	$volun_id = $_SESSION["ID"];

	if ($_SESSION["Estado_Horario"] == "options"){
		
		$dias_semana = array("Segunda-Feira", "Terça-Feira", "Quarta-Feira", "Quinta-Feira", "Sexta-Feira", "Sábado", "Domingo");
		$periodo_dia = array("Manhã", "Tarde", "Noite");
		
		echo "<div class='row'>";
		echo "<div class='form-group col-lg-6'>";
		echo "<select name='dia_select' class='form-control form-select' id='dia_select'>";
		foreach ($dias_semana as $dia) {
			echo "<option value='". $dia . "'>" . $dia . "</option>";
		
		}
		echo "</select>";
		echo "</div>";
		echo "<div class='form-group col-lg-6'>";
		echo "<select name='periodo_select' class='form-control form-select' id='periodo_select'>";
		foreach ($periodo_dia as $periodo) {
			echo "<option value='". $periodo . "'>" . $periodo . "</option>";
		
		}
		echo "</select></div></div>";

	}
	else if($_SESSION["Estado_Horario"] == "horario_adicionado"){
		
		$query = "SELECT dia, periodo FROM PL_Volun_Horario WHERE volun_id = $volun_id
				ORDER BY CASE WHEN dia = 'Segunda-Feira' THEN '1'
				WHEN dia = 'Terça-Feira' THEN '2'
				WHEN dia = 'Quarta-Feira' THEN '3'
				WHEN dia = 'Quinta-Feira' THEN '4'
				WHEN dia = 'Sexta-Feira' THEN '5'
				WHEN dia = 'Sábado' THEN '6'
				WHEN dia = 'Domingo' THEN '7'
				ELSE 2 END,
				CASE WHEN periodo = 'Manhã' THEN '1'
				WHEN periodo = 'Tarde' THEN '2'
				WHEN periodo = 'Noite' THEN '3' END";

		$resultado = mysqli_query($conn, $query);

		if (mysqli_num_rows($resultado)>=1) {
			while ($row = mysqli_fetch_array($resultado, MYSQLI_NUM)) {
				
				echo "<div class='input-group p-2'>
						<input type='text' class='form-control' value = '". utf8_encode($row[0]) ."' disabled>
						<input type='text' class='form-control' value = '". utf8_encode($row[1]) ."' disabled>
						<input type='hidden' name = 'hora_adicionar_volun[]' value = '". utf8_encode($row[0]) ."'>
						<input type='hidden' name = 'periodo_adicionar_volun[]' value = '". utf8_encode($row[1]) ."'>
						<button class='btn btn-outline-danger' type='button' onclick='remover_horario(this)'>X</button>
					  </div>";
			}  
		}
	} else {
		$dias_semana = array("Selecione uma opção", "Segunda-Feira", "Terça-Feira", "Quarta-Feira", "Quinta-Feira", "Sexta-Feira", "Sábado", "Domingo");
		$periodo_dia = array("Selecione uma opção", "Manhã", "Tarde", "Noite");
		
		echo "<div class='row mt-3'>";
		echo "<div class='form-group col-lg-6'>";
		echo "<label class='form-label'>Dia da semana</label>";
		echo "<select name='dia_select' class='form-control form-select' id='dia_select' onchange='esconder_small_dia_da_semana(); filtrar_acoes_apresentadas()'>";
		foreach ($dias_semana as $dia) {
			if ($dia == "Selecione uma opção") {
				echo "<option value='default' selected='selected'>" . $dia . "</option>";
			} else {
				echo "<option value='". $dia . "'>" . $dia . "</option>";
			}
		
		}
		echo "</select>";
		echo "</div>";
		echo "<div class='form-group col-lg-6'>";
		echo "<label class='form-label'>Período</label>";
		echo "<select name='periodo_select' class='form-control form-select' id='periodo_select' onchange='esconder_small_periodo(); filtrar_acoes_apresentadas()'>";
		foreach ($periodo_dia as $periodo) {
			if ($periodo == "Selecione uma opção") {
				echo "<option value='default' selected='selected'>" . $periodo . "</option>";
			} else {
				echo "<option value='". $periodo . "'>" . $periodo . "</option>";
			}
		
		}
		echo "</select></div></div>";
	}
}
else{

	if ($_SESSION["Estado_Horario"] == "apresentar_default"){

		$dias_semana = array("Selecione uma opção", "Segunda-Feira", "Terça-Feira", "Quarta-Feira", "Quinta-Feira", "Sexta-Feira", "Sábado", "Domingo");
		$periodo_dia = array("Selecione uma opção", "Manhã", "Tarde", "Noite");
		
		echo "<div class='row mt-3'>";
		echo "<div class='form-group col-lg-6'>";
		echo "<label class='form-label'>Dia da semana</label>";
		echo "<select name='dia_select' class='form-control form-select' id='dia_select' onchange='esconder_small_dia_da_semana(); filtrar_acoes_apresentadas()'>";
		foreach ($dias_semana as $dia) {
			if ($dia == "Selecione uma opção") {
				echo "<option value='default' selected='selected'>" . $dia . "</option>";
			} else {
				echo "<option value='". $dia . "'>" . $dia . "</option>";
			}
		
		}
		echo "</select>";
		echo "</div>";
		echo "<div class='form-group col-lg-6'>";
		echo "<label class='form-label'>Período</label>";
		echo "<select name='periodo_select' class='form-control form-select' id='periodo_select' onchange='esconder_small_periodo(); filtrar_acoes_apresentadas()'>";
		foreach ($periodo_dia as $periodo) {
			if ($periodo == "Selecione uma opção") {
				echo "<option value='default' selected='selected'>" . $periodo . "</option>";
			} else {
				echo "<option value='". $periodo . "'>" . $periodo . "</option>";
			}
		
		}
		echo "</select></div></div>";
		
	} else {

		$dias_semana = array("Segunda-Feira", "Terça-Feira", "Quarta-Feira", "Quinta-Feira", "Sexta-Feira", "Sábado", "Domingo");
		$periodo_dia = array("Manhã", "Tarde", "Noite");
			
		echo "<div class='row'>";
		echo "<div class='form-group col-lg-6'>";
		echo "<select name='dia_select' class='form-control form-select' id='dia_select'>";
		foreach ($dias_semana as $dia) {
			echo "<option value='". $dia . "'>" . $dia . "</option>";
			
		}
		echo "</select>";
		echo "</div>";
		echo "<div class='form-group col-lg-6'>";
		echo "<select name='periodo_select' class='form-control form-select' id='periodo_select'>";
		foreach ($periodo_dia as $periodo) {
			echo "<option value='". $periodo . "'>" . $periodo . "</option>";
			
		}
		echo "</select></div></div>";

	}
	
		
}