<?php
require_once("include/conexao.inc.php");
require_once("include/linha.php");

$linnome=trim($_GET["linnome"]);
$codigovtex=trim($_GET["codigovtex"]);
$codigotricae=trim($_GET["codigotricae"]);

$grucodigo=trim($_GET["grucodigo"]);
$subcodigo=trim($_GET["subcodigo"]);

if($codigovtex==''){
	$codigovtex='0';
}
if($codigotricae==''){
	$codigotricae='0';
}

$cadastro = new banco($conn,$db);
$cadastro->insere("linha","(linnome,codigovtex,codigotricae,grucodigo,subcodigo)","('$linnome',$codigovtex,$codigotricae,$grucodigo,$subcodigo)");

pg_close($conn);
exit();
?>