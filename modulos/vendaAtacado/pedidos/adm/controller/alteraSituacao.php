<?php

/**
 * Arquivo de ações da Interface de estacionamento de Pedidos.
 *
 * Controla as ações ocorridas na interface chamadas pelo jquery.
 * Procure na pasta view/js as ações jquery.
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

//pega as configurações do servidor
require_once($_SERVER['DOCUMENT_ROOT'] . "/$root/include/config.php");
require_once(DIR_ROOT . '/include/classes/JSON/JSON.php');
require_once (DIR_ROOT . '/modulos/vendaAtacado/pedidos/adm/model/EstacionamentoModel.php');
require_once(DIR_ROOT . '/include/funcoes/removeCaracterEspecial.php');

$json = new Services_JSON();
$pvnumero = $_POST["pvnumero"];
$situacao = $_POST["situacao"];
$observacao = $_POST["observacao"];
$txtMail = $_POST['txtMail'];
$from = trim(strtolower($_POST['from']));
$nomedoarquivo = "pedido$pvnumero.txt";
$acao = $_POST['acao'];
$id = $_POST['id'];
$msgSelecionadas = explode(",", $_POST['msgSelecionadas']);
$msgPadrao = '<ul>';
$destinatarios = '';
$remetente = $from;
$assunto = '';
$mensagem = '';

$model = new EstacionamentoModel();
print $json->encode($model->alteraSituacaoPedido($pvnumero, $situacao, $observacao));

$path = DIR_ROOT . '/lib';
set_include_path(get_include_path() . PATH_SEPARATOR . $path);



if ($acao == '1') {
    print $json->encode($model->verificaPrefechamento2($id));
}
?>
