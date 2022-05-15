<?php

require('./_app/Config.inc.php');

$parametro = trim($_POST["parametro"]);
$parametro2 = trim($_POST["parametro2"]);

$read = new Read;
if($parametro2==1){
    $read->FullRead("SELECT * FROM setor WHERE setor LIKE '%$parametro%' ORDER BY setor");
}
else if($parametro2==2){
    $read->ExeRead('setor', 'WHERE setcodigo = :codigo', "codigo=".$parametro);
}

$xml = null;

if ($read->getRowCount() >= 1){
    
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $xml .= "<dados>\n";
    
    foreach ($read->getResult() as $total){
                                   
        extract($total);
               
        if (trim($setcodigo) == "") {
            $setcodigo = "0";
        }
        if (trim($setor) == "") {
            $setor = "0";
        }
        if (trim($codigosetor) == "") {
            $codigosetor = "0";
        }

        $xml .= "<dado>\n";
        $xml .= "<codigo>" . $setcodigo . "</codigo>\n";
        $xml .= "<descricao>" . $setor . "</descricao>\n";
        $xml .= "<descricao2>" . $codigosetor . "</descricao2>\n";
        $xml .= "</dado>\n";
                        
    }
    
    $xml .= "</dados>\n";

    //CABEÇALHO

    Header("Content-type: application/xml; charset=iso-8859-1");
    
}

echo $xml;

