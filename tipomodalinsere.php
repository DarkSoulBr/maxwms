<?php

require_once("include/conexao.inc.php");
require_once("include/tipomodal.php");

$tmonome = trim($_GET["tmonome"]);

$cadastro = new banco($conn, $db);

$sql = "SELECT max(tmocodigo) as codigo FROM tipomodal";

$sql = pg_query($sql);

$row = pg_num_rows($sql);

$codigo = (pg_fetch_result($sql, 0, "codigo") + 1);

$cadastro->insere("tipomodal", "(tmonome,tmocodigo)", "('$tmonome','$codigo')");

pg_close($conn);
exit();
?>