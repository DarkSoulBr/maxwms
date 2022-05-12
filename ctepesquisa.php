<?php

require_once("include/conexao.inc.php");

//RECEBE PARÃMETRO

$parametro = trim($_POST["parametro"]);
$parametro2 = trim($_POST["parametro2"]);

//
//QUERY
$sql = "SELECT a.ctenumero,a.ctenum,a.ctechave,a.ctenprot FROM  cte a";

if ($parametro2 == 1) {
    $sql .= " WHERE a.ctenumero = '$parametro'";
} else if ($parametro2 == 2) {

    $parametro = str_pad($parametro, 9, '0', STR_PAD_LEFT);

    $sql .= " WHERE a.ctenum = '$parametro'";
} else {
    $sql .= " WHERE a.ctechave = '$parametro'";
}

$sql .= " ORDER BY a.ctenumero";


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
        $ctenumero = pg_fetch_result($sql, $i, "ctenumero");
        $ctenum = pg_fetch_result($sql, $i, "ctenum");
        $ctechaveref = pg_fetch_result($sql, $i, "ctechave");
        $ctenprot = pg_fetch_result($sql, $i, "ctenprot");

        if (trim($codigo) == "") {
            $codigo = "0";
        }
        if (trim($ctenum) == "") {
            $ctenum = "0";
        }
        if (trim($ctechaveref) == "") {
            $ctechaveref = "0";
        }
        if (trim($ctenprot) == "") {
            $ctenprot = "0";
        }

        $ctecprotocolo = 'X';
        $ctecmotivo = 'X';

        $sql1 = "SELECT a.ctecprotocolo,a.ctecmotivo FROM  ctecancelado a";
        $sql1 .= " WHERE a.ctenumero = '$ctenumero'";

        $sql1 = pg_query($sql1);

        $row1 = pg_num_rows($sql1);

        if ($row1) {

            $ctecprotocolo = pg_fetch_result($sql1, 0, "ctecprotocolo");
            $ctecmotivo = pg_fetch_result($sql1, 0, "ctecmotivo");

            if (trim($ctecprotocolo) == "") {
                $ctecprotocolo = "0";
            }
            if (trim($ctecmotivo) == "") {
                $ctecmotivo = "0";
            }
        }
        
        //Verifica se o CT-e tem carta de correção
        
        $sql1 = "SELECT * FROM ctecartacorrecao";
        $sql1 .= " WHERE ctenumero = '{$ctenumero}'";

        $sql1 = pg_query($sql1);
        $carta_correcao = pg_num_rows($sql1);
       

        $xml .= "<dado>\n";
        $xml .= "<codigo>" . $ctenumero . "</codigo>\n";
        $xml .= "<descricao>" . $ctenum . "</descricao>\n";
        $xml .= "<descricao2>" . $ctechaveref . "</descricao2>\n";
        $xml .= "<descricao3>" . $ctecprotocolo . "</descricao3>\n";
        $xml .= "<descricao4>" . $ctecmotivo . "</descricao4>\n";
        $xml .= "<descricao5>" . $ctenprot . "</descricao5>\n";
        $xml .= "<descricao6>" . $carta_correcao . "</descricao6>\n";

        $xml .= "</dado>\n";
    }//FECHA FOR                 

    $xml .= "</dados>\n";

    //CABEÇALHO

    Header("Content-type: application/xml; charset=iso-8859-1");
}//FECHA IF (row)                                               
//PRINTA O RESULTADO  
echo $xml;

