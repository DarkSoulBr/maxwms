<?php

//RECEBE PARĂMETRO
$parametro = trim($_POST["parametro"]);

require_once("include/conexao.inc.php");
require_once("include/cidade.php");

$cadastro = new banco($conn, $db);

//QUERY

if (strlen($parametro) >= 1) {

    if (strlen($parametro) == 1) {
        $sql = "
 		SELECT a.cidcodigo,a.descricao as cidnome,a.uf as estcodigo,a.cep,a.desconto,a.desconto2,a.desconto3,a.suframa
        	FROM  cidades a 
		WHERE upper(a.descricao) like '$parametro%'
		ORDER BY a.descricao";
    } else {
        $sql = "
		SELECT a.cidcodigo,a.descricao as cidnome,a.uf as estcodigo,a.cep,a.desconto,a.desconto2,a.desconto3,a.suframa
        	FROM  cidades a 
		WHERE upper(a.descricao) like '%$parametro%'
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
            $codigo = pg_fetch_result($sql, $i, "cidcodigo");
            $descricao = pg_fetch_result($sql, $i, "cidnome");
            $descricao2 = pg_fetch_result($sql, $i, "estcodigo");
            $descricao3 = intval(pg_fetch_result($sql, $i, "cep"));
            $descricao4 = pg_fetch_result($sql, $i, "desconto");
            $descricao5 = pg_fetch_result($sql, $i, "desconto2");
            $descricao6 = pg_fetch_result($sql, $i, "desconto3");
            $descricao7 = pg_fetch_result($sql, $i, "suframa");

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
            if (trim($descricao4) == "") {
                $descricao4 = "0";
            }
            if (trim($descricao5) == "") {
                $descricao5 = "0";
            }
            if (trim($descricao6) == "") {
                $descricao6 = "0";
            }
            if (trim($descricao7) == "") {
                $descricao7 = "N";
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
}
?>
