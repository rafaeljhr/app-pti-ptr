<?php
session_start();
//print_r($_SESSION);

include "openconn.php";
mysqli_set_charset($conn,"utf8");

$utilizador = $_SESSION["utilizador"];
$inst_id = $_SESSION["ID"];

if ($_SESSION["mostrar_todas_as_acoes_ativas"] == "nao") {

    # Todas as acoes da instituicao
    $query_acoes_instituicao = "SELECT acao_id, nome, distrito, concelho, freguesia, funcao, numero_vagas, Ativo
    FROM PL_Inst_Acoes
    WHERE inst_id='$inst_id' AND Ativo='nao'";

    

} else {
    # Todas as acoes da instituicao
    $query_acoes_instituicao = "SELECT acao_id, nome, distrito, concelho, freguesia, funcao, numero_vagas, Ativo
    FROM PL_Inst_Acoes
    WHERE inst_id='$inst_id' AND Ativo='sim'";
}


$resultado_acoes_instituicao = mysqli_query($conn, $query_acoes_instituicao);

if (mysqli_num_rows($resultado_acoes_instituicao)>=1) {

    $acoes_instituicao = array();

    while ($row_acoes_instituicao = mysqli_fetch_array($resultado_acoes_instituicao, MYSQLI_NUM)) {
        $acoes_instituicao[] = $row_acoes_instituicao;
    }

    $HTML_todas_acoes_instituicao = "";

    foreach ($acoes_instituicao as $acao){
		
		$acao_info = array();
        
        // Obter areas interesse da acao
        $query_acoes_instituicao_areas_interesse = "SELECT ai.nome
                                                    FROM PL_Inst_Interesse ii, PL_Areas_Interesse ai
                                                    WHERE ii.acao_id='$acao[0]' AND ii.area_int = ai.area_int";
        
        $resultado_acoes_instituicao_areas_interesse = mysqli_query($conn, $query_acoes_instituicao_areas_interesse);

        if (mysqli_num_rows($resultado_acoes_instituicao_areas_interesse)>=1) {

            $acoes_instituicao_areas_interesse = array();

            while ($row_acoes_instituicao_areas_interesse = mysqli_fetch_array($resultado_acoes_instituicao_areas_interesse, MYSQLI_NUM)) {
				array_push($acoes_instituicao_areas_interesse, $row_acoes_instituicao_areas_interesse[0]);
            }
			
			array_push($acao_info, $acoes_instituicao_areas_interesse);
        } 

        // Obter populacoes alvo da acao
        $query_acoes_instituicao_populacoes_alvo = "SELECT pa.nome
                                                    FROM PL_Inst_Popul_Alvo ipa, PL_Populacao_Alvo pa
                                                    WHERE ipa.acao_id='$acao[0]' AND ipa.id_popul_alvo = pa.id_populacao_alvo";

        $resultado_acoes_instituicao_populacoes_alvo = mysqli_query($conn, $query_acoes_instituicao_populacoes_alvo);

        if (mysqli_num_rows($resultado_acoes_instituicao_populacoes_alvo)>=1) {

            $acoes_instituicao_populacoes_alvo = array();

            while ($row_acoes_instituicao_populacoes_alvo = mysqli_fetch_array($resultado_acoes_instituicao_populacoes_alvo, MYSQLI_NUM)) {
                $acoes_instituicao_populacoes_alvo[] = $row_acoes_instituicao_populacoes_alvo[0];
            }
			array_push($acao_info, $acoes_instituicao_populacoes_alvo);
        }

        // Obter horarios da acao
        $query_acoes_instituicao_horarios = "SELECT dia, periodo
                                             FROM PL_Acoes_Horario
                                             WHERE acao_id='$acao[0]'";

        $resultado_acoes_instituicao_horarios = mysqli_query($conn, $query_acoes_instituicao_horarios);

        if (mysqli_num_rows($resultado_acoes_instituicao_horarios)>=1) {

            $acoes_instituicao_horarios = array();

            while ($row_acoes_instituicao_horarios = mysqli_fetch_array($resultado_acoes_instituicao_horarios, MYSQLI_NUM)) {
                $acoes_instituicao_horarios[] = $row_acoes_instituicao_horarios;
            }
			array_push($acao_info, $acoes_instituicao_horarios);
        }

        // Construção de cada caixa onde fica a ação no HTML
		$acao_info = json_encode($acao_info);
        $HTML_acao_instituicao = "";

        $HTML_acao_instituicao .= '
        <div class="container caixa_da_acao">

            <br>

            <div class="text-center zona_do_botao2">
                <button class="btn btn-primary texto_botao2" onclick="convidar_voluntario('.htmlspecialchars($acao_info).','.htmlspecialchars($acao[0]).')">VOLUNTÁRIOS</button>
				<br><br>
				<button class="btn btn-primary texto_botao2" onclick="candidaturas_voluntarios('.htmlspecialchars($acao[0]).')">CANDIDATURAS</button>
            </div>

            <br>
            
            <div class="container">
                <h2 class="texto_titulo_acao">Ação: '.$acao[1].'</h2>

                <br>

                <div> 

                    <span class="form-control" id="areas_interesse" class="texto_input_span" role="textbox" readonly> 
                        Distrito: '.$acao[2].', Concelho: '.$acao[3].', Freguesia: '.$acao[4].', Função: '.$acao[5].', Número de vagas: '.$acao[6].'
                    </span>

                </div>


            </div>

            <hr class="my-4">

            <div class="container zona_areas_interesse">

                <h5 class="texto_subtitulo_acao">Áreas de interesse</h5>

                <span class="form-control" id="areas_interesse" class="input" role="textbox" readonly>

        ';

        $numero_areas_interesse = count($acoes_instituicao_areas_interesse);

        $a = 1;
        foreach ($acoes_instituicao_areas_interesse as $area_interesse) {
            if ($a == $numero_areas_interesse) {
                $HTML_acao_instituicao .= $area_interesse;
            } else {
                $HTML_acao_instituicao .= $area_interesse . ', ';
            }
            $a++;
        }

        $HTML_acao_instituicao .= '
            </span>

        </div>

        <hr class="my-4">

        <div class="container zona_populacoes_alvo">
            <h5 class="texto_subtitulo_acao">Populações alvo</h5>

            <span class="form-control" id="populacoes_alvo" class="input" role="textbox" readonly>
        ';

        $numero_populacoes_alvo = count($acoes_instituicao_populacoes_alvo);

        $b = 1;
        foreach ($acoes_instituicao_populacoes_alvo as $populacao_alvo) {
            if ($b == $numero_populacoes_alvo) {
                $HTML_acao_instituicao .= $populacao_alvo;
            } else {
                $HTML_acao_instituicao .= $populacao_alvo . ', ';
            }
            $b++;
        }

        $HTML_acao_instituicao .= '
            </span>

        </div>

        <hr class="my-4">

        <div class="container zona_horarios">
                <h5 class="texto_subtitulo_acao">Horários da ação</h5>';

        $c = 1;
        foreach ($acoes_instituicao_horarios as $horario) {
            
            $HTML_acao_instituicao .= '
            <div class="row">
            <div class="col">
                <label for="dia_da_semana'.$c.'" class="form-label">Dia: </label>
                <input class="form-control" id="dia_da_semana'.$c.'" type="text" value="'.$horario[0].'" readonly>
            </div>

            <div class="col">
                <label  for="hora_inicio'.$c.'" class="form-label">Periodo:</label>
                <input class="form-control" id="hora_inicio'.$c.'" type="text" value="'.$horario[1].'" readonly>
            </div></div><br>';

            $c++;
        }

        $HTML_acao_instituicao .= '
            
                    
            </div>

            <br>

        </div>
        ';

        $HTML_todas_acoes_instituicao .= $HTML_acao_instituicao;

    } 
}



# include final no ficheiro acoes_das_instituicoes.php

# se a instituicao já registou alguma ação de voluntariado
if (mysqli_num_rows($resultado_acoes_instituicao)>=1) {

    echo '
        <div class="text-center">
            <a href="editar_criar_acoes_voluntariado.php"><button class="btn btn-primary btn-lg">CRIAR AÇÃO</button></a>
        </div>
        
        <br>
    ';

    echo $HTML_todas_acoes_instituicao;

} else {

    echo '

    <br>
    <br>

    <div class="container text-center">
        <a href="editar_criar_acoes_voluntariado.php"><button class="btn btn-primary btn-lg">CRIAR AÇÃO</button></a>
    </div>
    
    ';

    echo '
        <div class="text-center editar_interesses3">

            <div class="container w-75">

                <h4>Não existem ações</h4><br>

                <p>A sua empresa não possuí qualquer ação nesta zona!</p>

            </div>

        </div>
    ';

}

?> 