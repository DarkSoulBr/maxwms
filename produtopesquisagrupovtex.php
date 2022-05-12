<?php

//RECEBE PARÃMETRO                     
$parametro = trim($_POST["parametro"]);

require_once("include/conexao.inc.php");
require_once("include/produto.php");

$cadastro = new banco($conn, $db);

//QUERY  

if (($parametro) != 0) {
    $sql = "
	SELECT a.grucodigo,a.grunome,a.gruvtex,a.grutricae 
        FROM  grupo a 
	WHERE a.grucodigo = '$parametro'
	ORDER BY a.grucodigo";
} else {
    $sql = " 

	SELECT a.grucodigo,a.grunome,a.gruvtex,a.grutricae 
        FROM  grupo a 
	ORDER BY a.grunome";
}

//EXECUTA A QUERY               
$sql = pg_query($sql);

$row = pg_num_rows($sql);

//VERIFICA SE VOLTOU ALGO 
if ($row) {
    //XML
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $xml .= "<dados>\n";

    //PERCORRE ARRAY            
    for ($i = 0; $i < $row; $i++) {
        $codigo = pg_fetch_result($sql, $i, "grucodigo");
        $descricao = pg_fetch_result($sql, $i, "grunome");
        $vtex = trim(pg_fetch_result($sql, $i, "gruvtex"));
        $tricae = trim(pg_fetch_result($sql, $i, "grutricae"));

        if ($vtex == '') {
            $vtex = '0';
        }
        if ($tricae == '') {
            $tricae = '0';
        }

        //$descricao = trim($descricao) . ' (' . $vtex .'/'. $tricae. ')' ;
        $descricao = trim($descricao) . ' (' . $vtex . ')';


        $xml .= "<dado>\n";
        $xml .= "<codigo>" . $codigo . "</codigo>\n";
        $xml .= "<descricao>" . $descricao . "</descricao>\n";
        $xml .= "</dado>\n";
    }//FECHA FOR                 

    $xml .= "</dados>\n";

    //CABEÇALHO
    Header("Content-type: application/xml; charset=iso-8859-1");
}//FECHA IF (row)                                               
//PRINTA O RESULTADO  
echo $xml;
?>
