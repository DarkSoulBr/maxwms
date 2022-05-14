<?php

//RECEBE PARÃMETRO
$parametro = trim($_POST["parametro"]);

set_time_limit(0);

require("verifica2.php");

require_once("include/conexao.inc.php");
require_once("include/importainternet.php");

$usucodigo = $_SESSION["id_usuario"];

//$diretorio = getcwd();
$diretorio = "/home/delta/nfe";

$ponteiro = opendir($diretorio);

$itens = array();
unset($itens);

while ($nome_itens = readdir($ponteiro)) {
    $itens[] = $nome_itens;
}

sort($itens);

$arquivos = array();
unset($arquivos);

$pastas = array();
unset($pastas);

foreach ($itens as $listar) {
    if ($listar != "." && $listar != "..") {
        if (is_dir($listar)) {
            $pastas[] = $listar;
        } else {
            $arquivos[] = $listar;
        }
    }
}

if ($arquivos != "") {
    foreach ($arquivos as $listar) {

        if (substr($listar, strlen($listar) - 4, 4) == ".XML" || substr($listar, strlen($listar) - 4, 4) == ".xml") {


            print " Arquivo: <a href='$listar'>$listar</a><br>";
            //Comeca a Importacao

            $listarx = $diretorio . '/' . $listar;

            if (file_exists($listarx)) {

                #carrega o arquivo XML e retornando um Array
                $xml = simplexml_load_file($listarx);

                $cadastro = new banco($conn, $db);

                //Processa os Dados para Gravar na Tabela de Notas
                $uf = $xml->NFe->infNFe->ide->cUF;

                //Formato 1 
                if ($uf == "") {

                    $nfeserie = $xml->infNFe->ide->serie;
                    $nfenumero = $xml->infNFe->ide->nNF;
                    $nfeCNPJ = $xml->infNFe->emit->CNPJ;

                    $nfeuf = $xml->infNFe->ide->cUF;
                    $nfenf = $xml->infNFe->ide->cNF;
                    $nfenatop = $xml->infNFe->ide->natOp;
                    $nfenatop = substr($nfenatop, 0, 50);
                    $nfeindPag = $xml->infNFe->ide->indPag;
                    $nfemod = $xml->infNFe->ide->mod;
                    $nfedEmi = $xml->infNFe->ide->dEmi;
                    //Se data estiver em branco o XML é 3.10
                    if ($nfedEmi == '') {
                        $nfedEmi = $xml->infNFe->ide->dhEmi;
                        $nfedEmi = substr($nfedEmi, 0, 10);
                    }
                    $nfedSaiEnt = $xml->infNFe->ide->dSaiEnt;
                    $nfetpNF = $xml->infNFe->ide->tpNF;
                    $nfecMunFG = $xml->infNFe->ide->cMunFG;
                    $nfetpImp = $xml->infNFe->ide->tpImp;
                    $nfetpEmis = $xml->infNFe->ide->tpEmis;
                    $nfecDV = $xml->infNFe->ide->cDV;
                    $nfetpAmb = $xml->infNFe->ide->tpAmb;
                    $nfefinNFe = $xml->infNFe->ide->finNFe;
                    $nfeprocEmi = $xml->infNFe->ide->procEmi;
                    $nfeverProc = $xml->infNFe->ide->verProc;


                    //Dados do Emitente
                    $nfeemixNome = $xml->infNFe->emit->xNome;
                    $nfeemixFant = $xml->infNFe->emit->xFant;
                    $nfeemixFant = substr($nfeemixFant, 0, 30);
                    $nfeemixLgr = $xml->infNFe->emit->enderEmit->xLgr;
                    $nfeeminro = $xml->infNFe->emit->enderEmit->nro;
                    $nfeemixBairro = $xml->infNFe->emit->enderEmit->xBairro;
                    $nfeemicMun = $xml->infNFe->emit->enderEmit->cMun;
                    $nfeemixMun = $xml->infNFe->emit->enderEmit->xMun;
                    $nfeemiUF = $xml->infNFe->emit->enderEmit->UF;
                    $nfeemiCEP = $xml->infNFe->emit->enderEmit->CEP;
                    $nfeemicPais = $xml->infNFe->emit->enderEmit->cPais;
                    $nfeemixPais = $xml->infNFe->emit->enderEmit->xPais;
                    $nfeemiIE = $xml->infNFe->emit->IE;

                    //Dados do Destinatário
                    $nfedesCNPJ = $xml->infNFe->dest->CNPJ;
                    $nfedesxNome = $xml->infNFe->dest->xNome;
                    $nfedesxLgr = $xml->infNFe->dest->enderDest->xLgr;
                    $nfedesnro = $xml->infNFe->dest->enderDest->nro;
                    $nfedesxBairro = $xml->infNFe->dest->enderDest->xBairro;
                    $nfedescMun = $xml->infNFe->dest->enderDest->cMun;
                    $nfedesxMun = $xml->infNFe->dest->enderDest->xMun;
                    $nfedesUF = $xml->infNFe->dest->enderDest->UF;
                    $nfedesCEP = $xml->infNFe->dest->enderDest->CEP;
                    $nfedescPais = $xml->infNFe->dest->enderDest->cPais;
                    $nfedesxPais = $xml->infNFe->dest->enderDest->xPais;
                    $nfedesfone = $xml->infNFe->dest->enderDest->fone;
                    $nfedesIE = $xml->infNFe->dest->IE;

                    //Entrega
                    $nfeentCNPJ = $xml->infNFe->entrega->CNPJ;
                    $nfeentxLgr = $xml->infNFe->entrega->xLgr;
                    $nfeentnro = $xml->infNFe->entrega->nro;
                    $nfeentxBairro = $xml->infNFe->entrega->xBairro;
                    $nfeentcMun = $xml->infNFe->entrega->cMun;
                    $nfeentxMun = $xml->infNFe->entrega->xMun;
                    $nfeentUF = $xml->infNFe->entrega->UF;


                    //Totais
                    $nfevBC = $xml->infNFe->total->ICMSTot->vBC;
                    $nfevICMS = $xml->infNFe->total->ICMSTot->vICMS;
                    $nfevBCST = $xml->infNFe->total->ICMSTot->vBCST;
                    $nfevST = $xml->infNFe->total->ICMSTot->vST;
                    $nfevProd = $xml->infNFe->total->ICMSTot->vProd;
                    $nfevFrete = $xml->infNFe->total->ICMSTot->vFrete;
                    $nfevSeg = $xml->infNFe->total->ICMSTot->vSeg;
                    $nfevDesc = $xml->infNFe->total->ICMSTot->vDesc;
                    $nfevII = $xml->infNFe->total->ICMSTot->vII;
                    $nfevIPI = $xml->infNFe->total->ICMSTot->vIPI;
                    $nfevPIS = $xml->infNFe->total->ICMSTot->vPIS;
                    $nfevCOFINS = $xml->infNFe->total->ICMSTot->vCOFINS;
                    $nfevOutro = $xml->infNFe->total->ICMSTot->vOutro;
                    $nfevNF = $xml->infNFe->total->ICMSTot->vNF;


                    //Transportador
                    $nfetramodFrete = $xml->infNFe->transp->modFrete;
                    $nfetraCNPJ = $xml->infNFe->transp->transporta->CNPJ;
                    $nfetraxNome = $xml->infNFe->transp->transporta->xNome;
                    $nfetraxEnder = $xml->infNFe->transp->transporta->xEnder;
                    $nfetraxMun = $xml->infNFe->transp->transporta->xMun;
                    $nfetraUF = $xml->infNFe->transp->transporta->UF;
                    $nfetraqVol = $xml->infNFe->transp->vol->qVol;
                    $nfetraesp = $xml->infNFe->transp->vol->esp;
                    $nfetramarca = $xml->infNFe->transp->vol->marca;
                    $nfetranVol = $xml->infNFe->transp->vol->nVol;

                    if ($nfetraqVol == '') {
                        $nfetraqVol = 0;
                    }

                    //Dados da Fatura
                    $nfenFat = $xml->infNFe->cobr->fat->nFat;
                    $nfevOrig = $xml->infNFe->cobr->fat->vOrig;
                    $nfevLiq = $xml->infNFe->cobr->fat->vLiq;

                    if ($nfevOrig == '') {
                        $nfevOrig = 0;
                    }
                    if ($nfevLiq == '') {
                        $nfevLiq = 0;
                    }

                    //Observacoes
                    $nfeinfCpl = $xml->infNFe->infAdic->infCpl;
                    $nfeinfCpl = str_replace("'", "", $nfeinfCpl);

                    //Se existir a Nota Exclui a Nota e os itens	
                    $sql02 = "select nfecodigo from nfe where nfenumero = $nfenumero and nfeserie = '$nfeserie' and nfecnpj='$nfeCNPJ'";
                    $sql02 = pg_query($sql02);
                    $row02 = pg_num_rows($sql02);

                    if ($row02) {
                        $nfecodigo = pg_fetch_result($sql02, 0, "nfecodigo");

                        $sql02 = "Delete from nfe where nfecodigo = $nfecodigo";
                        pg_query($sql02);

                        $sql02 = "Delete from nfeit where nfecodigo = $nfecodigo";
                        pg_query($sql02);

                        $sql02 = "Delete from nfedp where nfecodigo = $nfecodigo";
                        pg_query($sql02);
                    }


                    $cadastro->insere("nfe", "(nfenumero,nfeserie,nfecnpj,
				nfeuf,
				nfenf,
				nfenatop,
				nfeindPag,
				nfemod,
				nfedEmi,
				nfedSaiEnt,
				nfetpNF,
				nfecMunFG,
				nfetpImp,
				nfetpEmis,
				nfecDV,
				nfetpAmb,
				nfefinNFe,
				nfeprocEmi,
				nfeverProc,
				nfeemixNome,
				nfeemixFant,
				nfeemixLgr,
				nfeeminro,
				nfeemixBairro,
				nfeemicMun,
				nfeemixMun,
				nfeemiUF,
				nfeemiCEP,
				nfeemicPais,
				nfeemixPais,
				nfeemiIE,
				nfedesCNPJ,
				nfedesxNome,
				nfedesxLgr,
				nfedesnro,
				nfedesxBairro,
				nfedescMun,
				nfedesxMun,
				nfedesUF,
				nfedesCEP,
				nfedescPais,
				nfedesxPais,
				nfedesfone,
				nfedesIE,
				nfeentCNPJ,
				nfeentxLgr,
				nfeentnro,
				nfeentxBairro,
				nfeentcMun,
				nfeentxMun,
				nfeentUF,
				nfevBC,
				nfevICMS,
				nfevBCST,
				nfevST,
				nfevProd,
				nfevFrete,
				nfevSeg,
				nfevDesc,
				nfevII,
				nfevIPI,
				nfevPIS,
				nfevCOFINS,
				nfevOutro,
				nfevNF,
				nfetramodFrete,
				nfetraCNPJ,
				nfetraxNome,
				nfetraxEnder,
				nfetraxMun,
				nfetraUF,
				nfetraqVol,
				nfetraesp,
				nfetramarca,
				nfetranVol,
				nfenFat,
				nfevOrig,
				nfevLiq,
				nfeinfCpl
				)", "
				('$nfenumero','$nfeserie','$nfeCNPJ',
				'$nfeuf',
				'$nfenf',
				'$nfenatop',
				'$nfeindPag',
				'$nfemod',
				'$nfedEmi',
				'$nfedSaiEnt',
				'$nfetpNF',
				'$nfecMunFG',
				'$nfetpImp',
				'$nfetpEmis',
				'$nfecDV',
				'$nfetpAmb',
				'$nfefinNFe',
				'$nfeprocEmi',
				'$nfeverProc',
				'$nfeemixNome',
				'$nfeemixFant',
				'$nfeemixLgr',
				'$nfeeminro',
				'$nfeemixBairro',
				'$nfeemicMun',
				'$nfeemixMun',
				'$nfeemiUF',
				'$nfeemiCEP',
				'$nfeemicPais',
				'$nfeemixPais',
				'$nfeemiIE',				
				'$nfedesCNPJ',
				'$nfedesxNome',
				'$nfedesxLgr',
				'$nfedesnro',
				'$nfedesxBairro',
				'$nfedescMun',
				'$nfedesxMun',
				'$nfedesUF',
				'$nfedesCEP',
				'$nfedescPais',
				'$nfedesxPais',
				'$nfedesfone',
				'$nfedesIE',				
				'$nfeentCNPJ',
				'$nfeentxLgr',
				'$nfeentnro',
				'$nfeentxBairro',
				'$nfeentcMun',
				'$nfeentxMun',
				'$nfeentUF',
				'$nfevBC',
				'$nfevICMS',
				'$nfevBCST',
				'$nfevST',
				'$nfevProd',
				'$nfevFrete',
				'$nfevSeg',
				'$nfevDesc',
				'$nfevII',
				'$nfevIPI',
				'$nfevPIS',
				'$nfevCOFINS',
				'$nfevOutro',
				'$nfevNF',
				'$nfetramodFrete',
				'$nfetraCNPJ',
				'$nfetraxNome',
				'$nfetraxEnder',
				'$nfetraxMun',
				'$nfetraUF',
				'$nfetraqVol',
				'$nfetraesp',
				'$nfetramarca',
				'$nfetranVol',
				'$nfenFat',
				'$nfevOrig',
				'$nfevLiq',
				'$nfeinfCpl'
				)");

                    //Pega o Código Interno que foi inserida a Nota
                    $j = 0;
                    for ($i = 0; $i < 2; $i++) {

                        $sql02 = "select nfecodigo from nfe where nfenumero = $nfenumero and nfeserie = '$nfeserie' and nfecnpj='$nfeCNPJ'";

                        $sql02 = pg_query($sql02);
                        $row02 = pg_num_rows($sql02);
                        $i = 0;
                        $j++;

                        if ($row02) {
                            $i = 2;
                            $nfecodigo = pg_fetch_result($sql02, 0, "nfecodigo");
                        }
                        if ($j == 10000) {
                            $i = 2;
                        }
                    }

                    //Duplicatas
                    foreach ($xml->infNFe->cobr->dup as $dup) {
                        $nfenDup = $dup->nDup;
                        $nfedVenc = $dup->dVenc;
                        $nfevDup = $dup->vDup;

                        $cadastro->insere("nfedp", "(nfecodigo,nfedpdup,nfedpvec,nfedpval)", "
					('$nfecodigo','$nfenDup','$nfedVenc','$nfevDup')");
                    }


                    //Entra em Looping para Inserior os Itens
                    //Produtos
                    foreach ($xml->infNFe->det as $item) {
                        $cEAN = $item->prod->cEAN;
                        $qCom = $item->prod->qCom;


                        //Vou Localizar o produto através do EAN 
                        if ($cEAN == "") {
                            $procodigo = 0;
                        } else {
                            $sqlit = "Select procodigo FROM cbarras where barunidade = '" . $cEAN . "'";

                            $cadit = pg_query($sqlit);
                            $rowit = pg_num_rows($cadit);

                            $procodigo = 0;

                            if ($rowit > 0) {
                                $procodigo = pg_fetch_result($cadit, 0, "procodigo");
                            }
                        }

                        //Se Nao encontrar vou tentar localizar pela referencia
                        if ($procodigo == 0) {

                            $sqlit = "Select procodigo FROM produto where proref = '" . $cprod . "'";

                            $cadit = pg_query($sqlit);
                            $rowit = pg_num_rows($cadit);

                            $procodigo = 0;

                            if ($rowit > 0) {
                                $procodigo = pg_fetch_result($cadit, 0, "procodigo");
                            }
                        }

                        $nfeprod = $item->prod->cProd;
                        $nfexProd = $item->prod->xProd;
                        $nfexProd = substr($nfexProd, 0, 100);
                        $nfexProd = str_replace("'", "", $nfexProd);
                        $nfeNCM = $item->prod->NCM;
                        $nfeEXTIPI = $item->prod->EXTIPI;
                        $nfeCFOP = $item->prod->CFOP;
                        $nfeuCom = $item->prod->uCom;
                        $nfevUnCom = $item->prod->vUnCom;
                        $nfevProd = $item->prod->vProd;
                        $nfecEANTrib = $item->prod->cEANTrib;
                        $nfeuTrib = $item->prod->uTrib;
                        $nfeqTrib = $item->prod->qTrib;
                        $nfevUnTrib = $item->prod->vUnTrib;
                        $nfevDesc = $item->prod->vDesc;

                        if ($nfevDesc == '') {
                            $nfevDesc = 0;
                        }

                        //Trata o Icms
                        $nfeticms = '';
                        $nfeorig = '';
                        $nfeCST = '';
                        $nfemodBC = '';
                        $nfepRedBC = 0;
                        $nfevBC = 0;
                        $nfepICMS = 0;
                        $nfevICMS = 0;
                        $nfemodBCST = '';
                        $nfepMVAST = 0;
                        $nfepRedBCST = 0;
                        $nfevBCST = 0;
                        $nfepICMSST = 0;
                        $nfevICMSST = 0;

                        $nfeorig = $item->imposto->ICMS->ICMS00->orig;
                        //Tipo Icms = 00
                        if ($nfeorig <> '') {
                            $nfeticms = '00';
                            $nfeCST = $item->imposto->ICMS->ICMS00->CST;
                            $nfemodBC = $item->imposto->ICMS->ICMS00->modBC;
                            $nfevBC = $item->imposto->ICMS->ICMS00->vBC;
                            $nfepICMS = $item->imposto->ICMS->ICMS00->pICMS;
                            $nfevICMS = $item->imposto->ICMS->ICMS00->vICMS;
                        } else {
                            $nfeorig = $item->imposto->ICMS->ICMS10->orig;
                            if ($nfeorig <> '') {
                                $nfeticms = '10';
                                $nfeCST = $item->imposto->ICMS->ICMS10->CST;
                                $nfemodBC = $item->imposto->ICMS->ICMS10->modBC;
                                $nfevBC = $item->imposto->ICMS->ICMS10->vBC;
                                $nfepICMS = $item->imposto->ICMS->ICMS10->pICMS;
                                $nfevICMS = $item->imposto->ICMS->ICMS10->vICMS;
                                $nfemodBCST = $item->imposto->ICMS->ICMS10->modBCST;
                                $nfepMVAST = $item->imposto->ICMS->ICMS10->pMVAST;
                                $nfepRedBCST = $item->imposto->ICMS->ICMS10->pRedBCST;
                                $nfevBCST = $item->imposto->ICMS->ICMS10->vBCST;
                                $nfepICMSST = $item->imposto->ICMS->ICMS10->pICMSST;
                                $nfevICMSST = $item->imposto->ICMS->ICMS10->vICMSST;
                            } else {
                                $nfeorig = $item->imposto->ICMS->ICMS20->orig;
                                if ($nfeorig <> '') {
                                    $nfeticms = '20';
                                    $nfeCST = $item->imposto->ICMS->ICMS20->CST;
                                    $nfemodBC = $item->imposto->ICMS->ICMS20->modBC;
                                    $nfepRedBC = $item->imposto->ICMS->ICMS20->pRedBC;
                                    $nfevBC = $item->imposto->ICMS->ICMS20->vBC;
                                    $nfepICMS = $item->imposto->ICMS->ICMS20->pICMS;
                                    $nfevICMS = $item->imposto->ICMS->ICMS20->vICMS;
                                } else {
                                    $nfeorig = $item->imposto->ICMS->ICMS30->orig;
                                    if ($nfeorig <> '') {
                                        $nfeticms = '30';
                                        $nfeCST = $item->imposto->ICMS->ICMS30->CST;
                                        $nfemodBCST = $item->imposto->ICMS->ICMS30->modBCST;
                                        $nfepMVAST = $item->imposto->ICMS->ICMS30->pMVAST;
                                        $nfepRedBCST = $item->imposto->ICMS->ICMS30->pRedBCST;
                                        $nfevBCST = $item->imposto->ICMS->ICMS30->vBCST;
                                        $nfepICMSST = $item->imposto->ICMS->ICMS30->pICMSST;
                                        $nfevICMSST = $item->imposto->ICMS->ICMS30->vICMSST;
                                    } else {
                                        $nfeorig = $item->imposto->ICMS->ICMS40->orig;
                                        if ($nfeorig <> '') {
                                            $nfeticms = '40';
                                            $nfeCST = $item->imposto->ICMS->ICMS40->CST;
                                        } else {
                                            $nfeorig = $item->imposto->ICMS->ICMS51->orig;
                                            if ($nfeorig <> '') {
                                                $nfeticms = '51';
                                                $nfeCST = $item->imposto->ICMS->ICMS51->CST;
                                                $nfemodBC = $item->imposto->ICMS->ICMS51->modBC;
                                                $nfepRedBC = $item->imposto->ICMS->ICMS51->pRedBC;
                                                $nfevBC = $item->imposto->ICMS->ICMS51->vBC;
                                                $nfepICMS = $item->imposto->ICMS->ICMS51->pICMS;
                                                $nfevICMS = $item->imposto->ICMS->ICMS51->vICMS;
                                            } else {
                                                $nfeorig = $item->imposto->ICMS->ICMS60->orig;
                                                if ($nfeorig <> '') {
                                                    $nfeticms = '60';
                                                    $nfeCST = $item->imposto->ICMS->ICMS60->CST;
                                                    $nfevBCST = $item->imposto->ICMS->ICMS60->vBCST;
                                                    $nfevICMSST = $item->imposto->ICMS->ICMS60->vICMSST;
                                                } else {
                                                    $nfeorig = $item->imposto->ICMS->ICMS70->orig;
                                                    if ($nfeorig <> '') {
                                                        $nfeticms = '70';
                                                        $nfeCST = $item->imposto->ICMS->ICMS70->CST;
                                                        $nfemodBC = $item->imposto->ICMS->ICMS70->modBC;
                                                        $nfepRedBC = $item->imposto->ICMS->ICMS70->pRedBC;
                                                        $nfevBC = $item->imposto->ICMS->ICMS70->vBC;
                                                        $nfepICMS = $item->imposto->ICMS->ICMS70->pICMS;
                                                        $nfevICMS = $item->imposto->ICMS->ICMS70->vICMS;
                                                        $nfemodBCST = $item->imposto->ICMS->ICMS70->modBCST;
                                                        $nfepMVAST = $item->imposto->ICMS->ICMS70->pMVAST;
                                                        $nfepRedBCST = $item->imposto->ICMS->ICMS70->pRedBCST;
                                                        $nfevBCST = $item->imposto->ICMS->ICMS70->vBCST;
                                                        $nfepICMSST = $item->imposto->ICMS->ICMS70->pICMSST;
                                                        $nfevICMSST = $item->imposto->ICMS->ICMS70->vICMSST;
                                                    } else {
                                                        $nfeorig = $item->imposto->ICMS->ICMS90->orig;
                                                        if ($nfeorig <> '') {
                                                            $nfeticms = '90';
                                                            $nfeCST = $item->imposto->ICMS->ICMS90->CST;
                                                            $nfemodBC = $item->imposto->ICMS->ICMS90->modBC;
                                                            $nfevBC = $item->imposto->ICMS->ICMS90->vBC;
                                                            $nfepICMS = $item->imposto->ICMS->ICMS90->pICMS;
                                                            $nfevICMS = $item->imposto->ICMS->ICMS90->vICMS;
                                                            $nfemodBCST = $item->imposto->ICMS->ICMS90->modBCST;
                                                            $nfepMVAST = $item->imposto->ICMS->ICMS90->pMVAST;
                                                            $nfepRedBCST = $item->imposto->ICMS->ICMS90->pRedBCST;
                                                            $nfevBCST = $item->imposto->ICMS->ICMS90->vBCST;
                                                            $nfepICMSST = $item->imposto->ICMS->ICMS90->pICMSST;
                                                            $nfevICMSST = $item->imposto->ICMS->ICMS90->vICMSST;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }

                        if ($nfepRedBC == '') {
                            $nfepRedBC = 0;
                        }
                        if ($nfevBC == '') {
                            $nfevBC = 0;
                        }
                        if ($nfepICMS == '') {
                            $nfepICMS = 0;
                        }
                        if ($nfevICMS == '') {
                            $nfevICMS = 0;
                        }
                        if ($nfepMVAST == '') {
                            $nfepMVAST = 0;
                        }
                        if ($nfepRedBCST == '') {
                            $nfepRedBCST = 0;
                        }
                        if ($nfevBCST == '') {
                            $nfevBCST = 0;
                        }
                        if ($nfepICMSST == '') {
                            $nfepICMSST = 0;
                        }
                        if ($nfevICMSST == '') {
                            $nfevICMSST = 0;
                        }

                        $nfeipicEnq = $item->imposto->IPI->cEnq;
                        $nfeipiCST = $item->imposto->IPI->IPITrib->CST;
                        $nfeipivBC = $item->imposto->IPI->IPITrib->vBC;
                        $nfeipipIPI = $item->imposto->IPI->IPITrib->pIPI;
                        $nfeipivIPI = $item->imposto->IPI->IPITrib->vIPI;

                        $nfepisCST = $item->imposto->PIS->PISAliq->CST;
                        $nfepisvBC = $item->imposto->PIS->PISAliq->vBC;
                        $nfepispPIS = $item->imposto->PIS->PISAliq->pPIS;
                        $nfepisvPIS = $item->imposto->PIS->PISAliq->vPIS;

                        $nfecofCST = $item->imposto->COFINS->COFINSAliq->CST;
                        $nfecofvBC = $item->imposto->COFINS->COFINSAliq->vBC;
                        $nfecofpCOFINS = $item->imposto->COFINS->COFINSAliq->pCOFINS;
                        $nfecofvCOFINS = $item->imposto->COFINS->COFINSAliq->vCOFINS;

                        if ($nfeipivBC == '') {
                            $nfeipivBC = 0;
                        }
                        if ($nfeipipIPI == '') {
                            $nfeipipIPI = 0;
                        }
                        if ($nfeipivIPI == '') {
                            $nfeipivIPI = 0;
                        }

                        if ($nfepisvBC == '') {
                            $nfepisvBC = 0;
                        }
                        if ($nfepispPIS == '') {
                            $nfepispPIS = 0;
                        }
                        if ($nfepisvPIS == '') {
                            $nfepisvPIS = 0;
                        }

                        if ($nfecofvBC == '') {
                            $nfecofvBC = 0;
                        }
                        if ($nfecofpCOFINS == '') {
                            $nfecofpCOFINS = 0;
                        }
                        if ($nfecofvCOFINS == '') {
                            $nfecofvCOFINS = 0;
                        }

                        $cadastro->insere("nfeit", "(nfecodigo,procodigo,nfeitquant,
					nfecEAN,
					nfeprod,
					nfexProd,
					nfeNCM,
					nfeEXTIPI,
					nfeCFOP,
					nfeuCom,
					nfevUnCom,
					nfevProd,
					nfecEANTrib,
					nfeuTrib,
					nfeqTrib,
					nfevUnTrib,
					nfeticms,
					nfeorig,
					nfeCST,
					nfemodBC,
					nfepRedBC,
					nfevBC,
					nfepICMS,
					nfevICMS,
					nfemodBCST,
					nfepMVAST,
					nfepRedBCST,
					nfevBCST,
					nfepICMSST,
					nfevICMSST,
					nfeipicEnq,
					nfeipiCST,
					nfeipivBC,
					nfeipipIPI,
					nfeipivIPI,
					nfepisCST,
					nfepisvBC,
					nfepispPIS,
					nfepisvPIS,
					nfecofCST,
					nfecofvBC,
					nfecofpCOFINS,
					nfecofvCOFINS,
					nfevDesc
					)", "
					('$nfecodigo','$procodigo','$qCom',
					'$cEAN',
					'$nfeprod',
					'$nfexProd',
					'$nfeNCM',
					'$nfeEXTIPI',
					'$nfeCFOP',
					'$nfeuCom',
					'$nfevUnCom',
					'$nfevProd',
					'$nfecEANTrib',
					'$nfeuTrib',
					'$nfeqTrib',
					'$nfevUnTrib',
					'$nfeticms',
					'$nfeorig',
					'$nfeCST',
					'$nfemodBC',
					'$nfepRedBC',
					'$nfevBC',
					'$nfepICMS',
					'$nfevICMS',
					'$nfemodBCST',
					'$nfepMVAST',
					'$nfepRedBCST',
					'$nfevBCST',
					'$nfepICMSST',
					'$nfevICMSST',
					'$nfeipicEnq',
					'$nfeipiCST',
					'$nfeipivBC',
					'$nfeipipIPI',
					'$nfeipivIPI',
					'$nfepisCST',
					'$nfepisvBC',
					'$nfepispPIS',
					'$nfepisvPIS',
					'$nfecofCST',
					'$nfecofvBC',
					'$nfecofpCOFINS',
					'$nfecofvCOFINS',
					'$nfevDesc'
					)");
                    }
                } else {

                    $nfeserie = $xml->NFe->infNFe->ide->serie;
                    $nfenumero = $xml->NFe->infNFe->ide->nNF;
                    $nfeCNPJ = $xml->NFe->infNFe->emit->CNPJ;

                    $nfeuf = $xml->NFe->infNFe->ide->cUF;
                    $nfenf = $xml->NFe->infNFe->ide->cNF;
                    $nfenatop = $xml->NFe->infNFe->ide->natOp;
                    $nfenatop = substr($nfenatop, 0, 50);
                    $nfeindPag = $xml->NFe->infNFe->ide->indPag;
                    $nfemod = $xml->NFe->infNFe->ide->mod;
                    $nfedEmi = $xml->NFe->infNFe->ide->dEmi;
                    //Se data estiver em branco o XML é 3.10
                    if ($nfedEmi == '') {
                        $nfedEmi = $xml->NFe->infNFe->ide->dhEmi;
                        $nfedEmi = substr($nfedEmi, 0, 10);
                    }
                    $nfedSaiEnt = $xml->NFe->infNFe->ide->dSaiEnt;
                    $nfetpNF = $xml->NFe->infNFe->ide->tpNF;
                    $nfecMunFG = $xml->NFe->infNFe->ide->cMunFG;
                    $nfetpImp = $xml->NFe->infNFe->ide->tpImp;
                    $nfetpEmis = $xml->NFe->infNFe->ide->tpEmis;
                    $nfecDV = $xml->NFe->infNFe->ide->cDV;
                    $nfetpAmb = $xml->NFe->infNFe->ide->tpAmb;
                    $nfefinNFe = $xml->NFe->infNFe->ide->finNFe;
                    $nfeprocEmi = $xml->NFe->infNFe->ide->procEmi;
                    $nfeverProc = $xml->NFe->infNFe->ide->verProc;


                    //Dados do Emitente
                    $nfeemixNome = $xml->NFe->infNFe->emit->xNome;
                    $nfeemixFant = $xml->NFe->infNFe->emit->xFant;
                    $nfeemixFant = substr($nfeemixFant, 0, 30);
                    $nfeemixLgr = $xml->NFe->infNFe->emit->enderEmit->xLgr;
                    $nfeeminro = $xml->NFe->infNFe->emit->enderEmit->nro;
                    $nfeemixBairro = $xml->NFe->infNFe->emit->enderEmit->xBairro;
                    $nfeemicMun = $xml->NFe->infNFe->emit->enderEmit->cMun;
                    $nfeemixMun = $xml->NFe->infNFe->emit->enderEmit->xMun;
                    $nfeemiUF = $xml->NFe->infNFe->emit->enderEmit->UF;
                    $nfeemiCEP = $xml->NFe->infNFe->emit->enderEmit->CEP;
                    $nfeemicPais = $xml->NFe->infNFe->emit->enderEmit->cPais;
                    $nfeemixPais = $xml->NFe->infNFe->emit->enderEmit->xPais;
                    $nfeemiIE = $xml->NFe->infNFe->emit->IE;

                    //Dados do Destinatário
                    $nfedesCNPJ = $xml->NFe->infNFe->dest->CNPJ;
                    $nfedesxNome = $xml->NFe->infNFe->dest->xNome;
                    $nfedesxLgr = $xml->NFe->infNFe->dest->enderDest->xLgr;
                    $nfedesnro = $xml->NFe->infNFe->dest->enderDest->nro;
                    $nfedesxBairro = $xml->NFe->infNFe->dest->enderDest->xBairro;
                    $nfedescMun = $xml->NFe->infNFe->dest->enderDest->cMun;
                    $nfedesxMun = $xml->NFe->infNFe->dest->enderDest->xMun;
                    $nfedesUF = $xml->NFe->infNFe->dest->enderDest->UF;
                    $nfedesCEP = $xml->NFe->infNFe->dest->enderDest->CEP;
                    $nfedescPais = $xml->NFe->infNFe->dest->enderDest->cPais;
                    $nfedesxPais = $xml->NFe->infNFe->dest->enderDest->xPais;
                    $nfedesfone = $xml->NFe->infNFe->dest->enderDest->fone;
                    $nfedesIE = $xml->NFe->infNFe->dest->IE;

                    //Entrega
                    $nfeentCNPJ = $xml->NFe->infNFe->entrega->CNPJ;
                    $nfeentxLgr = $xml->NFe->infNFe->entrega->xLgr;
                    $nfeentnro = $xml->NFe->infNFe->entrega->nro;
                    $nfeentxBairro = $xml->NFe->infNFe->entrega->xBairro;
                    $nfeentcMun = $xml->NFe->infNFe->entrega->cMun;
                    $nfeentxMun = $xml->NFe->infNFe->entrega->xMun;
                    $nfeentUF = $xml->NFe->infNFe->entrega->UF;


                    //Totais
                    $nfevBC = $xml->NFe->infNFe->total->ICMSTot->vBC;
                    $nfevICMS = $xml->NFe->infNFe->total->ICMSTot->vICMS;
                    $nfevBCST = $xml->NFe->infNFe->total->ICMSTot->vBCST;
                    $nfevST = $xml->NFe->infNFe->total->ICMSTot->vST;
                    $nfevProd = $xml->NFe->infNFe->total->ICMSTot->vProd;
                    $nfevFrete = $xml->NFe->infNFe->total->ICMSTot->vFrete;
                    $nfevSeg = $xml->NFe->infNFe->total->ICMSTot->vSeg;
                    $nfevDesc = $xml->NFe->infNFe->total->ICMSTot->vDesc;
                    $nfevII = $xml->NFe->infNFe->total->ICMSTot->vII;
                    $nfevIPI = $xml->NFe->infNFe->total->ICMSTot->vIPI;
                    $nfevPIS = $xml->NFe->infNFe->total->ICMSTot->vPIS;
                    $nfevCOFINS = $xml->NFe->infNFe->total->ICMSTot->vCOFINS;
                    $nfevOutro = $xml->NFe->infNFe->total->ICMSTot->vOutro;
                    $nfevNF = $xml->NFe->infNFe->total->ICMSTot->vNF;


                    //Transportador
                    $nfetramodFrete = $xml->NFe->infNFe->transp->modFrete;
                    $nfetraCNPJ = $xml->NFe->infNFe->transp->transporta->CNPJ;
                    $nfetraxNome = $xml->NFe->infNFe->transp->transporta->xNome;
                    $nfetraxEnder = $xml->NFe->infNFe->transp->transporta->xEnder;
                    $nfetraxMun = $xml->NFe->infNFe->transp->transporta->xMun;
                    $nfetraUF = $xml->NFe->infNFe->transp->transporta->UF;
                    $nfetraqVol = $xml->NFe->infNFe->transp->vol->qVol;
                    $nfetraesp = $xml->NFe->infNFe->transp->vol->esp;
                    $nfetramarca = $xml->NFe->infNFe->transp->vol->marca;
                    $nfetranVol = $xml->NFe->infNFe->transp->vol->nVol;

                    if ($nfetraqVol == '') {
                        $nfetraqVol = 0;
                    }

                    //Dados da Fatura
                    $nfenFat = $xml->NFe->infNFe->cobr->fat->nFat;
                    $nfevOrig = $xml->NFe->infNFe->cobr->fat->vOrig;
                    $nfevLiq = $xml->NFe->infNFe->cobr->fat->vLiq;

                    if ($nfevOrig == '') {
                        $nfevOrig = 0;
                    }
                    if ($nfevLiq == '') {
                        $nfevLiq = 0;
                    }

                    //Observacoes
                    $nfeinfCpl = $xml->NFe->infNFe->infAdic->infCpl;
                    $nfeinfCpl = str_replace("'", "", $nfeinfCpl);

                    //Se existir a Nota Exclui a Nota e os itens	
                    $sql02 = "select nfecodigo from nfe where nfenumero = $nfenumero and nfeserie = '$nfeserie' and nfecnpj='$nfeCNPJ'";
                    $sql02 = pg_query($sql02);
                    $row02 = pg_num_rows($sql02);

                    if ($row02) {
                        $nfecodigo = pg_fetch_result($sql02, 0, "nfecodigo");

                        $sql02 = "Delete from nfe where nfecodigo = $nfecodigo";
                        pg_query($sql02);

                        $sql02 = "Delete from nfeit where nfecodigo = $nfecodigo";
                        pg_query($sql02);

                        $sql02 = "Delete from nfedp where nfecodigo = $nfecodigo";
                        pg_query($sql02);
                    }


                    $cadastro->insere("nfe", "(nfenumero,nfeserie,nfecnpj,
				nfeuf,
				nfenf,
				nfenatop,
				nfeindPag,
				nfemod,
				nfedEmi,
				nfedSaiEnt,
				nfetpNF,
				nfecMunFG,
				nfetpImp,
				nfetpEmis,
				nfecDV,
				nfetpAmb,
				nfefinNFe,
				nfeprocEmi,
				nfeverProc,
				nfeemixNome,
				nfeemixFant,
				nfeemixLgr,
				nfeeminro,
				nfeemixBairro,
				nfeemicMun,
				nfeemixMun,
				nfeemiUF,
				nfeemiCEP,
				nfeemicPais,
				nfeemixPais,
				nfeemiIE,
				nfedesCNPJ,
				nfedesxNome,
				nfedesxLgr,
				nfedesnro,
				nfedesxBairro,
				nfedescMun,
				nfedesxMun,
				nfedesUF,
				nfedesCEP,
				nfedescPais,
				nfedesxPais,
				nfedesfone,
				nfedesIE,
				nfeentCNPJ,
				nfeentxLgr,
				nfeentnro,
				nfeentxBairro,
				nfeentcMun,
				nfeentxMun,
				nfeentUF,
				nfevBC,
				nfevICMS,
				nfevBCST,
				nfevST,
				nfevProd,
				nfevFrete,
				nfevSeg,
				nfevDesc,
				nfevII,
				nfevIPI,
				nfevPIS,
				nfevCOFINS,
				nfevOutro,
				nfevNF,
				nfetramodFrete,
				nfetraCNPJ,
				nfetraxNome,
				nfetraxEnder,
				nfetraxMun,
				nfetraUF,
				nfetraqVol,
				nfetraesp,
				nfetramarca,
				nfetranVol,
				nfenFat,
				nfevOrig,
				nfevLiq,
				nfeinfCpl
				)", "
				('$nfenumero','$nfeserie','$nfeCNPJ',
				'$nfeuf',
				'$nfenf',
				'$nfenatop',
				'$nfeindPag',
				'$nfemod',
				'$nfedEmi',
				'$nfedSaiEnt',
				'$nfetpNF',
				'$nfecMunFG',
				'$nfetpImp',
				'$nfetpEmis',
				'$nfecDV',
				'$nfetpAmb',
				'$nfefinNFe',
				'$nfeprocEmi',
				'$nfeverProc',
				'$nfeemixNome',
				'$nfeemixFant',
				'$nfeemixLgr',
				'$nfeeminro',
				'$nfeemixBairro',
				'$nfeemicMun',
				'$nfeemixMun',
				'$nfeemiUF',
				'$nfeemiCEP',
				'$nfeemicPais',
				'$nfeemixPais',
				'$nfeemiIE',				
				'$nfedesCNPJ',
				'$nfedesxNome',
				'$nfedesxLgr',
				'$nfedesnro',
				'$nfedesxBairro',
				'$nfedescMun',
				'$nfedesxMun',
				'$nfedesUF',
				'$nfedesCEP',
				'$nfedescPais',
				'$nfedesxPais',
				'$nfedesfone',
				'$nfedesIE',				
				'$nfeentCNPJ',
				'$nfeentxLgr',
				'$nfeentnro',
				'$nfeentxBairro',
				'$nfeentcMun',
				'$nfeentxMun',
				'$nfeentUF',
				'$nfevBC',
				'$nfevICMS',
				'$nfevBCST',
				'$nfevST',
				'$nfevProd',
				'$nfevFrete',
				'$nfevSeg',
				'$nfevDesc',
				'$nfevII',
				'$nfevIPI',
				'$nfevPIS',
				'$nfevCOFINS',
				'$nfevOutro',
				'$nfevNF',
				'$nfetramodFrete',
				'$nfetraCNPJ',
				'$nfetraxNome',
				'$nfetraxEnder',
				'$nfetraxMun',
				'$nfetraUF',
				'$nfetraqVol',
				'$nfetraesp',
				'$nfetramarca',
				'$nfetranVol',
				'$nfenFat',
				'$nfevOrig',
				'$nfevLiq',
				'$nfeinfCpl'
				)");

                    //Pega o Código Interno que foi inserida a Nota
                    $j = 0;
                    for ($i = 0; $i < 2; $i++) {

                        $sql02 = "select nfecodigo from nfe where nfenumero = $nfenumero and nfeserie = '$nfeserie' and nfecnpj='$nfeCNPJ'";

                        $sql02 = pg_query($sql02);
                        $row02 = pg_num_rows($sql02);
                        $i = 0;
                        $j++;

                        if ($row02) {
                            $i = 2;
                            $nfecodigo = pg_fetch_result($sql02, 0, "nfecodigo");
                        }
                        if ($j == 10000) {
                            $i = 2;
                        }
                    }

                    //Duplicatas
                    foreach ($xml->NFe->infNFe->cobr->dup as $dup) {
                        $nfenDup = $dup->nDup;
                        $nfedVenc = $dup->dVenc;
                        $nfevDup = $dup->vDup;

                        $cadastro->insere("nfedp", "(nfecodigo,nfedpdup,nfedpvec,nfedpval)", "
					('$nfecodigo','$nfenDup','$nfedVenc','$nfevDup')");
                    }


                    //Entra em Looping para Inserior os Itens
                    //Produtos
                    foreach ($xml->NFe->infNFe->det as $item) {
                        $cEAN = $item->prod->cEAN;
                        $qCom = $item->prod->qCom;


                        //Vou Localizar o produto através do EAN 
                        if ($cEAN == "") {
                            $procodigo = 0;
                        } else {
                            $sqlit = "Select procodigo FROM cbarras where barunidade = '" . $cEAN . "'";

                            $cadit = pg_query($sqlit);
                            $rowit = pg_num_rows($cadit);

                            $procodigo = 0;

                            if ($rowit > 0) {
                                $procodigo = pg_fetch_result($cadit, 0, "procodigo");
                            }
                        }

                        //Se Nao encontrar vou tentar localizar pela referencia
                        if ($procodigo == 0) {

                            $sqlit = "Select procodigo FROM produto where proref = '" . $cprod . "'";

                            $cadit = pg_query($sqlit);
                            $rowit = pg_num_rows($cadit);

                            $procodigo = 0;

                            if ($rowit > 0) {
                                $procodigo = pg_fetch_result($cadit, 0, "procodigo");
                            }
                        }

                        $nfeprod = $item->prod->cProd;
                        $nfexProd = $item->prod->xProd;
                        $nfexProd = substr($nfexProd, 0, 100);
                        $nfexProd = str_replace("'", "", $nfexProd);
                        $nfeNCM = $item->prod->NCM;
                        $nfeEXTIPI = $item->prod->EXTIPI;
                        $nfeCFOP = $item->prod->CFOP;
                        $nfeuCom = $item->prod->uCom;
                        $nfevUnCom = $item->prod->vUnCom;
                        $nfevProd = $item->prod->vProd;
                        $nfecEANTrib = $item->prod->cEANTrib;
                        $nfeuTrib = $item->prod->uTrib;
                        $nfeqTrib = $item->prod->qTrib;
                        $nfevUnTrib = $item->prod->vUnTrib;
                        $nfevDesc = $item->prod->vDesc;

                        if ($nfevDesc == '') {
                            $nfevDesc = 0;
                        }

                        //Trata o Icms
                        $nfeticms = '';
                        $nfeorig = '';
                        $nfeCST = '';
                        $nfemodBC = '';
                        $nfepRedBC = 0;
                        $nfevBC = 0;
                        $nfepICMS = 0;
                        $nfevICMS = 0;
                        $nfemodBCST = '';
                        $nfepMVAST = 0;
                        $nfepRedBCST = 0;
                        $nfevBCST = 0;
                        $nfepICMSST = 0;
                        $nfevICMSST = 0;

                        $nfeorig = $item->imposto->ICMS->ICMS00->orig;
                        //Tipo Icms = 00
                        if ($nfeorig <> '') {
                            $nfeticms = '00';
                            $nfeCST = $item->imposto->ICMS->ICMS00->CST;
                            $nfemodBC = $item->imposto->ICMS->ICMS00->modBC;
                            $nfevBC = $item->imposto->ICMS->ICMS00->vBC;
                            $nfepICMS = $item->imposto->ICMS->ICMS00->pICMS;
                            $nfevICMS = $item->imposto->ICMS->ICMS00->vICMS;
                        } else {
                            $nfeorig = $item->imposto->ICMS->ICMS10->orig;
                            if ($nfeorig <> '') {
                                $nfeticms = '10';
                                $nfeCST = $item->imposto->ICMS->ICMS10->CST;
                                $nfemodBC = $item->imposto->ICMS->ICMS10->modBC;
                                $nfevBC = $item->imposto->ICMS->ICMS10->vBC;
                                $nfepICMS = $item->imposto->ICMS->ICMS10->pICMS;
                                $nfevICMS = $item->imposto->ICMS->ICMS10->vICMS;
                                $nfemodBCST = $item->imposto->ICMS->ICMS10->modBCST;
                                $nfepMVAST = $item->imposto->ICMS->ICMS10->pMVAST;
                                $nfepRedBCST = $item->imposto->ICMS->ICMS10->pRedBCST;
                                $nfevBCST = $item->imposto->ICMS->ICMS10->vBCST;
                                $nfepICMSST = $item->imposto->ICMS->ICMS10->pICMSST;
                                $nfevICMSST = $item->imposto->ICMS->ICMS10->vICMSST;
                            } else {
                                $nfeorig = $item->imposto->ICMS->ICMS20->orig;
                                if ($nfeorig <> '') {
                                    $nfeticms = '20';
                                    $nfeCST = $item->imposto->ICMS->ICMS20->CST;
                                    $nfemodBC = $item->imposto->ICMS->ICMS20->modBC;
                                    $nfepRedBC = $item->imposto->ICMS->ICMS20->pRedBC;
                                    $nfevBC = $item->imposto->ICMS->ICMS20->vBC;
                                    $nfepICMS = $item->imposto->ICMS->ICMS20->pICMS;
                                    $nfevICMS = $item->imposto->ICMS->ICMS20->vICMS;
                                } else {
                                    $nfeorig = $item->imposto->ICMS->ICMS30->orig;
                                    if ($nfeorig <> '') {
                                        $nfeticms = '30';
                                        $nfeCST = $item->imposto->ICMS->ICMS30->CST;
                                        $nfemodBCST = $item->imposto->ICMS->ICMS30->modBCST;
                                        $nfepMVAST = $item->imposto->ICMS->ICMS30->pMVAST;
                                        $nfepRedBCST = $item->imposto->ICMS->ICMS30->pRedBCST;
                                        $nfevBCST = $item->imposto->ICMS->ICMS30->vBCST;
                                        $nfepICMSST = $item->imposto->ICMS->ICMS30->pICMSST;
                                        $nfevICMSST = $item->imposto->ICMS->ICMS30->vICMSST;
                                    } else {
                                        $nfeorig = $item->imposto->ICMS->ICMS40->orig;
                                        if ($nfeorig <> '') {
                                            $nfeticms = '40';
                                            $nfeCST = $item->imposto->ICMS->ICMS40->CST;
                                        } else {
                                            $nfeorig = $item->imposto->ICMS->ICMS51->orig;
                                            if ($nfeorig <> '') {
                                                $nfeticms = '51';
                                                $nfeCST = $item->imposto->ICMS->ICMS51->CST;
                                                $nfemodBC = $item->imposto->ICMS->ICMS51->modBC;
                                                $nfepRedBC = $item->imposto->ICMS->ICMS51->pRedBC;
                                                $nfevBC = $item->imposto->ICMS->ICMS51->vBC;
                                                $nfepICMS = $item->imposto->ICMS->ICMS51->pICMS;
                                                $nfevICMS = $item->imposto->ICMS->ICMS51->vICMS;
                                            } else {
                                                $nfeorig = $item->imposto->ICMS->ICMS60->orig;
                                                if ($nfeorig <> '') {
                                                    $nfeticms = '60';
                                                    $nfeCST = $item->imposto->ICMS->ICMS60->CST;
                                                    $nfevBCST = $item->imposto->ICMS->ICMS60->vBCST;
                                                    $nfevICMSST = $item->imposto->ICMS->ICMS60->vICMSST;
                                                } else {
                                                    $nfeorig = $item->imposto->ICMS->ICMS70->orig;
                                                    if ($nfeorig <> '') {
                                                        $nfeticms = '70';
                                                        $nfeCST = $item->imposto->ICMS->ICMS70->CST;
                                                        $nfemodBC = $item->imposto->ICMS->ICMS70->modBC;
                                                        $nfepRedBC = $item->imposto->ICMS->ICMS70->pRedBC;
                                                        $nfevBC = $item->imposto->ICMS->ICMS70->vBC;
                                                        $nfepICMS = $item->imposto->ICMS->ICMS70->pICMS;
                                                        $nfevICMS = $item->imposto->ICMS->ICMS70->vICMS;
                                                        $nfemodBCST = $item->imposto->ICMS->ICMS70->modBCST;
                                                        $nfepMVAST = $item->imposto->ICMS->ICMS70->pMVAST;
                                                        $nfepRedBCST = $item->imposto->ICMS->ICMS70->pRedBCST;
                                                        $nfevBCST = $item->imposto->ICMS->ICMS70->vBCST;
                                                        $nfepICMSST = $item->imposto->ICMS->ICMS70->pICMSST;
                                                        $nfevICMSST = $item->imposto->ICMS->ICMS70->vICMSST;
                                                    } else {
                                                        $nfeorig = $item->imposto->ICMS->ICMS90->orig;
                                                        if ($nfeorig <> '') {
                                                            $nfeticms = '90';
                                                            $nfeCST = $item->imposto->ICMS->ICMS90->CST;
                                                            $nfemodBC = $item->imposto->ICMS->ICMS90->modBC;
                                                            $nfevBC = $item->imposto->ICMS->ICMS90->vBC;
                                                            $nfepICMS = $item->imposto->ICMS->ICMS90->pICMS;
                                                            $nfevICMS = $item->imposto->ICMS->ICMS90->vICMS;
                                                            $nfemodBCST = $item->imposto->ICMS->ICMS90->modBCST;
                                                            $nfepMVAST = $item->imposto->ICMS->ICMS90->pMVAST;
                                                            $nfepRedBCST = $item->imposto->ICMS->ICMS90->pRedBCST;
                                                            $nfevBCST = $item->imposto->ICMS->ICMS90->vBCST;
                                                            $nfepICMSST = $item->imposto->ICMS->ICMS90->pICMSST;
                                                            $nfevICMSST = $item->imposto->ICMS->ICMS90->vICMSST;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }

                        if ($nfepRedBC == '') {
                            $nfepRedBC = 0;
                        }
                        if ($nfevBC == '') {
                            $nfevBC = 0;
                        }
                        if ($nfepICMS == '') {
                            $nfepICMS = 0;
                        }
                        if ($nfevICMS == '') {
                            $nfevICMS = 0;
                        }
                        if ($nfepMVAST == '') {
                            $nfepMVAST = 0;
                        }
                        if ($nfepRedBCST == '') {
                            $nfepRedBCST = 0;
                        }
                        if ($nfevBCST == '') {
                            $nfevBCST = 0;
                        }
                        if ($nfepICMSST == '') {
                            $nfepICMSST = 0;
                        }
                        if ($nfevICMSST == '') {
                            $nfevICMSST = 0;
                        }

                        $nfeipicEnq = $item->imposto->IPI->cEnq;
                        $nfeipiCST = $item->imposto->IPI->IPITrib->CST;
                        $nfeipivBC = $item->imposto->IPI->IPITrib->vBC;
                        $nfeipipIPI = $item->imposto->IPI->IPITrib->pIPI;
                        $nfeipivIPI = $item->imposto->IPI->IPITrib->vIPI;

                        $nfepisCST = $item->imposto->PIS->PISAliq->CST;
                        $nfepisvBC = $item->imposto->PIS->PISAliq->vBC;
                        $nfepispPIS = $item->imposto->PIS->PISAliq->pPIS;
                        $nfepisvPIS = $item->imposto->PIS->PISAliq->vPIS;

                        $nfecofCST = $item->imposto->COFINS->COFINSAliq->CST;
                        $nfecofvBC = $item->imposto->COFINS->COFINSAliq->vBC;
                        $nfecofpCOFINS = $item->imposto->COFINS->COFINSAliq->pCOFINS;
                        $nfecofvCOFINS = $item->imposto->COFINS->COFINSAliq->vCOFINS;

                        if ($nfeipivBC == '') {
                            $nfeipivBC = 0;
                        }
                        if ($nfeipipIPI == '') {
                            $nfeipipIPI = 0;
                        }
                        if ($nfeipivIPI == '') {
                            $nfeipivIPI = 0;
                        }

                        if ($nfepisvBC == '') {
                            $nfepisvBC = 0;
                        }
                        if ($nfepispPIS == '') {
                            $nfepispPIS = 0;
                        }
                        if ($nfepisvPIS == '') {
                            $nfepisvPIS = 0;
                        }

                        if ($nfecofvBC == '') {
                            $nfecofvBC = 0;
                        }
                        if ($nfecofpCOFINS == '') {
                            $nfecofpCOFINS = 0;
                        }
                        if ($nfecofvCOFINS == '') {
                            $nfecofvCOFINS = 0;
                        }

                        $cadastro->insere("nfeit", "(nfecodigo,procodigo,nfeitquant,
					nfecEAN,
					nfeprod,
					nfexProd,
					nfeNCM,
					nfeEXTIPI,
					nfeCFOP,
					nfeuCom,
					nfevUnCom,
					nfevProd,
					nfecEANTrib,
					nfeuTrib,
					nfeqTrib,
					nfevUnTrib,
					nfeticms,
					nfeorig,
					nfeCST,
					nfemodBC,
					nfepRedBC,
					nfevBC,
					nfepICMS,
					nfevICMS,
					nfemodBCST,
					nfepMVAST,
					nfepRedBCST,
					nfevBCST,
					nfepICMSST,
					nfevICMSST,
					nfeipicEnq,
					nfeipiCST,
					nfeipivBC,
					nfeipipIPI,
					nfeipivIPI,
					nfepisCST,
					nfepisvBC,
					nfepispPIS,
					nfepisvPIS,
					nfecofCST,
					nfecofvBC,
					nfecofpCOFINS,
					nfecofvCOFINS,
					nfevDesc
					)", "
					('$nfecodigo','$procodigo','$qCom',
					'$cEAN',
					'$nfeprod',
					'$nfexProd',
					'$nfeNCM',
					'$nfeEXTIPI',
					'$nfeCFOP',
					'$nfeuCom',
					'$nfevUnCom',
					'$nfevProd',
					'$nfecEANTrib',
					'$nfeuTrib',
					'$nfeqTrib',
					'$nfevUnTrib',
					'$nfeticms',
					'$nfeorig',
					'$nfeCST',
					'$nfemodBC',
					'$nfepRedBC',
					'$nfevBC',
					'$nfepICMS',
					'$nfevICMS',
					'$nfemodBCST',
					'$nfepMVAST',
					'$nfepRedBCST',
					'$nfevBCST',
					'$nfepICMSST',
					'$nfevICMSST',
					'$nfeipicEnq',
					'$nfeipiCST',
					'$nfeipivBC',
					'$nfeipipIPI',
					'$nfeipivIPI',
					'$nfepisCST',
					'$nfepisvBC',
					'$nfepispPIS',
					'$nfepisvPIS',
					'$nfecofCST',
					'$nfecofvBC',
					'$nfecofpCOFINS',
					'$nfecofvCOFINS',
					'$nfevDesc'
					)");
                    }
                }






                $listar1 = $listarx;


                $listar2 = $diretorio . '/' . substr($listar, 0, strlen($listar) - 4) . ".imp";

                //Se ja existir um .imp apaga
                if (file_exists($listar2)) {
                    unlink($listar2);
                }

                rename($listar1, $listar2);
            }

            echo "<meta HTTP-EQUIV='Refresh' CONTENT='5;URL=importanfex.php?parametro=1'>";
            exit;
        }
    }
}

echo "Nenhuma NFe encontrada em /home/delta/nfe - " . date("d/m/Y H:i:s");
;
echo "<meta HTTP-EQUIV='Refresh' CONTENT='5;URL=importanfex.php?parametro=1'>";
exit;
?>

