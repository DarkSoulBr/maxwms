<?php

require_once("include/conexao.inc.php");
require_once("include/romaneiosbaixa2.php");

$cadastro = new banco($conn, $db);
$pesquisa = $_GET["pesquisa"];

$pesquisa = "      " . $pesquisa;

if (isset($_GET["c"])) {
    $campo = $_GET["c"];
} else {
    $campo = [];
}
if (isset($_GET["d"])) {
    $campo2 = $_GET["d"];
} else {
    $campo2 = [];
}
if (isset($_GET["e"])) {
    $campo3 = $_GET["e"];
} else {
    $campo3 = [];
}
if (isset($_GET["f"])) {
    $campo4 = $_GET["f"];
} else {
    $campo4 = [];
}

$pesquisa1 = trim(substr($pesquisa, -12, 7));
$pesquisa2 = substr($pesquisa, -4, 4);

$data = $cadastro->seleciona2("$pesquisa1", "$pesquisa2");

//se encontrar registros
if (pg_num_rows($data)) {
    header("Content-type: application/xml");

    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";

    //preenchimento da Array com o nome dos campos
    for ($i = 0; $i < pg_num_fields($data); $i++) {
        $campos[$i] = pg_field_name($data, $i);
    }

    $xml .= "<dados>";
    $xml .= "<cabecalho>";

    //cabecalho da tabela
    for ($i = 0; $i < sizeof($campos); $i++) {
        $xml .= "<campo>" . $campos[$i] . "</campo>";
    }

    $xml .= "<campo>" . "controle" . "</campo>";

    $xml .= "</cabecalho>";

    //corpo da tabela
    while ($row = pg_fetch_object($data)) {
        $xml .= "<registro>";
        for ($i = 0; $i < sizeof($campos); $i++) {


            if (trim($row->{$campos[$i]}) == "") {
                $xml .= "<item>" . "0" . "</item>";
            } else {
                $xml .= "<item>" . $row->{$campos[$i]} . "</item>";
            }
        }

        $controle = '0';

        for ($j = 0; $j < sizeof($campo); $j++) {
            if ($row->{$campos['1']} == $campo[$j]) {

                if ($campo2[$j] == '0') {
                    $controle = '0';
                } else {
                    $controle = '1';
                }
            }
        }

        $xml .= "<item>" . $controle . "</item>";
        $xml .= "</registro>";
    }

    //fim da tabela
    $xml .= "</dados>";
}

echo $xml;
pg_close($conn);
exit();
?>