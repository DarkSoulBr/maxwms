<?php

//RECEBE PAR?METRO                     
$parametro = trim($_POST["parametro"]);

require_once("include/conexao.inc.php");

//QUERY  

if (($parametro) != 0) {
    $sql = "
	SELECT a.rotcodigo,a.rotnome
        FROM  rota a 
	WHERE a.rotcodigo = '$parametro'
	ORDER BY a.rotcodigo";
} else {
    $sql = " 

	SELECT a.rotcodigo,a.rotnome
        FROM  rota a 
	ORDER BY a.rotcodigo";
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
        $codigo = pg_fetch_result($sql, $i, "rotcodigo");
        $descricao = pg_fetch_result($sql, $i, "rotnome");
        $xml .= "<dado>\n";
        $xml .= "<codigo>" . $codigo . "</codigo>\n";
        $xml .= "<descricao>" . $descricao . "</descricao>\n";
        $xml .= "</dado>\n";
    }//FECHA FOR                 

    $xml .= "</dados>\n";

    //CABE?ALHO
    Header("Content-type: application/xml; charset=iso-8859-1");
}//FECHA IF (row)                                               
//PRINTA O RESULTADO  
echo $xml;
?>
