<?php

function ler_arquivo($arquivo)
{
    $arquivo = carregar_arquivo($arquivo);
    $texto_arquivo2 = array();
    $texto_arquivo_temp = "";
    while (!feof($arquivo)) {
        $texto_arquivo = explode("    ", fgets($arquivo));
        $texto_arquivo2[] = $texto_arquivo;
    }
    fclose($arquivo);
    return $texto_arquivo2;
}

function carregar_arquivo($arquivo)
{
    $arquivo = fopen("$arquivo", "r") or die("Falha ao carregar arquivo");
    return $arquivo;
}

function preenche_objeto_piloto($aquivo_array)
{
    foreach ($aquivo_array as $result) {
        $result_list[] = $result[1];
    }
    unset($result_list[0]);
    foreach (array_unique($result_list) as $reult_piloto) {
        $id_nome = explode(" – ", $reult_piloto);
        $piloto = new Piloto();
        $piloto->id     = $id_nome[0];
        $piloto->nome   = $id_nome[1];
        //inserir separa voltas
        foreach ($aquivo_array as $result) {
            if ($result[1] == $reult_piloto) {
                //gravar voltas                 
                $piloto->grava_resultados($result[0], $result[2], $result[3], $result[4]);
            }
        }
        $array_pilotos[] = $piloto;
    }
    return $array_pilotos;
}

function Trata_Time($valor)
{
    $resultt = explode(":", $valor);
    if (count($resultt) == 2) {
        if (strlen($resultt[0]) == 1) {
            return $novo_valor = "00:0" . $valor;
        } else {
            return $novo_valor = "00:" . $valor;
        }
    }
    return "";
}

function processar_dados($array_pilotos){
    foreach ($array_pilotos as $piloto) {
        $time_chegada = "00:00:00.000";
        $num_voltas = 0;
        $melhorvolta = "59:59:59.000";
        foreach ($piloto->voltas as $p_voltas) {

            if ($p_voltas['n_voltas'] >= $num_voltas) {
                if ($p_voltas['hora'] > $time_chegada) {
                    $time_chegada = $p_voltas['hora'];
                    $num_voltas = $p_voltas['n_voltas'];
                }
                if ($p_voltas['tempo_volta'] < $melhorvolta) {
                    $melhorvolta = $p_voltas['tempo_volta'];
                }
            }
            if ($p_voltas['n_voltas'] == 1) {
                $tempo_inicio_corrida = date('H:i:s.u', strtotime($p_voltas['hora']) - strtotime($p_voltas['tempo_volta']));
            }
        }

        $tempo_d_prova = date('H:i:s', strtotime($time_chegada) - strtotime($tempo_inicio_corrida));
        $array_pilotos_cal[] = array("Posição de Chegada" => 0, "Cod. Piloto" => $piloto->id, "Nome Piloto" => $piloto->nome, "Voltas completadas" => $num_voltas, "Melhor Volta" => $melhorvolta, "Tempo de Prova" => $tempo_d_prova, "Tempo de chegada" => $time_chegada);

        $time_chegada_array[] = $time_chegada;
    }
    sort($time_chegada_array);
    $posicao = 1;
    foreach ($time_chegada_array as $time_chegada_) {
        foreach ($array_pilotos_cal as $piloto_cal) {
            if ($piloto_cal['Tempo de chegada'] == $time_chegada_) {
                $piloto_cal["Posição de Chegada"] = $posicao;
                $array_pilotos_ordenado[] = $piloto_cal;
                $posicao++;
            }
        }
    }
    return $array_pilotos_ordenado;
}
