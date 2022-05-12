<?php

require_once("include/conexao.inc.php");
require_once("include/conferencia.php");

//RECEBE PARÃMETRO

$parametro = trim($_POST["parametro"]);

$parametro = md5($parametro);

$cadastro = new banco($conn, $db);

$sql = "SELECT a.usunome,b.acesso01,b.acesso02 FROM usuarios a
  Left Join acessos b on b.usucodigo = a.usucodigo
  Where ususenha = '$parametro' limit 1";

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

        $usunome = pg_fetch_result($sql, $i, "usunome");
        $acesso01 = pg_fetch_result($sql, $i, "acesso01");
        $acesso02 = pg_fetch_result($sql, $i, "acesso02");

        if (trim($usunome) == "") {
            $usunome = "N";
        }
        if (trim($acesso01) == "") {
            $acesso01 = "N";
        }
        if (trim($acesso02) == "") {
            $acesso02 = "N";
        }
        
        $acesso01 = "S";
        $acesso02 = "S";

        $xml .= "<dado>\n";
        $xml .= "<usunome>" . $usunome . "</usunome>\n";
        $xml .= "<acesso01>" . $acesso01 . "</acesso01>\n";
        $xml .= "<acesso02>" . $acesso02 . "</acesso02>\n";
        $xml .= "</dado>\n";
    }//FECHA FOR

    $xml .= "</dados>\n";

    //CABEÇALHO

    Header("Content-type: application/xml; charset=iso-8859-1");
}//FECHA IF (row)
//PRINTA O RESULTADO
echo $xml;
?>
