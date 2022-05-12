<?php 
require_once("include/conexao.inc.php");
require_once("include/tipocte.php");

$tctcodigo=trim($_GET["tctcodigo"]);

$cadastro = new banco($conn,$db);
$cadastro->apaga("tipocte","$tctcodigo");

pg_close($conn);
exit();
?>