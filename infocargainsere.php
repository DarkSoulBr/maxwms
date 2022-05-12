<?php
require_once("include/conexao.inc.php");
require_once("include/banco.php");

$usucodigo	=$_GET["usucodigo"];
$codservico	=$_GET["codservico"];
$servico	=$_GET["servico"];
$valor		=$_GET["valor"];
$grupo		=$_GET["grupo"];

$cadastro = new banco($conn,$db);

//VERIFICA SE VOLTOU ALGO
if($codservico=='' || $codservico=='0') {
	$cadastro->insere("infocarga","(usucodigo,infnome,infvalor,medcodigo)","('$usucodigo','$servico','$valor','$grupo')");	
}
else {
	$cadastro->altera("infocarga","usucodigo='$usucodigo',infnome='$servico',infvalor='$valor',medcodigo='$grupo'","infcodigo=$codservico"); 
}

pg_close($conn);
exit();
?>
