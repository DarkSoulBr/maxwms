<?php

//pega da pasta de istalacao
$arr = explode("/", $_SERVER['REQUEST_URI']);
$root = $arr[1];

//pega as configurações do servidor
require_once($_SERVER['DOCUMENT_ROOT'] . "/$root/include/config.php");

// inclui o model para acesso busca info no banco
require_once(DIR_ROOT . '/modulos/vendaAtacado/pedidos/pagamento/model/PagamentoModel.php');
require_once(DIR_ROOT . '/include/classes/JSON/JSON.php');
require_once(DIR_ROOT . '/vo/ItemFormaPagamentoVO.php');

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
Class PagamentoController {

    public function itemFormaPagamento($itemFormaPagamento) {
        $model = new PagamentoModel();
        $preFechamento = new ItemFormaPagamentoVO();
        $rows = count($itemFormaPagamento->preFechamento);

        $excluiAnterior = $model->exluiPreFechamentoAnterior($itemFormaPagamento->preFechamento[0]->pvnumero);

        function converteData($data) {
            if ($data == null OR $data == "") {
                return null;
            } else {
                $dt = explode("/", $data);
                $data = $dt[2] . "-" . $dt[1] . "-" . $dt[0];
                $hora = date("H:i:s");
                return $data . " " . $hora;
            }
        }

        for ($i = 0; $i < $rows; $i++) {
            $preFechamento->fecforma = $itemFormaPagamento->preFechamento[$i]->fecforma;
            $preFechamento->fecdata = converteData($itemFormaPagamento->preFechamento[$i]->fecdata);
            $preFechamento->pvnumero = $itemFormaPagamento->preFechamento[$i]->pvnumero;
            $preFechamento->vencodigo = $itemFormaPagamento->preFechamento[$i]->vencodigo;
            $preFechamento->clicodigo = $itemFormaPagamento->preFechamento[$i]->clicodigo;
            $preFechamento->fectipo = $itemFormaPagamento->preFechamento[$i]->fectipo;
            $preFechamento->fecvecto = converteData($itemFormaPagamento->preFechamento[$i]->fecvecto);
            $preFechamento->fecdia = $itemFormaPagamento->preFechamento[$i]->fecdia;
            $preFechamento->fecdocto = substr($itemFormaPagamento->preFechamento[$i]->fecdocto, 0, 12);
            $preFechamento->fecvalor = $itemFormaPagamento->preFechamento[$i]->fecvalor;
            $preFechamento->fecbanco = $itemFormaPagamento->preFechamento[$i]->fecbanco;
            $preFechamento->fecagencia = $itemFormaPagamento->preFechamento[$i]->fecagencia;
            $preFechamento->fecconta = $itemFormaPagamento->preFechamento[$i]->fecconta;
            $preFechamento->feccartao = $itemFormaPagamento->preFechamento[$i]->feccartao;
            $preFechamento->feccaixa = $itemFormaPagamento->preFechamento[$i]->feccaixa;
            $preFechamento->fecempresa = $itemFormaPagamento->preFechamento[$i]->fecempresa;

            $apreFechamento = new Object;
            $apreFechamento = $model->preFechamento($preFechamento);
        }
        $retorno = new stdClass();
        $retorno->retornoDeletaPreFechamento = $retornoDeletaPreFechamento;
        $retorno->aPreFechamento = $aPreFechamento;
        return $retorno;
    }

    public function baixaVale($pvvale, $clicod, $pvnumero) {
        $model = new PagamentoModel();
        $retorno = $model->baixaVale($pvvale, $clicod, $pvnumero);
        return $retorno;
    }

    public function upVale($pvvaleUp, $clicodUp, $pvnumero) {
        $model = new PagamentoModel();
        $retorno = $model->upVale2($pvvaleUp, $clicodUp, $pvnumero, $fecvalor, $clicodigo, $vencodigo);
        return $retorno;
    }

}
