<?php 
require_once("include/conexao.inc.php");
require_once("include/tipocte.php");

$tctcodigo=trim($_GET["tctcodigo"]);
$tctnome=trim($_GET["tctnome"]);

$cadastro = new banco($conn,$db);
$cadastro->altera("tipocte","tctnome='$tctnome'","$tctcodigo");

pg_close($conn);
exit();
?>
