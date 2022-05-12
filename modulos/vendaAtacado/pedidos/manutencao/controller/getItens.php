<?php

/**
 * Arquivo de a��es da Interface da Manuten��o de Pedidos.
 *
 * Controla as a��es ocorridas na interface chamadas pelo jquery.
 * Procure na pasta view/js as a��es jquery.
 * Este arquivo aquivo segue os padroes estabelecidos no dTrade. 
 * 
 * @name Pedidos Estoques View - A��es
 * @category Pedidos
 * @package modulos/vendaAtacado/pedidos/manutencao/controller
 * @link modulos/vendaAtacado/pedidos/manutencao/controller/getEstoquesItem.php
 * @version 1.0
 * @since Criado 10/12/2009 Modificado 10/12/2009
 * @author Wellington <wellington@centroatacadista.com.br>
 * @copyright MaxTrade
 */
//pega da pasta de istalacao
$arr = explode("/", $_SERVER['REQUEST_URI']);
$root = $arr[1];

//pega as configura��es do servidor
require_once($_SERVER['DOCUMENT_ROOT'] . "/$root/include/config.php");
require_once(DIR_ROOT . '/include/classes/JSON/JSON.php');
require_once (DIR_ROOT . '/modulos/vendaAtacado/pedidos/manutencao/model/PedidoModel.php');

$pvnumero = $_POST["pvnumero"];
$json = new Services_JSON();
$model = new PedidoModel();

print $json->encode($model->getItensPedido($pvnumero));
?>
