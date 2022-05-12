<?php 
require_once("include/conexao.inc.php");
require_once("include/tiposervico.php");

$sercodigo=trim($_GET["sercodigo"]);

$cadastro = new banco($conn,$db);
$cadastro->apaga("tiposervico","$sercodigo");

pg_close($conn);
exit();
?>