<?php

require('./_app/Config.inc.php');

$setcodigo=trim($_GET["setcodigo"]);
$setor=trim($_GET["setor"]);
$codigosetor=trim($_GET["codigosetor"]);


    $update = new Update;

    $Dados = ['setor' => $setor, 'codigosetor' => $codigosetor];

    $update->ExeUpdate('setor', $Dados, "WHERE setcodigo = :id", 'id=' . $setcodigo);

    if ($update->getResult()) {
        $setcodigo = $update->getRowCount();
        $erro = '_';
    } else {
        $setcodigo = 0;
        $erro = $update->getErro();
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

   