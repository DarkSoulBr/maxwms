<?php

require_once("include/conexao.inc.php");
require_once("include/romaneios.php");

//RECEBE PARÃMETRO
//$parametro = trim($_POST["parametro"]);

$cadastro = new banco($conn, $db);

//
//QUERY
$sql = "
       SELECT *
        FROM  configuracao a
        ";

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
        $codigo = pg_fetch_result($sql, $i, "acesso01");

        if (trim($codigo) == "") {
            $codigo = "0";
        }

        $xml .= "<dado>\n";
        $xml .= "<codigo>" . $codigo . "</codigo>\n";
        $xml .= "</dado>\n";
    }//FECHA FOR

    $xml .= "</dados>\n";

    //CABEÇALHO

    Header("Content-type: application/xml; charset=iso-8859-1");
}//FECHA IF (row)
else {
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $xml .= "<dados>\n";

    $codigo = '1';
    $xml .= "<dado>\n";
    $xml .= "<codigo>" . $codigo . "</codigo>\n";
    $xml .= "</dado>\n";

    $xml .= "</dados>\n";

    //CABEÇALHO
    Header("Content-type: application/xml; charset=iso-8859-1");
}

//PRINTA O RESULTADO
echo $xml;
?>
