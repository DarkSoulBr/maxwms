<?php

require_once("include/conexao.inc.php");
require_once("include/romaneiosbaixa.php");

$cadastro = new banco($conn, $db);
$pesquisa = $_POST["parametro"];

$pesquisa = "      " . $pesquisa;

$pesquisa1 = trim(substr($pesquisa, -12, 7));
$pesquisa2 = substr($pesquisa, -4, 4);


$sql = "SELECT a.romcodigo as codigo,
        rombaixa,
        romdata
        FROM romaneios a
        WHERE a.romnumero = '$pesquisa1'
	AND a.romano = '$pesquisa2'
        order by a.romcodigo";


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

        $codigo = pg_fetch_result($sql, $i, "codigo");
        $rombaixa = pg_fetch_result($sql, $i, "rombaixa");
        $romdata = pg_fetch_result($sql, $i, "romdata");



        if (trim($codigo) == "") {
            $codigo = "0";
        }
        if (trim($rombaixa) == "") {
            $rombaixa = "0";
        }
        if (trim($romdata) == "") {
            $romdata = "2000-01-01";
        }

        $romdata = substr($romdata, 8, 2) . '/' . substr($romdata, 5, 2) . '/' . substr($romdata, 0, 4);


        $xml .= "<dado>\n";
        $xml .= "<codigo>" . $codigo . "</codigo>\n";
        $xml .= "<rombaixa>" . $rombaixa . "</rombaixa>\n";
        $xml .= "<romdata>" . $romdata . "</romdata>\n";
        $xml .= "</dado>\n";
    }//FECHA FOR

    $xml .= "</dados>\n";

    //CABEÇALHO
    Header("Content-type: application/xml; charset=iso-8859-1");
}//FECHA IF (row)
//PRINTA O RESULTADO
echo $xml;
?>
