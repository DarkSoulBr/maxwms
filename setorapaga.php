<?php 

require('./_app/Config.inc.php');

$setcodigo=trim($_GET["setcodigo"]);

$deleta = new Delete;
        
$deleta->ExeDelete('setor', "WHERE setcodigo = :id", 'id=' . $setcodigo);

if ($deleta->getResult()) {
    $setcodigo = $deleta->getRowCount();
    $erro = '_';
} else {
    $setcodigo = 0;
    $erro = $deleta->getErro();    
}

header("Content-type: application/xml");
$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";

$xml = "<dados>
		<registro>
		<item>" . $setcodigo . "</item>
		<item>" . $erro . "</item>
		</registro>
		</dados>";
echo $xml;
