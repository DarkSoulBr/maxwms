<?php
require_once("include/conexao.inc.php");
require_once("include/logradouros.php");

$codigo=trim($_GET["codigo"]);

$cadastro = new banco($conn,$db);
$cadastro->apaga("logradouros","$codigo");

pg_close($conn);
exit();
?>