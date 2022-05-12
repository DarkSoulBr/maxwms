<?php

//RECEBE PARÃMETRO
$usuario = trim($_GET["usuario"]);

set_time_limit(0);
ob_implicit_flush(true);

require("verifica2.php");

include_once '../nfephpnovo/vendor/autoload.php';

require_once('include/conexao.inc.php');
require_once("include/banco.php");

use NFePHP\DA\NFe\Danfe;
use NFePHP\DA\Legacy\FilesFolders;

//Verifica o arquivo que sera usado pra imprimir
$arquivo = '';
$sql2 = "Select pdfnome FROM temporariopdf where usucodigo='$usuario'";
$sql2 = pg_query($sql2);
$row2 = pg_num_rows($sql2);
if ($row2) {
    $arquivo = pg_fetch_result($sql2, 0, "pdfnome");
}

if ($arquivo != '') {

    $uploaddir = 'arquivos/' . $usuario . '/';

    $file = $uploaddir . basename($arquivo);
    $file2 = $uploaddir . basename($name2);

    $listarx = $uploaddir . basename($arquivo);
    $listarx2 = substr($listarx, 0, strlen($listarx) - 4) . ".pdf";

    if (file_exists($listarx)) {

        if (file_exists($listarx2)) {
            unlink($listarx2);
        }

        echo 'Gerando PDF, por favor aguarde ...' . '<br>';

        //Gera o PDF da NFe
        exibe_danfe($listarx, $listarx2);

        echo "<meta HTTP-EQUIV='Refresh' CONTENT='2;URL=" . $listarx2 . "'>";
    } else {
        echo 'Falha na geracao do arquivo!';
    }
} else {
    echo 'Falha na geracao do arquivo!';
}

exit;

function exibe_danfe($arquivo, $arquivo2) {

    $docxml = NFePHP\DA\Legacy\FilesFolders::readFile($arquivo);

    $xml = simplexml_load_string($docxml);

    //Verifica se esta processado
    if ($xml->CTe->infCte->ide->nCT != '') {
        $versao = $xml->CTe->infCte["versao"];
    } else {
        $versao = $xml->infCte["versao"];
    }

    $dacte = new NFePHP\DA\CTe\DacteV3($docxml, 'P', 'A4', '', 'I', '');

    $id = $dacte->montaDACTE();
    $teste = $dacte->printDACTE($arquivo2, 'F');
}
?>

