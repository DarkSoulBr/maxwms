<?php

require('./_app/Config.inc.php');

$read = new Read;

$read->FullRead("SELECT grucodigo,grunome FROM grupo ORDER BY grunome ASC");

if ($read->getRowCount() >= 1) {

    header("Content-type: application/xml");
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";
    $xml .= "<dados>";

    foreach ($read->getResult() as $registros) {

        extract($registros);

        if (trim($grucodigo) == "") {
            $grucodigo = "0";
        }
        if (trim($grunome) == "") {
            $grunome = "_";
        }

        $xml .= "<registro>";
        $xml .= "<item>" . $grucodigo . "</item>";
        $xml .= "<item>" . $grunome . "</item>";

        $xml .= "</registro>";
    }
    $xml .= "</dados>";
}

echo $xml;
