<?php
    ini_set("display_errors", 1);
    $Dados = new Dados();
    $participantes = $Dados->lerParticipanteReservaAtivaJantarSindico('', 1);
    
    $imp = printer_open("ELGIN L-42");
    foreach($participantes as $participante) {
        printer_set_option($imp, PRINTER_MODE, "RAW");
        printer_write($imp, $participante["NOME"]);
        printer_close($imp);
    }
        