<?php 
require_once("include/conexao.inc.php");
require_once("include/cadusuarios.php");

$codigo=trim($_GET["codigo"]);

$cadastro = new banco($conn,$db);
$cadastro->apaga("cadusuarios","$codigo");

pg_close($conn);
exit();
?>