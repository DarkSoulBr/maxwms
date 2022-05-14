<?php

require_once("include/conexao.inc.php");
require_once("include/pedcompracons.php");

//RECEBE PARÃMETRO

$parametro = trim($_POST["parametro"]);

$cadastro = new banco($conn, $db);


$sql = "SELECT
  c.notentseqbaixa
  FROM  notaent c, pcompra a
  LEft Join fornecedor as b on a.forcodigo = b.forcodigo
  Where c.pcnumero = '$parametro'
  and a.pcnumero = c.pcnumero
  and c.notentvalor is not null
  and (c.notatualiza = ''
  or c.notatualiza is null)
  order by c.notentseqbaixa
  ";

//EXECUTA A QUERY
$sql = pg_query($sql);

$row = pg_num_rows($sql);

if ($row) {

    //XML
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $xml .= "<dados>\n";

    //PERCORRE ARRAY
    for ($i = 0; $i < $row; $i++) {

        $notentseqbaixa = pg_fetch_result($sql, $i, "notentseqbaixa");

        if (trim($notentseqbaixa) == "") {
            $notentseqbaixa = "0";
        }

        $xml .= "<dado>\n";
        $xml .= "<notentseqbaixa>" . $notentseqbaixa . "</notentseqbaixa>\n";
        $xml .= "</dado>\n";
    }//FECHA FOR

    $xml .= "</dados>\n";

    //CABEÇALHO

    Header("Content-type: application/xml; charset=iso-8859-1");
}//FECHA IF (row)
//PRINTA O RESULTADO
echo $xml;
?>
