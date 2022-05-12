<?php

require_once("include/conexao.inc.php");
require_once("include/romaneios.php");


$romnumeroano = $_GET["romnumeroano"];
$romnumeroano = "      " . $romnumeroano;
$romnumero = trim(substr($romnumeroano, -12, 7));
$romano = substr($romnumeroano, -4, 4);

$romveiculo = $_GET["romveiculo"];
$romdata = $_GET["romdata"];

$romdata = substr($romdata, 6, 4) . '-' . substr($romdata, 3, 2) . '-' . substr($romdata, 0, 2);

$romsaida = $_GET["romsaida"];
$rommotorista = $_GET["rommotorista"];

$romajudante = $_GET["romajudante"];

$rominicial = $_GET["rominicial"];
$romfinal = $_GET["romfinal"];
$romtipofrete = $_GET["romtipofrete"];
$romobservacao = $_GET["romobservacao"];

$romvalor = $_GET["romvalor"];
$rompercentual = $_GET["rompercentual"];

$tracodigo = $_GET["transp"];
$usucodigo = $_GET["usucodigo"];
if ($usucodigo == '') {
    $usucodigo = 0;
}
$romemissor = $_GET["romemissor"];

$aux = getdate();
$auxemissao = substr($romdata, 0, 10) . ' ' . $aux['hours'] . ':' . $aux['minutes'] . ":" . $aux['seconds'] . '-03';

$cadastro = new banco($conn, $db);

$cadastro->insere("romaneios", "(romnumero,romveiculo,romdata,
romsaida,rommotorista,rominicial,romfinal,romtipofrete,romobservacao,romano,romvalor,rompercentual,romajudante,tracodigo,usucodigo,romemissor)", "
('$romnumero','$romveiculo','$auxemissao','$romsaida','$rommotorista','$rominicial',
'$romfinal','$romtipofrete','$romobservacao','$romano','$romvalor','$rompercentual','$romajudante','$tracodigo','$usucodigo','$romemissor')");


//Grava um Log 

$sql = "SELECT romcodigo FROM romaneios WHERE romnumero = '$romnumero' AND romano = '$romano'";
$sql = pg_query($sql);
$row = pg_num_rows($sql);
$romcodigo = 0;
if ($row) {
    $romcodigo = pg_fetch_result($sql, 0, "romcodigo");
}

$romnumerox = $romnumero . '/' . $romano;

$dataLog = date('Y-m-d H:i:s');
$cadastro->insere("logromaneiosgeral", "(lgrdata,usucodigo,romcodigo,tracodigo,romnumero,operacao)", "('$dataLog','$usucodigo','$romcodigo','$tracodigo','$romnumerox',1)");

pg_close($conn);
exit();
?>
