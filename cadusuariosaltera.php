<?php
require_once("include/conexao.inc.php");
require_once("include/cadusuarios.php");

$codigo=trim($_GET["codigo"]);
$descricao=trim($_GET["descricao"]);
$usuario=trim($_GET["usuario"]);
$login=trim($_GET["login"]);
$email=trim($_GET["email"]);

$cadastro = new banco($conn,$db);
$cadastro->altera("cadusuarios","usdescricao='$descricao'
,ususuario='$usuario'
,uslogin='$login'
,usemail='$email'

","$codigo");

pg_close($conn);
exit();
?>
