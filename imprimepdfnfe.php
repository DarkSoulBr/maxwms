<?php
//RECEBE PARÃMETRO
$usuario = trim($_GET["usuario"]);

set_time_limit ( 0 );
ob_implicit_flush(true);

require("verifica2.php");

include_once '../nfephp/bootstrap.php';

require_once('include/conexao.inc.php');
require_once("include/banco.php");
require('code128.php');

use NFePHP\Extras\Danfe;
use NFePHP\Common\Files\FilesFolders;

//Verifica o arquivo que sera usado pra imprimir
$arquivo = '';
$sql2="Select pdfnome FROM temporariopdf where usucodigo='$usuario'";									
$sql2 = pg_query($sql2);
$row2 = pg_num_rows($sql2);
if($row2) {
	$arquivo = pg_fetch_result($sql2, 0, "pdfnome");
}

if($arquivo!=''){

	$uploaddir = 'arquivos/' . $usuario . '/';

	$file = $uploaddir . basename($arquivo);
	$file2 = $uploaddir . basename($name2);

	$listarx=$uploaddir . basename($arquivo);
	$listarx2 = substr($listarx,0,strlen($listarx)-4) . ".pdf";
	
	if(file_exists($listarx)) {
		
		if(file_exists($listarx2)) {	
			unlink($listarx2);
		}
		
		echo 'Gerando PDF, por favor aguarde ...' . '<br>';
		
		//Gera o PDF da NFe
		exibe_danfe($listarx,$listarx2);
		
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='2;URL=" . $listarx2 . "'>";
									
	}
	else {
		echo 'Falha na geracao do arquivo!';	
	}		
}
else {
	echo 'Falha na geracao do arquivo!';	
}	
				
exit;	

function exibe_danfe($arquivo,$arquivo2){
		
	$docxml = FilesFolders::readFile($arquivo);

	$danfe = new Danfe($docxml, 'P', 'A4', '', 'I', '');
	$id = $danfe->montaDANFE();
	//$teste = $danfe->printDANFE("$id.'.pdf', 'F');
	$teste = $danfe->printDANFE($arquivo2, 'F');	
	
}

?>

