<?php
session_start();
//print_r($_SESSION);

include "openconn.php";

if ($_SESSION["voluntario_ou_empresa"] == "perfil_voluntario.php"){

	$volun_id = $_SESSION["ID"];

	if ($_SESSION["Estado_Area_Interesse"] == "options"){

		$query = "SELECT nome, area_int FROM PL_Areas_Interesse WHERE area_int NOT IN 
				(SELECT vi.area_int FROM PL_Volun_Interesse vi WHERE vi.volun_id = $volun_id)
				ORDER BY nome";

		$resultado = mysqli_query($conn, $query);

		if (mysqli_num_rows($resultado)>=1) {
			while ($row = mysqli_fetch_array($resultado, MYSQLI_NUM)) {
				
				echo "<option value='". utf8_encode($row[1]) . "'>" . utf8_encode($row[0]) . "</option>";
			}  
		}

	}
	else if($_SESSION["Estado_Area_Interesse"] == "areas_adicionadas"){
		
		$query = "SELECT nome, area_int FROM PL_Areas_Interesse WHERE area_int IN 
				(SELECT vi.area_int FROM PL_Volun_Interesse vi WHERE vi.volun_id = $volun_id)
				ORDER BY nome";

		$resultado = mysqli_query($conn, $query);

		if (mysqli_num_rows($resultado)>=1) {
			while ($row = mysqli_fetch_array($resultado, MYSQLI_NUM)) {
				
				echo "<div class='input-group p-2'>
						<input type='text' class='form-control' value = '". utf8_encode($row[0]) ."' disabled>
						<input type='hidden' name = 'area_adicionar_volun[]' value = '". utf8_encode($row[1]) ."'>
						<button class='btn btn-outline-danger' type='button' onclick='remover_area(this)'>X</button>
					  </div>";
			}  
		}
	} else {

		$query = "SELECT nome, area_int FROM PL_Areas_Interesse ORDER BY nome";

		$resultado = mysqli_query($conn, $query);

		echo "<option value='default' selected='selected'>Selecione uma opção</option>";

		if (mysqli_num_rows($resultado)>=1) {
			while ($row = mysqli_fetch_array($resultado, MYSQLI_NUM)) {
						
				echo "<option value='". utf8_encode($row[1]) . "'>" . utf8_encode($row[0]) . "</option>";
			}  
		}

	}
}
else{

	if ($_SESSION["Estado_Area_Interesse"] == "apresentar_default"){
		$query = "SELECT nome, area_int FROM PL_Areas_Interesse ORDER BY nome";

		$resultado = mysqli_query($conn, $query);

		echo "<option value='default' selected='selected'>Selecione uma opção</option>";

		if (mysqli_num_rows($resultado)>=1) {
			while ($row = mysqli_fetch_array($resultado, MYSQLI_NUM)) {
						
				echo "<option value='". utf8_encode($row[1]) . "'>" . utf8_encode($row[0]) . "</option>";
			}  
		}
	} else {
		$query = "SELECT nome, area_int FROM PL_Areas_Interesse ORDER BY nome";

		$resultado = mysqli_query($conn, $query);

		if (mysqli_num_rows($resultado)>=1) {
			while ($row = mysqli_fetch_array($resultado, MYSQLI_NUM)) {
						
				echo "<option value='". utf8_encode($row[1]) . "'>" . utf8_encode($row[0]) . "</option>";
			}  
		}
	}

		
}













