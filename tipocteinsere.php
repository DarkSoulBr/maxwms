<?php

require_once("include/conexao.inc.php");
require_once("include/tipocte.php");

$tctnome = trim($_GET["tctnome"]);

$cadastro = new banco($conn, $db);

$sql = "SELECT max(tctcodigo) as codigo FROM tipocte";

$sql = pg_query($sql);

$row = pg_num_rows($sql);

$codigo = (pg_fetch_result($sql, 0, "codigo") + 1);

$cadastro->insere("tipocte", "(tctnome,tctcodigo)", "('$tctnome','$codigo')");

pg_close($conn);
exit();
?>