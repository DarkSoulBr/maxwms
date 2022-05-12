<?php
require_once("include/conexao.inc.php");
require_once("include/banco.php");

$usucodigo	=$_GET["usucodigo"];
$codservico	=$_GET["codservico"];
$servico	=$_GET["servico"];

$cadastro = new banco($conn,$db);

//VERIFICA SE VOLTOU ALGO
if($codservico=='' || $codservico=='0') {
	$cadastro->insere("infolacre","(usucodigo,lacnome)","('$usucodigo','$servico')");	
}
else {
	$cadastro->altera("infolacre","usucodigo='$usucodigo',lacnome='$servico'","laccodigo=$codservico"); 
}

pg_close($conn);
exit();
?>
