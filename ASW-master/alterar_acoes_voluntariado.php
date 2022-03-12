<?php
session_start();

include "openconn.php";

$inst_id = $_SESSION["ID"];





#registar todas as áreas de interesse
foreach ($array_areas_interesse as $area_interesse){

    $saber_id_area_interesse = "SELECT a.area_int FROM PL_Areas_Interesse a WHERE a.nome = '$area_interesse'";

    $resultado_saber_id_area_interesse = mysqli_query($conn, $saber_id_area_interesse);

    if (mysqli_num_rows($resultado_saber_id_area_interesse)>=1) {

        $row_area_interesse = mysqli_fetch_row($resultado_saber_id_area_interesse);
        $id_area_interesse = utf8_encode($row_area_interesse[0]);

        # verificar se a população alvo já não foi registada pelo voluntário, se foi, ignorar insert na base de dados
        $query_saber_se_area_interesse_ja_registada = "SELECT ai.area_int FROM PL_Volun_Interesse ai WHERE ai.area_int = '$id_area_interesse' AND ai.acao_id = '$acao_id'";
        $resultado_saber_se_area_interesse_ja_registada = mysqli_query($conn, $query_saber_se_area_interesse_ja_registada);

        if (mysqli_num_rows($resultado_saber_se_area_interesse_ja_registada)==0) {

            $query_area_interesse = "INSERT INTO `PL_Volun_Interesse` (`area_int`, `acao_id`)
            VALUES ('$id_area_interesse', '$acao_id')";

            $registar_area_interesse_do_voluntario = mysqli_query($conn, $query_area_interesse);

            if ($registar_area_interesse_do_voluntario) {

                continue;
            
            } else {

            echo "Erro: insert failed" . $query_area_interesse . "<br>" . mysqli_error($conn);
            
            }
        } else {
            # Esta área de interesse já foi registada
            continue;
        }
            
    } else {

        echo "Erro: " . $saber_id_area_interesse . "<br>" . mysqli_error($conn);
    
    }

}

#registar todas as populações alvo
foreach ($array_populacoes_alvo as $populacao_alvo){

    $saber_id_populacao_alvo = "SELECT p.id_populacao_alvo FROM PL_Populacao_Alvo p WHERE p.nome = '$populacao_alvo'";

    $resultado_saber_id_populacao_alvo = mysqli_query($conn, $saber_id_populacao_alvo);

    if (mysqli_num_rows($resultado_saber_id_populacao_alvo)>=1) {

        $row_populacao_alvo = mysqli_fetch_row($resultado_saber_id_populacao_alvo);
        $id_populacao_alvo = utf8_encode($row_populacao_alvo[0]); 

        # verificar se a população alvo já não foi registada pelo voluntário, se foi, ignorar insert na base de dados
        $query_saber_se_populacao_ja_registada = "SELECT vp.id_populacao_alvo FROM PL_Inst_Popul_Alvo vp WHERE vp.id_popul_alvo = '$id_populacao_alvo' AND vp.acao_id = '$acao_id'";
        $resultado_saber_se_populacao_ja_registada = mysqli_query($conn, $query_saber_se_populacao_ja_registada);

        if (mysqli_num_rows($resultado_saber_se_populacao_ja_registada)==0) {

            $query_populacao_alvo = "INSERT INTO `PL_Inst_Popul_Alvo` (`id_popul_alvo`, `acao_id`)
            VALUES ('$id_populacao_alvo', '$acao_id')";

            $registar_populacao_alvo_do_voluntario = mysqli_query($conn, $query_populacao_alvo);

            if ($registar_populacao_alvo_do_voluntario) {

                continue;
            
            } else {

            echo "Erro: insert failed" . $query_populacao_alvo . "<br>" . mysqli_error($conn);
            
            }

        } else {
            # Esta população alvo já foi registada
            continue;
        }
            
    } else {

        echo "Erro: " . $saber_id_populacao_alvo . "<br>" . mysqli_error($conn);
    
    }

}

#registar todos os horários
foreach ($array_horarios as $horario){

    # verificar se a população alvo já não foi registada pelo voluntário, se foi, ignorar insert na base de dados
    $query_saber_se_horario_ja_registado = "SELECT h.horario_id FROM PL_Acoes_Horario h WHERE h.acao_id = '$acao_id' AND h.dia = '$horario[0]' AND h.hora_inicio = '$horario[1]' AND h.hora_fim = '$horario[2]'";
    $resultado_saber_se_horario_ja_registado = mysqli_query($conn, $query_saber_se_horario_ja_registado);

    if (mysqli_num_rows($resultado_saber_se_horario_ja_registado)==0) {

        $query_horario = "INSERT INTO `PL_Acoes_Horario` (`acao_id`, `dia`, `hora_inicio`, `hora_fim`)
        VALUES ('$acao_id', '$horario[0]', '$horario[1]', '$horario[2]')";

        $registar_horario_do_voluntario = mysqli_query($conn, $query_horario);

        if ($registar_horario_do_voluntario) {

            continue;
        
        } else {

        echo "Erro: insert failed" . $query_horario . "<br>" . mysqli_error($conn);

        }
        
    } else {
        # Este horário já foi registado
        continue;
    }
}

header("Location: criar_acoes_voluntariado.php");

mysqli_close($conn);

?>