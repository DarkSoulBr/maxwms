<?php

//RECEBE PARÃMETRO                     
$parametro = trim($_POST["parametro"]);

require_once("include/conexao.inc.php");
require_once("include/estado.php");

$cadastro = new banco($conn, $db);


$j = 0;

for ($i = 0; $i < 2; $i++) {

    //EXECUTA A QUERY          

    $sql = " 
        SELECT a.estcodigo,a.codigo as estsigla,a.descricao as estnome, a.esticms,a.estinterna,a.estpobreza,a.estservico
        FROM  estados a
	WHERE a.descricao = '$parametro'
	ORDER BY a.estcodigo";

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
        $codigo = pg_fetch_result($sql, $i, "estcodigo");
        $descricao1 = pg_fetch_result($sql, $i, "estsigla");
        $descricao = pg_fetch_result($sql, $i, "estnome");
        $descricao3 = pg_fetch_result($sql, $i, "esticms");
        $descricao4 = pg_fetch_result($sql, $i, "estinterna");
        $descricao5 = pg_fetch_result($sql, $i, "estpobreza");
        $descricao6 = pg_fetch_result($sql, $i, "estservico");
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
        $xml .= "<dado>\n";
        $xml .= "<codigo>" . $codigo . "</codigo>\n";
        $xml .= "<descricao1>" . $descricao1 . "</descricao1>\n";
        $xml .= "<descricao>" . $descricao . "</descricao>\n";
        $xml .= "<descricao3>" . $descricao3 . "</descricao3>\n";
        $xml .= "<descricao4>" . $descricao4 . "</descricao4>\n";
        $xml .= "<descricao5>" . $descricao5 . "</descricao5>\n";
        $xml .= "<descricao6>" . $descricao6 . "</descricao6>\n";
        $xml .= "</dado>\n";
    }//FECHA FOR

    $xml .= "</dados>\n";

    //CABEÇALHO
    Header("Content-type: application/xml; charset=iso-8859-1");
}//FECHA IF (row)                                               
//PRINTA O RESULTADO  
echo $xml;
?>
