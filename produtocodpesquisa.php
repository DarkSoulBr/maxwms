<?php

require_once('./_app/Config.inc.php');
require_once("./include/config.php");


    
$sql = "SELECT max(a.procodigo) as codigo FROM produto a WHERE a.procod NOT LIKE 'F%'";
$read = new Read;
$read->FullRead($sql);

if ($read->getRowCount() >= 1) {

    $codigo = $read->getResult()[0]['codigo'];

    $procod = (int) $codigo + 1;

    if ($procod < 100000) {
        $codigo = '1000-00';
    } else {
        $codigo = substr($procod, 0, 4) . '-' . substr($procod, 4, 2);
    }

}//FECHA IF (row)
else {
    $codigo = '1000-00';
}
    


$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
$xml .= "<dados>\n";
$xml .= "<dado>\n";
$xml .= "<codigo>" . $codigo . "</codigo>\n";
$xml .= "</dado>\n";
$xml .= "</dados>\n";

Header("Content-type: application/xml; charset=iso-8859-1");


echo $xml;

