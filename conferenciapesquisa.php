<?php

require_once("include/conexao.inc.php");
require_once("include/conferencia.php");

//RECEBE PARÃMETRO

$conini = date('H') . ':' . date('i');

$parametro = trim($_POST["parametro"]);

$cadastro = new banco($conn, $db);

$sql = "SELECT
  a.pvnumero,a.pvemissao,b.clirazao as clinguerra,c.vennguerra,a.pvcondcon,
  a.pvobserva,a.pvperdesc,a.pvvalor,a.pvvaldesc,a.pvtipoped,a.pvorigem,a.pvdestino
  FROM  pvenda a
  LEft Join clientes as b on a.clicodigo = b.clicodigo
  LEft Join vendedor as c on a.vencodigo = c.vencodigo
  Where a.pvnumero = '$parametro'
  ORDER BY a.pvnumero";


//EXECUTA A QUERY
$sql = pg_query($sql);

$row = pg_num_rows($sql);

//VERIFICA SE VOLTOU ALGO
if ($row) {

    $pvtipoped = pg_fetch_result($sql, $i, "pvtipoped");
    if (trim($pvtipoped) == "S") {
        $sql = "SELECT
  a.pvnumero,a.pvemissao,b.etqnome as clinguerra,c.etqnome as vennguerra,a.pvcondcon,
  a.pvobserva,a.pvperdesc,a.pvvalor,a.pvvaldesc,a.pvtipoped,a.pvorigem,a.pvdestino
  FROM  pvenda a
  LEft Join estoque as b on a.pvorigem = b.etqcodigo
  LEft Join estoque as c on a.pvdestino = c.etqcodigo
  Where a.pvnumero = '$parametro'
  ORDER BY a.pvnumero";

        //EXECUTA A QUERY
        $sql = pg_query($sql);
        $row = pg_num_rows($sql);
    }
}

if ($row) {

    //XML
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $xml .= "<dados>\n";

    //PERCORRE ARRAY
    for ($i = 0; $i < $row; $i++) {



        $pvnumero = pg_fetch_result($sql, $i, "pvnumero");
        $pvemissao = pg_fetch_result($sql, $i, "pvemissao");
        $clinguerra = pg_fetch_result($sql, $i, "clinguerra");
        $vennguerra = pg_fetch_result($sql, $i, "vennguerra");
        $pvcondcon = pg_fetch_result($sql, $i, "pvcondcon");
        $pvobserva = pg_fetch_result($sql, $i, "pvobserva");
        $pvperdesc = pg_fetch_result($sql, $i, "pvperdesc");
        $pvvalor = pg_fetch_result($sql, $i, "pvvalor");
        $pvvaldesc = pg_fetch_result($sql, $i, "pvvaldesc");
        $pvtipoped = pg_fetch_result($sql, $i, "pvtipoped");

        $pvorigem = pg_fetch_result($sql, $i, "pvorigem");
        $pvdestino = pg_fetch_result($sql, $i, "pvdestino");

        if (trim($clinguerra) == "") {
            $clinguerra = $pvorigem;
        }
        if (trim($vennguerra) == "") {
            $vennguerra = $pvdestino;
        }

        if (trim($pvnumero) == "") {
            $pvnumero = "0";
        }
        if ($pvemissao <> "") {
            $pvemissao = substr($pvemissao, 8, 2) . '/' . substr($pvemissao, 5, 2) . '/' . substr($pvemissao, 0, 4);
        }

        if (trim($pvemissao) == "") {
            $pvemissao = "0";
        }
        if (trim($clinguerra) == "") {
            $clinguerra = "0";
        }
        if (trim($vennguerra) == "") {
            $vennguerra = "0";
        }
        if (trim($pvcondcon) == "") {
            $pvcondcon = "0";
        }
        if (trim($pvobserva) == "") {
            $pvobserva = "0";
        }
        if (trim($pvperdesc) == "") {
            $pvperdesc = "0";
        }
        if (trim($pvvalor) == "") {
            $pvvalor = "0";
        }
        if (trim($pvvaldesc) == "") {
            $pvvaldesc = "0";
        }
        if (trim($pvtipoped) == "") {
            $pvtipoped = "0";
        }

        if (trim($pvtipoped) == "S") {
            $clinguerra = $pvorigem . ' - ' . $clinguerra;
            $vennguerra = $pvdestino . ' - ' . $vennguerra;
        }

        $xml .= "<dado>\n";
        $xml .= "<pvnumero>" . $pvnumero . "</pvnumero>\n";
        $xml .= "<pvemissao>" . $pvemissao . "</pvemissao>\n";
        $xml .= "<clinguerra>" . $clinguerra . "</clinguerra>\n";
        $xml .= "<vennguerra>" . $vennguerra . "</vennguerra>\n";
        $xml .= "<pvcondcon>" . $pvcondcon . "</pvcondcon>\n";
        $xml .= "<pvobserva>" . $pvobserva . "</pvobserva>\n";
        $xml .= "<pvperdesc>" . $pvperdesc . "</pvperdesc>\n";
        $xml .= "<pvvalor>" . $pvvalor . "</pvvalor>\n";
        $xml .= "<pvvaldesc>" . $pvvaldesc . "</pvvaldesc>\n";
        $xml .= "<pvtipoped>" . $pvtipoped . "</pvtipoped>\n";
        $xml .= "<conini>" . $conini . "</conini>\n";

        $xml .= "</dado>\n";
    }//FECHA FOR

    $xml .= "</dados>\n";

    //CABEÇALHO

    Header("Content-type: application/xml; charset=iso-8859-1");
}//FECHA IF (row)
//PRINTA O RESULTADO
echo $xml;
?>
