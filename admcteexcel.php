<?php

require_once("include/conexao.inc.php");

$auxdatainicio = $_GET['dataInicio'];
$auxdatafim = $_GET['dataFim'];
$usuario = $_GET['usuario'];
$npedido = $_GET['npedido'];
if ($npedido == '') {
    $npedido = '0';
}
$cancelados = $_GET["cancelados"];

$dti = explode(" ", $auxdatainicio);
$dti = explode("-", $dti[0]);
$dti = $dti[2] . '/' . $dti[1] . '/' . $dti[0];

$dtf = explode(" ", $auxdatafim);
$dtf = explode("-", $dtf[0]);
$dtf = $dtf[2] . '/' . $dtf[1] . '/' . $dtf[0];

header("Content-type: " . "application/vnd.ms-excel");
header("Content-disposition: attachment; filename=admcte.xls");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

$report_names = "Listagem";

echo "<html>\r\n";
echo "<head><title>" . $report_names . "</title><meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel\"></head>\r\n";
echo "<body>\r\n";

echo "<table border='1' cellspacing='1' cellpadding='1' bordercolor='#999999'><tr>";
echo "<td bgcolor='#CCCCCC' class='borda' colspan='31' align='center' valign='middle'><font color='#000000'><b>Gerenciamento de CTe</b>";
echo "<br><b>Referência:</b> " . $dti . " a " . $dtf . " <b></font></td></tr>";

echo "<tr>\r\n";

echo "<td width='70' class='borda' bgcolor='#3366CC' bordercolor='#3366CC' align='center'><font color='#ffffff'><b>SEQ.</b></font></td>";
echo "<td width='70' class='borda' bgcolor='#3366CC' bordercolor='#3366CC' align='center'><font color='#ffffff'><b>No.</b></font></td>";
echo "<td width='70' class='borda' bgcolor='#3366CC' bordercolor='#3366CC' align='center'><font color='#ffffff'><b>SERIE</b></font></td>";
echo "<td width='80' class='borda' bgcolor='#3366CC' bordercolor='#3366CC' align='center'><font color='#ffffff'><b>NUMERO</b></font></td>";
echo "<td width='100' class='borda' bgcolor='#3366CC' bordercolor='#3366CC' align='center'><font color='#ffffff'><b>EMISSÃO</b></font></td>";
echo "<td width='70' class='borda' bgcolor='#3366CC' bordercolor='#3366CC' align='center'><font color='#ffffff'><b>HORA</b></font></td>";

echo "<td width='250' class='borda' bgcolor='#3366CC' bordercolor='#3366CC' align='center'><font color='#ffffff'><b>NFe</b></font></td>";

echo "<td width='180' class='borda' bgcolor='#3366CC' bordercolor='#3366CC' align='center'><font color='#ffffff'><b>PROTOCOLO</b></font></td>";
echo "<td width='300' class='borda' bgcolor='#3366CC' bordercolor='#3366CC' align='center'><font color='#ffffff'><b>SEFAZ</b></font></td>";

echo "<td width='70' class='borda' bgcolor='#3366CC' bordercolor='#3366CC' align='center'><font color='#ffffff'><b>CFOP</b></font></td>";
echo "<td width='130' class='borda' bgcolor='#3366CC' bordercolor='#3366CC' align='center'><font color='#ffffff'><b>MODAL</b></font></td>";
echo "<td width='150' class='borda' bgcolor='#3366CC' bordercolor='#3366CC' align='center'><font color='#ffffff'><b>SERVICO</b></font></td>";
echo "<td width='250' class='borda' bgcolor='#3366CC' bordercolor='#3366CC' align='center'><font color='#ffffff'><b>FINALIDADE</b></font></td>";
echo "<td width='200' class='borda' bgcolor='#3366CC' bordercolor='#3366CC' align='center'><font color='#ffffff'><b>LOCAL</b></font></td>";
echo "<td width='200' class='borda' bgcolor='#3366CC' bordercolor='#3366CC' align='center'><font color='#ffffff'><b>INICIO</b></font></td>";
echo "<td width='250' class='borda' bgcolor='#3366CC' bordercolor='#3366CC' align='center'><font color='#ffffff'><b>TERMINO</b></font></td>";
echo "<td width='300' class='borda' bgcolor='#3366CC' bordercolor='#3366CC' align='center'><font color='#ffffff'><b>EMITENTE</b></font></td>";
echo "<td width='200' class='borda' bgcolor='#3366CC' bordercolor='#3366CC' align='center'><font color='#ffffff'><b>TOMADOR</b></font></td>";
echo "<td width='300' class='borda' bgcolor='#3366CC' bordercolor='#3366CC' align='center'><font color='#ffffff'><b>REMETENTE</b></font></td>";
echo "<td width='200' class='borda' bgcolor='#3366CC' bordercolor='#3366CC' align='center'><font color='#ffffff'><b>EXPEDIDOR</b></font></td>";
echo "<td width='350' class='borda' bgcolor='#3366CC' bordercolor='#3366CC' align='center'><font color='#ffffff'><b>RECEBEDOR</b></font></td>";
echo "<td width='450' class='borda' bgcolor='#3366CC' bordercolor='#3366CC' align='center'><font color='#ffffff'><b>DESTINATARIO</b></font></td>";
echo "<td width='100' class='borda' bgcolor='#3366CC' bordercolor='#3366CC' align='center'><font color='#ffffff'><b>SERVICOS</b></font></td>";
echo "<td width='100' class='borda' bgcolor='#3366CC' bordercolor='#3366CC' align='center'><font color='#ffffff'><b>A RECEBER</b></font></td>";
echo "<td width='100' class='borda' bgcolor='#3366CC' bordercolor='#3366CC' align='center'><font color='#ffffff'><b>TRIBUTOS</b></font></td>";
echo "<td width='150' class='borda' bgcolor='#3366CC' bordercolor='#3366CC' align='center'><font color='#ffffff'><b>PRODUTO</b></font></td>";
echo "<td width='100' class='borda' bgcolor='#3366CC' bordercolor='#3366CC' align='center'><font color='#ffffff'><b>VALOR</b></font></td>";

echo "<td width='150' class='borda' bgcolor='#3366CC' bordercolor='#3366CC' align='center'><font color='#ffffff'><b>CANCELAMENTO</b></font></td>";

echo "<td width='150' class='borda' bgcolor='#3366CC' bordercolor='#3366CC' align='center'><font color='#ffffff'><b>INUTILIZACAO</b></font></td>";
echo "<td width='200' class='borda' bgcolor='#3366CC' bordercolor='#3366CC' align='center'><font color='#ffffff'><b>MOTORISTA</b></font></td>";
echo "<td width='1600' class='borda' bgcolor='#3366CC' bordercolor='#3366CC' align='center'><font color='#ffffff'><b>OBSERVACAO</b></font></td>";
echo "</tr>\r\n";

//Pesquisa por Datas	
if ($npedido == '0') {

    $sql = "Select cte.ctenumero, 
	cte.cteserie, 
	cte.ctenum, 
	cte.cteemissao, 
	cte.ctehorario,
	cte.ctecfop,
	tipomodal.tmonome,
	tiposervico.sernome, 
	tipocte.tctnome,
	cte.cteufemissao,
	cidades1.descricao as cidemissao,	
	cte.cteufinicio,
	cidades2.descricao as cidinicio,
	cte.cteuffinal,
	cidades3.descricao as cidfinal,
	cte.cteemirazao,
	tipotomador.tomnome,
	cte.ctetomrazao, 	
	tiporemetente.remnome,
	cte.cteremrazao,
	tipoexpedidor.expnome,
	cte.cteexprazao,
	tiporecebedor.recnome,
	cte.cterecrazao,
	tipodestinatario.desnome,
	cte.ctedesrazao, 
	cte.cteservicos, 
	cte.ctereceber, 
	cte.ctetributos, 
	cte.ctecargaval, 
	cte.ctepropredominante, 
	cte.cteobsgeral, 
	cte.ctecancdata, 
	cte.ctedatainutiliza,
	cte.ctenprot,
	cte.ctemotivo,
	cte.ctechave	 	 	
	FROM cte 
	left join tipomodal on cte.tmocodigo = tipomodal.tmocodigo	
	left join tiposervico on cte.sercodigo = tiposervico.sercodigo	
	left join tipocte on cte.tctcodigo = tipocte.tctcodigo	
	left join cidadesibge cidades1 on cte.ctecidemissao = cidades1.id 
	left join cidadesibge cidades2 on cte.ctecidinicio = cidades2.id 
	left join cidadesibge cidades3 on cte.ctecidfinal = cidades3.id 
	left join tipotomador on cte.tomcodigo = tipotomador.tomcodigo	
	left join tiporemetente on cte.remcodigo = tiporemetente.remcodigo	
	left join tipoexpedidor on cte.expcodigo = tipoexpedidor.expcodigo	
	left join tiporecebedor on cte.reccodigo = tiporecebedor.reccodigo	
	left join tipodestinatario on cte.descodigo = tipodestinatario.descodigo	
	where (cte.cteemissao between '$auxdatainicio' and '$auxdatafim')
	order by cte.cteemissao,cte.ctenumero asc";
} else {

    $sql = "Select cte.ctenumero, 
	cte.cteserie, 
	cte.ctenum, 
	cte.cteemissao, 
	cte.ctehorario,
	cte.ctecfop,
	tipomodal.tmonome,
	tiposervico.sernome, 
	tipocte.tctnome,
	cte.cteufemissao,
	cidades1.descricao as cidemissao,	
	cte.cteufinicio,
	cidades2.descricao as cidinicio,
	cte.cteuffinal,
	cidades3.descricao as cidfinal,
	cte.cteemirazao,
	tipotomador.tomnome,
	cte.ctetomrazao, 	
	tiporemetente.remnome,
	cte.cteremrazao,
	tipoexpedidor.expnome,
	cte.cteexprazao,
	tiporecebedor.recnome,
	cte.cterecrazao,
	tipodestinatario.desnome,
	cte.ctedesrazao, 
	cte.cteservicos, 
	cte.ctereceber, 
	cte.ctetributos, 
	cte.ctecargaval, 
	cte.ctepropredominante, 
	cte.cteobsgeral, 
	cte.ctecancdata, 
	cte.ctedatainutiliza,
	cte.ctenprot,
	cte.ctemotivo,
	cte.ctechave	 	 	
	FROM cte 
	left join tipomodal on cte.tmocodigo = tipomodal.tmocodigo	
	left join tiposervico on cte.sercodigo = tiposervico.sercodigo	
	left join tipocte on cte.tctcodigo = tipocte.tctcodigo	
	left join cidadesibge cidades1 on cte.ctecidemissao = cidades1.id 
	left join cidadesibge cidades2 on cte.ctecidinicio = cidades2.id 
	left join cidadesibge cidades3 on cte.ctecidfinal = cidades3.id 
	left join tipotomador on cte.tomcodigo = tipotomador.tomcodigo	
	left join tiporemetente on cte.remcodigo = tiporemetente.remcodigo	
	left join tipoexpedidor on cte.expcodigo = tipoexpedidor.expcodigo	
	left join tiporecebedor on cte.reccodigo = tiporecebedor.reccodigo	
	left join tipodestinatario on cte.descodigo = tipodestinatario.descodigo	
	where cte.ctenumero = '$npedido' ";
}

$cad = pg_query($sql);

$row = pg_num_rows($cad);


$k;


if ($row > 0) {

    for ($i = 0; $i < $row; $i++) {

        $cadastro = '';
        $ctenumero = pg_fetch_result($cad, $i, "ctenumero");
        $cteserie = pg_fetch_result($cad, $i, "cteserie");
        $ctenum = pg_fetch_result($cad, $i, "ctenum");
        $emissao = pg_fetch_result($cad, $i, "cteemissao");
        $hora = pg_fetch_result($cad, $i, "ctehorario");
        $cfop = pg_fetch_result($cad, $i, "ctecfop");
        $modal = pg_fetch_result($cad, $i, "tmonome");
        $servico = pg_fetch_result($cad, $i, "sernome");
        $finalidade = pg_fetch_result($cad, $i, "tctnome");
        $emissaoest = pg_fetch_result($cad, $i, "cteufemissao");
        $emissaocid = pg_fetch_result($cad, $i, "cidemissao");
        $localemissao = trim($emissaocid) . ' ' . trim($emissaoest);
        $inicioest = pg_fetch_result($cad, $i, "cteufinicio");
        $iniciocid = pg_fetch_result($cad, $i, "cidinicio");
        $localinicio = trim($iniciocid) . ' ' . trim($inicioest);
        $finalest = pg_fetch_result($cad, $i, "cteuffinal");
        $finalcid = pg_fetch_result($cad, $i, "cidfinal");
        $localfinal = trim($finalcid) . ' ' . trim($finalest);
        $emitente = pg_fetch_result($cad, $i, "cteemirazao");
        $tomador = pg_fetch_result($cad, $i, "tomnome");
        $tomador = convertem($tomador, 1);
        $tomadorrazao = pg_fetch_result($cad, $i, "ctetomrazao");
        if ($tomador == 'OUTROS' && $tomadorrazao != '') {
            $tomador = $tomadorrazao;
        }
        $remetente = pg_fetch_result($cad, $i, "remnome");
        $remetente = convertem(substr($remetente, 0, 13), 1);
        $remetenterazao = pg_fetch_result($cad, $i, "cteremrazao");
        if ($remetente == 'COM REMETENTE' && $remetenterazao != '') {
            $remetente = $remetenterazao;
        }
        $expedidor = pg_fetch_result($cad, $i, "expnome");
        $expedidor = convertem(substr($expedidor, 0, 13), 1);
        $expedidorrazao = pg_fetch_result($cad, $i, "cteexprazao");
        if ($expedidor == 'COM EXPEDIDOR' && $expedidorrazao != '') {
            $expedidor = $expedidorrazao;
        }
        $recebedor = pg_fetch_result($cad, $i, "recnome");
        $recebedor = convertem(substr($recebedor, 0, 13), 1);
        $recebedorrazao = pg_fetch_result($cad, $i, "cterecrazao");
        if ($recebedor == 'COM RECEBEDOR' && $recebedorrazao != '') {
            $recebedor = $recebedorrazao;
        }
        $destinatario = pg_fetch_result($cad, $i, "desnome");
        $destinatario = convertem(substr($destinatario, 0, 16), 1);
        $destinatariorazao = pg_fetch_result($cad, $i, "ctedesrazao");
        if ($destinatario == 'COM DESTINATARIO' && $destinatariorazao != '') {
            $destinatario = $destinatariorazao;
        }
        $servicos = pg_fetch_result($cad, $i, "cteservicos");
        $receber = pg_fetch_result($cad, $i, "ctereceber");
        $tributos = pg_fetch_result($cad, $i, "ctetributos");
        $cargaval = pg_fetch_result($cad, $i, "ctecargaval");
        $produto = pg_fetch_result($cad, $i, "ctepropredominante");
        $obs = pg_fetch_result($cad, $i, "cteobsgeral");

        $ctecancdata = pg_fetch_result($cad, $i, "ctecancdata");
        $ctedatainutiliza = pg_fetch_result($cad, $i, "ctedatainutiliza");

        $ctenprot = pg_fetch_result($cad, $i, "ctenprot");
        $ctemotivo = pg_fetch_result($cad, $i, "ctemotivo");
        $ctechave = pg_fetch_result($cad, $i, "ctechave");

        //Localiza o Veiculo		
        $sqlx = "Select cteveiplaca 
					from cteinfoveiculos where ctenumero = $ctenumero 
					order by cteinfveicodigo limit 1";
        $cadx = pg_query($sqlx);
        $rowx = pg_num_rows($cadx);
        $veiculo = '';
        if ($rowx > 0) {
            $veiculo = pg_fetch_result($cadx, 0, "cteveiplaca");
        }
        if ($veiculo == '') {
            $veiculo = " ";
        }

        //Localiza o Motorista
        $sqlx = "Select cteinfmotnome 
					from cteinfomotoristas where ctenumero = $ctenumero 
					order by cteinfmotcodigo limit 1";
        $cadx = pg_query($sqlx);
        $rowx = pg_num_rows($cadx);
        $motorista = '';
        if ($rowx > 0) {
            $motorista = pg_fetch_result($cadx, 0, "cteinfmotnome");
        }
        if ($motorista == '') {
            $motorista = " ";
        }



        //Localiza as nfs
        $sqlx = "Select ctenfenome from ctenfechave where ctenumero = $ctenumero order by ctenfecodigo";
        $cadx = pg_query($sqlx);
        $rowx = pg_num_rows($cadx);
        $nf = '';
        if ($rowx > 0) {

            for ($ix = 0; $ix < $rowx; $ix++) {

                $nf = $nf . ' ' . intval(substr(pg_fetch_result($cadx, $ix, "ctenfenome"), 25, 9));
            }
        }

        $nf = trim($nf);

        if ($nf == '') {
            $nf = "_";
        }

        if ($ctenumero == '') {
            $ctenumero = ' ';
        }
        if ($cteserie == '') {
            $cteserie = ' ';
        }
        if ($ctenum == '') {
            $ctenum = ' ';
        }
        if ($hora == '') {
            $hora = ' ';
        }
        if ($emissao == "") {
            $emissao = " ";
        } else {
            $aux = explode(" ", $emissao);
            $aux1 = explode("-", $aux[0]);
            $emissao = $aux1[2] . '/' . $aux1[1] . '/' . $aux1[0];
        }
        if ($cfop == '') {
            $cfop = ' ';
        }
        if ($modal == '') {
            $modal = ' ';
        }
        if ($servico == '') {
            $servico = ' ';
        }
        if ($finalidade == '') {
            $finalidade = ' ';
        }
        if ($localemissao == '') {
            $localemissao = ' ';
        }
        if ($localinicio == '') {
            $localinicio = ' ';
        }
        if ($localfinal == '') {
            $localfinal = ' ';
        }
        if ($emitente == '') {
            $emitente = ' ';
        }
        if ($tomador == '') {
            $tomador = ' ';
        }
        if ($remetente == '') {
            $remetente = ' ';
        }
        if ($expedidor == '') {
            $expedidor = ' ';
        }
        if ($recebedor == '') {
            $recebedor = ' ';
        }
        if ($destinatario == '') {
            $destinatario = ' ';
        }
        if ($servicos == '') {
            $servicos = '0';
        }
        if ($receber == '') {
            $receber = '0';
        }
        if ($tributos == '') {
            $tributos = '0';
        }
        if ($cargaval == '') {
            $cargaval = '0';
        }
        if ($produto == '') {
            $produto = ' ';
        }
        if ($obs == '') {
            $obs = ' ';
        }


        if ($ctemotivo == '') {
            $ctemotivo = '_';
        }

        if ($ctemotivo == 'Autorizado o uso do CT-e') {
            $logpdf = "arquivos/cte/" . $ctenum . "/" . $ctechave . "-procCTe.pdf";
            // Verifica se o arquivo existe
            if (!file_exists($logpdf)) {
                $logpdf = "_";
            }
            $logxml = "arquivos/cte/" . $ctenum . "/" . $ctechave . "-procCTe.xml";
            // Verifica se o arquivo existe
            if (!file_exists($logxml)) {
                $logxml = "_";
            }
        } else {
            $logpdf = "_";
            $logxml = "_";
        }

        if ($ctecancdata != "") {
            $aux = explode(" ", $ctecancdata);
            $aux1 = explode("-", $aux[0]);
            $ctecancdata = $aux1[2] . '/' . $aux1[1] . '/' . $aux1[0];
            $cor = "#ff6666";

            if ($ctedatainutiliza != "") {
                $aux = explode(" ", $ctedatainutiliza);
                $aux1 = explode("-", $aux[0]);
                $ctedatainutiliza = $aux1[2] . '/' . $aux1[1] . '/' . $aux1[0];
            } else {
                $ctedatainutiliza = "_";
            }
        } else if ($ctedatainutiliza != "") {
            $aux = explode(" ", $ctedatainutiliza);
            $aux1 = explode("-", $aux[0]);
            $ctedatainutiliza = $aux1[2] . '/' . $aux1[1] . '/' . $aux1[0];
            $cor = "#ffa366";
            $ctecancdata = "_";
        } else {
            $ctecancdata = "_";
            $ctedatainutiliza = "_";
            $cor = "#8FBC8F";

            // Se for uso autorizado aparece verde
            if ($ctemotivo == 'Autorizado o uso do CT-e') {
                $cor = "#8FBC8F";
            } else {
                // Se não for branco é rejeitado e aparece em amarelo
                if ($ctemotivo != '_') {
                    $cor = "#ffff99";
                } else {
                    $cor = "#99ddff";
                }
            }
        }

        $servicos = number_format($servicos, 2, ',', '.');
        $receber = number_format($receber, 2, ',', '.');
        $tributos = number_format($tributos, 2, ',', '.');
        $cargaval = number_format($cargaval, 2, ',', '.');

        $processa = 0;
        if ($ctecancdata == "_" && $ctedatainutiliza == "_") {
            $processa = 1;
        } else {
            if ($cancelados == 1) {
                $processa = 1;
            }
        }


        if ($processa == 1) {
            $k++;

            echo "<td bgcolor='" . $cor . "' align='center' class='borda'>" . $k . "</td>";
            echo "<td bgcolor='" . $cor . "' align='center' class='borda'>" . $ctenumero . "</td>";
            echo "<td bgcolor='" . $cor . "' align='center' class='borda'>" . $cteserie . "</td>";
            echo "<td bgcolor='" . $cor . "' align='center' class='borda'>" . $ctenum . "</td>";
            echo "<td bgcolor='" . $cor . "' align='center' class='borda'>" . $emissao . "</td>";
            echo "<td bgcolor='" . $cor . "' align='center' class='borda'>" . $hora . "</td>";

            echo "<td bgcolor='" . $cor . "' align='center' class='borda'>" . $nf . "</td>";
            if ($ctenprot == '') {
                echo "<td bgcolor='" . $cor . "' align='center' class='borda'>" . $ctenprot . "</td>";
            } else {
                echo "<td bgcolor='" . $cor . "' align='center' class='borda'>'" . $ctenprot . "'</td>";
            }
            echo "<td bgcolor='" . $cor . "' align='center' class='borda'>" . $ctemotivo . "</td>";

            echo "<td bgcolor='" . $cor . "' align='center' class='borda'>" . $cfop . "</td>";
            echo "<td bgcolor='" . $cor . "' align='center' class='borda'>" . $modal . "</td>";
            echo "<td bgcolor='" . $cor . "' align='center' class='borda'>" . $servico . "</td>";
            echo "<td bgcolor='" . $cor . "' align='center' class='borda'>" . $finalidade . "</td>";
            echo "<td bgcolor='" . $cor . "' align='center' class='borda'>" . $localemissao . "</td>";
            echo "<td bgcolor='" . $cor . "' align='center' class='borda'>" . $localinicio . "</td>";
            echo "<td bgcolor='" . $cor . "' align='center' class='borda'>" . $localfinal . "</td>";
            echo "<td bgcolor='" . $cor . "' align='center' class='borda'>" . $emitente . "</td>";
            echo "<td bgcolor='" . $cor . "' align='center' class='borda'>" . $tomador . "</td>";
            echo "<td bgcolor='" . $cor . "' align='center' class='borda'>" . $remetente . "</td>";
            echo "<td bgcolor='" . $cor . "' align='center' class='borda'>" . $expedidor . "</td>";
            echo "<td bgcolor='" . $cor . "' align='center' class='borda'>" . $recebedor . "</td>";
            echo "<td bgcolor='" . $cor . "' align='center' class='borda'>" . $destinatario . "</td>";
            echo "<td bgcolor='" . $cor . "' align='center' class='borda'>" . $servicos . "</td>";
            echo "<td bgcolor='" . $cor . "' align='center' class='borda'>" . $receber . "</td>";
            echo "<td bgcolor='" . $cor . "' align='center' class='borda'>" . $tributos . "</td>";
            echo "<td bgcolor='" . $cor . "' align='center' class='borda'>" . $produto . "</td>";
            echo "<td bgcolor='" . $cor . "' align='center' class='borda'>" . $cargaval . "</td>";

            echo "<td bgcolor='" . $cor . "' align='center' class='borda'>" . $ctecancdata . "</td>";

            echo "<td bgcolor='" . $cor . "' align='center' class='borda'>" . $ctedatainutiliza . "</td>";
            echo "<td bgcolor='" . $cor . "' align='center' class='borda'>" . $motorista . "</td>";
            echo "<td bgcolor='" . $cor . "' align='left' class='borda'>" . $obs . "</td>";
            echo "</tr>\r\n";
        }
    }
} else {

    echo "<tr>";
    echo "<td bgcolor=\"#CCCCCC\" colspan=\"27\" align=\"center\"><b>Nenhum registro encontrado!</b></td>";
    echo "</tr>\r\n";
}


//$xml.="</dados>";

echo "</table></body></html>\r\n";

//echo $xml;
pg_close($conn);

function convertem($term, $tp) {
    if ($tp == "1")
        $palavra = strtr(strtoupper($term), "àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß");
    elseif ($tp == "0")
        $palavra = strtr(strtolower($term), "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß", "àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ");
    return $palavra;
}

exit();
?>
