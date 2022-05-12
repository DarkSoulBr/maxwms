<?php

//RECEBE PARÃMETRO                     
$parametro = trim($_POST["parametro"]);

require_once("include/conexao.inc.php");
require_once("include/transportador.php");

$cadastro = new banco($conn, $db);

$sql = "SELECT a.tracodigo,a.tranguerra,a.trarazao,a.tracep,a.traendereco,
        a.trabairro,a.trafone,a.trafax,a.traemail,a.traobs,a.cidcodigo,b.descricao,b.uf,a.rotcodigo,a.tpfcodigo,a.tracnpj,a.traie,
        a.doccobvers,
        a.ocorenvers,
        a.conembvers,
        a.notfisvers,
        a.diredi,a.datcodigo,a.traretirada,a.tratptolera,a.tratolera   
       FROM  transportador a
        Left Join cidades as b on a.cidcodigo = b.cidcodigo
 	WHERE a.tracodigo = '$parametro'
	ORDER BY a.tranguerra";

//EXECUTA A QUERY
$sql = pg_query($sql);

$row = pg_num_rows($sql);

//VERIFICA SE VOLTOU ALGO
if ($row) {
    //XML
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $xml .= "<dados>\n";

    //PERCORRE ARRAY
    for ($i = 0; $i < $row; $i++) {
        $codigo = pg_fetch_result($sql, $i, "tracodigo");
        $descricao = pg_fetch_result($sql, $i, "tranguerra");
        $descricaob = pg_fetch_result($sql, $i, "trarazao");
        $descricaoc = pg_fetch_result($sql, $i, "tracep");
        $descricaod = pg_fetch_result($sql, $i, "traendereco");
        $descricaoe = pg_fetch_result($sql, $i, "trabairro");
        $descricaof = pg_fetch_result($sql, $i, "trafone");
        $descricaog = pg_fetch_result($sql, $i, "trafax");
        $descricaoh = pg_fetch_result($sql, $i, "traemail");
        $descricaoi = pg_fetch_result($sql, $i, "traobs");
        $descricaoj = pg_fetch_result($sql, $i, "cidcodigo");
        $descricaok = pg_fetch_result($sql, $i, "descricao");
        $descricaol = pg_fetch_result($sql, $i, "uf");
        $descricaom = pg_fetch_result($sql, $i, "rotcodigo");
        $tpfcodigo = (int) pg_fetch_result($sql, $i, "tpfcodigo") == 0 ? 1 : (int) pg_fetch_result($sql, $i, "tpfcodigo");
        $tracnpj = pg_fetch_result($sql, $i, "tracnpj");
        $traie = pg_fetch_result($sql, $i, "traie");
        $doccobvers = pg_fetch_result($sql, $i, "doccobvers");
        $ocorenvers = pg_fetch_result($sql, $i, "ocorenvers");
        $conembvers = pg_fetch_result($sql, $i, "conembvers");
        $notfisvers = pg_fetch_result($sql, $i, "notfisvers");
        $diredi = pg_fetch_result($sql, $i, "diredi");
        $tradatasul = pg_fetch_result($sql, $i, "datcodigo");
        $traretirada = pg_fetch_result($sql, $i, "traretirada");

        $tratptolera = (int) pg_fetch_result($sql, $i, "tratptolera");
        $tratolera = (double) pg_fetch_result($sql, $i, "tratolera");

        if (trim($codigo) == "") {
            $codigo = "0";
        }
        if (trim($descricao) == "") {
            $descricao = "0";
        }
        if (trim($descricaob) == "") {
            $descricaob = "0";
        }
        if (trim($descricaoc) == "") {
            $descricaoc = "0";
        }
        if (trim($descricaod) == "") {
            $descricaod = "0";
        }
        if (trim($descricaoe) == "") {
            $descricaoe = "0";
        }
        if (trim($descricaof) == "") {
            $descricaof = "0";
        }
        if (trim($descricaog) == "") {
            $descricaog = "0";
        }
        if (trim($descricaoh) == "") {
            $descricaoh = "0";
        }
        if (trim($descricaoi) == "") {
            $descricaoi = "0";
        }
        if (trim($descricaoj) == "") {
            $descricaoj = "0";
        }
        if (trim($descricaok) == "") {
            $descricaok = "0";
        }
        if (trim($descricaol) == "") {
            $descricaol = "0";
        }
        if (trim($descricaom) == "") {
            $descricaom = "0";
        }
        if (trim($tracnpj) == "") {
            $tracnpj = "0";
        }
        if (trim($traie) == "") {
            $traie = "0";
        }
        if (trim($doccobvers) == "") {
            $doccobvers = "0";
        }
        if (trim($ocorenvers) == "") {
            $ocorenvers = "0";
        }
        if (trim($conembvers) == "") {
            $conembvers = "0";
        }
        if (trim($notfisvers) == "") {
            $notfisvers = "0";
        }
        if (trim($diredi) == "") {
            $diredi = "0";
        }
        if (trim($tradatasul) == "") {
            $tradatasul = "0";
        }
        if (trim($traretirada) == "") {
            $traretirada = "N";
        }

        $xml .= "<dado>\n";
        $xml .= "<codigo>" . $codigo . "</codigo>\n";
        $xml .= "<descricao>" . $descricao . "</descricao>\n";
        $xml .= "<descricaob>" . $descricaob . "</descricaob>\n";
        $xml .= "<descricaoc>" . $descricaoc . "</descricaoc>\n";
        $xml .= "<descricaod>" . $descricaod . "</descricaod>\n";
        $xml .= "<descricaoe>" . $descricaoe . "</descricaoe>\n";
        $xml .= "<descricaof>" . $descricaof . "</descricaof>\n";
        $xml .= "<descricaog>" . $descricaog . "</descricaog>\n";
        $xml .= "<descricaoh>" . $descricaoh . "</descricaoh>\n";
        $xml .= "<descricaoi>" . $descricaoi . "</descricaoi>\n";
        $xml .= "<descricaoj>" . $descricaoj . "</descricaoj>\n";
        $xml .= "<descricaok>" . $descricaok . "</descricaok>\n";
        $xml .= "<descricaol>" . $descricaol . "</descricaol>\n";
        $xml .= "<descricaom>" . $descricaom . "</descricaom>\n";
        $xml .= "<tpfcodigo>" . $tpfcodigo . "</tpfcodigo>\n";
        $xml .= "<tracnpj>" . $tracnpj . "</tracnpj>\n";
        $xml .= "<traie>" . $traie . "</traie>\n";
        $xml .= "<doccob>" . $doccobvers . "</doccob>\n";
        $xml .= "<ocoren>" . $ocorenvers . "</ocoren>\n";
        $xml .= "<conemb>" . $conembvers . "</conemb>\n";
        $xml .= "<tracaminho>" . $diredi . "</tracaminho>\n";
        $xml .= "<notfis>" . $notfisvers . "</notfis>\n";
        $xml .= "<tradatasul>" . $tradatasul . "</tradatasul>\n";
        $xml .= "<traretirada>" . $traretirada . "</traretirada>\n";
        $xml .= "<tratptolera>" . $tratptolera . "</tratptolera>\n";
        $xml .= "<tratolera>" . $tratolera . "</tratolera>\n";
        $xml .= "</dado>\n";
    }//FECHA FOR

    $xml .= "</dados>\n";

    //CABEÇALHO
    Header("Content-type: application/xml; charset=iso-8859-1");
}//FECHA IF (row)
//PRINTA O RESULTADO
echo $xml;

