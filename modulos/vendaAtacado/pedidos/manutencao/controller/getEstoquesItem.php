<?php

/**
 * Arquivo de ações da Interface da Manutenção de Pedidos.
 *
 * Controla as ações ocorridas na interface chamadas pelo jquery.
 * Procure na pasta view/js as ações jquery.
 * Este arquivo aquivo segue os padroes estabelecidos no dTrade. 
 * 
 * @name Pedidos Estoques View - Ações
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

//pega as configurações do servidor
require_once($_SERVER['DOCUMENT_ROOT'] . "/$root/include/config.php");
require_once(DIR_ROOT . '/include/classes/JSON/JSON.php');
require_once (DIR_ROOT . '/modulos/vendaAtacado/pedidos/manutencao/model/EstoquesItem.php');

$tipoPedido = $_POST["tipoPedido"];
$codigoProduto = $_POST["codigoProduto"];
$json = new Services_JSON();
$model = new EstoquesItem();
print $json->encode($model->getEstoques($tipoPedido, $codigoProduto));
?>
