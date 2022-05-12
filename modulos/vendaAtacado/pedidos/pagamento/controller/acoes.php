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
require_once(DIR_ROOT . '/vo/ItemFormaPagamentoVO.php');

$acao = $_POST["acao"];

$json = new Services_JSON();
$itemPagamento = $_POST['itemFormaPagamento'];
$itemFormaPagamento = $json->decode($itemPagamento);

$pvnumero = $_POST['pvnumero'];
$pvvale = $_POST['baixaVale'];
$clicod = $_POST['clicod'];

$pvvaleUp = $_POST['upVale'];
$clicodUp = $_POST['clicodUp'];
$fecvalor = $_POST['fecvalor'];
$clicodigo = $_POST['clicodigo'];
$vencodigo = $_POST['vencodigo'];
if (!empty($acao)) {
    require_once('PagamentoController.php');
    $control = new PagamentoController();

    switch ($acao) {
        case 1:
            $retorno = $control->itemFormaPagamento($itemFormaPagamento);
            print $json->encode($retorno);
            break;

        case 2:
            $retorno = $control->baixaVale($pvvale, $clicod, $pvnumero);
            print $json->encode($retorno);
            break;
        case 3:
            $retorno = $control->upVale($pvvaleUp, $clicodUp, $pvnumero, $fecvalor, $clicodigo, $vencodigo);
            print $json->encode($retorno);
            break;
    }
}
?>