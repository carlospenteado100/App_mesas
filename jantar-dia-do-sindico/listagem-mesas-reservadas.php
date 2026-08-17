<?php
$Dados = new Dados();

$dados = $Dados->lerTodosMesasReservadasJantarSindico("mesa", 0);
$smarty->assign("dados", $dados);
