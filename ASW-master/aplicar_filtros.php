<?php
session_start();

include "openconn.php";

mysqli_set_charset($conn,"utf8");

$utilizador = $_SESSION["utilizador"];
$volun_id = $_SESSION["ID"];

$empresa_id = $_SESSION["ID"];

$freguesia = htmlspecialchars($_GET["freguesia"]);
$concelho = htmlspecialchars($_GET["concelho"]);
$distrito = htmlspecialchars($_GET["distrito"]);

$area_interesse = htmlspecialchars($_GET["area_interesse"]); // id da area de interesse na bd
$populacao_alvo = htmlspecialchars($_GET["populacao_alvo"]); // id da população alvo na bd

$dia_da_semana = htmlspecialchars($_GET["dia_select"]); // ex: Quarta-Feira / default
$periodo = htmlspecialchars($_GET["periodo_select"]); // ex: Manhã / default


if ($_SESSION["voluntario_ou_empresa"] == "perfil_voluntario.php") {


    # Todas as áreas de interesse do voluntario
    $query_areas_interesse = "SELECT ai.nome
    FROM PL_Areas_Interesse ai, PL_Volun_Interesse vi
    WHERE vi.volun_id = '$volun_id' AND vi.area_int = ai.area_int";

    $resultado_areas_interesse = mysqli_query($conn, $query_areas_interesse);

    if (mysqli_num_rows($resultado_areas_interesse)>=1) {

        $areas_interesse_voluntario = array();

        while ($row_areas_interesse_voluntario = mysqli_fetch_array($resultado_areas_interesse, MYSQLI_NUM)) {
            $areas_interesse_voluntario[] = $row_areas_interesse_voluntario;
        }

    }

    # Todas as populações alvo do voluntario
    $query_populacoes_alvo = "SELECT pa.nome
                            FROM PL_Populacao_Alvo pa, PL_Volun_Populacao_Alvo vpa
                            WHERE vpa.volun_id = '$volun_id' AND vpa.id_populacao_alvo =pa.id_populacao_alvo";

    $resultado_populacoes_alvo = mysqli_query($conn, $query_populacoes_alvo);

    if (mysqli_num_rows($resultado_populacoes_alvo)>=1) {

        $populacoes_alvo_voluntario = array();

        while ($row_populacoes_alvo_voluntario = mysqli_fetch_array($resultado_populacoes_alvo, MYSQLI_NUM)) {
            $populacoes_alvo_voluntario[] = $row_populacoes_alvo_voluntario;
        }

    } 

    # Todas as disponibilidades do voluntario
    $query_disponibilidades = "SELECT dia, periodo FROM PL_Volun_Horario WHERE volun_id = $volun_id
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

    $resultado_disponibilidades = mysqli_query($conn, $query_disponibilidades);

    if (mysqli_num_rows($resultado_disponibilidades)>=1) {

        $disponibilidades_voluntario = array();

        while ($row_disponibilidades_voluntario = mysqli_fetch_array($resultado_disponibilidades, MYSQLI_NUM)) {
            $disponibilidades_voluntario[] = $row_disponibilidades_voluntario;
        }

    }

    if ($_SESSION["mostrar_acoes_filtradas"] == "nao") {
        
        $query = "SELECT t1.acao_id, t1.inst_id, t1.nome, t1.distrito, t1.concelho, t1.freguesia, t1.funcao, t1.numero_vagas , t1.Ativo 
        FROM PL_Inst_Acoes t1, PL_Inst_Interesse t2, PL_Inst_Popul_Alvo t3, PL_Acoes_Horario t4 WHERE t1.Ativo='sim' AND";

        if ($freguesia != "") {
            $query .= " t1.freguesia = '$freguesia' AND";
        }

        if ($concelho != "") {
            $query .= " t1.concelho = '$concelho' AND";
        }

        if ($distrito != "") {
            $query .= " t1.distrito = '$distrito' AND";
        }


        if ($area_interesse != "default") {
            $query .= " t2.area_int = '$area_interesse' AND t2.acao_id = t1.acao_id AND";
        }

        if ($populacao_alvo != "default") {
            $query .= " t3.id_popul_alvo = '$populacao_alvo' AND t3.acao_id = t1.acao_id AND";
        }

        if ($dia_da_semana != "default") {
            $query .= " t4.dia = '$dia_da_semana' AND t4.periodo = '$periodo' AND t4.acao_id = t1.acao_id AND";
        }

        $pieces = explode(' ', $query);
        $last_word = end($pieces);

        if ($last_word == "AND") {
            $words = explode( " ", $query );
            array_splice( $words, -1 );
            $query = implode( " ", $words );
        }

        $query .= " GROUP BY t1.acao_id"; 

        //echo "<br>query final : " . $query . "<br>";

        $resultado = mysqli_query($conn, $query);


        if (mysqli_num_rows($resultado)>=1) {
            
            $acoes_instituicao = array();

            while ($row_acoes_instituicao = mysqli_fetch_array($resultado, MYSQLI_NUM)) {
                $acoes_instituicao[] = $row_acoes_instituicao;
            }

            $HTML_todas_acoes_instituicao = "";

            foreach ($acoes_instituicao as $acao){

                // Obter avatar da instituição da ação
                $query_avatar = "SELECT nome, foto FROM PL_Instituicao WHERE inst_id='$acao[1]'";

                $resultado_avatar = mysqli_query($conn, $query_avatar);

                if (mysqli_num_rows($resultado_avatar)>=1) {
                    $row = mysqli_fetch_row($resultado_avatar);
                    $nome_da_empresa = $row[0];
                    $foto = $row[1];
                }
                
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
                }


                // saber se o voluntário já se candidatou a esta ação

                $ja_candidatou = "SELECT candidatura_id FROM PL_Inst_Acoes_Volun_Candidato WHERE volun_id = '$volun_id' AND acao_id = '$acao[0]'";
                $resultado_ja_candidatou = mysqli_query($conn, $ja_candidatou);


                // Construção de cada caixa onde fica a ação no HTML

                $HTML_acao_instituicao = "";

                $HTML_acao_instituicao .= '
                <div class="container caixa_da_acao">

                    <br>
                    
                ';

                if (mysqli_num_rows($resultado_ja_candidatou)>=1) {
                    $HTML_acao_instituicao .= '
                    <form action="voluntario_quer_cancelar_candidatura.php" method="post">
                        <div class="text-center zona_do_botao">
                            <input class="btn btn-secondary btn-lg texto_botao" type="submit" value="CANCELAR CANDIDATURA À AÇÃO!" name="'.$acao[0].'">
                        </div>
                    </form><div class="estado_candidatura" id="'.$acao[0].'"><br></div>
                ';
                } else {
                    $HTML_acao_instituicao .= '
                    <form action="voluntario_quer_participar_na_acao.php" method="post">
                        <div class="text-center zona_do_botao">
                            <input class="btn btn-primary btn-lg texto_botao" type="submit" value="QUERO PARTICIPAR NESTA AÇÃO!" name="'.$acao[0].'">
                        </div>
                    </form>
                    ';
                }

                $HTML_acao_instituicao .= '
                    <br>
                    
                    <div class="participar_nome_da_empresa">

                        <img id="' .$acao[1]. '" class="avatar" src="' . $foto . '" alt="Avatar">

                        <div class="titulos">
                            <h4 class="nome_da_empresa">Empresa: '.$nome_da_empresa.'</h4>
                            <button id="sobre_a_empresa" class="btn btn-dark sobre_empresa" onclick="mostrar_sobre_empresa(); construir_apresentacao_empresa('.$acao[1].')">SOBRE A EMPRESA</button>
                            <img class="chat" src="imagens/chat.png" alt="Avatar" onclick="mostrar_chat()">
                            
                        </div>

                    </div>
                    

                    <div class="container zona_infos_principais">
                        <h4 class="texto_titulo_acao">Ação: '.($acao[2]).'</h4>

                        <div> 

                            <span class="form-control" id="areas_interesse" class="texto_input_span" role="textbox" readonly> 
                                Distrito: '.($acao[3]).', Concelho: '.($acao[4]).', Freguesia: '.($acao[5]).', Função: '.($acao[6]).', Número de vagas: '.($acao[7]).'
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
                        $HTML_acao_instituicao .= ($area_interesse);
                    } else {
                        $HTML_acao_instituicao .= ($area_interesse) . ', ';
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
                        $HTML_acao_instituicao .= ($populacao_alvo);
                    } else {
                        $HTML_acao_instituicao .= ($populacao_alvo) . ', ';
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
                        <input class="form-control" id="dia_da_semana'.$c.'" type="text" value="'.($horario[0]).'" readonly>
                    </div>

                    <div class="col">
                        <label  for="hora_inicio'.$c.'" class="form-label">Periodo:</label>
                        <input class="form-control" id="hora_inicio'.$c.'" type="text" value="'.($horario[1]).'" readonly>
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

            if ($HTML_todas_acoes_instituicao) {
                if ($HTML_todas_acoes_instituicao != "") {

                    echo $HTML_todas_acoes_instituicao;
            
                }
            } else {
                
                echo '
                    <div class="text-center editar_interesses2">
    
                        <div class="container w-75">
    
                            <h4>Não existem ações que correspondem aos filtros indicados!</h4><br>
    
                            <p>Por favor, altere os filtros indicados!</p>
    
                        </div>
    
                    </div>
                ';
            }
        }

    } else {
        
        $query = "SELECT t1.acao_id, t1.inst_id, t1.nome, t1.distrito, t1.concelho, t1.freguesia, t1.funcao, t1.numero_vagas , t1.Ativo 
        FROM PL_Inst_Acoes t1, PL_Inst_Interesse t2, PL_Inst_Popul_Alvo t3, PL_Acoes_Horario t4 WHERE t1.Ativo='sim' AND";

        if ($freguesia != "") {
            $query .= " t1.freguesia = '$freguesia' AND";
        }

        if ($concelho != "") {
            $query .= " t1.concelho = '$concelho' AND";
        }

        if ($distrito != "") {
            $query .= " t1.distrito = '$distrito' AND";
        }


        if ($area_interesse != "default") {
            $query .= " t2.area_int = '$area_interesse' AND t2.acao_id = t1.acao_id AND";
        }

        if ($populacao_alvo != "default") {
            $query .= " t3.id_popul_alvo = '$populacao_alvo' AND t3.acao_id = t1.acao_id AND";
        }

        if ($dia_da_semana != "default") {
            $query .= " t4.dia = '$dia_da_semana' AND t4.periodo = '$periodo' AND t4.acao_id = t1.acao_id AND";
        }

        $pieces = explode(' ', $query);
        $last_word = end($pieces);

        if ($last_word == "AND") {
            $words = explode( " ", $query );
            array_splice( $words, -1 );
            $query = implode( " ", $words );
        }

        $query .= " GROUP BY t1.acao_id"; 

        // echo "<br>query final : " . $query . "<br>";

        $resultado = mysqli_query($conn, $query);


        if (mysqli_num_rows($resultado)>=1) {
            
            $acoes_instituicao = array();

            while ($row_acoes_instituicao = mysqli_fetch_array($resultado, MYSQLI_NUM)) {
                $acoes_instituicao[] = $row_acoes_instituicao;
            }

            $HTML_todas_acoes_instituicao = "";

            foreach ($acoes_instituicao as $acao){

                // Obter avatar da instituição da ação
                $query_avatar = "SELECT nome, foto FROM PL_Instituicao WHERE inst_id='$acao[1]'";

                $resultado_avatar = mysqli_query($conn, $query_avatar);

                if (mysqli_num_rows($resultado_avatar)>=1) {
                    $row = mysqli_fetch_row($resultado_avatar);
                    $nome_da_empresa = $row[0];
                    $foto = $row[1];
                }
                
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
                }

                $match_area_interesse_voluntario_instituicao = 0;
                $match_populacao_alvo_voluntario_instituicao = 0;
                $match_disponibilidade_voluntario_instituicao = 0;

                foreach($areas_interesse_voluntario as $area_interesse_voluntario) {

                    foreach($acoes_instituicao_areas_interesse as $area_interesse_instituicao) {

                        if (($area_interesse_voluntario[0]) == ($area_interesse_instituicao)) {
                            $match_area_interesse_voluntario_instituicao = 1;

                        }
                    }

                }

                foreach($populacoes_alvo_voluntario as $populacao_alvo_voluntario) {

                    foreach($acoes_instituicao_populacoes_alvo as $populacao_alvo_instituicao) {

                        if (($populacao_alvo_voluntario[0]) == ($populacao_alvo_instituicao)) {
                            $match_populacao_alvo_voluntario_instituicao = 1;
                        }

                    }

                }

                foreach($disponibilidades_voluntario as $disponibilidade_voluntario) {

                    foreach($acoes_instituicao_horarios as $disponibilidade_instituicao) {


                        if (($disponibilidade_voluntario[0]) == ($disponibilidade_instituicao[0]) and ($disponibilidade_voluntario[1]) == ($disponibilidade_instituicao[1])) {
                            $match_disponibilidade_voluntario_instituicao = 1;
                        }

                    }

                }


                // saber se o voluntário já se candidatou a esta ação

                $ja_candidatou = "SELECT candidatura_id FROM PL_Inst_Acoes_Volun_Candidato WHERE volun_id = '$volun_id' AND acao_id = '$acao[0]'";
                $resultado_ja_candidatou = mysqli_query($conn, $ja_candidatou);

                if ($match_area_interesse_voluntario_instituicao==1 and $match_populacao_alvo_voluntario_instituicao==1 and $match_disponibilidade_voluntario_instituicao==1) {
                    
                    // Construção de cada caixa onde fica a ação no HTML

                    $HTML_acao_instituicao = "";

                    $HTML_acao_instituicao .= '
                    <div class="container caixa_da_acao">

                        <br>
                        
                    ';

                    if (mysqli_num_rows($resultado_ja_candidatou)>=1) {
                        $HTML_acao_instituicao .= '
                        <form action="voluntario_quer_cancelar_candidatura.php" method="post">
                            <div class="text-center zona_do_botao">
                                <input class="btn btn-secondary btn-lg texto_botao" type="submit" value="CANCELAR CANDIDATURA À AÇÃO!" name="'.$acao[0].'">
                            </div>
                        </form><div class="estado_candidatura" id="'.$acao[0].'"><br></div>
                    ';
                    } else {
                        $HTML_acao_instituicao .= '
                        <form action="voluntario_quer_participar_na_acao.php" method="post">
                            <div class="text-center zona_do_botao">
                                <input class="btn btn-primary btn-lg texto_botao" type="submit" value="QUERO PARTICIPAR NESTA AÇÃO!" name="'.$acao[0].'">
                            </div>
                        </form>
                        ';
                    }

                    $HTML_acao_instituicao .= '
                        <br>
                    
                        <div class="participar_nome_da_empresa">
        
                            <img id="' .$acao[1]. '" class="avatar" src="' . $foto . '" alt="Avatar">
        
                            <div class="titulos">
                                <h4 class="nome_da_empresa">Empresa: '.$nome_da_empresa.'</h4>
                                <button id="sobre_a_empresa" class="btn btn-dark sobre_empresa" onclick="mostrar_sobre_empresa(); construir_apresentacao_empresa('.$acao[1].')">SOBRE A EMPRESA</button>
                                <img class="chat" src="imagens/chat.png" alt="Avatar" onclick="mostrar_chat()">
                                
                            </div>
        
                        </div>
                        

                        <div class="container zona_infos_principais">
                            <h4 class="texto_titulo_acao">Ação: '.($acao[2]).'</h4>

                            <div> 

                                <span class="form-control" id="areas_interesse" class="texto_input_span" role="textbox" readonly> 
                                    Distrito: '.($acao[3]).', Concelho: '.($acao[4]).', Freguesia: '.($acao[5]).', Função: '.($acao[6]).', Número de vagas: '.($acao[7]).'
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
                            $HTML_acao_instituicao .= ($area_interesse);
                        } else {
                            $HTML_acao_instituicao .= ($area_interesse) . ', ';
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
                            $HTML_acao_instituicao .= ($populacao_alvo);
                        } else {
                            $HTML_acao_instituicao .= ($populacao_alvo) . ', ';
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
                            <input class="form-control" id="dia_da_semana'.$c.'" type="text" value="'.($horario[0]).'" readonly>
                        </div>

                        <div class="col">
                            <label  for="hora_inicio'.$c.'" class="form-label">Periodo:</label>
                            <input class="form-control" id="hora_inicio'.$c.'" type="text" value="'.($horario[1]).'" readonly>
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

            if ($HTML_todas_acoes_instituicao != "") {

                echo $HTML_todas_acoes_instituicao;
        
            } else {
                
                if (mysqli_num_rows($resultado_areas_interesse)==0 and mysqli_num_rows($resultado_populacoes_alvo)==0 and mysqli_num_rows($resultado_disponibilidades)==0) {
        
                    echo '
                        <div class="text-center editar_interesses">
        
                            <div class="container w-75">
        
                                <h4>Não possuí qualquer área de interesse registada</h4><br>
        
                                <p>Por favor, registe pelo menos 1 área de interesse no seu perfil!</p>
        
                            </div>
        
                            <hr class="my-4"> 
        
                            <div class="container w-75">
        
                                <h4>Não possuí qualquer população alvo registada</h4><br>
        
                                <p>Por favor, registe pelo menos 1 população alvo no seu perfil!</p>
        
                            </div>
        
                            <hr class="my-4"> 
        
                            <div class="container w-75">
        
                                <h4>Não possuí qualquer disponibilidade registada</h4><br>
        
                                <p>Por favor, registe pelo menos 1 disponibilidade no seu perfil!</p>
        
                            </div>
        
                        </div>
                    ';
        
                } else {
        
                    echo '
                        <div class="text-center editar_interesses2">
        
                            <div class="container w-75">
        
                                <h4>Não existem ações que correspondem aos filtros indicados!</h4><br>
        
                                <p>Por favor, altere os filtros indicados!</p>
        
                            </div>
        
                        </div>
                    ';
                }
            }
        }
    }

} else if ($_SESSION["voluntario_ou_empresa"] == "perfil_empresa.php") {

    if ($_SESSION["mostrar_todas_as_acoes_ativas"] == "nao") {
        
        $query = "SELECT t1.acao_id, t1.nome, t1.distrito, t1.concelho, t1.freguesia, t1.funcao, t1.numero_vagas , t1.Ativo 
        FROM PL_Inst_Acoes t1, PL_Inst_Interesse t2, PL_Inst_Popul_Alvo t3, PL_Acoes_Horario t4 WHERE t1.inst_id='$empresa_id' AND t1.Ativo='nao' AND";

    } else {

        $query = "SELECT t1.acao_id, t1.nome, t1.distrito, t1.concelho, t1.freguesia, t1.funcao, t1.numero_vagas , t1.Ativo 
        FROM PL_Inst_Acoes t1, PL_Inst_Interesse t2, PL_Inst_Popul_Alvo t3, PL_Acoes_Horario t4 WHERE t1.inst_id='$empresa_id' AND t1.Ativo='sim' AND";

    }

    if ($freguesia != "") {
        $query .= " t1.freguesia LIKE '%$freguesia%' AND";
    }

    if ($concelho != "") {
        $query .= " t1.concelho LIKE '%$concelho%' AND";
    }

    if ($distrito != "") {
        $query .= " t1.distrito LIKE '%$distrito%' AND";
    }

    if ($area_interesse != "default") {
        $query .= " t2.area_int = '$area_interesse' AND t2.acao_id = t1.acao_id AND";
    }

    if ($populacao_alvo != "default") {
        $query .= " t3.id_popul_alvo = '$populacao_alvo' AND t3.acao_id = t1.acao_id AND";
    }

    if ($dia_da_semana != "default") {
        $query .= " t4.dia = '$dia_da_semana' AND t4.periodo = '$periodo' AND t4.acao_id = t1.acao_id AND";
    }

    $pieces = explode(' ', $query);
    $last_word = end($pieces);

    if ($last_word == "AND") {
        $words = explode( " ", $query );
        array_splice( $words, -1 );
        $query = implode( " ", $words );
    }

    $query .= " GROUP BY t1.acao_id"; 

    // echo "<br>query final : " . $query . "<br>";

    $resultado = mysqli_query($conn, $query);

    $HTML_todas_acoes_instituicao = "";

    if (mysqli_num_rows($resultado)>=1) {
        
        $acoes_instituicao = array();

        while ($row_acoes_instituicao = mysqli_fetch_array($resultado, MYSQLI_NUM)) {
            $acoes_instituicao[] = $row_acoes_instituicao;
        }

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

			$acao_info = json_encode($acao_info);
			
            // Construção de cada caixa onde fica a ação no HTML

            $HTML_acao_instituicao = "";

            $HTML_acao_instituicao .= '
            <div class="container caixa_da_acao">

                <br>

                <div class="text-center zona_do_botao">
                    <button class="btn btn-primary texto_botao2" onclick="convidar_voluntario('.htmlspecialchars($acao_info).')">CONVIDAR VOLUNTÁRIOS</button>
                    <br><br>
                    <button class="btn btn-primary texto_botao2" onclick="candidaturas_voluntarios('.htmlspecialchars($acao[0]).')">CANDIDATURAS</button>
                </div>

                <br>
                
                <div class="container zona_infos_principais">
                    <h4 class="texto_titulo_acao">Ação: '.($acao[1]).'</h4>

                    <div> 

                        <span class="form-control" id="areas_interesse" class="texto_input_span" role="textbox" readonly> 
                            Distrito: '.($acao[2]).', Concelho: '.($acao[3]).', Freguesia: '.($acao[4]).', Função: '.($acao[5]).', Número de vagas: '.($acao[6]).'
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
                    $HTML_acao_instituicao .= ($area_interesse);
                } else {
                    $HTML_acao_instituicao .= ($area_interesse) . ', ';
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
                    $HTML_acao_instituicao .= ($populacao_alvo);
                } else {
                    $HTML_acao_instituicao .= ($populacao_alvo) . ', ';
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
                    <input class="form-control" id="dia_da_semana'.$c.'" type="text" value="'.($horario[0]).'" readonly>
                </div>

                <div class="col">
                    <label  for="hora_inicio'.$c.'" class="form-label">Periodo:</label>
                    <input class="form-control" id="hora_inicio'.$c.'" type="text" value="'.($horario[1]).'" readonly>
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

        if ($HTML_todas_acoes_instituicao) {
            if ($HTML_todas_acoes_instituicao != "") {

                echo $HTML_todas_acoes_instituicao;
        
            } else {
                echo "
                <div class='text-center editar_interesses2'>

                    <div class='container w-75'>

                        <h4>Não existem ações que correspondem aos filtros indicados!</h4><br>

                        <p>Por favor, altere os filtros indicados!</p>

                    </div>

                </div>
                ";
            }

        } else {
            echo "
            <div class='text-center editar_interesses2'>

                <div class='container w-75'>

                    <h4>Não existem ações que correspondem aos filtros indicados!</h4><br>

                    <p>Por favor, altere os filtros indicados!</p>

                </div>

            </div>
            ";
            
        }
    }
}

?>