<?php   
require_once("include/conexao.inc.php");
require_once("include/tipopagamento.php");

$tpgcodigo=trim($_GET["tpgcodigo"]);

$cadastro = new banco($conn,$db);
$cadastro->apaga("tipopagamento","$tpgcodigo");

pg_close($conn);
exit();
?>