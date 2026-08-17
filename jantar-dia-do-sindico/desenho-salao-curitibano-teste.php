<?php
ini_set("display_errors", 1);
    $Dados = new Dados();
    $mesas = $Dados->lerMesasJantarSindico();
    $tamPadrao = 4500;
    
    $img            =   imagecreatefromjpeg(DIR_IMAGENS . "jantar-dia-do-sindico/salao$tamPadrao.jpg");
    $corBranca      =   imagecolorallocate($img, 255, 255, 255);
    $corCinza       =   imagecolorallocate($img, 105, 105, 105);
    $corVermelha    =   imagecolorallocate($img, 255, 0, 0);
    $corVerde       =   imagecolorallocate($img, 0, 255, 0);
    $corAzul        =   imagecolorallocate($img, 0, 0, 255);
    $corAmarela     =   imagecolorallocate($img, 255, 255, 0);
    $corPreta       =   imagecolorallocate($img, 0, 0, 0);
    $x              =   imagesx($img);
    $y              =   imagesy($img);
    texto($img, "PALCO", $x/2*0.95, $y/2*1.35, 60*$x/$tamPadrao, null, $corAzul);
    // pista
        circulo($img, 10000, $x / 2, $y / 2, $x / 2 / 4, $corPreta);
        circulo($img, 10000, $x / 2, $y / 2, $x / 2 / 4.5, $corPreta);
        circulo($img, 10000, $x / 2, $y / 2, $x / 2 / 4.7, $corPreta);
        texto($img, "PISTA", $x / 2 * 0.95, $y / 2, 60*$x/$tamPadrao, null, $corAzul);
    //
    texto($img, "GARÇONS", $x / 2 * 1.6, $y / 2 * 1.35, 40*$x/$tamPadrao, null, $corAzul);
    texto($img, "BAR", $x / 2 * 1.45, $y / 2 * 1.45, 40*$x/$tamPadrao, null, $corAzul);
    texto($img, "SANITÁRIO", $x / 2 * 0.7, $y / 2 * 1.8, 40*$x/$tamPadrao, null, $corAzul);
    texto($img, "FEMININO", $x / 2 * 0.7, $y / 2 * 1.82, 40*$x/$tamPadrao, null, $corAzul);
    texto($img, "SANITÁRIO", $x / 2 * 1.0, $y / 2 * 1.8, 40*$x/$tamPadrao, null, $corAzul);
    texto($img, "MASCULINO", $x / 2 * 1.0, $y / 2 * 1.82, 40*$x/$tamPadrao, null, $corAzul);
    texto($img, "ACESSO PRINCIPAL", $x / 2 * 0.2, $y / 2 * 1.7, 40*$x/$tamPadrao, null, $corAzul);
    texto($img, "SAIDA DE EMERGÊNCIA", $x / 2 * 0.03, $y / 2 * 0.86, 20*$x/$tamPadrao, null, $corVermelha);
        
    $lugares = array('A1'=>array(0,0,1,1,1,0,0,1));
    
    $areas = mesas($img, "A", $mesas, $x / 2, $y / 2, $x / 2 * 0.33, $y / 2 * 1.1); // fila A
    $areas = array_merge($areas, mesas($img, "B", $mesas, $x / 2, $y / 2, $x / 2 * 0.44)); // fila B
    $areas = array_merge($areas, mesas($img, "C", $mesas, $x / 2, $y / 2, $x / 2 * 0.55)); // fila C
    $areas = array_merge($areas, mesas($img, "D", $mesas, $x / 2, $y / 2, $x / 2 * 0.66)); // fila D
    $areas = array_merge($areas, mesas($img, "E", $mesas, $x / 2, $y / 2, $x / 2 * 0.77)); // fila E
    $areas = array_merge($areas, mesas($img, "F", $mesas, $x / 2, $y / 2, $x / 2 * 0.88)); // fila F
    $nomeImg = "salao.jpg";// . date("YmdHis") . ".jpg";
    imagejpeg($img, DIR_IMAGENS . "jantar-dia-do-sindico/" . $nomeImg, 100);
    chmod(DIR_IMAGENS . "jantar-dia-do-sindico/" . $nomeImg, 0777);
    $Dados->atualizarSituacaoAtualizacao(0);
    unset($Dados);

    function mesas($img, $fila, $mesas, $x, $y, $raio) {
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
//echo "<br/>update mesas set x7000 = " . ($x1/4500*7000) . ", y7000 = " . ($y1/4500*7000) . " where numero_mesa = " . $mesa["NUMERO_MESA"] . ";";                    
                    if($mesa["TIPO"] == 1) {// AND $mesa["MOSTRAR"] == 1) { // mesa
                        $tamMesa    =   imagesx($img) * 0.03;
                        $tamCadeira = $tamMesa / 8;
                        $num = $mesa["NUMERO_MESA"];
                        desenharCadeiras($img, 8, $x1, $y1, $tamMesa*0.5, $tamCadeira, $mesa["QT_LUGARES_OCUPADOS"], $mesa["QT_LUGARES_RESERVADOS"], $corPreta, false, $num); // cadeiras
                        $cor = $mesa["QT_LUGARES_OCUPADOS"] < 8 ? $corPreta : imagecolorallocate($img, 255, 0, 0);
                        imageellipse($img, $x1, $y1, $tamMesa, $tamMesa, $cor);
                        imageellipse($img, $x1, $y1, $tamMesa*0.8, $tamMesa*0.8, $cor);
                        texto($img, $num, $x1-$tamCadeira*3, $y1+$tamCadeira, $tamMesa * 0.35, null, $cor);
                        $areas[] = array("x1" => $x1-$tamCadeira, "y1" => $y1+$tamCadeira, "x2" => $x1 + $tamCadeira, "y2" => $y1 + $tamCadeira, "num" => $num);
                    }
                    elseif($mesa["TIPO"] == 2) { // coluna
                        imagefilledellipse($img, $x1, $y1, $raio * 0.05, $raio * 0.05, imagecolorallocate($img, 122, 132, 189));
                    }
                }
                $i++;
            }
        }
//die;        
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
    
    function desenharCadeiras($img, $qtCadeiras, $x, $y, $raio, $tamCadeira, $qtLugaresOcupados, $qtLugaresReservados, $cor, $preenchido = false, $num) {
        $dist = 2 * pi() / $qtCadeiras;
        $qtOcupados = $qtLugaresOcupados;
        $qtReservados = $qtLugaresReservados;
        for($i = 0; $i < $qtCadeiras; $i++) {
            $cos = cos($i * $dist);
            $sen = sin($i * $dist);
            $x1 = $cos * $raio + $x;
            $y1 = $sen * $raio + $y;
            if($qtOcupados-- > 0) {
                imagefilledellipse($img, $x1, $y1, $raio*0.5, $raio*0.5, imagecolorallocate($img, 205, 0, 0));
            }
            elseif($qtReservados-- > 0) {
                imagefilledellipse($img, $x1, $y1, $raio*0.5, $raio*0.5, imagecolorallocate($img, 255, 174, 0));
            }
            else {
                imagefilledellipse($img, $x1, $y1, $raio*0.5, $raio*0.5, imagecolorallocate($img, 169, 169, 169));
            }
        }
    }
    
?>


