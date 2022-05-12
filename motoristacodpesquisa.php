<?php

require_once("include/conexao.inc.php");
require_once("include/banco.php");

//RECEBE PAR�METRO

$parametro = trim($_POST["parametro"]);

$cadastro = new banco($conn, $db);


$sql = "
       SELECT max(a.motcod) as codigo
       FROM  motoristas a";

$sql = pg_query($sql);

$row = pg_num_rows($sql);

//VERIFICA SE VOLTOU ALGO
if ($row) {

    //XML
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $xml .= "<dados>\n";

    //PERCORRE ARRAY
    for ($i = 0; $i < $row; $i++) {
        $codigo = (pg_fetch_result($sql, $i, "codigo") + 1);
        $xml .= "<dado>\n";
        $xml .= "<codigo>" . $codigo . "</codigo>\n";
        $xml .= "</dado>\n";
    }//FECHA FOR

    $xml .= "</dados>\n";

    //CABE�ALHO

    Header("Content-type: application/xml; charset=iso-8859-1");
}//FECHA IF (row)
//PRINTA O RESULTADO
echo $xml;
?>
