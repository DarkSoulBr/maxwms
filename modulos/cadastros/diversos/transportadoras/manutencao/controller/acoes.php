<?php

/**
 * Arquivo de aчѕes da Interface da Manutenчуo de Transportadoras.
 *
 * Controla as aчѕes ocorridas na interface chamadas pelo jquery.
 * Procure na pasta view/js as aчѕes jquery.
 * Este arquivo aquivo segue os padroes estabelecidos no dTrade. 
 * 
 * @name Transportadoras View - Aчѕes
 * @category Transportadoras
 * @package modulos/cadastros/diversos/transportadoras/manutencao/controller
 * @link modulos/cadastros/diversos/transportadoras/manutencao/controller/acoes.php
 * @version 1.0
 * @since Criado 02/12/2009 Modificado 02/12/2009
 * @author Wellington <wellington@centroatacadista.com.br>
 * @copyright MaxTrade
 */
//pega da pasta de istalacao
$arr = explode("/", $_SERVER['REQUEST_URI']);
$root = $arr[1];

//pega as configuraчѕes do servidor
require_once($_SERVER['DOCUMENT_ROOT'] . "/$root/include/config.php");
require_once(DIR_ROOT . '/include/classes/JSON/JSON.php');
require_once(DIR_ROOT . '/vo/TransportadoraVO.php');

$acao = $_POST["acao"];
$tipoPesquisa = $_POST["tipoPesquisa"];
$formaPesquisa = $_POST["formaPesquisa"];
$txtPesquisa = $_POST["txtPesquisa"];
$json = new Services_JSON();
$transportadora = new TransportadoraVO();

if (!empty($acao)) {
    require_once('TransportadoraController.php');

    $control = new TransportadoraController();

    switch ($acao) {
        case INSERIR:
            $control->inserir($transportadora);
            break;

        case PESQUISAR:
            $retorno = $control->pesquisar($tipoPesquisa, $txtPesquisa, $formaPesquisa);
            print $json->encode($retorno);
            break;

        case ALTERAR:
            $control->alterar($transportadora);
            break;

        case EXCLUIR:
            $control->excluir($transportadora);
            break;
    }
}
?>