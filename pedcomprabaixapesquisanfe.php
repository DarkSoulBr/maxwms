<?php

require_once("include/conexao.inc.php");
require_once("include/pedcompracons.php");

//RECEBE PARÃMETRO

$parametro = trim($_POST["parametro"]);
$parametro2 = trim($_POST["parametro2"]);
$parametro3 = trim($_POST["parametro3"]);

/*
  $parametro = 18597;
  $parametro2 = 242213;
  $parametro3 = 1;
 */

$cadastro = new banco($conn, $db);

$xml = "";

//Fase 1 - Localiza o CNPJ do Fornecedor a partir do pedido

$sql = "SELECT b.forcnpj  
  FROM  pcompra a
  LEft Join fornecedor as b on a.forcodigo = b.forcodigo
  Where a.pcnumero = '$parametro'";

//EXECUTA A QUERY
$sql = pg_query($sql);

$row = pg_num_rows($sql);

$forcnpj = "";

if ($row) {
    $forcnpj = pg_fetch_result($sql, $i, "forcnpj");
}

//Tira os pontos do cnpj
$caracteres = 0;
$caracteres += strlen($forcnpj);
$vai = '';
$i = 0;
for ($i = 0; $i < $caracteres; $i++) {
    if (is_numeric(substr($forcnpj, $i, 1))) {
        $vai = $vai . substr($forcnpj, $i, 1);
    }
}
$forcnpj = $vai;

//echo $forcnpj;
//Fase 2 - Localiza a Nota Fiscal Eletronica

$sql = "SELECT a.nfedemi,a.nfevprod,a.nfevbc,a.nfevicms,a.nfevipi,a.nfevnf,a.nfetraqvol,a.nfeinfcpl,a.nfevbcst,a.nfevst,a.nfecodigo 
		from nfe a where a.nfenumero = '$parametro2' and a.nfeserie = '$parametro3'  and a.nfecnpj = '$forcnpj'";

//EXECUTA A QUERY
$sql = pg_query($sql);

$row = pg_num_rows($sql);

if ($row) {

    //XML
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $xml .= "<dados>\n";

    //PERCORRE ARRAY
    for ($i = 0; $i < $row; $i++) {

        $notentemissao = pg_fetch_result($sql, $i, "nfedemi");
        $notentprodutos = pg_fetch_result($sql, $i, "nfevprod");
        $notentbaseicm = pg_fetch_result($sql, $i, "nfevbc");
        $notentvaloricm = pg_fetch_result($sql, $i, "nfevicms");
        $notentvaloripi = pg_fetch_result($sql, $i, "nfevipi");
        $notentvalor = pg_fetch_result($sql, $i, "nfevnf");
        $notentvolumes = pg_fetch_result($sql, $i, "nfetraqvol");
        $notentobservacoes = pg_fetch_result($sql, $i, "nfeinfcpl");
        $notbasesubst = pg_fetch_result($sql, $i, "nfevbcst");
        $notvalorsubst = pg_fetch_result($sql, $i, "nfevst");
        $nfecodigo = pg_fetch_result($sql, $i, "nfecodigo");

        if ($notentemissao <> "") {
            $notentemissao = substr($notentemissao, 8, 2) . '/' . substr($notentemissao, 5, 2) . '/' . substr($notentemissao, 0, 4);
        }
        if (trim($notentprodutos) == "") {
            $notentprodutos = "0";
        }
        if (trim($notentbaseicm) == "") {
            $notentbaseicm = "0";
        }
        if (trim($notentvaloricm) == "") {
            $notentvaloricm = "0";
        }
        if (trim($notentvaloripi) == "") {
            $notentvaloripi = "0";
        }
        if (trim($notentvalor) == "") {
            $notentvalor = "0";
        }
        if (trim($notentvolumes) == "") {
            $notentvolumes = "0";
        }
        if (trim($notentobservacoes) == "") {
            $notentobservacoes = "0";
        }
        if (trim($notbasesubst) == "") {
            $notbasesubst = "0";
        }
        if (trim($notvalorsubst) == "") {
            $notvalorsubst = "0";
        }
        if (trim($nfecodigo) == "") {
            $nfecodigo = "0";
        }

        $xml .= "<dado>\n";
        $xml .= "<notentemissao>" . $notentemissao . "</notentemissao>\n";
        $xml .= "<notentprodutos>" . $notentprodutos . "</notentprodutos>\n";
        $xml .= "<notentbaseicm>" . $notentbaseicm . "</notentbaseicm>\n";
        $xml .= "<notentvaloricm>" . $notentvaloricm . "</notentvaloricm>\n";
        $xml .= "<notentvaloripi>" . $notentvaloripi . "</notentvaloripi>\n";
        $xml .= "<notentvalor>" . $notentvalor . "</notentvalor>\n";
        $xml .= "<notentvolumes>" . $notentvolumes . "</notentvolumes>\n";
        $xml .= "<notentobservacoes>" . $notentobservacoes . "</notentobservacoes>\n";
        $xml .= "<notbasesubst>" . $notbasesubst . "</notbasesubst>\n";
        $xml .= "<notvalorsubst>" . $notvalorsubst . "</notvalorsubst>\n";
        $xml .= "<nfecodigo>" . $nfecodigo . "</nfecodigo>\n";

        $xml .= "</dado>\n";
    }//FECHA FOR

    $xml .= "</dados>\n";

    //CABEÇALHO

    Header("Content-type: application/xml; charset=iso-8859-1");
}//FECHA IF (row)
//PRINTA O RESULTADO
echo $xml;
?>
