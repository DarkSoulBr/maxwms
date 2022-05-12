<?php

require('./_app/Config.inc.php');

$parametro = trim($_REQUEST["parametro"]);

if (strlen($parametro) >= 1) {
    if (strlen($parametro) == 1) {
        $sql = "SELECT ib.codestado, ib.codcidade, ib.descricao as cidadeibge
        		FROM  cidadesibge ib
			WHERE ib.uf like '$parametro%'
			ORDER BY ib.descricao";
    } else {
        $sql = "SELECT ib.codestado, ib.codcidade, ib.descricao as cidadeibge
        		FROM  cidadesibge ib
			WHERE ib.uf like '%$parametro%'
			ORDER BY ib.descricao";
    }

    $read = new Read;
    $read->FullRead($sql);

    if ($read->getRowCount() >= 1) {
        
        $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
        $xml .= "<dadosib>\n";

        foreach ($read->getResult() as $registros) {
            extract($registros);            
            if ($codestado == 0) {
                $codestado = '00';
            }
            $aux = $codestado . $codcidade;
            $xml .= "<dadoib>\n";
            $xml .= "<codigoib>" . $aux . "</codigoib>\n";
            $xml .= "<cidadeib>" . $cidadeibge . "</cidadeib>\n";
            $xml .= "</dadoib>\n";
        }
        $xml .= "</dadosib>\n";
        Header("Content-type: application/xml; charset=iso-8859-1");
    }    
    echo $xml;
}