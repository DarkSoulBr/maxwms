<?php

require_once("include/conexao.inc.php");
require_once("include/romaneiosbaixa2.php");

$romcodigo = $_REQUEST["romcodigo"];
$rombaixa = $_REQUEST["baixa"];
$final = $_REQUEST["final"];
$romnumeroano = trim($_REQUEST["romnumeroano"]);

$campo1 = $_REQUEST["c"];
$campo2 = $_REQUEST["d"];
$campo3 = $_REQUEST["e"];
$campo4 = $_REQUEST["f"];
$campo5 = $_REQUEST["g"];

$cadastro = new banco($conn, $db);

for ($i = 0; $i < sizeof($campo1); $i++) {

    if (trim($campo4[$i]) != 0) {
        $romdata = "'" . substr($campo4[$i], 3, 2) . "/" . substr($campo4[$i], 0, 2) . "/" . substr($campo4[$i], 6, 4) . "'";
    } else {
        $romdata = 'null';
    }

    $romobs = $campo3[$i];
    if ($romobs == '0' || $romobs == '') {
        $romobs = 'null';
    } else {
        $romobs = "'" . $romobs . "'";
    }

    $romrecebe = $campo5[$i];
    if ($romrecebe == '0' || $romrecebe == '') {
        $romrecebe = 'null';
    } else {
        $romrecebe = "'" . $romrecebe . "'";
    }

    $cadastro->altera("romaneiospedidos", "romflag='$campo2[$i]',romobs=$romobs,romdata=$romdata,romrecebedor=$romrecebe", "$romcodigo", "$campo1[$i]");

    //Se tiver data de Entrega atualiza a Tabela Pvenda
    if (trim($campo4[$i]) != 0) {

        $aux_dt = substr($campo4[$i], 6, 4) . '-' . substr($campo4[$i], 3, 2) . "-" . substr($campo4[$i], 0, 2);
        $aux_hr = '00:00';
        $aux_pv = $campo1[$i];

        $sql2 = "UPDATE pvenda SET pvdataentrega='{$aux_dt}',pvhoraentrega='{$aux_hr}',pvflagentrega=8 WHERE pvnumero = '{$aux_pv}'";
        pg_query($sql2);
    }
}

$rombaixa = substr($rombaixa, 6, 4) . '-' . substr($rombaixa, 3, 2) . '-' . substr($rombaixa, 0, 2);

$cadastro = new banco($conn, $db);
$cadastro->alteraromaneio("romaneios", "rombaixa='$rombaixa',romfinal='$final'", "$romcodigo");

pg_close($conn);

$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
$xml .= "<dados>\n";
$xml .= "<dado>\n";
$xml .= "<retorno>1</retorno>\n";
$xml .= "</dado>\n";
$xml .= "</dados>\n";
Header("Content-type: application/xml; charset=iso-8859-1");

//PRINTA O RESULTADO
echo $xml;




