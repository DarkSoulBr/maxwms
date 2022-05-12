<?php

//RECEBE PARÃMETRO
$parametro = trim($_POST["parametro"]);


require_once("include/conexao.inc.php");
require_once("include/logradouros.php");

$cadastro = new banco($conn, $db);

//QUERY  
//EXECUTA A QUERY
$sql = "

	SELECT a.codigo,a.descricao as cidnome,a.uf as estcodigo,a.cep

	FROM  cidades a
	WHERE a.codigo = '$parametro'
	ORDER BY a.descricao";

$sql = pg_query($sql);
$row = pg_num_rows($sql);


//VERIFICA SE VOLTOU ALGO
if ($row) {
    //XML
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $xml .= "<dados>\n";

    //PERCORRE ARRAY
    for ($i = ($row - 1); $i < $row; $i++) {
        $codigo = pg_fetch_result($sql, $i, "codigo");
        $descricao = pg_fetch_result($sql, $i, "cidnome");
        $descricao2 = pg_fetch_result($sql, $i, "estcodigo");
        $descricao3 = pg_fetch_result($sql, $i, "cep");

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
?>
