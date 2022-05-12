<?php
require('./_app/Config.inc.php');

$etqcodigo=trim($_GET["etqcodigo"]);

$codigo = 0;
$erro = utf8_encode("Não é permitido excluir os estoques!");

/*
$deleta = new Delete;
        
$deleta->ExeDelete('estoque', "WHERE etqcodigo = :id", 'id=' . $etqcodigo);

if ($deleta->getResult()) {
    $codigo = $deleta->getRowCount();
    $erro = '_';
} else {
    $codigo = 0;
    $erro = $deleta->getErro();    
}
 * 
 */

header("Content-type: application/xml");
$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";

$xml = "<dados>
		<registro>
		<item>" . $codigo . "</item>
		<item>" . $erro . "</item>
		</registro>
		</dados>";
echo $xml;
