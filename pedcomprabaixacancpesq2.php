<?php

require('./_app/Config.inc.php');

$parametro = trim($_POST["parametro"]);

$sql = "SELECT c.notentseqbaixa
  FROM  notaent c, pcompra a
  LEFT JOIN fornecedor as b on a.forcodigo = b.forcodigo
  WHERE c.pcnumero = '$parametro'
  AND a.pcnumero = c.pcnumero
  ORDER BY c.notentseqbaixa";

$read = new Read;
$read->FullRead($sql);

if ($read->getRowCount() >= 1) {

    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $xml .= "<dados>\n";

    foreach ($read->getResult() as $registros) {
        extract($registros);

        if (trim($notentseqbaixa) == "") {
            $notentseqbaixa = "0";
        }

        $xml .= "<dado>\n";
        $xml .= "<notentseqbaixa>" . $notentseqbaixa . "</notentseqbaixa>\n";
        $xml .= "</dado>\n";
    }
    $xml .= "</dados>\n";
    Header("Content-type: application/xml; charset=iso-8859-1");
}
$read = null;
echo $xml;

