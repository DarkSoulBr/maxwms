<?php
require_once("include/conexao.inc.php");
require_once("include/bairros.php");


$nome=trim($_GET["nome"]);
$codigo=trim($_GET["codigo"]);
$codigocidade=trim($_GET["codigocidade"]);

$cadastro = new banco($conn,$db);
$cadastro->altera("bairros","descricao='$nome',codigocidade='$codigocidade'","$codigo");

pg_close($conn);
exit();
?>
