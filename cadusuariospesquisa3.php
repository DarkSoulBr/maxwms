<?php

require_once("include/conexao.inc.php");

$parametro = trim($_POST["parametro"]);


$j = 0;

for ($i = 0; $i < 2; $i++) {

    //EXECUTA A QUERY

    $sql = "
        SELECT a.uscodigo as codigo, a.usdescricao as descricao
		
		,0 as descricao2
		,0 as descricao3
		,a.ususuario as descricao4		
		,0 as descricao5
		,a.uslogin as descricao6
		,a.usemail as descricao7
		
        FROM  cadusuarios a
        WHERE a.usdescricao = '$parametro'
        ORDER BY a.uscodigo";

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
        $descricao3 = pg_result($sql, $i, "descricao3");
        $descricao4 = pg_result($sql, $i, "descricao4");
        $descricao5 = pg_result($sql, $i, "descricao5");
        $descricao6 = pg_result($sql, $i, "descricao6");
        $descricao7 = pg_result($sql, $i, "descricao7");

        if (trim($codigo) == "") {
            $codigo = "0";
        }
        if (trim($descricao) == "") {
            $descricao = "0";
        }

        if (trim($descricao2) == "") {
            $descricao2 = "2";
        }
        if (trim($descricao3) == "") {
            $descricao3 = "0";
        }
        if (trim($descricao4) == "") {
            $descricao4 = "0";
        }
        if (trim($descricao5) == "") {
            $descricao5 = "2";
        }

        if (trim($descricao6) == "") {
            $descricao6 = "0";
        }
        if (trim($descricao7) == "") {
            $descricao7 = "0";
        }


        $xml .= "<dado>\n";
        $xml .= "<codigo>" . $codigo . "</codigo>\n";
        $xml .= "<descricao>" . $descricao . "</descricao>\n";

        $xml .= "<descricao2>" . $descricao2 . "</descricao2>\n";
        $xml .= "<descricao3>" . $descricao3 . "</descricao3>\n";
        $xml .= "<descricao4>" . $descricao4 . "</descricao4>\n";
        $xml .= "<descricao5>" . $descricao5 . "</descricao5>\n";

        $xml .= "<descricao6>" . $descricao6 . "</descricao6>\n";
        $xml .= "<descricao7>" . $descricao7 . "</descricao7>\n";


        $xml .= "</dado>\n";
    }//FECHA FOR

    $xml .= "</dados>\n";

    //CABEÇALHO
    Header("Content-type: application/xml; charset=iso-8859-1");
}//FECHA IF (row)
//PRINTA O RESULTADO
echo $xml;
