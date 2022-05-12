<?php

require_once("include/conexao.inc.php");
require_once("include/tipopagamento.php");

$tpgnome = trim($_GET["tpgnome"]);

$cadastro = new banco($conn, $db);

$sql = "SELECT max(tpgcodigo) as codigo FROM tipopagamento";

$sql = pg_query($sql);

$row = pg_num_rows($sql);

$codigo = (pg_fetch_result($sql, 0, "codigo") + 1);

$cadastro->insere("tipopagamento", "(tpgnome,tpgcodigo)", "('$tpgnome','$codigo')");

pg_close($conn);
exit();
?>