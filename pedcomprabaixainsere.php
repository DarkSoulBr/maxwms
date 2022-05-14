<?php

require_once("include/conexao.inc.php");
require_once("include/pedcomprabaixa.php");
require_once('./_app/Config.inc.php');
require_once('include/classes/EnviarEmail.php');

$pcnumero = trim($_POST["pcnumero"]);
$data = trim($_POST["data"]);

$notentdata = substr($data, 6, 4) . '-' . substr($data, 3, 2) . '-' . substr($data, 0, 2);
$datanota = trim($_POST["datanota"]);
$notentdatanota = substr($datanota, 6, 4) . '-' . substr($datanota, 3, 2) . '-' . substr($datanota, 0, 2);
$notentnota = trim($_POST["nota"]);

$serie = trim($_POST["serie"]);

$notentcfop = trim($_POST["cfop"]);
$notentprodutos = trim($_POST["produtos"]);
$notenticm = trim($_POST["icm"]);
$notentbaseicm = trim($_POST["baseicm"]);
$notentvaloricm = trim($_POST["valoricm"]);
$notentisentas = trim($_POST["isentas"]);
$notentoutras = trim($_POST["outras"]);
$notentbaseipi = trim($_POST["baseipi"]);
$notentpercipi = trim($_POST["percipi"]);
$notentvaloripi = trim($_POST["valoripi"]);
$notentvalor = trim($_POST["totalnota"]);
$notentobservacoes = trim($_POST["observacoes"]);

$volumes = trim($_POST["volumes"]);

$outrasipi = trim($_POST["outrasipi"]);
$gerawms = trim($_POST["gerawms"]);
if ($gerawms == '') {
    $gerawms = 1;
}
$usuario = trim($_POST["usuario"]);
if ($usuario == '') {
    $usuario = 0;
}

$cfop2 = trim($_POST["cfop2"]);
$basesubst = trim($_POST["basesubst"]);
$valorsubst = trim($_POST["valorsubst"]);
$perciva = trim($_POST["perciva"]);

$tipobaixa = trim($_POST["tipobaixa"]);

if (isset($_POST["b"])) {
    $b = trim($_POST["b"]);
} else {
    $b = '';
}
if (isset($_POST["c"])) {
    $c = trim($_POST["c"]);
} else {
    $c = '';
}
if (isset($_POST["d"])) {
    $d = trim($_POST["d"]);
} else {
    $d = '';
}
if (isset($_POST["e"])) {
    $e = trim($_POST["e"]);
} else {
    $e = '';
}
if (isset($_POST["f"])) {
    $f = trim($_POST["f"]);
} else {
    $f = '';
}
if (isset($_POST["g"])) {
    $g = trim($_POST["g"]);
} else {
    $g = '';
}
if (isset($_POST["h"])) {
    $h = trim($_POST["h"]);
} else {
    $h = '';
}
if (isset($_POST["i"])) {
    $i = trim($_POST["i"]);
} else {
    $i = '';
}
if (isset($_POST["j"])) {
    $j = trim($_POST["j"]);
} else {
    $j = '';
}
if (isset($_POST["k"])) {
    $k = trim($_POST["k"]);
} else {
    $k = '';
}
if (isset($_POST["l"])) {
    $l = trim($_POST["l"]);
} else {
    $l = '';
}
if (isset($_POST["m"])) {
    $m = trim($_POST["m"]);
} else {
    $m = '';
}
if (isset($_POST["n"])) {
    $n = trim($_POST["n"]);
} else {
    $n = '';
}
if (isset($_POST["o"])) {
    $o = trim($_POST["o"]);
} else {
    $o = '';
}
if (isset($_POST["p"])) {
    $p = trim($_POST["p"]);
} else {
    $p = '';
}
if (isset($_POST["q"])) {
    $q = trim($_POST["q"]);
} else {
    $q = '';
}
if (isset($_POST["r"])) {
    $r = trim($_POST["r"]);
} else {
    $r = '';
}
if (isset($_POST["s"])) {
    $s = trim($_POST["s"]);
} else {
    $s = '';
}
if (isset($_POST["t"])) {
    $t = trim($_POST["t"]);
} else {
    $t = '';
}
if (isset($_POST["u"])) {
    $u = trim($_POST["u"]);
} else {
    $u = '';
}
if (isset($_POST["v"])) {
    $v = trim($_POST["v"]);
} else {
    $v = '';
}
if (isset($_POST["w"])) {
    $w = trim($_POST["w"]);
} else {
    $w = '';
}
if (isset($_POST["x"])) {
    $x = trim($_POST["x"]);
} else {
    $x = '';
}

//------------------------------------pedcomprabaixaconf.php
$nota1 = $_POST["nota1"];
$serie1 = $_POST["serie1"];
$pcnumero1 = $_POST["pcnumero1"];

$campo1 = $_POST["c1"];
$campo2 = $_POST["d1"];
$campo3 = $_POST["e1"];

$campo4 = $_POST["f1"];
$campo5 = $_POST["g1"];

$campo6 = $_POST["h1"];
$campo7 = $_POST["i1"];
$campo8 = $_POST["j1"];
$campo9 = $_POST["k1"];
$campo10 = $_POST["l1"];
$campo11 = $_POST["m1"];

$campo12 = $_POST["n1"];

$campo14 = $_POST["o1"];

$campo15 = $_POST["p1"];
$campo16 = $_POST["q1"];

$campo17 = $_POST["r1"];

$deposito = $_POST["deposito"];

//-----------------------------------

function calculapreco($valor, $medio, $maior, $menor, $minimo) {
    $formula_a = 0;
    $formula_c = 0;
    $formula_m = 0;
    $pa = 0;
    $pc = 0;
    $pm = 0;
    $aux = 0;
    
    $medio = (double) $medio;
    $maior = (double) $maior;
    $menor = (double) $menor;
    $minimo = (double) $minimo;       
    //$menord = (double) $menord;

    $formula_a = ((100 - $maior) / 100);
    if ($formula_a == 0) {
        $formula_a = 0.99999;
    }
    $formula_c = ((100 - $menor) / 100);
    $formula_m = (($minimo / 100) + 1);

    $aux = ($medio / 100);
    $pb = (float) ($valor * $aux) + (float) ($valor);
    //pb = round(pb);
    $pb = round($pb, 2);
    $pa = $pb / $formula_a;
    $pa = round($pa, 2);
    $pc = $pb * $formula_c;
    $pc = round($pc, 2);
    $pm = $valor * $formula_m;
    $pm = round($pm, 2);

    return array("A" => $pa, "B" => $pb, "C" => $pc);
    //Não será utilizado
    //$pm;	
}

function delimitador($variavel, $tamanho, $alinhamento, $preenchimento) {
    if ($tamanho < 10 && $alinhamento == 'R' && $preenchimento == '0')
        $strtam = "%0" . $tamanho . "s";
    else if ($tamanho < 10 && $alinhamento == 'L' && $preenchimento == '0')
        $strtam = "%-0" . $tamanho . "s";
    else if ($tamanho < 10 && $alinhamento == 'R' && $preenchimento == ' ')
        $strtam = "%" . $tamanho . "s";
    else if ($tamanho < 10 && $alinhamento == 'L' && $preenchimento == ' ')
        $strtam = "%-" . $tamanho . "s";

    if ($tamanho >= 10 && $alinhamento == 'R' && $preenchimento == '0')
        $strtam = "%0" . $tamanho . "s";
    else if ($tamanho >= 10 && $alinhamento == 'L' && $preenchimento == '0')
        $strtam = "%-0" . $tamanho . "s";
    else if ($tamanho >= 10 && $alinhamento == 'R' && $preenchimento == ' ')
        $strtam = "%" . $tamanho . "s";
    else if ($tamanho >= 10 && $alinhamento == 'L' && $preenchimento == ' ')
        $strtam = "%-" . $tamanho . "s";

    $var = substr(sprintf($strtam, $variavel), 0, $tamanho);
    return $var;
}

$volumes = round($volumes);

$cadastro = new banco($conn, $db);

$sql = "SELECT max(notentseqbaixa) as seq FROM notaent Where pcnumero = '$pcnumero'";
$sql = pg_query($sql);
$row = pg_num_rows($sql);

if ($row) {
    $seq = pg_fetch_result($sql, 0, "seq");
    $seq++;
}

if ($cfop2 == 0) {
    $cfop2 = '';
}

$pcseq = $seq;

//Passa a gravar o horário da emissão
$aux = getdate();
$auxemissao = substr($notentdata, 0, 10) . ' ' . $aux['hours'] . ':' . $aux['minutes'] . ":" . $aux['seconds'] . '-03';

$cadastro->insere("notaent", "
(notentseqbaixa,pcnumero,notentdata,notentemissao,notentnumero,notentcpof,notentprodutos,
notenticm,notentbaseicm,notentvaloricm,notentisentas,
notentoutras,notentbaseipi,notentpercipi,notentvaloripi,notentvalor,notentobservacoes,notentvolumes,
notentp1,
notentp2,
notentp3,
notentp4,
notentp5,
notentp6,
notentp7,
notentp8,
notentp9,
notentp10,
notentp11,
notentp12,
notentp13,
notentp14,
notentp15,
notentp16,
notentp17,
notentp18,
notentp19,
notentp20,
notentp21,
notentp22,
notentp23,
notentserie,
outrasipi,
deposito,
notcfopsubs,
notbasesubst,
notvalorsubst,
notperciva,
gerawms,
usuario,
tipobaixa
)", "
('$seq','$pcnumero','$auxemissao','$notentdatanota','$notentnota','$notentcfop',
'$notentprodutos','$notenticm','$notentbaseicm','$notentvaloricm','$notentisentas',
'$notentoutras','$notentbaseipi','$notentpercipi','$notentvaloripi','$notentvalor',
'$notentobservacoes','$volumes'
,'$b'
,'$c'
,'$d'
,'$e'
,'$f'
,'$g'
,'$h'
,'$i'
,'$j'
,'$k'
,'$l'
,'$m'
,'$n'
,'$o'
,'$p'
,'$q'
,'$r'
,'$s'
,'$t'
,'$u'
,'$v'
,'$w'
,'$x'
,'$serie'
,'$outrasipi'
,'$deposito'
,'$cfop2'
,'$basesubst'
,'$valorsubst'
,'$perciva'
,'$gerawms'
,'$usuario'
,'$tipobaixa'
)");



// ENVIAR NOTIFICACAO DE PRE-BAIXA REALIZADA AOS USUARIOS REGISTRADOS
//$notentnumero = $nota1;
//$notentemissao = $notentdatanota;
//$PedidoComprasController = new PedidoController();
//$PedidoComprasController->notificar($pcnumero, $notentnumero, $notentemissao, 3);
//------------------------------------pedcomprabaixaconf.php


$j = 0;


for ($i = 0; $i < 2; $i++) {

    $sql02 = "select notentcodigo from notaent where notentnumero = '$nota1' 
    and notentserie = '$serie1' and pcnumero='$pcnumero1';";

    $sql02 = pg_query($sql02);
    $row02 = pg_num_rows($sql02);
    $i = 0;
    $j++;

    if ($row02) {
        $i = 2;
        $notentcodigo = pg_fetch_result($sql02, 0, "notentcodigo");
    }
    if ($j == 10000) {
        $i = 2;
    }
}





for ($i = 0; $i < sizeof($campo1); $i++) {

    if (trim($campo2[$i]) != '0') {

        $cadastro = new banco($conn, $db);

        $saldo = $campo3[$i] + $campo2[$i];

        $sql = "SELECT procodigo,pcipreco
  ,desc1
  ,desc2
  ,desc3
  ,desc4
  ,ipi
  FROM pcitem Where pcicodigo = $campo1[$i]";
        $sql = pg_query($sql);
        $row = pg_num_rows($sql);

        if ($row) {
            $procodigo = pg_fetch_result($sql, 0, "procodigo");
            $pcipreco = pg_fetch_result($sql, 0, "pcipreco");

            $desc1 = pg_fetch_result($sql, 0, "desc1");
            $desc2 = pg_fetch_result($sql, 0, "desc2");
            $desc3 = pg_fetch_result($sql, 0, "desc3");
            $desc4 = pg_fetch_result($sql, 0, "desc4");
            $ipi = pg_fetch_result($sql, 0, "ipi");


            $liq = $pcipreco;
            if ($desc1 != 0) {
                $d1 = $liq / 100 * $desc1;
            } else {
                $d1 = 0;
            }
            $liq = $liq - $d1;
            if ($desc2 != 0) {
                $d2 = $liq / 100 * $desc2;
            } else {
                $d2 = 0;
            }
            $liq = $liq - $d2;
            if ($desc3 != 0) {
                $d3 = $liq / 100 * $desc3;
            } else {
                $d3 = 0;
            }
            $liq = $liq - $d3;
            if ($desc4 != 0) {
                $d4 = $liq / 100 * $desc4;
            } else {
                $d4 = 0;
            }
            $liq = $liq - $d4;

            if ($ipi != 0) {
                $vipi = $liq / 100 * $ipi;
            } else {
                $vipi = 0;
            }
            //Insere o Valor sem o IPI
            $val = round($liq, 2);
            //$val=round($liq+$vipi,2);



            $neiitem = $i + 1;

            $cadastro->insere("neitem", "(
     nenumero,neserie,notentcodigo,neiitem,procodigo,neisaldo,neipreco,neipercicm,neipercipi,iva,st,valornf)", "(
     '$nota1','$serie1','$notentcodigo','$neiitem','$procodigo','$campo2[$i]',$val,'$campo4[$i]','$campo5[$i]','$campo15[$i]','$campo16[$i]','$campo17[$i]')");


            //Verifica se houve alteração da Embalagem



            $sql = "SELECT a.proemb,a.procod,a.prnome,a.clacodigo,b.barunidade,b.barcaixa 
                    FROM produto a 
                    LEFT JOIN cbarras b ON a.procodigo = b.procodigo 
                    WHERE a.procodigo = '$procodigo'";
            $sql = pg_query($sql);
            $row = pg_num_rows($sql);
            if ($row) {

                $prolog = date('Y-m-d H:i:s');

                $proembAntigo = pg_fetch_result($sql, 0, "proemb");
                $clacodigoAntigo = pg_fetch_result($sql, 0, "clacodigo");
                $barunidadeAntigo = pg_fetch_result($sql, 0, "barunidade");
                $barcaixaAntigo = pg_fetch_result($sql, 0, "barcaixa");

                $procod = pg_fetch_result($sql, 0, "procod");
                $prnome = pg_fetch_result($sql, 0, "prnome");
                $proemb = $campo10[$i];
                $clacodigo = $campo12[$i];
                $barunidade1 = $campo14[$i];
                $barcaixa1 = $campo11[$i];

                if ($proembAntigo != $proemb) {

                    $DadosLog = null;
                    $DadosLog = ['lgpdata' => $prolog, 'usucodigo' => $usuario, 'procodigo' => $procodigo, 'procampo' => 31, 'proantes' => $proembAntigo, 'prodepois' => $proemb];
                    $Cadastra = new Create;
                    $Cadastra->ExeCreate('logprodutos', 'logprodutos_lgprocodigo_seq', $DadosLog);


                    $sql = "SELECT usulogin FROM usuarios WHERE usucodigo = '$usuario'";
                    $read = new Read;
                    $read->FullRead($sql);

                    $usulogin = "";
                    if ($read->getRowCount() >= 1) {
                        $usulogin = $read->getResult()[0]['usulogin'];
                    }
                    $read = null;

                    //Localiza quem deve Receber
                    $sql = "SELECT embmail FROM embemail";

                    $read = new Read;
                    $read->FullRead($sql);
                    $destinatarios = array();
                    if ($read->getRowCount() >= 1) {

                        foreach ($read->getResult() as $registros) {
                            extract($registros);
                            $destinatarios[] = trim($embmail);
                        }
                    }
                    $read = null;

                    $assunto = "ATENÇÃO ! Alteração de Embalagem " . $procod . " !";

                    $msg = "";

                    $msg .= '<h4><span style="font-family:tahoma,geneva,sans-serif;">' . "Atenção, embalagem alterada!" . '</span></h4>';
                    $msg .= '<p><span style="font-family:tahoma,geneva,sans-serif;">' . "Produto: <b>" . $procod . " " . $prnome . '</b></span></p>';
                    $msg .= '<p><span style="font-family:tahoma,geneva,sans-serif;">' . "De <b>" . $proembAntigo . "</b> para <b>" . $proemb . '</b></span></p>';
                    $msg .= '<p><span style="font-family:tahoma,geneva,sans-serif;">' . "Usuário: " . $usulogin . '</span></p>';
                    $msg .= '<p><span style="font-family:tahoma,geneva,sans-serif;">' . "Data: " . date('d/m/Y H:i:s') . '</span></p>';

                    $Email = new EnviarEmail();
                    $Email->enviar($destinatarios, $assunto, $msg, '', 1, 1, "Embalagem_" . $procod);
                }

                if ($clacodigoAntigo != $clacodigo) {
                    $DadosLog = null;
                    $DadosLog = ['lgpdata' => $prolog, 'usucodigo' => $usuario, 'procodigo' => $procodigo, 'procampo' => 4, 'proantes' => $clacodigoAntigo, 'prodepois' => $clacodigo];
                    $Cadastra = new Create;
                    $Cadastra->ExeCreate('logprodutos', 'logprodutos_lgprocodigo_seq', $DadosLog);
                }

                if ($barunidadeAntigo != $barunidade1) {
                    $DadosLog = null;
                    $DadosLog = ['lgpdata' => $prolog, 'usucodigo' => $usuario, 'procodigo' => $procodigo, 'procampo' => 43, 'proantes' => $barunidadeAntigo, 'prodepois' => $barunidade1];
                    $Cadastra = new Create;
                    $Cadastra->ExeCreate('logprodutos', 'logprodutos_lgprocodigo_seq', $DadosLog);
                }
                if ($barcaixaAntigo != $barcaixa1) {
                    $DadosLog = null;
                    $DadosLog = ['lgpdata' => $prolog, 'usucodigo' => $usuario, 'procodigo' => $procodigo, 'procampo' => 44, 'proantes' => $barcaixaAntigo, 'prodepois' => $barcaixa1];
                    $Cadastra = new Create;
                    $Cadastra->ExeCreate('logprodutos', 'logprodutos_lgprocodigo_seq', $DadosLog);
                }

                //Se não for Validação envia e-mail com as alterações 

                $sql = "SELECT log.procodigo, 
                            pr.prnome AS produto,pr.procod AS codigo,
                            log.proantes AS antes,log.prodepois AS depois,
                            log.lgpdata AS data,
                            log.procampo AS campo,
                            us.usunome AS usuario 
                            FROM logprodutos log, produto pr,usuarios us  
                            WHERE log.procodigo = {$procodigo} AND lgpdata = '{$prolog}' AND log.procodigo = pr.procodigo AND log.usucodigo = us.usucodigo 
                            ORDER BY log.lgpdata,log.procampo";

                $read = new Read;
                $read->FullRead($sql);

                if ($read->getRowCount() >= 1) {

                    $sql2 = "SELECT usulogin FROM usuarios WHERE usucodigo = '$usuario'";
                    $read2 = new Read;
                    $read2->FullRead($sql2);

                    $usulogin = "";
                    if ($read2->getRowCount() >= 1) {
                        $usulogin = $read2->getResult()[0]['usulogin'];
                    }
                    $read2 = null;

                    //Localiza quem deve Receber
                    $sql2 = "SELECT prodmail FROM produtoemail";

                    $read2 = new Read;
                    $read2->FullRead($sql2);
                    $destinatarios = array();
                    if ($read2->getRowCount() >= 1) {

                        foreach ($read2->getResult() as $registros2) {
                            extract($registros2);
                            $destinatarios[] = trim($prodmail);
                        }
                    }
                    $read2 = null;

                    $assunto = "ATENÇÃO ! Alteração de Produto " . $procod . " !";

                    $msg = "";

                    $msg .= '<h4><span style="font-family:tahoma,geneva,sans-serif;">' . "Atenção, produto alterado!" . '</span></h4>';
                    $msg .= '<p><span style="font-family:tahoma,geneva,sans-serif;">' . "Produto: <b>" . $procod . " " . $prnome . '</b></span></p>';
                    //$msg .= '<p><span style="font-family:tahoma,geneva,sans-serif;">' . "De <b>" . $proembAntigo . "</b> para <b>" . $proemb . '</b></span></p>';


                    foreach ($read->getResult() as $registros) {

                        extract($registros);

                        $hora = trim(substr($data, 11, 5));
                        $data = trim(substr($data, 0, 10));

                        if ($campo == 1) {
                            $campo = "ORIGEM";
                        } else if ($campo == 2) {
                            $campo = "SITUACAO TRIBUTARIA";
                        } else if ($campo == 3) {
                            $campo = "PROCEDENCIA";
                            if ($antes == 1) {
                                $antes = "1 - PROD. NACION. TRIBUTADOS";
                            } else if ($antes == 2) {
                                $antes = "2 - PROD. NACION. NAO TRIBUTADOS";
                            } else if ($antes == 3) {
                                $antes = "3 - PRODUTOS ISENTOS";
                            } else if ($antes == 4) {
                                $antes = "4 - P. ESTRANG. ADQUIR. MERC. INTER.";
                            } else if ($antes == 5) {
                                $antes = "5 - P. ESTRANG. DE IMPOR. DIRETA";
                            } else if ($antes == 6) {
                                $antes = "6 - PRODUTO COM SUSP. DO IPI";
                            } else if ($antes == 7) {
                                $antes = "6 - OUTROS";
                            }
                            if ($depois == 1) {
                                $depois = "1 - PROD. NACION. TRIBUTADOS";
                            } else if ($depois == 2) {
                                $depois = "2 - PROD. NACION. NAO TRIBUTADOS";
                            } else if ($depois == 3) {
                                $depois = "3 - PRODUTOS ISENTOS";
                            } else if ($depois == 4) {
                                $depois = "4 - P. ESTRANG. ADQUIR. MERC. INTER.";
                            } else if ($depois == 5) {
                                $depois = "5 - P. ESTRANG. DE IMPOR. DIRETA";
                            } else if ($depois == 6) {
                                $depois = "6 - PRODUTO COM SUSP. DO IPI";
                            } else if ($depois == 7) {
                                $depois = "6 - OUTROS";
                            }
                        } else if ($campo == 4) {
                            $campo = "CLASSIFICACAO FISCAL";
                            if ($antes != '') {
                                $sql2 = "SELECT clanumero FROM clfiscal WHERE clacodigo=$antes";
                                $read2 = new Read;
                                $read2->FullRead($sql2);
                                if ($read2->getRowCount() >= 1) {
                                    $antes = $read2->getResult()[0]['clanumero'];
                                }
                            }
                            if ($depois != '') {
                                $sql2 = "SELECT clanumero FROM clfiscal WHERE clacodigo=$depois";
                                $read2 = new Read;
                                $read2->FullRead($sql2);
                                if ($read2->getRowCount() >= 1) {
                                    $depois = $read2->getResult()[0]['clanumero'];
                                }
                            }
                        } else if ($campo == 5) {
                            $campo = "CALCULO ICMS";
                            if ($antes == 1) {
                                $antes = 'NORMAL';
                            } else if ($antes == 2) {
                                $antes = 'ISENTO';
                            } else if ($antes == 3) {
                                $antes = 'ESPECIAL';
                            }
                            if ($depois == 1) {
                                $depois = 'NORMAL';
                            } else if ($depois == 2) {
                                $depois = 'ISENTO';
                            } else if ($depois == 3) {
                                $depois = 'ESPECIAL';
                            }
                        } else if ($campo == 6) {
                            $campo = "PERCENTUAL IPI";
                        } else if ($campo == 7) {
                            $campo = "IVA";
                            if ($antes != '') {
                                $sql2 = "SELECT descricao FROM iva WHERE ivacodigo=$antes";
                                $read2 = new Read;
                                $read2->FullRead($sql2);
                                if ($read2->getRowCount() >= 1) {
                                    $antes .= ' ' . $read2->getResult()[0]['descricao'];
                                }
                            }
                            if ($depois != '') {
                                $sql2 = "SELECT descricao FROM iva WHERE ivacodigo=$depois";
                                $sql2 = pg_query($sql2);
                                $row2 = pg_num_rows($sql2);
                                if ($row2) {
                                    $depois .= ' ' . $read2->getResult()[0]['descricao'];
                                }
                            }
                        } else if ($campo == 8) {
                            $campo = "CALCULO DE ST";
                            if ($antes == 'S') {
                                $antes = 'SIM';
                            } else if ($antes == 'N') {
                                $antes = 'NAO';
                            }
                            if ($depois == 'S') {
                                $depois = 'SIM';
                            } else if ($depois == 'N') {
                                $depois = 'NAO';
                            }
                        } else if ($campo == 9) {
                            $campo = "CALCULO DIFAL";
                            if ($antes == 'S') {
                                $antes = 'SIM';
                            } else {
                                $antes = 'NAO';
                            }
                            if ($depois == 'S') {
                                $depois = 'SIM';
                            } else {
                                $depois = 'NAO';
                            }
                        } else if ($campo == 10) {
                            $campo = "CALCULO ST ESTADO SP";
                            if ($antes == 'I') {
                                $antes = 'IMPORTADO';
                            } else if ($antes == 'N') {
                                $antes = 'NORMAL';
                            }
                            if ($depois == 'I') {
                                $depois = 'IMPORTADO';
                            } else if ($depois == 'N') {
                                $depois = 'NORMAL';
                            }
                        } else if ($campo == 11) {
                            $campo = "PERCENTUAL IVA MG";
                        } else if ($campo == 12) {
                            $campo = "PERCENTUAL IVA SP";
                        } else if ($campo == 13) {
                            $campo = "PERCENTUAL IVA BA";
                        } else if ($campo == 14) {
                            $campo = "PERCENTUAL IVA RS";
                        } else if ($campo == 15) {
                            $campo = "PERCENTUAL IVA PE";
                        } else if ($campo == 16) {
                            $campo = "PERCENTUAL IVA SC";
                        } else if ($campo == 17) {
                            $campo = "PERCENTUAL IVA RJ";
                        } else if ($campo == 18) {
                            $campo = "PERCENTUAL IVA SE";
                        } else if ($campo == 19) {
                            $campo = "PERCENTUAL IVA AL";
                        } else if ($campo == 20) {
                            $campo = "PERCENTUAL IVA AP";
                        } else if ($campo == 21) {
                            $campo = "PERCENTUAL IVA PR";
                        } else if ($campo == 22) {
                            $campo = "PERCENTUAL IVA MT";
                        } else if ($campo == 23) {
                            $campo = "PERCENTUAL IVA MS";
                        } else if ($campo == 24) {
                            $campo = "MVA PR IMPORTADO";
                        } else if ($campo == 25) {
                            $campo = "MVA PR NACIONAL";
                        } else if ($campo == 26) {
                            $campo = "MVA SC NACIONAL";
                        } else if ($campo == 27) {
                            $campo = "MVA SC IMPORTADO";
                        } else if ($campo == 28) {
                            $campo = "IVA SC SIMPLES";
                        } else if ($campo == 29) {
                            $campo = "ICMS SC SIMPLES";
                        } else if ($campo == 30) {
                            $campo = "ST EXCECAO";
                        } else if ($campo == 31) {
                            $campo = "EMBALAGEM";
                        } else if ($campo == 32) {
                            $campo = "ALTURA";
                        } else if ($campo == 33) {
                            $campo = "LARGURA";
                        } else if ($campo == 34) {
                            $campo = "COMPRIMENTO";
                        } else if ($campo == 35) {
                            $campo = "PESO";
                        } else if ($campo == 36) {
                            $campo = "ALTURA CAIXA";
                        } else if ($campo == 37) {
                            $campo = "LARGURA CAIXA";
                        } else if ($campo == 38) {
                            $campo = "COMPRIMENTO CAIXA";
                        } else if ($campo == 39) {
                            $campo = "PESO CAIXA";
                        } else if ($campo == 40) {
                            $campo = "NOME PRODUTO";
                        } else if ($campo == 41) {
                            $campo = "DESCRICAO PRODUTO";
                        } else if ($campo == 42) {
                            $campo = "UNIDADE DE MEDIDA";
                            if ($antes != '') {
                                $sql2 = "SELECT mednome FROM medidas WHERE medcodigo={$antes}";
                                $read2 = new Read;
                                $read2->FullRead($sql2);
                                if ($read2->getRowCount() >= 1) {
                                    $antes = $read2->getResult()[0]['mednome'];
                                }
                                $read2 = null;
                            }
                            if ($depois != '') {
                                $sql2 = "SELECT mednome FROM medidas WHERE medcodigo={$depois}";
                                $read2 = new Read;
                                $read2->FullRead($sql2);
                                if ($read2->getRowCount() >= 1) {
                                    $depois = $read2->getResult()[0]['mednome'];
                                }
                                $read2 = null;
                            }
                        } else if ($campo == 43) {
                            $campo = "EAN 13";
                        } else if ($campo == 44) {
                            $campo = "DUN 14";
                        }

                        $msg .= '<p><span style="font-family:tahoma,geneva,sans-serif;">' . "Campo <b>" . $campo . "</b> de <b>" . $antes . "</b> para <b>" . $depois . '</b></span></p>';
                    }


                    $msg .= '<p><span style="font-family:tahoma,geneva,sans-serif;">' . "Usuário: " . $usulogin . '</span></p>';
                    $msg .= '<p><span style="font-family:tahoma,geneva,sans-serif;">' . "Data: " . date('d/m/Y H:i:s') . '</span></p>';

                    $Email = new EnviarEmail();
                    $Email->enviar($destinatarios, $assunto, $msg, '', 1, 1, "Produto_" . $procod);
                }
                $read = null;
            }


            /*
              $sql = "Update produto set proaltcx='$campo6[$i]',prolarcx='$campo7[$i]',procomcx='$campo8[$i]',propescx='$campo9[$i]',proemb='$campo10[$i]',clacodigo='$campo12[$i]'
              Where procodigo = '$procodigo'";
             */
            //A partir de 04/09 não atualiza mais a cubagem
            $sql = "Update produto set proemb='$campo10[$i]',clacodigo='$campo12[$i]'
	 Where procodigo = '$procodigo'";

            pg_query($sql);


            $sql = "Select * from cbarras Where procodigo = '$procodigo'";
            $sql = pg_query($sql);
            $row = pg_num_rows($sql);
            if ($row) {
                $sql = "Update cbarras set barcaixa='$campo11[$i]',barunidade='$campo14[$i]'
		Where procodigo = '$procodigo'";
                pg_query($sql);
            } else {
                $sql = "Insert into cbarras (barcaixa,barunidade,procodigo) values ('$campo11[$i]','$campo14[$i]','$procodigo')";
                pg_query($sql);
            }


            //Se for um Item Master Vai gravar todos os Sortimentos			
            $pegar2 = "SELECT procodigo from produto where promaster = $procodigo";
            $cad2 = pg_query($pegar2);
            $row2 = pg_num_rows($cad2);
            if ($row2) {
                //Grava o Master com a Quantidade Total				
                $cadastro->insere("neitemsort", "(nenumero,neserie,notentcodigo,promaster,procodigo,neisaldo)", "(
				'$nota1','$serie1','$notentcodigo','$procodigo','$procodigo','$campo2[$i]')");
                //Grava os Sortimentos Zerados
                for ($j = 0; $j < $row2; $j++) {
                    $sortimento = pg_fetch_result($cad2, $j, "procodigo");
                    $cadastro->insere("neitemsort", "(nenumero,neserie,notentcodigo,promaster,procodigo,neisaldo)", "(
					'$nota1','$serie1','$notentcodigo','$procodigo','$sortimento','0')");
                }
            }
        }


        $cadastro->alterapcitem("pcitem", "pcibaixa=$saldo", "$campo1[$i]");
    }
}


//Retirei a parte que faz a Geração de Arquivos WMS Backup na pasta 26/02/2020

pg_close($conn);

$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
$xml .= "<dados>\n";
$xml .= "<dado>\n";
$xml .= "<seq>" . $pcseq . "</seq>\n";
$xml .= "</dado>\n";
$xml .= "</dados>\n";
Header("Content-type: application/xml; charset=iso-8859-1");

//PRINTA O RESULTADO
echo $xml;
?>
