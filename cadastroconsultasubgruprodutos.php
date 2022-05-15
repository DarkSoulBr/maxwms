<?php

require('./_app/Config.inc.php');

$read = new Read;

$sql = "Select subcodigo,subnome FROM subgrupo order by subnome asc";

$read->FullRead($sql);

if ($read->getRowCount() >= 1) {

    header("Content-type: application/xml");
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";
    $xml .= "<dados>";

    foreach ($read->getResult() as $total) {

        extract($total);

        $xml .= "<registro>";

        $xml .= "<item>" . $subcodigo . "</item>";
        $xml .= "<item>" . $subnome . "</item>";


        $xml .= "</registro>";
    }
    $xml .= "</dados>";
}

echo $xml;
