<?php

//RECEBE PARÃMETRO
$parametro = trim($_POST["parametro"]);
$parametro2 = trim($_POST["parametro2"]);

require_once("include/conexao.inc.php");
require_once("include/conferencia.php");

$cadastro = new banco($conn, $db);

//QUERY

$sql = "
SELECT b.procodigo as codigo, b.pviest09 as descricao,d.pvcconfere
FROM  produto p,pvitem b
Left Join pvendaconfere as d on d.procodigo = b.procodigo and d.pvnumero = '$parametro2'
Where p.procod = '$parametro'
AND b.procodigo = p.procodigo
AND b.pvnumero = '$parametro2'
ORDER BY b.procodigo";

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
        $codigo = pg_fetch_result($sql, $i, "codigo");
        $descricao = pg_fetch_result($sql, $i, "descricao");
        $pvcconfere = pg_fetch_result($sql, $i, "pvcconfere");
        if (trim($pvcconfere) == "") {
            $pvcconfere = "0";
        }
        $xml .= "<dado>\n";
        $xml .= "<codigo>" . $codigo . "</codigo>\n";
        $xml .= "<descricao>" . $descricao . "</descricao>\n";
        $xml .= "<pvcconfere>" . $pvcconfere . "</pvcconfere>\n";
        $xml .= "</dado>\n";
    }//FECHA FOR

    $xml .= "</dados>\n";

    //CABEÇALHO
    Header("Content-type: application/xml; charset=iso-8859-1");
}//FECHA IF (row)
//PRINTA O RESULTADO
echo $xml;
?>
