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

$query = $cadastro->seleciona("contnome", "contagem", "contcodigo=$contagem3");
$array = pg_fetch_object($query);

$estoque4 = $array->contnome;

$query = $cadastro->seleciona("etqnome", "estoque", "etqcodigo=$estoque");
$array = pg_fetch_object($query);

$estoque3 = $array->etqnome;


echo "<html>\r\n";
echo "<head><title>" . $report_names . "</title><meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel\"></head>\r\n";
echo "<body>\r\n";
echo "<table width='860' border='1' cellspacing='1' cellpadding='1' bordercolor='#999999'><tr>";

//TITULO
echo "<td bgcolor='#CCCCCC' width='860' class='borda' colspan='134' align='center' valign='middle' height='35'><font color='#000000'><b>Relatório Gerencial de Contagem de Estoque</b>";
echo "<br>Data:</b> " . $invdata2 . "</font></td></tr>";


//$query_produto = $cadastro->seleciona("p.procod as codigo,p.procodigo,p.prnome as nome,g.grunome as grupo,f.fornguerra as subgrupo, p.proref as referencia, p.proemb as embalagem,m.medsigla as unidade, p.proreal as real, p.profinal as final, p.prorealv as realv, p.profinalv as finalv","produto p left join grupo g on p.grucodigo=g.grucodigo left join fornecedor f on p.forcodigo=f.forcodigo left join medidas m on p.medcodigo=m.medcodigo","p.procodigo > 0 order by p.procod asc");
$query_produto = $cadastro->seleciona("p.procod as codigo,p.procodigo,p.prnome as nome,g.grunome as grupo,f.fornguerra as subgrupo, p.proref as referencia, p.proemb as embalagem,m.medsigla as unidade, p.proreal as real, p.profinal as final, p.prorealv as realv, p.profinalv as finalv, e.estqtd as quantidade", "produto p left join grupo g on p.grucodigo=g.grucodigo left join fornecedor f on p.forcodigo=f.forcodigo left join medidas m on p.medcodigo=m.medcodigo left join estoqueatual e on p.procodigo=e.procodigo and e.codestoque=$estoque", "p.procodigo > 0 order by p.procod asc");


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
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>Grupo</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>Fornecedor</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>Referência</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>Embalagem</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>Unidade</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>" . $estoque1 . "</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>" . $estoque2 . "</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>" . $estoque4 . "</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>Inventario</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>" . $estoque3 . "</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C.Real</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C.Fiscal</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C1 S01</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C1 Q01</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C1 S02</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C1 Q02</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C1 S03</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C1 Q03</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C1 S04</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C1 Q04</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C1 S05</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C1 Q05</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C1 S06</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C1 Q06</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C1 S07</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C1 Q07</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C1 S08</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C1 Q08</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C1 S09</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C1 Q09</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C1 S10</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C1 Q10</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C1 S11</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C1 Q11</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C1 S12</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C1 Q12</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C1 S13</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C1 Q13</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C1 S14</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C1 Q14</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C1 S15</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C1 Q15</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C1 S16</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C1 Q16</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C1 S17</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C1 Q17</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C1 S18</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C1 Q18</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C1 S19</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C1 Q19</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C1 S20</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C1 Q20</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C2 S01</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C2 Q01</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C2 S02</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C2 Q02</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C2 S03</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C2 Q03</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C2 S04</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C2 Q04</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C2 S05</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C2 Q05</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C2 S06</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C2 Q06</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C2 S07</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C2 Q07</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C2 S08</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C2 Q08</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C2 S09</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C2 Q09</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C2 S10</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C2 Q10</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C2 S11</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C2 Q11</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C2 S12</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C2 Q12</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C2 S13</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C2 Q13</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C2 S14</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C2 Q14</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C2 S15</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C2 Q15</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C2 S16</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C2 Q16</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C2 S17</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C2 Q17</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C2 S18</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C2 Q18</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C2 S19</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C2 Q19</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C2 S20</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C2 Q20</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C3 S01</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C3 Q01</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C3 S02</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C3 Q02</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C3 S03</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C3 Q03</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C3 S04</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C3 Q04</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C3 S05</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C3 Q05</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C3 S06</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C3 Q06</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C3 S07</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C3 Q07</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C3 S08</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C3 Q08</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C3 S09</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C3 Q09</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C3 S10</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C3 Q10</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C3 S11</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C3 Q11</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C3 S12</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C3 Q12</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C3 S13</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C3 Q13</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C3 S14</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C3 Q14</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C3 S15</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C3 Q15</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C3 S16</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C3 Q16</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C3 S17</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C3 Q17</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C3 S18</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C3 Q18</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C3 S19</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C3 Q19</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C3 S20</b></font></td>";
            echo "<td align=\"left\" class='borda' bgcolor='#CCCCCC' bordercolor='#3366CC'><font color='#000000'><b>C3 Q20</b></font></td>";
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
                    //Situacao 2 : Usa a Contagem 2 se nao for branco
                    if ($qtd2 != 'NAO CONTADO') {
                        $saldo = $quantidade2;
                    } else {
                        $saldo = $quantidade;
                    }
                }
            }
            //Sem a Segunda Contagem
            else if ($qtd2 == 'NAO CONTADO') {

                //Situacao 1 : Quantidade 1 = 3 
                if ($quantidade == $quantidade4) {
                    $saldo = $quantidade;
                } else {
                    //Situacao 2 : Usa a Contagem 3 se nao for branco
                    if ($qtd4 != 'NAO CONTADO') {
                        $saldo = $quantidade4;
                    } else {
                        $saldo = $quantidade;
                    }
                }
            }
            //Sem a Primeira Contagem
            else if ($qtd == 'NAO CONTADO') {

                //Situacao 1 : Quantidade 2 = 3 
                if ($quantidade2 == $quantidade4) {
                    $saldo = $quantidade2;
                } else {
                    //Situacao 2 : Usa a Contagem 3 se nao for branco
                    if ($qtd4 != 'NAO CONTADO') {
                        $saldo = $quantidade4;
                    } else {
                        $saldo = $quantidade2;
                    }
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
                    $saldo = $quantidade4;
                }
            }
        } else {
            $saldo = 'NAO CONTADO';
        }



        //Passa a mostrar todos os produtos		
        //if($quantidade<>0 || $quantidade2<>0 || $quantidade3<>0 || $quantidade4<>0){

        echo "<tr>\r\n";
        echo "<td width=\"60\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $array_produto->codigo . "</b></font></td>";
        echo "<td width=\"500\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $array_produto->nome . "</b></font></td>";
        echo "<td width=\"200\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $array_produto->grupo . "</b></font></td>";
        echo "<td width=\"200\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $array_produto->subgrupo . "</b></font></td>";
        echo "<td width=\"200\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $array_produto->referencia . "</b></font></td>";
        echo "<td width=\"80\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $array_produto->embalagem . "</b></font></td>";
        echo "<td width=\"80\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $array_produto->unidade . "</b></font></td>";
        if ($qtd == '') {
            echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $quantidade . "</b></font></td>";
        } else {
            echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $qtd . "</b></font></td>";
        }
        if ($qtd2 == '') {
            echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $quantidade2 . "</b></font></td>";
        } else {
            echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $qtd2 . "</b></font></td>";
        }
        if ($qtd4 == '') {
            echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $quantidade4 . "</b></font></td>";
        } else {
            echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $qtd4 . "</b></font></td>";
        }
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $saldo . "</b></font></td>";
        echo "<td width=\"80\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $quantidade3 . "</b></font></td>";

        if ($estoque == 11) {
            $real = number_format($array_produto->realv, 2, ',', '');
            $final = number_format($array_produto->finalv, 2, ',', '');
        } else {
            $real = number_format($array_produto->real, 2, ',', '');
            $final = number_format($array_produto->final, 2, ',', '');
        }

        echo "<td width=\"80\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $real . "</b></font></td>";
        echo "<td width=\"80\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $final . "</b></font></td>";

        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c1s01 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c1q01 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c1s02 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c1q02 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c1s03 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c1q03 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c1s04 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c1q04 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c1s05 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c1q05 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c1s06 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c1q06 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c1s07 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c1q07 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c1s08 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c1q08 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c1s09 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c1q09 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c1s10 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c1q10 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c1s11 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c1q11 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c1s12 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c1q12 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c1s13 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c1q13 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c1s14 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c1q14 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c1s15 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c1q15 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c1s16 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c1q16 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c1s17 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c1q17 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c1s18 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c1q18 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c1s19 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c1q19 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c1s20 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c1q20 . "</b></font></td>";

        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c2s01 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c2q01 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c2s02 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c2q02 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c2s03 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c2q03 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c2s04 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c2q04 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c2s05 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c2q05 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c2s06 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c2q06 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c2s07 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c2q07 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c2s08 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c2q08 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c2s09 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c2q09 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c2s10 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c2q10 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c2s11 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c2q11 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c2s12 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c2q12 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c2s13 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c2q13 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c2s14 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c2q14 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c2s15 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c2q15 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c2s16 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c2q16 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c2s17 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c2q17 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c2s18 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c2q18 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c2s19 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c2q19 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c2s20 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c2q20 . "</b></font></td>";

        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c3s01 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c3q01 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c3s02 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c3q02 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c3s03 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c3q03 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c3s04 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c3q04 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c3s05 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c3q05 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c3s06 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c3q06 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c3s07 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c3q07 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c3s08 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c3q08 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c3s09 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c3q09 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c3s10 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c3q10 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c3s11 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c3q11 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c3s12 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c3q12 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c3s13 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c3q13 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c3s14 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c3q14 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c3s15 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c3q15 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c3s16 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c3q16 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c3s17 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c3q17 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c3s18 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c3q18 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c3s19 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c3q19 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c3s20 . "</b></font></td>";
        echo "<td width=\"120\" align=\"left\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>" . $c3q20 . "</b></font></td>";

        echo "</tr>\r\n";
        //}	
    }
} else {
    echo "<tr>\r\n";
    echo "<td width=\"80\" align=\"center\" colspan=\"134\" class='borda' bgcolor='#FFFFFF' bordercolor='#3366CC'><font color='#000000'><b>Nenhum registro encontrado...</b></font></td>";
    echo "</tr>\r\n";
}


echo "</table></body></html>\r\n";
pg_close($conn);
exit();
?>