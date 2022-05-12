<?php

//RECEBE PAR�METRO                     
if (isset($_POST["parametro"]) && $_POST["parametro"] != 'undefined') {
    $parametro = (int) trim($_POST["parametro"]);
} else {
    $parametro = 0;
}

require_once("include/conexao.inc.php");
require_once("include/produto.php");

$cadastro = new banco($conn, $db);

//QUERY  

if (($parametro) != 0) {
    $sql = "
	SELECT a.forcodigo,a.fornguerra
        FROM fornecedor a 
	WHERE a.forcodigo = '$parametro'
	ORDER BY a.forcodigo";
} else {
    $sql = " 

	SELECT a.forcodigo,a.fornguerra
        FROM fornecedor a 
	ORDER BY a.fornguerra";
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
        $codigo = pg_fetch_result($sql, $i, "forcodigo");
        $descricao = pg_fetch_result($sql, $i, "fornguerra");

        if (trim($codigo) == "") {
            $codigo = "0";
        }
        if (trim($descricao) == "") {
            $descricao = "0";
        }

        $xml .= "<dado>\n";
        $xml .= "<codigo>" . $codigo . "</codigo>\n";
        $xml .= "<descricao>" . $descricao . "</descricao>\n";
        $xml .= "</dado>\n";
    }//FECHA FOR                 

    $xml .= "</dados>\n";

    //CABE�ALHO
    Header("Content-type: application/xml; charset=iso-8859-1");
}//FECHA IF (row)                                               
//PRINTA O RESULTADO  
echo $xml;

