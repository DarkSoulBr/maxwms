<?php

header('Content-Type: text/html; charset=utf-8');
require_once("include/conexao.inc.php");

//ini_set("display_errors", 1);
//error_reporting(E_ALL);

$parametro = $_GET['cte'];

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

$sql = pg_query($sql);
$row = pg_num_rows($sql);

$totCte = 0;
$qtdCte = 0;

if ($row) {

    $ctenumero = trim(pg_fetch_result($sql, 0, "ctenumero"));
    $ctemodelo = trim(pg_fetch_result($sql, 0, "ctemodelo"));
    $cteserie = trim(pg_fetch_result($sql, 0, "cteserie"));
    $ctenum = trim(pg_fetch_result($sql, 0, "ctenum"));


    $nome = "/home/delta/cte_datasul/nf_" . str_pad((int) $ctenum, 9, '0', STR_PAD_LEFT) . ".txt";
    if (file_exists($nome)) {
        unlink($nome);
    }
    $arquivo = fopen("$nome", "x+");

    $caminhoArquivo = $nome;

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

    $chaveCte = trim(pg_fetch_result($sql, 0, "ctechave"));

    $ctecancdata = pg_fetch_result($sql, 0, "ctecancdata");
    $ctedatainutiliza = pg_fetch_result($sql, 0, "ctedatainutiliza");
    $ctemotivoinutiliza = pg_fetch_result($sql, 0, "ctemotivoinutiliza");

    $cnpj1 = trim($cteemicnpj);
    $cnpj1 = str_replace(".", "", $cnpj1);
    $cnpj1 = str_replace(",", "", $cnpj1);
    $cnpj1 = str_replace("-", "", $cnpj1);
    $cnpj1 = str_replace("/", "", $cnpj1);

    $motivocanc = "";

    if ($ctecancdata != "") {
        $aux = explode(" ", $ctecancdata);
        $aux1 = explode("-", $aux[0]);
        $ctecancdata = $aux1[2] . $aux1[1] . $aux1[0];
        $cor = "red";

        if ($ctedatainutiliza != "") {
            $aux = explode(" ", $ctedatainutiliza);
            $aux1 = explode("-", $aux[0]);
            $ctedatainutiliza = $aux1[2] . $aux1[1] . $aux1[0];
        } else {
            $ctedatainutiliza = "_";
        }

        //Localiza o Motivo
        $sql1 = "SELECT a.ctecmotivo FROM  ctecancelado a";
        $sql1 .= " WHERE a.ctenumero = '$ctenumero'";
        $sql1 = pg_query($sql1);
        $row1 = pg_num_rows($sql1);
        if ($row1) {
            $motivocanc = pg_fetch_result($sql1, 0, "ctecmotivo");
        }
    } else if ($ctedatainutiliza != "") {
        $aux = explode(" ", $ctedatainutiliza);
        $aux1 = explode("-", $aux[0]);
        $ctedatainutiliza = $aux1[2] . $aux1[1] . $aux1[0];
        $cor = "orange";
        $ctecancdata = "_";
        $motivocanc = $ctemotivoinutiliza;
    } else {
        $ctecancdata = "_";
        $ctedatainutiliza = "_";
        $cor = "green";
    }

    $txt = "1"; //Fixo
    $txt .= "02"; //Destino
    $txt .= str_pad('', 6, '0'); //Zeros
    $txt .= "200"; //Estabelecimento
    $txt .= str_pad('', 8); //Entrega Futura
    //$txt .= str_pad(substr($cteemiuf, 0, 4), 4); //Estado
    $txt .= str_pad(substr($cteremuf, 0, 4), 4); //Estado
    $txt .= str_pad(substr($ctecfop . '02', 0, 8), 8); //Natureza
    $txt .= str_pad('2', 9, ' ', STR_PAD_LEFT); //Codigo do Emitente vai como Barão
    $txt .= str_pad('', 3); //Campo Desativado
    $txt .= str_pad((int) $ctenum, 16, ' ', STR_PAD_RIGHT); //Numero da Nota
    //$txt .= str_pad($cteemipais, 20, ' ', STR_PAD_RIGHT); //Pais
    $txt .= str_pad($cterempais, 20, ' ', STR_PAD_RIGHT); //Pais
    $txt .= str_pad('', 5, '0'); //Percentual Embalagem
    $txt .= str_pad('', 5, '0'); //Percentual Frete
    $txt .= str_pad('', 5, '0'); //Desconto-1
    $txt .= str_pad('', 5, '0'); //Desconto-2
    $txt .= str_pad('', 5, '0'); //Percentual de Seguro 

    $peso = 0;
    $sql2 = "Select a.*,b.mednome from cteinfocarga a,tipomedida b Where a.ctenumero = '$parametro'";
    $sql2 .= " and a.medcodigo = b.medcodigo and a.medcodigo=2";
    $sql2 = pg_query($sql2);
    $row2 = pg_num_rows($sql2);
    if ($row2) {
        $peso = pg_fetch_result($sql2, 0, "cteinfvalor");
    }

    $txt .= str_pad(round($peso * 1000, 0), 12, '0', STR_PAD_LEFT); //Peso Bruto 12,3
    $txt .= str_pad(round($peso * 1000, 0), 12, '0', STR_PAD_LEFT); //Peso Liquido 12,3
    //$txt.= str_pad((int)$cteserie,5,' ',STR_PAD_RIGHT); //Série
    $txt .= str_pad($cteserie, 5, ' ', STR_PAD_RIGHT); //Série
    $txt .= str_pad('', 13, '0'); //Embalagem
    $txt .= str_pad('', 13, '0'); //Frete	
    $txt .= str_pad(round($cteservicos * 100, 0), 13, '0', STR_PAD_LEFT); //Frete 13,2	
    //Seguro
    $seguro = 0;
    $sql2 = "Select * from cteinfoseguro Where ctenumero = '$parametro'";

    $sql2 = pg_query($sql2);
    $row2 = pg_num_rows($sql2);
    if ($row2) {
        for ($i2 = 0; $i2 < $row2; $i2++) {
            $ctesegnome = pg_fetch_result($sql2, $i2, "ctesegnome");
            $ctesegapolice = trim(pg_fetch_result($sql2, $i2, "ctesegapolice"));
            $ctesegaverbacao = trim(pg_fetch_result($sql2, $i2, "ctesegaverbacao"));
            $rescodigo = pg_fetch_result($sql2, $i2, "rescodigo");
            $ctesegvalor = pg_fetch_result($sql2, $i2, "ctesegvalor");
            $seguro += $ctesegvalor;
        }
    }
    $txt .= str_pad(round($seguro * 100, 0), 13, '0', STR_PAD_LEFT); //Seguro 13,2	
    $txt .= str_pad('', 8, ' '); //Desconto
    $txt .= str_pad('', 6, '0'); //Percentual de Desconto
    $txt .= str_pad('', 3, '0'); //Canal
    //$txt .= str_pad($cteemibairro, 30, ' ', STR_PAD_RIGHT); //Bairro
    $txt .= str_pad($cterembairro, 30, ' ', STR_PAD_RIGHT); //Bairro
    //$txt .= str_pad($cteemicep, 12, ' ', STR_PAD_RIGHT); //CEP
    $txt .= str_pad($cteremcep, 12, ' ', STR_PAD_RIGHT); //CEP
    /*
      if ($cteemipessoa == 1) {
      $txt .= str_pad(substr(preg_replace("/[^0-9]/", "", $cteemicnpj), 0, 19), 19, ' ', STR_PAD_RIGHT); //CNPJ
      } else {
      $txt .= str_pad(substr(preg_replace("/[^0-9]/", "", $cteemicpf), 0, 19), 19, ' ', STR_PAD_RIGHT); //CPF
      }
     */
    if ($cterempessoa == 1) {
        $txt .= str_pad(substr(preg_replace("/[^0-9]/", "", $cteremcnpj), 0, 19), 19, ' ', STR_PAD_RIGHT); //CNPJ		
    } else {
        $txt .= str_pad(substr(preg_replace("/[^0-9]/", "", $cteremcpf), 0, 19), 19, ' ', STR_PAD_RIGHT); //CPF		
    }
    $txt .= str_pad($cidemi, 25, ' ', STR_PAD_RIGHT); //Cidade
    $txt .= str_pad($cidemi, 25, ' ', STR_PAD_RIGHT); //Cidade CIF
    $txt .= str_pad('', 3, '0'); //Condição de Pagamento
    $txt .= str_pad('', 12); //Código do Endereço de Entrega 
    $txt .= str_pad('', 8); //Data Base Duplicata
    $txt .= substr($cteemissao, 8, 2) . substr($cteemissao, 5, 2) . substr($cteemissao, 0, 4); //Emissão
    //$txt .= str_pad(substr(trim($cteemiendereco) . ' ' . trim($cteeminumero) . ' ' . trim($cteemicomplemento), 0, 40), 40); //Endereço
    $txt .= str_pad(substr(trim($cteremendereco) . ' ' . trim($cteremnumero) . ' ' . trim($cteremcomplemento), 0, 40), 40); //Endereço
    /*
      if ($cteemiie != 'ISENTO') {
      $cteemiie = preg_replace("/[^0-9]/", "", $cteemiie);
      }
      $txt .= str_pad($cteemiie, 19, ' ', STR_PAD_RIGHT); //I.E.
     */
    if ($cteremie != 'ISENTO') {
        $cteremie = preg_replace("/[^0-9]/", "", $cteremie);
    }
    $txt .= str_pad($cteremie, 19, ' ', STR_PAD_RIGHT); //I.E.
    $txt .= str_pad('', 20); //Marca Volumes
    $txt .= " 0"; //Moeda
    //$txt.= str_pad(substr($cteeminguerra,0,12),12); //Representante
    $txt .= "VENDA DIRETA"; //Representante
    $txt .= str_pad('', 12); //Redespacho
    $txt .= str_pad(substr($cteeminguerra, 0, 12), 12); //Transportadora
    $txt .= str_pad('', 1); //Nivel Restituição ICMS p/ Zona Franca
    $txt .= str_pad((int) $ctenum, 16, ' ', STR_PAD_RIGHT); //Numero da Fatura
    $txt .= str_pad('', 6); //Número da Tabela de Preço 
    $txt .= str_pad('', 10); //Número Volumes
    $txt .= str_pad('', 5, '0'); //Percentual de Restituição
    $txt .= str_pad('', 10); //Placa
    $txt .= str_pad('', 5); //Serie Futura
    $txt .= str_pad('', 16); //Nota Futura
    $txt .= str_pad('', 11, '0'); //Siscomex
    $txt .= "NAO"; //Libera Nota Fiscal sem Saldo 
    $txt .= str_pad('', 12); //Rota
    $txt .= str_pad('', 3, '0'); //Codigo Mensagem
    $txt .= str_pad('', 17, '0'); //Taxa Exportação
    $txt .= str_pad('', 16); //Número Processo Exportação
    $txt .= "  1"; //Tabela Financiamento 
    $txt .= " 1"; //Indice Financiamento
    $txt .= "34101"; //Codigo Portador	
    $txt .= "1"; //Modalidade
    $txt .= str_pad('', 16); //Número Nota Base
    $txt .= str_pad('', 5); //Série Base
    $txt .= str_pad('', 2); //UF Placa
    $txt .= substr($cteemissao, 8, 2) . substr($cteemissao, 5, 2) . substr($cteemissao, 0, 4); //Saida
    $txt .= str_pad('', 5); //Série Diferença de Preço
    $txt .= str_pad('', 16); //Número Nota Diferença de Preço 
    $txt .= str_pad('', 5, '0'); //Percentual Acréscimo Diferença de Preço
    $txt .= str_pad('', 13, '0'); //Valor Acréscimo Diferença de Preço
    $txt .= str_pad('', 15, '0'); //Valor Taxa Exportação Diferença de Preço
    $txt .= str_pad('', 2000); //Condições Redespacho 
    $txt .= str_pad('', 2000); //Observação
    if ($ctecancdata == "_" && $ctedatainutiliza == "_") {
        $txt .= str_pad('', 8); //Data de Cancelamento
        $situacaoNFe = "3 ";
    } else if ($ctecancdata != "_") {
        $txt .= $ctecancdata;
        $situacaoNFe = "6 ";
    } else if ($ctedatainutiliza != "_") {
        $txt .= $ctedatainutiliza;
        $situacaoNFe = "7 ";
    } else {
        $txt .= str_pad('', 8); //Data de Cancelamento
        $situacaoNFe = "3 ";
    }
    $txt .= str_pad($motivocanc, 2000); //Descrição do Motivo do Cancelamento
    $txt .= str_pad('', 2); //Moeda
    $txt .= str_pad('', 5); //Valor Percentual Desconto Tabela Preço
    $txt .= str_pad('', 50); //Percentuais Desconto Informados por Nota Fiscal
    $txt .= str_pad('', 7); //Percentual Desconto Total Nota Fiscal
    $txt .= str_pad('', 11); //Valor Desconto Total
    $txt .= str_pad('', 7); //Percentual Desconto por Valor do Pedido
    $txt .= str_pad('', 2000); //Endereço Completo

    if ($ctedatainutiliza != "_") {

        /* Se estiver sem chave ou com menos digitos será necessário criar e grava no arquivo */
        if (strlen(trim($chaveCte)) != 44) {

            $cnpj1 = trim($cteemicnpj);
            $cnpj1 = str_replace(".", "", $cnpj1);
            $cnpj1 = str_replace(",", "", $cnpj1);
            $cnpj1 = str_replace("-", "", $cnpj1);
            $cnpj1 = str_replace("/", "", $cnpj1);

            if ($cnpj1 == '') {
                $cnpj1 = '00000000000000';
            }

            //Cria um numero Randomico para o Codigo Numerico da Chave de Acesso
            $ctecodigo = mt_rand(1, 99999999);
            $ctecodigo = str_pad($ctecodigo, 8, "0", STR_PAD_LEFT);

            $infcteid = $codestado . substr($cteemissao, 2, 2) . substr($cteemissao, 5, 2) . $cnpj1 . $ctemodelo . $cteserie . str_pad($ctenum, 9, "0", STR_PAD_LEFT) . '1' . $ctecodigo;

            $digitoVerificador = dvCalcMod11($infcteid);

            $chaveCte = $infcteid . $digitoVerificador;

            $update = "Update cte set ctechave='$chaveCte' Where ctenumero = '$parametro'";
            pg_query($update);
        }
    }

    $txt .= str_pad($chaveCte, 60); //Código da Chave de Acesso NF-e    
    $txt .= $situacaoNFe; //Situação da NF-e   
    $txt .= "1"; //Tipo de Emissão NF-e
    $txt .= "200  "; //Estabelecimento
    $txt .= str_pad('', 15); //Protocolo
    $txt .= str_pad('', 8); //Modalidade de Frete
    $txt .= "01"; //Tipo CT-e
    $txt .= str_pad('', 10); //Aliquota ICMS Simples Nacional
    $txt .= "104 "; //Código Condição de Pagamento
    $txt .= str_pad('', 12); //Usuário de Cancelamento da Nota Fiscal

    fputs($arquivo, "$txt\r\n");

    //A Principio será um item apenas
    $txt = "2"; //Fixo
    $txt .= str_pad('', 3); //Baixa Estoque
    $txt .= str_pad('', 8, '0') . str_pad('', 4); //Classificação Fiscal
    $txt .= "200"; //Estabelecimento
    $txt .= str_pad('', 8); //Referencia
    $txt .= str_pad('', 8); //Data
    $txt .= str_pad('9022-2', 16, ' ', STR_PAD_RIGHT); //Codigo do Produto
    $txt .= str_pad('', 8); //Natureza Complementar
    $txt .= str_pad(substr($ctecfop . '02', 0, 8), 8); //Natureza
    $txt .= str_pad((int) $ctenum, 16, ' ', STR_PAD_RIGHT); //Numero da Nota
    $txt .= "00010"; //Sequência
    $txt .= str_pad('', 16); //Nota Complementar
    $txt .= str_pad('', 8, '0'); //Percentual de Desconto do Item 
    $txt .= str_pad(round($peso * 100000, 0), 11, '0', STR_PAD_LEFT); //Peso Bruto 11,5
    $txt .= str_pad('', 11, '0'); //Peso Embalagem 
    $txt .= str_pad(10000, 11, '0', STR_PAD_LEFT); //Quantidade 11,4
    $txt .= str_pad(10000, 11, '0', STR_PAD_LEFT); //Quantidade 11,4
    $txt .= str_pad('', 3); //Sequência Complementar
    //$txt.= str_pad((int)$cteserie,5,' ',STR_PAD_RIGHT); //Série
    $txt .= str_pad($cteserie, 5, ' ', STR_PAD_RIGHT); //Série
    $txt .= str_pad('', 5); //Série Complementar 
    $txt .= "UN"; //Unidade
    $txt .= "UN"; //Unidade
    $txt .= str_pad('', 12, '0'); //Valor Despesas
    $txt .= str_pad('', 12, '0'); //Valor Embalagem
    $txt .= str_pad('', 12, '0'); //Valor Frete
    $txt .= str_pad(round($cteservicos * 100, 0), 12, '0', STR_PAD_LEFT); //Frete 12,2	
    $txt .= str_pad(round($cteservicos * 100, 0), 12, '0', STR_PAD_LEFT); //Frete 12,2	
    $txt .= str_pad(round($cteservicos * 100, 0), 12, '0', STR_PAD_LEFT); //Frete 12,2	
    $txt .= str_pad(round($cteservicos * 100, 0), 14, '0', STR_PAD_LEFT); //Frete 14,2	
    $txt .= str_pad(round($cteservicos * 100, 0), 14, '0', STR_PAD_LEFT); //Frete 14,2	
    $txt .= str_pad(round($cteservicos * 100, 0), 14, '0', STR_PAD_LEFT); //Frete 14,2	
    $txt .= str_pad(round($seguro * 100, 0), 12, '0', STR_PAD_LEFT); //Seguro 12,2	
    $txt .= str_pad(round($cteservicos * 100, 0), 12, '0', STR_PAD_LEFT); //Frete 12,2	
    $txt .= str_pad('', 17); //Conta de Custo Contábil
    $txt .= "NAO"; //Retém IRRF 
    $txt .= str_pad('', 14, '0'); //Valor Mercadoria Líquido Moeda Forte
    $txt .= str_pad('', 14, '0'); //Valor Mercadoria Original Moeda Forte 
    $txt .= str_pad('', 14, '0'); //Valor Mercadoria Tabela Moeda Forte 
    $txt .= str_pad('', 1); //Nível Restituição
    $txt .= str_pad('', 5, '0'); //Perc. Restituição
    $txt .= str_pad(round($peso * 100000, 0), 14, '0', STR_PAD_LEFT); //Peso Bruto 14,5
    $txt .= str_pad('', 15, '0'); //Taxa de Exportação 
    $txt .= str_pad('', 7, '0'); //Valor do Desconto
    $txt .= str_pad('', 7, '0'); //Percentual de Desconto
    $txt .= str_pad(round($ctepericms * 100, 0), 5, '0', STR_PAD_LEFT); //Percentual do ICMS 3,2
    $txt .= str_pad('', 5, '0'); //Alíquota ICMS Complementar
    $txt .= str_pad('', 5, '0'); //Alíquota IPI 
    $txt .= str_pad('', 5, '0'); //Alíquota ISS
    $txt .= "01"; //Codigo Tributação ICMS
    $txt .= "02"; //Codigo Tributação IPI
    $txt .= "02"; //Codigo Tributação ISS
    $txt .= "00000"; //Codigo do Serviço
    $txt .= "NAO"; //Retem ICMS na Fonte
    $txt .= str_pad('', 6, '0'); //Percentual de Desconto de ICMS
    $txt .= str_pad('', 7, '0'); //Percentual de Redução de ICMS
    $txt .= str_pad('', 5, '0'); //Percentual de Redução de IPI
    $txt .= str_pad('', 5, '0'); //Percentual de Redução de ISS
    $txt .= str_pad('', 12, '0'); //Base de Cálculo do ICMS de Entrega Futura
    $txt .= str_pad(round($ctebasecalculo * 100, 0), 12, '0', STR_PAD_LEFT); //Base de Cálculo do ICMS 12,2
    $txt .= str_pad('', 12, '0'); //Base de Cálculo do IPI de Entrega Futura 
    $txt .= str_pad('', 12, '0'); //Base de Cálculo do IPI
    $txt .= str_pad('', 12, '0'); //Base de Cálculo do ISS 
    $txt .= str_pad('', 12, '0'); //Base ICMS Subst. Tributária de Entrega Futura 
    $txt .= str_pad('', 12, '0'); //Base ICMS Subst. Tributária
    $txt .= str_pad('', 12, '0'); //ICMS Complementar 
    $txt .= str_pad('', 12, '0'); //Valor ICMS de Entrega Futura
    $txt .= str_pad(round($ctevalicms * 100, 0), 12, '0', STR_PAD_LEFT); //Valor do ICMS 12,2
    $txt .= str_pad('', 12, '0'); //Valor ICMS Outras
    $txt .= str_pad('', 12, '0'); //Valor ICMS Não Tributado
    $txt .= str_pad('', 12, '0'); //Valor ICMS Subst. Tributária de Entrega Futura
    $txt .= str_pad('', 12, '0'); //Valor ICMS Subst. Tributária
    $txt .= str_pad('', 12, '0'); //Valor IPI de Entrega Futura 
    $txt .= str_pad('', 12, '0'); //Valor IPI
    $txt .= str_pad('', 12, '0'); //Valor IPI Outras
    $txt .= str_pad('', 12, '0'); //Valor IPI Não Tributado
    $txt .= str_pad('', 12, '0'); //Valor IRRF
    $txt .= str_pad('', 12, '0'); //Valor ISS
    $txt .= str_pad('', 12, '0'); //Valor ISS Não Tributado
    $txt .= str_pad('', 12, '0'); //Valor ISS Outras
    $txt .= str_pad('', 14, '0'); //Campo Desativado
    $txt .= str_pad('', 11, '0'); //Valor do Desconto para Zona Franca
    $txt .= str_pad('', 2000); //Narrativa 
    $txt .= str_pad('', 5); //Valor Percentual Desconto Tabela Preço 
    $txt .= str_pad('', 50); //Percentuais Descontos Informados por Item da Nota
    $txt .= str_pad('', 11); //Valor Desconto Informado
    $txt .= str_pad('', 7); //Percentual Desconto Total do Item da Nota
    $txt .= str_pad('', 11); //Valor Desconto Total
    $txt .= str_pad('', 5); //Percentual Desconto referente ao Período controlado
    $txt .= str_pad('', 5); //Percentual Desconto referente ao Prazo de Pagamento
    $txt .= str_pad('', 14); //Descontos Parametrizados (1)  Tabela Descontos
    $txt .= str_pad('', 14); //Descontos Parametrizados (2)  Tabela Descontos
    $txt .= str_pad('', 14); //Descontos Parametrizados (3)  Tabela Descontos
    $txt .= str_pad('', 14); //Descontos Parametrizados (4)  Tabela Descontos
    $txt .= str_pad('', 14); //Descontos Parametrizados (5)  Tabela Descontos
    $txt .= str_pad('', 16); //Valor do Desconto PIS para Zona Franca
    $txt .= str_pad('', 16); //Valor do Desconto COFINS para Zona Franca
    $txt .= "200  "; //Estabelecimento
    $txt .= str_pad('', 20); //Conta de Custo Contábil
    $txt .= str_pad('', 20); //Centro de Custo
    $txt .= str_pad('', 14); //Valor PIS ST
    $txt .= str_pad('', 15); //Valor Base PIS ST
    $txt .= str_pad('', 6); //Aliquota PIS ST
    $txt .= str_pad('', 14); //Valor COFINS ST
    $txt .= str_pad('', 15); //Valor Base COFINS ST
    $txt .= str_pad('', 6); //Aliquota COFINS ST
    $txt .= str_pad('', 10); //Código CSOSN Simples Nacional 
    $txt .= str_pad('', 13); //Valor Base ICMS Simples Nacional 
    $txt .= str_pad('', 13); //Valor de Crédito Simples Nacional
    $txt .= str_pad('', 36); //Número FCI
    $txt .= str_pad('', 2); //Código de Serviço de INSS
    $txt .= str_pad('', 16); //Valor de Dedução 
    $txt .= str_pad('', 14); //Base de Calculo do ISS Retido 
    $txt .= str_pad('', 14); //Aliquota do ISS Retido 
    $txt .= str_pad('', 14); //Valor do ISS Retido 
    $txt .= str_pad('', 2); //Código Situação Tributária IPI 
    $txt .= str_pad('', 2); //Código Situação Tributária PIS
    $txt .= str_pad('', 2); //Código Situação Tributária COFINS
    $txt .= str_pad('', 15); //Valor da BC do ICMS na UF de destino (vBCUFDest)
    $txt .= str_pad('', 7); //Percent ICMS Fundo Combate Pobreza UF Dest (pFCPUFDest)
    $txt .= str_pad('', 7); //Aliquota interna da UF de destino (pICMSUFDest)
    $txt .= str_pad('', 7); //Aliquota interestadual das UF envolvidas (pICMSInter)
    $txt .= str_pad('', 7); //Percent partilha do ICMS Interestadual (pICMSInterPart)
    $txt .= str_pad('', 15); //Valor ICMS Fundo Combate Pobreza UF Dest (vFCPUFDest)
    $txt .= str_pad('', 15); //Valor ICMS Interestadual para a UF Dest (vICMSUFDest)
    $txt .= str_pad('', 15); //Valor ICMS Interestadual para a UF Remet (vICMSUFRemet)    
    fputs($arquivo, "$txt\r\n");

    /*
     * Faturas da Nota Fiscal
     */
    $txt = "4"; //Fixo        
    $txt .= '01'; //1 - Dias       
    //Vencimento passa a ser dia 10 do mes seguinte
    $mes = (int) date("m");
    $ano = (int) date("Y");
    if ($mes == 12) {
        $mes = 1;
        $ano += 1;
    } else {
        $mes += 1;
    }
    $vecto = "10" . str_pad($mes, 2, '0', STR_PAD_LEFT) . trim((string) $ano);
    //$txt.= substr($cteemissao,8,2).substr($cteemissao,5,2).substr($cteemissao,0,4); //Data do Vencimento
    $txt .= $vecto; //Data do Vencimento        

    $txt .= str_pad('', 8); //Data do Desconto
    $txt .= str_pad('', 13, '0'); //Valor Desconto 
    $txt .= '01'; //Parcela
    $txt .= str_pad(round($cteservicos * 100, 0), 13, '0', STR_PAD_LEFT); //Valor da Parcela 13,2	
    $txt .= str_pad('', 13, '0'); //Valor Comissao
    $txt .= str_pad(round($cteservicos * 100, 0), 13, '0', STR_PAD_LEFT); //Valor Acumulado da Parcela 13,2	
    $txt .= 'DC'; //Espécie
    $txt .= str_pad('', 20); //Número do Boleto
    fputs($arquivo, "$txt\r\n");

    fclose($arquivo);



    echo "<font color='{$cor}'>Arquivo: <b>{$caminhoArquivo}</b> gerado com sucesso!</font><hr>";
} else {

    echo "<font color='black'>Problema na geração do arquivo no formato Datasul!</font><hr>";
}


pg_close($conn);
exit();

function removeTodosCaracterEspeciaisEspaco($text) {
    $palavra = $text;
    if (version_compare(PHP_VERSION, '7.0.0', '<')) {
        $palavra = ereg_replace("[^a-zA-Z0-9]", "", strtr($palavra, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ-", "aaaaeeiooouucAAAAEEIOOOUUC"));
    } else {
        $palavra = preg_replace("[^a-zA-Z0-9]", "", strtr($palavra, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ-", "aaaaeeiooouucAAAAEEIOOOUUC"));
    }
    return $palavra;
}

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

?>


