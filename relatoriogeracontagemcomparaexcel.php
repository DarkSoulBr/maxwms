<?php

require_once("include/conexao.inc.php");
require_once("include/gerencial.php");

$cadastro = new banco($conn, $db);

$invdata = trim($_GET["invdata"]);
$contagem = trim($_GET["contagem"]);
$contagem2 = trim($_GET["contagem2"]);
$contagem3 = trim($_GET["contagem3"]);
$estoque = trim($_GET["estoque"]);

$invdata2 = $invdata;

$aux = explode("/", $invdata);
$invdata = $aux[2] . '-' . $aux[1] . '-' . $aux[0] . ' 00:00:00-03';

$nome = '/home/delta/compara.csv';

if (file_exists($nome)) {
    unlink($nome);
}
$arquivo = fopen("$nome", "x+");

$query = $cadastro->seleciona("contnome", "contagem", "contcodigo=$contagem");
$array = pg_fetch_object($query);

$estoque1 = $array->contnome;

$query = $cadastro->seleciona("contnome", "contagem", "contcodigo=$contagem2");
$array = pg_fetch_object($query);

$estoque2 = $array->contnome;

$query = $cadastro->seleciona("contnome", "contagem", "contcodigo=$contagem3");
$array = pg_fetch_object($query);

$estoque4 = $array->contnome;

$query = $cadastro->seleciona("etqnome", "estoque", "etqcodigo=$estoque");
$array = pg_fetch_object($query);

$estoque3 = $array->etqnome;



//$query_produto = $cadastro->seleciona("p.procod as codigo,p.procodigo,p.prnome as nome,g.grunome as grupo,f.fornguerra as subgrupo, p.proref as referencia, p.proemb as embalagem,m.medsigla as unidade, p.proreal as real, p.profinal as final, p.prorealv as realv, p.profinalv as finalv","produto p left join grupo g on p.grucodigo=g.grucodigo left join fornecedor f on p.forcodigo=f.forcodigo left join medidas m on p.medcodigo=m.medcodigo","p.procodigo > 0 order by p.procod asc");
$query_produto = $cadastro->seleciona("p.procod as codigo,p.procodigo,p.promaster,p.prnome as nome,g.grunome as grupo,f.fornguerra as subgrupo, p.proref as referencia, p.proemb as embalagem,m.medsigla as unidade, p.proreal as real, p.profinal as final, p.prorealv as realv, p.profinalv as finalv, e.estqtd as quantidade, d.barunidade", "produto p left join grupo g on p.grucodigo=g.grucodigo left join fornecedor f on p.forcodigo=f.forcodigo left join medidas m on p.medcodigo=m.medcodigo left join estoqueatual e on p.procodigo=e.procodigo and e.codestoque=$estoque left join cbarras d on p.procodigo=d.procodigo", "p.procodigo > 0 order by p.procod asc");


$row = pg_num_rows($query_produto);
if ($row > 0) {
    $anteriorsub = 0;
    $anteriorgrupo = 0;
    for ($j = 0; $j < $row; $j++) {
    //for($j=0;$j<100;$j++)
        $total = 0;
        $aux = 0;
        $array_produto = pg_fetch_object($query_produto);

        if ($j == 0) {

            $linha = 'Código' . ';' . 'Nome' . ';' . 'Master' . ';' . 'Grupo' . ';' . 'Fornecedor' . ';' . 'Referência' . ';' . 'C.Barras' . ';' .
                    'Embalagem' . ';' .
                    'Unidade' . ';' .
                    $estoque1 . ';' .
                    $estoque2 . ';' .
                    $estoque4 . ';' .
                    'Inventario' . ';' .
                    $estoque3 . ';' .
                    'C.Real' . ';' .
                    'C.Fiscal' . ';' .
                    'C1 S01' . ';' .
                    'C1 Q01' . ';' .
                    'C1 S02' . ';' .
                    'C1 Q02' . ';' .
                    'C1 S03' . ';' .
                    'C1 Q03' . ';' .
                    'C1 S04' . ';' .
                    'C1 Q04' . ';' .
                    'C1 S05' . ';' .
                    'C1 Q05' . ';' .
                    'C1 S06' . ';' .
                    'C1 Q06' . ';' .
                    'C1 S07' . ';' .
                    'C1 Q07' . ';' .
                    'C1 S08' . ';' .
                    'C1 Q08' . ';' .
                    'C1 S09' . ';' .
                    'C1 Q09' . ';' .
                    'C1 S10' . ';' .
                    'C1 Q10' . ';' .
                    'C1 S11' . ';' .
                    'C1 Q11' . ';' .
                    'C1 S12' . ';' .
                    'C1 Q12' . ';' .
                    'C1 S13' . ';' .
                    'C1 Q13' . ';' .
                    'C1 S14' . ';' .
                    'C1 Q14' . ';' .
                    'C1 S15' . ';' .
                    'C1 Q15' . ';' .
                    'C1 S16' . ';' .
                    'C1 Q16' . ';' .
                    'C1 S17' . ';' .
                    'C1 Q17' . ';' .
                    'C1 S18' . ';' .
                    'C1 Q18' . ';' .
                    'C1 S19' . ';' .
                    'C1 Q19' . ';' .
                    'C1 S20' . ';' .
                    'C1 Q20' . ';' .
                    'C2 S01' . ';' .
                    'C2 Q01' . ';' .
                    'C2 S02' . ';' .
                    'C2 Q02' . ';' .
                    'C2 S03' . ';' .
                    'C2 Q03' . ';' .
                    'C2 S04' . ';' .
                    'C2 Q04' . ';' .
                    'C2 S05' . ';' .
                    'C2 Q05' . ';' .
                    'C2 S06' . ';' .
                    'C2 Q06' . ';' .
                    'C2 S07' . ';' .
                    'C2 Q07' . ';' .
                    'C2 S08' . ';' .
                    'C2 Q08' . ';' .
                    'C2 S09' . ';' .
                    'C2 Q09' . ';' .
                    'C2 S10' . ';' .
                    'C2 Q10' . ';' .
                    'C2 S11' . ';' .
                    'C2 Q11' . ';' .
                    'C2 S12' . ';' .
                    'C2 Q12' . ';' .
                    'C2 S13' . ';' .
                    'C2 Q13' . ';' .
                    'C2 S14' . ';' .
                    'C2 Q14' . ';' .
                    'C2 S15' . ';' .
                    'C2 Q15' . ';' .
                    'C2 S16' . ';' .
                    'C2 Q16' . ';' .
                    'C2 S17' . ';' .
                    'C2 Q17' . ';' .
                    'C2 S18' . ';' .
                    'C2 Q18' . ';' .
                    'C2 S19' . ';' .
                    'C2 Q19' . ';' .
                    'C2 S20' . ';' .
                    'C2 Q20' . ';' .
                    'C3 S01' . ';' .
                    'C3 Q01' . ';' .
                    'C3 S02' . ';' .
                    'C3 Q02' . ';' .
                    'C3 S03' . ';' .
                    'C3 Q03' . ';' .
                    'C3 S04' . ';' .
                    'C3 Q04' . ';' .
                    'C3 S05' . ';' .
                    'C3 Q05' . ';' .
                    'C3 S06' . ';' .
                    'C3 Q06' . ';' .
                    'C3 S07' . ';' .
                    'C3 Q07' . ';' .
                    'C3 S08' . ';' .
                    'C3 Q08' . ';' .
                    'C3 S09' . ';' .
                    'C3 Q09' . ';' .
                    'C3 S10' . ';' .
                    'C3 Q10' . ';' .
                    'C3 S11' . ';' .
                    'C3 Q11' . ';' .
                    'C3 S12' . ';' .
                    'C3 Q12' . ';' .
                    'C3 S13' . ';' .
                    'C3 Q13' . ';' .
                    'C3 S14' . ';' .
                    'C3 Q14' . ';' .
                    'C3 S15' . ';' .
                    'C3 Q15' . ';' .
                    'C3 S16' . ';' .
                    'C3 Q16' . ';' .
                    'C3 S17' . ';' .
                    'C3 Q17' . ';' .
                    'C3 S18' . ';' .
                    'C3 Q18' . ';' .
                    'C3 S19' . ';' .
                    'C3 Q19' . ';' .
                    'C3 S20' . ';' .
                    'C3 Q20';

            fputs($arquivo, "$linha\r\n");
        }

        echo $array_produto->codigo . '<br>';

        //Verifica a Contagem			
        $sql2 = "
			SELECT sum (quantidade) as estoque 
			FROM inventariocontagemsetorproduto where procodigo = " . $array_produto->procodigo . " and invdata = '$invdata' and concodigo = $contagem";

        //EXECUTA A QUERY
        $sql2 = pg_query($sql2);

        $row2 = pg_num_rows($sql2);

        $quantidade = 0;

        if ($row2) {
            $quantidade = pg_fetch_result($sql2, 0, "estoque");
        }


        $c1s01 = 'NAO CONTADO';
        $c1q01 = 'NAO CONTADO';
        $c1s02 = 'NAO CONTADO';
        $c1q02 = 'NAO CONTADO';
        $c1s03 = 'NAO CONTADO';
        $c1q03 = 'NAO CONTADO';
        $c1s04 = 'NAO CONTADO';
        $c1q04 = 'NAO CONTADO';
        $c1s05 = 'NAO CONTADO';
        $c1q05 = 'NAO CONTADO';
        $c1s06 = 'NAO CONTADO';
        $c1q06 = 'NAO CONTADO';
        $c1s07 = 'NAO CONTADO';
        $c1q07 = 'NAO CONTADO';
        $c1s08 = 'NAO CONTADO';
        $c1q08 = 'NAO CONTADO';
        $c1s09 = 'NAO CONTADO';
        $c1q09 = 'NAO CONTADO';
        $c1s10 = 'NAO CONTADO';
        $c1q10 = 'NAO CONTADO';
        $c1s11 = 'NAO CONTADO';
        $c1q11 = 'NAO CONTADO';
        $c1s12 = 'NAO CONTADO';
        $c1q12 = 'NAO CONTADO';
        $c1s13 = 'NAO CONTADO';
        $c1q13 = 'NAO CONTADO';
        $c1s14 = 'NAO CONTADO';
        $c1q14 = 'NAO CONTADO';
        $c1s15 = 'NAO CONTADO';
        $c1q15 = 'NAO CONTADO';
        $c1s16 = 'NAO CONTADO';
        $c1q16 = 'NAO CONTADO';
        $c1s17 = 'NAO CONTADO';
        $c1q17 = 'NAO CONTADO';
        $c1s18 = 'NAO CONTADO';
        $c1q18 = 'NAO CONTADO';
        $c1s19 = 'NAO CONTADO';
        $c1q19 = 'NAO CONTADO';
        $c1s20 = 'NAO CONTADO';
        $c1q20 = 'NAO CONTADO';

        if ($quantidade == '') {
            $qtd = 'NAO CONTADO';
            $quantidade = 0;
        } else {
            $qtd = '';

            $sql2 = "SELECT a.quantidade as estoque,b.setor 
				FROM inventariocontagemsetorproduto a,setor b where a.setcodigo = b.setcodigo and procodigo = " . $array_produto->procodigo . " and invdata = '$invdata' and concodigo = $contagem order by a.setcodigo";

            //EXECUTA A QUERY
            $sql2 = pg_query($sql2);

            $row2 = pg_num_rows($sql2);

            if ($row2) {

                for ($j2 = 0; $j2 < $row2; $j2++) {
                    if ($j2 == 0) {
                        $c1s01 = pg_fetch_result($sql2, $j2, "setor");
                        $c1q01 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 1) {
                        $c1s02 = pg_fetch_result($sql2, $j2, "setor");
                        $c1q02 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 2) {
                        $c1s03 = pg_fetch_result($sql2, $j2, "setor");
                        $c1q03 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 3) {
                        $c1s04 = pg_fetch_result($sql2, $j2, "setor");
                        $c1q04 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 4) {
                        $c1s05 = pg_fetch_result($sql2, $j2, "setor");
                        $c1q05 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 5) {
                        $c1s06 = pg_fetch_result($sql2, $j2, "setor");
                        $c1q06 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 6) {
                        $c1s07 = pg_fetch_result($sql2, $j2, "setor");
                        $c1q07 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 7) {
                        $c1s08 = pg_fetch_result($sql2, $j2, "setor");
                        $c1q08 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 8) {
                        $c1s09 = pg_fetch_result($sql2, $j2, "setor");
                        $c1q09 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 9) {
                        $c1s10 = pg_fetch_result($sql2, $j2, "setor");
                        $c1q10 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 10) {
                        $c1s11 = pg_fetch_result($sql2, $j2, "setor");
                        $c1q11 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 11) {
                        $c1s12 = pg_fetch_result($sql2, $j2, "setor");
                        $c1q12 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 12) {
                        $c1s13 = pg_fetch_result($sql2, $j2, "setor");
                        $c1q13 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 13) {
                        $c1s14 = pg_fetch_result($sql2, $j2, "setor");
                        $c1q14 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 14) {
                        $c1s15 = pg_fetch_result($sql2, $j2, "setor");
                        $c1q15 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 15) {
                        $c1s16 = pg_fetch_result($sql2, $j2, "setor");
                        $c1q16 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 16) {
                        $c1s17 = pg_fetch_result($sql2, $j2, "setor");
                        $c1q17 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 17) {
                        $c1s18 = pg_fetch_result($sql2, $j2, "setor");
                        $c1q18 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 18) {
                        $c1s19 = pg_fetch_result($sql2, $j2, "setor");
                        $c1q19 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 19) {
                        $c1s20 = pg_fetch_result($sql2, $j2, "setor");
                        $c1q20 = pg_fetch_result($sql2, $j2, "estoque");
                    }
                }
            }
        }

        //Verifica a Contagem			
        $sql2 = "
			SELECT sum (quantidade) as estoque 
			FROM inventariocontagemsetorproduto where procodigo = " . $array_produto->procodigo . " and invdata = '$invdata' and concodigo = $contagem2";

        //EXECUTA A QUERY
        $sql2 = pg_query($sql2);

        $row2 = pg_num_rows($sql2);

        $quantidade2 = 0;

        if ($row2) {
            $quantidade2 = pg_fetch_result($sql2, 0, "estoque");
        }

        $c2s01 = 'NAO CONTADO';
        $c2q01 = 'NAO CONTADO';
        $c2s02 = 'NAO CONTADO';
        $c2q02 = 'NAO CONTADO';
        $c2s03 = 'NAO CONTADO';
        $c2q03 = 'NAO CONTADO';
        $c2s04 = 'NAO CONTADO';
        $c2q04 = 'NAO CONTADO';
        $c2s05 = 'NAO CONTADO';
        $c2q05 = 'NAO CONTADO';
        $c2s06 = 'NAO CONTADO';
        $c2q06 = 'NAO CONTADO';
        $c2s07 = 'NAO CONTADO';
        $c2q07 = 'NAO CONTADO';
        $c2s08 = 'NAO CONTADO';
        $c2q08 = 'NAO CONTADO';
        $c2s09 = 'NAO CONTADO';
        $c2q09 = 'NAO CONTADO';
        $c2s10 = 'NAO CONTADO';
        $c2q10 = 'NAO CONTADO';
        $c2s11 = 'NAO CONTADO';
        $c2q11 = 'NAO CONTADO';
        $c2s12 = 'NAO CONTADO';
        $c2q12 = 'NAO CONTADO';
        $c2s13 = 'NAO CONTADO';
        $c2q13 = 'NAO CONTADO';
        $c2s14 = 'NAO CONTADO';
        $c2q14 = 'NAO CONTADO';
        $c2s15 = 'NAO CONTADO';
        $c2q15 = 'NAO CONTADO';
        $c2s16 = 'NAO CONTADO';
        $c2q16 = 'NAO CONTADO';
        $c2s17 = 'NAO CONTADO';
        $c2q17 = 'NAO CONTADO';
        $c2s18 = 'NAO CONTADO';
        $c2q18 = 'NAO CONTADO';
        $c2s19 = 'NAO CONTADO';
        $c2q19 = 'NAO CONTADO';
        $c2s20 = 'NAO CONTADO';
        $c2q20 = 'NAO CONTADO';

        if ($quantidade2 == '') {
            $qtd2 = 'NAO CONTADO';
            $quantidade2 = 0;
        } else {
            $qtd2 = '';

            $sql2 = "SELECT a.quantidade as estoque,b.setor 
				FROM inventariocontagemsetorproduto a,setor b where a.setcodigo = b.setcodigo and procodigo = " . $array_produto->procodigo . " and invdata = '$invdata' and concodigo = $contagem2 order by a.setcodigo";

            //EXECUTA A QUERY
            $sql2 = pg_query($sql2);

            $row2 = pg_num_rows($sql2);

            if ($row2) {

                for ($j2 = 0; $j2 < $row2; $j2++) {
                    if ($j2 == 0) {
                        $c2s01 = pg_fetch_result($sql2, $j2, "setor");
                        $c2q01 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 1) {
                        $c2s02 = pg_fetch_result($sql2, $j2, "setor");
                        $c2q02 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 2) {
                        $c2s03 = pg_fetch_result($sql2, $j2, "setor");
                        $c2q03 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 3) {
                        $c2s04 = pg_fetch_result($sql2, $j2, "setor");
                        $c2q04 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 4) {
                        $c2s05 = pg_fetch_result($sql2, $j2, "setor");
                        $c2q05 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 5) {
                        $c2s06 = pg_fetch_result($sql2, $j2, "setor");
                        $c2q06 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 6) {
                        $c2s07 = pg_fetch_result($sql2, $j2, "setor");
                        $c2q07 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 7) {
                        $c2s08 = pg_fetch_result($sql2, $j2, "setor");
                        $c2q08 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 8) {
                        $c2s09 = pg_fetch_result($sql2, $j2, "setor");
                        $c2q09 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 9) {
                        $c2s10 = pg_fetch_result($sql2, $j2, "setor");
                        $c2q10 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 10) {
                        $c2s11 = pg_fetch_result($sql2, $j2, "setor");
                        $c2q11 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 11) {
                        $c2s12 = pg_fetch_result($sql2, $j2, "setor");
                        $c2q12 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 12) {
                        $c2s13 = pg_fetch_result($sql2, $j2, "setor");
                        $c2q13 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 13) {
                        $c2s14 = pg_fetch_result($sql2, $j2, "setor");
                        $c2q14 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 14) {
                        $c2s15 = pg_fetch_result($sql2, $j2, "setor");
                        $c2q15 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 15) {
                        $c2s16 = pg_fetch_result($sql2, $j2, "setor");
                        $c2q16 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 16) {
                        $c2s17 = pg_fetch_result($sql2, $j2, "setor");
                        $c2q17 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 17) {
                        $c2s18 = pg_fetch_result($sql2, $j2, "setor");
                        $c2q18 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 18) {
                        $c2s19 = pg_fetch_result($sql2, $j2, "setor");
                        $c2q19 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 19) {
                        $c2s20 = pg_fetch_result($sql2, $j2, "setor");
                        $c2q20 = pg_fetch_result($sql2, $j2, "estoque");
                    }
                }
            }
        }

        //Verifica a Contagem			
        $sql2 = "
			SELECT sum (quantidade) as estoque 
			FROM inventariocontagemsetorproduto where procodigo = " . $array_produto->procodigo . " and invdata = '$invdata' and concodigo = $contagem3";

        //EXECUTA A QUERY
        $sql2 = pg_query($sql2);

        $row2 = pg_num_rows($sql2);

        $quantidade4 = 0;

        if ($row2) {
            $quantidade4 = pg_fetch_result($sql2, 0, "estoque");
        }

        $c3s01 = 'NAO CONTADO';
        $c3q01 = 'NAO CONTADO';
        $c3s02 = 'NAO CONTADO';
        $c3q02 = 'NAO CONTADO';
        $c3s03 = 'NAO CONTADO';
        $c3q03 = 'NAO CONTADO';
        $c3s04 = 'NAO CONTADO';
        $c3q04 = 'NAO CONTADO';
        $c3s05 = 'NAO CONTADO';
        $c3q05 = 'NAO CONTADO';
        $c3s06 = 'NAO CONTADO';
        $c3q06 = 'NAO CONTADO';
        $c3s07 = 'NAO CONTADO';
        $c3q07 = 'NAO CONTADO';
        $c3s08 = 'NAO CONTADO';
        $c3q08 = 'NAO CONTADO';
        $c3s09 = 'NAO CONTADO';
        $c3q09 = 'NAO CONTADO';
        $c3s10 = 'NAO CONTADO';
        $c3q10 = 'NAO CONTADO';
        $c3s11 = 'NAO CONTADO';
        $c3q11 = 'NAO CONTADO';
        $c3s12 = 'NAO CONTADO';
        $c3q12 = 'NAO CONTADO';
        $c3s13 = 'NAO CONTADO';
        $c3q13 = 'NAO CONTADO';
        $c3s14 = 'NAO CONTADO';
        $c3q14 = 'NAO CONTADO';
        $c3s15 = 'NAO CONTADO';
        $c3q15 = 'NAO CONTADO';
        $c3s16 = 'NAO CONTADO';
        $c3q16 = 'NAO CONTADO';
        $c3s17 = 'NAO CONTADO';
        $c3q17 = 'NAO CONTADO';
        $c3s18 = 'NAO CONTADO';
        $c3q18 = 'NAO CONTADO';
        $c3s19 = 'NAO CONTADO';
        $c3q19 = 'NAO CONTADO';
        $c3s20 = 'NAO CONTADO';
        $c3q20 = 'NAO CONTADO';

        if ($quantidade4 == '') {
            $qtd4 = 'NAO CONTADO';
            $quantidade4 = 0;
        } else {
            $qtd4 = '';

            $sql2 = "SELECT a.quantidade as estoque,b.setor 
				FROM inventariocontagemsetorproduto a,setor b where a.setcodigo = b.setcodigo and procodigo = " . $array_produto->procodigo . " and invdata = '$invdata' and concodigo = $contagem3 order by a.setcodigo";

            //EXECUTA A QUERY
            $sql2 = pg_query($sql2);

            $row2 = pg_num_rows($sql2);

            if ($row2) {

                for ($j2 = 0; $j2 < $row2; $j2++) {
                    if ($j2 == 0) {
                        $c3s01 = pg_fetch_result($sql2, $j2, "setor");
                        $c3q01 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 1) {
                        $c3s02 = pg_fetch_result($sql2, $j2, "setor");
                        $c3q02 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 2) {
                        $c3s03 = pg_fetch_result($sql2, $j2, "setor");
                        $c3q03 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 3) {
                        $c3s04 = pg_fetch_result($sql2, $j2, "setor");
                        $c3q04 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 4) {
                        $c3s05 = pg_fetch_result($sql2, $j2, "setor");
                        $c3q05 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 5) {
                        $c3s06 = pg_fetch_result($sql2, $j2, "setor");
                        $c3q06 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 6) {
                        $c3s07 = pg_fetch_result($sql2, $j2, "setor");
                        $c3q07 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 7) {
                        $c3s08 = pg_fetch_result($sql2, $j2, "setor");
                        $c3q08 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 8) {
                        $c3s09 = pg_fetch_result($sql2, $j2, "setor");
                        $c3q09 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 9) {
                        $c3s10 = pg_fetch_result($sql2, $j2, "setor");
                        $c3q10 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 10) {
                        $c3s11 = pg_fetch_result($sql2, $j2, "setor");
                        $c3q11 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 11) {
                        $c3s12 = pg_fetch_result($sql2, $j2, "setor");
                        $c3q12 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 12) {
                        $c3s13 = pg_fetch_result($sql2, $j2, "setor");
                        $c3q13 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 13) {
                        $c3s14 = pg_fetch_result($sql2, $j2, "setor");
                        $c3q14 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 14) {
                        $c3s15 = pg_fetch_result($sql2, $j2, "setor");
                        $c3q15 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 15) {
                        $c3s16 = pg_fetch_result($sql2, $j2, "setor");
                        $c3q16 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 16) {
                        $c3s17 = pg_fetch_result($sql2, $j2, "setor");
                        $c3q17 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 17) {
                        $c3s18 = pg_fetch_result($sql2, $j2, "setor");
                        $c3q18 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 18) {
                        $c3s19 = pg_fetch_result($sql2, $j2, "setor");
                        $c3q19 = pg_fetch_result($sql2, $j2, "estoque");
                    } else if ($j2 == 19) {
                        $c3s20 = pg_fetch_result($sql2, $j2, "setor");
                        $c3q20 = pg_fetch_result($sql2, $j2, "estoque");
                    }
                }
            }
        }

        $quantidade3 = $array_produto->quantidade;

        if ($quantidade3 == '') {
            $quantidade3 = 0;
        }

        //Processa a Quantidade


        if ($qtd != 'NAO CONTADO' || $qtd2 != 'NAO CONTADO' || $qtd4 != 'NAO CONTADO') {

            //echo $procod.' '.$quantidade . ' ' . $quantidade2. ' ' . $quantidade3;
            //echo '<br>';			

            $saldo = '';

            //Sem a terceira Contagem 
            if ($qtd4 == 'NAO CONTADO') {

                //Situacao 1 : Quantidade 1 = 2 
                if ($quantidade == $quantidade2) {
                    $saldo = $quantidade;
                } else {
                    $saldo = "RECONTAR";
                    /*
                      //Situacao 2 : Usa a Contagem 2 se nao for branco
                      if($qtd2!='NAO CONTADO'){
                      $saldo = $quantidade2;
                      }
                      else {
                      $saldo = $quantidade;
                      }
                     */
                }
            }
            //Sem a Segunda Contagem
            else if ($qtd2 == 'NAO CONTADO') {

                //Situacao 1 : Quantidade 1 = 3 
                if ($quantidade == $quantidade4) {
                    $saldo = $quantidade;
                } else {
                    $saldo = "RECONTAR";
                    /*
                      //Situacao 2 : Usa a Contagem 3 se nao for branco
                      if($qtd4!='NAO CONTADO'){
                      $saldo = $quantidade4;
                      }
                      else {
                      $saldo = $quantidade;
                      }
                     */
                }
            }
            //Sem a Primeira Contagem
            else if ($qtd == 'NAO CONTADO') {

                //Situacao 1 : Quantidade 2 = 3 
                if ($quantidade2 == $quantidade4) {
                    $saldo = $quantidade2;
                } else {
                    $saldo = "RECONTAR";
                    /*
                      //Situacao 2 : Usa a Contagem 3 se nao for branco
                      if($qtd4!='NAO CONTADO'){
                      $saldo = $quantidade4;
                      }
                      else {
                      $saldo = $quantidade2;
                      }
                     */
                }
            }
            //Todas estão Preenchidas
            else {

                //Situacao 1 : Quantidade 1 = 2 
                if ($quantidade == $quantidade2) {
                    $saldo = $quantidade;
                }
                //Situacao 2 : Quantidade 1 = 3 
                else if ($quantidade == $quantidade4) {
                    $saldo = $quantidade;
                }
                //Situacao 3 : Quantidade 2 = 3
                else if ($quantidade2 == $quantidade4) {
                    $saldo = $quantidade2;
                }
                //Situacao 3 : Usa a Contagem Final
                else {
                    //$saldo = $quantidade4;									
                    $saldo = "RECONTAR";
                }
            }
        } else {
            $saldo = 'NAO CONTADO';
        }

        $master = "";
        //Verifica se tem Master	
        if ($array_produto->promaster > 0) {
            $sql2 = "
				SELECT procod 
				FROM produto where procodigo = " . $array_produto->promaster;
            //EXECUTA A QUERY
            $sql2 = pg_query($sql2);
            $row2 = pg_num_rows($sql2);
            if ($row2) {
                $master = pg_fetch_result($sql2, 0, "procod");
            }
        }


        //Passa a mostrar todos os produtos		
        //if($quantidade<>0 || $quantidade2<>0 || $quantidade3<>0 || $quantidade4<>0){

        $linha = "'" . $array_produto->codigo . "'" . ";" .
                $array_produto->nome . ";" .
                $master . ";" .
                $array_produto->grupo . ";" .
                $array_produto->subgrupo . ";" .
                $array_produto->referencia . ";" .
                "'" . $array_produto->barunidade . "'" . ";" .
                $array_produto->embalagem . ";" .
                $array_produto->unidade . ";";



        if ($qtd == '') {
            $linha = $linha . $quantidade . ";";
        } else {
            $linha = $linha . $qtd . ";";
        }
        if ($qtd2 == '') {
            $linha = $linha . $quantidade2 . ";";
        } else {
            $linha = $linha . $qtd2 . ";";
        }
        if ($qtd4 == '') {
            $linha = $linha . $quantidade4 . ";";
        } else {
            $linha = $linha . $qtd4 . ";";
        }
        $linha = $linha . $saldo . ";";
        $linha = $linha . $quantidade3 . ";";


        if ($estoque == 11) {
            $real = number_format($array_produto->realv, 2, ',', '');
            $final = number_format($array_produto->finalv, 2, ',', '');
        } else {
            $real = number_format($array_produto->real, 2, ',', '');
            $final = number_format($array_produto->final, 2, ',', '');
        }

        $linha = $linha . $real . ";";
        $linha = $linha . $final . ";";

        $linha = $linha . $c1s01 . ";";
        $linha = $linha . $c1q01 . ";";
        $linha = $linha . $c1s02 . ";";
        $linha = $linha . $c1q02 . ";";
        $linha = $linha . $c1s03 . ";";
        $linha = $linha . $c1q03 . ";";
        $linha = $linha . $c1s04 . ";";
        $linha = $linha . $c1q04 . ";";
        $linha = $linha . $c1s05 . ";";
        $linha = $linha . $c1q05 . ";";
        $linha = $linha . $c1s06 . ";";
        $linha = $linha . $c1q06 . ";";
        $linha = $linha . $c1s07 . ";";
        $linha = $linha . $c1q07 . ";";
        $linha = $linha . $c1s08 . ";";
        $linha = $linha . $c1q08 . ";";
        $linha = $linha . $c1s09 . ";";
        $linha = $linha . $c1q09 . ";";
        $linha = $linha . $c1s10 . ";";
        $linha = $linha . $c1q10 . ";";
        $linha = $linha . $c1s11 . ";";
        $linha = $linha . $c1q11 . ";";
        $linha = $linha . $c1s12 . ";";
        $linha = $linha . $c1q12 . ";";
        $linha = $linha . $c1s13 . ";";
        $linha = $linha . $c1q13 . ";";
        $linha = $linha . $c1s14 . ";";
        $linha = $linha . $c1q14 . ";";
        $linha = $linha . $c1s15 . ";";
        $linha = $linha . $c1q15 . ";";
        $linha = $linha . $c1s16 . ";";
        $linha = $linha . $c1q16 . ";";
        $linha = $linha . $c1s17 . ";";
        $linha = $linha . $c1q17 . ";";
        $linha = $linha . $c1s18 . ";";
        $linha = $linha . $c1q18 . ";";
        $linha = $linha . $c1s19 . ";";
        $linha = $linha . $c1q19 . ";";
        $linha = $linha . $c1s20 . ";";
        $linha = $linha . $c1q20 . ";";

        $linha = $linha . $c2s01 . ";";
        $linha = $linha . $c2q01 . ";";
        $linha = $linha . $c2s02 . ";";
        $linha = $linha . $c2q02 . ";";
        $linha = $linha . $c2s03 . ";";
        $linha = $linha . $c2q03 . ";";
        $linha = $linha . $c2s04 . ";";
        $linha = $linha . $c2q04 . ";";
        $linha = $linha . $c2s05 . ";";
        $linha = $linha . $c2q05 . ";";
        $linha = $linha . $c2s06 . ";";
        $linha = $linha . $c2q06 . ";";
        $linha = $linha . $c2s07 . ";";
        $linha = $linha . $c2q07 . ";";
        $linha = $linha . $c2s08 . ";";
        $linha = $linha . $c2q08 . ";";
        $linha = $linha . $c2s09 . ";";
        $linha = $linha . $c2q09 . ";";
        $linha = $linha . $c2s10 . ";";
        $linha = $linha . $c2q10 . ";";
        $linha = $linha . $c2s11 . ";";
        $linha = $linha . $c2q11 . ";";
        $linha = $linha . $c2s12 . ";";
        $linha = $linha . $c2q12 . ";";
        $linha = $linha . $c2s13 . ";";
        $linha = $linha . $c2q13 . ";";
        $linha = $linha . $c2s14 . ";";
        $linha = $linha . $c2q14 . ";";
        $linha = $linha . $c2s15 . ";";
        $linha = $linha . $c2q15 . ";";
        $linha = $linha . $c2s16 . ";";
        $linha = $linha . $c2q16 . ";";
        $linha = $linha . $c2s17 . ";";
        $linha = $linha . $c2q17 . ";";
        $linha = $linha . $c2s18 . ";";
        $linha = $linha . $c2q18 . ";";
        $linha = $linha . $c2s19 . ";";
        $linha = $linha . $c2q19 . ";";
        $linha = $linha . $c2s20 . ";";
        $linha = $linha . $c2q20 . ";";

        $linha = $linha . $c3s01 . ";";
        $linha = $linha . $c3q01 . ";";
        $linha = $linha . $c3s02 . ";";
        $linha = $linha . $c3q02 . ";";
        $linha = $linha . $c3s03 . ";";
        $linha = $linha . $c3q03 . ";";
        $linha = $linha . $c3s04 . ";";
        $linha = $linha . $c3q04 . ";";
        $linha = $linha . $c3s05 . ";";
        $linha = $linha . $c3q05 . ";";
        $linha = $linha . $c3s06 . ";";
        $linha = $linha . $c3q06 . ";";
        $linha = $linha . $c3s07 . ";";
        $linha = $linha . $c3q07 . ";";
        $linha = $linha . $c3s08 . ";";
        $linha = $linha . $c3q08 . ";";
        $linha = $linha . $c3s09 . ";";
        $linha = $linha . $c3q09 . ";";
        $linha = $linha . $c3s10 . ";";
        $linha = $linha . $c3q10 . ";";
        $linha = $linha . $c3s11 . ";";
        $linha = $linha . $c3q11 . ";";
        $linha = $linha . $c3s12 . ";";
        $linha = $linha . $c3q12 . ";";
        $linha = $linha . $c3s13 . ";";
        $linha = $linha . $c3q13 . ";";
        $linha = $linha . $c3s14 . ";";
        $linha = $linha . $c3q14 . ";";
        $linha = $linha . $c3s15 . ";";
        $linha = $linha . $c3q15 . ";";
        $linha = $linha . $c3s16 . ";";
        $linha = $linha . $c3q16 . ";";
        $linha = $linha . $c3s17 . ";";
        $linha = $linha . $c3q17 . ";";
        $linha = $linha . $c3s18 . ";";
        $linha = $linha . $c3q18 . ";";
        $linha = $linha . $c3s19 . ";";
        $linha = $linha . $c3q19 . ";";
        $linha = $linha . $c3s20 . ";";
        $linha = $linha . $c3q20 . ";";

        fputs($arquivo, "$linha\r\n");

        //}	
    }
}


echo ' ';
echo ' ';
echo '<br>';
echo 'FINAL DE PROCESSAMENTO!';

fclose($arquivo);

pg_close($conn);
exit();
