<?php    
require_once("include/conexao.inc.php");
require_once("include/tipoforma.php");

$tfocodigo=trim($_GET["tfocodigo"]);

$cadastro = new banco($conn,$db);
$cadastro->apaga("tipoforma","$tfocodigo");

pg_close($conn);
exit();
?>