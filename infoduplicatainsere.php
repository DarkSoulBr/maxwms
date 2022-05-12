<?php
require_once("include/conexao.inc.php");
require_once("include/banco.php");

$usucodigo	=$_GET["usucodigo"];
$codservico	=$_GET["codservico"];
$servico	=$_GET["servico"];
$valor		=$_GET["valor"];
$vecto		=$_GET["vecto"];

$vecto = substr ( $vecto , 6 , 4 ) . '-' . substr ( $vecto , 3 , 2 ) . '-' . substr ( $vecto , 0 , 2 );

$cadastro = new banco($conn,$db);

//VERIFICA SE VOLTOU ALGO
if($codservico=='' || $codservico=='0') {
	$cadastro->insere("infoduplicata","(usucodigo,dupnome,dupvalor,dupvecto)","('$usucodigo','$servico','$valor','$vecto')");	
}
else {
	$cadastro->altera("infoduplicata","usucodigo='$usucodigo',dupnome='$servico',dupvalor='$valor',dupvecto='$vecto'","dupcodigo=$codservico"); 
}

pg_close($conn);
exit();
?>
