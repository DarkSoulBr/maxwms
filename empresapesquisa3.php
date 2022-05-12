<?php

require_once("include/conexao.inc.php");
require_once("include/banco.php");

//RECEBE PARÃMETRO

$parametro = trim($_POST["parametro"]);
$cadastro = new banco($conn, $db);

$j = 0;

for ($i = 0; $i < 2; $i++) {

    //EXECUTA A QUERY
    $sql = "SELECT a.empcodigo,a.clinguerra,a.clicod,a.clirazao,a.clisuframa,a.clicnpj,a.cliie,a.clirg,a.clicpf,a.cliobs,a.clipessoa
       ,a.clicep,a.cliendereco,a.clibairro,a.clifone,a.clicomplemento,a.cliemail,a.cidcodigoibge,a.clinumero,a.cidcodigo
       ,b.descricao,b.uf        
       FROM  empresa a        
       Left Join cidades as b on a.cidcodigo = b.cidcodigo WHERE a.clinguerra = '$parametro'	        
		ORDER BY a.empcodigo";

    $sql = pg_query($sql);
    $row = pg_num_rows($sql);
    $i = 0;
    $j++;
    if ($row) {
        $i = 2;
    }
}

//VERIFICA SE VOLTOU ALGO
if ($row) {
    //XML
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $xml .= "<dados>\n";

    //PERCORRE ARRAY
    for ($i = ($row - 1); $i < $row; $i++) {
        $codigo = pg_fetch_result($sql, $i, "empcodigo");
        $descricao = pg_fetch_result($sql, $i, "clinguerra");
        $descricaob = pg_fetch_result($sql, $i, "clicod");
        $descricaoc = pg_fetch_result($sql, $i, "clirazao");
        $descricaod = pg_fetch_result($sql, $i, "clisuframa");
        $descricaoe = pg_fetch_result($sql, $i, "clicnpj");
        $descricaof = pg_fetch_result($sql, $i, "cliie");
        $descricaog = pg_fetch_result($sql, $i, "clirg");
        $descricaoh = pg_fetch_result($sql, $i, "cicpf");
        $descricaoi = pg_fetch_result($sql, $i, "cliobs");

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

        $xml .= "</dado>\n";
    }//FECHA FOR

    $xml .= "</dados>\n";

    //CABEÇALHO
    Header("Content-type: application/xml; charset=iso-8859-1");
}//FECHA IF (row)
//PRINTA O RESULTADO
echo $xml;
?>
