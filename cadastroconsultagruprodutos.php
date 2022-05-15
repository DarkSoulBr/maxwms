<?php

require('./_app/Config.inc.php');

$read = new Read;

$sql = "Select grucodigo,grunome FROM grupo order by grunome asc";

$read->FullRead($sql);

if ($read->getRowCount() >= 1) {

    header("Content-type: application/xml");
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";
    $xml .= "<dados>";

    foreach ($read->getResult() as $total) {

        extract($total);

        $xml .= "<registro>";

        $xml .= "<item>" . $grucodigo . "</item>";
        $xml .= "<item>" . $grunome . "</item>";


        $xml .= "</registro>";
    }
    $xml .= "</dados>";
}

echo $xml;
