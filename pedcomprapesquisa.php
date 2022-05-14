<?php
/**
* Pesquisa de Pedidos de Compras
*
* Programa que busca Pedidos de Compra na Base de Dados e retorna um XML com os dados
*
* @name Compra Search
* @link pedcomprapesquisa.php
* @version 50.3.6
* @since 1.0.0
* @author Luis Ramires <delta.mais@uol.com.br>
* @copyright MaxTrade
*
* @global integer $_POST["parametro"] Numero do Pedido
*/

require_once("include/conexao.inc.php");
require_once("include/pedcompra.php");

//RECEBE PARAMETRO

$parametro = trim($_POST["parametro"]);

$cadastro = new banco($conn, $db);

$sql = "SELECT
  a.pcnumero,a.pcemissao,a.pcentrega,a.pcchegada,b.forrazao as fornguerra,a.forcodigo,b.forcod,a.comprador,a.pcprocesso,a.condicao,
  a.observacao1,a.observacao2,a.observacao3,a.observacao4,a.observacao5,a.comissao,a.total,a.ipi,a.desconto,a.perdesconto
  ,a.tipo,a.localentrega,a.tipoped
  
  ,a.tipoparcelas,a.parcelas,
  a.parcdia1,a.parcdia2,a.parcdia3,a.parcdia4,a.parcdia5,a.parcdia6,
  a.parcdata1,a.parcdata2,a.parcdata3,a.parcdata4,a.parcdata5,a.parcdata6,
  a.parcela1,a.parcela2,a.parcela3,a.parcela4,a.parcela5,a.parcela6,a.pvnumero,a.pccontainers,a.pcempresa 
  
  FROM  pcompra a
  LEft Join fornecedor as b on a.forcodigo = b.forcodigo
  Where a.pcnumero = '$parametro'
  ORDER BY a.pcnumero";

//EXECUTA A QUERY
$sql = pg_query($sql);

$row = pg_num_rows($sql);

if ($row) {

    //XML
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $xml .= "<dados>\n";

    //PERCORRE ARRAY
    for ($i = 0; $i < $row; $i++) {

        $pcnumero = pg_fetch_result($sql, $i, "pcnumero");
        $pcemissao = pg_fetch_result($sql, $i, "pcemissao");
        $pcentrega = pg_fetch_result($sql, $i, "pcentrega");
        $pcchegada = pg_fetch_result($sql, $i, "pcchegada");
        $fornguerra = pg_fetch_result($sql, $i, "fornguerra");
        $forcodigo = pg_fetch_result($sql, $i, "forcodigo");
        $forcod = pg_fetch_result($sql, $i, "forcod");
        $comprador = pg_fetch_result($sql, $i, "comprador");
        $pcprocesso = pg_fetch_result($sql, $i, "pcprocesso");
        $pccontainers = pg_fetch_result($sql, $i, "pccontainers");
        $condicao = pg_fetch_result($sql, $i, "condicao");
        $observacao1 = pg_fetch_result($sql, $i, "observacao1");
        $observacao2 = pg_fetch_result($sql, $i, "observacao2");
        $observacao3 = pg_fetch_result($sql, $i, "observacao3");

        $observacao4 = pg_fetch_result($sql, $i, "observacao4");
        $observacao5 = pg_fetch_result($sql, $i, "observacao5");

        $comissao = pg_fetch_result($sql, $i, "comissao");
        $total = pg_fetch_result($sql, $i, "total");
        $ipi = pg_fetch_result($sql, $i, "ipi");
        $desconto = pg_fetch_result($sql, $i, "desconto");
        $perdesconto = pg_fetch_result($sql, $i, "perdesconto");

        $tipo = pg_fetch_result($sql, $i, "tipo");
        $localentrega = pg_fetch_result($sql, $i, "localentrega");
        $tipoped = pg_fetch_result($sql, $i, "tipoped");

        $tipoparcelas = pg_fetch_result($sql, $i, "tipoparcelas");
        $parcelas = pg_fetch_result($sql, $i, "parcelas");
        $parcdia1 = pg_fetch_result($sql, $i, "parcdia1");
        $parcdia2 = pg_fetch_result($sql, $i, "parcdia2");
        $parcdia3 = pg_fetch_result($sql, $i, "parcdia3");
        $parcdia4 = pg_fetch_result($sql, $i, "parcdia4");
        $parcdia5 = pg_fetch_result($sql, $i, "parcdia5");
        $parcdia6 = pg_fetch_result($sql, $i, "parcdia6");
        $parcdata1 = pg_fetch_result($sql, $i, "parcdata1");
        $parcdata2 = pg_fetch_result($sql, $i, "parcdata2");
        $parcdata3 = pg_fetch_result($sql, $i, "parcdata3");
        $parcdata4 = pg_fetch_result($sql, $i, "parcdata4");
        $parcdata5 = pg_fetch_result($sql, $i, "parcdata5");
        $parcdata6 = pg_fetch_result($sql, $i, "parcdata6");
        $parcela1 = pg_fetch_result($sql, $i, "parcela1");
        $parcela2 = pg_fetch_result($sql, $i, "parcela2");
        $parcela3 = pg_fetch_result($sql, $i, "parcela3");
        $parcela4 = pg_fetch_result($sql, $i, "parcela4");
        $parcela5 = pg_fetch_result($sql, $i, "parcela5");
        $parcela6 = pg_fetch_result($sql, $i, "parcela6");

        $pvnumero = pg_fetch_result($sql, $i, "pvnumero");
        $pcempresa = pg_fetch_result($sql, $i, "pcempresa");


        if (trim($pcnumero) == "") {
            $pcnumero = "0";
        }
        if ($pcemissao <> "") {
            $pcemissao = substr($pcemissao, 8, 2) . '/' . substr($pcemissao, 5, 2) . '/' . substr($pcemissao, 0, 4);
        }
        if ($pcentrega <> "") {
            $pcentrega = substr($pcentrega, 8, 2) . '/' . substr($pcentrega, 5, 2) . '/' . substr($pcentrega, 0, 4);
        }
        if ($pcchegada <> "") {
            $pcchegada = substr($pcchegada, 8, 2) . '/' . substr($pcchegada, 5, 2) . '/' . substr($pcchegada, 0, 4);
        }
        else {
            $pcchegada = "0";
        }
        if (trim($pcemissao) == "") {
            $pcemissao = "0";
        }
        if (trim($pcentrega) == "") {
            $pcentrega = "0";
        }
        if (trim($fornguerra) == "") {
            $fornguerra = "0";
        }
        if (trim($forcodigo) == "") {
            $forcodigo = "0";
        }
        if (trim($forcod) == "") {
            $forcod = "0";
        }
        if (trim($comprador) == "") {
            $comprador = "0";
        }
        if (trim($pcprocesso) == "") {
            $pcprocesso = "0";
        }
        if (trim($pccontainers) == "") {
            $pccontainers = "0";
        }
        if (trim($condicao) == "") {
            $condicao = "0";
        }
        if (trim($observacao1) == "") {
            $observacao1 = "0";
        }
        if (trim($observacao2) == "") {
            $observacao2 = "0";
        }
        if (trim($observacao3) == "") {
            $observacao3 = "0";
        }

        if (trim($observacao4) == "") {
            $observacao4 = "0";
        }
        if (trim($observacao5) == "") {
            $observacao5 = "0";
        }

        if (trim($comissao) == "") {
            $comissao = "0";
        }
        if (trim($total) == "") {
            $total = "0";
        }
        if (trim($ipi) == "") {
            $ipi = "0";
        }
        if (trim($desconto) == "") {
            $desconto = "0";
        }
        if (trim($perdesconto) == "") {
            $perdesconto = "0";
        }

        if (trim($tipo) == "") {
            $tipo = "0";
        }
        if (trim($localentrega) == "") {
            $localentrega = "0";
        }
        if (trim($tipoped) == "") {
            $tipoped = "0";
        }

        if (trim($tipoparcelas) == "") {
            $tipoparcelas = "0";
        }
        if (trim($parcelas) == "") {
            $parcelas = "0";
        }
        if (trim($parcdia1) == "") {
            $parcdia1 = "0";
        }
        if (trim($parcdia2) == "") {
            $parcdia2 = "0";
        }
        if (trim($parcdia3) == "") {
            $parcdia3 = "0";
        }
        if (trim($parcdia4) == "") {
            $parcdia4 = "0";
        }
        if (trim($parcdia5) == "") {
            $parcdia5 = "0";
        }
        if (trim($parcdia6) == "") {
            $parcdia6 = "0";
        }

        if ($parcdata1 <> "") {
            $parcdata1 = substr($parcdata1, 8, 2) . '/' . substr($parcdata1, 5, 2) . '/' . substr($parcdata1, 0, 4);
        } else {
            $parcdata1 = '__/__/____';
        }
        if ($parcdata2 <> "") {
            $parcdata2 = substr($parcdata2, 8, 2) . '/' . substr($parcdata2, 5, 2) . '/' . substr($parcdata2, 0, 4);
        } else {
            $parcdata2 = '__/__/____';
        }
        if ($parcdata3 <> "") {
            $parcdata3 = substr($parcdata3, 8, 2) . '/' . substr($parcdata3, 5, 2) . '/' . substr($parcdata3, 0, 4);
        } else {
            $parcdata3 = '__/__/____';
        }
        if ($parcdata4 <> "") {
            $parcdata4 = substr($parcdata4, 8, 2) . '/' . substr($parcdata4, 5, 2) . '/' . substr($parcdata4, 0, 4);
        } else {
            $parcdata4 = '__/__/____';
        }
        if ($parcdata5 <> "") {
            $parcdata5 = substr($parcdata5, 8, 2) . '/' . substr($parcdata5, 5, 2) . '/' . substr($parcdata5, 0, 4);
        } else {
            $parcdata5 = '__/__/____';
        }
        if ($parcdata6 <> "") {
            $parcdata6 = substr($parcdata6, 8, 2) . '/' . substr($parcdata6, 5, 2) . '/' . substr($parcdata6, 0, 4);
        } else {
            $parcdata6 = '__/__/____';
        }

        if (trim($parcela1) == "") {
            $parcela1 = "0";
        }
        if (trim($parcela2) == "") {
            $parcela2 = "0";
        }
        if (trim($parcela3) == "") {
            $parcela3 = "0";
        }
        if (trim($parcela4) == "") {
            $parcela4 = "0";
        }
        if (trim($parcela5) == "") {
            $parcela5 = "0";
        }
        if (trim($parcela6) == "") {
            $parcela6 = "0";
        }

        if (trim($pvnumero) == "") {
            $pvnumero = "0";
        }

        if (trim($pcempresa) == "") {
            $pcempresa = "0";
        }

        $xml .= "<dado>\n";
        $xml .= "<pcnumero>" . $pcnumero . "</pcnumero>\n";
        $xml .= "<pcemissao>" . $pcemissao . "</pcemissao>\n";
        $xml .= "<pcentrega>" . $pcentrega . "</pcentrega>\n";
        $xml .= "<pcchegada>" . $pcchegada . "</pcchegada>\n";
        $xml .= "<fornguerra>" . $fornguerra . "</fornguerra>\n";
        $xml .= "<forcodigo>" . $forcodigo . "</forcodigo>\n";
        $xml .= "<forcod>" . $forcod . "</forcod>\n";
        $xml .= "<comprador>" . $comprador . "</comprador>\n";
        $xml .= "<pcprocesso>" . $pcprocesso . "</pcprocesso>\n";
        $xml .= "<pccontainers>" . $pccontainers . "</pccontainers>\n";
        $xml .= "<condicao>" . $condicao . "</condicao>\n";
        $xml .= "<observacao1>" . $observacao1 . "</observacao1>\n";
        $xml .= "<observacao2>" . $observacao2 . "</observacao2>\n";
        $xml .= "<observacao3>" . $observacao3 . "</observacao3>\n";

        $xml .= "<observacao4>" . $observacao4 . "</observacao4>\n";
        $xml .= "<observacao5>" . $observacao5 . "</observacao5>\n";

        $xml .= "<comissao>" . $comissao . "</comissao>\n";
        $xml .= "<total>" . $total . "</total>\n";
        $xml .= "<ipi>" . $ipi . "</ipi>\n";
        $xml .= "<desconto>" . $desconto . "</desconto>\n";
        $xml .= "<perdesconto>" . $perdesconto . "</perdesconto>\n";

        $xml .= "<tipo>" . $tipo . "</tipo>\n";
        $xml .= "<localentrega>" . $localentrega . "</localentrega>\n";

        $xml .= "<tipoped>" . $tipoped . "</tipoped>\n";

        $xml .= "<tipoparcelas>" . $tipoparcelas . "</tipoparcelas>\n";
        $xml .= "<parcelas>" . $parcelas . "</parcelas>\n";
        $xml .= "<parcdia1>" . $parcdia1 . "</parcdia1>\n";
        $xml .= "<parcdia2>" . $parcdia2 . "</parcdia2>\n";
        $xml .= "<parcdia3>" . $parcdia3 . "</parcdia3>\n";
        $xml .= "<parcdia4>" . $parcdia4 . "</parcdia4>\n";
        $xml .= "<parcdia5>" . $parcdia5 . "</parcdia5>\n";
        $xml .= "<parcdia6>" . $parcdia6 . "</parcdia6>\n";
        $xml .= "<parcdata1>" . $parcdata1 . "</parcdata1>\n";
        $xml .= "<parcdata2>" . $parcdata2 . "</parcdata2>\n";
        $xml .= "<parcdata3>" . $parcdata3 . "</parcdata3>\n";
        $xml .= "<parcdata4>" . $parcdata4 . "</parcdata4>\n";
        $xml .= "<parcdata5>" . $parcdata5 . "</parcdata5>\n";
        $xml .= "<parcdata6>" . $parcdata6 . "</parcdata6>\n";
        $xml .= "<parcela1>" . $parcela1 . "</parcela1>\n";
        $xml .= "<parcela2>" . $parcela2 . "</parcela2>\n";
        $xml .= "<parcela3>" . $parcela3 . "</parcela3>\n";
        $xml .= "<parcela4>" . $parcela4 . "</parcela4>\n";
        $xml .= "<parcela5>" . $parcela5 . "</parcela5>\n";
        $xml .= "<parcela6>" . $parcela6 . "</parcela6>\n";
        $xml .= "<pvnumero>" . $pvnumero . "</pvnumero>\n";
        $xml .= "<pcempresa>" . $pcempresa . "</pcempresa>\n";

        $xml .= "</dado>\n";
    }//FECHA FOR

    $xml .= "</dados>\n";

    //CABECALHO

    Header("Content-type: application/xml; charset=iso-8859-1");
}//FECHA IF (row)
//PRINTA O RESULTADO
echo $xml;

