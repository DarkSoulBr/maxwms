<?php

//RECEBE PARÃMETRO                     
$parametro = trim($_POST["parametro"]);

require_once("include/conexao.inc.php");
require_once("include/produto.php");

$cadastro = new banco($conn, $db);

//QUERY  


$sql = "
	SELECT a.forcodigo,a.formaior,a.formedio,a.formenor,a.formenord,a.forminimo
        FROM fornecedor a
	WHERE a.forcodigo = '$parametro'
	ORDER BY a.forcodigo";


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
        $descricao1 = pg_fetch_result($sql, $i, "formaior");
        $descricao2 = pg_fetch_result($sql, $i, "formedio");
        $descricao3 = pg_fetch_result($sql, $i, "formenor");
        $descricao5 = pg_fetch_result($sql, $i, "formenord");
        $descricao4 = pg_fetch_result($sql, $i, "forminimo");

        if (trim($descricao1) == "") {
            $descricao1 = "0";
        }
        if (trim($descricao2) == "") {
            $descricao2 = "0";
        }
        if (trim($descricao3) == "") {
            $descricao3 = "0";
        }
        if (trim($descricao4) == "") {
            $descricao4 = "0";
        }
        if (trim($descricao5) == "") {
            $descricao5 = "0";
        }

        $xml .= "<dado>\n";
        $xml .= "<codigo>" . $codigo . "</codigo>\n";
        $xml .= "<descricao1>" . $descricao1 . "</descricao1>\n";
        $xml .= "<descricao2>" . $descricao2 . "</descricao2>\n";
        $xml .= "<descricao3>" . $descricao3 . "</descricao3>\n";
        $xml .= "<descricao4>" . $descricao4 . "</descricao4>\n";
        $xml .= "<descricao5>" . $descricao5 . "</descricao5>\n";
        $xml .= "</dado>\n";
    }//FECHA FOR                 

    $xml .= "</dados>\n";

    //CABEÇALHO
    Header("Content-type: application/xml; charset=iso-8859-1");
}//FECHA IF (row)                                               
//PRINTA O RESULTADO  
echo $xml;
?>
