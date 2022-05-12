<?php     
require_once("include/conexao.inc.php");

//ini_set("display_errors", 1);
//error_reporting(E_ALL);

$datainicio = explode("/",$_GET['dataini']);
$auxdatainicio = $datainicio[2].'-'.$datainicio[1].'-'.$datainicio[0].' 00:00:00';

$datafinal = explode("/",$_GET['datafim']);
$auxdatafinal = $datafinal[2].'-'.$datafinal[1].'-'.$datafinal[0].' 23:59:59';

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
	
$sql.=" where (a.cteemissao between '$auxdatainicio' and '$auxdatafinal') and a.ctechave is not null and a.ctecancdata is null and a.ctedatainutiliza is null order by a.cteemissao";
		
$sql = pg_query($sql);
$row = pg_num_rows($sql);

$totCte = 0;
$qtdCte = 0;

if($row) {
	
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
	
	$totCte = 0;
	$qtdCte = 0;
	
	for($i=0; $i<$row; $i++) {
		
		
		$ctenumero = trim(pg_fetch_result($sql, $i, "ctenumero"));
		$parametro = $ctenumero;
		$ctemodelo = trim(pg_fetch_result($sql, $i, "ctemodelo"));
		$cteserie = trim(pg_fetch_result($sql, $i, "cteserie"));	
		$ctenum = trim(pg_fetch_result($sql, $i, "ctenum"));	
		$cteemissao = trim(pg_fetch_result($sql, $i, "cteemissao"));
		$ctehorario = trim(pg_fetch_result($sql, $i, "ctehorario"));
		$tmonome = trim(pg_fetch_result($sql, $i, "tmonome"));
		$tmocodigo = trim(pg_fetch_result($sql, $i, "tmocodigo"));
		$sernome = trim(pg_fetch_result($sql, $i, "sernome"));
		$ctechaveref = trim(pg_fetch_result($sql, $i, "ctechaveref"));
		$ctechavefin = trim(pg_fetch_result($sql, $i, "ctechavefin"));
		$datatomador = trim(pg_fetch_result($sql, $i, "ctedatatomador"));
		$tomnome = trim(pg_fetch_result($sql, $i, "tomnome"));
		$tfonome = trim(pg_fetch_result($sql, $i, "tfonome"));
		$ctecfop = trim(pg_fetch_result($sql, $i, "ctecfop"));
		$ctenatureza = trim(pg_fetch_result($sql, $i, "ctenatureza"));
		$tctcodigo = trim(pg_fetch_result($sql, $i, "tctcodigo"));
		$tctnome = trim(pg_fetch_result($sql, $i, "tctnome"));
		$cidinicio = trim(pg_fetch_result($sql, $i, "cidinicio"));
		$cteufinicio = trim(pg_fetch_result($sql, $i, "cteufinicio"));
		$cidfinal = trim(pg_fetch_result($sql, $i, "cidfinal"));
		$cteuffinal = trim(pg_fetch_result($sql, $i, "cteuffinal"));
		
		$remcodigo = trim(pg_fetch_result($sql, $i, "remcodigo"));
		$cteremrazao = trim(pg_fetch_result($sql, $i, "cteremrazao"));
		$cteremendereco = trim(pg_fetch_result($sql, $i, "cteremendereco"));
		$cterembairro = trim(pg_fetch_result($sql, $i, "cterembairro"));
		$cteremnumero = trim(pg_fetch_result($sql, $i, "cteremnumero"));
		$cidrem = trim(pg_fetch_result($sql, $i, "cidrem"));
		$cteremfone = trim(pg_fetch_result($sql, $i, "cteremfone"));
		$cterempais = trim(pg_fetch_result($sql, $i, "cterempais"));
		$cteremuf = trim(pg_fetch_result($sql, $i, "cteremuf"));
		
		$cterempessoa = trim(pg_fetch_result($sql, $i, "cterempessoa"));
		$cteremcep = trim(pg_fetch_result($sql, $i, "cteremcep"));
		$cteremcnpj = trim(pg_fetch_result($sql, $i, "cteremcnpj"));
		$cteremie = trim(pg_fetch_result($sql, $i, "cteremie"));
		$cteremcpf = trim(pg_fetch_result($sql, $i, "cteremcpf"));
		$cteremcidcodigoibge = trim(pg_fetch_result($sql, $i, "cteremcidcodigoibge"));
		
		if ($cterempessoa=='1'){
			$cteremdoc = $cteremcnpj;
		}
		else
		{
			$cteremdoc = $cteremcpf;
		}
				
		$descodigo = trim(pg_fetch_result($sql, $i, "descodigo"));
		$ctedesrazao = trim(pg_fetch_result($sql, $i, "ctedesrazao"));
		$ctedesendereco = trim(pg_fetch_result($sql, $i, "ctedesendereco"));
		$ctedescomplemento = trim(pg_fetch_result($sql, $i, "ctedescomplemento"));
		$ctedesbairro = trim(pg_fetch_result($sql, $i, "ctedesbairro"));
		$ctedesnumero = trim(pg_fetch_result($sql, $i, "ctedesnumero"));
		$ctedessuframa = trim(pg_fetch_result($sql, $i, "ctedessuframa"));
		$ciddes = trim(pg_fetch_result($sql, $i, "ciddes"));
		$ctedesfone = trim(pg_fetch_result($sql, $i, "ctedesfone"));
		$ctedespais = trim(pg_fetch_result($sql, $i, "ctedespais"));
		$ctedesuf = trim(pg_fetch_result($sql, $i, "ctedesuf"));
		
		$ctedespessoa = trim(pg_fetch_result($sql, $i, "ctedespessoa"));
		$ctedescep = trim(pg_fetch_result($sql, $i, "ctedescep"));
		$ctedescnpj = trim(pg_fetch_result($sql, $i, "ctedescnpj"));
		$ctedesie = trim(pg_fetch_result($sql, $i, "ctedesie"));	
		$ctedescpf = trim(pg_fetch_result($sql, $i, "ctedescpf"));
		
		if ($ctedespessoa=='1'){
			$ctedesdoc = $ctedescnpj;
		}
		else
		{
			$ctedesdoc = $ctedescpf;
		}
		
		$expcodigo = trim(pg_fetch_result($sql, $i, "expcodigo"));
		$cteexprazao = trim(pg_fetch_result($sql, $i, "cteexprazao"));
		$cteexpendereco = trim(pg_fetch_result($sql, $i, "cteexpendereco"));
		$cteexpcomplemento = trim(pg_fetch_result($sql, $i, "cteexpcomplemento"));
		$cteexpbairro = trim(pg_fetch_result($sql, $i, "cteexpbairro"));
		$cteexpnumero = trim(pg_fetch_result($sql, $i, "cteexpnumero"));
		$cidexp = trim(pg_fetch_result($sql, $i, "cidexp"));
		$cteexpfone = trim(pg_fetch_result($sql, $i, "cteexpfone"));
		$cteexppais = trim(pg_fetch_result($sql, $i, "cteexppais"));
		$cteexpuf = trim(pg_fetch_result($sql, $i, "cteexpuf"));
		
		$cteexppessoa = trim(pg_fetch_result($sql, $i, "cteexppessoa"));
		$cteexpcep = trim(pg_fetch_result($sql, $i, "cteexpcep"));
		$cteexpcnpj = trim(pg_fetch_result($sql, $i, "cteexpcnpj"));
		$cteexpie = trim(pg_fetch_result($sql, $i, "cteexpie"));
		$cteexpcpf = trim(pg_fetch_result($sql, $i, "cteexpcpf"));
		
		if ($cteexppessoa=='1'){
			$cteexpdoc = $cteexpcnpj;
		}
		else
		{
			$cteexpdoc = $cteexpcpf;
		}
		
		$reccodigo = trim(pg_fetch_result($sql, $i, "reccodigo"));
		$cterecrazao = trim(pg_fetch_result($sql, $i, "cterecrazao"));
		$cterecendereco = trim(pg_fetch_result($sql, $i, "cterecendereco"));
		$ctereccomplemento = trim(pg_fetch_result($sql, $i, "ctereccomplemento"));
		$cterecbairro = trim(pg_fetch_result($sql, $i, "cterecbairro"));
		$cterecnumero = trim(pg_fetch_result($sql, $i, "cterecnumero"));
		$cidrec = trim(pg_fetch_result($sql, $i, "cidrec"));
		$cterecfone = trim(pg_fetch_result($sql, $i, "cterecfone"));
		$cterecpais = trim(pg_fetch_result($sql, $i, "cterecpais"));
		$cterecuf = trim(pg_fetch_result($sql, $i, "cterecuf"));
		
		$cterecpessoa = trim(pg_fetch_result($sql, $i, "cterecpessoa"));
		$ctereccep = trim(pg_fetch_result($sql, $i, "ctereccep"));
		$ctereccnpj = trim(pg_fetch_result($sql, $i, "ctereccnpj"));
		$cterecie = trim(pg_fetch_result($sql, $i, "cterecie"));
		$ctereccpf = trim(pg_fetch_result($sql, $i, "ctereccpf"));
		
		if ($cterecpessoa=='1'){
			$cterecdoc = $ctereccnpj;
		}
		else
		{
			$cterecdoc = $ctereccpf;
		}		
		
		$ctetomrazao = trim(pg_fetch_result($sql, $i, "ctetomrazao"));
		$ctetomnguerra = trim(pg_fetch_result($sql, $i, "ctetomnguerra"));
		$ctetomendereco = trim(pg_fetch_result($sql, $i, "ctetomendereco"));
		$ctetomcomplemento = trim(pg_fetch_result($sql, $i, "ctetomcomplemento"));
		$ctetombairro = trim(pg_fetch_result($sql, $i, "ctetombairro"));
		$ctetomnumero = trim(pg_fetch_result($sql, $i, "ctetomnumero"));
		$cidtom = trim(pg_fetch_result($sql, $i, "cidtom"));
		$ctetomfone = trim(pg_fetch_result($sql, $i, "ctetomfone"));
		$ctetompais = trim(pg_fetch_result($sql, $i, "ctetompais"));
		$ctetomuf = trim(pg_fetch_result($sql, $i, "ctetomuf"));
		$ctetompessoa = trim(pg_fetch_result($sql, $i, "ctetompessoa"));
		$ctetomcep = trim(pg_fetch_result($sql, $i, "ctetomcep"));
		$ctetomcnpj = trim(pg_fetch_result($sql, $i, "ctetomcnpj"));
		$ctetomie = trim(pg_fetch_result($sql, $i, "ctetomie"));
		$ctetomcpf = trim(pg_fetch_result($sql, $i, "ctetomcpf"));
		$ctetomcidcodigoibge = trim(pg_fetch_result($sql, $i, "ctetomcidcodigoibge"));
		
		if ($ctetompessoa=='1'){
			$ctetomdoc = $ctetomcnpj;
		}
		else
		{
			$ctetomdoc = $ctetomcpf;
		}	
		
		$ctepropredominante = trim(pg_fetch_result($sql, $i, "ctepropredominante"));
		$cteoutcaracteristica = trim(pg_fetch_result($sql, $i, "cteoutcaracteristica"));
		$ctecargaval = trim(pg_fetch_result($sql, $i, "ctecargaval"));
		$cteservicos = trim(pg_fetch_result($sql, $i, "cteservicos"));
		$ctereceber = trim(pg_fetch_result($sql, $i, "ctereceber"));
		
		$sitcodigo = trim(pg_fetch_result($sql, $i, "sitcodigo"));
		$sitnome = trim(pg_fetch_result($sql, $i, "sitnome"));
		
		$cteperreducao = trim(pg_fetch_result($sql, $i, "cteperreducao"));
		$ctebasecalculo = trim(pg_fetch_result($sql, $i, "ctebasecalculo"));
		$ctepericms = trim(pg_fetch_result($sql, $i, "ctepericms"));
		$ctevalicms = trim(pg_fetch_result($sql, $i, "ctevalicms"));
		$ctecredito = trim(pg_fetch_result($sql, $i, "ctecredito"));
		
		$ctepreencheicms = trim(pg_fetch_result($sql, $i, "ctepreencheicms"));
		$ctebaseicms = trim(pg_fetch_result($sql, $i, "ctebaseicms"));
		$cteperinterna = trim(pg_fetch_result($sql, $i, "cteperinterna"));
		$cteperinter = trim(pg_fetch_result($sql, $i, "cteperinter"));
		$cteperpartilha = trim(pg_fetch_result($sql, $i, "cteperpartilha"));
		$ctevalicmsini = trim(pg_fetch_result($sql, $i, "ctevalicmsini"));
		$ctevalicmsfim = trim(pg_fetch_result($sql, $i, "ctevalicmsfim"));
		$cteperpobreza = trim(pg_fetch_result($sql, $i, "cteperpobreza"));
		$ctevalpobreza = trim(pg_fetch_result($sql, $i, "ctevalpobreza"));
		
		$cteobsgeral = trim(pg_fetch_result($sql, $i, "cteobsgeral"));
				
		$cterntrc = trim(pg_fetch_result($sql, $i, "cterntrc"));
		$cteentrega = trim(pg_fetch_result($sql, $i, "cteentrega1"));
		$cteciot = trim(pg_fetch_result($sql, $i, "cteciot"));
		$topnome = trim(pg_fetch_result($sql, $i, "topnome"));
		
		$codestado = trim(pg_fetch_result($sql, $i, "codestado"));
		$codcidade = trim(pg_fetch_result($sql, $i, "codcidade"));
		$cid1 = trim(pg_fetch_result($sql, $i, "cid1"));
		$uf1 = trim(pg_fetch_result($sql, $i, "uf1"));
		
		$codestado2 = trim(pg_fetch_result($sql, $i, "codestado2"));
		$codcidade2 = trim(pg_fetch_result($sql, $i, "codcidade2"));
		$cid2 = trim(pg_fetch_result($sql, $i, "cid2"));
		$uf2 = trim(pg_fetch_result($sql, $i, "uf2"));
		
		$codestado3 = trim(pg_fetch_result($sql, $i, "codestado3"));
		$codcidade3 = trim(pg_fetch_result($sql, $i, "codcidade3"));
		$cid3 = trim(pg_fetch_result($sql, $i, "cid3"));
		$uf3 = trim(pg_fetch_result($sql, $i, "uf3"));
		
		$tomcodigo = trim(pg_fetch_result($sql, $i, "tomcodigo"));			
		$cteemipessoa = trim(pg_fetch_result($sql, $i, "cteemipessoa"));
		$cteemicnpj = trim(pg_fetch_result($sql, $i, "cteemicnpj"));
		$cteemiie = trim(pg_fetch_result($sql, $i, "cteemiie"));
		$cteemicpf = trim(pg_fetch_result($sql, $i, "cteemicpf"));
		$cteemirg = trim(pg_fetch_result($sql, $i, "cteemirg"));
		$cteeminguerra = trim(pg_fetch_result($sql, $i, "cteeminguerra"));
		$cteemirazao = trim(pg_fetch_result($sql, $i, "cteemirazao"));
		$cteemicep = trim(pg_fetch_result($sql, $i, "cteemicep"));
		$cteemiendereco = trim(pg_fetch_result($sql, $i, "cteemiendereco"));
		$cteeminumero = trim(pg_fetch_result($sql, $i, "cteeminumero"));
		$cteemibairro = trim(pg_fetch_result($sql, $i, "cteemibairro"));
		$cteemicomplemento = trim(pg_fetch_result($sql, $i, "cteemicomplemento"));
		$cteemifone = trim(pg_fetch_result($sql, $i, "cteemifone"));
		$cteemipais = trim(pg_fetch_result($sql, $i, "cteemipais"));
		$cteemiuf = trim(pg_fetch_result($sql, $i, "cteemiuf"));
		$cteemicidcodigo = trim(pg_fetch_result($sql, $i, "cteemicidcodigo"));
		$cteemicidcodigoibge = trim(pg_fetch_result($sql, $i, "cteemicidcodigoibge"));
		$cidemi = trim(pg_fetch_result($sql, $i, "cidemi"));
				
		$ctetributos = trim(pg_fetch_result($sql, $i, "ctetributos"));
		
		$cteadcfisco = trim(pg_fetch_result($sql, $i, "cteadcfisco"));
		
		$ctecargaval = trim(pg_fetch_result($sql, $i, "ctecargaval"));
		$ctepropredominante = trim(pg_fetch_result($sql, $i, "ctepropredominante"));
		
		$cterntrc = trim(pg_fetch_result($sql, $i, "cterntrc"));
		$cteentrega = trim(pg_fetch_result($sql, $i, "cteentrega"));
		$cteindlocacao = trim(pg_fetch_result($sql, $i, "cteindlocacao"));
		
		$cteremnguerra = trim(pg_fetch_result($sql, $i, "cteremnguerra"));
		
		$ctedescomplemento = trim(pg_fetch_result($sql, $i, "ctedescomplemento"));
		$ctedescidcodigoibge = trim(pg_fetch_result($sql, $i, "ctedescidcodigoibge"));
		
		$cteremcomplemento = trim(pg_fetch_result($sql, $i, "cteremcomplemento"));
		
		$cteexpcidcodigoibge = trim(pg_fetch_result($sql, $i, "cteexpcidcodigoibge"));
		$ctereccidcodigoibge = trim(pg_fetch_result($sql, $i, "ctereccidcodigoibge"));
		
		$tfocodigo = trim(pg_fetch_result($sql, $i, "tfocodigo"));
		
		$sercodigox = trim(pg_fetch_result($sql, $i, "sercodigo"));
		$sercodigo = $sercodigox-1;
		
		$tpgcodigo = trim(pg_fetch_result($sql, $i, "tpgcodigo"));
		
		$ctecobrancanum = trim(pg_fetch_result($sql, $i, "ctecobrancanum"));
		$ctecobrancaval = trim(pg_fetch_result($sql, $i, "ctecobrancaval"));
		$ctecobrancades = trim(pg_fetch_result($sql, $i, "ctecobrancades"));
		$ctecobrancaliq = trim(pg_fetch_result($sql, $i, "ctecobrancaliq"));
		
		
		$ctesubschave 	= trim(pg_fetch_result($sql, $i, "ctesubschave"));
		$ctesubstipo 	= trim(pg_fetch_result($sql, $i, "ctesubstipo"));
		
		$chaveCte		= trim(pg_fetch_result($sql, $i, "ctechave"));
			
		$cnpj1 = trim($cteemicnpj);
		$cnpj1 = str_replace(".", "", $cnpj1);
		$cnpj1 = str_replace(",", "", $cnpj1);
		$cnpj1 = str_replace("-", "", $cnpj1);
		$cnpj1 = str_replace("/", "", $cnpj1);
		
		//Só imprime o 000, 320 e 321 da primeira vez
		if($i==0){
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
		}	
		
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
		
	}

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

echo "<font color='black'>Fim de Processamento!</font><hr>";

pg_close($conn);

echo "<meta HTTP-EQUIV='Refresh' CONTENT='3;URL=exportaprocedacte.php'>";

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


