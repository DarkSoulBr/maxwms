<?php

require_once("include/conexao.inc.php");
require_once("include/banco.php");

$cadastro = new banco($conn, $db);

$usucodigo = $_GET["parametro"];

//Verifica se o produto já está cadastrado
$sql = "select sum(a.valvalor) as total from valorservico a 
where a.usucodigo=$usucodigo";


$sql = pg_query($sql);
$row = pg_num_rows($sql);

//VERIFICA SE VOLTOU ALGO
if ($row) {

    header("Content-type: application/xml");

    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";

    $xml .= "<dados>";
    $xml .= "<cabecalho>";
    $xml .= "<campo>valor</campo>";
    $xml .= "</cabecalho>";


    $valor = pg_fetch_result($sql, 0, "total");
    if (trim($valor) == "") {
        $valor = "0";
    }

    $valor = number_format($valor, 2, ".", "");

    $xml .= "<registro>";
    $xml .= "<item>" . $valor . "</item>";
    $xml .= "</registro>";


    $xml .= "</dados>";
}

echo $xml;
pg_close($conn);
exit();
?>