<?php

//RECEBE PARÃMETRO
$parametro = trim($_POST["parametro"]);

require_once("include/conexao.inc.php");
require_once("include/bairros.php");

$cadastro = new banco($conn, $db);

//QUERY

if (strlen($parametro) >= 1) {

    if (strlen($parametro) == 1) {
        $sql = "
 		SELECT a.baicodigo as codigo,a.descricao,b.descricao as descricao2,a.codigocidade as descricao3,
        	b.uf
                FROM  bairros a, cidades b
		WHERE a.descricao like '$parametro%'
		AND a.codigocidade = b.codigo
		ORDER BY a.descricao";
    } else {
        $sql = "
 		SELECT a.baicodigo as codigo,a.descricao,b.descricao as descricao2,a.codigocidade as descricao3,
        	b.uf
                FROM  bairros a, cidades b
                WHERE a.descricao like '%$parametro%'
		AND a.codigocidade = b.codigo
		ORDER BY a.descricao";
    }


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
            $uf = pg_fetch_result($sql, $i, "uf");
            $xml .= "<dado>\n";
            $xml .= "<codigo>" . $codigo . "</codigo>\n";
            $xml .= "<descricao>" . $descricao . "</descricao>\n";
            $xml .= "<descricao2>" . $descricao2 . "</descricao2>\n";
            $xml .= "<descricao3>" . $descricao3 . "</descricao3>\n";
            $xml .= "<uf>" . $uf . "</uf>\n";
            $xml .= "</dado>\n";
        }//FECHA FOR

        $xml .= "</dados>\n";

        //CABEÇALHO
        Header("Content-type: application/xml; charset=iso-8859-1");
    }//FECHA IF (row)
    //PRINTA O RESULTADO
    echo $xml;
}
?>
