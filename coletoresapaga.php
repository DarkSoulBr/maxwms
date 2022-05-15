<?php 

require('./_app/Config.inc.php');

$fpgcodigo=trim($_GET["fpgcodigo"]);

$deleta = new Delete;
        
$deleta->ExeDelete('coletores', "WHERE colcodigo = :id", 'id=' . $fpgcodigo);

if ($deleta->getResult()) {
    $fpgcodigo = $deleta->getRowCount();
    $erro = '_';
} else {
    $fpgcodigo = 0;
    $erro = $deleta->getErro();    
}

header("Content-type: application/xml");
$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";

$xml = "<dados>
		<registro>
		<item>" . $fpgcodigo . "</item>
		<item>" . $erro . "</item>
		</registro>
		</dados>";
echo $xml;

