<?php

require_once("include/conexao.inc.php");
require_once("include/banco.php");

$cadastro = new banco($conn, $db);

$usucodigo = $_GET["usucodigo"];


$sql = "select a.dupcodigo,a.dupnome,a.dupvalor,a.dupvecto from infoduplicata a 
where a.usucodigo=$usucodigo order by a.dupcodigo";

$sql = pg_query($sql);
$row = pg_num_rows($sql);

//VERIFICA SE VOLTOU ALGO
if ($row) {

    header("Content-type: application/xml");

    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";

    $xml .= "<dados>";
    $xml .= "<cabecalho>";
    $xml .= "<campo>codigo</campo>";
    $xml .= "<campo>nome</campo>";
    $xml .= "<campo>vecto</campo>";
    $xml .= "<campo>valor</campo>";
    $xml .= "</cabecalho>";

    //PERCORRE ARRAY
    for ($i = 0; $i < $row; $i++) {

        $codigo = pg_fetch_result($sql, $i, "dupcodigo");
        $vecto = pg_fetch_result($sql, $i, "dupvecto");
        $nome = pg_fetch_result($sql, $i, "dupnome");
        $valor = pg_fetch_result($sql, $i, "dupvalor");

        if (trim($codigo) == "") {
            $codigo = "0";
        }
        if (trim($nome) == "") {
            $nome = "_";
        }
        if (trim($vecto) == "") {
            $vecto = "_";
        }
        if (trim($valor) == "") {
            $valor = "0";
        }

        $vecto = substr($vecto, 8, 2) . '/' . substr($vecto, 5, 2) . '/' . substr($vecto, 0, 4);

        $valor = number_format($valor, 2, ",", ".");

        $xml .= "<registro>";
        $xml .= "<item>" . $codigo . "</item>";
        $xml .= "<item>" . $nome . "</item>";
        $xml .= "<item>" . $vecto . "</item>";
        $xml .= "<item>" . $valor . "</item>";
        $xml .= "</registro>";
    }//FECHA FOR

    $xml .= "</dados>";
}

echo $xml;
pg_close($conn);
exit();
?>