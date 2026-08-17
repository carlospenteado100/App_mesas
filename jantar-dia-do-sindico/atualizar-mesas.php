<?php

$cnpj = explode("=", $params);

$Dados = new Dados();
// passar CNPJ como parâmetro - descriptografado -- alterado somente para o do SECOVI
$dados = $Dados->lerCadastroTCS('entidade', '78.376.472/0001-30');

$smarty->assign("cnpj", $dados['entidade']['CNPJ']);
$smarty->assign("fantasia", $dados['entidade']['FANTASIA']);
$smarty->assign("codigo", $dados['entidade']['IDCODIGO']);
$smarty->assign("telefone", $dados['entidade']['FONE']);
$smarty->assign("email", $dados['entidade']['EMAIL']);

?>
