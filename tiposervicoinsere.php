<?php

require_once("include/conexao.inc.php");
require_once("include/tiposervico.php");

$sernome = trim($_GET["sernome"]);

$cadastro = new banco($conn, $db);

$sql = "SELECT max(sercodigo) as codigo FROM tiposervico";

$sql = pg_query($sql);

$row = pg_num_rows($sql);

$codigo = (pg_fetch_result($sql, 0, "codigo") + 1);

$cadastro->insere("tiposervico", "(sernome,sercodigo)", "('$sernome','$codigo')");

pg_close($conn);
exit();
?>