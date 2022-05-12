<?php

//pega da pasta de istalacao
$arr = explode("/", $_SERVER['REQUEST_URI']);
$root = $arr[1];

//pega as configurações do servidor
require_once($_SERVER['DOCUMENT_ROOT'] . "/$root/include/config.php");

// inclui o model para acesso busca info no banco
require_once(DIR_ROOT . '/modulos/vendaAtacado/pedidos/manutencao/model/PedidoModel.php');
require_once(DIR_ROOT . '/modulos/cadastros/clientes/manutencao/model/ClienteModel.php');
require_once(DIR_ROOT . '/vo/ItemPedidoVO.php');
require_once(DIR_ROOT . '/vo/ItemEstoqueVO.php');
require_once(DIR_ROOT . '/vo/EstoqueAtualVO.php');
require_once(DIR_ROOT . '/vo/MovEstoqueVO.php');
require_once(DIR_ROOT . '/vo/LogLiberacaoVO.php');

/**
 * Classe de controle para crud do pedido (regras de negocio).
 * 
 * CRUD - (Create, Result, Update, Delete)
 * Este arquivo segue os padroes estabelecidos no dTrade.
 *
 * @access public
 * @name Pedido Controller
 * @package modulos/vendaAtacado/pedidos/manutencao/controller
 * @link modulos/vendaAtacado/pedidos/manutencao/controller/PedidoController.php
 * @version 1.0
 * @since Criado 24/11/2009 Modificado 11/01/2010
 * @author wellington <wellington@centroatacadista.com.br>
 * @exemple modulos/vendaAtacado/pedidos/manutencao/controller/PedidoController.php
 */
Class Controller {

    /**
     * Metodo para regras de negocios da alteração do cliente no banco.
     * Instancia a classe model para alteração no banco.
     *
     * @access public
     * @param ClienteVO $valor Recebe variavel tipada Cliente Value Object.
     * @return object Retorna objeto do tipo json;
     */
    public function liberarPedido(PedidoVO $pedido2, LogLiberacaoVO $logliberacao) {
        $model = new PedidoModel();
        return $model->liberacaoPedido($pedido2, $logliberacao);
    }

    /**
     * Metodo para regras de negocios da alteração do cliente no banco.
     * Instancia a classe model para alteração no banco.
     *
     * @access public
     * @param ClienteVO $valor Recebe variavel tipada Cliente Value Object.
     * @return object Retorna objeto do tipo json;
     */
    public function liberarPedido424(PedidoVO $pedido2, LogLiberacaoVO $logliberacao) {
        $model = new PedidoModel();
        $pedido2->pvimpresso;
        $senha2 = trim(md5($pedido2->pvimpresso));

        if ($pedido2->pvusulib != $senha2) {
            $retorno = new stdClass();
            $retorno->mensagem = "SENHA INCORRETA.";
            return $retorno;
        } else {

            return $model->liberacaoPedido424($pedido2, $logliberacao);
        }
    }

    /**
     * Metodo para regras de negocios da pesquisa do fornecedor tecnal no banco.
     * Instancia a classe model para pesquisar no banco.
     *
     * @access public
     * @param integer $tipoPesquisa Tipo de pesquisa 1 todos arquivos 0 pesquisa por data.
     * @param timestamp $dataInicio Data de inicio para a  pesquisa.
     * @param timestamp $dataFinal Data final para a  pesquisa.
     * @return object Retorna objeto de retorno;
     */
    public function alteraEndereco(ClienteEnderecoFaturamentoVO $alteracaoEndereco) {
        $model = new ClienteModel();
        $retorno = $model->alteraNumeroCliente($alteracaoEndereco);

        return $retorno;
    }

}
