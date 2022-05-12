<?php
require_once("include/conexao.inc.php");
require_once("include/banco.php");

$usucodigo	=$_GET["usucodigo"];
$codservico	=$_GET["codservico"];
$servico	=$_GET["servico"];
$valor		=$_GET["valor"];

$cadastro = new banco($conn,$db);

//VERIFICA SE VOLTOU ALGO
if($codservico=='' || $codservico=='0') {
	$cadastro->insere("valorservico","(usucodigo,valnome,valvalor)","('$usucodigo','$servico','$valor')");	
}
else {
	$cadastro->altera("valorservico","usucodigo='$usucodigo',valnome='$servico',valvalor='$valor'","valcodigo=$codservico"); 
}

pg_close($conn);
exit();
?>
