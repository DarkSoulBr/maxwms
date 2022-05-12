<?php
require_once("include/conexao.inc.php");
require_once("include/banco.php");

$usucodigo	=$_GET["usucodigo"];
$codservico	=$_GET["codservico"];
$servico	=$_GET["servico"];
$valor		=$_GET["valor"];
$forne		=$_GET["forne"];
$respo		=$_GET["respo"];

$cadastro = new banco($conn,$db);

//VERIFICA SE VOLTOU ALGO
if($codservico=='' || $codservico=='0') {
	$cadastro->insere("infopedagio","(usucodigo,pednome,pedvalor,pedforne,pedrespo)","('$usucodigo','$servico','$valor','$forne','$respo')");	
}
else {
	$cadastro->altera("infopedagio","usucodigo='$usucodigo',pednome='$servico',pedvalor='$valor',pedforne='$forne',pedrespo='$respo'","pedcodigo=$codservico"); 
}

pg_close($conn);
exit();
?>
