<?php

require_once('./include/config.php');
require_once("include/conexao.inc.php");

$parametro = trim($_POST["parametro"]);

$sql = "SELECT a.pvnumero FROM pvendafinalizado a
  Where a.pvnumero = '$parametro'
  ORDER BY a.pvnumero";


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

        $pvnumero = pg_fetch_result($sql, $i, "pvnumero");

        if (trim($pvnumero) == "") {
            $pvnumero = "0";
        }

        $xml .= "<dado>\n";
        $xml .= "<pvnumero>" . $pvnumero . "</pvnumero>\n";
        $xml .= "</dado>\n";
    }//FECHA FOR

    $xml .= "</dados>\n";

    //CABEÇALHO

    Header("Content-type: application/xml; charset=iso-8859-1");
}//FECHA IF (row)
else {

    //Verifica se tem itens saindo do estoque da matriz
    if (MAX_NOVO == 1) {
        $sql = "SELECT a.pvnumero FROM pvitem a Where a.pvnumero = '$parametro' and pviest01 > 0";
    } else {
        $sql = "SELECT a.pvnumero FROM pvitem a Where a.pvnumero = '$parametro' and pviest026 > 0";
    }

    //EXECUTA A QUERY
    $sql = pg_query($sql);

    $row = pg_num_rows($sql);

    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $xml .= "<dados>\n";
    $xml .= "<dado>\n";

    //VERIFICA SE VOLTOU ALGO
    if ($row) {
        $xml .= "<pvnumero>1</pvnumero>\n";
    } else {
        $xml .= "<pvnumero>2</pvnumero>\n";
    }

    $xml .= "</dado>\n";
    $xml .= "</dados>\n";

    Header("Content-type: application/xml; charset=iso-8859-1");
}

echo $xml;

