<?php

require('./_app/Config.inc.php');

$parametro = trim($_POST["parametro"]);
$parametro2 = trim($_POST["parametro2"]);

$read = new Read;
if($parametro2==1){
    $read->FullRead("SELECT * FROM enderecos WHERE ua LIKE '%$parametro%' ORDER BY ua");
}
else if($parametro2==2){
    $read->ExeRead('enderecos', 'WHERE esecodigo = :codigo', "codigo=".$parametro);
}

if ($read->getRowCount() >= 1){
    
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $xml .= "<dados>\n";
    
    foreach ($read->getResult() as $registros){
                                   
        extract($registros);
                    
        if (trim($ua) == "") {
            $ua = "_";
        }
        if (trim($bloco) == "") {
            $bloco = "_";
        }
        if (trim($rua) == "") {
            $rua = "_";
        }
        if (trim($nivel) == "") {
            $nivel = "_";
        }
        if (trim($coluna) == "") {
            $coluna = "_";
        }
        $posicao = (int) $posicao;

        $xml .= "<dado>\n";
        $xml .= "<codigo>" . $esecodigo . "</codigo>\n";
        $xml .= "<ua>" . $ua . "</ua>\n";        
        $xml .= "<bloco>" . $bloco . "</bloco>\n";        
        $xml .= "<rua>" . $rua . "</rua>\n";        
        $xml .= "<nivel>" . $nivel . "</nivel>\n";        
        $xml .= "<coluna>" . $coluna . "</coluna>\n";        
        $xml .= "<posicao>" . $posicao . "</posicao>\n";        
        $xml .= "</dado>\n";
                        
    }
    
    $xml .= "</dados>\n";

    //CABEÇALHO

    Header("Content-type: application/xml; charset=iso-8859-1");
    
}

echo $xml;

