<?php

require_once("include/conexao.inc.php");
require_once("include/aberturainventario.php");

set_time_limit(0);

$cadastro = new banco($conn, $db);
$invdata = trim($_GET["invdata"]);
$contagem = trim($_GET["contagem"]);
$coletor = trim($_GET["coletor"]);
$estoque = trim($_GET["estoque"]);
$setor = trim($_GET["setor"]);

$aux = explode("/", $invdata);
$invdata = $aux[2] . '-' . $aux[1] . '-' . $aux[0] . ' 00:00:00-03';

$query_produto = $cadastro->seleciona("p.procod as codigo,p.procodigo,p.prnome as nome,g.grunome as grupo,f.fornguerra as subgrupo, p.proref as referencia, p.proemb as embalagem,m.medsigla as unidade, p.proreal as real, p.profinal as final, p.prorealv as realv, p.profinalv as finalv, e.estqtd as quantidade", "produto p left join grupo g on p.grucodigo=g.grucodigo left join fornecedor f on p.forcodigo=f.forcodigo left join medidas m on p.medcodigo=m.medcodigo left join estoqueatual e on p.procodigo=e.procodigo and e.codestoque=$estoque", "p.procodigo > 0 order by p.procod asc");

$row = pg_num_rows($query_produto);
if ($row > 0) {

    for ($j = 0; $j < $row; $j++) {
        $total = 0;
        $aux = 0;
        $array_produto = pg_fetch_object($query_produto);

        $quantidade3 = $array_produto->quantidade;

        if ($quantidade3 <> 0) {

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

            if ($quantidade == '') {

                //Cria o Registro Zerado
                $procodigo = $array_produto->procodigo;
                $pvcconfere = 0;

                $cadastro->insere("inventariocontagemsetorproduto", "(procodigo,invdata,concodigo,setcodigo,quantidade,colcodigo)", "('$procodigo','$invdata','$contagem','$setor','$pvcconfere','$coletor')");


                $quantidade = 0;
            } else {
                $qtd = '';
            }
        }
    }
}

$status = 0;

header("Content-type: application/xml");
$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";


$xml = "<dadosinv>
<registroinv>
<iteminv>";

$xml .= $status;

$xml .= "</iteminv>
</registroinv>
</dadosinv>";

echo $xml;

pg_close($conn);
exit();
?>