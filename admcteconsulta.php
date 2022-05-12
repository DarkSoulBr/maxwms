<?php

require_once("include/conexao.inc.php");

$auxdatainicio = $_GET['dataInicio'];
$auxdatafim = $_GET['dataFim'];
$usuario = $_GET['usuario'];
$npedido = $_GET['npedido'];
$cancelados = $_GET["cancelados"];
if ($npedido == '') {
    $npedido = '0';
}

$pagina = $_GET['pagina'];
if ($pagina == '') {
    $pagina = '1';
}

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

    //Se estiver atualizando o Status de Algum pedido troca o flag pra trazer tudo.
    $cancelados = 1;

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

$valor = 0;

header("Content-type: application/xml");
$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";
$xml .= "<dados>";

$k;

$pagfim = (100 * $pagina);
$pagini = $pagfim - 99;

$processados = 0;

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
            $veiculo = "_";
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
            $motorista = "_";
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
            $ctenumero = '_';
        }
        if ($cteserie == '') {
            $cteserie = '_';
        }
        if ($ctenum == '') {
            $ctenum = '_';
        }
        if ($hora == '') {
            $hora = '_';
        }
        if ($emissao == "") {
            $emissao = "_";
        } else {
            $aux = explode(" ", $emissao);
            $aux1 = explode("-", $aux[0]);
            $emissao = $aux1[2] . '/' . $aux1[1] . '/' . $aux1[0];
        }
        if ($cfop == '') {
            $cfop = '_';
        }
        if ($modal == '') {
            $modal = '_';
        }
        if ($servico == '') {
            $servico = '_';
        }
        if ($finalidade == '') {
            $finalidade = '_';
        }
        if ($localemissao == '') {
            $localemissao = '_';
        }
        if ($localinicio == '') {
            $localinicio = '_';
        }
        if ($localfinal == '') {
            $localfinal = '_';
        }
        if ($emitente == '') {
            $emitente = '_';
        }
        if ($tomador == '') {
            $tomador = '_';
        }
        if ($remetente == '') {
            $remetente = '_';
        }
        if ($expedidor == '') {
            $expedidor = '_';
        }
        if ($recebedor == '') {
            $recebedor = '_';
        }
        if ($destinatario == '') {
            $destinatario = '_';
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
            $produto = '_';
        }
        if ($obs == '') {
            $obs = '_';
        }

        if ($ctenprot == '') {
            $ctenprot = '_';
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

            $processados++;
            $k++;

            if ($processados >= $pagini && $processados <= $pagfim) {

                $xml .= "<registro>";
                $xml .= "<item>" . $k . "</item>";
                $xml .= "<item>" . $ctenumero . "</item>";
                $xml .= "<item>" . $cteserie . "</item>";
                $xml .= "<item>" . $ctenum . "</item>";
                $xml .= "<item>" . $emissao . "</item>";
                $xml .= "<item>" . $hora . "</item>";
                $xml .= "<item>" . $cfop . "</item>";
                $xml .= "<item>" . $modal . "</item>";
                $xml .= "<item>" . $servico . "</item>";
                $xml .= "<item>" . $finalidade . "</item>";
                $xml .= "<item>" . $localemissao . "</item>";
                $xml .= "<item>" . $localinicio . "</item>";
                $xml .= "<item>" . $localfinal . "</item>";
                $xml .= "<item>" . $emitente . "</item>";
                $xml .= "<item>" . $tomador . "</item>";
                $xml .= "<item>" . $remetente . "</item>";
                $xml .= "<item>" . $expedidor . "</item>";
                $xml .= "<item>" . $recebedor . "</item>";
                $xml .= "<item>" . $destinatario . "</item>";
                $xml .= "<item>" . $servicos . "</item>";
                $xml .= "<item>" . $receber . "</item>";
                $xml .= "<item>" . $tributos . "</item>";
                $xml .= "<item>" . $produto . "</item>";
                $xml .= "<item>" . $cargaval . "</item>";
                $xml .= "<item>" . $ctedatainutiliza . "</item>";
                $xml .= "<item>" . $motorista . "</item>";
                $xml .= "<item>" . $obs . "</item>";
                $xml .= "<item>" . $cor . "</item>";
                $xml .= "<item>" . $nf . "</item>";
                $xml .= "<item>" . $ctecancdata . "</item>";
                $xml .= "<item>" . $ctenprot . "</item>";
                $xml .= "<item>" . $ctemotivo . "</item>";
                $xml .= "<item>" . $logpdf . "</item>";
                $xml .= "<item>" . $logxml . "</item>";
                $xml .= "</registro>";
            }
        }
    }
} else {

    $xml .= "<registro>";
    $xml .= "<item>0</item>";
    $xml .= "<item>0</item>";
    $xml .= "<item>0</item>";
    $xml .= "<item>0</item>";
    $xml .= "<item>0</item>";
    $xml .= "<item>0</item>";
    $xml .= "<item>0</item>";
    $xml .= "<item>0</item>";
    $xml .= "<item>0</item>";
    $xml .= "<item>0</item>";
    $xml .= "<item>0</item>";
    $xml .= "<item>0</item>";
    $xml .= "<item>0</item>";
    $xml .= "<item>0</item>";
    $xml .= "<item>0</item>";
    $xml .= "<item>0</item>";
    $xml .= "<item>0</item>";
    $xml .= "<item>0</item>";
    $xml .= "<item>0</item>";
    $xml .= "<item>0</item>";
    $xml .= "<item>0</item>";
    $xml .= "<item>0</item>";
    $xml .= "<item>0</item>";
    $xml .= "<item>0</item>";
    $xml .= "<item>0</item>";
    $xml .= "<item>0</item>";
    $xml .= "<item>0</item>";
    $xml .= "<item>0</item>";
    $xml .= "<item>0</item>";
    $xml .= "<item>0</item>";
    $xml .= "<item>0</item>";
    $xml .= "<item>0</item>";
    $xml .= "<item>0</item>";
    $xml .= "<item>0</item>";
    $xml .= "</registro>";
}


$xml .= "</dados>";

echo $xml;
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
