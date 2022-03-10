<?php
session_start();
//print_r($_SESSION);

$utilizador = $_SESSION["utilizador"];
$volun_id = $_SESSION["ID"];

include "openconn.php";

# Obter foto do utilizador
$query_foto_utilizador = "SELECT foto FROM PL_Voluntario WHERE volun_id = '$volun_id'";

$resultado_foto_utilizador = mysqli_query($conn, $query_foto_utilizador);

if (mysqli_num_rows($resultado_foto_utilizador)>=1) {

    $row = mysqli_fetch_row($resultado_foto_utilizador);
    $foto = utf8_encode($row[0]);
        
}

# Todas as áreas de interesse do voluntario
$query_areas_interesse = "SELECT ai.nome
                          FROM PL_Areas_Interesse ai, PL_Volun_Interesse vi
                          WHERE vi.volun_id = '$volun_id' AND vi.area_int = ai.area_int";

$resultado_areas_interesse = mysqli_query($conn, $query_areas_interesse);

if (mysqli_num_rows($resultado_areas_interesse)>=1) {
	$HTML_areas_interesse = "";

	$a = 1;
	
    while ($row_areas_interesse = mysqli_fetch_array($resultado_areas_interesse, MYSQLI_NUM)) {

		$HTML_areas_interesse .= '
        <label for="area'.$a.'" class="form-label">Área de interesse '.$a.': </label>
        <input class="form-control" id="area'.$a.'" type="text" value="'.utf8_encode($row_areas_interesse[0]).'" readonly><br>
        ';
        $a++;
    }
}

# Todas as populações alvo do voluntario
$query_populacoes_alvo = "SELECT pa.nome
                          FROM PL_Populacao_Alvo pa, PL_Volun_Populacao_Alvo vpa
                          WHERE vpa.volun_id = '$volun_id' AND vpa.id_populacao_alvo =pa.id_populacao_alvo";

$resultado_populacoes_alvo = mysqli_query($conn, $query_populacoes_alvo);

if (mysqli_num_rows($resultado_populacoes_alvo)>=1) {
	
    $HTML_populacoes_alvo = "";
	$b = 1;
	
    while ($row_populacoes_alvo = mysqli_fetch_array($resultado_populacoes_alvo, MYSQLI_NUM)) {
		$HTML_populacoes_alvo .= '
        <label for="populacao'.$b.'" class="form-label">População alvo '.$b.': </label>
        <input class="form-control" id="populacao'.$b.'" type="text" value='.utf8_encode($row_populacoes_alvo[0]).' readonly><br>
        ';
        $b++;
    }      
}

# Todas as disponibilidades do voluntario
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

$resultado_disponibilidades = mysqli_query($conn, $query);

if (mysqli_num_rows($resultado_disponibilidades)>=1) {
	
	$HTML_disponibilidades = "";
	$c = 1;
	
    while ($row_disponibilidades = mysqli_fetch_array($resultado_disponibilidades, MYSQLI_NUM)) {

		$HTML_disponibilidades .= '
        <div class="row">

            <div class="col">
            <label for="dia_da_semana'.$c.'" class="form-label">Disponibilidade '.$c.': </label>
            <input class="form-control" id="dia_da_semana'.$c.'" type="text" value='.utf8_encode($row_disponibilidades[0]).' readonly>
            </div>

            <div class="col desde_ate2">
            <label  for="hora_inicio'.$c.'" class="form-label">Periodo</label>
            <input class="form-control" id="hora_inicio'.$c.'" type="text" name="desde'.$c.'" value='.utf8_encode($row_disponibilidades[1]).' readonly>
            </div>
        
        </div><br>';
        $c++;
    }       
}

# se o voluntario já registou alguma área de interesse / população alvo / disponibilidades
if (mysqli_num_rows($resultado_areas_interesse)>=1 and mysqli_num_rows($resultado_populacoes_alvo)>=1 and mysqli_num_rows($resultado_disponibilidades)>=1) {
    echo '
        <div class="container editar_interesses">
            
            <div class="container text-center">
                <img id="avatar" src="' . $foto . '" alt="Avatar">
            </div>

            <br>
            <br>

            <div class="container w-75">

                <h4>Áreas de interesse:</h4><br>

                '.$HTML_areas_interesse.'

            </div>

            <hr class="my-4"> 

            <div class="container w-75">

                <h4>Populações Alvo:</h4> <br>

                '.$HTML_populacoes_alvo.'

            </div>

            <hr class="my-4"> 

            <div class="container w-75">

                <h4>Disponibilidades:</h4> <br>

                '.$HTML_disponibilidades.'

            </div>

            <br>
            <br>

            <div class="container text-center">
                <a href="editar_areas_interesse_voluntario.php"><button class="btn btn-primary btn-lg">EDITAR</button></a>
            </div>

        </div>
        
        ';
} else {
    echo '
        <div class="container editar_interesses">
            
            <div class="container text-center">
                <img id="avatar" src="' . $foto . '" alt="Avatar">
            </div>

            <br>
            <br>

            <div class="container w-75">

                <h4>Áreas de interesse:</h4><br>

                <p>Sem áreas de interesse registadas ainda!</p>

            </div>

            <hr class="my-4"> 

            <div class="container w-75">

                <h4>Populações Alvo:</h4> <br>

                <p>Sem populações alvo registadas ainda!</p>

            </div>

            <hr class="my-4"> 

            <div class="container w-75">

                <h4>Disponibilidades:</h4> <br>

                <p>Sem disponibilidades registadas ainda!</p>

            </div>

            <br>
            <br>

            <div class="container text-center">
                <a href="editar_areas_interesse_voluntario.php"><button class="btn btn-primary btn-lg">CONFIGURAR</button></a>
            </div>

        </div>
        
        ';
}

?>