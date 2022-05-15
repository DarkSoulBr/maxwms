<?php

require('./_app/Config.inc.php');

$parametro = trim($_POST["parametro"]);
$parametro2 = trim($_POST["parametro2"]);

$read = new Read;
if($parametro2==1){
    $read->FullRead("SELECT * FROM coletores WHERE colnome LIKE '%$parametro%' ORDER BY colnome");
}
else if($parametro2==2){
    $read->ExeRead('coletores', 'WHERE colcodigo = :codigo', "codigo=".$parametro);
}

if ($read->getRowCount() >= 1){
    
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $xml .= "<dados>\n";
    
    foreach ($read->getResult() as $total){
                                   
        extract($total);
               
        if (trim($colcodigo) == "") {
            $totecodigo = "0";
        }
        if (trim($colnome) == "") {
            $totenome = "0";
        }

        $xml .= "<dado>\n";
		$xml .= "<codigo>".$colcodigo."</codigo>\n";
		$xml .= "<descricao>".$colnome."</descricao>\n";
		$xml .= "</dado>\n";
                        
    }
    
    $xml .= "</dados>\n";

    //CABEÇALHO

    Header("Content-type: application/xml; charset=iso-8859-1");
    
}

echo $xml;

