<?php
require_once("include/conexao.inc.php");
require_once("include/banco.php");

$codigo=$_GET["codigo"];

$cadastro = new banco($conn,$db);
$cadastro->apaga("nfechave","nfecodigo=$codigo");

pg_close($conn);
exit();
?>
