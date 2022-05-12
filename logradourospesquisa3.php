<?php

//RECEBE PARÃMETRO
$parametro = trim($_POST["parametro"]);
$parametro2 = trim($_POST["parametro2"]);

require_once("include/conexao.inc.php");
require_once("include/logradouros.php");

$cadastro = new banco($conn, $db);

//QUERY

$j = 0;

for ($i = 0; $i < 2; $i++) {

    //EXECUTA A QUERY
    $sql = "

        SELECT a.logcodigo as codigo,a.descricao
       	FROM  logradouros a, cidades b
	WHERE a.descricao = '$parametro'
	AND a.codigocidade = '$parametro2'
	AND a.codigocidade = b.codigo
	ORDER BY a.descricao";


    $sql = pg_query($sql);
    $row = pg_num_rows($sql);
    $i = 0;
    $j++;
    if ($row) {
        $i = 2;
    }
    if ($j == 10000) {
        $i = 2;
    }
}

//VERIFICA SE VOLTOU ALGO
if ($row) {
    //XML
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $xml .= "<dados>\n";

    //PERCORRE ARRAY
    for ($i = ($row - 1); $i < $row; $i++) {
        $codigo = pg_fetch_result($sql, $i, "codigo");
        $descricao = pg_fetch_result($sql, $i, "descricao");
        $xml .= "<dado>\n";
        $xml .= "<codigo>" . $codigo . "</codigo>\n";
        $xml .= "<descricao>" . $descricao . "</descricao>\n";
        $xml .= "</dado>\n";
    }//FECHA FOR

    $xml .= "</dados>\n";

    //CABEÇALHO
    Header("Content-type: application/xml; charset=iso-8859-1");
}//FECHA IF (row)
//PRINTA O RESULTADO
echo $xml;
?>
