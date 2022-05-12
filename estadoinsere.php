<?php
require_once("include/conexao.inc.php");
require_once("include/estado.php");

$estsigla=trim($_GET["estsigla"]);
$estnome=trim($_GET["estnome"]);
$esticms=trim($_GET["esticms"]);
$esticms2=trim($_GET["esticms2"]);
$esticms3=trim($_GET["esticms3"]);
$estnfe=trim($_GET["estnfe"]);
	
$cadastro = new banco($conn,$db);
$cadastro->insere("estados","(codigo,descricao,esticms,estinterna,estpobreza,estservico)","('$estsigla','$estnome','$esticms','$esticms2','$esticms3','$estnfe')");

pg_close($conn);
exit();
?>