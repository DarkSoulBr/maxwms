<?php

header('Content-Type: text/html; charset=utf-8');
require_once("include/conexao.inc.php");

//ini_set("display_errors", 1);
//error_reporting(E_ALL);

$datainicio = explode("/", $_GET['dataini']);
$auxdatainicio = $datainicio[2] . '-' . $datainicio[1] . '-' . $datainicio[0] . ' 00:00:00';

$datafinal = explode("/", $_GET['datafim']);
$auxdatafinal = $datafinal[2] . '-' . $datafinal[1] . '-' . $datafinal[0] . ' 23:59:59';

$modelo = $_GET['modelo'];
$cancelados = $_GET["cancelados"];
$autorizados = $_GET["autorizados"];
$inutilizados = $_GET["inutilizados"];

$chaveCte = '';
$erroCte = '';

$sqlCompleto = '';

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

$sql .= " where a.cteemissao between '$auxdatainicio' and '$auxdatafinal'";

if ($autorizados == 1) {
    $sqlCompleto = $sql . " and (a.ctechave is not null and a.ctecancdata is null and a.ctedatainutiliza is null)";
}
if ($cancelados == 1) {
    if ($sqlCompleto != '') {
        $sqlCompleto .= " UNION ";
    }
    $sqlCompleto .= $sql . " and (a.ctechave is not null and a.ctecancdata is not null and a.ctedatainutiliza is null)";
}
if ($inutilizados == 1) {
    if ($sqlCompleto != '') {
        $sqlCompleto .= " UNION ";
    }
    $sqlCompleto .= $sql . " and (a.ctecancdata is null and a.ctedatainutiliza is not null)";
}

$sqlCompleto .= " order by cteemissao";

$sql = pg_query($sqlCompleto);
$row = pg_num_rows($sql);

$totCte = 0;
$qtdCte = 0;

//Gera um arquivo unico
if ($modelo == 2) {
    $nome = "/home/delta/cte_datasul/nf_" . date("Y_m_d_H_i_s") . ".txt";
    if (file_exists($nome)) {
        unlink($nome);
    }
    $arquivo = fopen("$nome", "x+");
    $caminhoArquivo = $nome;
}

if ($row) {

    for ($i = 0; $i < $row; $i++) {

        $ctenumero = trim(pg_fetch_result($sql, $i, "ctenumero"));
        $parametro = $ctenumero;
        $ctemodelo = trim(pg_fetch_result($sql, $i, "ctemodelo"));
        $cteserie = trim(pg_fetch_result($sql, $i, "cteserie"));
        $ctenum = trim(pg_fetch_result($sql, $i, "ctenum"));

        if ($modelo == 1) {
            $nome = "/home/delta/cte_datasul/nf_" . str_pad((int) $ctenum, 9, '0', STR_PAD_LEFT) . ".txt";
            if (file_exists($nome)) {
                unlink($nome);
            }
            $arquivo = fopen("$nome", "x+");
            $caminhoArquivo = $nome;
        }

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

        if ($cterempessoa == '1') {
            $cteremdoc = $cteremcnpj;
        } else {
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

        if ($ctedespessoa == '1') {
            $ctedesdoc = $ctedescnpj;
        } else {
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

        if ($cteexppessoa == '1') {
            $cteexpdoc = $cteexpcnpj;
        } else {
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

        if ($cterecpessoa == '1') {
            $cterecdoc = $ctereccnpj;
        } else {
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

        if ($ctetompessoa == '1') {
            $ctetomdoc = $ctetomcnpj;
        } else {
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
        $sercodigo = $sercodigox - 1;

        $tpgcodigo = trim(pg_fetch_result($sql, $i, "tpgcodigo"));

        $ctecobrancanum = trim(pg_fetch_result($sql, $i, "ctecobrancanum"));
        $ctecobrancaval = trim(pg_fetch_result($sql, $i, "ctecobrancaval"));
        $ctecobrancades = trim(pg_fetch_result($sql, $i, "ctecobrancades"));
        $ctecobrancaliq = trim(pg_fetch_result($sql, $i, "ctecobrancaliq"));


        $ctesubschave = trim(pg_fetch_result($sql, $i, "ctesubschave"));
        $ctesubstipo = trim(pg_fetch_result($sql, $i, "ctesubstipo"));

        $chaveCte = trim(pg_fetch_result($sql, $i, "ctechave"));

        $ctecancdata = pg_fetch_result($sql, $i, "ctecancdata");
        $ctedatainutiliza = pg_fetch_result($sql, $i, "ctedatainutiliza");
        $ctemotivoinutiliza = pg_fetch_result($sql, $i, "ctemotivoinutiliza");

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
		
		if($cteremcnpj=='20.548.209/0001-00') {
			$txt .= str_pad('90961940', 9, ' ', STR_PAD_LEFT); //Codigo do Emitente vai como FUN
		} else {
			$txt .= str_pad('2', 9, ' ', STR_PAD_LEFT); //Codigo do Emitente vai como Barão
		}	
        
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
                
                if($cnpj1==''){
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

        $auxNumero = str_pad((int) $ctenum, 9, '0', STR_PAD_LEFT);




        if ($modelo == 1) {
            fclose($arquivo);
            echo "<font color='{$cor}'>CTe: <b>{$auxNumero}</b> Arquivo: <b>{$caminhoArquivo}</b> gerado com sucesso!</font><hr>";
        } else {
            echo "<font color='{$cor}'>CTe: <b>{$auxNumero}</b> processado com sucesso!</font><hr>";
        }
    }
    if ($modelo == 2) {
        fclose($arquivo);
        echo "<font color='blue'>Arquivo: <b>{$caminhoArquivo}</b> consolidado gerado com sucesso!</font><hr>";
    }
} else {

    echo "<font color='black'>Problema na geração do arquivo no formato Datasul!</font><hr>";
}

echo "<font color='black'><b>Fim de Processamento!</b></font><hr>";

pg_close($conn);

echo "<meta HTTP-EQUIV='Refresh' CONTENT='3;URL=exportadatasulcte.php'>";

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


