<?php
require_once("include/conexao.inc.php");
require_once("include/banco.php");

$usucodigo	=$_GET["usucodigo"];
$codservico	=$_GET["codservico"];
$servico	=$_GET["servico"];
$obsgeral	=$_GET["obsgeral"];

$cadastro = new banco($conn,$db);

//VERIFICA SE VOLTOU ALGO
if($codservico=='' || $codservico=='0') {
	$cadastro->insere("obsfisco","(usucodigo,fisnome,fisobs)","('$usucodigo','$servico','$obsgeral')");	
}
else {
	$cadastro->altera("obsfisco","usucodigo='$usucodigo',fisnome='$servico',fisobs='$obsgeral'","fiscodigo=$codservico"); 
}

pg_close($conn);
exit();
?>
