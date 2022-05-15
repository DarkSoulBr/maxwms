<?php

require('./_app/Config.inc.php');

$sql = "SELECT a.etqcodigo,a.etqnome,0 as tipo FROM estoque a ORDER BY a.etqcodigo";

$read = new Read;
$read->FullRead($sql);

$arrayInventario = [];

if ($read->getRowCount() >= 1) {
    header("Content-type: application/xml");
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";

    $xml .= "<dados>";
    $xml .= "<cabecalho>";

    foreach (array_keys($read->getResult()[0]) as $cabecalho) {
        $xml .= "<campo>" . $cabecalho . "</campo>";
    }
    $xml .= "</cabecalho>";

    foreach ($read->getResult() as $registros) {

        extract($registros);

        //Verifica se tem Inventario a Encerrar
        $estoque = $etqcodigo;

        $sql2 = "SELECT max(invdata) as invdata FROM inventario WHERE estcodigo=$estoque LIMIT 1";
        $read2 = new Read;
        $read2->FullRead($sql2);

        if ($read2->getRowCount() >= 1) {
            $invdata = $read2->getResult()[0]['invdata'];
            if ($invdata) {
                $aux = explode(" ", $invdata);
                $aux2 = explode("-", $aux[0]);
                $dataaux = $aux2[2] . '/' . $aux2[1] . '/' . $aux2[0];
                if ($dataaux != '//') {
                    $arrayInventario[] = [
                        "codigo" => $etqcodigo,
                        "estoque" => $etqnome . " ({$dataaux})",
                        "tipo" => $tipo,
                        "data" => strtotime($invdata)
                    ];
                }
            }
        }
        $read2 = null;
    }


    // Ordena
    usort($arrayInventario, 'cmp');

    //Looping no vetor
    foreach ($arrayInventario as $registros) {

        $xml .= "<registro>";
        $xml .= "<item>" . $registros['codigo'] . "</item>";
        $xml .= "<item>" . $registros['estoque'] . "</item>";
        $xml .= "<item>" . $registros['tipo'] . "</item>";
        $xml .= "</registro>";
    }

    $xml .= "</dados>";
}
$read = null;
echo $xml;

//Os Comandos abaixo estão organizando o Vetor Multidimesional por ordem de mais pedidos 
// Compara se $a é maior que $b
/*
  function cmp($a, $b) {
  return $a['data'] < $b['data'];
  }
 * 
 */

function cmp($a, $b) {
    if ($a['data'] == $b['data']) {
        return 0;
    }
    return ($a['data'] < $b['data']) ? 1 : -1;
}
