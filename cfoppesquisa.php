<?php

require_once("include/conexao.inc.php");
require_once("include/natureza.php");

//RECEBE PARÃMETRO

$parametro = trim($_POST["parametro"]);

$cadastro = new banco($conn, $db);

// WHERE a.natcod = '$parametro'
//QUERY
$sql = "

        SELECT a.natcodigo as codigo, a.natcod as descricao,a.natdescr as descricao2
        FROM  natureza a
        ORDER BY a.natcod";


//EXECUTA A QUERY
$sql = pg_query($sql);

$row = pg_num_rows($sql);

//VERIFICA SE VOLTOU ALGO
if ($row) {


    //PERCORRE ARRAY
    for ($i = 0; $i < $row; $i++) {

        $descricao = pg_fetch_result($sql, $i, "descricao");
        if (trim($descricao) == "") {
            $descricao = "0";
        }
        $descricao1 = str_replace(".", "", $descricao);

        if ($descricao1 == $parametro) {

            //XML
            $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
            $xml .= "<dados>\n";
            $xml .= "<dado>\n";
            $xml .= "<descricao>" . $descricao1 . "</descricao>\n";
            $xml .= "</dado>\n";
            $xml .= "</dados>\n";
            Header("Content-type: application/xml; charset=iso-8859-1");
        }
    }
}

//PRINTA O RESULTADO
echo $xml;
?>
