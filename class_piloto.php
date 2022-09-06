<?php

class Piloto{
    public $id;
    public $nome;
    public $voltas = array();

    public function grava_resultados($hora,$n_voltas,$tempo_volta,$velocidade_media_volta){
        $array_temp['hora'] = $hora;
        $array_temp['n_voltas'] = $n_voltas;
        $array_temp['tempo_volta'] = Trata_Time($tempo_volta);
        $array_temp['velocidade_media_volta'] = $velocidade_media_volta;
        $this->voltas[] = $array_temp;
    }
}