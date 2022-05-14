<?php

 
require_once("include/conexao.inc.php");
require_once("include/consultamovimentacao3.php");

set_time_limit ( 0 );

$codigoproduto = trim($_GET["codigoproduto"]);

$dtinicio = trim($_GET["dtinicio"]);
$dtfinal = trim($_GET["dtfinal"]);

$deposito = trim($_GET["deposito"]);


//$codigoproduto = 1407;

//$dtinicio = '01/01/2008';
//$dtfinal = '01/01/2020';

//$deposito = 9;


$dtinicio=substr($dtinicio, 6, 4).substr($dtinicio, 3, 2).substr($dtinicio, 0, 2);
$dtfinal=substr($dtfinal, 6, 4).substr($dtfinal, 3, 2).substr($dtfinal, 0, 2);

$cadastro = new banco($conn,$db);
$data=$cadastro->selecionanovo($codigoproduto,$dtinicio,$dtfinal,$deposito);

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
		for($i=0;$i < (sizeof($campos) - 1) ;$i++){
			$xml.="<item>".$row->{$campos[$i]}."</item>";
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
