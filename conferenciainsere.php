<?php
require_once("include/conexao.inc.php");
require_once("include/conferencia.php");

$procodigo=trim($_GET["procodigo"]);
$pvnumero=trim($_GET["pvnumero"]);
$pvcestoque=trim($_GET["pvcestoque"]);
$pvcconfere=trim($_GET["pvcconfere"]);

$cadastro = new banco($conn,$db);

$cadastro->insere("pvendaconfere","(procodigo,pvnumero,pvcestoque,pvcconfere)","('$procodigo','$pvnumero','$pvcestoque','$pvcconfere')");

pg_close($conn);
exit();
?>