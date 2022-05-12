<?php

require_once("include/conexao.inc.php");
require_once("include/romaneios.php");

//RECEBE PARÃMETRO

$parametro = trim($_POST["parametro"]);

$cadastro = new banco($conn, $db);

/*
  $sql = "
  SELECT max(to_number(a.romnumero,'999999')) as numero,EXTRACT(YEAR FROM NOW()) as ano
  FROM  romaneios a
  Where romano = cast(EXTRACT(YEAR FROM NOW()) as varchar)

  ";
 */


$sql = "
       SELECT max(cast(a.romnumero as numeric)) as numero,EXTRACT(YEAR FROM NOW()) as ano
       FROM  romaneios a
       Where romano = cast(EXTRACT(YEAR FROM NOW()) as varchar)
       ";



$sql = pg_query($sql);

$row = pg_num_rows($sql);

//VERIFICA SE VOLTOU ALGO
if ($row) {

    //XML
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $xml .= "<dados>\n";

    //PERCORRE ARRAY
    for ($i = 0; $i < $row; $i++) {
        $numero = (pg_fetch_result($sql, $i, "numero") + 1);
        $ano = (pg_fetch_result($sql, $i, "ano"));

        $xml .= "<dado>\n";
        $xml .= "<numero>" . $numero . "/" . $ano . "</numero>\n";
        $xml .= "<numero1>" . $numero . "</numero1>\n";
        $xml .= "<numero2>" . $ano . "</numero2>\n";
        $xml .= "</dado>\n";
    }//FECHA FOR

    $xml .= "</dados>\n";

    //CABEÇALHO

    Header("Content-type: application/xml; charset=iso-8859-1");
}//FECHA IF (row)
//PRINTA O RESULTADO
echo $xml;
?>
