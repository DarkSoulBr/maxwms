<?php

require_once("include/conexao.inc.php");

$ctenumero = trim($_GET["ctenumero"]);

$pegar = "SELECT * FROM ctecartacorrecao WHERE ctenumero = '{$ctenumero}'";

$cad = pg_query($pegar);
$row = pg_num_rows($cad);

$xml = '';
if ($row) {

    header("Content-type: application/xml");

    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";

    $xml .= "<dados>";

    for ($i = 0; $i < $row; $i++) {

        $cccdata = date('d/m/Y H:i', strtotime(pg_fetch_result($cad, $i, "cccdata")));
        $cccchave = pg_fetch_result($cad, $i, "cccchave");

        $cccseq = pg_fetch_result($cad, $i, "cccseq");
        $ccccodigo = pg_fetch_result($cad, $i, "ccccodigo");

        $cccnprot = trim(pg_fetch_result($cad, $i, "cccnprot")) == '' ? '_' : trim(pg_fetch_result($cad, $i, "cccnprot"));
        $cccrecebto = trim(pg_fetch_result($cad, $i, "cccrecebto")) == '' ? '_' : date('d/m/Y H:i', strtotime(pg_fetch_result($cad, $i, "cccrecebto")));
        $cccmotivo = trim(pg_fetch_result($cad, $i, "cccmotivo")) == '' ? '_' : trim(pg_fetch_result($cad, $i, "cccmotivo"));

        if ($cccnprot != '_') {

            $pegar2 = "SELECT ctenum FROM cte WHERE ctenumero = '{$ctenumero}'";

            $cad2 = pg_query($pegar2);
            $row2 = pg_num_rows($cad2);

            if ($row2) {

                $ctenum = pg_fetch_result($cad2, 0, "ctenum");

                $ctechave = substr($cccchave, 8, 44) . '_' . substr($cccchave, 2, 6) . '_' . substr($cccchave, 52, 2);

                $logpdf = "arquivos/cte/" . $ctenum . "/" . $ctechave . "-procEventoCTe.pdf";

                // Verifica se o arquivo existe
                if (!file_exists($logpdf)) {
                    $logpdf = "_";
                }
                $logxml = "arquivos/cte/" . $ctenum . "/" . $ctechave . "-procEventoCTe.xml";
                // Verifica se o arquivo existe
                if (!file_exists($logxml)) {
                    $logxml = "_";
                }
            } else {
                $logpdf = "_";
                $logxml = "_";
            }
        } else {
            $logpdf = "_";
            $logxml = "_";
        }


        $xml .= "<registro>";
        $xml .= "<item>" . $cccdata . "</item>";
        //$xml .= "<item>" . $cccchave . "</item>";
        $xml .= "<item>" . $cccseq . "</item>";
        $xml .= "<item>" . $cccnprot . "</item>";
        $xml .= "<item>" . $cccrecebto . "</item>";
        $xml .= "<item>" . $cccmotivo . "</item>";
        $xml .= "<item>" . $logpdf . "</item>";
        $xml .= "<item>" . $logxml . "</item>";
        $xml .= "<item>" . $ccccodigo . "</item>";

        $xml .= "</registro>";
    }

    $xml .= "</dados>";
}

echo $xml;
pg_close($conn);
