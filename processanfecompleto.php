<?php

require_once("include/conexao.inc.php");
require_once("include/banco.php");

$cadastro = new banco($conn, $db);

$usuario = trim($_GET["usuario"]);

header("Content-type: application/xml");

$origem = "arquivos/" . $usuario . "/";

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

//Se o Destinatario for de outro estado precisa mudar para 6353
$ctecfop = '5353';

$ctecargaval = 0;
$ctepropredominante = 'BRINQUEDO';

$ctevolumes = 0;
$ctepesobruto = 0;
$ctecubagem = 0;

$percnfe = 0;

$observacaoRecebedor = "";

$pasta = $origem;

$arquivo_processado = 0;

if (is_dir($pasta)) {
    $diretorio = dir($pasta);

    $arquivos = '';

    while ($arquivo = $diretorio->read()) {
        if (($arquivo != '.') && ($arquivo != '..')) {

            //echo $pasta.$arquivo.'<br>';
            #carrega o arquivo XML e retornando um Array
            $xml = simplexml_load_file($pasta . $arquivo);

            if ($xml) {


                //Monta a Chave 
                $nfeChave = '';
                $contador_atributos = 0;

                //Só Processa se a opção de Informações de NFe não for Null
                if ($xml->NFe->infNFe[0]) {

                    $arquivo_processado = 1;

                    foreach ($xml->NFe->infNFe[0]->attributes() as $a => $b) {
                        $contador_atributos++;
                        if ($contador_atributos == 1) {
                            $nfeChave = substr($b, 3);
                        }
                        //echo "$a = $b ";
                    }

                    $chavenfe = $nfeChave;

                    //echo $chavenfe.'<br>';
                    //Passa a gravar o CNPJ e CPF do Destinatario

                    if ($xml->NFe->infNFe->dest->CNPJ != '') {
                        $cnpjDest = $xml->NFe->infNFe->dest->CNPJ;
                    } else {
                        $cnpjDest = $xml->NFe->infNFe->dest->CPF;
                    }

                    $sql = "SELECT * FROM nfechave where usucodigo=$usuario and nfenome='$chavenfe'";
                    $sql = pg_query($sql);
                    $row = pg_num_rows($sql);
                    if ($row) {
                        
                    } else {
                        $cadastro->insere("nfechave", "(usucodigo,nfenome,cnpj)", "('$usuario','$chavenfe','$cnpjDest')");
                    }


                    //Se for o primeiro XML carrega dados do Remetente
                    if ($cteremrazao == '') {

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
                        $cteremie = $xml->NFe->infNFe->emit->IE;
                        $cteremcpf = $xml->NFe->infNFe->emit->CPF;
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
                    }

                    //Se for o primeiro XML carrega dados do Destinatario
                    if ($ctedesrazao == '') {
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
                        $ctedesie = $xml->NFe->infNFe->dest->IE;
                        $ctedescpf = $xml->NFe->infNFe->dest->CPF;
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

                        $sql2 = "Select id,descricao ";
                        $sql2 .= " From cidadesibge";
                        $sql2 .= " Where codestado = '$aux1' and codcidade = '$aux2'";

                        $nomeCidade = '';

                        $sql2 = pg_query($sql2);
                        $row2 = pg_num_rows($sql2);
                        if ($row2) {
                            $ctecidfinal = pg_fetch_result($sql2, 0, "id");
                            $nomeCidade = pg_fetch_result($sql2, 0, "descricao");
                        }

                        /* Se nao encontrou a cidade pelo Nome, faz nova busca pelo nome Ibge */
                        if ($ctedescidcodigo == 0 && $nomeCidade != '') {
                            $sql = "SELECT cidcodigo From cidades WHERE descricao = '$nomeCidade' and uf='$ctedesuf'";
                            $sql = pg_query($sql);
                            $row = pg_num_rows($sql);
                            if ($row) {
                                $ctedescidcodigo = pg_fetch_result($sql, 0, "cidcodigo");
                            }
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
                    }

                    //Se for o primeiro XML carrega dados do Recebedor
                    if ($cterecrazao == '') {

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

                        $cteemitente = soNumero($cteemitente);

                        if ($cteemitente == $xml->NFe->infNFe->transp->transporta->CNPJ) {
                            $reccodigo = '2';

                            //Verifica se tem percentual Cadastrado					
                            $cnpjcliente = formatar($xml->NFe->infNFe->transp->transporta->CNPJ);
                            $sql2 = "Select a.*,b.descricao,b.uf FROM clientescte a Left Join cidades as b on a.cidcodigo = b.cidcodigo where a.clicnpj='$cnpjcliente'";

                            $sql2 = pg_query($sql2);
                            $row2 = pg_num_rows($sql2);
                            if ($row2) {
                                $percnfe = pg_fetch_result($sql2, 0, "clinfe");
                            }

                            $observacaoRecebedor = "";
                        } else {

                            //Se não for a Alfaness os dados da Transportadora tem que vir apenas como observacoes
                            $reccodigo = '2';

                            //Verifica se a Transportadora está Cadastrada, caso sim usa os dados que estão mais Completos
                            if ($xml->NFe->infNFe->transp->transporta->CPF != '') {
                                //$cterecpessoa 		= '2';
                                $cnpjcliente = formatar($xml->NFe->infNFe->transp->transporta->CPF);
                                $sql2 = "Select a.*,b.descricao,b.uf FROM clientescte a Left Join cidades as b on a.cidcodigo = b.cidcodigo where a.clicpf='$cnpjcliente'";
                            } else {
                                //$cterecpessoa 		= '1';
                                $cnpjcliente = formatar($xml->NFe->infNFe->transp->transporta->CNPJ);
                                $sql2 = "Select a.*,b.descricao,b.uf FROM clientescte a Left Join cidades as b on a.cidcodigo = b.cidcodigo where a.clicnpj='$cnpjcliente'";
                            }
                        
                            $sql2 = pg_query($sql2);
                            $row2 = pg_num_rows($sql2);
                            if ($row2) {

                                $auxRazao = trim(pg_fetch_result($sql2, 0, "clirazao"));

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

                                $observacaoRecebedor = "Transporte subcontratado com {$auxRazao} {$cnpjcliente}. ";

                                $percnfe = pg_fetch_result($sql2, 0, "clinfe");
                            } else {

                                $auxRazao = trim($xml->NFe->infNFe->transp->transporta->xNome);

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

                                $observacaoRecebedor = "Transporte subcontratado com {$auxRazao} {$cnpjcliente}. ";
                            }
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
                }
            }
            unlink($pasta . $arquivo);
        }
    }

    $diretorio->close();
}

if ($arquivo_processado == 1) {

    if ($ctevolumes > 0 || $ctepesobruto > 0 || $ctecubagem > 0) {
        $sql = "delete FROM infocarga where usucodigo=$usuario";
        pg_query($sql);
        if ($ctevolumes > 0) {
            $cadastro->insere("infocarga", "(usucodigo,medcodigo,infnome,infvalor)", "('$usuario','4','VOLUME','$ctevolumes')");
        }
        if ($ctepesobruto > 0) {
            $cadastro->insere("infocarga", "(usucodigo,medcodigo,infnome,infvalor)", "('$usuario','2','PESO BRUTO','$ctepesobruto')");
        }
        if ($ctecubagem > 0) {
            $cadastro->insere("infocarga", "(usucodigo,medcodigo,infnome,infvalor)", "('$usuario','1','METROS CUBICOS','$ctecubagem')");
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
        $sql = "delete FROM infoseguro where usucodigo=$usuario";
        pg_query($sql);
        $cadastro->insere("infoseguro", "(usucodigo,rescodigo,segvalor,segnome,segapolice,segaverbacao)", "('$usuario','5','$ctecargaval','$ctesegnome','$ctesegapolice','')");

        $valorservico = round($ctecargaval * $percnfe / 100, 2);

        //Inclui os Servicos e Valor a Receber
        $sql = "delete FROM valorservico where usucodigo=$usuario";
        pg_query($sql);
        $cadastro->insere("valorservico", "(usucodigo,valvalor,valnome)", "('$usuario','$valorservico','TRANSP.PRODUTOS')");
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




    if (trim($cteremrazao) == "") {
        $cteremrazao = "0";
    }
    if (trim($cteremendereco) == "") {
        $cteremendereco = "0";
    }
    if (trim($cterembairro) == "") {
        $cterembairro = "0";
    }
    if (trim($cteremnumero) == "") {
        $cteremnumero = "0";
    }
    if (trim($cidrem) == "") {
        $cidrem = "0";
    }
    if (trim($cteremfone) == "") {
        $cteremfone = "0";
    }
    if (trim($cterempais) == "") {
        $cterempais = "0";
    }
    if (trim($cteremuf) == "") {
        $cteremuf = "0";
    }
    if (trim($cterempessoa) == "") {
        $cterempessoa = "0";
    }
    if (trim($cteremcep) == "") {
        $cteremcep = "0";
    }
    if (trim($cteremcnpj) == "") {
        $cteremcnpj = "0";
    }
    if (trim($cteremie) == "") {
        $cteremie = "0";
    }
    if (trim($cteremcpf) == "") {
        $cteremcpf = "0";
    }
    if (trim($remcodigo) == "") {
        $remcodigo = "0";
    }
    if (trim($cteremrg) == "") {
        $cteremrg = "0";
    }
    if (trim($cteremnguerra) == "") {
        $cteremnguerra = "0";
    }
    if (trim($cteremcomplemento) == "") {
        $cteremcomplemento = "0";
    }
    if (trim($cteremcidcodigo) == "") {
        $cteremcidcodigo = "0";
    }
    if (trim($cteremcidcodigoibge) == "") {
        $cteremcidcodigoibge = "0";
    }

    if (trim($ctedesrazao) == "") {
        $ctedesrazao = "0";
    }
    if (trim($ctedesendereco) == "") {
        $ctedesendereco = "0";
    }
    if (trim($ctedesbairro) == "") {
        $ctedesbairro = "0";
    }
    if (trim($ctedesnumero) == "") {
        $ctedesnumero = "0";
    }
    if (trim($ctedessuframa) == "") {
        $ctedessuframa = "0";
    }
    if (trim($ciddes) == "") {
        $ciddes = "0";
    }
    if (trim($ctedesfone) == "") {
        $ctedesfone = "0";
    }
    if (trim($ctedespais) == "") {
        $ctedespais = "0";
    }
    if (trim($ctedesuf) == "") {
        $ctedesuf = "0";
    }
    if (trim($ctedespessoa) == "") {
        $ctedespessoa = "0";
    }
    if (trim($ctedescep) == "") {
        $ctedescep = "0";
    }
    if (trim($ctedescnpj) == "") {
        $ctedescnpj = "0";
    }
    if (trim($ctedesie) == "") {
        $ctedesie = "0";
    }
    if (trim($ctedescpf) == "") {
        $ctedescpf = "0";
    }
    if (trim($descodigo) == "") {
        $descodigo = "0";
    }
    if (trim($ctedesrg) == "") {
        $ctedesrg = "0";
    }
    if (trim($ctedesnguerra) == "") {
        $ctedesnguerra = "0";
    }
    if (trim($ctedescomplemento) == "") {
        $ctedescomplemento = "0";
    }
    if (trim($ctedesuf) == "") {
        $ctedesuf = "0";
    }
    if (trim($ctedescidcodigo) == "") {
        $ctedescidcodigo = "0";
    }
    if (trim($ctedescidcodigoibge) == "") {
        $ctedescidcodigoibge = "0";
    }

    if (trim($cterecrazao) == "") {
        $cterecrazao = "0";
    }
    if (trim($cterecendereco) == "") {
        $cterecendereco = "0";
    }
    if (trim($cterecbairro) == "") {
        $cterecbairro = "0";
    }
    if (trim($cterecnumero) == "") {
        $cterecnumero = "0";
    }
    if (trim($cidrec) == "") {
        $cidrec = "0";
    }
    if (trim($cterecfone) == "") {
        $cterecfone = "0";
    }
    if (trim($cterecpais) == "") {
        $cterecpais = "0";
    }
    if (trim($cterecuf) == "") {
        $cterecuf = "0";
    }
    if (trim($cterecpessoa) == "") {
        $cterecpessoa = "0";
    }
    if (trim($ctereccep) == "") {
        $ctereccep = "0";
    }
    if (trim($ctereccnpj) == "") {
        $ctereccnpj = "0";
    }
    if (trim($cterecie) == "") {
        $cterecie = "0";
    }
    if (trim($ctereccpf) == "") {
        $ctereccpf = "0";
    }
    if (trim($reccodigo) == "") {
        $reccodigo = "0";
    }
    if (trim($cterecrg) == "") {
        $cterecrg = "0";
    }
    if (trim($cterecnguerra) == "") {
        $cterecnguerra = "0";
    }
    if (trim($ctereccomplemento) == "") {
        $ctereccomplemento = "0";
    }
    if (trim($cterecuf) == "") {
        $cterecuf = "0";
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

    if (trim($observacaoRecebedor) == "") {
        $observacaoRecebedor = "0";
    }



    //Sugere a data de Previsão de Entrega a 3 dias para SP e 5 dias para fora de SP
    $liberareal = date("d/m/Y");

    //Localiza a Cidade Final para pegar o prazo em dias:

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

    $cteindlocacao = 2;
    $tpgcodigo = 2;

    $xml = "<dados>
	<registro>
		<item>" . $cteremrazao . "</item>
		<item>" . $cteremendereco . "</item>
		<item>" . $cterembairro . "</item>
		<item>" . $cteremnumero . "</item>
		<item>" . $cidrem . "</item>
		<item>" . $cteremfone . "</item> 
		<item>" . $cterempais . "</item> 
		<item>" . $cteremuf . "</item> 	
		<item>" . $cterempessoa . "</item> 
		<item>" . $cteremcep . "</item> 
		<item>" . $cteremcnpj . "</item> 
		<item>" . $cteremie . "</item> 
		<item>" . $cteremcpf . "</item>	
		<item>" . $remcodigo . "</item> 
		<item>" . $cteremrg . "</item> 
		<item>" . $cteremnguerra . "</item> 
		<item>" . $cteremcomplemento . "</item> 
		<item>" . $cteremcidcodigo . "</item> 
		<item>" . $cteremcidcodigoibge . "</item>	 
		<item>" . $ctedesrazao . "</item> 
		<item>" . $ctedesendereco . "</item> 
		<item>" . $ctedesbairro . "</item>
		<item>" . $ctedesnumero . "</item>
		<item>" . $ciddes . "</item>
		<item>" . $ctedesfone . "</item> 
		<item>" . $ctedespais . "</item> 
		<item>" . $ctedesuf . "</item> 	
		<item>" . $ctedespessoa . "</item>
		<item>" . $ctedescep . "</item> 
		<item>" . $ctedescnpj . "</item> 
		<item>" . $ctedesie . "</item> 
		<item>" . $ctedescpf . "</item> 
		<item>" . $descodigo . "</item> 
		<item>" . $ctedesrg . "</item> 
		<item>" . $ctedesnguerra . "</item> 
		<item>" . $ctedescomplemento . "</item> 
		<item>" . $ctedescidcodigo . "</item> 
		<item>" . $ctedescidcodigoibge . "</item> 	
		<item>" . $ctedessuframa . "</item>
		<item>" . $cterecrazao . "</item> 
		<item>" . $cterecendereco . "</item> 
		<item>" . $cterecbairro . "</item> 
		<item>" . $cterecnumero . "</item> 
		<item>" . $cidrec . "</item> 
		<item>" . $cterecfone . "</item> 
		<item>" . $cterecpais . "</item> 
		<item>" . $cterecuf . "</item>		
		<item>" . $cterecpessoa . "</item> 
		<item>" . $ctereccep . "</item> 
		<item>" . $ctereccnpj . "</item> 
		<item>" . $cterecie . "</item>
		<item>" . $ctereccpf . "</item>
		<item>" . $reccodigo . "</item> 
		<item>" . $cterecrg . "</item> 
		<item>" . $cterecnguerra . "</item> 
		<item>" . $ctereccomplemento . "</item> 
		<item>" . $ctereccidcodigo . "</item> 
		<item>" . $ctereccidcodigoibge . "</item>	
		<item>" . $cteufinicio . "</item> 
		<item>" . $cteuffinal . "</item>		
		<item>" . $ctecidinicio . "</item> 
		<item>" . $ctecidfinal . "</item> 
		<item>" . $ctecfop . "</item> 
		<item>" . $ctecargaval . "</item>
		<item>" . $ctepropredominante . "</item>
		<item>" . $cterntrc . "</item>	
		<item>" . $ctereceber . "</item>
		<item>" . $ctetributos . "</item>
		<item>" . $sitcodigo . "</item>
		<item>" . $cteperreducao . "</item>
		<item>" . $ctebasecalculo . "</item>
		<item>" . $ctepericms . "</item>
		<item>" . $ctevalicms . "</item>
		<item>" . $ctecredito . "</item>
		<item>" . $ctepreencheicms . "</item>
		<item>" . $ctebaseicms . "</item>
		<item>" . $cteperinterna . "</item>
		<item>" . $cteperinter . "</item>
		<item>" . $cteperpartilha . "</item>
		<item>" . $ctevalicmsini . "</item>
		<item>" . $ctevalicmsfim . "</item>
		<item>" . $cteperpobreza . "</item>
		<item>" . $ctevalpobreza . "</item>
		<item>" . $liberareal . "</item>
		<item>" . $cteindlocacao . "</item>
		<item>" . $tpgcodigo . "</item>
		<item>" . $observacaoRecebedor . "</item>
	</registro>
	</dados>";
} else {
    $xml = "<dados>
	<registro>
		<item>!ERRO!</item>
	</registro>
	</dados>";
}

//die;
echo $xml;
pg_close($conn);
exit();

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
        case 'fonenovo':
            $string = '(' . substr($string, 0, 2) . ') ' . substr($string, 2, 5) .
                    '-' . substr($string, 7);
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

?>
