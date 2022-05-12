<?php

require_once("include/conexao.inc.php");
require_once("include/banco.php");

$cadastro = new banco($conn, $db);

$codigo = $_GET["parametro"];

$sql = "select a.infmotcodigo,a.infmotnome,a.infmotcpf from infomotoristas a 
where a.infmotcodigo=$codigo order by a.infmotcodigo";

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
    $xml .= "<campo>valor</campo>";
    $xml .= "</cabecalho>";

    //PERCORRE ARRAY
    for ($i = 0; $i < $row; $i++) {

        $codigo = pg_fetch_result($sql, $i, "infmotcodigo");
        $nome = pg_fetch_result($sql, $i, "infmotnome");
        $valor = pg_fetch_result($sql, $i, "infmotcpf");

        if (trim($codigo) == "") {
            $codigo = "0";
        }
        if (trim($nome) == "") {
            $nome = "_";
        }
        if (trim($valor) == "") {
            $valor = "_";
        }

        $xml .= "<registro>";
        $xml .= "<item>" . $codigo . "</item>";
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