<?php

require_once("include/conexao.inc.php");

$nfe = $_GET['nfe'];

//Localiza as nfs
$sqlx = "Select a.ctenumero,b.ctenum,b.cteemissao from ctenfechave a, cte b where SUBSTRING(a.ctenfenome,26,9) = '$nfe' and a.ctenumero = b.ctenumero";
$cadx = pg_query($sqlx);
$rowx = pg_num_rows($cadx);

header("Content-type: application/xml");
$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";
$xml .= "<dados>";

if ($rowx > 0) {

    $ctenumero = pg_fetch_result($cadx, 0, "ctenumero");
    $ctenum = pg_fetch_result($cadx, 0, "ctenum");
    $emissao = pg_fetch_result($cadx, 0, "cteemissao");

    if ($ctenumero == '') {
        $ctenumero = '_';
    }
    if ($ctenum == '') {
        $ctenum = '_';
    }
    if ($emissao == "") {
        $emissao = "_";
    } else {
        $aux = explode(" ", $emissao);
        $aux1 = explode("-", $aux[0]);
        $emissao = $aux1[2] . '/' . $aux1[1] . '/' . $aux1[0];
    }

    $xml .= "<registro>";
    $xml .= "<item>" . $ctenumero . "</item>";
    $xml .= "<item>" . intval($ctenum) . "</item>";
    $xml .= "<item>" . $emissao . "</item>";
    $xml .= "</registro>";
} else {

    $xml .= "<registro>";
    $xml .= "<item>0</item>";
    $xml .= "<item>0</item>";
    $xml .= "<item>0</item>";
    $xml .= "</registro>";
}


$xml .= "</dados>";

echo $xml;
pg_close($conn);
?>
