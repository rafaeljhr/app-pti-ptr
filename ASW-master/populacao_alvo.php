<?php
session_start();
//print_r($_SESSION);

include "openconn.php";

if ($_SESSION["voluntario_ou_empresa"] == "perfil_voluntario.php"){
	
	$volun_id = $_SESSION["ID"];

	if ($_SESSION["Estado_Populacao_Alvo"] == "options"){

		$query = "SELECT nome, id_populacao_alvo FROM PL_Populacao_Alvo WHERE id_populacao_alvo NOT IN 
				(SELECT pa.id_populacao_alvo FROM PL_Volun_Populacao_Alvo pa WHERE pa.volun_id = $volun_id)
				ORDER BY nome";

		$resultado = mysqli_query($conn, $query);

		if (mysqli_num_rows($resultado)>=1) {
			while ($row = mysqli_fetch_array($resultado, MYSQLI_NUM)) {
				
				echo "<option value='". utf8_encode($row[1]) . "'>" . utf8_encode($row[0]) . "</option>";
			  }  
		}
	}
	else if($_SESSION["Estado_Populacao_Alvo"] == "populacao_adicionada"){
		
		$query = "SELECT nome, id_populacao_alvo FROM PL_Populacao_Alvo WHERE id_populacao_alvo IN 
				(SELECT pa.id_populacao_alvo FROM PL_Volun_Populacao_Alvo pa WHERE pa.volun_id = $volun_id)
				ORDER BY nome";

		$resultado = mysqli_query($conn, $query);

		if (mysqli_num_rows($resultado)>=1) {
			while ($row = mysqli_fetch_array($resultado, MYSQLI_NUM)) {
				
				echo "<div class='input-group p-2'>
						<input type='text' class='form-control' value = '". utf8_encode($row[0]) ."' disabled>
						<input type='hidden' name = 'populacao_adicionar_volun[]' value = '". utf8_encode($row[1]) ."'>
						<button class='btn btn-outline-danger' type='button' onclick='remover_populacao(this)'>X</button>
					  </div>";
			  }  
		}
	} else {
		$query = "SELECT nome, id_populacao_alvo FROM PL_Populacao_Alvo ORDER BY nome";

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

	if ($_SESSION["Estado_Populacao_Alvo"] == "apresentar_default"){
		$query = "SELECT nome, id_populacao_alvo FROM PL_Populacao_Alvo ORDER BY nome";

		$resultado = mysqli_query($conn, $query);

		echo "<option value='default' selected='selected'>Selecione uma opção</option>";

		if (mysqli_num_rows($resultado)>=1) {
			while ($row = mysqli_fetch_array($resultado, MYSQLI_NUM)) {
					
				echo "<option value='". utf8_encode($row[1]) . "'>" . utf8_encode($row[0]) . "</option>";
			}  
		}

	} else {
		$query = "SELECT nome, id_populacao_alvo FROM PL_Populacao_Alvo ORDER BY nome";

		$resultado = mysqli_query($conn, $query);

		if (mysqli_num_rows($resultado)>=1) {
			while ($row = mysqli_fetch_array($resultado, MYSQLI_NUM)) {
					
				echo "<option value='". utf8_encode($row[1]) . "'>" . utf8_encode($row[0]) . "</option>";
			}  
		}
	}
	
}