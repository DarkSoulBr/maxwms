<?php
require_once ( "include/conexao.inc.php" );
require_once ( "include/banco.php" );

$atual = date("Y-m-d");



$veicodigo = trim ( $_GET [ "veicodigo" ] );
$veicodint = trim ( $_GET [ "veicodint" ] );
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

$cadastro -> altera ( "veiculoscte" , "veicod='$veicodint',veirenavam='$veirenavam',veiplaca='$veiplaca',veitara='$veitara',
veicapacidadekg='$veicapacidadekg',veicapacidadem3='$veicapacidademt',veitprodado='$veitiporodado',veitpcarroceria='$veitipocarroceria',
veitpveiculo='$veitipoveiculo',veipropveiculo='$veitipopropveiculo',veiuf='$listestados',veicnpj='$veicnpj',
veiie='$veiie',veicpf='$veicpf',veirg='$veirg',veirntrc='$veirntrc',veitpproprietario='$veitipproprietario',veipropuf='$listestados2',veirazao='$veirazao',veipessoa='$veipessoa',veiempresa='$veiempresa'"
, "veicodigo=$veicodigo" );



pg_close ( $conn );
exit ( );
?>