<?php

//RECEBE PARÃMETRO                     
$parametro = trim($_POST["parametro"]);
//$parametro = 114;

require_once("include/conexao.inc.php");
require_once("include/produto.php");

$cadastro = new banco($conn, $db);

//QUERY  


$sql = "
	SELECT a.clacodigo,a.clanumero,a.claipi
        FROM clfiscal a 
	WHERE a.clacodigo = '$parametro'
	ORDER BY a.clacodigo";


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
        $codigo = pg_fetch_result($sql, $i, "clacodigo");
        $descricao1 = pg_fetch_result($sql, $i, "clanumero");
        $descricao2 = pg_fetch_result($sql, $i, "claipi");

        if (trim($descricao1) == "") {
            $descricao1 = "0";
        }
        if (trim($descricao2) == "") {
            $descricao2 = "0";
        }

        $xml .= "<dado>\n";
        $xml .= "<codigo>" . $codigo . "</codigo>\n";
        $xml .= "<descricao1>" . $descricao1 . "</descricao1>\n";
        $xml .= "<descricao2>" . $descricao2 . "</descricao2>\n";
        $xml .= "</dado>\n";
    }//FECHA FOR                 

    $xml .= "</dados>\n";

    //CABEÇALHO
    Header("Content-type: application/xml; charset=iso-8859-1");
}//FECHA IF (row)                                               
//PRINTA O RESULTADO  
echo $xml;
?>
