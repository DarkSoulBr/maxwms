<?php 
require_once("include/conexao.inc.php");
require_once("include/aberturainventario.php");

$cadastro = new banco($conn,$db);

header("Content-type: application/xml");
$xml="<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";

$invdata = trim($_GET["invdata"]);

$aux = explode("/",$invdata);
$invdata = $aux[2].'-'.$aux[1].'-'.$aux[0].' 00:00:00-03';

$status = '0';

//Verifica se tem Contagem na data
$sql = "Select * from inventariocontagem Where invdata = '" . $invdata . "'";
$sql = pg_query($sql);
$row = pg_num_rows($sql);
if ($row) {
	$status = '1';
}
else {
	//Verifica se tem Contagem na data
	$sql = "Select * from inventariocontagem Where invstatus = 0";
	$sql = pg_query($sql);
	$row = pg_num_rows($sql);
	if ($row) {
		$status = '2';
	}
	else {
		$dados = $cadastro->insere("inventariocontagem","(invdata,invstatus)","('$invdata','0')");
	}
}


$xml = "<dadosinv>
<registroinv>
<iteminv>";

$xml .= $status;

$xml .= "</iteminv>
</registroinv>
</dadosinv>";

echo $xml;

pg_close($conn);
exit();
?>