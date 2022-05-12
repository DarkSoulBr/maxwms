<?php
require_once("include/conexao.inc.php");
require_once("include/ibge.php");

$cidcodigo=trim($_GET["cidcodigo"]);

$cadastro = new banco($conn,$db);
$cadastro->apaga("cidadesibge","$cidcodigo");

pg_close($conn);
exit();
?>