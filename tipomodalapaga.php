<?php   
require_once("include/conexao.inc.php");
require_once("include/tipomodal.php");

$tmocodigo=trim($_GET["tmocodigo"]);

$cadastro = new banco($conn,$db);
$cadastro->apaga("tipomodal","$tmocodigo");

pg_close($conn);
exit();
?>