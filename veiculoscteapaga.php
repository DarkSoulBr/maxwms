<?php 
require_once("include/conexao.inc.php");
require_once("include/veiculoscte.php");

$codigo=trim($_GET["codigo"]);

$cadastro = new banco($conn,$db);
$cadastro->apaga("veiculoscte","$codigo");

pg_close($conn);
exit();
?>