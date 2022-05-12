<?php

require_once("include/conexao.inc.php");

//RECEBE PARÃMETRO
$parametro = trim($_POST["parametro"]);


//QUERY

$sql = "
   		SELECT ib.codestado, ib.codcidade, ib.descricao as cidadeibge
        		FROM  cidadesibge ib
				WHERE ib.uf = '$parametro'
				ORDER BY ib.descricao";


//EXECUTA A QUERY
$sql = pg_query($sql);
$row = pg_num_rows($sql);

//VERIFICA SE VOLTOU ALGO
if ($row) {
    //XML
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $xml .= "<dadosib>\n";

    //PERCORRE ARRAY
    for ($i = 0; $i < $row; $i++) {
        $codestado = pg_fetch_result($sql, $i, "codestado");
        $codcidade = pg_fetch_result($sql, $i, "codcidade");
        $cidadeibge = pg_fetch_result($sql, $i, "cidadeibge");

        $aux = $codestado . $codcidade;

        $xml .= "<dadoib>\n";
        $xml .= "<codigoib>" . $aux . "</codigoib>\n";
        $xml .= "<cidadeib>" . $cidadeibge . "</cidadeib>\n";
        $xml .= "</dadoib>\n";
    }//FECHA FOR
    $xml .= "</dadosib>\n";

    //CABEÇALHO
    Header("Content-type: application/xml; charset=iso-8859-1");
}//FECHA IF (row)
//PRINTA O RESULTADO
echo $xml;
?>