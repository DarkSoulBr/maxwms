<?php

require('./_app/Config.inc.php');

//RECEBE PARÃMETRO                     
$parametro = trim($_POST["parametro"]);

if (($parametro) != 0) {
    $sql = "SELECT a.grecodigo,a.grenome
            FROM  grupoemp a 
            WHERE a.grecodigo = {$parametro} 
            ORDER BY a.grecodigo";
} else {
    $sql = "SELECT a.grecodigo,a.grenome
            FROM  grupoemp a 
            ORDER BY a.grecodigo";
}

$read = new Read;
$read->FullRead($sql);

if ($read->getRowCount() >= 1) {
    
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $xml .= "<dados>\n";

    foreach ($read->getResult() as $registros) {
        extract($registros);
        
        $codigo = $grecodigo;
        $descricao = $grenome;
        $xml .= "<dado>\n";
        $xml .= "<codigo>" . $codigo . "</codigo>\n";
        $xml .= "<descricao>" . $descricao . "</descricao>\n";
        $xml .= "</dado>\n";
    }//FECHA FOR                 

    $xml .= "</dados>\n";

    //CABEÇALHO
    Header("Content-type: application/xml; charset=iso-8859-1");
}                                      
$read = null;
echo $xml;

