<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

//RECEBE PARÃMETRO
$usuario = trim($_GET["usuario"]);

set_time_limit(0);
ob_implicit_flush(true);

require("verifica2.php");

include_once '../nfephpnovo/vendor/autoload.php';

require_once('include/conexao.inc.php');
require_once("include/banco.php");

use NFePHP\DA\CTe\Dacce;
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
    
   
    $sql2 = "SELECT a.empcodigo,a.clinguerra,a.clicod,a.clirazao,a.clisuframa,a.clicnpj,a.cliie,a.clirg,a.clicpf,a.cliobs,a.clipessoa
            ,a.clicep,a.cliendereco,a.clibairro,a.clifone,a.clicomplemento,a.cliemail,a.cidcodigoibge,a.clinumero,a.cidcodigo
            ,b.descricao,b.uf        
            FROM  empresa a        
            LEFT JOIN cidades as b on a.cidcodigo = b.cidcodigo 
	    WHERE a.clicod = 1";
    
    $sql2 = pg_query($sql2);
    $row2 = pg_num_rows($sql2);
    $razao = '';
    $logradouro = '';
    $numero = '';
    $complemento = '';
    $bairro = '';
    $CEP = '';
    $municipio = '';
    $UF = '';
    $telefone = '';
    $email = '';
    if ($row2) {
        $razao = pg_fetch_result($sql2, 0, "clirazao");
        $logradouro = pg_fetch_result($sql2, 0, "cliendereco");
        $numero = pg_fetch_result($sql2, 0, "clinumero");
        $complemento = pg_fetch_result($sql2, 0, "clicomplemento");
        $bairro = pg_fetch_result($sql2, 0, "clibairro");
        $CEP = pg_fetch_result($sql2, 0, "clicep");
        $municipio = pg_fetch_result($sql2, 0, "descricao");
        $UF = pg_fetch_result($sql2, 0, "uf");
        $telefone = pg_fetch_result($sql2, 0, "clifone");
        $email = pg_fetch_result($sql2, 0, "cliemail");
    }

    $aEnd = array(
        'razao' => $razao,
        'logradouro' => $logradouro,
        'numero' => $numero,
        'complemento' => $complemento,
        'bairro' => $bairro,
        'CEP' => substr($CEP,0,5) . '-' . substr($CEP,5,3),
        'municipio' => $municipio,
        'UF' => $UF,
        'telefone' => $telefone,
        'email' => $email
    );

    $dacce = new Dacce($docxml, 'L', 'A4', '', 'I', $aEnd);
    
    $id = $dacce->monta();
    $teste = $dacce->printDACCE($arquivo2, 'F');
}
?>

