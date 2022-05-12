<?php

require_once("include/conexao.inc.php");

$tracodigo = trim($_POST["parametro"]);
$tpfcodigo = trim($_POST["parametro2"]);
$tracnpj = trim($_POST["parametro3"]);

$verificacao = 0;
$codigo = 0;
$descricao = '_';

$where = '';

if ($tpfcodigo == 1) {
    $where .= " WHERE (a.tpfcodigo = {$tpfcodigo} OR a.tpfcodigo = 0 OR a.tpfcodigo IS NULL)";
} else {
    $where .= " WHERE a.tpfcodigo = {$tpfcodigo}";
}
$where .= "  AND a.tracnpj = '{$tracnpj}'";

if ($tracodigo == 0) {
    $sql = "SELECT tracodigo,tranguerra 
            FROM transportador a 
            {$where}";
} else {
    $sql = "SELECT tracodigo,tranguerra 
            FROM  transportador a 
            {$where}
            AND a.tracodigo <> {$tracodigo}";
}

//EXECUTA A QUERY
$sql = pg_query($sql);
$row = pg_num_rows($sql);

//VERIFICA SE VOLTOU ALGO
if ($row) {
    $verificacao = 1;
    $codigo = pg_fetch_result($sql, 0, "tracodigo");
    $descricao = pg_fetch_result($sql, 0, "tranguerra");
}

//XML
$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
$xml .= "<dados>\n";
$xml .= "<dado>\n";
$xml .= "<verifica>" . $verificacao . "</verifica>\n";
$xml .= "<codigo>" . $codigo . "</codigo>\n";
$xml .= "<descricao>" . $descricao . "</descricao>\n";
$xml .= "</dado>\n";
$xml .= "</dados>\n";

//CABEÇALHO
Header("Content-type: application/xml; charset=iso-8859-1");

//PRINTA O RESULTADO
echo $xml;
