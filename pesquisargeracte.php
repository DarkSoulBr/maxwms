<?php

require_once("include/conexao.inc.php");
require_once("include/banco.php");

//------------- variáveis -----------------// 
$flag = $_GET["flag"];
$cte = $_GET["cte"];

//---------- instancia o objeto -----------//
$cadastro = new banco($conn, $db);

//---- Cabeçalho para a geração do xml ----//
header("Content-type: application/xml");
$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";


//----- Número do orçamento cadastrado ----//
if ($flag == "NumeroOrcamento") {


    $sql = "Select a.*,to_char(a.cteemissao, 'DD/MM/YYYY') as cteemissao1,to_char(a.ctedatatomador, 'DD/MM/YYYY') as ctedatatomador1,b.tmonome,c.sernome,d.tomnome,e.tfonome,f.tctnome,g.descricao as cidinicio,";
    $sql .= "h.descricao as cidfinal,i.descricao as cidrem,j.descricao as ciddes,k.descricao as cidexp,l.descricao as cidrec,m.descricao as cidtom,";
    $sql .= "n.sitnome,cteperreducao,ctebasecalculo,ctepericms,ctevalicms,cteobsgeral,o.topnome,to_char(a.cteentrega, 'DD/MM/YYYY') as cteentrega1,p.descricao as cidemi from cte a ";
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




    $sql .= " Where a.ctenumero = '$cte'";




    $sql = pg_query($sql);
    $row = pg_num_rows($sql);
    if ($row) {

        $ctenumero = pg_fetch_result($sql, 0, "ctenumero");
        $ctemodelo = pg_fetch_result($sql, 0, "ctemodelo");
        $cteserie = pg_fetch_result($sql, 0, "cteserie");
        $ctenum = pg_fetch_result($sql, 0, "ctenum");
        $cteemissao = pg_fetch_result($sql, 0, "cteemissao1");
        $ctehorario = pg_fetch_result($sql, 0, "ctehorario");
        $ctechave = pg_fetch_result($sql, 0, "ctechave");
        $tmonome = pg_fetch_result($sql, 0, "tmonome");
        $sernome = pg_fetch_result($sql, 0, "sernome");
        $ctechaveref = pg_fetch_result($sql, 0, "ctechaveref");
        $ctechavefin = pg_fetch_result($sql, 0, "ctechavefin");
        $ctedatatomador = pg_fetch_result($sql, 0, "ctedatatomador1");
        $tomnome = pg_fetch_result($sql, 0, "tomnome");
        $tfonome = pg_fetch_result($sql, 0, "tfonome");
        $ctecfop = pg_fetch_result($sql, 0, "ctecfop");
        $ctenatureza = pg_fetch_result($sql, 0, "ctenatureza");
        $tctnome = pg_fetch_result($sql, 0, "tctnome");
        $cidinicio = pg_fetch_result($sql, 0, "cidinicio");
        $cteufinicio = pg_fetch_result($sql, 0, "cteufinicio");
        $cidfinal = pg_fetch_result($sql, 0, "cidfinal");
        $cteuffinal = pg_fetch_result($sql, 0, "cteuffinal");


        $cteremrazao = pg_fetch_result($sql, 0, "cteremrazao");
        $cteremendereco = pg_fetch_result($sql, 0, "cteremendereco");
        $cterembairro = pg_fetch_result($sql, 0, "cterembairro");
        $cteremnumero = pg_fetch_result($sql, 0, "cteremnumero");
        $cidrem = pg_fetch_result($sql, 0, "cidrem");
        $cteremfone = pg_fetch_result($sql, 0, "cteremfone");
        $cterempais = pg_fetch_result($sql, 0, "cterempais");
        $cteremuf = pg_fetch_result($sql, 0, "cteremuf");

        $cterempessoa = pg_fetch_result($sql, 0, "cterempessoa");
        $cteremcep = pg_fetch_result($sql, 0, "cteremcep");
        $cteremcnpj = pg_fetch_result($sql, 0, "cteremcnpj");
        $cteremie = pg_fetch_result($sql, 0, "cteremie");
        $cteremcpf = pg_fetch_result($sql, 0, "cteremcpf");

        if ($cterempessoa == '1') {
            $cteremdoc = $cteremcnpj;
        } else {
            $cteremdoc = $cteremcpf;
        }




        $ctedesrazao = pg_fetch_result($sql, 0, "ctedesrazao");
        $ctedesendereco = pg_fetch_result($sql, 0, "ctedesendereco");
        $ctedesbairro = pg_fetch_result($sql, 0, "ctedesbairro");
        $ctedesnumero = pg_fetch_result($sql, 0, "ctedesnumero");
        $ctedessuframa = pg_fetch_result($sql, 0, "ctedessuframa");
        $ciddes = pg_fetch_result($sql, 0, "ciddes");
        $ctedesfone = pg_fetch_result($sql, 0, "ctedesfone");
        $ctedespais = pg_fetch_result($sql, 0, "ctedespais");
        $ctedesuf = pg_fetch_result($sql, 0, "ctedesuf");

        $ctedespessoa = pg_fetch_result($sql, 0, "ctedespessoa");
        $ctedescep = pg_fetch_result($sql, 0, "ctedescep");
        $ctedescnpj = pg_fetch_result($sql, 0, "ctedescnpj");
        $ctedesie = pg_fetch_result($sql, 0, "ctedesie");
        $ctedescpf = pg_fetch_result($sql, 0, "ctedescpf");

        if ($ctedespessoa == '1') {
            $ctedesdoc = $ctedescnpj;
        } else {
            $ctedesdoc = $ctedescpf;
        }






        $cteexprazao = pg_fetch_result($sql, 0, "cteexprazao");
        $cteexpendereco = pg_fetch_result($sql, 0, "cteexpendereco");
        $cteexpbairro = pg_fetch_result($sql, 0, "cteexpbairro");
        $cteexpnumero = pg_fetch_result($sql, 0, "cteexpnumero");
        $cidexp = pg_fetch_result($sql, 0, "cidexp");
        $cteexpfone = pg_fetch_result($sql, 0, "cteexpfone");
        $cteexppais = pg_fetch_result($sql, 0, "cteexppais");
        $cteexpuf = pg_fetch_result($sql, 0, "cteexpuf");

        $cteexppessoa = pg_fetch_result($sql, 0, "cteexppessoa");
        $cteexpcep = pg_fetch_result($sql, 0, "cteexpcep");
        $cteexpcnpj = pg_fetch_result($sql, 0, "cteexpcnpj");
        $cteexpie = pg_fetch_result($sql, 0, "cteexpie");
        $cteexpcpf = pg_fetch_result($sql, 0, "cteexpcpf");

        if ($cteexppessoa == '1') {
            $cteexpdoc = $cteexpcnpj;
        } else {
            $cteexpdoc = $cteexpcpf;
        }

        $cterecrazao = pg_fetch_result($sql, 0, "cterecrazao");
        $cterecendereco = pg_fetch_result($sql, 0, "cterecendereco");
        $cterecbairro = pg_fetch_result($sql, 0, "cterecbairro");
        $cterecnumero = pg_fetch_result($sql, 0, "cterecnumero");
        $cidrec = pg_fetch_result($sql, 0, "cidrec");
        $cterecfone = pg_fetch_result($sql, 0, "cterecfone");
        $cterecpais = pg_fetch_result($sql, 0, "cterecpais");
        $cterecuf = pg_fetch_result($sql, 0, "cterecuf");

        $cterecpessoa = pg_fetch_result($sql, 0, "cterecpessoa");
        $ctereccep = pg_fetch_result($sql, 0, "ctereccep");
        $ctereccnpj = pg_fetch_result($sql, 0, "ctereccnpj");
        $cterecie = pg_fetch_result($sql, 0, "cterecie");
        $ctereccpf = pg_fetch_result($sql, 0, "ctereccpf");

        if ($cterecpessoa == '1') {
            $cterecdoc = $ctereccnpj;
        } else {
            $cterecdoc = $ctereccpf;
        }

        $ctetomrazao = pg_fetch_result($sql, 0, "ctetomrazao");
        $ctetomendereco = pg_fetch_result($sql, 0, "ctetomendereco");
        $ctetombairro = pg_fetch_result($sql, 0, "ctetombairro");
        $ctetomnumero = pg_fetch_result($sql, 0, "ctetomnumero");
        $cidtom = pg_fetch_result($sql, 0, "cidtom");
        $ctetomfone = pg_fetch_result($sql, 0, "ctetomfone");
        $ctetompais = pg_fetch_result($sql, 0, "ctetompais");
        $ctetomuf = pg_fetch_result($sql, 0, "ctetomuf");
        $ctetompessoa = pg_fetch_result($sql, 0, "ctetompessoa");
        $ctetomcep = pg_fetch_result($sql, 0, "ctetomcep");
        $ctetomcnpj = pg_fetch_result($sql, 0, "ctetomcnpj");
        $ctetomie = pg_fetch_result($sql, 0, "ctetomie");
        $ctetomcpf = pg_fetch_result($sql, 0, "ctetomcpf");

        if ($ctetompessoa == '1') {
            $ctetomdoc = $ctetomcnpj;
        } else {
            $ctetomdoc = $ctetomcpf;
        }

        $ctepropredominante = pg_fetch_result($sql, 0, "ctepropredominante");
        $cteoutcaracteristica = pg_fetch_result($sql, 0, "cteoutcaracteristica");
        $ctecargaval = pg_fetch_result($sql, 0, "ctecargaval");
        $cteservicos = pg_fetch_result($sql, 0, "cteservicos");
        $ctereceber = pg_fetch_result($sql, 0, "ctereceber");
        $sitnome = pg_fetch_result($sql, 0, "sitnome");

        $cteperreducao = pg_fetch_result($sql, 0, "cteperreducao");
        $ctebasecalculo = pg_fetch_result($sql, 0, "ctebasecalculo");
        $ctepericms = pg_fetch_result($sql, 0, "ctepericms");
        $ctevalicms = pg_fetch_result($sql, 0, "ctevalicms");

        $cteobsgeral = pg_fetch_result($sql, 0, "cteobsgeral");


        $cterntrc = pg_fetch_result($sql, 0, "cterntrc");
        $cteentrega = pg_fetch_result($sql, 0, "cteentrega1");
        $cteciot = pg_fetch_result($sql, 0, "cteciot");
        $topnome = pg_fetch_result($sql, 0, "topnome");


        $tmocodigo = pg_fetch_result($sql, 0, "tmocodigo");
        $sercodigo = pg_fetch_result($sql, 0, "sercodigo");
        $tctcodigo = pg_fetch_result($sql, 0, "tctcodigo");
        $tpgcodigo = pg_fetch_result($sql, 0, "tpgcodigo");
        $tfocodigo = pg_fetch_result($sql, 0, "tfocodigo");

        $cteufemissao = pg_fetch_result($sql, 0, "cteufemissao");
        $cteufinicio = pg_fetch_result($sql, 0, "cteufinicio");
        $cteuffinal = pg_fetch_result($sql, 0, "cteuffinal");
        $ctecidemissao = pg_fetch_result($sql, 0, "ctecidemissao");
        $ctecidinicio = pg_fetch_result($sql, 0, "ctecidinicio");
        $ctecidfinal = pg_fetch_result($sql, 0, "ctecidfinal");

        $cteemipessoa = pg_fetch_result($sql, 0, "cteemipessoa");
        $cteemicnpj = pg_fetch_result($sql, 0, "cteemicnpj");
        $cteemiie = pg_fetch_result($sql, 0, "cteemiie");
        $cteemicpf = pg_fetch_result($sql, 0, "cteemicpf");
        $cteemirg = pg_fetch_result($sql, 0, "cteemirg");
        $cteeminguerra = pg_fetch_result($sql, 0, "cteeminguerra");
        $cteemirazao = pg_fetch_result($sql, 0, "cteemirazao");
        $cteemicep = pg_fetch_result($sql, 0, "cteemicep");
        $cteemiendereco = pg_fetch_result($sql, 0, "cteemiendereco");
        $cteeminumero = pg_fetch_result($sql, 0, "cteeminumero");
        $cteemibairro = pg_fetch_result($sql, 0, "cteemibairro");
        $cteemicomplemento = pg_fetch_result($sql, 0, "cteemicomplemento");
        $cteemifone = pg_fetch_result($sql, 0, "cteemifone");
        $cteemipais = pg_fetch_result($sql, 0, "cteemipais");
        $cteemiuf = pg_fetch_result($sql, 0, "cteemiuf");
        $cteemicidcodigo = pg_fetch_result($sql, 0, "cteemicidcodigo");
        $cteemicidcodigoibge = pg_fetch_result($sql, 0, "cteemicidcodigoibge");
        $cidemi = pg_fetch_result($sql, 0, "cidemi");

        $tomcodigo = pg_fetch_result($sql, 0, "tomcodigo");
        //$tompessoa = pg_fetch_result($sql, 0, "tompessoa");
        $tompessoa = '';
        $ctetomrg = pg_fetch_result($sql, 0, "ctetomrg");
        $ctetomnguerra = pg_fetch_result($sql, 0, "ctetomnguerra");
        $ctetombairro = pg_fetch_result($sql, 0, "ctetombairro");
        $ctetomcomplemento = pg_fetch_result($sql, 0, "ctetomcomplemento");
        $ctetomuf = pg_fetch_result($sql, 0, "ctetomuf");
        $ctetomcidcodigo = pg_fetch_result($sql, 0, "ctetomcidcodigo");
        $ctetomcidcodigoibge = pg_fetch_result($sql, 0, "ctetomcidcodigoibge");
        $ctetompessoa = pg_fetch_result($sql, 0, "ctetompessoa");


        $remcodigo = pg_fetch_result($sql, 0, "remcodigo");
        $cteremrg = pg_fetch_result($sql, 0, "cteremrg");
        $cteremnguerra = pg_fetch_result($sql, 0, "cteremnguerra");
        $cteremcomplemento = pg_fetch_result($sql, 0, "cteremcomplemento");
        $cteremuf = pg_fetch_result($sql, 0, "cteremuf");
        $cteremcidcodigo = pg_fetch_result($sql, 0, "cteremcidcodigo");
        $cteremcidcodigoibge = pg_fetch_result($sql, 0, "cteremcidcodigoibge");



        $expcodigo = pg_fetch_result($sql, 0, "expcodigo");
        $cteexprg = pg_fetch_result($sql, 0, "cteexprg");
        $cteexpnguerra = pg_fetch_result($sql, 0, "cteexpnguerra");
        $cteexpcomplemento = pg_fetch_result($sql, 0, "cteexpcomplemento");
        $cteexpuf = pg_fetch_result($sql, 0, "cteexpuf");
        $cteexpcidcodigo = pg_fetch_result($sql, 0, "cteexpcidcodigo");
        $cteexpcidcodigoibge = pg_fetch_result($sql, 0, "cteexpcidcodigoibge");


        $reccodigo = pg_fetch_result($sql, 0, "reccodigo");
        $cterecrg = pg_fetch_result($sql, 0, "cterecrg");
        $cterecnguerra = pg_fetch_result($sql, 0, "cterecnguerra");
        $ctereccomplemento = pg_fetch_result($sql, 0, "ctereccomplemento");
        $cterecuf = pg_fetch_result($sql, 0, "cterecuf");
        $ctereccidcodigo = pg_fetch_result($sql, 0, "ctereccidcodigo");
        $ctereccidcodigoibge = pg_fetch_result($sql, 0, "ctereccidcodigoibge");



        $descodigo = pg_fetch_result($sql, 0, "descodigo");
        $ctedesrg = pg_fetch_result($sql, 0, "ctedesrg");
        $ctedesnguerra = pg_fetch_result($sql, 0, "ctedesnguerra");
        $ctedescomplemento = pg_fetch_result($sql, 0, "ctedescomplemento");
        $ctedesuf = pg_fetch_result($sql, 0, "ctedesuf");
        $ctedescidcodigo = pg_fetch_result($sql, 0, "ctedescidcodigo");
        $ctedescidcodigoibge = pg_fetch_result($sql, 0, "ctedescidcodigoibge");


        $cteservicos = pg_fetch_result($sql, 0, "cteservicos");
        $ctereceber = pg_fetch_result($sql, 0, "ctereceber");
        $ctetributos = pg_fetch_result($sql, 0, "ctetributos");
        $sitcodigo = pg_fetch_result($sql, 0, "sitcodigo");
        $cteperreducao = pg_fetch_result($sql, 0, "cteperreducao");
        $ctebasecalculo = pg_fetch_result($sql, 0, "ctebasecalculo");
        $ctepericms = pg_fetch_result($sql, 0, "ctepericms");
        $ctevalicms = pg_fetch_result($sql, 0, "ctevalicms");
        $ctecredito = pg_fetch_result($sql, 0, "ctecredito");
        $ctepreencheicms = pg_fetch_result($sql, 0, "ctepreencheicms");
        $ctebaseicms = pg_fetch_result($sql, 0, "ctebaseicms");
        $cteperinterna = pg_fetch_result($sql, 0, "cteperinterna");
        $cteperinter = pg_fetch_result($sql, 0, "cteperinter");
        $cteperpartilha = pg_fetch_result($sql, 0, "cteperpartilha");
        $ctevalicmsini = pg_fetch_result($sql, 0, "ctevalicmsini");
        $ctevalicmsfim = pg_fetch_result($sql, 0, "ctevalicmsfim");
        $cteperpobreza = pg_fetch_result($sql, 0, "cteperpobreza");
        $ctevalpobreza = pg_fetch_result($sql, 0, "ctevalpobreza");
        $cteadcfisco = pg_fetch_result($sql, 0, "cteadcfisco");



        $ctecargaval = pg_fetch_result($sql, 0, "ctecargaval");
        $ctepropredominante = pg_fetch_result($sql, 0, "ctepropredominante");
        $cteoutcaracteristica = pg_fetch_result($sql, 0, "cteoutcaracteristica");
        $ctecobrancanum = pg_fetch_result($sql, 0, "ctecobrancanum");
        $ctecobrancaval = pg_fetch_result($sql, 0, "ctecobrancaval");
        $ctecobrancades = pg_fetch_result($sql, 0, "ctecobrancades");
        $ctecobrancaliq = pg_fetch_result($sql, 0, "ctecobrancaliq");
        $cterntrc = pg_fetch_result($sql, 0, "cterntrc");
        $cteentrega2 = pg_fetch_result($sql, 0, "cteentrega");
        $cteindlocacao = pg_fetch_result($sql, 0, "cteindlocacao");
        $cteciot = pg_fetch_result($sql, 0, "cteciot");
        $cteobsgeral = pg_fetch_result($sql, 0, "cteobsgeral");


        $ctesubstipo = pg_fetch_result($sql, 0, "ctesubstipo");
        $ctesubschave = pg_fetch_result($sql, 0, "ctesubschave");


        //Dados SEFAZ
        $sefazchave = pg_fetch_result($sql, 0, "ctechave");
        $sefazemissao = pg_fetch_result($sql, 0, "cteemissao");
        $sefazrecebto = pg_fetch_result($sql, 0, "cterecebto");
        $sefazstatus = pg_fetch_result($sql, 0, "ctemotivo");
        $sefazprotocolo = pg_fetch_result($sql, 0, "ctenprot");
        $sefazcancchave = pg_fetch_result($sql, 0, "ctecancchave");
        $sefazcancemissao = pg_fetch_result($sql, 0, "ctecancdata");
        $sefazcancrecebto = pg_fetch_result($sql, 0, "ctecancrecebto");
        $sefazcancstatus = pg_fetch_result($sql, 0, "ctecancmotivo");
        $sefazcancprotocolo = pg_fetch_result($sql, 0, "ctecancnprot");

        $inutmotivo = pg_fetch_result($sql, 0, "ctemotivoinutiliza");
        $inutdata = pg_fetch_result($sql, 0, "ctedatainutiliza");
    }


    //$ctenum = pg_fetch_result($sql, 0, "ctenum"); 


    if (trim($ctemodelo) == "") {
        $ctemodelo = "0";
    }
    if (trim($cteserie) == "") {
        $cteserie = "0";
    }
    if (trim($ctenumero) == "") {
        $ctenumero = "0";
    }

    if (trim($ctenum) == "") {
        $ctenum = "0";
    }

    if (trim($cteemissao) == "") {
        $cteemissao = "0";
    }
    if (trim($ctehorario) == "") {
        $ctehorario = "0";
    }
    if (trim($ctechave) == "") {
        $ctechave = "0";
    }
    if (trim($tmonome) == "") {
        $tmonome = "0";
    }
    if (trim($sernome) == "") {
        $sernome = "0";
    }
    if (trim($ctechaveref) == "") {
        $ctechaveref = "0";
    }
    if (trim($ctechavefin) == "") {
        $ctechavefin = "0";
    }
    if (trim($ctedatatomador) == "") {
        $ctedatatomador = "0";
    }
    if (trim($tomnome) == "") {
        $tomnome = "0";
    }
    if (trim($tfonome) == "") {
        $tfonome = "0";
    }
    if (trim($ctecfop) == "") {
        $ctecfop = "0";
    }
    if (trim($ctenatureza) == "") {
        $ctenatureza = "0";
    }
    if (trim($tctnome) == "") {
        $tctnome = "0";
    }
    if (trim($cidinicio) == "") {
        $cidinicio = "0";
    }
    if (trim($cteufinicio) == "") {
        $cteufinicio = "0";
    }
    if (trim($cidfinal) == "") {
        $cidfinal = "0";
    }
    if (trim($cteuffinal) == "") {
        $cteuffinal = "0";
    }
    if (trim($cteremrazao) == "") {
        $cteremrazao = "0";
    }
    if (trim($cteremendereco) == "") {
        $cteremendereco = "0";
    }
    if (trim($cterembairro) == "") {
        $cterembairro = "0";
    }
    if (trim($cteremnumero) == "") {
        $cteremnumero = "0";
    }
    if (trim($cidrem) == "") {
        $cidrem = "0";
    }
    if (trim($cteremfone) == "") {
        $cteremfone = "0";
    }
    if (trim($cterempais) == "") {
        $cterempais = "0";
    }
    if (trim($cteremuf) == "") {
        $cteremuf = "0";
    }
    if (trim($cterempessoa) == "") {
        $cterempessoa = "0";
    }
    if (trim($cteremcep) == "") {
        $cteremcep = "0";
    }
    if (trim($cteremcnpj) == "") {
        $cteremcnpj = "0";
    }
    if (trim($cteremie) == "") {
        $cteremie = "0";
    }
    if (trim($cteremcpf) == "") {
        $cteremcpf = "0";
    }
    if (trim($ctedesrazao) == "") {
        $ctedesrazao = "0";
    }
    if (trim($ctedesendereco) == "") {
        $ctedesendereco = "0";
    }
    if (trim($ctedesbairro) == "") {
        $ctedesbairro = "0";
    }
    if (trim($ctedesnumero) == "") {
        $ctedesnumero = "0";
    }
    if (trim($ctedessuframa) == "") {
        $ctedessuframa = "0";
    }
    if (trim($ciddes) == "") {
        $ciddes = "0";
    }
    if (trim($ctedesfone) == "") {
        $ctedesfone = "0";
    }
    if (trim($ctedespais) == "") {
        $ctedespais = "0";
    }
    if (trim($ctedesuf) == "") {
        $ctedesuf = "0";
    }
    if (trim($ctedespessoa) == "") {
        $ctedespessoa = "0";
    }
    if (trim($ctedescep) == "") {
        $ctedescep = "0";
    }
    if (trim($ctedescnpj) == "") {
        $ctedescnpj = "0";
    }
    if (trim($ctedesie) == "") {
        $ctedesie = "0";
    }
    if (trim($ctedescpf) == "") {
        $ctedescpf = "0";
    }
    if (trim($cteexprazao) == "") {
        $cteexprazao = "0";
    }
    if (trim($cteexpendereco) == "") {
        $cteexpendereco = "0";
    }
    if (trim($cteexpbairro) == "") {
        $cteexpbairro = "0";
    }
    if (trim($cteexpnumero) == "") {
        $cteexpnumero = "0";
    }
    if (trim($cidexp) == "") {
        $cidexp = "0";
    }
    if (trim($cteexpfone) == "") {
        $cteexpfone = "0";
    }
    if (trim($cteexppais) == "") {
        $cteexppais = "0";
    }
    if (trim($cteexpuf) == "") {
        $cteexpuf = "0";
    }
    if (trim($cteexppessoa) == "") {
        $cteexppessoa = "0";
    }
    if (trim($cteexpcep) == "") {
        $cteexpcep = "0";
    }
    if (trim($cteexpcnpj) == "") {
        $cteexpcnpj = "0";
    }
    if (trim($cteexpie) == "") {
        $cteexpie = "0";
    }
    if (trim($cteexpcpf) == "") {
        $cteexpcpf = "0";
    }
    if (trim($cterecrazao) == "") {
        $cterecrazao = "0";
    }
    if (trim($cterecendereco) == "") {
        $cterecendereco = "0";
    }
    if (trim($cterecbairro) == "") {
        $cterecbairro = "0";
    }
    if (trim($cterecnumero) == "") {
        $cterecnumero = "0";
    }
    if (trim($cidrec) == "") {
        $cidrec = "0";
    }
    if (trim($cterecfone) == "") {
        $cterecfone = "0";
    }
    if (trim($cterecpais) == "") {
        $cterecpais = "0";
    }
    if (trim($cterecuf) == "") {
        $cterecuf = "0";
    }
    if (trim($cterecpessoa) == "") {
        $cterecpessoa = "0";
    }
    if (trim($ctereccep) == "") {
        $ctereccep = "0";
    }
    if (trim($ctereccnpj) == "") {
        $ctereccnpj = "0";
    }
    if (trim($cterecie) == "") {
        $cterecie = "0";
    }
    if (trim($ctereccpf) == "") {
        $ctereccpf = "0";
    }
    if (trim($ctetomrazao) == "") {
        $ctetomrazao = "0";
    }
    if (trim($ctetomendereco) == "") {
        $ctetomendereco = "0";
    }
    if (trim($ctetombairro) == "") {
        $ctetombairro = "0";
    }
    if (trim($ctetomnumero) == "") {
        $ctetomnumero = "0";
    }
    if (trim($cidtom) == "") {
        $cidtom = "0";
    }
    if (trim($ctetomfone) == "") {
        $ctetomfone = "0";
    }
    if (trim($ctetompais) == "") {
        $ctetompais = "0";
    }
    if (trim($ctetomuf) == "") {
        $ctetomuf = "0";
    }
    if (trim($ctetompessoa) == "") {
        $ctetompessoa = "0";
    }
    if (trim($ctetomcep) == "") {
        $ctetomcep = "0";
    }
    if (trim($ctetomcnpj) == "") {
        $ctetomcnpj = "0";
    }
    if (trim($ctetomie) == "") {
        $ctetomie = "0";
    }
    if (trim($ctetomcpf) == "") {
        $ctetomcpf = "0";
    }
    if (trim($ctepropredominante) == "") {
        $ctepropredominante = "0";
    }
    if (trim($cteoutcaracteristica) == "") {
        $cteoutcaracteristica = "0";
    }
    if (trim($ctecargaval) == "") {
        $ctecargaval = "0";
    }
    if (trim($cteservicos) == "") {
        $cteservicos = "0";
    }
    if (trim($ctereceber) == "") {
        $ctereceber = "0";
    }
    if (trim($sitnome) == "") {
        $sitnome = "0";
    }
    if (trim($cteperreducao) == "") {
        $cteperreducao = "0";
    }
    if (trim($ctebasecalculo) == "") {
        $ctebasecalculo = "0";
    }
    if (trim($ctepericms) == "") {
        $ctepericms = "0";
    }
    if (trim($ctevalicms) == "") {
        $ctevalicms = "0";
    }
    if (trim($cteobsgeral) == "") {
        $cteobsgeral = "0";
    }
    if (trim($cterntrc) == "") {
        $cterntrc = "0";
    }
    if (trim($cteentrega) == "") {
        $cteentrega = "0";
    }
    if (trim($cteciot) == "") {
        $cteciot = "0";
    }
    if (trim($topnome) == "") {
        $topnome = "0";
    }


    if (trim($tmocodigo) == "") {
        $tmocodigo = "0";
    }
    if (trim($sercodigo) == "") {
        $sercodigo = "0";
    }
    if (trim($tctcodigo) == "") {
        $tctcodigo = "0";
    }
    if (trim($tpgcodigo) == "") {
        $tpgcodigo = "0";
    }
    if (trim($tfocodigo) == "") {
        $tfocodigo = "0";
    }


    if (trim($cteufemissao) == "") {
        $cteufemissao = "0";
    }
    if (trim($cteufinicio) == "") {
        $cteufinicio = "0";
    }
    if (trim($cteuffinal) == "") {
        $cteuffinal = "0";
    }
    if (trim($ctecidemissao) == "") {
        $ctecidemissao = "0";
    }
    if (trim($ctecidinicio) == "") {
        $ctecidinicio = "0";
    }
    if (trim($ctecidfinal) == "") {
        $ctecidfinal = "0";
    }


    if (trim($cteemipessoa) == "") {
        $cteemipessoa = "0";
    }
    if (trim($cteemicnpj) == "") {
        $cteemicnpj = "0";
    }
    if (trim($cteemiie) == "") {
        $cteemiie = "0";
    }
    if (trim($cteemicpf) == "") {
        $cteemicpf = "0";
    }
    if (trim($cteemirg) == "") {
        $cteemirg = "0";
    }
    if (trim($cteeminguerra) == "") {
        $cteeminguerra = "0";
    }
    if (trim($cteemirazao) == "") {
        $cteemirazao = "0";
    }
    if (trim($cteemicep) == "") {
        $cteemicep = "0";
    }
    if (trim($cteemiendereco) == "") {
        $cteemiendereco = "0";
    }
    if (trim($cteeminumero) == "") {
        $cteeminumero = "0";
    }
    if (trim($cteemibairro) == "") {
        $cteemibairro = "0";
    }
    if (trim($cteemicomplemento) == "") {
        $cteemicomplemento = "0";
    }
    if (trim($cteemifone) == "") {
        $cteemifone = "0";
    }
    if (trim($cteemipais) == "") {
        $cteemipais = "0";
    }
    if (trim($cteemiuf) == "") {
        $cteemiuf = "0";
    }
    if (trim($cteemicidcodigo) == "") {
        $cteemicidcodigo = "0";
    }
    if (trim($cteemicidcodigoibge) == "") {
        $cteemicidcodigoibge = "0";
    }

    if (trim($cidemi) == "") {
        $cidemi = "0";
    }

    if (trim($tomcodigo) == "") {
        $tomcodigo = "0";
    }
    if (trim($tompessoa) == "") {
        $tompessoa = "0";
    }
    if (trim($ctetomrg) == "") {
        $ctetomrg = "0";
    }
    if (trim($ctetomnguerra) == "") {
        $ctetomnguerra = "0";
    }
    if (trim($ctetombairro) == "") {
        $ctetombairro = "0";
    }
    if (trim($ctetomcomplemento) == "") {
        $ctetomcomplemento = "0";
    }
    if (trim($ctetomcidcodigo) == "") {
        $ctetomcidcodigo = "0";
    }
    if (trim($ctetomcidcodigoibge) == "") {
        $ctetomcidcodigoibge = "0";
    }
    if (trim($ctetomuf) == "") {
        $ctetomuf = "0";
    }
    if (trim($ctetompessoa) == "") {
        $ctetompessoa = "0";
    }
    if (trim($ctetomendereco) == "") {
        $ctetomendereco = "0";
    }

    if (trim($remcodigo) == "") {
        $remcodigo = "0";
    }
    if (trim($cteremrg) == "") {
        $cteremrg = "0";
    }
    if (trim($cteremnguerra) == "") {
        $cteremnguerra = "0";
    }
    if (trim($cteremcomplemento) == "") {
        $cteremcomplemento = "0";
    }
    if (trim($cteremuf) == "") {
        $cteremuf = "0";
    }
    if (trim($cteremcidcodigo) == "") {
        $cteremcidcodigo = "0";
    }
    if (trim($cteremcidcodigoibge) == "") {
        $cteremcidcodigoibge = "0";
    }


    if (trim($expcodigo) == "") {
        $expcodigo = "0";
    }
    if (trim($cteexprg) == "") {
        $cteexprg = "0";
    }
    if (trim($cteexpnguerra) == "") {
        $cteexpnguerra = "0";
    }
    if (trim($cteexpcomplemento) == "") {
        $cteexpcomplemento = "0";
    }
    if (trim($cteexpuf) == "") {
        $cteexpuf = "0";
    }
    if (trim($cteexpcidcodigo) == "") {
        $cteexpcidcodigo = "0";
    }
    if (trim($cteexpcidcodigoibge) == "") {
        $cteexpcidcodigoibge = "0";
    }


    if (trim($reccodigo) == "") {
        $reccodigo = "0";
    }
    if (trim($cterecrg) == "") {
        $cterecrg = "0";
    }
    if (trim($cterecnguerra) == "") {
        $cterecnguerra = "0";
    }
    if (trim($ctereccomplemento) == "") {
        $ctereccomplemento = "0";
    }
    if (trim($cterecuf) == "") {
        $cterecuf = "0";
    }
    if (trim($ctereccidcodigo) == "") {
        $ctereccidcodigo = "0";
    }
    if (trim($ctereccidcodigoibge) == "") {
        $ctereccidcodigoibge = "0";
    }


    if (trim($descodigo) == "") {
        $descodigo = "0";
    }
    if (trim($ctedesrg) == "") {
        $ctedesrg = "0";
    }
    if (trim($ctedesnguerra) == "") {
        $ctedesnguerra = "0";
    }
    if (trim($ctedescomplemento) == "") {
        $ctedescomplemento = "0";
    }
    if (trim($ctedesuf) == "") {
        $ctedesuf = "0";
    }
    if (trim($ctedescidcodigo) == "") {
        $ctedescidcodigo = "0";
    }
    if (trim($ctedescidcodigoibge) == "") {
        $ctedescidcodigoibge = "0";
    }

    if (trim($cteservicos) == "") {
        $cteservicos = "0";
    }
    if (trim($ctereceber) == "") {
        $ctereceber = "0";
    }
    if (trim($ctetributos) == "") {
        $ctetributos = "0";
    }
    if (trim($sitcodigo) == "") {
        $sitcodigo = "0";
    }
    if (trim($cteperreducao) == "") {
        $cteperreducao = "0";
    }
    if (trim($ctebasecalculo) == "") {
        $ctebasecalculo = "0";
    }
    if (trim($ctepericms) == "") {
        $ctepericms = "0";
    }
    if (trim($ctevalicms) == "") {
        $ctevalicms = "0";
    }
    if (trim($ctecredito) == "") {
        $ctecredito = "0";
    }
    if (trim($ctepreencheicms) == "") {
        $ctepreencheicms = "0";
    }
    if (trim($ctebaseicms) == "") {
        $ctebaseicms = "0";
    }
    if (trim($cteperinterna) == "") {
        $cteperinterna = "0";
    }
    if (trim($cteperinter) == "") {
        $cteperinter = "0";
    }
    if (trim($cteperpartilha) == "") {
        $cteperpartilha = "0";
    }
    if (trim($ctevalicmsini) == "") {
        $ctevalicmsini = "0";
    }
    if (trim($ctevalicmsfim) == "") {
        $ctevalicmsfim = "0";
    }
    if (trim($cteperpobreza) == "") {
        $cteperpobreza = "0";
    }
    if (trim($ctevalpobreza) == "") {
        $ctevalpobreza = "0";
    }
    if (trim($cteadcfisco) == "") {
        $cteadcfisco = "0";
    }


    if (trim($ctecargaval) == "") {
        $ctecargaval = "0";
    }
    if (trim($ctepropredominante) == "") {
        $ctepropredominante = "0";
    }
    if (trim($cteoutcaracteristica) == "") {
        $cteoutcaracteristica = "0";
    }
    if (trim($ctecobrancanum) == "") {
        $ctecobrancanum = "0";
    }
    if (trim($ctecobrancaval) == "") {
        $ctecobrancaval = "0";
    }
    if (trim($ctecobrancades) == "") {
        $ctecobrancades = "0";
    }
    if (trim($ctecobrancaliq) == "") {
        $ctecobrancaliq = "0";
    }
    if (trim($cterntrc) == "") {
        $cterntrc = "0";
    }
    if (trim($cteentrega) == "") {
        $cteentrega = "0";
    }
    if (trim($cteindlocacao) == "") {
        $cteindlocacao = "0";
    }
    if (trim($cteciot) == "") {
        $cteciot = "0";
    }
    if (trim($cteobsgeral) == "") {
        $cteobsgeral = "0";
    }

    if (trim($ctesubstipo) == "") {
        $ctesubstipo = "0";
    }
    if (trim($ctesubschave) == "") {
        $ctesubschave = "0";
    }

    if (trim($sefazchave) == "") {
        $sefazchave = "0";
    }
    $sefazemissao = (trim($sefazemissao) == "" ? "0" : date('d/m/Y H:i', strtotime($sefazemissao)) );
    $sefazrecebto = (trim($sefazrecebto) == "" ? "0" : date('d/m/Y H:i', strtotime($sefazrecebto)) );
    if (trim($sefazstatus) == "") {
        $sefazstatus = "0";
    }
    if (trim($sefazprotocolo) == "") {
        $sefazprotocolo = "0";
    }
    if (trim($sefazcancchave) == "") {
        $sefazcancchave = "0";
    }
    $sefazcancemissao = (trim($sefazcancemissao) == "" ? "0" : date('d/m/Y H:i', strtotime($sefazcancemissao)) );
    $sefazcancrecebto = (trim($sefazcancrecebto) == "" ? "0" : date('d/m/Y H:i', strtotime($sefazcancrecebto)) );
    if (trim($sefazcancstatus) == "") {
        $sefazcancstatus = "0";
    }
    if (trim($sefazcancprotocolo) == "") {
        $sefazcancprotocolo = "0";
    }

    $inutdata = (trim($inutdata) == "" ? "0" : date('d/m/Y H:i', strtotime($inutdata)) );
    if (trim($inutmotivo) == "") {
        $inutmotivo = "0";
    }


    $xml = "<dados>
	<registro>
		<item>" . $ctenumero . "</item>
		<item>" . $ctemodelo . "</item>
		<item>" . $cteserie . "</item>
		<item>" . $ctenum . "</item>
		<item>" . $cteemissao . "</item>
		<item>" . $ctehorario . "</item>
		
		<item>" . $tmonome . "</item>
		<item>" . $sernome . "</item>
		<item>" . $ctechaveref . "</item>		
		<item>" . $tomnome . "</item>
		<item>" . $tfonome . "</item>
		<item>" . $ctecfop . "</item>
		<item>" . $ctenatureza . "</item>
		<item>" . $tctnome . "</item>
		<item>" . $cidinicio . "</item>
		<item>" . $cteufinicio . "</item>
		<item>" . $cidfinal . "</item>
		<item>" . $cteuffinal . "</item>

		<item>" . $cteremrazao . "</item>
		<item>" . $cteremendereco . "</item>
		<item>" . $cterembairro . "</item>
		<item>" . $cteremnumero . "</item>
		<item>" . $cidrem . "</item>
		<item>" . $cteremfone . "</item> 
		<item>" . $cterempais . "</item> 
		<item>" . $cteremuf . "</item> 
		
		<item>" . $cterempessoa . "</item> 
		<item>" . $cteremcep . "</item> 
		<item>" . $cteremcnpj . "</item> 
		<item>" . $cteremie . "</item> 
		<item>" . $cteremcpf . "</item> 

		
		<item>" . $ctedesrazao . "</item> 
		<item>" . $ctedesendereco . "</item> 
		<item>" . $ctedesbairro . "</item>
		<item>" . $ctedesnumero . "</item>
		<item>" . $ciddes . "</item>
		<item>" . $ctedesfone . "</item> 
		<item>" . $ctedespais . "</item> 
		<item>" . $ctedesuf . "</item> 
		
		<item>" . $ctedespessoa . "</item>
		<item>" . $ctedescep . "</item> 
		<item>" . $ctedescnpj . "</item> 
		<item>" . $ctedesie . "</item> 
		<item>" . $ctedescpf . "</item> 

		<item>" . $cteexprazao . "</item> 
		<item>" . $cteexpendereco . "</item> 
		<item>" . $cteexpbairro . "</item> 
		<item>" . $cteexpnumero . "</item> 
		<item>" . $cidexp . "</item> 
		<item>" . $cteexpfone . "</item> 
		<item>" . $cteexppais . "</item> 
		<item>" . $cteexpuf . "</item> 
		
		<item>" . $cteexppessoa . "</item> 
		<item>" . $cteexpcep . "</item> 
		<item>" . $cteexpcnpj . "</item> 
		<item>" . $cteexpie . "</item> 
		<item>" . $cteexpcpf . "</item> 
		
		<item>" . $cterecrazao . "</item> 
		<item>" . $cterecendereco . "</item> 
		<item>" . $cterecbairro . "</item> 
		<item>" . $cterecnumero . "</item> 
		<item>" . $cidrec . "</item> 
		<item>" . $cterecfone . "</item> 
		<item>" . $cterecpais . "</item> 
		<item>" . $cterecuf . "</item> 
		
		<item>" . $cterecpessoa . "</item> 
		<item>" . $ctereccep . "</item> 
		<item>" . $ctereccnpj . "</item> 
		<item>" . $cterecie . "</item>
		<item>" . $ctereccpf . "</item>
		
		<item>" . $ctetomrazao . "</item> 
		<item>" . $ctetomendereco . "</item> 
		<item>" . $ctetombairro . "</item> 
		<item>" . $ctetomnumero . "</item> 
		<item>" . $cidtom . "</item> 
		<item>" . $ctetomfone . "</item> 
		<item>" . $ctetompais . "</item> 
		<item>" . $ctetomuf . "</item> 
		<item>" . $ctetompessoa . "</item> 
		<item>" . $ctetomcep . "</item> 
		<item>" . $ctetomcnpj . "</item> 
		<item>" . $ctetomie . "</item> 
		<item>" . $ctetomcpf . "</item> 
		
		<item>" . $ctepropredominante . "</item> 
		<item>" . $cteoutcaracteristica . "</item> 
		<item>" . $ctecargaval . "</item> 
		<item>" . $cteservicos . "</item> 
		<item>" . $ctereceber . "</item> 
		<item>" . $sitnome . "</item> 
		
		<item>" . $cteperreducao . "</item> 
		<item>" . $ctebasecalculo . "</item> 
		<item>" . $ctepericms . "</item> 
		<item>" . $ctevalicms . "</item> 
		
		<item>" . $cteobsgeral . "</item> 
		
		<item>" . $cterntrc . "</item> 
		<item>" . $cteentrega . "</item> 
		<item>" . $cteciot . "</item> 
		<item>" . $topnome . "</item> 
		
		
		<item>" . $tmocodigo . "</item> 
		<item>" . $sercodigo . "</item> 
		<item>" . $tctcodigo . "</item> 
		<item>" . $tpgcodigo . "</item> 
		<item>" . $tfocodigo . "</item> 
		
		
		<item>" . $cteufemissao . "</item> 
		<item>" . $cteufinicio . "</item> 
		<item>" . $cteuffinal . "</item> 
		<item>" . $ctecidemissao . "</item> 
		<item>" . $ctecidinicio . "</item> 
		<item>" . $ctecidfinal . "</item> 
			
		<item>" . $cteemipessoa . "</item> 
		<item>" . $cteemicnpj . "</item> 
		<item>" . $cteemiie . "</item> 
		<item>" . $cteemicpf . "</item> 
		<item>" . $cteemirg . "</item> 
		<item>" . $cteeminguerra . "</item> 
		<item>" . $cteemirazao . "</item> 
		<item>" . $cteemicep . "</item> 
		<item>" . $cteemiendereco . "</item> 
		<item>" . $cteeminumero . "</item> 
		<item>" . $cteemibairro . "</item> 
		<item>" . $cteemicomplemento . "</item> 
		<item>" . $cteemifone . "</item> 
		<item>" . $cteemipais . "</item> 
		<item>" . $cteemiuf . "</item> 
		<item>" . $cteemicidcodigo . "</item> 
		<item>" . $cteemicidcodigoibge . "</item> 
		<item>" . $cidemi . "</item> 
		
		<item>" . $tomcodigo . "</item> 
		<item>" . $tompessoa . "</item> 
		<item>" . $ctetomrg . "</item> 
		<item>" . $ctetomnguerra . "</item> 
		<item>" . $ctetombairro . "</item> 
		<item>" . $ctetomcomplemento . "</item> 
		<item>" . $ctetomcidcodigo . "</item> 
		<item>" . $ctetomcidcodigoibge . "</item> 
		
		
		<item>" . $remcodigo . "</item> 
		<item>" . $cteremrg . "</item> 
		<item>" . $cteremnguerra . "</item> 
		<item>" . $cteremcomplemento . "</item> 
		<item>" . $cteremcidcodigo . "</item> 
		<item>" . $cteremcidcodigoibge . "</item> 
		
		
		<item>" . $expcodigo . "</item> 
		<item>" . $cteexprg . "</item> 
		<item>" . $cteexpnguerra . "</item> 
		<item>" . $cteexpcomplemento . "</item> 
		<item>" . $cteexpcidcodigo . "</item> 
		<item>" . $cteexpcidcodigoibge . "</item> 
		


		<item>" . $reccodigo . "</item> 
		<item>" . $cterecrg . "</item> 
		<item>" . $cterecnguerra . "</item> 
		<item>" . $ctereccomplemento . "</item> 
		<item>" . $ctereccidcodigo . "</item> 
		<item>" . $ctereccidcodigoibge . "</item> 		


		<item>" . $descodigo . "</item> 
		<item>" . $ctedesrg . "</item> 
		<item>" . $ctedesnguerra . "</item> 
		<item>" . $ctedescomplemento . "</item> 
		<item>" . $ctedescidcodigo . "</item> 
		<item>" . $ctedescidcodigoibge . "</item> 			
		
		
		<item>" . $cteservicos . "</item>
		<item>" . $ctereceber . "</item>
		<item>" . $ctetributos . "</item>
		<item>" . $sitcodigo . "</item>
		<item>" . $cteperreducao . "</item>
		<item>" . $ctebasecalculo . "</item>
		<item>" . $ctepericms . "</item>
		<item>" . $ctevalicms . "</item>
		<item>" . $ctecredito . "</item>
		<item>" . $ctepreencheicms . "</item>
		<item>" . $ctebaseicms . "</item>
		<item>" . $cteperinterna . "</item>
		<item>" . $cteperinter . "</item>
		<item>" . $cteperpartilha . "</item>
		<item>" . $ctevalicmsini . "</item>
		<item>" . $ctevalicmsfim . "</item>
		<item>" . $cteperpobreza . "</item>
		<item>" . $ctevalpobreza . "</item>
		<item>" . $cteadcfisco . "</item>
		
			
		<item>" . $ctecargaval . "</item>
		<item>" . $ctepropredominante . "</item>
		<item>" . $cteoutcaracteristica . "</item>
		<item>" . $ctecobrancanum . "</item>
		<item>" . $ctecobrancaval . "</item>
		<item>" . $ctecobrancades . "</item>
		<item>" . $ctecobrancaliq . "</item>
		<item>" . $cterntrc . "</item>
		<item>" . $cteentrega . "</item>
		<item>" . $cteindlocacao . "</item>
		<item>" . $cteciot . "</item>
		<item>" . $cteobsgeral . "</item>
		<item>" . $ctechavefin . "</item>
		<item>" . $ctedatatomador . "</item>	
				
		<item>" . $ctesubstipo . "</item>
		<item>" . $ctesubschave . "</item>
		<item>" . $ctedessuframa . "</item>
		<item>" . $ctechave . "</item>
		
		<item>" . $sefazchave . "</item>
		<item>" . $sefazemissao . "</item>
		<item>" . $sefazrecebto . "</item>
		<item>" . $sefazstatus . "</item>
		<item>" . $sefazprotocolo . "</item>
		<item>" . $sefazcancchave . "</item>
		<item>" . $sefazcancemissao . "</item>
		<item>" . $sefazcancrecebto . "</item>
		<item>" . $sefazcancstatus . "</item>
		<item>" . $sefazcancprotocolo . "</item>
		
		<item>" . $inutmotivo . "</item>
		<item>" . $inutdata . "</item>
		 
	</registro>
	</dados>";
    echo $xml;
    pg_close($conn);
    exit();
}

function delimitador($variavel, $tamanho, $alinhamento, $preenchimento) {
    if ($tamanho < 10 && $alinhamento == 'R' && $preenchimento == '0')
        $strtam = "%0" . $tamanho . "s";
    else if ($tamanho < 10 && $alinhamento == 'L' && $preenchimento == '0')
        $strtam = "%-0" . $tamanho . "s";
    else if ($tamanho < 10 && $alinhamento == 'R' && $preenchimento == ' ')
        $strtam = "%" . $tamanho . "s";
    else if ($tamanho < 10 && $alinhamento == 'L' && $preenchimento == ' ')
        $strtam = "%-" . $tamanho . "s";

    if ($tamanho >= 10 && $alinhamento == 'R' && $preenchimento == '0')
        $strtam = "%0" . $tamanho . "s";
    else if ($tamanho >= 10 && $alinhamento == 'L' && $preenchimento == '0')
        $strtam = "%-0" . $tamanho . "s";
    else if ($tamanho >= 10 && $alinhamento == 'R' && $preenchimento == ' ')
        $strtam = "%" . $tamanho . "s";
    else if ($tamanho >= 10 && $alinhamento == 'L' && $preenchimento == ' ')
        $strtam = "%-" . $tamanho . "s";

    $var = substr(sprintf($strtam, $variavel), 0, $tamanho);
    return $var;
}

?>