<?php
$flagmenu=6;
require("verifica2.php");
require_once("include/conexao.inc.php");

$sql = "Update parametros set usucodigoedi = 0 Where parcodigo = 1 ";
$sql = pg_query($sql);

echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=maxwms.php?flagmenu=6'>";
exit;
