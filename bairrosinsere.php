<?php

require_once("include/conexao.inc.php");
require_once("include/bairros.php");

$nome = trim($_GET["nome"]);
$codigocidade = trim($_GET["codigocidade"]);

$cadastro = new banco($conn, $db);

//QUERY
$sql = "SELECT max(codigo) as codigo FROM  bairros";

//EXECUTA A QUERY
$sql = pg_query($sql);

$row = pg_num_rows($sql);

$codigo = 0;

//VERIFICA SE VOLTOU ALGO
if ($row) {
    $codigo = pg_fetch_result($sql, 0, "codigo");
}
$codigo++;

$cadastro->insere("bairros", "(descricao,codigocidade,codigo)", "('$nome','$codigocidade','$codigo')");

pg_close($conn);
exit();
?>