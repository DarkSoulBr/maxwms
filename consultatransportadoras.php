<?php

require_once("include/conexao.inc.php");

$opcao = $_GET['opcao'];
$consultatransportadora = $_GET['consultatransportadora'];

if ($opcao == '1')
    $where = "tracodigo=" . $consultatransportadora . " order by tracodigo";
else if ($opcao == '2')
    $where = "tranguerra like '%" . $consultatransportadora . "%' order by tranguerra";
else if ($opcao == '3')
    $where = "trarazao like '%" . $consultatransportadora . "%' order by trarazao";

$sql = "Select tracodigo,tracodigo as tracod,trarazao,tranguerra FROM transportador where $where asc";

$cad = pg_query($sql);

if (pg_num_rows($cad)) {

    $row = pg_num_rows($cad);

    header("Content-type: application/xml");
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";
    $xml .= "<dados>";
    for ($i = 0; $i < $row; $i++) {

        $xml .= "<registro>";

        //if($opcao=='1')
        //{
        $codigo = pg_fetch_result($cad, $i, "tracodigo");
        $xml .= "<item>" . $codigo . "</item>";
        //}

        $cod = pg_fetch_result($cad, $i, "tracodigo");
        $xml .= "<item>" . $cod . "</item>";

        if ($opcao == '1' || $opcao == '2') {
            $nomeguerra = pg_fetch_result($cad, $i, "tranguerra");
            $xml .= "<item>" . $nomeguerra . "</item>";
        }
        if ($opcao == '3') {
            $nome = pg_fetch_result($cad, $i, "trarazao");
            $xml .= "<item>" . $nome . "</item>";
        }

        $xml .= "</registro>";
    }
    $xml .= "</dados>";
}
echo $xml;
pg_close($conn);
exit();
?>
