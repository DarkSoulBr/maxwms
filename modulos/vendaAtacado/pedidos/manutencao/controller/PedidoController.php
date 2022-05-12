<?php

//pega da pasta de istalacao
$arr = explode("/", $_SERVER['REQUEST_URI']);
$root = $arr[1];

//pega as configurações do servidor
require_once($_SERVER['DOCUMENT_ROOT'] . "/$root/include/config.php");
//require_once(DIR_ROOT.'/include/classes/Excel/Writer.php');
// inclui o model para acesso busca info no banco
require_once(DIR_ROOT . '/modulos/vendaAtacado/pedidos/manutencao/model/PedidoModel.php');
require_once(DIR_ROOT . '/modulos/cadastros/clientes/manutencao/model/ClienteModel.php');
require_once(DIR_ROOT . '/include/classes/GeraArquivo.php');
require_once(DIR_ROOT . '/include/classes/JSON/JSON.php');
require_once(DIR_ROOT . '/vo/ItemPedidoVO.php');
require_once(DIR_ROOT . '/vo/TipoPedidoVO.php');
require_once(DIR_ROOT . '/vo/ItemEstoqueVO.php');
require_once(DIR_ROOT . '/vo/EstoqueAtualVO.php');
require_once(DIR_ROOT . '/vo/ItemFormaPagamentoVO.php');
require_once(DIR_ROOT . '/vo/MovEstoqueVO.php');
require_once(DIR_ROOT . '/vo/ProdutoVO.php');
require_once(DIR_ROOT . '/vo/PedParcelasVO.php');

/**
 * Classe de controle para crud do pedido (regras de negocio).
 *   
 * CRUD - (Create, Result, Update, Delete)
 * Este arquivo segue os padroes estabelecidos no dTrade.
 *
 * @access public
 * @name Pedido Controller
 * @package modulos/vendaAtacado/pedidos/manutencao/PedidoController
 * @link modulos/vendaAtacado/pedidos/manutencao/controller/PedidoController.php
 * @version 1.0
 * @since Criado 24/11/2009 Modificado 11/01/2010
 * @author wellington <wellington@centroatacadista.com.br>
 * @exemple modulos/vendaAtacado/pedidos/manutencao/controller/PedidoController.php
 */
Class PedidoController {

    /**
     * Metodo para regras de negocios da inserção do pedido no banco.
     * Instancia a classe model para inserir no banco.
     *
     * @access public
     * @param PedidoVO $pedido Recebe variavel tipada Pedido Value Object.
     * @param PedidoVO $pedidoEmpenho Recebe variavel tipada Pedido Value Object,
     * caso tenha selecionado itens que tenha empenho.
     * @return object Objeto com dados dados do retorno do banco.
     */
    public function inserir(PedidoVO $pedido, $itensPedido) {
        $model = new PedidoModel();

        $retorno = new stdClass();
        $logItensOk = array();
        $logItensErro = array();
        $logItensEp = array();
        $log = "";

        $itensPedidoEmpenho = array();

        $pedido->pvemissao = date('c');

        if ($pedido->tipoPedido->codigo == EXTERNO_SP || $pedido->tipoPedido->codigo == EXTERNO_VIX) {
            $tipoPedido = new TipoPedidoVO(EXTERNO, "tipcodigo");
            $pedido->tipoPedido = $tipoPedido;
        }

        $retornoPedido = $model->inserirPedido($pedido);
        $fecReserva = $retornoPedido->fecreserva;
        $log .= $retornoPedido->mensagem . "\n";

        if ($retornoPedido->retorno) {
            $totalPedido = 0;
            $pedido->pvnumero = $retornoPedido->codigo;

            foreach ($itensPedido as $item) {
                $itemPedido = new ItemPedidoVO();
                $itemPedido->castItemPedidoVO($item);

                $itemPedido->pvidatacadastro = date('c');

                $retornoItem = $model->inserirItem($pedido->pvnumero, $itemPedido);
                $log .= $retornoItem->mensagem . "\n";

                if ($retornoItem->retorno) {
                    $itemPedido->pvicodigo = $retornoItem->codigo;
                    $qtdeEmpenho = 0;

                    $itemPedido->pvisaldo = 0;

                    for ($i = 0; $i < count($itemPedido->estoques); $i++) {
                        $estoqueItem = new ItemEstoqueVO();
                        $estoqueItem->castItemEstoqueVO($itemPedido->estoques[$i]);

                        $estoqueItem->pviedatacadastro = date('c');

                        $retornoEstoqueItem = $model->inserirEstoqueItem($pedido->pvnumero, $itemPedido->pvicodigo, $estoqueItem);
                        $log .= $retornoEstoqueItem->mensagem . "\n";

                        if ($retornoEstoqueItem->retorno) {
                            $estoqueItem->pviecodigo = $retornoEstoqueItem->codigo;

                            $estoqueAtual = new EstoqueAtualVO();
                            $estoqueAtual->castEstoqueAtualVO($estoqueItem->estoqueAtual);

                            $retornoEstoqueAtual = $model->alterarEstoqueAtual($estoqueItem->pvieqtd, 0, $estoqueAtual);
                            $log .= $retornoEstoqueAtual->mensagem . "\n";

                            $estoqueItem->pvieqtd = $retornoEstoqueAtual->qtdeRetirada;
                            $itemPedido->pvisaldo += $estoqueItem->pvieqtd;

                            if (!$retornoEstoqueAtual->isRetiradaTotal) {
                                $qtdeEmpenho += $retornoEstoqueAtual->qtdeEmpenho;

                                if ($qtdeEmpenho) {
                                    if ($estoqueItem->pvieqtd) {
                                        $retornoAtualizaEstoqueItem = $model->alterarEstoqueItem($pedido->pvnumero, $itemPedido->pvicodigo, $estoqueItem);
                                        $log .= $retornoAtualizaEstoqueItem->mensagem . "\n";
                                    }

                                    if ($itemPedido->pvisaldo && $pedido->tipoPedido->codigo != RESERVA) {
                                        $retornoAtualizaItem = $model->alterarItem($pedido->pvnumero, $itemPedido);
                                        $log .= $retornoAtualizaItem->mensagem . "\n";
                                    }

                                    if ($pedido->tipoPedido->codigo == RESERVA) {
                                        $retornoGetEstoqueAtualP = $model->getEstoqueAtual(PENDENTES, $itemPedido->produto->procodigo);
                                        $log .= $retornoGetEstoqueAtualP->mensagem . "\n";

                                        $estoquePendente = new ItemEstoqueVO();
                                        $estoquePendente->pvieqtd = $qtdeEmpenho;
                                        $estoquePendente->estoqueAtual = $retornoGetEstoqueAtualP->estoqueAtual;
                                        $estoquePendente->pviedatacadastro = date('c');
                                        $estoquePendente->pviesituacao = true;

                                        $itemPedido->estoques[] = $estoquePendente;
                                    }
                                }
                            }

                            if ($retornoEstoqueAtual->retorno) {
                                $movEstoque = new MovEstoqueVO();
                                $movEstoque->movcodigo = 0;
                                $movEstoque->pvnumero = $pedido->pvnumero;
                                $movEstoque->movdata = date('c');
                                $movEstoque->produto = $itemPedido->produto;
                                $movEstoque->movqtd = $estoqueItem->pvieqtd;
                                $movEstoque->movvalor = $itemPedido->pvipreco;
                                $movEstoque->movtipo = 2;
                                $movEstoque->estoque = $estoqueAtual->estoque;

                                $retornoMovEstoque = $model->inserirMovEstoque($movEstoque);
                                $log .= $retornoMovEstoque->mensagem . "\n";

                                if ($retornoMovEstoque->retorno) {
                                    $itemPedido->estoques[$i] = $estoqueItem;

                                    if ($pedido->tipoPedido->codigo == ABASTECIMENTO) {
                                        $aEstoques[] = new EstoqueVO(7);
                                        $aEstoques[] = new EstoqueVO(8);
                                        $aEstoques[] = new EstoqueVO(12);
                                        $aEstoques[] = new EstoqueVO(10);

                                        foreach ($aEstoques as $estoque) {
                                            $retornoVerificaEstoque = $model->verificaEstoqueAtual($estoque, $itemPedido->produto);
                                            $log .= $retornoVerificaEstoque->mensagem . "\n";
                                        }

                                        $retornoDestino = $model->getEstoqueDestino($pedido->estoqueOrigem->etqcodigo, $pedido->estoqueDestino->etqcodigo);
                                        $log .= $retornoDestino->mensagem . "\n";

                                        $retornoGetEstoqueAtual = $model->getEstoqueAtual($retornoDestino->estoqueOrigemDestino->estoqueTemporario->etqcodigo, $itemPedido->produto->procodigo);
                                        $log .= $retornoGetEstoqueAtual->mensagem . "\n";

                                        if ($retornoGetEstoqueAtual->retorno) {
                                            $retornoEstoqueAtualAbastecimento = $model->alterarEstoqueAtual(0, $estoqueItem->pvieqtd, $retornoGetEstoqueAtual->estoqueAtual);
                                            $log .= $retornoEstoqueAtualAbastecimento->mensagem . "\n";

                                            if ($retornoEstoqueAtualAbastecimento->retorno) {
                                                $movEstoque->movtipo = 3;
                                                $movEstoque->estoque = $retornoDestino->estoqueOrigemDestino->estoqueTemporario;

                                                $retornoMovEstoqueAbastecimento = $model->inserirMovEstoque($movEstoque);
                                                $log .= $retornoMovEstoqueAbastecimento->mensagem . "\n";

                                                if (!$retornoMovEstoqueAbastecimento->retorno) {
                                                    $logItensErro[] = "[COD.M3A] " . $itemPedido->produto->procod . " " . $itemPedido->produto->prnome . " QTDE: " . $itemPedido->pvisaldo;
                                                }
                                            } else {
                                                $logItensErro[] = "[COD.EAA] " . $itemPedido->produto->procod . " " . $itemPedido->produto->prnome . " QTDE: " . $itemPedido->pvisaldo;
                                            }
                                        } else {
                                            $logItensErro[] = "[COD.GEA] " . $itemPedido->produto->procod . " " . $itemPedido->produto->prnome . " QTDE: " . $itemPedido->pvisaldo;
                                        }
                                    }
                                } else {
                                    $logItensErro[] = "[COD.M2] " . $itemPedido->produto->procod . " " . $itemPedido->produto->prnome . " QTDE: " . $itemPedido->pvisaldo;
                                }
                            } else {
                                $retornoItemEstoqueExcluido = $model->excluirEstoqueItem($estoqueItem->pviecodigo);
                                $log .= $retornoItemEstoqueExcluido->mensagem . "\n";

                                if ($retornoItemEstoqueExcluido->retorno) {
                                    $itemPedido->estoques[$i]->pvieqtd = 0;
                                }

                                if ($pedido->tipoPedido->codigo != RESERVA) {
                                    $retornoItemExcluido = $model->excluirItem($itemPedido->pvicodigo);
                                    $log .= $retornoItemExcluido->mensagem . "\n";

                                    $logItensErro[] = "[COD.EA] " . $itemPedido->produto->procod . " " . $itemPedido->produto->prnome . " QTDE: " . $itemPedido->pvisaldo;
                                }
                            }
                        } else {
                            $logItensErro[] = "[COD.EI] " . $itemPedido->produto->procod . " " . $itemPedido->produto->prnome . " QTDE: " . $itemPedido->pvisaldo;
                        }
                    }

                    if ($itemPedido->pvisaldo) {
                        $retornoItemAntigo = $model->inserirItemAntigo($pedido->pvnumero, $itemPedido);
                        $log .= $retornoItemAntigo->mensagem . "\n";

                        if ($retornoItemAntigo->retorno) {
                            $logItensOk[] = $itemPedido->produto->procod . " " . $itemPedido->produto->prnome . " QTDE: " . $itemPedido->pvisaldo;
                        } else {
                            $logItensErro[] = "[COD.IC] " . $itemPedido->produto->procod . " " . $itemPedido->produto->prnome . " QTDE: " . $itemPedido->pvisaldo;
                        }
                    }
                } else {
                    $logItensErro[] = "[COD.IP] " . $itemPedido->produto->procod . " " . $itemPedido->produto->prnome . " QTDE: " . $itemPedido->pvisaldo;
                }

                if ($qtdeEmpenho > 0 && $pedido->tipoPedido->codigo != RESERVA) {
                    $itemPedidoEmpenho = new ItemPedidoVO();
                    $itemPedidoEmpenho = clone($itemPedido);

                    $retornoGetEstoqueAtualEP = $model->getEstoqueAtual(EMPENHO, $itemPedidoEmpenho->produto->procodigo);
                    $log .= $retornoGetEstoqueAtualEP->mensagem . "\n";

                    $itemPedidoEmpenho->pvisaldo = $qtdeEmpenho;

                    $itemEstoqueEmpenho = new ItemEstoqueVO();
                    $itemEstoqueEmpenho->pvieqtd = $qtdeEmpenho;
                    $itemEstoqueEmpenho->estoqueAtual = $retornoGetEstoqueAtualEP->estoqueAtual;
                    $itemEstoqueEmpenho->pviedatacadastro = date('c');
                    $itemEstoqueEmpenho->pviesituacao = true;

                    $itemPedidoEmpenho->estoques = array();
                    $itemPedidoEmpenho->estoques[] = $itemEstoqueEmpenho;

                    $logItensEp[] = $itemPedidoEmpenho->produto->procod . " " . $itemPedidoEmpenho->produto->prnome . " QTDE: " . $itemPedidoEmpenho->pvisaldo;
                    $itensPedidoEmpenho[] = $itemPedidoEmpenho;
                }

                $totalPedido += (float) $itemPedido->pvipreco * (float) $itemPedido->pvisaldo;
            }

            if ((float) $pedido->pvvalor != (float) $totalPedido) {
                $pedido->pvvalor = $totalPedido;
                $pedido->pvvaldesc = ((float) $pedido->pvperdesc * $totalPedido) / 100;

                $retornoPedidoAlterado = $model->alterarPedido($pedido);
                $log .= $retornoPedidoAlterado->mensagem . "\n";
            }

            $rh = $model->inserirHistorico(INSERIR, $pedido->usuario->codigo, TABELA_PEDIDOS, $pedido->pvnumero, date('c'));
            $log .= $rh->mensagem . "\n";
        }

        if ($retornoPedido->retorno || !count($logItensErro)) {
            $retornoFinalizar = $model->alterarSituacaoPedido(true, $pedido->pvnumero);
            $log .= $retornoFinalizar->mensagem . "\n";

            if ($retornoFinalizar->retorno) {
                if ($pedido->tipoPedido->codigo != ABASTECIMENTO) {
                    if ($pedido->tipoPedido->codigo != DEVOLUCAO) {
                        $modelCliente = new ClienteModel();
                        $retornoUltimaCompra = $modelCliente->setUltimaCompra($pedido->cliente->clicodigo, $pedido->pvemissao);
                        $log .= $retornoUltimaCompra->mensagem . "\n";
                    }
                }

                if ($pedido->tipoPedido->codigo == ABASTECIMENTO OR $pedido->tipoPedido->codigo == ALMOXERIFADO OR $pedido->tipoPedido->codigo == DEVOLUCAO) {
                    $modelLibera = new PedidoModel();
                    $retornoLiberacao = $modelLibera->liberaPedidoAbastecimento($pedido->pvnumero, $pedido->pvlibdep, $pedido->pvlibvit, $pedido->pvlibmat, $pedido->pvlibfil, $pedido->pvurgente);
                    $log .= $retornoLiberacao->mensagem . "\n";
                }
            }

            $isFinalizar = $retornoFinalizar->retorno;
        } else {
            $isFinalizar = false;
        }

        $retorno->isFinalizado = $isFinalizar;
        $retorno->itensPedidoEmpenho = $itensPedidoEmpenho;

        $retorno->logItensOk = $logItensOk;
        $retorno->logItensErro = $logItensErro;
        $retorno->logItensEp = $logItensEp;

        $retorno->codigo = $pedido->pvnumero;
        $retorno->fecreserva = $fecReserva;
        //gerar arquivo de armazenamento de log
        $retorno->arquivoLog = $this->gerarLog($pedido, $log, "INSERIR");

        return $retorno;
    }

    /**
     * Metodo para regras de negocios da alteracao do pedido no banco.
     * Instancia a classe model para alteracao no banco.
     *
     * @access public
     * @param PedidoVO $pedido Recebe variavel tipada Pedido Value Object.
     * @return object Objeto com dados dados do retorno do banco.
     */
    public function alterar(PedidoVO $pedido, $itensPedido) {
        $model = new PedidoModel();

        $retorno = new stdClass();

        $logItensOk = array();
        $logItensDel = array();
        $logItensErro = array();
        $logItensEp = array();
        $log = "";

        $totalPedido = 0;

        if ($pedido->tipoPedido->codigo == EXTERNO_SP || $pedido->tipoPedido->codigo == EXTERNO_VIX) {
            $tipoPedido = new TipoPedidoVO(EXTERNO, "tipcodigo");
            $record['pvtipoped'] = trim($tipoPedido->sigla);
        }

        $exclusao = $model->exluiPreFechamentoAnterior($pedido->pvnumero);
        $log .= $exclusao->mensagem . "\n";

        if ($exclusao->retorno) {
            foreach ($itensPedido as $keyItem => $item) {
                $itemPedido = new ItemPedidoVO();
                $itemPedido->castItemPedidoVO($item);

                $retornoItem = $model->alterarItem($pedido->pvnumero, $itemPedido);
                $log .= $retornoItem->mensagem . "\n";

                $estoquesItem = $model->getItemEstoques($itemPedido->pvicodigo);
                $isDifEst = false;

                if ($estoquesItem->retorno) {
                    $saldo = 0;
                    $iDifEst = 0;
                    foreach ($estoquesItem->estoques as $value1) {
                        $isDif = true;
                        foreach ($itemPedido->estoques as $value2) {
                            if ($value1->pviecodigo == $value2->pviecodigo) {
                                $isDif = false;
                                $saldo += $value2->pvieqtd;
                            } else {
                                if (count($estoquesItem->estoques) != count($itemPedido->estoques)) {
                                    $isDifEst = true;
                                    $saldo -= $value2->pvieqtd;
                                }
                            }
                        }

                        if ($isDif) {
                            $deleteEstoqueItem = $this->excluirEstoqueItem($pedido, $itemPedido->pvipreco, $value1);
                            $log .= $deleteEstoqueItem->log;

                            if ($deleteEstoqueItem->isRemovido) {
                                $iDifEst ++;
                            }
                        }
                    }

                    $itemPedido->pvisaldo = $saldo;

                    if ($iDifEst) {
                        $isDifEst = true;
                    }
                }

                if ($retornoItem->retorno || $isDifEst) {
                    if ($retornoItem->isNovo) {
                        $itemPedido->pvicodigo = $retornoItem->codigo;
                        $itemPedido->pvidatacadastro = $retornoItem->dataCadastro;

                        $itensPedido[] = $itemPedido;

                        $itemPedido->pvisaldo = 0;
                    } else if ($retornoItem->isSaldo) {
                        $itemPedido->pvisaldo = 0;
                    }

                    $qtdeEmpenho = 0;

                    for ($i = 0; $i < count($itemPedido->estoques); $i++) {
                        $estoqueItem = new ItemEstoqueVO();
                        $estoqueItem->castItemEstoqueVO($itemPedido->estoques[$i]);

                        $retornoEstoqueItem = $model->alterarEstoqueItem($pedido->pvnumero, $itemPedido->pvicodigo, $estoqueItem);
                        if ($retornoEstoqueItem->isNovo || $retornoEstoqueItem->isAlterado) {
                            $log .= $retornoEstoqueItem->mensagem . "\n";

                            if ($retornoEstoqueItem->retorno) {
                                if ($retornoEstoqueItem->isNovo) {
                                    $estoqueItem->pviecodigo = $retornoEstoqueItem->codigo;
                                    $estoqueItem->pviedatacadastro = $retornoEstoqueItem->dataCadastro;
                                }

                                $estoqueAtual = new EstoqueAtualVO();
                                $estoqueAtual->castEstoqueAtualVO($estoqueItem->estoqueAtual);

                                $retornoEstoqueAtual = $model->alterarEstoqueAtual($estoqueItem->pvieqtd, $retornoEstoqueItem->qtde, $estoqueAtual);
                                $log .= $retornoEstoqueAtual->mensagem . "\n";

                                $estoqueItem->pvieqtd = ($retornoEstoqueItem->qtde + $retornoEstoqueAtual->qtdeRetirada) - $retornoEstoqueAtual->qtdeReposicao;
                                $itemPedido->pvisaldo += $estoqueItem->pvieqtd;

                                if ($retornoEstoqueAtual->qtdeEmpenho && !$retornoEstoqueAtual->isReposicao) {
                                    if ($pedido->tipoPedido->codigo != RESERVA) {
                                        if (!$retornoEstoqueAtual->qtdeTotal && $retornoEstoqueItem->isNovo) {
                                            $retornoExcluirEstoque = $model->excluirEstoqueItem($estoqueItem->pviecodigo);
                                            $log .= $retornoExcluirEstoque->mensagem . "\n";

                                            if ($retornoExcluirEstoque->isRemovido) {
                                                unset($itemPedido->estoques[$i]);
                                            }
                                        }
                                    } else {
                                        $qtdeEmpenho += $retornoEstoqueAtual->qtdeEmpenho;

                                        $retornoGetEstoqueAtualP = $model->getEstoqueAtual(PENDENTES, $itemPedido->produto->procodigo);
                                        $log .= $retornoGetEstoqueAtualP->mensagem . "\n";

                                        $estoquePendente = new ItemEstoqueVO();
                                        $estoquePendente->pvieqtd = $qtdeEmpenho;
                                        $estoquePendente->estoqueAtual = $retornoGetEstoqueAtualP->estoqueAtual;
                                        $estoquePendente->pviedatacadastro = date('c');
                                        $estoquePendente->pviesituacao = true;

                                        $itemPedido->estoques[] = $estoquePendente;
                                    }
                                }

                                $itemPedido->estoques[$i] = $estoqueItem;

                                if ($retornoEstoqueAtual->retorno) {
                                    $movEstoque = new MovEstoqueVO();
                                    $movEstoque->movcodigo = 0;
                                    $movEstoque->pvnumero = $pedido->pvnumero;
                                    $movEstoque->produto = $itemPedido->produto;
                                    $movEstoque->movvalor = $itemPedido->pvipreco;
                                    $movEstoque->estoque = $estoqueAtual->estoque;

                                    if ($retornoEstoqueItem->isAlterado) {
                                        $movEstoque->movtipo = 3;
                                        $movEstoque->movqtd = $retornoEstoqueItem->qtde;
                                        $movEstoque->movdata = date('c');

                                        $retornoMovEstoque = $model->inserirMovEstoque($movEstoque);
                                        $log .= $retornoMovEstoque->mensagem . "\n";

                                        if (!$retornoMovEstoque->retorno) {
                                            $logItensErro[] = "[COD.M3] " . $itemPedido->produto->procod . " " . $itemPedido->produto->prnome . " QTDE: " . $itemPedido->pvisaldo;
                                        }
                                    }

                                    $movEstoque->movqtd = $estoqueItem->pvieqtd;
                                    $movEstoque->movtipo = 2;
                                    $movEstoque->movdata = date('c');

                                    $retornoMovEstoque = $model->inserirMovEstoque($movEstoque);
                                    $log .= $retornoMovEstoque->mensagem . "\n";

                                    if ($retornoMovEstoque->retorno) {
                                        if ($pedido->tipoPedido->codigo == ABASTECIMENTO) {
                                            $retornoDestino = $model->getEstoqueDestino($pedido->estoqueOrigem->etqcodigo, $pedido->estoqueDestino->etqcodigo);
                                            $log .= $retornoDestino->mensagem . "\n";

                                            $retornoGetEstoqueAtual = $model->getEstoqueAtual($retornoDestino->estoqueOrigemDestino->estoqueTemporario->etqcodigo, $itemPedido->produto->procodigo);
                                            $log .= $retornoGetEstoqueAtual->mensagem . "\n";

                                            if ($retornoGetEstoqueAtual->retorno) {
                                                $retornoEstoqueAtualAbastecimento = $model->alterarEstoqueAtual($retornoEstoqueItem->qtde, $estoqueItem->pvieqtd, $retornoGetEstoqueAtual->estoqueAtual);

                                                if ($retornoEstoqueAtualAbastecimento->retorno) {
                                                    $movEstoque->estoque = $retornoDestino->estoqueOrigemDestino->estoqueTemporario;
                                                    if ($retornoEstoqueItem->isAlterado) {
                                                        $movEstoque->movtipo = 2;
                                                        $movEstoque->movqtd = $retornoEstoqueItem->qtde;
                                                        $movEstoque->movdata = date('c');

                                                        $retornoMovEstoque = $model->inserirMovEstoque($movEstoque);
                                                        $log .= $retornoMovEstoque->mensagem . "\n";

                                                        if (!$retornoMovEstoque->retorno) {
                                                            $logItensErro[] = "[COD.M2A] " . $itemPedido->produto->procod . " " . $itemPedido->produto->prnome . " QTDE: " . $itemPedido->pvisaldo;
                                                        }
                                                    }

                                                    $movEstoque->movtipo = 3;
                                                    $movEstoque->movqtd = $estoqueItem->pvieqtd;
                                                    $movEstoque->movdata = date('c');

                                                    $retornoMovEstoque = $model->inserirMovEstoque($movEstoque);
                                                    $log .= $retornoMovEstoque->mensagem . "\n";

                                                    if (!$retornoMovEstoque->retorno) {
                                                        $logItensErro[] = "[COD.M3A] " . $itemPedido->produto->procod . " " . $itemPedido->produto->prnome . " QTDE: " . $itemPedido->pvisaldo;
                                                    }
                                                } else {
                                                    $logItensErro[] = "[COD.EAA] " . $itemPedido->produto->procod . " " . $itemPedido->produto->prnome . " QTDE: " . $itemPedido->pvisaldo;
                                                }
                                            } else {
                                                $logItensErro[] = "[COD.GEA] " . $itemPedido->produto->procod . " " . $itemPedido->produto->prnome . " QTDE: " . $itemPedido->pvisaldo;
                                            }
                                        }
                                    } else {
                                        $logItensErro[] = "[COD.M2] " . $itemPedido->produto->procod . " " . $itemPedido->produto->prnome . " QTDE: " . $itemPedido->pvisaldo;
                                    }

                                    if (!$retornoEstoqueAtual->isRetiradaTotal && !$retornoEstoqueAtual->isReposicao) {
                                        $retornoAtualizaEstoqueItem = $model->alterarEstoqueItem($pedido->pvnumero, $itemPedido->pvicodigo, $estoqueItem);
                                        $log .= $retornoAtualizaEstoqueItem->mensagem . "\n";

                                        if ($pedido->tipoPedido->codigo != RESERVA) {
                                            $retornoAtualizaItem = $model->alterarItem($pedido->pvnumero, $itemPedido);
                                            $log .= $retornoAtualizaItem->mensagem . "\n";

                                            $retornoAtualizaItemAntigo = $model->alterarItemAntigo($pedido->pvnumero, $itemPedido);
                                            $log .= $retornoAtualizaItemAntigo->mensagem . "\n";
                                        }
                                    }
                                } else {
                                    if ($estoqueItem->pvieqtd) {
                                        $retornoAtualizaEstoqueItem = $model->alterarEstoqueItem($pedido->pvnumero, $itemPedido->pvicodigo, $estoqueItem);
                                        $log .= $retornoAtualizaEstoqueItem->mensagem . "\n";

                                        $retornoAtualizaItem = $model->alterarItem($pedido->pvnumero, $itemPedido);
                                        $log .= $retornoAtualizaItem->mensagem . "\n";
                                    }
                                    $logItensErro[] = "[COD.EA] " . $itemPedido->produto->procod . " " . $itemPedido->produto->prnome . " QTDE: " . $itemPedido->pvisaldo;
                                }
                            } else {
                                $logItensErro[] = "[COD.EI] " . $itemPedido->produto->procod . " " . $itemPedido->produto->prnome . " QTDE: " . $itemPedido->pvisaldo;
                            }
                        }
                    }

                    if ($itemPedido->pvisaldo) {
                        $retornoItemAntigo = $model->alterarItemAntigo($pedido->pvnumero, $itemPedido);
                        $log .= $retornoItemAntigo->mensagem . "\n";

                        $itemPedido->pvisaldo = $retornoItemAntigo->saldo;

                        if ($retornoItemAntigo->retorno) {
                            $logItensOk[] = $itemPedido->produto->procod . " " . $itemPedido->produto->prnome . " QTDE: " . $itemPedido->pvisaldo;
                        } else {
                            $logItensErro[] = "[COD.IC] " . $itemPedido->produto->procod . " " . $itemPedido->produto->prnome . " QTDE: " . $itemPedido->pvisaldo;
                        }
                    } else {
                        $retornoExcluirItem = $model->excluirItem($itemPedido->pvicodigo);
                        $log .= $retornoExcluirItem->mensagem . "\n";

                        $retornoExcluirItemAntigo = $model->excluirItemAntigo($itemPedido->pvicodigo);
                        $log .= $retornoExcluirItemAntigo->mensagem . "\n";

                        if ($retornoExcluirItem->retorno) {
                            unset($itensPedido[$keyItem]);
                        }
                    }
                } else {
                    if ($retornoItem->isNovo || $retornoItem->isAlterado) {
                        $logItensErro[] = "[COD.IB] " . $itemPedido->produto->procod . " " . $itemPedido->produto->prnome . " QTDE: " . $itemPedido->pvisaldo;
                    }
                }

                $totalPedido += (float) $itemPedido->pvipreco * (float) $itemPedido->pvisaldo;
            }

            $retornoItemAtuais = $model->getItens($pedido->pvnumero);
            if ($retornoItemAtuais->retorno) {
                foreach ($retornoItemAtuais->itensPedido as $valueDiff) {
                    $isDiff = true;
                    foreach ($itensPedido as $value) {
                        if ($value->pvicodigo == $valueDiff->pvicodigo) {
                            $isDiff = false;
                            continue;
                        }
                    }

                    if ($isDiff) {
                        $itemDiff = new ItemPedidoVO();
                        $itemDiff->castItemPedidoVO($valueDiff);

                        $retornoItemExcluido = $this->excluirItem($pedido, $itemDiff);
                        $log .= $retornoItemExcluido->log;

                        $logItensDel[] = $itemDiff->produto->procod . " " . $itemDiff->produto->prnome . " QTDE: " . $itemDiff->pvisaldo . " VALOR: " . $itemDiff->pvipreco;
                    }
                }
            }
        } else {
            $logItensErro[] = "[COD.EF] " . $itemPedido->produto->procod . " " . $itemPedido->produto->prnome . " QTDE: " . $itemPedido->pvisaldo;
        }

        if ((float) $pedido->pvvalor != (float) $totalPedido) {
            $pedido->pvvalor = $totalPedido;
            $pedido->pvvaldesc = ((float) $pedido->pvperdesc * $totalPedido) / 100;
        }

        $retornoPedido = $model->alterarPedido($pedido);
        $log .= $retornoPedido->mensagem . "\n";

        if ($retornoPedido->retorno || !count($logItensErro)) {
            $retornoFinalizar = $model->alterarSituacaoPedido(true, $pedido->pvnumero);
            $log .= $retornoFinalizar->mensagem . "\n";

            if ($retornoFinalizar->retorno) {
                $rh = $model->inserirHistorico(ALTERAR, $pedido->usuario->codigo, TABELA_PEDIDOS, $pedido->pvnumero, date('c'));
                $log .= $rh->mensagem . "\n";
            }

            $isFinalizar = $retornoFinalizar->retorno;

            if ($pedido->tipoPedido->codigo == ABASTECIMENTO OR $pedido->tipoPedido->codigo == ALMOXERIFADO OR $pedido->tipoPedido->codigo == DEVOLUCAO) {
                $modelLibera = new PedidoModel();
                $retornoLiberacao = $modelLibera->liberaPedidoAbastecimento($pedido->pvnumero, $pedido->pvlibdep, $pedido->pvlibvit, $pedido->pvlibmat, $pedido->pvlibfil, $pedido->pvurgente);
                $log .= $retornoLiberacao->mensagem . "\n";
            }
        } else {
            $isFinalizar = false;
        }

        $retorno->isFinalizado = $isFinalizar;

        $retorno->logItensOk = $logItensOk;
        $retorno->logItensDel = $logItensDel;
        $retorno->logItensErro = $logItensErro;
        $retorno->logItensEp = $logItensEp;

        //gerar arquivo de armazenamento de log
        $retorno->arquivoLog = $this->gerarLog($pedido, $log, "ALTERAR");




        return $retorno;
    }

    /**
     * Metodo para regras de negocios da alteracao do pedido no banco.
     * Instancia a classe model para alteracao no banco.
     *
     * @access public
     * @param PedidoVO $pedido Recebe variavel tipada Pedido Value Object.
     * @return object Objeto com dados dados do retorno do banco.
     */
    public function alterarTravaManutencao($pvnumero, $usucodigo) {
        $model = new PedidoModel();
        return $model->alterarTravaPedido($pvnumero, $usucodigo);
    }

    /**
     * Metodo para regras de negocios da exclusão do pedido no banco.
     * Instancia a classe model para exclusão no banco.
     *
     * @access public
     * @param PedidoVO $valor Recebe variavel tipada pedido Value Object.
     * @param ItemPedidoVO $valor Recebe variavel tipada ItemPedido Value Object.
     * @return object Retorna objeto do tipo json;
     */
    public function excluir($pvnumeroDel, $estoque, $usuarioDel, $movestoque) {
        $model = new PedidoModel();

        $retorno = new stdClass();
        $countErro = 0;
        $log = "";
        $tabelamov = 'movestoque' . substr($movestoque, 5, 2) . substr($movestoque, 2, 2);


        $retornoPedidoA = $model->tabelaEstoque($pvnumeroDel, $tabelamov);
        $log .= $retornoPedidoA->msgt . "\n";

        $retornoPedidoB = $model->excluiBanco($pvnumeroDel, $estoque, $usuarioDel, $tabelamov);
        $log .= $retornoPedidoB->pvitem . "-" . $retornoPedidoB->excluirPvendafinalizado . "-" . $retornoPedidoB->excluirPvendaconfere . "-" . $retornoPedidoB->excluirPvendafinalizadomatriz . "-" . $retornoPedidoB->excluirPvendafinalizadofilial . "\n";

        $retornoPedido = $model->excluirPedido($pvnumeroDel, $estoque, $usuarioDel);
        $log .= $retornoPedido->mensagem . "\n";

        if ($retornoPedido->retorno) {
            $retorno->isFinalizado = true;
            $retornoHistorico = $model->inserirHistorico(EXCLUIR, $usuarioDel, TABELA_PEDIDOS, $pvnumeroDel, date('c'));
            $log .= $retornoHistorico->mensagem . "\n";
        }


        $retorno->codigo = $pvnumeroDel;

        //gerar arquivo de armazenamento de log
        $retorno->arquivoLog = $this->gerarLogDel($pvnumeroDel, $usuarioDel, $log, "EXCLUIR");

        return $retorno;
    }

    /**
     * Metodo para regras de negocios para exclusão de item do pedido.
     * Instancia a classe model para exclusão no banco.
     *
     * @access public
     * @param integer $pvnumero Recebe numero do pedido.
     * @param ItemPedidoVO $itemPedido Recebe variavel tipada Item Pedido Value Object.
     * @return object Retorna objeto com resultados das acoes.
     */
    public function excluirItem(PedidoVO $pedido, ItemPedidoVO $itemPedido) {
        $model = new PedidoModel();

        $retorno = new stdClass();
        $contErro = 0;
        $log = "";

        $produto = new ProdutoVO();
        $produto->castProdutoVO($itemPedido->produto);

        if (count($itemPedido->estoques)) {
            foreach ($itemPedido->estoques as $iestoque) {
                $estoqueItem = new ItemEstoqueVO();
                $estoqueItem->castItemEstoqueVO($iestoque);

                $retornoEstoqueItem = $this->excluirEstoqueItem($pedido, $itemPedido->pvipreco, $estoqueItem);
                $log .= $retornoEstoqueItem->log;

                if (!$retornoEstoqueItem->isRemovido) {
                    $contErro ++;
                }
            }
        }

        $retorno->isRemovido = false;

        if (!$contErro) {
            $retornoItem = $model->alterarSituacaoItem($itemPedido->pvicodigo, false);
            $log .= $retornoItem->mensagem . "\n";

            if ($retornoItem->retorno) {
                $retornoItemCancelado = $model->inserirItemCancelado($pedido->pvnumero, $itemPedido);
                $log .= $retornoItemCancelado->mensagem . "\n";

                if ($retornoItemCancelado->retorno) {
                    $retornoItemAntigo = $model->excluirItemAntigo($itemPedido->pvicodigo);
                    $log .= $retornoItem->mensagem . "\n";

                    if ($retornoItemAntigo->retorno) {
                        $retorno->isRemovido = true;
                    } else {
                        $retornoItem3 = $model->alterarSituacaoItem($itemPedido->pvicodigo, true);
                        $log .= $retornoItem3->mensagem . "\n";
                    }
                } else {
                    $retornoItem2 = $model->alterarSituacaoItem($itemPedido->pvicodigo, true);
                    $log .= $retornoItem2->mensagem . "\n";
                }
            }
        }

        $retorno->log = $log;

        return $retorno;
    }

    /**
     * Metodo para regras de negocios da exclusão de estoque do item.
     * Instancia a classe model para exclusão no banco.
     *
     * @access public
     * @param integer $pviecodigo Codigo do estoque item.
     * @param bool $situacao Situacao do estoque item.
     * @return object Resulta um objeto com 'retorno' e 'mensagem' das acoes.
     */
    public function excluirEstoqueItem(PedidoVO $pedido, $pvipreco, ItemEstoqueVO $estoqueItem) {
        $model = new PedidoModel();
        $retorno = new stdClass();
        $countError = 0;

        $retornoEstoqueItem = $model->alterarSituacaoEstoqueItem($estoqueItem->pviecodigo, false);
        $log = $retornoEstoqueItem->mensagem . "\n";

        if ($retornoEstoqueItem->retorno) {
            $estoqueAtual = new EstoqueAtualVO();
            $estoqueAtual->castEstoqueAtualVO($estoqueItem->estoqueAtual);

            $retornoEstoqueAtual = $model->alterarEstoqueAtual(0, $estoqueItem->pvieqtd, $estoqueAtual);
            $log .= $retornoEstoqueAtual->mensagem . "\n";

            if ($retornoEstoqueAtual->retorno) {
                $produto = new ProdutoVO();
                $produto->castProdutoVO($estoqueAtual->produto);

                $movEstoque = new MovEstoqueVO();
                $movEstoque->movcodigo = 0;
                $movEstoque->pvnumero = $pedido->pvnumero;
                $movEstoque->movdata = date('c');
                $movEstoque->produto = $produto;
                $movEstoque->movvalor = $pvipreco;
                $movEstoque->estoque = $estoqueAtual->estoque;
                $movEstoque->movtipo = 3;
                $movEstoque->movqtd = $estoqueItem->pvieqtd;
                $retornoMovEstoque = $model->inserirMovEstoque($movEstoque);
                $log .= $retornoMovEstoque->mensagem . "\n";

                if ($retornoMovEstoque->retorno) {
                    if ($pedido->tipoPedido->codigo == ABASTECIMENTO) {
                        $retornoDestino = $model->getEstoqueDestino($pedido->estoqueOrigem->etqcodigo, $pedido->estoqueDestino->etqcodigo);
                        $retornoEstoqueAtualAbastecimento = $model->getEstoqueAtual($retornoDestino->estoqueOrigemDestino->estoqueTemporario->etqcodigo, $produto->procodigo);
                        if ($retornoEstoqueAtualAbastecimento->retorno) {
                            $retornoEstoqueAtualAbastecimento = $model->alterarEstoqueAtual($estoqueItem->pvieqtd, 0, $retornoEstoqueAtualAbastecimento->estoqueAtual);
                            $log .= $retornoEstoqueAtualAbastecimento->mensagem . "\n";
                            $movEstoque->movtipo = 2;
                            $movEstoque->estoque = $retornoDestino->estoqueOrigemDestino->estoqueTemporario;
                            $retornoMovEstoqueAbastecimento = $model->inserirMovEstoque($movEstoque);
                            $log .= $retornoMovEstoqueAbastecimento->mensagem . "\n";
                        }
                    }
                } else {
                    $retornoEstoqueAtual2 = $model->alterarEstoqueAtual($estoqueItem->pvieqtd, 0, $estoqueAtual);
                    $log .= $retornoEstoqueAtual2->mensagem . "\n";

                    $retornoEstoqueItem3 = $model->alterarSituacaoEstoqueItem($estoqueItem->pviecodigo, true);
                    $log = $retornoEstoqueItem3->mensagem . "\n";
                }
            } else {
                $retornoEstoqueItem2 = $model->alterarSituacaoEstoqueItem($estoqueItem->pviecodigo, true);
                $log = $retornoEstoqueItem2->mensagem . "\n";
            }
        }

        $retorno->isRemovido = false;
        if ($retornoEstoqueItem->retorno && $retornoEstoqueAtual->retorno && $retornoMovEstoque->retorno) {
            $retorno->isRemovido = true;
        }

        $retorno->log = $log;

        return $retorno;
    }

    /**
     * Metodo para regras de negocios da exclusão de item antigo.
     * Instancia a classe model para exclusão no banco.
     *
     * @access public
     * @param ItemPedidoVO $itemPedido Recebe variavel tipada Item Pedido Value Object.
     * @return object Retorna objeto com resultados das acoes.
     */
    public function excluirItemAntigo($pvicodigo) {
        $model = new PedidoModel();

        $retornoItemAntigo = new stdClass();
        $retornoItemAntigo = $model->excluirItemAntigo($pvicodigo);

        return $retornoItemAntigo;
    }

    /**
     * Metodo para regras de negocios da pesquisa no banco.
     * Instancia a classe model para pesquisar no banco.
     *
     * @access public
     * @param string $tipo Nome do campo para pesquisar.
     * @param string $pesquisa Texto para pesquisa.
     * @return object Retorna objeto do tipo json;
     */
    public function pesquisar($tipoPesquisa, $txtpesquisa, $exata) {
        $model = new PedidoModel();
        return $model->getPedidos($tipoPesquisa, $txtpesquisa, $exata);
    }

    /**
     * Metodo para regras de negocios da pesquisa no banco.
     * Instancia a classe model para pesquisar no banco.
     *
     * @access public
     * @param string $tipo Nome do campo para pesquisar.
     * @param string $pesquisa Texto para pesquisa.
     * @return object Retorna objeto do tipo json;
     */
    public function pesquisar2($tipoPesquisa, $txtpesquisa, $exata) {
        $model = new PedidoModel();
        return $model->pesquisar($tipoPesquisa, $txtpesquisa, $exata);
    }

    public function pesquisarSimples($tipoPesquisa, $txtpesquisa, $exata) {
        $model = new PedidoModel();
        return $model->pesquisarSimples($tipoPesquisa, $txtpesquisa, $exata);
    }

    /**
     * Metodo para gerar texto de retorno pedido.
     *
     * @access public
     * @param array $retorno Array de retorno do apropria estoque.
     * @return string Retorna texto de retorno resumido;
     */
    public function textRetornoPedido($retorno) {
        $txtRetorno = $retorno->mensagem . "\n\n";

        if ($retorno->retornoPedido->retorno) {
            $txtRetorno .= "NUMERO PEDIDO: " . $retorno->retornoPedido->pedido->pvnumero;

            if (isset($retorno->retornoPedido->aItensOk)) {
                $txtRetorno .= "\n\n " . count($retorno->retornoPedido->aItensOk) . " ITENS PROCESSADOS CORRETAMENTE:";

                foreach ($retorno->retornoPedido->aItensOk as $kItem => $vItem) {
                    $qtdeRetirada = 0;
                    foreach ($vItem->aRetornoEstoquesItem as $kEstoque => $vEstoque) {
                        $qtdeRetirada += $vEstoque->retornoEstoqueAtual->qtdeRetirada;
                    }

                    $txtRetorno .= "\n   - " . $vItem->itemPedido->produto->procod . " " . $vItem->itemPedido->produto->prnome . " | TOTAL " . $vItem->itemPedido->pvisaldo . " | Apropriado " . $qtdeRetirada;
                }
            }

            if (isset($retorno->retornoPedido->aItensParcial)) {
                $txtRetorno .= "\n\n " . count($retorno->retornoPedido->aItensParcial) . " ITENS PROCESSADOS PARCIALMENTE:";

                foreach ($retorno->retornoPedido->aItensParcial as $kItem => $vItem) {
                    $qtdeRetirada = 0;
                    foreach ($vItem->aRetornoEstoquesItem as $kEstoque => $vEstoque) {
                        $qtdeRetirada += $vEstoque->retornoEstoqueAtual->qtdeRetirada;
                    }
                    $txtRetorno .= "\n   - " . $vItem->itemPedido->produto->procod . " " . $vItem->itemPedido->produto->prnome . " | TOTAL " . $vItem->itemPedido->pvisaldo . " | APROPRIADO " . $qtdeRetirada;
                }
            }

            if (isset($retorno->retornoPedido->aItensFalha)) {
                $txtRetorno .= "\n\n " . count($retorno->retornoPedido->aItensFalha) . " ITENS NAO PROCESSADOS:";

                foreach ($retorno->retornoPedido->aItensFalha as $kItem => $vItem) {
                    $qtdeRetirada = 0;
                    if (count($vItem->aRetornoEstoquesItem)) {
                        foreach ($vItem->aRetornoEstoquesItem as $kEstoque => $vEstoque) {
                            $qtdeRetirada += $vEstoque->retornoEstoqueAtual->qtdeRetirada;
                        }
                        $txtRetorno .= "\n   - " . $vItem->itemPedido->produto->procod . " " . $vItem->itemPedido->produto->prnome . " | TOTAL " . $vItem->itemPedido->pvisaldo . " | APROPRIADO " . $qtdeRetirada;
                    }
                }
            }
        } else {
            $txtRetorno .= "A FALHA NAO PERMITIU CONCLUIR OPERACAO, CANCELANDO ANDAMENTO DOS PROCESSOS. \n O PEDIDO FOI SALVO AUTOMATICAMENTE EM PEDIDOS TEMPORARIOS!";
        }


        $txtRetorno .= "\n\n " . $retorno->retornoPedidoEmpenho->mensagem;
        if ($retorno->retornoPedidoEmpenho->retorno) {
            $txtRetorno .= "\n  " . count($retorno->retornoPedidoEmpenho->pedido->itensPedido) . " ITENS CRIADOS NO EMPENHO:";
            foreach ($retorno->retornoPedidoEmpenho->pedido->itensPedido as $kItemEmpenho => $vItemEmpenho) {
                $txtRetorno .= "\n   - " . $vItemEmpenho->produto->procod . " " . $vItemEmpenho->produto->prnome . " | TOTAL " . $vItemEmpenho->pvisaldo;
            }
        }
    }

    /**
     * Metodo para gerar texto de retorno pedido.
     *
     * @access public
     * @param array $retorno Array de retorno do apropria estoque.
     * @return string Retorna texto de retorno completo;
     */
    public function textRetornoPedidoDetalhado($retorno) {

        $txtRetorno .= $retorno->mensagem . "\n\n";
        $txtRetorno .= $retorno->retornoPedido->mensagem . "\n";

        if ($retorno->retornoPedido->retorno) {
            $txtRetorno .= "\n * ITENS PROCESSADOS CORRETAMENTE: " . count($retorno->retornoPedido->aItensOk);
            if (count($retorno->retornoPedido->aItensOk)) {

                foreach ($retorno->retornoPedido->aItensOk as $kRetornoItem => $retornoItem) {
                    if ($retornoItem->retorno) {
                        $txtRetorno .= "\n\n   - " . $retornoItem->mensagem;
                        $txtRetorno .= "\n     " . $retornoItem->itemPedido->produto->procod . " " . $retornoItem->itemPedido->produto->prnome . " TOTAL " . $retornoItem->itemPedido->pvisaldo;
                        $txtRetorno .= "\n     ----------------------------------------------------------";
                        foreach ($retornoItem->aRetornoEstoquesItem as $kRetornoEstoqueItem => $retornoEstoqueItem) {
                            $txtRetorno .= "\n      " . $retornoEstoqueItem->mensagem;
                            $txtRetorno .= "\n        - " . $retornoEstoqueItem->estoqueItem->estoqueAtual->estoque->etqcodigo . " " . $retornoEstoqueItem->estoqueItem->estoqueAtual->estoque->etqnome . " QTDE " . $retornoEstoqueItem->estoqueItem->pvieqtd;

                            $retornoEstoqueAtual = $retornoEstoqueItem->retornoEstoqueAtual;
                            $txtRetorno .= "\n        " . $retornoEstoqueAtual->mensagem;

                            $txtRetorno .= "\n        " . $retornoEstoqueAtual->retornoMovEstoque->mensagem;
                        }
                    }
                }
            }

            $txtRetorno .= "\n\n * ITENS PROCESSADOS PARCIALMENTE: " . count($retorno->retornoPedido->aItensParcial);
            if (count($retorno->retornoPedido->aItensParcial)) {
                foreach ($retorno->retornoPedido->aItensParcial as $kRetornoItem => $retornoItem) {
                    $txtRetorno .= "\n\n   - " . $retornoItem->mensagem;
                    $txtRetorno .= "\n     " . $retornoItem->itemPedido->produto->procod . " " . $retornoItem->itemPedido->produto->prnome . " TOTAL " . $retornoItem->itemPedido->pvisaldo;
                    $txtRetorno .= "\n     ----------------------------------------------------------";
                    foreach ($retornoItem->aRetornoEstoquesItem as $kRetornoEstoqueItem => $retornoEstoqueItem) {
                        $txtRetorno .= "\n      " . $retornoEstoqueItem->mensagem;

                        if ($retornoEstoqueItem->retorno) {
                            $txtRetorno .= "\n        - " . $retornoEstoqueItem->estoqueItem->pviecodigo . " " . $retornoEstoqueItem->estoqueItem->estoqueAtual->estoque->etqnome . " QTDE " . $retornoEstoqueItem->estoqueItem->pvieqtd;
                            $retornoEstoqueAtual = $retornoEstoqueItem->retornoEstoqueAtual;

                            $txtRetorno .= "\n        " . $retornoEstoqueAtual->mensagem;
                            $txtRetorno .= "\n        " . $retornoEstoqueAtual->retornoMovEstoque->mensagem;
                        }
                    }
                }
            }

            $txtRetorno .= "\n\n * ITENS NAO PROCESSADOS: " . count($retorno->retornoPedido->aItensFalha);
            if (count($retorno->retornoPedido->aItensFalha)) {
                foreach ($retorno->retornoPedido->aItensFalha as $kRetornoItem => $retornoItem) {
                    $txtRetorno .= "\n\n   - " . $retornoItem->mensagem;
                    $txtRetorno .= "\n     " . $retornoItem->itemPedido->produto->procod . " " . $retornoItem->itemPedido->produto->prnome . " TOTAL " . $retornoItem->itemPedido->pvisaldo;
                    $txtRetorno .= "\n      ESTOQUES DE ITEM";

                    foreach ($retornoItem->itemPedido->estoques as $kEstoqueItem => $estoqueItem) {
                        $txtRetorno .= "\n       - " . $estoqueItem->estoqueAtual->estoque->etqcodigo . " " . $estoqueItem->estoqueAtual->estoque->etqnome . " QTDE " . $estoqueItem->pvieqtd;
                    }
                }
            }
        } else {
            $txtRetorno .= "\nA FALHA NAO PERMITIU CONCLUIR OPERACAO, CANCELANDO ANDAMENTO DOS PROCESSOS. \n O PEDIDO FOI SALVO AUTOMATICAMENTE EM PEDIDOS TEMPORARIOS!";
        }

        if ($retorno->retornoPedidoEmpenho->retorno) {
            $txtRetorno .= "\n\n * ITENS DO PEDIDO EMPENHO: " . count($retorno->retornoPedidoEmpenho->pedido->itensPedido);
            if (count($retorno->retornoPedidoEmpenho->pedido->itensPedido)) {
                foreach ($retorno->retornoPedidoEmpenho->pedido->itensPedido as $kItem => $vItem) {
                    $txtRetorno .= "\n\n     " . $vItem->produto->procod . " " . $vItem->produto->prnome . " TOTAL " . $vItem->pvisaldo;
                    foreach ($vItem->estoques as $kEstoqueItem => $vEstoqueItem) {
                        $txtRetorno .= "\n        - " . $vEstoqueItem->estoqueAtual->estoque->etqcodigo . " " . $vEstoqueItem->estoqueAtual->estoque->etqnome . " QTDE " . $vEstoqueItem->pvieqtd;
                    }
                }
            }
        }



        return $txtRetorno;
    }

    public function itemFormaPagamento($itemFormaPagamento, $pedidoLibera, $usuarioPrefechamento) {
        $model = new PedidoModel();
        $preFechamento = new ItemFormaPagamentoVO();

        $pedido = new PedidoVO();
        $pedido->pvnumero = $pedidoLibera->pvnumero;
        $pedido->pvlibdep = $pedidoLibera->pvlibdep;
        $pedido->pvlibvit = $pedidoLibera->pvlibvit;
        $pedido->pvlibmat = $pedidoLibera->pvlibmat;
        $pedido->pvlibfil = $pedidoLibera->pvlibfil;
        $local = $model->liberacaoPedido2($pedido);

        //$excluiAnterior = $model->exluiPreFechamentoAnterior($itemFormaPagamento->pvnumero);

        if ($itemFormaPagamento->formaPagamento->pagcodigo == '100' || $itemFormaPagamento->formaPagamento->pagcodigo == '106' || $itemFormaPagamento->formaPagamento->pagcodigo == '111' || $itemFormaPagamento->formaPagamento->pagcodigo == '112') {
            $preFechamento->fecforma = $itemFormaPagamento->formaPagamento->pagcodigo;
            $preFechamento->fecdata = $itemFormaPagamento->data;
            $preFechamento->fecvecto = $itemFormaPagamento->data;
            $preFechamento->pvnumero = $itemFormaPagamento->pvnumero;
            $preFechamento->vencodigo = $itemFormaPagamento->vencodigo;
            $preFechamento->clicodigo = $itemFormaPagamento->clicodigo;
            $preFechamento->fectipo = $itemFormaPagamento->fectipo;
            $preFechamento->fecvalor = $itemFormaPagamento->ordemPagamento->valor;
            $preFechamento->fecdia = $itemFormaPagamento->ordemPagamento->diasVencimento;
            $preFechamento->feccaixa = $itemFormaPagamento->caixa;
            $preFechamento->fecempresa = $itemFormaPagamento->fecempresa;
            $preFechamento->valorst = $itemFormaPagamento->valorst;
            $preFechamento->usu_criacao = $usuarioPrefechamento->usuario;
            $aPreFechamento[] = $model->preFechamento($preFechamento);
        }

        if ($itemFormaPagamento->formaPagamento->pagcodigo == '101') {


//                        for ($i=0; $i<$itemFormaPagamento->condicaoComercial->parcela; $i++)
            for ($i = 0; $i < sizeof($itemFormaPagamento->duplicatas); $i++) {
                $preFechamento->fecforma = $itemFormaPagamento->formaPagamento->pagcodigo;
                $preFechamento->fecdata = $itemFormaPagamento->data;
                $preFechamento->pvnumero = $itemFormaPagamento->pvnumero;
                $preFechamento->vencodigo = $itemFormaPagamento->vencodigo;
                $preFechamento->clicodigo = $itemFormaPagamento->clicodigo;
                $preFechamento->fecbanco = $itemFormaPagamento->duplicatas[$i]->fecbanco;
                $preFechamento->fectipo = $itemFormaPagamento->fectipo;
                $preFechamento->fecvecto = $itemFormaPagamento->duplicatas[$i]->dataVencimento;
                $preFechamento->fecdia = $itemFormaPagamento->duplicatas[$i]->diasVencimento;
                $preFechamento->fecdocto = $itemFormaPagamento->duplicatas[$i]->numeroDocumento;
                $preFechamento->fecvalor = $itemFormaPagamento->duplicatas[$i]->valorParcela;
                $preFechamento->feccaixa = $itemFormaPagamento->caixa;
                $preFechamento->fecempresa = $itemFormaPagamento->fecempresa;
                $preFechamento->valorst = $itemFormaPagamento->valorst;
                $preFechamento->usu_criacao = $usuarioPrefechamento->usuario;


                if ($usuarioPrefechamento->senha != '') {
                    $preFechamento->usu_edicao_salto = $usuarioPrefechamento->usuario;
                }

                $aPreFechamento[] = $model->preFechamento($preFechamento);
            }
        }

        if ($itemFormaPagamento->formaPagamento->pagcodigo == '102') {
//   				for ($i=0; $i<$itemFormaPagamento->condicaoComercial->parcela; $i++)
            for ($i = 0; $i < sizeof($itemFormaPagamento->cartao); $i++) {
                $preFechamento->fecforma = $itemFormaPagamento->formaPagamento->pagcodigo;
                $preFechamento->fecdata = $itemFormaPagamento->data;
                $preFechamento->pvnumero = $itemFormaPagamento->pvnumero;
                $preFechamento->vencodigo = $itemFormaPagamento->vencodigo;
                $preFechamento->clicodigo = $itemFormaPagamento->clicodigo;
                $preFechamento->fectipo = $itemFormaPagamento->fectipo;
                $preFechamento->fecdocto = substr($itemFormaPagamento->cartao[$i]->numeroDocumento, 0, 12);
                $preFechamento->fecvecto = $itemFormaPagamento->cartao[$i]->dataVencimento;
                $preFechamento->fecdia = $itemFormaPagamento->cartao[$i]->diasVencimento;
                $preFechamento->fecvalor = $itemFormaPagamento->cartao[$i]->valorParcela;
                $preFechamento->feccartao = $itemFormaPagamento->cartao[$i]->feccartao;
                $prefechamento->fecempresa = $itemFormaPagamento->fecempresa;
                $preFechamento->feccaixa = $itemFormaPagamento->caixa;
                $preFechamento->valorst = $itemFormaPagamento->valorst;
                $preFechamento->usu_criacao = $usuarioPrefechamento->usuario;
                $aPreFechamento[] = $model->preFechamento($preFechamento);
            }
        }

        if ($itemFormaPagamento->formaPagamento->pagcodigo == '103' || $itemFormaPagamento->formaPagamento->pagcodigo == '110') {
//   				for ($i=0; $i<$itemFormaPagamento->condicaoComercial->parcela; $i++)
            for ($i = 0; $i < sizeof($itemFormaPagamento->chequesPre); $i++) {
                $preFechamento->fecforma = $itemFormaPagamento->formaPagamento->pagcodigo;
                $preFechamento->fecdata = $itemFormaPagamento->data;
                $preFechamento->pvnumero = $itemFormaPagamento->pvnumero;
                $preFechamento->vencodigo = $itemFormaPagamento->vencodigo;
                $preFechamento->clicodigo = $itemFormaPagamento->clicodigo;
                $preFechamento->fectipo = $itemFormaPagamento->fectipo;
                $preFechamento->fecbanco = $itemFormaPagamento->chequesPre[$i]->banco;
                $preFechamento->fecconta = $itemFormaPagamento->chequesPre[$i]->conta;
                $preFechamento->fecagencia = $itemFormaPagamento->chequesPre[$i]->agencia;
                $preFechamento->fecvecto = $itemFormaPagamento->chequesPre[$i]->dataVencimento;
                $preFechamento->fecdia = $itemFormaPagamento->chequesPre[$i]->diasVencimento;
                $preFechamento->fecdocto = $itemFormaPagamento->chequesPre[$i]->numeroDocumento;
                $preFechamento->fecvalor = $itemFormaPagamento->chequesPre[$i]->valorParcela;
                $preFechamento->feccaixa = $itemFormaPagamento->caixa;
                $preFechamento->fecempresa = $itemFormaPagamento->fecempresa;
                $preFechamento->valorst = $itemFormaPagamento->valorst;
                $preFechamento->usu_criacao = $usuarioPrefechamento->usuario;
                $aPreFechamento[] = $model->preFechamento($preFechamento);
            }
        }
        if ($itemFormaPagamento->formaPagamento->pagcodigo == '104') {
            $preFechamento->fecforma = $itemFormaPagamento->formaPagamento->pagcodigo;
            $preFechamento->fecdata = $itemFormaPagamento->data;
            $preFechamento->pvnumero = $itemFormaPagamento->pvnumero;
            $preFechamento->vencodigo = $itemFormaPagamento->vencodigo;
            $preFechamento->clicodigo = $itemFormaPagamento->clicodigo;
            $preFechamento->fectipo = $itemFormaPagamento->fectipo;
            $preFechamento->fecvalor = $itemFormaPagamento->ordemPagamento->valor;
            $preFechamento->fecdia = $itemFormaPagamento->ordemPagamento->diasVencimento;
            $preFechamento->fecdocto = strtoupper(substr($itemFormaPagamento->ordemPagamento->numeroDocumento, 0, 12));
            $preFechamento->fecvecto = $itemFormaPagamento->ordemPagamento->vencimento;
            $preFechamento->feccaixa = $itemFormaPagamento->caixa;
            $preFechamento->fecempresa = $itemFormaPagamento->fecempresa;
            $preFechamento->valorst = $itemFormaPagamento->valorst;
            $preFechamento->usu_criacao = $usuarioPrefechamento->usuario;
            $aPreFechamento[] = $model->preFechamento($preFechamento);
        }
        if ($itemFormaPagamento->formaPagamento->pagcodigo == '105') {
            for ($i = 0; $i < count($itemFormaPagamento->vale); $i++) {
                $preFechamento->fecforma = $itemFormaPagamento->formaPagamento->pagcodigo;
                $preFechamento->fecdata = $itemFormaPagamento->data;
                $preFechamento->pvnumero = $itemFormaPagamento->pvnumero;
                $preFechamento->vencodigo = $itemFormaPagamento->vencodigo;
                $preFechamento->clicodigo = $itemFormaPagamento->clicodigo;
                $preFechamento->fectipo = $itemFormaPagamento->fectipo;
                $preFechamento->fecvalor = $itemFormaPagamento->vale[$i]->valor;
                $preFechamento->fecdocto = $itemFormaPagamento->vale[$i]->vale;
                $preFechamento->feccaixa = $itemFormaPagamento->caixa;
                $preFechamento->fecempresa = $itemFormaPagamento->fecempresa;
                $preFechamento->fecvecto = $itemFormaPagamento->vale[$i]->dataVencimento;
                $preFechamento->fecdia = $itemFormaPagamento->vale[$i]->diasVencimento;

                $preFechamento->valorst = $itemFormaPagamento->valorst;
                $preFechamento->usu_criacao = $usuarioPrefechamento->usuario;
                $aPreFechamento[] = $model->preFechamento($preFechamento);
            }
        }

//   	if($itemFormaPagamento->formaPagamento->pagcodigo=='106')
//   			{
//   			for ($i=0; $i<$itemFormaPagamento->condicaoComercial->parcela; $i++)
//   			{
//   			$preFechamento->fecforma = $itemFormaPagamento->mista[$i]->fecforma;
//   			$preFechamento->fecdata = date("Y-m-d H:i:s");
//   			$preFechamento->pvnumero = $itemFormaPagamento->pvnumero;
//   			$preFechamento->vencodigo = $itemFormaPagamento->vencodigo;
//   			$preFechamento->clicodigo = $itemFormaPagamento->clicodigo;
//   			$preFechamento->fectipo = $itemFormaPagamento->fectipo;
//   			$preFechamento->fecvecto = $itemFormaPagamento->mista[$i]->dataVencimento;
//   			$preFechamento->fecdia = $itemFormaPagamento->mista[$i]->diasVencimento;
//   			$preFechamento->fecdocto = substr($itemFormaPagamento->mista[$i]->numeroDocumento, 0,12);
//   			$preFechamento->fecvalor = $itemFormaPagamento->mista[$i]->valorParcela;
//   			$preFechamento->fecbanco = $itemFormaPagamento->mista[$i]->banco;
//			$preFechamento->fecagencia = $itemFormaPagamento->mista[$i]->agencia;
//			$preFechamento->fecconta = $itemFormaPagamento->mista[$i]->conta;
//			$preFechamento->feccartao = $itemFormaPagamento->mista[$i]->feccartao;
//   			$preFechamento->feccaixa = $itemFormaPagamento->caixa;
//   			$preFechamento->fecempresa = $itemFormaPagamento->fecempresa;
//   			$preFechamento->valorst = $itemFormaPagamento->valorst;
//   			$aPreFechamento[] = $model->preFechamento($preFechamento);
//   			}
//   			}




        $pedParcela = new ItemFormaPagamentoVO();
        $pedParcela->pvnumero = $itemFormaPagamento->pvnumero;
        $pedParcela->parcelas = $itemFormaPagamento->condicaoComercial->parcela;
        $pedParcela->tipoparcelas = $itemFormaPagamento->tipoVencimento;

        if ($itemFormaPagamento->formaPagamento->pagcodigo == '100' || $itemFormaPagamento->formaPagamento->pagcodigo == '106' || $itemFormaPagamento->formaPagamento->pagcodigo == '111' || $itemFormaPagamento->formaPagamento->pagcodigo == '112') {
            $pedParcela->parcela1 = $itemFormaPagamento->valor;
            $pedParcela->parcdia1 = $itemFormaPagamento->diasVencimento;
            $pedParcela->parcdata1 = $itemFormaPagamento->ordemPagamento->vencimento;
        } elseif ($itemFormaPagamento->formaPagamento->pagcodigo == '101') {

            $pedParcela->parcdata1 = $itemFormaPagamento->duplicatas[0]->dataVencimento;
            $pedParcela->parcdia1 = $itemFormaPagamento->duplicatas[0]->diasVencimento;
            $pedParcela->parcela1 = $itemFormaPagamento->duplicatas[0]->valorParcela;

            $pedParcela->parcdata2 = $itemFormaPagamento->duplicatas[1]->dataVencimento;
            $pedParcela->parcdia2 = $itemFormaPagamento->duplicatas[1]->diasVencimento;
            $pedParcela->parcela2 = $itemFormaPagamento->duplicatas[1]->valorParcela;

            $pedParcela->parcdata3 = $itemFormaPagamento->duplicatas[2]->dataVencimento;
            $pedParcela->parcdia3 = $itemFormaPagamento->duplicatas[2]->diasVencimento;
            $pedParcela->parcela3 = $itemFormaPagamento->duplicatas[2]->valorParcela;

            $pedParcela->parcdata4 = $itemFormaPagamento->duplicatas[3]->dataVencimento;
            $pedParcela->parcdia4 = $itemFormaPagamento->duplicatas[3]->diasVencimento;
            $pedParcela->parcela4 = $itemFormaPagamento->duplicatas[3]->valorParcela;

            $pedParcela->parcdata5 = $itemFormaPagamento->duplicatas[4]->dataVencimento;
            $pedParcela->parcdia5 = $itemFormaPagamento->duplicatas[4]->diasVencimento;
            $pedParcela->parcela5 = $itemFormaPagamento->duplicatas[4]->valorParcela;

            $pedParcela->parcdata6 = $itemFormaPagamento->duplicatas[5]->dataVencimento;
            $pedParcela->parcdia6 = $itemFormaPagamento->duplicatas[5]->diasVencimento;
            $pedParcela->parcela6 = $itemFormaPagamento->duplicatas[5]->valorParcela;

            $pedParcela->parcdata7 = $itemFormaPagamento->duplicatas[6]->dataVencimento;
            $pedParcela->parcdia7 = $itemFormaPagamento->duplicatas[6]->diasVencimento;
            $pedParcela->parcela7 = $itemFormaPagamento->duplicatas[6]->valorParcela;

            $pedParcela->parcdata8 = $itemFormaPagamento->duplicatas[7]->dataVencimento;
            $pedParcela->parcdia8 = $itemFormaPagamento->duplicatas[7]->diasVencimento;
            $pedParcela->parcela8 = $itemFormaPagamento->duplicatas[7]->valorParcela;

            $pedParcela->parcdata9 = $itemFormaPagamento->duplicatas[8]->dataVencimento;
            $pedParcela->parcdia9 = $itemFormaPagamento->duplicatas[8]->diasVencimento;
            $pedParcela->parcela9 = $itemFormaPagamento->duplicatas[8]->valorParcela;

            $pedParcela->parcdata10 = $itemFormaPagamento->duplicatas[9]->dataVencimento;
            $pedParcela->parcdia10 = $itemFormaPagamento->duplicatas[9]->diasVencimento;
            $pedParcela->parcela10 = $itemFormaPagamento->duplicatas[9]->valorParcela;

            $pedParcela->parcdata11 = $itemFormaPagamento->duplicatas[10]->dataVencimento;
            $pedParcela->parcdia11 = $itemFormaPagamento->duplicatas[10]->diasVencimento;
            $pedParcela->parcela11 = $itemFormaPagamento->duplicatas[10]->valorParcela;

            $pedParcela->parcdata12 = $itemFormaPagamento->duplicatas[11]->dataVencimento;
            $pedParcela->parcdia12 = $itemFormaPagamento->duplicatas[11]->diasVencimento;
            $pedParcela->parcela12 = $itemFormaPagamento->duplicatas[11]->valorParcela;
        } elseif ($itemFormaPagamento->formaPagamento->pagcodigo == '102') {

            $pedParcela->parcdata1 = $itemFormaPagamento->cartao[0]->dataVencimento;
            $pedParcela->parcdia1 = $itemFormaPagamento->cartao[0]->diasVencimento;
            $pedParcela->parcela1 = $itemFormaPagamento->cartao[0]->valorParcela;

            $pedParcela->parcdata2 = $itemFormaPagamento->cartao[1]->dataVencimento;
            $pedParcela->parcdia2 = $itemFormaPagamento->cartao[1]->diasVencimento;
            $pedParcela->parcela2 = $itemFormaPagamento->cartao[1]->valorParcela;

            $pedParcela->parcdata3 = $itemFormaPagamento->cartao[2]->dataVencimento;
            $pedParcela->parcdia3 = $itemFormaPagamento->cartao[2]->diasVencimento;
            $pedParcela->parcela3 = $itemFormaPagamento->cartao[2]->valorParcela;

            $pedParcela->parcdata4 = $itemFormaPagamento->cartao[3]->dataVencimento;
            $pedParcela->parcdia4 = $itemFormaPagamento->cartao[3]->diasVencimento;
            $pedParcela->parcela4 = $itemFormaPagamento->cartao[3]->valorParcela;

            $pedParcela->parcdata5 = $itemFormaPagamento->cartao[4]->dataVencimento;
            $pedParcela->parcdia5 = $itemFormaPagamento->cartao[4]->diasVencimento;
            $pedParcela->parcela5 = $itemFormaPagamento->cartao[4]->valorParcela;

            $pedParcela->parcdata6 = $itemFormaPagamento->cartao[5]->dataVencimento;
            $pedParcela->parcdia6 = $itemFormaPagamento->cartao[5]->diasVencimento;
            $pedParcela->parcela6 = $itemFormaPagamento->cartao[5]->valorParcela;

            $pedParcela->parcdata7 = $itemFormaPagamento->cartao[6]->dataVencimento;
            $pedParcela->parcdia7 = $itemFormaPagamento->cartao[6]->diasVencimento;
            $pedParcela->parcela7 = $itemFormaPagamento->cartao[6]->valorParcela;

            $pedParcela->parcdata8 = $itemFormaPagamento->cartao[7]->dataVencimento;
            $pedParcela->parcdia8 = $itemFormaPagamento->cartao[7]->diasVencimento;
            $pedParcela->parcela8 = $itemFormaPagamento->cartao[7]->valorParcela;

            $pedParcela->parcdata9 = $itemFormaPagamento->cartao[8]->dataVencimento;
            $pedParcela->parcdia9 = $itemFormaPagamento->cartao[8]->diasVencimento;
            $pedParcela->parcela9 = $itemFormaPagamento->cartao[8]->valorParcela;

            $pedParcela->parcdata10 = $itemFormaPagamento->cartao[9]->dataVencimento;
            $pedParcela->parcdia10 = $itemFormaPagamento->cartao[9]->diasVencimento;
            $pedParcela->parcela10 = $itemFormaPagamento->cartao[9]->valorParcela;

            $pedParcela->parcdata11 = $itemFormaPagamento->cartao[10]->dataVencimento;
            $pedParcela->parcdia11 = $itemFormaPagamento->cartao[10]->diasVencimento;
            $pedParcela->parcela11 = $itemFormaPagamento->cartao[10]->valorParcela;

            $pedParcela->parcdata12 = $itemFormaPagamento->cartao[11]->dataVencimento;
            $pedParcela->parcdia12 = $itemFormaPagamento->cartao[11]->diasVencimento;
            $pedParcela->parcela12 = $itemFormaPagamento->cartao[11]->valorParcela;
        } elseif ($itemFormaPagamento->formaPagamento->pagcodigo == '103') {

            $pedParcela->parcdata1 = $itemFormaPagamento->chequesPre[0]->dataVencimento;
            $pedParcela->parcdia1 = $itemFormaPagamento->chequesPre[0]->diasVencimento;
            $pedParcela->parcela1 = $itemFormaPagamento->chequesPre[0]->valorParcela;

            $pedParcela->parcdata2 = $itemFormaPagamento->chequesPre[1]->dataVencimento;
            $pedParcela->parcdia2 = $itemFormaPagamento->chequesPre[1]->diasVencimento;
            $pedParcela->parcela2 = $itemFormaPagamento->chequesPre[1]->valorParcela;

            $pedParcela->parcdata3 = $itemFormaPagamento->chequesPre[2]->dataVencimento;
            $pedParcela->parcdia3 = $itemFormaPagamento->chequesPre[2]->diasVencimento;
            $pedParcela->parcela3 = $itemFormaPagamento->chequesPre[2]->valorParcela;

            $pedParcela->parcdata4 = $itemFormaPagamento->chequesPre[3]->dataVencimento;
            $pedParcela->parcdia4 = $itemFormaPagamento->chequesPre[3]->diasVencimento;
            $pedParcela->parcela4 = $itemFormaPagamento->chequesPre[3]->valorParcela;

            $pedParcela->parcdata5 = $itemFormaPagamento->chequesPre[4]->dataVencimento;
            $pedParcela->parcdia5 = $itemFormaPagamento->chequesPre[4]->diasVencimento;
            $pedParcela->parcela5 = $itemFormaPagamento->chequesPre[4]->valorParcela;

            $pedParcela->parcdata6 = $itemFormaPagamento->chequesPre[5]->dataVencimento;
            $pedParcela->parcdia6 = $itemFormaPagamento->chequesPre[5]->diasVencimento;
            $pedParcela->parcela6 = $itemFormaPagamento->chequesPre[5]->valorParcela;

            $pedParcela->parcdata7 = $itemFormaPagamento->chequesPre[6]->dataVencimento;
            $pedParcela->parcdia7 = $itemFormaPagamento->chequesPre[6]->diasVencimento;
            $pedParcela->parcela7 = $itemFormaPagamento->chequesPre[6]->valorParcela;

            $pedParcela->parcdata8 = $itemFormaPagamento->chequesPre[7]->dataVencimento;
            $pedParcela->parcdia8 = $itemFormaPagamento->chequesPre[7]->diasVencimento;
            $pedParcela->parcela8 = $itemFormaPagamento->chequesPre[7]->valorParcela;

            $pedParcela->parcdata9 = $itemFormaPagamento->chequesPre[8]->dataVencimento;
            $pedParcela->parcdia9 = $itemFormaPagamento->chequesPre[8]->diasVencimento;
            $pedParcela->parcela9 = $itemFormaPagamento->chequesPre[8]->valorParcela;

            $pedParcela->parcdata10 = $itemFormaPagamento->chequesPre[9]->dataVencimento;
            $pedParcela->parcdia10 = $itemFormaPagamento->chequesPre[9]->diasVencimento;
            $pedParcela->parcela10 = $itemFormaPagamento->chequesPre[9]->valorParcela;

            $pedParcela->parcdata11 = $itemFormaPagamento->chequesPre[10]->dataVencimento;
            $pedParcela->parcdia11 = $itemFormaPagamento->chequesPre[10]->diasVencimento;
            $pedParcela->parcela11 = $itemFormaPagamento->chequesPre[10]->valorParcela;

            $pedParcela->parcdata12 = $itemFormaPagamento->chequesPre[11]->dataVencimento;
            $pedParcela->parcdia12 = $itemFormaPagamento->chequesPre[11]->diasVencimento;
            $pedParcela->parcela12 = $itemFormaPagamento->chequesPre[11]->valorParcela;
        } elseif ($itemFormaPagamento->formaPagamento->pagcodigo == '104') {
            $pedParcela->parcela1 = $itemFormaPagamento->ordemPagamento->valor;
            $pedParcela->parcdia1 = $itemFormaPagamento->ordemPagamento->dias;
            $pedParcela->parcdata1 = $itemFormaPagamento->ordemPagamento->vencimento;
        } elseif ($itemFormaPagamento->formaPagamento->pagcodigo == '105') {

            for ($i = 0; $i < count($itemFormaPagamento->vale); $i++) {
                $pedParcela->parcela1 += $itemFormaPagamento->vale[$i]->valor;
            }
            $pedParcela->tipoparcelas = $itemFormaPagamento->vale;
            $pedParcela->parcdia1 = $itemFormaPagamento->vale->dias;
            $pedParcela->parcdata1 = $itemFormaPagamento->vale->vencimento;
        } elseif ($itemFormaPagamento->formaPagamento->pagcodigo == '106') {

            $pedParcela->parcdata1 = $itemFormaPagamento->mista[0]->dataVencimento;
            $pedParcela->parcdia1 = $itemFormaPagamento->mista[0]->diasVencimento;
            $pedParcela->parcela1 = $itemFormaPagamento->mista[0]->valorParcela;

            $pedParcela->parcdata2 = $itemFormaPagamento->mista[1]->dataVencimento;
            $pedParcela->parcdia2 = $itemFormaPagamento->mista[1]->diasVencimento;
            $pedParcela->parcela2 = $itemFormaPagamento->mista[1]->valorParcela;

            $pedParcela->parcdata3 = $itemFormaPagamento->mista[2]->dataVencimento;
            $pedParcela->parcdia3 = $itemFormaPagamento->mista[2]->diasVencimento;
            $pedParcela->parcela3 = $itemFormaPagamento->mista[2]->valorParcela;

            $pedParcela->parcdata4 = $itemFormaPagamento->mista[3]->dataVencimento;
            $pedParcela->parcdia4 = $itemFormaPagamento->mista[3]->diasVencimento;
            $pedParcela->parcela4 = $itemFormaPagamento->mista[3]->valorParcela;

            $pedParcela->parcdata5 = $itemFormaPagamento->mista[4]->dataVencimento;
            $pedParcela->parcdia5 = $itemFormaPagamento->mista[4]->diasVencimento;
            $pedParcela->parcela5 = $itemFormaPagamento->mista[4]->valorParcela;

            $pedParcela->parcdata6 = $itemFormaPagamento->mista[5]->dataVencimento;
            $pedParcela->parcdia6 = $itemFormaPagamento->mista[5]->diasVencimento;
            $pedParcela->parcela6 = $itemFormaPagamento->mista[5]->valorParcela;

            $pedParcela->parcdata7 = $itemFormaPagamento->mista[6]->dataVencimento;
            $pedParcela->parcdia7 = $itemFormaPagamento->mista[6]->diasVencimento;
            $pedParcela->parcela7 = $itemFormaPagamento->mista[6]->valorParcela;

            $pedParcela->parcdata8 = $itemFormaPagamento->mista[7]->dataVencimento;
            $pedParcela->parcdia8 = $itemFormaPagamento->mista[7]->diasVencimento;
            $pedParcela->parcela8 = $itemFormaPagamento->mista[7]->valorParcela;

            $pedParcela->parcdata9 = $itemFormaPagamento->mista[8]->dataVencimento;
            $pedParcela->parcdia9 = $itemFormaPagamento->mista[8]->diasVencimento;
            $pedParcela->parcela9 = $itemFormaPagamento->mista[8]->valorParcela;

            $pedParcela->parcdata10 = $itemFormaPagamento->mista[9]->dataVencimento;
            $pedParcela->parcdia10 = $itemFormaPagamento->mista[9]->diasVencimento;
            $pedParcela->parcela10 = $itemFormaPagamento->mista[9]->valorParcela;

            $pedParcela->parcdata11 = $itemFormaPagamento->mista[10]->dataVencimento;
            $pedParcela->parcdia11 = $itemFormaPagamento->mista[10]->diasVencimento;
            $pedParcela->parcela11 = $itemFormaPagamento->mista[10]->valorParcela;

            $pedParcela->parcdata12 = $itemFormaPagamento->mista[11]->dataVencimento;
            $pedParcela->parcdia12 = $itemFormaPagamento->mista[11]->diasVencimento;
            $pedParcela->parcela12 = $itemFormaPagamento->mista[11]->valorParcela;
        }
        $retornoPedParcela = $model->pedParcela($pedParcela);
        $retornoVale = $model->todosVales($itemFormaPagamento->clicodigo);
        $retornoPreFechamento = $model->getPreFechamento($itemFormaPagamento->pvnumero);


        $retorno = new stdClass();
        $retorno->retornoPedParcela = $retornoPedParcela;
        $retorno->aPreFechamento = $aPreFechamento;
        //$retorno->aBaixaVale = $aBaixaVale;
        //$retorno->exclusao = $excluiAnterior;
        $retorno->localLiberacao = $local;
        $retorno->vales = $retornoVale;
        $retorno->preFechamentos = $retornoPreFechamento;
        return $retorno;
    }

    public function alteraParcela($itemFormaPagamento, $usuarioPrefechamento) {
        $model = new PedidoModel();
        $preFechamento = new ItemFormaPagamentoVO();

        function converteData($data) {
            if ($data == null OR $data == "" OR $data == 0) {
                return null;
            } else {
                $dt = explode("/", $data);
                $data = $dt[2] . "-" . $dt[1] . "-" . $dt[0];
                $hora = date("H:i:s");
                return $data . " " . $hora;
            }
        }

        $preFechamento->fecforma = $itemFormaPagamento->fecforma;
        $preFechamento->prefeccodigo = $itemFormaPagamento->prefeccodigo;
        $preFechamento->fecdata = converteData(trim($itemFormaPagamento->fecdata));
        $preFechamento->fecvecto = converteData(trim($itemFormaPagamento->fecvecto));
        $preFechamento->fecdocto = substr($itemFormaPagamento->fecdocto, 0, 14);
        $preFechamento->pvnumero = $itemFormaPagamento->pvnumero;
        $preFechamento->vencodigo = $itemFormaPagamento->vencodigo;
        $preFechamento->clicodigo = $itemFormaPagamento->clicodigo;
        $preFechamento->fectipo = $itemFormaPagamento->fectipo;
        $preFechamento->fecvalor = $itemFormaPagamento->fecvalor;
        $preFechamento->fecdia = $itemFormaPagamento->fecdia;
        $preFechamento->feccaixa = $itemFormaPagamento->caixa;
        $preFechamento->fecempresa = $itemFormaPagamento->fecempresa;
        $preFechamento->fecbanco = $itemFormaPagamento->fecbanco;
        $preFechamento->fecagencia = $itemFormaPagamento->fecagencia;
        $preFechamento->feccartao = $itemFormaPagamento->feccartao;
        $preFechamento->fecconta = $itemFormaPagamento->fecconta;

        $preFechamento->usu_edicao = $usuarioPrefechamento->usuario;

        if ($usuarioPrefechamento->senha != '') {
            $preFechamento->usu_edicao_salto = $usuarioPrefechamento->usuario;
        }

        $aPreFechamento = $model->alteraParcelaPreFechamento($preFechamento);

        $retornoVale = $model->todosVales($itemFormaPagamento->clicodigo);
        $retornoPreFechamento = $model->getPreFechamento($itemFormaPagamento->pvnumero);


        $retorno = new stdClass();
        $retorno->aPreFechamento = $aPreFechamento;
        $retorno->vales = $retornoVale;
        $retorno->preFechamentos = $retornoPreFechamento;
        return $retorno;
    }

    public function destravaPedido($pvnumero) {
        $model = new PedidoModel();
        return $model->destravaPedido2($pvnumero);
        //return $model->deletaPreFechamento($pvcondcon, $pvnumero);
    }

    public function destravaSaltoPrefechamento($usuarioPrefechamento, $senhaDigitada) {

        $senha2 = md5($senhaDigitada);

        if ($usuarioPrefechamento->senha != $senha2) {
            $retorno = new stdClass();
            $retorno->mensagem = "SENHA INCORRETA.";
            return $retorno;
        }

        $retorno = new stdClass();
        $retorno->mensagem = "SENHA OK.";
        return $retorno;
    }

    public function alteraCondicoesComerciais($pvcondcon, $pvnumero) {
        $model = new PedidoModel();
        return $model->alteraCondicao($pvcondcon, $pvnumero);
        //return $model->deletaPreFechamento($pvcondcon, $pvnumero);
    }

    /**
     * Metodo para pedidos com situacao do pedido f.
     * Pedidos incluidos ou alterados que apresentaram falhas
     * sao armazenados em arquivos tmp.
     *
     * @access public
     * @param PedidoVO $pedido variavel tipada com o pedido localizado.
     * @return string Retorna o arquivo tmp do pedido com falha para recuperação ou
     * false se nao localizar arquivo.
     */
    public function getPedidoTmp(PedidoVO $pedido) {
        switch ($pedido->tipoPedido->codigo) {
            case ABASTECIMENTO:
                $fileName = "AO" . $pedido->estoqueOrigem->etqcodigo . "AD" . $pedido->estoqueDestino->etqcodigo . "P" . $pedido->pvnumero;
                break;
            case DEVOLUCAO:
                $fileName = "D" . $pedido->fornecedor->forcodigo . "P" . $pedido->pvnumero;
                break;
            default;
                $fileName = "C" . $pedido->cliente->clicodigo . "P" . $pedido->pvnumero;
                break;
        }

        $arquivoTmp = DIR_LOGS . "/pedido/tmp/$fileName.TMP";

        if (file_exists($arquivoTmp)) {
            $retorno = file_get_contents($arquivoTmp);
        } else {
            $retorno = false;
        }

        return $retorno;
    }

    public function alterarStatus($pvnumero, $status, $usucodigo) {
        $model = new PedidoModel();
        return $model->alteraStatus($pvnumero, $status, $usucodigo);
    }

    /**
     * Metodo para pedidos com situacao com falha no pedido.
     * Pedidos incluidos sao armazenados em arquivos tmp.
     *
     * @access public
     * @param PedidoVO $pedido variavel tipada com o pedido localizado.
     * @return string Retorna o arquivo tmp do pedido com falha para recuperação ou
     * false se nao localizar arquivo.
     */
    public function verificaPedidoTmp(PedidoVO $pedido) {
        if ($pedido->estoqueOrigem->etqcodigo && $pedido->estoqueDestino->etqcodigo) {
            $fileName = "AO" . $pedido->estoqueOrigem->etqcodigo . "AD" . $pedido->estoqueDestino->etqcodigo . "P0";
            $arquivoTmp = DIR_LOGS . "/pedido/tmp/$fileName.TMP";
            if (file_exists($arquivoTmp)) {
                $retornoArquivo = file_get_contents($arquivoTmp);
            } else {
                $retornoArquivo = false;
            }
        } else if ($pedido->fornecedor->forcodigo) {
            $fileName = "D" . $pedido->fornecedor->forcodigo . "P0";
            $arquivoTmp = DIR_LOGS . "/pedido/tmp/$fileName.TMP";
            if (file_exists($arquivoTmp)) {
                $retornoArquivo = file_get_contents($arquivoTmp);
            } else {
                $retornoArquivo = false;
            }
        } else if ($pedido->cliente->clicodigo) {
            $fileName = "C" . $pedido->cliente->clicodigo . "P0";
            $arquivoTmp = DIR_LOGS . "/pedido/tmp/$fileName.TMP";
            if (file_exists($arquivoTmp)) {
                $retornoArquivo = file_get_contents($arquivoTmp);
            } else {
                $retornoArquivo = false;
            }
        } else {
            $retornoArquivo = false;
        }

        $json = new Services_JSON();

        $retorno = new stdClass();
        $retorno->pedido = new PedidoVO();
        $retorno->itensPedido = array();
        $retorno->itensPedidoEmpenho = array();

        if ($retornoArquivo) {
            $retorno->retorno = true;
            $retorno->mensagem = "LOCALIZADO PEDIDO SALVO EM TEMPORIOS, PERDIDO DE FORMA INESPERADA.";

            $r = $json->decode($retornoArquivo);
            $retorno->pedido->castPedidoVO($r->retornoPedido->pedido);
            $retorno->itensPedido = $r->retornoPedido->itensPedido;
            $retorno->itensPedidoEmpenho = $r->retornoPedido->itensPedidoEmpenho;
        } else {
            $retorno->retorno = false;
            $retorno->mensagem = "NENHUM PEDIDO SALVO EM TEMPORARIOS.";
        }

        return $retorno;
    }

    /**
     * Metodo para gerar aquivos salvos em temporarios.
     *
     * @access public
     * @param PedidoVO $pedido variavel tipada com o pedido localizado.
     * @return boolean Retorna resposta true e false para criacao do arquivo;
     */
    public function gerarLog(PedidoVO $pedido, $log, $tipo = NULL) {
        switch ($pedido->tipoPedido->codigo) {
            case ABASTECIMENTO:
                $fileName = "AO" . $pedido->estoqueOrigem->etqcodigo . "AD" . $pedido->estoqueDestino->etqcodigo . "P" . $pedido->pvnumero;
                break;
            case DEVOLUCAO:
                $fileName = "D" . $pedido->fornecedor->forcodigo . "P" . $pedido->pvnumero;
                break;
            default;
                $fileName = "C" . $pedido->cliente->clicodigo . "P" . $pedido->pvnumero;
                break;
        }

        $arquivoLog = DIR_LOGS . "/pedido/$fileName.LOG";
        $arquivoTmp = DIR_LOGS . "/pedido/tmp/$fileName.TMP";

        $retorno = new stdClass();

        $json = new Services_JSON();

        $txt = "\n\n>>LOG $tipo GERADO EM " . date("d/m/Y H:i:s") . " POR " . $pedido->usuario->nome . " (" . $pedido->usuario->login . ")-------------------------------------------------------------------------\n";
        $txt .= $log;

        $isLog = file_put_contents($arquivoLog, $txt, FILE_APPEND) ? true : false;
        $isTmp = file_put_contents($arquivoTmp, $json->encode($pedido)) ? true : false;

        $retorno->isLog = $isLog;
        $retorno->isTmp = $isTmp;

        return $retorno;
    }

    /**
     * Metodo para gerar aquivos salvos em temporarios.
     *
     * @access public
     * @param PedidoVO $pedido variavel tipada com o pedido localizado.
     * @return boolean Retorna resposta true e false para criacao do arquivo;
     */
    public function gerarLogDel($pvnumeroDel, $usuarioDel, $log, $tipo = NULL) {
        $fileName = "E" . $pvnumeroDel;

        $arquivoLog = DIR_LOGS . "/pedido/$fileName.LOG";
        $arquivoTmp = DIR_LOGS . "/pedido/tmp/$fileName.TMP";

        $retorno = new stdClass();

        $json = new Services_JSON();

        $txt = "\n\n>>LOG $tipo GERADO EM " . date("d/m/Y H:i:s") . " POR USUARIO CODIGO: " . $usuarioDel . " -------------------------------------------------------------------------\n";
        $txt .= $log;

        $isLog = file_put_contents($arquivoLog, $txt, FILE_APPEND) ? true : false;
        $isTmp = file_put_contents($arquivoTmp, $pvnumeroDel) ? true : false;

        $retorno->isLog = $isLog;
        $retorno->isTmp = $isTmp;

        return $retorno;
    }

    /**
     * Metodo para gerar aquivos salvos em temporarios.
     *
     * @access public
     * @param PedidoVO $pedido variavel tipada com o pedido localizado.
     * @return boolean Retorna resposta true e false para criacao do arquivo;
     */
    public function gerarPedidoTmp(PedidoVO $pedido, $itensPedido, $itensPedidoEmpenho) {
        switch ($pedido->tipoPedido->codigo) {
            case ABASTECIMENTO:
                $fileName = "AO" . $pedido->estoqueOrigem->etqcodigo . "AD" . $pedido->estoqueDestino->etqcodigo . "P0";
                break;
            case DEVOLUCAO:
                $fileName = "D" . $pedido->fornecedor->forcodigo . "P0";
                break;
            default;
                $fileName = "C" . $pedido->cliente->clicodigo . "P0";
                break;
        }

        $arquivoTmp = DIR_LOGS . "/pedido/tmp/$fileName.TMP";
        $arquivoLog = DIR_LOGS . "/pedido/$fileName.LOG";

        $retorno = new stdClass();

        $retorno->linkPedidoLog = $arquivoLog;
        $retorno->linkPedidoTmp = $arquivoTmp;

        $json = new Services_JSON();

        $retorno->retornoPedido->pedido = $pedido;
        $retorno->retornoPedido->itensPedido = $itensPedido;
        $retorno->retornoPedido->itensPedidoEmpenho = $itensPedidoEmpenho;

        $retorno->tamanho = file_put_contents($arquivoTmp, $json->encode($retorno));
        $retorno->arquivo = $arquivoTmp;

        if ($retorno->tamanho) {
            $retorno->retorno = true;

            $txtRetornoPedidoTmp = "\n\n>>LOG TEMPORARIO GERADO EM " . date("d/m/Y H:i:s") . " POR " . $pedido->usuario->nome . " (" . $pedido->usuario->login . ")-------------------------------------------------------------------------\n";
            $txtRetornoPedidoTmp .= "\n----- RETORNO PEDIDO TEMPORARIO ------------------------------------------------------------------------------------\n\n";
            $txtRetornoPedidoTmp .= "GERADO ARQUIVO TEMPORARIO $fileName \n";

            if (count($itensPedido)) {
                $txtRetornoPedidoTmp .= "\n - ITENS\n";

                foreach ($itensPedido as $key => $value) {
                    $txtRetornoPedidoTmp .= $value->produto->procod . " - " . $value->produto->prnome . " QTDE " . $value->pvisaldo . " PRECO " . $value->pvipreco . "\n";
                }
            }



            if (count($itensPedidoEmpenho)) {
                $txtRetornoPedidoTmp .= "\n - ITENS EMPENHO\n";

                foreach ($itensPedidoEmpenho as $key => $value) {
                    $txtRetornoPedidoTmp .= $value->produto->procod . " - " . $value->produto->prnome . " QTDE " . $value->pvisaldo . " PRECO " . $value->pvipreco . "\n";
                }
            }

            file_put_contents($arquivoLog, $txtRetornoPedidoTmp, FILE_APPEND);
        } else {
            $retorno->retorno = false;
        }

        return $retorno;
    }

    /**
     * Metodo para limpar aquivos salvos em temporarios.
     *
     * @access public
     * @param PedidoVO $pedido variavel tipada com o pedido localizado.
     * @return boolean Retorna resposta true e false para exclusao do arquivo;
     */
    public function limparPedidoTmp(PedidoVO $pedido) {
        switch ($pedido->tipoPedido->codigo) {
            case ABASTECIMENTO:
                $fileName = "AO" . $pedido->estoqueOrigem->etqcodigo . "AD" . $pedido->estoqueDestino->etqcodigo . "P0";
                break;
            case DEVOLUCAO:
                $fileName = "D" . $pedido->fornecedor->forcodigo . "P0";
                break;
            default;
                $fileName = "C" . $pedido->cliente->clicodigo . "P0";
                break;
        }

        $arquivoTmp = DIR_LOGS . "/pedido/tmp/$fileName.TMP";

        if (file_exists($arquivoTmp)) {
            $retorno = unlink($arquivoTmp);
        } else {
            $retorno = false;
        }

        return $retorno;
    }

    /**
     * Metodo para limpar aquivos salvos em temporarios.
     *
     * @access public
     * @param PedidoVO $pedido variavel tipada com o pedido localizado.
     * @return boolean Retorna resposta true e false para exclusao do arquivo;
     */
    public function baixaParcela($fecdocto, $clicodigo, $pvnumero, $prefeccodigo, $fecforma) {
        $model = new PedidoModel();
        $retorno = $model->baixaParcela2($fecdocto, $clicodigo, $pvnumero, $prefeccodigo, $fecforma);
        return $retorno;
    }

}

?>