<?php   
require_once("include/conexao.inc.php");
require_once("include/tipopagamento.php");

$tpgcodigo=trim($_GET["tpgcodigo"]);
$tpgnome=trim($_GET["tpgnome"]);

$cadastro = new banco($conn,$db);
$cadastro->altera("tipopagamento","tpgnome='$tpgnome'","$tpgcodigo");

pg_close($conn);
exit();
?>
