<?php

$cnpj = explode("=", $params);
$idEvento = 1; // TODO arrumar isso

$Dados = new Dados();
$dados = $Dados->lerTodosPreInscritosJantarSindico(1);
//echo "<pre>";
//print_r($dados);die();
$smarty->assign("dados", $dados);
