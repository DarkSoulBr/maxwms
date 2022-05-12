<?php    
require_once("include/conexao.inc.php");
require_once("include/banco.php");

$motcodigo=trim($_GET["motcodigo"]);

$cadastro = new banco($conn,$db);
$cadastro->apaga("motoristas","motcodigo=$motcodigo");

pg_close($conn);
exit();
?>