<?php

//RECEBE PARÃMETRO
$parametro = trim($_POST["parametro"]);

require_once("include/conexao.inc.php");
require_once("include/logradouros.php");

$cadastro = new banco($conn, $db);

//QUERY
$sql = "
		SELECT a.logcodigo as codigo,a.descricao,a.cep,
        b.descricao as descricao2,b.codigo as descricao3,
        c.descricao as descricao4,c.cidcodigo as descricao5,
        c.uf
        FROM  logradouros a,bairros b, cidades c
		WHERE a.logcodigo = '$parametro'
		AND a.codigobairro = b.codigo
		AND a.codigocidade = c.codigo
		ORDER BY a.descricao";

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
        $descricao = pg_fetch_result($sql, $i, "descricao");
        $descricao2 = pg_fetch_result($sql, $i, "descricao2");
        $descricao3 = pg_fetch_result($sql, $i, "descricao3");
        $descricao4 = pg_fetch_result($sql, $i, "descricao4");
        $descricao5 = pg_fetch_result($sql, $i, "descricao5");
        $cep = pg_fetch_result($sql, $i, "cep");
        $uf = pg_fetch_result($sql, $i, "uf");

        $xml .= "<dado>\n";
        $xml .= "<codigo>" . $codigo . "</codigo>\n";
        $xml .= "<descricao>" . $descricao . "</descricao>\n";
        $xml .= "<descricao2>" . $descricao2 . "</descricao2>\n";
        $xml .= "<descricao3>" . $descricao3 . "</descricao3>\n";
        $xml .= "<descricao4>" . $descricao4 . "</descricao4>\n";
        $xml .= "<descricao5>" . $descricao5 . "</descricao5>\n";
        $xml .= "<cep>" . $cep . "</cep>\n";
        $xml .= "<uf>" . $uf . "</uf>\n";
        $xml .= "</dado>\n";
    }//FECHA FOR

    $xml .= "</dados>\n";

    //CABEÇALHO
    Header("Content-type: application/xml; charset=iso-8859-1");
}//FECHA IF (row)
//PRINTA O RESULTADO
echo $xml;
?>