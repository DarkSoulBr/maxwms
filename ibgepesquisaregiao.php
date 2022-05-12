<?php

//RECEBE PARÃMETRO
$parametro = trim($_POST["parametro"]);

require_once("include/conexao.inc.php");
require_once("include/regiaocidade.php");

$cadastro = new banco($conn, $db);

$est = substr($parametro, 0, 2);
$cid = substr($parametro, 2, 5);

$sql = "SELECT a.id,a.descricao,a.uf,a.codestado,a.codcidade,b.regcodigo,c.regnome  
		FROM  cidadesibge a 
		left join regiaocidade b on a.id=b.cidcodigo 
		left join regioes c on b.regcodigo=c.regicodigo 
	    WHERE a.codestado = '$est' and a.codcidade = '$cid'";

//EXECUTA A QUERY
$sql = pg_query($sql);

$row = pg_num_rows($sql);

$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
$xml .= "<dados>\n";
$xml .= "<dado>\n";
//VERIFICA SE VOLTOU ALGO
if ($row) {
    $codigo = pg_fetch_result($sql, 0, "regnome");
    if ($codigo == '') {
        $codigo = '_';
    }
    $xml .= "<codigo>" . $codigo . "</codigo>\n";
} else {
    $xml .= "<codigo>_</codigo>\n";
}
$xml .= "</dado>\n";
$xml .= "</dados>\n";

//CABEÇALHO
Header("Content-type: application/xml; charset=iso-8859-1");

//PRINTA O RESULTADO
echo $xml;
?>