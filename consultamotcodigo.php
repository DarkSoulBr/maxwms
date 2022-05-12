<?php

require_once("include/conexao.inc.php");

$opcao = $_GET['opcao'];
$nome = $_GET['nome'];


$sql = "SELECT a.motcodigo,a.motcod,a.motrazao,a.motcpf 
       FROM  motoristas a";

if ($nome == '') {
    if ($opcao == "1") {
        $sql = $sql . " ORDER BY a.motcod";
    } elseif ($opcao == "2") {
        $sql = $sql . " ORDER BY a.motrazao";
    } else {
        $sql = $sql . " ORDER BY a.motcpf";
    }
} else {
    if ($opcao == "1") {
        $sql = $sql . " WHERE a.motcod = '$nome' ORDER BY a.motcod";
    } elseif ($opcao == "2") {
        $sql = $sql . " WHERE a.motrazao like '%$nome%' ORDER BY a.motrazao";
    } else {
        $sql = $sql . " WHERE a.motcpf like '%$nome%' ORDER BY a.motcpf";
    }
}

$cad = pg_query($sql);


if (pg_num_rows($cad)) {

    $row = pg_num_rows($cad);

    header("Content-type: application/xml");
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";
    $xml .= "<dados>";
    for ($i = 0; $i < $row; $i++) {
        $xml .= "<registro>";

        $codigo = pg_fetch_result($cad, $i, "motcodigo");
        $xml .= "<item>" . $codigo . "</item>";

        $cod = pg_fetch_result($cad, $i, "motcod");
        $xml .= "<item>" . $cod . "</item>";

        $nome = pg_fetch_result($cad, $i, "motrazao");
        $xml .= "<item>" . $nome . "</item>";

        $proref = pg_fetch_result($cad, $i, "motcpf");
        $xml .= "<item>" . $proref . "</item>";

        $xml .= "</registro>";
    }
    $xml .= "</dados>";
}

echo $xml;
pg_close($conn);
exit();
?>
