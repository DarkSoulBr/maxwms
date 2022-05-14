<?php

require_once("include/conexao.inc.php");
require_once("include/pedcompracons.php");

//RECEBE PARÃMETRO

$parametro = trim($_POST["parametro"]);
$parametro2 = trim($_POST["parametro2"]);


$cadastro = new banco($conn, $db);


$sql = "SELECT
  b.forrazao as fornguerra,a.comprador,a.condicao,c.notentdata,
  c.notentemissao,c.notentnumero,c.notentcpof,c.notentvalor,
  c.notentprodutos,c.notenticm,c.notentbaseicm,c.notentvaloricm,
  c.notentisentas,c.notentoutras,c.notentbaseipi,c.notentpercipi,
  c.notentvaloripi,c.notentobservacoes,c.notatualiza,c.notentcodigo,c.notentserie,c.deposito
  FROM  notaent c, pcompra a
  LEft Join fornecedor as b on a.forcodigo = b.forcodigo
  Where c.pcnumero = '$parametro'
  and a.pcnumero = c.pcnumero
  and c.notentseqbaixa = '$parametro2'";


//EXECUTA A QUERY
$sql = pg_query($sql);

$row = pg_num_rows($sql);

if ($row) {

    //XML
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $xml .= "<dados>\n";

    //PERCORRE ARRAY
    for ($i = 0; $i < $row; $i++) {

        $fornguerra = pg_fetch_result($sql, $i, "fornguerra");
        $comprador = pg_fetch_result($sql, $i, "comprador");
        $deposito = pg_fetch_result($sql, $i, "deposito");
        $notentdata = pg_fetch_result($sql, $i, "notentdata");
        $notentemissao = pg_fetch_result($sql, $i, "notentemissao");
        $notentnumero = pg_fetch_result($sql, $i, "notentnumero");
        $notentcpof = pg_fetch_result($sql, $i, "notentcpof");
        $notentvalor = pg_fetch_result($sql, $i, "notentvalor");
        $notentprodutos = pg_fetch_result($sql, $i, "notentprodutos");
        $notenticm = pg_fetch_result($sql, $i, "notenticm");
        $notentbaseicm = pg_fetch_result($sql, $i, "notentbaseicm");
        $notentvaloricm = pg_fetch_result($sql, $i, "notentvaloricm");
        $notentisentas = pg_fetch_result($sql, $i, "notentisentas");
        $notentoutras = pg_fetch_result($sql, $i, "notentoutras");
        $notentbaseipi = pg_fetch_result($sql, $i, "notentbaseipi");
        $notentpercipi = pg_fetch_result($sql, $i, "notentpercipi");
        $notentvaloripi = pg_fetch_result($sql, $i, "notentvaloripi");
        $notentobservacoes = pg_fetch_result($sql, $i, "notentobservacoes");
        $notatualiza = pg_fetch_result($sql, $i, "notatualiza");

        $notentcodigo = pg_fetch_result($sql, $i, "notentcodigo");
        $notentserie = pg_fetch_result($sql, $i, "notentserie");

        if (trim($fornguerra) == "") {
            $fornguerra = "0";
        }
        if (trim($comprador) == "") {
            $comprador = "0";
        }
        if (trim($deposito) == "") {
            $deposito = "0";
        }

        if ($notentdata <> "") {
            $notentdata = substr($notentdata, 8, 2) . '/' . substr($notentdata, 5, 2) . '/' . substr($notentdata, 0, 4);
        }
        if ($notentemissao <> "") {
            $notentemissao = substr($notentemissao, 8, 2) . '/' . substr($notentemissao, 5, 2) . '/' . substr($notentemissao, 0, 4);
        }

        if (trim($notentnumero) == "") {
            $notentnumero = "0";
        }
        if (trim($notentcpof) == "") {
            $notentcpof = "0";
        }
        if (trim($notentvalor) == "") {
            $notentvalor = "0";
        }
        if (trim($notentprodutos) == "") {
            $notentprodutos = "0";
        }
        if (trim($notenticm) == "") {
            $notenticm = "0";
        }
        if (trim($notentbaseicm) == "") {
            $notentbaseicm = "0";
        }
        if (trim($notentvaloricm) == "") {
            $notentvaloricm = "0";
        }
        if (trim($notentisentas) == "") {
            $notentisentas = "0";
        }
        if (trim($notentoutras) == "") {
            $notentoutras = "0";
        }
        if (trim($notentbaseipi) == "") {
            $notentbaseipi = "0";
        }
        if (trim($notentpercipi) == "") {
            $notentpercipi = "0";
        }
        if (trim($notentvaloripi) == "") {
            $notentvaloripi = "0";
        }
        if (trim($notentobservacoes) == "") {
            $notentobservacoes = "0";
        }
        if (trim($notatualiza) == "") {
            $notatualiza = "0";
        }

        if (trim($notentcodigo) == "") {
            $notentcodigo = "0";
        }
        if (trim($notentserie) == "") {
            $notentserie = "0";
        }

        $xml .= "<dado>\n";

        $xml .= "<fornguerra>" . $fornguerra . "</fornguerra>\n";
        $xml .= "<comprador>" . $comprador . "</comprador>\n";
        $xml .= "<deposito>" . $deposito . "</deposito>\n";
        $xml .= "<notentdata>" . $notentdata . "</notentdata>\n";
        $xml .= "<notentemissao>" . $notentemissao . "</notentemissao>\n";
        $xml .= "<notentnumero>" . $notentnumero . "</notentnumero>\n";
        $xml .= "<notentcpof>" . $notentcpof . "</notentcpof>\n";
        $xml .= "<notentvalor>" . $notentvalor . "</notentvalor>\n";
        $xml .= "<notentprodutos>" . $notentprodutos . "</notentprodutos>\n";
        $xml .= "<notenticm>" . $notenticm . "</notenticm>\n";
        $xml .= "<notentbaseicm>" . $notentbaseicm . "</notentbaseicm>\n";
        $xml .= "<notentvaloricm>" . $notentvaloricm . "</notentvaloricm>\n";
        $xml .= "<notentisentas>" . $notentisentas . "</notentisentas>\n";
        $xml .= "<notentoutras>" . $notentoutras . "</notentoutras>\n";
        $xml .= "<notentbaseipi>" . $notentbaseipi . "</notentbaseipi>\n";
        $xml .= "<notentpercipi>" . $notentpercipi . "</notentpercipi>\n";
        $xml .= "<notentvaloripi>" . $notentvaloripi . "</notentvaloripi>\n";
        $xml .= "<notentobservacoes>" . $notentobservacoes . "</notentobservacoes>\n";
        $xml .= "<notatualiza>" . $notatualiza . "</notatualiza>\n";

        $xml .= "<notentcodigo>" . $notentcodigo . "</notentcodigo>\n";
        $xml .= "<notentserie>" . $notentserie . "</notentserie>\n";

        $xml .= "</dado>\n";
    }//FECHA FOR

    $xml .= "</dados>\n";

    //CABEÇALHO

    Header("Content-type: application/xml; charset=iso-8859-1");
}//FECHA IF (row)
//PRINTA O RESULTADO
echo $xml;
?>
