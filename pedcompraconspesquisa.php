<?php

require('./_app/Config.inc.php');

$parametro = trim($_POST["parametro"]);


$sql = "SELECT a.pcnumero,a.pcemissao,b.forrazao as fornguerra,a.forcodigo,a.comprador,a.condicao,
  a.observacao1,a.observacao2,a.observacao3,a.comissao,a.total,a.ipi,a.desconto,a.localentrega 
  FROM  pcompra a
  LEft JOIN fornecedor as b on a.forcodigo = b.forcodigo
  WHERE a.pcnumero = '$parametro'
  ORDER BY a.pcnumero";


$read = new Read;
$read->FullRead($sql);

if ($read->getRowCount() >= 1) {

    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $xml .= "<dados>\n";


    foreach ($read->getResult() as $registros) {
        extract($registros);

        if (trim($pcnumero) == "") {
            $pcnumero = "0";
        }
        if ($pcemissao <> "") {
            $pcemissao = substr($pcemissao, 8, 2) . '/' . substr($pcemissao, 5, 2) . '/' . substr($pcemissao, 0, 4);
        }
        if (trim($pcemissao) == "") {
            $pcemissao = "0";
        }
        if (trim($fornguerra) == "") {
            $fornguerra = "0";
        }
        if (trim($forcodigo) == "") {
            $forcodigo = "0";
        }
        if (trim($comprador) == "") {
            $comprador = "0";
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

        if (trim($localentrega) == "") {
            $localentrega = "0";
        }

        $xml .= "<dado>\n";
        $xml .= "<pcnumero>" . $pcnumero . "</pcnumero>\n";
        $xml .= "<pcemissao>" . $pcemissao . "</pcemissao>\n";
        $xml .= "<fornguerra>" . $fornguerra . "</fornguerra>\n";
        $xml .= "<forcodigo>" . $forcodigo . "</forcodigo>\n";
        $xml .= "<comprador>" . $comprador . "</comprador>\n";
        $xml .= "<condicao>" . $condicao . "</condicao>\n";
        $xml .= "<observacao1>" . $observacao1 . "</observacao1>\n";
        $xml .= "<observacao2>" . $observacao2 . "</observacao2>\n";
        $xml .= "<observacao3>" . $observacao3 . "</observacao3>\n";
        $xml .= "<comissao>" . $comissao . "</comissao>\n";
        $xml .= "<total>" . $total . "</total>\n";
        $xml .= "<ipi>" . $ipi . "</ipi>\n";
        $xml .= "<desconto>" . $desconto . "</desconto>\n";
        $xml .= "<localentrega>" . $localentrega . "</localentrega>\n";
        $xml .= "</dado>\n";
    }

    $xml .= "</dados>\n";

    Header("Content-type: application/xml; charset=iso-8859-1");
}
$read = null;
echo $xml;

