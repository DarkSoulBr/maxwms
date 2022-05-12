<?php
require_once("include/conexao.inc.php");
require_once("include/logradouros.php");

$nome=trim($_GET["nome"]);
$codigobairro=trim($_GET["codigobairro"]);
$codigocidade=trim($_GET["codigocidade"]);
$cep=trim($_GET["cep"]);


$cadastro = new banco($conn,$db);
$cadastro->insere("logradouros","(descricao,codigobairro,codigocidade,cep)","('$nome','$codigobairro','$codigocidade','$cep')");

pg_close($conn);
exit();
?>