<?php
/**
 * Faz a leitura de uma planilha Excel e Retorna os Dados em Formato Json 
 *
 * Programa que le os dados de uma planilha Excel fazendo algumas validacoes 
 * e Retorna os Dados no Formato Json para carregar os dados na Tela de Digitacao
 * de Pedidos de Compra
 *
 * @name Compras Import
 * @link uploadexcelcompra.php
 * @version 50.3.6
 * @since 1.0.0
 * @author Luis Ramires <delta.mais@uol.com.br>
 * @copyright MaxTrade
 *
 * @global integer $_GET["usuario"] Codigo do Usuario
 */

$usuario = $_GET["usuario"];

//pega da pasta de istalacao
$arr = explode("/", $_SERVER['REQUEST_URI']);
if (!$root)
    $root = $arr[1];

//pega as configuracoes do servidor
require_once($_SERVER['DOCUMENT_ROOT'] . "/$root/include/config.php");
require_once(DIR_ROOT . '/include/classes/Excel/Reader/Reader.php');
require_once(DIR_ROOT . '/include/conexao.inc.php');

require_once(DIR_ROOT . '/modulos/vendaAtacado/pedidos/manutencao/model/PedidoModel.php');

require_once(DIR_ROOT . '/vo/PedidoVO.php');
require_once(DIR_ROOT . '/vo/ItemPedidoCompraVO.php');
require_once(DIR_ROOT . '/vo/ItemEstoqueVO.php');
require_once(DIR_ROOT . '/vo/EstoqueAtualVO.php');
require_once(DIR_ROOT . '/vo/ProdutoVO.php');
require_once(DIR_ROOT . '/vo/ClienteVO.php');
require_once(DIR_ROOT . '/vo/TipoPedidoVO.php');
require_once(DIR_ROOT . '/vo/EstoqueVO.php');

$uploaddir = DIR_UPLOADS . '/tmp/';

$data = getdate();
$num = md5($data[0]);

$name = $usuario . ".xls";

$file = $uploaddir . basename($name);

$retorno = new stdClass();

$data = new Spreadsheet_Excel_Reader();
$data->setOutputEncoding('UTF-8');

if (file_exists($file)) {

    $data->read($file);

    $pedido = new PedidoVO();
    $pedido->pvvalor = 0;
    $itensPedido = array();
    $itensPedidoEmpenho = array();

    $tipo = trim($data->sheets[0]['cells'][1][2]);
    switch ($tipo) {
        case '1':
            $atipo = 'I';
            break;
        case '2':
            $atipo = 'A';
            break;
        case '3':
            $atipo = 'E';
            break;
        case '4':
            $atipo = 'I';
            break;
        case '5':
            $atipo = 'N';
            break;
        case '6':
            $atipo = 'R';
            break;
        case '7':
            $atipo = 'T';
            break;
        case '8':
            $atipo = 'V';
            break;
        case '9':
            $atipo = 'EV';
            break;
        case '10':
            $atipo = 'ED';
            break;
        case '11':
            $atipo = 'F';
            break;
        case '12':
            $atipo = 'M';
            break;
    }

    $pedido->tipoPedido = new TipoPedidoVO(trim($atipo));

    $pedido->cliente = new ClienteVO((int) $data->sheets[0]['cells'][2][2], "clicod");



    $pedido->condicaoComercial = new CondicaoComercialVO($data->sheets[0]['cells'][5][2], 'descricao');
    $pedido->vendedor = new VendedorVO((int) $data->sheets[0]['cells'][3][2]);
    $pedido->transportadora = new TransportadoraVO((int) $data->sheets[0]['cells'][4][2]);

    $pedido->pvtipofrete = "1";
    $pedido->pvvaldesc = 0;
    $pedido->pvperdesc = 0;


    if ($data->sheets[0]['cells'][1][4] == "2" || $pedido->tipoPedido->codigo == EXTERNO_VIX) {
        $estoque = new EstoqueVO(11);
        $pedido->tipolocal = "VIX";
    } else if ($data->sheets[0]['cells'][1][4] == "3") {
        $estoque = new EstoqueVO(1);
        $pedido->tipolocal = "LOJA NOVA (1)";
    } else if ($data->sheets[0]['cells'][1][4] == "4") {
        $estoque = new EstoqueVO(2);
        $pedido->tipolocal = "LOJA (2)";
    } else if ($data->sheets[0]['cells'][1][4] == "5") {
        $estoque = new EstoqueVO(26);
        $pedido->tipolocal = "CD SP";
    } else {
        $estoque = new EstoqueVO(9);
        $pedido->tipolocal = "CD RE";
    }

    for ($i = 7; $i <= $data->sheets[0]['numRows']; $i++) {
        if (trim($data->sheets[0]['cells'][$i][1])) {

            $auxcod = trim($data->sheets[0]['cells'][$i][1]);

            //Verifica se o produto ja foi Validado            
            $sqlaux = "SELECT provalida,profinal,proipi,probruto,forcodigo,stpcodigo FROM produto WHERE procod='$auxcod'";
            $cadaux = pg_query($sqlaux);
            $validado = '';
            $stpcodigo = 0;
            if (pg_num_rows($cadaux)) {
                $validado = pg_fetch_result($cadaux, 0, "provalida");
                $stpcodigo = (int) pg_fetch_result($cadaux, 0, "stpcodigo");
                $auxfinal = pg_fetch_result($cadaux, 0, "profinal");
                $auxipi = pg_fetch_result($cadaux, 0, "proipi");
                $auxbruto = pg_fetch_result($cadaux, 0, "probruto");
                $auxforcodigo = pg_fetch_result($cadaux, 0, "forcodigo");
            }

            //So inclui itens que estao validados
            if ($validado != '') {
                
                //So inclui produtos desde que o Status nao seja INATIVO e FORA DE LINHA
                if($stpcodigo!= 3) {

                    $itemPedido = new ItemPedidoCompraVO();
                    $itemPedido->pvicodigo = 0;
                    $itemPedido->pvitem = ($i - 9);
                    $itemPedido->pvitippr = ($data->sheets[0]['cells'][$i][3] ? $data->sheets[0]['cells'][$i][3] : "C");
                    $itemPedido->produto = new ProdutoVO($data->sheets[0]['cells'][$i][1], "procod");


                    $itemPedido->pvisaldo = (float) $data->sheets[0]['cells'][$i][2];
                    if ($auxbruto > 0) {
                        $itemPedido->pvipreco = $auxbruto;
                    } else {
                        $itemPedido->pvipreco = $auxfinal;
                    }

                    $auxdesc1 = 0;
                    $auxdesc2 = 0;
                    $auxdesc3 = 0;
                    $auxdesc4 = 0;
                    $sqlaux = "SELECT * FROM condicaopagto WHERE forcodigo='$auxforcodigo'";
                    $cadaux = pg_query($sqlaux);
                    if (pg_num_rows($cadaux)) {
                        $auxdesc1 = pg_fetch_result($cadaux, 0, "desc1");
                        $auxdesc2 = pg_fetch_result($cadaux, 0, "desc2");
                        $auxdesc3 = pg_fetch_result($cadaux, 0, "desc3");
                        $auxdesc4 = pg_fetch_result($cadaux, 0, "desc4");
                    }

                    $itemPedido->valDesconto1 = (float) $auxdesc1;
                    $itemPedido->valDesconto2 = (float) $auxdesc2;
                    $itemPedido->valDesconto3 = (float) $auxdesc3;
                    $itemPedido->valDesconto4 = (float) $auxdesc4;
                    $itemPedido->valIpi = (float) $auxipi;
                    $itemPedido->datEntrega = '';

                    $itemEstoque = new ItemEstoqueVO();

                    $estoqueAtual = PedidoModel::getEstoqueAtual($estoque->etqcodigo, $itemPedido->produto->procodigo);



                    $itemEstoque->estoqueAtual = $estoqueAtual->estoqueAtual;
                    $itemEstoque->pvieqtd = (int) $data->sheets[0]['cells'][$i][2];
                    $itemEstoque->pviedatacadastro = date("c");
                    $itemEstoque->pviesituacao = true;

                    $itemPedido->estoques[] = $itemEstoque;
                    $itemPedido->pvidatacadastro = date("c");
                    $itemPedido->pvisituacao = true;

                    $isDuplicado = false;

                    if (count($itensPedido)) {
                        foreach ($itensPedido as $vItem) {
                            if ($vItem->produto->procodigo == $itemPedido->produto->procodigo) {
                                $isDuplicado = true;
                            }
                        }
                    }
                    if (count($itensPedidoEmpenho)) {
                        foreach ($itensPedidoEmpenho as $vItemE) {
                            if ($vItemE->produto->procodigo == $itemPedido->produto->procodigo) {
                                $isDuplicado = true;
                            }
                        }
                    }

                    if ($itemPedido->produto->procodigo && $estoqueAtual->retorno) {
                        if (!$isDuplicado) {
                            if ($estoqueAtual->estoqueAtual->estoque->etqcodigo == EMPENHO) {
                                $itensPedidoEmpenho[] = $itemPedido;
                            } else {
                                $itensPedido[] = $itemPedido;
                            }

                            $pedido->pvvalor += $itemPedido->pvipreco * $itemEstoque->pvieqtd;
                        }
                    } else {
                        $notProduto[] = $data->sheets[0]['cells'][$i][1];
                    }
                } else {
                    $notProduto[] = $data->sheets[0]['cells'][$i][1];
                }
            } else {
                $notProduto[] = $data->sheets[0]['cells'][$i][1];
            }
        }
    }

    if (!count($itensPedido) && count($itensPedidoEmpenho)) {
        $pedido->tipoPedido = new TipoPedidoVO(TIPO_EMPENHO, "tipcodigo");
    }

    $retorno->retorno = true;
    $retorno->mensagem = "IMPORTACAO DE PEDIDO REALIZADA.";

    if (count($notProduto)) {
        $retorno->mensagem .= "\n" . count($notProduto) . " PRODUTOS NAO LOCALIZADOS, NAO VALIDADOS OU \n INATIVOS: \n" . implode(", ", $notProduto);
    }

    $retorno->pedido = $pedido;
    $retorno->itensPedido = $itensPedido;
    $retorno->itensPedidoEmpenho = $itensPedidoEmpenho;

    unlink($file);
} else {
    $retorno->retorno = false;
    $retorno->mensagem = "FALHA NA IMPORTACAO DE PEDIDO";
}

print json_encode($retorno);
