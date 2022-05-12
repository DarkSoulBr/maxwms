<?php

require_once("include/conexao.inc.php");
require_once("include/clientesvinculados.php");

$cadastro = new banco($conn, $db);
$pesquisa = $_GET["pesquisa"];

$sql = "Select vlccodigo from vinccli Where clicodigo = $pesquisa";
$cad = pg_query($sql);

$pesquisa2 = 99999999;
if ($cad) {
    if (pg_num_rows($cad)) {
        $pesquisa2 = pg_fetch_result($cad, 0, "vlccodigo");
    }


    $data = $cadastro->seleciona2("vinccli", "clientes", "$pesquisa", "$pesquisa2");

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

        $xml .= "</cabecalho>";

        //corpo da tabela
        while ($row = pg_fetch_object($data)) {
            $xml .= "<registro>";
            for ($i = 0; $i < sizeof($campos); $i++) {

                if (trim($row->{$campos[$i]}) == "") {
                    $xml .= "<item>" . "_" . "</item>";
                } else {
                    $xml .= "<item>" . $row->{$campos[$i]} . "</item>";
                }
            }
            $xml .= "</registro>";
        }

        //fim da tabela
        $xml .= "</dados>";
    }
}

echo $xml;
pg_close($conn);
exit();
?>