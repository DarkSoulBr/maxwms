<?php

//pega da pasta de istalacao
$arr = explode("/", $_SERVER['REQUEST_URI']);
if (!$root)
    $root = $arr[1];

//pega as configurações do servidor
require_once($_SERVER['DOCUMENT_ROOT'] . "/$root/include/config.php");
require_once(DIR_ROOT . '/include/conexao.inc.php');
require_once(DIR_ROOT . '/include/classes/JSON/JSON.php');
require_once(DIR_ROOT . '/include/classes/Excel/Reader/Reader.php');

require_once(DIR_ROOT . '/modulos/vendaAtacado/pedidos/manutencao/model/PedidoModel.php');

require_once(DIR_ROOT . '/vo/PedidoVO.php');
require_once(DIR_ROOT . '/vo/ItemPedidoVO.php');
require_once(DIR_ROOT . '/vo/ItemEstoqueVO.php');
require_once(DIR_ROOT . '/vo/EstoqueAtualVO.php');
require_once(DIR_ROOT . '/vo/ProdutoVO.php');
require_once(DIR_ROOT . '/vo/ClienteVO.php');
require_once(DIR_ROOT . '/vo/TipoPedidoVO.php');
require_once(DIR_ROOT . '/vo/EstoqueVO.php');

$uploaddir = DIR_UPLOADS . '/tmp/';

$data = getdate();
$num = md5($data[0]);
$name = substr($num, 0, 8) . ".xls";

$file = $uploaddir . basename($name);

$retorno = new stdClass();

$json = new Services_JSON();

$data = new Spreadsheet_Excel_Reader();
$data->setOutputEncoding('UTF-8');

if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) {
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

    $auxest = 0;

    if ($data->sheets[0]['cells'][1][4] == "2" || $pedido->tipoPedido->codigo == EXTERNO_VIX) {
        $estoque = new EstoqueVO(11);
        $pedido->tipolocal = "VIX";
        $auxest = 11;
    } else if ($data->sheets[0]['cells'][1][4] == "3") {
        $estoque = new EstoqueVO(1);
        $pedido->tipolocal = "LOJA NOVA (1)";
        $auxest = 1;
    } else if ($data->sheets[0]['cells'][1][4] == "4") {
        $estoque = new EstoqueVO(2);
        $pedido->tipolocal = "LOJA (2)";
        $auxest = 2;
    } else {
        $estoque = new EstoqueVO(9);
        $pedido->tipolocal = "SP";
        $auxest = 26;
    }

    for ($i = 7; $i <= $data->sheets[0]['numRows']; $i++) {
        if (trim($data->sheets[0]['cells'][$i][1])) {
            $itemPedido = new ItemPedidoVO();
            $itemPedido->pvicodigo = 0;
            $itemPedido->pvitem = ($i - 9);
            $itemPedido->pvitippr = ($data->sheets[0]['cells'][$i][3] ? $data->sheets[0]['cells'][$i][3] : "C");

            $itemPedido->produto = new ProdutoVO($data->sheets[0]['cells'][$i][1], "procod");


            //09/03

            if ($auxest == 11) {
                $itemPedido->pvitippr = "D";
            } else if ($auxest == 26) {
                if ($itemPedido->pvitippr == "D") {
                    $itemPedido->pvitippr = "C";
                }
            } else {
                if ($itemPedido->pvitippr == "D") {
                    /*
                      if($itemPedido->produto->fornecedor->forcodigo==157){
                      $itemPedido->pvitippr = "B";
                      }
                      else {
                      $itemPedido->pvitippr = "C";
                      }
                     */
                    $itemPedido->pvitippr = "C";
                } else if ($itemPedido->pvitippr == "C") {
                    /*
                      if($itemPedido->produto->fornecedor->forcodigo==157){
                      $itemPedido->pvitippr = "B";
                      }
                     */
                }
            }

            if ($pedido->tipoPedido->codigo == DEVOLUCAO || $pedido->tipoPedido->codigo == ABASTECIMENTO ||
                    $pedido->tipoPedido->codigo == BAIXA || $pedido->tipoPedido->codigo == ALMOXERIFADO) {
                if ($estoque->etqcodigo == VIX) {
                    $itemPedido->produto->tabelaValores[A] = (float) $itemPedido->produto->profinalv;
                    $itemPedido->produto->tabelaValores[B] = (float) $itemPedido->produto->profinalv;
                    $itemPedido->produto->tabelaValores[C] = (float) $itemPedido->produto->profinalv;
                } else {
                    $itemPedido->produto->tabelaValores[A] = (float) $itemPedido->produto->profinal;
                    $itemPedido->produto->tabelaValores[B] = (float) $itemPedido->produto->profinal;
                    $itemPedido->produto->tabelaValores[C] = (float) $itemPedido->produto->profinal;
                }
            }

            $pvipreco = (float) trim($data->sheets[0]['cells'][$i][4]);

            //Verifica se existe desconto 
            if ($pedido->tipoPedido->codigo == DEVOLUCAO || $pedido->tipoPedido->codigo == ABASTECIMENTO ||
                    $pedido->tipoPedido->codigo == BAIXA || $pedido->tipoPedido->codigo == ALMOXERIFADO) {
                $desconto = 0;
            } else {

                $desconto = 0;

                //Produra o Desconto por Fornecedor
                $auxcli = $pedido->cliente->clicodigo;
                $auxfor = $itemPedido->produto->fornecedor->forcodigo;

                if ($auxcli != '') {

                    $sqlaux = "SELECT percentual FROM clientesfornecedores 
							Where clicodigo = $auxcli  
							and forcodigo = $auxfor";

                    $cadaux = pg_query($sqlaux);

                    if (pg_num_rows($cadaux)) {
                        $desconto = pg_result($cadaux, 0, "percentual");
                    }

                    //Procura o Desconto por Grupo					
                    if ($desconto == 0) {
                        $auxgru = $itemPedido->produto->grupo->grucodigo;

                        //$auxgru = 1;

                        $sqlaux = "SELECT percentual FROM clientesgrupos 
								Where clicodigo = $auxcli  
								and grucodigo = $auxgru";

                        $cadaux = pg_query($sqlaux);

                        if (pg_num_rows($cadaux)) {
                            $desconto = pg_result($cadaux, 0, "percentual");
                        }
                    }
                }
            }

            $itemPedido->pvipreco = $pvipreco ? $pvipreco : ($itemPedido->produto->tabelaValores[$itemPedido->pvitippr] - ($itemPedido->produto->tabelaValores[$itemPedido->pvitippr] * ($desconto / 100)));

            $itemPedido->pvisaldo = (float) $data->sheets[0]['cells'][$i][2];

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
        }
    }

    if (!count($itensPedido) && count($itensPedidoEmpenho)) {
        $pedido->tipoPedido = new TipoPedidoVO(TIPO_EMPENHO, "tipcodigo");
    }

    $retorno->retorno = true;
    $retorno->mensagem = "IMPORTACAO DE PEDIDO REALIZADA.";

    if (count($notProduto)) {
        $retorno->mensagem .= count($notProduto) . " PRODUTOS NAO LOCALIZADOS OU SEM ENTRADA EM ESTOQUE: <br>  - LISTA DE ITENS NAO CARREGADOS: <br>" . implode(", ", $notProduto);
    }

    $retorno->pedido = $pedido;
    $retorno->itensPedido = $itensPedido;
    $retorno->itensPedidoEmpenho = $itensPedidoEmpenho;

    unlink($file);
} else {
    $retorno->retorno = false;
    $retorno->mensagem = "FALHA NA IMPORTACAO DE PEDIDO: " . $_FILES['uploadfile']['error'] . " --- " . $_FILES['uploadfile']['tmp_name'] . " %%% " . $file;
}

print $json->encode($retorno);
?>