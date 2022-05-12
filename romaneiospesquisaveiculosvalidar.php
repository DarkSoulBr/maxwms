<?php

//RECEBE PARÃMETRO                     
$parametro = trim($_POST["parametro"]);

require_once("include/conexao.inc.php");
require_once("include/romaneios.php");

$cadastro = new banco($conn, $db);

//QUERY
$romano = 0;
$romnumero = 0;
$rombaixa = 0;

$sql = "
	SELECT veicodigo as codigo,veimodelo as modelo,veiplaca as placa,veivalidar
        FROM  veiculos a
	WHERE veicodigo = '$parametro'
	ORDER BY modelo";



//EXECUTA A QUERY
$sql = pg_query($sql);

$row = pg_num_rows($sql);

//VERIFICA SE VOLTOU ALGO
if ($row) {

    $sql2 = "
        SELECT romnumero,rombaixa,romano
        FROM romaneios a
        WHERE romveiculo = '$parametro'
        ORDER BY romano DESC, romnumero DESC limit 1";

    //EXECUTA A QUERY
    $sql2 = pg_query($sql2);

    $row2 = pg_num_rows($sql2);

    //VERIFICA SE VOLTOU ALGO
    if ($row2) {
        $romano = pg_fetch_result($sql2, 0, "romano");
        $romnumero = pg_fetch_result($sql2, 0, "romnumero");
        $rombaixa = pg_fetch_result($sql2, 0, "rombaixa");
        if (trim($rombaixa) == "") {
            $rombaixa = 0;
        }
    }






    //XML
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $xml .= "<dados>\n";

    //PERCORRE ARRAY
    for ($i = 0; $i < $row; $i++) {
        $veivalidar = pg_fetch_result($sql, $i, "veivalidar");

        if (trim($veivalidar) == "") {
            $veivalidar = 'N';
        }

        $xml .= "<dado>\n";
        $xml .= "<romano>" . $romano . "</romano>\n";
        $xml .= "<romnumero>" . $romnumero . "</romnumero>\n";
        $xml .= "<rombaixa>" . $rombaixa . "</rombaixa>\n";
        $xml .= "<veivalidar>" . $veivalidar . "</veivalidar>\n";
        $xml .= "</dado>\n";
    }//FECHA FOR

    $xml .= "</dados>\n";

    //CABEÇALHO
    Header("Content-type: application/xml; charset=iso-8859-1");
}//FECHA IF (row)
//PRINTA O RESULTADO
echo $xml;
?>
