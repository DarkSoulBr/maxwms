<?php

/**
 * Arquivo de aчѕes da Interface da Manutenчуo de Pedidos.
 *
 * Controla as aчѕes ocorridas na interface chamadas pelo jquery.
 * Procure na pasta view/js as aчѕes jquery.
 * Este arquivo aquivo segue os padroes estabelecidos no dTrade. 
 * 
 * @name Pedidos View - Aчѕes
 * @category Pedidos
 * @package modulos/vendaAtacado/pedidos/manutencao/controller
 * @link modulos/vendaAtacado/pedidos/manutencao/controller/acoes.php
 * @version 1.0
 * @since Criado 03/12/2009 Modificado 11/01/2010
 * @author Wellington <wellington@centroatacadista.com.br>
 * @copyright MaxTrade
 */
//pega da pasta de istalacao
$arr = explode("/", $_SERVER['REQUEST_URI']);
$root = $arr[1];

//pega as configuraчѕes do servidor
require_once($_SERVER['DOCUMENT_ROOT'] . "/$root/include/config.php");
require_once(DIR_ROOT . '/include/classes/JSON/JSON.php');
require_once(DIR_ROOT . '/vo/PedidoVO.php');
require_once(DIR_ROOT . '/vo/LogLiberacaoVO.php');
require_once(DIR_ROOT . '/vo/ClienteEnderecoFaturamentoVO.php');

$acao = $_POST['acao'];

$json = new Services_JSON();

$ped2 = $_POST["pedido2"];
$pedido2 = new PedidoVO();
$pedido2->castPedidoVO($json->decode($ped2));

$log = $_POST['loglibera'];
$logliberacao = new LogLiberacaoVO();
$logliberacao->castLogLiberacaoVO($json->decode($log));

$alteraEndereco = $_POST["alteracaoEndereco"];
$alteracaoEndereco = new ClienteEnderecoFaturamentoVO();
$alteracaoEndereco->castClienteEnderecoFaturamentoVO($json->decode($alteraEndereco));

require_once('Controller.php');

switch ($acao) {
    CASE 1:
        $json = new Services_JSON();
        $pedido = new PedidoVO();
        $pedido->castPedidoVO($json->decode($ped));
        BREAK;

    CASE 2:
        $control = new Controller();
        $retorno = $control->liberarPedido($pedido2, $logliberacao);
        print $json->encode($retorno);
        BREAK;

    CASE 3:
        $controlCliente = new Controller();
        $retorno = $controlCliente->alteraEndereco($alteracaoEndereco);
        print $json->encode($retorno);
        BREAK;

    CASE 4:
        $control = new Controller();
        $retorno = $control->liberarPedido424($pedido2, $logliberacao);
        print $json->encode($retorno);
        BREAK;
}
?>