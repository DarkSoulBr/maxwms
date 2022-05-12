<?php   
require_once("include/conexao.inc.php");
require_once("include/tipomodal.php");

$tmocodigo=trim($_GET["tmocodigo"]);
$tmonome=trim($_GET["tmonome"]);

$cadastro = new banco($conn,$db);
$cadastro->altera("tipomodal","tmonome='$tmonome'","$tmocodigo");

pg_close($conn);
exit();
?>
