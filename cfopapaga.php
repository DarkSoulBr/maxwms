<?php    
require_once("include/conexao.inc.php");
require_once("include/cfop.php");

$cfocodigo=trim($_GET["cfocodigo"]);

$cadastro = new banco($conn,$db);
$cadastro->apaga("cfop","$cfocodigo");

pg_close($conn);
exit();
?>