<?php

require_once("include/conexao.inc.php");
require_once("include/transportador.php");

$tracodigo = trim($_POST["parametro"]);
$tradatasul = trim($_POST["parametro2"]);
$tracnpj = trim($_POST["parametro3"]);

$baruni = 0;

$codigo = '0';
$descricao = '0';

$cadastro = new banco($conn, $db);

if ($tracodigo == 0) {
    $sql = "
  	SELECT *
    FROM  transportador a 
	WHERE a.datcodigo = '$tradatasul' AND a.tracnpj <> '$tracnpj'";
} else {
    $sql = "
  	SELECT *
    FROM  transportador a 
	WHERE a.datcodigo = '$tradatasul'
	AND a.tracodigo <> '$tracodigo' AND a.tracnpj <> '$tracnpj'";
}

//EXECUTA A QUERY
$sql = pg_query($sql);
$row = pg_num_rows($sql);

//VERIFICA SE VOLTOU ALGO
if ($row) {
    $baruni = 1;
    $codigo = pg_fetch_result($sql, 0, "tracodigo");
    $descricao = pg_fetch_result($sql, 0, "tranguerra");
}

//XML
$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
$xml .= "<dados>\n";
$xml .= "<dado>\n";
$xml .= "<baruni>" . $baruni . "</baruni>\n";
$xml .= "<codigo>" . $codigo . "</codigo>\n";
$xml .= "<descricao>" . $descricao . "</descricao>\n";
$xml .= "</dado>\n";
$xml .= "</dados>\n";

//CABEÇALHO
Header("Content-type: application/xml; charset=iso-8859-1");


//PRINTA O RESULTADO
echo $xml;
?>