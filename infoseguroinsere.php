<?php
require_once("include/conexao.inc.php");
require_once("include/banco.php");

$usucodigo	=$_GET["usucodigo"];
$codservico	=$_GET["codservico"];
$servico	=$_GET["servico"];
$valor		=$_GET["valor"];
$grupo		=$_GET["grupo"];
$apolice	=$_GET["apolice"];
$averbacao	=$_GET["averbacao"];

$cadastro = new banco($conn,$db);

//VERIFICA SE VOLTOU ALGO
if($codservico=='' || $codservico=='0') {
	$cadastro->insere("infoseguro","(usucodigo,segnome,segvalor,rescodigo,segapolice,segaverbacao)","('$usucodigo','$servico','$valor','$grupo','$apolice','$averbacao')");	
}
else {
	$cadastro->altera("infoseguro","usucodigo='$usucodigo',segnome='$servico',segvalor='$valor',rescodigo='$grupo',segapolice='$apolice',segaverbacao='$averbacao'","segcodigo=$codservico"); 
}

pg_close($conn);
exit();
?>
