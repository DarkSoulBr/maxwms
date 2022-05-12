<?php
require_once("include/conexao.inc.php");
require_once("include/ibge.php");

$cidnome=trim($_GET["cidnome"]);
$estcodigo=trim($_GET["estcodigo"]);
$cep=trim($_GET["cep"]);
$cep2=trim($_GET["cep2"]);

$cadastro = new banco($conn,$db);
$cadastro->insere("cidadesibge","(descricao,uf,codcidade,codestado)","('$cidnome','$estcodigo','$cep','$cep2')");

pg_close($conn);
exit();
?>