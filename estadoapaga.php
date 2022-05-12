<?php
require_once("include/conexao.inc.php");
require_once("include/estado.php");

$estcodigo=trim($_GET["estcodigo"]);
	
$cadastro = new banco($conn,$db);
$cadastro->apaga("estados","$estcodigo");

pg_close($conn);
exit();
?>