<?php

require_once("include/conexao.inc.php");
require_once("include/natureza.php");

//RECEBE PARÃMETRO

$parametro = trim($_POST["parametro"]);
$parametro2 = trim($_POST["parametro2"]);
$parametro3 = trim($_POST["parametro3"]);

/*
  $parametro  = 64;
  $parametro2 = '46596';
  $parametro3 = '1';
 */

$cadastro = new banco($conn, $db);

//Fase 1 - Descobre o Codigo do Fornecedor
$sql = "SELECT forcodigo FROM pcompra where pcnumero = $parametro";

//EXECUTA A QUERY
$sql = pg_query($sql);

$row = pg_num_rows($sql);

$forcodigo = 0;
//VERIFICA SE VOLTOU ALGO
if ($row) {
    $forcodigo = pg_fetch_result($sql, 0, "forcodigo");
}

//Fase 2 - Verifica se ja existe a Nota / Serie lancada para o fornecedor
// WHERE a.natcod = '$parametro'
//QUERY
$sql = "SELECT a.pcnumero,a.notentseqbaixa from notaent a,pcompra b
        Where a.pcnumero = b.pcnumero and a.notentnumero = '$parametro2' and a.notentserie = '$parametro3' and b.forcodigo = $forcodigo";

//EXECUTA A QUERY
$sql = pg_query($sql);

$row = pg_num_rows($sql);

//VERIFICA SE VOLTOU ALGO
if ($row) {


    $pcnumero = trim(pg_fetch_result($sql, 0, "pcnumero"));
    $baixa = trim(pg_fetch_result($sql, 0, "notentseqbaixa"));

    $descricao1 = $pcnumero . '-' . $baixa;

    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $xml .= "<dados>\n";
    $xml .= "<dado>\n";
    $xml .= "<descricao>" . $descricao1 . "</descricao>\n";
    $xml .= "</dado>\n";
    $xml .= "</dados>\n";
    Header("Content-type: application/xml; charset=iso-8859-1");
} else {

    $descricao1 = '0';

    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $xml .= "<dados>\n";
    $xml .= "<dado>\n";
    $xml .= "<descricao>" . $descricao1 . "</descricao>\n";
    $xml .= "</dado>\n";
    $xml .= "</dados>\n";
    Header("Content-type: application/xml; charset=iso-8859-1");
}

//PRINTA O RESULTADO
echo $xml;
?>
