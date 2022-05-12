<?php

//RECEBE PARÃMETRO
$parametro = trim($_POST["parametro"]);

set_time_limit(0);
ob_implicit_flush(true);

require("verifica2.php");

include_once '../nfephp/bootstrap.php';

require_once("include/conexaobarao.inc.php");
require_once('include/conexao.inc.php');
require_once("include/banco.php");
require('code128.php');

use NFePHP\Extras\Danfe;
use NFePHP\Common\Files\FilesFolders;

//$diretorio = getcwd();
$diretorio = "/home/delta/cte_nfe";
$diretorio_copia = "/home/delta/cte_enviar/";
$diretorio_agrupamento = "/home/delta/cte_agrupa/";

$ponteiro = new RecursiveDirectoryIterator($diretorio);

foreach (new RecursiveIteratorIterator($ponteiro) as $listar) {

    if (substr($listar, strlen($listar) - 2, strlen($listar)) == '\.' || substr($listar, strlen($listar) - 2, strlen($listar)) == '/.') {
        
    } else if (substr($listar, strlen($listar) - 3, strlen($listar)) == '\..' || substr($listar, strlen($listar) - 2, strlen($listar)) == '/..') {
        
    } else {
        if (substr($listar, strlen($listar) - 4, 4) == ".XML" || substr($listar, strlen($listar) - 4, 4) == ".xml" || substr($listar, strlen($listar) - 4, 4) == ".Xml") {

            print " Arquivo: <a href='$listar'>$listar</a><br>";
            //Comeca a Importacao
            $nomeOriginal = $listar->getFilename();

            //Remetente
            $cteremrazao = '';
            $cteremendereco = '';
            $cterembairro = '';
            $cteremnumero = '';
            $cidrem = '';
            $cteremfone = '';
            $cterempais = '';
            $cteremuf = '';
            $cterempessoa = '';
            $cteremcep = '';
            $cteremcnpj = '';
            $cteremie = '';
            $cteremcpf = '';
            $remcodigo = '';
            $cteremrg = '';
            $cteremnguerra = '';
            $cteremcomplemento = '';
            $cteremuf = '';
            $cteremcidcodigo = '';
            $cteremcidcodigoibge = '';

            //Destinatario
            $ctedesrazao = '';
            $ctedesendereco = '';
            $ctedesbairro = '';
            $ctedesnumero = '';
            $ctedessuframa = '';
            $ciddes = '';
            $ctedesfone = '';
            $ctedespais = '';
            $ctedesuf = '';
            $ctedespessoa = '';
            $ctedescep = '';
            $ctedescnpj = '';
            $ctedesie = '';
            $ctedescpf = '';
            $ctedesdoc = '';
            $descodigo = '';
            $ctedesrg = '';
            $ctedesnguerra = '';
            $ctedescomplemento = '';
            $ctedesuf = '';
            $ctedescidcodigo = '';
            $ctedescidcodigoibge = '';

            //Recebedor
            $cterecrazao = '';
            $cterecendereco = '';
            $cterecbairro = '';
            $cterecnumero = '';
            $cidrec = '';
            $cterecfone = '';
            $cterecpais = '';
            $cterecuf = '';
            $cterecpessoa = '';
            $ctereccep = '';
            $ctereccnpj = '';
            $cterecie = '';
            $ctereccpf = '';
            $reccodigo = '';
            $cterecrg = '';
            $cterecnguerra = '';
            $ctereccomplemento = '';
            $cterecuf = '';
            $ctereccidcodigo = '';
            $ctereccidcodigoibge = '';

            //Dados CTe
            $cteufinicio = '';
            $cteuffinal = '';
            $ctecidinicio = '';
            $ctecidfinal = '';
            $ctecfop = '5353';

            $ctecargaval = 0;
            $ctepropredominante = 'BRINQUEDO';

            $ctevolumes = 0;
            $ctepesobruto = 0;
            $ctecubagem = 0;

            $percnfe = 0;
            $cteobsgeral = '';

            $cte_numero = '';

            $listarx = $listar;

            if (file_exists($listarx)) {

                #carrega o arquivo XML e retornando um Array
                $xml = simplexml_load_file($listarx);

                $cadastro = new banco($conn, $db);

                $nfeserie = $xml->NFe->infNFe->ide->serie;
                $serieEmail = $nfeserie;

                $nfenumero = $xml->NFe->infNFe->ide->nNF;
                $numeroEmail = $nfenumero;

                $cteremrazao = $xml->NFe->infNFe->emit->xNome;
                $emiteEmail = $cteremrazao;

                $cteobsgeral = 'CTE GERADO AUTOMATICAMENTE A PARTIR DA NFE ' . $nfenumero . '-' . $nfeserie;

                //So faz o processamento se o XML tiver numero de Nota
                if ($nfenumero != '') {

                    //Monta a Chave 
                    $nfeChave = '';
                    $contador_atributos = 0;
                    foreach ($xml->NFe->infNFe[0]->attributes() as $a => $b) {
                        $contador_atributos++;
                        if ($contador_atributos == 1) {
                            $nfeChave = substr($b, 3);
                        }
                        //echo "$a = $b ";
                    }

                    $chavenfe = $nfeChave;

                    //Se for um XML da Barao vai verificar se o Pedido tem Bonificação,
                    //	caso sim transfere para a pasta de importação de Pedidos Agrupados
                    //	caso não faz a importação unica
                    $cnpj_emitente = $xml->NFe->infNFe->emit->CNPJ;
                    //Número do Pedido
                    $numero_pedido = $xml->NFe->infNFe->compra->xPed;

                    $pedido_agrupado = 0;

                    if ((substr($cnpj_emitente, 0, 8) == '49329873' || substr($cnpj_emitente, 0, 8) == '20548209') && $numero_pedido != '') {

                        $sql_barao = "SELECT * From pedidosagrupados WHERE pvnumero = " . $numero_pedido . " or pedido = " . $numero_pedido;

                        //Verifica se o Pedido Existe na Tabela de Pedidos Arupados da Barão						
                        $sql_barao = pg_query($conn_2, $sql_barao);
                        $row_barao = pg_num_rows($sql_barao);
                        if ($row_barao) {
                            $pedido_agrupado = 1;
                        }

                        //26/09/2017
                        //Verifica se é Bonificação de algum pedido 
                        if ($pedido_agrupado == 0) {

                            $sql_barao = "SELECT pvnumero FROM pvenda WHERE pvnumero = " . $numero_pedido . " AND pvvinculo IS NOT NULL AND pvvinculo > 0 AND pvtipoped = 'F'";

                            //Verifica se o Pedido Existe na Tabela de Pedidos Arupados da Barão						
                            $sql_barao = pg_query($conn_2, $sql_barao);
                            $row_barao = pg_num_rows($sql_barao);
                            if ($row_barao) {
                                $pedido_agrupado = 1;
                            }
                        }

                        //Verifica se é tem algum pedido Bonificação 
                        if ($pedido_agrupado == 0) {

                            $sql_barao = "SELECT pvnumero FROM pvenda WHERE pvvinculo = " . $numero_pedido . " AND pvtipoped = 'F'";

                            //Verifica se o Pedido Existe na Tabela de Pedidos Arupados da Barão						
                            $sql_barao = pg_query($conn_2, $sql_barao);
                            $row_barao = pg_num_rows($sql_barao);
                            if ($row_barao) {
                                $pedido_agrupado = 1;
                            }
                        }
                        //26/09/2017
                    }




                    //Verifica se ja existe algum CTe gerado a partir dessa NFe					
                    $sql = "SELECT * FROM ctenfechave where ctenfenome='$chavenfe'";
                    $sql = pg_query($sql);
                    $row = pg_num_rows($sql);
                    if ($row) {
                        echo "<font color='red'>" . $chavenfe . ' ERRO : JA FOI GERADO UM CTE A PARTIR DESSA NFE!' . "</font><br>";

                        $logdata = date('Y-m-d H:i:s');
                        $sqllog = "Insert into logimportacao (logdata,logemitente,lognfe,logchavenfe,logcte,logchavecte,logstatus,logerro) values ('$logdata','$emiteEmail','$numeroEmail','$chavenfe',null,null,'CTE NAO GERADO','JA GERADO UM CTE A PARTIR DESSA NFE')";
                        pg_query($sqllog);

                        $pedido_agrupado = 0;
                    } else {
                        //Verifica a Modalidade do Frete
                        $nfetramodFrete = $xml->NFe->infNFe->transp->modFrete;
                        if ($nfetramodFrete != 0) {
                            echo "<font color='red'>" . $chavenfe . ' ERRO : FRETE DA NFE DIFERENTE DE CIF!' . "</font><br>";

                            $logdata = date('Y-m-d H:i:s');
                            $sqllog = "Insert into logimportacao (logdata,logemitente,lognfe,logchavenfe,logcte,logchavecte,logstatus,logerro) values ('$logdata','$emiteEmail','$numeroEmail','$chavenfe',null,null,'CTE NAO GERADO','FRETE DA NFE DIFERENTE DE CIF')";
                            pg_query($sqllog);

                            $pedido_agrupado = 0;
                        } else {
                            //Verifica se os Dados da Transportadora estão Completos

                            $deveprosseguir = 0;

                            $cteemitente = '';
                            $cteemitenteuf = '';
                            $cteemitenteibge = '';

                            $sql2 = "Select a.clicnpj,a.cidcodigoibge,b.uf,a.clinguerra,a.clicod,a.clirazao,a.clisuframa,a.clicnpj,a.cliie,a.clirg,a.clicpf,a.cliobs,a.clipessoa
									,a.clicep,a.cliendereco,a.clibairro,a.clifone,a.clicomplemento,a.cliemail,a.clinumero,a.cidcodigo";
                            $sql2 .= " From empresa a Left Join cidades as b on a.cidcodigo = b.cidcodigo";

                            $sql2 = pg_query($sql2);
                            $row2 = pg_num_rows($sql2);
                            if ($row2) {
                                $cteemitente = pg_fetch_result($sql2, 0, "clicnpj");
                                $cteemitenteuf = pg_fetch_result($sql2, 0, "uf");
                                $cteemitenteibge = pg_fetch_result($sql2, 0, "cidcodigoibge");
                            }

                            $cteemitente = soNumero($cteemitente);

                            if ($cteemitente == $xml->NFe->infNFe->transp->transporta->CNPJ) {
                                $deveprosseguir = 1;
                            } else {
                                //Verifica se a Transportadora está Cadastrada, caso sim usa os dados que estão mais Completos
                                if ($xml->NFe->infNFe->transp->transporta->CPF != '') {
                                    $cterecpessoa = '2';
                                    $cnpjcliente = formatar($xml->NFe->infNFe->transp->transporta->CPF);
                                    $sql2 = "Select a.*,b.descricao,b.uf FROM clientes a Left Join cidades as b on a.cidcodigo = b.cidcodigo where a.clicpf='$cnpjcliente'";
                                } else {
                                    $cterecpessoa = '1';
                                    $cnpjcliente = formatar($xml->NFe->infNFe->transp->transporta->CNPJ);
                                    $sql2 = "Select a.*,b.descricao,b.uf FROM clientes a Left Join cidades as b on a.cidcodigo = b.cidcodigo where a.clicnpj='$cnpjcliente'";
                                }

                                $sql2 = pg_query($sql2);
                                $row2 = pg_num_rows($sql2);
                                if ($row2) {
                                    $deveprosseguir = 1;
                                }

                                //Sempre vai prosseguir pois a transportadora passa a ir apenas como Observação
                                $deveprosseguir = 1;
                            }

                            if ($deveprosseguir == 0) {
                                echo "<font color='red'>" . $chavenfe . ' ERRO : DADOS DA TRANSPORTADORA ' . trim($xml->NFe->infNFe->transp->transporta->xNome) . ' INCOMPLETOS!' . "</font><br>";

                                $logdata = date('Y-m-d H:i:s');
                                $sqllog = "Insert into logimportacao (logdata,logemitente,lognfe,logchavenfe,logcte,logchavecte,logstatus,logerro) values ('$logdata','$emiteEmail','$numeroEmail','$chavenfe',null,null,'CTE NAO GERADO','DADOS DA TRANSPORTADORA INCOMPLETOS')";
                                pg_query($sqllog);

                                $pedido_agrupado = 0;
                            } else {

                                if ($pedido_agrupado == 1) {

                                    echo "<font color='red'>" . $chavenfe . ' ERRO : PEDIDO ESTA AGRUPADO, SERA PROCESSADO NA OPCAO AGRUPAMENTO NFE!' . "</font><br>";

                                    $logdata = date('Y-m-d H:i:s');
                                    $sqllog = "Insert into logimportacao (logdata,logemitente,lognfe,logchavenfe,logcte,logchavecte,logstatus,logerro) values ('$logdata','$emiteEmail','$numeroEmail','$chavenfe',null,null,'CTE NAO GERADO','SERA PROCESSADO NA OPCAO AGRUPAMENTO NFE')";
                                    pg_query($sqllog);
                                } else {

                                    //Carrega dados do Remetente							

                                    $cteremrazao = $xml->NFe->infNFe->emit->xNome;
                                    $cteremendereco = $xml->NFe->infNFe->emit->enderEmit->xLgr;
                                    $cterembairro = $xml->NFe->infNFe->emit->enderEmit->xBairro;
                                    $cteremnumero = $xml->NFe->infNFe->emit->enderEmit->nro;
                                    $cidrem = $xml->NFe->infNFe->emit->enderEmit->xMun;
                                    $cteremfone = $xml->NFe->infNFe->emit->enderEmit->fone;


                                    if (strlen(trim($cteremfone)) == 11) {
                                        if (substr(trim($cteremfone), 0, 1) == '0') {
                                            $telefone = formatar(substr(trim($cteremfone), 1), 'fone');
                                        } else {
                                            $telefone = formatar(trim($cteremfone), 'fonenovo');
                                        }
                                    } else if (strlen(trim($cteremfone)) == 8) {
                                        $telefone = formatar('00' . trim($cteremfone), 'fone');
                                    } else if (strlen(trim($cteremfone)) == 12) {
                                        $telefone = formatar(substr(trim($cteremfone), 2), 'fone');
                                    } else if (strlen(trim($cteremfone)) == 0) {
                                        $telefone = '';
                                    } else {
                                        $telefone = formatar(trim($cteremfone), 'fone');
                                    }

                                    $cteremfone = $telefone;

                                    $cterempais = $xml->NFe->infNFe->emit->enderEmit->xPais;
                                    $cteremuf = $xml->NFe->infNFe->emit->enderEmit->UF;
                                    $cteremcnpj = $xml->NFe->infNFe->emit->CNPJ;
                                    $cteremcnpj = formatar(trim($cteremcnpj));
                                    $cteremie = $xml->NFe->infNFe->emit->IE;
                                    $cteremcpf = $xml->NFe->infNFe->emit->CPF;
                                    $cteremcpf = formatar(trim($cteremcpf));
                                    if ($xml->NFe->infNFe->emit->CPF != '') {
                                        $cterempessoa = '2';
                                    } else {
                                        $cterempessoa = '1';
                                    }
                                    $cteremcep = $xml->NFe->infNFe->emit->enderEmit->CEP;
                                    $remcodigo = '1'; //Com Remetente
                                    $cteremrg = '';
                                    $cteremnguerra = $xml->NFe->infNFe->emit->xFant;
                                    $cteremcomplemento = $xml->NFe->infNFe->emit->xCpl;

                                    $cteremcidcodigo = '';
                                    $cteremcidcodigoibge = $xml->NFe->infNFe->emit->enderEmit->cMun;

                                    //Localiza o Codigo Interno da Cidade	
                                    $sql = "SELECT cidcodigo From cidades WHERE descricao = '$cidrem' and uf='$cteremuf'";
                                    $sql = pg_query($sql);
                                    $row = pg_num_rows($sql);
                                    if ($row) {
                                        $cteremcidcodigo = pg_fetch_result($sql, 0, "cidcodigo");
                                    }

                                    //Localiza o Codigo Interno da Tabela IBGE
                                    $ctecidinicio = '';
                                    $cteufinicio = $cteremuf;

                                    $aux1 = substr($cteremcidcodigoibge, 0, 2);
                                    $aux2 = substr($cteremcidcodigoibge, 2, 5);

                                    $sql2 = "Select id ";
                                    $sql2 .= " From cidadesibge";
                                    $sql2 .= " Where codestado = '$aux1' and codcidade = '$aux2'";

                                    $sql2 = pg_query($sql2);
                                    $row2 = pg_num_rows($sql2);
                                    if ($row2) {
                                        $ctecidinicio = pg_fetch_result($sql2, 0, "id");
                                    }


                                    //Carrega dados do Destinatario							
                                    $ctedesrazao = $xml->NFe->infNFe->dest->xNome;
                                    $ctedesendereco = $xml->NFe->infNFe->dest->enderDest->xLgr;
                                    $ctedesbairro = $xml->NFe->infNFe->dest->enderDest->xBairro;
                                    $ctedesnumero = $xml->NFe->infNFe->dest->enderDest->nro;
                                    $ctedessuframa = $xml->NFe->infNFe->dest->ISUF;
                                    $ciddes = $xml->NFe->infNFe->dest->enderDest->xMun;
                                    $ctedesfone = $xml->NFe->infNFe->dest->enderDest->fone;

                                    if (strlen(trim($ctedesfone)) == 11) {
                                        if (substr(trim($ctedesfone), 0, 1) == '0') {
                                            $telefone = formatar(substr(trim($ctedesfone), 1), 'fone');
                                        } else {
                                            $telefone = formatar(trim($ctedesfone), 'fonenovo');
                                        }
                                    } else if (strlen(trim($ctedesfone)) == 8) {
                                        $telefone = formatar('00' . trim($ctedesfone), 'fone');
                                    } else if (strlen(trim($ctedesfone)) == 12) {
                                        $telefone = formatar(substr(trim($ctedesfone), 2), 'fone');
                                    } else if (strlen(trim($ctedesfone)) == 0) {
                                        $telefone = '';
                                    } else {
                                        $telefone = formatar(trim($ctedesfone), 'fone');
                                    }

                                    $ctedesfone = $telefone;


                                    $ctedespais = $xml->NFe->infNFe->dest->enderDest->xPais;
                                    $ctedesuf = $xml->NFe->infNFe->dest->enderDest->UF;
                                    if ($xml->NFe->infNFe->dest->CPF != '') {
                                        $ctedespessoa = '2';
                                    } else {
                                        $ctedespessoa = '1';
                                    }
                                    $ctedescep = $xml->NFe->infNFe->dest->enderDest->CEP;
                                    $ctedescnpj = $xml->NFe->infNFe->dest->CNPJ;
                                    $ctedescnpj = formatar(trim($ctedescnpj));
                                    $ctedesie = $xml->NFe->infNFe->dest->IE;
                                    $ctedescpf = $xml->NFe->infNFe->dest->CPF;
                                    $ctedescpf = formatar(trim($ctedescpf));
                                    $descodigo = '1';
                                    $ctedesrg = '';
                                    $ctedesnguerra = '';
                                    $ctedescomplemento = $xml->NFe->infNFe->dest->enderDest->xCpl;
                                    $ctedesuf = $xml->NFe->infNFe->dest->enderDest->UF;
                                    $ctedescidcodigo = '';
                                    $ctedescidcodigoibge = $xml->NFe->infNFe->dest->enderDest->cMun;

                                    //Localiza o Codigo Interno da Cidade	
                                    $sql = "SELECT cidcodigo From cidades WHERE descricao = '$ciddes' and uf='$ctedesuf'";
                                    $sql = pg_query($sql);
                                    $row = pg_num_rows($sql);
                                    if ($row) {
                                        $ctedescidcodigo = pg_fetch_result($sql, 0, "cidcodigo");
                                    }

                                    //Localiza o Codigo Interno da Tabela IBGE
                                    $ctecidfinal = '';
                                    $cteuffinal = $ctedesuf;

                                    $aux1 = substr($ctedescidcodigoibge, 0, 2);
                                    $aux2 = substr($ctedescidcodigoibge, 2, 5);

                                    $sql2 = "Select id ";
                                    $sql2 .= " From cidadesibge";
                                    $sql2 .= " Where codestado = '$aux1' and codcidade = '$aux2'";

                                    $sql2 = pg_query($sql2);
                                    $row2 = pg_num_rows($sql2);
                                    if ($row2) {
                                        $ctecidfinal = pg_fetch_result($sql2, 0, "id");
                                    }

                                    //Atenção 
                                    //Localiza o CNPJ do Emitente
                                    $cteemitente = '';
                                    $cteemitenteuf = '';

                                    $sql2 = "Select a.clicnpj,b.uf ";
                                    $sql2 .= " From empresa a Left Join cidades as b on a.cidcodigo = b.cidcodigo";

                                    $sql2 = pg_query($sql2);
                                    $row2 = pg_num_rows($sql2);
                                    if ($row2) {
                                        $cteemitente = pg_fetch_result($sql2, 0, "clicnpj");
                                        $cteemitenteuf = pg_fetch_result($sql2, 0, "uf");
                                    }

                                    if ($ctedesuf == $cteemitenteuf) {
                                        $ctecfop = '5353';
                                    } else {
                                        $ctecfop = '6353';
                                    }

                                    //Carrega dados do Recebedor
                                    //Localiza o CNPJ do Emitente
                                    $cteemitente = '';
                                    $cteemitenteuf = '';
                                    $cteemitenteibge = '';

                                    $emipessoa = '';
                                    $emicnpj = '';
                                    $emiie = '';
                                    $emicpf = '';
                                    $emirg = '';
                                    $eminguerra = '';
                                    $emirazao = '';
                                    $emicep = '';
                                    $emiendereco = '';
                                    $eminumero = 0;
                                    $emibairro = '';
                                    $emicomplemento = '';
                                    $emifone = '';
                                    $emipais = '';
                                    $emiuf = '';
                                    $emicidcodigo = 0;
                                    $emicidcodigoibge = '';


                                    $sql2 = "Select a.clicnpj,a.cidcodigoibge,b.uf,a.clinguerra,a.clicod,a.clirazao,a.clisuframa,a.clicnpj,a.cliie,a.clirg,a.clicpf,a.cliobs,a.clipessoa
											,a.clicep,a.cliendereco,a.clibairro,a.clifone,a.clicomplemento,a.cliemail,a.clinumero,a.cidcodigo";
                                    $sql2 .= " From empresa a Left Join cidades as b on a.cidcodigo = b.cidcodigo";

                                    $sql2 = pg_query($sql2);
                                    $row2 = pg_num_rows($sql2);
                                    if ($row2) {
                                        $cteemitente = pg_fetch_result($sql2, 0, "clicnpj");
                                        $cteemitenteuf = pg_fetch_result($sql2, 0, "uf");
                                        $cteemitenteibge = pg_fetch_result($sql2, 0, "cidcodigoibge");

                                        $emipessoa = pg_fetch_result($sql2, 0, "clipessoa");
                                        $emicnpj = pg_fetch_result($sql2, 0, "clicnpj");
                                        $emiie = pg_fetch_result($sql2, 0, "cliie");
                                        $emicpf = pg_fetch_result($sql2, 0, "clicpf");
                                        $emirg = pg_fetch_result($sql2, 0, "clirg");
                                        $eminguerra = pg_fetch_result($sql2, 0, "clinguerra");
                                        $emirazao = pg_fetch_result($sql2, 0, "clirazao");
                                        $emicep = pg_fetch_result($sql2, 0, "clicep");
                                        $emiendereco = pg_fetch_result($sql2, 0, "cliendereco");
                                        $eminumero = pg_fetch_result($sql2, 0, "clinumero");
                                        if ($eminumero == '' || !is_numeric($eminumero)) {
                                            $eminumero = 0;
                                        }
                                        $emibairro = pg_fetch_result($sql2, 0, "clibairro");
                                        $emicomplemento = pg_fetch_result($sql2, 0, "clicomplemento");
                                        $emifone = pg_fetch_result($sql2, 0, "clifone");
                                        $emipais = 'BRASIL';
                                        $emiuf = pg_fetch_result($sql2, 0, "uf");
                                        $emicidcodigo = pg_fetch_result($sql2, 0, "cidcodigo");
                                        if ($emicidcodigo == '') {
                                            $emicidcodigo = 0;
                                        }
                                        $emicidcodigoibge = pg_fetch_result($sql2, 0, "cidcodigoibge");
                                    }

                                    $cteemitente = soNumero($cteemitente);

                                    if ($cteemitente == $xml->NFe->infNFe->transp->transporta->CNPJ) {
                                        $reccodigo = '2';
                                        $cterecpessoa = '1';

                                        //Verifica se tem percentual Cadastrado					
                                        $cnpjcliente = formatar($xml->NFe->infNFe->transp->transporta->CNPJ);
                                        $sql2 = "Select a.*,b.descricao,b.uf FROM clientes a Left Join cidades as b on a.cidcodigo = b.cidcodigo where a.clicnpj='$cnpjcliente'";

                                        $sql2 = pg_query($sql2);
                                        $row2 = pg_num_rows($sql2);
                                        if ($row2) {
                                            $percnfe = pg_fetch_result($sql2, 0, "clinfe");
                                        }
                                    } else {

                                        $reccodigo = '2';

                                        //Verifica se a Transportadora está Cadastrada, caso sim usa os dados que estão mais Completos
                                        if ($xml->NFe->infNFe->transp->transporta->CPF != '') {
                                            $cterecpessoa = '2';
                                            $cnpjcliente = formatar($xml->NFe->infNFe->transp->transporta->CPF);
                                            $sql2 = "Select a.*,b.descricao,b.uf FROM clientes a Left Join cidades as b on a.cidcodigo = b.cidcodigo where a.clicpf='$cnpjcliente'";
                                        } else {
                                            $cterecpessoa = '1';
                                            $cnpjcliente = formatar($xml->NFe->infNFe->transp->transporta->CNPJ);
                                            $sql2 = "Select a.*,b.descricao,b.uf FROM clientes a Left Join cidades as b on a.cidcodigo = b.cidcodigo where a.clicnpj='$cnpjcliente'";
                                        }

                                        $sql2 = pg_query($sql2);
                                        $row2 = pg_num_rows($sql2);
                                        if ($row2) {

                                            /*
                                              $cterecrazao 			= pg_fetch_result($sql2, 0, "clirazao");
                                              $cterecendereco 		= pg_fetch_result($sql2, 0, "cliendereco");
                                              $cterecbairro 			= pg_fetch_result($sql2, 0, "clibairro");
                                              $cterecnumero 			= pg_fetch_result($sql2, 0, "clinumero");
                                              $cidrec 				= pg_fetch_result($sql2, 0, "descricao");
                                              $cterecfone 			= pg_fetch_result($sql2, 0, "clifone");
                                              $cterecpais 			= 'BRASIL';
                                              $ctereccep 				= pg_fetch_result($sql2, 0, "clicep");
                                              $ctereccnpj 			= pg_fetch_result($sql2, 0, "clicnpj");
                                              $cterecie 				= pg_fetch_result($sql2, 0, "cliie");;
                                              $ctereccpf 				= pg_fetch_result($sql2, 0, "clicpf");;
                                              $reccodigo 				= '1';
                                              $cterecrg 				= pg_fetch_result($sql2, 0, "clirg");
                                              $cterecnguerra 			= pg_fetch_result($sql2, 0, "clinguerra");
                                              $ctereccomplemento 		= pg_fetch_result($sql2, 0, "clicomplemento");
                                              $cterecuf 				= pg_fetch_result($sql2, 0, "uf");
                                              $ctereccidcodigo 		= pg_fetch_result($sql2, 0, "cidcodigo");
                                              $ctereccidcodigoibge 	= pg_fetch_result($sql2, 0, "cidcodigoibge");
                                             */

                                            $auxRazao = trim(pg_fetch_result($sql2, 0, "clirazao"));
                                            $cteobsgeral = "Transporte subcontratado com {$auxRazao} {$cnpjcliente}. " . $cteobsgeral;
                                            $percnfe = pg_fetch_result($sql2, 0, "clinfe");
                                        } else {

                                            $auxRazao = trim($xml->NFe->infNFe->transp->transporta->xNome);
                                            $cteobsgeral = "Transporte subcontratado com {$auxRazao} {$cnpjcliente}. " . $cteobsgeral;

                                            /*
                                              $cterecrazao 			= $xml->NFe->infNFe->transp->transporta->xNome;
                                              $cterecendereco 		= $xml->NFe->infNFe->transp->transporta->xEnder;
                                              $cterecbairro 			= '';
                                              $cterecnumero 			= '';
                                              $cidrec 				= $xml->NFe->infNFe->transp->transporta->xMun;
                                              $cterecfone 			= '';
                                              $cterecpais 			= 'BRASIL';
                                              if($xml->NFe->infNFe->dest->CPF!=''){
                                              $cterecpessoa 		= '2';
                                              }
                                              else {
                                              $cterecpessoa 		= '1';
                                              }
                                              $ctereccep 				= '';
                                              $ctereccnpj 			= $xml->NFe->infNFe->transp->transporta->CNPJ;
                                              $cterecie 				= $xml->NFe->infNFe->transp->transporta->IE;
                                              $ctereccpf 				= $xml->NFe->infNFe->transp->transporta->CPF;
                                              $reccodigo 				= '1';
                                              $cterecrg 				= '';
                                              $cterecnguerra 			= '';
                                              $ctereccomplemento 		= '';
                                              $cterecuf 				= $xml->NFe->infNFe->transp->transporta->UF;
                                              $ctereccidcodigo 		= '';

                                              //Localiza o Codigo Interno da Cidade
                                              $sql = "SELECT cidcodigo From cidades WHERE descricao = '$cidrec' and uf='$cterecuf'";
                                              $sql = pg_query($sql);
                                              $row = pg_num_rows($sql);
                                              if($row) {
                                              $ctereccidcodigo = pg_fetch_result($sql, 0, "cidcodigo");
                                              }

                                              //Localiza o Codigo IBGE
                                              $ctereccidcodigoibge 	= '';

                                              $sql2="Select codestado,codcidade ";
                                              $sql2.=" From cidadesibge";
                                              $sql2.=" Where descricao = '$cidrec' and uf = '$cterecuf'";

                                              $sql2 = pg_query($sql2);
                                              $row2 = pg_num_rows($sql2);
                                              if($row2) {
                                              $codestado = pg_fetch_result($sql2, 0, "codestado");
                                              $codcidade = pg_fetch_result($sql2, 0, "codcidade");
                                              $ctereccidcodigoibge = $codestado.$codcidade;
                                              }
                                             */
                                        }
                                    }

                                    $ctecargaval = $ctecargaval + (double) $xml->NFe->infNFe->total->ICMSTot->vNF;
                                    $ctevolumes = $ctevolumes + (int) $xml->NFe->infNFe->transp->vol->qVol;

                                    $ctepesobruto = $ctepesobruto + (double) $xml->NFe->infNFe->transp->vol->pesoB;

                                    //Observacoes
                                    $nfeinfCpl = $xml->NFe->infNFe->infAdic->infCpl;

                                    $posicaoCubagem = strpos($nfeinfCpl, 'Cubagem:');
                                    if ($posicaoCubagem != '') {
                                        $nfecubagem = substr($nfeinfCpl, ($posicaoCubagem + 8), 6);
                                        $nfecubagem = str_replace(",", ".", $nfecubagem);
                                        if (is_numeric($nfecubagem)) {
                                            $nfecubagem = $nfecubagem + 0;
                                        } else {
                                            $nfecubagem = 0;
                                        }
                                    } else {
                                        $nfecubagem = 0;
                                    }

                                    $ctecubagem = $ctecubagem + (double) $nfecubagem;

                                    //Cria o Registro na Tabela CTe com os Dados da Primeira Tela							
                                    $cte_modelo = '57';
                                    $cte_serie = '001';

                                    //Faz a busca do nº MAX do ctenum
                                    $query_num_orcamento2 = $cadastro->seleciona("max(ctenum) as total2", "cte", "1=1");
                                    $array_num_orcamento2 = pg_fetch_object($query_num_orcamento2);

                                    if ($array_num_orcamento2->total2 == "")
                                        $array_num_orcamento2->total2 = 0;
                                    $array_num_orcamento2->total2++;

                                    $cte_numero = delimitador(trim($array_num_orcamento2->total2), '9', 'R', '0');

                                    $cte_emissao = date("Y-m-d H:i");
                                    $cte_hora = date("H:i");
                                    $cte_cfop = $ctecfop;
                                    if ($cte_cfop == '6353') {
                                        $cte_natureza = 'PRESTACAO DE SERVICO DE TRANSPORTE FORA DO ESTADO';
                                    } else {
                                        $cte_natureza = 'PRESTACAO DE SERVICO DE TRANSPORTE';
                                    }

                                    $cte_modal = '1';
                                    $cte_servico = '1';
                                    $cte_finalidade = '1';
                                    $cte_pagto = '2';
                                    $cte_forma = '1';
                                    $cte_chave = '';


                                    $cte_estado = $cteemitenteuf;

                                    $aux_uf = substr($cteemitenteibge, 0, 2);
                                    $aux_cid = substr($cteemitenteibge, 2, 5);

                                    $sql2 = "Select id ";
                                    $sql2 .= " From cidadesibge where codestado='$aux_uf' and codcidade='$aux_cid'";

                                    $sql2 = pg_query($sql2);
                                    $row2 = pg_num_rows($sql2);
                                    $cte_cidade = '';
                                    if ($row2) {
                                        $cte_cidade = pg_fetch_result($sql2, 0, "id");
                                    }


                                    if (trim($ctecidinicio) == "") {
                                        $ctecidinicio = "0";
                                    }
                                    if (trim($cteufinicio) == "") {
                                        $cteufinicio = "0";
                                    }
                                    if (trim($ctecidfinal) == "") {
                                        $ctecidfinal = "0";
                                    }
                                    if (trim($cteuffinal) == "") {
                                        $cteuffinal = "0";
                                    }

                                    $cte_chavefin = '';
                                    $cte_datatomador = "NULL";

                                    //Faz a busca do nº MAX da devolucaon 
                                    $query_num_orcamento = $cadastro->seleciona("max(ctenumero) as total", "cte", "1=1");
                                    $array_num_orcamento = pg_fetch_object($query_num_orcamento);

                                    $cte_max = $array_num_orcamento->total + 1;

                                    $query_orcamento = $cadastro->insere("cte", "(ctenumero,ctemodelo,cteserie,ctenum,cteemissao,ctehorario,ctecfop,ctenatureza,tmocodigo,sercodigo,tctcodigo,tpgcodigo,tfocodigo,ctechaveref,cteufemissao,ctecidemissao,cteufinicio,cteuffinal,ctecidinicio,ctecidfinal,ctechavefin,ctedatatomador,
									cteemipessoa,cteemicnpj,cteemiie,cteemicpf,cteemirg,cteeminguerra,cteemirazao,cteemicep,cteemiendereco,cteeminumero,cteemibairro,cteemicomplemento,cteemifone,cteemipais,cteemiuf,cteemicidcodigo,cteemicidcodigoibge)",
                                            "($cte_max,'$cte_modelo','$cte_serie','$cte_numero','$cte_emissao','$cte_hora','$cte_cfop','$cte_natureza','$cte_modal','$cte_servico','$cte_finalidade','$cte_pagto','$cte_forma','$cte_chave','$cte_estado','$cte_cidade','$cteufinicio','$cteuffinal','$ctecidinicio','$ctecidfinal','$cte_chavefin',$cte_datatomador,
									'$emipessoa','$emicnpj','$emiie','$emicpf','$emirg','$eminguerra','$emirazao','$emicep','$emiendereco','$eminumero','$emibairro','$emicomplemento','$emifone','$emipais','$emiuf','$emicidcodigo','$emicidcodigoibge')");


                                    $sql = "delete FROM ctenfechave where ctenumero=$cte_max";
                                    pg_query($sql);
                                    $cadastro->insere("ctenfechave", "(ctenumero,ctenfenome)", "('$cte_max','$chavenfe')");

                                    if ($ctevolumes > 0 || $ctepesobruto > 0 || $ctecubagem > 0) {
                                        $sql = "delete FROM cteinfocarga where ctenumero=$cte_max";
                                        pg_query($sql);
                                        if ($ctevolumes > 0) {
                                            $cadastro->insere("cteinfocarga", "(ctenumero,medcodigo,cteinfnome,cteinfvalor)", "('$cte_max','4','VOLUME','$ctevolumes')");
                                        }
                                        if ($ctepesobruto > 0) {
                                            $cadastro->insere("cteinfocarga", "(ctenumero,medcodigo,cteinfnome,cteinfvalor)", "('$cte_max','2','PESO BRUTO','$ctepesobruto')");
                                        }
                                        if ($ctecubagem > 0) {
                                            $cadastro->insere("cteinfocarga", "(ctenumero,medcodigo,cteinfnome,cteinfvalor)", "('$cte_max','1','METROS CUBICOS','$ctecubagem')");
                                        }
                                    }

                                    $percicm = 0;
                                    $percint = 0;
                                    $percpob = 0;

                                    //Se a Transportadora nao tem percentual localica o percentual do estado
                                    $sql2 = "SELECT estservico,esticms,estinterna,estpobreza FROM estados";
                                    $sql2 = $sql2 . " WHERE codigo = '$cteuffinal'";
                                    $sql2 = pg_query($sql2);
                                    $row2 = pg_num_rows($sql2);
                                    if ($row2) {
                                        $percicm = pg_fetch_result($sql2, 0, "esticms");
                                        $percint = pg_fetch_result($sql2, 0, "estinterna");
                                        $percpob = pg_fetch_result($sql2, 0, "estpobreza");
                                        if ($percnfe == 0) {
                                            $percnfe = pg_fetch_result($sql2, 0, "estservico");
                                        }
                                    }

                                    if (trim($percicm) == "") {
                                        $percicm = "0";
                                    }
                                    if (trim($percint) == "") {
                                        $percint = "0";
                                    }
                                    if (trim($percpob) == "") {
                                        $percpob = "0";
                                    }

                                    //Pega dados da Parametrização do Seguro

                                    $ctesegnome = '';
                                    $ctesegapolice = '';
                                    $cterntrc = '';

                                    $sql2 = "SELECT parambiente,parversao,parcodigos,ctesegnome,ctesegapolice,cterntrc,cteperservico FROM  parametros";
                                    $sql2 = $sql2 . " WHERE parcod = '1'";

                                    $sql2 = pg_query($sql2);
                                    $row2 = pg_num_rows($sql2);
                                    if ($row2) {
                                        $ctesegnome = pg_fetch_result($sql2, 0, "ctesegnome");
                                        $ctesegapolice = pg_fetch_result($sql2, 0, "ctesegapolice");
                                        $cterntrc = pg_fetch_result($sql2, 0, "cterntrc");
                                        //Se nao tem percentual da Transportadora nem do Estado usa o Padrao
                                        if ($percnfe == 0) {
                                            $percnfe = pg_fetch_result($sql2, 0, "cteperservico");
                                        }
                                    }

                                    $valorservico = 0;

                                    if ($ctecargaval > 0) {

                                        $sql = "delete FROM cteinfoseguro where ctenumero=$cte_max";
                                        pg_query($sql);
                                        $cadastro->insere("cteinfoseguro", "(ctenumero,rescodigo,ctesegvalor,ctesegnome,ctesegapolice,ctesegaverbacao)", "('$cte_max','5','$ctecargaval','$ctesegnome','$ctesegapolice','')");

                                        $valorservico = round($ctecargaval * $percnfe / 100, 2);

                                        //Inclui os Servicos e Valor a Receber
                                        $sql = "delete FROM ctevalorservico where ctenumero=$cte_max";
                                        pg_query($sql);
                                        $cadastro->insere("ctevalorservico", "(ctenumero,ctevalvalor,ctevalnome)", "('$cte_max','$valorservico','TRANSP.PRODUTOS')");
                                    }

                                    $ctepreencheicms = 0;
                                    $ctebaseicms = 0;
                                    $cteperinterna = 0;
                                    $cteperinter = 0;
                                    $cteperpartilha = 0;
                                    $ctevalicmsini = 0;
                                    $ctevalicmsfim = 0;
                                    $cteperpobreza = 0;
                                    $ctevalpobreza = 0;

                                    //Se tiver valor de Servico calcula os Impostos
                                    if ($valorservico != 0) {
                                        $ctereceber = $valorservico;
                                        $ctetributos = round($valorservico * $percicm / 100, 2);
                                        $sitcodigo = 1;
                                        $cteperreducao = 0;
                                        $ctebasecalculo = $valorservico;
                                        $ctepericms = $percicm;
                                        $ctevalicms = round($valorservico * $percicm / 100, 2);
                                        $ctecredito = 0;

                                        //Se for uma operacao Interestadual carrega dados da Partilha
                                        if ($cteemitenteuf != $cteuffinal) {

                                            $ctepreencheicms = 1;
                                            $ctebaseicms = $valorservico;
                                            $cteperinterna = $percint;
                                            $cteperinter = $percicm;

                                            $percdif = $percint - $percicm;
                                            $valdif = round($valorservico * $percdif / 100, 2);

                                            if (date('Y') == 2016) {
                                                $cteperpartilha = 1;
                                                $ctevalicmsini = round($valdif * 60 / 100, 2);
                                                $ctevalicmsfim = round($valdif * 40 / 100, 2);
                                            } else if (date('Y') == 2017) {
                                                $cteperpartilha = 2;
                                                $ctevalicmsini = round($valdif * 40 / 100, 2);
                                                $ctevalicmsfim = round($valdif * 60 / 100, 2);
                                            } else if (date('Y') == 2018) {
                                                $cteperpartilha = 3;
                                                $ctevalicmsini = round($valdif * 20 / 100, 2);
                                                $ctevalicmsfim = round($valdif * 80 / 100, 2);
                                            } else {
                                                $cteperpartilha = 4;
                                                $ctevalicmsini = round($valdif * 0 / 100, 2);
                                                $ctevalicmsfim = round($valdif * 100 / 100, 2);
                                            }
                                            $cteperpobreza = $percpob;
                                            $ctevalpobreza = round($valorservico * $percpob / 100, 2);
                                        }
                                    } else {
                                        $ctereceber = 0;
                                        $ctetributos = 0;
                                        $sitcodigo = 1;
                                        $cteperreducao = 0;
                                        $ctebasecalculo = 0;
                                        $ctepericms = 0;
                                        $ctevalicms = 0;
                                        $ctecredito = 0;
                                    }

                                    if (trim($cteremnumero) == "" || !is_numeric(trim($cteremnumero))) {
                                        $cteremnumero = 0;
                                    }
                                    if (trim($remcodigo) == "") {
                                        $remcodigo = "0";
                                    }
                                    if (trim($cteremcidcodigo) == "") {
                                        $cteremcidcodigo = "0";
                                    }
                                    if (trim($cteremcidcodigoibge) == "") {
                                        $cteremcidcodigoibge = "0";
                                    }


                                    if (trim($ctedesnumero) == "" || !is_numeric(trim($ctedesnumero))) {
                                        $ctedesnumero = 0;
                                    }
                                    if (trim($descodigo) == "") {
                                        $descodigo = "0";
                                    }
                                    if (trim($ctedescidcodigo) == "") {
                                        $ctedescidcodigo = "0";
                                    }
                                    if (trim($ctedescidcodigoibge) == "") {
                                        $ctedescidcodigoibge = "0";
                                    }

                                    if (trim($cterecnumero) == "" || !is_numeric(trim($cterecnumero))) {
                                        $cterecnumero = 0;
                                    }
                                    if (trim($reccodigo) == "") {
                                        $reccodigo = "0";
                                    }
                                    if (trim($ctereccidcodigo) == "") {
                                        $ctereccidcodigo = "0";
                                    }
                                    if (trim($ctereccidcodigoibge) == "") {
                                        $ctereccidcodigoibge = "0";
                                    }

                                    if (trim($ctecidinicio) == "") {
                                        $ctecidinicio = "0";
                                    }
                                    if (trim($cteufinicio) == "") {
                                        $cteufinicio = "0";
                                    }
                                    if (trim($ctecidfinal) == "") {
                                        $ctecidfinal = "0";
                                    }
                                    if (trim($cteuffinal) == "") {
                                        $cteuffinal = "0";
                                    }

                                    if (trim($ctecargaval) == "") {
                                        $ctecargaval = "0";
                                    }
                                    if (trim($cterntrc) == "") {
                                        $cterntrc = "0";
                                    }

                                    //Sugere a data de Previsão de Entrega a 3 dias para SP e 5 dias para fora de SP
                                    $liberareal = date("d/m/Y");

                                    $sql = "Select * from cidadesfrete Where cidcodigo = '$ctecidfinal'";
                                    $sql = pg_query($sql);
                                    $row = pg_num_rows($sql);
                                    if ($row) {
                                        $prazodias = pg_fetch_result($sql, 0, "prazo");
                                    } else {
                                        if ($cteemitenteuf == $cteuffinal) {
                                            $prazodias = 3;
                                        } else {
                                            $prazodias = 5;
                                        }
                                    }

                                    for ($xi = 0; $xi < $prazodias; $xi++) {

                                        //Soma 1 dia na data do Conhecimento
                                        $datax = explode("/", $liberareal);
                                        $newData = date("d/m/Y", mktime(0, 0, 0, $datax[1] + 0, $datax[0] + 1, $datax[2] + 0));
                                        $liberareal = substr($newData, 0, 2) . '/' . substr($newData, 3, 2) . '/' . substr($newData, 6, 4);

                                        //Verifica se a data é sábado 					
                                        $pdianu = mktime(0, 0, 0, substr($liberareal, 3, 2), substr($liberareal, 0, 2), substr($liberareal, 6, 4));
                                        $dialet = date('D', $pdianu); //escolhe pelo dia da semana
                                        switch ($dialet) {//verifica que dia cai
                                            case "Sun": $branco = 0;
                                                break;
                                            case "Mon": $branco = 1;
                                                break;
                                            case "Tue": $branco = 2;
                                                break;
                                            case "Wed": $branco = 3;
                                                break;
                                            case "Thu": $branco = 4;
                                                break;
                                            case "Fri": $branco = 5;
                                                break;
                                            case "Sat": $branco = 6;
                                                break;
                                        }

                                        //Se for domingo soma 1 dia
                                        if ($branco == 0) {
                                            $datax = explode("/", $liberareal);
                                            $newData = date("d/m/Y", mktime(0, 0, 0, $datax[1] + 0, $datax[0] + 1, $datax[2] + 0));
                                            $liberareal = substr($newData, 0, 2) . '/' . substr($newData, 3, 2) . '/' . substr($newData, 6, 4);
                                        } else if ($branco == 6) {
                                            $datax = explode("/", $liberareal);
                                            $newData = date("d/m/Y", mktime(0, 0, 0, $datax[1] + 0, $datax[0] + 2, $datax[2] + 0));
                                            $liberareal = substr($newData, 0, 2) . '/' . substr($newData, 3, 2) . '/' . substr($newData, 6, 4);
                                        } else {
                                            $datax = explode("/", $liberareal);
                                            $newData = date("d/m/Y", mktime(0, 0, 0, $datax[1] + 0, $datax[0], $datax[2] + 0));
                                            $liberareal = substr($newData, 0, 2) . '/' . substr($newData, 3, 2) . '/' . substr($newData, 6, 4);
                                        }

                                        //echo $liberareal.' '.$xi.'<br>';

                                        /*
                                          //Verifica Feriados
                                          $nfx=substr($liberareal,6,4).'-'.substr($liberareal,3,2).'-'.substr($liberareal,0,2);

                                          $sqlfer = "SELECT * FROM feriado b Where b.ferdata = '$nfx' and (b.fertipo='1' or (b.fertipo='2' and b.uf='$estado') or (b.fertipo='3' and b.cidcodigo='$codibge') )";

                                          $sqlfer = pg_query($sqlfer);
                                          $rowfer = pg_num_rows($sqlfer);
                                          if($rowfer) {
                                          $fertipo = pg_fetch_result($sqlfer, 0, "fertipo");
                                          $proc = 1;
                                          if($proc==1){

                                          $datax = explode("/", $liberareal);
                                          $newData = date("d/m/Y", mktime(0, 0, 0, $datax[1] + 0,$datax[0] + 1, $datax[2] + 0) );
                                          $liberareal=substr($newData,0,2).'/'.substr($newData,3,2).'/'.substr($newData,6,4);

                                          //Se o dia seguinte cair num sabado ou domingo
                                          $pdianu = mktime(0,0,0,substr($liberareal,3,2),substr($liberareal,0,2),substr($liberareal,6,4));
                                          $dialet = date('D', $pdianu);//escolhe pelo dia da semana
                                          switch($dialet){//verifica que dia cai
                                          case "Sun": $branco = 0; break;
                                          case "Mon": $branco = 1; break;
                                          case "Tue": $branco = 2; break;
                                          case "Wed": $branco = 3; break;
                                          case "Thu": $branco = 4; break;
                                          case "Fri": $branco = 5; break;
                                          case "Sat": $branco = 6; break;
                                          }

                                          //Se for domingo soma 1 dia
                                          if($branco==0){
                                          $datax = explode("/", $liberareal);
                                          $newData = date("d/m/Y", mktime(0, 0, 0, $datax[1] + 0,$datax[0] + 1, $datax[2] + 0) );
                                          $liberareal=substr($newData,0,2).'/'.substr($newData,3,2).'/'.substr($newData,6,4);
                                          }
                                          else if($branco==6){
                                          $datax = explode("/", $liberareal);
                                          $newData = date("d/m/Y", mktime(0, 0, 0, $datax[1] + 0,$datax[0] + 2, $datax[2] + 0) );
                                          $liberareal=substr($newData,0,2).'/'.substr($newData,3,2).'/'.substr($newData,6,4);
                                          }

                                          //Verifica mais um Feriado para o Caso de dois Feriados na sequencia
                                          $nfx=substr($liberareal,6,4).'-'.substr($liberareal,3,2).'-'.substr($liberareal,0,2);

                                          $sqlfer = "SELECT * FROM feriado b Where b.ferdata = '$nfx' and (b.fertipo='1' or (b.fertipo='2' and b.uf='$estado') or (b.fertipo='3' and b.cidcodigo='$codibge') )";
                                          $sqlfer = pg_query($sqlfer);
                                          $rowfer = pg_num_rows($sqlfer);
                                          if($rowfer) {
                                          $fertipo = pg_fetch_result($sqlfer, 0, "fertipo");
                                          $proc = 1;
                                          if($proc==1){
                                          $datax = explode("/", $liberareal);
                                          $newData = date("d/m/Y", mktime(0, 0, 0, $datax[1] + 0,$datax[0] + 1, $datax[2] + 0) );
                                          $liberareal=substr($newData,0,2).'/'.substr($newData,3,2).'/'.substr($newData,6,4);

                                          //Se o dia seguinte cair num sabado ou domingo
                                          $pdianu = mktime(0,0,0,substr($liberareal,3,2),substr($liberareal,0,2),substr($liberareal,6,4));
                                          $dialet = date('D', $pdianu);//escolhe pelo dia da semana
                                          switch($dialet){//verifica que dia cai
                                          case "Sun": $branco = 0; break;
                                          case "Mon": $branco = 1; break;
                                          case "Tue": $branco = 2; break;
                                          case "Wed": $branco = 3; break;
                                          case "Thu": $branco = 4; break;
                                          case "Fri": $branco = 5; break;
                                          case "Sat": $branco = 6; break;
                                          }

                                          //Se for domingo soma 1 dia
                                          if($branco==0){
                                          $datax = explode("/", $liberareal);
                                          $newData = date("d/m/Y", mktime(0, 0, 0, $datax[1] + 0,$datax[0] + 1, $datax[2] + 0) );
                                          $liberareal=substr($newData,0,2).'/'.substr($newData,3,2).'/'.substr($newData,6,4);
                                          }
                                          else if($branco==6){
                                          $datax = explode("/", $liberareal);
                                          $newData = date("d/m/Y", mktime(0, 0, 0, $datax[1] + 0,$datax[0] + 2, $datax[2] + 0) );
                                          $liberareal=substr($newData,0,2).'/'.substr($newData,3,2).'/'.substr($newData,6,4);
                                          }

                                          }
                                          }
                                          }
                                          }
                                         */
                                    }

                                    $cteentrega = $liberareal;
                                    $cteentrega = substr($cteentrega, 6, 4) . '-' . substr($cteentrega, 3, 2) . '-' . substr($cteentrega, 0, 2);

                                    $cteindlocacao = 2;
                                    $tpgcodigo = 2;

                                    //Atualiza os outros Campos na Tabela CTe

                                    $cadastro->altera("cte", "
									tomcodigo='1',
									ctetompessoa='1',
									ctetomcnpj='',
									ctetomie='',
									ctetomcpf='',
									ctetomrg='',
									ctetomnguerra='',
									ctetomrazao='',
									ctetomcep='',
									ctetomendereco='',
									ctetomnumero='0',
									ctetombairro='',
									ctetomcomplemento='',
									ctetomfone='',
									ctetompais='BRASIL',
									ctetomuf='',
									ctetomcidcodigo='0',
									ctetomcidcodigoibge='0',
									remcodigo='$remcodigo',
									cterempessoa='$cterempessoa',
									cteremcnpj='$cteremcnpj',
									cteremie='$cteremie',
									cteremcpf='$cteremcpf',
									cteremrg='$cteremrg',
									cteremnguerra='$cteremnguerra',
									cteremrazao='$cteremrazao',
									cteremcep='$cteremcep',
									cteremendereco='$cteremendereco',
									cteremnumero='$cteremnumero',
									cterembairro='$cterembairro',
									cteremcomplemento='$cteremcomplemento',
									cteremfone='$cteremfone',
									cterempais='$cterempais',
									cteremuf='$cteremuf',
									cteremcidcodigo='$cteremcidcodigo',
									cteremcidcodigoibge='$cteremcidcodigoibge',
									expcodigo='2',
									cteexppessoa='1',
									cteexpcnpj='',
									cteexpie='',
									cteexpcpf='',
									cteexprg='',
									cteexpnguerra='',
									cteexprazao='',
									cteexpcep='',
									cteexpendereco='',
									cteexpnumero='0',
									cteexpbairro='',
									cteexpcomplemento='',
									cteexpfone='',
									cteexppais='BRASIL',
									cteexpuf='',
									cteexpcidcodigo='0',
									cteexpcidcodigoibge='0',
									reccodigo='$reccodigo',
									cterecpessoa='$cterecpessoa',
									ctereccnpj='$ctereccnpj',
									cterecie='$cterecie',
									ctereccpf='$ctereccpf',
									cterecrg='$cterecrg',
									cterecnguerra='$cterecnguerra',
									cterecrazao='$cterecrazao',
									ctereccep='$ctereccep',
									cterecendereco='$cterecendereco',
									cterecnumero='$cterecnumero',
									cterecbairro='$cterecbairro',
									ctereccomplemento='$ctereccomplemento',
									cterecfone='$cterecfone',
									cterecpais='$cterecpais',
									cterecuf='$cterecuf',
									ctereccidcodigo='$ctereccidcodigo',
									ctereccidcodigoibge='$ctereccidcodigoibge',
									descodigo='$descodigo',
									ctedespessoa='$ctedespessoa',
									ctedescnpj='$ctedescnpj',
									ctedesie='$ctedesie',
									ctedescpf='$ctedescpf',
									ctedesrg='$ctedesrg',
									ctedesnguerra='$ctedesnguerra',
									ctedesrazao='$ctedesrazao',
									ctedescep='$ctedescep',
									ctedesendereco='$ctedesendereco',
									ctedesnumero='$ctedesnumero',
									ctedessuframa='$ctedessuframa',
									ctedesbairro='$ctedesbairro',
									ctedescomplemento='$ctedescomplemento',
									ctedesfone='$ctedesfone',
									ctedespais='$ctedespais',
									ctedesuf='$ctedesuf',
									ctedescidcodigo='$ctedescidcodigo',
									ctedescidcodigoibge='$ctedescidcodigoibge',
									cteservicos='$valorservico',
									ctereceber='$ctereceber',
									ctetributos='$ctetributos',
									sitcodigo='$sitcodigo',
									cteperreducao='$cteperreducao',
									ctebasecalculo='$ctebasecalculo',
									ctepericms='$ctepericms',
									ctevalicms='$ctevalicms',
									ctecredito='$ctecredito',
									ctepreencheicms='$ctepreencheicms',
									ctebaseicms='$ctebaseicms',
									cteperinterna='$cteperinterna',
									cteperinter='$cteperinter',
									cteperpartilha='$cteperpartilha',
									ctevalicmsini='$ctevalicmsini',
									ctevalicmsfim='$ctevalicmsfim',
									cteperpobreza='$cteperpobreza',
									ctevalpobreza='$ctevalpobreza',
									cteadcfisco='',
									ctecargaval='$ctecargaval',
									ctepropredominante='$ctepropredominante',
									cteoutcaracteristica='',
									ctecobrancanum='',
									ctecobrancaval='0',
									ctecobrancades='0',
									ctecobrancaliq='0',
									cterntrc='$cterntrc',
									cteentrega='$cteentrega',
									cteindlocacao='$cteindlocacao',
									cteciot='',
									cteobsgeral='$cteobsgeral',
									ctesubstipo='0',
									ctesubschave=''"
                                            , "ctenumero='$cte_max'");



                                    //Gera o XML do CTe
                                    geraCteXml($cte_max, $chavenfe, $numeroEmail, $emiteEmail);
                                }
                            }
                        }
                    }
                }


                $listar1 = $listarx;

                //$copia = $diretorio_copia . $nomeOriginal;		

                if ($pedido_agrupado == 1) {

                    $destino = $diretorio_agrupamento;

                    if (!is_dir($destino)) {
                        mkdir($destino, 0755);
                    }
                } else {

                    if ($cte_numero == '') {
                        $cte_numero = 'nao_importado';
                    }

                    $destino = $diretorio_copia . $cte_numero . '/';

                    if (!is_dir($destino)) {
                        mkdir($destino, 0755);
                    }
                }

                //$copia = $diretorio_copia . 'NFe' . $chavenfe . '.xml';
                $copia = $destino . 'NFe' . $chavenfe . '.xml';

                if (file_exists($copia)) {
                    unlink($copia);
                }
                copy($listar1, $copia);


                //$copia2 = $diretorio_copia . 'NFe' . $chavenfe . '.pdf';				
                $copia2 = $destino . 'NFe' . $chavenfe . '.pdf';
                if (file_exists($copia2)) {
                    unlink($copia2);
                }

                $listar2 = substr($listar, 0, strlen($listar) - 4) . ".imp";
                if ($listar2 != $listar) {
                    //Se ja existir um .imp apaga
                    if (file_exists($listar2)) {
                        unlink($listar2);
                    }
                    rename($listar1, $listar2);
                }

                if ($cte_numero != '') {
                    //Gera o PDF da NFe
                    exibe_danfe($copia, $cte_numero);
                }
            }

            //Isso nao deveria ter pois volta pro Loopoing		
            echo "<meta HTTP-EQUIV='Refresh' CONTENT='2;URL=importageranfexml.php?parametro=1'>";
            exit;
        }
    }
}

echo "Nenhuma NFe encontrada em /home/delta/cte_nfe - " . date("d/m/Y H:i:s");
;
echo "<meta HTTP-EQUIV='Refresh' CONTENT='2;URL=importageranfexml.php?parametro=1'>";
exit;

function soNumero($str) {
    return preg_replace("/[^0-9]/", "", $str);
}

function formatar($string, $tipo = "") {
    $string = preg_replace("[^0-9]", "", $string);
    if (!$tipo) {
        switch (strlen($string)) {
            case 10: $tipo = 'fone';
                break;
            case 8: $tipo = 'cep';
                break;
            case 11: $tipo = 'cpf';
                break;
            case 14: $tipo = 'cnpj';
                break;
        }
    }
    switch ($tipo) {
        case 'fone':
            $string = '(' . substr($string, 0, 2) . ') ' . substr($string, 2, 4) .
                    '-' . substr($string, 6);
            break;
        case 'cep':
            $string = substr($string, 0, 5) . '-' . substr($string, 5, 3);
            break;
        case 'cpf':
            $string = substr($string, 0, 3) . '.' . substr($string, 3, 3) .
                    '.' . substr($string, 6, 3) . '-' . substr($string, 9, 2);
            break;
        case 'cnpj':
            $string = substr($string, 0, 2) . '.' . substr($string, 2, 3) .
                    '.' . substr($string, 5, 3) . '/' .
                    substr($string, 8, 4) . '-' . substr($string, 12, 2);
            break;
        case 'rg':
            $string = substr($string, 0, 2) . '.' . substr($string, 2, 3) .
                    '.' . substr($string, 5, 3);
            break;
    }
    return $string;
}

function delimitador($variavel, $tamanho, $alinhamento, $preenchimento) {
    if ($tamanho < 10 && $alinhamento == 'R' && $preenchimento == '0')
        $strtam = "%0" . $tamanho . "s";
    else if ($tamanho < 10 && $alinhamento == 'L' && $preenchimento == '0')
        $strtam = "%-0" . $tamanho . "s";
    else if ($tamanho < 10 && $alinhamento == 'R' && $preenchimento == ' ')
        $strtam = "%" . $tamanho . "s";
    else if ($tamanho < 10 && $alinhamento == 'L' && $preenchimento == ' ')
        $strtam = "%-" . $tamanho . "s";

    if ($tamanho >= 10 && $alinhamento == 'R' && $preenchimento == '0')
        $strtam = "%0" . $tamanho . "s";
    else if ($tamanho >= 10 && $alinhamento == 'L' && $preenchimento == '0')
        $strtam = "%-0" . $tamanho . "s";
    else if ($tamanho >= 10 && $alinhamento == 'R' && $preenchimento == ' ')
        $strtam = "%" . $tamanho . "s";
    else if ($tamanho >= 10 && $alinhamento == 'L' && $preenchimento == ' ')
        $strtam = "%-" . $tamanho . "s";

    $var = substr(sprintf($strtam, $variavel), 0, $tamanho);
    return $var;
}

function geraCteXml($parametro, $chavenfe, $numeroEmail, $emiteEmail) {

    $chaveCte = '';
    $erroCte = '';

    $sql = "Select a.*,to_char(a.cteemissao, 'DD/MM/YYYY') as cteemissao1,b.tmonome,c.sernome,d.tomnome,e.tfonome,f.tctnome,g.descricao as cidinicio,";
    $sql .= "h.descricao as cidfinal,i.descricao as cidrem,j.descricao as ciddes,k.descricao as cidexp,l.descricao as cidrec,m.descricao as cidtom,";
    $sql .= "n.sitnome,cteperreducao,ctebasecalculo,ctepericms,ctevalicms,cteobsgeral,o.topnome,to_char(a.cteentrega, 'DD/MM/YYYY') as cteentrega1,p.descricao as cidemi,";

    $sql .= "aa.codestado,aa.codcidade,aa.descricao as cid1,aa.uf as uf1,";

    $sql .= "g.codestado as codestado2,g.codcidade as codcidade2,g.descricao as cid2,g.uf as uf2,";

    $sql .= "h.codestado as codestado3,h.codcidade as codcidade3,h.descricao as cid3,h.uf as uf3";

    $sql .= " from cte a ";

    $sql .= " left join cidadesibge aa on aa.id = a.ctecidemissao";

    $sql .= " left join tipomodal b on b.tmocodigo = a.tmocodigo";
    $sql .= " left join tiposervico c on c.sercodigo = a.sercodigo";
    $sql .= " left join tipotomador d on d.tomcodigo = a.tomcodigo";
    $sql .= " left join tipoforma e on e.tfocodigo = a.tfocodigo";
    $sql .= " left join tipocte f on f.tctcodigo = a.tctcodigo";
    $sql .= " left join cidadesibge g on g.id = a.ctecidinicio";
    $sql .= " left join cidadesibge h on h.id = a.ctecidfinal";
    $sql .= " left join cidades i on i.cidcodigo = a.cteremcidcodigo";
    $sql .= " left join cidades j on j.cidcodigo = a.ctedescidcodigo";

    $sql .= " left join cidades k on k.cidcodigo = a.cteexpcidcodigo";
    $sql .= " left join cidades l on l.cidcodigo = a.ctereccidcodigo";
    $sql .= " left join cidades m on m.cidcodigo = a.ctetomcidcodigo";

    $sql .= " left join tiposituacao n on n.sitcodigo = a.sitcodigo";

    $sql .= " left join tipoopcao o on o.topcodigo = a.cteindlocacao";

    $sql .= " left join cidades p on p.cidcodigo = a.cteemicidcodigo";

    $sql .= " Where a.ctenumero = '$parametro'";

    //$nome = "/home/delta/cte_nfe_enviar/cte" . date("YmdHis") . ".tmp";
    $nome = "/home/delta/cte/cte" . date("YmdHis") . ".tmp";
    if (file_exists($nome)) {
        unlink($nome);
    }
    $arquivo = fopen("$nome", "x+");

    $sql = pg_query($sql);
    $row = pg_num_rows($sql);

    if ($row) {

        $ctenumero = trim(pg_fetch_result($sql, 0, "ctenumero"));
        $ctemodelo = trim(pg_fetch_result($sql, 0, "ctemodelo"));
        $cteserie = trim(pg_fetch_result($sql, 0, "cteserie"));
        $ctenum = trim(pg_fetch_result($sql, 0, "ctenum"));
        $cteemissao = trim(pg_fetch_result($sql, 0, "cteemissao"));
        $ctehorario = trim(pg_fetch_result($sql, 0, "ctehorario"));
        $tmonome = trim(pg_fetch_result($sql, 0, "tmonome"));
        $tmocodigo = trim(pg_fetch_result($sql, 0, "tmocodigo"));
        $sernome = trim(pg_fetch_result($sql, 0, "sernome"));
        $ctechaveref = trim(pg_fetch_result($sql, 0, "ctechaveref"));
        $ctechavefin = trim(pg_fetch_result($sql, 0, "ctechavefin"));
        $datatomador = trim(pg_fetch_result($sql, 0, "ctedatatomador"));
        $tomnome = trim(pg_fetch_result($sql, 0, "tomnome"));
        $tfonome = trim(pg_fetch_result($sql, 0, "tfonome"));
        $ctecfop = trim(pg_fetch_result($sql, 0, "ctecfop"));
        $ctenatureza = trim(pg_fetch_result($sql, 0, "ctenatureza"));
        $tctcodigo = trim(pg_fetch_result($sql, 0, "tctcodigo"));
        $tctnome = trim(pg_fetch_result($sql, 0, "tctnome"));
        $cidinicio = trim(pg_fetch_result($sql, 0, "cidinicio"));
        $cteufinicio = trim(pg_fetch_result($sql, 0, "cteufinicio"));
        $cidfinal = trim(pg_fetch_result($sql, 0, "cidfinal"));
        $cteuffinal = trim(pg_fetch_result($sql, 0, "cteuffinal"));

        $remcodigo = trim(pg_fetch_result($sql, 0, "remcodigo"));
        $cteremrazao = trim(pg_fetch_result($sql, 0, "cteremrazao"));
        $cteremendereco = trim(pg_fetch_result($sql, 0, "cteremendereco"));
        $cterembairro = trim(pg_fetch_result($sql, 0, "cterembairro"));
        $cteremnumero = trim(pg_fetch_result($sql, 0, "cteremnumero"));
        $cidrem = trim(pg_fetch_result($sql, 0, "cidrem"));
        $cteremfone = trim(pg_fetch_result($sql, 0, "cteremfone"));
        $cterempais = trim(pg_fetch_result($sql, 0, "cterempais"));
        $cteremuf = trim(pg_fetch_result($sql, 0, "cteremuf"));

        $cterempessoa = trim(pg_fetch_result($sql, 0, "cterempessoa"));
        $cteremcep = trim(pg_fetch_result($sql, 0, "cteremcep"));
        $cteremcnpj = trim(pg_fetch_result($sql, 0, "cteremcnpj"));
        $cteremie = trim(pg_fetch_result($sql, 0, "cteremie"));
        $cteremcpf = trim(pg_fetch_result($sql, 0, "cteremcpf"));
        $cteremcidcodigoibge = trim(pg_fetch_result($sql, 0, "cteremcidcodigoibge"));

        if ($cterempessoa == '1') {
            $cteremdoc = $cteremcnpj;
        } else {
            $cteremdoc = $cteremcpf;
        }

        $descodigo = trim(pg_fetch_result($sql, 0, "descodigo"));
        $ctedesrazao = trim(pg_fetch_result($sql, 0, "ctedesrazao"));
        $ctedesendereco = trim(pg_fetch_result($sql, 0, "ctedesendereco"));
        $ctedescomplemento = trim(pg_fetch_result($sql, 0, "ctedescomplemento"));
        $ctedesbairro = trim(pg_fetch_result($sql, 0, "ctedesbairro"));
        $ctedesnumero = trim(pg_fetch_result($sql, 0, "ctedesnumero"));
        $ctedessuframa = trim(pg_fetch_result($sql, 0, "ctedessuframa"));
        $ciddes = trim(pg_fetch_result($sql, 0, "ciddes"));
        $ctedesfone = trim(pg_fetch_result($sql, 0, "ctedesfone"));
        $ctedespais = trim(pg_fetch_result($sql, 0, "ctedespais"));
        $ctedesuf = trim(pg_fetch_result($sql, 0, "ctedesuf"));

        $ctedespessoa = trim(pg_fetch_result($sql, 0, "ctedespessoa"));
        $ctedescep = trim(pg_fetch_result($sql, 0, "ctedescep"));
        $ctedescnpj = trim(pg_fetch_result($sql, 0, "ctedescnpj"));
        $ctedesie = trim(pg_fetch_result($sql, 0, "ctedesie"));
        $ctedescpf = trim(pg_fetch_result($sql, 0, "ctedescpf"));

        if ($ctedespessoa == '1') {
            $ctedesdoc = $ctedescnpj;
        } else {
            $ctedesdoc = $ctedescpf;
        }

        $expcodigo = trim(pg_fetch_result($sql, 0, "expcodigo"));
        $cteexprazao = trim(pg_fetch_result($sql, 0, "cteexprazao"));
        $cteexpendereco = trim(pg_fetch_result($sql, 0, "cteexpendereco"));
        $cteexpcomplemento = trim(pg_fetch_result($sql, 0, "cteexpcomplemento"));
        $cteexpbairro = trim(pg_fetch_result($sql, 0, "cteexpbairro"));
        $cteexpnumero = trim(pg_fetch_result($sql, 0, "cteexpnumero"));
        $cidexp = trim(pg_fetch_result($sql, 0, "cidexp"));
        $cteexpfone = trim(pg_fetch_result($sql, 0, "cteexpfone"));
        $cteexppais = trim(pg_fetch_result($sql, 0, "cteexppais"));
        $cteexpuf = trim(pg_fetch_result($sql, 0, "cteexpuf"));

        $cteexppessoa = trim(pg_fetch_result($sql, 0, "cteexppessoa"));
        $cteexpcep = trim(pg_fetch_result($sql, 0, "cteexpcep"));
        $cteexpcnpj = trim(pg_fetch_result($sql, 0, "cteexpcnpj"));
        $cteexpie = trim(pg_fetch_result($sql, 0, "cteexpie"));
        $cteexpcpf = trim(pg_fetch_result($sql, 0, "cteexpcpf"));

        if ($cteexppessoa == '1') {
            $cteexpdoc = $cteexpcnpj;
        } else {
            $cteexpdoc = $cteexpcpf;
        }

        $reccodigo = trim(pg_fetch_result($sql, 0, "reccodigo"));
        $cterecrazao = trim(pg_fetch_result($sql, 0, "cterecrazao"));
        $cterecendereco = trim(pg_fetch_result($sql, 0, "cterecendereco"));
        $ctereccomplemento = trim(pg_fetch_result($sql, 0, "ctereccomplemento"));
        $cterecbairro = trim(pg_fetch_result($sql, 0, "cterecbairro"));
        $cterecnumero = trim(pg_fetch_result($sql, 0, "cterecnumero"));
        $cidrec = trim(pg_fetch_result($sql, 0, "cidrec"));
        $cterecfone = trim(pg_fetch_result($sql, 0, "cterecfone"));
        $cterecpais = trim(pg_fetch_result($sql, 0, "cterecpais"));
        $cterecuf = trim(pg_fetch_result($sql, 0, "cterecuf"));

        $cterecpessoa = trim(pg_fetch_result($sql, 0, "cterecpessoa"));
        $ctereccep = trim(pg_fetch_result($sql, 0, "ctereccep"));
        $ctereccnpj = trim(pg_fetch_result($sql, 0, "ctereccnpj"));
        $cterecie = trim(pg_fetch_result($sql, 0, "cterecie"));
        $ctereccpf = trim(pg_fetch_result($sql, 0, "ctereccpf"));

        if ($cterecpessoa == '1') {
            $cterecdoc = $ctereccnpj;
        } else {
            $cterecdoc = $ctereccpf;
        }

        $ctetomrazao = trim(pg_fetch_result($sql, 0, "ctetomrazao"));
        $ctetomnguerra = trim(pg_fetch_result($sql, 0, "ctetomnguerra"));
        $ctetomendereco = trim(pg_fetch_result($sql, 0, "ctetomendereco"));
        $ctetomcomplemento = trim(pg_fetch_result($sql, 0, "ctetomcomplemento"));
        $ctetombairro = trim(pg_fetch_result($sql, 0, "ctetombairro"));
        $ctetomnumero = trim(pg_fetch_result($sql, 0, "ctetomnumero"));
        $cidtom = trim(pg_fetch_result($sql, 0, "cidtom"));
        $ctetomfone = trim(pg_fetch_result($sql, 0, "ctetomfone"));
        $ctetompais = trim(pg_fetch_result($sql, 0, "ctetompais"));
        $ctetomuf = trim(pg_fetch_result($sql, 0, "ctetomuf"));
        $ctetompessoa = trim(pg_fetch_result($sql, 0, "ctetompessoa"));
        $ctetomcep = trim(pg_fetch_result($sql, 0, "ctetomcep"));
        $ctetomcnpj = trim(pg_fetch_result($sql, 0, "ctetomcnpj"));
        $ctetomie = trim(pg_fetch_result($sql, 0, "ctetomie"));
        $ctetomcpf = trim(pg_fetch_result($sql, 0, "ctetomcpf"));
        $ctetomcidcodigoibge = trim(pg_fetch_result($sql, 0, "ctetomcidcodigoibge"));

        if ($ctetompessoa == '1') {
            $ctetomdoc = $ctetomcnpj;
        } else {
            $ctetomdoc = $ctetomcpf;
        }

        $ctepropredominante = trim(pg_fetch_result($sql, 0, "ctepropredominante"));
        $cteoutcaracteristica = trim(pg_fetch_result($sql, 0, "cteoutcaracteristica"));
        $ctecargaval = trim(pg_fetch_result($sql, 0, "ctecargaval"));
        $cteservicos = trim(pg_fetch_result($sql, 0, "cteservicos"));
        $ctereceber = trim(pg_fetch_result($sql, 0, "ctereceber"));

        $sitcodigo = trim(pg_fetch_result($sql, 0, "sitcodigo"));
        $sitnome = trim(pg_fetch_result($sql, 0, "sitnome"));

        $cteperreducao = trim(pg_fetch_result($sql, 0, "cteperreducao"));
        $ctebasecalculo = trim(pg_fetch_result($sql, 0, "ctebasecalculo"));
        $ctepericms = trim(pg_fetch_result($sql, 0, "ctepericms"));
        $ctevalicms = trim(pg_fetch_result($sql, 0, "ctevalicms"));
        $ctecredito = trim(pg_fetch_result($sql, 0, "ctecredito"));

        $ctepreencheicms = trim(pg_fetch_result($sql, 0, "ctepreencheicms"));
        $ctebaseicms = trim(pg_fetch_result($sql, 0, "ctebaseicms"));
        $cteperinterna = trim(pg_fetch_result($sql, 0, "cteperinterna"));
        $cteperinter = trim(pg_fetch_result($sql, 0, "cteperinter"));
        $cteperpartilha = trim(pg_fetch_result($sql, 0, "cteperpartilha"));
        $ctevalicmsini = trim(pg_fetch_result($sql, 0, "ctevalicmsini"));
        $ctevalicmsfim = trim(pg_fetch_result($sql, 0, "ctevalicmsfim"));
        $cteperpobreza = trim(pg_fetch_result($sql, 0, "cteperpobreza"));
        $ctevalpobreza = trim(pg_fetch_result($sql, 0, "ctevalpobreza"));

        $cteobsgeral = trim(pg_fetch_result($sql, 0, "cteobsgeral"));

        $cterntrc = trim(pg_fetch_result($sql, 0, "cterntrc"));
        $cteentrega = trim(pg_fetch_result($sql, 0, "cteentrega1"));
        $cteciot = trim(pg_fetch_result($sql, 0, "cteciot"));
        $topnome = trim(pg_fetch_result($sql, 0, "topnome"));

        $codestado = trim(pg_fetch_result($sql, 0, "codestado"));
        $codcidade = trim(pg_fetch_result($sql, 0, "codcidade"));
        $cid1 = trim(pg_fetch_result($sql, 0, "cid1"));
        $uf1 = trim(pg_fetch_result($sql, 0, "uf1"));

        $codestado2 = trim(pg_fetch_result($sql, 0, "codestado2"));
        $codcidade2 = trim(pg_fetch_result($sql, 0, "codcidade2"));
        $cid2 = trim(pg_fetch_result($sql, 0, "cid2"));
        $uf2 = trim(pg_fetch_result($sql, 0, "uf2"));

        $codestado3 = trim(pg_fetch_result($sql, 0, "codestado3"));
        $codcidade3 = trim(pg_fetch_result($sql, 0, "codcidade3"));
        $cid3 = trim(pg_fetch_result($sql, 0, "cid3"));
        $uf3 = trim(pg_fetch_result($sql, 0, "uf3"));

        $tomcodigo = trim(pg_fetch_result($sql, 0, "tomcodigo"));
        $cteemipessoa = trim(pg_fetch_result($sql, 0, "cteemipessoa"));
        $cteemicnpj = trim(pg_fetch_result($sql, 0, "cteemicnpj"));
        $cteemiie = trim(pg_fetch_result($sql, 0, "cteemiie"));
        $cteemicpf = trim(pg_fetch_result($sql, 0, "cteemicpf"));
        $cteemirg = trim(pg_fetch_result($sql, 0, "cteemirg"));
        $cteeminguerra = trim(pg_fetch_result($sql, 0, "cteeminguerra"));
        $cteemirazao = trim(pg_fetch_result($sql, 0, "cteemirazao"));
        $cteemicep = trim(pg_fetch_result($sql, 0, "cteemicep"));
        $cteemiendereco = trim(pg_fetch_result($sql, 0, "cteemiendereco"));
        $cteeminumero = trim(pg_fetch_result($sql, 0, "cteeminumero"));
        $cteemibairro = trim(pg_fetch_result($sql, 0, "cteemibairro"));
        $cteemicomplemento = trim(pg_fetch_result($sql, 0, "cteemicomplemento"));
        $cteemifone = trim(pg_fetch_result($sql, 0, "cteemifone"));
        $cteemipais = trim(pg_fetch_result($sql, 0, "cteemipais"));
        $cteemiuf = trim(pg_fetch_result($sql, 0, "cteemiuf"));
        $cteemicidcodigo = trim(pg_fetch_result($sql, 0, "cteemicidcodigo"));
        $cteemicidcodigoibge = trim(pg_fetch_result($sql, 0, "cteemicidcodigoibge"));
        $cidemi = trim(pg_fetch_result($sql, 0, "cidemi"));

        $ctetributos = trim(pg_fetch_result($sql, 0, "ctetributos"));

        $cteadcfisco = trim(pg_fetch_result($sql, 0, "cteadcfisco"));

        $ctecargaval = trim(pg_fetch_result($sql, 0, "ctecargaval"));
        $ctepropredominante = trim(pg_fetch_result($sql, 0, "ctepropredominante"));

        $cterntrc = trim(pg_fetch_result($sql, 0, "cterntrc"));
        $cteentrega = trim(pg_fetch_result($sql, 0, "cteentrega"));
        $cteindlocacao = trim(pg_fetch_result($sql, 0, "cteindlocacao"));

        $cteremnguerra = trim(pg_fetch_result($sql, 0, "cteremnguerra"));

        $ctedescomplemento = trim(pg_fetch_result($sql, 0, "ctedescomplemento"));
        $ctedescidcodigoibge = trim(pg_fetch_result($sql, 0, "ctedescidcodigoibge"));

        $cteremcomplemento = trim(pg_fetch_result($sql, 0, "cteremcomplemento"));

        $cteexpcidcodigoibge = trim(pg_fetch_result($sql, 0, "cteexpcidcodigoibge"));
        $ctereccidcodigoibge = trim(pg_fetch_result($sql, 0, "ctereccidcodigoibge"));

        $tfocodigo = trim(pg_fetch_result($sql, 0, "tfocodigo"));

        $sercodigox = trim(pg_fetch_result($sql, 0, "sercodigo"));
        $sercodigo = $sercodigox - 1;

        $tpgcodigo = trim(pg_fetch_result($sql, 0, "tpgcodigo"));

        $ctecobrancanum = trim(pg_fetch_result($sql, 0, "ctecobrancanum"));
        $ctecobrancaval = trim(pg_fetch_result($sql, 0, "ctecobrancaval"));
        $ctecobrancades = trim(pg_fetch_result($sql, 0, "ctecobrancades"));
        $ctecobrancaliq = trim(pg_fetch_result($sql, 0, "ctecobrancaliq"));


        $ctesubschave = trim(pg_fetch_result($sql, 0, "ctesubschave"));
        $ctesubstipo = trim(pg_fetch_result($sql, 0, "ctesubstipo"));


        //cUF - Código da UF do emitente do Documento Fiscal 
        //AAMM - Ano e Mês de emissão da NF-e (Nota Fiscal Eletrônica)
        //CNPJ - CNPJ do emitente
        //mod - Modelo do Documento Fiscal
        //serie - Série do Documento Fiscal
        //nNF - Número do Documento Fiscal
        //tpEmis – forma de emissão da NF-e													?
        //cNF - Código Numérico que compõe a Chave de Acesso								?
        //cDV - Dígito Verificador da Chave de Acesso										?
        //Exemplo:
        //<infCTe Id="CTe13130209191845000186550010000000591000000590" versao="1.01"> 


        $cnpj1 = trim($cteemicnpj);
        $cnpj1 = str_replace(".", "", $cnpj1);
        $cnpj1 = str_replace(",", "", $cnpj1);
        $cnpj1 = str_replace("-", "", $cnpj1);
        $cnpj1 = str_replace("/", "", $cnpj1);

        //26/10/2016
        //Cria um numero Randomico para o Codigo Numerico da Chave de Acesso
        $ctecodigo = mt_rand(1, 99999999);
        $ctecodigo = str_pad($ctecodigo, 8, "0", STR_PAD_LEFT);

        $infcteid = $codestado . substr($cteemissao, 2, 2) . substr($cteemissao, 5, 2) . $cnpj1 . $ctemodelo . $cteserie . str_pad($ctenum, 9, "0", STR_PAD_LEFT) . '1' . $ctecodigo;

        //$infcteid = '3516091070277000013057001000000345103010000';

        $digitoVerificador = dvCalcMod11($infcteid);

        $chaveCte = $infcteid . $digitoVerificador;

        $update = "Update cte set ctechave=$chaveCte Where ctenumero = '$parametro'";
        pg_query($update);

        $infcteidarquivo = $infcteid . $digitoVerificador . '-cte';

        $infcteid = 'CTe' . $infcteid . $digitoVerificador;
        //26/10/2016

        $txt = '<?xml version="1.0" encoding="UTF-8"?><CTe xmlns="http://www.portalfiscal.inf.br/cte">';

        $txt .= '<infCte Id="' . $infcteid . '" versao="2.00">';

        $txt .= '<ide>';

        $txt .= '<cUF>' . $codestado . '</cUF>';   //UF TABELA IBGE		
        $txt .= '<cCT>' . $ctecodigo . '</cCT>'; //Número aleatório gerado pelo emitente para cada CT-e, com o objetivo de evitar acessos indevidos ao documento.		
        $txt .= '<CFOP>' . $ctecfop . '</CFOP>';
        $txt .= '<natOp>' . substr($ctenatureza, 0, 60) . '</natOp>';

        if ($tpgcodigo == 1) {
            $tpgcodigox = 0;
        } else if ($tpgcodigo == 2) {
            $tpgcodigox = 1;
        } else if ($tpgcodigo == 3) {
            $tpgcodigox = 2;
        }

        $txt .= '<forPag>' . $tpgcodigox . '</forPag>'; //0 – pagamento à vista; 1 – pagamento à prazo; 2 - outros.         xxxxxxxxxxxxxxxxxxxxxxxx

        $txt .= '<mod>' . $ctemodelo . '</mod>';
        $txt .= '<serie>' . (int) $cteserie . '</serie>';
        $txt .= '<nCT>' . (int) $ctenum . '</nCT>';
        $txt .= '<dhEmi>' . substr($cteemissao, 0, 10) . 'T' . substr($cteemissao, 11, 8) . '</dhEmi>';  //Formato UTC “AAAA-MM-DDThh:mm:ss
        $txt .= '<tpImp>1</tpImp>'; //1-Retrato 2-Paisagem 

        /*
          1 - normal
          2 - contingencia epec
          3 - contingencia fsda
          4 - Autorização pela SVC-RS
         */

        if ($tfocodigo == 1) {
            $tfocodigox = 1;
        } else if ($tfocodigo == 2) {
            $tfocodigox = 4;
        } else if ($tfocodigo == 3) {
            $tfocodigox = 5;
        } else if ($tfocodigo == 4) {
            $tfocodigox = 7;
        }

        $txt .= '<tpEmis>' . $tfocodigox . '</tpEmis>';  //1 - Normal;4 - EPEC pela SVC;5 - Contingência FSDA;7 - Autorização pela SVC-RS;8 - Autorização pela SVC-SP

        $txt .= '<cDV>' . $digitoVerificador . '</cDV>';  //xxxxxxxxx
        //Parametrização	
        $ambiente = '';
        $versao = '';
        $sql2 = "Select * from parametros";
        $sql2 = pg_query($sql2);
        $row2 = pg_num_rows($sql2);
        if ($row2) {
            $ambiente = pg_fetch_result($sql2, 0, "parambiente");
            $versao = pg_fetch_result($sql2, 0, "parversao");
        }

        if ($ambiente == 1 || $ambiente == 2) {
            
        } else {
            $ambiente = 2;
        }

        if ($versao == '') {
            $versao = '2.0.42';
        }

        $txt .= '<tpAmb>' . $ambiente . '</tpAmb>'; //1 - Produção; 2 - Homologação 

        /*
          0 - CT-e Normal;
          1 - CT-e de Complemento de Valores;
          2 - CT-e de Anulação;
          3 - CT-e Substituto
         */

        if ($tctcodigo == 1 || $tctcodigo == 0 || $tctcodigo == '') {
            $tctcodigox = 0;
        } else if ($tctcodigo == 2) {
            $tctcodigox = 1;
        } else if ($tctcodigo == 3) {
            $tctcodigox = 2;
        } else if ($tctcodigo == 4) {
            $tctcodigox = 3;
        }

        $txt .= '<tpCTe>' . $tctcodigox . '</tpCTe>'; //0 - CT-e Normal;1 - CT-e de Complemento de Valores;2 - CT-e de Anulação;3 - CT-e Substituto

        $txt .= '<procEmi>0</procEmi>'; //0 - Emissão de CT-e com aplicativo do contribuinte;1 - Emissão de CT-e avulsa pelo Fisco;2 - Emissão de CT-e avulsa, pelo contribuinte com seu certificado digital, através do site do Fisco;3 - Emissão CT-e pelo contribuinte com aplicativo fornecido pelo Fisco.		

        $txt .= '<verProc>' . $versao . '</verProc>';  //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

        if ($ctechaveref != '' && $ctechaveref != '0') {
            $txt .= '<refCTE>' . $ctechaveref . '</refCTE>';
        }

        $txt .= '<cMunEnv>' . $codestado . $codcidade . '</cMunEnv>';  //Utilizar a tabela do IBGE, informar 9999999 para as operações com o exterior.
        $txt .= '<xMunEnv>' . $cid1 . '</xMunEnv>';
        $txt .= '<UFEnv>' . $uf1 . '</UFEnv>';

        if ($tmocodigo == 1 || $tmocodigo == 0 || $tmocodigo == '') {
            $tmocodigox = '01';
        } else if ($tmocodigo == 2) {
            $tmocodigox = '02';
        } else if ($tmocodigo == 3) {
            $tmocodigox = '03';
        } else if ($tmocodigo == 4) {
            $tmocodigox = '04';
        } else if ($tmocodigo == 5) {
            $tmocodigox = '05';
        } else if ($tmocodigo == 6) {
            $tmocodigox = '06';
        }

        $txt .= '<modal>' . $tmocodigox . '</modal>'; //01 - Rodoviário;02 - Aéreo;03 - Aquaviário;04 - Ferroviário;05 - Dutoviário;06 - Multimodal

        $txt .= '<tpServ>' . $sercodigo . '</tpServ>'; //0 - Normal;1 - Subcontratação;2 - Redespacho;3 - Redespacho Intermediário;4 - Serviço Vinculado a Multimodal

        $txt .= '<cMunIni>' . $codestado2 . $codcidade2 . '</cMunIni>';
        $txt .= '<xMunIni>' . $cid2 . '</xMunIni>';
        $txt .= '<UFIni>' . $uf2 . '</UFIni>';

        $txt .= '<cMunFim>' . $codestado3 . $codcidade3 . '</cMunFim>';
        $txt .= '<xMunFim>' . $cid3 . '</xMunFim>';
        $txt .= '<UFFim>' . $uf3 . '</UFFim>';

        $txt .= '<retira>1</retira>';   //Indicador se o Recebedor retira 0 - Sim 1 - Não
        //$txt.= '<xDetRetira></xDetRetira>';  //Detalhes do retira

        if ($tomcodigo == 1 || $tomcodigo == 0 || $tomcodigo == '') {
            $tomcodigox = '0';
        } else if ($tomcodigo == 2) {
            $tmocodigox = '1';
        } else if ($tomcodigo == 3) {
            $tomcodigox = '2';
        } else if ($tomcodigo == 4) {
            $tomcodigox = '3';
        } else if ($tomcodigo == 5) {
            $tomcodigox = '4';
        }

        if ($tomcodigox != '4') {
            $txt .= '<toma03>';
            $txt .= '<toma>' . $tomcodigox . '</toma>';
            $txt .= '</toma03>';
        } else {
            $txt .= '<toma4>';
            $txt .= '<toma>' . $tomcodigox . '</toma>';   //0 - Remetente;1 - Expedidor;2 - Recebedor;3 - Destinatário;4 - Outros						
            if ($ctetompessoa == 1) {
                $ctetomcnpj = preg_replace("/[^0-9]/", "", $ctetomcnpj);
                $txt .= '<CNPJ>' . $ctetomcnpj . '</CNPJ>';
            } else {
                $ctetomcpf = preg_replace("/[^0-9]/", "", $ctetomcpf);
                $txt .= '<CPF>' . $ctetomcpf . '</CPF>';
            }
            if ($ctetomie != 'ISENTO') {
                $ctetomie = preg_replace("/[^0-9]/", "", $ctetomie);
            }
            $txt .= '<IE>' . $ctetomie . '</IE>';
            $txt .= '<xNome>' . $ctetomrazao . '</xNome>';
            if ($ctetomnguerra != '') {
                $txt .= '<xFant>' . $ctetomnguerra . '</xFant>';
            }
            $ctetomfone = preg_replace("/[^0-9]/", "", $ctetomfone);
            if ($ctetomfone != '') {
                $txt .= '<fone>' . $ctetomfone . '</fone>';
            }
            $txt .= '<enderToma>';
            $txt .= '<xLgr>' . $ctetomendereco . '</xLgr>';
            $txt .= '<nro>' . $ctetomnumero . '</nro>';
            if ($ctetomcomplemento != '') {
                $txt .= '<xCpl>' . $ctetomcomplemento . '</xCpl>';
            }
            if ($ctetombairro != '') {
                $txt .= '<xBairro>' . $ctetombairro . '</xBairro>';
            }
            $txt .= '<cMun>' . $ctetomcidcodigoibge . '</cMun>';
            $txt .= '<xMun>' . $cidtom . '</xMun>';
            $txt .= '<CEP>' . $ctetomcep . '</CEP>';
            $txt .= '<UF>' . $ctetomuf . '</UF>';
            $txt .= '<cPais>1058</cPais>';
            $txt .= '<xPais>' . $ctetompais . '</xPais>';
            $txt .= '</enderToma>';
            $txt .= '</toma4>';
        }

        $txt .= '</ide>';

        $txt .= '<compl>';

        $txt .= '<fluxo/>';

        //Observacoes Gerais
        if ($cteobsgeral != '') {
            $txt .= '<xObs>' . $cteobsgeral . '</xObs>';
        }

        //Observacoes Contribuinte		
        $sql2 = "Select a.cteconnome,a.cteconobs ";
        $sql2 .= " From cteobscontribuinte a";
        $sql2 .= " Where a.ctenumero = '$parametro' order by a.cteconcodigo";

        $sql2 = pg_query($sql2);
        $row2 = pg_num_rows($sql2);
        if ($row2) {
            for ($i2 = 0; $i2 < $row2; $i2++) {
                $ctevalnome = pg_fetch_result($sql2, $i2, "cteconnome");
                $ctevalobs = pg_fetch_result($sql2, $i2, "cteconobs");
                $txt .= '<ObsCont xCampo="' . $ctevalnome . '">';
                $txt .= '<xTexto>' . $ctevalobs . '</xTexto>';
                $txt .= '</ObsCont>';
            }
        }

        //Observacoes Fisco
        $sql2 = "Select a.ctefisnome,a.ctefisobs ";
        $sql2 .= " From cteobsfisco a";
        $sql2 .= " Where a.ctenumero = '$parametro' order by a.ctefiscodigo";

        $sql2 = pg_query($sql2);
        $row2 = pg_num_rows($sql2);
        if ($row2) {
            for ($i2 = 0; $i2 < $row2; $i2++) {
                $ctevalnome = pg_fetch_result($sql2, $i2, "ctefisnome");
                $ctevalobs = pg_fetch_result($sql2, $i2, "ctefisobs");
                $txt .= '<ObsFisco xCampo="' . $ctevalnome . '">';
                $txt .= '<xTexto>' . $ctevalobs . '</xTexto>';
                $txt .= '</ObsFisco>';
            }
        }


        $txt .= '</compl>';


        $txt .= '<emit>';

        if ($cteemipessoa == 1) {
            $cteemicnpj = preg_replace("/[^0-9]/", "", $cteemicnpj);
            $txt .= '<CNPJ>' . $cteemicnpj . '</CNPJ>';
        } else {
            $cteemicpf = preg_replace("/[^0-9]/", "", $cteemicpf);
            $txt .= '<CPF>' . $cteemicpf . '</CPF>';
        }
        if ($cteemiie != 'ISENTO') {
            $cteemiie = preg_replace("/[^0-9]/", "", $cteemiie);
        }
        $txt .= '<IE>' . $cteemiie . '</IE>';
        $txt .= '<xNome>' . $cteemirazao . '</xNome>';
        if ($cteeminguerra != '') {
            $txt .= '<xFant>' . $cteeminguerra . '</xFant>';
        }
        $txt .= '<enderEmit>';
        $txt .= '<xLgr>' . $cteemiendereco . '</xLgr>';
        $txt .= '<nro>' . $cteeminumero . '</nro>';
        if ($cteemicomplemento != '') {
            $txt .= '<xCpl>' . $cteemicomplemento . '</xCpl>';
        }
        if ($cteemibairro != '') {
            $txt .= '<xBairro>' . $cteemibairro . '</xBairro>';
        }
        $txt .= '<cMun>' . $cteemicidcodigoibge . '</cMun>';
        $txt .= '<xMun>' . $cidemi . '</xMun>';
        $txt .= '<CEP>' . $cteemicep . '</CEP>';
        $txt .= '<UF>' . $cteemiuf . '</UF>';
        $cteemifone = preg_replace("/[^0-9]/", "", $cteemifone);
        if ($cteemifone != '') {
            $txt .= '<fone>' . $cteemifone . '</fone>';
        }
        $txt .= '</enderEmit>';
        $txt .= '</emit>';

        //CTe com Remetente
        if ($remcodigo == 0 || $remcodigo == 1 || $remcodigo == '') {

            $txt .= '<rem>';
            if ($cterempessoa == '1') {
                $cteremcnpj = preg_replace("/[^0-9]/", "", $cteremcnpj);
                $txt .= '<CNPJ>' . $cteremcnpj . '</CNPJ>';
            } else {
                $cteremcpf = preg_replace("/[^0-9]/", "", $cteremcpf);
                $txt .= '<CPF>' . $cteremcpf . '</CPF>';
            }
            if ($cteremie != 'ISENTO') {
                $cteremie = preg_replace("/[^0-9]/", "", $cteremie);
            }
            $txt .= '<IE>' . $cteremie . '</IE>';
            $txt .= '<xNome>' . $cteremrazao . '</xNome>';
            if ($cteremnguerra != '') {
                $txt .= '<xFant>' . $cteremnguerra . '</xFant>';
            }
            $cteremfone = preg_replace("/[^0-9]/", "", $cteremfone);
            if ($cteremfone != '') {
                $txt .= '<fone>' . $cteremfone . '</fone>';
            }
            $txt .= '<enderReme>';
            $txt .= '<xLgr>' . $cteremendereco . '</xLgr>';
            $txt .= '<nro>' . $cteremnumero . '</nro>';
            if ($cteremcomplemento != '') {
                $txt .= '<xCpl>' . $cteremcomplemento . '</xCpl>';
            }
            if ($cterembairro != '') {
                $txt .= '<xBairro>' . $cterembairro . '</xBairro>';
            }
            $txt .= '<cMun>' . $cteremcidcodigoibge . '</cMun>';
            $txt .= '<xMun>' . $cidrem . '</xMun>';
            $txt .= '<CEP>' . $cteremcep . '</CEP>';
            $txt .= '<UF>' . $cteremuf . '</UF>';
            $txt .= '<cPais>1058</cPais>';
            $txt .= '<xPais>' . $cterempais . '</xPais>';
            $txt .= '</enderReme>';
            $txt .= '</rem>';
        }

        //CTe com Expedidor
        if ($expcodigo == 0 || $expcodigo == 1 || $expcodigo == '') {
            $txt .= '<exped>';
            if ($cteexppessoa == '1') {
                $cteexpcnpj = preg_replace("/[^0-9]/", "", $cteexpcnpj);
                $txt .= '<CNPJ>' . $cteexpcnpj . '</CNPJ>';
            } else {
                $cteexpcpf = preg_replace("/[^0-9]/", "", $cteexpcpf);
                $txt .= '<CPF>' . $cteexpcpf . '</CPF>';
            }
            if ($cteexpie != 'ISENTO') {
                $cteexpie = preg_replace("/[^0-9]/", "", $cteexpie);
            }
            $txt .= '<IE>' . $cteexpie . '</IE>';
            $txt .= '<xNome>' . $cteexprazao . '</xNome>';
            $cteexpfone = preg_replace("/[^0-9]/", "", $cteexpfone);
            if ($cteexpfone != '') {
                $txt .= '<fone>' . $cteexpfone . '</fone>';
            }
            $txt .= '<enderExped>';
            $txt .= '<xLgr>' . $cteexpendereco . '</xLgr>';
            $txt .= '<nro>' . $cteexpnumero . '</nro>';
            if ($cteexpcomplemento != '') {
                $txt .= '<xCpl>' . $cteexpcomplemento . '</xCpl>';
            }
            if ($cteexpbairro != '') {
                $txt .= '<xBairro>' . $cteexpbairro . '</xBairro>';
            }
            $txt .= '<cMun>' . $cteexpcidcodigoibge . '</cMun>';
            $txt .= '<xMun>' . $cidexp . '</xMun>';
            $txt .= '<CEP>' . $cteexpcep . '</CEP>';
            $txt .= '<UF>' . $cteexpuf . '</UF>';
            $txt .= '<cPais>1058</cPais>';
            $txt .= '<xPais>' . $cteexppais . '</xPais>';
            $txt .= '</enderExped>';
            $txt .= '</exped>';
        }

        //CTe com Recebedor
        if ($reccodigo == 0 || $reccodigo == 1 || $reccodigo == '') {
            $txt .= '<receb>';
            if ($cterecpessoa == '1') {
                $ctereccnpj = preg_replace("/[^0-9]/", "", $ctereccnpj);
                $txt .= '<CNPJ>' . $ctereccnpj . '</CNPJ>';
            } else {
                $ctereccpf = preg_replace("/[^0-9]/", "", $ctereccpf);
                $txt .= '<CPF>' . $ctereccpf . '</CPF>';
            }
            if ($cterecie != 'ISENTO') {
                $cterecie = preg_replace("/[^0-9]/", "", $cterecie);
            }
            $txt .= '<IE>' . $cterecie . '</IE>';
            $txt .= '<xNome>' . $cterecrazao . '</xNome>';
            $cterecfone = preg_replace("/[^0-9]/", "", $cterecfone);
            if ($cterecfone != '') {
                $txt .= '<fone>' . $cterecfone . '</fone>';
            }
            $txt .= '<enderReceb>';
            $txt .= '<xLgr>' . $cterecendereco . '</xLgr>';
            $txt .= '<nro>' . $cterecnumero . '</nro>';
            if ($ctereccomplemento != '') {
                $txt .= '<xCpl>' . $ctereccomplemento . '</xCpl>';
            }
            if ($cterecbairro != '') {
                $txt .= '<xBairro>' . $cterecbairro . '</xBairro>';
            }
            $txt .= '<cMun>' . $ctereccidcodigoibge . '</cMun>';
            $txt .= '<xMun>' . $cidrec . '</xMun>';
            $txt .= '<CEP>' . $ctereccep . '</CEP>';
            $txt .= '<UF>' . $cterecuf . '</UF>';
            $txt .= '<cPais>1058</cPais>';
            $txt .= '<xPais>' . $cterecpais . '</xPais>';
            $txt .= '</enderReceb>';
            $txt .= '</receb>';
        }

        //CTe com Destinatario	
        if ($descodigo == 0 || $descodigo == 1 || $descodigo == '') {
            $txt .= '<dest>';
            if ($ctedespessoa == '1') {
                $ctedescnpj = preg_replace("/[^0-9]/", "", $ctedescnpj);
                $txt .= '<CNPJ>' . $ctedescnpj . '</CNPJ>';
            } else {
                $ctedescpf = preg_replace("/[^0-9]/", "", $ctedescpf);
                $txt .= '<CPF>' . $ctedescpf . '</CPF>';
            }
            if ($ctedesie != 'ISENTO') {
                $ctedesie = preg_replace("/[^0-9]/", "", $ctedesie);
            }
            $txt .= '<IE>' . $ctedesie . '</IE>';
            $txt .= '<xNome>' . $ctedesrazao . '</xNome>';
            $ctedesfone = preg_replace("/[^0-9]/", "", $ctedesfone);
            if ($ctedesfone != '') {
                $txt .= '<fone>' . $ctedesfone . '</fone>';
            }
            if ($ctedessuframa != '' && $ctedessuframa != '0') {
                $txt .= '<ISUF>' . $ctedessuframa . '</ISUF>';
            }
            $txt .= '<enderDest>';
            $txt .= '<xLgr>' . $ctedesendereco . '</xLgr>';
            $txt .= '<nro>' . $ctedesnumero . '</nro>';
            if ($ctedescomplemento != '') {
                $txt .= '<xCpl>' . $ctedescomplemento . '</xCpl>';
            }
            if ($ctedesbairro != '') {
                $txt .= '<xBairro>' . $ctedesbairro . '</xBairro>';
            }
            $txt .= '<cMun>' . $ctedescidcodigoibge . '</cMun>';
            $txt .= '<xMun>' . $ciddes . '</xMun>';
            $txt .= '<CEP>' . $ctedescep . '</CEP>';
            $txt .= '<UF>' . $ctedesuf . '</UF>';
            $txt .= '<cPais>1058</cPais>';
            $txt .= '<xPais>' . $ctedespais . '</xPais>';
            $txt .= '</enderDest>';
            $txt .= '</dest>';
        }


        //Pretacao de Servicos
        $txt .= '<vPrest>';
        $txt .= '<vTPrest>' . number_format($cteservicos, 2, '.', '') . '</vTPrest>';
        $txt .= '<vRec>' . number_format($ctereceber, 2, '.', '') . '</vRec>';

        $sql2 = "Select a.ctevalnome,a.ctevalvalor ";
        $sql2 .= " From ctevalorservico a";
        $sql2 .= " Where a.ctenumero = '$parametro' order by a.ctevalcodigo";
        $sql2 = pg_query($sql2);
        $row2 = pg_num_rows($sql2);
        if ($row2) {
            for ($i2 = 0; $i2 < $row2; $i2++) {
                $txt .= '<Comp>';
                $ctevalnome = pg_fetch_result($sql2, $i2, "ctevalnome");
                $ctevalvalor = pg_fetch_result($sql2, $i2, "ctevalvalor");
                $txt .= '<xNome>' . $ctevalnome . '</xNome>';
                $txt .= '<vComp>' . number_format($ctevalvalor, 2, '.', '') . '</vComp>';
                $txt .= '</Comp>';
            }
        }

        $txt .= '</vPrest>';

        //Impostos - Vai Depender do Cálculo de ICMS escolhido	
        $txt .= '<imp>';
        $txt .= '<ICMS>';
        //00 - tributação normal ICMS	
        if ($sitcodigo == 1 || $sitcodigo == 0 || $sitcodigo == '') {
            $txt .= '<ICMS00>';
            $txt .= '<CST>00</CST>';
            $txt .= '<vBC>' . number_format($ctebasecalculo, 2, '.', '') . '</vBC>';
            $txt .= '<pICMS>' . number_format($ctepericms, 2, '.', '') . '</pICMS>';
            $txt .= '<vICMS>' . number_format($ctevalicms, 2, '.', '') . '</vICMS>';
            $txt .= '</ICMS00>';
        }
        //20 - tributação com BC reduzida do ICMS
        else if ($sitcodigo == 2) {
            $txt .= '<ICMS20>';
            $txt .= '<CST>20</CST>';
            $txt .= '<pRedBC>' . number_format($cteperreducao, 2, '.', '') . '</pRedBC>';
            $txt .= '<vBC>' . number_format($ctebasecalculo, 2, '.', '') . '</vBC>';
            $txt .= '<pICMS>' . number_format($ctepericms, 2, '.', '') . '</pICMS>';
            $txt .= '<vICMS>' . number_format($ctevalicms, 2, '.', '') . '</vICMS>';
            $txt .= '</ICMS20>';
        }
        //45 - ICMS Isento, não Tributado ou diferido
        else if ($sitcodigo == 3 || $sitcodigo == 4 || $sitcodigo == 5) {
            $txt .= '<ICMS45>';
            if ($sitcodigo == 3) {
                $txt .= '<CST>40</CST>';
            } else if ($sitcodigo == 4) {
                $txt .= '<CST>41</CST>';
            } else if ($sitcodigo == 5) {
                $txt .= '<CST>51</CST>';
            }
            $txt .= '</ICMS45>';
        }
        //60 - ICMS cobrado anteriormente por substituição tributária
        else if ($sitcodigo == 6) {
            $txt .= '<ICMS60>';
            $txt .= '<CST>60</CST>';
            $txt .= '<vBCSTRet>' . number_format($ctebasecalculo, 2, '.', '') . '</vBCSTRet>';
            $txt .= '<vICMSSTRet>' . number_format($ctevalicms, 2, '.', '') . '</vICMSSTRet>';
            $txt .= '<pICMSSTRet>' . number_format($ctepericms, 2, '.', '') . '</pICMSSTRet>';
            $txt .= '<vCred>' . number_format($ctecredito, 2, '.', '') . '</vCred>';
            $txt .= '</ICMS60>';
        }
        //90 - ICMS outros
        else if ($sitcodigo == 7) {
            $txt .= '<ICMS90>';
            $txt .= '<CST>90</CST>';
            $txt .= '<pRedBC>' . number_format($cteperreducao, 2, '.', '') . '</pRedBC>';
            $txt .= '<vBC>' . number_format($ctebasecalculo, 2, '.', '') . '</vBC>';
            $txt .= '<pICMS>' . number_format($ctepericms, 2, '.', '') . '</pICMS>';
            $txt .= '<vICMS>' . number_format($ctevalicms, 2, '.', '') . '</vICMS>';
            $txt .= '<vCred>' . number_format($ctecredito, 2, '.', '') . '</vCred>';
            $txt .= '</ICMS90>';
        }
        //Simples Nacional
        else if ($sitcodigo == 8) {
            $txt .= '<ICMSSN>';
            $txt .= '<indSN>1</indSN>';
            $txt .= '</ICMSSN>';
        }

        $txt .= '</ICMS>';

        $txt .= '<vTotTrib>' . number_format($ctetributos, 2, '.', '') . '</vTotTrib>';


        if ($ctevalicmsfim > 0 && $ctepreencheicms == 1) {
            if (trim($cteadcfisco) == '') {
                $cteadcfisco = "VALOR DO ICMS DE PARTILHA R$ " . number_format($ctevalicmsfim, 2, ',', '.');
            } else {
                $cteadcfisco .= " - VALOR DO ICMS DE PARTILHA R$ " . number_format($ctevalicmsfim, 2, ',', '.');
            }
        }

        if ($cteadcfisco != '') {
            $txt .= '<infAdFisco>' . $cteadcfisco . '</infAdFisco>';
        }

        //Diferencia de Aliquota
        if ($ctepreencheicms == 1) {
            $txt .= '<ICMSUFFim>';
            $txt .= '<vBCUFFim>' . number_format($ctebaseicms, 2, '.', '') . '</vBCUFFim>';
            $txt .= '<pFCPUFFim>' . number_format($cteperpobreza, 2, '.', '') . '</pFCPUFFim>';
            $txt .= '<pICMSUFFim>' . number_format($cteperinterna, 2, '.', '') . '</pICMSUFFim>';
            $txt .= '<pICMSInter>' . number_format($cteperinter, 2, '.', '') . '</pICMSInter>';
            /*
              if($cteperpartilha==1 || $cteperpartilha==0 || $cteperpartilha==''){
              $txt.= '<pICMSInterPart>' . number_format(40, 2, '.', '') . '</pICMSInterPart>';
              }
              else if($cteperpartilha==2){
              $txt.= '<pICMSInterPart>' . number_format(60, 2, '.', '') . '</pICMSInterPart>';
              }
              else if($cteperpartilha==3){
              $txt.= '<pICMSInterPart>' . number_format(80, 2, '.', '') . '</pICMSInterPart>';
              }
              else {
              $txt.= '<pICMSInterPart>' . number_format(100, 2, '.', '') . '</pICMSInterPart>';
              }
             */
            $txt .= '<vFCPUFFim>' . number_format($ctevalpobreza, 2, '.', '') . '</vFCPUFFim>';
            $txt .= '<vICMSUFFim>' . number_format($ctevalicmsfim, 2, '.', '') . '</vICMSUFFim>';
            $txt .= '<vICMSUFIni>' . number_format($ctevalicmsini, 2, '.', '') . '</vICMSUFIni>';
            $txt .= '</ICMSUFFim>';
        }

        $txt .= '</imp>';

        if ($tctcodigox == 0 || $tctcodigox == 3) {

            //Grupo de informações do CT-e Normal e Substituto
            $txt .= '<infCTeNorm>';
            $txt .= '<infCarga>';
            $txt .= '<vCarga>' . number_format($ctecargaval, 2, '.', '') . '</vCarga>';
            $txt .= '<proPred>' . $ctepropredominante . '</proPred>';
            if ($ctepropredominante == '') {
                $erroCte .= 'Produto Predominante Invalido' . '_';
            }
            if (trim($cteoutcaracteristica) != '') {
                $txt .= '<xOutCat>' . $cteoutcaracteristica . '</xOutCat>';
            }

            $sql2 = "Select a.*,b.mednome from cteinfocarga a,tipomedida b Where a.ctenumero = '$parametro'";
            $sql2 .= " and a.medcodigo = b.medcodigo ";

            $sql2 = pg_query($sql2);
            $row2 = pg_num_rows($sql2);
            if ($row2) {

                for ($i2 = 0; $i2 < $row2; $i2++) {

                    $mednome = pg_fetch_result($sql2, $i2, "mednome");
                    $cteinfnome = pg_fetch_result($sql2, $i2, "cteinfnome");
                    $cteinfvalor = pg_fetch_result($sql2, $i2, "cteinfvalor");

                    $txt .= '<infQ>';

                    if ($mednome == 'M3') {
                        $mednome = '00';
                    } else if ($mednome == 'KG') {
                        $mednome = '01';
                    } else if ($mednome == 'TON') {
                        $mednome = '02';
                    } else if ($mednome == 'LITROS') {
                        $mednome = '04';
                    } else if ($mednome == 'MMBTU') {
                        $mednome = '05';
                    } else { //UNIDADE
                        $mednome = '03';
                    }

                    $txt .= '<cUnid>' . $mednome . '</cUnid>';
                    $txt .= '<tpMed>' . $cteinfnome . '</tpMed>';
                    $txt .= '<qCarga>' . number_format($cteinfvalor, 4, '.', '') . '</qCarga>';

                    $txt .= '</infQ>';
                }
            } else {
                $erroCte .= 'Preencher Informacoes da Carga' . '_';
            }




            $txt .= '</infCarga>';

            $txt .= '<infDoc>';

            $sql2 = "Select * from ctenfechave Where ctenumero = '$parametro'";

            $sql2 = pg_query($sql2);
            $row2 = pg_num_rows($sql2);
            if ($row2) {

                for ($i2 = 0; $i2 < $row2; $i2++) {

                    $ctenfenome = pg_fetch_result($sql2, $i2, "ctenfenome");
                    $ctenfepin = pg_fetch_result($sql2, $i2, "ctenfepin");

                    $txt .= '<infNFe>';

                    $txt .= '<chave>' . $ctenfenome . '</chave>';
                    if (trim($ctenfepin) != '') {
                        $txt .= '<PIN>' . $ctenfepin . '</PIN>';
                    }
                    //$txt.= '<dPrev>2016-09-19</dPrev>';

                    $txt .= '</infNFe>';
                }
            } else {
                $erroCte .= 'Preencher Informacoes de Documentos Originarios' . '_';
            }

            $txt .= '</infDoc>';


            $sql2 = "Select * from cteinfoseguro Where ctenumero = '$parametro'";

            $sql2 = pg_query($sql2);
            $row2 = pg_num_rows($sql2);
            if ($row2) {

                for ($i2 = 0; $i2 < $row2; $i2++) {

                    $ctesegnome = pg_fetch_result($sql2, $i2, "ctesegnome");
                    $ctesegapolice = trim(pg_fetch_result($sql2, $i2, "ctesegapolice"));
                    $ctesegaverbacao = trim(pg_fetch_result($sql2, $i2, "ctesegaverbacao"));
                    $rescodigo = pg_fetch_result($sql2, $i2, "rescodigo");
                    $ctesegvalor = pg_fetch_result($sql2, $i2, "ctesegvalor");

                    $rescodigo--;

                    $txt .= '<seg>';

                    $txt .= '<respSeg>' . $rescodigo . '</respSeg>';  //0 - Remetente;1 - Expedidor;2 - Recebedor;3 - Destinatário;4 - Emitente do CT-e;5 - Tomador do ServiçoDados obrigatórios apenas no modal Rodoviário, depois da lei 11.442/07. Para os demais modais esta informação é opcional.
                    $txt .= '<xSeg>' . $ctesegnome . '</xSeg>';
                    $txt .= '<nApol>' . $ctesegapolice . '</nApol>';
                    if ($ctesegaverbacao != '') {
                        $txt .= '<nAver>' . $ctesegaverbacao . '</nAver>';
                    }
                    $txt .= '<vCarga>' . number_format($ctesegvalor, 2, '.', '') . '</vCarga>';
                    if ($ctesegvalor == 0) {
                        $erroCte .= 'Preencher Informacoes do Seguro (Valor da Carga)' . '_';
                    }

                    $txt .= '</seg>';
                }
            } else {
                $erroCte .= 'Preencher Informacoes do Seguro' . '_';
            }

            $txt .= '<infModal versaoModal="2.00">';

            //A partir daqui depende do tipo de Modal, a principio só tera tratamento para Rodoviario
            if ($tmocodigox == '01') {
                $txt .= '<rodo>';

                $txt .= '<RNTRC>' . $cterntrc . '</RNTRC>';
                $txt .= '<dPrev>' . substr($cteentrega, 0, 10) . '</dPrev>';
                if (trim(substr($cteentrega, 0, 10)) == '') {
                    $erroCte .= 'Preencher Data Prevista da Entrega' . '_';
                }
                if ($cteindlocacao == 1) {
                    $cteindlocacao = 1;
                } else {
                    $cteindlocacao = 0;
                }
                $txt .= '<lota>' . $cteindlocacao . '</lota>';   //0 - Não; 1 - Sim
                if ($cteciot !== '') {
                    $txt .= '<CIOT>' . $cteciot . '</CIOT>';
                }

                //Ordens de Coleta Associoadas
                $sql2 = "Select * from cteinfocoleta Where ctenumero = '$parametro'";
                $sql2 = pg_query($sql2);
                $row2 = pg_num_rows($sql2);
                if ($row2) {

                    for ($i2 = 0; $i2 < $row2; $i2++) {

                        $ctecolserie = trim(pg_fetch_result($sql2, $i2, "ctecolserie"));
                        $ctecolnumero = trim(pg_fetch_result($sql2, $i2, "ctecolnumero"));
                        $ctecolemissao = trim(pg_fetch_result($sql2, $i2, "ctecolemissao"));
                        $ctecolcnpj = trim(pg_fetch_result($sql2, $i2, "ctecolcnpj"));
                        $ctecolinterno = trim(pg_fetch_result($sql2, $i2, "ctecolinterno"));
                        $ctecolie = trim(pg_fetch_result($sql2, $i2, "ctecolie"));
                        $ctecoluf = trim(pg_fetch_result($sql2, $i2, "ctecoluf"));
                        $ctecolfone = trim(pg_fetch_result($sql2, $i2, "ctecolfone"));


                        $txt .= '<occ>';

                        if ($ctecolserie != '') {
                            $txt .= '<serie>' . $ctecolserie . '</serie>';
                        }
                        if ($ctecolnumero != '') {
                            $txt .= '<nOcc>' . $ctecolnumero . '</nOcc>';
                        }
                        if ($ctecolemissao != '') {
                            $txt .= '<dEmi>' . substr($ctecolemissao, 0, 10) . '</dEmi>';
                        }
                        $txt .= '<emiOcc>';
                        if ($ctecolcnpj != '') {
                            $ctecolcnpj = preg_replace("/[^0-9]/", "", $ctecolcnpj);
                            $txt .= '<CNPJ>' . $ctecolcnpj . '</CNPJ>';
                        }
                        if ($ctecolinterno != '') {
                            $txt .= '<cInt>' . $ctecolinterno . '</cInt>';
                        }
                        if ($ctecolie != '') {
                            if ($ctecolie != 'ISENTO') {
                                $ctecolie = preg_replace("/[^0-9]/", "", $ctecolie);
                            }
                            $txt .= '<IE>' . $ctecolie . '</IE>';
                        }
                        if ($ctecoluf != '') {
                            $txt .= '<UF>' . $ctecoluf . '</UF>';
                        }
                        if ($ctecolfone != '') {
                            $ctecolfone = preg_replace("/[^0-9]/", "", $ctecolfone);
                            $txt .= '<fone>' . $ctecolfone . '</fone>';
                        }
                        $txt .= '</emiOcc>';

                        $txt .= '</occ>';
                    }
                }


                //Informações de Vale Pedágio
                $sql2 = "Select * from cteinfopedagio Where ctenumero = '$parametro'";
                $sql2 = pg_query($sql2);
                $row2 = pg_num_rows($sql2);
                if ($row2) {
                    for ($i2 = 0; $i2 < $row2; $i2++) {
                        $ctepedforne = trim(pg_fetch_result($sql2, $i2, "ctepedforne"));
                        $ctepedrespo = trim(pg_fetch_result($sql2, $i2, "ctepedrespo"));
                        $ctepednome = trim(pg_fetch_result($sql2, $i2, "ctepednome"));
                        $ctepedvalor = pg_fetch_result($sql2, $i2, "ctepedvalor");
                        $txt .= '<valePed>';
                        if ($ctepedforne != '') {
                            $ctepedforne = preg_replace("/[^0-9]/", "", $ctepedforne);
                            $txt .= '<CNPJForn>' . $ctepedforne . '</CNPJForn>';
                        }
                        if ($ctepednome != '') {
                            $txt .= '<nCompra>' . $ctepednome . '</nCompra>';
                        }
                        if ($ctepedrespo != '') {
                            $ctepedrespo = preg_replace("/[^0-9]/", "", $ctepedrespo);
                            $txt .= '<CNPJPg>' . $ctepedrespo . '</CNPJPg>';
                        }
                        $txt .= '<vValePed>' . number_format($ctepedvalor, 2, '.', '') . '</vValePed>';
                        $txt .= '</valePed>';
                    }
                }


                //Dados dos Veículos
                $sql2 = "Select * from cteinfoveiculos Where ctenumero = '$parametro'";
                $sql2 = pg_query($sql2);
                $row2 = pg_num_rows($sql2);
                if ($row2) {
                    for ($i2 = 0; $i2 < $row2; $i2++) {
                        $cteveicod = trim(pg_fetch_result($sql2, $i2, "cteveicod"));
                        $cteveirenavam = trim(pg_fetch_result($sql2, $i2, "cteveirenavam"));
                        $cteveiplaca = trim(pg_fetch_result($sql2, $i2, "cteveiplaca"));
                        $cteveitara = pg_fetch_result($sql2, $i2, "cteveitara");
                        $cteveicapacidadekg = pg_fetch_result($sql2, $i2, "cteveicapacidadekg");
                        $cteveicapacidadem3 = pg_fetch_result($sql2, $i2, "cteveicapacidadem3");
                        $cteveipropveiculo = pg_fetch_result($sql2, $i2, "cteveipropveiculo");
                        $cteveitpveiculo = pg_fetch_result($sql2, $i2, "cteveitpveiculo");
                        $cteveitprodado = pg_fetch_result($sql2, $i2, "cteveitprodado");
                        if ($cteveitprodado == 1 || $cteveitprodado == 0 || $cteveitprodado == '') {
                            $cteveitprodadox = '00';
                        } else if ($cteveitprodado == 2) {
                            $cteveitprodadox = '01';
                        } else if ($cteveitprodado == 3) {
                            $cteveitprodadox = '02';
                        } else if ($cteveitprodado == 4) {
                            $cteveitprodadox = '03';
                        } else if ($cteveitprodado == 5) {
                            $cteveitprodadox = '04';
                        } else if ($cteveitprodado == 6) {
                            $cteveitprodadox = '05';
                        } else if ($cteveitprodado == 7) {
                            $cteveitprodadox = '06';
                        }
                        $cteveitpcarroceria = pg_fetch_result($sql2, $i2, "cteveitpcarroceria");
                        if ($cteveitpcarroceria == 1 || $cteveitpcarroceria == 0 || $cteveitpcarroceria == '') {
                            $cteveitpcarroceriax = '00';
                        } else if ($cteveitpcarroceria == 2) {
                            $cteveitpcarroceriax = '01';
                        } else if ($cteveitpcarroceria == 3) {
                            $cteveitpcarroceriax = '02';
                        } else if ($cteveitpcarroceria == 4) {
                            $cteveitpcarroceriax = '03';
                        } else if ($cteveitpcarroceria == 5) {
                            $cteveitpcarroceriax = '04';
                        } else if ($cteveitpcarroceria == 6) {
                            $cteveitpcarroceriax = '05';
                        }
                        $cteveiuf = trim(pg_fetch_result($sql2, $i2, "cteveiuf"));
                        $cteveiempresa = trim(pg_fetch_result($sql2, $i2, "cteveiempresa"));

                        $cteveicpf = trim(pg_fetch_result($sql2, $i2, "cteveicpf"));
                        $cteveicnpj = trim(pg_fetch_result($sql2, $i2, "cteveicnpj"));
                        $cteveirntrc = trim(pg_fetch_result($sql2, $i2, "cteveirntrc"));
                        $cteveirazao = trim(pg_fetch_result($sql2, $i2, "cteveirazao"));
                        $cteveiie = trim(pg_fetch_result($sql2, $i2, "cteveiie"));
                        $cteveipropuf = trim(pg_fetch_result($sql2, $i2, "cteveipropuf"));
                        $cteveitpproprietario = pg_fetch_result($sql2, $i2, "cteveitpproprietario");
                        if ($cteveitpproprietario == 1 || $cteveitpproprietario == 0 || $cteveitpproprietario == '') {
                            $cteveitpproprietariox = '0';
                        } else if ($cteveitpproprietario == 2) {
                            $cteveitpproprietariox = '1';
                        } else if ($cteveitpproprietario == 3) {
                            $cteveitpproprietariox = '2';
                        }

                        $txt .= '<veic>';
                        if ($cteveicod != '') {
                            $txt .= '<cInt>' . $cteveicod . '</cInt>';
                        }
                        if ($cteveirenavam != '') {
                            $txt .= '<RENAVAM>' . $cteveirenavam . '</RENAVAM>';
                        }
                        if ($cteveiplaca != '') {
                            $cteveiplaca = removeTodosCaracterEspeciaisEspaco($cteveiplaca);
                            $txt .= '<placa>' . $cteveiplaca . '</placa>';
                        }
                        if ($cteveitara > 0) {
                            $txt .= '<tara>' . round($cteveitara, 0) . '</tara>';
                        }
                        if ($cteveicapacidadekg > 0) {
                            $txt .= '<capKG>' . round($cteveicapacidadekg, 0) . '</capKG>';
                        }
                        if ($cteveicapacidadem3 > 0) {
                            $txt .= '<capM3>' . round($cteveicapacidadem3, 0) . '</capM3>';
                        }
                        if ($cteveipropveiculo == 2) {
                            $txt .= '<tpProp>T</tpProp>';
                        } else {
                            $txt .= '<tpProp>P</tpProp>';
                        }
                        if ($cteveitpveiculo == 2) {
                            $txt .= '<tpVeic>1</tpVeic>';
                        } else {
                            $txt .= '<tpVeic>0</tpVeic>';
                        }
                        $txt .= '<tpRod>' . $cteveitprodadox . '</tpRod>';
                        $txt .= '<tpCar>' . $cteveitpcarroceriax . '</tpCar>';
                        if ($cteveiuf != '') {
                            $txt .= '<UF>' . $cteveiuf . '</UF>';
                        }
                        if ($cteveiempresa == 2) {
                            $txt .= '<prop>';
                            if ($cteveicpf != '') {
                                $cteveicpf = preg_replace("/[^0-9]/", "", $cteveicpf);
                                $txt .= '<CPF>' . $cteveicpf . '</CPF>';
                            } else if ($cteveicnpj != '') {
                                $cteveicnpj = preg_replace("/[^0-9]/", "", $cteveicnpj);
                                $txt .= '<CNPJ>' . $cteveicnpj . '</CNPJ>';
                            }
                            if ($cteveirntrc != '') {
                                $txt .= '<RNTRC>' . $cteveirntrc . '</RNTRC>';
                            }
                            if ($cteveirazao != '') {
                                $txt .= '<xNome>' . $cteveirazao . '</xNome>';
                            }
                            if ($cteveicpf != '') {
                                $txt .= '<IE>ISENTO</IE>';
                            } else {
                                if ($cteveiie != 'ISENTO') {
                                    $cteveiie = preg_replace("/[^0-9]/", "", $cteveiie);
                                }
                                if ($cteveiie != '') {
                                    $txt .= '<IE>' . $cteveiie . '</IE>';
                                }
                            }
                            if ($cteveipropuf != '') {
                                $txt .= '<UF>' . $cteveipropuf . '</UF>';
                            }
                            $txt .= '<tpProp>' . $cteveitpproprietariox . '</tpProp>';
                            $txt .= '</prop>';
                        }
                        $txt .= '</veic>';
                    }
                }

                //Lacres
                $sql2 = "Select * from cteinfolacre Where ctenumero = '$parametro'";
                $sql2 = pg_query($sql2);
                $row2 = pg_num_rows($sql2);
                if ($row2) {
                    for ($i2 = 0; $i2 < $row2; $i2++) {
                        $ctelacnome = trim(pg_fetch_result($sql2, $i2, "ctelacnome"));
                        $txt .= '<lacRodo>';
                        if ($ctelacnome != '') {
                            $txt .= '<nLacre>' . $ctelacnome . '</nLacre>';
                        }
                        $txt .= '</lacRodo>';
                    }
                }

                //Motoristas
                $sql2 = "Select * from cteinfomotoristas Where ctenumero = '$parametro'";
                $sql2 = pg_query($sql2);
                $row2 = pg_num_rows($sql2);
                if ($row2) {
                    for ($i2 = 0; $i2 < $row2; $i2++) {
                        $cteinfmotnome = trim(pg_fetch_result($sql2, $i2, "cteinfmotnome"));
                        $cteinfmotcpf = trim(pg_fetch_result($sql2, $i2, "cteinfmotcpf"));
                        $txt .= '<moto>';
                        if ($cteinfmotnome != '') {
                            $txt .= '<xNome>' . $cteinfmotnome . '</xNome>';
                        }
                        if ($cteinfmotcpf != '') {
                            $cteinfmotcpf = preg_replace("/[^0-9]/", "", $cteinfmotcpf);
                            $txt .= '<CPF>' . $cteinfmotcpf . '</CPF>';
                        }
                        $txt .= '</moto>';
                    }
                }


                $txt .= '</rodo>';
            }

            $txt .= '</infModal>';

            //Dados da Cobrança		
            $sql2 = "Select * from cteinfoduplicata Where ctenumero = '$parametro'";
            $sql2 = pg_query($sql2);
            $row2 = pg_num_rows($sql2);
            if (($ctecobrancanum != '' && $ctecobrancaval > 0) || $row2) {
                $txt .= '<cobr>';
                if ($ctecobrancanum != '' && $ctecobrancaval > 0) {
                    $txt .= '<fat>';
                    $txt .= '<nFat>' . $ctecobrancanum . '</nFat>';
                    $txt .= '<vOrig>' . number_format($ctecobrancaval, 2, '.', '') . '</vOrig>';
                    $txt .= '<vDesc>' . number_format($ctecobrancades, 2, '.', '') . '</vDesc>';
                    $txt .= '<vLiq>' . number_format($ctecobrancaliq, 2, '.', '') . '</vLiq>';
                    $txt .= '</fat>';
                }
                if ($row2) {
                    for ($i2 = 0; $i2 < $row2; $i2++) {
                        $ctedupnome = trim(pg_fetch_result($sql2, $i2, "ctedupnome"));
                        $ctedupvecto = trim(pg_fetch_result($sql2, $i2, "ctedupvecto"));
                        $ctedupvalor = trim(pg_fetch_result($sql2, $i2, "ctedupvalor"));
                        $txt .= '<dup>';
                        if ($ctedupnome != '') {
                            $txt .= '<nDup>' . $ctedupnome . '</nDup>';
                        }
                        if ($ctedupvecto != '') {
                            $txt .= '<dVenc>' . substr($ctedupvecto, 0, 10) . '</dVenc>';
                        }
                        $txt .= '<vDup>' . number_format($ctedupvalor, 2, '.', '') . '</vDup>';
                        $txt .= '</dup>';
                    }
                }
                $txt .= '</cobr>';
            }

            //Se for um CTE de Substituição 
            if ($tctcodigox == 3) {
                $txt .= '<infCteSub>';
                $txt .= '<chCte>' . $ctechavefin . '</chCte>';
                if ($ctesubstipo == 1 || $ctesubstipo == 0 || $ctesubstipo == '') {
                    $txt .= '<tomaICMS>';
                    $txt .= '<refCte>' . $ctesubschave . '</refCte>';
                    $txt .= '</tomaICMS>';
                } else if ($ctesubstipo == 2) {
                    $txt .= '<tomaICMS>';
                    $txt .= '<refNFe>' . $ctesubschave . '</refNFe>';
                    $txt .= '</tomaICMS>';
                } else {
                    $txt .= '<tomaNaoICMS>';
                    $txt .= '<refCteAnu>' . $ctesubschave . '</refCteAnu>';
                    $txt .= '</tomaNaoICMS>';
                }
                $txt .= '</infCteSub>';
            }


            $txt .= '</infCTeNorm>';
        }
        //Detalhamento do CT-e complementado
        else if ($tctcodigox == 1) {

            //Grupo de informações do CT-e Normal e Substituto
            $txt .= '<infCteComp>';
            $txt .= '<chave>' . $ctechavefin . '</chave>';
            $txt .= '</infCteComp>';
        }
        //Detalhamento do CT-e do tipo Anulação
        else if ($tctcodigox == 2) {

            //Grupo de informações do CT-e Normal e Substituto
            $txt .= '<infCteAnu>';
            $txt .= '<chCte>' . $ctechavefin . '</chCte>';
            if ($datatomador != '') {
                $txt .= '<dEmi>' . substr($datatomador, 0, 10) . '</dEmi>';
            }
            $txt .= '</infCteAnu>';
        }


        $txt .= '</infCte>';

        //Qr Code
        $txt .= '<infCTeSupl>';
        $txt .= '<qrCodCTe>' . '<![CDATA[https://nfe.fazenda.sp.gov.br/CTeConsulta/qrCode?chCTe=' . $chaveCte . '&tpAmb=' . trim($ambiente) . ']]>' . '</qrCodCTe>';
        $txt .= '</infCTeSupl>';

        $txt .= '</CTe>';

        if ($erroCte == '') {
            fputs($arquivo, $txt);
        }
    }


    if ($chaveCte == '') {
        $chaveCte = '_';
    }

    fclose($arquivo);

    if ($erroCte == '') {

        //$nomex = "/home/delta/cte_nfe_enviar/" . $infcteid . ".xml";
        $nomex = "/home/delta/cte/" . $infcteidarquivo . ".xml";
        if (file_exists($nomex)) {
            unlink($nomex);
        }
        rename($nome, $nomex);

        //print("<br>&nbsp;Arquivo gerado com sucesso!");

        $erroCte = '_';

        echo "<font color='green'>" . $chavenfe . ' CTe GERADO COM SUCESSO!' . "</font><br>";

        $logdata = date('Y-m-d H:i:s');
        $sqllog = "Insert into logimportacao (logdata,logemitente,lognfe,logchavenfe,logcontrole,logcte,logchavecte,logstatus,logerro) values ('$logdata','$emiteEmail','$numeroEmail','$chavenfe','$parametro','$ctenum','$chaveCte','CTE GERADO COM SUCESSO','')";
        pg_query($sqllog);
    } else {

        if (file_exists($nome)) {
            unlink($nome);
        }

        echo "<font color='red'>" . $chavenfe . ' ERRO : ' . $erroCte . '!' . "</font><br>";

        $logdata = date('Y-m-d H:i:s');
        $sqllog = "Insert into logimportacao (logdata,logemitente,lognfe,logchavenfe,logcontrole,logcte,logchavecte,logstatus,logerro) values ('$logdata','$emiteEmail','$numeroEmail','$chavenfe','$parametro','$ctenum','$chaveCte','FALHA NA GERACAO DO XML','$erroCte')";
        pg_query($sqllog);
    }
}

function dvCalcMod11($key_nfe) {
    $base = 9;
    $result = 0;
    $sum = 0;
    $factor = 2;

    for ($i = strlen($key_nfe); $i > 0; $i--) {
        $numbers[$i] = substr($key_nfe, $i - 1, 1);
        $partial[$i] = $numbers[$i] * $factor;
        $sum += $partial[$i];
        if ($factor == $base) {
            $factor = 1;
        }
        $factor++;
    }

    if ($result == 0) {
        $sum *= 10;
        $digit = $sum % 11;
        if ($digit == 10) {
            $digit = 0;
        }
        return $digit;
    } elseif ($result == 1) {
        $rest = $sum % 11;
        return $rest;
    }
}

//26/10/2016

function removeTodosCaracterEspeciaisEspaco($text) {
    $palavra = $text;
    if (version_compare(PHP_VERSION, '7.0.0', '<')) {
        $palavra = ereg_replace("[^a-zA-Z0-9]", "", strtr($palavra, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ-", "aaaaeeiooouucAAAAEEIOOOUUC"));
    } else {
        $palavra = preg_replace("[^a-zA-Z0-9]", "", strtr($palavra, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ-", "aaaaeeiooouucAAAAEEIOOOUUC"));
    }
    return $palavra;
}

function exibe_danfe($arquivo, $cte_numero) {

    $docxml = FilesFolders::readFile($arquivo);

    $danfe = new Danfe($docxml, 'P', 'A4', '', 'I', '');
    $id = $danfe->montaDANFE();
    //$teste = $danfe->printDANFE("$id.'.pdf', 'F');
    $teste = $danfe->printDANFE("/home/delta/cte_enviar/" . $cte_numero . "/NFe$id.pdf", 'F');
}
?>

