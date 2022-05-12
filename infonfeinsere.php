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
	$cadastro->insere("nfechave","(usucodigo,nfenome,nfepin)","('$usucodigo','$servico','$valor')");	
}
else {
	$cadastro->altera("nfechave","usucodigo='$usucodigo',nfenome='$servico',nfepin='$valor'","nfecodigo=$codservico"); 
}

pg_close($conn);
exit();
?>
