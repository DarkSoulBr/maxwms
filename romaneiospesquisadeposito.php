<?php

require('./_app/Config.inc.php');

$parametro = trim($_POST["parametro"]);

$sql = "SELECT a.etqcodigo as codigo,a.etqnome as descricao
        FROM  estoque a
	ORDER BY a.etqcodigo";

$read = new Read;
$read->FullRead($sql);

if ($read->getRowCount() >= 1) {

    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $xml .= "<dados>\n";

    foreach ($read->getResult() as $registros) {
        extract($registros);

        $xml .= "<dado>\n";
        $xml .= "<codigo>" . $codigo . "</codigo>\n";
        $xml .= "<descricao>" .$descricao . "</descricao>\n";
        $xml .= "</dado>\n";
    }
    $xml .= "</dados>\n";

    Header("Content-type: application/xml; charset=iso-8859-1");
}
$read = null;
echo $xml;

