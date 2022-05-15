<?php

//RECEBE PARÃMETRO
$parametro = trim($_POST["parametro"]);
$invdata = trim($_POST["parametro2"]);
$parametro3 = trim($_POST["parametro3"]);
$parametro4 = trim($_POST["parametro4"]);
$parametro5 = trim($_POST["parametro5"]);

$aux = explode("/", $invdata);
$invdata = $aux[2] . '-' . $aux[1] . '-' . $aux[0] . ' 00:00:00-03';

require_once("include/conexao.inc.php");
require_once("include/conferencia.php");

$cadastro = new banco($conn, $db);

//QUERY

$sql = "
SELECT p.procodigo as codigo, 0 as descricao, d.quantidade as pvcconfere
FROM  produto p
Left Join inventariocontagemsetorproduto as d on d.procodigo = p.procodigo and invdata = '$invdata' and concodigo = $parametro3 and setcodigo = $parametro4 and colcodigo = $parametro5 
Where p.procod = '$parametro'
ORDER BY p.procodigo";

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
