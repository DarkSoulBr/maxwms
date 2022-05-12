<?php     
require_once("include/conexao.inc.php");

//ini_set("display_errors", 1);
//error_reporting(E_ALL);

$parametro = $_GET['cte'];

$chaveCte = '';
$erroCte = '';

$sql="Select a.*,to_char(a.cteemissao, 'DD/MM/YYYY') as cteemissao1,b.tmonome,c.sernome,d.tomnome,e.tfonome,f.tctnome,g.descricao as cidinicio,";
$sql.="h.descricao as cidfinal,i.descricao as cidrem,j.descricao as ciddes,k.descricao as cidexp,l.descricao as cidrec,m.descricao as cidtom,";
$sql.="n.sitnome,cteperreducao,ctebasecalculo,ctepericms,ctevalicms,cteobsgeral,o.topnome,to_char(a.cteentrega, 'DD/MM/YYYY') as cteentrega1,p.descricao as cidemi,";

$sql.="aa.codestado,aa.codcidade,aa.descricao as cid1,aa.uf as uf1,";

$sql.="g.codestado as codestado2,g.codcidade as codcidade2,g.descricao as cid2,g.uf as uf2,";

$sql.="h.codestado as codestado3,h.codcidade as codcidade3,h.descricao as cid3,h.uf as uf3";

$sql.=" from cte a ";

$sql.=" left join cidadesibge aa on aa.id = a.ctecidemissao";	

$sql.=" left join tipomodal b on b.tmocodigo = a.tmocodigo";
$sql.=" left join tiposervico c on c.sercodigo = a.sercodigo";
$sql.=" left join tipotomador d on d.tomcodigo = a.tomcodigo";
$sql.=" left join tipoforma e on e.tfocodigo = a.tfocodigo";	
$sql.=" left join tipocte f on f.tctcodigo = a.tctcodigo";	
$sql.=" left join cidadesibge g on g.id = a.ctecidinicio";	
$sql.=" left join cidadesibge h on h.id = a.ctecidfinal";	
$sql.=" left join cidades i on i.cidcodigo = a.cteremcidcodigo";	
$sql.=" left join cidades j on j.cidcodigo = a.ctedescidcodigo";	

$sql.=" left join cidades k on k.cidcodigo = a.cteexpcidcodigo";	
$sql.=" left join cidades l on l.cidcodigo = a.ctereccidcodigo";	
$sql.=" left join cidades m on m.cidcodigo = a.ctetomcidcodigo";	

$sql.=" left join tiposituacao n on n.sitcodigo = a.sitcodigo";	

$sql.=" left join tipoopcao o on o.topcodigo = a.cteindlocacao";	

$sql.=" left join cidades p on p.cidcodigo = a.cteemicidcodigo";
	
$sql.=" Where a.ctenumero = '$parametro'";

$dir = "/home/delta/cte_proceda/";

$ident_intercambio ="CON" . date("dmHi") . "1";
		
$caminhoArquivo = $dir.$ident_intercambio . ".txt";

$count = 1;

//Verifica se há arquivo gerado com esse mesmo nome e nesse caso adiciona o próximo contador nos tres últimos dígitos
while(file_exists($caminhoArquivo)){
	$ident_intercambio = substr($ident_intercambio, 0, -1). trim((string)$count);
	$caminhoArquivo = $dir.$ident_intercambio . ".txt";
	$count++;
}

$nome = $caminhoArquivo;
$arquivo = fopen("$nome","x+");
		
$sql = pg_query($sql);
$row = pg_num_rows($sql);

$totCte = 0;
$qtdCte = 0;

if($row) {
	  	   
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
	
	$remcodigo = trim(pg_fetch_result($sql, 0, "remcodigo"));
	$cteremrazao = trim(pg_fetch_result($sql, 0, "cteremrazao"));
	$cteremendereco = trim(pg_fetch_result($sql, 0, "cteremendereco"));
	$cterembairro = trim(pg_fetch_result($sql, 0, "cterembairro"));
	$cteremnumero = trim(pg_fetch_result($sql, 0, "cteremnumero"));
	$cidrem = trim(pg_fetch_result($sql, 0, "cidrem"));
	$cteremfone = trim(pg_fetch_result($sql, 0, "cteremfone"));
	$cterempais = trim(pg_fetch_result($sql, 0, "cterempais"));
	$cteremuf = trim(pg_fetch_result($sql, 0, "cteremuf"));
	
	$cterempessoa = trim(pg_fetch_result($sql, 0, "cterempessoa"));
	$cteremcep = trim(pg_fetch_result($sql, 0, "cteremcep"));
	$cteremcnpj = trim(pg_fetch_result($sql, 0, "cteremcnpj"));
	$cteremie = trim(pg_fetch_result($sql, 0, "cteremie"));
	$cteremcpf = trim(pg_fetch_result($sql, 0, "cteremcpf"));
	$cteremcidcodigoibge = trim(pg_fetch_result($sql, 0, "cteremcidcodigoibge"));
	
	if ($cterempessoa=='1'){
		$cteremdoc = $cteremcnpj;
	}
	else
	{
		$cteremdoc = $cteremcpf;
	}
			
	$descodigo = trim(pg_fetch_result($sql, 0, "descodigo"));
	$ctedesrazao = trim(pg_fetch_result($sql, 0, "ctedesrazao"));
	$ctedesendereco = trim(pg_fetch_result($sql, 0, "ctedesendereco"));
	$ctedescomplemento = trim(pg_fetch_result($sql, 0, "ctedescomplemento"));
	$ctedesbairro = trim(pg_fetch_result($sql, 0, "ctedesbairro"));
	$ctedesnumero = trim(pg_fetch_result($sql, 0, "ctedesnumero"));
	$ctedessuframa = trim(pg_fetch_result($sql, 0, "ctedessuframa"));
	$ciddes = trim(pg_fetch_result($sql, 0, "ciddes"));
	$ctedesfone = trim(pg_fetch_result($sql, 0, "ctedesfone"));
	$ctedespais = trim(pg_fetch_result($sql, 0, "ctedespais"));
	$ctedesuf = trim(pg_fetch_result($sql, 0, "ctedesuf"));
	
	$ctedespessoa = trim(pg_fetch_result($sql, 0, "ctedespessoa"));
	$ctedescep = trim(pg_fetch_result($sql, 0, "ctedescep"));
	$ctedescnpj = trim(pg_fetch_result($sql, 0, "ctedescnpj"));
	$ctedesie = trim(pg_fetch_result($sql, 0, "ctedesie"));	
	$ctedescpf = trim(pg_fetch_result($sql, 0, "ctedescpf"));
	
	if ($ctedespessoa=='1'){
		$ctedesdoc = $ctedescnpj;
	}
	else
	{
		$ctedesdoc = $ctedescpf;
	}
	
	$expcodigo = trim(pg_fetch_result($sql, 0, "expcodigo"));
	$cteexprazao = trim(pg_fetch_result($sql, 0, "cteexprazao"));
	$cteexpendereco = trim(pg_fetch_result($sql, 0, "cteexpendereco"));
	$cteexpcomplemento = trim(pg_fetch_result($sql, 0, "cteexpcomplemento"));
	$cteexpbairro = trim(pg_fetch_result($sql, 0, "cteexpbairro"));
	$cteexpnumero = trim(pg_fetch_result($sql, 0, "cteexpnumero"));
	$cidexp = trim(pg_fetch_result($sql, 0, "cidexp"));
	$cteexpfone = trim(pg_fetch_result($sql, 0, "cteexpfone"));
	$cteexppais = trim(pg_fetch_result($sql, 0, "cteexppais"));
	$cteexpuf = trim(pg_fetch_result($sql, 0, "cteexpuf"));
	
	$cteexppessoa = trim(pg_fetch_result($sql, 0, "cteexppessoa"));
	$cteexpcep = trim(pg_fetch_result($sql, 0, "cteexpcep"));
	$cteexpcnpj = trim(pg_fetch_result($sql, 0, "cteexpcnpj"));
	$cteexpie = trim(pg_fetch_result($sql, 0, "cteexpie"));
	$cteexpcpf = trim(pg_fetch_result($sql, 0, "cteexpcpf"));
	
	if ($cteexppessoa=='1'){
		$cteexpdoc = $cteexpcnpj;
	}
	else
	{
		$cteexpdoc = $cteexpcpf;
	}
	
	$reccodigo = trim(pg_fetch_result($sql, 0, "reccodigo"));
	$cterecrazao = trim(pg_fetch_result($sql, 0, "cterecrazao"));
	$cterecendereco = trim(pg_fetch_result($sql, 0, "cterecendereco"));
	$ctereccomplemento = trim(pg_fetch_result($sql, 0, "ctereccomplemento"));
	$cterecbairro = trim(pg_fetch_result($sql, 0, "cterecbairro"));
	$cterecnumero = trim(pg_fetch_result($sql, 0, "cterecnumero"));
	$cidrec = trim(pg_fetch_result($sql, 0, "cidrec"));
	$cterecfone = trim(pg_fetch_result($sql, 0, "cterecfone"));
	$cterecpais = trim(pg_fetch_result($sql, 0, "cterecpais"));
	$cterecuf = trim(pg_fetch_result($sql, 0, "cterecuf"));
	
	$cterecpessoa = trim(pg_fetch_result($sql, 0, "cterecpessoa"));
	$ctereccep = trim(pg_fetch_result($sql, 0, "ctereccep"));
	$ctereccnpj = trim(pg_fetch_result($sql, 0, "ctereccnpj"));
	$cterecie = trim(pg_fetch_result($sql, 0, "cterecie"));
	$ctereccpf = trim(pg_fetch_result($sql, 0, "ctereccpf"));
	
	if ($cterecpessoa=='1'){
		$cterecdoc = $ctereccnpj;
	}
	else
	{
		$cterecdoc = $ctereccpf;
	}		
	
	$ctetomrazao = trim(pg_fetch_result($sql, 0, "ctetomrazao"));
	$ctetomnguerra = trim(pg_fetch_result($sql, 0, "ctetomnguerra"));
	$ctetomendereco = trim(pg_fetch_result($sql, 0, "ctetomendereco"));
	$ctetomcomplemento = trim(pg_fetch_result($sql, 0, "ctetomcomplemento"));
	$ctetombairro = trim(pg_fetch_result($sql, 0, "ctetombairro"));
	$ctetomnumero = trim(pg_fetch_result($sql, 0, "ctetomnumero"));
	$cidtom = trim(pg_fetch_result($sql, 0, "cidtom"));
	$ctetomfone = trim(pg_fetch_result($sql, 0, "ctetomfone"));
	$ctetompais = trim(pg_fetch_result($sql, 0, "ctetompais"));
	$ctetomuf = trim(pg_fetch_result($sql, 0, "ctetomuf"));
	$ctetompessoa = trim(pg_fetch_result($sql, 0, "ctetompessoa"));
	$ctetomcep = trim(pg_fetch_result($sql, 0, "ctetomcep"));
	$ctetomcnpj = trim(pg_fetch_result($sql, 0, "ctetomcnpj"));
	$ctetomie = trim(pg_fetch_result($sql, 0, "ctetomie"));
	$ctetomcpf = trim(pg_fetch_result($sql, 0, "ctetomcpf"));
	$ctetomcidcodigoibge = trim(pg_fetch_result($sql, 0, "ctetomcidcodigoibge"));
	
	if ($ctetompessoa=='1'){
		$ctetomdoc = $ctetomcnpj;
	}
	else
	{
		$ctetomdoc = $ctetomcpf;
	}	
	
	$ctepropredominante = trim(pg_fetch_result($sql, 0, "ctepropredominante"));
	$cteoutcaracteristica = trim(pg_fetch_result($sql, 0, "cteoutcaracteristica"));
	$ctecargaval = trim(pg_fetch_result($sql, 0, "ctecargaval"));
	$cteservicos = trim(pg_fetch_result($sql, 0, "cteservicos"));
	$ctereceber = trim(pg_fetch_result($sql, 0, "ctereceber"));
	
	$sitcodigo = trim(pg_fetch_result($sql, 0, "sitcodigo"));
	$sitnome = trim(pg_fetch_result($sql, 0, "sitnome"));
	
	$cteperreducao = trim(pg_fetch_result($sql, 0, "cteperreducao"));
	$ctebasecalculo = trim(pg_fetch_result($sql, 0, "ctebasecalculo"));
	$ctepericms = trim(pg_fetch_result($sql, 0, "ctepericms"));
	$ctevalicms = trim(pg_fetch_result($sql, 0, "ctevalicms"));
	$ctecredito = trim(pg_fetch_result($sql, 0, "ctecredito"));
	
	$ctepreencheicms = trim(pg_fetch_result($sql, 0, "ctepreencheicms"));
	$ctebaseicms = trim(pg_fetch_result($sql, 0, "ctebaseicms"));
	$cteperinterna = trim(pg_fetch_result($sql, 0, "cteperinterna"));
	$cteperinter = trim(pg_fetch_result($sql, 0, "cteperinter"));
	$cteperpartilha = trim(pg_fetch_result($sql, 0, "cteperpartilha"));
	$ctevalicmsini = trim(pg_fetch_result($sql, 0, "ctevalicmsini"));
	$ctevalicmsfim = trim(pg_fetch_result($sql, 0, "ctevalicmsfim"));
	$cteperpobreza = trim(pg_fetch_result($sql, 0, "cteperpobreza"));
	$ctevalpobreza = trim(pg_fetch_result($sql, 0, "ctevalpobreza"));
	
	$cteobsgeral = trim(pg_fetch_result($sql, 0, "cteobsgeral"));
			
	$cterntrc = trim(pg_fetch_result($sql, 0, "cterntrc"));
	$cteentrega = trim(pg_fetch_result($sql, 0, "cteentrega1"));
	$cteciot = trim(pg_fetch_result($sql, 0, "cteciot"));
	$topnome = trim(pg_fetch_result($sql, 0, "topnome"));
	
	$codestado = trim(pg_fetch_result($sql, 0, "codestado"));
	$codcidade = trim(pg_fetch_result($sql, 0, "codcidade"));
	$cid1 = trim(pg_fetch_result($sql, 0, "cid1"));
	$uf1 = trim(pg_fetch_result($sql, 0, "uf1"));
	
	$codestado2 = trim(pg_fetch_result($sql, 0, "codestado2"));
	$codcidade2 = trim(pg_fetch_result($sql, 0, "codcidade2"));
	$cid2 = trim(pg_fetch_result($sql, 0, "cid2"));
	$uf2 = trim(pg_fetch_result($sql, 0, "uf2"));
	
	$codestado3 = trim(pg_fetch_result($sql, 0, "codestado3"));
	$codcidade3 = trim(pg_fetch_result($sql, 0, "codcidade3"));
	$cid3 = trim(pg_fetch_result($sql, 0, "cid3"));
	$uf3 = trim(pg_fetch_result($sql, 0, "uf3"));
	
	$tomcodigo = trim(pg_fetch_result($sql, 0, "tomcodigo"));			
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
			
	$ctetributos = trim(pg_fetch_result($sql, 0, "ctetributos"));
	
	$cteadcfisco = trim(pg_fetch_result($sql, 0, "cteadcfisco"));
	
	$ctecargaval = trim(pg_fetch_result($sql, 0, "ctecargaval"));
	$ctepropredominante = trim(pg_fetch_result($sql, 0, "ctepropredominante"));
	
	$cterntrc = trim(pg_fetch_result($sql, 0, "cterntrc"));
	$cteentrega = trim(pg_fetch_result($sql, 0, "cteentrega"));
	$cteindlocacao = trim(pg_fetch_result($sql, 0, "cteindlocacao"));
	
	$cteremnguerra = trim(pg_fetch_result($sql, 0, "cteremnguerra"));
	
	$ctedescomplemento = trim(pg_fetch_result($sql, 0, "ctedescomplemento"));
	$ctedescidcodigoibge = trim(pg_fetch_result($sql, 0, "ctedescidcodigoibge"));
	
	$cteremcomplemento = trim(pg_fetch_result($sql, 0, "cteremcomplemento"));
	
	$cteexpcidcodigoibge = trim(pg_fetch_result($sql, 0, "cteexpcidcodigoibge"));
	$ctereccidcodigoibge = trim(pg_fetch_result($sql, 0, "ctereccidcodigoibge"));
	
	$tfocodigo = trim(pg_fetch_result($sql, 0, "tfocodigo"));
	
	$sercodigox = trim(pg_fetch_result($sql, 0, "sercodigo"));
	$sercodigo = $sercodigox-1;
	
	$tpgcodigo = trim(pg_fetch_result($sql, 0, "tpgcodigo"));
	
	$ctecobrancanum = trim(pg_fetch_result($sql, 0, "ctecobrancanum"));
	$ctecobrancaval = trim(pg_fetch_result($sql, 0, "ctecobrancaval"));
	$ctecobrancades = trim(pg_fetch_result($sql, 0, "ctecobrancades"));
	$ctecobrancaliq = trim(pg_fetch_result($sql, 0, "ctecobrancaliq"));
	
	
	$ctesubschave 	= trim(pg_fetch_result($sql, 0, "ctesubschave"));
	$ctesubstipo 	= trim(pg_fetch_result($sql, 0, "ctesubstipo"));
	
	$chaveCte		= trim(pg_fetch_result($sql, 0, "ctechave"));
		
	$cnpj1 = trim($cteemicnpj);
	$cnpj1 = str_replace(".", "", $cnpj1);
	$cnpj1 = str_replace(",", "", $cnpj1);
	$cnpj1 = str_replace("-", "", $cnpj1);
	$cnpj1 = str_replace("/", "", $cnpj1);
	
	$txt = "000"; //Fixo
	$txt.= str_pad(substr($cteemirazao,0,35),35); //Remetente
	$txt.= str_pad(substr($cteremrazao,0,35),35); //Destinatario	
	$txt.= date("dmyHi"); //Data Atual
	$txt.= $ident_intercambio; //Identificação do Intercambio
	$txt.= str_pad('',585); //Espaços em Branco
	fputs($arquivo, "$txt\r\n");
	
	$txt = "320"; //Fixo
	$txt.= str_replace('CON','CONHE',$ident_intercambio); //Identificação do Documento
	$txt.= str_pad('',663); //Espaços em Branco
	fputs($arquivo, "$txt\r\n");
		
	$txt = "321"; //Fixo
	if ($cteemipessoa==1){
		$txt.= str_pad(substr(preg_replace("/[^0-9]/", "", $cteemicnpj),0,14),14,'0',STR_PAD_LEFT); //CNPJ		
	}else{
		$txt.= str_pad(substr(preg_replace("/[^0-9]/", "", $cteemicpf),0,14),14,'0',STR_PAD_LEFT); //CPF		
	}
	$txt.= str_pad(substr($cteemirazao,0,40),40); //Razão	
	$txt.= str_pad('',623); //Espaços em Branco
	fputs($arquivo, "$txt\r\n");
	
	$txt = "322"; //Fixo
	$txt.= str_pad('',10); //Espaços em Branco
	$txt.= str_pad((int)$cteserie,5,' ',STR_PAD_RIGHT); //Série
	$txt.= str_pad((int)$ctenum,12,' ',STR_PAD_LEFT); //Numero do Conhecimento
	$txt.= substr($cteemissao,8,2).substr($cteemissao,5,2).substr($cteemissao,0,4); //Emissão
	$txt.= 'C'; //Condição de Frete será sempre CIF a princípio
	
	//Localiza o Peso em KG
	$peso = 0;
	$sql2 = "Select a.*,b.mednome from cteinfocarga a,tipomedida b Where a.ctenumero = '$parametro'";
	$sql2.= " and a.medcodigo = b.medcodigo and a.medcodigo=2";	
	$sql2 = pg_query($sql2);
	$row2 = pg_num_rows($sql2);
	if($row2) {
		$peso = pg_fetch_result($sql2, 0, "cteinfvalor");			
	}
	$peso = round($peso*100,0);
	$txt.= str_pad($peso,7,'0',STR_PAD_LEFT); //Peso 5,2
	
	$txt.= str_pad(round($cteservicos*100,0),15,'0',STR_PAD_LEFT); //Frete 13,2	
	$txt.= str_pad(round($ctebasecalculo*100,0),15,'0',STR_PAD_LEFT); //Base do ICMS 13,2
	$txt.= str_pad(round($ctepericms*100,0),4,'0',STR_PAD_LEFT); //Percentual do ICMS 2,2
	$txt.= str_pad(round($ctevalicms*100,0),15,'0',STR_PAD_LEFT); //Valor do ICMS 13,2
	
	$totCte += $cteservicos;
	$qtdCte += 1;
	
	//Valores abaixo a principio vão todos zerados
	$txt.= str_pad(0,15,'0',STR_PAD_LEFT); //Valor do Frete por Peso / Volume 13,2
	$txt.= str_pad(0,15,'0',STR_PAD_LEFT); //Frete Valor 13,2
	$txt.= str_pad(0,15,'0',STR_PAD_LEFT); //Valor SEC / CAT 13,2
	$txt.= str_pad(0,15,'0',STR_PAD_LEFT); //Valor ITR 13,2
	$txt.= str_pad(0,15,'0',STR_PAD_LEFT); //Valor do Despacho 13,2
	$txt.= str_pad(0,15,'0',STR_PAD_LEFT); //Valor do Pedágio 13,2
	$txt.= str_pad(0,15,'0',STR_PAD_LEFT); //Valor Ademe 13,2	
	$txt.= '2'; //Substituição Tributária
	$txt.= str_pad('',3); //Espaços em Branco
	if ($cteemipessoa==1){
		$txt.= str_pad(substr(preg_replace("/[^0-9]/", "", $cteemicnpj),0,14),14,'0',STR_PAD_LEFT); //CNPJ		
	}else{
		$txt.= str_pad(substr(preg_replace("/[^0-9]/", "", $cteemicpf),0,14),14,'0',STR_PAD_LEFT); //CPF		
	}
	if ($cterempessoa==1){
		$txt.= str_pad(substr(preg_replace("/[^0-9]/", "", $cteremcnpj),0,14),14,'0',STR_PAD_LEFT); //CNPJ		
	}else{
		$txt.= str_pad(substr(preg_replace("/[^0-9]/", "", $cteremcpf),0,14),14,'0',STR_PAD_LEFT); //CPF		
	}
		
	//Carrega as Notas 1 - 40
	$numeroNotas = 0;
	$sql2 = "Select * from ctenfechave Where ctenumero = '$parametro' limit 40";
			
	$sql2 = pg_query($sql2);
	$row2 = pg_num_rows($sql2);
	if($row2) {
	
		for($i2=0; $i2<$row2; $i2++) {
			
			$numeroNotas ++;
		
			$ctenfenome     = pg_fetch_result($sql2, $i2, "ctenfenome");  
			$nfeSerie		= (int)substr($ctenfenome,22,3);
			$nfeNumero		= (int)substr($ctenfenome,25,9);
			
			$txt.= str_pad($nfeSerie,3,' ',STR_PAD_RIGHT); //Série
			$txt.= str_pad($nfeNumero,8,'0',STR_PAD_LEFT); //Numero
			
		}
	}
	
	//Preenche as Notas Restantes em Branco
	for($i2=$numeroNotas; $i2<40; $i2++) {
		$txt.= str_pad('',3,' ',STR_PAD_RIGHT); //Série
		$txt.= str_pad('',8,'0',STR_PAD_LEFT); //Numero
	}
	
	$txt.= 'I'; //Ação do Documento
	$txt.= 'N'; //Tipo do Documento
	$txt.= str_pad($ctecfop,6,' ',STR_PAD_RIGHT); //CFOP		
	fputs($arquivo, "$txt\r\n");
	
	$txt = "323"; //Fixo
	$txt.= str_pad($qtdCte,4,'0',STR_PAD_LEFT); //Quantidade de Conhecimentos
	$txt.= str_pad(round($totCte*100,0),15,'0',STR_PAD_LEFT); //Valor dos Conhecimentos
	$txt.= str_pad('',658); //Espaços em Branco
	fputs($arquivo, "$txt\r\n");
	
	
	fclose($arquivo);
	
	echo "<font color='green'>Arquivo: <b>{$caminhoArquivo}</b> gerado com sucesso!</font><hr>";
	
}
else {
	
	echo "<font color='red'>Problema na geração do arquivo no formato Proceda!</font><hr>";
		
}


pg_close($conn);
exit();




function removeTodosCaracterEspeciaisEspaco($text)
{
	 $palavra = $text;
	 if(version_compare(PHP_VERSION, '7.0.0', '<')){
		$palavra = ereg_replace("[^a-zA-Z0-9]", "", strtr($palavra, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ-", "aaaaeeiooouucAAAAEEIOOOUUC"));
	 }
	 else {
		$palavra = preg_replace("[^a-zA-Z0-9]", "", strtr($palavra, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ-", "aaaaeeiooouucAAAAEEIOOOUUC"));
     }	 
	return $palavra;
}

?>


