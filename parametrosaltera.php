<?php   
require_once ( "include/conexao.inc.php" );
require_once ( "include/banco.php" );
  
$atual = date("Y-m-d"); 

$parambiente = trim ( $_GET [ "parambiente" ] );
$parversao = trim ( $_GET [ "parversao" ] );
$parcodigos = trim ( $_GET [ "parcodigos" ] );
$servico = trim ( $_GET [ "servico" ] );
$apolice = trim ( $_GET [ "apolice" ] );
$gerrntrc = trim ( $_GET [ "gerrntrc" ] );
$perc = trim ( $_GET [ "perc" ] );
if($perc==''){
	$perc=0;
}

$versaocte = trim ( $_GET [ "versaocte" ] );
$assinacte = trim ( $_GET [ "assinacte" ] );

$cadastro = new banco ( $conn , $db );

//$cadastro -> altera ( "parametros" , "parambiente=$parambiente,parversao='$parversao',ctesegnome='$servico',ctesegapolice='$apolice',cterntrc='$gerrntrc',cteperservico='$perc',ctelayoutversao='$versaocte'" , "parcodigos=$parcodigos" );
$cadastro -> altera ( "parametros" , "parambiente=$parambiente,parversao='$parversao',ctesegnome='$servico',ctesegapolice='$apolice',cterntrc='$gerrntrc',cteperservico='$perc',ctelayoutversao='$versaocte',cteassinatura='$assinacte'" , "parcodigos=$parcodigos" );

pg_close ( $conn );
exit ( );
?>