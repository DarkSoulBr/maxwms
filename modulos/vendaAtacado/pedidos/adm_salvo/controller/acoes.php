<?php

/**
 * Arquivo de a??es da Interface de estacionamento de Pedidos.
 *
 * Controla as a??es ocorridas na interface chamadas pelo jquery.
 * Procure na pasta view/js as a??es jquery.
 * Este arquivo segue os padroes estabelecidos no dTrade. 
 * 
 * @name Pedidos Adm View - Get Estacionamento
 * @category Pedidos
 * @package modulos/vendaAtacado/pedidos/adm/controller
 * @link modulos/vendaAtacado/pedidos/adm/controller/getEsacionamento.php
 * @version 1.0
 * @since Criado 19/05/2010
 * @author Wellington <wellington@centroatacadista.com.br>
 * @copyright MaxTrade
 */
//pega da pasta de istalacao
$arr = explode("/", $_SERVER['REQUEST_URI']);
$root = $arr[1];

//pega as configura??es do servidor
require_once($_SERVER['DOCUMENT_ROOT'] . "/$root/include/config.php");
require_once(DIR_ROOT . '/include/classes/JSON/JSON.php');
require_once (DIR_ROOT . '/modulos/vendaAtacado/pedidos/adm/controller/VerificaPrefechamento.php');

$json = new Services_JSON();
$pvnumero = $_POST["pvnumero"];
$situacao = $_POST["situacao"];
$observacao = $_POST["observacao"];
$acao = $_POST['acao'];
$id = $_POST['id'];
$id2 = $_POST['id2'];

$control = new VerificaPrefechamento();
if ($acao == '1') {

    $retorno = $control->verifica($id);
    print ($retorno);
}
if ($acao == '9') {

    $retorno = $control->libera($id2);
    print $json->encode($retorno);
}
				