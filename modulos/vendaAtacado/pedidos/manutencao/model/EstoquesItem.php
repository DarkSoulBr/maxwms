<?php

//pega da pasta de istalacao
$arr = explode("/", $_SERVER['REQUEST_URI']);
$root = $arr[1];

//pega as configurações do servidor
require_once($_SERVER['DOCUMENT_ROOT'] . "/$root/include/config.php");
require_once(DIR_ROOT . '/include/classes/Conexao.php');

//inclui Values Object
require_once(DIR_ROOT . '/vo/EstoqueAtualVO.php');
require_once(DIR_ROOT . '/vo/ProdutoVO.php');
require_once(DIR_ROOT . '/vo/EstoqueVO.php');

/**
 * Classe modelo para comunicação com banco de dados.
 * 
 * Comunicação e Manutenção da tabela de estoque atual.
 * Este arquivo segue os padroes estabelecidos no dTrade.
 *
 * @access public
 * @name Estoques Item Model
 * @package modulos/vendaAtacado/pedidos/manutencao/model
 * @link modulos/vendaAtacado/pedidos/manutencao/model/EstoquesItem.php
 * @version 1.0.0
 * @since Criado 10/12/2009 Modificado 10/12/2009
 * @author wellington <wellington@centroatacadista.com.br>
 * @exemple modulos/vendaAtacado/pedidos/manutencao/model/EstoquesItem.php
 */
Class EstoquesItem {

    /**
     * Metodo para efetuar pesquisa dos estoques por produto com estoque atual.
     * Executa select na tabela estoqueatual ver config.php lista de tabelas.
     *
     * @access public
     * @param integer $tipoPedido Codigo do Tipo do Pedido.
     * @param integer $produto Codigo do Produto. 
     * @return object Objeto de confirmação de retorno;
     */
    public function getEstoques($tipoPedido, $produto) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $sql = "SELECT 
					" . TABELA_ESTOQUE_ATUAL . ".etqatualcodigo as etqatualcodigo,
					" . TABELA_ESTOQUE_ATUAL . ".estqtd as estqtd,
					" . TABELA_ESTOQUE . ".etqcodigo as etqcodigo,
					" . TABELA_ESTOQUE . ".etqnome as etqnome
				FROM 
					" . TABELA_ESTOQUE . "
				INNER JOIN
					" . TABELA_TIPO_PEDIDO__ESTOQUE . "
				USING
					(etqcodigo)
				INNER JOIN
					" . TABELA_TIPO_PEDIDO . "
				USING
					(tipcodigo)
				INNER JOIN
					" . TABELA_ESTOQUE_ATUAL . "
				ON
					" . TABELA_ESTOQUE . ".etqcodigo = " . TABELA_ESTOQUE_ATUAL . ".codestoque
				WHERE
					" . TABELA_TIPO_PEDIDO . ".tipsigla = '$tipoPedido' AND
					" . TABELA_ESTOQUE_ATUAL . ".procodigo = $produto ORDER BY estqtd DESC";

        $result = $db->GetAll($sql);

        $retorno = new stdClass();
        $isEmpenho = false;
        $isPendentes = false;

        if (!$result) {
            $msg = "NAO FOI POSSIVEL CARREGAR LISTA DE ESTOQUE DO PRODUTO. " . $db->ErrorMsg();
            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        } else {
            $msg = "LISTA " . count($result) . " PRODUTO(S) CARREGADOS.";
            $retorno->retorno = true;
            $retorno->mensagem = $msg;

            foreach ($result as $value) {
                $estoqueAtual = new EstoqueAtualVO();
                $estoqueAtual->etqatualcodigo = $value['etqatualcodigo'];
                $estoqueAtual->produto = new ProdutoVO();
                $estoqueAtual->produto->procodigo = $produto;
                $estoqueAtual->estqtd = $value['estqtd'];
                $estoqueAtual->estoque = new EstoqueVO($value['etqcodigo']);
                $estoques[$estoqueAtual->estoque->etqcodigo] = $estoqueAtual;

                if ($value['etqcodigo'] == EMPENHO) {
                    $isEmpenho = true;
                } else if ($value['etqcodigo'] == PENDENTES) {
                    $isPendentes = true;
                }
            }

            if (!$isEmpenho) {
                $estoqueAtual = new EstoqueAtualVO();

                $estoqueAtual->produto = new ProdutoVO();
                $estoqueAtual->produto->procodigo = $produto;
                $estoqueAtual->estqtd = 0;
                $estoqueAtual->estoque = new EstoqueVO(EMPENHO);

                $retornoEmpenho = $this->inserirEstoqueAtual($estoqueAtual);
                if ($retornoEmpenho->retorno) {
                    $estoqueAtual->etqatualcodigo = $retornoEmpenho->codigo;
                    $estoques[$estoqueAtual->estoque->etqcodigo] = $estoqueAtual;
                }
            }

            if (!$isPendentes) {
                $estoqueAtual = new EstoqueAtualVO();
                $estoqueAtual->etqatualcodigo = 0;
                $estoqueAtual->produto = new ProdutoVO();
                $estoqueAtual->produto->procodigo = $produto;
                $estoqueAtual->estqtd = 0;
                $estoqueAtual->estoque = new EstoqueVO(PENDENTES);

                $retornoPendentes = $this->inserirEstoqueAtual($estoqueAtual);
                if ($retornoPendentes->retorno) {
                    $estoqueAtual->etqatualcodigo = $retornoPendentes->codigo;
                    $estoques[$estoqueAtual->estoque->etqcodigo] = $estoqueAtual;
                }
            }

            $retorno->estoques = $estoques;
        }

        return $retorno;
    }

    /**
     * Metodo para efetuar pesquisa dos estoques por produto com estoque atual.
     * Executa select na tabela estoqueatual ver config.php lista de tabelas.
     *
     * @access public
     * @param integer $tipoPedido Codigo do Tipo do Pedido.
     * @param integer $produto Codigo do Produto. 
     * @return object Objeto de confirmação de retorno;
     */
    public function inserirEstoqueAtual(EstoqueAtualVO $estoqueAtual) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $record['procodigo'] = $estoqueAtual->produto->procodigo;
        $record['estqtd'] = $estoqueAtual->estqtd;
        $record['codestoque'] = $estoqueAtual->estoque->etqcodigo;

        $result = $db->AutoExecute(TABELA_ESTOQUE_ATUAL, $record, 'INSERT');

        $retorno = new stdClass();

        if (!$result) {
            $msg = "[" . date('d.m.Y H:i:s') . "] ERRO: INSERCAO ESTOQUE ATUAL. " . $db->ErrorMsg();

            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        } else {
            $row = $db->GetRow("SELECT * FROM " . TABELA_ESTOQUE_ATUAL . " WHERE procodigo='{$estoqueAtual->produto->procodigo}' and codestoque='{$estoqueAtual->estoque->etqcodigo}'");

            $msg = "[{date('d.m.Y H:i:s')}] OK: INSERCAO ESTOQUE ATUAL {$row['etqatualcodigo']}.";

            $retorno->retorno = true;
            $retorno->mensagem = $msg;
            $retorno->codigo = $row['etqatualcodigo'];
        }

        return $retorno;
    }

}

?>
