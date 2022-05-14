<?php


require_once("include/conexao.inc.php");
require_once("include/pedcomprabaixacanc.php");

$nota = trim($_GET["nota"]);             
$cadastro = new banco($conn,$db);
$data=$cadastro->seleciona($nota);

//se encontrar registros
if(pg_num_rows($data)){
	header("Content-type: application/xml");
		
	$xml="<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";
	
	//preenchimento da Array com o nome dos campos
	for($i=0;$i < pg_num_fields($data);$i++){
		$campos[$i]=pg_field_name($data,$i);
	}	
	
	$xml.="<dados>";
	$xml.="<cabecalho>";
	
	//cabecalho da tabela
	for($i=0;$i < sizeof($campos);$i++){
		$xml.="<campo>".$campos[$i]."</campo>";
	}
	
	$xml.="</cabecalho>";
	
	//corpo da tabela
	while($row=pg_fetch_object($data)){
		$xml.="<registro>";
		for($i=0;$i < sizeof($campos);$i++){
                        if (trim($row->{$campos[$i]})!=''){
			$xml.="<item>".$row->{$campos[$i]}."</item>";
			}else
			{$xml.="<item>0</item>";}

		}
		$xml.="</registro>";
	}
	
	//fim da tabela
	$xml.="</dados>";	
}

echo $xml;
pg_close($conn);
exit();
?>