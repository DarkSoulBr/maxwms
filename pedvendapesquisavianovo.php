<?php

//RECEBE PARÃMETRO
$parametro = trim($_POST["parametro"]);

require_once("include/conexao.inc.php");
require_once("include/pedvenda.php");

$cadastro = new banco($conn, $db);

//QUERY  

$sql = "Select pvvia,pvlibdep,pvlibmat,pvlibfil,pvlibvit,pvlibcivit,pvlibgre from pvenda Where pvnumero = '$parametro'";

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
        $codigo = pg_fetch_result($sql, $i, "pvvia");

        $pvlibdep = pg_fetch_result($sql, $i, "pvlibdep");
        $pvlibmat = pg_fetch_result($sql, $i, "pvlibmat");
        $pvlibfil = pg_fetch_result($sql, $i, "pvlibfil");
        $pvlibvit = pg_fetch_result($sql, $i, "pvlibvit");
        $pvlibgre = pg_fetch_result($sql, $i, "pvlibgre");
        $pvlibcivit = pg_fetch_result($sql, $i, "pvlibcivit");

        if (trim($codigo) == "") {
            $codigo = "0";
        }

        if (trim($pvlibdep) == "") {
            $pvlibdep = "0";
        }
        if (trim($pvlibmat) == "") {
            $pvlibmat = "0";
        }
        if (trim($pvlibfil) == "") {
            $pvlibfil = "0";
        }
        if (trim($pvlibvit) == "") {
            $pvlibvit = "0";
        }
        if (trim($pvlibgre) == "") {
            $pvlibgre = "0";
        }
        if (trim($pvlibcivit) == "") {
            $pvlibcivit = "0";
        }

        $xml .= "<dado>\n";
        $xml .= "<codigo>" . $codigo . "</codigo>\n";

        $xml .= "<pvlibdep>" . $pvlibdep . "</pvlibdep>\n";
        $xml .= "<pvlibmat>" . $pvlibmat . "</pvlibmat>\n";
        $xml .= "<pvlibfil>" . $pvlibfil . "</pvlibfil>\n";
        $xml .= "<pvlibvit>" . $pvlibvit . "</pvlibvit>\n";
        $xml .= "<pvlibgre>" . $pvlibgre . "</pvlibgre>\n";
        $xml .= "<pvlibcivit>" . $pvlibcivit . "</pvlibcivit>\n";

        $xml .= "</dado>\n";
    }//FECHA FOR                 

    $xml .= "</dados>\n";

    //CABEÇALHO
    Header("Content-type: application/xml; charset=iso-8859-1");
}//FECHA IF (row)                                               
//PRINTA O RESULTADO  
echo $xml;
?>
