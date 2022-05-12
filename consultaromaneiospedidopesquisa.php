<?php

require_once("include/conexao.inc.php");
require_once("include/conferencia.php");

//RECEBE PARÃMETRO

$parametro = trim($_POST["parametro"]);

$cadastro = new banco($conn, $db);

$sql = "SELECT
  a.pvemissao,(select d.clirazao from clientes d where  a.clicodigo = d.clicodigo) as clinguerra
  ,a.pvnumero
  ,c.romnumero,c.romdata,c.romano,c.rombaixa,e.veimodelo,e.veiplaca
  FROM  pvenda a
  Left Join romaneiospedidos as b on a.pvnumero = b.pvnumero
  Left Join romaneios as c on c.romcodigo = b.romcodigo
  Left Join veiculos as e on e.veicodigo = c.romveiculo
  Where a.pvnumero = '$parametro'
  ORDER BY a.pvnumero";

//  LEft Join clientes as b on a.clicodigo = b.clicodigo
//EXECUTA A QUERY
$sql = pg_query($sql);

$row = pg_num_rows($sql);

if ($row) {

    //XML
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $xml .= "<dados>\n";

    //PERCORRE ARRAY
    for ($i = 0; $i < $row; $i++) {



        $pvnumero = pg_fetch_result($sql, $i, "pvnumero");
        $pvemissao = pg_fetch_result($sql, $i, "pvemissao");
        $clinguerra = pg_fetch_result($sql, $i, "clinguerra");

        $romnumero = pg_fetch_result($sql, $i, "romnumero");
        $romdata = pg_fetch_result($sql, $i, "romdata");
        $romano = pg_fetch_result($sql, $i, "romano");
        $rombaixa = pg_fetch_result($sql, $i, "rombaixa");

        $veimodelo = pg_fetch_result($sql, $i, "veimodelo");
        $veiplaca = pg_fetch_result($sql, $i, "veiplaca");

        if (trim($clinguerra) == "") {
            $clinguerra = $pvorigem;
        }
        if (trim($vennguerra) == "") {
            $vennguerra = $pvdestino;
        }
        if (trim($pvnumero) == "") {
            $pvnumero = "0";
        }
        if ($pvemissao <> "") {
            $pvemissao = substr($pvemissao, 8, 2) . '/' . substr($pvemissao, 5, 2) . '/' . substr($pvemissao, 0, 4);
        }
        if (trim($pvemissao) == "") {
            $pvemissao = "0";
        }
        if (trim($clinguerra) == "") {
            $clinguerra = "0";
        }

        if (trim($romnumero) == "") {
            $romnumero = "0";
        }
        if ($romdata <> "") {
            $romdata = substr($romdata, 8, 2) . '/' . substr($romdata, 5, 2) . '/' . substr($romdata, 0, 4);
        } else {
            $romdata = '__/__/____';
        }
        if (trim($romano) == "") {
            $romano = "0";
        }
        if ($rombaixa <> "") {
            $rombaixa = substr($rombaixa, 8, 2) . '/' . substr($rombaixa, 5, 2) . '/' . substr($rombaixa, 0, 4);
        } else {
            $rombaixa = '__/__/____';
        }
        if (trim($veimodelo) == "") {
            $veimodelo = "0";
        }
        if (trim($veiplaca) == "") {
            $veiplaca = "0";
        }

        $xml .= "<dado>\n";
        $xml .= "<pvnumero>" . $pvnumero . "</pvnumero>\n";
        $xml .= "<pvemissao>" . $pvemissao . "</pvemissao>\n";
        $xml .= "<clinguerra>" . $clinguerra . "</clinguerra>\n";

        $xml .= "<romnumero>" . $romnumero . "</romnumero>\n";
        $xml .= "<romdata>" . $romdata . "</romdata>\n";
        $xml .= "<romano>" . $romano . "</romano>\n";
        $xml .= "<rombaixa>" . $rombaixa . "</rombaixa>\n";
        $xml .= "<veimodelo>" . $veimodelo . "</veimodelo>\n";
        $xml .= "<veiplaca>" . $veiplaca . "</veiplaca>\n";

        $xml .= "</dado>\n";
    }//FECHA FOR

    $xml .= "</dados>\n";

    //CABEÇALHO

    Header("Content-type: application/xml; charset=iso-8859-1");
}//FECHA IF (row)
//PRINTA O RESULTADO
echo $xml;
?>
