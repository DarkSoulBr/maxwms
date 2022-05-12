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
require_once(DIR_ROOT . '/vo/ItemFormaPagamentoVO.php');

$acao = $_POST["acao"];

$json = new Services_JSON();

$pedido = new PedidoVO();
$pedido->castPedidoVO($json->decode($_POST["pedido"]));
$itensPedido = $json->decode($_POST["itensPedido"]);


$ped2 = $_POST["pedido2"];
$pedido2 = new PedidoVO();
$pedido2->castPedidoVO($json->decode($ped2));

$pedidoLib = $_POST["pedidoLiberas"];
$pedidoLibera = new PedidoVO();
$pedidoLibera->castPedidoVO($json->decode($pedidoLib));

//utilizado para recuperaчуo de pedidos
$itensPedidoEmpenho = $json->decode($_POST["itensPedidoEmpenho"]);

$itemFormaPagamento = $json->decode($_POST['itemFormaPagamento']);

$pvcondcon = $_POST['pvcondcon'];
$pvnumero = $_POST['pvnumero'];
$usucodigo = $_POST['usucodigo'];

$fecdocto = $_POST['fecdocto'];
$clicodigo = $_POST['clicodigo'];
$prefeccodigo = $_POST['prefeccodigo'];
$fecforma = $_POST['fecforma'];

$tipoPesquisa = $_POST["tipoPesquisa"];
$txtPesquisa = $_POST["txtPesquisa"];
$formaPesquisa = $_POST["formaPesquisa"];


$pvnumeroDel = $_POST['pvnumeroDel'];
$estoque = $_POST['estoque'];
$usuarioDel = $_POST['usuarioDel'];
$movestoque = $_POST['movestoque'];

$status = $_POST['novoStatus'];

$usuarioPrefechamento = $json->decode($_POST['usuarioPrefechamento']);

$senhaDigitada = $_POST['senhaDigitada'];


if (!empty($acao)) {
    require_once('PedidoController.php');

    $control = new PedidoController();

    switch ($acao) {
        case INSERIR:
            $retorno = $control->inserir($pedido, $itensPedido);
            print $json->encode($retorno);
            break;

        case ALTERAR:
            $retorno = $control->alterar($pedido, $itensPedido);
            print $json->encode($retorno);
            break;

        case EXCLUIR:
            $retorno = $control->excluir($pvnumeroDel, $estoque, $usuarioDel, $movestoque);
            print $json->encode($retorno);
            break;

        case PESQUISAR:
            $retorno = $control->pesquisar($tipoPesquisa, $txtPesquisa, $formaPesquisa);
            print $json->encode($retorno);
            break;

        //esta versуo do pequisar e antiga e demora o carregamento
        //esta sendo revisto a pesquisa acima para melhorar o sistema
        //nao sera escluido pois ha outras partes do sistema que o utiliza
        case 25:
            $retorno = $control->pesquisar2($tipoPesquisa, $txtPesquisa, $formaPesquisa);
            print $json->encode($retorno);
            break;

        case 26:
            $retorno = $control->pesquisarSimples($tipoPesquisa, $txtPesquisa, $formaPesquisa);
            print $json->encode($retorno);
            break;

        case 27:
//echo "On Action\npvnumero -> $pvnumero \n status-> $status \n usucodigo->$usucodigo";
            $retorno = $control->alterarStatus($pvnumero, $status, $usucodigo);
            print $json->encode($retorno);
            break;

        case PREFECHAMENTO:
            $retorno = $control->itemFormaPagamento($itemFormaPagamento, $pedidoLibera, $usuarioPrefechamento);
            print $json->encode($retorno);
            break;

        case 6:
            $retorno = $control->alteraCondicoesComerciais($pvcondcon, $pvnumero);
            print $json->encode($retorno);
            break;

        case 7:
            $retorno = $control->getPedidoTmp($pedido);
            print $retorno;
            break;

        case 8:
            $retorno = $control->verificaPedidoTmp($pedido);
            print $json->encode($retorno);
            break;

        case 9:
            $retorno = $control->limparPedidoTmp($pedido);
            print $json->encode($retorno);
            break;

        case 10:
            $retorno = $control->gerarPedidoTmp($pedido, $itensPedido, $itensPedidoEmpenho);
            print $json->encode($retorno);
            break;

        case 11:
            $retorno = $control->baixaParcela($fecdocto, $clicodigo, $pvnumero, $prefeccodigo, $fecforma);
            print $json->encode($retorno);
            break;

        case 12:
            $retorno = $control->alteraParcela($itemFormaPagamento, $usuarioPrefechamento);
            print $json->encode($retorno);
            break;

        case 13:
            $retorno = $control->alterarTravaManutencao($pvnumero, $usucodigo);
            print $json->encode($retorno);
            break;

        case 14:
            $retorno = $control->destravaPedido($pvnumero);
            print $json->encode($retorno);
            break;

        case 15:
            $retorno = $control->destravaSaltoPrefechamento($usuarioPrefechamento, $senhaDigitada);
            print $json->encode($retorno);
            break;
    }
}
?>