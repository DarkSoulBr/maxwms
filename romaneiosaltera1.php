<?php

require_once("include/conexao.inc.php");
require_once("include/romaneios.php");

$romcodigo = $_GET["romcodigo"];

$romveiculo = $_GET["romveiculo"];
$romdata = $_GET["romdata"];
$usucodigo = $_GET["usucodigo"];
if($usucodigo=='') {
    $usucodigo = 0;
}

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

$cadastro = new banco($conn, $db);

//Se mudou a data 

$sql = "SELECT romdata FROM romaneios WHERE romcodigo = $romcodigo";
$sql = pg_query($sql);
$row = pg_num_rows($sql);
$anterior = '';
if ($row) {
    $anterior = pg_fetch_result($sql, 0, "romdata");
    $anterior = substr($anterior, 0, 10);
}

if ($anterior == $romdata) {
    $cadastro->alteraromaneio("romaneios", "romveiculo='$romveiculo'
	,romsaida='$romsaida'
	,rommotorista='$rommotorista'
	,rominicial='$rominicial'
	,romfinal='$romfinal'
	,romtipofrete='$romtipofrete'
	,romobservacao='$romobservacao'
	,romvalor='$romvalor'
	,rompercentual='$rompercentual'
	,romajudante='$romajudante'
	,tracodigo='$tracodigo'
	", "$romcodigo");
} else {

    $aux = getdate();
    $auxemissao = substr($romdata, 0, 10) . ' ' . $aux['hours'] . ':' . $aux['minutes'] . ":" . $aux['seconds'] . '-03';

    $cadastro->alteraromaneio("romaneios", "romveiculo='$romveiculo'
	,romdata='$auxemissao'
	,romsaida='$romsaida'
	,rommotorista='$rommotorista'
	,rominicial='$rominicial'
	,romfinal='$romfinal'
	,romtipofrete='$romtipofrete'
	,romobservacao='$romobservacao'
	,romvalor='$romvalor'
	,rompercentual='$rompercentual'
	,romajudante='$romajudante'
	,tracodigo='$tracodigo'
	", "$romcodigo");
}

$dataLog = date('Y-m-d H:i:s');
$cadastro->insere("logromaneiosgeral", "(lgrdata,usucodigo,romcodigo,tracodigo,operacao)", "('$dataLog','$usucodigo','$romcodigo','$tracodigo',2)");

pg_close($conn);
exit();
?>
