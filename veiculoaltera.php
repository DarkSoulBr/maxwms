<?php
require_once("include/conexao.inc.php");
require_once("include/veiculo.php");

$veicodigo=trim($_GET["veicodigo"]);
$veiplaca=trim($_GET["veiplaca"]);

$veiano=trim($_GET["veiano"]);
$veimodelo=trim($_GET["veimodelo"]);
$veicor=trim($_GET["veicor"]);
$veichassis=trim($_GET["veichassis"]);
$veitipo=trim($_GET["veitipo"]);

$veivalidar=trim($_GET["veivalidar"]);

$cadastro = new banco($conn,$db);
$cadastro->altera("veiculos","veiplaca='$veiplaca'
,veiano='$veiano'
,veimodelo='$veimodelo'
,veicor='$veicor'
,veichassis='$veichassis'
,veitipo='$veitipo'
,veivalidar='$veivalidar'
","$veicodigo");


pg_close($conn);
exit();
?>
