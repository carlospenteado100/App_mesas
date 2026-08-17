<?php
    $idEvento = 1; // TODO arrumar isso
    $Dados = new Dados();
    $participantes = $Dados->listagemParticipantesJantarSindico($idEvento);
    $smarty->assign("participantes", $participantes);
    $html = $smarty->fetch($template);
    // criar lista de e-mail
    $fp = fopen(DIR_TEMP . "lista-participantes.csv", "w");
    fwrite($fp, "NOME DA ENTIDADE,NOME,EMAIL\r\n");
    foreach($participantes as $participante) {
        fwrite($fp, $participante["titulares_tcs"][0]["FANTASIA"] . ", " . $participante["titulares_tcs"][0]["NOME"] . "," . $participante["titulares_tcs"][0]["EMAIL"] . "\r\n");
    }
    fclose($fp);
    header("Content-type: application/vnd.ms-excel; charset=iso-8859-1");   
    header("Content-type: application/force-download");  
    header("Content-Disposition: attachment; filename=lisagem-participantes.xls");
    header("Pragma: no-cache");
    echo $html;
