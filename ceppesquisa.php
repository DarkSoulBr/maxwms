<?php

//RECEBE PARÃMETRO
$parametro = trim($_POST["parametro"]);

//$parametro = '01023001';
//$parametro = '08900000';

require_once("include/conexao.inc.php");


//QUERY
$sql = "SELECT a.cidcodigo as codigo,a.descricao as descricao,a.uf as descricao2,'_' as descricao3,'_' as descricao4
FROM  cidades a
WHERE a.cep = '$parametro'";

//EXECUTA A QUERY
$sql = pg_query($sql);

$row = pg_num_rows($sql);

//CABEÇALHO
Header("Content-type: application/xml; charset=iso-8859-1");
//XML
$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
$xml .= "<dados>\n";

//VERIFICA SE VOLTOU ALGO
if ($row) {
    //PERCORRE ARRAY
    for ($i = 0; $i < $row; $i++) {
        $codigo = pg_fetch_result($sql, $i, "codigo");
        $descricao = pg_fetch_result($sql, $i, "descricao");
        $descricao2 = pg_fetch_result($sql, $i, "descricao2");
        $descricao3 = pg_fetch_result($sql, $i, "descricao3");
        $descricao4 = pg_fetch_result($sql, $i, "descricao4");
        $xml .= "<dado>\n";
        $xml .= "<codigo>" . $codigo . "</codigo>\n";
        $xml .= "<descricao>" . $descricao . "</descricao>\n";
        $xml .= "<descricao2>" . $descricao2 . "</descricao2>\n";
        $xml .= "<descricao3>" . $descricao3 . "</descricao3>\n";
        $xml .= "<descricao4>" . $descricao4 . "</descricao4>\n";
        $xml .= "</dado>\n";
    }//FECHA FOR
}//FECHA IF (row)
else {
    $sql = "SELECT a.cidcodigo as codigo,a.descricao as descricao,a.uf as descricao2,
	b.descricao as descricao3,c.descricao as descricao4
	FROM  cidades a, logradouros b, bairros c
	WHERE b.cep = '$parametro'
	AND a.codigo = b.codigocidade
	AND c.codigo = b.codigobairro";

    //EXECUTA A QUERY
    $sql = pg_query($sql);

    $row = pg_num_rows($sql);

    //VERIFICA SE VOLTOU ALGO
    if ($row) {
        //PERCORRE ARRAY
        for ($i = 0; $i < $row; $i++) {
            $codigo = pg_fetch_result($sql, $i, "codigo");
            $descricao = pg_fetch_result($sql, $i, "descricao");
            $descricao2 = pg_fetch_result($sql, $i, "descricao2");
            $descricao3 = pg_fetch_result($sql, $i, "descricao3");
            $descricao4 = pg_fetch_result($sql, $i, "descricao4");
            $xml .= "<dado>\n";
            $xml .= "<codigo>" . $codigo . "</codigo>\n";
            $xml .= "<descricao>" . $descricao . "</descricao>\n";
            $xml .= "<descricao2>" . $descricao2 . "</descricao2>\n";
            $xml .= "<descricao3>" . $descricao3 . "</descricao3>\n";
            $xml .= "<descricao4>" . $descricao4 . "</descricao4>\n";
            $xml .= "</dado>\n";
        }//FECHA FOR
    }//FECHA IF (row)
}
$xml .= "</dados>\n";

//PRINTA O RESULTADO
echo $xml;
?>
