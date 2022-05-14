<?php

//RECEBE PARÃMETRO
$parametro = trim($_POST["parametro"]);

require_once("include/conexao.inc.php");
require_once("include/consultamovimentacao.php");

$cadastro = new banco($conn, $db);

//QUERY

$sql = "
SELECT p.procodigo,p.procod,p.prnome,p.prdescr
FROM  produto p
Where p.procodigo = '$parametro'";

//EXECUTA A QUERY
$sql = pg_query($sql);

$row = pg_num_rows($sql);

//VERIFICA SE VOLTOU ALGO

if ($row) {

    //XML
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $xml .= "<dados>\n";

    //PERCORRE ARRAY
    for ($i = 0; $i < $row; $i++) {


        $procodigo = pg_fetch_result($sql, $i, "procodigo");
        $procod = pg_fetch_result($sql, $i, "procod");
        $prnome = pg_fetch_result($sql, $i, "prnome");
        $prdescr = pg_fetch_result($sql, $i, "prdescr");

        if (trim($procodigo) == "") {
            $procodigo = "0";
        }
        if (trim($procod) == "") {
            $procod = "0";
        }
        if (trim($prnome) == "") {
            $prnome = "0";
        }
        if (trim($prdescr) == "") {
            $prdescr = "0";
        }

        $xml .= "<dado>\n";
        $xml .= "<procodigo>" . $procodigo . "</procodigo>\n";
        $xml .= "<procod>" . $procod . "</procod>\n";
        $xml .= "<prnome>" . $prnome . "</prnome>\n";
        $xml .= "<prdescr>" . $prdescr . "</prdescr>\n";
        $xml .= "</dado>\n";
    }//FECHA FOR

    $xml .= "</dados>\n";

    //CABEÇALHO
    Header("Content-type: application/xml; charset=iso-8859-1");
}//FECHA IF (row)
//PRINTA O RESULTADO
echo $xml;
?>
