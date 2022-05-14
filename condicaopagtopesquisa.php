<?php
/**
 * Pesquisa Condicoes de Pagamento do Fornecedor
 *
 * Programa que pesquisa as condicoes de pagamento do fornecedor 
 * na Base de Dados e retorna um XML com descontos, ipi, icms e parcelas
 *
 * @name Pagamento Search
 * @link condicaopagtopesquisa.php
 * @version 50.3.6
 * @since 1.0.0
 * @author Luis Ramires <delta.mais@uol.com.br>
 * @copyright MaxTrade
 * @global integer $_POST['parametro'] Código do Fornecedor 
 */

require('./_app/Config.inc.php');

$parametro = trim($_POST["parametro"]);

$sql = "SELECT a.cpgcodigo,a.forcodigo,a.desc1,a.desc2,a.desc3,a.desc4,a.desc5,a.desc6,a.ipi,a.comissao,
  a.icm,a.tipo,a.parcelas,a.tipoparcelas,a.parcdata1,a.parcdata2,a.parcdata3,a.parcdata4,
  a.parcdata5,a.parcdata6,a.parcdia1,a.parcdia2,a.parcdia3,a.parcdia4,a.parcdia5,a.parcdia6,b.forcod
  FROM condicaopagto a,fornecedor b
  WHERE a.forcodigo = b.forcodigo
  AND b.forcod = '$parametro'";

$read = new Read;
$read->FullRead($sql);

if ($read->getRowCount() >= 1) {

    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $xml .= "<dados>\n";

    foreach ($read->getResult() as $registros) {
        extract($registros);

        if (trim($cpgcodigo) == "") {
            $cpgcodigo = "0";
        }
        if (trim($desc1) == "") {
            $desc1 = "0";
        }
        if (trim($desc2) == "") {
            $desc2 = "0";
        }
        if (trim($desc3) == "") {
            $desc3 = "0";
        }
        if (trim($desc4) == "") {
            $desc4 = "0";
        }
        if (trim($desc5) == "") {
            $desc5 = "0";
        }
        if (trim($desc6) == "") {
            $desc6 = "0";
        }
        if (trim($ipi) == "") {
            $ipi = "0";
        }
        if (trim($comissao) == "") {
            $comissao = "0";
        }
        if (trim($icm) == "") {
            $icm = "0";
        }
        if (trim($tipo) == "") {
            $tipo = "0";
        }
        if (trim($parcelas) == "") {
            $parcelas = "0";
        }
        if (trim($tipoparcelas) == "") {
            $tipoparcelas = "0";
        }
        if (trim($parcdata1) == "") {
            $parcdata1 = "0";
        }
        if (trim($parcdata2) == "") {
            $parcdata2 = "0";
        }
        if (trim($parcdata3) == "") {
            $parcdata3 = "0";
        }
        if (trim($parcdata4) == "") {
            $parcdata4 = "0";
        }
        if (trim($parcdata5) == "") {
            $parcdata5 = "0";
        }
        if (trim($parcdata6) == "") {
            $parcdata6 = "0";
        }
        if (trim($parcdia1) == "") {
            $parcdia1 = "0";
        }
        if (trim($parcdia2) == "") {
            $parcdia2 = "0";
        }
        if (trim($parcdia3) == "") {
            $parcdia3 = "0";
        }
        if (trim($parcdia4) == "") {
            $parcdia4 = "0";
        }
        if (trim($parcdia5) == "") {
            $parcdia5 = "0";
        }
        if (trim($parcdia6) == "") {
            $parcdia6 = "0";
        }

        if ($parcdata1 <> "") {
            $parcdata1 = substr($parcdata1, 8, 2) . '/' . substr($parcdata1, 5, 2) . '/' . substr($parcdata1, 0, 4);
        } else {
            $parcdata1 = '__/__/____';
        }
        if ($parcdata2 <> "") {
            $parcdata2 = substr($parcdata2, 8, 2) . '/' . substr($parcdata2, 5, 2) . '/' . substr($parcdata2, 0, 4);
        } else {
            $parcdata2 = '__/__/____';
        }
        if ($parcdata3 <> "") {
            $parcdata3 = substr($parcdata3, 8, 2) . '/' . substr($parcdata3, 5, 2) . '/' . substr($parcdata3, 0, 4);
        } else {
            $parcdata3 = '__/__/____';
        }
        if ($parcdata4 <> "") {
            $parcdata4 = substr($parcdata4, 8, 2) . '/' . substr($parcdata4, 5, 2) . '/' . substr($parcdata4, 0, 4);
        } else {
            $parcdata4 = '__/__/____';
        }
        if ($parcdata5 <> "") {
            $parcdata5 = substr($parcdata5, 8, 2) . '/' . substr($parcdata5, 5, 2) . '/' . substr($parcdata5, 0, 4);
        } else {
            $parcdata5 = '__/__/____';
        }
        if ($parcdata6 <> "") {
            $parcdata6 = substr($parcdata6, 8, 2) . '/' . substr($parcdata6, 5, 2) . '/' . substr($parcdata6, 0, 4);
        } else {
            $parcdata6 = '__/__/____';
        }

        $xml .= "<dado>\n";
        $xml .= "<cpgcodigo>" . $cpgcodigo . "</cpgcodigo>\n";
        $xml .= "<desc1>" . $desc1 . "</desc1>\n";
        $xml .= "<desc2>" . $desc2 . "</desc2>\n";
        $xml .= "<desc3>" . $desc3 . "</desc3>\n";
        $xml .= "<desc4>" . $desc4 . "</desc4>\n";
        $xml .= "<desc5>" . $desc5 . "</desc5>\n";
        $xml .= "<desc6>" . $desc6 . "</desc6>\n";
        $xml .= "<ipi>" . $ipi . "</ipi>\n";
        $xml .= "<comissao>" . $comissao . "</comissao>\n";
        $xml .= "<icm>" . $icm . "</icm>\n";
        $xml .= "<tipo>" . $tipo . "</tipo>\n";
        $xml .= "<parcelas>" . $parcelas . "</parcelas>\n";
        $xml .= "<tipoparcelas>" . $tipoparcelas . "</tipoparcelas>\n";
        $xml .= "<parcdata1>" . $parcdata1 . "</parcdata1>\n";
        $xml .= "<parcdata2>" . $parcdata2 . "</parcdata2>\n";
        $xml .= "<parcdata3>" . $parcdata3 . "</parcdata3>\n";
        $xml .= "<parcdata4>" . $parcdata4 . "</parcdata4>\n";
        $xml .= "<parcdata5>" . $parcdata5 . "</parcdata5>\n";
        $xml .= "<parcdata6>" . $parcdata6 . "</parcdata6>\n";
        $xml .= "<parcdia1>" . $parcdia1 . "</parcdia1>\n";
        $xml .= "<parcdia2>" . $parcdia2 . "</parcdia2>\n";
        $xml .= "<parcdia3>" . $parcdia3 . "</parcdia3>\n";
        $xml .= "<parcdia4>" . $parcdia4 . "</parcdia4>\n";
        $xml .= "<parcdia5>" . $parcdia5 . "</parcdia5>\n";
        $xml .= "<parcdia6>" . $parcdia6 . "</parcdia6>\n";
        $xml .= "</dado>\n";
    }
    $xml .= "</dados>\n";
    Header("Content-type: application/xml; charset=iso-8859-1");
}
echo $xml;
