<?php

require_once("include/conexao.inc.php");
require_once("include/tipopagamento.php");

//RECEBE PARÃMETRO

$parametro = trim($_POST["parametro"]);

$cadastro = new banco($conn, $db);

$j = 0;

for ($i = 0; $i < 2; $i++) {

    //EXECUTA A QUERY

    $sql = "
        SELECT a.tpgcodigo,a.tpgnome
        FROM  tipopagamento a
	WHERE a.tpgnome = '$parametro'
	ORDER BY a.tpgcodigo";

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
        $codigo = pg_fetch_result($sql, $i, "tpgcodigo");
        $descricao = pg_fetch_result($sql, $i, "tpgnome");
        $opcao = pg_fetch_result($sql, $i, "opcao");
        if (trim($codigo) == "") {
            $codigo = "0";
        }
        if (trim($descricao) == "") {
            $descricao = "0";
        }

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
