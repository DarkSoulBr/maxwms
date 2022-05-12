<?php

require_once("include/conexao.inc.php");
require_once("include/consultaromaneios.php");

$dtinicio = trim($_GET["dtinicio"]);
$dtfinal = trim($_GET["dtfinal"]);

$dtinicio = substr($dtinicio, 6,4).substr($dtinicio, 3,2).substr($dtinicio, 0,2);
$dtfinal = substr($dtfinal, 6,4).substr($dtfinal, 3,2).substr($dtfinal, 0,2);

$cadastro = new banco($conn, $db);
$data = $cadastro->seleciona($dtinicio, $dtfinal);

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
    $xml .= "<campo>" . "total" . "</campo>";
    $xml .= "</cabecalho>";

    //corpo da tabela
    while ($row = pg_fetch_object($data)) {
        $xml .= "<registro>";
        $pvnumero = 0;
        for ($i = 0; $i < sizeof($campos); $i++) {


            if ($i == 11) {

                $ntvalnot = 0;

                $romcodigo = $row->{$campos[$i]};

                $pegar1 = "Select a.pvnumero
                        FROM romaneiospedidos a
                        WHERE a.romcodigo = $romcodigo
                        order by a.pvnumero";

                $cad1 = pg_query($pegar1);
                $row1 = pg_num_rows($cad1);

                for ($i1 = 0; $i1 < $row1; $i1++) {

                    $pvnumero = pg_fetch_result($cad1, $i1, "pvnumero");

                    $pegar2 = "Select a.notvalor
                                FROM notadep a
                                WHERE a.pvnumero = $pvnumero
                                order by a.notnumero";

                    $cad2 = pg_query($pegar2);
                    $row2 = pg_num_rows($cad2);

                    if ($row2) {

                        for ($i2 = 0; $i2 < $row2; $i2++) {
                            $notvalor = pg_fetch_result($cad2, $i2, "notvalor");
                            $ntvalnot = $ntvalnot + $notvalor;
                        }
                    } else {


                        $pegar3 = "Select a.pvvalor
                                    FROM pvenda a
                                    WHERE a.pvnumero = $pvnumero
                                    ";

                        $cad3 = pg_query($pegar3);
                        $row3 = pg_num_rows($cad3);

                        if ($row3) {
                            $pvvalor = pg_fetch_result($cad3, 0, "pvvalor");
                            $ntvalnot = $ntvalnot + $pvvalor;
                        }
                    }
                }



                $xml .= "<item>" . $ntvalnot . "</item>";
            } else {


                $xml .= "<item>" . $row->{$campos[$i]} . "</item>";
            }
        }

        if($pvnumero) {
            $pegar4 = "Select a.pviest01,a.pviest02,a.pviest03,a.pviest09, a.pviest011
            FROM pvitem a
            WHERE a.pvnumero = $pvnumero
            ";

            $cad4 = pg_query($pegar4);
            $row4 = pg_fetch_row($cad4);

            if ($row4[0] > 0) {
                $xml .= "<item>FILIAL</item>";
            } else if ($row4[1] > 0) {
                $xml .= "<item>MATRIZ</item>";
            } else if ($row4[2] > 0) {
                $xml .= "<item>CD</item>";
            } else if ($row4[3] > 0) {
                $xml .= "<item>CD</item>";
            } else if ($row4[4] > 0) {
                $xml .= "<item>VIX</item>";
            } else {
                $xml .= "<item>SP</item>";
            }
        } else {
            $xml .= "<item>_</item>";
        }


        $xml .= "</registro>";
    }

    //fim da tabela
    $xml .= "</dados>";
}

echo $xml;
pg_close($conn);
exit();
?>