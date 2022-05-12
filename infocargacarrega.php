<?php

require_once("include/conexao.inc.php");
require_once("include/banco.php");

$cadastro = new banco($conn, $db);

$codigo = $_GET["parametro"];

//Verifica se o produto j� est� cadastrado
$sql = "select a.infcodigo,a.infnome,a.infvalor,a.medcodigo from infocarga a 
where a.infcodigo=$codigo order by a.infcodigo";

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
    $xml .= "</cabecalho>";

    //PERCORRE ARRAY
    for ($i = 0; $i < $row; $i++) {

        $codigo = pg_fetch_result($sql, $i, "infcodigo");
        $medida = pg_fetch_result($sql, $i, "medcodigo");
        $nome = pg_fetch_result($sql, $i, "infnome");
        $valor = pg_fetch_result($sql, $i, "infvalor");

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

        $valor = number_format($valor, 4, ".", "");

        $xml .= "<registro>";
        $xml .= "<item>" . $codigo . "</item>";
        $xml .= "<item>" . $medida . "</item>";
        $xml .= "<item>" . $nome . "</item>";
        $xml .= "<item>" . $valor . "</item>";
        $xml .= "</registro>";
    }//FECHA FOR

    $xml .= "</dados>";
}

echo $xml;
pg_close($conn);
exit();
?>