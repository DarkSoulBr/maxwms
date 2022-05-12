<?php
require_once("include/conexao.inc.php");
require_once("include/banco.php");

//RECEBE PARÃMETRO
$parametro = trim($_REQUEST["parametro"]);

$cadastro = new banco($conn,$db);

$sql = "Delete FROM infocarga where usucodigo = $parametro";
pg_query($sql);

$sql = "Delete FROM infocoleta where usucodigo = $parametro";
pg_query($sql);

$sql = "Delete FROM infoduplicata where usucodigo = $parametro";
pg_query($sql);

$sql = "Delete FROM infolacre where usucodigo = $parametro";
pg_query($sql);

$sql = "Delete FROM infomotoristas where usucodigo = $parametro";
pg_query($sql);

$sql = "Delete FROM infopedagio where usucodigo = $parametro";
pg_query($sql);

$sql = "Delete FROM infoseguro where usucodigo = $parametro";
pg_query($sql);

$sql = "Delete FROM infoveiculos where usucodigo = $parametro";
pg_query($sql);

$sql = "Delete FROM nfechave where usucodigo = $parametro";
pg_query($sql);


$sql = "Delete FROM obscontribuinte where usucodigo = $parametro";
pg_query($sql);

$sql = "Delete FROM obsfisco where usucodigo = $parametro";
pg_query($sql);

$sql = "Delete FROM valorservico where usucodigo = $parametro";
pg_query($sql);


 


   	//XML
   	$xml  = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
   	$xml .= "<dados>\n";

	$xml .= "<dado>\n";
	$xml .= "<descricao>1</descricao>\n";
	$xml .= "</dado>\n";
	
   	$xml.= "</dados>\n";

   //CABEÇALHO
   Header("Content-type: application/xml; charset=iso-8859-1");


//PRINTA O RESULTADO
echo $xml;
?>