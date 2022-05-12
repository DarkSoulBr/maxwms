<?php
require_once("include/conexao.inc.php");
require_once("include/banco.php");

$usucodigo	=$_GET["usucodigo"];
$codcoleta	=$_GET["codcoleta"];
$serie		=$_GET["serie"];
$numero		=$_GET["numero"];
$emissao	=$_GET["emissao"];
$forcnpj	=$_GET["forcnpj"];
$forie		=$_GET["forie"];
$estado		=$_GET["estado"];
$fone		=$_GET["fone"];
$interno	=$_GET["interno"];

$emissao = substr ( $emissao , 6 , 4 ) . '-' . substr ( $emissao , 3 , 2 ) . '-' . substr ( $emissao , 0 , 2 );

$cadastro = new banco($conn,$db);

//VERIFICA SE VOLTOU ALGO
if($codcoleta=='' || $codcoleta=='0') {
	$cadastro->insere("infocoleta","(usucodigo,colserie,colnumero,colemissao,colcnpj,colie,coluf,colfone,colinterno)","('$usucodigo','$serie','$numero','$emissao','$forcnpj','$forie','$estado','$fone','$interno')");	
}
else {
	$cadastro->altera("infocoleta","usucodigo='$usucodigo',colserie='$serie',colnumero='$numero',colemissao='$emissao',colcnpj='$forcnpj',colie='$forie',coluf='$estado',colfone='$fone',colinterno='$interno'","colcodigo=$codcoleta"); 
}

pg_close($conn);
exit();
?>
