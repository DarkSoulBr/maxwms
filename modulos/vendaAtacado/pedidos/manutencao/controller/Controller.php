<?php

//pega da pasta de istalacao
$arr = explode("/", $_SERVER['REQUEST_URI']);
$root = $arr[1];

//pega as configurações do servidor
require_once($_SERVER['DOCUMENT_ROOT'] . "/$root/include/config.php");

// inclui o model para acesso busca info no banco
require_once(DIR_ROOT . '/modulos/utilitarios/cobranca/pedidos/manutencao/model/Model.php');
require_once(DIR_ROOT . '/include/classes/JSON/JSON.php');

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
Class Controller {

    /**
     * Metodo para regras de negocios da pesquisa no banco.
     * Instancia a classe model para pesquisar no banco.
     *
     * @access public
     * @param string $tipo Nome do campo para pesquisar.
     * @param string $pesquisa Texto para pesquisa.
     * @return object Retorna objeto do tipo json;
     */
    public function pesquisar($tipoPesquisa, $txtpesquisa, $exata) {
        $model = new Model();
        return $model->pesquisar($tipoPesquisa, $txtpesquisa, $exata);
    }

}

?>