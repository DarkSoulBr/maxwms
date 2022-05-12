<?php
require_once("include/conexao.inc.php");
require_once("include/cadusuarios.php");

$descricao=trim($_GET["descricao"]);
$usuario=trim($_GET["usuario"]);
$login=trim($_GET["login"]);
$email=trim($_GET["email"]);
$senha=trim($_GET["senha"]);
$senha=md5($senha);

$cadastro = new banco($conn,$db);
$cadastro->insere("cadusuarios","(usdescricao,ususuario,uslogin,usemail,ussenha)","('$descricao','$usuario','$login','$email','$senha')");

pg_close($conn);
exit();
?>