<?php

    $Dados = new Dados();
    $mesas = $Dados->lerMesasJantarSindico();
    $tamPadrao = 2000;
    
    $img            =   imagecreatefromjpeg(DIR_IMAGENS . "jantar-dia-do-sindico/salao2000.jpg");
    $corBranca      =   imagecolorallocate($img, 255, 255, 255);
    $corCinza       =   imagecolorallocate($img, 205, 205, 205);
    $corVermelha    =   imagecolorallocate($img, 255, 0, 0);
    $corVerde       =   imagecolorallocate($img, 0, 255, 0);
    $corAzul        =   imagecolorallocate($img, 0, 0, 255);
    $corAmarela     =   imagecolorallocate($img, 255, 255, 0);
    $x              =   imagesx($img);
    $y              =   imagesy($img);
    texto($img, "PALCO", $x/2*0.9, $y/2*1.45, 60*$x/2200, null, $corCinza);
    // pista
        circulo($img, 1000, $x / 2, $y / 2, $x / 2 / 4, $corCinza);
        circulo($img, 1000, $x / 2, $y / 2, $x / 2 / 4.5, $corCinza);
        circulo($img, 1000, $x / 2, $y / 2, $x / 2 / 4.7, $corCinza);
        texto($img, "PISTA", $xPista * 0.9, $yPista * 1.05, 60*$x/$tamPadrao, null, $corCinza);
    //
        
    $lugares = array('A1'=>array(0,0,1,1,1,0,0,1));
    
    $areas = mesas($img, "A", $mesas, $x / 2, $y / 2, $x / 2 * 0.333); // fila A
    $areas = array_merge($areas, mesas($img, "B", $mesas, $x / 2, $y / 2, $x / 2 * 0.45)); // fila B
    $areas = array_merge($areas, mesas($img, "C", $mesas, $x / 2, $y / 2, $x / 2 * 0.57)); // fila C
    $areas = array_merge($areas, mesas($img, "D", $mesas, $x / 2, $y / 2, $x / 2 * 0.68)); // fila D
    $areas = array_merge($areas, mesas($img, "E", $mesas, $x / 2, $y / 2, $x / 2 * 0.8)); // fila E
    $areas = array_merge($areas, mesas($img, "F", $mesas, $x / 2, $y / 2, $x / 2 * 0.9)); // fila F
    $nomeImg = "salao.jpg";// . date("YmdHis") . ".jpg";
    imagejpeg($img, DIR_IMAGENS . "jantar-dia-do-sindico/" . $nomeImg, 100);
    chmod(DIR_IMAGENS . "jantar-dia-do-sindico/" . $nomeImg, 0777);

    function mesas($img, $fila, $mesas, $x, $y, $raio, $lugares = "") {
        $corPreta = imagecolorallocate($img, 0, 0, 0);
        $qtMesas = 0;
        foreach($mesas as $mesa) {
            if($mesa["FILA"] == $fila) {
                $qtMesas++;
            }
        }
        $dist = 2 * pi() / $qtMesas;
        $i = 0;
        $areas = array();
        foreach($mesas as $mesa) {
            if($mesa["FILA"] == $fila) {
                if($mesa["TIPO"] != 0) {
                    $cos = cos($i * $dist);
                    $sen = sin($i * $dist);
                    $x1 = $cos * $raio * -1 + $x;
                    $y1 = $sen * $raio * -1 + $y;
                    if($mesa["TIPO"] == 1) { // mesa
                        $tamMesa    =   imagesx($img) * 0.035;
                        $tamCadeira = $tamMesa / 8;
                        $num = $mesa["NUMERO_MESA"];
                        desenharCadeiras($img, 8, $x1, $y1, $tamMesa*0.5, $tamCadeira, $mesa["QT_LUGARES_OCUPADOS"], $mesa["QT_LUGARES_RESERVADOS"], $corPreta); // cadeiras
                        imageellipse($img, $x1, $y1, $tamMesa, $tamMesa, $corPreta);
                        imageellipse($img, $x1, $y1, $tamMesa*0.8, $tamMesa*0.8, $corPreta);
                        if( ($num >= 100 AND $num < 200) OR ($num >= 300 AND $num < 400) OR ($num >= 500)) {
                            $cor = imagecolorallocate($img, 255, 0, 0);
                        }
                        else {
                            $cor = imagecolorallocate($img, 0, 0, 0);
                        }
                        texto($img, $num, $x1-$tamCadeira, $y1+$tamCadeira, $tamCadeira, null, $cor);
                        $areas[] = array("x1" => $x2, "y1" => $y2, "x2" => $x2 + $tamCadeira, "y2" => $y2 + $tamCadeira, "num" => $num);
                    }
                    else { // coluna
                        imagefilledellipse($img, $x1, $y1, $raio * 0.10, $raio * 0.10, imagecolorallocate($img, 122, 132, 189));
                    }
                }
                $i++;
            }
        }
        return $areas;
    }
    
    function circulo($img, $qtPontos, $x, $y, $raio, $cor) {
        $dist = 2 * pi() / $qtPontos;
        for($i = 0; $i < $qtPontos; $i++) {
            $cos = cos($i * $dist);
            $sen = sin($i * $dist);
            $x1 = $cos * $raio + $x;
            $y1 = $sen * $raio + $y;
            imagesetpixel($img, $x1, $y1, $cor);
        }
    }
    
    function texto($img, $texto, $x = -1, $y = -1, $tamFonte = 15, $nomeFonte = "", $cor = -1) {
        $nomeFonte = $nomeFonte == "" ? DIR_COMUM . "fontes/arial.ttf" : $nomeFonte;
        $cor = $cor < 0 ? imagecolorallocate($img, 0, 0, 0) : $cor;
        $text_box = imagettfbbox($tamFonte, 0, $nomeFonte, $texto);
        $text_width = $text_box[2]-$text_box[0];
        $text_height = $text_box[7]-$text_box[1];
        if(!$x OR $x < 0) {
            $x = (imagesx($img) / 2) - ($text_width/2);
        }
        if(!$y OR $y < 0) {
            $y = (imagesy($img) / 2) - ($text_height/2);
        }
        imagettftext($img, $tamFonte, 0, $x, $y, $cor, $nomeFonte, $texto);        
    }
    
    function desenharCadeiras($img, $qtCadeiras, $x, $y, $raio, $tamCadeira, $qtLugaresOcupados, $qtLugaresReservados, $cor, $preenchido = false) {
        $dist = 2 * pi() / $qtCadeiras;
        $qtOcupados = $qtLugaresOcupados;
        $qtReservados = $qtLugaresReservados;
        for($i = 0; $i < $qtCadeiras; $i++) {
            $cos = cos($i * $dist);
            $sen = sin($i * $dist);
            $x1 = $cos * $raio + $x;
            $y1 = $sen * $raio + $y;
            if($preenchido) {
                imagefilledellipse($img, $x1, $y1, $raio*0.5, $raio*0.5, $cor);
//                imagefilledarc($img, $x1-20, $y1, $raio*0.2, $raio*0.5, 0, 0, $cor, IMG_ARC_PIE);
            }
            else {
                if($qtOcupados-- > 0) {
                    imagefilledellipse($img, $x1, $y1, $raio*0.5, $raio*0.5, imagecolorallocate($img, 255, 0, 0));
                }
                if($qtReservados-- > 0) {
                    imagefilledellipse($img, $x1, $y1, $raio*0.5, $raio*0.5, imagecolorallocate($img, 255, 165, 0));
                }
                else {
                    imageellipse($img, $x1, $y1, $raio*0.5, $raio*0.5, $cor);
                }
//                imagearc($img, $x1 - $tamCadeira + $dist, $y1, $raio*0.2, $raio*0.5, $tamCadeira, $tamCadeira, $cor);
            }
        }
    }
    
?>
