<?php

require('./_app/Config.inc.php');

$parametro = trim($_POST["parametro"]);
$parametro2 = trim($_POST["parametro2"]);

$read = new Read;
if ($parametro2 == 1) {
    $read->FullRead("SELECT a.etqcodigo AS codigo,a.etqnome AS descricao,a.reserva,a.consultas,a.zerou,a.etqsigla,a.empcodigo FROM estoque a WHERE a.etqnome LIKE '%$parametro%' ORDER BY a.etqnome");
} else if ($parametro2 == 2) {
    $read->FullRead("SELECT a.etqcodigo AS codigo,a.etqnome AS descricao,a.reserva,a.consultas,a.zerou,a.etqsigla,a.empcodigo FROM estoque a WHERE a.etqcodigo = '$parametro'");
}

if ($read->getRowCount() >= 1) {

    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $xml .= "<dados>\n";

    foreach ($read->getResult() as $registros) {

        extract($registros);

        if (trim($codigo) == "") {
            $codigo = "0";
        }
        if (trim($descricao) == "") {
            $descricao = "0";
        }
        if (trim($reserva) == "") {
            $reserva = "N";
        }
        if (trim($consultas) == "") {
            $consultas = "S";
        }
        if (trim($zerou) == "") {
            $zerou = "N";
        }

        if (trim($etqsigla) == "") {
            $etqsigla = "_";
        }
        if (trim($empcodigo) == "") {
            $empcodigo = 1;
        }

        $xml .= "<dado>\n";
        $xml .= "<codigo>" . $codigo . "</codigo>\n";
        $xml .= "<descricao>" . $descricao . "</descricao>\n";
        $xml .= "<reserva>" . $reserva . "</reserva>\n";
        $xml .= "<consultas>" . $consultas . "</consultas>\n";
        $xml .= "<zerou>" . $zerou . "</zerou>\n";
        $xml .= "<etqsigla>" . $etqsigla . "</etqsigla>\n";
        $xml .= "<empcodigo>" . $empcodigo . "</empcodigo>\n";
        $xml .= "</dado>\n";
    }

    $xml .= "</dados>\n";



    Header("Content-type: application/xml; charset=iso-8859-1");
}


echo $xml;

