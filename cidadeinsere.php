<?php

require_once("include/conexao.inc.php");
require_once("include/cidade.php");

$cidnome = trim($_GET["cidnome"]);
$estcodigo = trim($_GET["estcodigo"]);
$cep = trim($_GET["cep"]);
$suframa = trim($_GET["suframa"]);

$sql = "SELECT max(codigo) as codigo FROM cidades a";
$sql = pg_query($sql);
$row = pg_num_rows($sql);
if ($row) {
    $codigo = (pg_fetch_result($sql, 0, "codigo") + 1);
}

$cadastro = new banco($conn, $db);
$cadastro->insere("cidades", "(descricao,uf,cep,codigo,suframa)", "('$cidnome','$estcodigo','$cep','$codigo','$suframa')");

pg_close($conn);
exit();
?>