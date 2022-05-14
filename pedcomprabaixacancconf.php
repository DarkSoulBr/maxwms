<?php

require_once("include/conexao.inc.php");
require_once("include/pedcomprabaixacanc.php");

$notentcodigo = $_GET["notentcodigo"];
$pcseq = $_GET["pcseq"];

$campo1 = $_GET["c"];
$campo2 = $_GET["d"];

$cadastro = new banco($conn, $db);

$sql = "SELECT pcnumero FROM notaent Where notentcodigo = $notentcodigo";
$sql = pg_query($sql);
$row = pg_num_rows($sql);

if ($row) {

    $pcnumero = pg_fetch_result($sql, 0, "pcnumero");



    for ($i = 0; $i < sizeof($campo1); $i++) {

        if (trim($campo2[$i]) != '0') {



            $sql = "SELECT pcibaixa,pcicodigo FROM pcitem Where pcnumero = $pcnumero
                    and procodigo = $campo1[$i]";
            $sql = pg_query($sql);
            $row = pg_num_rows($sql);

            if ($row) {

                $pcibaixa = pg_fetch_result($sql, 0, "pcibaixa");
                $pcicodigo = pg_fetch_result($sql, 0, "pcicodigo");
                $saldo = $pcibaixa - $campo2[$i];


                $cadastro->alterapcitem("pcitem", "pcibaixa=$saldo", "$pcicodigo");
            }
        }
    }

    $cadastro->apaga("notaent", "notentcodigo=$notentcodigo");
    $cadastro->apaga("neitem", "notentcodigo=$notentcodigo");
    //$cadastro->apaga("neitemsort", "notentcodigo=$notentcodigo");
}



pg_close($conn);
exit();
