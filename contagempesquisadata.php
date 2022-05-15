<?php

require_once("include/conexao.inc.php");
require_once("include/banco.php");


$parametro = trim($_POST["parametro"]);

$cadastro = new banco($conn, $db);

$sql = "SELECT
  a.invdata
  FROM  inventariocontagem a 
  Where a.invstatus = '0' 
  limit 1";


//EXECUTA A QUERY
$sql = pg_query($sql);

$row = pg_num_rows($sql);

if ($row) {

    //XML
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $xml .= "<dados>\n";

    //PERCORRE ARRAY
    for ($i = 0; $i < $row; $i++) {


        $pvemissao = pg_fetch_result($sql, $i, "invdata");

        if ($pvemissao <> "") {
            $pvemissao = substr($pvemissao, 8, 2) . '/' . substr($pvemissao, 5, 2) . '/' . substr($pvemissao, 0, 4);
        }

        if (trim($pvemissao) == "") {
            $pvemissao = "0";
        }

        $xml .= "<dado>\n";
        $xml .= "<pvemissao>" . $pvemissao . "</pvemissao>\n";
        $xml .= "</dado>\n";
    }//FECHA FOR

    $xml .= "</dados>\n";

    //CABEÇALHO

    Header("Content-type: application/xml; charset=iso-8859-1");
}//FECHA IF (row)
else {

    //XML
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $xml .= "<dados>\n";

    $pvemissao = "0";

    $xml .= "<dado>\n";
    $xml .= "<pvemissao>" . $pvemissao . "</pvemissao>\n";
    $xml .= "</dado>\n";

    $xml .= "</dados>\n";

    //CABEÇALHO

    Header("Content-type: application/xml; charset=iso-8859-1");
}

//PRINTA O RESULTADO
echo $xml;
?>
