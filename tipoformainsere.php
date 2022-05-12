<?php

require_once("include/conexao.inc.php");
require_once("include/tipoforma.php");

$tfonome = trim($_GET["tfonome"]);

$cadastro = new banco($conn, $db);

$sql = "SELECT max(tfocodigo) as codigo FROM tipoforma";

$sql = pg_query($sql);

$row = pg_num_rows($sql);

$codigo = (pg_fetch_result($sql, 0, "codigo") + 1);

$cadastro->insere("tipoforma", "(tfonome,tfocodigo)", "('$tfonome','$codigo')");

pg_close($conn);
exit();
?>