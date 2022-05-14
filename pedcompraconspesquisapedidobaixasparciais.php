<?php


require_once("include/conexao.inc.php");
require_once("include/pedcompracons.php");

$pcnumero = trim($_GET["pcnumero"]);
$pcbaixa = trim($_GET["pcbaixa"]);
$codigoproduto = trim($_GET["codigoproduto"]);
$cadastro = new banco($conn,$db);
$data=$cadastro->seleciona_baixasparciais2($pcnumero,$pcbaixa,$codigoproduto);

header("Content-type: application/xml");
		
$xml="<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";

//se encontrar registros
if(pg_num_rows($data)){
	//preenchimento da Array com o nome dos campos
	for($i=0;$i < pg_num_fields($data);$i++){
		$campos[$i]=pg_field_name($data,$i);
	}	
	
	$xml.="<dados>";
	$xml.="<cabecalhob>";
	
	//cabecalho da tabela
	for($i=0;$i < sizeof($campos);$i++){
		$xml.="<campo>".$campos[$i]."</campo>";
	}
	
	$xml.="</cabecalhob>";
	
	//corpo da tabela
	while($row=pg_fetch_object($data)){
		$xml.="<registrob>";
		for($i=0;$i < sizeof($campos);$i++){
			if($i==5)
			$xml.="<itemb>".number_format($row->{$campos[$i]},2,',','')."</itemb>";
			else
			$xml.="<itemb>".$row->{$campos[$i]}."</itemb>";
		}
		$xml.="</registrob>";
	}
	
	//fim da tabela
	$xml.="</dados>";	
}
else $xml.="<dados></dados>";

print $xml;
pg_close($conn);
exit();
?>
