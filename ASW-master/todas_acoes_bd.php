<?php
session_start();
//print_r($_SESSION);

include "openconn.php";
mysqli_set_charset($conn,"utf8");

$utilizador = $_SESSION["utilizador"];
$inst_id = $_SESSION["ID"];

# Todas as acoes de todas as instituicoes
$query_acoes_instituicoes = "SELECT acao_id, inst_id, nome, distrito, concelho, freguesia, funcao, numero_vagas, Ativo
                            FROM PL_Inst_Acoes";

$resultado_acoes_instituicoes = mysqli_query($conn, $query_acoes_instituicoes);

if (mysqli_num_rows($resultado_acoes_instituicoes)>=1) {

    $acoes_instituicoes = array();

    while ($row_acoes_instituicoes = mysqli_fetch_array($resultado_acoes_instituicoes, MYSQLI_NUM)) {
        $acoes_instituicoes[] = $row_acoes_instituicoes;
    }

    $HTML_todas_acoes_instituicoes = "";

    foreach ($acoes_instituicoes as $acoes){

        // Obter avatar da instituição da ação
        $query_avatar = "SELECT nome, foto FROM PL_Instituicao WHERE inst_id='$acoes[1]'";

        $resultado_avatar = mysqli_query($conn, $query_avatar);

        if (mysqli_num_rows($resultado_avatar)>=1) {
            $row = mysqli_fetch_row($resultado_avatar);
            $nome_da_empresa = $row[0];
            $foto = $row[1];
        }
        
        // Obter areas interesse das acoes de toodas as instituicoes
        $query_acoes_instituicoes_areas_interesse = "SELECT ai.nome
                                                    FROM PL_Inst_Interesse ii, PL_Areas_Interesse ai
                                                    WHERE ii.acao_id='$acoes[0]' AND ii.area_int = ai.area_int";
        
        $resultado_acoes_instituicoes_areas_interesse = mysqli_query($conn, $query_acoes_instituicoes_areas_interesse);

        if (mysqli_num_rows($resultado_acoes_instituicoes_areas_interesse)>=1) {

            $acoes_instituicoes_areas_interesse = array();

            while ($row_acoes_instituicoes_areas_interesse = mysqli_fetch_array($resultado_acoes_instituicoes_areas_interesse, MYSQLI_NUM)) {
                $acoes_instituicoes_areas_interesse[] = $row_acoes_instituicoes_areas_interesse;
            }

        }

        // Obter populacoes alvo das acoes de todas as instituicoes
        $query_acoes_instituicoes_populacoes_alvo = "SELECT pa.nome
                                                    FROM PL_Inst_Popul_Alvo ipa, PL_Populacao_Alvo pa
                                                    WHERE ipa.acao_id='$acoes[0]' AND ipa.id_popul_alvo = pa.id_populacao_alvo";

        $resultado_acoes_instituicoes_populacoes_alvo = mysqli_query($conn, $query_acoes_instituicoes_populacoes_alvo);

        if (mysqli_num_rows($resultado_acoes_instituicoes_populacoes_alvo)>=1) {

            $acoes_instituicoes_populacoes_alvo = array();

            while ($row_acoes_instituicoes_populacoes_alvo = mysqli_fetch_array($resultado_acoes_instituicoes_populacoes_alvo, MYSQLI_NUM)) {
                $acoes_instituicoes_populacoes_alvo[] = $row_acoes_instituicoes_populacoes_alvo;
            }

        }

        // Obter horarios das acoes de todas as instituicoes
        $query_acoes_instituicoes_horarios = "SELECT dia, periodo
                                             FROM PL_Acoes_Horario
                                             WHERE acao_id='$acoes[0]'";

        $resultado_acoes_instituicoes_horarios = mysqli_query($conn, $query_acoes_instituicoes_horarios);

        if (mysqli_num_rows($resultado_acoes_instituicoes_horarios)>=1) {

            $acoes_instituicoes_horarios = array();

            while ($row_acoes_instituicoes_horarios = mysqli_fetch_array($resultado_acoes_instituicoes_horarios, MYSQLI_NUM)) {
                $acoes_instituicoes_horarios[] = $row_acoes_instituicoes_horarios;
            }

        }

        // Construção de cada caixa onde ficam as açoes de todas as instituicoes no HTML

        $HTML_acoes_instituicoes = "";

        $HTML_acoes_instituicoes .= '
        <div class="container caixa_da_acao">

            <br>
                    
            <div class="participar_nome_da_empresa">

                <img id="' .$acoes[1]. '" class="avatar" src="' . $foto . '" alt="Avatar">

                <div class="titulos">
                    <h4 class="nome_da_empresa">Empresa: '.$nome_da_empresa.'</h4>
                    <button id="sobre_a_empresa" class="btn btn-dark sobre_empresa" onclick="mostrar_sobre_empresa(); construir_apresentacao_empresa('.$acoes[1].');">SOBRE A EMPRESA</button>
                </div>

            </div>
            

            <div class="container zona_infos_principais">
                <h6 class="texto_titulo_acao">Ação: '.$acoes[2].'</h6>

                <br>

                <div> 

                    <span class="form-control" id="areas_interesse" class="texto_input_span" role="textbox" readonly> 
                        Distrito: '.$acoes[3].', Concelho: '.$acoes[4].', Freguesia: '.$acoes[5].', Função: '.$acoes[6].', Número de vagas: '.$acoes[7].'
                    </span>

                </div>


            </div>

            <hr class="my-4">

            <div class="container zona_areas_interesse">

                <h5 class="texto_subtitulo_acao">Áreas de interesse</h5>

                <span class="form-control" id="areas_interesse" class="input" role="textbox" readonly>

        ';

        $numero_areas_interesse = count($acoes_instituicoes_areas_interesse);

        $a = 1;
        foreach ($acoes_instituicoes_areas_interesse as $area_interesse) {
            if ($a == $numero_areas_interesse) {
                $HTML_acoes_instituicoes .= $area_interesse[0];
            } else {
                $HTML_acoes_instituicoes .= $area_interesse[0] . ', ';
            }
            $a++;
        }

        $HTML_acoes_instituicoes .= '
            </span>

        </div>

        <hr class="my-4">

        <div class="container zona_populacoes_alvo">
            <h5 class="texto_subtitulo_acao">Populações alvo</h5>

            <span class="form-control" id="populacoes_alvo" class="input" role="textbox" readonly>
        ';

        $numero_populacoes_alvo = count($acoes_instituicoes_populacoes_alvo);

        $b = 1;
        foreach ($acoes_instituicoes_populacoes_alvo as $populacao_alvo) {
            if ($b == $numero_populacoes_alvo) {
                $HTML_acoes_instituicoes .= $populacao_alvo[0];
            } else {
                $HTML_acoes_instituicoes .= $populacao_alvo[0] . ', ';
            }
            $b++;
        }

        $HTML_acoes_instituicoes .= '
            </span>

        </div>

        <hr class="my-4">

        <div class="container zona_horarios">
                <h5 class="texto_subtitulo_acao">Horários da ação</h5>';

        $c = 1;
        foreach ($acoes_instituicoes_horarios as $horario) {
            
            $HTML_acoes_instituicoes .= '
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

        $HTML_acoes_instituicoes .= '
            
                    
            </div>

            <br>

        </div>
        ';

        $HTML_todas_acoes_instituicoes .= $HTML_acoes_instituicoes;

    } 
}

# include final no ficheiro acoes_das_instituicoes.php

# se as instituicoes já registaram alguma ação de voluntariado
if (mysqli_num_rows($resultado_acoes_instituicoes)>=1) {

    echo $HTML_todas_acoes_instituicoes;

} else {

    echo '
        <p>De momento não existem quaisquer acções disponíveis. Tente verificar novamente mais tarde</p>
        
        ';

}

?> 