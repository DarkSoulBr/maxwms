<?php

require('./_app/Config.inc.php');

$fpgcodigo=trim($_GET["fpgcodigo"]);
$fpgnome=trim($_GET["fpgnome"]);
$opcao=$_GET["opcao"];


    $update = new Update;

    $Dados = ['contnome' => $fpgnome, 'opcao' => $opcao];

    $update->ExeUpdate('contagem', $Dados, "WHERE contcodigo = :id", 'id=' . $fpgcodigo);

    if ($update->getResult()) {
        $fpgcodigo = $update->getRowCount();
        $erro = '_';
    } else {
        $fpgcodigo = 0;
        $erro = $update->getErro();
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

   