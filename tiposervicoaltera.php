<?php 
require_once("include/conexao.inc.php");
require_once("include/tiposervico.php");

$sercodigo=trim($_GET["sercodigo"]);
$sernome=trim($_GET["sernome"]);

$cadastro = new banco($conn,$db);
$cadastro->altera("tiposervico","sernome='$sernome'","$sercodigo");

pg_close($conn);
exit();
?>
