<?php
require_once("include/conexao.inc.php");
require_once("include/cidade.php");

$cidcodigo=trim($_GET["cidcodigo"]);

$cadastro = new banco($conn,$db);
$cadastro->apaga("cidades","$cidcodigo");

pg_close($conn);
exit();
?>