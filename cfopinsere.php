<?php

require_once("include/conexao.inc.php");
require_once("include/cfop.php");

$cfonome = trim($_GET["cfonome"]);
$cfocod = trim($_GET["cfocod"]);

$cadastro = new banco($conn, $db);

$sql = "SELECT max(cfocodigo) as codigo FROM cfop";

$sql = pg_query($sql);

$row = pg_num_rows($sql);

$codigo = (pg_fetch_result($sql, 0, "codigo") + 1);

$cadastro->insere("cfop", "(cfonome,cfocodigo,cfocod)", "('$cfonome','$codigo','$cfocod')");

pg_close($conn);
exit();
?>