<?php 
require_once("include/conexao.inc.php");
require_once("include/aberturainventario.php");

$cadastro = new banco($conn,$db);

header("Content-type: application/xml");
$xml="<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";

$invdata 	= trim($_GET["invdata"]);
$contagem 	= trim($_GET["contagem"]);

$aux = explode("/",$invdata);
$invdata = $aux[2].'-'.$aux[1].'-'.$aux[0].' 00:00:00-03';

$status = '0';

//Verifica se a Contagem na data está encerrada
$sql = "Select * from inventariocontagemcon Where invdata = '" . $invdata . "' and concodigo = $contagem";
$sql = pg_query($sql);
$row = pg_num_rows($sql);
if ($row) {

	$sql = "UPDATE inventariocontagemcon SET invstatus=1 Where invdata = '" . $invdata . "' and concodigo = $contagem";
	pg_query($sql);
	
	
}
else {
	$dados = $cadastro->insere("inventariocontagemcon","(invdata,invstatus,concodigo)","('$invdata','1',$contagem)");	
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