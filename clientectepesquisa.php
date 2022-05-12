<?php

require_once("include/conexao.inc.php");
require_once("include/banco.php");

//RECEBE PARÃMETRO
$parametro = trim($_REQUEST["parametro"]);
$parametro2 = trim($_REQUEST["parametro2"]);

$cadastro = new banco($conn, $db);

$sql = "SELECT a.clicodigo,a.clinguerra,a.clicod,a.clirazao,a.clisuframa,a.clicnpj,a.cliie,a.clirg,a.clicpf,a.cliobs,a.clipessoa
       ,a.clicep,a.cliendereco,a.clibairro,a.clifone,a.clicomplemento,a.cliemail,a.cidcodigoibge,a.clinumero,a.cidcodigo
       ,b.descricao,b.uf,a.clinfe         
       FROM  clientescte a        
       Left Join cidades as b on a.cidcodigo = b.cidcodigo";

if ($parametro2 == "1") {
    $sql = $sql . " WHERE a.clicod = '$parametro' ORDER BY a.clicod";
} elseif ($parametro2 == "2") {
    $sql = $sql . " WHERE a.clinguerra like '%$parametro%' ORDER BY a.clinguerra";
} elseif ($parametro2 == "3") {
    $sql = $sql . " WHERE a.clirazao like '%$parametro%' ORDER BY a.clirazao";
} elseif ($parametro2 == "4") {
    $sql = $sql . " WHERE a.clicnpj like '%$parametro%' ORDER BY a.clicnpj";
} else {
    $sql = $sql . " WHERE a.clicpf like '%$parametro%' ORDER BY a.clicpf";
}

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
        $codigo = pg_fetch_result($sql, $i, "clicodigo");
        $descricao = pg_fetch_result($sql, $i, "clinguerra");
        $descricaob = pg_fetch_result($sql, $i, "clicod");
        $descricaoc = pg_fetch_result($sql, $i, "clirazao");
        $descricaod = pg_fetch_result($sql, $i, "clisuframa");
        $descricaoe = pg_fetch_result($sql, $i, "clicnpj");
        $descricaof = pg_fetch_result($sql, $i, "cliie");
        $descricaog = pg_fetch_result($sql, $i, "clirg");
        $descricaoh = pg_fetch_result($sql, $i, "clicpf");
        $descricaoi = pg_fetch_result($sql, $i, "cliobs");

        $descricaou = pg_fetch_result($sql, $i, "clipessoa");
        $descricao2a = pg_fetch_result($sql, $i, "clicep");
        $descricao2b = pg_fetch_result($sql, $i, "cliendereco");
        $fnenumero = pg_fetch_result($sql, $i, "clinumero");
        $descricao2c = pg_fetch_result($sql, $i, "clibairro");
        $descricao2d = pg_fetch_result($sql, $i, "clifone");
        $descricao2e = pg_fetch_result($sql, $i, "clicomplemento");
        $descricao2f = pg_fetch_result($sql, $i, "cliemail");

        $descricaov = pg_fetch_result($sql, $i, "cidcodigo");
        $descricaox = pg_fetch_result($sql, $i, "descricao");
        $descricaoz = pg_fetch_result($sql, $i, "uf");
        $cidcodigoibge = pg_fetch_result($sql, $i, "cidcodigoibge");
        $fornfe = pg_fetch_result($sql, $i, "clinfe");

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
        if (trim($descricaou) == "") {
            $descricaou = "0";
        }
        if (trim($descricao2a) == "") {
            $descricao2a = "0";
        }
        if (trim($descricao2b) == "") {
            $descricao2b = "0";
        }
        if (trim($descricao2c) == "") {
            $descricao2c = "0";
        }
        if (trim($descricao2d) == "") {
            $descricao2d = "0";
        }
        if (trim($descricao2e) == "") {
            $descricao2e = "0";
        }
        if (trim($descricao2f) == "") {
            $descricao2f = "0";
        }
        if (trim($fnenumero) == "") {
            $fnenumero = "0";
        }
        if (trim($descricaov) == "") {
            $descricaov = "0";
        }
        if (trim($descricaox) == "") {
            $descricaox = "0";
        }
        if (trim($descricaoz) == "") {
            $descricaoz = "0";
        }
        if (trim($cidcodigoibge) == "") {
            $cidcodigoibge = "0";
        }
        if (trim($fornfe) == "") {
            $fornfe = "0";
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
        $xml .= "<descricaou>" . $descricaou . "</descricaou>\n";
        $xml .= "<descricao2a>" . $descricao2a . "</descricao2a>\n";
        $xml .= "<descricao2b>" . $descricao2b . "</descricao2b>\n";
        $xml .= "<descricao2c>" . $descricao2c . "</descricao2c>\n";
        $xml .= "<descricao2d>" . $descricao2d . "</descricao2d>\n";
        $xml .= "<descricao2e>" . $descricao2e . "</descricao2e>\n";
        $xml .= "<descricao2f>" . $descricao2f . "</descricao2f>\n";
        $xml .= "<fnenumero>" . $fnenumero . "</fnenumero>\n";
        $xml .= "<descricaov>" . $descricaov . "</descricaov>\n";
        $xml .= "<descricaox>" . $descricaox . "</descricaox>\n";
        $xml .= "<descricaoz>" . $descricaoz . "</descricaoz>\n";

        if ($cidcodigoibge == "")
            $cidcodigoibge = "0";

        $xml .= "<descricaoib>" . $cidcodigoibge . "</descricaoib>\n";

        $auxestado = substr($cidcodigoibge, 0, 2);
        $auxcidade = substr($cidcodigoibge, 2, 5);

        //Busca no nome da cidade do IBGE
        $sql5 = @pg_query("Select descricao from cidadesibge where codestado=$auxestado and codcidade like '$auxcidade'");
        $array5 = @pg_fetch_object($sql5);

        if ($array5->descricao == "")
            $array5->descricao = "0";
        $xml .= "<cidadeibge>" . $array5->descricao . "</cidadeibge>\n";

        $xml .= "<fornfe>" . $fornfe . "</fornfe>\n";

        $xml .= "</dado>\n";
    }//FECHA FOR
    $xml .= "</dados>\n";

    //CABEÇALHO
    Header("Content-type: application/xml; charset=iso-8859-1");
}//FECHA IF (row)
//PRINTA O RESULTADO
echo $xml;
?>