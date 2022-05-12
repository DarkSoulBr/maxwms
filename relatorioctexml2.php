<?php
//require('fpdf.php');
require_once("include/conexao.inc.php");
require('code128.php');


$parametro = $_GET['parametro'];

$chaveCte = '';
$erroCte = '';

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

$sql .= " Where a.ctenumero = '$parametro'";

$nome = "/home/delta/cte/cte" . date("YmdHis") . ".tmp";
if (file_exists($nome)) {
    unlink($nome);
}
$arquivo = fopen("$nome", "x+");

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

    if ($cterempessoa == '1') {
        $cteremdoc = $cteremcnpj;
    } else {
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

    if ($ctedespessoa == '1') {
        $ctedesdoc = $ctedescnpj;
    } else {
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

    if ($cteexppessoa == '1') {
        $cteexpdoc = $cteexpcnpj;
    } else {
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

    if ($cterecpessoa == '1') {
        $cterecdoc = $ctereccnpj;
    } else {
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

    if ($ctetompessoa == '1') {
        $ctetomdoc = $ctetomcnpj;
    } else {
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
    $sercodigo = $sercodigox - 1;

    $tpgcodigo = trim(pg_fetch_result($sql, 0, "tpgcodigo"));

    $ctecobrancanum = trim(pg_fetch_result($sql, 0, "ctecobrancanum"));
    $ctecobrancaval = trim(pg_fetch_result($sql, 0, "ctecobrancaval"));
    $ctecobrancades = trim(pg_fetch_result($sql, 0, "ctecobrancades"));
    $ctecobrancaliq = trim(pg_fetch_result($sql, 0, "ctecobrancaliq"));


    $ctesubschave = trim(pg_fetch_result($sql, 0, "ctesubschave"));
    $ctesubstipo = trim(pg_fetch_result($sql, 0, "ctesubstipo"));

    $cteglobalizado = trim(pg_fetch_result($sql, 0, "cteglobalizado"));


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
    $ctecodigo = mt_rand(1, 99999999);
    $ctecodigo = str_pad($ctecodigo, 8, "0", STR_PAD_LEFT);

    $infcteid = $codestado . substr($cteemissao, 2, 2) . substr($cteemissao, 5, 2) . $cnpj1 . $ctemodelo . $cteserie . str_pad($ctenum, 9, "0", STR_PAD_LEFT) . '1' . $ctecodigo;

    //$infcteid = '3516091070277000013057001000000345103010000';

    $digitoVerificador = dvCalcMod11($infcteid);

    $chaveCte = $infcteid . $digitoVerificador;

    $update = "Update cte set ctechave=$chaveCte,ctemotivo=null,cterecebto=null Where ctenumero = '$parametro'";
    pg_query($update);

    $infcteidarquivo = $infcteid . $digitoVerificador . '-cte';

    $infcteid = 'CTe' . $infcteid . $digitoVerificador;
    //26/10/2016

    $txt = '<?xml version="1.0" encoding="UTF-8"?><CTe xmlns="http://www.portalfiscal.inf.br/cte">';

    $txt .= '<infCte Id="' . $infcteid . '" versao="3.00">';

    $txt .= '<ide>';

    $txt .= '<cUF>' . $codestado . '</cUF>';   //UF TABELA IBGE		
    $txt .= '<cCT>' . $ctecodigo . '</cCT>'; //Número aleatório gerado pelo emitente para cada CT-e, com o objetivo de evitar acessos indevidos ao documento.		
    $txt .= '<CFOP>' . $ctecfop . '</CFOP>';
    $txt .= '<natOp>' . substr($ctenatureza, 0, 60) . '</natOp>';

    if ($tpgcodigo == 1) {
        $tpgcodigox = 0;
    } else if ($tpgcodigo == 2) {
        $tpgcodigox = 1;
    } else if ($tpgcodigo == 3) {
        $tpgcodigox = 2;
    }

    ///3.00
    /// $txt.= '<forPag>' . $tpgcodigox . '</forPag>'; //0 – pagamento à vista; 1 – pagamento à prazo; 2 - outros.

    $txt .= '<mod>' . $ctemodelo . '</mod>';
    $txt .= '<serie>' . (int) $cteserie . '</serie>';
    $txt .= '<nCT>' . (int) $ctenum . '</nCT>';

    ///3.00
    $txt .= '<dhEmi>' . substr($cteemissao, 0, 10) . 'T' . substr($cteemissao, 11, 8) . '+00:00' . '</dhEmi>';  //Formato UTC “AAAA-MM-DDThh:mm:ss  ///xxx

    $txt .= '<tpImp>1</tpImp>'; //1-Retrato 2-Paisagem 

    /*
      1 - normal
      2 - contingencia epec
      3 - contingencia fsda
      4 - Autorização pela SVC-RS
     */

    if ($tfocodigo == 1) {
        $tfocodigox = 1;
    } else if ($tfocodigo == 2) {
        $tfocodigox = 4;
    } else if ($tfocodigo == 3) {
        $tfocodigox = 5;
    } else if ($tfocodigo == 4) {
        $tfocodigox = 7;
    }

    $txt .= '<tpEmis>' . $tfocodigox . '</tpEmis>';  //1 - Normal;4 - EPEC pela SVC;5 - Contingência FSDA;7 - Autorização pela SVC-RS;8 - Autorização pela SVC-SP

    $txt .= '<cDV>' . $digitoVerificador . '</cDV>';  //xxxxxxxxx
    //Parametrização	
    $ambiente = '';
    $versao = '';
    $sql2 = "Select * from parametros";
    $sql2 = pg_query($sql2);
    $row2 = pg_num_rows($sql2);
    if ($row2) {
        $ambiente = pg_fetch_result($sql2, 0, "parambiente");
        $versao = pg_fetch_result($sql2, 0, "parversao");
    }

    if ($ambiente == 1 || $ambiente == 2) {
        
    } else {
        $ambiente = 2;
    }

    if ($versao == '') {
        $versao = '2.0.42';
    }

    $txt .= '<tpAmb>' . $ambiente . '</tpAmb>'; //1 - Produção; 2 - Homologação 

    /*
      0 - CT-e Normal;
      1 - CT-e de Complemento de Valores;
      2 - CT-e de Anulação;
      3 - CT-e Substituto
     */

    if ($tctcodigo == 1 || $tctcodigo == 0 || $tctcodigo == '') {
        $tctcodigox = 0;
    } else if ($tctcodigo == 2) {
        $tctcodigox = 1;
    } else if ($tctcodigo == 3) {
        $tctcodigox = 2;
    } else if ($tctcodigo == 4) {
        $tctcodigox = 3;
    }

    $txt .= '<tpCTe>' . $tctcodigox . '</tpCTe>'; //0 - CT-e Normal;1 - CT-e de Complemento de Valores;2 - CT-e de Anulação;3 - CT-e Substituto

    $txt .= '<procEmi>0</procEmi>'; //0 - Emissão de CT-e com aplicativo do contribuinte;1 - Emissão de CT-e avulsa pelo Fisco;2 - Emissão de CT-e avulsa, pelo contribuinte com seu certificado digital, através do site do Fisco;3 - Emissão CT-e pelo contribuinte com aplicativo fornecido pelo Fisco.		

    $txt .= '<verProc>' . $versao . '</verProc>';  //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

    if ($cteglobalizado == 1) {
        ///3.00
        ///indGlobalizado //Informar valor 1 quando for globalizado e não informar a tag nas demais situações
        $txt .= '<indGlobalizado>1</indGlobalizado>';
    }

    ///3.00
    ///if($ctechaveref!='' && $ctechaveref!='0'){
    ///	$txt.= '<refCTE>'.$ctechaveref.'</refCTE>';	
    ///}

    $txt .= '<cMunEnv>' . $codestado . $codcidade . '</cMunEnv>';  //Utilizar a tabela do IBGE, informar 9999999 para as operações com o exterior.
    $txt .= '<xMunEnv>' . $cid1 . '</xMunEnv>';
    $txt .= '<UFEnv>' . $uf1 . '</UFEnv>';

    if ($tmocodigo == 1 || $tmocodigo == 0 || $tmocodigo == '') {
        $tmocodigox = '01';
    } else if ($tmocodigo == 2) {
        $tmocodigox = '02';
    } else if ($tmocodigo == 3) {
        $tmocodigox = '03';
    } else if ($tmocodigo == 4) {
        $tmocodigox = '04';
    } else if ($tmocodigo == 5) {
        $tmocodigox = '05';
    } else if ($tmocodigo == 6) {
        $tmocodigox = '06';
    }

    $txt .= '<modal>' . $tmocodigox . '</modal>'; //01 - Rodoviário;02 - Aéreo;03 - Aquaviário;04 - Ferroviário;05 - Dutoviário;06 - Multimodal

    $txt .= '<tpServ>' . $sercodigo . '</tpServ>'; //0 - Normal;1 - Subcontratação;2 - Redespacho;3 - Redespacho Intermediário;4 - Serviço Vinculado a Multimodal

    $txt .= '<cMunIni>' . $codestado2 . $codcidade2 . '</cMunIni>';
    $txt .= '<xMunIni>' . $cid2 . '</xMunIni>';
    $txt .= '<UFIni>' . $uf2 . '</UFIni>';

    $txt .= '<cMunFim>' . $codestado3 . $codcidade3 . '</cMunFim>';
    $txt .= '<xMunFim>' . $cid3 . '</xMunFim>';
    $txt .= '<UFFim>' . $uf3 . '</UFFim>';

    $txt .= '<retira>1</retira>';   //Indicador se o Recebedor retira 0 - Sim 1 - Não
    //$txt.= '<xDetRetira></xDetRetira>';  //Detalhes do retira
    ///3.00
    ///Indicador do papel do tomador na
    ///prestação do serviço:
    ///1 – Contribuinte ICMS;
    ///2 – Contribuinte isento de inscrição;
    ///9 – Não Contribuinte
    $txt .= '<indIEToma>1</indIEToma>';

    if ($tomcodigo == 1 || $tomcodigo == 0 || $tomcodigo == '') {
        $tomcodigox = '0';
    } else if ($tomcodigo == 2) {
        $tmocodigox = '1';
    } else if ($tomcodigo == 3) {
        $tomcodigox = '2';
    } else if ($tomcodigo == 4) {
        $tomcodigox = '3';
    } else if ($tomcodigo == 5) {
        $tomcodigox = '4';
    }

    if ($tomcodigox != '4') {
        ///3.00
        $txt .= '<toma3>';
        $txt .= '<toma>' . $tomcodigox . '</toma>';
        $txt .= '</toma3>';
    } else {
        $txt .= '<toma4>';
        $txt .= '<toma>' . $tomcodigox . '</toma>';   //0 - Remetente;1 - Expedidor;2 - Recebedor;3 - Destinatário;4 - Outros						
        if ($ctetompessoa == 1) {
            $ctetomcnpj = preg_replace("/[^0-9]/", "", $ctetomcnpj);
            $txt .= '<CNPJ>' . $ctetomcnpj . '</CNPJ>';
        } else {
            $ctetomcpf = preg_replace("/[^0-9]/", "", $ctetomcpf);
            $txt .= '<CPF>' . $ctetomcpf . '</CPF>';
        }
        if ($ctetomie != 'ISENTO') {
            $ctetomie = preg_replace("/[^0-9]/", "", $ctetomie);
        }
        $txt .= '<IE>' . $ctetomie . '</IE>';
        $txt .= '<xNome>' . $ctetomrazao . '</xNome>';
        if ($ctetomnguerra != '') {
            $txt .= '<xFant>' . $ctetomnguerra . '</xFant>';
        }
        $ctetomfone = preg_replace("/[^0-9]/", "", $ctetomfone);
        if ($ctetomfone != '') {
            $txt .= '<fone>' . $ctetomfone . '</fone>';
        }
        $txt .= '<enderToma>';
        $txt .= '<xLgr>' . $ctetomendereco . '</xLgr>';
        $txt .= '<nro>' . $ctetomnumero . '</nro>';
        if ($ctetomcomplemento != '') {
            $txt .= '<xCpl>' . $ctetomcomplemento . '</xCpl>';
        }
        if ($ctetombairro != '') {
            $txt .= '<xBairro>' . $ctetombairro . '</xBairro>';
        }
        $txt .= '<cMun>' . $ctetomcidcodigoibge . '</cMun>';
        $txt .= '<xMun>' . $cidtom . '</xMun>';
        $txt .= '<CEP>' . $ctetomcep . '</CEP>';
        $txt .= '<UF>' . $ctetomuf . '</UF>';
        $txt .= '<cPais>1058</cPais>';
        $txt .= '<xPais>' . $ctetompais . '</xPais>';
        $txt .= '</enderToma>';
        $txt .= '</toma4>';
    }

    $txt .= '</ide>';

    $txt .= '<compl>';

    $txt .= '<fluxo/>';

    //Observacoes Gerais
    if ($cteobsgeral != '') {

        $cteobsgeral = str_replace("\n", " ", $cteobsgeral);

        $txt .= '<xObs>' . $cteobsgeral . '</xObs>';
    }

    //Observacoes Contribuinte		
    $sql2 = "Select a.cteconnome,a.cteconobs ";
    $sql2 .= " From cteobscontribuinte a";
    $sql2 .= " Where a.ctenumero = '$parametro' order by a.cteconcodigo";

    $sql2 = pg_query($sql2);
    $row2 = pg_num_rows($sql2);
    if ($row2) {
        for ($i2 = 0; $i2 < $row2; $i2++) {
            $ctevalnome = pg_fetch_result($sql2, $i2, "cteconnome");
            $ctevalobs = pg_fetch_result($sql2, $i2, "cteconobs");
            $txt .= '<ObsCont xCampo="' . $ctevalnome . '">';
            $txt .= '<xTexto>' . $ctevalobs . '</xTexto>';
            $txt .= '</ObsCont>';
        }
    }

    //Observacoes Fisco
    $sql2 = "Select a.ctefisnome,a.ctefisobs ";
    $sql2 .= " From cteobsfisco a";
    $sql2 .= " Where a.ctenumero = '$parametro' order by a.ctefiscodigo";

    $sql2 = pg_query($sql2);
    $row2 = pg_num_rows($sql2);
    if ($row2) {
        for ($i2 = 0; $i2 < $row2; $i2++) {
            $ctevalnome = pg_fetch_result($sql2, $i2, "ctefisnome");
            $ctevalobs = pg_fetch_result($sql2, $i2, "ctefisobs");
            $txt .= '<ObsFisco xCampo="' . $ctevalnome . '">';
            $txt .= '<xTexto>' . $ctevalobs . '</xTexto>';
            $txt .= '</ObsFisco>';
        }
    }


    $txt .= '</compl>';


    $txt .= '<emit>';

    if ($cteemipessoa == 1) {
        $cteemicnpj = preg_replace("/[^0-9]/", "", $cteemicnpj);
        $txt .= '<CNPJ>' . $cteemicnpj . '</CNPJ>';
    } else {
        $cteemicpf = preg_replace("/[^0-9]/", "", $cteemicpf);
        $txt .= '<CPF>' . $cteemicpf . '</CPF>';
    }
    if ($cteemiie != 'ISENTO') {
        $cteemiie = preg_replace("/[^0-9]/", "", $cteemiie);
    }
    $txt .= '<IE>' . $cteemiie . '</IE>';

    ///3.00	
    ///Inscrição Estadual do Substituto Tributário
    //$txt.= '<IEST>' . $cteemiie . '</IEST>';		

    $txt .= '<xNome>' . $cteemirazao . '</xNome>';
    if ($cteeminguerra != '') {
        $txt .= '<xFant>' . $cteeminguerra . '</xFant>';
    }
    $txt .= '<enderEmit>';
    $txt .= '<xLgr>' . $cteemiendereco . '</xLgr>';
    $txt .= '<nro>' . $cteeminumero . '</nro>';
    if ($cteemicomplemento != '') {
        $txt .= '<xCpl>' . $cteemicomplemento . '</xCpl>';
    }
    if ($cteemibairro != '') {
        $txt .= '<xBairro>' . $cteemibairro . '</xBairro>';
    }
    $txt .= '<cMun>' . $cteemicidcodigoibge . '</cMun>';
    $txt .= '<xMun>' . $cidemi . '</xMun>';
    $txt .= '<CEP>' . $cteemicep . '</CEP>';
    $txt .= '<UF>' . $cteemiuf . '</UF>';
    $cteemifone = preg_replace("/[^0-9]/", "", $cteemifone);
    if ($cteemifone != '') {
        $txt .= '<fone>' . $cteemifone . '</fone>';
    }
    $txt .= '</enderEmit>';
    $txt .= '</emit>';

    //CTe com Remetente
    if ($remcodigo == 0 || $remcodigo == 1 || $remcodigo == '') {

        $txt .= '<rem>';
        if ($cterempessoa == '1') {
            $cteremcnpj = preg_replace("/[^0-9]/", "", $cteremcnpj);
            $txt .= '<CNPJ>' . $cteremcnpj . '</CNPJ>';
        } else {
            $cteremcpf = preg_replace("/[^0-9]/", "", $cteremcpf);
            $txt .= '<CPF>' . $cteremcpf . '</CPF>';
        }
        if ($cteremie != 'ISENTO') {
            $cteremie = preg_replace("/[^0-9]/", "", $cteremie);
        }
        $txt .= '<IE>' . $cteremie . '</IE>';
        $txt .= '<xNome>' . $cteremrazao . '</xNome>';
        if ($cteremnguerra != '') {
            $txt .= '<xFant>' . $cteremnguerra . '</xFant>';
        }
        $cteremfone = preg_replace("/[^0-9]/", "", $cteremfone);
        if ($cteremfone != '') {
            $txt .= '<fone>' . $cteremfone . '</fone>';
        }
        $txt .= '<enderReme>';
        $txt .= '<xLgr>' . $cteremendereco . '</xLgr>';
        $txt .= '<nro>' . $cteremnumero . '</nro>';
        if ($cteremcomplemento != '') {
            $txt .= '<xCpl>' . $cteremcomplemento . '</xCpl>';
        }
        if ($cterembairro != '') {
            $txt .= '<xBairro>' . $cterembairro . '</xBairro>';
        }
        $txt .= '<cMun>' . $cteremcidcodigoibge . '</cMun>';
        $txt .= '<xMun>' . $cidrem . '</xMun>';
        $txt .= '<CEP>' . $cteremcep . '</CEP>';
        $txt .= '<UF>' . $cteremuf . '</UF>';
        $txt .= '<cPais>1058</cPais>';
        $txt .= '<xPais>' . $cterempais . '</xPais>';
        $txt .= '</enderReme>';
        $txt .= '</rem>';
    }

    //CTe com Expedidor
    if ($expcodigo == 0 || $expcodigo == 1 || $expcodigo == '') {
        $txt .= '<exped>';
        if ($cteexppessoa == '1') {
            $cteexpcnpj = preg_replace("/[^0-9]/", "", $cteexpcnpj);
            $txt .= '<CNPJ>' . $cteexpcnpj . '</CNPJ>';
        } else {
            $cteexpcpf = preg_replace("/[^0-9]/", "", $cteexpcpf);
            $txt .= '<CPF>' . $cteexpcpf . '</CPF>';
        }
        if ($cteexpie != 'ISENTO') {
            $cteexpie = preg_replace("/[^0-9]/", "", $cteexpie);
        }
        $txt .= '<IE>' . $cteexpie . '</IE>';
        $txt .= '<xNome>' . $cteexprazao . '</xNome>';
        $cteexpfone = preg_replace("/[^0-9]/", "", $cteexpfone);
        if ($cteexpfone != '') {
            $txt .= '<fone>' . $cteexpfone . '</fone>';
        }
        $txt .= '<enderExped>';
        $txt .= '<xLgr>' . $cteexpendereco . '</xLgr>';
        $txt .= '<nro>' . $cteexpnumero . '</nro>';
        if ($cteexpcomplemento != '') {
            $txt .= '<xCpl>' . $cteexpcomplemento . '</xCpl>';
        }
        if ($cteexpbairro != '') {
            $txt .= '<xBairro>' . $cteexpbairro . '</xBairro>';
        }
        $txt .= '<cMun>' . $cteexpcidcodigoibge . '</cMun>';
        $txt .= '<xMun>' . $cidexp . '</xMun>';
        $txt .= '<CEP>' . $cteexpcep . '</CEP>';
        $txt .= '<UF>' . $cteexpuf . '</UF>';
        $txt .= '<cPais>1058</cPais>';
        $txt .= '<xPais>' . $cteexppais . '</xPais>';
        $txt .= '</enderExped>';
        $txt .= '</exped>';
    }

    //CTe com Recebedor
    if ($reccodigo == 0 || $reccodigo == 1 || $reccodigo == '') {
        $txt .= '<receb>';
        if ($cterecpessoa == '1') {
            $ctereccnpj = preg_replace("/[^0-9]/", "", $ctereccnpj);
            $txt .= '<CNPJ>' . $ctereccnpj . '</CNPJ>';
        } else {
            $ctereccpf = preg_replace("/[^0-9]/", "", $ctereccpf);
            $txt .= '<CPF>' . $ctereccpf . '</CPF>';
        }
        if ($cterecie != 'ISENTO') {
            $cterecie = preg_replace("/[^0-9]/", "", $cterecie);
        }
        $txt .= '<IE>' . $cterecie . '</IE>';
        $txt .= '<xNome>' . $cterecrazao . '</xNome>';
        $cterecfone = preg_replace("/[^0-9]/", "", $cterecfone);
        if ($cterecfone != '') {
            $txt .= '<fone>' . $cterecfone . '</fone>';
        }
        $txt .= '<enderReceb>';
        $txt .= '<xLgr>' . $cterecendereco . '</xLgr>';
        $txt .= '<nro>' . $cterecnumero . '</nro>';
        if ($ctereccomplemento != '') {
            $txt .= '<xCpl>' . $ctereccomplemento . '</xCpl>';
        }
        if ($cterecbairro != '') {
            $txt .= '<xBairro>' . $cterecbairro . '</xBairro>';
        }
        $txt .= '<cMun>' . $ctereccidcodigoibge . '</cMun>';
        $txt .= '<xMun>' . $cidrec . '</xMun>';
        $txt .= '<CEP>' . $ctereccep . '</CEP>';
        $txt .= '<UF>' . $cterecuf . '</UF>';
        $txt .= '<cPais>1058</cPais>';
        $txt .= '<xPais>' . $cterecpais . '</xPais>';
        $txt .= '</enderReceb>';
        $txt .= '</receb>';
    }

    //CTe com Destinatario	
    if ($descodigo == 0 || $descodigo == 1 || $descodigo == '') {
        $txt .= '<dest>';
        if ($ctedespessoa == '1') {
            $ctedescnpj = preg_replace("/[^0-9]/", "", $ctedescnpj);
            $txt .= '<CNPJ>' . $ctedescnpj . '</CNPJ>';
        } else {
            $ctedescpf = preg_replace("/[^0-9]/", "", $ctedescpf);
            $txt .= '<CPF>' . $ctedescpf . '</CPF>';
        }
        if ($ctedesie != 'ISENTO') {
            $ctedesie = preg_replace("/[^0-9]/", "", $ctedesie);
        }
        $txt .= '<IE>' . $ctedesie . '</IE>';
        $txt .= '<xNome>' . $ctedesrazao . '</xNome>';
        $ctedesfone = preg_replace("/[^0-9]/", "", $ctedesfone);
        if ($ctedesfone != '') {
            $txt .= '<fone>' . $ctedesfone . '</fone>';
        }
        if ($ctedessuframa != '' && $ctedessuframa != '0') {
            $txt .= '<ISUF>' . $ctedessuframa . '</ISUF>';
        }
        $txt .= '<enderDest>';
        $txt .= '<xLgr>' . $ctedesendereco . '</xLgr>';
        $txt .= '<nro>' . $ctedesnumero . '</nro>';
        if ($ctedescomplemento != '') {
            $txt .= '<xCpl>' . $ctedescomplemento . '</xCpl>';
        }
        if ($ctedesbairro != '') {
            $txt .= '<xBairro>' . $ctedesbairro . '</xBairro>';
        }
        $txt .= '<cMun>' . $ctedescidcodigoibge . '</cMun>';
        $txt .= '<xMun>' . $ciddes . '</xMun>';
        $txt .= '<CEP>' . $ctedescep . '</CEP>';
        $txt .= '<UF>' . $ctedesuf . '</UF>';
        $txt .= '<cPais>1058</cPais>';
        $txt .= '<xPais>' . $ctedespais . '</xPais>';
        $txt .= '</enderDest>';
        $txt .= '</dest>';
    }


    //Pretacao de Servicos
    $txt .= '<vPrest>';
    $txt .= '<vTPrest>' . number_format($cteservicos, 2, '.', '') . '</vTPrest>';
    $txt .= '<vRec>' . number_format($ctereceber, 2, '.', '') . '</vRec>';

    $sql2 = "Select a.ctevalnome,a.ctevalvalor ";
    $sql2 .= " From ctevalorservico a";
    $sql2 .= " Where a.ctenumero = '$parametro' order by a.ctevalcodigo";
    $sql2 = pg_query($sql2);
    $row2 = pg_num_rows($sql2);
    if ($row2) {
        for ($i2 = 0; $i2 < $row2; $i2++) {
            $txt .= '<Comp>';
            $ctevalnome = pg_fetch_result($sql2, $i2, "ctevalnome");
            $ctevalvalor = pg_fetch_result($sql2, $i2, "ctevalvalor");
            $txt .= '<xNome>' . $ctevalnome . '</xNome>';
            $txt .= '<vComp>' . number_format($ctevalvalor, 2, '.', '') . '</vComp>';
            $txt .= '</Comp>';
        }
    }

    $txt .= '</vPrest>';

    //Impostos - Vai Depender do Cálculo de ICMS escolhido	
    $txt .= '<imp>';
    $txt .= '<ICMS>';
    //00 - tributação normal ICMS	
    if ($sitcodigo == 1 || $sitcodigo == 0 || $sitcodigo == '') {
        $txt .= '<ICMS00>';
        $txt .= '<CST>00</CST>';
        $txt .= '<vBC>' . number_format($ctebasecalculo, 2, '.', '') . '</vBC>';
        $txt .= '<pICMS>' . number_format($ctepericms, 2, '.', '') . '</pICMS>';
        $txt .= '<vICMS>' . number_format($ctevalicms, 2, '.', '') . '</vICMS>';
        $txt .= '</ICMS00>';
    }
    //20 - tributação com BC reduzida do ICMS
    else if ($sitcodigo == 2) {
        $txt .= '<ICMS20>';
        $txt .= '<CST>20</CST>';
        $txt .= '<pRedBC>' . number_format($cteperreducao, 2, '.', '') . '</pRedBC>';
        $txt .= '<vBC>' . number_format($ctebasecalculo, 2, '.', '') . '</vBC>';
        $txt .= '<pICMS>' . number_format($ctepericms, 2, '.', '') . '</pICMS>';
        $txt .= '<vICMS>' . number_format($ctevalicms, 2, '.', '') . '</vICMS>';
        $txt .= '</ICMS20>';
    }
    //45 - ICMS Isento, não Tributado ou diferido
    else if ($sitcodigo == 3 || $sitcodigo == 4 || $sitcodigo == 5) {
        $txt .= '<ICMS45>';
        if ($sitcodigo == 3) {
            $txt .= '<CST>40</CST>';
        } else if ($sitcodigo == 4) {
            $txt .= '<CST>41</CST>';
        } else if ($sitcodigo == 5) {
            $txt .= '<CST>51</CST>';
        }
        $txt .= '</ICMS45>';
    }
    //60 - ICMS cobrado anteriormente por substituição tributária
    else if ($sitcodigo == 6) {
        $txt .= '<ICMS60>';
        $txt .= '<CST>60</CST>';
        $txt .= '<vBCSTRet>' . number_format($ctebasecalculo, 2, '.', '') . '</vBCSTRet>';
        $txt .= '<vICMSSTRet>' . number_format($ctevalicms, 2, '.', '') . '</vICMSSTRet>';
        $txt .= '<pICMSSTRet>' . number_format($ctepericms, 2, '.', '') . '</pICMSSTRet>';
        $txt .= '<vCred>' . number_format($ctecredito, 2, '.', '') . '</vCred>';
        $txt .= '</ICMS60>';
    }
    //90 - ICMS outros
    else if ($sitcodigo == 7) {
        $txt .= '<ICMS90>';
        $txt .= '<CST>90</CST>';
        $txt .= '<pRedBC>' . number_format($cteperreducao, 2, '.', '') . '</pRedBC>';
        $txt .= '<vBC>' . number_format($ctebasecalculo, 2, '.', '') . '</vBC>';
        $txt .= '<pICMS>' . number_format($ctepericms, 2, '.', '') . '</pICMS>';
        $txt .= '<vICMS>' . number_format($ctevalicms, 2, '.', '') . '</vICMS>';
        $txt .= '<vCred>' . number_format($ctecredito, 2, '.', '') . '</vCred>';
        $txt .= '</ICMS90>';
    }
    //Simples Nacional
    else if ($sitcodigo == 8) {
        $txt .= '<ICMSSN>';
        $txt .= '<indSN>1</indSN>';
        $txt .= '</ICMSSN>';
    }

    $txt .= '</ICMS>';

    $txt .= '<vTotTrib>' . number_format($ctetributos, 2, '.', '') . '</vTotTrib>';


    if ($ctevalicmsfim > 0 && $ctepreencheicms == 1) {
        if (trim($cteadcfisco) == '') {
            $cteadcfisco = "VALOR DO ICMS DE PARTILHA R$ " . number_format($ctevalicmsfim, 2, ',', '.');
        } else {
            $cteadcfisco .= " - VALOR DO ICMS DE PARTILHA R$ " . number_format($ctevalicmsfim, 2, ',', '.');
        }
    }

    if ($cteadcfisco != '') {
        $txt .= '<infAdFisco>' . $cteadcfisco . '</infAdFisco>';
    }

    //Diferencia de Aliquota
    if ($ctepreencheicms == 1) {
        $txt .= '<ICMSUFFim>';
        $txt .= '<vBCUFFim>' . number_format($ctebaseicms, 2, '.', '') . '</vBCUFFim>';
        $txt .= '<pFCPUFFim>' . number_format($cteperpobreza, 2, '.', '') . '</pFCPUFFim>';
        $txt .= '<pICMSUFFim>' . number_format($cteperinterna, 2, '.', '') . '</pICMSUFFim>';
        $txt .= '<pICMSInter>' . number_format($cteperinter, 2, '.', '') . '</pICMSInter>';
		/*
        if ($cteperpartilha == 1 || $cteperpartilha == 0 || $cteperpartilha == '') {
            $txt .= '<pICMSInterPart>' . number_format(40, 2, '.', '') . '</pICMSInterPart>';
        } else if ($cteperpartilha == 2) {
            $txt .= '<pICMSInterPart>' . number_format(60, 2, '.', '') . '</pICMSInterPart>';
        } else if ($cteperpartilha == 3) {
            $txt .= '<pICMSInterPart>' . number_format(80, 2, '.', '') . '</pICMSInterPart>';
        } else {
            $txt .= '<pICMSInterPart>' . number_format(100, 2, '.', '') . '</pICMSInterPart>';
        }
		*/
        $txt .= '<vFCPUFFim>' . number_format($ctevalpobreza, 2, '.', '') . '</vFCPUFFim>';
        $txt .= '<vICMSUFFim>' . number_format($ctevalicmsfim, 2, '.', '') . '</vICMSUFFim>';
        $txt .= '<vICMSUFIni>' . number_format($ctevalicmsini, 2, '.', '') . '</vICMSUFIni>';
        $txt .= '</ICMSUFFim>';
    }

    $txt .= '</imp>';

    if ($tctcodigox == 0 || $tctcodigox == 3) {

        //Grupo de informações do CT-e Normal e Substituto
        $txt .= '<infCTeNorm>';
        $txt .= '<infCarga>';
        $txt .= '<vCarga>' . number_format($ctecargaval, 2, '.', '') . '</vCarga>';
        $txt .= '<proPred>' . $ctepropredominante . '</proPred>';
        if ($ctepropredominante == '') {
            $erroCte .= 'Produto Predominante Invalido' . '_';
        }
        if (trim($cteoutcaracteristica) != '') {
            $txt .= '<xOutCat>' . $cteoutcaracteristica . '</xOutCat>';
        }

        $sql2 = "Select a.*,b.mednome from cteinfocarga a,tipomedida b Where a.ctenumero = '$parametro'";
        $sql2 .= " and a.medcodigo = b.medcodigo ";

        $sql2 = pg_query($sql2);
        $row2 = pg_num_rows($sql2);
        if ($row2) {

            for ($i2 = 0; $i2 < $row2; $i2++) {

                $mednome = pg_fetch_result($sql2, $i2, "mednome");
                $cteinfnome = pg_fetch_result($sql2, $i2, "cteinfnome");
                $cteinfvalor = pg_fetch_result($sql2, $i2, "cteinfvalor");

                $txt .= '<infQ>';

                if ($mednome == 'M3') {
                    $mednome = '00';
                } else if ($mednome == 'KG') {
                    $mednome = '01';
                } else if ($mednome == 'TON') {
                    $mednome = '02';
                } else if ($mednome == 'LITROS') {
                    $mednome = '04';
                } else if ($mednome == 'MMBTU') {
                    $mednome = '05';
                } else { //UNIDADE
                    $mednome = '03';
                }

                $txt .= '<cUnid>' . $mednome . '</cUnid>';
                $txt .= '<tpMed>' . $cteinfnome . '</tpMed>';
                $txt .= '<qCarga>' . number_format($cteinfvalor, 4, '.', '') . '</qCarga>';

                $txt .= '</infQ>';
            }
            ///3.00
            ///15 posições, sendo 13 inteiras e 2 decimais. Normalmente igual ao valor declarado da
            ///mercadoria, diferente por exemplo,
            ///quando a mercadoria transportada é
            ///isenta de tributos nacionais para
            ///exportação, onde é preciso averbar um
            ///valor maior, pois no caso de indenização,
            ///o valor a ser pago será maior
            $txt .= '<vCargaAverb>' . number_format($ctecargaval, 2, '.', '') . '</vCargaAverb>';
        } else {
            $erroCte .= 'Preencher Informacoes da Carga' . '_';
        }




        $txt .= '</infCarga>';

        $txt .= '<infDoc>';

        $sql2 = "Select * from ctenfechave Where ctenumero = '$parametro'";

        $sql2 = pg_query($sql2);
        $row2 = pg_num_rows($sql2);
        if ($row2) {

            for ($i2 = 0; $i2 < $row2; $i2++) {

                $ctenfenome = pg_fetch_result($sql2, $i2, "ctenfenome");
                $ctenfepin = pg_fetch_result($sql2, $i2, "ctenfepin");

                $txt .= '<infNFe>';

                $txt .= '<chave>' . $ctenfenome . '</chave>';
                if (trim($ctenfepin) != '') {
                    $txt .= '<PIN>' . $ctenfepin . '</PIN>';
                }
                //$txt.= '<dPrev>2016-09-19</dPrev>';

                $txt .= '</infNFe>';
            }
        } else {
            $erroCte .= 'Preencher Informacoes de Documentos Originarios' . '_';
        }

        $txt .= '</infDoc>';

        ///3.00
        /*
          $sql2 = "Select * from cteinfoseguro Where ctenumero = '$parametro'";

          $sql2 = pg_query($sql2);
          $row2 = pg_num_rows($sql2);
          if($row2) {

          for($i2=0; $i2<$row2; $i2++) {

          $ctesegnome      	= pg_fetch_result($sql2, $i2, "ctesegnome");
          $ctesegapolice      = trim(pg_fetch_result($sql2, $i2, "ctesegapolice"));
          $ctesegaverbacao    = trim(pg_fetch_result($sql2, $i2, "ctesegaverbacao"));
          $rescodigo      	= pg_fetch_result($sql2, $i2, "rescodigo");
          $ctesegvalor      	= pg_fetch_result($sql2, $i2, "ctesegvalor");

          $rescodigo--;

          $txt.= '<seg>';

          $txt.= '<respSeg>' . $rescodigo . '</respSeg>';  //0 - Remetente;1 - Expedidor;2 - Recebedor;3 - Destinatário;4 - Emitente do CT-e;5 - Tomador do ServiçoDados obrigatórios apenas no modal Rodoviário, depois da lei 11.442/07. Para os demais modais esta informação é opcional.
          $txt.= '<xSeg>' . $ctesegnome . '</xSeg>';
          $txt.= '<nApol>' . $ctesegapolice . '</nApol>';


          if($ctesegaverbacao!=''){
          $txt.= '<nAver>' . $ctesegaverbacao . '</nAver>';
          }

          $txt.= '<vCarga>' . number_format($ctesegvalor, 2, '.', '') .  '</vCarga>';
          if($ctesegvalor==0){
          $erroCte .= 'Preencher Informacoes do Seguro (Valor da Carga)' . '_';
          }

          $txt.= '</seg>';

          }
          }
          else {
          $erroCte .= 'Preencher Informacoes do Seguro' . '_';
          }

         */


        ///3.00
        $txt .= '<infModal versaoModal="3.00">';

        //A partir daqui depende do tipo de Modal, a principio só tera tratamento para Rodoviario
        if ($tmocodigox == '01') {
            $txt .= '<rodo>';

            $txt .= '<RNTRC>' . $cterntrc . '</RNTRC>';
            /*
              $txt.= '<dPrev>' . substr($cteentrega,0,10) . '</dPrev>';
              if(trim(substr($cteentrega,0,10))==''){
              $erroCte .= 'Preencher Data Prevista da Entrega' . '_';
              }
              if ($cteindlocacao==1){
              $cteindlocacao=1;
              }
              else
              {
              $cteindlocacao=0;
              }
              $txt.= '<lota>' . $cteindlocacao . '</lota>';   //0 - Não; 1 - Sim
              if($cteciot!==''){
              $txt.= '<CIOT>' . $cteciot . '</CIOT>';
              }
             */

            //Ordens de Coleta Associoadas
            $sql2 = "Select * from cteinfocoleta Where ctenumero = '$parametro'";
            $sql2 = pg_query($sql2);
            $row2 = pg_num_rows($sql2);
            if ($row2) {

                for ($i2 = 0; $i2 < $row2; $i2++) {

                    $ctecolserie = trim(pg_fetch_result($sql2, $i2, "ctecolserie"));
                    $ctecolnumero = trim(pg_fetch_result($sql2, $i2, "ctecolnumero"));
                    $ctecolemissao = trim(pg_fetch_result($sql2, $i2, "ctecolemissao"));
                    $ctecolcnpj = trim(pg_fetch_result($sql2, $i2, "ctecolcnpj"));
                    $ctecolinterno = trim(pg_fetch_result($sql2, $i2, "ctecolinterno"));
                    $ctecolie = trim(pg_fetch_result($sql2, $i2, "ctecolie"));
                    $ctecoluf = trim(pg_fetch_result($sql2, $i2, "ctecoluf"));
                    $ctecolfone = trim(pg_fetch_result($sql2, $i2, "ctecolfone"));


                    $txt .= '<occ>';

                    if ($ctecolserie != '') {
                        $txt .= '<serie>' . $ctecolserie . '</serie>';
                    }
                    if ($ctecolnumero != '') {
                        $txt .= '<nOcc>' . $ctecolnumero . '</nOcc>';
                    }
                    if ($ctecolemissao != '') {
                        $txt .= '<dEmi>' . substr($ctecolemissao, 0, 10) . '</dEmi>';
                    }
                    $txt .= '<emiOcc>';
                    if ($ctecolcnpj != '') {
                        $ctecolcnpj = preg_replace("/[^0-9]/", "", $ctecolcnpj);
                        $txt .= '<CNPJ>' . $ctecolcnpj . '</CNPJ>';
                    }
                    if ($ctecolinterno != '') {
                        $txt .= '<cInt>' . $ctecolinterno . '</cInt>';
                    }
                    if ($ctecolie != '') {
                        if ($ctecolie != 'ISENTO') {
                            $ctecolie = preg_replace("/[^0-9]/", "", $ctecolie);
                        }
                        $txt .= '<IE>' . $ctecolie . '</IE>';
                    }
                    if ($ctecoluf != '') {
                        $txt .= '<UF>' . $ctecoluf . '</UF>';
                    }
                    if ($ctecolfone != '') {
                        $ctecolfone = preg_replace("/[^0-9]/", "", $ctecolfone);
                        $txt .= '<fone>' . $ctecolfone . '</fone>';
                    }
                    $txt .= '</emiOcc>';

                    $txt .= '</occ>';
                }
            }


            //Informações de Vale Pedágio
            $sql2 = "Select * from cteinfopedagio Where ctenumero = '$parametro'";
            $sql2 = pg_query($sql2);
            $row2 = pg_num_rows($sql2);
            if ($row2) {
                for ($i2 = 0; $i2 < $row2; $i2++) {
                    $ctepedforne = trim(pg_fetch_result($sql2, $i2, "ctepedforne"));
                    $ctepedrespo = trim(pg_fetch_result($sql2, $i2, "ctepedrespo"));
                    $ctepednome = trim(pg_fetch_result($sql2, $i2, "ctepednome"));
                    $ctepedvalor = pg_fetch_result($sql2, $i2, "ctepedvalor");
                    $txt .= '<valePed>';
                    if ($ctepedforne != '') {
                        $ctepedforne = preg_replace("/[^0-9]/", "", $ctepedforne);
                        $txt .= '<CNPJForn>' . $ctepedforne . '</CNPJForn>';
                    }
                    if ($ctepednome != '') {
                        $txt .= '<nCompra>' . $ctepednome . '</nCompra>';
                    }
                    if ($ctepedrespo != '') {
                        $ctepedrespo = preg_replace("/[^0-9]/", "", $ctepedrespo);
                        $txt .= '<CNPJPg>' . $ctepedrespo . '</CNPJPg>';
                    }
                    $txt .= '<vValePed>' . number_format($ctepedvalor, 2, '.', '') . '</vValePed>';
                    $txt .= '</valePed>';
                }
            }


            //Dados dos Veículos
            $sql2 = "Select * from cteinfoveiculos Where ctenumero = '$parametro'";
            $sql2 = pg_query($sql2);
            $row2 = pg_num_rows($sql2);
            if ($row2) {
                for ($i2 = 0; $i2 < $row2; $i2++) {
                    $cteveicod = trim(pg_fetch_result($sql2, $i2, "cteveicod"));
                    $cteveirenavam = trim(pg_fetch_result($sql2, $i2, "cteveirenavam"));
                    $cteveiplaca = trim(pg_fetch_result($sql2, $i2, "cteveiplaca"));
                    $cteveitara = pg_fetch_result($sql2, $i2, "cteveitara");
                    $cteveicapacidadekg = pg_fetch_result($sql2, $i2, "cteveicapacidadekg");
                    $cteveicapacidadem3 = pg_fetch_result($sql2, $i2, "cteveicapacidadem3");
                    $cteveipropveiculo = pg_fetch_result($sql2, $i2, "cteveipropveiculo");
                    $cteveitpveiculo = pg_fetch_result($sql2, $i2, "cteveitpveiculo");
                    $cteveitprodado = pg_fetch_result($sql2, $i2, "cteveitprodado");
                    if ($cteveitprodado == 1 || $cteveitprodado == 0 || $cteveitprodado == '') {
                        $cteveitprodadox = '00';
                    } else if ($cteveitprodado == 2) {
                        $cteveitprodadox = '01';
                    } else if ($cteveitprodado == 3) {
                        $cteveitprodadox = '02';
                    } else if ($cteveitprodado == 4) {
                        $cteveitprodadox = '03';
                    } else if ($cteveitprodado == 5) {
                        $cteveitprodadox = '04';
                    } else if ($cteveitprodado == 6) {
                        $cteveitprodadox = '05';
                    } else if ($cteveitprodado == 7) {
                        $cteveitprodadox = '06';
                    }
                    $cteveitpcarroceria = pg_fetch_result($sql2, $i2, "cteveitpcarroceria");
                    if ($cteveitpcarroceria == 1 || $cteveitpcarroceria == 0 || $cteveitpcarroceria == '') {
                        $cteveitpcarroceriax = '00';
                    } else if ($cteveitpcarroceria == 2) {
                        $cteveitpcarroceriax = '01';
                    } else if ($cteveitpcarroceria == 3) {
                        $cteveitpcarroceriax = '02';
                    } else if ($cteveitpcarroceria == 4) {
                        $cteveitpcarroceriax = '03';
                    } else if ($cteveitpcarroceria == 5) {
                        $cteveitpcarroceriax = '04';
                    } else if ($cteveitpcarroceria == 6) {
                        $cteveitpcarroceriax = '05';
                    }
                    $cteveiuf = trim(pg_fetch_result($sql2, $i2, "cteveiuf"));
                    $cteveiempresa = trim(pg_fetch_result($sql2, $i2, "cteveiempresa"));

                    $cteveicpf = trim(pg_fetch_result($sql2, $i2, "cteveicpf"));
                    $cteveicnpj = trim(pg_fetch_result($sql2, $i2, "cteveicnpj"));
                    $cteveirntrc = trim(pg_fetch_result($sql2, $i2, "cteveirntrc"));
                    $cteveirazao = trim(pg_fetch_result($sql2, $i2, "cteveirazao"));
                    $cteveiie = trim(pg_fetch_result($sql2, $i2, "cteveiie"));
                    $cteveipropuf = trim(pg_fetch_result($sql2, $i2, "cteveipropuf"));
                    $cteveitpproprietario = pg_fetch_result($sql2, $i2, "cteveitpproprietario");
                    if ($cteveitpproprietario == 1 || $cteveitpproprietario == 0 || $cteveitpproprietario == '') {
                        $cteveitpproprietariox = '0';
                    } else if ($cteveitpproprietario == 2) {
                        $cteveitpproprietariox = '1';
                    } else if ($cteveitpproprietario == 3) {
                        $cteveitpproprietariox = '2';
                    }

                    $txt .= '<veic>';
                    if ($cteveicod != '') {
                        $txt .= '<cInt>' . $cteveicod . '</cInt>';
                    }
                    if ($cteveirenavam != '') {
                        $txt .= '<RENAVAM>' . $cteveirenavam . '</RENAVAM>';
                    }
                    if ($cteveiplaca != '') {
                        $cteveiplaca = removeTodosCaracterEspeciaisEspaco($cteveiplaca);
                        $txt .= '<placa>' . $cteveiplaca . '</placa>';
                    }
                    if ($cteveitara > 0) {
                        $txt .= '<tara>' . round($cteveitara, 0) . '</tara>';
                    }
                    if ($cteveicapacidadekg > 0) {
                        $txt .= '<capKG>' . round($cteveicapacidadekg, 0) . '</capKG>';
                    }
                    if ($cteveicapacidadem3 > 0) {
                        $txt .= '<capM3>' . round($cteveicapacidadem3, 0) . '</capM3>';
                    }
                    if ($cteveipropveiculo == 2) {
                        $txt .= '<tpProp>T</tpProp>';
                    } else {
                        $txt .= '<tpProp>P</tpProp>';
                    }
                    if ($cteveitpveiculo == 2) {
                        $txt .= '<tpVeic>1</tpVeic>';
                    } else {
                        $txt .= '<tpVeic>0</tpVeic>';
                    }
                    $txt .= '<tpRod>' . $cteveitprodadox . '</tpRod>';
                    $txt .= '<tpCar>' . $cteveitpcarroceriax . '</tpCar>';
                    if ($cteveiuf != '') {
                        $txt .= '<UF>' . $cteveiuf . '</UF>';
                    }
                    if ($cteveiempresa == 2) {
                        $txt .= '<prop>';
                        if ($cteveicpf != '') {
                            $cteveicpf = preg_replace("/[^0-9]/", "", $cteveicpf);
                            $txt .= '<CPF>' . $cteveicpf . '</CPF>';
                        } else if ($cteveicnpj != '') {
                            $cteveicnpj = preg_replace("/[^0-9]/", "", $cteveicnpj);
                            $txt .= '<CNPJ>' . $cteveicnpj . '</CNPJ>';
                        }
                        if ($cteveirntrc != '') {
                            $txt .= '<RNTRC>' . $cteveirntrc . '</RNTRC>';
                        }
                        if ($cteveirazao != '') {
                            $txt .= '<xNome>' . $cteveirazao . '</xNome>';
                        }
                        if ($cteveicpf != '') {
                            $txt .= '<IE>ISENTO</IE>';
                        } else {
                            if ($cteveiie != 'ISENTO') {
                                $cteveiie = preg_replace("/[^0-9]/", "", $cteveiie);
                            }
                            if ($cteveiie != '') {
                                $txt .= '<IE>' . $cteveiie . '</IE>';
                            }
                        }
                        if ($cteveipropuf != '') {
                            $txt .= '<UF>' . $cteveipropuf . '</UF>';
                        }
                        $txt .= '<tpProp>' . $cteveitpproprietariox . '</tpProp>';
                        $txt .= '</prop>';
                    }
                    $txt .= '</veic>';
                }
            }

            //Lacres
            $sql2 = "Select * from cteinfolacre Where ctenumero = '$parametro'";
            $sql2 = pg_query($sql2);
            $row2 = pg_num_rows($sql2);
            if ($row2) {
                for ($i2 = 0; $i2 < $row2; $i2++) {
                    $ctelacnome = trim(pg_fetch_result($sql2, $i2, "ctelacnome"));
                    $txt .= '<lacRodo>';
                    if ($ctelacnome != '') {
                        $txt .= '<nLacre>' . $ctelacnome . '</nLacre>';
                    }
                    $txt .= '</lacRodo>';
                }
            }

            //Motoristas
            $sql2 = "Select * from cteinfomotoristas Where ctenumero = '$parametro'";
            $sql2 = pg_query($sql2);
            $row2 = pg_num_rows($sql2);
            if ($row2) {
                for ($i2 = 0; $i2 < $row2; $i2++) {
                    $cteinfmotnome = trim(pg_fetch_result($sql2, $i2, "cteinfmotnome"));
                    $cteinfmotcpf = trim(pg_fetch_result($sql2, $i2, "cteinfmotcpf"));
                    $txt .= '<moto>';
                    if ($cteinfmotnome != '') {
                        $txt .= '<xNome>' . $cteinfmotnome . '</xNome>';
                    }
                    if ($cteinfmotcpf != '') {
                        $cteinfmotcpf = preg_replace("/[^0-9]/", "", $cteinfmotcpf);
                        $txt .= '<CPF>' . $cteinfmotcpf . '</CPF>';
                    }
                    $txt .= '</moto>';
                }
            }


            $txt .= '</rodo>';
        }

        $txt .= '</infModal>';

        //Dados da Cobrança		
        $sql2 = "Select * from cteinfoduplicata Where ctenumero = '$parametro'";
        $sql2 = pg_query($sql2);
        $row2 = pg_num_rows($sql2);
        if (($ctecobrancanum != '' && $ctecobrancaval > 0) || $row2) {
            $txt .= '<cobr>';
            if ($ctecobrancanum != '' && $ctecobrancaval > 0) {
                $txt .= '<fat>';
                $txt .= '<nFat>' . $ctecobrancanum . '</nFat>';
                $txt .= '<vOrig>' . number_format($ctecobrancaval, 2, '.', '') . '</vOrig>';
                $txt .= '<vDesc>' . number_format($ctecobrancades, 2, '.', '') . '</vDesc>';
                $txt .= '<vLiq>' . number_format($ctecobrancaliq, 2, '.', '') . '</vLiq>';
                $txt .= '</fat>';
            }
            if ($row2) {
                for ($i2 = 0; $i2 < $row2; $i2++) {
                    $ctedupnome = trim(pg_fetch_result($sql2, $i2, "ctedupnome"));
                    $ctedupvecto = trim(pg_fetch_result($sql2, $i2, "ctedupvecto"));
                    $ctedupvalor = trim(pg_fetch_result($sql2, $i2, "ctedupvalor"));
                    $txt .= '<dup>';
                    if ($ctedupnome != '') {
                        $txt .= '<nDup>' . $ctedupnome . '</nDup>';
                    }
                    if ($ctedupvecto != '') {
                        $txt .= '<dVenc>' . substr($ctedupvecto, 0, 10) . '</dVenc>';
                    }
                    $txt .= '<vDup>' . number_format($ctedupvalor, 2, '.', '') . '</vDup>';
                    $txt .= '</dup>';
                }
            }
            $txt .= '</cobr>';
        }

        //Se for um CTE de Substituição 
        if ($tctcodigox == 3) {
            $txt .= '<infCteSub>';
            $txt .= '<chCte>' . $ctechavefin . '</chCte>';
            if ($ctesubstipo == 1 || $ctesubstipo == 0 || $ctesubstipo == '') {
                $txt .= '<tomaICMS>';
                $txt .= '<refCte>' . $ctesubschave . '</refCte>';
                $txt .= '</tomaICMS>';
            } else if ($ctesubstipo == 2) {
                $txt .= '<tomaICMS>';
                $txt .= '<refNFe>' . $ctesubschave . '</refNFe>';
                $txt .= '</tomaICMS>';
            } else {
                $txt .= '<tomaNaoICMS>';
                $txt .= '<refCteAnu>' . $ctesubschave . '</refCteAnu>';
                $txt .= '</tomaNaoICMS>';
            }
            $txt .= '</infCteSub>';
        }

        if ($cteglobalizado == 1) {
            $txt .= '<infGlobalizado>';
            $txt .= '<xObs>Procedimento efetuado conforme Resolução/SEFAZ n. 2.833/2017</xObs>';
            $txt .= '</infGlobalizado>';
        }

        $txt .= '</infCTeNorm>';
    }
    //Detalhamento do CT-e complementado
    else if ($tctcodigox == 1) {

        //Grupo de informações do CT-e Normal e Substituto
        $txt .= '<infCteComp>';
        $txt .= '<chave>' . $ctechavefin . '</chave>';
        $txt .= '</infCteComp>';
    }
    //Detalhamento do CT-e do tipo Anulação
    else if ($tctcodigox == 2) {

        //Grupo de informações do CT-e Normal e Substituto 
        $txt .= '<infCteAnu>';
        $txt .= '<chCte>' . $ctechavefin . '</chCte>';
        if ($datatomador != '') {
            $txt .= '<dEmi>' . substr($datatomador, 0, 10) . '</dEmi>';
        }
        $txt .= '</infCteAnu>';
    }


    $txt .= '</infCte>';
		
	//Qr Code
	$txt .= '<infCTeSupl>';
	$txt .= '<qrCodCTe>' . '<![CDATA[https://nfe.fazenda.sp.gov.br/CTeConsulta/qrCode?chCTe=' . $chaveCte . '&tpAmb=' . trim($ambiente) . ']]>' . '</qrCodCTe>';	
	$txt .= '</infCTeSupl>';
	
    $txt .= '</CTe>';
	
	
    if ($erroCte == '') {
        fputs($arquivo, $txt);
    }
}


if ($chaveCte == '') {
    $chaveCte = '_';
}

fclose($arquivo);

if ($erroCte == '') {

    $nomex = "/home/delta/cte/" . $infcteidarquivo . ".xml";
    if (file_exists($nomex)) {
        unlink($nomex);
    }
    rename($nome, $nomex);

    //print("<br>&nbsp;Arquivo gerado com sucesso!");

    $erroCte = '_';
} else {
    if (file_exists($nome)) {
        unlink($nome);
    }
}


header("Content-type: application/xml");
$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";
$xml .= "<dados>";
$xml .= "<registro>";
$xml .= "<item>" . $chaveCte . "</item>";
$xml .= "<item>" . $erroCte . "</item>";
$xml .= "</registro>";
$xml .= "</dados>";

echo $xml;
pg_close($conn);
exit();

//echo "<meta HTTP-EQUIV='Refresh' CONTENT='3;URL=alterarcte.php'>";
//exit;
//26/10/2016
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

//26/10/2016

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


<script>
    //window.close();
</script>