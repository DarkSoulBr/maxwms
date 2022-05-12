<?php

require_once("include/conexao.inc.php");

$motivo = trim($_GET["motivo"]);
$usuario = $_GET["usuario"];
$ctecodigo = $_GET["ctecodigo"];

$numero = $_GET["numero"];
$chave = $_GET["chave"];

$data = date("Y-m-d H:i:s");
$fuso = date("P");

$sql = "SELECT parambiente,ctelayoutversao,cteassinatura FROM parametros WHERE parcod = '1'";
$sql = pg_query($sql);
$row = pg_num_rows($sql);
$parambiente    	= "";
$ctelayoutversao 	= "";
$flagassina 		= "";	
if($row)
{	
	$parambiente    	= pg_fetch_result($sql, 0, "parambiente");
	$ctelayoutversao 	= pg_fetch_result($sql, 0, "ctelayoutversao");
	$flagassina 		= pg_fetch_result($sql, 0, "cteassinatura");	
}

if (trim($parambiente)==""){$parambiente = "1";}
if (trim($ctelayoutversao)==""){$ctelayoutversao = "1";}
if (trim($flagassina)==""){$flagassina = "2";}
   	
		
if ($ctelayoutversao == "1"){
	$versao	= '2.00';
}
else
{
	$versao	= '3.00';
}

$sql = "Select a.*,to_char(a.cteemissao, 'DD/MM/YYYY') as cteemissao1,b.tmonome,c.sernome,d.tomnome,e.tfonome,f.tctnome,g.descricao as cidinicio,";
$sql .= "h.descricao as cidfinal,i.descricao as cidrem,j.descricao as ciddes,k.descricao as cidexp,l.descricao as cidrec,m.descricao as cidtom,";
$sql .= "n.sitnome,cteperreducao,ctebasecalculo,ctepericms,ctevalicms,cteobsgeral,o.topnome,to_char(a.cteentrega, 'DD/MM/YYYY') as cteentrega1,p.descricao as cidemi,";

$sql .= "aa.codestado,aa.codcidade,aa.descricao as cid1,aa.uf as uf1,";

$sql .= "g.codestado as codestado2,g.codcidade as codcidade2,g.descricao as cid2,g.uf as uf2,";

$sql .= "h.codestado as codestado3,h.codcidade as codcidade3,h.descricao as cid3,h.uf as uf3";

$sql .= " from cte a ";

$sql .= " left join cidadesibge aa on aa.id = a.ctecidemissao";

$sql .= " left join tipomodal b on b.tmocodigo = a.tmocodigo";
$sql .= " left join tiposervico c on c.sercodigo = a.sercodigo";
$sql .= " left join tipotomador d on d.tomcodigo = a.tomcodigo";
$sql .= " left join tipoforma e on e.tfocodigo = a.tfocodigo";
$sql .= " left join tipocte f on f.tctcodigo = a.tctcodigo";
$sql .= " left join cidadesibge g on g.id = a.ctecidinicio";
$sql .= " left join cidadesibge h on h.id = a.ctecidfinal";
$sql .= " left join cidades i on i.cidcodigo = a.cteremcidcodigo";
$sql .= " left join cidades j on j.cidcodigo = a.ctedescidcodigo";

$sql .= " left join cidades k on k.cidcodigo = a.cteexpcidcodigo";
$sql .= " left join cidades l on l.cidcodigo = a.ctereccidcodigo";
$sql .= " left join cidades m on m.cidcodigo = a.ctetomcidcodigo";

$sql .= " left join tiposituacao n on n.sitcodigo = a.sitcodigo";

$sql .= " left join tipoopcao o on o.topcodigo = a.cteindlocacao";

$sql .= " left join cidades p on p.cidcodigo = a.cteemicidcodigo";

$sql .= " Where a.ctenumero = '$ctecodigo'";

$sql = pg_query($sql);
$row = pg_num_rows($sql);

if ($row) {

	$ctenumero = trim(pg_fetch_result($sql, 0, "ctenumero"));
	$ctemodelo = trim(pg_fetch_result($sql, 0, "ctemodelo"));
	$cteserie = trim(pg_fetch_result($sql, 0, "cteserie"));
	$ctenum = trim(pg_fetch_result($sql, 0, "ctenum"));
	$cteemissao = trim(pg_fetch_result($sql, 0, "cteemissao"));
	$ctehorario = trim(pg_fetch_result($sql, 0, "ctehorario"));
	
	$tmonome = trim(pg_fetch_result($sql, 0, "tmonome"));
	$tmocodigo = trim(pg_fetch_result($sql, 0, "tmocodigo"));
	$sernome = trim(pg_fetch_result($sql, 0, "sernome"));
	$ctechaveref = trim(pg_fetch_result($sql, 0, "ctechaveref"));
	$ctechavefin = trim(pg_fetch_result($sql, 0, "ctechavefin"));
	$datatomador = trim(pg_fetch_result($sql, 0, "ctedatatomador"));
	$tomnome = trim(pg_fetch_result($sql, 0, "tomnome"));
	$tfonome = trim(pg_fetch_result($sql, 0, "tfonome"));
	$ctecfop = trim(pg_fetch_result($sql, 0, "ctecfop"));
	$ctenatureza = trim(pg_fetch_result($sql, 0, "ctenatureza"));
	$tctcodigo = trim(pg_fetch_result($sql, 0, "tctcodigo"));
	$tctnome = trim(pg_fetch_result($sql, 0, "tctnome"));
	$cidinicio = trim(pg_fetch_result($sql, 0, "cidinicio"));
	$cteufinicio = trim(pg_fetch_result($sql, 0, "cteufinicio"));
	$cidfinal = trim(pg_fetch_result($sql, 0, "cidfinal"));
	$cteuffinal = trim(pg_fetch_result($sql, 0, "cteuffinal"));

	
	$codestado = trim(pg_fetch_result($sql, 0, "codestado"));
	$codcidade = trim(pg_fetch_result($sql, 0, "codcidade"));
	$cid1 = trim(pg_fetch_result($sql, 0, "cid1"));
	$uf1 = trim(pg_fetch_result($sql, 0, "uf1"));

	$cteemipessoa = trim(pg_fetch_result($sql, 0, "cteemipessoa"));
	$cteemicnpj = trim(pg_fetch_result($sql, 0, "cteemicnpj"));
	$cteemiie = trim(pg_fetch_result($sql, 0, "cteemiie"));
	$cteemicpf = trim(pg_fetch_result($sql, 0, "cteemicpf"));
	$cteemirg = trim(pg_fetch_result($sql, 0, "cteemirg"));
	$cteeminguerra = trim(pg_fetch_result($sql, 0, "cteeminguerra"));
	$cteemirazao = trim(pg_fetch_result($sql, 0, "cteemirazao"));
	$cteemicep = trim(pg_fetch_result($sql, 0, "cteemicep"));
	$cteemiendereco = trim(pg_fetch_result($sql, 0, "cteemiendereco"));
	$cteeminumero = trim(pg_fetch_result($sql, 0, "cteeminumero"));
	$cteemibairro = trim(pg_fetch_result($sql, 0, "cteemibairro"));
	$cteemicomplemento = trim(pg_fetch_result($sql, 0, "cteemicomplemento"));
	$cteemifone = trim(pg_fetch_result($sql, 0, "cteemifone"));
	$cteemipais = trim(pg_fetch_result($sql, 0, "cteemipais"));
	$cteemiuf = trim(pg_fetch_result($sql, 0, "cteemiuf"));
	$cteemicidcodigo = trim(pg_fetch_result($sql, 0, "cteemicidcodigo"));
	$cteemicidcodigoibge = trim(pg_fetch_result($sql, 0, "cteemicidcodigoibge"));
	$cidemi = trim(pg_fetch_result($sql, 0, "cidemi"));        

	//cUF - Código da UF do emitente do Documento Fiscal 
	//AAMM - Ano e Mês de emissão da NF-e (Nota Fiscal Eletrônica)
	//CNPJ - CNPJ do emitente
	//mod - Modelo do Documento Fiscal
	//serie - Série do Documento Fiscal
	//nNF - Número do Documento Fiscal
	//tpEmis – forma de emissão da NF-e													?
	//cNF - Código Numérico que compõe a Chave de Acesso								?
	//cDV - Dígito Verificador da Chave de Acesso										?
	//Exemplo:
	//<infCTe Id="CTe13130209191845000186550010000000591000000590" versao="1.01"> 


	$cnpj1 = trim($cteemicnpj);
	$cnpj1 = str_replace(".", "", $cnpj1);
	$cnpj1 = str_replace(",", "", $cnpj1);
	$cnpj1 = str_replace("-", "", $cnpj1);
	$cnpj1 = str_replace("/", "", $cnpj1);

	//26/10/2016
	//Cria um numero Randomico para o Codigo Numerico da Chave de Acesso
	$ctecodigox = mt_rand(1, 99999999);
	$ctecodigox = str_pad($ctecodigox, 8, "0", STR_PAD_LEFT);

	$infcteid = $codestado . substr($cteemissao, 2, 2) . substr($cteemissao, 5, 2) . $cnpj1 . $ctemodelo . $cteserie . str_pad($ctenum, 9, "0", STR_PAD_LEFT) . '1' . $ctecodigox;

	//$infcteid = '3516091070277000013057001000000345103010000';

	$digitoVerificador = dvCalcMod11($infcteid);

	$chaveCte = $infcteid . $digitoVerificador;
	
	$chaveCteInut = "ID" . $codestado . $cnpj1 . $ctemodelo . $cteserie . str_pad($ctenum, 9, "0", STR_PAD_LEFT) . str_pad($ctenum, 9, "0", STR_PAD_LEFT);
	
	$arq = $codestado . $cnpj1 . $ctemodelo . $cteserie . str_pad($ctenum, 9, "0", STR_PAD_LEFT) . str_pad($ctenum, 9, "0", STR_PAD_LEFT);

	$update = "Update cte set ctechave=$chaveCte,ctechaveinut='$chaveCteInut',ctedatainutiliza='$data',ctemotivoinutiliza='$motivo',usucodigoinutiliza='$usuario' Where ctenumero = '$ctecodigo'";        
	pg_query($update);

	$name = "/home/delta/cte/" . $arq . "-cte-inut.xml";
	
	$text = '<?xml version="1.0" encoding="UTF-8" ?>';	
	$text.= '<inutCTe versao="'.$versao.'" xmlns="http://www.portalfiscal.inf.br/cte">';
	$text.= '<infInut Id="'.$chaveCteInut.'">';
	$text.= '<tpAmb>1</tpAmb>'; 
	$text.= '<xServ>INUTILIZAR</xServ>'; 	
	$text.= '<cUF>'.$codestado.'</cUF>';
	$text.= '<ano>'.substr($data,2,2).'</ano>';	
	$text.= '<CNPJ>'.$cnpj1.'</CNPJ>';
	$text.= '<mod>'.(int)$ctemodelo.'</mod>';
	$text.= '<serie>'.(int)$cteserie.'</serie>';
	$text.= '<nCTIni>'.(int)$ctenum.'</nCTIni>';
	$text.= '<nCTFin>'.(int)$ctenum.'</nCTFin>';	
	$text.= '<xJust>'.$motivo.'</xJust>';	
	$text.= '</infInut>';
	$text.= '</inutCTe>';
	
	$file = fopen($name, 'w');
	fwrite($file, $text);
	fclose($file);

}

pg_close($conn);
exit();

function dvCalcMod11($key_nfe) {
    $base = 9;
    $result = 0;
    $sum = 0;
    $factor = 2;

    for ($i = strlen($key_nfe); $i > 0; $i--) {
        $numbers[$i] = substr($key_nfe, $i - 1, 1);
        $partial[$i] = $numbers[$i] * $factor;
        $sum += $partial[$i];
        if ($factor == $base) {
            $factor = 1;
        }
        $factor++;
    }

    if ($result == 0) {
        $sum *= 10;
        $digit = $sum % 11;
        if ($digit == 10) {
            $digit = 0;
        }
        return $digit;
    } elseif ($result == 1) {
        $rest = $sum % 11;
        return $rest;
    }
}

function removeTodosCaracterEspeciaisEspaco($text) {
    $palavra = $text;
    if (version_compare(PHP_VERSION, '7.0.0', '<')) {
        $palavra = ereg_replace("[^a-zA-Z0-9]", "", strtr($palavra, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ-", "aaaaeeiooouucAAAAEEIOOOUUC"));
    } else {
        $palavra = preg_replace("[^a-zA-Z0-9]", "", strtr($palavra, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ-", "aaaaeeiooouucAAAAEEIOOOUUC"));
    }
    return $palavra;
}

?>
