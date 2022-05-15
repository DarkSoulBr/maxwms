<?php

require_once("include/conexao.inc.php");
require_once("include/contagem.php");

$invdata=trim($_GET["invdata"]);
$contagem=trim($_GET["contagem"]);
$coletor=trim($_GET["coletor"]);
$setor=trim($_GET["setor"]);

$aux = explode("/",$invdata);
$invdata = $aux[2].'-'.$aux[1].'-'.$aux[0].' 00:00:00-03';

$cadastro = new banco($conn,$db);
$data=$cadastro->selecionanovo($invdata,$contagem,$setor,$coletor);            

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
			if($i==1){
				$xml.="<item>".substr($row->{$campos[$i]},0,12)."</item>";
			}
			else {
				$xml.="<item>".$row->{$campos[$i]}."</item>";
			}	
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