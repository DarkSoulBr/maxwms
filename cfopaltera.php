<?php    
require_once("include/conexao.inc.php");
require_once("include/cfop.php");

$cfocodigo=trim($_GET["cfocodigo"]);
$cfonome=trim($_GET["cfonome"]);
$cfocod=trim($_GET["cfocod"]);

$cadastro = new banco($conn,$db);
$cadastro->altera("cfop","cfonome='$cfonome',cfocod='$cfocod'","$cfocodigo");

pg_close($conn);
exit();
?>
