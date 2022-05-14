<?php
require_once("include/conexao.inc.php");

//RECEBE PARAMETRO

$parametro = trim($_POST["parametro"]);

$sql = "SELECT a.pcnumero  
  FROM  pcompra a
  ORDER BY a.pcnumero desc limit 1";

$sql = pg_query($sql);

$row = pg_num_rows($sql);

if ($row) {

    //XML
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $xml .= "<dados>\n";

    //PERCORRE ARRAY
    for ($i = 0; $i < $row; $i++) {

        $pcnumero = pg_fetch_result($sql, $i, "pcnumero");

        $xml .= "<dado>\n";
        $xml .= "<pcnumero>" . $pcnumero . "</pcnumero>\n";
        $xml .= "</dado>\n";
    }//FECHA FOR

    $xml .= "</dados>\n";

    //CABECALHO

    Header("Content-type: application/xml; charset=iso-8859-1");
}//FECHA IF (row)
//PRINTA O RESULTADO
echo $xml;

