<?php
require_once ( "include/conexao.inc.php" );
require_once ( "include/banco.php" );

$atual = date("Y-m-d");

$veicodint = trim ( $_GET [ "veicodint" ] );
$veicodigo = trim ( $_GET [ "veicodigo" ] );
$usucodigo = trim ( $_GET [ "usucodigo" ] );
$veirenavam = trim ( $_GET [ "veirenavam" ] );
$veiplaca = trim ( $_GET [ "veiplaca" ] );
$veitara = trim ( $_GET [ "veitara" ] );
$veicapacidadekg = trim ( $_GET [ "veicapacidadekg" ] );
$veicapacidademt = trim ( $_GET [ "veicapacidademt" ] );
$veitiporodado = trim ( $_GET [ "veitiporodado" ] );
$veitipocarroceria = trim ( $_GET [ "veitipocarroceria" ] );
$veitipoveiculo = trim ( $_GET [ "veitipoveiculo" ] );
$veitipopropveiculo = trim ( $_GET [ "veitipopropveiculo" ] );
$listestados = trim ( $_GET [ "listestados" ] );
$veicnpj = trim ( $_GET [ "veicnpj" ] );
$veiie = trim ( $_GET [ "veiie" ] );
$veicpf = trim ( $_GET [ "veicpf" ] );
$veirg = trim ( $_GET [ "veirg" ] );
$veirntrc = trim ( $_GET [ "veirntrc" ] );
$veitipproprietario = trim ( $_GET [ "veitipproprietario" ] );
$listestados2 = trim ( $_GET [ "listestados2" ] );
$veirazao = trim ( $_GET [ "veirazao" ] );    
$veipessoa = trim ( $_GET [ "veipessoa" ] );  
$veiempresa = trim ( $_GET [ "veiempresa" ] );  

if($veicodint==""){$veicodint=0;}
if($veitara==""){$veitara=0;}
if($veicapacidadekg==""){$veicapacidadekg=0;}
if($veicapacidademt==""){$veicapacidademt=0;}


$cadastro = new banco ( $conn , $db );

if($veicodigo=='' || $veicodigo=='0') {
	$cadastro -> insere ( "infoveiculos" , "(veicod,veirenavam,veiplaca,veitara,veicapacidadekg,veicapacidadem3,veitprodado,veitpcarroceria,veitpveiculo,veipropveiculo,veiuf,veicnpj,veiie,veicpf,veirg,veirntrc,veitpproprietario,veipropuf,veirazao,veipessoa,veiempresa,usucodigo)" ,
	"('$veicodint','$veirenavam','$veiplaca',$veitara,$veicapacidadekg,$veicapacidademt,$veitiporodado,$veitipocarroceria,$veitipoveiculo,$veitipopropveiculo,'$listestados','$veicnpj','$veiie','$veicpf','$veirg','$veirntrc',$veitipproprietario,'$listestados2','$veirazao','$veipessoa','$veiempresa','$usucodigo')" );
}
else {
	$cadastro -> altera ( "infoveiculos" , "veicod='$veicodint',veirenavam='$veirenavam',veiplaca='$veiplaca',veitara='$veitara',
	veicapacidadekg='$veicapacidadekg',veicapacidadem3='$veicapacidademt',veitprodado='$veitiporodado',veitpcarroceria='$veitipocarroceria',
	veitpveiculo='$veitipoveiculo',veipropveiculo='$veitipopropveiculo',veiuf='$listestados',veicnpj='$veicnpj',
	veiie='$veiie',veicpf='$veicpf',veirg='$veirg',veirntrc='$veirntrc',veitpproprietario='$veitipproprietario',veipropuf='$listestados2',veirazao='$veirazao',veipessoa='$veipessoa',veiempresa='$veiempresa'"
	, "infveicodigo=$veicodigo" );
}	


	
pg_close ( $conn );
exit ( );

?>