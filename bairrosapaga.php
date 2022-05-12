<?php

require_once("include/conexao.inc.php");
require_once("include/bairros.php");

$codigo=trim($_GET["codigo"]);

$cadastro = new banco($conn,$db);
$cadastro->apaga("bairros","$codigo");

pg_close($conn);
exit();
?>