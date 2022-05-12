<?php
require_once("include/conexao.inc.php");
require_once("include/estado.php");


$estsigla=trim($_GET["estsigla"]);
$estnome=trim($_GET["estnome"]);
$estcodigo=trim($_GET["estcodigo"]);
$esticms=trim($_GET["esticms"]);
$esticms2=trim($_GET["esticms2"]);
$esticms3=trim($_GET["esticms3"]);
$estnfe=trim($_GET["estnfe"]);

$cadastro = new banco($conn,$db);
$cadastro->altera("estados","codigo='$estsigla',descricao='$estnome',esticms='$esticms',estinterna='$esticms2',estpobreza='$esticms3',estservico='$estnfe'","$estcodigo");

pg_close($conn);
exit();
?>
