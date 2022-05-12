<?php

//pega da pasta de istalacao
$arr = explode("/", $_SERVER['REQUEST_URI']);
$root = $arr[1];

//pega as configurações do servidor
require_once($_SERVER['DOCUMENT_ROOT'] . "/$root/include/config.php");
require_once(DIR_ROOT . '/include/classes/Conexao.php');
//require_once(DIR_ROOT.'/include/acertoestoque.php');
//inclui models necessarios
require_once(DIR_ROOT . '/modulos/vendaAtacado/pedidos/manutencao/model/EstoquesItem.php');

//inclui Values Object
require_once(DIR_ROOT . '/vo/PedidoVO.php');
require_once(DIR_ROOT . '/vo/ItemPedidoVO.php');
require_once(DIR_ROOT . '/vo/ClienteVO.php');
require_once(DIR_ROOT . '/vo/TipoPedidoVO.php');
require_once(DIR_ROOT . '/vo/VendedorVO.php');
require_once(DIR_ROOT . '/vo/TransportadoraVO.php');
require_once(DIR_ROOT . '/vo/PalmVO.php');
require_once(DIR_ROOT . '/vo/FornecedorVO.php');
require_once(DIR_ROOT . '/vo/UsuarioVO.php');
require_once(DIR_ROOT . '/vo/UsuariosVO.php');
require_once(DIR_ROOT . '/vo/ItemEstoqueVO.php');
require_once(DIR_ROOT . '/vo/EstoqueAtualVO.php');
require_once(DIR_ROOT . '/vo/EstoqueFisicoVO.php');
require_once(DIR_ROOT . '/vo/EstoqueVO.php');
require_once(DIR_ROOT . '/vo/EstoqueDestinoOrigemVO.php');
require_once(DIR_ROOT . '/vo/ProdutoVO.php');
require_once(DIR_ROOT . '/vo/CidadeVO.php');
require_once(DIR_ROOT . '/vo/ClienteEnderecoFaturamentoVO.php');
require_once(DIR_ROOT . '/vo/ClienteEnderecoCobrancaVO.php');
require_once(DIR_ROOT . '/vo/ClassificacaoFiscalVO.php');
require_once(DIR_ROOT . '/vo/CondicaoComercialVO.php');
require_once(DIR_ROOT . '/vo/GrupoVO.php');
require_once(DIR_ROOT . '/vo/DevolucaoVO.php');
require_once(DIR_ROOT . '/vo/ValeVO.php');
require_once(DIR_ROOT . '/vo/DevolucaoVendaItemVO.php');
require_once(DIR_ROOT . '/vo/ItemFormaPagamentoVO.php');
require_once(DIR_ROOT . '/vo/PreFechamentoVO.php');
require_once(DIR_ROOT . '/vo/PedParcelasVO.php');
require_once(DIR_ROOT . '/vo/CobrancaVO.php');
require_once(DIR_ROOT . '/vo/FechamentoVO.php');
require_once(DIR_ROOT . '/vo/PedidoVendaItemVO.php');
require_once(DIR_ROOT . '/vo/HistoricoVO.php');
require_once(DIR_ROOT . '/vo/LogLiberacaoVO.php');
require_once(DIR_ROOT . '/vo/NotadepVO.php');
require_once(DIR_ROOT . '/vo/NotaguaVO.php');
require_once(DIR_ROOT . '/vo/NotafilVO.php');
require_once(DIR_ROOT . '/vo/NotamatVO.php');
require_once(DIR_ROOT . '/vo/NotavitVO.php');
require_once(DIR_ROOT . '/vo/SacVO.php');
require_once(DIR_ROOT . '/vo/SacItemVO.php');
require_once(DIR_ROOT . '/include/conexao.inc.php');
require_once(DIR_ROOT . '/include/faturamento.php');
require_once(DIR_ROOT . '/include/classes/GeraArquivo.php');
//require_once(DIR_ROOT.'/include/pedexclusao.php');

/**
 * Classe modelo para comunicação com banco de dados.
 *
 * Comunicação e Manutenção da tabela de pedidos.
 * Este arquivo segue os padroes estabelecidos no dTrade.
 *
 * @access public
 * @name Pedido Model
 * @package modulos/vendaAtacado/pedidos/manutencao/model
 * @link modulos/vendaAtacado/pedidos/manutencao/model/PedidoModel.php
 * @version 1.0.0
 * @since Criado 03/12/2009 Modificado 03/12/2009 Modificado 06/02/2010(Douglas - douglas@centroatacadista.com.br)
 * @author wellington <wellington@centroatacadista.com.br>
 * @exemple modulos/vendaAtacado/pedidos/manutencao/model/PedidoModel.php
 */
Class PedidoModel {

    /**
     * Metodo para efetuar inserção do pedido no banco.
     * Executa insert na tabela de pedido ver config.php lista de tabelas.
     *
     * @access public
     * @param PedidoVO $valor Recebe variavel do tipo Pedido Value Object.
     * @return object Retorna objeto com informações da resposta do banco;
     */
    public function inserirPedido(PedidoVO $pedido) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        if (!$pedido->pvnumero) {
            $record['pvemissao'] = $pedido->pvemissao;
            $record['clicodigo'] = $pedido->cliente->clicodigo ? $pedido->cliente->clicodigo : 0;
            $record['forcodigo'] = $pedido->fornecedor->forcodigo ? $pedido->fornecedor->forcodigo : 0;
            $record['vencodigo'] = $pedido->vendedor->vencodigo ? $pedido->vendedor->vencodigo : 0;
            $record['pvvalor'] = $pedido->pvvalor;
            $record['pvvaldesc'] = $pedido->pvvaldesc;
            $record['pvperdesc'] = $pedido->pvperdesc;
            $record['pvtipoped'] = trim($pedido->tipoPedido->sigla);
            $record['tracodigo'] = $pedido->transportadora->tracodigo ? $pedido->transportadora->tracodigo : 0;
            $record['pvcondcon'] = $pedido->condicaoComercial->codigo ? $pedido->condicaoComercial->codigo : 0;
            $record['pvlocal'] = $pedido->pvlocal;
            $record['pvobserva'] = $pedido->pvobserva;
            $record['pvtipofrete'] = $pedido->pvtipofrete;
            $record['pvnewobs'] = $pedido->pvnewobs;
            $record['pvorigem'] = $pedido->estoqueOrigem->etqcodigo;
            $record['pvdestino'] = $pedido->estoqueDestino->etqcodigo;
            $record['pvencer'] = $pedido->pvencer;
            $record['pvencer2'] = $pedido->pvencer;
            $record['tipolocal'] = $pedido->tipolocal;
            $record['pventrega'] = $pedido->pventrega;
            $record['usuario'] = $pedido->usuario->codigo;
            $record['etqfcodigo'] = $pedido->estoqueFisico->etqfcodigo;
            if ($pedido->fecreserva == null) {
                $record['fecreserva'] = '2';
            } else {
                $record['fecreserva'] = $pedido->fecreserva;
            }


            $result = $db->AutoExecute(TABELA_PEDIDOS, $record, 'INSERT');

            $retorno = new stdClass();

            if (!$result) {
                $msg = "[" . date('d.m.Y H:i:s') . "] ERRO: INSERCAO PEDIDO. " . $db->ErrorMsg();
                $retorno->retorno = false;
                $retorno->mensagem = $msg;
            } else {
                $sql = "SELECT * FROM " . TABELA_PEDIDOS . " WHERE pvemissao='$pedido->pvemissao' ";
                switch ($pedido->tipoPedido->codigo) {
                    case ABASTECIMENTO:
                        $sql .= "and pvorigem = " . $pedido->estoqueOrigem->etqcodigo . " and pvdestino = " . $pedido->estoqueDestino->etqcodigo;
                        break;
                    case DEVOLUCAO:
                        $sql .= "and forcodigo = " . $pedido->fornecedor->forcodigo;
                        break;
                    case TIPO_EMPENHO:
                        $sql .= "and pvtipoped = '" . trim($pedido->tipoPedido->sigla) . "'";
                        break;
                    default:
                        $sql .= "and clicodigo = " . $pedido->cliente->clicodigo;
                        break;
                }
                $sql .= " and pvsituacao = false";

                $row = $db->GetRow($sql);

                $retorno->codigo = $row['pvnumero'];
                $retorno->fecreserva = $row['fecreserva'];
                $retorno->retorno = true;

                $verificaMovimentacao = $this->verificaMovimentacao($row['pvnumero']);

                if ($verificaMovimentacao == '1') {
                    $msg = "[" . date('d.m.Y H:i:s') . "] OK: INSERCAO PEDIDO " . $row['pvnumero'] . ".";
                    $retorno->isMovimentacao = true;
                } else {
                    $rec['pvsituacao'] = 'f';
                    $rs = $db->AutoExecute(TABELA_PEDIDOS, $rec, 'UPDATE', 'pvnumero=' . $row['pvnumero']);

                    $msg = "[" . date('d.m.Y H:i:s') . "] ATENCAO [COD.2]: INSERCAO PEDIDO " . $row['pvnumero'] . ".";
                    $retorno->isMovimentacao = false;
                }

                $retorno->mensagem = $msg;
            }
        }

        return $retorno;
    }

    /**
     * Funcao para efetuar insersão do item.
     * Executa insert na tabela pvitembeta.
     *
     * @access public
     * @param ItemPedidoVO $itemPedido Recebe o item do pedido.
     * @return array Retorna array com o retorno da insersão do item.
     */
    public function inserirItem($pvnumero, ItemPedidoVO $itemPedido) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $record['pvnumero'] = $pvnumero;
        $record['pvitem'] = $itemPedido->pvitem;
        $record['procodigo'] = $itemPedido->produto->procodigo;
        $record['pvipreco'] = $itemPedido->pvipreco;
        $record['pvisaldo'] = $itemPedido->pvisaldo;
        $record['pvitippr'] = $itemPedido->pvitippr;
        $record['pvidatacadastro'] = $itemPedido->pvidatacadastro;
        $record['pvisituacao'] = $itemPedido->pvisituacao ? 't' : 'f';

        $result = $db->AutoExecute(TABELA_ITENS_PEDIDO, $record, 'INSERT');

        $retorno = new stdClass();

        if (!$result) {
            $msg = "[" . date('d.m.Y H:i:s') . "] ERRO: INSERCAO ITEM. " . $db->ErrorMsg();

            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        } else {
            $row = $db->GetRow("SELECT * FROM " . TABELA_ITENS_PEDIDO . " WHERE pvnumero='$pvnumero' and procodigo=" . $itemPedido->produto->procodigo . " and pvidatacadastro='$itemPedido->pvidatacadastro'");

            $msg = "[" . date('d.m.Y H:i:s') . "] OK: INSERCAO ITEM " . $row['pvicodigo'] . ".";

            $retorno->retorno = true;
            $retorno->mensagem = $msg;
            $retorno->codigo = $row['pvicodigo'];
        }

        return $retorno;
    }

    /**
     * Funcao para efetuar insersão dos estoques do item retirados.
     * Executa insert na tabela pviestoques.
     *
     * @access public
     * @param PedidoVO $pedido Recebe o pedido ja inserido no banco.
     * @return PedidoVO Retorna objecto tipado com os estoques de itens inseridos.
     */
    public function inserirEstoqueItem($pvnumero, $pvicodigo, ItemEstoqueVO $estoqueItem) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $record['pvnumero'] = $pvnumero;
        $record['pvicodigo'] = $pvicodigo;
        $record['etqatualcodigo'] = $estoqueItem->estoqueAtual->etqatualcodigo;
        $record['pvieqtd'] = $estoqueItem->pvieqtd;
        $record['pviedatacadastro'] = $estoqueItem->pviedatacadastro;
        $record['pviesituacao'] = $estoqueItem->pviesituacao ? 't' : 'f';

        $result = $db->AutoExecute(TABELA_ITENS_PEDIDO_ESTOQUES, $record, 'INSERT');

        $retorno = new stdClass();

        if (!$result) {
            $msg = "[" . date('d.m.Y H:i:s') . "] ERRO: INSERCAO ESTOQUE ITEM. " . $db->ErrorMsg();

            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        } else {
            $row = $db->GetRow("SELECT * FROM " . TABELA_ITENS_PEDIDO_ESTOQUES . " WHERE pvnumero='$pvnumero' and etqatualcodigo=" . $estoqueItem->estoqueAtual->etqatualcodigo . " and pviedatacadastro='$estoqueItem->pviedatacadastro'");

            $msg = "[" . date('d.m.Y H:i:s') . "] OK: INSERCAO ESTOQUE ITEM " . $row['pviecodigo'] . ".";

            $retorno->retorno = true;
            $retorno->mensagem = $msg;
            $retorno->codigo = $row['pviecodigo'];
        }

        return $retorno;
    }

    /**
     * Funcao para efetuar insersão na movimentacao de estoque.
     * Executa insert na tabela movestoqueMMYY.
     * MM e o mes corrente com 2 digitos
     * YY e o ano corrente com 2 digitos
     *
     * @access public
     * @param MovEstoqueVO $movEstoque Recebe a movimentacao.
     * @return MovEstoqueVO Retorna objecto tipado com a movimentacao.
     */
    public function inserirMovEstoque(MovEstoqueVO $movEstoque, $mmyy = NULL) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        if (!$mmyy) {
            $mmyy = date('my');
        }

        $retorno = new stdClass();

        $record['pvnumero'] = $movEstoque->pvnumero;
        $record['movdata'] = $movEstoque->movdata;
        $record['procodigo'] = $movEstoque->produto->procodigo;
        $record['movqtd'] = $movEstoque->movqtd;
        $record['movvalor'] = $movEstoque->movvalor;
        $record['movtipo'] = $movEstoque->movtipo;
        $record['codestoque'] = $movEstoque->estoque->etqcodigo;

        $result = $db->AutoExecute(TABELA_MOVIMENTACAO_ESTOQUE . $mmyy, $record, 'INSERT');

        if (!$result) {
            $msg = "[" . date('d.m.Y H:i:s') . "] ERRO: INSERCAO MOVIMENTACAO TIPO $movEstoque->movtipo. " . $db->ErrorMsg();
            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        } else {
            $row = $db->GetRow("SELECT * FROM " . TABELA_MOVIMENTACAO_ESTOQUE . $mmyy . " WHERE pvnumero=$movEstoque->pvnumero and movdata='$movEstoque->movdata' and procodigo=" . $movEstoque->produto->procodigo . " and codestoque=" . $movEstoque->estoque->etqcodigo);
            $msg = "[" . date('d.m.Y H:i:s') . "] OK: INSERCAO MOVIMENTACAO " . $row['movcodigo'] . " TIPO $movEstoque->movtipo.";

            $retorno->retorno = true;
            $retorno->mensagem = $msg;
        }

        return $retorno;
    }

    /**
     * Funcao para efetuar insersão dos itens.
     * Executa insert na tabela pvitem versão antiga.
     * Devera ser desativada apos a atualização do sitema pra a nova versão.
     *
     * @access public
     * @param PedidoVO $pedido Recebe o pedido ja inserido no banco.
     */
    public function inserirItemAntigo($pvnumero, ItemPedidoVO $itemPedido) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $record['pvicodigo'] = $itemPedido->pvicodigo;
        $record['pvnumero'] = $pvnumero;
        $record['pvitem'] = $itemPedido->pvitem;
        $record['procodigo'] = $itemPedido->produto->procodigo;
        $record['pvipreco'] = $itemPedido->pvipreco;
        $record['pvisaldo'] = $itemPedido->pvisaldo;
        $record['pvitippr'] = $itemPedido->pvitippr;

        for ($i = 1; $i <= 99; $i++) {
            $record["pviest0" . $i] = 0;
        }

        foreach ($itemPedido->estoques as $keyEstoque => $valueEstoque) {
            $record["pviest0" . $valueEstoque->estoqueAtual->estoque->etqcodigo] = $valueEstoque->pvieqtd;
        }

        $result = $db->AutoExecute(TABELA_ITENS_PEDIDO2, $record, 'INSERT');

        $retorno = new stdClass();

        if (!$result) {
            $msg = "[" . date('d.m.Y H:i:s') . "] ERRO: INSERCAO ITEM CONSULTA $itemPedido->pvicodigo. " . $db->ErrorMsg();
            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        } else {
            $msg = "[" . date('d.m.Y H:i:s') . "] OK: INSERCAO ITEM CONSULTA $itemPedido->pvicodigo.";

            $retorno->retorno = true;
            $retorno->mensagem = $msg;
        }

        return $retorno;
    }

    /**
     * Metodo para efetuar inserção do pedido cancelado no banco.
     * Executa insert na tabela de pedido cancelados ver config.php lista de tabelas.
     *
     * @access public
     * @param PedidoVO $valor Recebe variavel do tipo Pedido Value Object.
     * @return object Retorna objeto com informações da resposta do banco;
     */
    public function inserirPedidoCancelado(PedidoVO $pedido) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $_sql = "SELECT * FROM " . TABELA_PEDIDOS_CANCELADOS . " WHERE pvnumcanc = '$pedido->pvnumero'";

        $rs = $db->GetRow($_sql);

        if (!$rs) {
            if ($pedido->pvnumero) {
                $record['pvnumcanc'] = $pedido->pvnumero;
                $record['clicodigo'] = $pedido->cliente->clicodigo ? $pedido->cliente->clicodigo : 0;
                $record['pvtipoped'] = trim($pedido->tipoPedido->sigla);
                $record['vencodigo'] = $pedido->vendedor->vencodigo ? $pedido->vendedor->vencodigo : 0;
                $record['tracodigo'] = $pedido->transportadora->tracodigo ? $pedido->transportadora->tracodigo : 0;
                $record['pvemissao'] = $pedido->pvemissao;
                $record['pvvaldesc'] = $pedido->pvvaldesc;
                $record['pvperdesc'] = $pedido->pvperdesc;
                $record['pvvalor'] = $pedido->pvvalor;
                $record['pvcondcon'] = $pedido->condicaoComercial->codigo ? $pedido->condicaoComercial->codigo : 0;
                $record['pvobserva'] = $pedido->pvobserva;
                $record['pvbaixa'] = $pedido->pvbaixa;
                $record['pvencer'] = $pedido->pvencer;
                $record['pvorigem'] = $pedido->estoqueOrigem->etqcodigo;
                $record['pvdestino'] = $pedido->estoqueDestino->etqcodigo;
                $record['pvvinculo'] = $pedido->pvvinculo;
                $record['pvlibera'] = $pedido->pvlibera;
                $record['pvcancelado'] = date('c');
                $record['pvhora'] = $pedido->pvhora;
                $record['pvimpresso'] = $pedido->pvimpresso;
                $record['pvusulib'] = $pedido->pvusulib;
                $record['palmcodigo'] = $pedido->palm->palmcodigo;
                $record['pvnewobs'] = $pedido->pvnewobs;
                $record['pvlocal'] = $pedido->pvlocal;
                $record['pvtpalt'] = $pedido->pvtpalt;
                $record['pvitens'] = $pedido->pvitem;
                $record['palmcodigo2'] = $pedido->palm2->palmcodigo;
                $record['pvcomissao'] = $pedido->pvcomissao;
                $record['pvcomisa'] = $pedido->pvcomisa;
                $record['pvcomisb'] = $pedido->pvcomisb;
                $record['pvcomistp'] = $pedido->pvcomistp;
                $record['forcodigo'] = $pedido->fornecedor->forcodigo ? $pedido->fornecedor->forcodigo : 0;
                $record['pvtipofrete'] = $pedido->pvtipofrete;
                $record['pventrega'] = $pedido->pventrega;
                $record['pvinternet'] = $pedido->pvinternet;
                $record['pvportal'] = $pedido->pvportal;

                if ($pedido->tipoPedido->codigo == EXTERNO_SP || $pedido->tipoPedido->codigo == EXTERNO_VIX) {
                    $tipoPedido = new TipoPedidoVO(EXTERNO, "tipcodigo");
                    $record['pvtipoped'] = trim($tipoPedido->sigla);
                }

                $result = $db->AutoExecute(TABELA_PEDIDOS_CANCELADOS, $record, 'INSERT');

                $retorno = new stdClass();

                if (!$result) {
                    $msg = "[" . date('d.m.Y H:i:s') . "] ERRO: INSERCAO PEDIDO CANCELADOS $pedido->pvnumero. " . $db->ErrorMsg();
                    $retorno->retorno = false;
                    $retorno->mensagem = $msg;
                } else {
                    $msg = "[" . date('d.m.Y H:i:s') . "] OK: INSERCAO PEDIDO CANCELADOS $pedido->pvnumero. ";
                    $retorno->retorno = true;
                    $retorno->mensagem = $msg;
                }
            }
        } else {
            $msg = "[" . date('d.m.Y H:i:s') . "] ATENCAO: PEDIDO CANCELADO $pedido->pvnumero.";
            $retorno->retorno = true;
            $retorno->mensagem = $msg;
        }

        return $retorno;
    }

    /**
     * Funcao para efetuar insersão dos itens cancelados.
     * Executa insert na tabela pvicance.
     *
     * @access public
     * @param PedidoVO $pedido Recebe o pedido ja inserido no banco.
     */
    public function inserirItemCancelado($pvnumero, ItemPedidoVO $itemPedido) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $record['pvnumero'] = $pvnumero;
        $record['pvitem'] = $itemPedido->pvitem;
        $record['procodigo'] = $itemPedido->produto->procodigo;
        $record['pvipreco'] = $itemPedido->pvipreco;
        $record['pvisaldo'] = $itemPedido->pvisaldo;
        $record['pvicomis'] = $itemPedido->pvicomis ? $itemPedido->pvicomis : 0;
        $record['pvitippr'] = $itemPedido->pvitippr;

        for ($i = 1; $i <= 99; $i++) {
            $record["pviest0" . $i] = 0;
        }

        foreach ($itemPedido->estoques as $keyEstoque => $valueEstoque) {
            $record["pviest0" . $valueEstoque->estoqueAtual->estoque->etqcodigo] = $valueEstoque->pvieqtd;
        }

        $_sql = "SELECT * FROM " . TABELA_ITENS_PEDIDO_CANCELADOS . " WHERE pvnumero='$pvnumero' and procodigo='" . $itemPedido->produto->procodigo . "'";

        $rs = $db->GetRow($_sql);

        if (!$rs) {
            $result = $db->AutoExecute(TABELA_ITENS_PEDIDO_CANCELADOS, $record, 'INSERT');

            $retorno = new stdClass();

            if (!$result) {
                $msg = "[" . date('d.m.Y H:i:s') . "] ERRO: INSERCAO ITEM CANCELADOS $itemPedido->pvicodigo. " . $db->ErrorMsg();

                $retorno->retorno = false;
                $retorno->mensagem = $msg;
            } else {
                $msg = "[" . date('d.m.Y H:i:s') . "] OK: INSERCAO ITEM CANCELADOS $itemPedido->pvicodigo.";

                $retorno->retorno = true;
                $retorno->mensagem = $msg;
            }
        } else {
            $msg = "[" . date('d.m.Y H:i:s') . "] ATENCAO: ITEM CANCELADO $itemPedido->pvicodigo.";

            $retorno->retorno = true;
            $retorno->mensagem = $msg;
        }

        return $retorno;
    }

    /**
     * Metodo para efetuar inserção do pedido no banco.
     * Executa insert na tabela de pedido ver config.php lista de tabelas.
     *
     * @access public
     * @param PedidoVO $valor Recebe variavel do tipo Pedido Value Object.
     * @return object Retorna objeto com informações da resposta do banco;
     */
    public function inserirHistorico($acao, $usuarioDel, $tabela, $codtabela, $dataacao) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $rec['acao'] = $acao;
        $rec['usuario'] = $usuarioDel;
        $rec['tabela'] = $tabela;
        $rec['codtabela'] = $codtabela;
        $rec['dataacao'] = $dataacao;

        $result = $db->AutoExecute(TABELA_HISTORICO, $rec, 'INSERT');

        $retorno = new stdClass();

        switch ($acao) {
            case INSERIR:
                $strAcao = "INSERIR";
                break;
            case PESQUISAR:
                $strAcao = "PESQUISAR";
                break;
            case ALTERAR:
                $strAcao = "ALTERAR";
                break;
            case EXCLUIR:
                $strAcao = "EXCLUIR";
                break;
        }

        if (!$result) {
            $msg = "[" . date('d.m.Y H:i:s') . "] ERRO: HISTORICO $strAcao $tabela. " . $db->ErrorMsg();

            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        } else {
            $msg = "[" . date('d.m.Y H:i:s') . "] OK: HISTORICO $strAcao $tabela $usuarioDel. ";

            $retorno->retorno = true;
            $retorno->mensagem = $msg;
        }

        return $retorno;
    }

    public function alteraFilhotes($parametro) {

        set_time_limit(0);

//RECEBE PARÃMETRO
//$parametro = trim($_GET["parametro"]);
//Fase 1 - Fica em Looping em todos os pedidos Filhote
        $sql = "select * from pvenda where pvvinculo = '$parametro'";

        $sql = pg_query($sql);
        $row = pg_num_rows($sql);

        $contador = 0;
        $valor = 1;

        if ($row) {
            for ($i = 0; $i < $row; $i++) {

                $pvnumero = pg_result($sql, $i, "pvnumero");
                echo '<br>';
                echo ' ' . $pvnumero;

                //Fase 2 - Fica em looping nos itens dos filhotes para atualizar os precos (pvitem)
                $sql2 = "select a.*,b.procod from pvitem a,produto b where a.pvnumero = '$pvnumero' and a.procodigo = b.procodigo";

                $sql2 = pg_query($sql2);
                $row2 = pg_num_rows($sql2);

                if ($row2) {
                    for ($i2 = 0; $i2 < $row2; $i2++) {

                        $procod = pg_result($sql2, $i2, "procod");
                        $procodigo = pg_result($sql2, $i2, "procodigo");
                        $pvipreco = pg_result($sql2, $i2, "pvipreco");


                        //Localiza o preco do item no pedido mãe
                        $sql3 = "select pvipreco from pvitem where pvnumero = '$parametro' and procodigo = '$procodigo'";

                        $sql3 = pg_query($sql3);
                        $row3 = pg_num_rows($sql3);

                        if ($row3) {
                            $pvinovo = pg_result($sql3, $i3, "pvipreco");

                            //Vai atualizar se forem diferentes
                            if ($pvipreco <> $pvinovo) {

                                echo '<br>';
                                echo ' PVITEM';
                                echo '<br>';
                                echo ' ' . $procod;
                                echo '<br>';
                                echo ' ' . $pvipreco;
                                echo '<br>';
                                echo ' ' . $pvinovo;

                                $sql3 = "UPDATE pvitem SET pvipreco=$pvinovo where pvnumero = '$pvnumero' and procodigo = '$procodigo'";
                                pg_query($sql3);
                            }
                        }
                    }
                }


                //Fase 3 - Fica em looping nos itens dos filhotes para atualizar os precos (pvitemBETA)
                $sql2 = "select a.*,b.procod from pvitembeta a,produto b where a.pvnumero = '$pvnumero' and a.procodigo = b.procodigo";

                $sql2 = pg_query($sql2);
                $row2 = pg_num_rows($sql2);

                if ($row2) {
                    for ($i2 = 0; $i2 < $row2; $i2++) {

                        $procod = pg_result($sql2, $i2, "procod");
                        $procodigo = pg_result($sql2, $i2, "procodigo");
                        $pvipreco = pg_result($sql2, $i2, "pvipreco");

                        //Localiza o preco do item no pedido mãe
                        $sql3 = "select pvipreco from pvitem where pvnumero = '$parametro' and procodigo = '$procodigo'";

                        $sql3 = pg_query($sql3);
                        $row3 = pg_num_rows($sql3);

                        if ($row3) {
                            $pvinovo = pg_result($sql3, $i3, "pvipreco");

                            //Vai atualizar se forem diferentes
                            if ($pvipreco <> $pvinovo) {
                                echo '<br>';
                                echo ' PVITEMBETA';
                                echo '<br>';
                                echo ' ' . $procod;
                                echo '<br>';
                                echo ' ' . $pvipreco;
                                echo '<br>';
                                echo ' ' . $pvinovo;

                                $sql3 = "UPDATE pvitembeta SET pvipreco=$pvinovo where pvnumero = '$pvnumero' and procodigo = '$procodigo'";
                                pg_query($sql3);
                            }
                        }
                    }
                }

                //Fase 4 - Recalcula o Total dos Pedidos
                $notvalor = 0;

                $sql1 = "
		SELECT *
			FROM  pvitem a
			WHERE pvnumero = '$pvnumero' and pvisaldo<>0";
                $sql1 = pg_query($sql1);
                $row1 = pg_num_rows($sql1);

                if ($row1) {

                    $j1 = 1;
                    for ($i1 = 0; $i1 < $row1; $i1++) {

                        $pvicodigo = pg_result($sql1, $i1, "pvicodigo");
                        $pvitem = pg_result($sql1, $i1, "pvitem");
                        $procodigo = pg_result($sql1, $i1, "procodigo");
                        $pvipreco = pg_result($sql1, $i1, "pvipreco");
                        $pvisaldo = pg_result($sql1, $i1, "pvisaldo");

                        if (trim($pvicodigo) == "") {
                            $pvicodigo = "0";
                        }
                        if (trim($pvitem) == "") {
                            $pvitem = "0";
                        }
                        if (trim($procodigo) == "") {
                            $procodigo = "0";
                        }
                        if (trim($pvipreco) == "") {
                            $pvipreco = "0";
                        }
                        if (trim($pvisaldo) == "") {
                            $pvisaldo = "0";
                        }

                        $pvipreco = round($pvipreco, 2);

                        $totalitem = ($pvipreco * $pvisaldo);
                        $notvalor = $notvalor + $totalitem;
                    }

                    $sql1 = "SELECT * FROM  pvenda a WHERE pvnumero = '$pvnumero'";

                    $sql1 = pg_query($sql1);
                    $row1 = pg_num_rows($sql1);

                    if ($row1) {

                        $pvperdesc = pg_result($sql1, 0, "pvperdesc");

                        $desconto = 0;
                        if ($pvperdesc <> 0) {
                            $desconto = $notvalor / 100 * $pvperdesc;
                        }

                        $sql3 = "UPDATE PVENDA SET PVVALOR=$notvalor,PVVALDESC=$desconto where pvnumero = '$pvnumero'";
                        pg_query($sql3);
                    }
                }
            }
        }
    }

    /**
     * Metodo para efetuar alteração do pedido no banco.
     * Executa update na tabela pedido ver config.php lista de tabelas.
     *
     * @access public
     * @param PedidoVO $valor Recebe variavel do tipo Pedido Value Object.
     * @return object Retorna objeto com informações da resposta do banco;
     */
    public function alterarPedido(PedidoVO $pedido) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $record['clicodigo'] = $pedido->cliente->clicodigo ? $pedido->cliente->clicodigo : 0;
        $record['forcodigo'] = $pedido->fornecedor->forcodigo ? $pedido->fornecedor->forcodigo : 0;
        $record['vencodigo'] = $pedido->vendedor->vencodigo ? $pedido->vendedor->vencodigo : 0;
        $record['pvvalor'] = $pedido->pvvalor;
        $record['pvvaldesc'] = $pedido->pvvaldesc;
        $record['pvperdesc'] = $pedido->pvperdesc;
        $record['pvtipoped'] = trim($pedido->tipoPedido->sigla);
        $record['tracodigo'] = $pedido->transportadora->tracodigo ? $pedido->transportadora->tracodigo : 0;
        $record['pvcondcon'] = $pedido->condicaoComercial->codigo ? $pedido->condicaoComercial->codigo : 0;
        $record['pvlocal'] = $pedido->pvlocal;
        $record['pvobserva'] = $pedido->pvobserva;
        $record['pvtipofrete'] = $pedido->pvtipofrete;
        $record['pvnewobs'] = $pedido->pvnewobs;
        $record['pvorigem'] = $pedido->estoqueOrigem->etqcodigo;
        $record['pvdestino'] = $pedido->estoqueDestino->etqcodigo;
        $record['pvencer'] = $pedido->pvencer;
        $record['tipolocal'] = $pedido->tipolocal;
        $record['pventrega'] = $pedido->pventrega;
        $record['etqfcodigo'] = $pedido->estoqueFisico->etqfcodigo ? $pedido->estoqueFisico->etqfcodigo : 0;
        $record['fecreserva'] = $pedido->fecreserva;

        $result = $db->AutoExecute(TABELA_PEDIDOS, $record, 'UPDATE', 'pvnumero=' . $pedido->pvnumero);

        $retorno = new stdClass();
        if (!$result) {
            $msg = "[" . date('d.m.Y H:i:s') . "] ERRO: ALTERACAO PEDIDO $pedido->pvnumero. " . $db->ErrorMsg();
            $retorno->mensagem = $msg;
            $retorno->retorno = false;
        } else {
            $msg = "[" . date('d.m.Y H:i:s') . "] OK: ALTERACAO PEDIDO $pedido->pvnumero.";
            if (trim($pedido->tipoPedido->sigla) == 'R') {
                $filhotes = $this->alteraFilhotes($pedido->pvnumero);
            }
            $verificaMovimentacao = $this->verificaMovimentacao($pedido->pvnumero);

            if ($verificaMovimentacao == '1') {
                $flagVerificaPreco = $this->verificaPrecoPedido($pedido->pvnumero);

                if ($flagVerificaPreco == '2') {
                    $listaPreco = $this->listaPrecosDiferentes($pedido->pvnumero);
                    $rec['pvsituacao'] = 'f';
                    $rs = $db->AutoExecute(TABELA_PEDIDOS, $rec, 'UPDATE', 'pvnumero=' . $pedido->pvnumero);
                    $msg = "[" . date('d.m.Y H:i:s') . "] ERRO: 424 $pedido->pvnumero.";
                } else {
                    $msg = "[" . date('d.m.Y H:i:s') . "] OK: ALTERACAO PEDIDO $pedido->pvnumero.";
                    $retorno->retorno = true;
                }
            } else {
                $rec['pvsituacao'] = 'f';
                $rs = $db->AutoExecute(TABELA_PEDIDOS, $rec, 'UPDATE', 'pvnumero=' . $pedido->pvnumero);

                $msg = "[" . date('d.m.Y H:i:s') . "] ATENCAO [COD.2]: INSERCAO PEDIDO " . $pedido->pvnumero . ".";
                $retorno->isMovimentacao = false;
            }


            $retorno->mensagem = $msg;
            $retorno->retorno = true;
        }

        return $retorno;
    }

    /**
     * Funcao para efetuar alteracao do item no pedido.
     * Executa update caso o item ja tenha ou insert 
     * caso nao tenha na tabela pvitembeta.
     *
     * @access public
     * @param ItemPedidoVO $itemPedido Recebe o item do pedido.
     * @return object Retorna object com o retorno da insersão do item.
     */
    public function alterarItem($pvnumero, ItemPedidoVO $itemPedido) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $retorno = new stdClass();

        $record['pvitem'] = $itemPedido->pvitem;
        $record['pvipreco'] = $itemPedido->pvipreco;
        $record['pvisaldo'] = $itemPedido->pvisaldo;
        $record['pvitippr'] = $itemPedido->pvitippr;
        $record['pvisituacao'] = $itemPedido->pvisituacao;

        $row = $db->GetRow("SELECT * FROM " . TABELA_ITENS_PEDIDO . " WHERE pvicodigo=$itemPedido->pvicodigo");
        $retorno->isSaldo = false;
        if ($row) {
            if ($row['pvitem'] != $itemPedido->pvitem || $row['pvipreco'] != $itemPedido->pvipreco ||
                    $row['pvisaldo'] != $itemPedido->pvisaldo || $row['pvitippr'] != $itemPedido->pvitippr ||
                    $row['pvisituacao'] != $itemPedido->pvisituacao) {
                $result = $db->AutoExecute(TABELA_ITENS_PEDIDO, $record, 'UPDATE', 'pvicodigo=' . $itemPedido->pvicodigo);
                $retorno->isAlterado = true;

                if ($row['pvisaldo'] != $itemPedido->pvisaldo) {
                    $retorno->isSaldo = true;
                }
            } else {
                $retorno->isAlterado = false;
            }

            $retorno->isNovo = false;
        } else {
            $itemPedido->pvidatacadastro = date('c');
            $record['pvnumero'] = $pvnumero;
            $record['procodigo'] = $itemPedido->produto->procodigo;
            $record['pvidatacadastro'] = $itemPedido->pvidatacadastro;

            $result = $db->AutoExecute(TABELA_ITENS_PEDIDO, $record, 'INSERT');
            $rowNew = $db->GetRow("SELECT * FROM " . TABELA_ITENS_PEDIDO . " WHERE pvnumero='$pvnumero' and procodigo=" . $itemPedido->produto->procodigo . " and pvidatacadastro='$itemPedido->pvidatacadastro'");

            $retorno->codigo = $rowNew['pvicodigo'];
            $retorno->dataCadastro = $rowNew['pvidatacadastro'];
            $retorno->isNovo = true;
        }

        if (!$result) {
            $retorno->retorno = false;

            if ($retorno->isNovo) {
                $msg = "[" . date('d.m.Y H:i:s') . "] ERRO: ALTERACAO NOVO ITEM $retorno->codigo. " . $db->ErrorMsg();
            } else {
                if ($retorno->isSaldo) {
                    $msg = "[" . date('d.m.Y H:i:s') . "] ERRO: ALTERACAO ITEM $itemPedido->pvicodigo. " . $db->ErrorMsg();
                } else {
                    $msg = "[" . date('d.m.Y H:i:s') . "] ATENCAO: SALDO ITEM $itemPedido->pvicodigo NAO ALTERADO. ";
                    //$retorno->retorno = true;
                }
            }
        } else {
            if ($retorno->isNovo) {
                $msg = "[" . date('d.m.Y H:i:s') . "] OK: ALTERACAO NOVO ITEM $retorno->codigo.";
            } else {
                $msg = "[" . date('d.m.Y H:i:s') . "] OK: ALTERACAO ITEM $itemPedido->pvicodigo.";
            }

            $retorno->retorno = true;
        }
        $retorno->mensagem = $msg;

        return $retorno;
    }

    /**
     * Metodo para efetuar alteração da situacao do pvi.
     *
     * @access public
     * @param integer $pvicodigo Codigo do item.
     * @param bool $situacao Flag para situacao do item.
     * @return object Retorna objeto com 'retorno' e 'mensagem' da operacao.
     */
    public function alterarSituacaoItem($pvicodigo, $situacao) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $retorno = new stdClass();

        $record['pvisituacao'] = $situacao ? 't' : 'f';
        $result = $db->AutoExecute(TABELA_ITENS_PEDIDO, $record, 'UPDATE', 'pvicodigo=' . $pvicodigo);

        $strSituacao = $situacao ? "ATIVADA" : "DESATIVADA";

        if (!$result) {
            $msg = "[" . date('d.m.Y H:i:s') . "] ERRO: FLAG ITEM $pvicodigo. " . $db->ErrorMsg();

            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        } else {
            $msg = "[" . date('d.m.Y H:i:s') . "] OK: $strSituacao FLAG ITEM $pvicodigo.";

            $retorno->retorno = true;
            $retorno->mensagem = $msg;
        }

        return $retorno;
    }

    /**
     * Funcao para efetuar insersão dos estoques do item retirados.
     * Executa insert na tabela pviestoques.
     *
     * @access public
     * @param PedidoVO $pedido Recebe o pedido ja inserido no banco.
     * @return PedidoVO Retorna objecto tipado com os estoques de itens inseridos.
     */
    public function alterarEstoqueItem($pvnumero, $pvicodigo, ItemEstoqueVO $estoqueItem) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $retorno = new stdClass();

        $record['etqatualcodigo'] = $estoqueItem->estoqueAtual->etqatualcodigo;
        $record['pvieqtd'] = $estoqueItem->pvieqtd;
        $record['pviesituacao'] = $estoqueItem->pviesituacao;

        $sql = "SELECT * FROM " . TABELA_ITENS_PEDIDO_ESTOQUES . " WHERE pviecodigo=$estoqueItem->pviecodigo";
        $row = $db->GetRow($sql);

        if ($row) {
            if ($row['pvieqtd'] != $estoqueItem->pvieqtd) {
                $result = $db->AutoExecute(TABELA_ITENS_PEDIDO_ESTOQUES, $record, 'UPDATE', 'pviecodigo=' . $estoqueItem->pviecodigo);
                $retorno->isAlterado = true;
                $retorno->qtde = $row['pvieqtd'];
            } else {
                $retorno->isAlterado = false;
            }

            $retorno->isNovo = false;
        } else {
            $estoqueItem->pviedatacadastro = date('c');

            $record['pvnumero'] = $pvnumero;
            $record['pvicodigo'] = $pvicodigo;
            $record['pviedatacadastro'] = $estoqueItem->pviedatacadastro;

            $result = $db->AutoExecute(TABELA_ITENS_PEDIDO_ESTOQUES, $record, 'INSERT');

            $rowNew = $db->GetRow("SELECT * FROM " . TABELA_ITENS_PEDIDO_ESTOQUES . " WHERE pvnumero='$pvnumero' and etqatualcodigo=" . $estoqueItem->estoqueAtual->etqatualcodigo . " and pviedatacadastro='$estoqueItem->pviedatacadastro'");

            $retorno->isNovo = true;
            $retorno->codigo = $rowNew['pviecodigo'];
            $retorno->dataCadastro = $rowNew['pviedatacadastro'];
        }

        if (!$result) {
            if ($retorno->isNovo) {
                $msg = "[" . date('d.m.Y H:i:s') . "] ERRO: ALTERACAO NOVO ESTOQUE $retorno->codigo. " . $db->ErrorMsg();
            } else {
                $msg = "[" . date('d.m.Y H:i:s') . "] ERRO: ALTERACAO ESTOQUE $estoqueItem->pviecodigo. " . $db->ErrorMsg();
            }

            $retorno->retorno = false;
        } else {
            if ($retorno->isNovo) {
                $msg = "[" . date('d.m.Y H:i:s') . "] OK: ALTERACAO NOVO ESTOQUE $retorno->codigo.";
            } else {
                $msg = "[" . date('d.m.Y H:i:s') . "] OK: ALTERACAO ESTOQUE $estoqueItem->pviecodigo.";
            }

            $retorno->retorno = true;
        }

        $retorno->mensagem = $msg;

        return $retorno;
    }

    /**
     * Metodo para efetuar alteracao da situacao do pvie.
     *
     * @access public
     * @param integer $pviecodigo Codigo do estoque do item.
     * @param bool $situacao Flag para situacao estoque.
     * @return object Retorna objeto com 'retorno' e 'mensagem' da operacao.
     */
    public function alterarSituacaoEstoqueItem($pviecodigo, $situacao) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $retorno = new stdClass();

        $record['pviesituacao'] = $situacao ? 't' : 'f';

        $result = $db->AutoExecute(TABELA_ITENS_PEDIDO_ESTOQUES, $record, 'UPDATE', 'pviecodigo=' . $pviecodigo);

        $strSituacao = $situacao ? "ATIVADA" : "DESATIVADA";

        if (!$result) {
            $msg = "[" . date('d.m.Y H:i:s') . "] ERRO: FLAG ESTOQUE ITEM $pviecodigo." . $db->ErrorMsg();

            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        } else {
            $msg = "[" . date('d.m.Y H:i:s') . "] OK: $strSituacao FLAG ESTOQUE ITEM $pviecodigo.";

            $retorno->retorno = true;
            $retorno->mensagem = $msg;
        }

        return $retorno;
    }

    /**
     * Funcao para efetuar insersão dos estoques do item retirados.
     * Executa insert na tabela pviestoques.
     *
     * @access public
     * @param PedidoVO $pedido Recebe o pedido ja inserido no banco.
     * @return PedidoVO Retorna objecto tipado com os estoques de itens inseridos.
     */
    /* public function alterarEstoqueItem($pvnumero, $pvicodigo, ItemEstoqueVO $estoqueItem)
      {
      $conexao = new Conexao();
      $db = $conexao->connection();

      $retorno = new stdClass();
      $estoqueItemOld = new ItemEstoqueVO();

      $record['pvnumero'] = $pvnumero;
      $record['pvicodigo'] = $pvicodigo;
      $record['etqatualcodigo'] = $estoqueItem->estoqueAtual->etqatualcodigo;
      $record['pvieqtd'] = $estoqueItem->pvieqtd;
      $record['pviedatacadastro'] = $estoqueItem->pviedatacadastro;
      $record['pviesituacao'] = $estoqueItem->pviesituacao;

      $sql = "SELECT * FROM ".TABELA_ITENS_PEDIDO_ESTOQUES." WHERE pviecodigo=$estoqueItem->pviecodigo";
      $row = $db->GetRow($sql);

      if($row)
      {
      $estoqueItemOld->pviecodigo = $row['pviecodigo'];
      $estoqueItemOld->estoqueAtual = new EstoqueAtualVO($row['etqatualcodigo']);
      $estoqueItemOld->pvieqtd = $row['pvieqtd'];
      $estoqueItemOld->pviedatacadastro = $row['pviedatacadastro'];
      $estoqueItemOld->pviesituacao = $row['pviesituacao'];

      if ($estoqueItem->pvieqtd == $row['pvieqtd'])
      {
      $msg = "QUANTIDADE DO ESTOQUE NAO ALTERADO";
      $retorno->isAlterado = false;
      }
      else
      {
      $result = $db->AutoExecute(TABELA_ITENS_PEDIDO_ESTOQUES, $record, 'UPDATE', 'pviecodigo='.$estoqueItem->pviecodigo);
      $retorno->isAlterado = true;
      }

      $retorno->isNovo = false;
      }
      else
      {
      $result = $db->AutoExecute(TABELA_ITENS_PEDIDO_ESTOQUES, $record, 'INSERT');

      $rowNew = $db->GetRow("SELECT * FROM ".TABELA_ITENS_PEDIDO_ESTOQUES." WHERE pvnumero='$pvnumero' and etqatualcodigo=".$estoqueItem->estoqueAtual->etqatualcodigo." and pviedatacadastro='$estoqueItem->pviedatacadastro'");
      $retorno->isAlterado = false;
      $retorno->isNovo = true;
      }

      if ($retorno->isAlterado || $retorno->isNovo)
      {
      if(!$result)
      {
      $msg = "FALHA NA ALTERACAO DO ESTOQUE. \n      ". $db->ErrorMsg();

      $retorno->retorno = false;
      }
      else
      {
      if (!$retorno->estoqueItem->pviecodigo)
      {
      $retorno->estoqueItem->pviecodigo = $rowNew['pviecodigo'];
      }

      $msg = "ESTOQUE ".$retorno->estoqueItem->pviecodigo." ALTERADO. ";

      $retorno->retorno = true;
      }
      }

      $retorno->estoqueItem = $estoqueItem;
      $retorno->estoqueItemOld = $estoqueItemOld;
      $retorno->mensagem = $msg;

      return $retorno;
      } */

    /**
     * Funcao para efetuar alteracao do estoque atual.
     * Executa update na tabela estoqueatual.
     *
     * @access public
     * @param integer $pvieqtd Recebe quantidade do estoque que ser movimentada.
     * @param integer $pvieqtdOdl Recebe quantidade do estoque antiga caso de alteracao.
     * @return object Retorna objecto de retorno da alteracao.
     */
    public function alterarEstoqueAtual($pvieqtd, $pvieqtdOdl, EstoqueAtualVO $estoqueAtual) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $retorno = new stdClass();
        $retorno->isRetiradaTotal = false;
        $retorno->isReposicao = false;

        if ($pvieqtd > $pvieqtdOdl) {
            $row = $db->GetRow("SELECT * FROM " . TABELA_ESTOQUE_ATUAL . " WHERE etqatualcodigo=" . $estoqueAtual->etqatualcodigo);
            $estoqueAtual->estqtd = $row['estqtd'];

            $isPermite = false;

            $retirada = $pvieqtd - $pvieqtdOdl;
            if ((int) $estoqueAtual->estoque->etqcodigo != (int) EMPENHO && (int) $estoqueAtual->estoque->etqcodigo != (int) PENDENTES) {
                if ($pvieqtd > $estoqueAtual->estqtd) {
                    $retirada = $estoqueAtual->estqtd;
                }
            }

            $sql = "UPDATE
						" . TABELA_ESTOQUE_ATUAL . "
					SET
						estqtd = (estqtd - $retirada),
						usucodigo = 0
					WHERE
						etqatualcodigo = " . $estoqueAtual->etqatualcodigo;
        } else {
            $reposicao = $pvieqtdOdl - $pvieqtd;

            $retorno->isReposicao = true;
            $sql = "UPDATE
						" . TABELA_ESTOQUE_ATUAL . "
					SET
						estqtd = (estqtd + $reposicao),
						usucodigo = 0
					WHERE
						etqatualcodigo = " . $estoqueAtual->etqatualcodigo;
        }

        if ($retirada > 0 || $reposicao > 0) {
            $result = $db->Execute($sql);

            if (!$result) {
                $msg = "[" . date('d.m.Y H:i:s') . "] ERRO: ATUALIZACAO ESTOQUE. " . $db->ErrorMsg();

                $retorno->retorno = false;
            } else {
                if ($retirada > 0) {
                    $msg = "[" . date('d.m.Y H:i:s') . "] OK: ESTOQUE APROPRIADO $retirada ";
                    $msg .= "ATUALIZADO DE " . $estoqueAtual->estqtd . " PARA " . ($estoqueAtual->estqtd - $retirada) . ".";
                    $retorno->qtdeTotal = $pvieqtdOdl + $retirada;
                }
                if ($reposicao > 0) {
                    $msg = "[" . date('d.m.Y H:i:s') . "] OK: ESTOQUE REPOSTO $reposicao ";
                    $msg .= "ATUALIZADO DE " . $estoqueAtual->estqtd . " PARA " . ($estoqueAtual->estqtd + $reposicao) . ".";
                    $retorno->qtdeTotal = $pvieqtdOdl - $reposicao;
                }

                $retorno->retorno = true;
            }
        } else {
            $msg = "[" . date('d.m.Y H:i:s') . "] ATENCAO: NAO HA RETIRADA OU REPOSICAO ESTOQUE.";
            $retorno->retorno = false;
        }

        $retorno->qtdeRetirada = $retirada;
        $retorno->qtdeReposicao = $reposicao;
        $retorno->qtdeEmpenho = ($pvieqtd - $pvieqtdOdl) - $retirada;

        if ($retorno->qtdeEmpenho > 0 && !$retorno->isReposicao) {
            $msg .= " QTDE " . $retorno->qtdeEmpenho . " ADICIONADO EMPENHO.";
        } else {
            $retorno->isRetiradaTotal = true;
        }

        $retorno->mensagem = $msg;
        return $retorno;
    }

    /**
     * Funcao para efetuar alteracao do itemAntigo do pedido.
     * Executa update caso o item ja tenha ou insert caso seja novo 
     * caso nao tenha na tabela pvitem.
     *
     * @access public
     * @param ItemPedidoVO $itemPedido Recebe o item do pedido.
     * @return object Retorna object com o retorno da alteracao do item.
     */
    public function alterarItemAntigo($pvnumero, ItemPedidoVO $itemPedido) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $record['pvicodigo'] = $itemPedido->pvicodigo;
        $record['pvnumero'] = $pvnumero;
        $record['pvitem'] = $itemPedido->pvitem;
        $record['procodigo'] = $itemPedido->produto->procodigo;
        $record['pvipreco'] = $itemPedido->pvipreco;
        $record['pvisaldo'] = 0;
        $record['pvitippr'] = $itemPedido->pvitippr;

        for ($i = 1; $i <= 99; $i++) {
            $record["pviest0" . $i] = 0;
        }

        foreach ($itemPedido->estoques as $keyEstoque => $valueEstoque) {
            $record["pviest0" . $valueEstoque->estoqueAtual->estoque->etqcodigo] = $valueEstoque->pvieqtd;

            if ($valueEstoque->pvieqtd) {
                $record['pvisaldo'] += $valueEstoque->pvieqtd;
            }
        }

        $row = $db->GetRow("SELECT * FROM " . TABELA_ITENS_PEDIDO2 . " WHERE pvicodigo=$itemPedido->pvicodigo");

        if ($row) {
            $result = $db->AutoExecute(TABELA_ITENS_PEDIDO2, $record, 'UPDATE', 'pvicodigo=' . $itemPedido->pvicodigo);
            $retorno->isNovo = false;
        } else {
            $result = $db->AutoExecute(TABELA_ITENS_PEDIDO2, $record, 'INSERT');

            $retorno->codigo = $itemPedido->pvicodigo;
            $retorno->isNovo = true;
        }

        $retorno = new stdClass();

        if (!$result) {
            if ($retorno->isNovo) {
                $msg = "[" . date('d.m.Y H:i:s') . "] ERRO: ALTERACAO NOVO ITEM CONSULTA $retorno->codigo." . $db->ErrorMsg();
            } else {
                $msg = "[" . date('d.m.Y H:i:s') . "] ERRO: ALTERACAO ITEM CONSULTA $itemPedido->pvicodigo." . $db->ErrorMsg();
            }
            $retorno->retorno = false;
        } else {
            if ($retorno->isNovo) {
                $msg = "[" . date('d.m.Y H:i:s') . "] OK: ALTERACAO NOVO ITEM CONSULTA $retorno->codigo.";
            } else {
                $msg = "[" . date('d.m.Y H:i:s') . "] OK: ALTERACAO ITEM CONSULTA $itemPedido->pvicodigo.";
            }
            $retorno->retorno = true;
        }
        $retorno->mensagem = $msg;
        $retorno->saldo = $record['pvisaldo'];

        return $retorno;
    }

    /**
     * Funcao para efetuar alteração da situacao do pedido.
     * Executa update na tabela pedido.
     *
     * @access public
     * @param boolean $bool Recebe valor booleano para situação.
     * @param integer $pvnumero Recebe o numero do pedido.
     * @return object Retorna objecto de retorno.
     */
    public function alterarSituacaoPedido($situacao, $pvnumero) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $record['pvsituacao'] = $situacao ? 't' : 'f';

        $result = $db->AutoExecute(TABELA_PEDIDOS, $record, 'UPDATE', 'pvnumero=' . $pvnumero);

        $retorno = new stdClass();

        if ($situacao) {
            $situacao = "FINALIZADO";
        } else {
            $situacao = "EM ABERTO";
        }

        if (!$result) {
            $msg = "[" . date('d.m.Y H:i:s') . "] ERRO: ATUALIZACAO SITUACAO PEDIDO $pvnumero $situacao. " . $db->ErrorMsg();

            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        } else {

            $msg = "[" . date('d.m.Y H:i:s') . "] OK: ATUALIZACAO SITUACAO PEDIDO $pvnumero $situacao.";

            $retorno->retorno = true;
            $retorno->mensagem = $msg;
        }

        return $retorno;
    }

    /**
     * Metodo para travar pedidos.
     *
     * @access public
     * @param int $pvnumero numero do pedido.
     * @param int $pvnumero numero do pedido.
     * @return object Objeto com dados dados do retorno do banco.
     */
    public function alterarTravaPedido($pvnumero, $usucodigo = Null) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $record['usucodigo'] = $usucodigo;

        $result = $db->AutoExecute(TABELA_PEDIDOS, $record, 'UPDATE', 'pvnumero=' . $pvnumero);

        $retorno = new stdClass();

        if (!$result) {
            $msg = "[" . date('d.m.Y H:i:s') . "] ERRO: ATUALIZACAO TRAVA PEDIDO $pvnumero. " . $db->ErrorMsg();

            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        } else {
            if ($usucodigo) {
                $msg = "[" . date('d.m.Y H:i:s') . "] OK: ATUALIZACAO TRAVA PEDIDO $pvnumero USUARIO $usucodigo.";
                $retorno->retorno = true;
                $retorno->mensagem = $msg;
            } else {
                $msg = "[" . date('d.m.Y H:i:s') . "] OK: ATUALIZACAO TRAVA PEDIDO $pvnumero USUARIO TODOS.";
                $retorno->retorno = false;
                $retorno->mensagem = $msg;
            }
        }

        return $retorno;
    }

    /**
     * Metodo para efetuar pesquisa dos pedidos no banco.
     * Executa select na tabela pvenda ver config.php lista de tabelas.
     *
     * @access public
     * @param string $tipo Nome do campo para pesquisar.
     * @param string $pesquisa Texto para pesquisa.
     * @return object Retorna objetos do tipo json;
     */
    public function getPedidos($tipoPesquisa, $txtpesquisa, $exata) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        switch ($exata) {
            case 0:
                $where = "$tipoPesquisa LIKE '$txtpesquisa%'";
                break;

            case 1:
                $where = "$tipoPesquisa LIKE '%$txtpesquisa%'";
                break;

            case 2:
                $where = "$tipoPesquisa = '$txtpesquisa'";
                break;
        }

        $sql = "SELECT * FROM " . TABELA_PEDIDOS . " WHERE $where ORDER BY pvnumero";

        $result = $db->GetAll($sql);

        $retorno = new stdClass();
        $pedidos = array();

        if (!$result) {
            $msg = "[" . date('d.m.Y H:i:s') . "] ATENCAO: NAO FOI POSSIVEL LOCALIZAR PEDIDO TIPO $exata $txtpesquisa. " . $db->ErrorMsg();
            ;
            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        } else {
            $msg = "[" . date('d.m.Y H:i:s') . "] OK: LOCALIZADO(S) " . count($result) . " PEDIDO(S) TIPO $exata $txtpesquisa.";
            $retorno->retorno = true;
            $retorno->mensagem = $msg;

            foreach ($result as $value) {
                $pedido = new PedidoVO();
                $pedido->pvnumero = $value['pvnumero'];
                $pedido->tipoPedido = new TipoPedidoVO($value['pvtipoped']);
                $pedido->pvemissao = $value['pvemissao'];
                $pedido->pvvaldesc = $value['pvvaldesc'];
                $pedido->pvperdesc = $value['pvperdesc'];
                $pedido->pvvalor = $value['pvvalor'];
                $pedido->pvobserva = $value['pvobserva'];
                $pedido->pvbaixa = $value['pvbaixa'];
                $pedido->pvencer = $value['pvencer'];
                $pedido->pvvinculo = $value['pvvinculo'];
                $pedido->pvlibera = $value['pvlibera'];
                $pedido->pvhora = $value['pvhora'];
                $pedido->pvimpresso = $value['pvimpresso'];
                $pedido->pvusulib = $value['pvusulib'];
                $pedido->palm = $value['palmcodigo'];
                $pedido->pvnewobs = $value['pvnewobs'];
                $pedido->pvlocal = $value['pvlocal'];
                $pedido->pvtpalt = $value['pvtpalt'];
                $pedido->pvitem = $value['pvitens'];
                $pedido->palm2 = $value['palmcodigo2'];
                $pedido->pvcomissao = $value['pvcomissao'];
                $pedido->pvcomisa = $value['pvcomisa'];
                $pedido->pvcomisb = $value['pvcomisb'];
                $pedido->pvcomistp = $value['pvcomistp'];
                $pedido->pvtipofrete = $value['pvtipofrete'];
                $pedido->pventrega = $value['pventrega'];
                $pedido->pvinternet = $value['pvinternet'];
                $pedido->pvportal = $value['pvportal'];
                $pedido->pvurgente = $value['pvurgente'];
                $pedido->pvvia = $value['pvvia'];
                $pedido->pvcredito = $value['pvcredito'];
                $pedido->pvbloqueio = $value['pvbloqueio'];
                $pedido->pvfilialb = $value['pvfilialb'];
                $pedido->pvmatrizb = $value['pvmatrizb'];
                $pedido->pvfilial = $value['pvfilial'];
                $pedido->pvmatriz = $value['pvmatriz'];
                $pedido->usuarioCadastroPedido = new UsuarioVO($value['usuario']);
                $pedido->pvlibdep = $value['pvlibdep'];
                $pedido->pvlibmat = $value['pvlibmat'];
                $pedido->pvlibfil = $value['pvlibfil'];
                $pedido->pvlibvit = $value['pvlibvit'];
                $pedido->fecreserva = $value['fecreserva'];
                $pedido->usuario = new UsuarioVO($value['usucodigo']);
                $pedido->estoqueFisico = new EstoqueFisicoVO($value['etqfcdigo']);
                $pedido->pvsituacao = $value['pvsituacao'] == "t" ? true : false;



                switch ($pedido->tipoPedido->codigo) {
                    case DEVOLUCAO:
                        //devolucao
                        $pedido->fornecedor = new FornecedorVO($value['forcodigo']);
                        $pedido->transportadora = new TransportadoraVO($value['tracodigo']);
                        //abastecimento
                        $pedido->estoqueOrigem = new EstoqueVO();
                        $pedido->estoqueDestino = new EstoqueVO();
                        //todos
                        $pedido->cliente = new ClienteVO();
                        $pedido->vendedor = new VendedorVO();
                        $pedido->condicaoComercial = new CondicaoComercialVO();
                        break;
                    case ABASTECIMENTO:
                        //devolucao
                        $pedido->fornecedor = new FornecedorVO();
                        //abastecimento
                        $pedido->estoqueOrigem = new EstoqueVO($value['pvorigem']);
                        $pedido->estoqueDestino = new EstoqueVO($value['pvdestino']);
                        //todos
                        $pedido->cliente = new ClienteVO();
                        $pedido->vendedor = new VendedorVO();
                        $pedido->transportadora = new TransportadoraVO();
                        $pedido->condicaoComercial = new CondicaoComercialVO();
                        break;
                    default:
                        //devolucao
                        $pedido->fornecedor = new FornecedorVO();
                        //abastecimento
                        $pedido->estoqueOrigem = new EstoqueVO();
                        $pedido->estoqueDestino = new EstoqueVO();
                        //todos
                        $pedido->cliente = new ClienteVO($value['clicodigo']);
                        $pedido->vendedor = new VendedorVO($value['vencodigo']);
                        $pedido->transportadora = new TransportadoraVO($value['tracodigo']);
                        $pedido->condicaoComercial = new CondicaoComercialVO($value['pvcondcon']);
                        break;
                }

                $pedidos[] = $pedido;
            }
        }

        $retorno->pedidos = $pedidos;

        return $retorno;
    }

    /**
     * Metodo para efetuar pesquisa dos pedidos no banco.
     * Executa select na tabela pvenda ver config.php lista de tabelas.
     *
     * @access public
     * @param string $tipo Nome do campo para pesquisar.
     * @param string $pesquisa Texto para pesquisa.
     * @return object Retorna objetos do tipo json;
     */
    public function getPedidosFilhos($pvnumero) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $sql = "SELECT * FROM " . TABELA_PEDIDOS . " WHERE pvvinculo = $pvnumero ORDER BY pvnumero";
        $result = $db->GetAll($sql);

        $retorno = new stdClass();
        $pedidos = array();

        if (!$result) {
            $msg = "[" . date('d.m.Y H:i:s') . "] ATENCAO: NAO HA FILHOS O PEDIDO $pvnumero." . $db->ErrorMsg();
            ;
            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        } else {
            $msg = "[" . date('d.m.Y H:i:s') . "] OK: LOCALIZADO(S) " . count($result) . " PEDIDOS FILHOS.";
            $retorno->retorno = true;
            $retorno->mensagem = $msg;

            foreach ($result as $value) {
                $pedido = new PedidoVO();
                $pedido->pvnumero = $value['pvnumero'];
                $pedido->tipoPedido = new TipoPedidoVO($value['pvtipoped']);
                $pedido->pvemissao = $value['pvemissao'];
                $pedido->pvvaldesc = $value['pvvaldesc'];
                $pedido->pvperdesc = $value['pvperdesc'];
                $pedido->pvvalor = $value['pvvalor'];
                $pedido->pvobserva = $value['pvobserva'];
                $pedido->pvbaixa = $value['pvbaixa'];
                $pedido->pvencer = $value['pvencer'];
                $pedido->pvvinculo = $value['pvvinculo'];
                $pedido->pvlibera = $value['pvlibera'];
                $pedido->pvhora = $value['pvhora'];
                $pedido->pvimpresso = $value['pvimpresso'];
                $pedido->pvusulib = $value['pvusulib'];
                $pedido->palm = $value['palmcodigo'];
                $pedido->pvnewobs = $value['pvnewobs'];
                $pedido->pvlocal = $value['pvlocal'];
                $pedido->pvtpalt = $value['pvtpalt'];
                $pedido->pvitem = $value['pvitens'];
                $pedido->palm2 = $value['palmcodigo2'];
                $pedido->pvcomissao = $value['pvcomissao'];
                $pedido->pvcomisa = $value['pvcomisa'];
                $pedido->pvcomisb = $value['pvcomisb'];
                $pedido->pvcomistp = $value['pvcomistp'];
                $pedido->pvtipofrete = $value['pvtipofrete'];
                $pedido->pventrega = $value['pventrega'];
                $pedido->pvinternet = $value['pvinternet'];
                $pedido->pvportal = $value['pvportal'];
                $pedido->pvurgente = $value['pvurgente'];
                $pedido->pvvia = $value['pvvia'];
                $pedido->pvcredito = $value['pvcredito'];
                $pedido->pvbloqueio = $value['pvbloqueio'];
                $pedido->pvfilialb = $value['pvfilialb'];
                $pedido->pvmatrizb = $value['pvmatrizb'];
                $pedido->pvfilial = $value['pvfilial'];
                $pedido->pvmatriz = $value['pvmatriz'];
                $pedido->usuarioCadastroPedido = new UsuarioVO($value['usuario']);
                $pedido->pvlibdep = $value['pvlibdep'];
                $pedido->pvlibmat = $value['pvlibmat'];
                $pedido->pvlibfil = $value['pvlibfil'];
                $pedido->pvlibvit = $value['pvlibvit'];
                $pedido->usuario = new UsuarioVO($value['usucodigo']);
                $pedido->estoqueFisico = new EstoqueFisicoVO($value['etqfcdigo']);
                $pedido->pvsituacao = $value['pvsituacao'] == "t" ? true : false;

                switch ($pedido->tipoPedido->codigo) {
                    case DEVOLUCAO:
                        //devolucao
                        $pedido->fornecedor = new FornecedorVO($value['forcodigo']);
                        $pedido->transportadora = new TransportadoraVO($value['tracodigo']);
                        //abastecimento
                        $pedido->estoqueOrigem = new EstoqueVO();
                        $pedido->estoqueDestino = new EstoqueVO();
                        //todos
                        $pedido->cliente = new ClienteVO();
                        $pedido->vendedor = new VendedorVO();
                        $pedido->condicaoComercial = new CondicaoComercialVO();
                        break;
                    case ABASTECIMENTO:
                        //devolucao
                        $pedido->fornecedor = new FornecedorVO();
                        //abastecimento
                        $pedido->estoqueOrigem = new EstoqueVO($value['pvorigem']);
                        $pedido->estoqueDestino = new EstoqueVO($value['pvdestino']);
                        //todos
                        $pedido->cliente = new ClienteVO();
                        $pedido->vendedor = new VendedorVO();
                        $pedido->transportadora = new TransportadoraVO();
                        $pedido->condicaoComercial = new CondicaoComercialVO();
                        break;
                    default:
                        //devolucao
                        $pedido->fornecedor = new FornecedorVO();
                        //abastecimento
                        $pedido->estoqueOrigem = new EstoqueVO();
                        $pedido->estoqueDestino = new EstoqueVO();
                        //todos
                        $pedido->cliente = new ClienteVO($value['clicodigo']);
                        $pedido->vendedor = new VendedorVO($value['vencodigo']);
                        $pedido->transportadora = new TransportadoraVO($value['tracodigo']);
                        $pedido->condicaoComercial = new CondicaoComercialVO($value['pvcondcon']);
                        break;
                }

                $pedidos[] = $pedido;
            }
        }

        $retorno->pedidos = $pedidos;

        return $retorno;
    }

    /**
     * Metodo para efetuar pesquisa dos estoques Atuais.
     * Executa select na tabela estoque ver config.php lista de tabelas.
     *
     * @access public
     * @param integer pvicodigo lista item pedidos
     * @return object Retorna objetos do tipo json;
     */
    public function getEstoqueFisico($etqfcodigo) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $sql = "SELECT * FROM " . TABELA_ESTOQUE_FISICO . " where etqfcodigo='$etqfcodigo'";

        $result = $db->Execute($sql);

        $retornoEstoqueFisico = new stdClass();
        if (!$result) {
            $msg = "Falha na conexao com banco de dados! " . $db->ErrorMsg();

            $retornoEstoqueFisico->retorno = false;
            $retornoEstoqueFisico->mensagem = $msg;
        }

        while (!$result->EOF) {
            $estoqueFisico = new EstoqueFisicoVO();

            $estoqueFisico->etqfcodigo = $result->fields[0];
            $estoqueFisico->etqfdatacadastro = $result->fields[1];
            $estoqueFisico->etqfnome = $result->fields[2];
            $estoqueFisico->situacao = $result->fields[3];
            $estoqueFisico->etqfsigla = $result->fields[4];


            $estoqueFisicos[$estoqueFisico->etqfcodigo] = $estoqueFisico;

            $result->MoveNext();
        }

        if (count($estoqueFisicos)) {
            $msg = "Estoque(s) Atual localizado(s) com sucesso!(tabela estoque)";
            $retornoEstoqueFisico->retorno = true;
            $retornoEstoqueFisico->mensagem = $msg;
            $retornoEstoqueFisico->estoqueFisicos = $estoqueFisicos;
        } else {
            $msg = "N&atilde;o foi possivel localizar o estoque Atual!(tabela estoque) " . $db->ErrorMsg();
            $retornoEstoqueFisico->retorno = false;
            $retornoEstoqueFisico->mensagem = $msg;
        }

        return $retornoEstoqueFisico;
    }

    /**
     * Metodo para efetuar pesquisa dos estoques Atuais.
     * Executa select na tabela estoque ver config.php lista de tabelas.
     *
     * @access public
     * @param integer pvicodigo lista item pedidos
     * @return object Retorna objetos do tipo json;
     */
    public function getEstoque($codestoque) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $sql = "SELECT * FROM " . TABELA_ESTOQUE . " where etqcodigo='$codestoque'";

        $result = $db->Execute($sql);

        $retornoEstoque = new stdClass();
        if (!$result) {
            $msg = "Falha na conexao com banco de dados! " . $db->ErrorMsg();

            $retornoEstoque->retorno = false;
            $retornoEstoque->mensagem = $msg;
        }
        while (!$result->EOF) {
            $estoque = new EstoqueVO();

            $estoque->etqcodigo = $result->fields[0];
            $estoque->etqnome = $result->fields[1];
            $estoque->usuario = $result->fields[2];
            //$estoque->estoquesfisicos = new EstoqueFisicoVO();
            $estoque->etqfcodigo = $result->fields[3];

            $estoque->etqdatacadastro = $result->fields[4];
            $estoque->situacao = $result->fields[5];

            $retornoEstoqueFisico = $this->getEstoqueFisico($estoque->etqfcodigo);
            $estoque->estoqueFisico = $retornoEstoqueFisico;

            $estoques[$estoque->etqcodigo] = $estoque;

            $result->MoveNext();
        }

        if (count($estoques)) {
            $msg = "Estoque(s) Atual localizado(s) com sucesso!(tabela estoque)";
            $retornoEstoque->retorno = true;
            $retornoEstoque->mensagem = $msg;
            $retornoEstoque->estoques = $estoques;
        } else {
            $msg = $sql . "N&atilde;o foi possivel localizar o estoque Atual!(tabela estoque) " . $db->ErrorMsg();
            $retornoEstoque->retorno = false;
            $retornoEstoque->mensagem = $msg;
        }

        return $retornoEstoque;
    }

    /**
     * Metodo para efetuar pesquisa dos estoques Atuais.
     * Executa select na tabela estoque ver config.php lista de tabelas.
     *
     * @access public
     * @param integer pvicodigo lista item pedidos
     * @return object Retorna objetos do tipo json;
     */
    public function getItensEstoqueAtual($etqatualcodigo) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $sql = "SELECT * FROM " . TABELA_ESTOQUE_ATUAL . " where etqatualcodigo='$etqatualcodigo'";

        $result = $db->Execute($sql);

        $retornoEstoqueAtual = new stdClass();
        if (!$result) {
            $msg = "Falha na conexao com banco de dados! " . $db->ErrorMsg();

            $retornoEstoqueAtual->retorno = false;
            $retornoEstoqueAtual->mensagem = $msg;
        }
        while (!$result->EOF) {
            $estoqueAtual = new EstoqueAtualVO();
            $estoqueAtual->etqatualcodigo = $result->fields[0];

            $estoqueAtual->produto = new ProdutoVO();
            $estoqueAtual->produto->procodigo = $result->fields[1];

            $estoqueAtual->estqtd = $result->fields[2];

            $estoqueAtual->estoque = new EstoqueVO();
            $estoqueAtual->estoque->codestoque = $result->fields[3];

            $retornoEstoque = $this->getEstoque($estoqueAtual->estoque->codestoque);
            $estoqueAtual->itensEstoque = $retornoEstoque;

            $estoqueAtuais[$estoqueAtual->etqatualcodigo] = $estoqueAtual;

            $result->MoveNext();
        }

        if (count($estoqueAtuais)) {
            $msg = "Estoque(s) Atual localizado(s) com sucesso!(tabela estoqueAtual)";
            $retornoEstoqueAtual->retorno = true;
            $retornoEstoqueAtual->mensagem = $msg;
            $retornoEstoqueAtual->estoqueAtuais = $estoqueAtuais;
        } else {
            $msg = "N&atilde;o foi possivel localizar o estoque Atual!(tabela estoqueAtual) " . $db->ErrorMsg();
            $retornoEstoqueAtual->retorno = false;
            $retornoEstoqueAtual->mensagem = $msg;
        }

        return $retornoEstoqueAtual;
    }

    /**
     * Metodo para efetuar pesquisa dos estoques de um item.
     * Executa select na tabela estoque ver config.php lista de tabelas.
     *
     * @access public
     * @param integer pvicodigo lista item pedidos
     * @return object Retorna objetos do tipo json;
     */
    public function getItemEstoques($pvicodigo, $pviesituacao = 't') {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $sql = "SELECT * FROM " . TABELA_ITENS_PEDIDO_ESTOQUES . " where pvicodigo='$pvicodigo' and pviesituacao = '$pviesituacao'";

        $result = $db->GetAll($sql);

        $retorno = new stdClass();

        if (!$result) {
            $msg = "N&atilde;o foi possivel localizar pedido(s)! (tabelaitensPedidoEstoque(pviestoques))" . $db->ErrorMsg();

            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        } else {
            $msg = "Pedido(s) localizado(s) com sucesso!(tabelaitensPedidoEstoque(pviestoques))";
            $retorno->retorno = true;
            $retorno->mensagem = $msg;

            foreach ($result as $value) {
                $itemEstoque = new ItemEstoqueVO();
                $itemEstoque->pviecodigo = $value['pviecodigo'];
                $itemEstoque->estoqueAtual = new EstoqueAtualVO($value['etqatualcodigo']);
                $itemEstoque->pvieqtd = $value['pvieqtd'];
                $itemEstoque->pviedatacadastro = $value['pviedatacadastro'];
                $itemEstoque->pviesituacao = $value['pviesituacao'];

                $estoques[] = $itemEstoque;
            }

            $retorno->estoques = $estoques;
        }

        return $retorno;
    }

    /**
     * Metodo para efetuar pesquisa dos itens de um pedido.
     * Executa select na tabela pvitembeta ver config.php lista de tabelas.
     *
     * @access public
     * @param integer $pvnumero Recebe o numero do Pedido
     * @return object Retorna objetos com retorno da busca;
     */
    public function getItens($pvnumero, $pvsituacao = 't') {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $sql = "SELECT pvi.*, sacit.sacitresponsavel,sacit.sacitobs,sacit.saccodigo,sacitqtd,sacit.pvnumero as sacitpvnumero
                FROM " . TABELA_ITENS_PEDIDO . " pvi 

                LEFT JOIN " . TABELA_SAC_ITEM . " sacit ON pvi.pvnumero = sacit.pvnumero AND sacit.procodigo = pvi.procodigo
                WHERE pvi.pvnumero='$pvnumero' AND pvi.pvisituacao = '$pvsituacao'
                order by sacit.saccodigo";
        $result = $db->GetAll($sql);

        $retorno = new stdClass();
        if (!$result) {
            $msg = "NAO HA ESTOQUE APROPRIADO. " . $db->ErrorMsg();
            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        } else {
            $msg = count($result) . " ITEN(S) LOCALIZADOS. ";
            $retorno->retorno = true;
            $retorno->mensagem = $msg;

            foreach ($result as $value) {
                $itemPedido = new ItemPedidoVO();
                $itemPedido->pvicodigo = $value['pvicodigo'];
                $itemPedido->pvitem = $value['pvitem'];
                $itemPedido->produto = new ProdutoVO($value['procodigo']);
                $itemPedido->pvipreco = $value['pvipreco'];
                $itemPedido->pvisaldo = $value['pvisaldo'];
                $itemPedido->pvicomis = $value['pvicomis'];
                $itemPedido->pvitippr = $value['pvitippr'];

                $retornoItemEstoques = $this->getItemEstoques($itemPedido->pvicodigo);
                $itemPedido->estoques = $retornoItemEstoques->estoques;

                $itemPedido->pedidoVendaItemEstoque = new PedidoVendaItemVO($itemPedido->pvicodigo);

                $itemPedido->pvidatacadastro = $value['pvidatacadastro'];
                $itemPedido->pvisituacao = $value['pvisituacao'];

                $itemPedido->SacItem = new SacItemVO();
                $itemPedido->SacItem->procodigo = $value['procodigo'];
                $itemPedido->SacItem->sacitresponsavel = $value['sacitresponsavel'];
                $itemPedido->SacItem->sacitobs = $value['sacitobs'];
                $itemPedido->SacItem->saccodigo = $value['saccodigo'];
                $itemPedido->SacItem->sacitqtd = $value['sacitqtd'];
                $itemPedido->SacItem->pvnumero = $value['sacitpvnumero'];

                $itensPedido[] = $itemPedido;
            }

            $retorno->itensPedido = $itensPedido;
        }

        return $retorno;
    }

    /**
     * Metodo para pegar os tipo de icms utilizada na NF informada.
     * Executa select na tabela correspondente ao estoque informado.
     * Ver config.php lista de tabelas.
     *
     * @access public
     * @param integer $notnumero Recebe o numero da NF do Pedido
     * @param String $estoqueSaida Recebe o estoque do Pedido
     * @return object Retorna objetos com retorno da busca;
     */
    public function getTipoIcmsNF($notnumero, $estoqueSaida) {

        $conexao = new Conexao();
        $db = $conexao->connection();
        $nf = null;
        $comp = '';

        if ($estoqueSaida == 'fil') {

            $nf = new NotafilVO();
            $tabelaNFItem = TABELA_NF_ITEM_FILIAL;
            $comp = 'f';
        } else if ($estoqueSaida == 'mat') {

            $nf = new NotamatVO();
            $tabelaNFItem = TABELA_NF_ITEM_MATRIZ;
            $comp = 'm';
        } else if ($estoqueSaida == 'vit') {

            $nf = new NotavitVO();
            $tabelaNFItem = TABELA_NF_ITEM_VIX;
            $comp = 'v';
        } else if ($estoqueSaida == 'gua') {

            $nf = new NotaguaVO();
            $tabelaNFItem = TABELA_NF_ITEM_GUA;
            $comp = 'g';
        }

        $sql = "SELECT ndiproicms FROM " . $tabelaNFItem . " WHERE ndnumero = " . $notnumero;
        $result = $db->GetRow($sql);

        if ($result["ndiproicms"] == "2") {
            return "ST";
        } else {
            return "NORMAL";
        }
    }

    /**
     * Metodo para efetuar pesquisa da NF de um pedido.
     * Executa select na tabela correspondente ao estoque informado.
     * Ver config.php lista de tabelas.
     *
     * @access public
     * @param integer $pvnumero Recebe o numero do Pedido
     * @param String $estoqueSaida Recebe o estoque do Pedido
     * @return object Retorna objetos com retorno da busca;
     */
    public function getNF($pvnumero, $estoqueSaida) {

        $conexao = new Conexao();
        $db = $conexao->connection();
        $nf = null;
        $comp = '';

        $possuiEstoque = true;

        if ($estoqueSaida == 'fil') {

            $nf = new NotafilVO();
            $tabelaNF = TABELA_NF_FILIAL;
            $comp = 'f';
        } else if ($estoqueSaida == 'mat') {

            $nf = new NotamatVO();
            $tabelaNF = TABELA_NF_MATRIZ;
            $comp = 'm';
        } else if ($estoqueSaida == 'vit') {

            $nf = new NotavitVO();
            $tabelaNF = TABELA_NF_VIX;
            $comp = 'v';
        } else if ($estoqueSaida == 'gua') {

            $nf = new NotaguaVO();
            $tabelaNF = TABELA_NF_GUA;
            $comp = 'g';
        } else if ($estoqueSaida == 'dep') {

            $nf = new NotadepVO();
            $tabelaNF = TABELA_NF_DEP;
        } else {

            $possuiEstoque = false;
        }

        $sql = "SELECT not" . $comp . "codigo,
                                            pvnumero,
                                             to_char( notemissao, 'dd/mm/yyyy') as notemissao,
                                            notvolumes,
                                            notnumero,
                                            notvalor,
                                            tracodigo,
                                            natcodigo,
                                            parcelas,
                                            tipoparcelas,
                                            parcela1,
                                            parcela2,
                                            parcela3,
                                            parcela4,
                                            parcela5,
                                            parcela6,
                                            parcela7,
                                            parcela8,
                                            parcela9,
                                            parcela10,
                                            parcela11,
                                            parcela12,
                                             to_char( parcdata1, 'dd/mm/yyyy') as parcdata1,
                                             to_char( parcdata2, 'dd/mm/yyyy') as parcdata2,
                                             to_char( parcdata3, 'dd/mm/yyyy') as parcdata3,
                                             to_char( parcdata4, 'dd/mm/yyyy') as parcdata4,
                                             to_char( parcdata5, 'dd/mm/yyyy') as parcdata5,
                                             to_char( parcdata6, 'dd/mm/yyyy') as parcdata6,
                                             to_char( parcdata7, 'dd/mm/yyyy') as parcdata7,
                                             to_char( parcdata8, 'dd/mm/yyyy') as parcdata8,
                                             to_char( parcdata9, 'dd/mm/yyyy') as parcdata9,
                                             to_char( parcdata10, 'dd/mm/yyyy') as parcdata10,
                                             to_char( parcdata11, 'dd/mm/yyyy') as parcdata11,
                                             to_char( parcdata12, 'dd/mm/yyyy') as parcdata12,
                                            parcdia1,
                                            parcdia2,
                                            parcdia3,
                                            parcdia4,
                                            parcdia5,
                                            parcdia6,
                                            parcdia7,
                                            parcdia8,
                                            parcdia9,
                                            parcdia10,
                                            parcdia11,
                                            parcdia12,
                                            especie,
                                            quantidade,
                                             to_char( data, 'dd/mm/yyyy') as data,
                                            numero,
                                            alicms,
                                            obs1,
                                            obs2,
                                            obs3,
                                            frete,
                                            obs4,
                                            marca,
                                            comissao,
                                            nnota,
                                            tnota,
                                            clicodigo,
                                            tipo,
                                            pvvaldesc,
                                            pvperdesc,
                                            icms,
                                            ipi,
                                            baseicms,
                                            notnumero2,
                                            basecalculoicms,
                                            valoricms,
                                            baseicmssub,
                                            valoricmssub,
                                            valorfrete,
                                            valorseguro,
                                            outrasdespesas,
                                            valortotalipi,
                                            valprod,
                                            chave
                                FROM " . $tabelaNF . " WHERE pvnumero='$pvnumero' ";

        $result = $db->GetAll($sql);

        if ($result) {
            foreach ($result as $value) {
                $nf->notcodigo = $value['not' . $comp . 'codigo'];
                $nf->pvnumero = $value['pvnumero'];
                $nf->notemissao = $value['notemissao'];
                $nf->notvolumes = $value['notvolumes'];
                $nf->notnumero = $value['notnumero'];
                $nf->notvalor = $value['notvalor'];
                $nf->tracodigo = $value['tracodigo'];
                $nf->natcodigo = $value['natcodigo'];
                $nf->parcelas = $value['parcelas'];
                $nf->tipoparcelas = $value['tipoparcelas'];
                $nf->parcela1 = $value['parcela1'];
                $nf->parcela2 = $value['parcela2'];
                $nf->parcela3 = $value['parcela3'];
                $nf->parcela4 = $value['parcela4'];
                $nf->parcela5 = $value['parcela5'];
                $nf->parcela6 = $value['parcela6'];
                $nf->parcela7 = $value['parcela7'];
                $nf->parcela8 = $value['parcela8'];
                $nf->parcela9 = $value['parcela9'];
                $nf->parcela10 = $value['parcela10'];
                $nf->parcela11 = $value['parcela11'];
                $nf->parcela12 = $value['parcela12'];
                $nf->parcdata1 = $value['parcdata1'];
                $nf->parcdata2 = $value['parcdata2'];
                $nf->parcdata3 = $value['parcdata3'];
                $nf->parcdata4 = $value['parcdata4'];
                $nf->parcdata5 = $value['parcdata5'];
                $nf->parcdata6 = $value['parcdata6'];
                $nf->parcdata7 = $value['parcdata7'];
                $nf->parcdata8 = $value['parcdata8'];
                $nf->parcdata9 = $value['parcdata9'];
                $nf->parcdata10 = $value['parcdata10'];
                $nf->parcdata11 = $value['parcdata11'];
                $nf->parcdata12 = $value['parcdata12'];
                $nf->parcdia1 = $value['parcdia1'];
                $nf->parcdia2 = $value['parcdia2'];
                $nf->parcdia3 = $value['parcdia3'];
                $nf->parcdia4 = $value['parcdia4'];
                $nf->parcdia5 = $value['parcdia5'];
                $nf->parcdia6 = $value['parcdia6'];
                $nf->parcdia7 = $value['parcdia7'];
                $nf->parcdia8 = $value['parcdia8'];
                $nf->parcdia9 = $value['parcdia9'];
                $nf->parcdia10 = $value['parcdia10'];
                $nf->parcdia11 = $value['parcdia11'];
                $nf->parcdia12 = $value['parcdia12'];
                $nf->especie = $value['especie'];
                $nf->quantidade = $value['quantidade'];
                $nf->data = $value['data'];
                $nf->numero = $value['numero'];
                $nf->alicms = $value['alicms'];
                $nf->obs1 = $value['obs1'];
                $nf->obs2 = $value['obs2'];
                $nf->obs3 = $value['obs3'];
                $nf->frete = $value['frete'];
                $nf->obs4 = $value['obs4'];
                $nf->marca = $value['marca'];
                $nf->comissao = $value['comissao'];
                $nf->nnota = $value['nnota'];
                $nf->tnota = $value['tnota'];
                $nf->clicodigo = $value['clicodigo'];
                $nf->tipo = $value['tipo'];
                $nf->pvvaldesc = $value['pvvaldesc'];
                $nf->pvperdesc = $value['pvperdesc'];
                $nf->icms = $value['icms'];
                $nf->ipi = $value['ipi'];
                $nf->baseicms = $value['baseicms'];
                $nf->notnumero2 = $value['notnumero2'];
                $nf->basecalculoicms = $value['basecalculoicms'];
                $nf->valoricms = $value['valoricms'];
                $nf->baseicmssub = $value['baseicmssub'];
                $nf->valoricmssub = $value['valoricmssub'];
                $nf->valorfrete = $value['valorfrete'];
                $nf->valorseguro = $value['valorseguro'];
                $nf->outrasdespesas = $value['outrasdespesas'];
                $nf->valortotalipi = $value['valortotalipi'];
                $nf->valprod = $value['valprod'];
                $nf->chave = $value['chave'];
                $nf->chaveicms = $value['chaveicms'];
                $nf->notaicms = $value['notaicms'];
                $nf->pais = $value['pais'];
                $nf->codpais = $value['codpais'];
                $nf->numerodi = $value['numerodi'];
                $nf->codexporta = $value['codexporta'];
                $nf->locdesemb = $value['locdesemb'];
                $nf->ufdesemb = $value['ufdesemb'];
                $nf->didata = $value['didata'];
                $nf->datadesemb = $value['datadesemb'];
                $nf->tipoIcms = $this->getTipoIcmsNF($nf->notnumero, $estoqueSaida);
            }
        }
//			$retorno->notafiscal = $nf;
//		}

        return $nf;
    }

    /**
     * Metodo para efetuar pesquisa dos itens de um pedido.
     * Executa select na tabela pvitembeta ver config.php lista de tabelas.
     *
     * @access public
     * @param integer $pvnumero Recebe o numero do Pedido
     * @return object Retorna objetos com retorno da busca;
     */
    public function getEstoqueDestino($origem, $destino) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $sql = "SELECT * FROM " . TABELA_ESTOQUE_DESTINO_ORIGEM . " WHERE etqorigem=$origem and etqdestino=$destino";

        $result = $db->GetRow($sql);

        $retorno = new stdClass();
        if (!$result) {
            $etqOrigemDestino = new EstoqueDestinoOrigemVO();
            $etqOrigemDestino->etqodCodigo = 0;
            $etqOrigemDestino->estoqueOrigem = new EstoqueVO($origem);
            $etqOrigemDestino->estoqueDestino = new EstoqueVO($destino);
            $etqOrigemDestino->estoqueTemporario = new EstoqueVO(10);
        } else {
            $etqOrigemDestino = new EstoqueDestinoOrigemVO();
            $etqOrigemDestino->etqodCodigo = $result['etqodcodigo'];
            $etqOrigemDestino->estoqueOrigem = new EstoqueVO($result['etqorigem']);
            $etqOrigemDestino->estoqueDestino = new EstoqueVO($result['etqdestino']);
            $etqOrigemDestino->estoqueTemporario = new EstoqueVO($result['etqtemporario']);
            $etqOrigemDestino->etqodDataCadastro = $result['etqoddatacadastro'];
            $etqOrigemDestino->etqodSituacao = $result['etqodsituacao'];
        }

        $msg = "[" . date('d.m.Y H:i:s') . "] OK: ORIGEM [" . $etqOrigemDestino->estoqueOrigem->etqcodigo . "] DESTINO [" . $etqOrigemDestino->estoqueDestino->etqcodigo . "] ARMAZENADO [" . $etqOrigemDestino->estoqueTemporario->etqcodigo . "].";

        $retorno->retorno = true;
        $retorno->mensagem = $msg;
        $retorno->estoqueOrigemDestino = $etqOrigemDestino;

        return $retorno;
    }

    /**
     * Metodo para localizar estoque atual do produto.
     * Executa select para localizar estoque.
     *
     * @access public
     * @param integer $etqcodigo Recebe o valor do codigo do estoque.
     * @param integer $procodgio Recebe o valor do codigo do produto.
     * @return object Retorna objeto do tipo estoque atual;
     */
    public function getEstoqueAtual($etqcodigo, $procodigo) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $sql = "SELECT * FROM " . TABELA_ESTOQUE_ATUAL . " WHERE procodigo = $procodigo AND codestoque = $etqcodigo";

        $row = $db->GetRow($sql);

        $retornoEstoqueAtual = new stdClass();
        $sta = false;
        if (!$row) {
            $record['procodigo'] = $procodigo;
            $record['estqtd'] = 0;
            $record['codestoque'] = $etqcodigo;
            $result = $db->AutoExecute(TABELA_ESTOQUE_ATUAL, $record, 'INSERT');

            $sql = "SELECT * FROM " . TABELA_ESTOQUE_ATUAL . " WHERE procodigo = $procodigo AND codestoque = $etqcodigo";
            $row = $db->GetRow($sql);
            if (!$row) {
                $msg = "[" . date('d.m.Y H:i:s') . "] ERRO: CONSULTA ESTOQUE ATUAL." . $db->ErrorMsg();

                $retornoEstoqueAtual->retorno = false;
                $retornoEstoqueAtual->mensagem = $msg;
            } else {
                $sta = true;
            }
        } else {
            $sta = true;
        }

        if ($sta) {
            $estoqueAtual = new EstoqueAtualVO();
            $estoqueAtual->etqatualcodigo = $row['etqatualcodigo'];
            $estoqueAtual->produto = new ProdutoVO();
            $estoqueAtual->produto->procodigo = $row['procodigo'];
            $estoqueAtual->estqtd = $row['estqtd'];
            $estoqueAtual->estoque = new EstoqueVO($row['codestoque']);

            $msg = "[" . date('d.m.Y H:i:s') . "] OK: CONSULTA ESTOQUE ATUAL " . $row['etqatualcodigo'] . ".";

            $retornoEstoqueAtual->retorno = true;
            $retornoEstoqueAtual->mensagem = $msg;
            $retornoEstoqueAtual->estoqueAtual = $estoqueAtual;
        }

        return $retornoEstoqueAtual;
    }

    /**
     * Metodo para efetuar pesquisa dos pedidos no banco.
     * Executa select na tabela pvitembeta ver config.php lista de tabelas.
     *
     * @access public
     * @param integer pvnumero lista item pedidos
     * @return object Retorna objetos do tipo json;
     */
    public function getVales($clicodigo) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $sql = "SELECT devolucao.pvnumero as numero, devolucao.dvnumero, devolucao.pvbaixa, (select sum(pvipreco*pvidevol)  
					FROM dvitem 
					WHERE devolucao.pvvale = dvitem.pvvale) as valor,
					pvenda.pvperdesc as desconto, devolucao.pvemissao as emissao, devolucao.pvdevolucao as devolucao, devolucao.pvvale as vale,
					(CASE WHEN clientes.clicod isnull THEN fornecedor.forcodigo ELSE clientes.clicod END) as cliente, 
					(CASE WHEN clientes.clirazao isnull THEN fornecedor.forrazao ELSE clientes.clirazao END) as razao, 
					pvenda.vencodigo as vendedor,
					dvitem.devolucaototal, dvitem.valorpedido
					FROM devolucao
					LEFT JOIN pvenda on devolucao.pvnumero=pvenda.pvnumero
					LEFT JOIN dvitem on dvitem.pvnumero=pvenda.pvnumero
					LEFT JOIN clientes on pvenda.clicodigo = clientes.clicodigo
					LEFT JOIN fornecedor on pvenda.clicodigo = fornecedor.forcodigo
					WHERE devolucao.pvbaixa isnull and clientes.clicodigo='$clicodigo'
					ORDER BY devolucao.pvnumero,devolucao.pvvale asc";

        $result = $db->Execute($sql);

        $retorno = new stdClass();
        if (!$result) {
            $msg = $sql . "Falha na conexao com banco de dados! " . $db->ErrorMsg();

            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        }
        while (!$result->EOF) {
            $vale = new ValeVO();
            $vale->numero = trim($result->fields[0]);
            $vale->dvnumero = trim($result->fields[1]);
            $vale->pvbaixa = trim($result->fields[2]);

            $datadevolucao = trim($result->fields[6]);
            $datadevolucao = substr($datadevolucao, 0, 4) . substr($datadevolucao, 5, 2) . substr($datadevolucao, 8, 2);

            /*
              Todos os Vales passam a ter desconto
              if($datadevolucao>='20110803'){
              $vale->valor = trim(round($result->fields[3] - ($result->fields[3] * $result->fields[4] / 100),2));
              }
              else {
              $vale->valor = trim(round($result->fields[3],2));
              }
             */
            $vale->valor = trim(round($result->fields[3] - ($result->fields[3] * $result->fields[4] / 100), 2));

            $vale->desconto = trim($result->fields[4]);
            $vale->emissao = trim($result->fields[5]);
            $vale->devolucao = trim($result->fields[6]);
            $vale->vale = trim($result->fields[7]);
            $vale->cliente = trim($result->fields[8]);
            $vale->razao = trim($result->fields[9]);
            $vale->vendedor = trim($result->fields[10]);
            $vale->devolucaototal = trim($result->fields[11]);
            $vale->valorpedido = trim($result->fields[12]);

            $vales[$vale->dvnumero] = $vale;
            $result->MoveNext();
        }

        if (is_array($vales) && count($vales)) {
            $msg = $sql . "Vales(s) localizado(s) com sucesso!";
            $retorno->retorno = true;
            $retorno->mensagem = $msg;
            $retorno->vales = $vales;
        } else {
            $msg = $sql . "N&atilde;o foi possivel localizar vale(s)! " . $db->ErrorMsg();
            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        }

        return $retorno;
    }

    /**
     * Metodo para efetuar pesquisa dos pedidos no banco.
     * Executa select na tabela pvitembeta ver config.php lista de tabelas.
     *
     * @access public
     * @param integer pvnumero lista item pedidos
     * @return object Retorna objetos do tipo json;

      public function getVales($clicodigo)
      {
      $conexao = new Conexao();
      $db = $conexao->connection();

      $sql = "SELECT devolucao.pvnumero as numero, devolucao.dvnumero, devolucao.pvbaixa, (select sum(pvipreco*pvidevol)
      FROM dvitem
      WHERE devolucao.pvvale = dvitem.pvvale) as valor,
      0 as desconto, devolucao.pvemissao as emissao, devolucao.pvdevolucao as devolucao, devolucao.pvvale as vale,
      (CASE WHEN clientes.clicod isnull THEN fornecedor.forcodigo ELSE clientes.clicod END) as cliente,
      (CASE WHEN clientes.clirazao isnull THEN fornecedor.forrazao ELSE clientes.clirazao END) as razao,
      pvenda.vencodigo as vendedor,
      dvitem.devolucaototal, dvitem.valorpedido
      FROM devolucao
      LEFT JOIN pvenda on devolucao.pvnumero=pvenda.pvnumero
      LEFT JOIN dvitem on dvitem.pvnumero=pvenda.pvnumero
      LEFT JOIN clientes on pvenda.clicodigo = clientes.clicodigo
      LEFT JOIN fornecedor on pvenda.clicodigo = fornecedor.forcodigo
      WHERE devolucao.pvbaixa isnull and clientes.clicodigo='$clicodigo'
      ORDER BY devolucao.pvnumero,devolucao.pvvale asc";

      $result = $db->Execute($sql);

      $retorno = new stdClass();
      if (!$result)
      {
      $msg = $sql. "Falha na conexao com banco de dados! ". $db->ErrorMsg();

      $retorno->retorno = false;
      $retorno->mensagem = $msg;
      }
      while (!$result->EOF)
      {
      $vale = new ValeVO();
      $vale->numero = trim($result->fields[0]);
      $vale->dvnumero = trim($result->fields[1]);
      $vale->pvbaixa = trim($result->fields[2]);
      $vale->valor = trim($result->fields[3]);
      $vale->desconto = trim($result->fields[4]);
      $vale->emissao = trim($result->fields[5]);
      $vale->devolucao = trim($result->fields[6]);
      $vale->vale = trim($result->fields[7]);
      $vale->cliente = trim($result->fields[8]);
      $vale->razao = trim($result->fields[9]);
      $vale->vendedor = trim($result->fields[10]);
      $vale->devolucaototal = trim($result->fields[11]);
      $vale->valorpedido = trim($result->fields[12]);

      $vales{$vale->dvnumero} = $vale;
      $result->MoveNext();
      }

      if (count($vales))
      {
      $msg = $sql. "Vales(s) localizado(s) com sucesso!";
      $retorno->retorno = true;
      $retorno->mensagem = $msg;
      $retorno->vales = $vales;
      }
      else
      {
      $msg = $sql. "N&atilde;o foi possivel localizar vale(s)! ". $db->ErrorMsg();
      $retorno->retorno = false;
      $retorno->mensagem = $msg;
      }

      return $retorno;
      }
     */

    /**
     * Metodo para verificar se peidodo esta travado.
     * Pedido travado não permite 2 pessoas 
     * alterar pedido ao mesmo tempo
     *
     * @access public
     * @param int $pvnumero numero do pedido.
     * @return object Objeto com dados dados do retorno do banco.
     */
    public function getTravaPedido($pvnumero) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $sql = "SELECT * FROM " . TABELA_PEDIDOS . " WHERE pvnumero=$pvnumero";

        $result = $db->GetRow($sql);

        $retorno = new stdClass();
        if (!$result) {
            $msg = "PEDIDO LIBERADO PARA ALTERACAO.";
            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        } else {
            $usuario = new UsuariosVO($result['usucodigo']);
            $msg = "PEDIDO SENDO UTILIZADO POR $usuario->usunome.";
            $retorno->retorno = true;
            $retorno->mensagem = $msg;
        }

        return $retorno;
    }

    /**
     * Metodo traz historico do pedido.
     * historico do pedido por usuario 
     *
     * @access public
     * @param int $pvnumero numero do pedido.
     * @param int $usuario codigo do usuario do pedido.
     * @return array Array com dados do retorno do banco.
     */
    public function getHistoricoPedido($pvnumero) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $sql = "SELECT * FROM " . TABELA_HISTORICO . " WHERE tabela = '" . TABELA_PEDIDOS . "' 
		and codtabela = $pvnumero ORDER BY dataacao desc";

        $result = $db->GetAll($sql);

        $retorno = new stdClass();
        if (!$result) {
            $msg = "NAO HA HISTORICO DESTE PEDIDO.";
            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        } else {
            $msg = "LOCALIZADO HISTORIO COMPLETO DO PEDIDO";
            $retorno->retorno = true;
            $retorno->mensagem = $msg;

            foreach ($result as $value) {
                $historico = new HistoricoVO();
                $historico->codigo = $value['codigo'];
                $historico->acao = $value['acao'];
                $historico->usuario = new UsuarioVO($value['usuario']);
                $historico->tabela = $value['tabela'];
                $historico->codTabela = $value['codtabela'];
                $historico->dataAcao = $value['dataacao'];

                $historicos[] = $historico;
            }

            $retorno->historico = $historicos;
        }

        return $retorno;
    }

//Calcula o valor do produto conforme o TIPO "tabela" que for selecionada (A / B / C)
    public function calculapreco($valor, $medio, $maior, $menor, $minimo) {
        $formula_a = 0;
        $formula_c = 0;
        $formula_m = 0;

        $pa = 0;
        $pc = 0;
        $pm = 0;
        $aux = 0;

        $formula_a = ((100 - $maior) / 100);
        $formula_c = ((100 - $menor) / 100);
        $formula_m = (($minimo / 100) + 1);

        $aux = ($medio / 100);
        $pb = (float) ($valor * $aux) + (float) ($valor);
        //pb = round(pb);
        $pb = round($pb, 2);
        $pa = $pb / $formula_a;
        $pa = round($pa, 2);
        $pc = $pb * $formula_c;
        $pc = round($pc, 2);
        $pm = $valor * $formula_m;
        $pm = round($pm, 2);

        //tabela == 'A' => $pa;
        //tabela == 'B' => $pb;
        //tabela == 'C' => $pc;

        return array("A" => $pa, "B" => $pb, "C" => $pc);
    }

//RECEBE PARÃMETRO
    public function listaPrecosDiferentes($parametro) {

        $sql = "select a.*,b.procod,b.proreal as valor,b.promedio as medio,b.promaior as maior,b.promenor as menor,b.prominimo as minimo,b.proreal as real,b.profinal as final,c.pvtipoped from pvitem a,produto b,pvenda c where a.pvnumero = '$parametro' and a.procodigo = b.procodigo and a.pvnumero = c.pvnumero";

        $sql = pg_query($sql);
        $row = pg_num_rows($sql);

        $contador = 0;
        $val = 1;

//Calcula o valor do produto conforme o TIPO "tabela" que for selecionada (A / B / C)
        /* function calculapreco2($valor,$medio,$maior,$menor,$minimo)
          {
          $formula_a = 0;
          $formula_c = 0;
          $formula_m = 0;

          $pa = 0;
          $pc = 0;
          $pm = 0;
          $aux = 0;

          $formula_a = ((100-$maior)/100);
          $formula_c = ((100-$menor)/100);
          $formula_m = (($minimo/100)+1);

          $aux = ($medio/100);
          $pb = (float)($valor * $aux) + (float)($valor);
          //pb = round(pb);
          $pb=round($pb,2);
          $pa = $pb / $formula_a;
          $pa = round($pa,2);
          $pc = $pb * $formula_c;
          $pc = round($pc,2);
          $pm = $valor * $formula_m;
          $pm = round($pm,2);

          //tabela == 'A' => $pa;
          //tabela == 'B' => $pb;
          //tabela == 'C' => $pc;

          return array("A" => $pa, "B" => $pb, "C" => $pc);
          } */

//VERIFICA SE VOLTOU ALGO
        if ($row) {

            //PERCORRE ARRAY
            for ($i = 0; $i < $row; $i++) {

                $codigoproduto = pg_result($sql, $i, "procodigo");
                $pvnumero = pg_result($sql, $i, "pvnumero");
                $pvtipoped = pg_result($sql, $i, "pvtipoped");
                $procod = pg_result($sql, $i, "procod");
                $pvitippr = pg_result($sql, $i, "pvitippr");
                $pvipreco = pg_result($sql, $i, "pvipreco");
                $valor = pg_result($sql, $i, "valor");
                $medio = pg_result($sql, $i, "medio");
                $maior = pg_result($sql, $i, "maior");
                $menor = pg_result($sql, $i, "menor");
                $minimo = pg_result($sql, $i, "minimo");
                $real = pg_result($sql, $i, "real");
                $final = pg_result($sql, $i, "final");
                $preco = $this->calculapreco($valor, $medio, $maior, $menor, $minimo);

                if ($pvtipoped == 'S' || $pvtipoped == 'D' || $pvtipoped == 'C') {
                    $tabela = $final;
                } else {

                    if ($pvitippr == 'A') {
                        $tabela = $preco["A"];
                    } elseif ($pvitippr == 'B') {
                        $tabela = $preco["B"];
                    } elseif ($pvitippr == 'C') {
                        $tabela = $preco["C"];
                    }
                }

                $aux = round($pvipreco, 2) - round($tabela, 2);

                if ($aux <> 0) {
                    $val = 2;
                    $data = date('d-m-Y');
                    $hora = date('His');
                    $arquivo2 = $parametro . '-' . $data . '-' . $hora;
                    $arquivoCliente = new GeraArquivo(DIR_LOGS . '/preco/' . $arquivo2 . '.txt');
                    $arquivoCliente->addContent($parametro . " " . $procod . " " . $pvitippr . " " . $pvipreco . " " . $tabela . "<br >");

                    $arrayRetorno[] = $tabela;
                    $arrayRetorno[] = $pvipreco;
                    $arrayRetorno[] = $pvitippr;
                    $arrayRetorno[] = $procod;
                }
                //echo ' '.$val;
            }
        }
        $retorno = new stdClass();
        $retorno->parametro = $val;
        $retorno->arquivo = $arquivo2;
        $retorno->valores = $arrayRetorno;
        return $retorno;
    }

    public function verificaPrecoPedido($parametro) {
//Fica em Looping em todos os itens do Pedido

        $sql = "select a.*,b.procod,b.proreal as valor,b.promedio as medio,b.promaior as maior,b.promenor as menor,b.prominimo as minimo,b.proreal as real,b.profinal as final,c.pvtipoped from pvitem a,produto b,pvenda c where a.pvnumero = '$parametro' and a.procodigo = b.procodigo and a.pvnumero = c.pvnumero";

        $sql = pg_query($sql);
        $row = pg_num_rows($sql);

        $contador = 0;
        $val = 1;

//VERIFICA SE VOLTOU ALGO
        if ($row) {

            //PERCORRE ARRAY
            for ($i = 0; $i < $row; $i++) {

                $codigoproduto = pg_result($sql, $i, "procodigo");
                $pvnumero = pg_result($sql, $i, "pvnumero");
                $pvtipoped = pg_result($sql, $i, "pvtipoped");
                $procod = pg_result($sql, $i, "procod");
                $pvitippr = pg_result($sql, $i, "pvitippr");
                $pvipreco = pg_result($sql, $i, "pvipreco");
                $valor = pg_result($sql, $i, "valor");
                $medio = pg_result($sql, $i, "medio");
                $maior = pg_result($sql, $i, "maior");
                $menor = pg_result($sql, $i, "menor");
                $minimo = pg_result($sql, $i, "minimo");
                $real = pg_result($sql, $i, "real");
                $final = pg_result($sql, $i, "final");
                $preco = $this->calculapreco($valor, $medio, $maior, $menor, $minimo);

                if ($pvtipoped == 'S' || $pvtipoped == 'D' || $pvtipoped == 'C') {
                    $tabela = $final;
                } else {

                    if ($pvitippr == 'A') {
                        $tabela = $preco["A"];
                    } elseif ($pvitippr == 'B') {
                        $tabela = $preco["B"];
                    } elseif ($pvitippr == 'C') {
                        $tabela = $preco["C"];
                    }
                }

                $aux = round($pvipreco, 2) - round($tabela, 2);
                if ($aux <> 0) {
                    $val = 2;
                    //echo '<br>';
                    //echo ' '.$parametro;
                    //echo ' '.$procod;
                    //echo ' '.$pvitippr;
                    //echo ' '.$pvipreco;
                    //echo ' '.$tabela;
                }
                //echo ' '.$val;
            }
        }
        return $val;
    }

    /**
     * Funcao para efetuar insersão do item.
     * Executa insert na tabela pvitembeta.
     *
     * @access public
     * @param ItemPedidoVO $itemPedido Recebe o item do pedido.
     * @return array Retorna array com o retorno da insersão do item.
     */
    public function verificaMovimentacao($parametro) {
        //$cadastro = new banco($conn,$db);
        //Fica em Looping em todos os itens do Pedido

        $sql = "select a.*,b.procod from pvitem a,produto b where a.pvnumero = '$parametro' and a.procodigo = b.procodigo";

        $sql = pg_query($sql);
        $row = pg_num_rows($sql);

        $contador = 0;
        $valor = 1;

        //VERIFICA SE VOLTOU ALGO
        if ($row) {

            //Vou abrir o Select uma vez apenas
            $sql3 = "";
            for ($ano = 8; $ano < 13; $ano++) {
                for ($mes = 1; $mes < 13; $mes++) {
                    if ($ano < 10) {
                        $anovai = '0' . $ano;
                    } else {
                        $anovai = $ano;
                    }
                    if ($mes < 10) {
                        $mesvai = '0' . $mes;
                    } else {
                        $mesvai = $mes;
                    }
                    $tabela = 'movestoque' . $mesvai . $anovai;

                    if ($sql3 == "") {
                        $sql3 = "";
                    } else {
                        $sql3 = $sql3 . "union ";
                    }
                    $sql3 = $sql3 . "select a.movqtd,a.movtipo,a.movdata as ordem,a.movcodigo,a.procodigo,a.codestoque
								FROM $tabela a
								Where a.pvnumero = '$parametro' ";
                }
            }
            $sql3 = $sql3 . " order by ordem,movcodigo";

            $sql3 = pg_query($sql3);
            $row3 = pg_num_rows($sql3);


            //PERCORRE ARRAY
            for ($i = 0; $i < $row; $i++) {
                //for($i=0; $i<1000; $i++) {

                $codigoproduto = pg_result($sql, $i, "procodigo");
                $pvnumero = pg_result($sql, $i, "pvnumero");
                $procod = pg_result($sql, $i, "procod");

                for ($estcodigo = 1; $estcodigo < 100; $estcodigo++) {

                    $saldoped = pg_result($sql, $i, "pviest0" . ($estcodigo));

                    if ($saldoped > 0) {

                        //Processa as Movimentações do Item para Comparar com o pedido

                        $saldo = 0;

                        //VERIFICA SE VOLTOU ALGO
                        if ($row3) {

                            //PERCORRE ARRAY
                            for ($i3 = 0; $i3 < $row3; $i3++) {

                                $movqtd = pg_result($sql3, $i3, "movqtd");
                                $movtipo = pg_result($sql3, $i3, "movtipo");
                                $ordem = pg_result($sql3, $i3, "ordem");
                                $movcodigo = pg_result($sql3, $i3, "movcodigo");
                                $procodigo = pg_result($sql3, $i3, "procodigo");
                                $deposito = pg_result($sql3, $i3, "codestoque");

                                if (trim($movqtd) == "") {
                                    $movqtd = "0";
                                }
                                if (trim($movtipo) == "") {
                                    $movtipo = "0";
                                }
                                if (trim($movcodigo) == "") {
                                    $movcodigo = "0";
                                }
                                if (trim($procodigo) == "") {
                                    $procodigo = "0";
                                }
                                if (trim($deposito) == "") {
                                    $deposito = "0";
                                }

                                if ($codigoproduto == $procodigo) {
                                    if ($estcodigo == $deposito) {

                                        if ($movtipo == 1) {
                                            $saldo = $movqtd;
                                        } else if ($movtipo == 2) {
                                            $saldo = $saldo - $movqtd;
                                        } else if ($movtipo == 3) {
                                            $saldo = $saldo + $movqtd;
                                        } else if ($movtipo == 4) {
                                            $saldo = $saldo - $movqtd;
                                        }
                                    }
                                }
                            }
                        }


                        $aux = $saldoped + $saldo;
                        if ($aux <> 0) {
                            $valor = 2;
                        }
                    }
                }
            }
        }
        return $valor;
    }

    /**
     * Metodo para efetuar verificacao dos estoques existentes no estoque atual.
     * Executa select, insert e update na tabela estoqueatual config.php lista de tabelas.
     *
     * @access public
     * @param array Lista de EstoqueVO para add no estoque atual
     * @return object Retorna objeto com resultado do banco;
     */
    public function verificaEstoqueAtual($estoque, $produto, $qtd = 0) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $retorno = new stdClass();
        $retorno->retorno = false;
        $retorno->isInsert = false;

        $sql = "SELECT * FROM " . TABELA_ESTOQUE_ATUAL . " WHERE procodigo = $produto->procodigo AND codestoque = $estoque->etqcodigo";
        $row = $db->GetRow($sql);

        if (!$row) {
            $record['procodigo'] = $produto->procodigo;
            $record['estqtd'] = $qtd;
            $record['codestoque'] = $estoque->etqcodigo;
            $record['usucodigo'] = 0;

            $result = $db->AutoExecute(TABELA_ESTOQUE_ATUAL, $record, 'INSERT');

            if (!$result) {
                $msg = "[" . date('d.m.Y H:i:s') . "] ERRO: INSERCAO ESTOQUE ATUAL PRODUTO $produto->procodigo ESTOQUE $estoque->etqcodigo. " . $db->ErrorMsg();

                $retorno->mensagem = $msg;
            } else {
                $msg = "[" . date('d.m.Y H:i:s') . "] OK: INSERCAO ESTOQUE ATUAL PRODUTO $produto->procodigo ESTOQUE $estoque->etqcodigo QTDE $qtd.";

                $retorno->retorno = true;
                $retorno->isInsert = true;
                $retorno->mensagem = $msg;
            }
        } else {
            $msg = "[" . date('d.m.Y H:i:s') . "] ATENCAO: ESTOQUE ATUAL EXISTENTE PRODUTO $produto->procodigo ESTOQUE $estoque->etqcodigo QTDE " . $row['estqtd'] . ".";

            $retorno->retorno = true;
            $retorno->mensagem = $msg;
        }

        return $retorno;
    }

    /**
     * Metodo para efetuar pesquisa dos pedidos no banco.
     * Executa select na tabela pvenda ver config.php lista de tabelas.
     *
     * @access public
     * @param string $tipo Nome do campo para pesquisar.
     * @param string $pesquisa Texto para pesquisa.
     * @return object Retorna objetos do tipo json;
     */
    public function saldoTotalItensPedidos($pvnumero) {
        $conexao = new Conexao();
        $db = $conexao->connection();
        
        $retorno = new stdClass();

        $row = $db->GetRow("SELECT sum(pvisaldo) as saldototal FROM " . TABELA_ITENS_PEDIDO2 . " WHERE pvnumero='$pvnumero' ");

        if (!$row) {
            $msg = $row . "NAO FOI POSSIVEL SOMAR O SALDO.";

            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        } else {

            $msg = "Saldo Total " . $row['saldototal'];

            $retorno->retorno = true;
            $retorno->mensagem = $msg;
            $retorno = $row['saldototal'];
        }
        return $retorno;
    }

    /**
     * Metodo para efetuar pesquisa dos pedidos no banco.
     * Executa select na tabela pvenda ver config.php lista de tabelas.
     *
     * @access public
     * @param string $tipo Nome do campo para pesquisar.
     * @param string $pesquisa Texto para pesquisa.
     * @return object Retorna objetos do tipo json;
     */
    public function valorTotalPreFechamento($pvnumero) {
        $conexao = new Conexao();
        $db = $conexao->connection();
        
        $retorno = new stdClass();

        $row = $db->GetRow("SELECT sum(fecvalor) as valortotal FROM " . TABELA_PREFECHAMENTO . " WHERE pvnumero='$pvnumero' ");

        if (!$row) {
            $msg = $row . "NAO FOI POSSIVEL SOMAR O VALOR TOTAL.";

            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        } else {

            $msg = "VALOR TOTAL " . $row['valortotal'];

            $retorno->retorno = true;
            $retorno->mensagem = $msg;
            $retorno = $row['valortotal'];
        }
        return $retorno;
    }

    /**
     * Metodo para efetuar pesquisa dos pedidos no banco.
     * Executa select na tabela pvenda ver config.php lista de tabelas.
     *
     * @access public
     * @param string $tipo Nome do campo para pesquisar.
     * @param string $pesquisa Texto para pesquisa.
     * @return object Retorna objetos do tipo json;
     */
    public function saldoTotalItensEstoque($pvnumero) {
        $conexao = new Conexao();
        $db = $conexao->connection();
        
        $retorno = new stdClass();

        $row = $db->GetRow("SELECT sum(pvieqtd) as saldototal FROM " . TABELA_ITENS_PEDIDO_ESTOQUES . " WHERE pvnumero='$pvnumero' ");

        if (!$row) {
            $msg = $row . "NAO FOI POSSIVEL SOMAR A Quantidade do estoque.";

            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        } else {

            $msg = "Quantidade Total em Estoque " . $row['saldototal'];

            $retorno->retorno = true;
            $retorno->mensagem = $msg;
            $retorno = $row['saldototal'];
        }
        return $retorno;
    }

    /**
     * Metodo para efetuar pesquisa dos pedidos no banco.
     * Executa select na tabela pvenda ver config.php lista de tabelas.
     *
     * @access public
     * @param string $tipo Nome do campo para pesquisar.
     * @param string $pesquisa Texto para pesquisa.
     * @return object Retorna objetos do tipo json;
     */
    public function getCalculoSt($parametro, $parametro2) {
        $optanteSimples = false;



        //Calcula o percentual de ICMS
        $sql = "SELECT pvtipoped,clicodigo from pvenda
		Where pvnumero = '$parametro'";



        //EXECUTA A QUERY
        $sql = pg_query($sql);

        $row = pg_num_rows($sql);

        $auxtipoped = '';
        $auxcliente = '0';

        if ($row) {

            $auxtipoped = pg_result($sql, 0, "pvtipoped");
            $auxcliente = pg_result($sql, 0, "clicodigo");
        }

        if ($auxtipoped == '' || $auxtipoped == 'D' || $auxtipoped == 'C') {
            $auxcliente = 0;
        }

        $clipessoa == '0';

        if ($auxcliente == 0) {
            $icms = 0;
        } else {

            $icms = 0;

            $sql = "SELECT f.clicodigo,f.clipessoa,i.esticms,f.cliie,h.uf,g.clecep

			from  clientes f

			Left Join cliefat g on f.clicodigo = g.clicodigo
			Left Join cidades h on g.cidcodigo = h.cidcodigo
			Left Join estados i on i.codigo = h.uf

			Where f.clicodigo = '$auxcliente'";

            //EXECUTA A QUERY
            $sql = pg_query($sql);

            $row = pg_num_rows($sql);

            if ($row) {

                $clipessoa = trim(pg_result($sql, 0, "clipessoa"));
                $esticms = pg_result($sql, 0, "esticms");
                $cliie = trim(pg_result($sql, 0, "cliie"));
                $uf = trim(pg_result($sql, 0, "uf"));

                if ($pvtipoped == 'M') {  //Se tipo 'M' Verifica estado do Cliente
                    if ($clipessoa == '0') {  //Se não tem cliente icm = 18
                        $icms = 18;
                    } else {
                        if ($uf == 'SP') { //Se estado = SP icm = 0
                            $icms = 0;
                        } else { //Se estado <> SP icm = do estado   esticms
                            $icms = $esticms;
                        }
                    }
                } else {

                    if ($clipessoa == '2') {  //Se pessoa fisica icm = 18   1 - Jurídica, 2 - Física.
                        $icms = 18;
                    } else if ($clipessoa == '2') { //Se pessoa juridica
                        if ($cliie == 'ISENTO') {  // e "ISE" ou "EM " = 18
                            $icms = 18;
                        } else if ($cliie == 'EM ANDAMENTO') {  // e "ISE" ou "EM " = 18
                            $icms = 18;
                        } else {//busca do estado
                            $icms = $esticms;
                        }
                    } else { //Se não tem cliente icm = 18
                        $icms = 18;
                    }
                }
            }
        }


        $alicms = $icms;

        $cadastro = new banco($conn, $db);


        //Criação de vetor com todos os IVAs, cada código já na sua respectiva posicao
        for ($j = 1; $j <= 1000; $j++) {
            $aperiva[$j] = 0;
            $amgiva[$j] = '';
            $abaiva[$j] = '';
            $arsiva[$j] = '';
            $apeiva[$j] = '';
            $avalitema[$j] = 0;   //Valor total do Item para Calculo da ST
            $avalitemb[$j] = 0;   //Valor total do item para Calculo da ST + Icms Normal
            $avalipia[$j] = 0;   //Valor total do IPI para Calculo da ST
            $avalipib[$j] = 0;   //Valor total do IPI para Calculo da ST + Icms Normal
            $avalipic[$j] = 0;   //Valor total do IPI para Calculo da ST
            $avaldesa[$j] = 0;   //Valor total do Desconto para Calculo da ST
            $avaldesb[$j] = 0;   //Valor total do Desconto para da ST + Icms Normal
            $avalliqa[$j] = 0;   //Valor total Liquido para Calculo da ST
            $avalliqb[$j] = 0;   //Valor total Liquido para Calculo da ST + Icms Normal
        }

        $pegariva = "SELECT * FROM iva order by ivacodigo";

        $cadiva = pg_query($pegariva);
        $rowiva = pg_num_rows($cadiva);

        if ($rowiva) {
            for ($iiva = 0; $iiva < $rowiva; $iiva++) {
                $iva = pg_result($cadiva, $iiva, "ivacodigo");
                $periva = pg_result($cadiva, $iiva, "ivaperc");

                $mgiva = trim(pg_result($cadiva, $iiva, "ivamg"));
                $baiva = trim(pg_result($cadiva, $iiva, "ivaba"));
                $rsiva = trim(pg_result($cadiva, $iiva, "ivars"));
                $peiva = trim(pg_result($cadiva, $iiva, "ivape"));

                $aperiva[$iva] = $periva;

                $amgiva[$iva] = $mgiva;
                $abaiva[$iva] = $baiva;
                $arsiva[$iva] = $rsiva;
                $apeiva[$iva] = $peiva;
            }
        }




        /*
          $sql = "SELECT
          a.pvcomissao as comissao
          ,a.pvcomistp
          ,a.pvperdesc
          ,a.clicodigo
          from  pvenda a
          Where a.pvnumero = '$parametro'
          ORDER BY a.pvnumero";
         */

        $sql = "SELECT
		a.pvcomissao as comissao
		,a.pvcomistp
		,a.pvperdesc
		,a.pvperdesc1,a.pvperdesc2
		,c.uf
		,a.pvvaldesc
		,a.pvtipoped
		,clientes.clioptsimples
		from  pvenda a
		LEFT JOIN cliefat as b on a.clicodigo = b.clicodigo
		LEFT JOIN cidades as c on b.cidcodigo = c.cidcodigo
		LEFT JOIN clientes on a.clicodigo  = clientes.clicodigo
		Where a.pvnumero = '$parametro'
		ORDER BY a.pvnumero";

        //EXECUTA A QUERY
        $sql = pg_query($sql);

        $row = pg_num_rows($sql);

        if ($row) {

            //XML
            $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
            $xml .= "<dados>\n";

            //PERCORRE ARRAY
            for ($i = 0; $i < $row; $i++) {


                $comissao = pg_result($sql, $i, "comissao");
                $pvperdesc = pg_result($sql, $i, "pvperdesc");
                $pvperdesc1 = pg_result($sql, $i, "pvperdesc1");
                $pvperdesc2 = pg_result($sql, $i, "pvperdesc2");

                //Se o Desconto do pedido estiver preenchido ele será usado
                if ($pvperdesc != '' && $pvperdesc != '0') {
                    if (($pvperdesc1 == '' || $pvperdesc1 == '0') && ($pvperdesc2 == '' || $pvperdesc2 == '0')) {
                        $pvperdesc2 = $pvperdesc;
                    }
                }

                $pvcomistp = pg_result($sql, $i, "pvcomistp");
                $cliest = pg_result($sql, $i, "uf");
                $optanteSimples = (pg_result($sql, $i, "clioptsimples") === 't') ? true : false;
                $pvvaldesc = pg_result($sql, $i, "pvvaldesc");
                $pvtipoped = trim(pg_result($sql, $i, "pvtipoped"));


                if (trim($comissao) == "") {
                    $comissao = "100";
                }
                if (trim($comissao) == "0") {
                    $comissao = "100";
                }
                if (trim($pvperdesc) == "") {
                    $pvperdesc = "0";
                }
                if (trim($pvcomistp) == "") {
                    $pvcomistp = "0";
                }
                if (trim($pvvaldesc) == "") {
                    $pvvaldesc = "0";
                }



                $notvalor = 0;
                $substituicao = 0;


                $sql1 = "
				SELECT *
				FROM  pvitem a
				WHERE pvnumero = '$parametro' and pvisaldo<>0";
                $sql1 = pg_query($sql1);
                $row1 = pg_num_rows($sql1);

                if ($row1) {

                    $j1 = 1;
                    $k1 = 1;
                    for ($i1 = 0; $i1 < $row1; $i1++) {

                        if ($j1 > $itensnota) {
                            $notnumero++;
                            $j1 = 1;
                            $k1++;
                            $seqnum = 0;
                        }

                        $pvicodigo = pg_result($sql1, $i1, "pvicodigo");
                        $pvitem = pg_result($sql1, $i1, "pvitem");
                        $procodigo = pg_result($sql1, $i1, "procodigo");
                        $pvipreco = pg_result($sql1, $i1, "pvipreco");
                        $pvisaldo = pg_result($sql1, $i1, "pvisaldo");

                        if (trim($pvicodigo) == "") {
                            $pvicodigo = "0";
                        }
                        if (trim($pvitem) == "") {
                            $pvitem = "0";
                        }
                        if (trim($procodigo) == "") {
                            $procodigo = "0";
                        }
                        if (trim($pvipreco) == "") {
                            $pvipreco = "0";
                        }
                        if (trim($pvisaldo) == "") {
                            $pvisaldo = "0";
                        }

                        $seqnum++;

                        $pvcomissao = $comissao;

                        if ($pvcomistp == "1") {
                            $pvipreco = $pvipreco * $pvcomissao / 100;
                        }
                        if ($pvcomistp == "2") {
                            $pvisaldo = $pvisaldo * $pvcomissao / 100;
                            $pvisaldo = ceil($pvisaldo);
                        }
                        if ($pvcomistp == "3") {

                            $sqlp = "
							SELECT profinal
							FROM  produto a
							WHERE procodigo = '$procodigo'";

                            $sqlp = pg_query($sqlp);
                            $rowp = pg_num_rows($sqlp);

                            if ($rowp) {
                                $profinal = pg_result($sqlp, 0, "profinal");
                            }

                            if ($icms >= "18") {
                                $pvipreco = $profinal * 1.1;
                            } else if ($icms >= "12") {
                                $pvipreco = $profinal * 1.5;
                            } else {
                                $pvipreco = $profinal;
                            }
                        }

                        $pvipreco = round($pvipreco, 2);

                        $totalitem = ($pvipreco * $pvisaldo);
                        $notvalor = $notvalor + $totalitem;
                    }


                    if ($pvperdesc <> 0) {

                        $desconto = $notvalor / 100 * $pvperdesc;

                        $notvalor = $notvalor - $desconto;

                        $notvalor = round($notvalor, 2);
                    }

                    /*
                      if ($pvvaldesc<>0){

                      $notvalor=$notvalor-$pvvaldesc;

                      $notvalor=round($notvalor,2);
                      }
                     */
                }


                //Faz todo o processamento para saber se haverá valor de Substituição
                $substituicao = 0;


                $notvalor1 = 0;
                $notvalor2 = 0;

                //Zera os totais de itens
                for ($j = 1; $j <= 1000; $j++) {
                    $avalitema[$j] = 0;
                    $avalitemb[$j] = 0;
                    $avalipia[$j] = 0;
                    $avalipib[$j] = 0;
                    $avalipic[$j] = 0;
                    $avaldesa[$j] = 0;
                    $avaldesb[$j] = 0;
                    $avalliqa[$j] = 0;
                    $avalliqb[$j] = 0;
                }

                $notipi = 0;
                $notipi02 = 0;

                $notbasipi = 0;

                if ($cliest == '') {
                    $cliest = 'SP';
                }

                //Pedidos Indutria não vao ter a S.T.
                if ($pvtipoped == 'R' || $pvtipoped == 'I' || $pvtipoped == 'Y') {
                    //Verifica o CFOP

                    /*
                      if($natcodigo=='5.119' || $natcodigo=='6.119' || $natcodigo=='5.922' || $natcodigo=='5.923' || $natcodigo=='6.922' || $natcodigo=='6.923' || $natcodigo=='6.102'){
                      $cliest='XX';
                      }
                     */
                }

                //Se Cliente de Minas o Cálculo de Substituição será diferente
                if ($cliest == 'MG' || $cliest == 'BA' || $cliest == 'RJ' || $cliest == 'SC' || $cliest == 'PE') {

                    $pegarsubs = "SELECT a.pvicodigo,b.procod,b.proref,b.prnome,a.pvipreco,a.pvisaldo
					,b.tricodigo,b.trbcodigo,c.medsigla,d.claipi,b.propeso,d.clast as proicms,d.claiva,b.proprocedencia,b.prosubs,d.clanumero,b.grucodigo
					FROM pvitem a,medidas c,produto b
					LEFT JOIN clfiscal as d on b.clacodigo = d.clacodigo
					WHERE a.pvnumero = '$parametro' and a.pvisaldo<>0
					AND a.procodigo = b.procodigo
					AND c.medcodigo = b.medcodigo
					order by a.pvitem
					";

                    $cadsubs = pg_query($pegarsubs);
                    $rowsubs = pg_num_rows($cadsubs);

                    $subs1 = 0;
                    $subs2 = 0;

                    if ($rowsubs) {


                        for ($isubs = 0; $isubs < $rowsubs; $isubs++) {

                            $procod = trim(pg_result($cadsubs, $isubs, "procod"));
                            $proref = trim(pg_result($cadsubs, $isubs, "proref"));
                            $prnome = trim(pg_result($cadsubs, $isubs, "prnome"));
                            $pvipreco = trim(pg_result($cadsubs, $isubs, "pvipreco"));
                            $pvisaldo = trim(pg_result($cadsubs, $isubs, "pvisaldo"));

                            $tricodigo = trim(pg_result($cadsubs, $isubs, "tricodigo"));
                            $trbcodigo = trim(pg_result($cadsubs, $isubs, "trbcodigo"));
                            $medsigla = trim(pg_result($cadsubs, $isubs, "medsigla"));
                            $ipi = trim(pg_result($cadsubs, $isubs, "claipi"));

                            $ndicodigo = trim(pg_result($cadsubs, $isubs, "pvicodigo"));

                            $proauxicms = trim(pg_result($cadsubs, $isubs, "proicms"));


                            if ($proauxicms == "") {
                                $proicms = "2";
                            } else {
                                if ($proauxicms == "N") {
                                    $proicms = "1";
                                } else {
                                    $proicms = "2";
                                }
                            }

                            $proauxsubs = trim(pg_result($cadsubs, $isubs, "prosubs"));

                            if ($proauxsubs == "0") {
                                $prosubs = "2";
                            } else {
                                $prosubs = $proauxsubs;
                            }

                            //Campo será sempre 1 para incluir a Substituição no Total da Nota
                            $prosubs = "1";

                            $proauxiva = trim(pg_result($cadsubs, $isubs, "claiva"));
                            $grucodigo = trim(pg_result($cadsubs, $isubs, "grucodigo"));

                            if ($proauxiva == "") {

                                if ($grucodigo == 2) {
                                    $proiva = "3";
                                } else {
                                    $proiva = "1";
                                }
                            } else {
                                $proiva = $proauxiva;
                            }

                            //Se for de PE, verifica se tem decreto, caso sim
                            //tem S.T., caso não, não terá o cálculo de S.T.
                            if ($cliest == 'PE') {
                                if ($apeiva[$proiva] == '') {
                                    $proicms = "1";
                                }
                            }

                            if (trim($proicms) == "1") {
                                $subs2 = $subs2 + 1;
                            } else {
                                $subs1 = $subs1 + 1;
                            }

                            //Se for de outro estado o ICMS será normal
                            /*
                              if($cliest<>'SP'){
                              $proicms = "1";
                              $proiva = "1";
                              $prosubs = "2";
                              }
                             */

                            $proprocedencia = trim(pg_result($cadsubs, $isubs, "proprocedencia"));

                            //Preco tera que ser de acordo com a Comissao
                            if (trim($pvipreco) == "") {
                                $pvipreco = "0";
                            }
                            if (trim($pvisaldo) == "") {
                                $pvisaldo = "0";
                            }


                            $pvcomissao = $comissao;

                            if ($pvcomistp == "1") {
                                $pvipreco = $pvipreco * $pvcomissao / 100;
                            }
                            if ($pvcomistp == "2") {
                                $pvisaldo = $pvisaldo * $pvcomissao / 100;
                                $pvisaldo = ceil($pvisaldo);
                            }
                            if ($pvcomistp == "3") {

                                $sqlp = "
								SELECT profinal
								FROM  produto a
								WHERE procodigo = '$procodigo'";

                                $sqlp = pg_query($sqlp);
                                $rowp = pg_num_rows($sqlp);

                                if ($rowp) {
                                    $profinal = pg_result($sqlp, 0, "profinal");
                                }

                                if ($icms >= "18") {
                                    $pvipreco = $profinal * 1.1;
                                } else if ($icms >= "12") {
                                    $pvipreco = $profinal * 1.5;
                                } else {
                                    $pvipreco = $profinal;
                                }
                            }

                            $pvipreco = round($pvipreco, 2);



                            if (trim($proprocedencia) == "4" || trim($proprocedencia) == "5") {
                                
                            } else {
                                $ipi = 0;
                            }

                            //-----Se a natureza for xxx ipi = 0
                            /*
                              if (trim($natcodigo)=='5.905')
                              {
                              $ipi=0;
                              }
                             */

                            $pviipi_b = 0;

                            if ($ipi > 0) {

                                if ($pvperdesc1 > 0) {

                                    $pviprecoaux = $pvipreco - ($pvipreco / 100 * $pvperdesc1);

                                    $auxtotal = round($pviprecoaux * $pvisaldo, 2);

                                    $pviprecoaux = round($pviprecoaux / (1 + $ipi / 100), 4);

                                    $totalitem_b = Round(Round($pviprecoaux, 4) * $pvisaldo, 2);

                                    $pviipi_b = $auxtotal - $totalitem_b;
                                }


                                $auxtotal = $pvipreco * $pvisaldo;

                                $pvipreco = round($pvipreco / (1 + $ipi / 100), 4);

                                $totalitem = Round($pvipreco * $pvisaldo, 2);

                                $pviipi = $auxtotal - $totalitem;

                                $pvipreco = Round($pvipreco, 2);
                                //sprintf("%01.2f",Round($prpre,2))

                                $notipi = $notipi + $pviipi;
                                $notbasipi = $notbasipi + $totalitem;

                                //Alterei Aqui !!!
                                if (trim($proicms) == "1") {
                                    $notipi02 = $notipi02 + $pviipi;
                                }
                                //Se For Icms Substituição Verifica se deve ser IVA 1 (44%) ou 2 (47%)
                                else {

                                    $avalipia[$proiva] = $avalipia[$proiva] + $pviipi;
                                    $avalipic[$proiva] = $avalipic[$proiva] + $pviipi_b;

                                    //Se for um produto importado vai calcular Icms Normal e ICMS Substituição
                                    if ($prosubs == "1") {

                                        $notipi02 = $notipi02 + $pviipi;
                                        $avalipib[$proiva] = $avalipib[$proiva] + $pviipi;
                                    }
                                }
                            } else {
                                $totalitem = ($pvipreco * $pvisaldo);
                                $ipi = "";
                                $pviipi = "";
                            }

                            $notvalor1 = $notvalor1 + $totalitem;

                            if (trim($proicms) == "1") {
                                $notvalor2 = $notvalor2 + $totalitem;
                            }
                            //Se For Icms Substituição Verifica se deve ser IVA 1 (44%) ou 2 (47%)
                            else {

                                $avalitema[$proiva] = $avalitema[$proiva] + $totalitem;

                                //Se for um produto importado vai calcular Icms Normal e ICMS Substituição
                                if ($prosubs == "1") {

                                    $notvalor2 = $notvalor2 + $totalitem;

                                    $avalitemb[$proiva] = $avalitemb[$proiva] + $totalitem;
                                }
                            }
                        }
                    }

                    if ($subs1 > 0) {
                        if ($subs2 == 0) {
                            $cfop = '2';
                        } else {
                            $cfop = '3';
                        }
                    }

                    if ($notvalor1 > 0) {
                        $desconto = ($notvalor1 + $notipi) / 100 * $pvperdesc;
                        $desconto = round($desconto, 2);

                        $desconto02 = ($notvalor2 + $notipi02) / 100 * $pvperdesc;
                        $desconto02 = round($desconto02, 2);

                        //Calcula os Descontos
                        for ($j = 1; $j <= 1000; $j++) {
                            if ($avalitema[$j] + $avalipia[$j] > 0) {
                                $avaldesa[$j] = ($avalitema[$j] + $avalipia[$j]) / 100 * $pvperdesc;
                                $avaldesa[$j] = round($avaldesa[$j], 2);
                            }
                        }

                        //Calcula os Descontos
                        for ($j = 1; $j <= 1000; $j++) {
                            if ($avalitemb[$j] + $avalipib[$j] > 0) {
                                $avaldesb[$j] = ($avalitemb[$j] + $avalipib[$j]) / 100 * $pvperdesc;
                                $avaldesb[$j] = round($avaldesb[$j], 2);
                            }
                        }

                        $notvalorliq = $notvalor1 - $desconto;

                        //Aqui
                        $notvalorliq2 = $notvalor2 - $desconto02;
                        //$notvalorliq2=$desconto02;
                        //Valor Liquido do Item
                        for ($j = 1; $j <= 1000; $j++) {
                            if ($avalitema[$j] > 0) {
                                $avalliqa[$j] = $avalitema[$j] - $avaldesa[$j];
                            }
                        }
                        //echo "\n avalitemb: $avalitemb\n";
                        //print_r($avalitemb);
                        //Valor Liquido do Item
                        for ($j = 1; $j <= 1000; $j++) {
                            if ($avalitemb[$j] + $avalipib[$j] > 0) {
                                //echo "avalitemb[$j] + avalipib[$j] > 0 == true\n";
                                $avalliqb[$j] = $avalitemb[$j] - $avaldesb[$j] + $avalipib[$j];
                            }
                        }

                        //Origem = São Paulo
                        if ($parametro2 == 1) {

                            if ($cliest == 'MG') {

                                $noticmsivanovo = 0;
                                //Valor Liquido do Item
                                for ($j = 1; $j <= 1000; $j++) {
                                    if ($avalliqb[$j] > 0) {
                                        $mva = 1 + ($aperiva[$j] / 100);
                                        $mvb = ((12 / 100) - 1) / ((18 / 100) - 1);
                                        $mvc = (($mva * $mvb) - 1) * 100;
                                        $mvd = (1000 * 12 / 100);
                                        $mve = 1000 + (1000 * $mvc / 100);
                                        $mvf = $mve * 18 / 100;
                                        $mvg = ($mvf - $mvd) * 0.001;
                                        $noticmsiva = $avalliqb[$j] * $mvg;
                                        $noticmsivanovo = $noticmsivanovo + $noticmsiva;
                                    }
                                }
                            } else if ($cliest == 'BA' || $cliest == 'PE') {

                                //echo "\n avalliqb $avalliqb\n";
                                //print_r($avalliqb);
                                $noticmsivanovo = 0;
                                //Valor Liquido do Item
                                for ($j = 1; $j <= 1000; $j++) {
                                    if ($avalliqb[$j] > 0) {
                                        $mva = 1 + ($aperiva[$j] / 100);
                                        $mvb = ((7 / 100) - 1) / ((17 / 100) - 1);
                                        $mvc = (($mva * $mvb) - 1) * 100;
                                        $mvd = (1000 * 7 / 100);
                                        $mve = 1000 + (1000 * $mvc / 100);
                                        $mvf = $mve * 17 / 100;
                                        $mvg = ($mvf - $mvd) * 0.001;
                                        $noticmsiva = $avalliqb[$j] * $mvg;
                                        $noticmsivanovo = $noticmsivanovo + $noticmsiva;

                                        //print "\n mva: $mva\n";
                                        //print "\n mvb: $mvb\n";
                                        //print "\n mvc: $mvc\n";
                                        //print "\n mvd: $mvd\n";
                                        //print "\n mve: $mve\n";
                                        //print "\n mvf: $mvf\n";
                                        //print "\n mvg: $mvg\n";
                                        //print "\n noticmsiva: $noticmsiva\n";
                                        //print "\n noticmsivanovo: $noticmsivanovo\n";
                                    }
                                }
                            } else if ($cliest == 'RJ') {

                                $noticmsivanovo = 0;
                                //Valor Liquido do Item
                                for ($j = 1; $j <= 1000; $j++) {
                                    if ($avalliqb[$j] > 0) {
                                        $mva = 1 + ($aperiva[$j] / 100);
                                        $mvb = ((12 / 100) - 1) / ((19 / 100) - 1);
                                        $mvc = (($mva * $mvb) - 1) * 100;
                                        $mvd = (1000 * 12 / 100);
                                        $mve = 1000 + (1000 * $mvc / 100);
                                        $mvf = $mve * 19 / 100;
                                        $mvg = ($mvf - $mvd) * 0.001;
                                        $noticmsiva = $avalliqb[$j] * $mvg;
                                        $noticmsivanovo = $noticmsivanovo + $noticmsiva;
                                    }
                                }
                            } else if ($cliest == 'SC') {

                                //Calculo Novo
                                //Lers - 24/05/2012
                                //echo "optanteSimples: ".$optanteSimples . "\n";
                                $noticmsivanovo = 0;

                                //Valor Liquido do Item
                                for ($j = 1; $j <= 1000; $j++) {

                                    if ($avalliqa[$j] > 0) {

                                        //Fase 1 - Calcula o ICMS usando a aliquota Interestadual sobre o valor sem o IPI
                                        //$scIcms = $avalliqa[$j] * 0.12;
                                        if ($avalipic[$j] > 0) {
                                            $scIcms = ($avalliqb[$j] - $avalipic[$j]) * 0.12;
                                        } else {
                                            $scIcms = $avalliqa[$j] * 0.12;
                                        }


                                        //Fase 2 - Calcula a MVA Ajsutada
                                        //Optante pelo simples o IVA será sempre 17.1
                                        if ($optanteSimples == true) {
                                            $mva = 1 + (17.1 / 100);
                                        } else {
                                            $mva = 1 + ($aperiva[$j] / 100);
                                        }
                                        $mvb = ((12 / 100) - 1) / ((17 / 100) - 1);
                                        $mvc = (($mva * $mvb) - 1) * 100;

                                        //Fase 3 - Calcula a Base ST do valor com o IPI
                                        $scBasest = $avalliqb[$j] + ($avalliqb[$j] * $mvc / 100);

                                        //Fase 4 - Calcula o ICMS ST com a aliquota de 17%
                                        $scValst = $scBasest * 0.17;

                                        //Fase 5 - Calcula o ICMS ST substraindo o valor do ICMS original
                                        $noticmsiva = $scValst - $scIcms;

                                        $noticmsivanovo = $noticmsivanovo + $noticmsiva;
                                    }
                                }

                                //Lers - 24/05/2012
                            }
                        }

                        //Origem = Vix
                        else if ($parametro2 == 2) {

                            if ($cliest == 'MG') {

                                /*
                                  $noticmsivanovo = 0;
                                  //Valor Liquido do Item
                                  for ($j = 1; $j <= 1000; $j++) {
                                  if ($avalliqb[$j] > 0) {
                                  $mva = 1 + ($aperiva[$j] / 100);
                                  $mvb = ((12 / 100) - 1) / ((18 / 100) - 1);
                                  $mvc = (($mva * $mvb) - 1) * 100;
                                  $mvd = (1000 * 12 / 100);
                                  $mve = 1000 + (1000 * $mvc / 100);
                                  $mvf = $mve * 18 / 100;
                                  $mvg = ($mvf - $mvd) * 0.001;
                                  $noticmsiva = $avalliqb[$j] * $mvg;
                                  $noticmsivanovo = $noticmsivanovo + $noticmsiva;
                                  }
                                  }
                                 */

                                //Calculo Novo
                                //echo "optanteSimples: ".$optanteSimples . "\n";
                                $noticmsivanovo = 0;

                                //Valor Liquido do Item
                                for ($j = 1; $j <= 1000; $j++) {

                                    if ($avalliqa[$j] > 0) {

                                        //Fase 1 - Calcula o ICMS usando a aliquota Interestadual sobre o valor sem o IPI
                                        //$scIcms = $avalliqa[$j] * 0.12;
                                        if ($avalipic[$j] > 0) {
                                            $scIcms = ($avalliqb[$j] - $avalipic[$j]) * 0.12;
                                        } else {
                                            $scIcms = $avalliqa[$j] * 0.12;
                                        }

                                        //Fase 2 - Calcula a MVA Ajsutada
                                        //Optante pelo simples o IVA será sempre 17.1
                                        //if ($optanteSimples == true) {
                                        //	$mva = 1 + (17.1 / 100);
                                        //}
                                        //else {
                                        $mva = 1 + ($aperiva[$j] / 100);
                                        //}
                                        $mvb = ((12 / 100) - 1) / ((18 / 100) - 1);
                                        $mvc = (($mva * $mvb) - 1) * 100;

                                        //Fase 3 - Calcula a Base ST do valor com o IPI
                                        $scBasest = $avalliqb[$j] + ($avalliqb[$j] * $mvc / 100);

                                        //Fase 4 - Calcula o ICMS ST com a aliquota de 18%
                                        $scValst = $scBasest * 0.18;

                                        //Fase 5 - Calcula o ICMS ST substraindo o valor do ICMS original
                                        $noticmsiva = $scValst - $scIcms;

                                        $noticmsivanovo = $noticmsivanovo + $noticmsiva;
                                    }
                                }
                            } else if ($cliest == 'BA') {

                                /*
                                  $noticmsivanovo = 0;
                                  //Valor Liquido do Item
                                  for ($j = 1; $j <= 1000; $j++) {
                                  if ($avalliqb[$j] > 0) {
                                  $mva = 1 + ($aperiva[$j] / 100);
                                  $mvb = ((12 / 100) - 1) / ((17 / 100) - 1);
                                  $mvc = (($mva * $mvb) - 1) * 100;
                                  $mvd = (1000 * 12 / 100);
                                  $mve = 1000 + (1000 * $mvc / 100);
                                  $mvf = $mve * 17 / 100;
                                  $mvg = ($mvf - $mvd) * 0.001;
                                  $noticmsiva = $avalliqb[$j] * $mvg;
                                  $noticmsivanovo = $noticmsivanovo + $noticmsiva;
                                  }
                                  }
                                 */

                                //Calculo Novo
                                //echo "optanteSimples: ".$optanteSimples . "\n";
                                $noticmsivanovo = 0;

                                //Valor Liquido do Item
                                for ($j = 1; $j <= 1000; $j++) {

                                    if ($avalliqa[$j] > 0) {

                                        //Fase 1 - Calcula o ICMS usando a aliquota Interestadual sobre o valor sem o IPI
                                        //$scIcms = $avalliqa[$j] * 0.12;
                                        if ($avalipic[$j] > 0) {
                                            $scIcms = ($avalliqb[$j] - $avalipic[$j]) * 0.12;
                                        } else {
                                            $scIcms = $avalliqa[$j] * 0.12;
                                        }

                                        //Fase 2 - Calcula a MVA Ajsutada
                                        //Optante pelo simples o IVA será sempre 17.1
                                        //if ($optanteSimples == true) {
                                        //	$mva = 1 + (17.1 / 100);
                                        //}
                                        //else {
                                        $mva = 1 + ($aperiva[$j] / 100);
                                        //}
                                        $mvb = ((12 / 100) - 1) / ((17 / 100) - 1);
                                        $mvc = (($mva * $mvb) - 1) * 100;

                                        //Fase 3 - Calcula a Base ST do valor com o IPI
                                        $scBasest = $avalliqb[$j] + ($avalliqb[$j] * $mvc / 100);

                                        //Fase 4 - Calcula o ICMS ST com a aliquota de 17%
                                        $scValst = $scBasest * 0.17;

                                        //Fase 5 - Calcula o ICMS ST substraindo o valor do ICMS original
                                        $noticmsiva = $scValst - $scIcms;

                                        $noticmsivanovo = $noticmsivanovo + $noticmsiva;
                                    }
                                }
                            } else if ($cliest == 'PE') {

                                //$noticmsivanovo = 0;
                                //Calculo Novo
                                //echo "optanteSimples: ".$optanteSimples . "\n";
                                $noticmsivanovo = 0;

                                //Valor Liquido do Item
                                for ($j = 1; $j <= 1000; $j++) {

                                    if ($avalliqa[$j] > 0) {

                                        //Fase 1 - Calcula o ICMS usando a aliquota Interestadual sobre o valor sem o IPI
                                        //$scIcms = $avalliqa[$j] * 0.12;
                                        if ($avalipic[$j] > 0) {
                                            $scIcms = ($avalliqb[$j] - $avalipic[$j]) * 0.12;
                                        } else {
                                            $scIcms = $avalliqa[$j] * 0.12;
                                        }

                                        //Fase 2 - Calcula a MVA Ajsutada
                                        //Optante pelo simples o IVA será sempre 17.1
                                        //if ($optanteSimples == true) {
                                        //	$mva = 1 + (17.1 / 100);
                                        //}
                                        //else {
                                        $mva = 1 + ($aperiva[$j] / 100);
                                        //}
                                        $mvb = ((12 / 100) - 1) / ((17 / 100) - 1);
                                        $mvc = (($mva * $mvb) - 1) * 100;

                                        //Fase 3 - Calcula a Base ST do valor com o IPI
                                        $scBasest = $avalliqb[$j] + ($avalliqb[$j] * $mvc / 100);

                                        //Fase 4 - Calcula o ICMS ST com a aliquota de 17%
                                        $scValst = $scBasest * 0.17;

                                        //Fase 5 - Calcula o ICMS ST substraindo o valor do ICMS original
                                        $noticmsiva = $scValst - $scIcms;

                                        $noticmsivanovo = $noticmsivanovo + $noticmsiva;
                                    }
                                }
                            } else if ($cliest == 'RJ') {

                                /*
                                  $noticmsivanovo = 0;
                                  //Valor Liquido do Item
                                  for ($j = 1; $j <= 1000; $j++) {
                                  if ($avalliqb[$j] > 0) {
                                  $mva = 1 + ($aperiva[$j] / 100);
                                  $mvb = ((12 / 100) - 1) / ((19 / 100) - 1);
                                  $mvc = (($mva * $mvb) - 1) * 100;
                                  $mvd = (1000 * 12 / 100);
                                  $mve = 1000 + (1000 * $mvc / 100);
                                  $mvf = $mve * 19 / 100;
                                  $mvg = ($mvf - $mvd) * 0.001;
                                  $noticmsiva = $avalliqb[$j] * $mvg;
                                  $noticmsivanovo = $noticmsivanovo + $noticmsiva;
                                  }
                                  }
                                 */

                                //Calculo Novo
                                //echo "optanteSimples: ".$optanteSimples . "\n";
                                $noticmsivanovo = 0;

                                //Valor Liquido do Item
                                for ($j = 1; $j <= 1000; $j++) {

                                    if ($avalliqa[$j] > 0) {

                                        //Fase 1 - Calcula o ICMS usando a aliquota Interestadual sobre o valor sem o IPI
                                        //$scIcms = $avalliqa[$j] * 0.12;
                                        if ($avalipic[$j] > 0) {
                                            $scIcms = ($avalliqb[$j] - $avalipic[$j]) * 0.12;
                                        } else {
                                            $scIcms = $avalliqa[$j] * 0.12;
                                        }

                                        //Fase 2 - Calcula a MVA Ajsutada
                                        //Optante pelo simples o IVA será sempre 17.1
                                        //if ($optanteSimples == true) {
                                        //	$mva = 1 + (17.1 / 100);
                                        //}
                                        //else {
                                        $mva = 1 + ($aperiva[$j] / 100);
                                        //}

                                        $mvb = ((12 / 100) - 1) / ((19 / 100) - 1);
                                        $mvc = (($mva * $mvb) - 1) * 100;

                                        //Fase 3 - Calcula a Base ST do valor com o IPI
                                        $scBasest = $avalliqb[$j] + ($avalliqb[$j] * $mvc / 100);

                                        //Fase 4 - Calcula o ICMS ST com a aliquota de 19%
                                        $scValst = $scBasest * 0.19;

                                        //Fase 5 - Calcula o ICMS ST substraindo o valor do ICMS original
                                        $noticmsiva = $scValst - $scIcms;

                                        $noticmsivanovo = $noticmsivanovo + $noticmsiva;
                                    }
                                }
                            } else if ($cliest == 'SC') {

                                //Calculo Novo
                                //Lers - 24/05/2012
                                //echo "optanteSimples: ".$optanteSimples . "\n";
                                $noticmsivanovo = 0;

                                //Valor Liquido do Item
                                for ($j = 1; $j <= 1000; $j++) {

                                    if ($avalliqa[$j] > 0) {

                                        //Fase 1 - Calcula o ICMS usando a aliquota Interestadual sobre o valor sem o IPI
                                        //$scIcms = $avalliqa[$j] * 0.12;
                                        if ($avalipic[$j] > 0) {
                                            $scIcms = ($avalliqb[$j] - $avalipic[$j]) * 0.12;
                                        } else {
                                            $scIcms = $avalliqa[$j] * 0.12;
                                        }

                                        //Fase 2 - Calcula a MVA Ajsutada
                                        //Optante pelo simples o IVA será sempre 17.1
                                        if ($optanteSimples == true) {
                                            $mva = 1 + (17.1 / 100);
                                        } else {
                                            $mva = 1 + ($aperiva[$j] / 100);
                                        }
                                        $mvb = ((12 / 100) - 1) / ((17 / 100) - 1);
                                        $mvc = (($mva * $mvb) - 1) * 100;

                                        //Fase 3 - Calcula a Base ST do valor com o IPI
                                        $scBasest = $avalliqb[$j] + ($avalliqb[$j] * $mvc / 100);

                                        //Fase 4 - Calcula o ICMS ST com a aliquota de 17%
                                        $scValst = $scBasest * 0.17;

                                        //Fase 5 - Calcula o ICMS ST substraindo o valor do ICMS original
                                        $noticmsiva = $scValst - $scIcms;

                                        $noticmsivanovo = $noticmsivanovo + $noticmsiva;
                                    }
                                }

                                //Lers - 24/05/2012
                            }
                        }


                        if ($noticmsivanovo > 0) {

                            $substituicao = round($noticmsivanovo, 2);
                            $notvalor = $notvalor + $substituicao;
                        }
                    }
                }

                //Se Cliente do Rio Grande do Sul o Cálculo de Substituição será diferente
                else if ($cliest == 'RS') {

                    $pegarsubs = "SELECT a.pvicodigo,b.procod,b.proref,b.prnome,a.pvipreco,a.pvisaldo
					,b.tricodigo,b.trbcodigo,c.medsigla,d.claipi,b.propeso,d.clast as proicms,d.claiva,b.proprocedencia,b.prosubs,d.clanumero,b.grucodigo
					FROM pvitem a,medidas c,produto b
					LEFT JOIN clfiscal as d on b.clacodigo = d.clacodigo
					WHERE a.pvnumero = '$parametro' and a.pvisaldo<>0
					AND a.procodigo = b.procodigo
					AND c.medcodigo = b.medcodigo
					order by a.pvitem
					";

                    $cadsubs = pg_query($pegarsubs);
                    $rowsubs = pg_num_rows($cadsubs);

                    $subs1 = 0;
                    $subs2 = 0;

                    if ($rowsubs) {


                        for ($isubs = 0; $isubs < $rowsubs; $isubs++) {

                            $procod = trim(pg_result($cadsubs, $isubs, "procod"));
                            $proref = trim(pg_result($cadsubs, $isubs, "proref"));
                            $prnome = trim(pg_result($cadsubs, $isubs, "prnome"));
                            $pvipreco = trim(pg_result($cadsubs, $isubs, "pvipreco"));
                            $pvisaldo = trim(pg_result($cadsubs, $isubs, "pvisaldo"));

                            $tricodigo = trim(pg_result($cadsubs, $isubs, "tricodigo"));
                            $trbcodigo = trim(pg_result($cadsubs, $isubs, "trbcodigo"));
                            $medsigla = trim(pg_result($cadsubs, $isubs, "medsigla"));
                            $ipi = trim(pg_result($cadsubs, $isubs, "claipi"));

                            $ndicodigo = trim(pg_result($cadsubs, $isubs, "pvicodigo"));

                            $proauxicms = trim(pg_result($cadsubs, $isubs, "proicms"));


                            if ($proauxicms == "") {
                                $proicms = "2";
                            } else {
                                if ($proauxicms == "N") {
                                    $proicms = "1";
                                } else {
                                    $proicms = "2";
                                }
                            }

                            if (trim($proicms) == "1") {
                                $subs2 = $subs2 + 1;
                            } else {
                                $subs1 = $subs1 + 1;
                            }

                            $proauxsubs = trim(pg_result($cadsubs, $isubs, "prosubs"));

                            if ($proauxsubs == "0") {
                                $prosubs = "2";
                            } else {
                                $prosubs = $proauxsubs;
                            }

                            //Campo será sempre 1 para incluir a Substituição no Total da Nota
                            $prosubs = "1";

                            $proauxiva = trim(pg_result($cadsubs, $isubs, "claiva"));
                            $grucodigo = trim(pg_result($cadsubs, $isubs, "grucodigo"));

                            if ($proauxiva == "") {

                                if ($grucodigo == 2) {
                                    $proiva = "3";
                                } else {
                                    $proiva = "1";
                                }
                            } else {
                                $proiva = $proauxiva;
                            }

                            //Se for de outro estado o ICMS será normal
                            /*
                              if($cliest<>'SP'){
                              $proicms = "1";
                              $proiva = "1";
                              $prosubs = "2";
                              }
                             */

                            $proprocedencia = trim(pg_result($cadsubs, $isubs, "proprocedencia"));

                            //Preco tera que ser de acordo com a Comissao
                            if (trim($pvipreco) == "") {
                                $pvipreco = "0";
                            }
                            if (trim($pvisaldo) == "") {
                                $pvisaldo = "0";
                            }


                            $pvcomissao = $comissao;

                            if ($pvcomistp == "1") {
                                $pvipreco = $pvipreco * $pvcomissao / 100;
                            }
                            if ($pvcomistp == "2") {
                                $pvisaldo = $pvisaldo * $pvcomissao / 100;
                                $pvisaldo = ceil($pvisaldo);
                            }
                            if ($pvcomistp == "3") {

                                $sqlp = "
								SELECT profinal
								FROM  produto a
								WHERE procodigo = '$procodigo'";

                                $sqlp = pg_query($sqlp);
                                $rowp = pg_num_rows($sqlp);

                                if ($rowp) {
                                    $profinal = pg_result($sqlp, 0, "profinal");
                                }

                                if ($icms >= "18") {
                                    $pvipreco = $profinal * 1.1;
                                } else if ($icms >= "12") {
                                    $pvipreco = $profinal * 1.5;
                                } else {
                                    $pvipreco = $profinal;
                                }
                            }

                            $pvipreco = round($pvipreco, 2);



                            if (trim($proprocedencia) == "4" || trim($proprocedencia) == "5") {
                                
                            } else {
                                $ipi = 0;
                            }

                            //-----Se a natureza for xxx ipi = 0
                            /*
                              if (trim($natcodigo)=='5.905')
                              {
                              $ipi=0;
                              }
                             */

                            $pviipi_b = 0;

                            if ($ipi > 0) {

                                if ($pvperdesc1 > 0) {

                                    $pviprecoaux = $pvipreco - ($pvipreco / 100 * $pvperdesc1);

                                    $auxtotal = round($pviprecoaux * $pvisaldo, 2);

                                    $pviprecoaux = round($pviprecoaux / (1 + $ipi / 100), 4);

                                    $totalitem_b = Round(Round($pviprecoaux, 4) * $pvisaldo, 2);

                                    $pviipi_b = $auxtotal - $totalitem_b;
                                }

                                $auxtotal = $pvipreco * $pvisaldo;

                                $pvipreco = round($pvipreco / (1 + $ipi / 100), 4);

                                $totalitem = Round($pvipreco * $pvisaldo, 2);

                                $pviipi = $auxtotal - $totalitem;

                                $pvipreco = Round($pvipreco, 2);
                                //sprintf("%01.2f",Round($prpre,2))

                                $notipi = $notipi + $pviipi;
                                $notbasipi = $notbasipi + $totalitem;

                                //Alterei Aqui !!!
                                if (trim($proicms) == "1") {
                                    $notipi02 = $notipi02 + $pviipi;
                                }
                                //Se For Icms Substituição Verifica se deve ser IVA 1 (44%) ou 2 (47%)
                                else {

                                    $avalipia[$proiva] = $avalipia[$proiva] + $pviipi;
                                    $avalipic[$proiva] = $avalipic[$proiva] + $pviipi_b;

                                    //Se for um produto importado vai calcular Icms Normal e ICMS Substituição
                                    if ($prosubs == "1") {

                                        $notipi02 = $notipi02 + $pviipi;
                                        $avalipib[$proiva] = $avalipib[$proiva] + $pviipi;
                                    }
                                }
                            } else {
                                $totalitem = ($pvipreco * $pvisaldo);
                                $ipi = "";
                                $pviipi = "";
                            }

                            $notvalor1 = $notvalor1 + $totalitem;

                            if (trim($proicms) == "1") {
                                $notvalor2 = $notvalor2 + $totalitem;
                            }
                            //Se For Icms Substituição Verifica se deve ser IVA 1 (44%) ou 2 (47%)
                            else {

                                $avalitema[$proiva] = $avalitema[$proiva] + $totalitem;

                                //Se for um produto importado vai calcular Icms Normal e ICMS Substituição
                                if ($prosubs == "1") {

                                    $notvalor2 = $notvalor2 + $totalitem;

                                    $avalitemb[$proiva] = $avalitemb[$proiva] + $totalitem;
                                }
                            }
                        }
                    }

                    if ($subs1 > 0) {
                        if ($subs2 == 0) {
                            $cfop = '2';
                        } else {
                            $cfop = '3';
                        }
                    }

                    if ($notvalor1 > 0) {
                        $desconto = ($notvalor1 + $notipi) / 100 * $pvperdesc;
                        $desconto = round($desconto, 2);

                        $desconto02 = ($notvalor2 + $notipi02) / 100 * $pvperdesc;
                        $desconto02 = round($desconto02, 2);

                        //Calcula os Descontos
                        for ($j = 1; $j <= 1000; $j++) {
                            if ($avalitema[$j] + $avalipia[$j] > 0) {
                                $avaldesa[$j] = ($avalitema[$j] + $avalipia[$j]) / 100 * $pvperdesc;
                                $avaldesa[$j] = round($avaldesa[$j], 2);
                            }
                        }

                        //Calcula os Descontos
                        for ($j = 1; $j <= 1000; $j++) {
                            if ($avalitemb[$j] + $avalipib[$j] > 0) {
                                $avaldesb[$j] = ($avalitemb[$j] + $avalipib[$j]) / 100 * $pvperdesc;
                                $avaldesb[$j] = round($avaldesb[$j], 2);
                            }
                        }


                        $notvalorliq = $notvalor1 - $desconto;

                        //Aqui
                        $notvalorliq2 = $notvalor2 - $desconto02;
                        //$notvalorliq2=$desconto02;
                        //Valor Liquido do Item
                        for ($j = 1; $j <= 1000; $j++) {
                            if ($avalitema[$j] > 0) {
                                $avalliqa[$j] = $avalitema[$j] - $avaldesa[$j];
                            }
                        }

                        //Valor Liquido do Item
                        for ($j = 1; $j <= 1000; $j++) {
                            if ($avalitemb[$j] + $avalipib[$j] > 0) {
                                $avalliqb[$j] = $avalitemb[$j] - $avaldesb[$j] + $avalipib[$j];
                            }
                        }

                        //Origem = São Paulo
                        if ($parametro2 == 1) {

                            $noticmsivanovo = 0;
                            //Valor Liquido do Item
                            for ($j = 1; $j <= 1000; $j++) {
                                if ($avalliqb[$j] > 0) {
                                    $mva = 1 + ($aperiva[$j] / 100);
                                    $mvb = ((12 / 100) - 1) / ((17 / 100) - 1);
                                    $mvc = (($mva * $mvb) - 1) * 100;
                                    $mvd = (1000 * 12 / 100);
                                    $mve = 1000 + (1000 * $mvc / 100);
                                    $mvf = $mve * 17 / 100;
                                    $mvg = ($mvf - $mvd) * 0.001;
                                    $noticmsiva = $avalliqb[$j] * $mvg;
                                    $noticmsivanovo = $noticmsivanovo + $noticmsiva;
                                }
                            }
                        }

                        //Origem = Vix
                        else if ($parametro2 == 2) {

                            /*
                              $noticmsivanovo = 0;
                              //Valor Liquido do Item
                              for ($j = 1; $j <= 1000; $j++) {
                              if ($avalliqb[$j] > 0) {
                              $mva = 1 + ($aperiva[$j] / 100);
                              $mvb = ((12 / 100) - 1) / ((17 / 100) - 1);
                              $mvc = (($mva * $mvb) - 1) * 100;
                              $mvd = (1000 * 12 / 100);
                              $mve = 1000 + (1000 * $mvc / 100);
                              $mvf = $mve * 17 / 100;
                              $mvg = ($mvf - $mvd) * 0.001;
                              $noticmsiva = $avalliqb[$j] * $mvg;
                              $noticmsivanovo = $noticmsivanovo + $noticmsiva;
                              }
                              }
                             */

                            //Calculo Novo
                            //echo "optanteSimples: ".$optanteSimples . "\n";
                            $noticmsivanovo = 0;

                            //Valor Liquido do Item
                            for ($j = 1; $j <= 1000; $j++) {

                                if ($avalliqa[$j] > 0) {

                                    //Fase 1 - Calcula o ICMS usando a aliquota Interestadual sobre o valor sem o IPI
                                    //$scIcms = $avalliqa[$j] * 0.12;
                                    if ($avalipic[$j] > 0) {
                                        $scIcms = ($avalliqb[$j] - $avalipic[$j]) * 0.12;
                                    } else {
                                        $scIcms = $avalliqa[$j] * 0.12;
                                    }

                                    //Fase 2 - Calcula a MVA Ajsutada
                                    //Optante pelo simples o IVA será sempre 17.1
                                    //if ($optanteSimples == true) {
                                    //	$mva = 1 + (17.1 / 100);
                                    //}
                                    //else {
                                    $mva = 1 + ($aperiva[$j] / 100);
                                    //}
                                    $mvb = ((12 / 100) - 1) / ((17 / 100) - 1);
                                    $mvc = (($mva * $mvb) - 1) * 100;

                                    //Fase 3 - Calcula a Base ST do valor com o IPI
                                    $scBasest = $avalliqb[$j] + ($avalliqb[$j] * $mvc / 100);

                                    //Fase 4 - Calcula o ICMS ST com a aliquota de 17%
                                    $scValst = $scBasest * 0.17;

                                    //Fase 5 - Calcula o ICMS ST substraindo o valor do ICMS original
                                    $noticmsiva = $scValst - $scIcms;

                                    $noticmsivanovo = $noticmsivanovo + $noticmsiva;
                                }
                            }
                        }

                        if ($noticmsivanovo > 0) {

                            $substituicao = round($noticmsivanovo, 2);
                            $notvalor = $notvalor + $substituicao;
                        }
                    }
                }

                //Se o tipo de Pedido for R ou I não vai haver mais cálculo de ST , nem Pessoa Física
                if ($auxtipoped == 'I' || $auxtipoped == 'R' || $clipessoa == '2') {
                    $substituicao = 0;
                }


                $retorno = new stdClass();
                $retorno->notavalor = $notvalor;
                $retorno->substituicao = $substituicao;
                $retorno->estoque = $parametro2;
            }
        }
        return $retorno;
    }

    /**
     * Metodo para efetuar pesquisa dos pedidos no banco.
     * Executa select na tabela pvenda ver config.php lista de tabelas.
     *
     * @access public
     * @param string $tipo Nome do campo para pesquisar.
     * @param string $pesquisa Texto para pesquisa.
     * @return object Retorna objetos do tipo json;
     */
    public function saldoTotalParcelaCobranca($pvnumero) {
        $conexao = new Conexao();
        $db = $conexao->connection();
        
        $retorno = new stdClass();

        $row = $db->GetRow("SELECT sum(cobvalor) as saldototal FROM " . TABELA_COBRANCA . " WHERE pvnumero='$pvnumero' ");

        if (!$row) {
            $msg = $row . "NAO FOI POSSIVEL SOMAR A Quantidade do estoque.";

            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        } else {

            $msg = "Quantidade Total em Estoque " . $row['saldototal'];

            $retorno->retorno = true;
            $retorno->mensagem = $msg;
            $retorno = $row['saldototal'];
        }
        return $retorno;
    }

    /**
     * Metodo para efetuar pesquisa dos pedidos no banco.
     * Executa select na tabela pvenda ver config.php lista de tabelas.
     *
     * @access public
     * @param string $tipo Nome do campo para pesquisar.
     * @param string $pesquisa Texto para pesquisa.
     * @return object Retorna objetos do tipo json;
     */
    public function pesquisar($tipoPesquisa, $txtpesquisa, $exata) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        switch ($exata) {
            case 0:
                $where = "$tipoPesquisa LIKE '$txtpesquisa%'";
                break;

            case 1:
                $where = "$tipoPesquisa LIKE '%$txtpesquisa%'";
                break;

            case 2:
                $where = "$tipoPesquisa = '$txtpesquisa'";
                break;
        }

        $sql = "SELECT * FROM " . TABELA_PEDIDOS . " WHERE $where ORDER BY pvnumero";

        $result = $db->Execute($sql);

        $retorno = new stdClass();

        if (!$result) {
            $msg = "FALHA NA CONEXAO COM BANCO DE DADOS " . $db->ErrorMsg();

            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        }

//echo  "pvnumero ==============> ". $result->fields['pvnumero'];
// echo "<pre>";
// print_r($result);
// echo "</pre>";
        while (!$result->EOF) {
            $pedido = new PedidoVO();
            $pedido->pvnumero = $result->fields[0];
            $pedido->cliente = new ClienteVO($result->fields[1]);
            $pedido->tipoPedido = new TipoPedidoVO($result->fields[2]);

            $pedido->vendedor = new VendedorVO($result->fields[3]);
            $pedido->transportadora = new TransportadoraVO($result->fields[4]);

            $pedido->pvemissao = $result->fields[5];
            $pedido->pvvaldesc = $result->fields[6];
            $pedido->pvperdesc = $result->fields[7];
            $pedido->pvvalor = $result->fields[8];

            $pedido->condicaoComercial = new CondicaoComercialVO($result->fields[9]);

            $pedido->pvobserva = $result->fields[10];
            $pedido->pvbaixa = $result->fields[11];
            $pedido->pvencer = $result->fields[12];
            $pedido->pvencer2 = $result->fields[61];

            $pedido->estoqueOrigem = new EstoqueVO($result->fields[13]);
            $pedido->estoqueDestino = new EstoqueVO($result->fields[14]);
            $pedido->pvvinculo = $result->fields[15];
            $pedido->pvlibera = $result->fields[16];
            $pedido->pvhora = $result->fields[17];
            $pedido->pvimpresso = $result->fields[18];
            $pedido->pvusulib = $result->fields[19];

            $pedido->palm = new PalmVO();
            $pedido->palm->palmcodigo = $result->fields[20];

            $pedido->pvnewobs = $result->fields[21];
            $pedido->pvlocal = $result->fields[22];
            $pedido->pvtpalt = $result->fields[23];

            $pedido->pvitem = $result->fields[24];

            $pedido->palm2 = new PalmVO();
            $pedido->palm2->palmcodigo = $result->fields[25];

            $pedido->pvcomissao = $result->fields[26];
            $pedido->pvcomisa = $result->fields[27];
            $pedido->pvcomisb = $result->fields[28];
            $pedido->pvcomistp = $result->fields[29];

            $pedido->fornecedor = new FornecedorVO($result->fields[30]);

            $pedido->pvtipofrete = $result->fields[31];
            $pedido->pventrega = $result->fields[32];
            $pedido->pvinternet = $result->fields[33];
            $pedido->pvportal = $result->fields[34];
            $pedido->pvurgente = $result->fields[35];
            $pedido->pvvia = $result->fields[36];
            $pedido->pvcredito = $result->fields[37];
            $pedido->pvbloqueio = $result->fields[38];
            $pedido->pvfilialb = $result->fields[39];
            $pedido->pvmatrizb = $result->fields[40];
            $pedido->pvfilial = $result->fields[41];
            $pedido->pvmatriz = $result->fields[42];

            $pedido->pvpeso = $result->fields[120];

            $pedido->usuarioCadastroPedido = new UsuarioVO($result->fields[43]);

            if ($result->fields[2] != 'I') {

                $pedido->pvlibdep = $result->fields[44];
                $pedido->pvlibmat = $result->fields[45];
                $pedido->pvlibfil = $result->fields[46];
                $pedido->pvlibvit = $result->fields[48];
            } else {

                $query_item = "Select pviest01,pviest02,pviest011,pviest026 from pvitem where pvnumero=" . $pedido->pvvinculo;
                $result2 = $db->Execute($query_item);

                $pedido->pvlibdep = ($result2->fields[3]) ? '1' : '';
                $pedido->pvlibmat = ($result2->fields[1]) ? '1' : '';
                $pedido->pvlibfil = ($result2->fields[0]) ? '1' : '';
                $pedido->pvlibvit = ($result2->fields[2]) ? '1' : '';
            }

            $pedido->fecreserva = $result->fields[64];

            $retornoPreFechamento = $this->getPreFechamento($pedido->pvnumero);
            $pedido->preFechamento = $retornoPreFechamento->preFechamentos;

            $pedido->usuario = new UsuarioVO($result->fields[49]);

            $pedido->estoqueFisico = new EstoqueFisicoVO($result->fields[50]);

            $pedido->pvsituacao = $result->fields[51] == "t" ? true : false;

            $retornoItensPedido = $this->getItens($pedido->pvnumero);
            $pedido->itensPedido = $retornoItensPedido->itensPedido;


            if ($pedido->itensPedido[0]->pedidoVendaItemEstoque->pviest011 > '0' OR $pedido->itensPedido[0]->pedidoVendaItemEstoque->pviest017 > '0' OR $pedido->itensPedido[0]->pedidoVendaItemEstoque->pviest024 > '0') {
                $pedido->calculoSt = $this->getCalculoSt($pedido->pvnumero, '2');
            } else {
                $pedido->calculoSt = $this->getCalculoSt($pedido->pvnumero, '1');
            }

            $pedido->fechamento = new FechamentoVO($pedido->pvnumero);

            $retornoCobranca = $this->getCobranca($pedido->pvnumero);
            $pedido->cobranca = $retornoCobranca->cobranca;

            $pedido->TotalItensPedidos = $this->saldoTotalItensPedidos($pedido->pvnumero);
            $pedido->TotalItensEstoque = $this->saldoTotalItensEstoque($pedido->pvnumero);
            $pedido->TotalParcelaCobranca = $this->saldoTotalParcelaCobranca($pedido->pvnumero);

            $pedido->TotalValorPreFechamento = $this->valorTotalPreFechamento($pedido->pvnumero);

            $retornoHistorico = $this->getHistoricoPedido($pedido->pvnumero);
            $pedido->historico = $retornoHistorico->historico;

            $estoqueSaida = '';

            /*
              if($pedido->itensPedido[0]->pedidoVendaItemEstoque->pviest09 > '0') {
              $estoqueSaida = 'dep';
              } else if($pedido->itensPedido[0]->pedidoVendaItemEstoque->pviest026 > '0') {
              $estoqueSaida = 'gua';
              } else if($pedido->itensPedido[0]->pedidoVendaItemEstoque->pviest02 > '0') {
              $estoqueSaida = 'mat';
              } else if($pedido->itensPedido[0]->pedidoVendaItemEstoque->pviest01 > '0') {
              $estoqueSaida = 'fil';
              } else if($pedido->itensPedido[0]->pedidoVendaItemEstoque->pviest011 > '0') {
              $estoqueSaida = 'vit';
              }
             */
            
            if($pedido->itensPedido[0]->pedidoVendaItemEstoque->pviest02 > '0') {
                $estoqueSaida = 'fil';
            } else {
                $estoqueSaida = 'gua';
            }
          
            $retornoNF = $this->getNF($pedido->pvnumero, $estoqueSaida);
            $pedido->notafiscal = $retornoNF;




            $sql02 = "SELECT * FROM fechamento WHERE pvnumero = " . $result->fields['pvnumero'];
            $sql02 = pg_query($sql02);
            $row02 = pg_num_rows($sql02);
            if ($row02) {


                $sql03 = "SELECT * FROM formapag WHERE pagcodigo = " . pg_result($sql02, 0, "fecforma");
                $sql03 = pg_query($sql03);
                $row03 = pg_num_rows($sql03);
                if ($row03) {
                    $pedido->formapagto = pg_result($sql03, 0, "pagdescricao") . " " . pg_result($sql02, 0, "fecdocto");
                } else {
                    $pedido->formapagto = pg_result($sql02, 0, "fecdocto");
                }

                $pedido->parcelas = $row02;
            } else {

                $pedido->formapagto = "";
                $pedido->parcelas = "";
            }




            $pedidos[$pedido->pvnumero] = $pedido;

            $result->MoveNext();
        }

        if (count($pedidos)) {
            $msg = "LOCALIZADO(S) " . count($pedidos) . " PEDIDO(S). ";

            $retorno->retorno = true;
            $retorno->mensagem = $msg;
            $retorno->pedidos = $pedidos;
        } else {
            $msg = "NAO FOI POSSIVEL LOCALIZAR PEDIDO(S). ";

            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        }

        $retorno->mensagem .= $retornoItensPedido->mensagem;

        return $retorno;
    }

    public function pesquisarSimples($tipoPesquisa, $txtpesquisa, $exata) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        switch ($exata) {
            case 0:
                $where = "$tipoPesquisa LIKE '$txtpesquisa%'";
                break;

            case 1:
                $where = "$tipoPesquisa LIKE '%$txtpesquisa%'";
                break;

            case 2:
                $where = "$tipoPesquisa = '$txtpesquisa'";
                break;
        }

        $sql = "SELECT * FROM " . TABELA_PEDIDOS . " WHERE $where ORDER BY pvnumero";

        $result = $db->Execute($sql);

        $retorno = new stdClass();

        if (!$result) {
            $msg = "FALHA NA CONEXAO COM BANCO DE DADOS " . $db->ErrorMsg();

            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        }

        while (!$result->EOF) {
            $pedido = new PedidoVO();
            $pedido->pvnumero = $result->fields[0];
            $pedido->cliente = new ClienteVO($result->fields[1], 'clicodigo', true);
            $pedido->tipoPedido = $result->fields[2];

            $pedido->vendedor = $result->fields[3];
            $pedido->transportadora = $result->fields[4];

            $pedido->pvemissao = $result->fields[5];
            $pedido->pvvaldesc = $result->fields[6];
            $pedido->pvperdesc = $result->fields[7];
            $pedido->pvvalor = $result->fields[8];

            $pedido->condicaoComercial = $result->fields[9];

            $pedido->pvobserva = $result->fields[10];
            $pedido->pvbaixa = $result->fields[11];
            $pedido->pvencer = $result->fields[12];
            $pedido->pvencer2 = $result->fields[61];

            $pedido->estoqueOrigem = $result->fields[13];
            $pedido->estoqueDestino = $result->fields[14];
            $pedido->pvvinculo = $result->fields[15];
            $pedido->pvlibera = $result->fields[16];
            $pedido->pvhora = $result->fields[17];
            $pedido->pvimpresso = $result->fields[18];
            $pedido->pvusulib = $result->fields[19];

            $pedido->palm = new PalmVO();
            $pedido->palm->palmcodigo = $result->fields[20];

            $pedido->pvnewobs = $result->fields[21];
            $pedido->pvlocal = $result->fields[22];
            $pedido->pvtpalt = $result->fields[23];

            $pedido->pvitem = $result->fields[24];

            $pedido->palm2 = new PalmVO();
            $pedido->palm2->palmcodigo = $result->fields[25];

            $pedido->pvcomissao = $result->fields[26];
            $pedido->pvcomisa = $result->fields[27];
            $pedido->pvcomisb = $result->fields[28];
            $pedido->pvcomistp = $result->fields[29];

            $pedido->fornecedor = $result->fields[30];

            $pedido->pvtipofrete = $result->fields[31];
            $pedido->pventrega = $result->fields[32];
            $pedido->pvinternet = $result->fields[33];
            $pedido->pvportal = $result->fields[34];
            $pedido->pvurgente = $result->fields[35];
            $pedido->pvvia = $result->fields[36];
            $pedido->pvcredito = $result->fields[37];
            $pedido->pvbloqueio = $result->fields[38];
            $pedido->pvfilialb = $result->fields[39];
            $pedido->pvmatrizb = $result->fields[40];
            $pedido->pvfilial = $result->fields[41];
            $pedido->pvmatriz = $result->fields[42];

            $pedido->usuarioCadastroPedido = $result->fields[43];

            if ($result->fields[2] != 'I') {

                $pedido->pvlibdep = $result->fields[44];
                $pedido->pvlibmat = $result->fields[45];
                $pedido->pvlibfil = $result->fields[46];
                $pedido->pvlibvit = $result->fields[48];
            } else {

                $query_item = "Select pviest01,pviest02,pviest011,pviest026 from pvitem where pvnumero=" . $pedido->pvvinculo;
                $result2 = $db->Execute($query_item);

                $pedido->pvlibdep = ($result2->fields[3]) ? '1' : '';
                $pedido->pvlibmat = ($result2->fields[1]) ? '1' : '';
                $pedido->pvlibfil = ($result2->fields[0]) ? '1' : '';
                $pedido->pvlibvit = ($result2->fields[2]) ? '1' : '';
            }

            $pedido->fecreserva = $result->fields[64];

//			$retornoPreFechamento = $this->getPreFechamento($pedido->pvnumero);
            $pedido->preFechamento = $pedido->pvnumero;

            $pedido->usuario = $result->fields[49];

            $pedido->estoqueFisico = $result->fields[50];

            $pedido->pvsituacao = $result->fields[51] == "t" ? true : false;

//			$retornoItensPedido = $this->getItens($pedido->pvnumero);
//			$pedido->itensPedido = $retornoItensPedido->itensPedido;
//			if($pedido->itensPedido[0]->pedidoVendaItemEstoque->pviest011 > '0' OR $pedido->itensPedido[0]->pedidoVendaItemEstoque->pviest017 > '0' OR $pedido->itensPedido[0]->pedidoVendaItemEstoque->pviest024 > '0')
//			{
//			$pedido->calculoSt = $this->getCalculoSt($pedido->pvnumero, '2');
//			}else{
//			$pedido->calculoSt = $this->getCalculoSt($pedido->pvnumero, '1');
//			}
//			$pedido->fechamento = new FechamentoVO($pedido->pvnumero);
//			$retornoCobranca = $this->getCobranca($pedido->pvnumero);
//			$pedido->cobranca = $retornoCobranca->cobranca;
//			$pedido->TotalItensPedidos = $this->saldoTotalItensPedidos($pedido->pvnumero);
//			$pedido->TotalItensEstoque = $this->saldoTotalItensEstoque($pedido->pvnumero);
//			$pedido->TotalParcelaCobranca = $this->saldoTotalParcelaCobranca($pedido->pvnumero);
//
//			$pedido->TotalValorPreFechamento = $this->valorTotalPreFechamento($pedido->pvnumero);
//
//			$retornoHistorico = $this->getHistoricoPedido($pedido->pvnumero);
//			$pedido->historico = $retornoHistorico->historico;
//                        $estoqueSaida = '';
//                        if($pedido->itensPedido[0]->pedidoVendaItemEstoque->pviest011 > '0') {
//                            $estoqueSaida = 'dep';
//                        } else if($pedido->itensPedido[0]->pedidoVendaItemEstoque->pviest026 > '0') {
//                            $estoqueSaida = 'gua';
//                        } else if($pedido->itensPedido[0]->pedidoVendaItemEstoque->pviest02 > '0') {
//                            $estoqueSaida = 'mat';
//                        } else if($pedido->itensPedido[0]->pedidoVendaItemEstoque->pviest01 > '0') {
//                            $estoqueSaida = 'fil';
//                        } else if($pedido->itensPedido[0]->pedidoVendaItemEstoque->pviest09 > '0') {
//                            $estoqueSaida = 'vit';
//                        }
//                        $retornoNF = $this->getNF($pedido->pvnumero,$estoqueSaida);
//			$pedido->notafiscal = $retornoNF;

            $pedidos[$pedido->pvnumero] = $pedido;

            $result->MoveNext();
        }

        if (count($pedidos)) {
            $msg = "LOCALIZADO(S) " . count($pedidos) . " PEDIDO(S). ";

            $retorno->retorno = true;
            $retorno->mensagem = $msg;
            $retorno->pedidos = $pedidos;
        } else {
            $msg = "NAO FOI POSSIVEL LOCALIZAR PEDIDO(S). ";

            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        }

        $retorno->mensagem .= $retornoItensPedido->mensagem;

        return $retorno;
    }

    /**
     * Metodo para efetuar excluisão do usuario no banco.
     * Executa delete na tabela pviestoques ver config.php lista de tabelas.
     *
     * @access public
     * @param ItemEstoqueVO $estoqueItem Recebe variavel tipada.
     * @return object Retorna objeto com resultado do operacao;
     */
    public function excluirEstoqueItem($pviecodigo) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $retorno = new stdClass();

        $sql = "DELETE
				FROM " . TABELA_ITENS_PEDIDO_ESTOQUES . "
				WHERE
					pviecodigo = '$pviecodigo'";

        $result = $db->Execute($sql);

        if (!$result) {
            $msg = "[" . date('d.m.Y H:i:s') . "] ERRO: EXCLUIR ESTOQUE $pviecodigo.";
            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        } else {
            $msg = "[" . date('d.m.Y H:i:s') . "] OK: EXCLUIR ESTOQUE $pviecodigo.";
            $retorno->retorno = true;
            $retorno->mensagem = $msg;
        }

        return $retorno;
    }

    /**
     * Metodo para efetuar excluisão do usuario no banco.
     * Executa delete na tabela pvitembeta ver config.php lista de tabelas.
     *
     * @access public
     * @param ItemPedidoVO $itemPedido Recebe variavel tipada.
     * @return object Retorna objeto com resultado do operacao;
     */
    public function excluirItem($pvicodigo) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $retorno = new stdClass();

        $sql = "DELETE
				FROM " . TABELA_ITENS_PEDIDO . "
				WHERE
					pvicodigo = '$pvicodigo'";

        $result = $db->Execute($sql);
        $retorno->itemPedido = $itemPedido;

        if (!$result) {
            $msg = "[" . date('d.m.Y H:i:s') . "] ERRO: EXCLUSAO ITEM $pvicodigo. " . $db->ErrorMsg();
            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        } else {
            $msg = "[" . date('d.m.Y H:i:s') . "] OK: EXCLUSAO ITEM $pvicodigo.";
            $retorno->retorno = true;
            $retorno->mensagem = $msg;
        }

        return $retorno;
    }

    /**
     * Metodo para efetuar excluisão do usuario no banco.
     * Executa delete na tabela pvitem ver config.php lista de tabelas.
     *
     * @access public
     * @param ItemPedidoVO $itemPedido Recebe variavel tipada.
     * @return object Retorna objeto com resultado do operacao;
     */
    public function excluirItemAntigo($pvicodigo) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $retorno = new stdClass();

        $sql = "DELETE
				FROM " . TABELA_ITENS_PEDIDO2 . "
				WHERE
					pvicodigo = '$pvicodigo'";

        $result = $db->Execute($sql);

        if (!$result) {
            $msg = "[" . date('d.m.Y H:i:s') . "] ERRO: EXCLUSAO ITEM CONSULTA $pvicodigo. " . $db->ErrorMsg();
            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        } else {
            $msg = "[" . date('d.m.Y H:i:s') . "] OK: EXCLUSAO ITEM CONSULTA $pvicodigo.";
            $retorno->retorno = true;
            $retorno->mensagem = $msg;
        }

        return $retorno;
    }

    public function seleciona($pvnumero) {
        //Left Join pvendaconfere as b on b.procodigo = c.procodigo AND b.pvnumero = $pvnumero
        $query = "SELECT c.procod as codigo,c.prnome as descricao,a.pvisaldo as estoque,a.pvipreco as conferido
                FROM pvitem a,produto c
                Where a.pvnumero = $pvnumero
                and a.procodigo = c.procodigo
                order by a.pvicodigo";

        $result = pg_query($query) or die("Nao foi possivel selecionar na base");
        return $result;
    }

    public function seleciona_pvenda($pvnumero) {
        $query = "Select * from pvenda where pvnumero=$pvnumero";
        $result = pg_query($query) or die("Não foi possível selecionar na base");
        return $result;
    }

    public function seleciona_pvitem($pvnumero) {
        $query = "Select * from pvitem where pvnumero=$pvnumero";
        $result = pg_query($query) or die("Não foi possível selecionar na base");
        return $result;
    }

    public function seleciona_pvitem_estoques_principais($pvnumero) {
        $query = "Select pviest01,pviest02,pviest011,pviest026 from pvitem where pvnumero=$pvnumero";
        $result = pg_query($query) or die("Não foi possível selecionar na base");
        return $result;
    }

    public function insere($tabela, $campos, $valores) {
        $query = "INSERT INTO $tabela $campos VALUES $valores";
        $result = pg_query($query) or die("Nao foi possivel inserir o registro na base");
        return $result;
    }

    public function apaga($tabela, $condicao) {
        $query = "DELETE FROM $tabela $condicao";
        $result = pg_query($query); // or die ("Nao foi possivel apagar o registro na base ".$tabela);
        return $result;
    }

    public function altera($tabela, $alteracao, $procodigo, $pvnumero) {
        $query = "UPDATE $tabela SET $alteracao WHERE procodigo=$procodigo AND pvnumero=$pvnumero";
        $result = pg_query($query) or die("Nao foi possivel alterar o registro na base");
        return $result;
    }

    public function excluiBanco($pvnumeroDel, $estoque, $usuarioDel, $tabelamov) {

        $pvnumero = trim($pvnumeroDel);
        $estoque = trim($estoque);
        $usuario = trim($usuarioDel);
        $tabelamov = trim($tabelamov);




// Processa os dados da tabela PVENDA 
//----------------------------------------------------------------
        $data = $this->seleciona_pvenda($pvnumero);
        $array = pg_fetch_object($data);



        $datacancelamento = date("Y-m-d H:i:s");
        $datacancelamento .= "-03";

        $tabela = "pvcance";
        $campos = "(pvnumcanc,clicodigo,pvtipoped,vencodigo,tracodigo,pvemissao,pvvaldesc,pvperdesc,pvvalor,pvcondcon,pvobserva,pvbaixa,pvencer,pvorigem,pvdestino,pvvinculo,pvlibera,pvhora,pvimpresso,pvusulib,palmcodigo,pvnewobs,pvlocal,pvtpalt,pvitens,palmcodigo2,pvcomissao,pvcomisa,pvcomisb,pvcomistp,forcodigo,pvtipofrete,pventrega,pvinternet,pvportal,pvcorreio,pvcancelado)";
        $valores = "(" . trim($array->pvnumero) . "," . trim($array->clicodigo) . ",'" . trim($array->pvtipoped) . "'," . trim($array->vencodigo) . "," . trim($array->tracodigo) . ",'" . trim($array->pvemissao) . "','" . trim($array->pvvaldesc) . "','" . trim($array->pvperdesc) . "','" . trim($array->pvvalor) . "','" . trim($array->pvcondcon) . "','" . trim($array->pvobserva) . "','" . trim($array->pvbaixa) . "'," . trim($array->pvencer) . "," . trim($array->pvorigem) . "," . trim($array->pvdestino) . "," . trim($array->pvvinculo) . ",'" . trim($array->pvlibera) . "','" . trim($array->pvhora) . "'," . trim($array->pvimpresso) . "," . trim($array->pvusulib) . "," . trim($array->palmcodigo) . ",'" . trim($array->pvnewobs) . "','" . trim($array->pvlocal) . "','" . trim($array->pvtpalt) . "'," . trim($array->pvitens) . "," . trim($array->palmcodigo2) . ",'" . trim($array->pvcomissao) . "','" . trim($array->pvcomisa) . "','" . trim($array->pvcomisb) . "'," . trim($array->pvcomistp) . "," . trim($array->forcodigo) . "," . trim($array->pvtipofrete) . ",'" . trim($array->pventrega) . "'," . trim($array->pvinternet) . "," . trim($array->pvportal) . ",'" . trim($array->pvcorreio) . "','" . trim($datacancelamento) . "')";
//Os valores nulos serão gravados como NULL
        $valores = str_replace(",,", ",null,", $valores);
        $valores = str_replace(",''", ",null", $valores);
        $valores = str_replace(",,", ",null,", $valores);

        $valores;
        $campos;

        $data_insere = $this->insere($tabela, $campos, $valores);
//-----------------------------------------------------------------
// Processa os dados da tabela PVITEM
//----------------------------------------------------------------
        $data_pvi = $this->seleciona_pvitem($pvnumero);

        $tabela = "pvicance";
        $campos = "(pvnumero,pvitem,procodigo,pvipreco,pvisaldo,pvicomis,pvitippr,pviest01,pviest02,pviest03,pviest04,pviest05,pviest06,pviest07,pviest08,pviest09,pviest10,pvicodcanc)";
        for ($i = 0; $i < pg_num_rows($data_pvi); $i++) {
            $array_pvi = pg_fetch_object($data_pvi);

            if (is_null($array_pvi->pviest10))
                $array_pvi->pviest10 = 'null';

            $valores = "(" . trim($array_pvi->pvnumero) . "," . trim($array_pvi->pvitem) . "," . trim($array_pvi->procodigo) . ",'" . trim($array_pvi->pvipreco) . "','" . trim($array_pvi->pvisaldo) . "','" . trim($array_pvi->pvicomis) . "','" . trim($array_pvi->pvitippr) . "'," . trim($array_pvi->pviest01) . "," . trim($array_pvi->pviest02) . "," . trim($array_pvi->pviest03) . "," . trim($array_pvi->pviest04) . "," . trim($array_pvi->pviest05) . "," . trim($array_pvi->pviest06) . "," . trim($array_pvi->pviest07) . "," . trim($array_pvi->pviest08) . "," . trim($array_pvi->pviest09) . "," . trim($array_pvi->pviest10) . "," . trim($array_pvi->pvicodigo) . ")";

            //Os valores nulos serão gravados como NULL
            $valores = str_replace(",,", ",null,", $valores);
            $valores = str_replace(",''", ",null", $valores);
            $valores = str_replace(",,", ",null,", $valores);

            $valores;
            $campos;

            //print("<br>Valores: ".$valores);
            $data_insere = $this->insere($tabela, $campos, $valores);

            //echo 'produto';
            $array_pvi->procodigo;

            //echo 'estoque';
            //echo $estoque;
            //Atualiza o Estoque
            if ($estoque == 1) {

                for ($z = 0; $z < 99; $z++) {


                    $codestoque = $z + 1;
                    if ($z == 0) {
                        $devolver = $array_pvi->pviest01;
                    } else if ($z == 1) {
                        $devolver = $array_pvi->pviest02;
                    } else if ($z == 2) {
                        $devolver = $array_pvi->pviest03;
                    } else if ($z == 3) {
                        $devolver = $array_pvi->pviest04;
                    } else if ($z == 4) {
                        $devolver = $array_pvi->pviest05;
                    } else if ($z == 5) {
                        $devolver = $array_pvi->pviest06;
                    } else if ($z == 6) {
                        $devolver = $array_pvi->pviest07;
                    } else if ($z == 7) {
                        $devolver = $array_pvi->pviest08;
                    } else if ($z == 8) {
                        $devolver = $array_pvi->pviest09;
                    } else if ($z == 9) {
                        $devolver = $array_pvi->pviest010;
                    } else if ($z == 10) {
                        $devolver = $array_pvi->pviest011;
                    } else if ($z == 11) {
                        $devolver = $array_pvi->pviest012;
                    } else if ($z == 12) {
                        $devolver = $array_pvi->pviest013;
                    } else if ($z == 13) {
                        $devolver = $array_pvi->pviest014;
                    } else if ($z == 14) {
                        $devolver = $array_pvi->pviest015;
                    } else if ($z == 15) {
                        $devolver = $array_pvi->pviest016;
                    } else if ($z == 16) {
                        $devolver = $array_pvi->pviest017;
                    } else if ($z == 17) {
                        $devolver = $array_pvi->pviest018;
                    } else if ($z == 18) {
                        $devolver = $array_pvi->pviest019;
                    } else if ($z == 19) {
                        $devolver = $array_pvi->pviest020;
                    } else if ($z == 20) {
                        $devolver = $array_pvi->pviest021;
                    } else if ($z == 21) {
                        $devolver = $array_pvi->pviest022;
                    } else if ($z == 22) {
                        $devolver = $array_pvi->pviest023;
                    } else if ($z == 23) {
                        $devolver = $array_pvi->pviest024;
                    } else if ($z == 24) {
                        $devolver = $array_pvi->pviest025;
                    } else if ($z == 25) {
                        $devolver = $array_pvi->pviest026;
                    } else if ($z == 26) {
                        $devolver = $array_pvi->pviest027;
                    } else if ($z == 27) {
                        $devolver = $array_pvi->pviest028;
                    } else if ($z == 28) {
                        $devolver = $array_pvi->pviest029;
                    } else if ($z == 29) {
                        $devolver = $array_pvi->pviest030;
                    } else if ($z == 30) {
                        $devolver = $array_pvi->pviest031;
                    } else if ($z == 31) {
                        $devolver = $array_pvi->pviest032;
                    } else if ($z == 32) {
                        $devolver = $array_pvi->pviest033;
                    } else if ($z == 33) {
                        $devolver = $array_pvi->pviest034;
                    } else if ($z == 34) {
                        $devolver = $array_pvi->pviest035;
                    } else if ($z == 35) {
                        $devolver = $array_pvi->pviest036;
                    } else if ($z == 36) {
                        $devolver = $array_pvi->pviest037;
                    } else if ($z == 37) {
                        $devolver = $array_pvi->pviest038;
                    } else if ($z == 38) {
                        $devolver = $array_pvi->pviest039;
                    } else if ($z == 39) {
                        $devolver = $array_pvi->pviest040;
                    } else if ($z == 40) {
                        $devolver = $array_pvi->pviest041;
                    } else if ($z == 41) {
                        $devolver = $array_pvi->pviest042;
                    } else if ($z == 42) {
                        $devolver = $array_pvi->pviest043;
                    } else if ($z == 43) {
                        $devolver = $array_pvi->pviest044;
                    } else if ($z == 44) {
                        $devolver = $array_pvi->pviest045;
                    } else if ($z == 45) {
                        $devolver = $array_pvi->pviest046;
                    } else if ($z == 46) {
                        $devolver = $array_pvi->pviest047;
                    } else if ($z == 47) {
                        $devolver = $array_pvi->pviest048;
                    } else if ($z == 48) {
                        $devolver = $array_pvi->pviest049;
                    } else if ($z == 49) {
                        $devolver = $array_pvi->pviest050;
                    } else if ($z == 50) {
                        $devolver = $array_pvi->pviest051;
                    } else if ($z == 51) {
                        $devolver = $array_pvi->pviest052;
                    } else if ($z == 52) {
                        $devolver = $array_pvi->pviest053;
                    } else if ($z == 53) {
                        $devolver = $array_pvi->pviest054;
                    } else if ($z == 54) {
                        $devolver = $array_pvi->pviest055;
                    } else if ($z == 55) {
                        $devolver = $array_pvi->pviest056;
                    } else if ($z == 56) {
                        $devolver = $array_pvi->pviest057;
                    } else if ($z == 57) {
                        $devolver = $array_pvi->pviest058;
                    } else if ($z == 58) {
                        $devolver = $array_pvi->pviest059;
                    } else if ($z == 59) {
                        $devolver = $array_pvi->pviest060;
                    } else if ($z == 60) {
                        $devolver = $array_pvi->pviest061;
                    } else if ($z == 61) {
                        $devolver = $array_pvi->pviest062;
                    } else if ($z == 62) {
                        $devolver = $array_pvi->pviest063;
                    } else if ($z == 63) {
                        $devolver = $array_pvi->pviest064;
                    } else if ($z == 64) {
                        $devolver = $array_pvi->pviest065;
                    } else if ($z == 65) {
                        $devolver = $array_pvi->pviest066;
                    } else if ($z == 66) {
                        $devolver = $array_pvi->pviest067;
                    } else if ($z == 67) {
                        $devolver = $array_pvi->pviest068;
                    } else if ($z == 68) {
                        $devolver = $array_pvi->pviest069;
                    } else if ($z == 69) {
                        $devolver = $array_pvi->pviest070;
                    } else if ($z == 70) {
                        $devolver = $array_pvi->pviest071;
                    } else if ($z == 71) {
                        $devolver = $array_pvi->pviest072;
                    } else if ($z == 72) {
                        $devolver = $array_pvi->pviest073;
                    } else if ($z == 73) {
                        $devolver = $array_pvi->pviest074;
                    } else if ($z == 74) {
                        $devolver = $array_pvi->pviest075;
                    } else if ($z == 75) {
                        $devolver = $array_pvi->pviest076;
                    } else if ($z == 76) {
                        $devolver = $array_pvi->pviest077;
                    } else if ($z == 77) {
                        $devolver = $array_pvi->pviest078;
                    } else if ($z == 78) {
                        $devolver = $array_pvi->pviest079;
                    } else if ($z == 79) {
                        $devolver = $array_pvi->pviest080;
                    } else if ($z == 80) {
                        $devolver = $array_pvi->pviest081;
                    } else if ($z == 81) {
                        $devolver = $array_pvi->pviest082;
                    } else if ($z == 82) {
                        $devolver = $array_pvi->pviest083;
                    } else if ($z == 83) {
                        $devolver = $array_pvi->pviest084;
                    } else if ($z == 84) {
                        $devolver = $array_pvi->pviest085;
                    } else if ($z == 85) {
                        $devolver = $array_pvi->pviest086;
                    } else if ($z == 86) {
                        $devolver = $array_pvi->pviest087;
                    } else if ($z == 87) {
                        $devolver = $array_pvi->pviest088;
                    } else if ($z == 88) {
                        $devolver = $array_pvi->pviest089;
                    } else if ($z == 89) {
                        $devolver = $array_pvi->pviest090;
                    } else if ($z == 90) {
                        $devolver = $array_pvi->pviest091;
                    } else if ($z == 91) {
                        $devolver = $array_pvi->pviest092;
                    } else if ($z == 92) {
                        $devolver = $array_pvi->pviest093;
                    } else if ($z == 93) {
                        $devolver = $array_pvi->pviest094;
                    } else if ($z == 94) {
                        $devolver = $array_pvi->pviest095;
                    } else if ($z == 95) {
                        $devolver = $array_pvi->pviest096;
                    } else if ($z == 96) {
                        $devolver = $array_pvi->pviest097;
                    } else if ($z == 97) {
                        $devolver = $array_pvi->pviest098;
                    } else if ($z == 98) {
                        $devolver = $array_pvi->pviest099;
                    }


                    //echo 'quant';
                    //echo $devolver;
                    //if($array_pvi->pviest01>0){
                    if ($devolver > 0) {

                        $pedido = $array_pvi->pvnumero;
                        $valor = $array_pvi->pvipreco;
                        $produto = $array_pvi->procodigo;
                        $pvcestoque = $devolver;
                        $pvquant = $pvcestoque;

                        //echo 'produto';
                        //echo $produto;

                        $sql2 = "SELECT * From estoqueatual WHERE procodigo = '$produto' and codestoque = '$codestoque'";

                        $sql2 = pg_query($sql2);
                        $row2 = pg_num_rows($sql2);

                        if ($row2) {
                            $estqtd = pg_result($sql2, 0, "estqtd");
                            $pvcestoque = $estqtd + $pvcestoque;

                            $sql2 = "Update estoqueatual set estqtd=$pvcestoque WHERE procodigo = '$produto' and codestoque = '$codestoque'";
                            pg_query($sql2);
                        } else {
                            $estqtd = 0;
                            $pvcestoque = $estqtd + $pvcestoque;
                            $sql2 = "Insert into estoqueatual (procodigo,estqtd,codestoque) values ('$produto',$pvcestoque,'$codestoque') ";
                            pg_query($sql2);
                        }


                        //Grava o Log
                        $lgqdata = date('Y-m-d');
                        $lgqhora = date('h:i');
                        $lgqtipo = 'EXCLUSAO PEDIDOS';
                        $usucodigo = $usuario;
                        $sql2 = "Insert into logestoque (lgqdata,lgqhora,usucodigo,lgqpedido,procodigo,lgqsaldo,lgqquantidade,lgqestoque,lgqtipo
				) values ('$lgqdata','$lgqhora','$usucodigo','$pedido','$produto',$estqtd,$devolver,'$codestoque','$lgqtipo') ";
                        pg_query($sql2);


                        $datadev = $lgqdata;

                        //Grava a Movimentação
                        //$tabelamov='movestoque'.substr($datadev, 5, 2).substr($datadev, 2, 2);	
                        //Grava a Movimentação de Estoque
                        $this->insere($tabelamov, "(pvnumero,movdata,procodigo,movqtd,movvalor,movtipo,codestoque)", "('$pedido','$datadev','$produto','$devolver','$valor','3','$codestoque')");
                    }
                }
            }

            $tabela_pviend = "pviendereco";
            $condicao_pviend = "pvicodigo=" . $array_pvi->pvicodigo;
            $data_excluir = @$this->apaga($tabela_pviend, $condicao_pviend);
        }
//die;
//----------------------------------------------------------------
//excluir os registros da tabela
//----------------------------------------------------------------
        $condicao = "where pvnumero=" . $pvnumero;
        $tabela = "pvitem";
        $excluirPvitem = $this->apaga($tabela, $condicao);

        $tabela = "pvendafinalizado";
        $excluirPvendafinalizado = $this->apaga($tabela, $condicao);

        $tabela = "pvendaconfere";
        $excluirPvendaconfere = $this->apaga($tabela, $condicao);

        $tabela = "pvendafinalizadomatriz";
        $excluirPvendafinalizadomatriz = $this->apaga($tabela, $condicao);

        $tabela = "pvendafinalizadofilial";
        $excluirPvendafinalizadofilial = $this->apaga($tabela, $condicao);


        $retorno = new stdClass();
        if ($excluirPvitem) {
            $retorno->pvitem = " PVITEM: OK";
        } else {
            $retorno->pvitem = " PVITEM:  FAIL";
        }
        if ($excluirPvendafinalizado) {
            $retorno->excluirPvendafinalizado = " PVENDAFNALIZADO: OK";
        } else {
            $retorno->excluirPvendafinalizado = "  PVENDAFNALIZADO: FAIL";
        }
        if ($excluirPvendaconfere) {
            $retorno->excluirPvendaconfere = " PVENDACONFERE: OK";
        } else {
            $retorno->excluirPvendaconfere = " PVENDACONFERE: FAIL";
        }
        if ($excluirPvendafinalizadomatriz) {
            $retorno->excluirPvendafinalizadomatriz = " PVENDAFINALIZAMATRIZ: OK ";
        } else {
            $retorno->excluirPvendafinalizadomatriz = " PVENDAFINALIZAMATRIZ: FAIL ";
        }
        if ($excluirPvendafinalizadofilial) {
            $retorno->excluirPvendafinalizadofilial = " PVENDAFINALIZAFILIAL: OK";
        } else {
            $retorno->excluirPvendafinalizadofilial = " PVENDAFINALIZAFILIAL: FAIL";
        }


        return $retorno;
    }

    /**
     * Metodo para efetuar excluisão do usuario no banco.
     * Executa delete na tabela pvenda ver config.php lista de tabelas.
     *
     * @access public
     * @param PedidoVO $pedido Recebe variavel tipada.
     * @return object Retorna objeto com resultado do operacao;
     */
    public function excluirPedido($pvnumeroDel, $estoque, $usuarioDel) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $retorno = new stdClass();

        $sql = "DELETE FROM " . TABELA_PEDIDOS . " WHERE pvnumero = '$pvnumeroDel'";

        $result = $db->Execute($sql);

        if (!$result) {
            $msg = "[" . date('d.m.Y H:i:s') . "] ERRO: EXCLUCAO PEDIDO $pvnumeroDel. " . $db->ErrorMsg();
            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        } else {
            $msg = "[" . date('d.m.Y H:i:s') . "] OK: EXCLUCAO PEDIDO $pvnumeroDel. ";
            //$retorno->tabelas = $this->excluiBanco($pvnumeroDel, $estoque, $usuarioDel);
            $retorno->retorno = true;
            $retorno->mensagem = $msg;
        }

        return $retorno;
    }

    /**
     * Metodo para efetuar excluisão do usuario no banco.
     * Executa delete na tabela pvenda ver config.php lista de tabelas.
     *
     * @access public
     * @param PedidoVO $pedido Recebe variavel tipada.
     * @return object Retorna objeto com resultado do operacao;
     */
    public function tabelaEstoque($pvnumeroDel, $tabelamov) {
        $conexao = new Conexao();
        $db = $conexao->connection();



        $tblmovestoque = 'movestoque' . date("m") . date("y");

        $movdata = date("Y-m-d H:i:s");
        $sql = "SELECT * FROM $tabelamov WHERE pvnumero=$pvnumeroDel";
        $movestoque = pg_query($sql);

        while (false != ($lista = pg_fetch_object($movestoque))) {
            $sql2 = "INSERT INTO $tblmovestoque (pvnumero,  movdata ,  procodigo,  movqtd, movvalor, movtipo, codestoque) VALUES ('$pvnumeroDel','$movdata','$lista->procodigo','$lista->movqtd','$lista->movvalor', '3', '$lista->codestoque')";
            $result = pg_query($sql2);
        }
        $retorno = new stdClass();
        $retorno->msgt = "MOVIMENTACAO CADASTRADA COM SUCESSO : " . $tblmovestoque;

        return $retorno;
    }

    /**
     * Metodo para efetuar a liberação de pedido no banco.
     * Executa update na tabela pvenda ver config.php lista de tabelas.
     *
     * @access public
     * @param PedidoVO $valor Recebe variavel tipada.
     * @return object Retorna objeto do tipo json;
     */
    public function liberacaoPedido(PedidoVO $pedido2, LogLiberacaoVO $logliberacao) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $record['pvnumero'] = $pedido2->pvnumero;
        $record['pvlibera'] = date("c"); //$pedido2->pvlibera;
        $record['pvhora'] = date("H:i"); //$pedido2->pvhora;
        $record['pvlibdep'] = $pedido2->pvlibdep;
        $record['pvlibvit'] = $pedido2->pvlibvit;
        $record['pvlibmat'] = $pedido2->pvlibmat;
        $record['pvlibfil'] = $pedido2->pvlibfil;
        $record['pvurgente'] = $pedido2->pvurgente;
        $record['pvencer2'] = '6';

//		$record2['lgldata'] = $logliberacao->lgldata;
//		$record2['lglhora'] = $logliberacao->lglhora;
        $record2['lgldata'] = date("Y-m-d H:i:s");
        $record2['lglhora'] = date("H:i:s");
        $record2['usucodigo'] = $logliberacao->usucodigo;
        $record2['clicodigo'] = $logliberacao->clicodigo;
        $record2['lglpedido'] = $logliberacao->lglpedido;
        $record2['lgltipo'] = $logliberacao->lgltipo;

        $verificaMovimentacao = $this->verificaMovimentacao($pedido2->pvnumero);

        $resultPrefec = $db->GetAll("SELECT fecdia FROM " . TABELA_PREFECHAMENTO . " WHERE pvnumero='$pedido2->pvnumero' 
                        AND fecforma = 101 AND fecdia = '0'");

        if ($resultPrefec) {
            foreach ($resultPrefec as $value) {
                $diasVenc = $resultPrefec['fecdia'];
            }
            $isDiaFechamentoZero = true;
        }

        if ($isDiaFechamentoZero == false) {
            if ($verificaMovimentacao == '1') {
                $flagVerificaPreco = $this->verificaPrecoPedido($pedido2->pvnumero);

                if ($flagVerificaPreco == '2') {
                    $listaPreco = $this->listaPrecosDiferentes($pedido2->pvnumero);
                } else {
                    $result = $db->AutoExecute(TABELA_PEDIDOS, $record, 'UPDATE', 'pvnumero=' . $pedido2->pvnumero);
                }
            } else {
                $result = false;
            }
        }


        $retorno = new stdClass();
        $retorno->pedido2 = $pedido2;

        if (!$result) {

//                        if($isDiaFechamentoZero == true){
//                            $msg = "NAO FOI POSSIVEL LIBERAR O PEDIDO. PREFECHAMENTO COM DIAS DE VENCIMENTO = 0";
//                            $retorno->codigo = '007';
//                        } else
//
            if ($listaPreco->parametro == '2') {
                $msg = "NAO FOI POSSIVEL LIBERAR O PEDIDO. ENTRE EM CONTATO COM O ADMINISTRADOR! CODIGO:424 ";
                $retorno->codigo = '424';
            } else {

                if ($logliberacao->lgltipo != 'I') {
                    $msg = "NAO FOI POSSIVEL LIBERAR O PEDIDO. ENTRE EM CONTATO COM O ADMINISTRADOR! CODIGO:2 ";
                    $retorno->codigo = '2';
                } else {
                    $resultlog = $db->AutoExecute(TABELA_LOGLIBERACAO, $record2, 'INSERT');
                    $msg = "PEDIDO LIBERADO COM SUCESSO!";
                    $retorno->mensagem = $msg;
                    $retorno->pedido2 = $pedido2;
                    $retorno->ver = $verificaMovimentacao;
                    $retorno->result = $result;
                    $retorno->resultlog = $resultlog;
                    $retorno->codigo = '0';
                }
            }
            $retorno->mensagem = $msg;
            $retorno->ver = $verificaMovimentacao;
            $retorno->result = $result;
            $retorno->erro = $listaPreco;
        } else {
            $resultlog = $db->AutoExecute(TABELA_LOGLIBERACAO, $record2, 'INSERT');
            $msg = "PEDIDO LIBERADO COM SUCESSO!";
            $retorno->mensagem = $msg;
            $retorno->pedido2 = $pedido2;
            $retorno->ver = $verificaMovimentacao;
            $retorno->result = $result;
            $retorno->resultlog = $resultlog;
            $retorno->codigo = '0';
        }
        return $retorno;
    }

    /**
     * Metodo para efetuar a liberação de pedido no banco.
     * Executa update na tabela pvenda ver config.php lista de tabelas.
     *
     * @access public
     * @param PedidoVO $valor Recebe variavel tipada.
     * @return object Retorna objeto do tipo json;
     */
    public function liberacaoPedido2(PedidoVO $pedido) {
        $conexao = new Conexao();
        $db = $conexao->connection();
        $retorno = new stdClass();


        $record['pvnumero'] = $pedido->pvnumero;
        $record['pvlibdep'] = $pedido->pvlibdep;
        $record['pvlibvit'] = $pedido->pvlibvit;
        $record['pvlibmat'] = $pedido->pvlibmat;
        $record['pvlibfil'] = $pedido->pvlibfil;





        $result = $db->AutoExecute(TABELA_PEDIDOS, $record, 'UPDATE', 'pvnumero=' . $pedido->pvnumero);

        if (!$result) {
            $retorno->localLiberacao = "NAO FOI POSSIVEL CADASTRAR O LOCAL DA LIBERACAO";
        } else {
            $retorno->localLiberacao = "LOCAL DA LIBERACAO CADASTRADO COM SUCESSO";
        }
        return $retorno;
    }

    /**
     * Metodo para efetuar a liberação de pedido no banco.
     * Executa update na tabela pvenda ver config.php lista de tabelas.
     *
     * @access public
     * @param PedidoVO $valor Recebe variavel tipada.
     * @return object Retorna objeto do tipo json;
     */
    public function liberacaoPedido424(PedidoVO $pedido2, LogLiberacaoVO $logliberacao) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $record['pvnumero'] = $pedido2->pvnumero;
        $record['pvlibera'] = date("c"); //$pedido2->pvlibera;
        $record['pvhora'] = date("H:i"); //$pedido2->pvhora;
        $record['pvlibdep'] = $pedido2->pvlibdep;
        $record['pvlibvit'] = $pedido2->pvlibvit;
        $record['pvlibmat'] = $pedido2->pvlibmat;
        $record['pvlibfil'] = $pedido2->pvlibfil;
        $record['pvurgente'] = $pedido2->pvurgente;
        $record['pvencer2'] = '6';


//		$record2['lgldata'] = $logliberacao->lgldata;
//		$record2['lglhora'] = $logliberacao->lglhora;
        $record2['lgldata'] = date("Y-m-d H:i:s");
        $record2['lglhora'] = date("H:i:s");
        $record2['usucodigo'] = $logliberacao->usucodigo;
        $record2['clicodigo'] = $logliberacao->clicodigo;
        $record2['lglpedido'] = $logliberacao->lglpedido;
        $record2['lgltipo'] = $logliberacao->lgltipo;

        $result = $db->AutoExecute(TABELA_PEDIDOS, $record, 'UPDATE', 'pvnumero=' . $pedido2->pvnumero);

        $retorno = new stdClass();
        $retorno->pedido2 = $pedido2;
        if (!$result) {
            $msg = "NAO FOI POSSIVEL LIBERAR O PEDIDO";
            $retorno->mensagem = $msg;
        } else {


            $dataLiberacao = date("d-m-Y H:i:s");
            $filename = DIR_LOGS . '/preco/' . $pedido2->pvlocal . '.txt';
            $conteudo = "USUARIO LIBERACAO: $pedido2->usuario - $dataLiberacao";

            if (is_writable($filename)) {

                if (!$handle = fopen($filename, 'a')) {
                    echo "Não foi possível abrir o arquivo ($filename)";
                    exit;
                }

                // Escreve $conteudo no nosso arquivo aberto.
                if (fwrite($handle, $conteudo) === FALSE) {
                    echo "Não foi possível escrever no arquivo ($filename)";
                    exit;
                }

                $arq = "Sucesso: Escrito ($conteudo) no arquivo ($filename)";

                fclose($handle);
            } else {
                $arq = "O arquivo $filename não pode ser alterado";
            }


            $resultlog = $db->AutoExecute(TABELA_LOGLIBERACAO, $record2, 'INSERT');
            $msg = "PEDIDO LIBERADO COM SUCESSO!" . $pedido2->arquivo;
            $retorno->mensagem = $msg;
            $retorno->resultlog = $resultlog;
            $retorno->log = $arq;
        }
        return $retorno;
    }

    /**
     * Metodo para efetuar a liberação de pedido no banco.
     * Executa update na tabela pvenda ver config.php lista de tabelas.
     *
     * @access public
     * @param PedidoVO $valor Recebe variavel tipada.
     * @return object Retorna objeto do tipo json;
     */
    public function liberaPedidoAbastecimento($pvnumero, $pvlibdep, $pvlibvit, $pvlibmat, $pvlibfil, $pvurgente) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $pvlibera = date("Y-m-d H:i:s");
        $pvhora = date("H:i");

        $sql = "UPDATE " . TABELA_PEDIDOS . " SET pvlibera='$pvlibera', pvhora='$pvhora',pvlibdep='$pvlibdep',pvlibvit='$pvlibvit',pvlibmat='$pvlibmat',pvlibfil='$pvlibfil' WHERE pvnumero='$pvnumero'";
        $result = $db->Execute($sql);

        $retorno = new stdClass();

        if (!$result) {
            $msg = "[" . date('d.m.Y H:i:s') . "] ERRO: LIBERACAO PEDIDO $pvnumero. " . $db->ErrorMsg();
            $retorno->mensagem = $msg;
        } else {
            $msg = "[" . date('d.m.Y H:i:s') . "] OK: LIBERACAO PEDIDO $pvnumero. ";
            $retorno->mensagem = $msg;
            $retorno->pvnumero = $pvnumero;
        }
        return $retorno;
    }

    /**
     * Metodo para efetuar a liberação de pedido no banco.
     * Executa update na tabela pvenda ver config.php lista de tabelas.
     *
     * @access public
     * @param PedidoVO $valor Recebe variavel tipada.
     * @return object Retorna objeto do tipo json;
     */
    public function exluiPreFechamentoAnterior($pvnumero) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $retorno = new stdClass();

        $sql1 = "select * from prefechamento where pvnumero='$pvnumero'";
        $result1 = $db->Execute($sql1);

        while (!$result1->EOF) {
            $preFechamento = new PreFechamentoVO();
            $preFechamento->prefeccodigo = $result1->fields[0];
            $preFechamento->fecdata = $result1->fields[1];
            $preFechamento->pvnumero = $result1->fields[2];
            $preFechamento->fecforma = $result1->fields[3];
            $preFechamento->fecdocto = $result1->fields[4];
            $preFechamento->fecbanco = $result1->fields[5];
            $preFechamento->fecvalor = $result1->fields[6];
            $preFechamento->fecvecto = $result1->fields[7];
            $preFechamento->clicodigo = $result1->fields[8];
            $preFechamento->vencodigo = $result1->fields[9];
            $preFechamento->fectipo = $result1->fields[10];
            $preFechamento->fecagencia = $result1->fields[11];
            $preFechamento->fecempresa = $result1->fields[12];
            $preFechamento->feccaixa = $result1->fields[13];
            $preFechamento->feccartao = $result1->fields[14];
            $preFechamento->fecconta = $result1->fields[15];
            $preFechamento->fecdia = $result1->fields[16];

            if ($preFechamento->fecforma == '105') {
                $sqlU = "UPDATE " . TABELA_DEVOLUCAO . " SET PVBAIXA=null WHERE pvvale='$preFechamento->fecdocto'";
                $db->Execute($sqlU);


                $lgvdata = date('Y-m-d h:i');
                $lgvtpoperacao = 'E';
                $pvvale = "pvvale";

                $sqlVale = "INSERT INTO logvale (lgvdata,lgvtpoperacao,pvvale,pvnumero
                                        ) VALUES ('$lgvdata','$lgvtpoperacao','$preFechamento->fecdocto','$preFechamento->pvnumero') ";
                pg_query($sqlVale);
            }

            $result1->MoveNext();
        }

        $conexao2 = new Conexao();
        $db2 = $conexao2->connection();

        $sql2 = "DELETE FROM PREFECHAMENTO WHERE PVNUMERO='$pvnumero'";
        $result2 = $db2->Execute($sql2);

        if (!$result2) {
            $msg = "[" . date('d.m.Y H:i:s') . "] ERRO: EXCLUSAO PRE FECHAMENTO $pvnumero. " . $db->ErrorMsg();
            $retorno->mensagem = $msg;
            $retorno->retorno = false;
        } else {
            $sql3 = "DELETE FROM PEDPARCELAS WHERE PVNUMERO='$pvnumero'";
            $result3 = $db2->Execute($sql3);

            $msg = "[" . date('d.m.Y H:i:s') . "] OK: EXCLUSAO PRE FECHAMENTO $pvnumero.";
            $retorno->mensagem = $msg;
            $retorno->retorno = true;
        }

        return $retorno;
    }

    /**
     * Metodo para efetuar inserção do pedido no banco.
     * Executa insert na tabela de pedido ver config.php lista de tabelas.
     *
     * @access public
     * @param PedidoVO $valor Recebe variavel do tipo Pedido Value Object.
     * @return object Retorna objeto com informações da resposta do banco;
     */
    public function corrigeParcelaPrefechamento($pvnumero) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $sqlVerificaQtParcelas = "select prefeccodigo, fecforma,fecdia,fecdocto from prefechamento WHERE pvnumero='$pvnumero' AND fecforma = '101' order by fecdia";
        $resultVerificaQtParcelas = $db->GetAll($sqlVerificaQtParcelas);

        $sqlVerificaCalculoParcela = "select cc.inicial,cc.salto from pvenda pv left join condcomerciais cc on cc.codigo = pv.pvcondcon where pvnumero ='$pvnumero' ";
        $resultVerificaCalculoParcela = $db->Execute($sqlVerificaCalculoParcela);

        //                echo "<pre>";
        //                print_r($resultVerificaQtParcelas);
        //                echo "</pre>";

        $qtParcelas = sizeof($resultVerificaQtParcelas);

        //   echo  "\n qtParcelas: $qtParcelas \n";
        if ($qtParcelas != 0 && $qtParcelas != '') {
            //selecionar cada fecdocto e alterar apenas a ultima letra para que a sequencia alfabetica não se quebre
            $novoFecData = date("Y-m-d");

            for ($index = 0; $index < $qtParcelas; $index++) {

                if ($index === 0) {
                    $dias = $resultVerificaCalculoParcela->fields [0];
                } else {
                    $dias += $resultVerificaCalculoParcela->fields [1];
//                                                    $dias = ($resultVerificaCalculoParcela ->fields [1])*($index+1);
                }

                $dataVectParcela = mktime(0, 0, 0, date("m"), date("d") + $dias, date("Y"));
                $novoFecVecto = date("Y-m-d", $dataVectParcela);

                //pegar somente o fecdocto que for 101
                $fecdoctoSemIndicadorParcela = substr($resultVerificaQtParcelas[$index][3], 0, -1);
                $codigoParcela = 65 + $index;
                $novoFecdocto = $fecdoctoSemIndicadorParcela . chr($codigoParcela);
                $prefeccodigoAtualiza = $resultVerificaQtParcelas[$index][0];

                if ($resultVerificaQtParcelas[$index][1] == '101') {
                    $recordPrefechamento['fecdocto'] = $novoFecdocto;
                }
                $recordPrefechamento['fecdata'] = $novoFecData;
                //$recordPrefechamento['fecvecto'] = $novoFecVecto;
                $recordPrefechamento['fecdia'] = $dias;

                //                                $sqlReajustaFecdocto = "UPDATE ".TABELA_PREFECHAMENTO." SET fecdocto='$novoFecdocto', fecdata = '$novoFecData'  WHERE prefeccodigo='$prefeccodigoAtualiza'";

                $sqlReajustaFecdocto = $db->AutoExecute(TABELA_PREFECHAMENTO, $recordPrefechamento, 'UPDATE', 'prefeccodigo=' . $prefeccodigoAtualiza);

                //                                $resultReajustaFecdocto = $db->Execute($sqlReajustaFecdocto);
            }
        }
    }

    public function baixaParcela2($fecdocto, $clicodigo, $pvnumero, $prefeccodigo, $fecforma) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $qtParcelas = 0;
        $resultVale = true;


        if ($fecforma == '105') {
            $sqlVale = "UPDATE " . TABELA_DEVOLUCAO . " SET pvbaixa=null  WHERE pvvale='$fecdocto'";
            $resultVale = $db->Execute($sqlVale);

            $lgvdata = date('Y-m-d h:i');
            $lgvtpoperacao = 'E';
            $pvvale = "pvvale";

            $sqlVale = "INSERT INTO logvale (lgvdata,lgvtpoperacao,pvvale,pvnumero
                                ) VALUES ('$lgvdata','$lgvtpoperacao','$fecdocto','$pvnumero') ";
            pg_query($sqlVale);
        }

        $sql = "DELETE FROM " . TABELA_PREFECHAMENTO . " where prefeccodigo='$prefeccodigo' ";
        $result = $db->Execute($sql);

        if (!$resultVale) {
            $msg = "HOUVE FALHAS NA EXCLUSAO DO VALE. \n" . $db->ErrorMsg();
            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        } else {

            $sql2 = "SELECT devolucao.pvnumero as numero, devolucao.dvnumero, devolucao.pvbaixa, (select sum(pvipreco*pvidevol)
			FROM dvitem
			WHERE devolucao.pvvale = dvitem.pvvale) as valor,
			0 as desconto, devolucao.pvemissao as emissao, devolucao.pvdevolucao as devolucao, devolucao.pvvale as vale,
			(CASE WHEN clientes.clicod isnull THEN fornecedor.forcodigo ELSE clientes.clicod END) as cliente,
			(CASE WHEN clientes.clirazao isnull THEN fornecedor.forrazao ELSE clientes.clirazao END) as razao,
			pvenda.vencodigo as vendedor

			FROM devolucao
			LEFT JOIN pvenda on devolucao.pvnumero=pvenda.pvnumero
			LEFT JOIN clientes on pvenda.clicodigo = clientes.clicodigo
			LEFT JOIN fornecedor on pvenda.clicodigo = fornecedor.forcodigo

			WHERE devolucao.pvbaixa isnull and clientes.clicodigo='$clicodigo'
			ORDER BY devolucao.pvnumero,devolucao.pvvale asc";

            $result2 = $db->Execute($sql2);




            $retorno = new stdClass();
            if (!$result2) {
                $msg = $sql . "Falha na conexao com banco de dados! " . $db->ErrorMsg();
                $retorno->retorno = false;
                $retorno->mensagem = $msg;
            }

            while (!$result2->EOF) {
                $vale = new ValeVO();
                $vale->numero = trim($result2->fields[0]);
                $vale->dvnumero = trim($result2->fields[1]);
                $vale->pvbaixa = trim($result2->fields[2]);
                $vale->valor = trim($result2->fields[3]);
                $vale->desconto = trim($result2->fields[4]);
                $vale->emissao = trim($result2->fields[5]);
                $vale->devolucao = trim($result2->fields[6]);
                $vale->vale = trim($result2->fields[7]);
                $vale->cliente = trim($result2->fields[8]);
                $vale->razao = trim($result2->fields[9]);
                $vale->vendedor = trim($result2->fields[10]);

                $vales[$vale->dvnumero] = $vale;



                $result2->MoveNext();
            }


            $this->corrigeParcelaPrefechamento($pvnumero);

            $sql4 = "select prefeccodigo,
				  to_char(fecdata, 'dd/mm/yyyy') as fecdata,
				  pvnumero,
				  fecforma,
				  fecdocto,
				  fecbanco,
				  fecvalor,
				  to_char(fecvecto, 'dd/mm/yyyy') as fecvecto,
				  clicodigo,
				  vencodigo,
				  fectipo,
				  fecagencia,
				  fecempresa,
				  feccaixa,
				  feccartao,
				  fecconta,
				  fecdia 
				from prefechamento where pvnumero='$pvnumero' order by fecdia,fecvecto,fecforma";

            $result4 = $db->Execute($sql4);

            while (!$result4->EOF) {
                $preFechamento = new PreFechamentoVO();
                $preFechamento->prefeccodigo = $result4->fields[0];
                $preFechamento->fecdata = $result4->fields[1];
                $preFechamento->pvnumero = $result4->fields[2];
                $preFechamento->fecforma = $result4->fields[3];
                $preFechamento->fecdocto = $result4->fields[4];
                $preFechamento->fecbanco = $result4->fields[5];
                $preFechamento->fecvalor = $result4->fields[6];
                $preFechamento->fecvecto = $result4->fields[7];
                $preFechamento->clicodigo = $result4->fields[8];
                $preFechamento->vencodigo = $result4->fields[9];
                $preFechamento->fectipo = $result4->fields[10];
                $preFechamento->fecagencia = $result4->fields[11];
                $preFechamento->fecempresa = $result4->fields[12];
                $preFechamento->feccaixa = $result4->fields[13];
                $preFechamento->feccartao = $result4->fields[14];
                $preFechamento->fecconta = $result4->fields[15];
                $preFechamento->fecdia = $result4->fields[16];

                $preFechamentos[$preFechamento->prefeccodigo] = $preFechamento;

                $result4->MoveNext();
            }

            $msg = "EXCLUIDO COM SUCESSO ";
            $retorno->retorno = true;
            $retorno->mensagem = $msg;
            $retorno->vales = $vales;
            $retorno->preFechamentos = $preFechamentos;
            $row = $db->GetRow("SELECT sum(fecvalor) as valortotal FROM " . TABELA_PREFECHAMENTO . " WHERE pvnumero='$pvnumero' ");
            $retorno->total += $row['valortotal'];
        }
        return $retorno;
    }

    public function preFechamento(ItemFormaPagamentoVO $itemFormaPagamento) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $record['fecdata'] = $itemFormaPagamento->fecdata;
        $record['pvnumero'] = $itemFormaPagamento->pvnumero;
        $record['fecforma'] = $itemFormaPagamento->fecforma;
        $record['fecdocto'] = $itemFormaPagamento->fecdocto;
        $record['fecbanco'] = $itemFormaPagamento->fecbanco;
        $record['fecvalor'] = $itemFormaPagamento->fecvalor;

        if ($record['fecforma'] == '103') {
            $record['fecvecto'] = $itemFormaPagamento->fecvecto;
        }
// echo "\n record['fecvecto']: ".$record['fecvecto'] . "\n";
        $record['clicodigo'] = $itemFormaPagamento->clicodigo;
        $record['vencodigo'] = $itemFormaPagamento->vencodigo;
        $record['fectipo'] = $itemFormaPagamento->fectipo;
        $record['fecagencia'] = $itemFormaPagamento->fecagencia;
        $record['fecempresa'] = $itemFormaPagamento->fecempresa;
        $record['feccaixa'] = $itemFormaPagamento->feccaixa;
        $record['feccartao'] = $itemFormaPagamento->feccartao;
        $record['fecconta'] = $itemFormaPagamento->fecconta;
        $record['fecdia'] = $itemFormaPagamento->fecdia;


        $record['valorst'] = $itemFormaPagamento->valorst;

        $record['usu_criacao'] = $itemFormaPagamento->usu_criacao;

        if ($itemFormaPagamento->usu_edicao_salto != '') {
            $record['usu_edicao_salto'] = $itemFormaPagamento->usu_criacao;
        }

        $dtVenc = '';
        $diasVenc = '';


        $resultinsert = $db->AutoExecute(TABELA_PREFECHAMENTO, $record, 'INSERT');

        if ($itemFormaPagamento->fecforma == '105') {
            $pvbaixa = date("Y-m-d H:i:s");
            $sqlU = "UPDATE " . TABELA_DEVOLUCAO . " SET pvbaixa='$pvbaixa' WHERE pvvale=$itemFormaPagamento->fecdocto";
            $db->Execute($sqlU);

            $lgvdata = date('Y-m-d h:i');
            $lgvtpoperacao = 'I';
            $usucodigo = $itemFormaPagamento->usu_criacao;
            $pvvale = "pvvale";

            $sqlVale = "INSERT INTO logvale (lgvdata,usucodigo,lgvtpoperacao,pvvale,pvnumero
                                        ) VALUES ('$lgvdata','$usucodigo','$lgvtpoperacao','$itemFormaPagamento->fecdocto','$itemFormaPagamento->pvnumero') ";
            pg_query($sqlVale);

            //$fecdia ='1';
            //$sqlDia = "UPDATE ".TABELA_PREFECHAMENTO." SET fecdia='$fecdia' WHERE pvnumero='$itemFormaPagamento->pvnumero' AND fecforma=='105'";
            //$db->Execute($sqlDia);
        }

//if ( $itemFormaPagamento->fecforma == '101' || $itemFormaPagamento->fecforma == '103')

        $row = $db->GetRow("SELECT fecvecto, fecdia FROM " . TABELA_PREFECHAMENTO . " WHERE pvnumero='$itemFormaPagamento->pvnumero' ");
//    $dtVenc = $row['fecvecto'];
        $diasVenc = $row['fecdia'];

        $retorno = new stdClass();

        $retorno->itemFormaPagamento = $itemFormaPagamento;

        if (!$resultinsert) {
            $msg = "HOUVE FALHAS NO CADASTRO DE PREFECHAMENTO, NAO FOI POSSIVEL FAZER O PREFECHAMENTO. \n" . $db->ErrorMsg();
            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        } else if (($itemFormaPagamento->fecforma == '101') && ($diasVenc == '0')) {
            $sql = "DELETE FROM " . TABELA_PREFECHAMENTO . " WHERE pvnumero='$itemFormaPagamento->pvnumero'";
            $resultDelete = $db->Execute($sql);

            $msg = "HOUVE FALHAS NO CADASTRO DE PREFECHAMENTO, NAO FOI POSSIVEL FAZER O PREFECHAMENTO. \nDIA VENCIMENTO = 0";
            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        } else {
//			$this->corrigeParcelaPrefechamento($itemFormaPagamento->pvnumero);
            $msg = "PREFECHAMENTO REALIZADO COM SUCESSO ";
            $retorno->retorno = true;
            $retorno->mensagem = $msg;

            $retorno->itemFormaPagamento = $itemFormaPagamento;
        }
        $row = $db->GetRow("SELECT sum(fecvalor) as valortotal FROM " . TABELA_PREFECHAMENTO . " WHERE pvnumero='$itemFormaPagamento->pvnumero' ");
        $retorno->total += $row['valortotal'];
        return $retorno;
    }

    public function alteraParcelaPreFechamento(ItemFormaPagamentoVO $itemFormaPagamento) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $record['prefeccodigo'] = $itemFormaPagamento->prefeccodigo;
        $record['fecdata'] = $itemFormaPagamento->fecdata;
        $record['pvnumero'] = $itemFormaPagamento->pvnumero;
        $record['fecforma'] = $itemFormaPagamento->fecforma;
        $record['fecdocto'] = $itemFormaPagamento->fecdocto;
        $record['fecbanco'] = $itemFormaPagamento->fecbanco;
        $record['fecvalor'] = $itemFormaPagamento->fecvalor;
//			$record['fecvecto'] = $itemFormaPagamento->fecvecto;
        $record['clicodigo'] = $itemFormaPagamento->clicodigo;
        $record['vencodigo'] = $itemFormaPagamento->vencodigo;
        $record['fectipo'] = 'A';
        $record['fecagencia'] = $itemFormaPagamento->fecagencia;
        $record['fecempresa'] = '1';
        $record['feccaixa'] = '0';
        $record['feccartao'] = $itemFormaPagamento->feccartao;
        $record['fecconta'] = $itemFormaPagamento->fecconta;
        $record['fecdia'] = $itemFormaPagamento->fecdia;

        $record['usu_edicao'] = $itemFormaPagamento->usu_edicao;

        $record['data_usu_edicao'] = date("Y-m-d H:i:s");

        if ($itemFormaPagamento->usu_edicao_salto != '') {
            $record['usu_edicao_salto'] = $itemFormaPagamento->usu_edicao;
        }

        $result = $db->AutoExecute(TABELA_PREFECHAMENTO, $record, 'UPDATE', 'prefeccodigo=' . $itemFormaPagamento->prefeccodigo);

        $retorno = new stdClass();

        $retorno->itemFormaPagamento = $itemFormaPagamento;

        if (!$result) {
            $msg = "HOUVE FALHAS NO CADASTRO DE PREFECHAMENTO, NAO FOI POSSIVEL FAZER O PREFECHAMENTO. \n" . $db->ErrorMsg();
            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        } else {


            $msg = "PREFECHAMENTO REALIZADO COM SUCESSO ";
            $retorno->retorno = true;
            $retorno->mensagem = $msg;

            $retorno->itemFormaPagamento = $itemFormaPagamento;
        }
        $row = $db->GetRow("SELECT sum(fecvalor) as valortotal FROM " . TABELA_PREFECHAMENTO . " WHERE pvnumero='$itemFormaPagamento->pvnumero' ");
        $retorno->total = $row['valortotal'];
        return $retorno;
    }

    public function getPreFechamento($pvnumero) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $sql = "select prefeccodigo,
			  to_char(fecdata, 'dd/mm/yyyy') as fecdata,
			  pvnumero,
			  fecforma,
			  fecdocto,
			  fecbanco,
			  fecvalor,
			  to_char(fecvecto, 'dd/mm/yyyy') as fecvecto,
			  clicodigo,
			  vencodigo,
			  fectipo,
			  fecagencia,
			  fecempresa,
			  feccaixa,
			  feccartao,
			  fecconta,
			  fecdia 
				from prefechamento where pvnumero='$pvnumero' order by fecdia,fecvecto,fecforma";

        $result = $db->Execute($sql);

        $retorno = new stdClass();

        if (!$result) {
            $msg = "FALHA NA CONEXAO COM BANCO DE DADOS " . $db->ErrorMsg();

            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        }
        while (!$result->EOF) {
            $preFechamento = new PreFechamentoVO();
            $preFechamento->prefeccodigo = $result->fields[0];
            $preFechamento->fecdata = $result->fields[1];
            $preFechamento->pvnumero = $result->fields[2];
            $preFechamento->fecforma = $result->fields[3];
            $preFechamento->fecdocto = $result->fields[4];
            $preFechamento->fecbanco = $result->fields[5];
            $preFechamento->fecvalor = $result->fields[6];
            $preFechamento->fecvecto = $result->fields[7];
            $preFechamento->clicodigo = $result->fields[8];
            $preFechamento->vencodigo = $result->fields[9];
            $preFechamento->fectipo = $result->fields[10];
            $preFechamento->fecagencia = $result->fields[11];
            $preFechamento->fecempresa = $result->fields[12];
            $preFechamento->feccaixa = $result->fields[13];
            $preFechamento->feccartao = $result->fields[14];
            $preFechamento->fecconta = $result->fields[15];
            $preFechamento->fecdia = $result->fields[16];

            $preFechamentos[$preFechamento->prefeccodigo] = $preFechamento;

            $result->MoveNext();
        }

        if (is_array($preFechamentos) && count($preFechamentos)) {
            $msg = "LOCALIZADO(S) " . count($preFechamentos) . " PEDIDO(S). ";

            $retorno->retorno = true;
            $retorno->mensagem = $msg;
            $retorno->preFechamentos = $preFechamentos;
            $row = $db->GetRow("SELECT sum(fecvalor) as valortotal FROM " . TABELA_PREFECHAMENTO . " WHERE pvnumero='$preFechamento->pvnumero' ");
            $retorno->total = $row['valortotal'];
        } else {
            $msg = "NAO FOI POSSIVEL LOCALIZAR PEDIDO(S). ";

            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        }

        //$retorno->mensagem .= $retornoItensPedido->mensagem;

        return $retorno;
    }

    public function getCobranca($pvnumero) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $sql = "select a.cobcodigo,a.cobnumero,to_char(a.cobemissao,'DD/MM/YYYY') as cobemissao,to_char(a.cobvecto,'DD/MM/YYYY') as cobvecto,a.cobvalor,to_char(a.cobrecebto,'DD/MM/YYYY') as cobrecebto,a.cobtipo,a.clicodigo,a.cobbanco,a.cobagencia,
				a.cobcheque,a.cobconta,a.cobpago,a.cobjuros,a.cobmulta,a.cobdesconto,a.cobsituacao,to_char(a.cobdeposito,'DD/MM/YYYY') as cobdeposito,
				to_char(a.cobcompensacao,'DD/MM/YYYY') as cobcompensacao,
				to_char(a.cobdevolucao,'DD/MM/YYYY') as cobdevolucao,
				to_char(a.cobcancelamento,'DD/MM/YYYY') as cobcancelamento,
				a.analise,a.pvnumero
				from cobranca a  where a.pvnumero='$pvnumero' ORDER BY a.cobcodigo";

        $result = $db->Execute($sql);

        $retorno = new stdClass();

        if (!$result) {
            $msg = "FALHA NA CONEXAO COM BANCO DE DADOS " . $db->ErrorMsg();

            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        }
        while (!$result->EOF) {
            $cobranca = new CobrancaVO();
            $cobranca->cobcodigo = $result->fields[0];
            $cobranca->cobnumero = $result->fields[1];
            $cobranca->cobemissao = $result->fields[2];
            $cobranca->cobvecto = $result->fields[3];
            $cobranca->cobvalor = $result->fields[4];
            $cobranca->cobrecebto = $result->fields[5];
            $cobranca->cobtipo = $result->fields[6];
            $cobranca->clicodigo = $result->fields[7];
            $cobranca->cobbanco = $result->fields[8];
            $cobranca->cobagencia = $result->fields[9];
            $cobranca->cobcheque = $result->fields[10];
            $cobranca->cobconta = $result->fields[11];
            $cobranca->cobpago = $result->fields[12];
            $cobranca->cobjuros = $result->fields[13];
            $cobranca->cobmulta = $result->fields[14];
            $cobrancais->cobdesconto = $result->fields[15];
            $cobrancahis->cobsituacao = $result->fields[16];
            $cobranca->cobdeposito = $result->fields[17];
            $cobranca->cobcompensacao = $result->fields[18];
            $cobranca->cobdevolucao = $result->fields[19];
            $cobranca->cobcancelamento = $result->fields[20];
            $cobranca->analise = $result->fields[21];
            $cobranca->pvnumero = $result->fields[22];

            $cobrancas[$cobranca->cobcodigo] = $cobranca;

            $result->MoveNext();
        }

        if (is_array($cobrancas) && count($cobrancas)) {
            $msg = "LOCALIZADO(S) " . count($cobrancas) . " PEDIDO(S). ";

            $retorno->retorno = true;
            $retorno->mensagem = $msg;
            $retorno->cobranca = $cobrancas;
        } else {
            $msg = "NAO FOI POSSIVEL LOCALIZAR PEDIDO(S). ";

            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        }

        //$retorno->mensagem .= $retornoItensPedido->mensagem;

        return $retorno;
    }

    public function cobranca(CobrancaVO $cobranca) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $record['fecdata'] = $cobranca->fecdata;
        $record['pvnumero'] = $cobranca->pvnumero;
        $record['fecforma'] = $cobranca->fecforma;
        $record['fecdocto'] = $cobranca->fecdocto;
        $record['fecbanco'] = $cobranca->fecbanco;
        $record['fecvalor'] = $cobranca->fecvalor;
        $record['fecvecto'] = $cobranca->fecvecto;
        $record['clicodigo'] = $cobranca->clicodigo;
        $record['vencodigo'] = $cobranca->vencodigo;
        $record['fectipo'] = $cobranca->fectipo;
        $record['fecagencia'] = $cobranca->fecagencia;
        $record['fecempresa'] = $cobranca->fecempresa;
        $record['feccaixa'] = $cobranca->feccaixa;
        $record['feccartao'] = $cobranca->feccartao;
        $record['fecconta'] = $cobranca->fecconta;
        $record['fecdia'] = $cobranca->fecdia;

        $resultinsert = $db->AutoExecute(TABELA_PREFECHAMENTO, $record, 'INSERT');
        $retorno = new stdClass();
        $retorno->itemFormaPagamento = $itemFormaPagamento;

        if (!$resultinsert) {
            $msg = "HOUVE FALHAS NO CADASTRO DE PREFECHAMENTO, NAO FOI POSSIVEL FAZER O PREFECHAMENTO. \n" . $db->ErrorMsg();
            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        } else {
            $msg = "PREFECHAMENTO REALIZADO COM SUCESSO ";
            $retorno->retorno = true;
            $retorno->mensagem = $msg;

            $retorno->itemFormaPagamento = $itemFormaPagamento;
        }
        $row = $db->GetRow("SELECT sum(fecvalor) as valortotal FROM " . TABELA_PREFECHAMENTO . " WHERE pvnumero='$itemFormaPagamento->pvnumero' ");
        $retorno->total += $row['valortotal'];
        return $retorno;
    }

    public function destravaPedido2($pvnumero) {
        $conexao = new Conexao();
        $db = $conexao->connection();
        $sit = 't';
        $sql = "UPDATE " . TABELA_PEDIDOS . " SET pvsituacao='$sit' AND usucodigo=null WHERE pvnumero='$pvnumero' ";

        $result = $db->Execute($sql);

        if (!$result) {
            $msg = $sql . "NAO FOI POSSIVEL DESTRVAR O PEDIDO. " . $db->ErrorMsg();
            $retorno->mensagem = $msg;
            $retorno->retorno = false;
        } else {
            $msg = "DESTRAVADO COM SUCESSO. PEDIDO N. " . $pvnumero . ". ";
            $retorno->retorno = true;
            $retorno->mensagem = $msg;
        }

        return $retorno;
    }

    public function alteraCondicao($pvcondcon, $pvnumero) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $sql = "UPDATE " . TABELA_PEDIDOS . " SET pvcondcon='$pvcondcon' WHERE pvnumero='$pvnumero' ";

        $result = $db->Execute($sql);

        if (!$result) {
            $msg = $sql . "NAO FOI POSSIVEL EFETUAR ALTERACAO. " . $db->ErrorMsg();
            $retorno->mensagem = $msg;
            $retorno->retorno = false;
        } else {
            //$sqllista = "SELECT  * FROM ".TABELA_PREFECHAMENTO." WHERE pvnumero = '$pvnumero'";
            //$resultlista = $db->Execute($sqllista);
            //if(count($resultlista)!=0)
            //{
            //$sqldel = "DELETE FROM ".TABELA_PREFECHAMENTO." WHERE pvnumero = '$pvnumero'";
            //$resultdel = $db->Execute($sqldel);

            $msg = "ALTERADO O PEDIDO N. " . $pvnumero . ". ";
            $retorno->retorno = true;
            $retorno->mensagem = $msg;
        }

        return $retorno;
    }

    public function logAlteraStatus($pvnumero, $status, $usucodigo) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $record['lgpsdata'] = date("Y-m-d H:i:s");
        $record['usucodigo'] = $usucodigo;
        $record['pvnumero'] = $pvnumero;
        $record['lgpsstatus'] = $status;
        $result = $db->AutoExecute(TABELA_LOG_PEDIDO_STATUS, $record, 'INSERT');

        if (!$result) {
            return false;
        } else {
            return true;
        }
    }

    public function alteraStatus($pvnumero, $status, $usucodigo) {
        $conexao = new Conexao();
        $db = $conexao->connection();


        $sql = "UPDATE " . TABELA_PEDIDOS . " SET pvencer2='$status' WHERE pvnumero='$pvnumero'";

        $result = $db->Execute($sql);

        if (!$result) {
            $msg = $sql . "NAO FOI POSSIVEL EFETUAR ALTERACAO. " . $db->ErrorMsg();
            $retorno->mensagem = $msg;
            $retorno->retorno = false;
        } else {

            $this->logAlteraStatus($pvnumero, $status, $usucodigo);

            $msg = "ALTERADO O PEDIDO N. " . $pvnumero . ". ";
            $retorno->retorno = true;
            $retorno->mensagem = $msg;
        }

        return $retorno;
    }

    public function pedParcela($pedParcela) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $record['pvnumero'] = $pedParcela->pvnumero;
        $record['parcelas'] = $pedParcela->parcelas;
        $record['tipoparcelas'] = $pedParcela->tipoparcelas;
        $record['parcela1'] = $pedParcela->parcela1;
        $record['parcela2'] = $pedParcela->parcela2;
        $record['parcela3'] = $pedParcela->parcela3;
        $record['parcela4'] = $pedParcela->parcela4;
        $record['parcela5'] = $pedParcela->parcela5;
        $record['parcela6'] = $pedParcela->parcela6;
        $record['parcela7'] = $pedParcela->parcela7;
        $record['parcela8'] = $pedParcela->parcela8;
        $record['parcela9'] = $pedParcela->parcela9;
        $record['parcela10'] = $pedParcela->parcela10;
        $record['parcela11'] = $pedParcela->parcela11;
        $record['parcela12'] = $pedParcela->parcela12;
        $record['parcdata1'] = $pedParcela->parcdata1;
        $record['parcdata2'] = $pedParcela->parcdata2;
        $record['parcdata3'] = $pedParcela->parcdata3;
        $record['parcdata4'] = $pedParcela->parcdata4;
        $record['parcdata5'] = $pedParcela->parcdata5;
        $record['parcdata6'] = $pedParcela->parcdata6;
        $record['parcdata7'] = $pedParcela->parcdata7;
        $record['parcdata8'] = $pedParcela->parcdata8;
        $record['parcdata9'] = $pedParcela->parcdata9;
        $record['parcdata10'] = $pedParcela->parcdata10;
        $record['parcdata11'] = $pedParcela->parcdata11;
        $record['parcdata12'] = $pedParcela->parcdata12;
        $record['parcdia1'] = $pedParcela->parcdia1;
        $record['parcdia2'] = $pedParcela->parcdia2;
        $record['parcdia3'] = $pedParcela->parcdia3;
        $record['parcdia4'] = $pedParcela->parcdia4;
        $record['parcdia5'] = $pedParcela->parcdia5;
        $record['parcdia6'] = $pedParcela->parcdia6;
        $record['parcdia7'] = $pedParcela->parcdia7;
        $record['parcdia8'] = $pedParcela->parcdia8;
        $record['parcdia9'] = $pedParcela->parcdia9;
        $record['parcdia10'] = $pedParcela->parcdia10;
        $record['parcdia11'] = $pedParcela->parcdia11;
        $record['parcdia12'] = $pedParcela->parcdia12;

        $result = $db->AutoExecute(TABELA_PEDIDO_PARCELAS, $record, 'INSERT');
        $retorno = new stdClass();
        $retorno->pedParcelas = $pedParcela;

        if (!$result) {
            $msg = "HOUVE FALHAS NO CADASTRO DE PREFECHAMENTO, NAO FOI POSSIVEL FAZER CADASTRAR NA TABELA PEDPARCELA. \n" . $db->ErrorMsg();
            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        } else {
            $msg = "PREFECHAMENTO REALIZADO COM SUCESSO ";
            $retorno->retorno = true;
            $retorno->mensagem = $msg;
            $retorno->pedParcelas = $pedParcelas;
        }
        return $retorno;
    }

    /**
     * Metodo para efetuar pesquisa dos pedidos no banco.
     * Executa select na tabela pvitembeta ver config.php lista de tabelas.
     *
     * @access public
     * @param integer pvnumero lista item pedidos
     * @return object Retorna objetos do tipo json;
     */
    public function todosVales($clicodigo) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $sql = "SELECT devolucao.pvnumero as numero, devolucao.dvnumero, devolucao.pvbaixa, (select sum(pvipreco*pvidevol)
			FROM dvitem 
			WHERE devolucao.pvvale = dvitem.pvvale) as valor,
			pvenda.pvperdesc as desconto, devolucao.pvemissao as emissao, devolucao.pvdevolucao as devolucao, devolucao.pvvale as vale,
			(CASE WHEN clientes.clicod isnull THEN fornecedor.forcodigo ELSE clientes.clicod END) as cliente, 
			(CASE WHEN clientes.clirazao isnull THEN fornecedor.forrazao ELSE clientes.clirazao END) as razao, 
			pvenda.vencodigo as vendedor
			FROM devolucao
			LEFT JOIN pvenda on devolucao.pvnumero=pvenda.pvnumero
			LEFT JOIN clientes on pvenda.clicodigo = clientes.clicodigo
			LEFT JOIN fornecedor on pvenda.clicodigo = fornecedor.forcodigo
			WHERE devolucao.pvbaixa isnull and clientes.clicodigo='$clicodigo'
			ORDER BY devolucao.pvnumero,devolucao.pvvale asc";

        $result = $db->Execute($sql);

        $retorno = new stdClass();
        if (!$result) {
            $msg = $sql . "Falha na conexao com banco de dados! " . $db->ErrorMsg();

            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        }
        while (!$result->EOF) {
            $vale = new ValeVO();
            $vale->numero = trim($result->fields[0]);
            $vale->dvnumero = trim($result->fields[1]);
            $vale->pvbaixa = trim($result->fields[2]);
//			$vale->valor = trim($result->fields[3]);
            $vale->valor = trim(round($result->fields[3] - ($result->fields[3] * $result->fields[4] / 100), 2));
            $vale->desconto = trim($result->fields[4]);
            $vale->emissao = trim($result->fields[5]);
            $vale->devolucao = trim($result->fields[6]);
            $vale->vale = trim($result->fields[7]);
            $vale->cliente = trim($result->fields[8]);
            $vale->razao = trim($result->fields[9]);
            $vale->vendedor = trim($result->fields[10]);

            $vales[$vale->dvnumero] = $vale;

            $result->MoveNext();
        }

        if (count($vales)) {
            $msg = "Vales(s) localizado(s) com sucesso!";
            $retorno->retorno = true;
            $retorno->mensagem = $msg;
            $retorno->vales = $vales;
        } else {
            $msg = "N&atilde;o foi possivel localizar vale(s)! " . $db->ErrorMsg();
            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        }

        return $retorno;
    }

    /**
     * Metodo para efetuar pesquisa dos pedidos no banco.
     * Executa select na tabela movestoque ver config.php lista de tabelas.
     *
     * @access public
     * @param integer pvnumero lista item pedidos
     * @return object Retorna objetos do tipo json;
     */
    public function isGerouMov($pvnumero, $pvemissao, $procodigo) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $data = getdate(strtotime($pvemissao));
        $mmyy = date('my', $data[0]);

        $sql = "SELECT * FROM " . TABELA_MOVIMENTACAO_ESTOQUE . $mmyy . " WHERE pvnumero = $pvnumero and procodigo = $procodigo ORDER BY procodigo;";

        $result = $db->GetRow($sql);
        $retorno = new stdClass();

        if (!$result) {
            $msg = "[" . date('d.m.Y H:i:s') . "] ERRO: INEXISTENTE MOVIMENTACAO PEDIDO $pvnumero PRODUTO $procodigo. " . $db->ErrorMsg();
            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        } else {
            $msg = "[" . date('d.m.Y H:i:s') . "] OK: MOVIMENTACAO EXISTENTE PEDIDO $pvnumero PRODUTO $procodigo. ";
            $retorno->retorno = true;
            $retorno->mensagem = $msg;
        }

        return $retorno;
    }

}

?>
	