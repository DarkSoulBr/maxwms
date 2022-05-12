<?php

require_once("include/conexao.inc.php");
require_once("include/romaneios.php");

$cadastro = new banco($conn, $db);
$pesquisa = $_POST["parametro"];

$pesquisa = "      " . $pesquisa;

$pesquisa1 = trim(substr($pesquisa, -12, 7));
$pesquisa2 = substr($pesquisa, -4, 4);


$sql = "SELECT a.romcodigo as codigo,
        romveiculo,
        romdata,
        romsaida,
        rommotorista,
        romajudante,
        rominicial,
        romfinal,
        romtipofrete,
        romobservacao,
        romvalor,
        rompercentual,
        romemissor,
        f.forcod,
        tracodigo
        FROM romaneios a
        LEFT JOIN fornecedor f ON a.forcodigo = f.forcodigo
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
        $romveiculo = pg_fetch_result($sql, $i, "romveiculo");
        $romdata = pg_fetch_result($sql, $i, "romdata");
        $romsaida = pg_fetch_result($sql, $i, "romsaida");
        $rommotorista = pg_fetch_result($sql, $i, "rommotorista");
        $romajudante = pg_fetch_result($sql, $i, "romajudante");
        $rominicial = pg_fetch_result($sql, $i, "rominicial");
        $romfinal = pg_fetch_result($sql, $i, "romfinal");
        $romtipofrete = pg_fetch_result($sql, $i, "romtipofrete");
        $romobservacao = pg_fetch_result($sql, $i, "romobservacao");

        $romvalor = pg_fetch_result($sql, $i, "romvalor");
        $rompercentual = pg_fetch_result($sql, $i, "rompercentual");
        $romemissor = trim(pg_fetch_result($sql, $i, "romemissor"));

        $forcod = pg_fetch_result($sql, $i, "forcod");
        $tracodigo = pg_fetch_result($sql, $i, "tracodigo");


        if (trim($codigo) == "") {
            $codigo = "0";
        }
        if (trim($romveiculo) == "") {
            $romveiculo = "0";
        }
        if (trim($romdata) == "") {
            $romdata = "2000-01-01";
        }

        $romdata = substr($romdata, 8, 2) . '/' . substr($romdata, 5, 2) . '/' . substr($romdata, 0, 4);

        if (trim($romsaida) == "") {
            $romsaida = "0";
        }
        if (trim($rommotorista) == "") {
            $rommotorista = "0";
        }
        if (trim($romajudante) == "") {
            $romajudante = "0";
        }
        if (trim($rominicial) == "") {
            $rominicial = "0";
        }
        if (trim($romfinal) == "") {
            $romfinal = "0";
        }
        if (trim($romobservacao) == "") {
            $romobservacao = "0";
        }
        if (trim($romvalor) == "") {
            $romvalor = "0";
        }
        if (trim($rompercentual) == "") {
            $rompercentual = "0";
        }
        if (trim($forcod) == "") {
            $forcod = "0";
        }
        if (trim($tracodigo) == "") {
            $tracodigo = "0";
        }
        if (trim($romemissor) == "") {
            $romemissor = "0";
        }
        if (trim($romtipofrete) == "") {
            $romtipofrete = "1";
        }

        $xml .= "<dado>\n";
        $xml .= "<codigo>" . $codigo . "</codigo>\n";
        $xml .= "<romveiculo>" . $romveiculo . "</romveiculo>\n";
        $xml .= "<romdata>" . $romdata . "</romdata>\n";
        $xml .= "<romsaida>" . $romsaida . "</romsaida>\n";
        $xml .= "<rommotorista>" . $rommotorista . "</rommotorista>\n";
        $xml .= "<romajudante>" . $romajudante . "</romajudante>\n";
        $xml .= "<rominicial>" . $rominicial . "</rominicial>\n";
        $xml .= "<romfinal>" . $romfinal . "</romfinal>\n";
        $xml .= "<romtipofrete>" . $romtipofrete . "</romtipofrete>\n";
        $xml .= "<romobservacao>" . $romobservacao . "</romobservacao>\n";
        $xml .= "<romvalor>" . $romvalor . "</romvalor>\n";
        $xml .= "<rompercentual>" . $rompercentual . "</rompercentual>\n";
        $xml .= "<forn>" . $forcod . "</forn>\n";
        $xml .= "<transp>" . $tracodigo . "</transp>\n";
        $xml .= "<romemissor>" . $romemissor . "</romemissor>\n";
        $xml .= "</dado>\n";
    }//FECHA FOR

    $xml .= "</dados>\n";

    //CABEÇALHO
    Header("Content-type: application/xml; charset=iso-8859-1");
}//FECHA IF (row)
//PRINTA O RESULTADO
echo $xml;
?>
