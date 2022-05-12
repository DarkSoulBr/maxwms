<?php

require_once("include/conexao.inc.php");
require_once("include/banco.php");

$cadastro = new banco($conn, $db);

$codigo = $_GET["parametro"];

$sql = "select a.segcodigo,a.segnome,a.segvalor,a.rescodigo,a.segapolice,a.segaverbacao from infoseguro a 
where a.segcodigo=$codigo order by a.segcodigo";

$sql = pg_query($sql);
$row = pg_num_rows($sql);

//VERIFICA SE VOLTOU ALGO
if ($row) {

    header("Content-type: application/xml");

    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";

    $xml .= "<dados>";
    $xml .= "<cabecalho>";
    $xml .= "<campo>codigo</campo>";
    $xml .= "<campo>medida</campo>";
    $xml .= "<campo>nome</campo>";
    $xml .= "<campo>valor</campo>";
    $xml .= "<campo>apolice</campo>";
    $xml .= "<campo>averbacao</campo>";
    $xml .= "</cabecalho>";

    //PERCORRE ARRAY
    for ($i = 0; $i < $row; $i++) {

        $codigo = pg_fetch_result($sql, $i, "segcodigo");
        $medida = pg_fetch_result($sql, $i, "rescodigo");
        $nome = pg_fetch_result($sql, $i, "segnome");
        $valor = pg_fetch_result($sql, $i, "segvalor");
        $apolice = pg_fetch_result($sql, $i, "segapolice");
        $averbacao = pg_fetch_result($sql, $i, "segaverbacao");

        if (trim($codigo) == "") {
            $codigo = "0";
        }
        if (trim($nome) == "") {
            $nome = "_";
        }
        if (trim($valor) == "") {
            $valor = "0";
        }
        if (trim($medida) == "") {
            $medida = "0";
        }
        if (trim($apolice) == "") {
            $apolice = "_";
        }
        if (trim($averbacao) == "") {
            $averbacao = "_";
        }

        $valor = number_format($valor, 2, ".", "");

        $xml .= "<registro>";
        $xml .= "<item>" . $codigo . "</item>";
        $xml .= "<item>" . $medida . "</item>";
        $xml .= "<item>" . $nome . "</item>";
        $xml .= "<item>" . $valor . "</item>";
        $xml .= "<item>" . $apolice . "</item>";
        $xml .= "<item>" . $averbacao . "</item>";
        $xml .= "</registro>";
    }//FECHA FOR

    $xml .= "</dados>";
}

echo $xml;
pg_close($conn);
exit();
?>