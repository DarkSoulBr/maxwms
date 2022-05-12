<?php
require_once("include/conexao.inc.php");
require_once("include/ibge.php");


$cidnome=trim($_GET["cidnome"]);
$cidcodigo=trim($_GET["cidcodigo"]);
$estcodigo=trim($_GET["estcodigo"]);
$cep=trim($_GET["cep"]);
$cep2=trim($_GET["cep2"]);

$cadastro = new banco($conn,$db);
$cadastro->altera("cidadesibge","descricao='$cidnome',uf='$estcodigo',codcidade='$cep',codestado='$cep2'","$cidcodigo");

pg_close($conn);
exit();
?>
