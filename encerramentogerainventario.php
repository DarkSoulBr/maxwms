<?php

require('./_app/Config.inc.php');

$atualiza = $_GET["atualiza"];
$campo1 = $_GET["c1"];

//Faz um Loopin dos Estoques
for ($x = 0; $x < sizeof($campo1); $x++) {
    $estoque = $campo1[$x];

    $sql2 = "SELECT max(invdata) as invdata FROM inventario WHERE estcodigo=$estoque LIMIT 1";
    $read2 = new Read;
    $read2->FullRead($sql2);

    if ($read2->getRowCount() >= 1) {
        $invdata = $read2->getResult()[0]['invdata'];

        if ($invdata != '') {

            //Looping em todos os produtos do Inventario
            $sql = "SELECT invatual as atual, procodigo as produto FROM inventario WHERE estcodigo=$estoque and invdata='$invdata'";
            $read = new Read;
            $read->FullRead($sql);

            if ($read->getRowCount() >= 1) {

                foreach ($read->getResult() as $registros) {
                    extract($registros);

                    if ($atual == "")
                        $atual = "0";

                    //Atualiza a tabela de Estoque Atual
                    if ($atualiza == 'S') {

                        //Será necessário verificar se o estoque existe 
                        //Looping em todos os produtos do Inventario
                        $sql3 = "SELECT * FROM estoqueatual WHERE procodigo={$produto} AND codestoque={$estoque}";
                        $read3 = new Read;
                        $read3->FullRead($sql3);

                        if ($read3->getRowCount() >= 1) {

                            $Dados = null;
                            $Dados = ['estqtd' => $atual];

                            $update = new Update;
                            $update->ExeUpdate('estoqueatual', $Dados, "WHERE procodigo = :id AND codestoque = :es", 'id=' . $produto . '&es=' . $estoque);
                            $update = null;
                        } else {

                            $Dados = [
                                'procodigo' => $produto,
                                'estqtd' => $atual,
                                'codestoque' => $estoque
                            ];

                            $Cadastra = new Create;
                            $Cadastra->ExeCreate('estoqueatual', 'estoqueatual_etqatualcodigo_seq', $Dados);
                            $Cadastra = null;
                        }
                    }

                    //Atualiza a Movimentação de Estoque 
                    $tabela = 'movestoque' . substr($invdata, 5, 2) . substr($invdata, 2, 2);
                    $sequence = 'movestoque' . substr($invdata, 5, 2) . substr($invdata, 2, 2) . '_movcodigo_seq';

                    $Dados = null;
                    $Dados = ['movdata' => $invdata,
                        'procodigo' => $produto,
                        'movqtd' => $atual,
                        'movvalor' => 0,
                        'movtipo' => 1,
                        'codestoque' => $estoque];

                    $Cadastra = new Create;
                    $Cadastra->ExeCreate($tabela, $sequence, $Dados);
                    $Cadastra = null;
                }
            }
        }
    }
}

$xml = "<dadosencerrar>";
$xml .= "<registroencerrar>";
$xml .= "<itemencerrar>OK</itemencerrar>";
$xml .= "</registroencerrar>";
$xml .= "</dadosencerrar>";

echo $xml;
