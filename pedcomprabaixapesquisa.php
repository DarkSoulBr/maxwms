<?php

require_once("include/conexao.inc.php");

$parametro = trim($_POST["parametro"]);

$sql = "SELECT
        a.pcnumero,a.pcemissao,b.forrazao as fornguerra,a.forcodigo,a.comprador,a.condicao,a.pcempresa,
        a.observacao1,a.observacao2,a.observacao3,a.comissao,a.total,a.ipi,a.desconto,a.localentrega,c.icm,c.ipi as percipi 
        FROM  pcompra a
        LEFT JOIN fornecedor as b on a.forcodigo = b.forcodigo
        LEFT JOIN condicaopagto as c on a.forcodigo = c.forcodigo
        WHERE a.pcnumero = '$parametro'
        ORDER BY a.pcnumero";


$sql = pg_query($sql);

$row = pg_num_rows($sql);

if ($row) {

    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $xml .= "<dados>\n";

    for ($i = 0; $i < $row; $i++) {

        $pcnumero = pg_fetch_result($sql, $i, "pcnumero");
        $pcemissao = pg_fetch_result($sql, $i, "pcemissao");
        $fornguerra = pg_fetch_result($sql, $i, "fornguerra");
        $forcodigo = pg_fetch_result($sql, $i, "forcodigo");
        $comprador = pg_fetch_result($sql, $i, "comprador");
        $condicao = pg_fetch_result($sql, $i, "condicao");
        $observacao1 = pg_fetch_result($sql, $i, "observacao1");
        $observacao2 = pg_fetch_result($sql, $i, "observacao2");
        $observacao3 = pg_fetch_result($sql, $i, "observacao3");
        $comissao = pg_fetch_result($sql, $i, "comissao");
        $total = pg_fetch_result($sql, $i, "total");
        $ipi = pg_fetch_result($sql, $i, "ipi");
        $icm = pg_fetch_result($sql, $i, "icm");
        $percipi = pg_fetch_result($sql, $i, "percipi");
        $desconto = pg_fetch_result($sql, $i, "desconto");
        $localentrega = pg_fetch_result($sql, $i, "localentrega");
        $pcempresa = pg_fetch_result($sql, $i, "pcempresa");

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
        if (trim($percipi) == "") {
            $percipi = "0";
        }
        if (trim($icm) == "") {
            $icm = "0";
        }
        if (trim($desconto) == "") {
            $desconto = "0";
        }
        if (trim($localentrega) == "") {
            $localentrega = "0";
        }
        if (trim($pcempresa) == "") {
            $pcempresa = "0";
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
        $xml .= "<percipi>" . $percipi . "</percipi>\n";
        $xml .= "<icm>" . $icm . "</icm>\n";
        $xml .= "<pcempresa>" . $pcempresa . "</pcempresa>\n";
        $xml .= "</dado>\n";
    }

    $xml .= "</dados>\n";


    Header("Content-type: application/xml; charset=iso-8859-1");
}
echo $xml;
