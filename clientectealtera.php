<?php
require_once ( "include/conexao.inc.php" );
require_once ( "include/banco.php" );

$atual = date("Y-m-d");

$forcodigo = trim ( $_GET [ "forcodigo" ] );
$fornguerra = trim ( $_GET [ "fornguerra" ] );
$forcod = trim ( $_GET [ "forcod" ] );
$forrazao = trim ( $_GET [ "forrazao" ] );
$forsuframa = trim ( $_GET [ "forsuframa" ] );
$fnenumero = trim ( $_GET [ "fnenumero" ] );
$forie = trim ( $_GET [ "forie" ] );
$forcnpj = trim ( $_GET [ "forcnpj" ] );
$forie = trim ( $_GET [ "forie" ] );
$forrg = trim ( $_GET [ "forrg" ] );
$forcpf = trim ( $_GET [ "forcpf" ] );
$forobs = trim ( $_GET [ "forobs" ] );
$forpessoa = trim ( $_GET [ "forpessoa" ] );
$fnecep = trim ( $_GET [ "fnecep" ] );
$fneendereco = trim ( $_GET [ "fneendereco" ] );
$fnebairro = trim ( $_GET [ "fnebairro" ] );
$fnefone = trim ( $_GET [ "fnefone" ] );
$fnecomplemento = trim ( $_GET [ "fnecomplemento" ] );
$fneemail = trim ( $_GET [ "fneemail" ] );

$fnecodcidade = trim ( $_GET [ "fnecodcidade" ] );
$cidadeibge = trim ( $_GET [ "cidcodigoibge" ] );

$fornfe = trim ( $_GET [ "fornfe" ] );
if($fornfe==''){
	$fornfe = 0;	
}

$cadastro = new banco ( $conn , $db );

$cadastro -> altera ( "clientescte" , "clinguerra='$fornguerra',clicod='$forcod',clirazao='$forrazao',clicnpj='$forcnpj',cliie='$forie',clirg='$forrg',clicpf='$forcpf',cliobs='$forobs',clipessoa='$forpessoa',clisuframa='$forsuframa',clialt='$atual',clicep='$fnecep',cliendereco='$fneendereco',clibairro='$fnebairro',clifone='$fnefone',clicomplemento='$clicomplemento',cliemail='$fneemail',cidcodigo='$fnecodcidade',cidcodigoibge='$cidadeibge',clinumero='$fnenumero',cliNFE='$fornfe'" , "clicodigo=$forcodigo" );

pg_close ( $conn );
exit ( );
?>