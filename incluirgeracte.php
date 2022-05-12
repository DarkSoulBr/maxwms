<?php    
require_once("include/conexao.inc.php");
require_once("include/banco.php");

//------------- variáveis -----------------// 
$flag = $_GET["flag"];

//---------- instancia o objeto -----------//
$cadastro = new banco($conn,$db);

//---- Cabeçalho para a geração do xml ----//
header("Content-type: application/xml");
$xml="<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";


//----- Número do orçamento cadastrado ----//
if($flag=="NumeroOrcamento")
{
	//Faz a busca do nº MAX do orçamento
	$query_num_orcamento = $cadastro->seleciona("max(ctenumero) as total","cte","1=1");
	$array_num_orcamento = pg_fetch_object($query_num_orcamento);

	if($array_num_orcamento->total=="")
	$array_num_orcamento->total=0;	
	$array_num_orcamento->total++;
	
	//$numero = delimitador(trim($array_num_orcamento->total),'9','R','0');
	
	$emissao=date('d').'/'.date('m').'/'.date('Y');
	$hora=date('H').':'.date('i');
	
	
	//Faz a busca do nº MAX do ctenum
	$query_num_orcamento2 = $cadastro->seleciona("max(ctenum) as total2","cte","1=1");
	$array_num_orcamento2 = pg_fetch_object($query_num_orcamento2);

	if($array_num_orcamento2->total2=="")
	$array_num_orcamento2->total2=0;	
	$array_num_orcamento2->total2++;
	
	$numero = delimitador(trim($array_num_orcamento2->total2),'9','R','0');	
	
	

	$xml = "<dados>
	<registro>
		<item>".$array_num_orcamento->total."</item>
		<item>"."57"."</item>
		<item>"."001"."</item>
		<item>".$numero."</item>
		<item>".$emissao."</item>
		<item>".$hora."</item>
	</registro>
	</dados>";
	echo $xml;
	pg_close($conn);
	exit();
}

function delimitador($variavel,$tamanho,$alinhamento,$preenchimento)
{
	if($tamanho<10 && $alinhamento=='R' && $preenchimento == '0')
	$strtam = "%0".$tamanho."s";
	else if($tamanho<10 && $alinhamento=='L' && $preenchimento == '0')
		$strtam = "%-0".$tamanho."s";
		else if($tamanho<10 && $alinhamento=='R' && $preenchimento == ' ')
			$strtam = "%".$tamanho."s";
			else if($tamanho<10 && $alinhamento=='L' && $preenchimento == ' ')
				$strtam = "%-".$tamanho."s";

	if($tamanho>=10 && $alinhamento=='R' && $preenchimento == '0')
	$strtam = "%0".$tamanho."s";
	else if($tamanho>=10 && $alinhamento=='L' && $preenchimento == '0')
		$strtam = "%-0".$tamanho."s";
		else if($tamanho>=10 && $alinhamento=='R' && $preenchimento == ' ')
			$strtam = "%".$tamanho."s";
			else if($tamanho>=10 && $alinhamento=='L' && $preenchimento == ' ')
				$strtam = "%-".$tamanho."s";

	$var = substr(sprintf($strtam,$variavel),0,$tamanho);
	return $var;
}

?>