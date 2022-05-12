<?php

//RECEBE PARÃMETRO                     
$parametro = trim($_POST["parametro"]);


require_once("include/conexao.inc.php");
require_once("include/produto.php");

$cadastro = new banco($conn, $db);

//QUERY  

if (($parametro) != 0) {
    $sql = "
	SELECT a.subcodigo,a.subnome,a.subvtex,a.subtricae 
        FROM  subgrupo a 
	WHERE a.grucodigo = '$parametro'
	ORDER BY a.subcodigo";
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
        $codigo = pg_fetch_result($sql, $i, "subcodigo");
        $descricao = pg_fetch_result($sql, $i, "subnome");
        $vtex = trim(pg_fetch_result($sql, $i, "subvtex"));
        $tricae = trim(pg_fetch_result($sql, $i, "subtricae"));

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
