<?php

require_once("include/conexao.inc.php");
require_once("include/gerencial.php");

$cadastro = new banco($conn, $db);

$invdata = trim($_GET["invdata"]);
$contagem = trim($_GET["contagem"]);
$contagem2 = trim($_GET["contagem2"]);

$invdata2 = $invdata;

$aux = explode("/", $invdata);
$invdata = $aux[2] . '-' . $aux[1] . '-' . $aux[0] . ' 00:00:00-03';

header("Content-type: " . "application/vnd.ms-excel");
header("Content-disposition: attachment; filename=relatoriocontagem.xls");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");


$query = $cadastro->seleciona("contnome", "contagem", "contcodigo=$contagem");
$array = pg_fetch_object($query);

$estoque1 = $array->contnome;

$query = $cadastro->seleciona("contnome", "contagem", "contcodigo=$contagem2");
$array = pg_fetch_object($query);

$estoque2 = $array->contnome;

echo "<html>\r\n";
echo "<head><title>" . $report_names . "</title><meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel\"></head>\r\n";
echo "<body>\r\n";
echo "<table width='780' border='1' cellspacing='1' cellpadding='1' bordercolor='#999999'><tr>";

//TITULO
echo "<td bgcolor='#CCCCCC' width='780' class='borda' colspan='13' align='center' valign='middle' height='35'><font color='#000000'><b>Relat�rio Gerencial de Contagem de Estoque</b>";
echo "<br>Data:</b> " . $invdata2 . "</font></td></tr>";


$query_produto = $cadastro->seleciona("p.procod as codigo,p.procodigo,p.prnome as nome,g.grunome as grupo,f.fornguerra as subgrupo, p.proref as referencia, p.proemb as embalagem,m.medsigla as unidade, p.proreal as real, p.profinal as final, p.prorealv as realv, p.profinalv as finalv", "produto p left join grupo g on p.grucodigo=g.grucodigo left join fornecedor f on p.forcodigo=f.forcodigo left join medidas m on p.medcodigo=m.medcodigo", "p.procodigo > 0 order by p.procod asc");

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
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C�digo</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>Nome</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>Grupo</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>Fornecedor</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>Refer�ncia</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>Embalagem</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>Unidade</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>Setor</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>" . $estoque1 . "</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>" . $estoque2 . "</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>Diferen�a</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C.Real</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C.Fiscal</b></font></td>";
            echo "</tr>\r\n";
        }

        /*
          if($array_produto->codigo=='6551-8' ||
          $array_produto->codigo=='7089-5' ||
          $array_produto->codigo=='7273-9' ||
          $array_produto->codigo=='7274-9' ||
          $array_produto->codigo=='7349-1' ||
          $array_produto->codigo=='7350-5' ||
          $array_produto->codigo=='7433-1' ||
          $array_produto->codigo=='7492-2' ||
          $array_produto->codigo=='7532-0' ||

          $array_produto->codigo=='7216-2' ||
          $array_produto->codigo=='7532-0' ||
          $array_produto->codigo=='7532-0' ||
         */


        $sql2 = "
			SELECT a.setor,b.quantidade as estoque,b.setcodigo  
			FROM setor a,inventariocontagemsetorproduto b where a.setcodigo = b.setcodigo and b.procodigo = " . $array_produto->procodigo . " and b.invdata = '$invdata' and b.concodigo = $contagem order by a.setcodigo";

        //EXECUTA A QUERY
        $sql2 = pg_query($sql2);

        $row2 = pg_num_rows($sql2);

        $quantidade = 0;

        if ($row2) {

            for ($j2 = 0; $j2 < $row2; $j2++) {
                $setor = pg_fetch_result($sql2, $j2, "setor");
                $quantidade = pg_fetch_result($sql2, $j2, "estoque");
                $setcodigo = pg_fetch_result($sql2, $j2, "setcodigo");

                if ($quantidade == '') {
                    $quantidade = 0;
                }


                //Verifica a Contagem 2			
                $sql3 = "
					SELECT quantidade as estoque 
					FROM inventariocontagemsetorproduto where procodigo = " . $array_produto->procodigo . " and invdata = '$invdata' and concodigo = $contagem2 and setcodigo=$setcodigo";

                //EXECUTA A QUERY
                $sql3 = pg_query($sql3);

                $row3 = pg_num_rows($sql3);

                $quantidade2 = 0;

                if ($row3) {
                    $quantidade2 = pg_fetch_result($sql3, 0, "estoque");
                }

                if ($quantidade2 == '') {
                    $quantidade2 = 0;
                }

                $diferenca = ($quantidade - $quantidade2);


                if ($quantidade > 0 || $quantidade2 > 0) {

                    echo "<tr>\r\n";
                    echo "<td width=\"60\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $array_produto->codigo . "</b></font></td>";
                    echo "<td width=\"500\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $array_produto->nome . "</b></font></td>";
                    echo "<td width=\"200\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $array_produto->grupo . "</b></font></td>";
                    echo "<td width=\"200\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $array_produto->subgrupo . "</b></font></td>";
                    echo "<td width=\"200\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $array_produto->referencia . "</b></font></td>";
                    echo "<td width=\"80\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $array_produto->embalagem . "</b></font></td>";
                    echo "<td width=\"80\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $array_produto->unidade . "</b></font></td>";
                    echo "<td width=\"80\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $setor . "</b></font></td>";
                    echo "<td width=\"80\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $quantidade . "</b></font></td>";
                    echo "<td width=\"80\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $quantidade2 . "</b></font></td>";
                    echo "<td width=\"80\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $diferenca . "</b></font></td>";

                    /*
                      if($estoque==11){
                      $real = number_format($array_produto->realv,2,',','');
                      $final = number_format($array_produto->finalv,2,',','');
                      }
                      else {
                      $real = number_format($array_produto->real,2,',','');
                      $final = number_format($array_produto->final,2,',','');
                      }
                     */

                    $real = number_format($array_produto->real, 2, ',', '');
                    $final = number_format($array_produto->final, 2, ',', '');

                    echo "<td width=\"80\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $real . "</b></font></td>";
                    echo "<td width=\"80\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $final . "</b></font></td>";
                    echo "</tr>\r\n";
                }
            }
        }


        $sql2 = "
			SELECT a.setor,b.quantidade as estoque,b.setcodigo  
			FROM setor a,inventariocontagemsetorproduto b where a.setcodigo = b.setcodigo and b.procodigo = " . $array_produto->procodigo . " and b.invdata = '$invdata' and b.concodigo = $contagem2 order by a.setcodigo";

        //EXECUTA A QUERY
        $sql2 = pg_query($sql2);

        $row2 = pg_num_rows($sql2);

        $quantidade2 = 0;

        if ($row2) {

            for ($j2 = 0; $j2 < $row2; $j2++) {
                $setor = pg_fetch_result($sql2, $j2, "setor");
                $quantidade2 = pg_fetch_result($sql2, $j2, "estoque");
                $setcodigo = pg_fetch_result($sql2, $j2, "setcodigo");

                if ($quantidade2 == '') {
                    $quantidade2 = 0;
                }


                //Verifica a Contagem 1			
                $sql3 = "
					SELECT quantidade as estoque 
					FROM inventariocontagemsetorproduto where procodigo = " . $array_produto->procodigo . " and invdata = '$invdata' and concodigo = $contagem and setcodigo=$setcodigo";

                //EXECUTA A QUERY
                $sql3 = pg_query($sql3);

                $row3 = pg_num_rows($sql3);

                $quantidade = 0;

                if ($row3) {
                    $quantidade = pg_fetch_result($sql3, 0, "estoque");
                } else {

                    if ($quantidade == '') {
                        $quantidade = 0;
                    }

                    $diferenca = ($quantidade - $quantidade2);


                    if ($quantidade > 0 || $quantidade2 > 0) {

                        echo "<tr>\r\n";
                        echo "<td width=\"60\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $array_produto->codigo . "</b></font></td>";
                        echo "<td width=\"500\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $array_produto->nome . "</b></font></td>";
                        echo "<td width=\"200\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $array_produto->grupo . "</b></font></td>";
                        echo "<td width=\"200\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $array_produto->subgrupo . "</b></font></td>";
                        echo "<td width=\"200\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $array_produto->referencia . "</b></font></td>";
                        echo "<td width=\"80\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $array_produto->embalagem . "</b></font></td>";
                        echo "<td width=\"80\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $array_produto->unidade . "</b></font></td>";
                        echo "<td width=\"80\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $setor . "</b></font></td>";
                        echo "<td width=\"80\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $quantidade . "</b></font></td>";
                        echo "<td width=\"80\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $quantidade2 . "</b></font></td>";
                        echo "<td width=\"80\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $diferenca . "</b></font></td>";

                        /*
                          if($estoque==11){
                          $real = number_format($array_produto->realv,2,',','');
                          $final = number_format($array_produto->finalv,2,',','');
                          }
                          else {
                          $real = number_format($array_produto->real,2,',','');
                          $final = number_format($array_produto->final,2,',','');
                          }
                         */

                        $real = number_format($array_produto->real, 2, ',', '');
                        $final = number_format($array_produto->final, 2, ',', '');

                        echo "<td width=\"80\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $real . "</b></font></td>";
                        echo "<td width=\"80\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $final . "</b></font></td>";
                        echo "</tr>\r\n";
                    }
                }
            }
        }
    }
} else {
    echo "<tr>\r\n";
    echo "<td width=\"80\" align=\"center\" colspan=\"12\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>Nenhum registro encontrado...</b></font></td>";
    echo "</tr>\r\n";
}


echo "</table></body></html>\r\n";
pg_close($conn);
exit();
?>