<?php    
require_once("include/conexao.inc.php"); 
require_once("include/usuario.php");

$codigo=trim($_GET["codigo"]);
$descricao3=trim($_GET["descricao3"]);
$descricao3=md5($descricao3);

$cadastro = new banco($conn,$db);
$cadastro->altera("cadusuarios","ussenha='$descricao3'","$codigo");

pg_close($conn);
exit();
?>
