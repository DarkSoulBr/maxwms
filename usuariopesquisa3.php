<?php

require_once("include/conexao.inc.php");

$parametro = trim($_POST["parametro"]);

$j = 0;

for ($i = 0; $i < 2; $i++) {

    //EXECUTA A QUERY
    $sql = "
    SELECT a.uscodigo as codigo, a.uslogin as descricao,usdescricao as descricao2
    FROM  cadusuarios a
    WHERE a.uslogin = '$parametro'
    ORDER BY a.uslogin";



    $sql = pg_query($sql);
    $row = pg_num_rows($sql);
    $i = 0;
    $j++;
    if ($row) {
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
        $codigo = pg_result($sql, $i, "codigo");
        $descricao = pg_result($sql, $i, "descricao");
        $descricao2 = pg_result($sql, $i, "descricao2");
        $descricao3 = "";


        if (trim($codigo) == "") {
            $codigo = "0";
        }
        if (trim($descricao) == "") {
            $descricao = "0";
        }
        if (trim($descricao2) == "") {
            $descricao2 = "0";
        }
        if (trim($descricao3) == "") {
            $descricao3 = "0";
        }



        $xml .= "<dado>\n";
        $xml .= "<codigo>" . $codigo . "</codigo>\n";
        $xml .= "<descricao>" . $descricao . "</descricao>\n";
        $xml .= "<descricao2>" . $descricao2 . "</descricao2>\n";
        $xml .= "<descricao3>" . $descricao3 . "</descricao3>\n";

        $xml .= "</dado>\n";
    }//FECHA FOR

    $xml .= "</dados>\n";

    //CABEÇALHO
    Header("Content-type: application/xml; charset=iso-8859-1");
}//FECHA IF (row)
//PRINTA O RESULTADO
echo $xml;

