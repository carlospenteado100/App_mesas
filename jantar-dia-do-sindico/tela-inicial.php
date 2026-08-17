<?php
    $Dados = new Dados();
    
    $smarty->assign("evento", $Dados->lerEventosAtivosJantarSindico());
    $smarty->assign("cargos", $Dados->lerCargosTCS());
    $smarty->assign("mesas", $Dados->lerReservasTemporariasJantarSindico());
    
    unset($Dados);