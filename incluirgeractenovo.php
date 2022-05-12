<?php

require_once("include/conexao.inc.php");
require_once("include/banco.php");

//------------- variáveis -----------------// 
$flag = $_REQUEST["flag"];

//---------- instancia o objeto -----------//
$cadastro = new banco($conn, $db);

//---- Cabeçalho para a geração do xml ----//
header("Content-type: application/xml");
$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";

//--------- Incluir dados no orçamento ----------//
if ($flag == "InserirOrcamento") {

    $tabela = $_REQUEST['tabela'];

    if ($tabela == "cte") {


        $pedido = $_REQUEST['pedido'];
        $numero_correto = $_REQUEST['numero_correto'];
        $modelo = $_REQUEST['modelo'];
        $serie = $_REQUEST['serie'];
        $numero = $_REQUEST['numero'];
        $orcemissao = $_REQUEST['orcemissao'];
        $orchora = $_REQUEST['orchora'];
        $cfop = $_REQUEST['cfop'];
        $natureza = $_REQUEST['natureza'];
        $modal = $_REQUEST['modal'];
        $servico = $_REQUEST['servico'];
        $finalidade = $_REQUEST['finalidade'];
        $pagto = $_REQUEST['pagto'];
        $forma = $_REQUEST['forma'];
        $chave = $_REQUEST['chave'];
        $estado = $_REQUEST['estado'];
        $estadoini = $_REQUEST['estadoini'];
        $estadofim = $_REQUEST['estadofim'];
        $cidade = $_REQUEST['cidade'];
        $cidadeini = $_REQUEST['cidadeini'];
        $cidadefim = $_REQUEST['cidadefim'];
        $chavefin = $_REQUEST['chavefin'];
        $datatomador = $_REQUEST['datatomador'];

        $orcemissao = substr($orcemissao, 6, 4) . '-' . substr($orcemissao, 3, 2) . '-' . substr($orcemissao, 0, 2);
        $emissao = substr($orcemissao, 0, 10) . ' ' . $orchora . ":00-03";
        $emissao = "'$emissao'";

        if ($datatomador != '') {
            $datatomador = substr($datatomador, 6, 4) . '-' . substr($datatomador, 3, 2) . '-' . substr($datatomador, 0, 2) . ' 00:00:00-03';
            $datatomador = "'$datatomador'";
        } else {
            $datatomador = "NULL";
        }

        if ($numero_correto == 0 || $numero_correto == '') {

            //Faz a busca do nº MAX da devolucaon 
            $query_num_orcamento = $cadastro->seleciona("max(ctenumero) as total", "cte", "1=1");
            $array_num_orcamento = pg_fetch_object($query_num_orcamento);

            $orc_max = $array_num_orcamento->total + 1;


            //Faz a busca do nº MAX do ctenum
            $query_num_orcamento2 = $cadastro->seleciona("max(ctenum) as total2", "cte", "1=1");
            $array_num_orcamento2 = pg_fetch_object($query_num_orcamento2);

            if ($array_num_orcamento2->total2 == "")
                $array_num_orcamento2->total2 = 0;
            $array_num_orcamento2->total2++;

            $orc_numero = delimitador(trim($array_num_orcamento2->total2), '9', 'R', '0');

            //$orc_numero = delimitador($numero,'9','R','0');

            $query_orcamento = $cadastro->insere("cte", "(ctenumero,ctemodelo,cteserie,ctenum,cteemissao,ctehorario,ctecfop,ctenatureza,tmocodigo,sercodigo,tctcodigo,tpgcodigo,tfocodigo,ctechaveref,cteufemissao,cteufinicio,cteuffinal,ctecidemissao,ctecidinicio,ctecidfinal,ctechavefin,ctedatatomador)",
                    "($orc_max,'$modelo','$serie','$orc_numero',$emissao,'$orchora','$cfop','$natureza','$modal',$servico,$finalidade,$pagto,$forma,'$chave','$estado','$estadoini','$estadofim',$cidade,$cidadeini,$cidadefim,'$chavefin',$datatomador)");
        } else {

            $orc_max = $pedido;
            //$orc_numero = delimitador($orc_max,'9','R','0');
            $orc_numero = delimitador($numero, '9', 'R', '0');

            $cadastro->altera("cte", "ctemodelo='$modelo',cteserie='$serie',ctenum='$orc_numero',cteemissao=$emissao,
			ctehorario='$orchora',ctecfop='$cfop',ctenatureza='$natureza',tmocodigo='$modal',
			sercodigo='$servico',tctcodigo='$finalidade',tpgcodigo='$pagto',tfocodigo='$forma',
			ctechaveref='$chave',cteufemissao='$estado',cteufinicio='$estadoini',cteuffinal='$estadofim',ctecidemissao='$cidade',ctecidinicio='$cidadeini',ctecidfinal='$cidadefim',ctechavefin='$chavefin',ctedatatomador=$datatomador"
                    , "ctenumero=$pedido");
        }

        $xml .= "<dados>\n";
        $xml .= "<dado>\n";
        $xml .= "<pvnumero>" . $orc_max . "</pvnumero>\n";
        $xml .= "<ctenumero>" . $orc_numero . "</ctenumero>\n";
        $xml .= "</dado>\n";
        $xml .= "</dados>\n";

        echo $xml;
    } else if ($tabela == "ctecompleto") {


        $pedido = $_REQUEST['pedido'];
        $numero_correto = $_REQUEST['numero_correto'];
        $modelo = $_REQUEST['modelo'];
        $serie = $_REQUEST['serie'];
        $numero = $_REQUEST['numero'];
        $orcemissao = $_REQUEST['orcemissao'];
        $orchora = $_REQUEST['orchora'];
        $cfop = $_REQUEST['cfop'];
        $natureza = $_REQUEST['natureza'];
        $modal = $_REQUEST['modal'];
        $servico = $_REQUEST['servico'];
        $finalidade = $_REQUEST['finalidade'];
        $pagto = $_REQUEST['pagto'];
        $forma = $_REQUEST['forma'];
        $chave = $_REQUEST['chave'];
        $estado = $_REQUEST['estado'];
        $estadoini = $_REQUEST['estadoini'];
        $estadofim = $_REQUEST['estadofim'];
        $cidade = $_REQUEST['cidade'];
        $cidadeini = $_REQUEST['cidadeini'];
        $cidadefim = $_REQUEST['cidadefim'];

        $emipessoa = $_REQUEST['emipessoa'];
        $emicnpj = $_REQUEST['emicnpj'];
        $emiie = $_REQUEST['emiie'];
        $emicpf = $_REQUEST['emicpf'];
        $emirg = $_REQUEST['emirg'];
        $eminguerra = $_REQUEST['eminguerra'];
        $emirazao = $_REQUEST['emirazao'];
        $emicep = $_REQUEST['emicep'];
        $emiendereco = $_REQUEST['emiendereco'];
        $eminumero = $_REQUEST['eminumero'];
        if ($eminumero == '' || !is_numeric($eminumero)) {
            $eminumero = 0;
        }
        $emibairro = $_REQUEST['emibairro'];
        $emicomplemento = $_REQUEST['emicomplemento'];
        $emifone = $_REQUEST['emifone'];
        $emipais = $_REQUEST['emipais'];
        $emiuf = $_REQUEST['emiuf'];
        $emicidcodigo = $_REQUEST['emicidcodigo'];
        if ($emicidcodigo == '') {
            $emicidcodigo = 0;
        }
        $emicidcodigoibge = $_REQUEST['emicidcodigoibge'];

        $tomcodigo = $_REQUEST['tomcodigo'];
        $tompessoa = $_REQUEST['tompessoa'];
        $tomcnpj = $_REQUEST['tomcnpj'];
        $tomie = $_REQUEST['tomie'];
        $tomcpf = $_REQUEST['tomcpf'];
        $tomrg = $_REQUEST['tomrg'];
        $tomnguerra = $_REQUEST['tomnguerra'];
        $tomrazao = $_REQUEST['tomrazao'];
        $tomcep = $_REQUEST['tomcep'];
        $tomendereco = $_REQUEST['tomendereco'];
        $tomnumero = $_REQUEST['tomnumero'];
        if ($tomnumero == '' || !is_numeric($tomnumero)) {
            $tomnumero = 0;
        }
        $tombairro = $_REQUEST['tombairro'];
        $tomcomplemento = $_REQUEST['tomcomplemento'];
        $tomfone = $_REQUEST['tomfone'];
        $tompais = $_REQUEST['tompais'];
        $tomuf = $_REQUEST['tomuf'];
        $tomcidcodigo = $_REQUEST['tomcidcodigo'];
        if ($tomcidcodigo == '') {
            $tomcidcodigo = 0;
        }
        $tomcidcodigoibge = $_REQUEST['tomcidcodigoibge'];

        $remcodigo = $_REQUEST['remcodigo'];
        $rempessoa = $_REQUEST['rempessoa'];
        $remcnpj = $_REQUEST['remcnpj'];
        $remie = $_REQUEST['remie'];
        $remcpf = $_REQUEST['remcpf'];
        $remrg = $_REQUEST['remrg'];
        $remnguerra = $_REQUEST['remnguerra'];
        $remrazao = $_REQUEST['remrazao'];
        $remcep = $_REQUEST['remcep'];
        $remendereco = $_REQUEST['remendereco'];
        $remnumero = $_REQUEST['remnumero'];
        if ($remnumero == '' || !is_numeric($remnumero)) {
            $remnumero = 0;
        }
        $rembairro = $_REQUEST['rembairro'];
        $remcomplemento = $_REQUEST['remcomplemento'];
        $remfone = $_REQUEST['remfone'];
        $rempais = $_REQUEST['rempais'];
        $remuf = $_REQUEST['remuf'];
        $remcidcodigo = $_REQUEST['remcidcodigo'];
        if ($remcidcodigo == '') {
            $remcidcodigo = 0;
        }
        $remcidcodigoibge = $_REQUEST['remcidcodigoibge'];

        $expcodigo = $_REQUEST['expcodigo'];
        $exppessoa = $_REQUEST['exppessoa'];
        $expcnpj = $_REQUEST['expcnpj'];
        $expie = $_REQUEST['expie'];
        $expcpf = $_REQUEST['expcpf'];
        $exprg = $_REQUEST['exprg'];
        $expnguerra = $_REQUEST['expnguerra'];
        $exprazao = $_REQUEST['exprazao'];
        $expcep = $_REQUEST['expcep'];
        $expendereco = $_REQUEST['expendereco'];
        $expnumero = $_REQUEST['expnumero'];
        if ($expnumero == '' || !is_numeric($expnumero)) {
            $expnumero = 0;
        }
        $expbairro = $_REQUEST['expbairro'];
        $expcomplemento = $_REQUEST['expcomplemento'];
        $expfone = $_REQUEST['expfone'];
        $exppais = $_REQUEST['exppais'];
        $expuf = $_REQUEST['expuf'];
        $expcidcodigo = $_REQUEST['expcidcodigo'];
        if ($expcidcodigo == '') {
            $expcidcodigo = 0;
        }
        $expcidcodigoibge = $_REQUEST['expcidcodigoibge'];

        $reccodigo = $_REQUEST['reccodigo'];
        $recpessoa = $_REQUEST['recpessoa'];
        $reccnpj = $_REQUEST['reccnpj'];
        $recie = $_REQUEST['recie'];
        $reccpf = $_REQUEST['reccpf'];
        $recrg = $_REQUEST['recrg'];
        $recnguerra = $_REQUEST['recnguerra'];
        $recrazao = $_REQUEST['recrazao'];
        $reccep = $_REQUEST['reccep'];
        $recendereco = $_REQUEST['recendereco'];
        $recnumero = $_REQUEST['recnumero'];
        if ($recnumero == '' || !is_numeric($recnumero)) {
            $recnumero = 0;
        }
        $recbairro = $_REQUEST['recbairro'];
        $reccomplemento = $_REQUEST['reccomplemento'];
        $recfone = $_REQUEST['recfone'];
        $recpais = $_REQUEST['recpais'];
        $recuf = $_REQUEST['recuf'];
        $reccidcodigo = $_REQUEST['reccidcodigo'];
        if ($reccidcodigo == '') {
            $reccidcodigo = 0;
        }
        $reccidcodigoibge = $_REQUEST['reccidcodigoibge'];

        $descodigo = $_REQUEST['descodigo'];
        $despessoa = $_REQUEST['despessoa'];
        $descnpj = $_REQUEST['descnpj'];
        $desie = $_REQUEST['desie'];
        $descpf = $_REQUEST['descpf'];
        $desrg = $_REQUEST['desrg'];
        $desnguerra = $_REQUEST['desnguerra'];
        $desrazao = $_REQUEST['desrazao'];
        $descep = $_REQUEST['descep'];
        $desendereco = $_REQUEST['desendereco'];
        $desnumero = $_REQUEST['desnumero'];
        $dessuframa = $_REQUEST['dessuframa'];
        if ($desnumero == '' || !is_numeric($desnumero)) {
            $desnumero = 0;
        }
        $desbairro = $_REQUEST['desbairro'];
        $descomplemento = $_REQUEST['descomplemento'];
        $desfone = $_REQUEST['desfone'];
        $despais = $_REQUEST['despais'];
        $desuf = $_REQUEST['desuf'];
        $descidcodigo = $_REQUEST['descidcodigo'];
        if ($descidcodigo == '') {
            $descidcodigo = 0;
        }
        $descidcodigoibge = $_REQUEST['descidcodigoibge'];

        $cteservicos = $_REQUEST['cteservicos'];
        if ($cteservicos == '') {
            $cteservicos = 0;
        }
        $ctereceber = $_REQUEST['ctereceber'];
        if ($ctereceber == '') {
            $ctereceber = 0;
        }
        $ctetributos = $_REQUEST['ctetributos'];
        if ($ctetributos == '') {
            $ctetributos = 0;
        }
        $sitcodigo = $_REQUEST['sitcodigo'];
        if ($sitcodigo == '') {
            $sitcodigo = 0;
        }
        $cteperreducao = $_REQUEST['cteperreducao'];
        if ($cteperreducao == '') {
            $cteperreducao = 0;
        }
        $ctebasecalculo = $_REQUEST['ctebasecalculo'];
        if ($ctebasecalculo == '') {
            $ctebasecalculo = 0;
        }
        $ctepericms = $_REQUEST['ctepericms'];
        if ($ctepericms == '') {
            $ctepericms = 0;
        }
        $ctevalicms = $_REQUEST['ctevalicms'];
        if ($ctevalicms == '') {
            $ctevalicms = 0;
        }
        $ctecredito = $_REQUEST['ctecredito'];
        if ($ctecredito == '') {
            $ctecredito = 0;
        }
        $ctepreencheicms = $_REQUEST['ctepreencheicms'];
        if ($ctepreencheicms == '') {
            $ctepreencheicms = 0;
        }
        $ctebaseicms = $_REQUEST['ctebaseicms'];
        if ($ctebaseicms == '') {
            $ctebaseicms = 0;
        }
        $cteperinterna = $_REQUEST['cteperinterna'];
        if ($cteperinterna == '') {
            $cteperinterna = 0;
        }
        $cteperinter = $_REQUEST['cteperinter'];
        if ($cteperinter == '') {
            $cteperinter = 0;
        }
        $cteperpartilha = $_REQUEST['cteperpartilha'];
        if ($cteperpartilha == '') {
            $cteperpartilha = 0;
        }
        $ctevalicmsini = $_REQUEST['ctevalicmsini'];
        if ($ctevalicmsini == '') {
            $ctevalicmsini = 0;
        }
        $ctevalicmsfim = $_REQUEST['ctevalicmsfim'];
        if ($ctevalicmsfim == '') {
            $ctevalicmsfim = 0;
        }
        $cteperpobreza = $_REQUEST['cteperpobreza'];
        if ($cteperpobreza == '') {
            $cteperpobreza = 0;
        }
        $ctevalpobreza = $_REQUEST['ctevalpobreza'];
        if ($ctevalpobreza == '') {
            $ctevalpobreza = 0;
        }
        $cteadcfisco = $_REQUEST['cteadcfisco'];

        $ctecargaval = $_REQUEST['ctecargaval'];
        if ($ctecargaval == '') {
            $ctecargaval = 0;
        }
        $ctepropredominante = $_REQUEST['ctepropredominante'];
        $cteoutcaracteristica = $_REQUEST['cteoutcaracteristica'];
        $ctecobrancanum = $_REQUEST['ctecobrancanum'];
        $ctecobrancaval = $_REQUEST['ctecobrancaval'];
        if ($ctecobrancaval == '') {
            $ctecobrancaval = 0;
        }
        $ctecobrancades = $_REQUEST['ctecobrancades'];
        if ($ctecobrancades == '') {
            $ctecobrancades = 0;
        }
        $ctecobrancaliq = $_REQUEST['ctecobrancaliq'];
        if ($ctecobrancaliq == '') {
            $ctecobrancaliq = 0;
        }

        $cterntrc = $_REQUEST['cterntrc'];
        $cteentrega = $_REQUEST['cteentrega'];
        if ($cteentrega == '') {
            $cteentrega = "NULL";
        } else {
            $cteentrega = substr($cteentrega, 6, 4) . '-' . substr($cteentrega, 3, 2) . '-' . substr($cteentrega, 0, 2);
            $cteentrega = "'$cteentrega'";
        }
        $cteindlocacao = $_REQUEST['cteindlocacao'];
        if ($cteindlocacao == '') {
            $cteindlocacao = 0;
        }
        $cteciot = $_REQUEST['cteciot'];

        $cteobsgeral = $_REQUEST['cteobsgeral'];

        $usucodigo = $_REQUEST['usucodigo'];

        $chavefin = $_REQUEST['chavefin'];
        $datatomador = $_REQUEST['datatomador'];

        if ($datatomador != '') {
            $datatomador = substr($datatomador, 6, 4) . '-' . substr($datatomador, 3, 2) . '-' . substr($datatomador, 0, 2) . ' 00:00:00-03';
            $datatomador = "'$datatomador'";
        } else {
            $datatomador = "NULL";
        }

        $orcemissao = substr($orcemissao, 6, 4) . '-' . substr($orcemissao, 3, 2) . '-' . substr($orcemissao, 0, 2);
        $emissao = substr($orcemissao, 0, 10) . ' ' . $orchora . ":00-03";
        $emissao = "'$emissao'";

        $ctesubstipo = $_REQUEST['ctesubstipo'];
        $ctesubschave = $_REQUEST['ctesubschave'];

        $orc_max = $pedido;
        $orc_numero = delimitador($numero, '9', 'R', '0');

        $cadastro->altera("cte", "ctemodelo='$modelo',cteserie='$serie',ctenum='$orc_numero',cteemissao=$emissao,
		ctehorario='$orchora',ctecfop='$cfop',ctenatureza='$natureza',tmocodigo='$modal',
		sercodigo='$servico',tctcodigo='$finalidade',tpgcodigo='$pagto',tfocodigo='$forma',
		ctechaveref='$chave',cteufemissao='$estado',cteufinicio='$estadoini',cteuffinal='$estadofim',ctecidemissao='$cidade',ctecidinicio='$cidadeini',ctecidfinal='$cidadefim',		
		cteemipessoa='$emipessoa',
		cteemicnpj='$emicnpj',
		cteemiie='$emiie',
		cteemicpf='$emicpf',
		cteemirg='$emirg',
		cteeminguerra='$eminguerra',
		cteemirazao='$emirazao',
		cteemicep='$emicep',
		cteemiendereco='$emiendereco',
		cteeminumero='$eminumero',
		cteemibairro='$emibairro',
		cteemicomplemento='$emicomplemento',
		cteemifone='$emifone',
		cteemipais='$emipais',
		cteemiuf='$emiuf',
		cteemicidcodigo='$emicidcodigo',
		cteemicidcodigoibge='$emicidcodigoibge',
		tomcodigo='$tomcodigo',
		ctetompessoa='$tompessoa',
		ctetomcnpj='$tomcnpj',
		ctetomie='$tomie',
		ctetomcpf='$tomcpf',
		ctetomrg='$tomrg',
		ctetomnguerra='$tomnguerra',
		ctetomrazao='$tomrazao',
		ctetomcep='$tomcep',
		ctetomendereco='$tomendereco',
		ctetomnumero='$tomnumero',
		ctetombairro='$tombairro',
		ctetomcomplemento='$tomcomplemento',
		ctetomfone='$tomfone',
		ctetompais='$tompais',
		ctetomuf='$tomuf',
		ctetomcidcodigo='$tomcidcodigo',
		ctetomcidcodigoibge='$tomcidcodigoibge',
		remcodigo='$remcodigo',
		cterempessoa='$rempessoa',
		cteremcnpj='$remcnpj',
		cteremie='$remie',
		cteremcpf='$remcpf',
		cteremrg='$remrg',
		cteremnguerra='$remnguerra',
		cteremrazao='$remrazao',
		cteremcep='$remcep',
		cteremendereco='$remendereco',
		cteremnumero='$remnumero',
		cterembairro='$rembairro',
		cteremcomplemento='$remcomplemento',
		cteremfone='$remfone',
		cterempais='$rempais',
		cteremuf='$remuf',
		cteremcidcodigo='$remcidcodigo',
		cteremcidcodigoibge='$remcidcodigoibge',		
		expcodigo='$expcodigo',
		cteexppessoa='$exppessoa',
		cteexpcnpj='$expcnpj',
		cteexpie='$expie',
		cteexpcpf='$expcpf',
		cteexprg='$exprg',
		cteexpnguerra='$expnguerra',
		cteexprazao='$exprazao',
		cteexpcep='$expcep',
		cteexpendereco='$expendereco',
		cteexpnumero='$expnumero',
		cteexpbairro='$expbairro',
		cteexpcomplemento='$expcomplemento',
		cteexpfone='$expfone',
		cteexppais='$exppais',
		cteexpuf='$expuf',
		cteexpcidcodigo='$expcidcodigo',
		cteexpcidcodigoibge='$expcidcodigoibge',		
		reccodigo='$reccodigo',
		cterecpessoa='$recpessoa',
		ctereccnpj='$reccnpj',
		cterecie='$recie',
		ctereccpf='$reccpf',
		cterecrg='$recrg',
		cterecnguerra='$recnguerra',
		cterecrazao='$recrazao',
		ctereccep='$reccep',
		cterecendereco='$recendereco',
		cterecnumero='$recnumero',
		cterecbairro='$recbairro',
		ctereccomplemento='$reccomplemento',
		cterecfone='$recfone',
		cterecpais='$recpais',
		cterecuf='$recuf',
		ctereccidcodigo='$reccidcodigo',
		ctereccidcodigoibge='$reccidcodigoibge',		
		descodigo='$descodigo',
		ctedespessoa='$despessoa',
		ctedescnpj='$descnpj',
		ctedesie='$desie',
		ctedescpf='$descpf',
		ctedesrg='$desrg',
		ctedesnguerra='$desnguerra',
		ctedesrazao='$desrazao',
		ctedescep='$descep',
		ctedesendereco='$desendereco',
		ctedesnumero='$desnumero',
		ctedessuframa='$dessuframa',
		ctedesbairro='$desbairro',
		ctedescomplemento='$descomplemento',
		ctedesfone='$desfone',
		ctedespais='$despais',
		ctedesuf='$desuf',
		ctedescidcodigo='$descidcodigo',
		ctedescidcodigoibge='$descidcodigoibge',		
		cteservicos='$cteservicos',
		ctereceber='$ctereceber',
		ctetributos='$ctetributos',
		sitcodigo='$sitcodigo',
		cteperreducao='$cteperreducao',
		ctebasecalculo='$ctebasecalculo',
		ctepericms='$ctepericms',
		ctevalicms='$ctevalicms',
		ctecredito='$ctecredito',
		ctepreencheicms='$ctepreencheicms',
		ctebaseicms='$ctebaseicms',
		cteperinterna='$cteperinterna',
		cteperinter='$cteperinter',
		cteperpartilha='$cteperpartilha',
		ctevalicmsini='$ctevalicmsini',
		ctevalicmsfim='$ctevalicmsfim',
		cteperpobreza='$cteperpobreza',
		ctevalpobreza='$ctevalpobreza',
		cteadcfisco='$cteadcfisco',
		ctecargaval='$ctecargaval',
		ctepropredominante='$ctepropredominante',
		cteoutcaracteristica='$cteoutcaracteristica',
		ctecobrancanum='$ctecobrancanum',
		ctecobrancaval='$ctecobrancaval',
		ctecobrancades='$ctecobrancades',
		ctecobrancaliq='$ctecobrancaliq',
		cterntrc='$cterntrc',
		cteentrega=$cteentrega,
		cteindlocacao='$cteindlocacao',
		cteciot='$cteciot',
		cteobsgeral='$cteobsgeral',
		ctechavefin='$chavefin',
		ctedatatomador=$datatomador,

		ctesubstipo=$ctesubstipo,
		ctesubschave='$ctesubschave'
		"
                , "ctenumero=$pedido");

        //Tabela de Valores do Servico
        $cadastro->apaga("ctevalorservico", "ctenumero=$pedido");
        $sqlaux = "select a.valcodigo,a.valnome,a.valvalor from valorservico a 
			where a.usucodigo=$usucodigo order by a.valcodigo";
        $sqlaux = pg_query($sqlaux);
        $rowaux = pg_num_rows($sqlaux);
        if ($rowaux) {
            for ($iaux = 0; $iaux < $rowaux; $iaux++) {
                $aux_codigo = pg_fetch_result($sqlaux, $iaux, "valcodigo");
                $aux_nome = pg_fetch_result($sqlaux, $iaux, "valnome");
                $aux_valor = pg_fetch_result($sqlaux, $iaux, "valvalor");
                $cadastro->insere("ctevalorservico", "(ctenumero,ctevalnome,ctevalvalor)", "($pedido,'$aux_nome','$aux_valor')");
            }
        }

        //Tabela de Informacoes de Carga
        $cadastro->apaga("cteinfocarga", "ctenumero=$pedido");
        $sqlaux = "select a.infcodigo,a.medcodigo,a.infnome,a.infvalor from infocarga a 
			where a.usucodigo=$usucodigo order by a.infcodigo";
        $sqlaux = pg_query($sqlaux);
        $rowaux = pg_num_rows($sqlaux);
        if ($rowaux) {
            for ($iaux = 0; $iaux < $rowaux; $iaux++) {
                $aux_codigo = pg_fetch_result($sqlaux, $iaux, "medcodigo");
                $aux_nome = pg_fetch_result($sqlaux, $iaux, "infnome");
                $aux_valor = pg_fetch_result($sqlaux, $iaux, "infvalor");
                $cadastro->insere("cteinfocarga", "(ctenumero,cteinfnome,cteinfvalor,medcodigo)", "($pedido,'$aux_nome','$aux_valor','$aux_codigo')");
            }
        }

        //Tabela de Informacoes do Seguro
        $cadastro->apaga("cteinfoseguro", "ctenumero=$pedido");
        $sqlaux = "select a.segcodigo,a.rescodigo,a.segnome,a.segvalor,a.segapolice,a.segaverbacao from infoseguro a 
			where a.usucodigo=$usucodigo order by a.segcodigo";
        $sqlaux = pg_query($sqlaux);
        $rowaux = pg_num_rows($sqlaux);
        if ($rowaux) {
            for ($iaux = 0; $iaux < $rowaux; $iaux++) {
                $aux_codigo = pg_fetch_result($sqlaux, $iaux, "rescodigo");
                $aux_nome = pg_fetch_result($sqlaux, $iaux, "segnome");
                $aux_valor = pg_fetch_result($sqlaux, $iaux, "segvalor");
                $aux_apolice = pg_fetch_result($sqlaux, $iaux, "segapolice");
                $aux_averbacao = pg_fetch_result($sqlaux, $iaux, "segaverbacao");
                $cadastro->insere("cteinfoseguro", "(ctenumero,ctesegnome,ctesegvalor,rescodigo,ctesegapolice,ctesegaverbacao)", "($pedido,'$aux_nome','$aux_valor','$aux_codigo','$aux_apolice','$aux_averbacao')");
            }
        }

        //Tabela de Documentos
        $cadastro->apaga("ctenfechave", "ctenumero=$pedido");
        $sqlaux = "select a.nfecodigo,a.nfenome,a.nfepin,a.cnpj from nfechave a 
			where a.usucodigo=$usucodigo order by a.nfecodigo";
        $sqlaux = pg_query($sqlaux);
        $rowaux = pg_num_rows($sqlaux);
        if ($rowaux) {
            for ($iaux = 0; $iaux < $rowaux; $iaux++) {
                $aux_codigo = pg_fetch_result($sqlaux, $iaux, "nfecodigo");
                $aux_nome = pg_fetch_result($sqlaux, $iaux, "nfenome");
                $aux_valor = pg_fetch_result($sqlaux, $iaux, "nfepin");
                $aux_cnpj = pg_fetch_result($sqlaux, $iaux, "cpnj");
                $cadastro->insere("ctenfechave", "(ctenumero,ctenfenome,ctenfepin,cnpj)", "($pedido,'$aux_nome','$aux_valor','$aux_cnpj')");
            }
        }

        //Tabela de Duplicatas
        $cadastro->apaga("cteinfoduplicata", "ctenumero=$pedido");
        $sqlaux = "select a.dupcodigo,a.dupnome,a.dupvalor,a.dupvecto from infoduplicata a 
			where a.usucodigo=$usucodigo order by a.dupcodigo";
        $sqlaux = pg_query($sqlaux);
        $rowaux = pg_num_rows($sqlaux);
        if ($rowaux) {
            for ($iaux = 0; $iaux < $rowaux; $iaux++) {
                $aux_codigo = pg_fetch_result($sqlaux, $iaux, "dupcodigo");
                $aux_nome = pg_fetch_result($sqlaux, $iaux, "dupnome");
                $aux_valor = pg_fetch_result($sqlaux, $iaux, "dupvalor");
                $aux_vecto = pg_fetch_result($sqlaux, $iaux, "dupvecto");
                $cadastro->insere("cteinfoduplicata", "(ctenumero,ctedupnome,ctedupvalor,ctedupvecto)", "($pedido,'$aux_nome','$aux_valor','$aux_vecto')");
            }
        }

        //Tabela de Coletas
        $cadastro->apaga("cteinfocoleta", "ctenumero=$pedido");
        $sqlaux = "select colcodigo,colserie,colnumero,colemissao,colcnpj,colie,coluf,colfone,colinterno from infocoleta a 
			where a.usucodigo=$usucodigo order by a.colcodigo";
        $sqlaux = pg_query($sqlaux);
        $rowaux = pg_num_rows($sqlaux);
        if ($rowaux) {
            for ($iaux = 0; $iaux < $rowaux; $iaux++) {
                $aux_codigo = pg_fetch_result($sqlaux, $iaux, "colcodigo");
                $aux_serie = pg_fetch_result($sqlaux, $iaux, "colserie");
                $aux_numero = pg_fetch_result($sqlaux, $iaux, "colnumero");
                $aux_emissao = pg_fetch_result($sqlaux, $iaux, "colemissao");
                $aux_cnpj = pg_fetch_result($sqlaux, $iaux, "colcnpj");
                $aux_ie = pg_fetch_result($sqlaux, $iaux, "colie");
                $aux_uf = pg_fetch_result($sqlaux, $iaux, "coluf");
                $aux_fone = pg_fetch_result($sqlaux, $iaux, "colfone");
                $aux_interno = pg_fetch_result($sqlaux, $iaux, "colinterno");
                $cadastro->insere("cteinfocoleta", "(ctenumero,ctecolserie,ctecolnumero,ctecolemissao,ctecolcnpj,ctecolie,ctecoluf,ctecolfone,ctecolinterno)", "($pedido,'$aux_serie','$aux_numero','$aux_emissao','$aux_cnpj','$aux_ie','$aux_uf','$aux_fone','$aux_interno')");
            }
        }

        //Tabela de Lacres
        $cadastro->apaga("cteinfolacre", "ctenumero=$pedido");
        $sqlaux = "select a.laccodigo,a.lacnome from infolacre a 
			where a.usucodigo=$usucodigo order by a.laccodigo";
        $sqlaux = pg_query($sqlaux);
        $rowaux = pg_num_rows($sqlaux);
        if ($rowaux) {
            for ($iaux = 0; $iaux < $rowaux; $iaux++) {
                $aux_codigo = pg_fetch_result($sqlaux, $iaux, "laccodigo");
                $aux_nome = pg_fetch_result($sqlaux, $iaux, "lacnome");
                $cadastro->insere("cteinfolacre", "(ctenumero,ctelacnome)", "($pedido,'$aux_nome')");
            }
        }

        //Tabela de Pedagios
        $cadastro->apaga("cteinfopedagio", "ctenumero=$pedido");
        $sqlaux = "select a.pedcodigo,a.pednome,a.pedvalor,a.pedforne,a.pedrespo from infopedagio a 
			where a.usucodigo=$usucodigo order by a.pedcodigo";
        $sqlaux = pg_query($sqlaux);
        $rowaux = pg_num_rows($sqlaux);
        if ($rowaux) {
            for ($iaux = 0; $iaux < $rowaux; $iaux++) {
                $aux_codigo = pg_fetch_result($sqlaux, $iaux, "pedcodigo");
                $aux_nome = pg_fetch_result($sqlaux, $iaux, "pednome");
                $aux_valor = pg_fetch_result($sqlaux, $iaux, "pedvalor");
                $aux_forne = pg_fetch_result($sqlaux, $iaux, "pedforne");
                $aux_respo = pg_fetch_result($sqlaux, $iaux, "pedrespo");
                $cadastro->insere("cteinfopedagio", "(ctenumero,ctepednome,ctepedvalor,ctepedforne,ctepedrespo)", "($pedido,'$aux_nome','$aux_valor','$aux_forne','$aux_respo')");
            }
        }

        //Tabela de Veiculos
        $cadastro->apaga("cteinfoveiculos", "ctenumero=$pedido");
        $sqlaux = "select a.infveicodigo,a.veirenavam,a.veiplaca,a.veitara,a.veicapacidadekg,a.veicapacidadem3,a.veitprodado,a.veitpcarroceria,a.veitpveiculo,a.veipropveiculo,a.veiuf,
			a.veitpdoc,a.veicpf,a.veicnpj,a.veirntrc,a.veiie,a.veipropuf,a.veitpproprietario,a.veirazao,a.veipessoa,a.veirg,a.veicod,a.veiempresa from infoveiculos a 
			where a.usucodigo=$usucodigo order by a.infveicodigo";
        $sqlaux = pg_query($sqlaux);
        $rowaux = pg_num_rows($sqlaux);
        if ($rowaux) {
            for ($iaux = 0; $iaux < $rowaux; $iaux++) {
                $aux_codigo = pg_fetch_result($sqlaux, $iaux, "infveicodigo");
                $aux_cod = pg_fetch_result($sqlaux, $iaux, "veicod");
                $aux_renavam = pg_fetch_result($sqlaux, $iaux, "veirenavam");
                $aux_placa = pg_fetch_result($sqlaux, $iaux, "veiplaca");
                $aux_tara = pg_fetch_result($sqlaux, $iaux, "veitara");
                if ($aux_tara == '') {
                    $aux_tara = 0;
                }
                $aux_kg = pg_fetch_result($sqlaux, $iaux, "veicapacidadekg");
                if ($aux_kg == '') {
                    $aux_kg = 0;
                }
                $aux_m3 = pg_fetch_result($sqlaux, $iaux, "veicapacidadem3");
                if ($aux_m3 == '') {
                    $aux_m3 = 0;
                }
                $aux_rodado = pg_fetch_result($sqlaux, $iaux, "veitprodado");
                if ($aux_rodado == '') {
                    $aux_rodado = 0;
                }
                $aux_tpcar = pg_fetch_result($sqlaux, $iaux, "veitpcarroceria");
                if ($aux_tpcar == '') {
                    $aux_tpcar = 0;
                }
                $aux_tpvei = pg_fetch_result($sqlaux, $iaux, "veitpveiculo");
                if ($aux_tpvei == '') {
                    $aux_tpvei = 0;
                }
                $aux_prop = pg_fetch_result($sqlaux, $iaux, "veipropveiculo");
                if ($aux_prop == '') {
                    $aux_prop = 0;
                }
                $aux_uf = pg_fetch_result($sqlaux, $iaux, "veiuf");
                $aux_tpdoc = pg_fetch_result($sqlaux, $iaux, "veitpdoc");
                if ($aux_tpdoc == '') {
                    $aux_tpdoc = 0;
                }
                $aux_cpf = pg_fetch_result($sqlaux, $iaux, "veicpf");
                $aux_cnpj = pg_fetch_result($sqlaux, $iaux, "veicnpj");
                $aux_rntrc = pg_fetch_result($sqlaux, $iaux, "veirntrc");
                $aux_ie = pg_fetch_result($sqlaux, $iaux, "veiie");
                $aux_prouf = pg_fetch_result($sqlaux, $iaux, "veipropuf");
                $aux_tpprop = pg_fetch_result($sqlaux, $iaux, "veitpproprietario");
                if ($aux_tpprop == '') {
                    $aux_tpprop = 0;
                }
                $aux_razao = pg_fetch_result($sqlaux, $iaux, "veirazao");
                $aux_pessoa = pg_fetch_result($sqlaux, $iaux, "veipessoa");
                $aux_rg = pg_fetch_result($sqlaux, $iaux, "veirg");
                $aux_empresa = pg_fetch_result($sqlaux, $iaux, "veiempresa");

                $cadastro->insere("cteinfoveiculos", "(ctenumero,cteveicod,cteveirenavam,cteveiplaca,cteveitara,cteveicapacidadekg,cteveicapacidadem3,cteveitprodado,cteveitpcarroceria,cteveitpveiculo,cteveipropveiculo,
									cteveiuf,cteveitpdoc,cteveicpf,cteveicnpj,cteveirntrc,cteveiie,cteveipropuf,cteveitpproprietario,cteveirazao,cteveipessoa,cteveirg,cteveiempresa)", "($pedido,
									'$aux_cod','$aux_renavam','$aux_placa','$aux_tara','$aux_kg','$aux_m3','$aux_rodado','$aux_tpcar','$aux_tpvei','$aux_prop','$aux_uf','$aux_tpdoc','$aux_cpf',
									'$aux_cnpj','$aux_rntrc','$aux_ie','$aux_prouf','$aux_tpprop','$aux_razao','$aux_pessoa','$aux_rg','$aux_empresa')");
            }
        }

        //Tabela de Motoristas
        $cadastro->apaga("cteinfomotoristas", "ctenumero=$pedido");
        $sqlaux = "select a.infmotcodigo,a.infmotnome,a.infmotcpf from infomotoristas a 
			where a.usucodigo=$usucodigo order by a.infmotcodigo";
        $sqlaux = pg_query($sqlaux);
        $rowaux = pg_num_rows($sqlaux);
        if ($rowaux) {
            for ($iaux = 0; $iaux < $rowaux; $iaux++) {
                $aux_codigo = pg_fetch_result($sqlaux, $iaux, "infmotcodigo");
                $aux_nome = pg_fetch_result($sqlaux, $iaux, "infmotnome");
                $aux_cpf = pg_fetch_result($sqlaux, $iaux, "infmotcpf");
                $cadastro->insere("cteinfomotoristas", "(ctenumero,cteinfmotnome,cteinfmotcpf)", "($pedido,'$aux_nome','$aux_cpf')");
            }
        }

        //Observacoes Contribuinte
        $cadastro->apaga("cteobscontribuinte", "ctenumero=$pedido");
        $sqlaux = "select a.concodigo,a.connome,a.conobs from obscontribuinte a 
			where a.usucodigo=$usucodigo order by a.concodigo";
        $sqlaux = pg_query($sqlaux);
        $rowaux = pg_num_rows($sqlaux);
        if ($rowaux) {
            for ($iaux = 0; $iaux < $rowaux; $iaux++) {
                $aux_codigo = pg_fetch_result($sqlaux, $iaux, "concodigo");
                $aux_nome = pg_fetch_result($sqlaux, $iaux, "connome");
                $aux_obs = pg_fetch_result($sqlaux, $iaux, "conobs");
                $cadastro->insere("cteobscontribuinte", "(ctenumero,cteconnome,cteconobs)", "($pedido,'$aux_nome','$aux_obs')");
            }
        }

        //Observacoes Fisco
        $cadastro->apaga("cteobsfisco", "ctenumero=$pedido");
        $sqlaux = "select a.fiscodigo,a.fisnome,a.fisobs from obsfisco a 
			where a.usucodigo=$usucodigo order by a.fiscodigo";
        $sqlaux = pg_query($sqlaux);
        $rowaux = pg_num_rows($sqlaux);
        if ($rowaux) {
            for ($iaux = 0; $iaux < $rowaux; $iaux++) {
                $aux_codigo = pg_fetch_result($sqlaux, $iaux, "fiscodigo");
                $aux_nome = pg_fetch_result($sqlaux, $iaux, "fisnome");
                $aux_obs = pg_fetch_result($sqlaux, $iaux, "fisobs");
                $cadastro->insere("cteobsfisco", "(ctenumero,ctefisnome,ctefisobs)", "($pedido,'$aux_nome','$aux_obs')");
            }
        }

        // Verifica se é um CT-e Globalizado		
        $sqlaux = "SELECT cteglobalizado FROM cte WHERE ctenumero = {$pedido}";
        $sqlaux = pg_query($sqlaux);
        $rowaux = pg_num_rows($sqlaux);
        $globalizado = 0;
        if ($rowaux) {
            $globalizado = pg_fetch_result($sqlaux, 0, "cteglobalizado");
        }


        // Se forem 5 ou mais destinatarios transforma o CT-e em Globalizado
        if ($globalizado == 1) {

            // Grava os Dados do Emitente nos Campos do Destinatário

            $cadastro->altera("cte", "
			cteglobalizado='1',
			ctedespessoa='$emipessoa',
			ctedescnpj='$emicnpj',
			ctedesie='$emiie',
			ctedescpf='$emicpf',
			ctedesrg='$emirg',
			ctedesnguerra='$eminguerra',
			ctedesrazao='DIVERSOS',
			ctedescep='$emicep',
			ctedesendereco='$emiendereco',
			ctedesnumero='$eminumero',
			ctedessuframa='',
			ctedesbairro='$emibairro',
			ctedescomplemento='$emicomplemento',
			ctedesfone='$emifone',
			ctedespais='$emipais',
			ctedesuf='$emiuf',
			ctedescidcodigo='$emicidcodigo',
			ctedescidcodigoibge='$emicidcodigoibge'"
                    , "ctenumero=$pedido");
        }

        $xml .= "<dados>\n";
        $xml .= "<dado>\n";
        $xml .= "<pvnumero>" . $orc_max . "</pvnumero>\n";
        $xml .= "<ctenumero>" . $orc_numero . "</ctenumero>\n";
        $xml .= "</dado>\n";
        $xml .= "</dados>\n";

        echo $xml;
    } else if ($tabela == "ctenfe") {


        $pedido = $_REQUEST['pedido'];
        $numero_correto = $_REQUEST['numero_correto'];
        $modelo = $_REQUEST['modelo'];
        $serie = $_REQUEST['serie'];
        $numero = $_REQUEST['numero'];
        $orcemissao = $_REQUEST['orcemissao'];
        $orchora = $_REQUEST['orchora'];
        $cfop = $_REQUEST['cfop'];
        $natureza = $_REQUEST['natureza'];
        $modal = $_REQUEST['modal'];
        $servico = $_REQUEST['servico'];
        $finalidade = $_REQUEST['finalidade'];
        $pagto = $_REQUEST['pagto'];
        $forma = $_REQUEST['forma'];
        $chave = $_REQUEST['chave'];
        $estado = $_REQUEST['estado'];
        $estadoini = $_REQUEST['estadoini'];
        $estadofim = $_REQUEST['estadofim'];
        $cidade = $_REQUEST['cidade'];
        $cidadeini = $_REQUEST['cidadeini'];
        $cidadefim = $_REQUEST['cidadefim'];

        $emipessoa = $_REQUEST['emipessoa'];
        $emicnpj = $_REQUEST['emicnpj'];
        $emiie = $_REQUEST['emiie'];
        $emicpf = $_REQUEST['emicpf'];
        $emirg = $_REQUEST['emirg'];
        $eminguerra = $_REQUEST['eminguerra'];
        $emirazao = $_REQUEST['emirazao'];
        $emicep = $_REQUEST['emicep'];
        $emiendereco = $_REQUEST['emiendereco'];
        $eminumero = $_REQUEST['eminumero'];
        if ($eminumero == '' || !is_numeric($eminumero)) {
            $eminumero = 0;
        }
        $emibairro = $_REQUEST['emibairro'];
        $emicomplemento = $_REQUEST['emicomplemento'];
        $emifone = $_REQUEST['emifone'];
        $emipais = $_REQUEST['emipais'];
        $emiuf = $_REQUEST['emiuf'];
        $emicidcodigo = $_REQUEST['emicidcodigo'];
        if ($emicidcodigo == '') {
            $emicidcodigo = 0;
        }
        $emicidcodigoibge = $_REQUEST['emicidcodigoibge'];

        $tomcodigo = $_REQUEST['tomcodigo'];
        $tompessoa = $_REQUEST['tompessoa'];
        $tomcnpj = $_REQUEST['tomcnpj'];
        $tomie = $_REQUEST['tomie'];
        $tomcpf = $_REQUEST['tomcpf'];
        $tomrg = $_REQUEST['tomrg'];
        $tomnguerra = $_REQUEST['tomnguerra'];
        $tomrazao = $_REQUEST['tomrazao'];
        $tomcep = $_REQUEST['tomcep'];
        $tomendereco = $_REQUEST['tomendereco'];
        $tomnumero = $_REQUEST['tomnumero'];
        if ($tomnumero == '' || !is_numeric($tomnumero)) {
            $tomnumero = 0;
        }
        $tombairro = $_REQUEST['tombairro'];
        $tomcomplemento = $_REQUEST['tomcomplemento'];
        $tomfone = $_REQUEST['tomfone'];
        $tompais = $_REQUEST['tompais'];
        $tomuf = $_REQUEST['tomuf'];
        $tomcidcodigo = $_REQUEST['tomcidcodigo'];
        if ($tomcidcodigo == '') {
            $tomcidcodigo = 0;
        }
        $tomcidcodigoibge = $_REQUEST['tomcidcodigoibge'];

        $remcodigo = $_REQUEST['remcodigo'];
        $rempessoa = $_REQUEST['rempessoa'];
        $remcnpj = $_REQUEST['remcnpj'];
        $remie = $_REQUEST['remie'];
        $remcpf = $_REQUEST['remcpf'];
        $remrg = $_REQUEST['remrg'];
        $remnguerra = $_REQUEST['remnguerra'];
        $remrazao = $_REQUEST['remrazao'];
        $remcep = $_REQUEST['remcep'];
        $remendereco = $_REQUEST['remendereco'];
        $remnumero = $_REQUEST['remnumero'];
        if ($remnumero == '' || !is_numeric($remnumero)) {
            $remnumero = 0;
        }
        $rembairro = $_REQUEST['rembairro'];
        $remcomplemento = $_REQUEST['remcomplemento'];
        $remfone = $_REQUEST['remfone'];
        $rempais = $_REQUEST['rempais'];
        $remuf = $_REQUEST['remuf'];
        $remcidcodigo = $_REQUEST['remcidcodigo'];
        if ($remcidcodigo == '') {
            $remcidcodigo = 0;
        }
        $remcidcodigoibge = $_REQUEST['remcidcodigoibge'];

        $expcodigo = $_REQUEST['expcodigo'];
        $exppessoa = $_REQUEST['exppessoa'];
        $expcnpj = $_REQUEST['expcnpj'];
        $expie = $_REQUEST['expie'];
        $expcpf = $_REQUEST['expcpf'];
        $exprg = $_REQUEST['exprg'];
        $expnguerra = $_REQUEST['expnguerra'];
        $exprazao = $_REQUEST['exprazao'];
        $expcep = $_REQUEST['expcep'];
        $expendereco = $_REQUEST['expendereco'];
        $expnumero = $_REQUEST['expnumero'];
        if ($expnumero == '' || !is_numeric($expnumero)) {
            $expnumero = 0;
        }
        $expbairro = $_REQUEST['expbairro'];
        $expcomplemento = $_REQUEST['expcomplemento'];
        $expfone = $_REQUEST['expfone'];
        $exppais = $_REQUEST['exppais'];
        $expuf = $_REQUEST['expuf'];
        $expcidcodigo = $_REQUEST['expcidcodigo'];
        if ($expcidcodigo == '') {
            $expcidcodigo = 0;
        }
        $expcidcodigoibge = $_REQUEST['expcidcodigoibge'];

        $reccodigo = $_REQUEST['reccodigo'];
        $recpessoa = $_REQUEST['recpessoa'];
        $reccnpj = $_REQUEST['reccnpj'];
        $recie = $_REQUEST['recie'];
        $reccpf = $_REQUEST['reccpf'];
        $recrg = $_REQUEST['recrg'];
        $recnguerra = $_REQUEST['recnguerra'];
        $recrazao = $_REQUEST['recrazao'];
        $reccep = $_REQUEST['reccep'];
        $recendereco = $_REQUEST['recendereco'];
        $recnumero = $_REQUEST['recnumero'];
        if ($recnumero == '' || !is_numeric($recnumero)) {
            $recnumero = 0;
        }
        $recbairro = $_REQUEST['recbairro'];
        $reccomplemento = $_REQUEST['reccomplemento'];
        $recfone = $_REQUEST['recfone'];
        $recpais = $_REQUEST['recpais'];
        $recuf = $_REQUEST['recuf'];
        $reccidcodigo = $_REQUEST['reccidcodigo'];
        if ($reccidcodigo == '') {
            $reccidcodigo = 0;
        }
        $reccidcodigoibge = $_REQUEST['reccidcodigoibge'];

        $descodigo = $_REQUEST['descodigo'];
        $despessoa = $_REQUEST['despessoa'];
        $descnpj = $_REQUEST['descnpj'];
        $desie = $_REQUEST['desie'];
        $descpf = $_REQUEST['descpf'];
        $desrg = $_REQUEST['desrg'];
        $desnguerra = $_REQUEST['desnguerra'];
        $desrazao = $_REQUEST['desrazao'];
        $descep = $_REQUEST['descep'];
        $desendereco = $_REQUEST['desendereco'];
        $desnumero = $_REQUEST['desnumero'];
        $dessuframa = $_REQUEST['dessuframa'];
        if ($desnumero == '' || !is_numeric($desnumero)) {
            $desnumero = 0;
        }
        $desbairro = $_REQUEST['desbairro'];
        $descomplemento = $_REQUEST['descomplemento'];
        $desfone = $_REQUEST['desfone'];
        $despais = $_REQUEST['despais'];
        $desuf = $_REQUEST['desuf'];
        $descidcodigo = $_REQUEST['descidcodigo'];
        if ($descidcodigo == '') {
            $descidcodigo = 0;
        }
        $descidcodigoibge = $_REQUEST['descidcodigoibge'];

        $cteservicos = $_REQUEST['cteservicos'];
        if ($cteservicos == '') {
            $cteservicos = 0;
        }
        $ctereceber = $_REQUEST['ctereceber'];
        if ($ctereceber == '') {
            $ctereceber = 0;
        }
        $ctetributos = $_REQUEST['ctetributos'];
        if ($ctetributos == '') {
            $ctetributos = 0;
        }
        $sitcodigo = $_REQUEST['sitcodigo'];
        if ($sitcodigo == '') {
            $sitcodigo = 0;
        }
        $cteperreducao = $_REQUEST['cteperreducao'];
        if ($cteperreducao == '') {
            $cteperreducao = 0;
        }
        $ctebasecalculo = $_REQUEST['ctebasecalculo'];
        if ($ctebasecalculo == '') {
            $ctebasecalculo = 0;
        }
        $ctepericms = $_REQUEST['ctepericms'];
        if ($ctepericms == '') {
            $ctepericms = 0;
        }
        $ctevalicms = $_REQUEST['ctevalicms'];
        if ($ctevalicms == '') {
            $ctevalicms = 0;
        }
        $ctecredito = $_REQUEST['ctecredito'];
        if ($ctecredito == '') {
            $ctecredito = 0;
        }
        $ctepreencheicms = $_REQUEST['ctepreencheicms'];
        if ($ctepreencheicms == '') {
            $ctepreencheicms = 0;
        }
        $ctebaseicms = $_REQUEST['ctebaseicms'];
        if ($ctebaseicms == '') {
            $ctebaseicms = 0;
        }
        $cteperinterna = $_REQUEST['cteperinterna'];
        if ($cteperinterna == '') {
            $cteperinterna = 0;
        }
        $cteperinter = $_REQUEST['cteperinter'];
        if ($cteperinter == '') {
            $cteperinter = 0;
        }
        $cteperpartilha = $_REQUEST['cteperpartilha'];
        if ($cteperpartilha == '') {
            $cteperpartilha = 0;
        }
        $ctevalicmsini = $_REQUEST['ctevalicmsini'];
        if ($ctevalicmsini == '') {
            $ctevalicmsini = 0;
        }
        $ctevalicmsfim = $_REQUEST['ctevalicmsfim'];
        if ($ctevalicmsfim == '') {
            $ctevalicmsfim = 0;
        }
        $cteperpobreza = $_REQUEST['cteperpobreza'];
        if ($cteperpobreza == '') {
            $cteperpobreza = 0;
        }
        $ctevalpobreza = $_REQUEST['ctevalpobreza'];
        if ($ctevalpobreza == '') {
            $ctevalpobreza = 0;
        }
        $cteadcfisco = $_REQUEST['cteadcfisco'];

        $ctecargaval = $_REQUEST['ctecargaval'];
        if ($ctecargaval == '') {
            $ctecargaval = 0;
        }
        $ctepropredominante = $_REQUEST['ctepropredominante'];
        $cteoutcaracteristica = $_REQUEST['cteoutcaracteristica'];
        $ctecobrancanum = $_REQUEST['ctecobrancanum'];
        $ctecobrancaval = $_REQUEST['ctecobrancaval'];
        if ($ctecobrancaval == '') {
            $ctecobrancaval = 0;
        }
        $ctecobrancades = $_REQUEST['ctecobrancades'];
        if ($ctecobrancades == '') {
            $ctecobrancades = 0;
        }
        $ctecobrancaliq = $_REQUEST['ctecobrancaliq'];
        if ($ctecobrancaliq == '') {
            $ctecobrancaliq = 0;
        }

        $cterntrc = $_REQUEST['cterntrc'];
        $cteentrega = $_REQUEST['cteentrega'];
        if ($cteentrega == '') {
            $cteentrega = "NULL";
        } else {
            $cteentrega = substr($cteentrega, 6, 4) . '-' . substr($cteentrega, 3, 2) . '-' . substr($cteentrega, 0, 2);
            $cteentrega = "'$cteentrega'";
        }
        $cteindlocacao = $_REQUEST['cteindlocacao'];
        if ($cteindlocacao == '') {
            $cteindlocacao = 0;
        }
        $cteciot = $_REQUEST['cteciot'];

        $cteobsgeral = $_REQUEST['cteobsgeral'];

        $usucodigo = $_REQUEST['usucodigo'];

        $chavefin = $_REQUEST['chavefin'];
        $datatomador = $_REQUEST['datatomador'];

        if ($datatomador != '') {
            $datatomador = substr($datatomador, 6, 4) . '-' . substr($datatomador, 3, 2) . '-' . substr($datatomador, 0, 2) . ' 00:00:00-03';
            $datatomador = "'$datatomador'";
        } else {
            $datatomador = "NULL";
        }

        $orcemissao = substr($orcemissao, 6, 4) . '-' . substr($orcemissao, 3, 2) . '-' . substr($orcemissao, 0, 2);
        $emissao = substr($orcemissao, 0, 10) . ' ' . $orchora . ":00-03";
        $emissao = "'$emissao'";

        $ctesubstipo = $_REQUEST['ctesubstipo'];
        $ctesubschave = $_REQUEST['ctesubschave'];

        $orc_max = $pedido;
        $orc_numero = delimitador($numero, '9', 'R', '0');

        if ($numero_correto == 0 || $numero_correto == '') {

            //Faz a busca do nº MAX da devolucaon 
            $query_num_orcamento = $cadastro->seleciona("max(ctenumero) as total", "cte", "1=1");
            $array_num_orcamento = pg_fetch_object($query_num_orcamento);

            $orc_max = $array_num_orcamento->total + 1;

            //Faz a busca do nº MAX do ctenum
            $query_num_orcamento2 = $cadastro->seleciona("max(ctenum) as total2", "cte", "1=1");
            $array_num_orcamento2 = pg_fetch_object($query_num_orcamento2);

            if ($array_num_orcamento2->total2 == "")
                $array_num_orcamento2->total2 = 0;
            $array_num_orcamento2->total2++;

            $orc_numero = delimitador(trim($array_num_orcamento2->total2), '9', 'R', '0');

            //$orc_numero = delimitador($numero,'9','R','0');

            $query_orcamento = $cadastro->insere("cte", "(ctenumero,ctemodelo,cteserie,ctenum,cteemissao,ctehorario,ctecfop,ctenatureza,tmocodigo,sercodigo,tctcodigo,tpgcodigo,tfocodigo,ctechaveref,cteufemissao,cteufinicio,cteuffinal,ctecidemissao,ctecidinicio,ctecidfinal,ctechavefin,ctedatatomador)",
                    "($orc_max,'$modelo','$serie','$orc_numero',$emissao,'$orchora','$cfop','$natureza','$modal',$servico,$finalidade,$pagto,$forma,'$chave','$estado','$estadoini','$estadofim',$cidade,$cidadeini,$cidadefim,'$chavefin',$datatomador)");

            $pedido = $orc_max;
        }


        $cadastro->altera("cte", "ctemodelo='$modelo',cteserie='$serie',ctenum='$orc_numero',cteemissao=$emissao,
		ctehorario='$orchora',ctecfop='$cfop',ctenatureza='$natureza',tmocodigo='$modal',
		sercodigo='$servico',tctcodigo='$finalidade',tpgcodigo='$pagto',tfocodigo='$forma',
		ctechaveref='$chave',cteufemissao='$estado',cteufinicio='$estadoini',cteuffinal='$estadofim',ctecidemissao='$cidade',ctecidinicio='$cidadeini',ctecidfinal='$cidadefim',		
		cteemipessoa='$emipessoa',
		cteemicnpj='$emicnpj',
		cteemiie='$emiie',
		cteemicpf='$emicpf',
		cteemirg='$emirg',
		cteeminguerra='$eminguerra',
		cteemirazao='$emirazao',
		cteemicep='$emicep',
		cteemiendereco='$emiendereco',
		cteeminumero='$eminumero',
		cteemibairro='$emibairro',
		cteemicomplemento='$emicomplemento',
		cteemifone='$emifone',
		cteemipais='$emipais',
		cteemiuf='$emiuf',
		cteemicidcodigo='$emicidcodigo',
		cteemicidcodigoibge='$emicidcodigoibge',
		tomcodigo='$tomcodigo',
		ctetompessoa='$tompessoa',
		ctetomcnpj='$tomcnpj',
		ctetomie='$tomie',
		ctetomcpf='$tomcpf',
		ctetomrg='$tomrg',
		ctetomnguerra='$tomnguerra',
		ctetomrazao='$tomrazao',
		ctetomcep='$tomcep',
		ctetomendereco='$tomendereco',
		ctetomnumero='$tomnumero',
		ctetombairro='$tombairro',
		ctetomcomplemento='$tomcomplemento',
		ctetomfone='$tomfone',
		ctetompais='$tompais',
		ctetomuf='$tomuf',
		ctetomcidcodigo='$tomcidcodigo',
		ctetomcidcodigoibge='$tomcidcodigoibge',
		remcodigo='$remcodigo',
		cterempessoa='$rempessoa',
		cteremcnpj='$remcnpj',
		cteremie='$remie',
		cteremcpf='$remcpf',
		cteremrg='$remrg',
		cteremnguerra='$remnguerra',
		cteremrazao='$remrazao',
		cteremcep='$remcep',
		cteremendereco='$remendereco',
		cteremnumero='$remnumero',
		cterembairro='$rembairro',
		cteremcomplemento='$remcomplemento',
		cteremfone='$remfone',
		cterempais='$rempais',
		cteremuf='$remuf',
		cteremcidcodigo='$remcidcodigo',
		cteremcidcodigoibge='$remcidcodigoibge',		
		expcodigo='$expcodigo',
		cteexppessoa='$exppessoa',
		cteexpcnpj='$expcnpj',
		cteexpie='$expie',
		cteexpcpf='$expcpf',
		cteexprg='$exprg',
		cteexpnguerra='$expnguerra',
		cteexprazao='$exprazao',
		cteexpcep='$expcep',
		cteexpendereco='$expendereco',
		cteexpnumero='$expnumero',
		cteexpbairro='$expbairro',
		cteexpcomplemento='$expcomplemento',
		cteexpfone='$expfone',
		cteexppais='$exppais',
		cteexpuf='$expuf',
		cteexpcidcodigo='$expcidcodigo',
		cteexpcidcodigoibge='$expcidcodigoibge',		
		reccodigo='$reccodigo',
		cterecpessoa='$recpessoa',
		ctereccnpj='$reccnpj',
		cterecie='$recie',
		ctereccpf='$reccpf',
		cterecrg='$recrg',
		cterecnguerra='$recnguerra',
		cterecrazao='$recrazao',
		ctereccep='$reccep',
		cterecendereco='$recendereco',
		cterecnumero='$recnumero',
		cterecbairro='$recbairro',
		ctereccomplemento='$reccomplemento',
		cterecfone='$recfone',
		cterecpais='$recpais',
		cterecuf='$recuf',
		ctereccidcodigo='$reccidcodigo',
		ctereccidcodigoibge='$reccidcodigoibge',		
		descodigo='$descodigo',
		ctedespessoa='$despessoa',
		ctedescnpj='$descnpj',
		ctedesie='$desie',
		ctedescpf='$descpf',
		ctedesrg='$desrg',
		ctedesnguerra='$desnguerra',
		ctedesrazao='$desrazao',
		ctedescep='$descep',
		ctedesendereco='$desendereco',
		ctedesnumero='$desnumero',
		ctedessuframa='$dessuframa',
		ctedesbairro='$desbairro',
		ctedescomplemento='$descomplemento',
		ctedesfone='$desfone',
		ctedespais='$despais',
		ctedesuf='$desuf',
		ctedescidcodigo='$descidcodigo',
		ctedescidcodigoibge='$descidcodigoibge',		
		cteservicos='$cteservicos',
		ctereceber='$ctereceber',
		ctetributos='$ctetributos',
		sitcodigo='$sitcodigo',
		cteperreducao='$cteperreducao',
		ctebasecalculo='$ctebasecalculo',
		ctepericms='$ctepericms',
		ctevalicms='$ctevalicms',
		ctecredito='$ctecredito',
		ctepreencheicms='$ctepreencheicms',
		ctebaseicms='$ctebaseicms',
		cteperinterna='$cteperinterna',
		cteperinter='$cteperinter',
		cteperpartilha='$cteperpartilha',
		ctevalicmsini='$ctevalicmsini',
		ctevalicmsfim='$ctevalicmsfim',
		cteperpobreza='$cteperpobreza',
		ctevalpobreza='$ctevalpobreza',
		cteadcfisco='$cteadcfisco',
		ctecargaval='$ctecargaval',
		ctepropredominante='$ctepropredominante',
		cteoutcaracteristica='$cteoutcaracteristica',
		ctecobrancanum='$ctecobrancanum',
		ctecobrancaval='$ctecobrancaval',
		ctecobrancades='$ctecobrancades',
		ctecobrancaliq='$ctecobrancaliq',
		cterntrc='$cterntrc',
		cteentrega=$cteentrega,
		cteindlocacao='$cteindlocacao',
		cteciot='$cteciot',
		cteobsgeral='$cteobsgeral',
		ctechavefin='$chavefin',
		ctedatatomador=$datatomador,

		ctesubstipo=$ctesubstipo,
		ctesubschave='$ctesubschave'
		"
                , "ctenumero=$pedido");

        //Tabela de Valores do Servico
        $cadastro->apaga("ctevalorservico", "ctenumero=$pedido");
        $sqlaux = "select a.valcodigo,a.valnome,a.valvalor from valorservico a 
			where a.usucodigo=$usucodigo order by a.valcodigo";
        $sqlaux = pg_query($sqlaux);
        $rowaux = pg_num_rows($sqlaux);
        if ($rowaux) {
            for ($iaux = 0; $iaux < $rowaux; $iaux++) {
                $aux_codigo = pg_fetch_result($sqlaux, $iaux, "valcodigo");
                $aux_nome = pg_fetch_result($sqlaux, $iaux, "valnome");
                $aux_valor = pg_fetch_result($sqlaux, $iaux, "valvalor");
                $cadastro->insere("ctevalorservico", "(ctenumero,ctevalnome,ctevalvalor)", "($pedido,'$aux_nome','$aux_valor')");
            }
        }

        //Tabela de Informacoes de Carga
        $cadastro->apaga("cteinfocarga", "ctenumero=$pedido");
        $sqlaux = "select a.infcodigo,a.medcodigo,a.infnome,a.infvalor from infocarga a 
			where a.usucodigo=$usucodigo order by a.infcodigo";
        $sqlaux = pg_query($sqlaux);
        $rowaux = pg_num_rows($sqlaux);
        if ($rowaux) {
            for ($iaux = 0; $iaux < $rowaux; $iaux++) {
                $aux_codigo = pg_fetch_result($sqlaux, $iaux, "medcodigo");
                $aux_nome = pg_fetch_result($sqlaux, $iaux, "infnome");
                $aux_valor = pg_fetch_result($sqlaux, $iaux, "infvalor");
                $cadastro->insere("cteinfocarga", "(ctenumero,cteinfnome,cteinfvalor,medcodigo)", "($pedido,'$aux_nome','$aux_valor','$aux_codigo')");
            }
        }

        //Tabela de Informacoes do Seguro
        $cadastro->apaga("cteinfoseguro", "ctenumero=$pedido");
        $sqlaux = "select a.segcodigo,a.rescodigo,a.segnome,a.segvalor,a.segapolice,a.segaverbacao from infoseguro a 
			where a.usucodigo=$usucodigo order by a.segcodigo";
        $sqlaux = pg_query($sqlaux);
        $rowaux = pg_num_rows($sqlaux);
        if ($rowaux) {
            for ($iaux = 0; $iaux < $rowaux; $iaux++) {
                $aux_codigo = pg_fetch_result($sqlaux, $iaux, "rescodigo");
                $aux_nome = pg_fetch_result($sqlaux, $iaux, "segnome");
                $aux_valor = pg_fetch_result($sqlaux, $iaux, "segvalor");
                $aux_apolice = pg_fetch_result($sqlaux, $iaux, "segapolice");
                $aux_averbacao = pg_fetch_result($sqlaux, $iaux, "segaverbacao");
                $cadastro->insere("cteinfoseguro", "(ctenumero,ctesegnome,ctesegvalor,rescodigo,ctesegapolice,ctesegaverbacao)", "($pedido,'$aux_nome','$aux_valor','$aux_codigo','$aux_apolice','$aux_averbacao')");
            }
        }

        //Tabela de Documentos
        $cadastro->apaga("ctenfechave", "ctenumero=$pedido");
        $sqlaux = "select a.nfecodigo,a.nfenome,a.nfepin,a.cnpj from nfechave a 
			where a.usucodigo=$usucodigo order by a.nfecodigo";

        $sqlaux = pg_query($sqlaux);
        $rowaux = pg_num_rows($sqlaux);
        if ($rowaux) {
            for ($iaux = 0; $iaux < $rowaux; $iaux++) {
                $aux_codigo = pg_fetch_result($sqlaux, $iaux, "nfecodigo");
                $aux_nome = pg_fetch_result($sqlaux, $iaux, "nfenome");
                $aux_valor = pg_fetch_result($sqlaux, $iaux, "nfepin");
                $aux_cnpj = pg_fetch_result($sqlaux, $iaux, "cnpj");
                $cadastro->insere("ctenfechave", "(ctenumero,ctenfenome,ctenfepin,cnpj)", "($pedido,'$aux_nome','$aux_valor','$aux_cnpj')");
            }
        }

        //Tabela de Duplicatas
        $cadastro->apaga("cteinfoduplicata", "ctenumero=$pedido");
        $sqlaux = "select a.dupcodigo,a.dupnome,a.dupvalor,a.dupvecto from infoduplicata a 
			where a.usucodigo=$usucodigo order by a.dupcodigo";
        $sqlaux = pg_query($sqlaux);
        $rowaux = pg_num_rows($sqlaux);
        if ($rowaux) {
            for ($iaux = 0; $iaux < $rowaux; $iaux++) {
                $aux_codigo = pg_fetch_result($sqlaux, $iaux, "dupcodigo");
                $aux_nome = pg_fetch_result($sqlaux, $iaux, "dupnome");
                $aux_valor = pg_fetch_result($sqlaux, $iaux, "dupvalor");
                $aux_vecto = pg_fetch_result($sqlaux, $iaux, "dupvecto");
                $cadastro->insere("cteinfoduplicata", "(ctenumero,ctedupnome,ctedupvalor,ctedupvecto)", "($pedido,'$aux_nome','$aux_valor','$aux_vecto')");
            }
        }

        //Tabela de Coletas
        $cadastro->apaga("cteinfocoleta", "ctenumero=$pedido");
        $sqlaux = "select colcodigo,colserie,colnumero,colemissao,colcnpj,colie,coluf,colfone,colinterno from infocoleta a 
			where a.usucodigo=$usucodigo order by a.colcodigo";
        $sqlaux = pg_query($sqlaux);
        $rowaux = pg_num_rows($sqlaux);
        if ($rowaux) {
            for ($iaux = 0; $iaux < $rowaux; $iaux++) {
                $aux_codigo = pg_fetch_result($sqlaux, $iaux, "colcodigo");
                $aux_serie = pg_fetch_result($sqlaux, $iaux, "colserie");
                $aux_numero = pg_fetch_result($sqlaux, $iaux, "colnumero");
                $aux_emissao = pg_fetch_result($sqlaux, $iaux, "colemissao");
                $aux_cnpj = pg_fetch_result($sqlaux, $iaux, "colcnpj");
                $aux_ie = pg_fetch_result($sqlaux, $iaux, "colie");
                $aux_uf = pg_fetch_result($sqlaux, $iaux, "coluf");
                $aux_fone = pg_fetch_result($sqlaux, $iaux, "colfone");
                $aux_interno = pg_fetch_result($sqlaux, $iaux, "colinterno");
                $cadastro->insere("cteinfocoleta", "(ctenumero,ctecolserie,ctecolnumero,ctecolemissao,ctecolcnpj,ctecolie,ctecoluf,ctecolfone,ctecolinterno)", "($pedido,'$aux_serie','$aux_numero','$aux_emissao','$aux_cnpj','$aux_ie','$aux_uf','$aux_fone','$aux_interno')");
            }
        }

        //Tabela de Lacres
        $cadastro->apaga("cteinfolacre", "ctenumero=$pedido");
        $sqlaux = "select a.laccodigo,a.lacnome from infolacre a 
			where a.usucodigo=$usucodigo order by a.laccodigo";
        $sqlaux = pg_query($sqlaux);
        $rowaux = pg_num_rows($sqlaux);
        if ($rowaux) {
            for ($iaux = 0; $iaux < $rowaux; $iaux++) {
                $aux_codigo = pg_fetch_result($sqlaux, $iaux, "laccodigo");
                $aux_nome = pg_fetch_result($sqlaux, $iaux, "lacnome");
                $cadastro->insere("cteinfolacre", "(ctenumero,ctelacnome)", "($pedido,'$aux_nome')");
            }
        }

        //Tabela de Pedagios
        $cadastro->apaga("cteinfopedagio", "ctenumero=$pedido");
        $sqlaux = "select a.pedcodigo,a.pednome,a.pedvalor,a.pedforne,a.pedrespo from infopedagio a 
			where a.usucodigo=$usucodigo order by a.pedcodigo";
        $sqlaux = pg_query($sqlaux);
        $rowaux = pg_num_rows($sqlaux);
        if ($rowaux) {
            for ($iaux = 0; $iaux < $rowaux; $iaux++) {
                $aux_codigo = pg_fetch_result($sqlaux, $iaux, "pedcodigo");
                $aux_nome = pg_fetch_result($sqlaux, $iaux, "pednome");
                $aux_valor = pg_fetch_result($sqlaux, $iaux, "pedvalor");
                $aux_forne = pg_fetch_result($sqlaux, $iaux, "pedforne");
                $aux_respo = pg_fetch_result($sqlaux, $iaux, "pedrespo");
                $cadastro->insere("cteinfopedagio", "(ctenumero,ctepednome,ctepedvalor,ctepedforne,ctepedrespo)", "($pedido,'$aux_nome','$aux_valor','$aux_forne','$aux_respo')");
            }
        }

        //Tabela de Veiculos
        $cadastro->apaga("cteinfoveiculos", "ctenumero=$pedido");
        $sqlaux = "select a.infveicodigo,a.veirenavam,a.veiplaca,a.veitara,a.veicapacidadekg,a.veicapacidadem3,a.veitprodado,a.veitpcarroceria,a.veitpveiculo,a.veipropveiculo,a.veiuf,
			a.veitpdoc,a.veicpf,a.veicnpj,a.veirntrc,a.veiie,a.veipropuf,a.veitpproprietario,a.veirazao,a.veipessoa,a.veirg,a.veicod,a.veiempresa from infoveiculos a 
			where a.usucodigo=$usucodigo order by a.infveicodigo";
        $sqlaux = pg_query($sqlaux);
        $rowaux = pg_num_rows($sqlaux);
        if ($rowaux) {
            for ($iaux = 0; $iaux < $rowaux; $iaux++) {
                $aux_codigo = pg_fetch_result($sqlaux, $iaux, "infveicodigo");
                $aux_cod = pg_fetch_result($sqlaux, $iaux, "veicod");
                $aux_renavam = pg_fetch_result($sqlaux, $iaux, "veirenavam");
                $aux_placa = pg_fetch_result($sqlaux, $iaux, "veiplaca");
                $aux_tara = pg_fetch_result($sqlaux, $iaux, "veitara");
                if ($aux_tara == '') {
                    $aux_tara = 0;
                }
                $aux_kg = pg_fetch_result($sqlaux, $iaux, "veicapacidadekg");
                if ($aux_kg == '') {
                    $aux_kg = 0;
                }
                $aux_m3 = pg_fetch_result($sqlaux, $iaux, "veicapacidadem3");
                if ($aux_m3 == '') {
                    $aux_m3 = 0;
                }
                $aux_rodado = pg_fetch_result($sqlaux, $iaux, "veitprodado");
                if ($aux_rodado == '') {
                    $aux_rodado = 0;
                }
                $aux_tpcar = pg_fetch_result($sqlaux, $iaux, "veitpcarroceria");
                if ($aux_tpcar == '') {
                    $aux_tpcar = 0;
                }
                $aux_tpvei = pg_fetch_result($sqlaux, $iaux, "veitpveiculo");
                if ($aux_tpvei == '') {
                    $aux_tpvei = 0;
                }
                $aux_prop = pg_fetch_result($sqlaux, $iaux, "veipropveiculo");
                if ($aux_prop == '') {
                    $aux_prop = 0;
                }
                $aux_uf = pg_fetch_result($sqlaux, $iaux, "veiuf");
                $aux_tpdoc = pg_fetch_result($sqlaux, $iaux, "veitpdoc");
                if ($aux_tpdoc == '') {
                    $aux_tpdoc = 0;
                }
                $aux_cpf = pg_fetch_result($sqlaux, $iaux, "veicpf");
                $aux_cnpj = pg_fetch_result($sqlaux, $iaux, "veicnpj");
                $aux_rntrc = pg_fetch_result($sqlaux, $iaux, "veirntrc");
                $aux_ie = pg_fetch_result($sqlaux, $iaux, "veiie");
                $aux_prouf = pg_fetch_result($sqlaux, $iaux, "veipropuf");
                $aux_tpprop = pg_fetch_result($sqlaux, $iaux, "veitpproprietario");
                if ($aux_tpprop == '') {
                    $aux_tpprop = 0;
                }
                $aux_razao = pg_fetch_result($sqlaux, $iaux, "veirazao");
                $aux_pessoa = pg_fetch_result($sqlaux, $iaux, "veipessoa");
                $aux_rg = pg_fetch_result($sqlaux, $iaux, "veirg");
                $aux_empresa = pg_fetch_result($sqlaux, $iaux, "veiempresa");

                $cadastro->insere("cteinfoveiculos", "(ctenumero,cteveicod,cteveirenavam,cteveiplaca,cteveitara,cteveicapacidadekg,cteveicapacidadem3,cteveitprodado,cteveitpcarroceria,cteveitpveiculo,cteveipropveiculo,
									cteveiuf,cteveitpdoc,cteveicpf,cteveicnpj,cteveirntrc,cteveiie,cteveipropuf,cteveitpproprietario,cteveirazao,cteveipessoa,cteveirg,cteveiempresa)", "($pedido,
									'$aux_cod','$aux_renavam','$aux_placa','$aux_tara','$aux_kg','$aux_m3','$aux_rodado','$aux_tpcar','$aux_tpvei','$aux_prop','$aux_uf','$aux_tpdoc','$aux_cpf',
									'$aux_cnpj','$aux_rntrc','$aux_ie','$aux_prouf','$aux_tpprop','$aux_razao','$aux_pessoa','$aux_rg','$aux_empresa')");
            }
        }

        //Tabela de Motoristas
        $cadastro->apaga("cteinfomotoristas", "ctenumero=$pedido");
        $sqlaux = "select a.infmotcodigo,a.infmotnome,a.infmotcpf from infomotoristas a 
			where a.usucodigo=$usucodigo order by a.infmotcodigo";
        $sqlaux = pg_query($sqlaux);
        $rowaux = pg_num_rows($sqlaux);
        if ($rowaux) {
            for ($iaux = 0; $iaux < $rowaux; $iaux++) {
                $aux_codigo = pg_fetch_result($sqlaux, $iaux, "infmotcodigo");
                $aux_nome = pg_fetch_result($sqlaux, $iaux, "infmotnome");
                $aux_cpf = pg_fetch_result($sqlaux, $iaux, "infmotcpf");
                $cadastro->insere("cteinfomotoristas", "(ctenumero,cteinfmotnome,cteinfmotcpf)", "($pedido,'$aux_nome','$aux_cpf')");
            }
        }

        //Observacoes Contribuinte
        $cadastro->apaga("cteobscontribuinte", "ctenumero=$pedido");
        $sqlaux = "select a.concodigo,a.connome,a.conobs from obscontribuinte a 
			where a.usucodigo=$usucodigo order by a.concodigo";
        $sqlaux = pg_query($sqlaux);
        $rowaux = pg_num_rows($sqlaux);
        if ($rowaux) {
            for ($iaux = 0; $iaux < $rowaux; $iaux++) {
                $aux_codigo = pg_fetch_result($sqlaux, $iaux, "concodigo");
                $aux_nome = pg_fetch_result($sqlaux, $iaux, "connome");
                $aux_obs = pg_fetch_result($sqlaux, $iaux, "conobs");
                $cadastro->insere("cteobscontribuinte", "(ctenumero,cteconnome,cteconobs)", "($pedido,'$aux_nome','$aux_obs')");
            }
        }

        //Observacoes Fisco
        $cadastro->apaga("cteobsfisco", "ctenumero=$pedido");
        $sqlaux = "select a.fiscodigo,a.fisnome,a.fisobs from obsfisco a 
			where a.usucodigo=$usucodigo order by a.fiscodigo";
        $sqlaux = pg_query($sqlaux);
        $rowaux = pg_num_rows($sqlaux);
        if ($rowaux) {
            for ($iaux = 0; $iaux < $rowaux; $iaux++) {
                $aux_codigo = pg_fetch_result($sqlaux, $iaux, "fiscodigo");
                $aux_nome = pg_fetch_result($sqlaux, $iaux, "fisnome");
                $aux_obs = pg_fetch_result($sqlaux, $iaux, "fisobs");
                $cadastro->insere("cteobsfisco", "(ctenumero,ctefisnome,ctefisobs)", "($pedido,'$aux_nome','$aux_obs')");
            }
        }

        // Verifica se tem mais de 5 destinatarios diferentes		
        $sqlaux = "SELECT COUNT(DISTINCT cnpj) AS quant FROM ctenfechave WHERE ctenumero = {$pedido}";
        $sqlaux = pg_query($sqlaux);
        $qtdDest = pg_fetch_result($sqlaux, 0, "quant");

        $globalizado = 0;

        // Se forem 5 ou mais destinatarios transforma o CT-e em Globalizado
        if ($qtdDest >= 5) {

            // Grava os Dados do Emitente nos Campos do Destinatário

            $cadastro->altera("cte", "
			cteglobalizado='1',
			ctedespessoa='$emipessoa',
			ctedescnpj='$emicnpj',
			ctedesie='$emiie',
			ctedescpf='$emicpf',
			ctedesrg='$emirg',
			ctedesnguerra='$eminguerra',
			ctedesrazao='DIVERSOS',
			ctedescep='$emicep',
			ctedesendereco='$emiendereco',
			ctedesnumero='$eminumero',
			ctedessuframa='',
			ctedesbairro='$emibairro',
			ctedescomplemento='$emicomplemento',
			ctedesfone='$emifone',
			ctedespais='$emipais',
			ctedesuf='$emiuf',
			ctedescidcodigo='$emicidcodigo',
			ctedescidcodigoibge='$emicidcodigoibge'"
                    , "ctenumero=$pedido");

            $globalizado = 1;
        }

        $xml .= "<dados>\n";
        $xml .= "<dado>\n";
        $xml .= "<pvnumero>" . $orc_max . "</pvnumero>\n";
        $xml .= "<ctenumero>" . $orc_numero . "</ctenumero>\n";
        $xml .= "<globalizado>" . $globalizado . "</globalizado>\n";
        $xml .= "</dado>\n";
        $xml .= "</dados>\n";

        echo $xml;
    }
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