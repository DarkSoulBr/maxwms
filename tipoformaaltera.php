<?php    
require_once("include/conexao.inc.php");
require_once("include/tipoforma.php");

$tfocodigo=trim($_GET["tfocodigo"]);
$tfonome=trim($_GET["tfonome"]);

$cadastro = new banco($conn,$db);
$cadastro->altera("tipoforma","tfonome='$tfonome'","$tfocodigo");

pg_close($conn);
exit();
?>
