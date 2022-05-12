<?php
require_once("include/conexao.inc.php");
require_once("include/logradouros.php");

$codigo=trim($_GET["codigo"]);
$nome=trim($_GET["nome"]);
$codigobairro=trim($_GET["codigobairro"]);
$codigocidade=trim($_GET["codigocidade"]);
$cep=trim($_GET["cep"]);

$cadastro = new banco($conn,$db);
$cadastro->altera("logradouros","descricao='$nome',codigocidade='$codigocidade',codigobairro='$codigobairro',cep='$cep'","$codigo");

pg_close($conn);
exit();
?>
