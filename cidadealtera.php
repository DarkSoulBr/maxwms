<?php

require_once("include/conexao.inc.php");
require_once("include/cidade.php");


$cidnome = trim($_GET["cidnome"]);
$cidcodigo = trim($_GET["cidcodigo"]);
$estcodigo = trim($_GET["estcodigo"]);
$cep = trim($_GET["cep"]);
$suframa = trim($_GET["suframa"]);

//Verifica se a cidade está com o Campo código Preenchido
$sql = "SELECT codigo FROM cidades where cidcodigo=$cidcodigo";
$sql = pg_query($sql);
$row = pg_num_rows($sql);
$codigo = '';
if ($row) {
    $codigo = (pg_fetch_result($sql, 0, "codigo"));
}

if ($codigo == '') {
    $sql = "SELECT max(codigo) as codigo FROM cidades a";
    $sql = pg_query($sql);
    $row = pg_num_rows($sql);
    if ($row) {
        $codigo = (pg_fetch_result($sql, 0, "codigo") + 1);
    }
}


$cadastro = new banco($conn, $db);
$cadastro->altera("cidades", "descricao='$cidnome',uf='$estcodigo',cep='$cep',codigo='$codigo',suframa='$suframa'", "$cidcodigo");

pg_close($conn);
exit();
?>
