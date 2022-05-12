<?php

/**
 * gera arquivo segundo layout NOTFIS 3.1
 *
 * Visa fornecer uma cópia eletrônica das Notas Fiscais para a transportadora solicitada
 *
 *
 */
//pega da pasta de istalacao
$arr = explode("/", $_SERVER['REQUEST_URI']);
$root = $arr[1];

//pega as configurações do servidor
require_once($_SERVER['DOCUMENT_ROOT'] . "/$root/include/config.php");
require_once(DIR_ROOT . '/include/classes/JSON/JSON.php');
$json = new Services_JSON();

require_once('include/classes/PHPExcel/PHPExcel.php');

require_once('include/conexao.inc.php');
require_once("include/config.php");
require_once('include/funcoes/removeCaracterEspecial.php');
require_once('include/classes/JSON/JSON.php');
require_once('include/classes/Pedido.php');
require_once('include/classes/Cliente.php');
//require_once('modulos/cadastros/clientes/manutencao/model/ClienteModel.php');
//require_once('modulos/vendaAtacado/pedidos/manutencao/model/PedidoModel.php');

include 'include/jquery.php';

$path = DIR_ROOT . '/lib';
set_include_path(get_include_path() . PATH_SEPARATOR . $path);
require_once("Zend/Loader/Autoloader.php");

set_time_limit(0);

//$cadastro = new banco($conn,$db);

ob_implicit_flush(true);

$enviaEmail = 1;
$usuario = $_GET['usuario'];
$dti = $_GET['dataini'];
$dtf = $_GET['datafim'];
$datainicio = explode("/", $dti);
$datafim = explode("/", $dtf);

$auxdatainicio = $datainicio[2] . '-' . $datainicio[1] . '-' . $datainicio[0] . ' 00:00:00';
$auxdatafinal = $datafim[2] . '-' . $datafim[1] . '-' . $datafim[0] . ' 23:59:59';


$sql_geral = "SELECT a.*,b.tranguerra,b.notfisvers FROM romaneios a,transportador b 
                WHERE a.tracodigo=b.tracodigo AND a.romdata BETWEEN '$auxdatainicio' AND '$auxdatafinal' ORDER BY a.romcodigo";
$con_geral = pg_query($sql_geral);
$row_geral = pg_num_rows($con_geral);

if ($row_geral) {

    //PERCORRE ARRAY
    for ($i_geral = 0; $i_geral < $row_geral; $i_geral++) {

        $codigo = pg_fetch_result($con_geral, $i_geral, "romcodigo");
        $romnumero = trim(pg_fetch_result($con_geral, $i_geral, "romnumero")) . '/' . trim(pg_fetch_result($con_geral, $i_geral, "romano"));
        $transportadora = trim(pg_fetch_result($con_geral, $i_geral, "tranguerra"));
        $codtransp = trim(pg_fetch_result($con_geral, $i_geral, "tracodigo"));
        $romlocal = '';
        $romdata = trim(pg_fetch_result($con_geral, $i_geral, "romdata"));
        $romdata = substr($romdata, 8, 2) . '/' . substr($romdata, 5, 2) . '/' . substr($romdata, 0, 4);
        $notfisvers = pg_fetch_result($con_geral, $i_geral, "notfisvers");

        echo $romnumero . ' ' . $romdata . ' ' . $codtransp . ' ' . $transportadora . '<br>';
        ob_flush();

        //Fase 1 - Verifica qual processamento vai executar por vai depender da Transportadora
        //Processamento Loggi : Notfis ( X ) | Arquivo Especifico ( X ) | Anexar XML ( X )
        if ($codtransp == 15 || $codtransp == 11) {
            
            $retornoGeraNtF = geraArquivoNotfis($romnumero, $romdata, $transportadora, $romlocal, $codtransp, $enviaEmail);
            if ($retornoGeraNtF != null) {
                geraArquivoLoggi($romnumero, $usuario, $codtransp);
            } else {
                echo 'Problema na geração do Arquivo, favor avisar o Administrador !' . '<br>';
            }
            
        }
        //Processamento Total Express : Notfis ( X ) | Arquivo Especifico ( X ) | Anexar XML ( X )
        else if ($codtransp == 1) {
            //Gera o Arquivo Notfis sem enviar E-mail
            $retornoGeraNtF = geraArquivoNotfis($romnumero, $romdata, $transportadora, $romlocal, $codtransp, 2);
            if ($retornoGeraNtF != null) {
                geraArquivoTotal($romnumero, $usuario, $codtransp, $retornoGeraNtF);
            } else {
                echo 'Problema na geração do Arquivo NOTFIS, favor avisar o Administrador !' . '<br>';
            }
        }
        //Processamento Outras : Notfis ( X ) | Arquivo Especifico (   ) | Anexar XML ( X )
        else {
            $retornoGeraNtF = geraArquivoNotfis($romnumero, $romdata, $transportadora, $romlocal, $codtransp, $enviaEmail);
            if ($retornoGeraNtF != null) {
                
            } else {
                echo 'Problema na geração do Arquivo, favor avisar o Administrador !' . '<br>';
            }
        }


        echo '<hr>';
    }
}

echo 'Fim de Processamento!';

//Gera o Arquivo no Formato Total Express
function geraArquivoTotal($numeroRomaneio, $usuario, $codtransp, $arquivoNotfis) {

    echo '<br>';
    echo 'Geração do Arquivo de Integração formato Total Express ' . '<br>';
    echo '<br>';
    ob_flush();

    $numeroRomaneioSplited = explode("/", $numeroRomaneio);
    $romnumero = $numeroRomaneioSplited[0];
    $romano = $numeroRomaneioSplited[1];
    $romcodigo = 0;
    $xendereco = 2;
    $xmail = 1;

    //Localiza o Codigo Interno do Romaneio
    $pegar = "SELECT romcodigo FROM romaneios Where romnumero='$romnumero' and romano='$romano'";
    $cad = pg_query($pegar);
    $row = pg_num_rows($cad);
    if ($row) {
        $romcodigo = trim(pg_fetch_result($cad, 0, "romcodigo"));
    }

    //Monta o Where com todos os Pedidos do Romaneio Seleciona
    $pegar = "SELECT pvnumero FROM romaneiospedidos Where romcodigo=$romcodigo";
    $cad = pg_query($pegar);
    $row = pg_num_rows($cad);
    $where = '';
    if ($row) {

        for ($i = 0; $i < $row; $i++) {
            $auxpedido = trim(pg_fetch_result($cad, $i, "pvnumero"));
            if ($where == '') {
                $where = "where (a.pvnumero = '$auxpedido'";
            } else {
                $where = $where . " or a.pvnumero = '$auxpedido'";
            }
        }
        $where = $where . ")";
    }

    $nome = "/home/delta/total_express/pedidos.csv";

    if (file_exists($nome)) {
        unlink($nome);
    }

    $arquivo = fopen("$nome", "x+");

    $nome2 = "arquivos/totalexpress/pedidos.csv";

    if (file_exists($nome2)) {
        unlink($nome2);
    }

    $arquivo2 = fopen("$nome2", "x+");

    //Nao tem mais Cabeçalho
    //$txt = '#01 - Código do Layout;#02 - CNPJ do Remetente;#03 - Código Remessa;#04 - Tipo de Serviço;#05 - Tipo de Entrega (0-NORMAL / 1-TROCA / 2-RMA);#06 - Peso;#07 - Quantidade de Volumes;#08 - Condição do Frete (CIF/FOB);#09 – Número de Pedido;#10 – Código de Barras;#11 - Natureza do Produto;#12 - Tipo de Volume;#13 - Isenção de ICMS;#14 – Informações de RMA ou TROCA;#15 - Nome do Destinatário;#16 - CPF/CNPJ do Destinatário;#17 – Inscrição Estadual do Destinatário;#18 - Endereço do Destinatário;#19 – Número do Endereço do Destinatário;#20 - Complemento do Destinatário;#21 - Ponto de Referência do Destinatário;#22 - Bairro do Destinatário;#23 - Cidade do Destinatário;#24 - Estado do Destinatário;#25 – País do Destinatário;#26 - Cep do Destinatário;#27 - Email do Destinatário;#28 - Ddd do Destinatário;#29 - Telefone do Destinatário;#30 - Telefone2 do Destinatário;#31 - Telefone3 do Destinatário;#32 - C.O.D. (0=>não/1=>sim);#33 - C.O.D. Forma;#34 - C.O.D. Parcelas;#35 - C.O.D. Valor;#36 - Agendamento - Data para Entrega;#37 - Agendamento – Período para Entrega;#38 - Agendamento - Segundo Período para Entrega;#39 - NFe Número;#40 - NFe Série;#41 - NFe Data de Emissão;#42 - NFe Valor Total;#43 - NFe Valor Total dos Produtos;#44 - NFe CFOP Predominante;#45 - NFe Chave de Acesso';
    //fputs($arquivo, "$txt\r\n");

    $pegar = "SELECT c.clicnpj FROM clientes as c Where c.clicodigo = " . CLIENTE_TOY;

    $cad = pg_query($pegar);
    $row = pg_num_rows($cad);

    if ($row) {
        $cnpj = trim(pg_fetch_result($cad, 0, "clicnpj"));
    } else {
        $cnpj = '00000000000000';
    }

    $msgerro = '';

    $query = "select a.*,b.pvnumero,b.pvinternet,b.pvtipofrete,b.pvdest,c.clicodigo as cliente,c.clicod,c.clinguerra,c.clirazao,c.clicnpj,c.cliie,c.clipessoa,c.clist,c.clioptsimples,c.clicpf,c.clipais,d.natcod from notagua a 
	left join natureza d on a.natcodigo = d.natcodigo 
	left join pvenda b on a.pvnumero = b.pvnumero 
	left join clientes c on b.clicodigo = c.clicodigo 
	$where order by a.notemissao asc";

    $cad = pg_query($query);
    for ($i = 0; $i < pg_num_rows($cad); $i++) {
        $array = pg_fetch_object($cad);

        echo 'NFe: ' . $array->notnumero . ' - ' . $array->pvnumero . '<br>';
        ob_flush();

        //Looping nos itens para Calcular o Peso	
        $query3 = "select a.*,b.procod,b.proicms,b.propeso,b.proisento,c.clanumero,b.procod as codigo,b.prnome as nome,b.grucodigo as grupo,d.medsigla as sigla from ngitem a ";
        $query3 = $query3 . " left join produto b on a.procodigo = b.procodigo ";
        $query3 = $query3 . " left join clfiscal c on b.clacodigo = c.clacodigo ";
        $query3 = $query3 . " left join medidas d on b.medcodigo = d.medcodigo ";
        $query3 = $query3 . " Where a.ndnumero = " . $array->notnumero;
        $query3 = $query3 . " order by a.nditem asc ";

        $cad3 = pg_query($query3);

        $peso = 0;

        $natureza = '';
        $isento = 1;

        for ($i3 = 0; $i3 < pg_num_rows($cad3); $i3++) {
            $array3 = pg_fetch_object($cad3);

            if ($i3 == 0) {
                $natureza = substr($array3->nome, 0, 25);
            }

            if ($array3->proisento != '2') {
                $isento = 0;
            }

            $peso = $peso + ($array3->propeso * $array3->ndisaldo);
        }

        $peso = round($peso, 2);

        //Se tiver peso na Nota Importada do XML usa esse valor
        if ($array->pesobru > 0) {
            $peso = round($array->pesobru, 2);
        }

        //Vai passar a pegar os volumes da Conferência WMS
        $pegarest = "SELECT pvfvolume 
			FROM pvendafinalizado 		
			Where pvnumero = " . $array->pvnumero;
        $cadest = pg_query($pegarest);
        $rowest = pg_num_rows($cadest);
        if ($rowest) {
            $volumes = trim(pg_fetch_result($cadest, 0, "pvfvolume"));
        } else {
            $volumes = $array->notvolumes;
        }

        //Vai passar a usar os Volumes da Tabela de Romaneios (23/11/2016)
        $sql_aux = "SELECT rpvolumes FROM romaneiospedidos where pvnumero = " . $array->pvnumero;
        $con_aux = pg_query($sql_aux);
        $notvolumes_rom = 0;
        if (pg_num_rows($con_aux)) {
            $notvolumes_rom = pg_fetch_result($con_aux, 0, "rpvolumes");
        }
        if ($notvolumes_rom > 0) {
            $volumes = $notvolumes_rom;
        }

        if ($volumes == '' || $volumes == '0' || $volumes == 0) {
            $volumes = '1';
        }

        if ($array->pvtipofrete == 2) {
            ;
            $tipoFrete = 'FOB';
        } else {
            $tipoFrete = 'CIF';
        }

        $remessa = '';
        $tipoServico = '1';
        $tipoEntrega = '0';

        $numeroPedido = $array->pvinternet;

        $numeroCliente = '';
        $tipoVolume = '';

        $infoColeta = '';

        $destinatario = $array->clirazao;
        if ($array->pvdest != '') {
            $destinatario = $array->pvdest;
        }

        if ($array->clipessoa == '2') {
            $cpfcnpj = trim($array->clicpf);
            $ie = '';
        } else {
            $cpfcnpj = trim($array->clicnpj);
            $ie = trim($array->cliie);

            $caracteres = 0;
            $caracteres += strlen($ie);
            $vaix = '';
            $ixx = 0;
            for ($ixx = 0; $ixx < $caracteres; $ixx++) {
                if (is_numeric(substr($ie, $ixx, 1))) {
                    $vaix = $vaix . substr($ie, $ixx, 1);
                }
            }
            $ie = $vaix;
        }

        $clicodigo = $array->cliente;

        $pais = $array->clipais;


        $endereco = '';
        $numero = '';
        $comple = '';
        $refer = '';
        $bairro = '';
        $cidade = '';
        $estado = '';
        $cep = '';
        $emailx = '';
        $ddd = '';
        $fone = '';
        $fone2 = '';
        $fone3 = '';

        $cidibge = '';
        $cidcorr = '';

        if ($clicodigo != 0) {
            $pegarest = "SELECT a.cleendereco,a.clecep,a.clefone,b.descricao,b.uf,a.clebairro as bairro,c.descricao as ibge,a.clenumero,a.clecomplemento,a.cleemail
			FROM cliefat a
			LEFT JOIN cidades as b on a.cidcodigo = b.cidcodigo
			LEFT JOIN cidadesibge as c on cast(substr(a.cidcodigoibge,1,2) as integer) = c.codestado and cast(substr(a.cidcodigoibge,3,5) as character varying(5)) = c.codcidade
			Where a.clicodigo = '$clicodigo'";

            $cadest = pg_query($pegarest);
            $rowest = pg_num_rows($cadest);

            if ($rowest) {

                $endereco = trim(pg_fetch_result($cadest, 0, "cleendereco"));
                $numero = trim(pg_fetch_result($cadest, 0, "clenumero"));
                $comple = trim(pg_fetch_result($cadest, 0, "clecomplemento"));

                $cidade = trim(pg_fetch_result($cadest, 0, "ibge"));
                if (trim($cidade) == '') {
                    $cidade = trim(pg_fetch_result($cadest, 0, "descricao"));
                }

                $cidibge = trim(pg_fetch_result($cadest, 0, "ibge"));
                $cidcorr = trim(pg_fetch_result($cadest, 0, "descricao"));

                $estado = delimitador(trim(pg_fetch_result($cadest, 0, "uf")), 4, 'L', ' '); // Estado
                $cep = (pg_fetch_result($cadest, 0, "clecep"));
                $fone = trim(pg_fetch_result($cadest, 0, "clefone"));
                $fone = preg_replace("/[^0-9]/", "", $fone);
                $bairro = trim(pg_fetch_result($cadest, 0, "bairro"));
                $emailx = (pg_fetch_result($cadest, 0, "cleemail"));
            }
        }


        //Se o endereço escolhido for dos pedidos
        if ($xendereco == 2) {

            $parametro = $array->pvnumero;

            //Verifica se existe o Endereço
            //Localiza os Dados do Endereço do Pedido
            $sql2 = "SELECT * FROM pedidoendereco
				WHERE pvnumero = '$parametro'";

            //EXECUTA A QUERY
            $sql2 = pg_query($sql2);

            $row2 = pg_num_rows($sql2);

            //VERIFICA SE VOLTOU ALGO
            if ($row2) {

                $acep = pg_fetch_result($sql2, 0, "pvcep");
                $aendereco = pg_fetch_result($sql2, 0, "pvendereco");
                $anumero = pg_fetch_result($sql2, 0, "pvnum");
                $acomplemento = pg_fetch_result($sql2, 0, "pvcomplemento");
                $abairro = pg_fetch_result($sql2, 0, "pvbairro");
                $acidade = pg_fetch_result($sql2, 0, "pvcidade");
                $auf = pg_fetch_result($sql2, 0, "pvuf");

                if ($acep == '') {
                    $acep = '_';
                }
                if ($aendereco == '') {
                    $aendereco = '_';
                }
                if ($anumero == '') {
                    $anumero = '0';
                }
                if ($acomplemento == '') {
                    $acomplemento = '_';
                }
                if ($abairro == '') {
                    $abairro = '_';
                }
                if ($acidade == '') {
                    $acidade = '_';
                }
                if ($auf == '') {
                    $auf = '_';
                }

                if ($acep != '_') {
                    $endereco = trim($aendereco);
                    $numero = trim($anumero);
                    $comple = trim($acomplemento);
                    $cidade = trim($acidade);
                    $estado = trim($auf);
                    $cep = trim($acep);
                    $bairro = trim($abairro);
                }
            }
        }



        $codservi = 0;
        $codpagto = '';
        $codparce = '';
        $codvalor = '';

        $agdata = '';
        $agper1 = '';
        $agper2 = '';

        $nfenumero = $array->notnumero;
        $nfeserie = '1';

        $nfedata = substr($array->notemissao, 8, 2) . '/' . substr($array->notemissao, 5, 2) . '/' . substr($array->notemissao, 0, 4);

        $nfevalor = $array->notvalor;
        $nfeprod = $array->notvalor - $array->notipi;

        $nfecfop = substr($array->natcod, 0, 1) . substr($array->natcod, 2, 3);

        $nfechave = $array->chave;

        $erro = 0;

        if ($estado == '') {
            $msgerro .= "<br /><br /><h5>" . "Pedido Vtex : " . $numeroPedido . " Pedido Max : " . $array->pvnumero . " Erro : ESTADO EM BRANCO " . '</ h5>';
            $erro = 1;
        }

        if ($cidcorr == '') {
            $msgerro .= "<br /><br /><h5>" . "Pedido Vtex : " . $numeroPedido . " Pedido Max : " . $array->pvnumero . " Erro : CIDADE EM BRANCO " . '</ h5>';
            $erro = 1;
        }

        if ($cidibge == '') {
            $msgerro .= "<br /><br /><h5>" . "Pedido Vtex : " . $numeroPedido . " Pedido Max : " . $array->pvnumero . " Erro : CIDADE IBGE EM BRANCO " . '</ h5>';
            $erro = 1;
        }

        if ($numero == '') {
            $msgerro .= "<br /><br /><h5>" . "Pedido Vtex : " . $numeroPedido . " Pedido Max : " . $array->pvnumero . " Erro : NUMERO DO ENDERECO EM BRANCO " . '</ h5>';
            $erro = 1;
        }

        if ($bairro == '') {
            $msgerro .= "<br /><br /><h5>" . "Pedido Vtex : " . $numeroPedido . " Pedido Max : " . $array->pvnumero . " Erro : BAIRRO EM BRANCO " . '</ h5>';
            $erro = 1;
        }

        if ($erro == 0) {
            if ($numero == '' || $numero == '0') {
                $numero = 'SN';
            }

            $bairro = substr($bairro, 0, 40);

            /*
              if ($numeroPedido == '' || $numeroPedido == '0') {
              $vaipedido = $array->pvnumero;
              } else {
              $vaipedido = $numeroPedido;
              }
             * 
             */

            $vaipedido = $array->pvnumero;

            //Compelemento com limite de 60 Caracteres
            $comple = substr($comple, 0, 60);

            $txt = 'TOTAL20' . ';' . $cnpj . ';' . $remessa . ';' . $tipoServico . ';' . $tipoEntrega . ';' . $peso . ';' . $volumes . ';' . $tipoFrete . ';' . $vaipedido . ';' . $numeroCliente . ';' . $natureza . ';' . $tipoVolume . ';' . $isento . ';' . $infoColeta . ';' . $destinatario . ';' . $cpfcnpj . ';' . $ie . ';' . $endereco . ';' . $numero . ';' . $comple . ';' . $refer . ';' . $bairro . ';' . $cidade . ';' . $estado . ';' . $pais . ';' . $cep . ';' . $emailx . ';' . $ddd . ';' . $fone . ';' . $fone2 . ';' . $fone3 . ';' . $codservi . ';' . $codpagto . ';' . $codparce . ';' . $codvalor . ';' . $agdata . ';' . $agper1 . ';' . $agper2 . ';' . $nfenumero . ';' . $nfeserie . ';' . $nfedata . ';' . $nfevalor . ';' . $nfeprod . ';' . $nfecfop . ';' . $nfechave;
            fputs($arquivo, "$txt\r\n");
            fputs($arquivo2, "$txt\r\n");

            $data_total = date("Y-m-d H:i:s");

            //Atualiza a data / hora da Exportacao Total Express
            $sql2 = "Update pvenda set pvtotal='$data_total' WHERE pvnumero = " . $array->pvnumero;
            pg_query($sql2);
        }
    }

    fclose($arquivo);

    fclose($arquivo2);

    //print("<br>&nbsp;Arquivo /home/delta/total_express/pedidos.csv gerado com sucesso!");
    //print("<br>&nbsp;Arquivo " . DIR_HOME . "/total_express/pedidos.csv gerado com sucesso!");

    if ($xmail == 1) {

        //Usa os dados da tabela de Parametros
        $sqlmail = "Select * from parametrosemail where tipo=6 LIMIT 1";
        //$sqlmail = "Select * from parametrosemail where tipo=1 LIMIT 1";
        $cadmail = pg_query($sqlmail);
        if (pg_num_rows($cadmail)) {
            $paremail = pg_fetch_result($cadmail, 0, "email");
            $parsenha = pg_fetch_result($cadmail, 0, "senha");
            $parsmtp = pg_fetch_result($cadmail, 0, "smtp");
            $parporta = pg_fetch_result($cadmail, 0, "usuario");
            $smtpuser = pg_fetch_result($cadmail, 0, "smtpuser");
            $smtppass = pg_fetch_result($cadmail, 0, "smtppass");
        } else {
            $paremail = '';
            $parsenha = '';
            $parsmtp = '';
            $parporta = '';
            $smtpuser = '';
            $smtppass = '';
        }
        $from = $paremail;

        $nomedoarquivo = "totalexpress" . date("YmdHis") . '.txt';
        $acao = "1";
        $id = "'";

        $destinatarios = '';
        $remetente = $from;
        $assunto = '';
        $mensagem = '';

        $data = date("Y-m-d");
        $aux = getdate();
        $data = substr($data, 0, 10) . ' ' . $aux['hours'] . ':' . $aux['minutes'] . ":" . $aux['seconds'] . '-03';

        $path = DIR_ROOT . '/lib';
        set_include_path(get_include_path() . PATH_SEPARATOR . $path);
        require_once("Zend/Loader/Autoloader.php");

        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->setFallbackAutoloader(true);

        $data = date("d/m/Y H:i:s");

        //configura para envio de email
        if (!$smtpuser) {
            $config = array("auth" => "login", "username" => $paremail, "password" => $parsenha, "port" => $parporta);
        } else {
            $config = array("ssl" => "tls", "auth" => "login", "username" => $smtpuser, "password" => $smtppass, "port" => $parporta);
        }
        $tr = new Zend_Mail_Transport_Smtp($parsmtp, $config);

        Zend_Mail::setDefaultTransport($tr);
        //funcao para envio de email - Zend_Mail
        $mail = new Zend_Mail();

        //$mail->setFrom ($remetente, "Workflow MAXTrade");
        $mail->setFrom($remetente, "Workflow Toymania");

        $email = "";

        $sql = "Select totemail FROM totalemail";
        $sql = pg_query($sql);
        $row = pg_num_rows($sql);
        if ($row) {
            //PERCORRE ARRAY
            for ($i = 0; $i < $row; $i++) {
                if ($email == '') {
                    $email = pg_fetch_result($sql, $i, "totemail");
                } else {
                    $email = $email . ";" . pg_fetch_result($sql, $i, "totemail");
                }
            }
        }

        //Envia para todos os Contatos da Transportadora
        $sql = "Select traemail FROM transportadorcontato where tracodigo=$codtransp";
        $sql = pg_query($sql);
        $row = pg_num_rows($sql);
        if ($row) {
            //PERCORRE ARRAY
            for ($i = 0; $i < $row; $i++) {
                if ($email == '') {
                    $email = pg_fetch_result($sql, $i, "traemail");
                } else {
                    $email = $email . ";" . pg_fetch_result($sql, $i, "traemail");
                }
            }
        }

        //Envia para usuarios cadastrados no Notfis 	
        $sql = "Select notmail FROM notemail";
        $sql = pg_query($sql);
        $row = pg_num_rows($sql);
        if ($row) {
            //PERCORRE ARRAY
            for ($i = 0; $i < $row; $i++) {
                if ($email == '') {
                    $email = pg_fetch_result($sql, $i, "notmail");
                } else {
                    $email = $email . ";" . pg_fetch_result($sql, $i, "notmail");
                }
            }
        }

        $texto = $email;

        $mails = explode(";", $texto);

        foreach ($mails as $value) {

            if (trim($value)) {

                $mail->addTo(trim(strtolower($value)));
                $destinatarios .= trim(strtolower($value));
            }
        }

        $msg .= "<br /><b>" . nl2br($msg1) . "</b>";
        $msg = str_replace('_', '', $msg);


        //$mail->setSubject("Arquivo Total Express");	
        //$msg .= "<br /><br /><h5>" . "Segue em anexo arquivo Toymania" . '</ h5>';
        //$msg .= "<br /><br /><h5>" . $data .'</ h5>';


        $mail->setSubject("NotFis Toy Mania - " . $numeroRomaneio);

        $msg .= "<br /><br /><h5>" . "Segue em anexo arquivo NotFis com pedidos exportados da Toymania" . '</ h5>';

        $msg .= "<br /><br /><h5>" . "Romaneio : " . $numeroRomaneio . '</ h5>';

        $msg .= "<br /><br /><h5>" . $data . '</ h5>';



        $mail->setBodyHTML($msg);

        $diretorio = 'arquivos/totalexpress';

        if (is_dir($diretorio)) {

            $file = $diretorio . '/pedidos.csv';


            $at = new Zend_Mime_Part(file_get_contents($file));
            $at->filename = basename($file);
            $at->disposition = Zend_Mime::DISPOSITION_ATTACHMENT;
            //$at->encoding = Zend_Mime::ENCODING_8BIT;
            $at->encoding = Zend_Mime::ENCODING_BASE64;
            $mail->addAttachment($at);
        }

        //Adiciona o arquivo Notfis Gerado 
        $diretorio = 'arquivos/notfis';
        if (is_dir($diretorio)) {
            $file = $diretorio . '/' . $arquivoNotfis;
            $at = new Zend_Mime_Part(file_get_contents($file));
            $at->filename = basename($file);
            $at->disposition = Zend_Mime::DISPOSITION_ATTACHMENT;
            //$at->encoding = Zend_Mime::ENCODING_8BIT;
            $at->encoding = Zend_Mime::ENCODING_BASE64;
            $mail->addAttachment($at);
        }

        if ($where != '') {
            //Vai fazer um Looping para Processar todos os XMLS 
            $query = "select a.notnumero from notagua a 		
			$where order by a.notemissao asc";

            $cad = pg_query($query);
            for ($i = 0; $i < pg_num_rows($cad); $i++) {
                $array = pg_fetch_object($cad);

                $nomexml = ESTABELECIMENTO_TOY . '001' . str_pad($array->notnumero, 7, "0", STR_PAD_LEFT) . '.xml';

                //$aquivoxml = "/home/delta/datasul_toymania/datasul_nfe_copia/" . $nomexml;
                $aquivoxml = "/home/delta/datasul_nfe_copia_50/" . $nomexml;

                if (file_exists($aquivoxml)) {

                    $file = $aquivoxml;

                    $at = new Zend_Mime_Part(file_get_contents($file));
                    $at->filename = basename($file);
                    $at->disposition = Zend_Mime::DISPOSITION_ATTACHMENT;
                    //$at->encoding = Zend_Mime::ENCODING_8BIT;
                    $at->encoding = Zend_Mime::ENCODING_BASE64;

                    $mail->addAttachment($at);
                }

                //echo 'NFe: ' . $array->notnumero . ' - ' . $nomexml . '<br>';
                //ob_flush();
            }
        }

        try {
            $mail->send();
            print("<br>");
            print("<br>");
            print("E-mail Encaminhado!");
            logEmail("EMAIL ENCAMINHADO ", $nomedoarquivo, $texto, $remetente, $assunto, $mensagem, date("Y-m-d H:i:s"));
        } catch (Exception $e) {
            print("<br>");
            print("<br>");
            print("NAO FOI POSSIVEL ENVIAR O EMAIL" . $e->getMessage());
            logEmail("NAO FOI POSSIVEL ENVIAR O EMAIL" . $e->getMessage(), $nomedoarquivo, $texto, $remetente, $assunto, $mensagem, date("Y-m-d H:i:s"), true);
        }
    }

    //Se tiver erro manda e-mail:			
    if ($msgerro != '') {

        //Usa os dados da tabela de Parametros
        $sqlmail = "Select * from parametrosemail where tipo=6 LIMIT 1";
        //$sqlmail = "Select * from parametrosemail where tipo=1 LIMIT 1";
        $cadmail = pg_query($sqlmail);
        if (pg_num_rows($cadmail)) {
            $paremail = pg_fetch_result($cadmail, 0, "email");
            $parsenha = pg_fetch_result($cadmail, 0, "senha");
            $parsmtp = pg_fetch_result($cadmail, 0, "smtp");
            $parporta = pg_fetch_result($cadmail, 0, "usuario");
            $smtpuser = pg_fetch_result($cadmail, 0, "smtpuser");
            $smtppass = pg_fetch_result($cadmail, 0, "smtppass");
        } else {
            $paremail = '';
            $parsenha = '';
            $parsmtp = '';
            $parporta = '';
            $smtpuser = '';
            $smtppass = '';
        }
        $from = $paremail;

        $nomedoarquivo = 'errototal' . date("YmdHis") . '.txt';
        $acao = "1";
        $id = "'";

        $destinatarios = '';
        $remetente = $from;
        $assunto = '';
        $mensagem = '';

        $msg = '';

        $data = date("Y-m-d");
        $aux = getdate();
        $data = substr($data, 0, 10) . ' ' . $aux['hours'] . ':' . $aux['minutes'] . ":" . $aux['seconds'] . '-03';

        $path = DIR_ROOT . '/lib';
        set_include_path(get_include_path() . PATH_SEPARATOR . $path);
        require_once("Zend/Loader/Autoloader.php");

        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->setFallbackAutoloader(true);


        $data = date("d/m/Y H:i:s");

        //configura para envio de email
        if (!$smtpuser) {
            $config = array("auth" => "login", "username" => $paremail, "password" => $parsenha, "port" => $parporta);
        } else {
            $config = array("ssl" => "tls", "auth" => "login", "username" => $smtpuser, "password" => $smtppass, "port" => $parporta);
        }
        $tr = new Zend_Mail_Transport_Smtp($parsmtp, $config);

        Zend_Mail::setDefaultTransport($tr);
        //funcao para envio de email - Zend_Mail
        $mail = new Zend_Mail();

        //$mail->setFrom ($remetente, "Workflow MAXTrade");
        $mail->setFrom($remetente, "Workflow Toymania");

        $email = '';

        $where = "usucodigo = $usuario or usucodigo = 359";

        $sql = "Select usuemail FROM usuarios where $where ";
        $sql = pg_query($sql);
        $row = pg_num_rows($sql);
        if ($row) {
            //PERCORRE ARRAY
            for ($i = 0; $i < $row; $i++) {
                if ($i == 0) {
                    $email = pg_fetch_result($sql, $i, "usuemail");
                } else {
                    $email = $email . ";" . pg_fetch_result($sql, $i, "usuemail");
                }
            }
        }

        /*
          $sql = "Select divemail FROM divergenciaemail";
          $sql = pg_query($sql);
          $row = pg_num_rows($sql);
          if($row)
          {
          //PERCORRE ARRAY
          for($i=0; $i<$row; $i++)
          {

          $email = $email.";".pg_fetch_result($sql, $i, "divemail");

          }

          }
         */

        $texto = $email;

        $mails = explode(";", $texto);

        foreach ($mails as $value) {

            if (trim($value)) {

                $mail->addTo(trim(strtolower($value)));
                $destinatarios .= trim(strtolower($value));
            }
        }

        $mail->setSubject("Erro na Exportação Total Express");

        $msg .= "<br /><br /><h5>" . $data . '</ h5>';

        $msg .= $msgerro;

        $mail->setBodyHTML($msg);

        try {
            $mail->send();
            print("<br>");
            print("<br>");
            print("E-mail de Erros Encaminhado!");
            logEmail("EMAIL ENCAMINHADO ", $nomedoarquivo, $texto, $remetente, $assunto, $mensagem, date("Y-m-d H:i:s"));
            //print true;
        } catch (Exception $e) {
            print("<br>");
            print("<br>");
            print("NAO FOI POSSIVEL ENVIAR O EMAIL DE ERROS " . $e->getMessage());
            logEmail("NAO FOI POSSIVEL ENVIAR O EMAIL" . $e->getMessage(), $nomedoarquivo, $texto, $remetente, $assunto, $mensagem, date("Y-m-d H:i:s"), true);
        }
    }
}

//Gera o Arquivo no Formato Loggi
function geraArquivoLoggi($numeroRomaneio, $usuario, $codtransp) {

    echo '<br>';
    echo 'Geração do Arquivo de Integração formato Loggi ' . '<br>';
    echo '<br>';
    ob_flush();

    $numeroRomaneioSplited = explode("/", $numeroRomaneio);
    $romnumero = $numeroRomaneioSplited[0];
    $romano = $numeroRomaneioSplited[1];
    $romcodigo = 0;
    $xendereco = 2;



    //Localiza o Codigo Interno do Romaneio
    $pegar = "SELECT romcodigo FROM romaneios Where romnumero='$romnumero' and romano='$romano'";
    $cad = pg_query($pegar);
    $row = pg_num_rows($cad);
    if ($row) {
        $romcodigo = trim(pg_fetch_result($cad, 0, "romcodigo"));
    }

    //Monta o Where com todos os Pedidos do Romaneio Seleciona
    $pegar = "SELECT pvnumero FROM romaneiospedidos Where romcodigo=$romcodigo";
    $cad = pg_query($pegar);
    $row = pg_num_rows($cad);
    $where = '';
    if ($row) {

        for ($i = 0; $i < $row; $i++) {
            $auxpedido = trim(pg_fetch_result($cad, $i, "pvnumero"));
            if ($where == '') {
                $where = "where (a.pvnumero = '$auxpedido'";
            } else {
                $where = $where . " or a.pvnumero = '$auxpedido'";
            }
        }
        $where = $where . ")";
    }

    $arquivo = '/home/delta/loggi/pedidos' . date("YmdHis") . '.xlsx';
    $destino = '/home/delta/loggi/';

    if (file_exists($arquivo)) {
        unlink($arquivo);
    }

    // Criar um novo objecto PHPExcel
    $objPHPExcel = new PHPExcel();

    $objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri')
            ->setSize(10);

    $nomeplanilha = "pedidos";

    $objPHPExcel->getActiveSheet()->setTitle($nomeplanilha);


    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'External ID');
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'Endereco');
    $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', 'Complemento');
    $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', 'Nome do Contato');
    $objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', 'Telefone do Contato');
    $objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', 'Email do Contato');
    $objPHPExcel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', 'Descricao');
    $objPHPExcel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true);

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', 'Tamanho');
    $objPHPExcel->getActiveSheet()->getStyle('H1')->getFont()->setBold(true);

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', 'Nome do Deposito');
    $objPHPExcel->getActiveSheet()->getStyle('I1')->getFont()->setBold(true);

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', 'ID Orcamento Loggi');
    $objPHPExcel->getActiveSheet()->getStyle('J1')->getFont()->setBold(true);

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1', 'Status');
    $objPHPExcel->getActiveSheet()->getStyle('K1')->getFont()->setBold(true);

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L1', 'Chave NFe');
    $objPHPExcel->getActiveSheet()->getStyle('L1')->getFont()->setBold(true);

    $sheet = $objPHPExcel->getActiveSheet();

    $sheet->getStyle('A1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

    $sheet->getStyle('B1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

    $sheet->getStyle('C1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

    $sheet->getStyle('D1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

    $sheet->getStyle('E1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

    $sheet->getStyle('F1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

    $sheet->getStyle('G1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

    $sheet->getStyle('H1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

    $sheet->getStyle('I1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

    $sheet->getStyle('J1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

    $sheet->getStyle('K1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

    $sheet->getStyle('L1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

    $objPHPExcel->getActiveSheet()->getStyle('A1:A1')->getBorders()->getOutline()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
    $objPHPExcel->getActiveSheet()->getStyle('B1:B1')->getBorders()->getOutline()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
    $objPHPExcel->getActiveSheet()->getStyle('C1:C1')->getBorders()->getOutline()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
    $objPHPExcel->getActiveSheet()->getStyle('D1:D1')->getBorders()->getOutline()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
    $objPHPExcel->getActiveSheet()->getStyle('E1:E1')->getBorders()->getOutline()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
    $objPHPExcel->getActiveSheet()->getStyle('F1:F1')->getBorders()->getOutline()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
    $objPHPExcel->getActiveSheet()->getStyle('G1:G1')->getBorders()->getOutline()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
    $objPHPExcel->getActiveSheet()->getStyle('H1:H1')->getBorders()->getOutline()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
    $objPHPExcel->getActiveSheet()->getStyle('I1:I1')->getBorders()->getOutline()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
    $objPHPExcel->getActiveSheet()->getStyle('J1:J1')->getBorders()->getOutline()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
    $objPHPExcel->getActiveSheet()->getStyle('K1:K1')->getBorders()->getOutline()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
    $objPHPExcel->getActiveSheet()->getStyle('L1:L1')->getBorders()->getOutline()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

    cellColor('A1', 'C1FFC1', $objPHPExcel);
    cellColor('B1', 'C1FFC1', $objPHPExcel);
    cellColor('C1', 'C1FFC1', $objPHPExcel);
    cellColor('D1', 'C1FFC1', $objPHPExcel);
    cellColor('E1', 'C1FFC1', $objPHPExcel);
    cellColor('F1', 'C1FFC1', $objPHPExcel);
    cellColor('G1', 'C1FFC1', $objPHPExcel);
    cellColor('H1', 'C1FFC1', $objPHPExcel);
    cellColor('I1', 'C1FFC1', $objPHPExcel);
    cellColor('J1', 'C1FFC1', $objPHPExcel);
    cellColor('K1', 'C1FFC1', $objPHPExcel);
    cellColor('L1', 'C1FFC1', $objPHPExcel);

    $ultima = 1;

    //Segunda Planilha que será enviada para Loggi
    $uploaddir_b = 'arquivos/loggi/';
    $destino_b = $uploaddir_b;
    if (!is_dir($destino_b)) {
        mkdir($destino_b, 0755);
    }

    $arquivo_b = 'arquivos/loggi/pedidos' . date("YmdHis") . '.xlsx';
    if (file_exists($arquivo_b)) {
        unlink($arquivo_b);
    }

    // Criar um novo objecto PHPExcel
    $objPHPExcel_b = new PHPExcel();

    $objPHPExcel_b->getDefaultStyle()->getFont()->setName('Calibri')
            ->setSize(10);

    $nomeplanilha = "pedidos";

    $objPHPExcel_b->getActiveSheet()->setTitle($nomeplanilha);


    $objPHPExcel_b->setActiveSheetIndex(0)->setCellValue('A1', 'address');
    $objPHPExcel_b->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

    $objPHPExcel_b->setActiveSheetIndex(0)->setCellValue('B1', 'address_number');
    $objPHPExcel_b->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);

    $objPHPExcel_b->setActiveSheetIndex(0)->setCellValue('C1', 'address_complement');
    $objPHPExcel_b->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);

    $objPHPExcel_b->setActiveSheetIndex(0)->setCellValue('D1', 'cep');
    $objPHPExcel_b->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);

    $objPHPExcel_b->setActiveSheetIndex(0)->setCellValue('E1', 'instructions');
    $objPHPExcel_b->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);

    $objPHPExcel_b->setActiveSheetIndex(0)->setCellValue('F1', 'width');
    $objPHPExcel_b->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);

    $objPHPExcel_b->setActiveSheetIndex(0)->setCellValue('G1', 'height');
    $objPHPExcel_b->getActiveSheet()->getStyle('G1')->getFont()->setBold(true);

    $objPHPExcel_b->setActiveSheetIndex(0)->setCellValue('H1', 'length');
    $objPHPExcel_b->getActiveSheet()->getStyle('H1')->getFont()->setBold(true);

    $objPHPExcel_b->setActiveSheetIndex(0)->setCellValue('I1', 'tracking_key');
    $objPHPExcel_b->getActiveSheet()->getStyle('I1')->getFont()->setBold(true);

    //$objPHPExcel_b->setActiveSheetIndex(0)->setCellValue('J1', 'recipient_name'); 
    //$objPHPExcel_b->getActiveSheet()->getStyle('J1')->getFont()->setBold(true);

    $objPHPExcel_b->setActiveSheetIndex(0)->setCellValue('J1', 'recipient_email');
    $objPHPExcel_b->getActiveSheet()->getStyle('J1')->getFont()->setBold(true);

    $objPHPExcel_b->setActiveSheetIndex(0)->setCellValue('K1', 'recipient_phone');
    $objPHPExcel_b->getActiveSheet()->getStyle('K1')->getFont()->setBold(true);

    $objPHPExcel_b->setActiveSheetIndex(0)->setCellValue('L1', 'num_nf');
    $objPHPExcel_b->getActiveSheet()->getStyle('L1')->getFont()->setBold(true);

    $objPHPExcel_b->setActiveSheetIndex(0)->setCellValue('M1', 'serie_nf');
    $objPHPExcel_b->getActiveSheet()->getStyle('M1')->getFont()->setBold(true);

    $objPHPExcel_b->setActiveSheetIndex(0)->setCellValue('N1', 'nfe_key');
    $objPHPExcel_b->getActiveSheet()->getStyle('N1')->getFont()->setBold(true);

    $objPHPExcel_b->setActiveSheetIndex(0)->setCellValue('O1', 'cgc_cpf');
    $objPHPExcel_b->getActiveSheet()->getStyle('O1')->getFont()->setBold(true);

    $objPHPExcel_b->setActiveSheetIndex(0)->setCellValue('P1', 'ins_estadual');
    $objPHPExcel_b->getActiveSheet()->getStyle('P1')->getFont()->setBold(true);

    $objPHPExcel_b->setActiveSheetIndex(0)->setCellValue('Q1', 'valor_total');
    $objPHPExcel_b->getActiveSheet()->getStyle('Q1')->getFont()->setBold(true);

    $objPHPExcel_b->setActiveSheetIndex(0)->setCellValue('R1', 'weight');
    $objPHPExcel_b->getActiveSheet()->getStyle('R1')->getFont()->setBold(true);

    $objPHPExcel_b->setActiveSheetIndex(0)->setCellValue('S1', 'peso_cubado');
    $objPHPExcel_b->getActiveSheet()->getStyle('S1')->getFont()->setBold(true);

    $sheet = $objPHPExcel_b->getActiveSheet();

    $sheet->getStyle('A1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

    $sheet->getStyle('B1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

    $sheet->getStyle('C1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

    $sheet->getStyle('D1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

    $sheet->getStyle('E1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

    $sheet->getStyle('F1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

    $sheet->getStyle('G1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

    $sheet->getStyle('H1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

    $sheet->getStyle('I1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

    $sheet->getStyle('J1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

    $sheet->getStyle('K1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

    $sheet->getStyle('L1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

    $sheet->getStyle('M1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

    $sheet->getStyle('N1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

    $sheet->getStyle('O1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

    $sheet->getStyle('P1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

    $sheet->getStyle('Q1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

    $sheet->getStyle('R1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

    $sheet->getStyle('S1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

    $objPHPExcel_b->getActiveSheet()->getStyle('A1:A1')->getBorders()->getOutline()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
    $objPHPExcel_b->getActiveSheet()->getStyle('B1:B1')->getBorders()->getOutline()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
    $objPHPExcel_b->getActiveSheet()->getStyle('C1:C1')->getBorders()->getOutline()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
    $objPHPExcel_b->getActiveSheet()->getStyle('D1:D1')->getBorders()->getOutline()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
    $objPHPExcel_b->getActiveSheet()->getStyle('E1:E1')->getBorders()->getOutline()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
    $objPHPExcel_b->getActiveSheet()->getStyle('F1:F1')->getBorders()->getOutline()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
    $objPHPExcel_b->getActiveSheet()->getStyle('G1:G1')->getBorders()->getOutline()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
    $objPHPExcel_b->getActiveSheet()->getStyle('H1:H1')->getBorders()->getOutline()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
    $objPHPExcel_b->getActiveSheet()->getStyle('I1:I1')->getBorders()->getOutline()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
    $objPHPExcel_b->getActiveSheet()->getStyle('J1:J1')->getBorders()->getOutline()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
    $objPHPExcel_b->getActiveSheet()->getStyle('K1:K1')->getBorders()->getOutline()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
    $objPHPExcel_b->getActiveSheet()->getStyle('L1:L1')->getBorders()->getOutline()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
    $objPHPExcel_b->getActiveSheet()->getStyle('M1:M1')->getBorders()->getOutline()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
    $objPHPExcel_b->getActiveSheet()->getStyle('N1:N1')->getBorders()->getOutline()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
    $objPHPExcel_b->getActiveSheet()->getStyle('O1:O1')->getBorders()->getOutline()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
    $objPHPExcel_b->getActiveSheet()->getStyle('P1:P1')->getBorders()->getOutline()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
    $objPHPExcel_b->getActiveSheet()->getStyle('Q1:Q1')->getBorders()->getOutline()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
    $objPHPExcel_b->getActiveSheet()->getStyle('R1:R1')->getBorders()->getOutline()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
    $objPHPExcel_b->getActiveSheet()->getStyle('S1:S1')->getBorders()->getOutline()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

    cellColor_b('A1', 'C1FFC1', $objPHPExcel_b);
    cellColor_b('B1', 'C1FFC1', $objPHPExcel_b);
    cellColor_b('C1', 'C1FFC1', $objPHPExcel_b);
    cellColor_b('D1', 'C1FFC1', $objPHPExcel_b);
    cellColor_b('E1', 'C1FFC1', $objPHPExcel_b);
    cellColor_b('F1', 'C1FFC1', $objPHPExcel_b);
    cellColor_b('G1', 'C1FFC1', $objPHPExcel_b);
    cellColor_b('H1', 'C1FFC1', $objPHPExcel_b);
    cellColor_b('I1', 'C1FFC1', $objPHPExcel_b);
    cellColor_b('J1', 'C1FFC1', $objPHPExcel_b);
    cellColor_b('K1', 'C1FFC1', $objPHPExcel_b);
    cellColor_b('L1', 'C1FFC1', $objPHPExcel_b);
    cellColor_b('M1', 'C1FFC1', $objPHPExcel_b);
    cellColor_b('N1', 'C1FFC1', $objPHPExcel_b);
    cellColor_b('O1', 'C1FFC1', $objPHPExcel_b);
    cellColor_b('P1', 'C1FFC1', $objPHPExcel_b);
    cellColor_b('Q1', 'C1FFC1', $objPHPExcel_b);
    cellColor_b('R1', 'C1FFC1', $objPHPExcel_b);
    cellColor_b('S1', 'C1FFC1', $objPHPExcel_b);

    $ultima_b = 1;

    $pegar = "SELECT c.clicnpj FROM clientes as c Where c.clicodigo = " . CLIENTE_TOY;

    $cad = pg_query($pegar);
    $row = pg_num_rows($cad);

    if ($row) {
        $cnpj = trim(pg_fetch_result($cad, 0, "clicnpj"));
    } else {
        $cnpj = '00000000000000';
    }

    $msgerro = '';
    $msgerro2 = '';


    $query = "select a.*,b.pvnumero,b.pvinternet,b.pvtipofrete,b.pvdest,b.pvaltura,b.pvlargura,b.pvcomprimento,b.pvpeso,c.clicodigo as cliente,c.clicod,c.clinguerra,c.clirazao,c.clicnpj,c.cliie,c.clipessoa,c.clist,c.clioptsimples,c.clicpf,c.clipais,d.natcod from notagua a 
	left join natureza d on a.natcodigo = d.natcodigo 
	left join pvenda b on a.pvnumero = b.pvnumero 
	left join clientes c on b.clicodigo = c.clicodigo 
	$where order by a.notemissao asc";

    $contador = 0;

    $cad = pg_query($query);
    for ($i = 0; $i < pg_num_rows($cad); $i++) {
        $array = pg_fetch_object($cad);

        echo 'NFe: ' . $array->notnumero . ' - ' . $array->pvnumero . '<br>';
        ob_flush();

        //Looping nos itens para Calcular o Peso	
        $query3 = "select a.*,b.procod,b.proicms,b.propeso,b.proisento,c.clanumero,b.procod as codigo,b.prnome as nome,b.grucodigo as grupo,d.medsigla as sigla from ngitem a ";
        $query3 = $query3 . " left join produto b on a.procodigo = b.procodigo ";
        $query3 = $query3 . " left join clfiscal c on b.clacodigo = c.clacodigo ";
        $query3 = $query3 . " left join medidas d on b.medcodigo = d.medcodigo ";
        $query3 = $query3 . " Where a.ndnumero = " . $array->notnumero;
        $query3 = $query3 . " order by a.nditem asc ";

        $cad3 = pg_query($query3);

        $peso = 0;

        $natureza = '';
        $isento = 1;

        for ($i3 = 0; $i3 < pg_num_rows($cad3); $i3++) {
            $array3 = pg_fetch_object($cad3);

            if ($i3 == 0) {
                $natureza = substr($array3->nome, 0, 25);
            }

            if ($array3->proisento != '2') {
                $isento = 0;
            }

            $peso = $peso + ($array3->propeso * $array3->ndisaldo);
        }

        $peso = round($peso, 3);

        //Vai passar a pegar os volumes da Conferência WMS
        $pegarest = "SELECT pvfvolume 
			FROM pvendafinalizado 		
			Where pvnumero = " . $array->pvnumero;
        $cadest = pg_query($pegarest);
        $rowest = pg_num_rows($cadest);
        if ($rowest) {
            $volumes = trim(pg_fetch_result($cadest, 0, "pvfvolume"));
        } else {
            $volumes = $array->notvolumes;
        }

        if ($volumes == '' || $volumes == '0' || $volumes == 0) {
            $volumes = '1';
        }

        if ($array->pvtipofrete == 1) {
            ;
            $tipoFrete = 'CIF';
        } else {
            $tipoFrete = 'FOB';
        }

        $remessa = '';
        $tipoServico = '1';
        $tipoEntrega = '0';

        $numeroPedido = $array->pvinternet;

        $pvdest = $array->pvdest;
        $pvaltura = $array->pvaltura;
        $pvlargura = $array->pvlargura;
        $pvcomprimento = $array->pvcomprimento;
        $pvpeso = $array->pvpeso;

        if ($pvaltura == '') {
            $pvaltura = 0;
        }
        if ($pvlargura == '') {
            $pvlargura = 0;
        }
        if ($pvcomprimento == '') {
            $pvcomprimento = 0;
        }
        if ($pvpeso == '' || $pvpeso == 0) {
            if ($peso > 0) {
                $pvpeso = $peso;
            } else {
                $pvpeso = 1;
            }
        }

        //Se tiver peso na Nota 
        //Se tiver peso na Nota Importada do XML usa esse valor
        if ($array->pesobru > 0) {
            $pvpeso = round($array->pesobru, 2);
        }


        //Se estiver zerado vai usar as medidas da Caixa Media
        if ($pvaltura == '0') {
            $pvaltura = '0.2';
        }
        if ($pvlargura == '0') {
            $pvlargura = '0.2';
        }
        if ($pvcomprimento == '0') {
            $pvcomprimento = '0.2';
        }

        $cubagem = $pvaltura * $pvlargura * $pvcomprimento * $volumes;

        $numeroCliente = '';
        $tipoVolume = '';

        $infoColeta = '';

        $destinatario = $array->clirazao;

        if ($array->clipessoa == '2') {
            $cpfcnpj = trim($array->clicpf);
            $ie = '';
        } else {
            $cpfcnpj = trim($array->clicnpj);
            $ie = trim($array->cliie);

            $caracteres = 0;
            $caracteres += strlen($ie);
            $vaix = '';
            $ixx = 0;
            for ($ixx = 0; $ixx < $caracteres; $ixx++) {
                if (is_numeric(substr($ie, $ixx, 1))) {
                    $vaix = $vaix . substr($ie, $ixx, 1);
                }
            }
            $ie = $vaix;
        }

        $clicodigo = $array->cliente;

        $pais = $array->clipais;


        $endereco = '';
        $numero = '';
        $comple = '';
        $refer = '';
        $bairro = '';
        $cidade = '';
        $estado = '';
        $cep = '';
        $emailx = '';
        $ddd = '';
        $fone = '';
        $fone2 = '';
        $fone3 = '';

        $cidibge = '';
        $cidcorr = '';

        if ($clicodigo != 0) {
            $pegarest = "SELECT a.cleendereco,a.clecep,a.clefone,a.clefone2,a.clefone3,b.descricao,b.uf,a.clebairro as bairro,c.descricao as ibge,a.clenumero,a.clecomplemento,a.cleemail
			FROM cliefat a
			LEFT JOIN cidades as b on a.cidcodigo = b.cidcodigo
			LEFT JOIN cidadesibge as c on cast(substr(a.cidcodigoibge,1,2) as integer) = c.codestado and cast(substr(a.cidcodigoibge,3,5) as character varying(5)) = c.codcidade
			Where a.clicodigo = '$clicodigo'";

            $cadest = pg_query($pegarest);
            $rowest = pg_num_rows($cadest);

            if ($rowest) {

                $endereco = trim(pg_fetch_result($cadest, 0, "cleendereco"));
                $numero = trim(pg_fetch_result($cadest, 0, "clenumero"));
                $comple = trim(pg_fetch_result($cadest, 0, "clecomplemento"));

                $cidade = trim(pg_fetch_result($cadest, 0, "ibge"));
                if (trim($cidade) == '') {
                    $cidade = trim(pg_fetch_result($cadest, 0, "descricao"));
                }

                $cidibge = trim(pg_fetch_result($cadest, 0, "ibge"));
                $cidcorr = trim(pg_fetch_result($cadest, 0, "descricao"));

                $estado = delimitador(trim(pg_fetch_result($cadest, 0, "uf")), 4, 'L', ' '); // Estado
                $cep = (pg_fetch_result($cadest, 0, "clecep"));
                $fone = trim(pg_fetch_result($cadest, 0, "clefone"));
                $fone2 = trim(pg_fetch_result($cadest, 0, "clefone2"));
                $fone3 = trim(pg_fetch_result($cadest, 0, "clefone3"));
                $bairro = trim(pg_fetch_result($cadest, 0, "bairro"));
                $emailx = (pg_fetch_result($cadest, 0, "cleemail"));
            }
        }


        //Se o endereço escolhido for dos pedidos
        if ($xendereco == 2) {

            $parametro = $array->pvnumero;

            //Verifica se existe o Endereço
            //Localiza os Dados do Endereço do Pedido
            $sql2 = "SELECT * FROM pedidoendereco
				WHERE pvnumero = '$parametro'";

            //EXECUTA A QUERY
            $sql2 = pg_query($sql2);

            $row2 = pg_num_rows($sql2);

            //VERIFICA SE VOLTOU ALGO
            if ($row2) {

                $acep = pg_fetch_result($sql2, 0, "pvcep");
                $aendereco = pg_fetch_result($sql2, 0, "pvendereco");
                $anumero = pg_fetch_result($sql2, 0, "pvnum");
                $acomplemento = pg_fetch_result($sql2, 0, "pvcomplemento");
                $abairro = pg_fetch_result($sql2, 0, "pvbairro");
                $acidade = pg_fetch_result($sql2, 0, "pvcidade");
                $auf = pg_fetch_result($sql2, 0, "pvuf");

                if ($acep == '') {
                    $acep = '_';
                }
                if ($aendereco == '') {
                    $aendereco = '_';
                }
                if ($anumero == '') {
                    $anumero = '0';
                }
                if ($acomplemento == '') {
                    $acomplemento = '_';
                }
                if ($abairro == '') {
                    $abairro = '_';
                }
                if ($acidade == '') {
                    $acidade = '_';
                }
                if ($auf == '') {
                    $auf = '_';
                }

                if ($acep != '_') {
                    $endereco = trim($aendereco);
                    $numero = trim($anumero);
                    $comple = trim($acomplemento);
                    $cidade = trim($acidade);
                    $estado = trim($auf);
                    $cep = trim($acep);
                    $bairro = trim($abairro);
                }
            }
        }



        $codservi = 0;
        $codpagto = '';
        $codparce = '';
        $codvalor = '';

        $agdata = '';
        $agper1 = '';
        $agper2 = '';

        $nfenumero = $array->notnumero;
        $nfeserie = '1';

        $nfedata = substr($array->notemissao, 8, 2) . '/' . substr($array->notemissao, 5, 2) . '/' . substr($array->notemissao, 0, 4);

        $nfevalor = $array->notvalor;
        $nfeprod = $array->notvalor - $array->notipi;

        $nfecfop = substr($array->natcod, 0, 1) . substr($array->natcod, 2, 3);

        $nfechave = $array->chave;

        $erro = 0;

        $msgerro2 = '';

        if ($estado == '') {
            $msgerro .= "<br /><br /><h5>" . "Pedido Vtex : " . $numeroPedido . " Pedido Max : " . $array->pvnumero . " Erro : ESTADO EM BRANCO " . '</ h5>';
            $msgerro2 .= "Erro : ESTADO EM BRANCO ";
            $erro = 1;
        }

        if ($cidcorr == '') {
            $msgerro .= "<br /><br /><h5>" . "Pedido Vtex : " . $numeroPedido . " Pedido Max : " . $array->pvnumero . " Erro : CIDADE EM BRANCO " . '</ h5>';
            $msgerro2 .= "Erro : CIDADE EM BRANCO ";
            $erro = 1;
        }

        if ($cidibge == '') {
            $msgerro .= "<br /><br /><h5>" . "Pedido Vtex : " . $numeroPedido . " Pedido Max : " . $array->pvnumero . " Erro : CIDADE IBGE EM BRANCO " . '</ h5>';
            $msgerro2 .= "Erro : IBGE EM BRANCO ";
            $erro = 1;
        }

        if ($numero == '') {
            $msgerro .= "<br /><br /><h5>" . "Pedido Vtex : " . $numeroPedido . " Pedido Max : " . $array->pvnumero . " Erro : NUMERO DO ENDERECO EM BRANCO " . '</ h5>';
            $msgerro2 .= "Erro : NUMERO EM BRANCO ";
            $erro = 1;
        }

        if ($bairro == '') {
            $msgerro .= "<br /><br /><h5>" . "Pedido Vtex : " . $numeroPedido . " Pedido Max : " . $array->pvnumero . " Erro : BAIRRO EM BRANCO " . '</ h5>';
            $msgerro2 .= "Erro : BAIRRO EM BRANCO ";
            $erro = 1;
        }

        if (($pvaltura == '0.15' && $pvlargura == '0.15' && $pvcomprimento == '0.15') || ($pvaltura == '0.2' && $pvlargura == '0.2' && $pvcomprimento == '0.2') || ($pvaltura == '0.44' && $pvlargura == '0.42' && $pvcomprimento == '0.32')) {
            
        } else {
            $msgerro .= "<br /><br /><h5>" . "Pedido Vtex : " . $numeroPedido . " Pedido Max : " . $array->pvnumero . " Erro : MEDIDAS DA CAIXA INVALIDAS (" . $pvlargura . 'x' . $pvaltura . 'x' . $pvcomprimento . ")" . '</ h5>';
            $msgerro2 .= "Erro : MEDIDAS DA CAIXA INVALIDAS (" . $pvlargura . 'x' . $pvaltura . 'x' . $pvcomprimento . ")";
            $erro = 1;
        }
        if ($pvpeso == 0) {
            $msgerro .= "<br /><br /><h5>" . "Pedido Vtex : " . $numeroPedido . " Pedido Max : " . $array->pvnumero . " Erro : PESO DA CAIXA EM BRANCO " . '</ h5>';
            $msgerro2 .= "Erro : PESO DA CAIXA EM BRANCO ";
            $erro = 1;
        }

        if ($erro == 0) {
            if ($numero == '' || $numero == '0') {
                $numero = 'SN';
            }

            $bairro = substr($bairro, 0, 40);

            if ($numeroPedido == '' || $numeroPedido == '0') {
                $vaipedido = $array->pvnumero;
            } else {
                $vaipedido = $numeroPedido;
            }

            $contador++;

            //$endereco		= trim($endereco).','. trim($numero) . ' ' . trim($bairro) . ' ' . trim($cidade) . '-' . trim($estado) . ' CEP:' . substr($cep,0,5) . '-' . substr($cep,5,3);

            $enderecox = trim($endereco) . ',' . trim($numero) . ' ' . trim($bairro) . ' ' . trim($cidade) . '-' . trim($estado) . ' CEP:' . substr($cep, 0, 5) . '-' . substr($cep, 5, 3);
            if ($comple == '_') {
                $comple = '';
            }

            if ($pvdest == '') {
                $dest = $destinatario;
            } else {
                $dest = $pvdest;
            }

            if (trim($cidade) == 'RIO DE JANEIRO') {
                $lgcity = '2';
            } else {
                $lgcity = '1';
            }


            if ($pvaltura == '0.15' && $pvlargura == '0.15' && $pvcomprimento == '0.15') {
                $package_type = 'box';
            } else if ($pvaltura == '0.2' && $pvlargura == '0.2' && $pvcomprimento == '0.2') {
                $package_type = 'medium_box';
            } else {
                $package_type = 'large_box';
            }

            $pvaltura = round($pvaltura * 100, 0);
            $pvlargura = round($pvlargura * 100, 0);
            $pvcomprimento = round($pvcomprimento * 100, 0);

            if ($pvaltura == 0) {
                $pvaltura = 1;
            }
            if ($pvlargura == 0) {
                $pvlargura = 1;
            }
            if ($pvcomprimento == 0) {
                $pvcomprimento = 1;
            }

            //Verifica o Tipo de Endereço

            $end1 = '';
            $end2 = '';
            $separa = 0;

            $endereco = trim($endereco);

            $caracteres = 0;
            $caracteres += strlen($endereco);
            $vai = '';
            $ix = 0;
            for ($ix = 0; $ix < $caracteres; $ix++) {

                if ((substr($endereco, $ix, 1) == ' ' || substr($endereco, $ix, 1) == '.') && $separa == 0) {
                    $separa = 1;
                    $end1 = $end1 . substr($endereco, $ix, 1);
                } else {
                    if ($separa == 0) {
                        $end1 = $end1 . substr($endereco, $ix, 1);
                    } else {
                        $end2 = $end2 . substr($endereco, $ix, 1);
                    }
                }
            }
            $end1 = trim($end1);
            $end2 = trim($end2);


            //07170350

            $end1 = ucwords(strtolower($end1));
            $end2 = ucwords(strtolower($end2));
            $comple = ucwords(strtolower($comple));
            $bairro = ucwords(strtolower($bairro));
            $dest = ucwords(strtolower($dest));

            $erro = 'EXPORTADO';

            $enderecox = ucwords(strtolower($enderecox));
            $comple = ucwords(strtolower($comple));
            $destinatario = ucwords(strtolower($destinatario));
            $pvdest = ucwords(strtolower($pvdest));

            $ultima++;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $ultima, $array->pvnumero);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $ultima, $enderecox);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $ultima, $comple);
            if ($pvdest == '') {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $ultima, $destinatario);
            } else {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $ultima, $pvdest);
            }
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $ultima, $fone);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $ultima, $emailx);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $ultima, $numeroPedido);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $ultima, round($cubagem, 3));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $ultima, 'TOYMANIA');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $ultima, $id_rapiddo);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $ultima, $erro);

            $objPHPExcel->getActiveSheet()
                    ->getCell('L' . $ultima)
                    ->setValueExplicit($nfechave, PHPExcel_Cell_DataType::TYPE_STRING);




            $endereco = ucwords(strtolower($endereco));
            $bairro = ucwords(strtolower($bairro));
            $cidade = ucwords(strtolower($cidade));

            $ultima_b++;
            $objPHPExcel_b->setActiveSheetIndex(0)->setCellValue('A' . $ultima_b, $endereco);
            $objPHPExcel_b->setActiveSheetIndex(0)->setCellValue('B' . $ultima_b, $numero);
            $objPHPExcel_b->setActiveSheetIndex(0)->setCellValue('C' . $ultima_b, $bairro . ' ' . $comple);
            $objPHPExcel_b->setActiveSheetIndex(0)->setCellValue('D' . $ultima_b, substr($cep, 0, 5) . substr($cep, 5, 3));
            if ($pvdest == '') {
                $objPHPExcel_b->setActiveSheetIndex(0)->setCellValue('E' . $ultima_b, "Entregar Pacote para " . $destinatario);
            } else {
                $objPHPExcel_b->setActiveSheetIndex(0)->setCellValue('E' . $ultima_b, "Entregar Pacote para " . $pvdest);
            }
            $objPHPExcel_b->setActiveSheetIndex(0)->setCellValue('F' . $ultima_b, $pvaltura);
            $objPHPExcel_b->setActiveSheetIndex(0)->setCellValue('G' . $ultima_b, $pvlargura);
            $objPHPExcel_b->setActiveSheetIndex(0)->setCellValue('H' . $ultima_b, $pvcomprimento);
            $objPHPExcel_b->setActiveSheetIndex(0)->setCellValue('I' . $ultima_b, $array->notnumero);
            /*
              if($pvdest==''){
              $objPHPExcel_b->setActiveSheetIndex(0)->setCellValue('J'.$ultima_b , $destinatario );
              }
              else {
              $objPHPExcel_b->setActiveSheetIndex(0)->setCellValue('J'.$ultima_b , $pvdest );
              }
             */
            $objPHPExcel_b->setActiveSheetIndex(0)->setCellValue('J' . $ultima_b, $emailx);
            $objPHPExcel_b->setActiveSheetIndex(0)->setCellValue('K' . $ultima_b, $fone);
            $objPHPExcel_b->setActiveSheetIndex(0)->setCellValue('L' . $ultima_b, $array->notnumero);
            $objPHPExcel_b->setActiveSheetIndex(0)->setCellValue('M' . $ultima_b, '1'); //Serie

            $objPHPExcel_b->getActiveSheet()
                    ->getCell('N' . $ultima_b)
                    ->setValueExplicit($nfechave, PHPExcel_Cell_DataType::TYPE_STRING);

            $objPHPExcel_b->getActiveSheet()
                    ->getCell('O' . $ultima_b)
                    ->setValueExplicit($cpfcnpj, PHPExcel_Cell_DataType::TYPE_STRING);

            $objPHPExcel_b->getActiveSheet()
                    ->getCell('P' . $ultima_b)
                    ->setValueExplicit($ie, PHPExcel_Cell_DataType::TYPE_STRING);

            $objPHPExcel_b->setActiveSheetIndex(0)->setCellValue('Q' . $ultima_b, round($nfevalor, 2));
            $objPHPExcel_b->setActiveSheetIndex(0)->setCellValue('R' . $ultima_b, round($pvpeso, 3));
            $objPHPExcel_b->setActiveSheetIndex(0)->setCellValue('S' . $ultima_b, round(1, 0));

            $auxdat = date("Y-m-d H:i:s");
            $sql2 = "Update pvenda set pvloggiped='$auxdat' WHERE pvnumero = " . $array->pvnumero;
            pg_query($sql2);
        } else {

            if ($numero == '' || $numero == '0') {
                $numero = 'SN';
            }

            $bairro = substr($bairro, 0, 40);

            if ($numeroPedido == '' || $numeroPedido == '0') {
                $vaipedido = $array->pvnumero;
            } else {
                $vaipedido = $numeroPedido;
            }

            $enderecox = trim($endereco) . ',' . trim($numero) . ' ' . trim($bairro) . ' ' . trim($cidade) . '-' . trim($estado) . ' CEP:' . substr($cep, 0, 5) . '-' . substr($cep, 5, 3);
            if ($comple == '_') {
                $comple = '';
            }



            $ultima++;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $ultima, $array->pvnumero);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $ultima, $enderecox);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $ultima, $comple);
            if ($pvdest == '') {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $ultima, $destinatario);
            } else {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $ultima, $pvdest);
            }
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $ultima, $fone);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $ultima, $emailx);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $ultima, $numeroPedido);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $ultima, round($cubagem, 3));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $ultima, 'TOYMANIA');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $ultima, '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $ultima, $msgerro2);

            $objPHPExcel->getActiveSheet()
                    ->getCell('L' . $ultima)
                    ->setValueExplicit($nfechave, PHPExcel_Cell_DataType::TYPE_STRING);
        }
    }



    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);

    $objPHPExcel_b->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
    $objPHPExcel_b->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
    $objPHPExcel_b->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
    $objPHPExcel_b->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
    $objPHPExcel_b->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
    $objPHPExcel_b->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
    $objPHPExcel_b->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
    $objPHPExcel_b->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
    $objPHPExcel_b->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
    $objPHPExcel_b->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
    $objPHPExcel_b->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
    $objPHPExcel_b->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
    $objPHPExcel_b->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
    $objPHPExcel_b->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
    $objPHPExcel_b->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
    $objPHPExcel_b->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
    $objPHPExcel_b->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
    $objPHPExcel_b->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
    $objPHPExcel_b->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);

    // Save Excel 2007 file
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save($arquivo);


    // Save Excel 2007 file
    $objWriter_b = PHPExcel_IOFactory::createWriter($objPHPExcel_b, 'Excel2007');
    $objWriter_b->save($arquivo_b);


    print("<br>&nbsp;" . $arquivo . " gerado com sucesso!");

    //Se exportou pelo menos 1 Pedido
    if ($contador > 0) {

        print("<br>");
        print("<br>");
        print("Enviando E-mail!");

        //Usa os dados da tabela de Parametros
        $sqlmail = "Select * from parametrosemail where tipo=6 LIMIT 1";
        //$sqlmail = "Select * from parametrosemail where tipo=1 LIMIT 1";
        $cadmail = pg_query($sqlmail);
        if (pg_num_rows($cadmail)) {
            $paremail = pg_fetch_result($cadmail, 0, "email");
            $parsenha = pg_fetch_result($cadmail, 0, "senha");
            $parsmtp = pg_fetch_result($cadmail, 0, "smtp");
            $parporta = pg_fetch_result($cadmail, 0, "usuario");
            $smtpuser = pg_fetch_result($cadmail, 0, "smtpuser");
            $smtppass = pg_fetch_result($cadmail, 0, "smtppass");
        } else {
            $paremail = '';
            $parsenha = '';
            $parsmtp = '';
            $parporta = '';
            $smtpuser = '';
            $smtppass = '';
        }
        $from = $paremail;

        $nomedoarquivo = 'loggimanual' . date("YmdHis") . '.txt';
        $acao = "1";
        $id = "'";

        $destinatarios = '';
        $remetente = $from;
        $assunto = '';
        $mensagem = '';

        $data = date("Y-m-d");
        $aux = getdate();
        $data = substr($data, 0, 10) . ' ' . $aux['hours'] . ':' . $aux['minutes'] . ":" . $aux['seconds'] . '-03';

        $path = DIR_ROOT . '/lib';
        set_include_path(get_include_path() . PATH_SEPARATOR . $path);
        require_once("Zend/Loader/Autoloader.php");

        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->setFallbackAutoloader(true);

        $data = date("d/m/Y H:i:s");

        //configura para envio de email
        if (!$smtpuser) {
            $config = array("auth" => "login", "username" => $paremail, "password" => $parsenha, "port" => $parporta);
        } else {
            $config = array("ssl" => "tls", "auth" => "login", "username" => $smtpuser, "password" => $smtppass, "port" => $parporta);
        }
        $tr = new Zend_Mail_Transport_Smtp($parsmtp, $config);

        Zend_Mail::setDefaultTransport($tr);
        //funcao para envio de email - Zend_Mail
        $mail = new Zend_Mail();

        $mail->setFrom($remetente, "Workflow Toymania");

        $email = "";

        $sql = "Select loggmail FROM loggiemail";
        $sql = pg_query($sql);
        $row = pg_num_rows($sql);
        if ($row) {
            //PERCORRE ARRAY
            for ($i = 0; $i < $row; $i++) {
                if ($email == '') {
                    $email = pg_fetch_result($sql, $i, "loggmail");
                } else {
                    $email = $email . ";" . pg_fetch_result($sql, $i, "loggmail");
                }
            }
        }


        //Envia para todos os Contatos da Transportadora
        $sql = "Select traemail FROM transportadorcontato where tracodigo=$codtransp";
        $sql = pg_query($sql);
        $row = pg_num_rows($sql);
        if ($row) {
            //PERCORRE ARRAY
            for ($i = 0; $i < $row; $i++) {
                if ($email == '') {
                    $email = pg_fetch_result($sql, $i, "traemail");
                } else {
                    $email = $email . ";" . pg_fetch_result($sql, $i, "traemail");
                }
            }
        }

        $texto = $email;

        $mails = explode(";", $texto);

        foreach ($mails as $value) {

            if (trim($value)) {

                $mail->addTo(trim(strtolower($value)));
                $destinatarios .= trim(strtolower($value));
            }
        }

        $msg .= "<br /><b>" . nl2br($msg1) . "</b>";
        $msg = str_replace('_', '', $msg);
        $mail->setSubject("Roteirização Toy Mania " . $data);

        $msg .= "<br /><br /><h5>" . "Segue em anexo planilha com pedidos exportados da Toymania" . '</ h5>';

        $msg .= "<br /><br /><h5>" . $data . '</ h5>';


        $mail->setBodyHTML($msg);

        $diretorio = 'arquivos/loggi';

        if (is_dir($diretorio)) {

            //$file = $diretorio.'/pedidos.csv';
            $file = $arquivo_b;

            $at = new Zend_Mime_Part(file_get_contents($file));
            $at->filename = basename($file);
            $at->disposition = Zend_Mime::DISPOSITION_ATTACHMENT;
            //$at->encoding = Zend_Mime::ENCODING_8BIT;
            $at->encoding = Zend_Mime::ENCODING_BASE64;

            $mail->addAttachment($at);
        }

        if ($where != '') {
            //Vai fazer um Looping para Processar todos os XMLS 
            $query = "select a.notnumero from notagua a 		
			$where order by a.notemissao asc";

            $cad = pg_query($query);
            for ($i = 0; $i < pg_num_rows($cad); $i++) {
                $array = pg_fetch_object($cad);

                $nomexml = ESTABELECIMENTO_TOY . '001' . str_pad($array->notnumero, 7, "0", STR_PAD_LEFT) . '.xml';

                //$aquivoxml = "/home/delta/datasul_toymania/datasul_nfe_copia/" . $nomexml;
                $aquivoxml = "/home/delta/datasul_nfe_copia_50/" . $nomexml;

                if (file_exists($aquivoxml)) {

                    $file = $aquivoxml;

                    $at = new Zend_Mime_Part(file_get_contents($file));
                    $at->filename = basename($file);
                    $at->disposition = Zend_Mime::DISPOSITION_ATTACHMENT;
                    //$at->encoding = Zend_Mime::ENCODING_8BIT;
                    $at->encoding = Zend_Mime::ENCODING_BASE64;

                    $mail->addAttachment($at);
                }

                //echo 'NFe: ' . $array->notnumero . ' - ' . $nomexml . '<br>';
                //ob_flush();
            }
        }

        try {
            $mail->send();
            print("<br>");
            print("<br>");
            print("E-mail Encaminhado!");
            logEmail("EMAIL ENCAMINHADO ", $nomedoarquivo, $texto, $remetente, $assunto, $mensagem, date("Y-m-d H:i:s"));
            //print true;
        } catch (Exception $e) {

            //print false;
            print("<br>");
            print("<br>");
            print("NAO FOI POSSIVEL ENVIAR O EMAIL" . $e->getMessage());
            logEmail("NAO FOI POSSIVEL ENVIAR O EMAIL" . $e->getMessage(), $nomedoarquivo, $texto, $remetente, $assunto, $mensagem, date("Y-m-d H:i:s"), true);
        }
    }

    //Se tiver erro manda e-mail:			
    if ($msgerro != '') {

        //Usa os dados da tabela de Parametros
        $sqlmail = "Select * from parametrosemail where tipo=6 LIMIT 1";
        //$sqlmail = "Select * from parametrosemail where tipo=1 LIMIT 1";
        $cadmail = pg_query($sqlmail);
        if (pg_num_rows($cadmail)) {
            $paremail = pg_fetch_result($cadmail, 0, "email");
            $parsenha = pg_fetch_result($cadmail, 0, "senha");
            $parsmtp = pg_fetch_result($cadmail, 0, "smtp");
            $parporta = pg_fetch_result($cadmail, 0, "usuario");
            $smtpuser = pg_fetch_result($cadmail, 0, "smtpuser");
            $smtppass = pg_fetch_result($cadmail, 0, "smtppass");
        } else {
            $paremail = '';
            $parsenha = '';
            $parsmtp = '';
            $parporta = '';
            $smtpuser = '';
            $smtppass = '';
        }
        $from = $paremail;

        $nomedoarquivo = 'errologgi' . date("YmdHis") . '.txt';
        $acao = "1";
        $id = "'";

        $destinatarios = '';
        $remetente = $from;
        $assunto = '';
        $mensagem = '';

        $msg = '';

        $data = date("Y-m-d");
        $aux = getdate();
        $data = substr($data, 0, 10) . ' ' . $aux['hours'] . ':' . $aux['minutes'] . ":" . $aux['seconds'] . '-03';

        $path = DIR_ROOT . '/lib';
        set_include_path(get_include_path() . PATH_SEPARATOR . $path);
        require_once("Zend/Loader/Autoloader.php");

        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->setFallbackAutoloader(true);


        $data = date("d/m/Y H:i:s");

        //configura para envio de email
        if (!$smtpuser) {
            $config = array("auth" => "login", "username" => $paremail, "password" => $parsenha, "port" => $parporta);
        } else {
            $config = array("ssl" => "tls", "auth" => "login", "username" => $smtpuser, "password" => $smtppass, "port" => $parporta);
        }
        $tr = new Zend_Mail_Transport_Smtp($parsmtp, $config);

        Zend_Mail::setDefaultTransport($tr);
        //funcao para envio de email - Zend_Mail
        $mail = new Zend_Mail();

        $mail->setFrom($remetente, "Workflow Toymania");

        $email = '';

        $where = "usucodigo = $usuario";

        $sql = "Select usuemail FROM usuarios where $where ";
        $sql = pg_query($sql);
        $row = pg_num_rows($sql);
        if ($row) {
            //PERCORRE ARRAY
            for ($i = 0; $i < $row; $i++) {
                if ($i == 0) {
                    $email = pg_fetch_result($sql, $i, "usuemail");
                } else {
                    $email = $email . ";" . pg_fetch_result($sql, $i, "usuemail");
                }
            }
        }

        $texto = $email;

        $mails = explode(";", $texto);

        foreach ($mails as $value) {

            if (trim($value)) {

                $mail->addTo(trim(strtolower($value)));
                $destinatarios .= trim(strtolower($value));
            }
        }


        $mail->setSubject("Erro na Exportação Loggi");

        $msg .= "<br /><br /><h5>" . $data . '</ h5>';

        $msg .= $msgerro;

        $mail->setBodyHTML($msg);

        try {
            $mail->send();
            print("<br>");
            print("<br>");
            print("E-mail de Erros na Exportação Encaminhado!");
            logEmail("EMAIL ENCAMINHADO ", $nomedoarquivo, $texto, $remetente, $assunto, $mensagem, date("Y-m-d H:i:s"));
            //print true;
        } catch (Exception $e) {

            //print false;
            print("<br>");
            print("<br>");
            print("NAO FOI POSSIVEL ENVIAR O EMAIL DE ERROS NA EXPORTACAO" . $e->getMessage());
            logEmail("NAO FOI POSSIVEL ENVIAR O EMAIL" . $e->getMessage(), $nomedoarquivo, $texto, $remetente, $assunto, $mensagem, date("Y-m-d H:i:s"), true);
        }
    }
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

function logEmail($msg, $nomedoarquivo, $destinatarios, $remetente, $assunto, $mensagem, $data, $reenvio = false) {
    $fp = fopen('/home/delta/pedidos/' . $nomedoarquivo, 'a+');
    //$fp = fopen(DIR_HOME . '/pedidos/' . $nomedoarquivo, 'a+');
    fwrite($fp, $msg . " EM " . $data . "\n");
    if ($reenvio) {
        fwrite($fp, "NOVA TENTATIVA DE ENVIO EM 1 HORA.\n");
    }
    fwrite($fp, "DESTINARARIO(S): " . $destinatarios . "\n");
    fwrite($fp, "REMETENTE: " . $remetente . "\n");
    fwrite($fp, "ASSUNTO: " . $assunto . "\n");
    fwrite($fp, "MENSAGEM: " . strip_tags($mensagem) . "\n\n\n");
    fclose($fp);
}

function confirmaLocalExpedicao($romnumero, $romdata, $romlocal = "") {

    $tabelaRomaneio = "romaneios" . $romlocal;
    $romcodigo = "romcodigo" . $romlocal;

    //$sql = "SELECT $romcodigo FROM $tabelaRomaneio where romnumero = '$romnumero' AND romdata = '$romdata'";
    $sql = "SELECT $romcodigo FROM $tabelaRomaneio where romnumero = '$romnumero' AND romano = '$romdata'";

    $consulta = pg_query($sql);
    if (pg_num_rows($consulta)) {
        $romcodigo = pg_fetch_result($consulta, "0", $romcodigo);
        return $romcodigo;
    }
    return '';
}

//Verifica a versao do Layout 
function verificaNotfis($tranguerra) {
    $sql = "SELECT notfisvers FROM transportador where tranguerra ilike '$tranguerra%'";
    $consulta = pg_query($sql);
    if (pg_num_rows($consulta)) {
        $notfisvers = pg_fetch_result($consulta, "0", "notfisvers");
        return $notfisvers;
    }
    return '';
}

//Verifica se cliente possui conemb para prosseguir com criacao de NOTFIS
function verificaConemb($tranguerra) {
    $sql = "SELECT conembvers FROM transportador where tranguerra ilike '$tranguerra%'";
    $consulta = pg_query($sql);
    $row = pg_num_rows($consulta);
    return $row;
}

function pedidosExpedicao($romcodigo, $tabelaRomaneioPedidos) {
    $sql = "SELECT pvnumero FROM $tabelaRomaneioPedidos where romcodigo = '$romcodigo'";
    $consulta = pg_query($sql);
    $pedidos = array();
    $row = pg_num_rows($consulta);
    if ($row) {
        for ($i = 0; $i < $row; $i++) {
            $pedidos[] = pg_fetch_result($consulta, $i, "pvnumero");
        }
    }
    return $pedidos;
}

function geraArquivoNotfis($romnumeroano, $romdata, $transportadora, $romlocal, $codtransp, $enviaEmail) {


    echo '<br>';
    echo 'Geração do Arquivo de Integração formato NOTFIS Proceda ' . '<br>';
    echo '<br>';
    ob_flush();

    /*
      if(!verificaConemb($transportadora)) {
      return false;
      }
     */

    $notfisvers = verificaNotfis($transportadora);
    if ($notfisvers == '') {
        return false;
    }

    $dir = "/home/delta/edi_toymania_nf/";
    $romnumeroanoSplited = explode("/", $romnumeroano);
    $romnumero = $romnumeroanoSplited[0];
    //$romdata = substr($romdata, 6, 4).'-'.substr($romdata, 3, 2).'-'.substr($romdata, 0, 2);
    $romdata = substr($romdata, 6, 4);
    $romcodigo = '';
    $dataDDMMAAAA = date("dmY");
    $dataDDMMAA = date("dmy");
    $dataDDMM = date("dm");
    $horaHHMM = date("Hi");
    $conteudo = "";
    $conteudoTmp = "";
    $total_nfs = 0;
    $qtd_total_volumes = 0;

    $total_pesobru = 0;
    $total_cubagem = 0;

    $codigoBarao = CLIENTE_TOY;
    $tabelaPedidoEstoque = "romaneiospedidos" . $romlocal;
    $retorno = new stdClass();

    $romcodigo = confirmaLocalExpedicao($romnumero, $romdata, $romlocal);

    if ($romcodigo) {
        $pedidos = pedidosExpedicao($romcodigo, $tabelaPedidoEstoque);
        //$PedidoModel = new PedidoModel();

        //$ClienteModel = new ClienteModel();        
        //$getBarao = $ClienteModel->pesquisar("clicodigo", $codigoBarao, 2);
        //$BaraoObj = $getBarao->clientes[$codigoBarao];
        
        $BaraoObj = new Cliente();            
        $BaraoObj->pesquisar($codigoBarao);
        
    } else {
        return null;
    }

    //Monta o Where com todos os Pedidos do Romaneio Seleciona
    $pegar = "SELECT pvnumero FROM romaneiospedidos Where romcodigo=$romcodigo";
    $cad = pg_query($pegar);
    $row = pg_num_rows($cad);
    $where = '';
    if ($row) {

        for ($i = 0; $i < $row; $i++) {
            $auxpedido = trim(pg_fetch_result($cad, $i, "pvnumero"));
            if ($where == '') {
                $where = "where (a.pvnumero = '$auxpedido'";
            } else {
                $where = $where . " or a.pvnumero = '$auxpedido'";
            }
        }
        $where = $where . ")";
    }

    if (preg_match("/jamef/i", $transportadora)) {
        $transportadora = "JAMEF ENCOMENDAS URGENTES";
        $pasta = "jamef/";
    }

    if (!isset($pasta)) {
        $pasta = preg_replace('/\s+/', '', strtolower(trim($transportadora))) . "/";
    }

    $dir .= $pasta;
    if (!is_dir($dir)) {
        mkdir($dir);
    }

    if ($notfisvers == '5') {

        //$ident_intercambio ="NOT".$dataDDMM.$horaHHMM . "0";
        $ident_intercambio = "NOT50" . $dataDDMM . "001";

        $caminhoArquivo = $dir . $ident_intercambio . '_' . $romnumero . '_' . $dataDDMMAAAA . '_' . $horaHHMM . '_' . "TM.txt";

        $count = 1;

        //Verifica se há arquivo gerado com esse mesmo nome e nesse caso adiciona o próximo contador nos tres últimos dígitos
        while (file_exists($caminhoArquivo)) {
            $ident_intercambio = substr($ident_intercambio, 0, -3) . delimitador($count, '3', 'R', '0');
            $caminhoArquivo = $dir . $ident_intercambio . '_' . $romnumero . '_' . $dataDDMMAAAA . '_' . $horaHHMM . '_' . "TM.txt";
            $count++;
        }

        //CABECALHO INTERCAMBIO
        $ident_registro = "000";
        //$remetente = sprintf("%-35s", "T MANIA COMERCIAL BRINQUEDOS EIRELI");
        $remetente = sprintf("%-35s", "CENTRO ATACADISTA BARAO LTDA");
        $destinatario = sprintf("%-35s", $transportadora); // NOME DA TRANSPORTADORA
        $data = $dataDDMMAA;
        $hora = $horaHHMM;
        $ident_intercambio = $ident_intercambio; // Sequencia do arquivo
        $filler_225 = sprintf("%225s", "");  // OPCIONAL
        $cabecalho_intercambio = $ident_registro . $remetente . $destinatario . $data . $hora
                . $ident_intercambio . $filler_225;
        $conteudoTmp = $cabecalho_intercambio;

        //------------------------------------------------------------------------------------------
        //CABECALHO DOCUMENTO
        $ident_registro = "\r\n500";
        //$ident_doc = $ident_intercambio;
        $ident_doc = "NOTAS50" . $dataDDMM . "001";
        ;
        $filler_303 = sprintf("%303s", ""); // OPCIONAL
        $cabecalho_documento = $ident_registro . $ident_doc . $filler_303;
        $conteudoTmp .= $cabecalho_documento;

        //------------------------------------------------------------------------------------------
        //DADOS EMBARCADORA
        $ident_registro = "\r\n501";

        $cnpj = substr(removeTodosCaracterNaoNumericos($BaraoObj->clicnpj), 0, 14);
        $ie = sprintf("%-15s", removeTodosCaracterNaoNumericos($BaraoObj->cliie));
        "109912156113"; // OPCIONAL
        $iest = sprintf("%-15s", ""); // OPCIONAL
        $im = sprintf("%-15s", ""); // OPCIONAL
        //$logradouro = sprintf("%-40s","");// OPCIONAL		
        $logradouro = $BaraoObj->enderecoFaturamento->cleendereco . " " . $BaraoObj->enderecoFaturamento->clenumero . " " . $BaraoObj->enderecoFaturamento->clecomplemento;
        $logradouro = sprintf("%-50s", substr($logradouro, 0, 50)); // OPCIONAL	
        $bairro = $BaraoObj->enderecoFaturamento->clebairro;
        $bairro = sprintf("%-35s", $bairro); // OPCIONAL		
        //$cidade = sprintf("%35s","");// OPCIONAL		
        $cidade = sprintf("%-35s", substr($BaraoObj->enderecoFaturamento->cidade->descricao, 0, 35)); // OPCIONAL		
        //$cep = sprintf("%9s","");// OPCIONAL
        $cepTmp = removeTodosCaracterNaoNumericos($BaraoObj->enderecoFaturamento->clecep);
        $cep = substr($cepTmp, 0, 5) . "-" . substr($cepTmp, 5, 3);
        $cep = sprintf("%09s", $cep);

        $ibge = removeTodosCaracterNaoNumericos($BaraoObj->enderecoFaturamento->cidcodigo);
        $ibge = sprintf("%-9s", $ibge); //UF// OPCIONAL

        $subentidade_pais = sprintf("%-9s", substr($BaraoObj->enderecoFaturamento->cidade->uf, 0, 2)); //UF  OPCIONAL

        $data_embarque = $dataDDMMAAAA;
        $empresa_embarcadora = $BaraoObj->clirazao;
        $empresa_embarcadora = sprintf("%-50s", $empresa_embarcadora); //$remetente; // OPCIONAL
        $filler_53 = sprintf("%53s", ""); // OPCIONAL
        $dados_embarcadora = $ident_registro . $empresa_embarcadora . $cnpj . $ie . $iest . $im . $logradouro . $bairro . $cidade . $cep . $ibge . $subentidade_pais
                . $data_embarque . $filler_53;
        $conteudoTmp .= $dados_embarcadora;

        $aux_valor_total = 0;
        $aux_peso_total = 0;
        $aux_volume_total = 0;
        $aux_notas_total = 0;

        //------------------------------------------------------------------------------------------
        //DADOS DESTINATARIO_MERCADORIA - REPETE-SE A CADA NF
        foreach ($pedidos as $value) {

            //15/10/2021 - Deixou de Usar as Classes dos Antigos Programadores Barão
            //$getPedidos = $PedidoModel->pesquisar("pvnumero", $value, 2);
            //$PedidoObj = $getPedidos->pedidos[$value];                        
            
            $PedidoObj = new Pedido();
            $PedidoObj->pesquisar($value);

            //        echo "<pre>";
            //        print_r($PedidoObj);
            //        echo "</pre>";
            //        exit();
            //        echo "value: ". $value . " ". $PedidoObj->cliente->clirazao . " - NF: ".$PedidoObj->notafiscal->notnumero ." = ";

            echo 'NFe: ' . $PedidoObj->notafiscal->notnumero . '<br>';
            //echo 'Chave: ' . $chave . '<br>';
            $serie_nfe = (int) substr($PedidoObj->notafiscal->chave, 22, 3);
            //echo 'Serie: ' . $serie_nfe . '<br>';
            ob_flush();


            $notpesol = 0;
            $notpesob = 0;
            $notcubag = 0;

            //Localiza a Nota
            $sql_aux = "SELECT * FROM notagua where pvnumero = $value";
            $con_aux = pg_query($sql_aux);
            if (pg_num_rows($con_aux)) {
                //$notnumero 	= pg_fetch_result($con_aux,"0","notnumero");
                //$notemissao = pg_fetch_result($con_aux,"0","notemissao");
                //$notemissao = substr($notemissao,8,2).'/'.substr($notemissao,5,2).'/'.substr($notemissao,0,4);
                //$notvolumes = pg_fetch_result($con_aux,"0","notvolumes");
                //$notvalor 	= pg_fetch_result($con_aux,"0","notvalor");
                //$chave 		= pg_fetch_result($con_aux,"0","chave");
                $notpesol = pg_fetch_result($con_aux, "0", "pesoliq");
                $notpesob = pg_fetch_result($con_aux, "0", "pesobru");
                $notcubag = pg_fetch_result($con_aux, "0", "cubagem");
            }


            $ident_registro = "\r\n503";
            $razao_social = sprintf("%-50s", substr($PedidoObj->cliente->clirazao, 0, 50)); // OPCIONAL
            //Verifica se o Pedido tem o Campo Destinatario Preenchido
            $pegarDestinatario = "SELECT pvdest FROM pvenda Where pvnumero = '$value'";
            $cadDestinatario = pg_query($pegarDestinatario);
            $rowDestinatario = pg_num_rows($cadDestinatario);
            if ($rowDestinatario) {
                $destinatario = pg_fetch_result($cadDestinatario, 0, "pvdest");
                if ($destinatario != '') {
                    $destinatario = str_pad($destinatario, 50, " ", STR_PAD_RIGHT);
                    $razao_social = sprintf("%-50s", substr($destinatario, 0, 50)); // OPCIONAL					
                }
            }

            if ($PedidoObj->cliente->clipessoa == 1) {
                $cnpj_dest = substr(removeTodosCaracterNaoNumericos($PedidoObj->cliente->clicnpj), 0, 14);
            } else {
                $cnpj_dest = substr(removeTodosCaracterNaoNumericos($PedidoObj->cliente->clicpf), 0, 14);
            }

            $cnpj_dest = delimitador($cnpj_dest, '14', 'R', '0');

            $ie_dest = sprintf("%-15s", substr(removeTodosCaracterNaoNumericos($PedidoObj->cliente->cliie), 0, 15)); // OPCIONAL
            $suframa_dest = sprintf("%-15s", substr($PedidoObj->cliente->clisuframa, 0, 15)); // OPCIONAL			


            $endereco_destTmp = trim($PedidoObj->cliente->enderecoFaturamento->cleendereco) . " " . trim($PedidoObj->cliente->enderecoFaturamento->clenumero) . " " . trim($PedidoObj->cliente->enderecoFaturamento->clecomplemento);
            $endereco_dest = sprintf("%-50s", substr($endereco_destTmp, 0, 50)); // OPCIONAL
            $bairro_dest = sprintf("%-35s", substr($PedidoObj->cliente->enderecoFaturamento->clebairro, 0, 35)); // OPCIONAL
            $cidade_dest = sprintf("%-35s", substr($PedidoObj->cliente->enderecoFaturamento->cidade->descricao, 0, 35)); // OPCIONAL			
            $clecepTmp = removeTodosCaracterNaoNumericos($PedidoObj->cliente->enderecoFaturamento->clecep);
            $clecep = substr($clecepTmp, 0, 5) . "-" . substr($clecepTmp, 5, 3);
            $cep_dest = sprintf("%09s", $clecep);
            $cod_municipio_dest = removeTodosCaracterNaoNumericos($PedidoObj->cliente->enderecoFaturamento->cidcodigo);

            $cod_municipio_dest = sprintf("%-9s", $cod_municipio_dest); // OPCIONAL			
            $subentidade_pais_dest = sprintf("%-9s", $PedidoObj->cliente->enderecoFaturamento->cidade->uf); //UF  OPCIONAL
            //Verifica se o Pedido tem Endereço Cadastrado			
            $sqlEndereco = "SELECT * FROM pedidoendereco WHERE pvnumero = '$value'";
            //EXECUTA A QUERY
            $sqlEndereco = pg_query($sqlEndereco);
            $rowEndereco = pg_num_rows($sqlEndereco);
            //VERIFICA SE VOLTOU ALGO
            if ($rowEndereco) {

                $acep = pg_fetch_result($sqlEndereco, 0, "pvcep");
                $aendereco = pg_fetch_result($sqlEndereco, 0, "pvendereco");
                $anumero = pg_fetch_result($sqlEndereco, 0, "pvnum");
                $acomplemento = pg_fetch_result($sqlEndereco, 0, "pvcomplemento");
                $abairro = pg_fetch_result($sqlEndereco, 0, "pvbairro");
                $acidade = pg_fetch_result($sqlEndereco, 0, "pvcidade");
                $auf = pg_fetch_result($sqlEndereco, 0, "pvuf");

                if ($acep == '') {
                    $acep = '_';
                }
                if ($aendereco == '') {
                    $aendereco = '_';
                }
                if ($anumero == '') {
                    $anumero = '0';
                }
                //if($acomplemento==''){$acomplemento	= '_';}
                if ($abairro == '') {
                    $abairro = '_';
                }
                if ($acidade == '') {
                    $acidade = '_';
                }
                if ($auf == '') {
                    $auf = '_';
                }

                if ($acep != '_') {

                    $endereco_destTmp = trim($aendereco) . " " . trim($anumero) . " " . trim($acomplemento);
                    $endereco_destTmp = str_pad($endereco_destTmp, 50, " ", STR_PAD_RIGHT);
                    $endereco_dest = sprintf("%-50s", substr($endereco_destTmp, 0, 50));
                    $bairro_dest = sprintf("%-35s", substr($abairro, 0, 35));
                    $cidade_dest = sprintf("%-35s", substr($acidade, 0, 35)); // OPCIONAL
                    $clecepTmp = removeTodosCaracterNaoNumericos($acep);
                    $clecep = substr($clecepTmp, 0, 5) . "-" . substr($clecepTmp, 5, 3);
                    $cep_dest = sprintf("%09s", $clecep);
                    $subentidade_pais_dest = sprintf("%-9s", $auf); //UF  OPCIONAL		
                    //Localiza o Codigo IBGE de acordo com a Cidade					
                    $sqlIbge = "SELECT codestado,codcidade FROM cidadesibge WHERE descricao = '$acidade' and uf = '$auf'";
                    //EXECUTA A QUERY
                    $sqlIbge = pg_query($sqlIbge);
                    $rowIbge = pg_num_rows($sqlIbge);
                    //VERIFICA SE VOLTOU ALGO
                    if ($rowIbge) {
                        $cod_municipio_dest = pg_fetch_result($sqlIbge, 0, "codestado") . pg_fetch_result($sqlIbge, 0, "codcidade");
                    } else {
                        $cod_municipio_dest = removeTodosCaracterNaoNumericos($PedidoObj->cliente->enderecoFaturamento->cidcodigo);
                    }
                    $cod_municipio_dest = sprintf("%-9s", $cod_municipio_dest); // OPCIONAL			
                }
            }

            //Telefone

            $cliente_fone = trim($PedidoObj->cliente->enderecoFaturamento->clefone);

            //Somente numeros
            $caracteres = 0;
            $caracteres += strlen($cliente_fone);
            $vai = '';
            $ifon = 0;
            for ($ifon = 0; $ifon < $caracteres; $ifon++) {
                if (is_numeric(substr($cliente_fone, $ifon, 1))) {
                    $vai = $vai . substr($cliente_fone, $ifon, 1);
                }
            }
            $cliente_fone = $vai;
            if (strlen($cliente_fone) == 10) {
                $cliente_fone = "(" . substr($cliente_fone, 0, 2) . ")" . substr($cliente_fone, 2, 4) . "-" . substr($cliente_fone, 6, 4);
            } else if (strlen($cliente_fone) == 11) {
                $cliente_fone = "(" . substr($cliente_fone, 0, 2) . ")" . substr($cliente_fone, 2, 5) . "-" . substr($cliente_fone, 7, 4);
            }

            //$fone_dest = sprintf("%-35s",substr($PedidoObj->cliente->enderecoFaturamento->clefone,0,35));// OPCIONAL
            $fone_dest = sprintf("%-35s", substr($cliente_fone, 0, 35)); // OPCIONAL

            $pais_dest = '1058';

            $area_frete = sprintf("%-4s", ""); // OPCIONAL
            //$num_comunicacao= sprintf("%-35s",""); // OPCIONAL
            $tp_ident_dest = sprintf("%-1s", $PedidoObj->cliente->clipessoa); // 1 - PJ, 2 - PF  OPCIONAL
            $filler_32 = sprintf("%-32s", ""); // OPCIONAL
            $dados_destinatario_mercadoria = $ident_registro . $razao_social . $cnpj_dest . $ie_dest . $suframa_dest . $endereco_dest
                    . $bairro_dest . $cidade_dest . $cep_dest . $cod_municipio_dest . $subentidade_pais_dest
                    . $fone_dest . $pais_dest . $area_frete . $tp_ident_dest . $filler_32;
            $conteudoTmp .= $dados_destinatario_mercadoria;

            //------------------------------------------------------------------------------------------
            //  DADOS NF - repete-se a cada NF
            $ident_registro = "\r\n505";
            $serie_nf = sprintf("%-3s", $serie_nfe); // OPCIONAL			
            $num_nf = delimitador(trim($PedidoObj->notafiscal->notnumero), '9', 'R', '0');
            $data_emissao = str_replace("/", "", $PedidoObj->notafiscal->notemissao); //DDMMAAAA
            $tp_mercadoria = sprintf("%-15s", "BRINQUEDOS");
            $especie_acondicionamento = sprintf("%-15s", "CAIXAS");
            $cod_rota = sprintf("%-7s", ""); // OPCIONAL
            $meio_transp = sprintf("%01s", "1"); //1 - rodoviario, 2 - aereo, 3 - maritimo, 4 - fluvial, 5 - ferroviario // OPCIONAL NUMERICO			
            $num_romaneio = sprintf("%-20s", $romnumero . '/' . $romdata); // OPCIONAL			


            $tp_transp = sprintf("%01s", ""); // 1 - carga fechada, 2 - carga fracionada // OPCIONAL NUMERICO
            $tp_carga = sprintf("%01s", ""); // 1 - fria, 2 - seca, 3 - mista // OPCIONAL NUMERICO
            $cond_frete = sprintf("%1s", ($PedidoObj->pvtipofrete == "2") ? "F" : "C"); // C - CIF, F -FOB
            $data_embarque = sprintf("%08s", ""); // OPCIONAL
            $desdobro = sprintf("%-10s", ""); // OPCIONAL
            $plano_carga_rapida = sprintf("%1s", ""); //S - SIM, N - NAO// OPCIONAL
            $tipo_doc_fiscal = '1';
            $indicacao_bonificacao = sprintf("%1s", ""); // OPCIONAL
            $codigo_fiscal = sprintf("%04s", ""); // OPCIONAL
            $frete_diferenciado = sprintf("%1s", ""); // OPCIONAL
            $tabela_frete = sprintf("%10s", ""); // OPCIONAL
            $modalidade_frete = sprintf("%2s", ""); // OPCIONAL            
            
            if($codtransp=='59') {
                
                $pvinternet = 0;
                $pegarInternet = "SELECT pvinternet FROM pvenda WHERE pvnumero = '{$value}'";
                $cadInternet = pg_query($pegarInternet);
                $rowInternet = pg_num_rows($cadInternet);
                if ($rowInternet) {
                    $pvinternet = (int) pg_fetch_result($cadInternet, 0, "pvinternet");                    
                }
                
                if($pvinternet) {                    
                    if ($pvinternet > 1 && $pvinternet < 10000000) {
                        $rastreio = 'GRPBR' . $pvinternet;                        
                    } else if ($pvinternet > 10000000 && $pvinternet < 200000000) {
                        //AnyMarket
                        $pedidoAnyMarket = ($pvinternet - 10000000);
                        $rastreio = 'GRPBRAM' . $pedidoAnyMarket;                        
                    }                    
                    $num_pedido = delimitador(trim($rastreio), '20', 'L', ' ');                    
                } else {
                    $num_pedido = delimitador(trim($PedidoObj->notafiscal->pvnumero), '20', 'L', ' ');
                }
                
            } else {
                $num_pedido = delimitador(trim($PedidoObj->notafiscal->pvnumero), '20', 'L', ' ');
            }

            $tipo_periodo_entrega = '0';

            $data_inicial = sprintf("%08s", ""); // OPCIONAL
            $hora_inicial = sprintf("%04s", ""); // OPCIONAL

            $data_final = sprintf("%08s", ""); // OPCIONAL
            $hora_final = sprintf("%04s", ""); // OPCIONAL


            $peso_total_mercadoria = sprintf("%07s", "0"); //5,2
            $peso_dens_cubagem = sprintf("%05s", ""); // OPCIONAL NUMERICO 3,2

            $valor_seguro = sprintf("%015s", "0"); // OPCIONAL NUMERICO 13,2
            $valor_cobrado = sprintf("%015s", "0"); // Valor que sera cobrado// OPCIONAL NUMERICO 13,2
            $num_placa_caminhao = sprintf("%7s", ""); // OPCIONAL

            $frete_peso_volume = sprintf("%015s", "0"); // OPCIONAL NUMERICO 13,2
            $valor_ad_valorem = sprintf("%015s", "0"); // OPCIONAL NUMERICO 13,2
            $total_taxas = sprintf("%015s", "0"); // OPCIONAL NUMERICO 13,2
            $total_frete = sprintf("%015s", "0"); // OPCIONAL NUMERICO 13,2
            $acao_doc = 'I'; //I - Inclusao, E - Exclusao/Cancelamento// OPCIONAL
            $valor_icms = sprintf("%012s", "0"); // OPCIONAL NUMERICO 10,2
            $valor_icms_retido = sprintf("%012s", "0"); // OPCIONAL NUMERICO 10,2

            $filler_60 = sprintf("%60s", $filler_60); // OPCIONAL 2
            $filler_21 = sprintf("%21s", $filler_21); // OPCIONAL 2

            $codigo_NF = delimitador(substr($PedidoObj->notafiscal->chave, 34, 9), '9', 'R', '0');
            $chave_NF = delimitador(trim($PedidoObj->notafiscal->chave), '45', 'L', ' ');

            $protocolo_NF = sprintf("%15s", ""); // OPCIONAL

            $dados_nf = $ident_registro . $serie_nf . $num_nf . $data_emissao . $tp_mercadoria . $especie_acondicionamento . $cod_rota . $meio_transp . $tp_transp
                    . $tp_carga . $cond_frete . $data_embarque . $desdobro . $plano_carga_rapida . $tipo_doc_fiscal . $indicacao_bonificacao . $codigo_fiscal
                    . substr($subentidade_pais, 0, 2) . $frete_diferenciado . $tabela_frete . $modalidade_frete . $num_pedido
                    . $num_romaneio . $filler_60 . $tipo_periodo_entrega . $data_inicial . $hora_inicial . $data_final . $hora_final
                    . $codigo_NF . $chave_NF . $protocolo_NF . $acao_doc . $filler_21;

            $conteudoTmp .= $dados_nf;

            $aux_volume = $PedidoObj->notafiscal->notvolumes;

            //Vai usar os Volumes da Tabela de Romaneios
            $sql_aux = "SELECT rpvolumes FROM $tabelaPedidoEstoque where pvnumero = $value";
            $con_aux = pg_query($sql_aux);
            $notvolumes_rom = 0;
            if (pg_num_rows($con_aux)) {
                $notvolumes_rom = pg_fetch_result($con_aux, 0, "rpvolumes");
            }
            if ($notvolumes_rom > 0) {
                $aux_volume = $notvolumes_rom;
            }

            if ($aux_volume == 0 || $aux_volume == '') {
                $aux_volume = 1;
            }

            $aux_valor_total = $aux_valor_total + $PedidoObj->notafiscal->notvalor;
            $aux_volume_total = $aux_volume_total + $aux_volume;
            $aux_notas_total = $aux_notas_total + 1;


            //  Valores da NF 
            $ident_registro = "\r\n506";
            $qtd_volume = sprintf("%06s", $aux_volume) . "00"; //num 6,2

            /*
              if($PedidoObj->pvpeso>0){
              $aux_peso = round($PedidoObj->pvpeso,2);
              $aux_peso = $aux_peso * 100;
              $aux_peso = round($aux_peso,0);
              }
              else {
              $aux_peso = 100;
              }
              $peso_pedido = sprintf("%08s",$aux_peso) . '0' ;//6,3
              $aux_peso_total 	= $aux_peso_total + $aux_peso;

              $peso_total_mercadoria = sprintf("%09s","0");//6,3
              $peso_total_cubagem = sprintf("%010s","0");//6,4
              $peso_total_cubado = sprintf("%010s","0");//6,4
             */

            //Peso Bruto será arredondado para 6,3
            if ($notpesob == 0) {
                $notpesob = 1;
            }

            $aux_peso_total = $aux_peso_total + $notpesob;

            $notpesob = Round($notpesob * 1000, 0);

            $peso_pedido = sprintf("%09s", $notpesob); //5,2
            //Cubagem será arredondado para 6,4
            $notcubag = Round($notcubag * 10000, 0);

            $peso_total_cubagem = sprintf("%010s", $notcubag); //6,4

            $peso_total_mercadoria = sprintf("%09s", "0"); //6,3

            $peso_total_cubado = sprintf("%010s", "0"); //6,4

            $valor_cobrado_cliente = sprintf("%015s", "0"); //13,2

            /* Isso é herança dos antigos programadores Barão e causa um erro
             * Dependendo do valor, 48.3 por exemplo vira 00000483 (4,83)
             *             
             * $valorNF = str_replace(".", "", ($PedidoObj->notafiscal->notvalor));
             */
            $valorNF = round($PedidoObj->notafiscal->notvalor * 100, 0);
            $valor_total_nf = sprintf("%015s", $valorNF); //num 13,2

            $valor_total_seguro = sprintf("%015s", "0"); //13,2
            $valor_total_desconto = sprintf("%015s", "0"); //13,2
            $valor_total_outras = sprintf("%015s", "0"); //13,2
            $base_calculo_icms = sprintf("%015s", "0"); //13,2
            $valor_total_icms = sprintf("%015s", "0"); //13,2			
            $base_calculo_subs = sprintf("%015s", "0"); //13,2
            $valor_total_subs = sprintf("%015s", "0"); //13,2
            $valor_icms_retido = sprintf("%015s", "0"); //13,2
            $valor_total_ii = sprintf("%015s", "0"); //13,2
            $valor_total_ipi = sprintf("%015s", "0"); //13,2
            $valor_total_pis = sprintf("%015s", "0"); //13,2
            $valor_total_cofins = sprintf("%015s", "0"); //13,2
            $valor_calculado_frete = sprintf("%015s", "0"); //13,2

            $total_icms_frete = sprintf("%013s", "0"); //11,2
            $total_subs_frete = sprintf("%013s", "0"); //11,2
            $total_iss_frete = sprintf("%013s", "0"); //11,2

            $tp_icms = 'S';
            $seguro_efetuado = "N";

            $filler_5 = sprintf("%5s", $filler_5); // OPCIONAL 2

            $dados_nf_valores = $ident_registro . $qtd_volume . $peso_pedido . $peso_total_mercadoria . $peso_total_cubagem . $peso_total_cubado . $tp_icms . $seguro_efetuado .
                    $valor_cobrado_cliente . $valor_total_nf . $valor_total_seguro . $valor_total_desconto . $valor_total_outras . $base_calculo_icms . $valor_total_icms .
                    $base_calculo_subs . $valor_total_subs . $valor_icms_retido . $valor_total_ii . $valor_total_ipi . $valor_total_pis . $valor_total_cofins .
                    $valor_calculado_frete . $total_icms_frete . $total_subs_frete . $total_iss_frete . $filler_5;

            $conteudoTmp .= $dados_nf_valores;


            $qtd_total_volumes += $qtd_volume;
            $total_nfs += $valor_total_nf;
            //break;
        }


        //==========CAMPOS ABAIXO ESTÃO COMENTADOS PARA USO FUTURO=========
        //
        //DADOS COMPLEMENTARES DA NF - OPCIONAL
        //$ident_registro = "333";
        //$cfop = sprintf("%04s",$cfop); // Codigo
        //$tp_periodo_entrega = sprintf("%01s",$tp_periodo_entrega);  // 0 - Sem data definida, 1 - Na data, 2 - Até a Data, 3 - A partir da Data, 4 - No período
        //$data_ini_entrega;//DDMMAAAA// OPCIONAL NUMERICO
        //$hora_ini_entrega;//HHMM// OPCIONAL NUMERICO
        //$data_fim_entrega;//DDMMAAAA// OPCIONAL NUMERICO
        //$hora_fim_entrega;//HHMM// OPCIONAL NUMERICO
        //$local_desembarque = sprintf("%15s",$local_desembarque);// OPCIONAL
        //$calc_frete_diferenciado = sprintf("%1s",$calc_frete_diferenciado); //S - SIM, N - NAO
        //$ident_tab_preco_frete = sprintf("%10s",$ident_tab_preco_frete); // OPCIONAL
        //$entrega_casada_cnpj1 = sprintf("%015s",$entrega_casada_cnpj1);// OPCIONAL NUMERICO
        //$entrega_casada_serie_nf1 = sprintf("%3s",$entrega_casada_serie_nf1);// OPCIONAL
        //$entrega_casada_num_nf1 = sprintf("%08s",$entrega_casada_num_nf1);// OPCIONAL NUMERICO
        //$entrega_casada_cnpj2 = sprintf("%015s",$entrega_casada_cnpj2);// OPCIONAL NUMERICO
        //$entrega_casada_serie_nf2 = sprintf("%3s",$entrega_casada_serie_nf2);// OPCIONAL
        //$entrega_casada_num_nf2 = sprintf("%08s",$entrega_casada_num_nf2);// OPCIONAL NUMERICO
        //$entrega_casada_cnpj3 = sprintf("%015s",$entrega_casada_cnpj3);// OPCIONAL NUMERICO
        //$entrega_casada_serie_nf3 = sprintf("%3s",$entrega_casada_serie_nf3);// OPCIONAL
        //$entrega_casada_num_nf3 = sprintf("%08s",$entrega_casada_num_nf3);// OPCIONAL NUMERICO
        //$entrega_casada_cnpj4 = sprintf("%015s",$entrega_casada_cnpj4);// OPCIONAL NUMERICO
        //$entrega_casada_serie_nf4 = sprintf("%3s",$entrega_casada_serie_nf4);// OPCIONAL
        //$entrega_casada_num_nf4 = sprintf("%08s",$entrega_casada_num_nf4);// OPCIONAL NUMERICO
        //$entrega_casada_cnpj5 = sprintf("%015s",$entrega_casada_cnpj5);// OPCIONAL NUMERICO
        //$entrega_casada_serie_nf5 = sprintf("%3s",$entrega_casada_serie_nf5);// OPCIONAL
        //$entrega_casada_num_nf5 = sprintf("%08s",$entrega_casada_num_nf5);// OPCIONAL NUMERICO
        //$despesas_adic_transporte= sprintf("%015s",$despesas_adic_transporte);// OPCIONAL NUMERICO 13,2
        //$tp_veiculo_transp = sprintf("%5s",$tp_veiculo_transp);// ver manual NOTFIS pág. 12 // OPCIONAL
        //$filial_emis_transp_contratante = sprintf("%10s",$filial_emis_transp_contratante);//Usado para redespacho // OPCIONAL
        //$serie_transp_contratante = sprintf("%5s",$serie_transp_contratante);//Usado para redespacho// OPCIONAL
        //$numero_transp_contratante = sprintf("%12s",$numero_transp_contratante);//Usado para redespacho// OPCIONAL
        //$filler_5 = sprintf("%5s",$filler_5);// OPCIONAL
        //$dados_comp_nf = $ident_registro . $cfop . $tp_periodo_entrega . $data_ini_entrega . $hora_ini_entrega
        //                                . $data_fim_entrega . $hora_fim_entrega . $local_desembarque . $calc_frete_diferenciado
        //                                . $ident_tab_preco_frete . $ident_tab_preco_frete
        //                                . $entrega_casada_cnpj1 . $entrega_casada_serie_nf1 . $entrega_casada_num_nf1
        //                                . $entrega_casada_cnpj2 . $entrega_casada_serie_nf2 . $entrega_casada_num_nf2
        //                                . $entrega_casada_cnpj3 . $entrega_casada_serie_nf3 . $entrega_casada_num_nf3
        //                                . $entrega_casada_cnpj4 . $entrega_casada_serie_nf4 . $entrega_casada_num_nf4
        //                                . $entrega_casada_cnpj5 . $entrega_casada_serie_nf5 . $entrega_casada_num_nf5
        //                                . $despesas_adic_transporte . $tp_veiculo_transp . $tp_veiculo_transp
        //                                . $filial_emis_transp_contratante . $filler_5 ;
        //
        //if( $inserirCompNF ) {
        //    $conteudoTmp .= $dados_comp_nf;
        //}
        //------------------------------------------------------------------------------------------
        //MERCADORIA NF -  para cada 313  - OPCIONAL
        //$ident_registro = "314";
        //$qtd_volume1 = sprintf("%07s",$qtd_volume1); // 5,2
        //$especie_acondicionamento1 = sprintf("%15s",$especie_acondicionamento1);
        //$mercadoria_nf1 = sprintf("%30s",$mercadoria_nf1);
        //$qtd_volume2 = sprintf("%07s",$qtd_volume2); // 5,2// OPCIONAL NUMERICO
        //$especie_acondicionamento2 = sprintf("%15s",$especie_acondicionamento2);// OPCIONAL
        //$mercadoria_nf2 = sprintf("%30s",$mercadoria_nf2);// OPCIONAL
        //$qtd_volume3 = sprintf("%07s",$qtd_volume3); // 5,2// OPCIONAL NUMERICO
        //$especie_acondicionamento3 = sprintf("%15s",$especie_acondicionamento3);// OPCIONAL
        //$mercadoria_nf3 = sprintf("%30s",$mercadoria_nf3);// OPCIONAL
        //$qtd_volume4 = sprintf("%07s",$qtd_volume4); // 5,2// OPCIONAL NUMERICO
        //$especie_acondicionamento4 = sprintf("%15s",$especie_acondicionamento4);// OPCIONAL
        //$mercadoria_nf4 = sprintf("%30s",$mercadoria_nf4);// OPCIONAL
        //$qtd_volume5 = sprintf("%07s",$qtd_volume5); // 5,2// OPCIONAL NUMERICO
        //$especie_acondicionamento5 = sprintf("%15s",$especie_acondicionamento5);// OPCIONAL
        //$mercadoria_nf5 = sprintf("%30s",$mercadoria_nf5);// OPCIONAL
        //$filler_29 = sprintf("%29s",$filler_29);// OPCIONAL
        //$mercadoria_nf = $ident_registro
        //                                . $qtd_volume1 . $especie_acondicionamento1 . $mercadoria_nf1
        //                                . $qtd_volume2 . $especie_acondicionamento2 . $mercadoria_nf2
        //                                . $qtd_volume3 . $especie_acondicionamento3 . $mercadoria_nf3
        //                                . $qtd_volume4 . $especie_acondicionamento4 . $mercadoria_nf4
        //                                . $qtd_volume5 . $especie_acondicionamento5 . $mercadoria_nf5
        //                                . $filler_29;
        //
        //if($inserirMercadoriaNF){
        //    $conteudoTmp .= $mercadoria_nf;
        //}
        //------------------------------------------------------------------------------------------
        //DADOS CONSIGNATARIO DA MERCADORIA - para cada 313 - OPCIONAL
        //$ident_registro = "315";
        //$razao_social1 =  sprintf("%40s",$razao_social1);
        //$cnpj1 = substr($cnpj1,0,14);
        //$ie1 =  sprintf("%15s",$ie1);// OPCIONAL
        //$endereco1 =  sprintf("%40s",$endereco1);
        //$bairro1 =  sprintf("%20s",$bairro1);// OPCIONAL
        //$cidade1 =  sprintf("%35s",$cidade1);
        //$cep1 =  sprintf("%9s",$cep1);
        //$cod_municipio1 = sprintf("%9s",$cod_municipio1);// OPCIONAL
        //$subentidade_pais1 = sprintf("%9s",$subentidade_pais1);
        //$num_comunicacao1 = sprintf("%35s",$num_comunicacao1);// OPCIONAL
        //$filler_11 = sprintf("%11s", $filler_11);// OPCIONAL
        //$dados_consig_mercadoria = $ident_registro . $razao_social1 . $cnpj1 . $ie1
        //                                                    . $endereco1 . $bairro1 . $cidade1 . $cep1
        //                                                    . $cod_municipio1 . $subentidade_pais1 . $num_comunicacao1 . $filler_11;
        //
        //if($inserirConsigMercadoria){
        //    $conteudoTmp .= $dados_consig_mercadoria;
        //}
        //------------------------------------------------------------------------------------------
        //DADOS REDESPACHO DA MERCADORIA - para cada 313 - OPCIONAL
        //$ident_registro = "316";
        //$razao_social2 =  sprintf("%40s",$razao_social2);
        //$cnpj2 = substr($cnpj2,0,14);
        //$ie2 =  sprintf("%15s",$ie2);// OPCIONAL
        //$endereco2 =  sprintf("%40s",$endereco2);
        //$bairro2 =  sprintf("%20s",$bairro2);// OPCIONAL
        //$cidade2 =  sprintf("%35s",$cidade2);
        //$cep2 =  sprintf("%9s",$cep2);
        //$cod_municipio2 = sprintf("%9s",$cod_municipio2);// OPCIONAL
        //$subentidade_pais2 = sprintf("%9s",$subentidade_pais2);
        //$area_frete2 = sprintf("%4s",$area_frete2);
        //$num_comunicacao2 = sprintf("%35s",$num_comunicacao2);// OPCIONAL
        //$filler_7 = sprintf("%7s",$filler_7);// OPCIONAL
        //$redespacho_mercadoria = $ident_registro . $razao_social2 . $cnpj2 . $ie2
        //                                                . $endereco2 . $bairro2 . $cidade2 . $cep2 . $cod_municipio2 . $subentidade_pais2
        //                                                . $area_frete2 . $num_comunicacao2 . $filler_7;
        //
        //if($fazerRedespachoMercadoria){
        //    $conteudoTmp .= $redespacho_mercadoria;
        //}
        //
        ////------------------------------------------------------------------------------------------
        ////DADOS RESPONSAVEL PELO FRETE - para cada 313 - OPCIONAL
        //$ident_registro = "317";
        //$razao_social3 =  sprintf("%40s",$razao_social3);
        //$cnpj3 = substr($cnpj3,0,14);
        //$ie3 =  sprintf("%15s",$ie3);// OPCIONAL
        //$endereco3 =  sprintf("%40s",$endereco3);
        //$bairro3 =  sprintf("%20s",$bairro3);// OPCIONAL
        //$cidade3 =  sprintf("%35s",$cidade3);
        //$cep3 =  sprintf("%9s",$cep3);
        //$cod_municipio3 = sprintf("%9s",$cod_municipio3);// OPCIONAL
        //$subentidade_pais3 = sprintf("%9s",$subentidade_pais3);
        //$num_comunicacao3 = sprintf("%35s",$num_comunicacao3);// OPCIONAL
        //$filler_11 = sprintf("11s",$filler_11);// OPCIONAL
        //$responsavel_frete = $ident_registro . $razao_social3 . $cnpj3 . $ie3
        //                                                . $endereco3 . $bairro3 . $cidade3 . $cep3 . $cod_municipio3 . $subentidade_pais3
        //                                                . $area_frete3 . $num_comunicacao3 . $filler_11;
        //if($inserirRespFrete){
        //    $conteudoTmp .= $responsavel_frete;
        //}
        //------------------------------------------------------------------------------------------
        //VALORES TOTAIS DO DOCUMENTO
        $ident_registro = "\r\n519";


        $total_nfs = sprintf("%-10s", $aux_notas_total); //13,2

        $valor_total = sprintf("%015s", $aux_valor_total * 100); //13,2// OPCIONAL NUMERICO		
        $peso_total = sprintf("%015s", round($aux_peso_total * 100, 0)); //13,2// OPCIONAL NUMERICO
        $volume_total = sprintf("%015s", $aux_volume_total * 100); //13,2// OPCIONAL NUMERICO


        $filler_262 = sprintf("%262s", ""); // OPCIONAL

        $valorTotalDoc = $ident_registro . $valor_total . $peso_total . $volume_total . $total_nfs . $filler_262;

        $conteudoTmp .= $valorTotalDoc;

        $conteudo .= $conteudoTmp;
    } else {

        $ident_intercambio = "NOT" . $dataDDMM . $horaHHMM . "0";
        $caminhoArquivo = $dir . $ident_intercambio . '_' . $romnumero . '_' . $dataDDMMAAAA . '_' . $horaHHMM . '_' . "TM.txt";

        $count = 1;

        //Verifica se há arquivo gerado com esse mesmo nome e nesse caso adiciona o próximo contador no último dígito
        while (file_exists($caminhoArquivo)) {
            $ident_intercambio = substr($ident_intercambio, 0, -1) . $count;
            $caminhoArquivo = $dir . $ident_intercambio . '_' . $romnumero . '_' . $dataDDMMAAAA . '_' . $horaHHMM . '_' . "TM.txt";
            $count++;
        }

        //CABECALHO INTERCAMBIO
        $ident_registro = "000";
        //$remetente = sprintf("%-35s", "T MANIA COMERCIAL BRINQUEDOS EIRELI");
        $remetente = sprintf("%-35s", "CENTRO ATACADISTA BARAO LTDA");
        $destinatario = sprintf("%-35s", $transportadora); // NOME DA TRANSPORTADORA
        $data = $dataDDMMAA;
        $hora = $horaHHMM;
        $ident_intercambio = $ident_intercambio; // Sequencia do arquivo
        $filler_145 = sprintf("%145s", "");  // OPCIONAL
        $cabecalho_intercambio = $ident_registro . $remetente . $destinatario . $data . $hora
                . $ident_intercambio . $filler_145;
        $conteudoTmp = $cabecalho_intercambio;

        //------------------------------------------------------------------------------------------
        //CABECALHO DOCUMENTO
        $ident_registro = "\r\n310";
        $ident_doc = $ident_intercambio;
        $filler_223 = sprintf("%223s", ""); // OPCIONAL
        $cabecalho_documento = $ident_registro . $ident_doc . $filler_223;
        $conteudoTmp .= $cabecalho_documento;

        //------------------------------------------------------------------------------------------
        //DADOS EMBARCADORA
        $ident_registro = "\r\n311";
        $cnpj = substr(removeTodosCaracterNaoNumericos($BaraoObj->clicnpj), 0, 14);
        $ie = sprintf("%-15s", removeTodosCaracterNaoNumericos($BaraoObj->cliie));
        "109912156113"; // OPCIONAL

        /*
          $logradouro = sprintf("%-40s","");// OPCIONAL
          $cidade = sprintf("%35s","");// OPCIONAL
          $cep = sprintf("%9s","");// OPCIONAL
          $subentidade_pais = sprintf("%9s",$cep); //UF// OPCIONAL
          $data_embarque = $dataDDMMAAAA;
          $empresa_embarcadora = sprintf("%40s",""); //$remetente; // OPCIONAL
         */

        $logradouro = $BaraoObj->enderecoFaturamento->cleendereco . " " . $BaraoObj->enderecoFaturamento->clenumero . " " . $BaraoObj->enderecoFaturamento->clecomplemento;
        $logradouro = sprintf("%-40s", substr($logradouro, 0, 40)); // OPCIONAL				
        $cidade = sprintf("%-35s", substr($BaraoObj->enderecoFaturamento->cidade->descricao, 0, 35)); // OPCIONAL				
        $cepTmp = removeTodosCaracterNaoNumericos($BaraoObj->enderecoFaturamento->clecep);
        $cep = sprintf("%-9s", $cepTmp);
        $subentidade_pais = sprintf("%-9s", substr($BaraoObj->enderecoFaturamento->cidade->uf, 0, 2)); //UF  OPCIONAL
        $data_embarque = $dataDDMMAAAA;
        $empresa_embarcadora = $BaraoObj->clirazao;
        $empresa_embarcadora = sprintf("%-40s", $empresa_embarcadora); //$remetente; // OPCIONAL		

        $filler_67 = sprintf("%67s", ""); // OPCIONAL



        $dados_embarcadora = $ident_registro . $cnpj . $ie . $logradouro . $cidade . $cep . $subentidade_pais
                . $data_embarque . $empresa_embarcadora . $filler_67;
        $conteudoTmp .= $dados_embarcadora;

        $qtd_total_volumes = 0;
        $qtd_total_peso = 0;

        //------------------------------------------------------------------------------------------
        //DADOS DESTINATARIO_MERCADORIA - REPETE-SE A CADA NF
        foreach ($pedidos as $value) {

            //15/10/2021 - Deixou de Usar as Classes dos Antigos Programadores Barão
            //$getPedidos = $PedidoModel->pesquisar("pvnumero", $value, 2);
            //$PedidoObj = $getPedidos->pedidos[$value];                        
            
            $PedidoObj = new Pedido();
            $PedidoObj->pesquisar($value);

            //        echo "<pre>";
            //        print_r($PedidoObj);
            //        echo "</pre>";
            //        exit();
            //        echo "value: ". $value . " ". $PedidoObj->cliente->clirazao . " - NF: ".$PedidoObj->notafiscal->notnumero ." = ";

            echo 'NFe: ' . $PedidoObj->notafiscal->notnumero . '<br>';
            //echo 'Chave: ' . $chave . '<br>';
            $serie_nfe = (int) substr($PedidoObj->notafiscal->chave, 22, 3);
            //echo 'Serie: ' . $serie_nfe . '<br>';
            ob_flush();


            $notpesol = 0;
            $notpesob = 0;
            $notcubag = 0;

            //Localiza a Nota
            $sql_aux = "SELECT * FROM notagua where pvnumero = $value";
            $con_aux = pg_query($sql_aux);
            if (pg_num_rows($con_aux)) {
                //$notnumero 	= pg_fetch_result($con_aux,"0","notnumero");
                //$notemissao = pg_fetch_result($con_aux,"0","notemissao");
                //$notemissao = substr($notemissao,8,2).'/'.substr($notemissao,5,2).'/'.substr($notemissao,0,4);
                //$notvolumes = pg_fetch_result($con_aux,"0","notvolumes");
                //$notvalor 	= pg_fetch_result($con_aux,"0","notvalor");
                $notpesol = pg_fetch_result($con_aux, "0", "pesoliq");
                $notpesob = pg_fetch_result($con_aux, "0", "pesobru");
                $notcubag = pg_fetch_result($con_aux, "0", "cubagem");
            }

            $ident_registro = "\r\n312";
            $razao_social = sprintf("%-40s", substr($PedidoObj->cliente->clirazao, 0, 40)); // OPCIONAL
            //Verifica se o Pedido tem o Campo Destinatario Preenchido			
            $pegarDestinatario = "SELECT pvdest FROM pvenda Where pvnumero = '$value'";
            $cadDestinatario = pg_query($pegarDestinatario);
            $rowDestinatario = pg_num_rows($cadDestinatario);
            if ($rowDestinatario) {
                $destinatario = pg_fetch_result($cadDestinatario, 0, "pvdest");
                if ($destinatario != '') {
                    $destinatario = str_pad($destinatario, 40, " ", STR_PAD_RIGHT);
                    $razao_social = sprintf("%-40s", substr($destinatario, 0, 40)); // OPCIONAL					
                }
            }

            if ($PedidoObj->cliente->clipessoa == 1) {
                $cnpj_dest = substr(removeTodosCaracterNaoNumericos($PedidoObj->cliente->clicnpj), 0, 14);
            } else {
                $cnpj_dest = substr(removeTodosCaracterNaoNumericos($PedidoObj->cliente->clicpf), 0, 14);
            }

            $cnpj_dest = delimitador($cnpj_dest, '14', 'R', '0');


            $ie_dest = sprintf("%-15s", substr(removeTodosCaracterNaoNumericos($PedidoObj->cliente->cliie), 0, 15)); // OPCIONAL

            $endereco_destTmp = $PedidoObj->cliente->enderecoFaturamento->cleendereco . " " . $PedidoObj->cliente->enderecoFaturamento->clenumero . " " . $PedidoObj->cliente->enderecoFaturamento->clecomplemento;
            $endereco_dest = sprintf("%-40s", substr($endereco_destTmp, 0, 40)); // OPCIONAL
            $bairro_dest = sprintf("%-20s", substr($PedidoObj->cliente->enderecoFaturamento->clebairro, 0, 20)); // OPCIONAL
            $cidade_dest = sprintf("%-35s", substr($PedidoObj->cliente->enderecoFaturamento->cidade->descricao, 0, 35)); // OPCIONAL
            $clecepTmp = removeTodosCaracterNaoNumericos($PedidoObj->cliente->enderecoFaturamento->clecep);
            $clecep = substr($clecepTmp, 0, 5) . "-" . substr($clecepTmp, 5, 3);
            $cep_dest = sprintf("%09s", $clecep);
            $cod_municipio_dest = sprintf("%-9s", ""); // OPCIONAL
            $subentidade_pais_dest = sprintf("%-9s", $PedidoObj->cliente->enderecoFaturamento->cidade->uf); //UF  OPCIONAL
            //DADOS COMPLEMENTARES DA NF - OPCIONAL			
            if ($PedidoObj->notafiscal->natcodigo == '' || $PedidoObj->notafiscal->natcodigo == '0') {
                if ($PedidoObj->cliente->enderecoFaturamento->cidade->uf == 'SP') {
                    $aux_nat = 51;
                } else {
                    $aux_nat = 6;
                }
            } else {
                $aux_nat = $PedidoObj->notafiscal->natcodigo;
            }

            //Verifica se o Pedido tem Endereço Cadastrado			
            $sqlEndereco = "SELECT * FROM pedidoendereco WHERE pvnumero = '$value'";
            //EXECUTA A QUERY
            $sqlEndereco = pg_query($sqlEndereco);
            $rowEndereco = pg_num_rows($sqlEndereco);
            //VERIFICA SE VOLTOU ALGO
            if ($rowEndereco) {

                $acep = pg_fetch_result($sqlEndereco, 0, "pvcep");
                $aendereco = pg_fetch_result($sqlEndereco, 0, "pvendereco");
                $anumero = pg_fetch_result($sqlEndereco, 0, "pvnum");
                $acomplemento = pg_fetch_result($sqlEndereco, 0, "pvcomplemento");
                $abairro = pg_fetch_result($sqlEndereco, 0, "pvbairro");
                $acidade = pg_fetch_result($sqlEndereco, 0, "pvcidade");
                $auf = pg_fetch_result($sqlEndereco, 0, "pvuf");

                if ($acep == '') {
                    $acep = '_';
                }
                if ($aendereco == '') {
                    $aendereco = '_';
                }
                if ($anumero == '') {
                    $anumero = '0';
                }
                //if($acomplemento==''){$acomplemento	= '_';}
                if ($abairro == '') {
                    $abairro = '_';
                }
                if ($acidade == '') {
                    $acidade = '_';
                }
                if ($auf == '') {
                    $auf = '_';
                }

                if ($acep != '_') {

                    $endereco_destTmp = trim($aendereco) . " " . trim($anumero) . " " . trim($acomplemento);
                    $endereco_destTmp = str_pad($endereco_destTmp, 40, " ", STR_PAD_RIGHT);
                    $endereco_dest = sprintf("%-40s", substr($endereco_destTmp, 0, 40));
                    $bairro_dest = sprintf("%-20s", substr($abairro, 0, 20));
                    $cidade_dest = sprintf("%-35s", substr($acidade, 0, 35)); // OPCIONAL
                    $clecepTmp = removeTodosCaracterNaoNumericos($acep);
                    $clecep = substr($clecepTmp, 0, 5) . "-" . substr($clecepTmp, 5, 3);
                    $cep_dest = sprintf("%09s", $clecep);
                    $cod_municipio_dest = sprintf("%-9s", ""); // OPCIONAL
                    $subentidade_pais_dest = sprintf("%-9s", $auf); //UF  OPCIONAL		
                    //DADOS COMPLEMENTARES DA NF - OPCIONAL			
                    if ($PedidoObj->notafiscal->natcodigo == '' || $PedidoObj->notafiscal->natcodigo == '0') {
                        if ($auf == 'SP') {
                            $aux_nat = 51;
                        } else {
                            $aux_nat = 6;
                        }
                    } else {
                        $aux_nat = $PedidoObj->notafiscal->natcodigo;
                    }
                }
            }


            $area_frete = sprintf("%-4s", ""); // OPCIONAL
            //Telefone
            $cliente_fone = trim($PedidoObj->cliente->enderecoFaturamento->clefone);

            //Somente numeros
            $caracteres = 0;
            $caracteres += strlen($cliente_fone);
            $vai = '';
            $ifon = 0;
            for ($ifon = 0; $ifon < $caracteres; $ifon++) {
                if (is_numeric(substr($cliente_fone, $ifon, 1))) {
                    $vai = $vai . substr($cliente_fone, $ifon, 1);
                }
            }
            $cliente_fone = $vai;
            if (strlen($cliente_fone) == 10) {
                $cliente_fone = "(" . substr($cliente_fone, 0, 2) . ")" . substr($cliente_fone, 2, 4) . "-" . substr($cliente_fone, 6, 4);
            } else if (strlen($cliente_fone) == 11) {
                $cliente_fone = "(" . substr($cliente_fone, 0, 2) . ")" . substr($cliente_fone, 2, 5) . "-" . substr($cliente_fone, 7, 4);
            }


            //$num_comunicacao= sprintf("%-35s",""); // OPCIONAL
            $num_comunicacao = sprintf("%-35s", $cliente_fone); // OPCIONAL


            $tp_ident_dest = sprintf("%-1s", $PedidoObj->cliente->clipessoa); // 1 - PJ, 2 - PF  OPCIONAL
            $filler_6 = sprintf("%-6s", ""); // OPCIONAL
            $dados_destinatario_mercadoria = $ident_registro . $razao_social . $cnpj_dest . $ie_dest . $endereco_dest
                    . $bairro_dest . $cidade_dest . $cep_dest . $cod_municipio_dest . $subentidade_pais_dest
                    . $area_frete . $num_comunicacao . $tp_ident_dest . $filler_6;
            $conteudoTmp .= $dados_destinatario_mercadoria;

            //------------------------------------------------------------------------------------------
            //  DADOS NF - repete-se a cada NF
            $ident_registro = "\r\n313";
            $num_romaneio = sprintf("%-15s", $num_romaneio); // OPCIONAL
            $cod_rota = sprintf("%-7s", ""); // OPCIONAL
            $meio_transp = sprintf("%01s", "1"); //1 - rodoviario, 2 - aereo, 3 - maritimo, 4 - fluvial, 5 - ferroviario // OPCIONAL NUMERICO
            $tp_transp = sprintf("%01s", ""); // 1 - carga fechada, 2 - carga fracionada // OPCIONAL NUMERICO
            $tp_carga = sprintf("%01s", ""); // 1 - fria, 2 - seca, 3 - mista // OPCIONAL NUMERICO

            $cond_frete = sprintf("%1s", ($PedidoObj->pvtipofrete == "2") ? "F" : "C"); // C - CIF, F -FOB
            $serie_nf = sprintf("%-3s", $serie_nfe); // OPCIONAL
            $num_nf = sprintf("%08s", trim($PedidoObj->notafiscal->notnumero)); // num
            $data_emissao = str_replace("/", "", $PedidoObj->notafiscal->notemissao); //DDMMAAAA
            $tp_mercadoria = sprintf("%-15s", "BRINQUEDOS");
            $especie_acondicionamento = sprintf("%-15s", "CAIXAS");

            $aux_volume = $PedidoObj->notafiscal->notvolumes;

            //Vai usar os Volumes da Tabela de Romaneios
            $sql_aux = "SELECT rpvolumes FROM $tabelaPedidoEstoque where pvnumero = $value";
            $con_aux = pg_query($sql_aux);
            $notvolumes_rom = 0;
            if (pg_num_rows($con_aux)) {
                $notvolumes_rom = pg_fetch_result($con_aux, 0, "rpvolumes");
            }
            if ($notvolumes_rom > 0) {
                $aux_volume = $notvolumes_rom;
            }

            if ($aux_volume == 0 || $aux_volume == '') {
                $aux_volume = 1;
            }
            $qtd_volume = sprintf("%05s", $aux_volume) . "00"; //num 5,2

            /* Isso é herança dos antigos programadores Barão e causa um erro
             * Dependendo do valor, 48.3 por exemplo vira 00000483 (4,83)
             *
             * $valorNF = str_replace(".", "", ($PedidoObj->notafiscal->notvalor));
             */
            $valorNF = round($PedidoObj->notafiscal->notvalor * 100, 0);
            $valor_total_nf = sprintf("%015s", $valorNF); //num 13,2

            /* 	
              if($PedidoObj->pvpeso>0){
              $aux_peso = round($PedidoObj->pvpeso,2);
              $aux_peso = $aux_peso * 100;
              $aux_peso = round($aux_peso,0);
              }
              else {
              $aux_peso = 100;
              }
              $peso_total_mercadoria = sprintf("%07s",$aux_peso);//5,2

              $peso_dens_cubagem = sprintf("%05s",""); // OPCIONAL NUMERICO 3,2
             */

            if ($notpesob == 0) {
                $notpesob = 1;
            }

            //Peso Bruto será arredondado para 5,2
            $notpesob = Round($notpesob * 100, 0);

            $peso_total_mercadoria = sprintf("%07s", $notpesob); //5,2
            //Cubagem será arredondado para 3,2
            $notcubag = Round($notcubag * 100, 0);

            $peso_dens_cubagem = sprintf("%05s", $notcubag); // OPCIONAL NUMERICO 3,2			


            $tp_icms = sprintf("%1s", ($PedidoObj->notafiscal->tipoIcms == 'ST') ? "T" : "S"); // D - Diferido, R - Reduzido, P - Presumido,  T - Substituicao,  S - Aliquota Normal/Standard, N - Não incidencia/Isento
            $seguro_efetuado = "N";
            $valor_seguro = sprintf("%015s", "0"); // OPCIONAL NUMERICO 13,2
            $valor_cobrado = sprintf("%015s", "0"); // Valor que sera cobrado// OPCIONAL NUMERICO 13,2
            $num_placa_caminhao = sprintf("%7s", ""); // OPCIONAL
            $plano_carga_rapida = sprintf("%1s", ""); //S - SIM, N - NAO// OPCIONAL
            $frete_peso_volume = sprintf("%015s", "0"); // OPCIONAL NUMERICO 13,2
            $valor_ad_valorem = sprintf("%015s", "0"); // OPCIONAL NUMERICO 13,2
            $total_taxas = sprintf("%015s", "0"); // OPCIONAL NUMERICO 13,2
            $total_frete = sprintf("%015s", "0"); // OPCIONAL NUMERICO 13,2
            $acao_doc = sprintf("%1s", ""); //I - Inclusao, E - Exclusao/Cancelamento// OPCIONAL
            $valor_icms = sprintf("%012s", "0"); // OPCIONAL NUMERICO 10,2
            $valor_icms_retido = sprintf("%012s", "0"); // OPCIONAL NUMERICO 10,2
            $indicacao_bonificacao = sprintf("%1s", ""); // OPCIONAL
            $filler_2 = sprintf("%2s", $filler_2); // OPCIONAL 2
            $dados_nf = $ident_registro . $num_romaneio . $cod_rota . $meio_transp . $tp_transp . $tp_carga . $cond_frete
                    . $serie_nf . $num_nf . $data_emissao . $tp_mercadoria . $especie_acondicionamento
                    . $qtd_volume . $valor_total_nf . $peso_total_mercadoria . $peso_dens_cubagem
                    . $tp_icms . $seguro_efetuado . $valor_seguro . $valor_cobrado . $num_placa_caminhao . $plano_carga_rapida
                    . $frete_peso_volume . $valor_ad_valorem . $total_taxas . $total_frete . $acao_doc . $valor_icms . $valor_icms_retido
                    . $indicacao_bonificacao . $filler_2;
            $conteudoTmp .= $dados_nf;

            $qtd_total_volumes += $aux_volume;
            $qtd_total_peso += $aux_peso;

            $total_nfs += $valor_total_nf;

            $total_pesobru += $notpesob;
            $total_cubagem += $notcubag;

            $sql_aux = "SELECT natcod FROM natureza where natcodigo = '$aux_nat'";
            $consulta_aux = pg_query($sql_aux);
            if (pg_num_rows($consulta_aux)) {
                $cfop = pg_fetch_result($consulta_aux, "0", 'natcod');
            }
            $cfop = substr($cfop, 0, 1) . substr($cfop, 2, 3);

            $tp_periodo_entrega = '0';
            $calc_frete_diferenciado = 'N';

            $ident_registro = "\r\n333";
            $cfop = sprintf("%04s", $cfop); // Codigo
            $tp_periodo_entrega = sprintf("%01s", $tp_periodo_entrega);  // 0 - Sem data definida, 1 - Na data, 2 - Até a Data, 3 - A partir da Data, 4 - No período
            $filler_39 = sprintf("%39s", $filler_39); // OPCIONAL
            $calc_frete_diferenciado = sprintf("%1s", $calc_frete_diferenciado); //S - SIM, N - NAO
            $filler_192 = sprintf("%192s", $filler_192); // OPCIONAL
            $chave_NF = delimitador(trim($PedidoObj->notafiscal->chave), '44', 'L', ' ');

            $dados_comp_nf = $ident_registro . $cfop . $tp_periodo_entrega . $filler_39 . $calc_frete_diferenciado . $filler_192 . $chave_NF;
            $conteudoTmp .= $dados_comp_nf;

            //break;
        }


        //==========CAMPOS ABAIXO ESTÃO COMENTADOS PARA USO FUTURO=========
        //
        //DADOS COMPLEMENTARES DA NF - OPCIONAL
        //$ident_registro = "333";
        //$cfop = sprintf("%04s",$cfop); // Codigo
        //$tp_periodo_entrega = sprintf("%01s",$tp_periodo_entrega);  // 0 - Sem data definida, 1 - Na data, 2 - Até a Data, 3 - A partir da Data, 4 - No período
        //$data_ini_entrega;//DDMMAAAA// OPCIONAL NUMERICO
        //$hora_ini_entrega;//HHMM// OPCIONAL NUMERICO
        //$data_fim_entrega;//DDMMAAAA// OPCIONAL NUMERICO
        //$hora_fim_entrega;//HHMM// OPCIONAL NUMERICO
        //$local_desembarque = sprintf("%15s",$local_desembarque);// OPCIONAL
        //$calc_frete_diferenciado = sprintf("%1s",$calc_frete_diferenciado); //S - SIM, N - NAO
        //$ident_tab_preco_frete = sprintf("%10s",$ident_tab_preco_frete); // OPCIONAL
        //$entrega_casada_cnpj1 = sprintf("%015s",$entrega_casada_cnpj1);// OPCIONAL NUMERICO
        //$entrega_casada_serie_nf1 = sprintf("%3s",$entrega_casada_serie_nf1);// OPCIONAL
        //$entrega_casada_num_nf1 = sprintf("%08s",$entrega_casada_num_nf1);// OPCIONAL NUMERICO
        //$entrega_casada_cnpj2 = sprintf("%015s",$entrega_casada_cnpj2);// OPCIONAL NUMERICO
        //$entrega_casada_serie_nf2 = sprintf("%3s",$entrega_casada_serie_nf2);// OPCIONAL
        //$entrega_casada_num_nf2 = sprintf("%08s",$entrega_casada_num_nf2);// OPCIONAL NUMERICO
        //$entrega_casada_cnpj3 = sprintf("%015s",$entrega_casada_cnpj3);// OPCIONAL NUMERICO
        //$entrega_casada_serie_nf3 = sprintf("%3s",$entrega_casada_serie_nf3);// OPCIONAL
        //$entrega_casada_num_nf3 = sprintf("%08s",$entrega_casada_num_nf3);// OPCIONAL NUMERICO
        //$entrega_casada_cnpj4 = sprintf("%015s",$entrega_casada_cnpj4);// OPCIONAL NUMERICO
        //$entrega_casada_serie_nf4 = sprintf("%3s",$entrega_casada_serie_nf4);// OPCIONAL
        //$entrega_casada_num_nf4 = sprintf("%08s",$entrega_casada_num_nf4);// OPCIONAL NUMERICO
        //$entrega_casada_cnpj5 = sprintf("%015s",$entrega_casada_cnpj5);// OPCIONAL NUMERICO
        //$entrega_casada_serie_nf5 = sprintf("%3s",$entrega_casada_serie_nf5);// OPCIONAL
        //$entrega_casada_num_nf5 = sprintf("%08s",$entrega_casada_num_nf5);// OPCIONAL NUMERICO
        //$despesas_adic_transporte= sprintf("%015s",$despesas_adic_transporte);// OPCIONAL NUMERICO 13,2
        //$tp_veiculo_transp = sprintf("%5s",$tp_veiculo_transp);// ver manual NOTFIS pág. 12 // OPCIONAL
        //$filial_emis_transp_contratante = sprintf("%10s",$filial_emis_transp_contratante);//Usado para redespacho // OPCIONAL
        //$serie_transp_contratante = sprintf("%5s",$serie_transp_contratante);//Usado para redespacho// OPCIONAL
        //$numero_transp_contratante = sprintf("%12s",$numero_transp_contratante);//Usado para redespacho// OPCIONAL
        //$filler_5 = sprintf("%5s",$filler_5);// OPCIONAL
        //$dados_comp_nf = $ident_registro . $cfop . $tp_periodo_entrega . $data_ini_entrega . $hora_ini_entrega
        //                                . $data_fim_entrega . $hora_fim_entrega . $local_desembarque . $calc_frete_diferenciado
        //                                . $ident_tab_preco_frete . $ident_tab_preco_frete
        //                                . $entrega_casada_cnpj1 . $entrega_casada_serie_nf1 . $entrega_casada_num_nf1
        //                                . $entrega_casada_cnpj2 . $entrega_casada_serie_nf2 . $entrega_casada_num_nf2
        //                                . $entrega_casada_cnpj3 . $entrega_casada_serie_nf3 . $entrega_casada_num_nf3
        //                                . $entrega_casada_cnpj4 . $entrega_casada_serie_nf4 . $entrega_casada_num_nf4
        //                                . $entrega_casada_cnpj5 . $entrega_casada_serie_nf5 . $entrega_casada_num_nf5
        //                                . $despesas_adic_transporte . $tp_veiculo_transp . $tp_veiculo_transp
        //                                . $filial_emis_transp_contratante . $filler_5 ;
        //
        //if( $inserirCompNF ) {
        //    $conteudoTmp .= $dados_comp_nf;
        //}
        //------------------------------------------------------------------------------------------
        //MERCADORIA NF -  para cada 313  - OPCIONAL
        //$ident_registro = "314";
        //$qtd_volume1 = sprintf("%07s",$qtd_volume1); // 5,2
        //$especie_acondicionamento1 = sprintf("%15s",$especie_acondicionamento1);
        //$mercadoria_nf1 = sprintf("%30s",$mercadoria_nf1);
        //$qtd_volume2 = sprintf("%07s",$qtd_volume2); // 5,2// OPCIONAL NUMERICO
        //$especie_acondicionamento2 = sprintf("%15s",$especie_acondicionamento2);// OPCIONAL
        //$mercadoria_nf2 = sprintf("%30s",$mercadoria_nf2);// OPCIONAL
        //$qtd_volume3 = sprintf("%07s",$qtd_volume3); // 5,2// OPCIONAL NUMERICO
        //$especie_acondicionamento3 = sprintf("%15s",$especie_acondicionamento3);// OPCIONAL
        //$mercadoria_nf3 = sprintf("%30s",$mercadoria_nf3);// OPCIONAL
        //$qtd_volume4 = sprintf("%07s",$qtd_volume4); // 5,2// OPCIONAL NUMERICO
        //$especie_acondicionamento4 = sprintf("%15s",$especie_acondicionamento4);// OPCIONAL
        //$mercadoria_nf4 = sprintf("%30s",$mercadoria_nf4);// OPCIONAL
        //$qtd_volume5 = sprintf("%07s",$qtd_volume5); // 5,2// OPCIONAL NUMERICO
        //$especie_acondicionamento5 = sprintf("%15s",$especie_acondicionamento5);// OPCIONAL
        //$mercadoria_nf5 = sprintf("%30s",$mercadoria_nf5);// OPCIONAL
        //$filler_29 = sprintf("%29s",$filler_29);// OPCIONAL
        //$mercadoria_nf = $ident_registro
        //                                . $qtd_volume1 . $especie_acondicionamento1 . $mercadoria_nf1
        //                                . $qtd_volume2 . $especie_acondicionamento2 . $mercadoria_nf2
        //                                . $qtd_volume3 . $especie_acondicionamento3 . $mercadoria_nf3
        //                                . $qtd_volume4 . $especie_acondicionamento4 . $mercadoria_nf4
        //                                . $qtd_volume5 . $especie_acondicionamento5 . $mercadoria_nf5
        //                                . $filler_29;
        //
        //if($inserirMercadoriaNF){
        //    $conteudoTmp .= $mercadoria_nf;
        //}
        //------------------------------------------------------------------------------------------
        //DADOS CONSIGNATARIO DA MERCADORIA - para cada 313 - OPCIONAL
        //$ident_registro = "315";
        //$razao_social1 =  sprintf("%40s",$razao_social1);
        //$cnpj1 = substr($cnpj1,0,14);
        //$ie1 =  sprintf("%15s",$ie1);// OPCIONAL
        //$endereco1 =  sprintf("%40s",$endereco1);
        //$bairro1 =  sprintf("%20s",$bairro1);// OPCIONAL
        //$cidade1 =  sprintf("%35s",$cidade1);
        //$cep1 =  sprintf("%9s",$cep1);
        //$cod_municipio1 = sprintf("%9s",$cod_municipio1);// OPCIONAL
        //$subentidade_pais1 = sprintf("%9s",$subentidade_pais1);
        //$num_comunicacao1 = sprintf("%35s",$num_comunicacao1);// OPCIONAL
        //$filler_11 = sprintf("%11s", $filler_11);// OPCIONAL
        //$dados_consig_mercadoria = $ident_registro . $razao_social1 . $cnpj1 . $ie1
        //                                                    . $endereco1 . $bairro1 . $cidade1 . $cep1
        //                                                    . $cod_municipio1 . $subentidade_pais1 . $num_comunicacao1 . $filler_11;
        //
        //if($inserirConsigMercadoria){
        //    $conteudoTmp .= $dados_consig_mercadoria;
        //}
        //------------------------------------------------------------------------------------------
        //DADOS REDESPACHO DA MERCADORIA - para cada 313 - OPCIONAL
        //$ident_registro = "316";
        //$razao_social2 =  sprintf("%40s",$razao_social2);
        //$cnpj2 = substr($cnpj2,0,14);
        //$ie2 =  sprintf("%15s",$ie2);// OPCIONAL
        //$endereco2 =  sprintf("%40s",$endereco2);
        //$bairro2 =  sprintf("%20s",$bairro2);// OPCIONAL
        //$cidade2 =  sprintf("%35s",$cidade2);
        //$cep2 =  sprintf("%9s",$cep2);
        //$cod_municipio2 = sprintf("%9s",$cod_municipio2);// OPCIONAL
        //$subentidade_pais2 = sprintf("%9s",$subentidade_pais2);
        //$area_frete2 = sprintf("%4s",$area_frete2);
        //$num_comunicacao2 = sprintf("%35s",$num_comunicacao2);// OPCIONAL
        //$filler_7 = sprintf("%7s",$filler_7);// OPCIONAL
        //$redespacho_mercadoria = $ident_registro . $razao_social2 . $cnpj2 . $ie2
        //                                                . $endereco2 . $bairro2 . $cidade2 . $cep2 . $cod_municipio2 . $subentidade_pais2
        //                                                . $area_frete2 . $num_comunicacao2 . $filler_7;
        //
        //if($fazerRedespachoMercadoria){
        //    $conteudoTmp .= $redespacho_mercadoria;
        //}
        //
        ////------------------------------------------------------------------------------------------
        ////DADOS RESPONSAVEL PELO FRETE - para cada 313 - OPCIONAL
        //$ident_registro = "317";
        //$razao_social3 =  sprintf("%40s",$razao_social3);
        //$cnpj3 = substr($cnpj3,0,14);
        //$ie3 =  sprintf("%15s",$ie3);// OPCIONAL
        //$endereco3 =  sprintf("%40s",$endereco3);
        //$bairro3 =  sprintf("%20s",$bairro3);// OPCIONAL
        //$cidade3 =  sprintf("%35s",$cidade3);
        //$cep3 =  sprintf("%9s",$cep3);
        //$cod_municipio3 = sprintf("%9s",$cod_municipio3);// OPCIONAL
        //$subentidade_pais3 = sprintf("%9s",$subentidade_pais3);
        //$num_comunicacao3 = sprintf("%35s",$num_comunicacao3);// OPCIONAL
        //$filler_11 = sprintf("11s",$filler_11);// OPCIONAL
        //$responsavel_frete = $ident_registro . $razao_social3 . $cnpj3 . $ie3
        //                                                . $endereco3 . $bairro3 . $cidade3 . $cep3 . $cod_municipio3 . $subentidade_pais3
        //                                                . $area_frete3 . $num_comunicacao3 . $filler_11;
        //if($inserirRespFrete){
        //    $conteudoTmp .= $responsavel_frete;
        //}
        //------------------------------------------------------------------------------------------
        //VALORES TOTAIS DO DOCUMENTO
        $ident_registro = "\r\n318";
        $total_nfs = sprintf("%015s", $total_nfs); //13,2
        $peso_total_nfs = sprintf("%015s", $total_pesobru); //13,2
        $peso__total_dens_cubagem = sprintf("%015s", $total_cubagem); //13,2// OPCIONAL NUMERICO
        $qtd_total_volumes = sprintf("%013s", $qtd_total_volumes) . "00"; //13,2
        $valor_total = sprintf("%015s", "0"); //13,2// OPCIONAL NUMERICO
        $valor_total_seguro = sprintf("%015s", "0"); //13,2// OPCIONAL NUMERICO
        $filler_147 = sprintf("%174s", ""); // OPCIONAL
        $valorTotalDoc = $ident_registro . $total_nfs . $peso_total_nfs . $peso__total_dens_cubagem . $qtd_total_volumes
                . $valor_total . $valor_total_seguro . $filler_147;
        $conteudoTmp .= $valorTotalDoc;

        $conteudo .= $conteudoTmp;
    }

    //$caminhoArquivo = "remessa.txt";
    $arquivo = fopen("$caminhoArquivo", "x+");

    // Escreve $conteudo no nosso arquivo aberto.
    if (fwrite($arquivo, $conteudo) === FALSE) {
        echo "Não foi possivel escrever no arquivo ($caminhoArquivo)";
        return null;
    }
    fclose($arquivo);

    echo 'Arquivo ' . $caminhoArquivo . ' gerado com sucesso !' . '<br>';

    //Copia arquivo para que esteja no FTP automático
    $copiar = copy($caminhoArquivo, "/home/delta/edi_toymania_nf2/" . $ident_intercambio . '_' . $romnumero . '_' . $dataDDMMAAAA . '_' . $horaHHMM . '_' . "TM.txt");


    //Copia o arquivo para a pasta de Upload
    //Verifica se a Pasta Existe
    $destino = 'arquivos/notfis/';
    if (!is_dir($destino)) {
        mkdir($destino, 0755);
    }
    $nomeArquivoDestino = $ident_intercambio . '_' . $romnumero . '_' . $dataDDMMAAAA . '_' . $horaHHMM . '_' . "TM.txt";
    $arquivoDestino = $destino . $ident_intercambio . '_' . $romnumero . '_' . $dataDDMMAAAA . '_' . $horaHHMM . '_' . "TM.txt";
    if (file_exists($arquivoDestino)) {
        unlink($arquivoDestino);
    }
    $copiar = copy($caminhoArquivo, $arquivoDestino);

    //Envia o e-mail se for o Caso			
    if ($enviaEmail == 1) {

        print("<br>");
        print("<br>");
        print("Enviando E-mail!");

        ob_flush();

        //Usa os dados da tabela de Parametros
        $sqlmail = "Select * from parametrosemail where tipo=6 LIMIT 1";
        //$sqlmail = "Select * from parametrosemail where tipo=1 LIMIT 1";
        $cadmail = pg_query($sqlmail);
        if (pg_num_rows($cadmail)) {
            $paremail = pg_fetch_result($cadmail, 0, "email");
            $parsenha = pg_fetch_result($cadmail, 0, "senha");
            $parsmtp = pg_fetch_result($cadmail, 0, "smtp");
            $parporta = pg_fetch_result($cadmail, 0, "usuario");
            $smtpuser = pg_fetch_result($cadmail, 0, "smtpuser");
            $smtppass = pg_fetch_result($cadmail, 0, "smtppass");
        } else {
            $paremail = '';
            $parsenha = '';
            $parsmtp = '';
            $parporta = '';
            $smtpuser = '';
            $smtppass = '';
        }
        $from = $paremail;

        $nomedoarquivo = 'notfis' . date("YmdHis") . '.txt';
        $acao = "1";
        $id = "'";

        $destinatarios = '';
        $remetente = $from;
        $assunto = '';
        $mensagem = '';

        $data = date("Y-m-d");
        $aux = getdate();
        $data = substr($data, 0, 10) . ' ' . $aux['hours'] . ':' . $aux['minutes'] . ":" . $aux['seconds'] . '-03';

        $path = DIR_ROOT . '/lib';
        set_include_path(get_include_path() . PATH_SEPARATOR . $path);
        require_once("Zend/Loader/Autoloader.php");

        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->setFallbackAutoloader(true);

        $data = date("d/m/Y H:i:s");

        //configura para envio de email
        if (!$smtpuser) {
            $config = array("auth" => "login", "username" => $paremail, "password" => $parsenha, "port" => $parporta);
        } else {
            $config = array("ssl" => "tls", "auth" => "login", "username" => $smtpuser, "password" => $smtppass, "port" => $parporta);
        }
        $tr = new Zend_Mail_Transport_Smtp($parsmtp, $config);

        Zend_Mail::setDefaultTransport($tr);
        //funcao para envio de email - Zend_Mail
        $mail = new Zend_Mail();

        $mail->setFrom($remetente, "Workflow Toymania");

        $email = "";

        //Envia para todos o e-mail principal da Transportadora
        /*
          $sql = "Select traemail FROM transportador where tracodigo=$codtransp";
          $sql = pg_query($sql);
          $row = pg_num_rows($sql);
          if($row)
          {
          $email = pg_fetch_result($sql, 0, "traemail");
          }
         */

        //Envia para todos os Contatos da Transportadora
        $sql = "Select traemail FROM transportadorcontato where tracodigo=$codtransp";
        $sql = pg_query($sql);
        $row = pg_num_rows($sql);
        if ($row) {
            //PERCORRE ARRAY
            for ($i = 0; $i < $row; $i++) {
                if ($email == '') {
                    $email = pg_fetch_result($sql, $i, "traemail");
                } else {
                    $email = $email . ";" . pg_fetch_result($sql, $i, "traemail");
                }
            }
        }


        if ($email == '') {

            print("<br>");
            print("Nenhum E-mail cadastrado para a Transportadora!");
        } else {

            $sql = "Select notmail FROM notemail";
            $sql = pg_query($sql);
            $row = pg_num_rows($sql);
            if ($row) {
                //PERCORRE ARRAY
                for ($i = 0; $i < $row; $i++) {
                    $email = $email . ";" . pg_fetch_result($sql, $i, "notmail");
                }
            }

            $texto = $email;

            $mails = explode(";", $texto);

            foreach ($mails as $value) {

                if (trim($value)) {

                    $mail->addTo(trim(strtolower($value)));
                    $destinatarios .= trim(strtolower($value));
                }
            }

            $msg .= "<br /><b>" . nl2br($msg1) . "</b>";
            $msg = str_replace('_', '', $msg);
            //$mail->setSubject("NotFis Toy Mania " . $data);
            $mail->setSubject("NotFis Toy Mania - " . $romnumeroano);

            $msg .= "<br /><br /><h5>" . "Segue em anexo arquivo NotFis com pedidos exportados da Toymania" . '</ h5>';

            $msg .= "<br /><br /><h5>" . "Romaneio : " . $romnumeroano . '</ h5>';

            $msg .= "<br /><br /><h5>" . $data . '</ h5>';


            $mail->setBodyHTML($msg);

            $diretorio = 'arquivos/notfis';

            if (is_dir($diretorio)) {

                //$file = $diretorio.'/pedidos.csv';
                $file = $arquivoDestino;

                $at = new Zend_Mime_Part(file_get_contents($file));
                $at->filename = basename($file);
                $at->disposition = Zend_Mime::DISPOSITION_ATTACHMENT;
                //$at->encoding = Zend_Mime::ENCODING_8BIT;
                $at->encoding = Zend_Mime::ENCODING_BASE64;

                $mail->addAttachment($at);
            }

            if ($where != '') {
                //Vai fazer um Looping para Processar todos os XMLS 
                $query = "select a.notnumero from notagua a 		
						$where order by a.notemissao asc";

                $cad = pg_query($query);
                for ($i = 0; $i < pg_num_rows($cad); $i++) {
                    $array = pg_fetch_object($cad);

                    $nomexml = ESTABELECIMENTO_TOY . '001' . str_pad($array->notnumero, 7, "0", STR_PAD_LEFT) . '.xml';

                    //$aquivoxml = "/home/delta/datasul_toymania/datasul_nfe_copia/" . $nomexml;
                    $aquivoxml = "/home/delta/datasul_nfe_copia_50/" . $nomexml;

                    if (file_exists($aquivoxml)) {

                        $file = $aquivoxml;

                        $at = new Zend_Mime_Part(file_get_contents($file));
                        $at->filename = basename($file);
                        $at->disposition = Zend_Mime::DISPOSITION_ATTACHMENT;
                        //$at->encoding = Zend_Mime::ENCODING_8BIT;
                        $at->encoding = Zend_Mime::ENCODING_BASE64;

                        $mail->addAttachment($at);
                    }

                    //echo 'NFe: ' . $array->notnumero . ' - ' . $nomexml . '<br>';
                    //ob_flush();
                }
            }

            try {
                $mail->send();
                print("<br>");
                print("<br>");
                print("E-mail Encaminhado!");
                logEmail("EMAIL ENCAMINHADO ", $nomeArquivoDestino, $texto, $remetente, $assunto, $mensagem, date("Y-m-d H:i:s"));
                //print true;
            } catch (Exception $e) {

                //print false;
                print("<br>");
                print("<br>");
                print("NAO FOI POSSIVEL ENVIAR O EMAIL" . $e->getMessage());
                logEmail("NAO FOI POSSIVEL ENVIAR O EMAIL" . $e->getMessage(), $nomeArquivoDestino, $texto, $remetente, $assunto, $mensagem, date("Y-m-d H:i:s"), true);
            }
        }
    }

    $retorno->arquivo = $caminhoArquivo;
    $retorno->nome = $ident_intercambio;

    //return true;
    return $nomeArquivoDestino;

//            print $json->encode($retorno);
}

function cellColor($cells, $color, $objPHPExcelx) {
    $objPHPExcelx->getActiveSheet()->getStyle($cells)->getFill()
            ->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array('rgb' => $color)
    ));
}

function cellColor_b($cells, $color, $objPHPExcel_bx) {
    $objPHPExcel_bx->getActiveSheet()->getStyle($cells)->getFill()
            ->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array('rgb' => $color)
    ));
}

?>