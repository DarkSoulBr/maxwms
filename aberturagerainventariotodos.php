<?php

require('./_app/Config.inc.php');

header("Content-type: application/xml");
$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";

$grupo = trim($_GET["grupo"]);
$subgrupo = trim($_GET["subgrupo"]);
$invdata = trim($_GET["invdata"]);
$estoque_atual = trim($_GET["estoque_atual"]);

$campo1 = $_GET["c1"];

$aux = "";
$resultadogru = "";
$resultadosub = "";

$aux = explode("/", $invdata);
$invdata = $aux[2] . '-' . $aux[1] . '-' . $aux[0] . ' 00:00:00-03';

$auxgrupo = substr_count($grupo, ';');
$auxcg = explode(";", $grupo);

for ($i = 0; $i < $auxgrupo; $i++)
    $grupox[$i] = $auxcg[$i];

$auxsgrupo = substr_count($subgrupo, ';');
$auxcsg = explode(";", $subgrupo);
for ($i = 0; $i < $auxsgrupo; $i++)
    $subgrupox[$i] = $auxcsg[$i];

if (isset($grupox)) {
    $contagrupo = count($grupox);
} else {
    $contagrupo = 0;
}

if (isset($subgrupox)) {
    $contasubgrupo = count($subgrupox);
} else {
    $contasubgrupo = 0;
}

if ($contagrupo > 0) {
    for ($i = 0; $i < $contagrupo; $i++) {

        //Faz um Loopin dos Estoques
        for ($x = 0; $x < sizeof($campo1); $x++) {
            $estoque = $campo1[$x];

            $sql = "SELECT p.procodigo,e.estqtd,p.stpcodigo FROM produto p 
                    LEFT JOIN estoqueatual e on p.procodigo=e.procodigo and e.codestoque=$estoque 
                    WHERE p.grucodigo=" . $grupox[$i];

            $read = new Read;
            $read->FullRead($sql);

            if ($read->getRowCount() >= 1) {

                foreach ($read->getResult() as $registros) {
                    extract($registros);

                    //Faz a busca do produto na tabela inventário
                    $sql2 = "SELECT invcodigo FROM inventario WHERE procodigo=$procodigo and invdata='$invdata' and estcodigo=$estoque";
                    $read2 = new Read;
                    $read2->FullRead($sql2);
                    $invcodigo = 0;
                    if ($read2->getRowCount() >= 1) {
                        $invcodigo = $read2->getResult()[0]['invcodigo'];
                    }
                    $read2 = null;

                    if ($estqtd == "")
                        $estqtd = "0";

                    $processa = 1;

                    /*
                      if ($stpcodigo == 1) {
                      $processa = 1;
                      } else if ($stpcodigo == 2) {
                      $processa = 1;
                      } else {
                      $nestqtd = $estqtd;
                      if ($nestqtd > 0) {
                      $processa = 1;
                      }
                      }
                     * 
                     */

                    if ($processa == 1) {

                        if ($estoque_atual == 1) {
                            $gravaEstoque = $estqtd;
                        } else {
                            $gravaEstoque = null;
                        }

                        $Dados = null;
                        if ($invcodigo == 0) {
                            $Dados = ['procodigo' => $procodigo,
                                'estcodigo' => $estoque,
                                'invantigo' => $estqtd,
                                'invdata' => $invdata,
                                'invatual' => $gravaEstoque];

                            $Cadastra = new Create;
                            $Cadastra->ExeCreate('inventario', 'inventario_invcodigo_seq', $Dados);
                            $Cadastra = null;
                        } else {
                            $Dados = ['invantigo' => $estqtd,
                                'invatual' => $gravaEstoque];

                            $update = new Update;
                            $update->ExeUpdate('inventario', $Dados, "WHERE invcodigo = :id", 'id=' . $invcodigo);
                            $update = null;
                        }
                    }
                }
                $resultadogru = "1";
            }
            $read = null;
        }
    }
} else
if ($contasubgrupo > 0) {
    for ($i = 0; $i < $contasubgrupo; $i++) {

        //Faz um Looping dos Estoques
        for ($x = 0; $x < sizeof($campo1); $x++) {
            $estoque = $campo1[$x];

            $sql = "SELECT p.procodigo,e.estqtd,p.stpcodigo FROM produto p 
                    LEFT JOIN estoqueatual e on p.procodigo=e.procodigo and e.codestoque=$estoque 
                    WHERE p.subcodigo=" . $subgrupox[$i];

            $read = new Read;
            $read->FullRead($sql);

            if ($read->getRowCount() >= 1) {

                foreach ($read->getResult() as $registros) {
                    extract($registros);

                    //Faz a busca do produto na tabela inventário
                    $sql2 = "SELECT invcodigo FROM inventario WHERE procodigo=$procodigo and invdata='$invdata' and estcodigo=$estoque";
                    $read2 = new Read;
                    $read2->FullRead($sql2);
                    $invcodigo = 0;
                    if ($read2->getRowCount() >= 1) {
                        $invcodigo = $read2->getResult()[0]['invcodigo'];
                    }
                    $read2 = null;

                    if ($estqtd == "")
                        $estqtd = "0";

                    $processa = 1;

                    /*
                      if ($stpcodigo == 1) {
                      $processa = 1;
                      } else if ($stpcodigo == 2) {
                      $processa = 1;
                      } else {
                      $nestqtd = $estqtd;
                      if ($nestqtd > 0) {
                      $processa = 1;
                      }
                      }
                     * 
                     */

                    if ($processa == 1) {

                        if ($estoque_atual == 1) {
                            $gravaEstoque = $estqtd;
                        } else {
                            $gravaEstoque = null;
                        }

                        $Dados = null;
                        if ($invcodigo == 0) {
                            $Dados = ['procodigo' => $procodigo,
                                'estcodigo' => $estoque,
                                'invantigo' => $estqtd,
                                'invdata' => $invdata,
                                'invatual' => $gravaEstoque];

                            $Cadastra = new Create;
                            $Cadastra->ExeCreate('inventario', 'inventario_invcodigo_seq', $Dados);
                            $Cadastra = null;
                        } else {
                            $Dados = ['invantigo' => $estqtd,
                                'invatual' => $gravaEstoque];

                            $update = new Update;
                            $update->ExeUpdate('inventario', $Dados, "WHERE invcodigo = :id", 'id=' . $invcodigo);
                            $update = null;
                        }
                    }
                }
                $resultadosub = "2";
            }
            $read = null;
        }
    }
}

//}

if ($contagrupo > 0) {
    if ($resultadogru == "")
        $resultadogru = "11";
}

if ($contasubgrupo > 0) {
    if ($resultadosub == "")
        $resultadosub = "22";
}

$xml = "<dadosinv>
<registroinv>
<iteminv>";
if ($resultadogru != "")
    $xml .= $resultadogru;
else
if ($resultadosub != "")
    $xml .= $resultadosub;
else
    $xml .= "3";

$xml .= "</iteminv>
</registroinv>
</dadosinv>";
echo $xml;
