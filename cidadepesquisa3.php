<?php

//RECEBE PARÃMETRO
$parametro = trim($_POST["parametro"]);

require_once("include/conexao.inc.php");
require_once("include/cidade.php");

$cadastro = new banco($conn, $db);

//QUERY

$j = 0;

for ($i = 0; $i < 2; $i++) {

    //EXECUTA A QUERY
    $sql = "
	
	SELECT a.cidcodigo,a.descricao as cidnome,a.uf as estcodigo,a.cep,a.suframa

	FROM  cidades a 
	WHERE a.descricao = '$parametro'
	ORDER BY a.cidcodigo";

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
        $codigo = pg_fetch_result($sql, $i, "cidcodigo");
        $descricao = pg_fetch_result($sql, $i, "cidnome");
        $descricao2 = pg_fetch_result($sql, $i, "estcodigo");
        $descricao3 = pg_fetch_result($sql, $i, "cep");
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
        if (trim($descricao7) == "") {
            $descricao7 = "N";
        }

        $xml .= "<dado>\n";
        $xml .= "<codigo>" . $codigo . "</codigo>\n";
        $xml .= "<descricao>" . $descricao . "</descricao>\n";
        $xml .= "<descricao2>" . $descricao2 . "</descricao2>\n";
        $xml .= "<descricao3>" . $descricao3 . "</descricao3>\n";
        $xml .= "<descricao7>" . $descricao7 . "</descricao7>\n";
        $xml .= "</dado>\n";
    }//FECHA FOR

    $xml .= "</dados>\n";

    //CABEÇALHO
    Header("Content-type: application/xml; charset=iso-8859-1");
}//FECHA IF (row)
//PRINTA O RESULTADO
echo $xml;
?>
