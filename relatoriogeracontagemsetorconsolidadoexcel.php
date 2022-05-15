<?php

require_once("include/conexao.inc.php");
require_once("include/gerencial.php");

$cadastro = new banco($conn, $db);

$invdata = trim($_GET["invdata"]);
$contagem = trim($_GET["contagem"]);
$contagem2 = trim($_GET["contagem2"]);
$contagem3 = trim($_GET["contagem3"]);

$aux = explode("/", $invdata);
$invdata = $aux[2] . '-' . $aux[1] . '-' . $aux[0] . ' 00:00:00-03';

header("Content-type: " . "application/vnd.ms-excel");
header("Content-disposition: attachment; filename=relatoriocontagem.xls");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

$query = $cadastro->seleciona("contnome", "contagem", "contcodigo=$contagem");
$array = pg_fetch_object($query);

$estoque1 = $array->contnome;

echo "<html>\r\n";
echo "<head><title>" . $report_names . "</title><meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel\"></head>\r\n";
echo "<body>\r\n";
echo "<table width='200' border='1' cellspacing='1' cellpadding='1' bordercolor='#999999'><tr>";

//TITULO
echo "<td bgcolor='#CCCCCC' width='200' class='borda' colspan='18' align='center' valign='middle' height='35'><font color='#000000'><b>Relatório Gerencial de Contagem de Estoque</b>";

$query_produto = $cadastro->seleciona("p.procod as codigo,p.procodigo,p.promaster,p.prnome as nome,g.grunome as grupo,f.fornguerra as subgrupo, p.proref as referencia, p.proemb as embalagem,m.medsigla as unidade, p.proreal as real, p.profinal as final, p.prorealv as realv, p.profinalv as finalv,x.barunidade as barraunidade ", "produto p left join grupo g on p.grucodigo=g.grucodigo left join fornecedor f on p.forcodigo=f.forcodigo left join medidas m on p.medcodigo=m.medcodigo left join cbarras x on p.procodigo=x.procodigo", "p.procodigo > 0 order by p.procod asc");

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

            echo "<tr>\r\n";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>Código</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>Nome</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>Master</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>Grupo</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>Fornecedor</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>Referência</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>Embalagem</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>Unidade</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>EAN</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>Setor</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>Contagem 1</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>Coletor</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>Contagem 2</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>Coletor</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>Contagem 3</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>Coletor</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C.Real</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C.Fiscal</b></font></td>";
            echo "</tr>\r\n";
        }



        //Verifica a Contagem	
        //Fica em Looping nos Setores
        $sql0 = "SELECT a.setcodigo,a.setor FROM setor a order by a.setcodigo";

        //EXECUTA A QUERY
        $sql0 = pg_query($sql0);

        $row0 = pg_num_rows($sql0);

        if ($row0) {

            for ($j0 = 0; $j0 < $row0; $j0++) {
                $setcodigo = pg_fetch_result($sql0, $j0, "setcodigo");
                $setor = pg_fetch_result($sql0, $j0, "setor");

                //Calcula a quantidade da Primeira contagem 

                $sql2 = "SELECT b.quantidade as estoque,b.colcodigo,c.colnome 
                            FROM inventariocontagemsetorproduto b 
                            LEFT JOIN coletores c on b.colcodigo=c.colcodigo          
                            where b.procodigo = " . $array_produto->procodigo . " and b.invdata = '$invdata' and b.concodigo = $contagem and setcodigo = $setcodigo";

                //EXECUTA A QUERY
                $sql2 = pg_query($sql2);

                $row2 = pg_num_rows($sql2);

                $quantidade1 = 0;

                $arrayColetores = [];

                if ($row2) {

                    for ($j2 = 0; $j2 < $row2; $j2++) {
                        $quantidade1 += pg_fetch_result($sql2, $j2, "estoque");

                        $coletor = (string) trim(pg_fetch_result($sql2, $j2, "colnome"));
                        $quantidade = (int) pg_fetch_result($sql2, $j2, "estoque");

                        //Alimenta um vetor com os Dados dos Coletores
                        $key = array_search($coletor, array_column($arrayColetores, 'coletor'));
                        if (false !== $key) {
                            $aux_qtd = $arrayColetores[$key]['quantidade'];
                            $arrayColetores[$key]['quantidade'] = (int) ($aux_qtd + $quantidade);
                        } else {
                            $arrayColetores[] = ["coletor" => $coletor,
                                "quantidade" => $quantidade];
                        }
                    }
                }

                $detalhe1 = "";

                //Looping no vetor
                foreach ($arrayColetores as $contagemColetor) {
                    if ($detalhe1 == "") {
                        $detalhe1 .= "C" . $contagemColetor['coletor'] . 'Q' . $contagemColetor['quantidade'];
                    } else {
                        $detalhe1 .= "; C" . $contagemColetor['coletor'] . 'Q' . $contagemColetor['quantidade'];
                    }
                }


                //Calcula a quantidade da Segunda contagem 

                $sql2 = "SELECT b.quantidade as estoque,b.colcodigo,c.colnome 
                            FROM inventariocontagemsetorproduto b 
                            LEFT JOIN coletores c on b.colcodigo=c.colcodigo          
                            where b.procodigo = " . $array_produto->procodigo . " and b.invdata = '$invdata' and b.concodigo = $contagem2 and setcodigo = $setcodigo";

                //EXECUTA A QUERY
                $sql2 = pg_query($sql2);

                $row2 = pg_num_rows($sql2);

                $quantidade2 = 0;

                $arrayColetores = [];

                if ($row2) {

                    for ($j2 = 0; $j2 < $row2; $j2++) {
                        $quantidade2 += pg_fetch_result($sql2, $j2, "estoque");

                        $coletor = (string) trim(pg_fetch_result($sql2, $j2, "colnome"));
                        $quantidade = (int) pg_fetch_result($sql2, $j2, "estoque");

                        //Alimenta um vetor com os Dados dos Coletores
                        $key = array_search($coletor, array_column($arrayColetores, 'coletor'));
                        if (false !== $key) {
                            $aux_qtd = $arrayColetores[$key]['quantidade'];
                            $arrayColetores[$key]['quantidade'] = (int) ($aux_qtd + $quantidade);
                        } else {
                            $arrayColetores[] = ["coletor" => $coletor,
                                "quantidade" => $quantidade];
                        }
                    }
                }


                $detalhe2 = "";

                //Looping no vetor
                foreach ($arrayColetores as $contagemColetor) {
                    if ($detalhe2 == "") {
                        $detalhe2 .= "C" . $contagemColetor['coletor'] . 'Q' . $contagemColetor['quantidade'];
                    } else {
                        $detalhe2 .= "; C" . $contagemColetor['coletor'] . 'Q' . $contagemColetor['quantidade'];
                    }
                }

                //Calcula a quantidade da Terceira contagem 

                $sql2 = "SELECT b.quantidade as estoque,b.colcodigo,c.colnome 
                            FROM inventariocontagemsetorproduto b 
                            LEFT JOIN coletores c on b.colcodigo=c.colcodigo          
                            where b.procodigo = " . $array_produto->procodigo . " and b.invdata = '$invdata' and b.concodigo = $contagem3 and setcodigo = $setcodigo";

                //EXECUTA A QUERY
                $sql2 = pg_query($sql2);

                $row2 = pg_num_rows($sql2);

                $quantidade3 = 0;

                $arrayColetores = [];

                if ($row2) {

                    for ($j2 = 0; $j2 < $row2; $j2++) {
                        $quantidade3 += pg_fetch_result($sql2, $j2, "estoque");

                        $coletor = (string) trim(pg_fetch_result($sql2, $j2, "colnome"));
                        $quantidade = (int) pg_fetch_result($sql2, $j2, "estoque");

                        //Alimenta um vetor com os Dados dos Coletores
                        $key = array_search($coletor, array_column($arrayColetores, 'coletor'));
                        if (false !== $key) {
                            $aux_qtd = $arrayColetores[$key]['quantidade'];
                            $arrayColetores[$key]['quantidade'] = (int) ($aux_qtd + $quantidade);
                        } else {
                            $arrayColetores[] = ["coletor" => $coletor,
                                "quantidade" => $quantidade];
                        }
                    }
                }

                $detalhe3 = "";

                //Looping no vetor
                foreach ($arrayColetores as $contagemColetor) {
                    if ($detalhe3 == "") {
                        $detalhe3 .= "C" . $contagemColetor['coletor'] . 'Q' . $contagemColetor['quantidade'];
                    } else {
                        $detalhe3 .= "; C" . $contagemColetor['coletor'] . 'Q' . $contagemColetor['quantidade'];
                    }
                }


                if (($quantidade1 + $quantidade2 + $quantidade3) > 0) {


                    if ($quantidade1 == 0) {
                        $quantidade1 = 'SEM CONTAGEM';
                    }

                    if ($quantidade2 == 0) {
                        $quantidade2 = 'SEM CONTAGEM';
                    }

                    if ($quantidade3 == 0) {
                        $quantidade3 = 'SEM CONTAGEM';
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

                    echo "<tr>\r\n";
                    echo "<td width=\"60\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $array_produto->codigo . "</b></font></td>";
                    echo "<td width=\"500\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $array_produto->nome . "</b></font></td>";
                    echo "<td width=\"60\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $master . "</b></font></td>";
                    echo "<td width=\"200\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $array_produto->grupo . "</b></font></td>";
                    echo "<td width=\"200\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $array_produto->subgrupo . "</b></font></td>";
                    echo "<td width=\"200\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $array_produto->referencia . "</b></font></td>";
                    echo "<td width=\"80\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $array_produto->embalagem . "</b></font></td>";
                    echo "<td width=\"80\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $array_produto->unidade . "</b></font></td>";
                    echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>'" . $array_produto->barraunidade . "'</b></font></td>";
                    echo "<td width=\"80\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $setor . "</b></font></td>";
                    echo "<td width=\"180\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $quantidade1 . "</b></font></td>";
                    echo "<td width=\"160\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $detalhe1 . "</b></font></td>";
                    echo "<td width=\"180\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $quantidade2 . "</b></font></td>";
                    echo "<td width=\"160\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $detalhe2 . "</b></font></td>";
                    echo "<td width=\"180\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $quantidade3 . "</b></font></td>";
                    echo "<td width=\"160\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $detalhe3 . "</b></font></td>";

                    $real = number_format($array_produto->real, 2, ',', '');
                    $final = number_format($array_produto->final, 2, ',', '');

                    echo "<td width=\"80\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $real . "</b></font></td>";
                    echo "<td width=\"80\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $final . "</b></font></td>";
                    echo "</tr>\r\n";
                }
            }
        }
    }
} else {
    echo "<tr>\r\n";
    echo "<td width=\"80\" align=\"center\" colspan=\"18\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>Nenhum registro encontrado...</b></font></td>";
    echo "</tr>\r\n";
}


echo "</table></body></html>\r\n";
pg_close($conn);
exit();
