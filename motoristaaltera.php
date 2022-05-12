<?php
require_once ( "include/conexao.inc.php" );
require_once ( "include/banco.php" );

$atual = date("Y-m-d");

$forcodigo = trim ( $_GET [ "forcodigo" ] );
$forcod = trim ( $_GET [ "forcod" ] );
$forrazao = trim ( $_GET [ "forrazao" ] );
$forcpf = trim ( $_GET [ "forcpf" ] );

$cadastro = new banco ( $conn , $db );

$cadastro -> altera ( "motoristas" , "motcod='$forcod',motrazao='$forrazao',motcpf='$forcpf',motalt='$atual'" , "motcodigo=$forcodigo" );

pg_close ( $conn );
exit ( );
?>