<?php

require_once("include/conexao.inc.php");

$opcao = $_GET['opcao'];
$consultagrupo = $_GET['consultagrupo'];

if ($opcao == '1')
    $where = "grucodigo=" . $consultagrupo . " order by grucodigo";
else if ($opcao == '2')
    $where = "grunome like '%" . $consultagrupo . "%' order by grunome";

$sql = "Select grucodigo,grunome FROM grupo where $where asc";

//print($sql);

$cad = pg_query($sql);


if (pg_num_rows($cad)) {

    $row = pg_num_rows($cad);

    header("Content-type: application/xml");
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";
    $xml .= "<dados>";
    for ($i = 0; $i < $row; $i++) {

        $xml .= "<registro>";

        if ($opcao == '1') {
            $codigo = pg_fetch_result($cad, $i, "grucodigo");
            $xml .= "<item>" . $codigo . "</item>";
        }

        if ($opcao == '2') {
            $nome = pg_fetch_result($cad, $i, "grunome");
            $xml .= "<item>" . $nome . "</item>";
        }

        $xml .= "</registro>";
    }
    $xml .= "</dados>";
}
//die;
echo $xml;
pg_close($conn);
exit();
?>