<?php

require_once("include/conexao.inc.php");
require_once("include/romaneios.php");

$cadastro = new banco($conn, $db);
$pesquisa = $_POST["parametro"];

$pesquisa = "      " . $pesquisa;

$pesquisa1 = trim(substr($pesquisa, -12, 7));
$pesquisa2 = substr($pesquisa, -4, 4);


$j = 0;

for ($i = 0; $i < 2; $i++) {

    $sql = "SELECT a.romcodigo as codigo
        FROM romaneios a
        WHERE a.romnumero = '$pesquisa1'
	AND a.romano = '$pesquisa2'
        order by a.romcodigo";


    //EXECUTA A QUERY
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
    for ($i = 0; $i < $row; $i++) {

        $codigo = pg_fetch_result($sql, $i, "codigo");

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
//PRINTA O RESULTADO
echo $xml;
?>
