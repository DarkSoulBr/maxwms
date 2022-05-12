<?php

require_once("include/conexao.inc.php");
require_once("include/banco.php");

$cadastro = new banco($conn, $db);

$codigo = $_GET["parametro"];

$sql = "select a.pedcodigo,a.pednome,a.pedvalor,a.pedforne,a.pedrespo from infopedagio a 
where a.pedcodigo=$codigo order by a.pedcodigo";

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
    $xml .= "<campo>forne</campo>";
    $xml .= "<campo>respo</campo>";
    $xml .= "<campo>valor</campo>";
    $xml .= "</cabecalho>";

    //PERCORRE ARRAY
    for ($i = 0; $i < $row; $i++) {

        $codigo = pg_fetch_result($sql, $i, "pedcodigo");
        $nome = pg_fetch_result($sql, $i, "pednome");
        $forne = pg_fetch_result($sql, $i, "pedforne");
        $respo = pg_fetch_result($sql, $i, "pedrespo");
        $valor = pg_fetch_result($sql, $i, "pedvalor");

        if (trim($codigo) == "") {
            $codigo = "0";
        }
        if (trim($nome) == "") {
            $nome = "_";
        }
        if (trim($respo) == "") {
            $respo = "_";
        }
        if (trim($forne) == "") {
            $forne = "_";
        }
        if (trim($valor) == "") {
            $valor = "0";
        }

        $xml .= "<registro>";
        $xml .= "<item>" . $codigo . "</item>";
        $xml .= "<item>" . $nome . "</item>";
        $xml .= "<item>" . $forne . "</item>";
        $xml .= "<item>" . $respo . "</item>";
        $xml .= "<item>" . $valor . "</item>";
        $xml .= "</registro>";
    }//FECHA FOR

    $xml .= "</dados>";
}

echo $xml;
pg_close($conn);
exit();
?>