<?php
/**
* Alteracao de Pedidos de Compras
*
* Programa que faz a alteracao dos Pedidos de Compra na Base de Dados e 
* retorna um XML com o número do pedido alterado
*
* @name Compra Update
* @link pedcompraaltera.php
* @version 50.3.6
* @since 1.0.0
* @author Luis Ramires <delta.mais@uol.com.br>
* @copyright MaxTrade
*
* @global integer $_POST["pcnumero"] Numero do Pedido
* @global string $_POST["pcentrega"] Data da Entrega do Pedido
* @global string $_POST["pcemissao"] Data da Emissao do Pedido
* @global string $_POST["pcchegada"] Data da Chegada do Pedido
* @global integer $_POST["codigofornecedor"] Codigo do Fornecedor
* @global string $_POST["comprador"] Nome do Comprador
* @global string $_POST["pcprocesso"] Numero do Processo
* @global string $_POST["pccontainer"] Numero do Container
* @global double $_POST["comissao"] Percentual de Comissao
* @global string $_POST["condicao"] Condicao de Pagamento
* @global string $_POST["observacao1"] Observacao (Linha 1)
* @global string $_POST["observacao2"] Observacao (Linha 2)
* @global string $_POST["observacao3"] Observacao (Linha 3)
* @global string $_POST["observacao4"] Observacao (Linha 4)
* @global string $_POST["observacao5"] Observacao (Linha 5)
* @global double $_POST["percdesc"] Percentual de Desconto
* @global double $_POST["pcdesconto"] Valor do Desconto
* @global integer $_POST["radio"] Tipo de Valor 1 - FOB 2 - CIF
* @global integer $_POST["radioa"] Local 1 Filial, 2 Matriz, 3 CD RE, 4 CD VIX, 5 CD SP, 6 FUN
* @global integer $_POST["radiob"] Tipo de Pedido 1 Compra, 2 Retorno, 3 Bonificacao
* @global double $_POST["total"] Valor Total
* @global integer $_POST["tipoparcelas"] Tipo de Parcelas
* @global integer $_POST["pvparcelas"] Quantidade de Parcelas
* @global double $_POST["ipi"] Valor do IPI
* @global integer $_POST["dia1"] Quantidade de Dias da Parcela 1
* @global integer $_POST["dia2"] Quantidade de Dias da Parcela 2
* @global integer $_POST["dia3"] Quantidade de Dias da Parcela 3
* @global integer $_POST["dia4"] Quantidade de Dias da Parcela 4
* @global integer $_POST["dia5"] Quantidade de Dias da Parcela 5
* @global integer $_POST["dia6"] Quantidade de Dias da Parcela 6
* @global string $_POST["pvdata1"] Vencimento da Parcela 1
* @global string $_POST["pvdata2"] Vencimento da Parcela 2
* @global string $_POST["pvdata3"] Vencimento da Parcela 3
* @global string $_POST["pvdata4"] Vencimento da Parcela 4
* @global string $_POST["pvdata5"] Vencimento da Parcela 5
* @global string $_POST["pvdata6"] Vencimento da Parcela 6
* @global double $_POST["parc1"] Valor da Parcela 1
* @global double $_POST["parc2"] Valor da Parcela 2
* @global double $_POST["parc3"] Valor da Parcela 3
* @global double $_POST["parc4"] Valor da Parcela 4
* @global double $_POST["parc5"] Valor da Parcela 5
* @global double $_POST["parc6"] Valor da Parcela 6
* @global integer $_POST["venda"] Numero do Pedido de Venda
* @global array $_POST["a"] Codigo do Produto
* @global array $_POST["b"] Produto
* @global array $_POST["c"] Quantidade
* @global array $_POST["d"] Custo
* @global array $_POST["e"] Desconto 1
* @global array $_POST["f"] Desconto 2
* @global array $_POST["g"] Desconto 3
* @global array $_POST["h"] Desconto 4
* @global array $_POST["i"] IPI
* @global array $_POST["j"] Data da Entrega
*/

require_once("include/conexao.inc.php");
require_once("include/pedcompra.php");

$pcnumero = trim($_POST["pcnumero"]);
$pcentrega = trim($_POST["pcentrega"]);
$pcemissao = trim($_POST["pcemissao"]);
$pcchegada = trim($_POST["pcchegada"]);

if ($pcentrega <> "") {
    $pcentrega = substr($pcentrega, 6, 4) . '-' . substr($pcentrega, 3, 2) . '-' . substr($pcentrega, 0, 2);
}
if ($pcemissao <> "") {
    $pcemissao = substr($pcemissao, 6, 4) . '-' . substr($pcemissao, 3, 2) . '-' . substr($pcemissao, 0, 2);
}

if ($pcentrega == "") {
    $pcentrega = '2000-01-01';
}
if ($pcemissao == "") {
    $pcemissao = '2000-01-01';
}

if ($pcchegada == "") {
    $pcchegada = "NULL";
} else {
    $pcchegada = substr($pcchegada, 6, 4) . '-' . substr($pcchegada, 3, 2) . '-' . substr($pcchegada, 0, 2);
    $pcchegada = "'$pcchegada'";
}

$codigofornecedor = trim($_POST["codigofornecedor"]);

$comprador = trim($_POST["comprador"]);
$pcprocesso = trim($_POST["pcprocesso"]);
$pccontainer = trim($_POST["pccontainer"]);
$comissao = trim($_POST["comissao"]);
$condicao = trim($_POST["condicao"]);

$observacao1 = trim($_POST["observacao1"]);
$observacao2 = trim($_POST["observacao2"]);
$observacao3 = trim($_POST["observacao3"]);

$observacao4 = trim($_POST["observacao4"]);
$observacao5 = trim($_POST["observacao5"]);

$percdesc = trim($_POST["percdesc"]);
$pcdesconto = trim($_POST["pcdesconto"]);

$radio = trim($_POST["radio"]);
$radioa = trim($_POST["radioa"]);

$radiob = trim($_POST["radiob"]);

$total = trim($_POST["total"]);

$tipoparcelas = trim($_POST["tipoparcelas"]);

$parcelas = trim($_POST["pvparcelas"]);

$ipi = trim($_POST["ipi"]);

$parcdia1 = trim($_POST["dia1"]);
$parcdia2 = trim($_POST["dia2"]);
$parcdia3 = trim($_POST["dia3"]);
$parcdia4 = trim($_POST["dia4"]);
$parcdia5 = trim($_POST["dia5"]);
$parcdia6 = trim($_POST["dia6"]);

$parcdata1 = trim($_POST["pvdata1"]);
$parcdata2 = trim($_POST["pvdata2"]);
$parcdata3 = trim($_POST["pvdata3"]);
$parcdata4 = trim($_POST["pvdata4"]);
$parcdata5 = trim($_POST["pvdata5"]);
$parcdata6 = trim($_POST["pvdata6"]);

if ($parcdata1 <> "") {
    $parcdata1 = substr($parcdata1, 6, 4) . '-' . substr($parcdata1, 3, 2) . '-' . substr($parcdata1, 0, 2);
}
if ($parcdata2 <> "") {
    $parcdata2 = substr($parcdata2, 6, 4) . '-' . substr($parcdata2, 3, 2) . '-' . substr($parcdata2, 0, 2);
}
if ($parcdata3 <> "") {
    $parcdata3 = substr($parcdata3, 6, 4) . '-' . substr($parcdata3, 3, 2) . '-' . substr($parcdata3, 0, 2);
}
if ($parcdata4 <> "") {
    $parcdata4 = substr($parcdata4, 6, 4) . '-' . substr($parcdata4, 3, 2) . '-' . substr($parcdata4, 0, 2);
}
if ($parcdata5 <> "") {
    $parcdata5 = substr($parcdata5, 6, 4) . '-' . substr($parcdata5, 3, 2) . '-' . substr($parcdata5, 0, 2);
}
if ($parcdata6 <> "") {
    $parcdata6 = substr($parcdata6, 6, 4) . '-' . substr($parcdata6, 3, 2) . '-' . substr($parcdata6, 0, 2);
}

if ($parcdata1 == "") {
    $parcdata1 = '2000-01-01';
}
if ($parcdata2 == "") {
    $parcdata2 = '2000-01-01';
}
if ($parcdata3 == "") {
    $parcdata3 = '2000-01-01';
}
if ($parcdata4 == "") {
    $parcdata4 = '2000-01-01';
}
if ($parcdata5 == "") {
    $parcdata5 = '2000-01-01';
}
if ($parcdata6 == "") {
    $parcdata6 = '2000-01-01';
}

$parcela1 = trim($_POST["parc1"]);
$parcela2 = trim($_POST["parc2"]);
$parcela3 = trim($_POST["parc3"]);
$parcela4 = trim($_POST["parc4"]);
$parcela5 = trim($_POST["parc5"]);
$parcela6 = trim($_POST["parc6"]);

$pvnumero = trim($_POST["venda"]);

$ipi = trim($_POST["ipi"]);

if ($parcelas == "") {
    $parcelas = 0;
}

if ($parcela1 == "") {
    $parcela1 = 0;
}
if ($parcela2 == "") {
    $parcela2 = 0;
}
if ($parcela3 == "") {
    $parcela3 = 0;
}
if ($parcela4 == "") {
    $parcela4 = 0;
}
if ($parcela5 == "") {
    $parcela5 = 0;
}
if ($parcela6 == "") {
    $parcela6 = 0;
}

if ($parcdia1 == "") {
    $parcdia1 = 0;
}
if ($parcdia2 == "") {
    $parcdia2 = 0;
}
if ($parcdia3 == "") {
    $parcdia3 = 0;
}
if ($parcdia4 == "") {
    $parcdia4 = 0;
}
if ($parcdia5 == "") {
    $parcdia5 = 0;
}
if ($parcdia6 == "") {
    $parcdia6 = 0;
}

if ($pvnumero == "") {
    $pvnumero = 0;
}

if ($pccontainer == '') {
    $pccontainer = 0;
}

if (isset($_POST["a"])) {
    $campo1 = $_POST["a"];
    $campo2 = $_POST["b"];
    $campo3 = $_POST["c"];
    $campo4 = $_POST["d"];
    $campo5 = $_POST["e"];
    $campo6 = $_POST["f"];
    $campo7 = $_POST["g"];
    $campo8 = $_POST["h"];
    $campo9 = $_POST["i"];
    $campo10 = $_POST["j"];
} else {
    $campo1 = [];
    $campo2 = [];
    $campo3 = [];
    $campo4 = [];
    $campo5 = [];
    $campo6 = [];
    $campo7 = [];
    $campo8 = [];
    $campo9 = [];
    $campo10 = [];
}

$cadastro = new banco($conn, $db);

//Verifica a serie 
$sqlser = "Select serie from pcompra
Where pcnumero = '$pcnumero' 
";

$sqlser = pg_query($sqlser);
$rowser = pg_num_rows($sqlser);

$serie = 0;
if ($rowser) {
    $serie = pg_fetch_result($sqlser, 0, "serie");
    if ($serie == '') {
        $serie = 0;
    }
}
$serie = $serie + 1;

$cadastro->altera("pcompra", "pcentrega='$pcentrega',pcemissao='$pcemissao',pcchegada=$pcchegada,forcodigo='$codigofornecedor'
,comprador='$comprador',pcprocesso='$pcprocesso',comissao='$comissao',condicao='$condicao',observacao1='$observacao1'
,observacao2='$observacao2',observacao3='$observacao3'
,observacao4='$observacao4'
,observacao5='$observacao5'
,perdesconto='$percdesc',desconto='$pcdesconto'
,tipo='$radio',localentrega='$radioa',tipoped='$radiob',total='$total',

tipoparcelas='$tipoparcelas',
parcelas='$parcelas',
parcdia1='$parcdia1',
parcdia2='$parcdia2',
parcdia3='$parcdia3',
parcdia4='$parcdia4',
parcdia5='$parcdia5',
parcdia6='$parcdia6',
parcdata1='$parcdata1',
parcdata2='$parcdata2',
parcdata3='$parcdata3',
parcdata4='$parcdata4',
parcdata5='$parcdata5',
parcdata6='$parcdata6',
parcela1='$parcela1',
parcela2='$parcela2',
parcela3='$parcela3',
parcela4='$parcela4',
parcela5='$parcela5',
parcela6='$parcela6',

pvnumero='$pvnumero',
serie='$serie',
ipi='$ipi',
pccontainers='$pccontainer'

", "$pcnumero");



//rotina para apagar os itens se necessario
$sqlb = "Select a.procod,b.pcicodigo from pcitem b, produto a
Where b.pcnumero = '$pcnumero' 
and a.procodigo = b.procodigo
order by a.procod
";

$sqlb = pg_query($sqlb);
$rowb = pg_num_rows($sqlb);

if ($rowb) {
    for ($ib = 0; $ib < $rowb; $ib++) {
        $apagar = 1;
        $procodb = pg_fetch_result($sqlb, $ib, "procod");
        $pcicodigo = pg_fetch_result($sqlb, $ib, "pcicodigo");



        if (sizeof($campo1) > 0) {
            for ($i = 0; $i < sizeof($campo1); $i++) {
                if (trim($campo1[$i]) != '0') {
                    $procod = $campo1[$i];

                    if (trim($procod) == trim($procodb)) {
                        $apagar = 0;
                    }
                }
            }
        }

        if ($apagar == 1) {
            $sql = "Delete from pcitem
			Where pcicodigo = '$pcicodigo'";
            pg_query($sql);
        }
    }
}

if (sizeof($campo1) > 0) {
    for ($i = 0; $i < sizeof($campo1); $i++) {

        if (trim($campo1[$i]) != '0') {

            $procod = $campo1[$i];
            $produto = $campo2[$i];
            $quantidade = $campo3[$i];
            $custo = $campo4[$i];
            $desc1 = $campo5[$i];
            $desc2 = $campo6[$i];
            $desc3 = $campo7[$i];
            $desc4 = $campo8[$i];
            $ipi = $campo9[$i];
            $entrega = $campo10[$i];

            $entrega = substr($entrega, 6, 4) . '-' . substr($entrega, 3, 2) . '-' . substr($entrega, 0, 2);


            $sql = "Select procodigo from produto Where procod = '$procod'";
            $sql = pg_query($sql);
            $row = pg_num_rows($sql);
            if ($row) {

                $procodigo = pg_fetch_result($sql, 0, "procodigo");


                $sqlb = "Select pcicodigo,pcibaixa from pcitem
				Where pcnumero = '$pcnumero' 
				and procodigo = '$procodigo' 
				";
                $sqlb = pg_query($sqlb);
                $rowb = pg_num_rows($sqlb);
                if ($rowb) {

                    $pcicodigo = pg_fetch_result($sqlb, 0, "pcicodigo");
                    $pcibaixa = pg_fetch_result($sqlb, 0, "pcibaixa");

                    $quantidade = $quantidade + $pcibaixa;

                    $cadastro->altera2("pcitem", "pcnumero='$pcnumero',procodigo='$procodigo',
					pcisaldo='$quantidade',pcipreco='$custo',desc1='$desc1',desc2='$desc2',desc3='$desc3',
					desc4=$desc4,ipi=$ipi,pcentrega='$entrega'
					", "'$pcicodigo'");
                } else {

                    $sqlc = "Select count(pcicodigo) as total from pcitem
					Where pcnumero = '$pcnumero' 
					";
                    $sqlc = pg_query($sqlc);
                    $rowc = pg_num_rows($sqlc);
                    if ($rowc) {
                        $tot = pg_fetch_result($sqlc, 0, "total");
                        $tot++;
                    } else {
                        $tot = 1;
                    }


                    $cadastro->insere("pcitem", "(pcnumero,pcitem,procodigo,pcisaldo,pcipreco,desc1,desc2,desc3,desc4,ipi,pcentrega
					)", "('$pcnumero','$tot','$procodigo','$quantidade','$custo','$desc1','$desc2','$desc3',$desc4,$ipi,'$entrega'
					)");
                }
            }
        }
    }
}


$forcod = 0;
$sql = "Select forcod from fornecedor Where forcodigo = '$codigofornecedor'";
$sql = pg_query($sql);
$row = pg_num_rows($sql);
if ($row) {
    $forcod = pg_fetch_result($sql, 0, "forcod");
}

for ($j = 0; $j <= 3000; $j++) {
    $vetorpro[$j] = '';
}
$ivetpro = 0;

pg_close($conn);

$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
$xml .= "<dados>\n";
$xml .= "<dado>\n";
$xml .= "<pedido>" . $pcnumero . "</pedido>\n";
$xml .= "</dado>\n";
$xml .= "</dados>\n";
Header("Content-type: application/xml; charset=iso-8859-1");

//PRINTA O RESULTADO
echo $xml;
