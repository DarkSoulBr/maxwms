<?php

require_once("include/conexao.inc.php");
require_once("include/banco.php");

$cadastro = new banco($conn, $db);

$usucodigo = $_GET["usucodigo"];

$sql = "select a.concodigo,a.connome,a.conobs from obscontribuinte a 
where a.usucodigo=$usucodigo order by a.concodigo";

//echo $sql;
//die;

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
    $xml .= "<campo>obs</campo>";
    $xml .= "</cabecalho>";

    //PERCORRE ARRAY
    for ($i = 0; $i < $row; $i++) {

        $codigo = pg_fetch_result($sql, $i, "concodigo");
        $nome = pg_fetch_result($sql, $i, "connome");
        $obs = trim(pg_fetch_result($sql, $i, "conobs"));

        if (trim($codigo) == "") {
            $codigo = "0";
        }
        if (trim($nome) == "") {
            $nome = "_";
        }
        if (trim($obs) == "") {
            $obs = "_";
        }

        $xml .= "<registro>";
        $xml .= "<item>" . $codigo . "</item>";
        $xml .= "<item>" . $nome . "</item>";
        $xml .= "<item>" . $obs . "</item>";
        $xml .= "</registro>";
    }//FECHA FOR

    $xml .= "</dados>";
}

echo $xml;
pg_close($conn);
exit();
?>