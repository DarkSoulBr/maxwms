<?php

//RECEBE PARÃMETRO                     
$parametro = trim($_POST["parametro"]);

require_once("include/conexao.inc.php");
require_once("include/banco.php");

$cadastro = new banco($conn, $db);

//QUERY  

if (($parametro) != 0) {
    $sql = "
	SELECT a.medcodigo,a.mednome 
        FROM tipomedida a 
	WHERE a.medcodigo = '$parametro'
	ORDER BY a.medcodigo";
} else {
    $sql = " 

	SELECT a.medcodigo,a.mednome
        FROM  tipomedida a 
	ORDER BY a.mednome";
}

//XML
$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
$xml .= "<dados>\n";

/*
  $xml .= "<dado>\n";
  $xml .= "<codigo>0</codigo>\n";
  $xml .= "<descricao>-- Escolha a Unidade --</descricao>\n";
  $xml .= "</dado>\n";
 */

//EXECUTA A QUERY               
$sql = pg_query($sql);

$row = pg_num_rows($sql);

//VERIFICA SE VOLTOU ALGO 
if ($row) {

    //PERCORRE ARRAY            
    for ($i = 0; $i < $row; $i++) {
        $codigo = pg_fetch_result($sql, $i, "medcodigo");
        $descricao = pg_fetch_result($sql, $i, "mednome");
        $xml .= "<dado>\n";
        $xml .= "<codigo>" . $codigo . "</codigo>\n";
        $xml .= "<descricao>" . $descricao . "</descricao>\n";
        $xml .= "</dado>\n";
    }//FECHA FOR                 
}//FECHA IF (row)                                               

$xml .= "</dados>\n";

//CABEÇALHO
Header("Content-type: application/xml; charset=iso-8859-1");

//PRINTA O RESULTADO  
echo $xml;
?>
