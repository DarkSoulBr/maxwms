<?php 
require_once("include/conexao.inc.php");
require_once("include/banco.php");

//RECEBE PARÃMETRO
$parametro = trim($_REQUEST["parametro"]);
$parametro2 = trim($_REQUEST["parametro2"]);

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









$sql = "Delete FROM cteinfocarga where ctenumero = $parametro2";
pg_query($sql);

$sql = "Delete FROM cteinfocoleta where ctenumero = $parametro2";
pg_query($sql);

$sql = "Delete FROM cteinfoduplicata where ctenumero = $parametro2";
pg_query($sql);

$sql = "Delete FROM cteinfolacre where ctenumero = $parametro2";
pg_query($sql);

$sql = "Delete FROM cteinfomotoristas where ctenumero = $parametro2";
pg_query($sql);

$sql = "Delete FROM cteinfopedagio where ctenumero = $parametro2";
pg_query($sql);

$sql = "Delete FROM cteinfoseguro where ctenumero = $parametro2";
pg_query($sql);

$sql = "Delete FROM cteinfoveiculos where ctenumero = $parametro2";
pg_query($sql);

$sql = "Delete FROM ctenfechave where ctenumero = $parametro2";
pg_query($sql);

$sql = "Delete FROM cteobscontribuinte where ctenumero = $parametro2";
pg_query($sql);

$sql = "Delete FROM cteobsfisco where ctenumero = $parametro2";
pg_query($sql);

$sql = "Delete FROM cte where ctenumero = $parametro2";
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