<?php

unset($dados);

if ($_POST['codigo-barras']):
    $Dados = new Dados();
    $res = $Dados->lerCodigodeBarrasJantarSindico($_POST['codigo-barras']);
    //print_r($res);
    $smarty->assign("dados", $res);
    unset($_POST['codigo-barras']);
endif;

