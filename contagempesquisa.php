<?php

require('./_app/Config.inc.php');

$parametro = trim($_POST["parametro"]);
$parametro2 = trim($_POST["parametro2"]);

$read = new Read;
if($parametro2==1){
    $read->FullRead("SELECT * FROM contagem WHERE contnome LIKE '%$parametro%' ORDER BY contnome");
}
else if($parametro2==2){
    $read->ExeRead('contagem', 'WHERE contcodigo = :codigo', "codigo=".$parametro);
}

if ($read->getRowCount() >= 1){
    
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $xml .= "<dados>\n";
    
    foreach ($read->getResult() as $total){
                                   
        extract($total);
               
        if (trim($contcodigo) == "") {
            $contcodigo = "0";
        }
        if (trim($contnome) == "") {
            $contnome = "0";
        }
        if (trim($opcao) == "") {
            $opcao = "0";
        }

        $xml .= "<dado>\n";
		$xml .= "<codigo>".$contcodigo."</codigo>\n";
		$xml .= "<descricao>".$contnome."</descricao>\n";
		$xml .= "<opcao>".$opcao."</opcao>\n";
		$xml .= "</dado>\n";
                        
    }
    
    $xml .= "</dados>\n";

    //CABEÇALHO

    Header("Content-type: application/xml; charset=iso-8859-1");
    
}

echo $xml;

