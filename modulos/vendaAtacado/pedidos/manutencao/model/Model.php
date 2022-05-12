<?php

//pega da pasta de istalacao
$arr = explode("/", $_SERVER['REQUEST_URI']);
$root = $arr[1];

//pega as configurações do servidor
require_once($_SERVER['DOCUMENT_ROOT'] . "/$root/include/config.php");
require_once(DIR_ROOT . '/include/classes/Conexao.php');

//inclui models necessarios
require_once(DIR_ROOT . '/modulos/vendaAtacado/pedidos/manutencao/model/EstoquesItem.php');

//inclui Values Object
require_once(DIR_ROOT . '/vo/PedidoVO.php');
require_once(DIR_ROOT . '/vo/ItemPedidoVO.php');
require_once(DIR_ROOT . '/vo/ClienteVO.php');
require_once(DIR_ROOT . '/vo/TipoPedidoVO.php');
require_once(DIR_ROOT . '/vo/VendedorVO.php');
require_once(DIR_ROOT . '/vo/TransportadoraVO.php');
require_once(DIR_ROOT . '/vo/PalmVO.php');
require_once(DIR_ROOT . '/vo/FornecedorVO.php');
require_once(DIR_ROOT . '/vo/UsuariosVO.php');
require_once(DIR_ROOT . '/vo/ItemEstoqueVO.php');
require_once(DIR_ROOT . '/vo/EstoqueAtualVO.php');
require_once(DIR_ROOT . '/vo/EstoqueFisicoVO.php');
require_once(DIR_ROOT . '/vo/EstoqueVO.php');
require_once(DIR_ROOT . '/vo/EstoqueDestinoOrigemVO.php');
require_once(DIR_ROOT . '/vo/ProdutoVO.php');
require_once(DIR_ROOT . '/vo/CidadeVO.php');
require_once(DIR_ROOT . '/vo/ClienteEnderecoFaturamentoVO.php');
require_once(DIR_ROOT . '/vo/ClienteEnderecoCobrancaVO.php');
require_once(DIR_ROOT . '/vo/ClassificacaoFiscalVO.php');
require_once(DIR_ROOT . '/vo/CondicaoComercialVO.php');
require_once(DIR_ROOT . '/vo/GrupoVO.php');
require_once(DIR_ROOT . '/vo/DevolucaoVO.php');
require_once(DIR_ROOT . '/vo/ValeVO.php');
require_once(DIR_ROOT . '/vo/DevolucaoVendaItemVO.php');
require_once(DIR_ROOT . '/vo/ItemFormaPagamentoVO.php');
require_once(DIR_ROOT . '/vo/PreFechamentoVO.php');
require_once(DIR_ROOT . '/vo/PedParcelasVO.php');
require_once(DIR_ROOT . '/vo/CobrancaVO.php');
require_once(DIR_ROOT . '/vo/FechamentoVO.php');

/**
 * Classe modelo para comunicação com banco de dados.
 *
 * Comunicação e Manutenção da tabela de pedidos.
 * Este arquivo segue os padroes estabelecidos no dTrade.
 *
 * @access public
 * @name Pedido Model
 * @package modulos/vendaAtacado/pedidos/manutencao/model
 * @link modulos/vendaAtacado/pedidos/manutencao/model/PedidoModel.php
 * @version 1.0.0
 * @since Criado 03/12/2009 Modificado 03/12/2009 Modificado 06/02/2010(Douglas - douglas@centroatacadista.com.br)
 * @author wellington <wellington@centroatacadista.com.br>
 * @exemple modulos/vendaAtacado/pedidos/manutencao/model/PedidoModel.php
 */
Class Model {

    /**
     * Metodo para efetuar pesquisa dos estoques Atuais.
     * Executa select na tabela estoque ver config.php lista de tabelas.
     *
     * @access public
     * @param integer pvicodigo lista item pedidos
     * @return object Retorna objetos do tipo json;
     */
    public function getEstoqueFisico($etqfcodigo) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $sql = "SELECT * FROM " . TABELA_ESTOQUE_FISICO . " where etqfcodigo='$etqfcodigo'";

        $result = $db->Execute($sql);

        $retornoEstoqueFisico = new stdClass();
        if (!$result) {
            $msg = "Falha na conexao com banco de dados! " . $db->ErrorMsg();

            $retornoEstoqueFisico->retorno = false;
            $retornoEstoqueFisico->mensagem = $msg;
        }

        while (!$result->EOF) {
            $estoqueFisico = new EstoqueFisicoVO();

            $estoqueFisico->etqfcodigo = $result->fields[0];
            $estoqueFisico->etqfdatacadastro = $result->fields[1];
            $estoqueFisico->etqfnome = $result->fields[2];
            $estoqueFisico->situacao = $result->fields[3];
            $estoqueFisico->etqfsigla = $result->fields[4];


            $estoqueFisicos{$estoqueFisico->etqfcodigo} = $estoqueFisico;

            $result->MoveNext();
        }

        if (count($estoqueFisicos)) {
            $msg = "Estoque(s) Atual localizado(s) com sucesso!(tabela estoque)";
            $retornoEstoqueFisico->retorno = true;
            $retornoEstoqueFisico->mensagem = $msg;
            $retornoEstoqueFisico->estoqueFisicos = $estoqueFisicos;
        } else {
            $msg = "N&atilde;o foi possivel localizar o estoque Atual!(tabela estoque) " . $db->ErrorMsg();
            $retornoEstoqueFisico->retorno = false;
            $retornoEstoqueFisico->mensagem = $msg;
        }

        return $retornoEstoqueFisico;
    }

    /**
     * Metodo para efetuar pesquisa dos estoques Atuais.
     * Executa select na tabela estoque ver config.php lista de tabelas.
     *
     * @access public
     * @param integer pvicodigo lista item pedidos
     * @return object Retorna objetos do tipo json;
     */
    public function getEstoque($codestoque) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $sql = "SELECT * FROM " . TABELA_ESTOQUE . " where etqcodigo='$codestoque'";

        $result = $db->Execute($sql);

        $retornoEstoque = new stdClass();
        if (!$result) {
            $msg = "Falha na conexao com banco de dados! " . $db->ErrorMsg();

            $retornoEstoque->retorno = false;
            $retornoEstoque->mensagem = $msg;
        }
        while (!$result->EOF) {
            $estoque = new EstoqueVO();

            $estoque->etqcodigo = $result->fields[0];
            $estoque->etqnome = $result->fields[1];
            $estoque->usuario = $result->fields[2];
            //$estoque->estoquesfisicos = new EstoqueFisicoVO();
            $estoque->etqfcodigo = $result->fields[3];

            $estoque->etqdatacadastro = $result->fields[4];
            $estoque->situacao = $result->fields[5];

            $retornoEstoqueFisico = $this->getEstoqueFisico($estoque->etqfcodigo);
            $estoque->estoqueFisico = $retornoEstoqueFisico;

            $estoques{$estoque->etqcodigo} = $estoque;

            $result->MoveNext();
        }

        if (count($estoques)) {
            $msg = "Estoque(s) Atual localizado(s) com sucesso!(tabela estoque)";
            $retornoEstoque->retorno = true;
            $retornoEstoque->mensagem = $msg;
            $retornoEstoque->estoques = $estoques;
        } else {
            $msg = $sql . "N&atilde;o foi possivel localizar o estoque Atual!(tabela estoque) " . $db->ErrorMsg();
            $retornoEstoque->retorno = false;
            $retornoEstoque->mensagem = $msg;
        }

        return $retornoEstoque;
    }

    /**
     * Metodo para efetuar pesquisa dos estoques Atuais.
     * Executa select na tabela estoque ver config.php lista de tabelas.
     *
     * @access public
     * @param integer pvicodigo lista item pedidos
     * @return object Retorna objetos do tipo json;
     */
    public function getItensEstoqueAtual($etqatualcodigo) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $sql = "SELECT * FROM " . TABELA_ESTOQUE_ATUAL . " where etqatualcodigo='$etqatualcodigo'";

        $result = $db->Execute($sql);

        $retornoEstoqueAtual = new stdClass();
        if (!$result) {
            $msg = "Falha na conexao com banco de dados! " . $db->ErrorMsg();

            $retornoEstoqueAtual->retorno = false;
            $retornoEstoqueAtual->mensagem = $msg;
        }
        while (!$result->EOF) {
            $estoqueAtual = new EstoqueAtualVO();
            $estoqueAtual->etqatualcodigo = $result->fields[0];

            $estoqueAtual->produto = new ProdutoVO();
            $estoqueAtual->produto->procodigo = $result->fields[1];

            $estoqueAtual->estqtd = $result->fields[2];

            $estoqueAtual->estoque = new EstoqueVO();
            $estoqueAtual->estoque->codestoque = $result->fields[3];

            $retornoEstoque = $this->getEstoque($estoqueAtual->estoque->codestoque);
            $estoqueAtual->itensEstoque = $retornoEstoque;

            $estoqueAtuais{$estoqueAtual->etqatualcodigo} = $estoqueAtual;

            $result->MoveNext();
        }

        if (count($estoqueAtuais)) {
            $msg = "Estoque(s) Atual localizado(s) com sucesso!(tabela estoqueAtual)";
            $retornoEstoqueAtual->retorno = true;
            $retornoEstoqueAtual->mensagem = $msg;
            $retornoEstoqueAtual->estoqueAtuais = $estoqueAtuais;
        } else {
            $msg = "N&atilde;o foi possivel localizar o estoque Atual!(tabela estoqueAtual) " . $db->ErrorMsg();
            $retornoEstoqueAtual->retorno = false;
            $retornoEstoqueAtual->mensagem = $msg;
        }

        return $retornoEstoqueAtual;
    }

    /**
     * Metodo para efetuar pesquisa dos estoques de um item.
     * Executa select na tabela estoque ver config.php lista de tabelas.
     *
     * @access public
     * @param integer pvicodigo lista item pedidos
     * @return object Retorna objetos do tipo json;
     */
    public function getItemEstoques($pvicodigo) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $sql = "SELECT * FROM " . TABELA_ITENS_PEDIDO_ESTOQUES . " where pvicodigo='$pvicodigo'";

        $result = $db->Execute($sql);

        $retorno = new stdClass();

        if (!$result) {
            $msg = "FALHA NA CONEXAO COM BANCO DE DADOS. " . $db->ErrorMsg();

            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        }

        while (!$result->EOF) {
            $itemEstoque = new ItemEstoqueVO();
            $itemEstoque->pviecodigo = $result->fields[0];
            $itemEstoque->estoqueAtual = new EstoqueAtualVO($result->fields[3]);
            $itemEstoque->pvieqtd = $result->fields[4];
            $itemEstoque->pviedatacadastro = $result->fields[5];
            $itemEstoque->pviesituacao = $result->fields[6];

            $estoques{$itemEstoque->pviecodigo} = $itemEstoque;

            $result->MoveNext();
        }

        if (count($estoques)) {
            $msg = "Pedido(s) localizado(s) com sucesso!(tabelaitensPedidoEstoque(pviestoques))";
            $retorno->retorno = true;
            $retorno->mensagem = $msg;
            $retorno->estoques = $estoques;
        } else {
            $msg = $sql . "N&atilde;o foi possivel localizar pedido(s)! (tabelaitensPedidoEstoque(pviestoques))" . $db->ErrorMsg();
            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        }

        return $retorno;
    }

    /**
     * Metodo para efetuar pesquisa dos itens de um pedido.
     * Executa select na tabela pvitembeta ver config.php lista de tabelas.
     *
     * @access public
     * @param integer $pvnumero Recebe o numero do Pedido
     * @return object Retorna objetos com retorno da busca;
     */
    public function getItens($pvnumero) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $sql = "SELECT * FROM " . TABELA_ITENS_PEDIDO . " WHERE pvnumero='$pvnumero'";

        $result = $db->Execute($sql);

        $retorno = new stdClass();
        if (!$result) {
            $msg = "FALHA NA CONEXAO COM BANCO DE DADOS. " . $db->ErrorMsg();

            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        }

        while (!$result->EOF) {
            $itemPedido = new ItemPedidoVO();
            $itemPedido->pvicodigo = $result->fields[0];
            $itemPedido->pvitem = $result->fields[2];
            $itemPedido->produto = new ProdutoVO($result->fields[3]);
            $itemPedido->pvipreco = $result->fields[4];
            $itemPedido->pvisaldo = $result->fields[5];
            $itemPedido->pvicomis = $result->fields[6];
            $itemPedido->pvitippr = $result->fields[7];

            //$retornoItemEstoques = $this->getItemEstoques($itemPedido->pvicodigo);
            //$itemPedido->estoques = $retornoItemEstoques->estoques;

            $itemPedido->pvidatacadastro = $result->fields[8];
            $itemPedido->pvisituacao = $result->fields[9];

            $itemPedido->usuario = New UsuarioVO();
            $itemPedido->usuario->codigo = $result->fields[10];

            $itensPedido{$itemPedido->pvicodigo} = $itemPedido;
            $result->MoveNext();
        }

        if (count($itensPedido)) {
            $msg = count($itensPedido) . " ITEN(S) LOCALIZADOS. ";
            $retorno->retorno = true;
            $retorno->mensagem = $msg;
            $retorno->itensPedido = $itensPedido;
        } else {
            $msg = "NAO HA ESTOQUE APROPRIADO. ";
            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        }

        return $retorno;
    }

    /**
     * Metodo para efetuar pesquisa dos itens de um pedido.
     * Executa select na tabela pvitembeta ver config.php lista de tabelas.
     *
     * @access public
     * @param integer $pvnumero Recebe o numero do Pedido
     * @return object Retorna objetos com retorno da busca;
     */
    public function getEstoqueDestino($origem, $destino) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $sql = "SELECT * FROM " . TABELA_ESTOQUE_DESTINO_ORIGEM . " WHERE etqorigem=$origem and etqdestino=$destino";

        $result = $db->GetRow($sql);

        $retorno = new stdClass();
        if (!$result) {
            /* $msg = "NAO FOI POSSIVEL LOCALIZAR. ". $db->ErrorMsg();
              $retorno->retorno = false;
              $retorno->mensagem = $msg; */

            $etqOrigemDestino = new EstoqueDestinoOrigemVO();
            $etqOrigemDestino->etqodCodigo = 0;
            $etqOrigemDestino->estoqueOrigem = new EstoqueVO($origem);
            $etqOrigemDestino->estoqueDestino = new EstoqueVO($destino);
            $etqOrigemDestino->estoqueTemporario = new EstoqueVO(10);

            $msg = "ESTOQUE DE DESTINO PADRAO.";
            $retorno->retorno = true;
            $retorno->mensagem = $msg;
            $retorno->estoqueOrigemDestino = $etqOrigemDestino;
        } else {
            $etqOrigemDestino = new EstoqueDestinoOrigemVO();
            $etqOrigemDestino->etqodCodigo = $result['etqodcodigo'];
            $etqOrigemDestino->estoqueOrigem = new EstoqueVO($result['etqorigem']);
            $etqOrigemDestino->estoqueDestino = new EstoqueVO($result['etqdestino']);
            $etqOrigemDestino->estoqueTemporario = new EstoqueVO($result['etqtemporario']);
            $etqOrigemDestino->etqodDataCadastro = $result['etqoddatacadastro'];
            $etqOrigemDestino->etqodSituacao = $result['etqodsituacao'];

            $msg = "ESTOQUE DE DESTINO LOCALIZADO.";
            $retorno->retorno = true;
            $retorno->mensagem = $msg;
            $retorno->estoqueOrigemDestino = $etqOrigemDestino;
        }

        return $retorno;
    }

    /**
     * Metodo para localizar estoque atual do produto.
     * Executa select para localizar estoque.
     *
     * @access public
     * @param integer $etqcodigo Recebe o valor do codigo do estoque.
     * @param integer $procodgio Recebe o valor do codigo do produto.
     * @return object Retorna objeto do tipo estoque atual;
     */
    public function getEstoqueAtual($etqcodigo, $procodigo) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $sql = "SELECT * FROM " . TABELA_ESTOQUE_ATUAL . " WHERE procodigo = $procodigo AND codestoque = $etqcodigo";

        $row = $db->GetRow($sql);

        $retornoEstoqueAtual = new stdClass();
        if (!$row) {
            $msg = "FALHA NA LOCALIZACAO DO ESTOQUE ATUAL" . $db->ErrorMsg();

            $retornoEstoqueAtual->retorno = false;
            $retornoEstoqueAtual->mensagem = $msg;
        } else {
            $estoqueAtual = new EstoqueAtualVO();
            $estoqueAtual->etqatualcodigo = $row['etqatualcodigo'];

            $estoqueAtual->produto = new ProdutoVO();
            $estoqueAtual->produto->procodigo = $row['procodigo'];

            $estoqueAtual->estqtd = $row['estqtd'];

            $estoqueAtual->estoque = new EstoqueVO($row['codestoque']);

            $msg = "ESTOQUE ATUAL LOCALIZADO";
            $retornoEstoqueAtual->retorno = true;
            $retornoEstoqueAtual->mensagem = $msg;
            $retornoEstoqueAtual->estoqueAtual = $estoqueAtual;
        }

        return $retornoEstoqueAtual;
    }

    /**
     * Metodo para efetuar pesquisa dos pedidos no banco.
     * Executa select na tabela pvitembeta ver config.php lista de tabelas.
     *
     * @access public
     * @param integer pvnumero lista item pedidos
     * @return object Retorna objetos do tipo json;
     */
    public function getVales($clicod) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $sql = "SELECT devolucao.pvnumero as numero, devolucao.dvnumero, devolucao.pvbaixa, (select sum(pvipreco*pvidevol) 
			FROM dvitem 
			WHERE devolucao.pvvale = dvitem.pvvale) as valor,
			0 as desconto, devolucao.pvemissao as emissao, devolucao.pvdevolucao as devolucao, devolucao.pvvale as vale,
			(CASE WHEN clientes.clicod isnull THEN fornecedor.forcodigo ELSE clientes.clicod END) as cliente, 
			(CASE WHEN clientes.clirazao isnull THEN fornecedor.forrazao ELSE clientes.clirazao END) as razao, 
			pvenda.vencodigo as vendedor
			FROM devolucao
			LEFT JOIN pvenda on devolucao.pvnumero=pvenda.pvnumero
			LEFT JOIN clientes on pvenda.clicodigo = clientes.clicodigo
			LEFT JOIN fornecedor on pvenda.clicodigo = fornecedor.forcodigo
			WHERE  devolucao.pvbaixa is null and clientes.clicod='$clicod'
			ORDER BY devolucao.pvnumero,devolucao.pvvale asc";

        $result = $db->Execute($sql);

        $retorno = new stdClass();
        if (!$result) {
            $msg = $sql . "Falha na conexao com banco de dados! " . $db->ErrorMsg();

            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        }
        while (!$result->EOF) {
            $vale = new ValeVO();
            $vale->numero = trim($result->fields[0]);
            $vale->dvnumero = trim($result->fields[1]);
            $vale->pvbaixa = trim($result->fields[2]);
            $vale->valor = trim($result->fields[3]);
            $vale->desconto = trim($result->fields[4]);
            $vale->emissao = trim($result->fields[5]);
            $vale->devolucao = trim($result->fields[6]);
            $vale->vale = trim($result->fields[7]);
            $vale->cliente = trim($result->fields[8]);
            $vale->razao = trim($result->fields[9]);
            $vale->vendedor = trim($result->fields[10]);

            $vales{$vale->dvnumero} = $vale;
            $result->MoveNext();
        }

        if (count($vales)) {
            $msg = $sql . "Vales(s) localizado(s) com sucesso!";
            $retorno->retorno = true;
            $retorno->mensagem = $msg;
            $retorno->vales = $vales;
        } else {
            $msg = $sql . "N&atilde;o foi possivel localizar vale(s)! " . $db->ErrorMsg();
            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        }

        return $retorno;
    }

    /**
     * Metodo para efetuar verificacao dos estoques existentes no estoque atual.
     * Executa select, insert e update na tabela estoqueatual config.php lista de tabelas.
     *
     * @access public
     * @param array Lista de EstoqueVO para add no estoque atual
     * @return object Retorna objeto com resultado do banco;
     */
    public function verificaEstoquesAtuais($aEstoques, $produto, $qtd = 0) {
        $conexao = new Conexao();
        $db = $conexao->connection();
        $retorno = new stdClass();
        $aRetornoEstoqueAtual = array();
        foreach ($aEstoques as $kEstoque => $vEstoque) {
            $sql = "SELECT * FROM " . TABELA_ESTOQUE_ATUAL . " WHERE procodigo = $produto->procodigo AND codestoque = $vEstoque->etqcodigo";
            $row = $db->GetRow($sql);

            if (!$row) {
                $record['procodigo'] = $produto->procodigo;
                $record['estqtd'] = $qtd;
                $record['codestoque'] = $vEstoque->etqcodigo;
                $record['usucodigo'] = 0;

                $result = $db->AutoExecute(TABELA_ESTOQUE_ATUAL, $record, 'INSERT');

                if (!$result) {
                    $msg = "NAO FOI POSSIVEL INSERIR ESTOQUE ATUAL DO PRODUTO $produto->procodigo NO ESTOQUE $vEstoque->etqcodigo" . $db->ErrorMsg();
                    $retornoEstoqueAtual->retorno = false;
                    $retornoEstoqueAtual->mensagem = $msg;
                } else {
                    $msg = "ESTOQUE ATUAL DO PRODUTO $produto->procodigo NO ESTOQUE $vEstoque->etqcodigo CRIADO COM A QUANTIDADE DE $qtd ITENS";
                    $retornoEstoqueAtual->retorno = true;
                    $retornoEstoqueAtual->mensagem = $msg;
                }

                $aRetornoEstoqueAtual[] = $retornoEstoqueAtual;
            }
        }

        if (count($aRetornoEstoqueAtual)) {
            $retorno->isInsert = true;
            $retorno->aRetornoEstoqueAtual = $aRetornoEstoqueAtual;
        } else {
            $retorno->isInsert = false;
        }

        return $retorno;
    }

    /**
     * Metodo para efetuar pesquisa dos pedidos no banco.
     * Executa select na tabela pvenda ver config.php lista de tabelas.
     *
     * @access public
     * @param string $tipo Nome do campo para pesquisar.
     * @param string $pesquisa Texto para pesquisa.
     * @return object Retorna objetos do tipo json;
     */
    public function saldoTotalItensPedidos($pvnumero) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $row = $db->GetRow("SELECT sum(pvisaldo) as saldototal FROM " . TABELA_ITENS_PEDIDO2 . " WHERE pvnumero='$pvnumero' ");

        if (!$row) {
            $msg = $row . "NAO FOI POSSIVEL SOMAR O SALDO.";

            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        } else {

            $msg = "Saldo Total " . $row['saldototal'];

            $retorno->retorno = true;
            $retorno->mensagem = $msg;
            $retorno = $row['saldototal'];
        }
        return $retorno;
    }

    /**
     * Metodo para efetuar pesquisa dos pedidos no banco.
     * Executa select na tabela pvenda ver config.php lista de tabelas.
     *
     * @access public
     * @param string $tipo Nome do campo para pesquisar.
     * @param string $pesquisa Texto para pesquisa.
     * @return object Retorna objetos do tipo json;
     */
    public function valorTotalPreFechamento($pvnumero) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $row = $db->GetRow("SELECT sum(fecvalor) as valortotal FROM " . TABELA_PREFECHAMENTO . " WHERE pvnumero='$pvnumero' ");

        if (!$row) {
            $msg = $row . "NAO FOI POSSIVEL SOMAR O VALOR TOTAL.";

            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        } else {

            $msg = "VALOR TOTAL " . $row['valortotal'];

            $retorno->retorno = true;
            $retorno->mensagem = $msg;
            $retorno = $row['valortotal'];
        }
        return $retorno;
    }

    /**
     * Metodo para efetuar pesquisa dos pedidos no banco.
     * Executa select na tabela pvenda ver config.php lista de tabelas.
     *
     * @access public
     * @param string $tipo Nome do campo para pesquisar.
     * @param string $pesquisa Texto para pesquisa.
     * @return object Retorna objetos do tipo json;
     */
    public function saldoTotalItensEstoque($pvnumero) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $row = $db->GetRow("SELECT sum(pvieqtd) as saldototal FROM " . TABELA_ITENS_PEDIDO_ESTOQUES . " WHERE pvnumero='$pvnumero' ");

        if (!$row) {
            $msg = $row . "NAO FOI POSSIVEL SOMAR A Quantidade do estoque.";

            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        } else {

            $msg = "Quantidade Total em Estoque " . $row['saldototal'];

            $retorno->retorno = true;
            $retorno->mensagem = $msg;
            $retorno = $row['saldototal'];
        }
        return $retorno;
    }

    /**
     * Metodo para efetuar pesquisa dos pedidos no banco.
     * Executa select na tabela pvenda ver config.php lista de tabelas.
     *
     * @access public
     * @param string $tipo Nome do campo para pesquisar.
     * @param string $pesquisa Texto para pesquisa.
     * @return object Retorna objetos do tipo json;
     */
    public function saldoTotalParcelaCobranca($pvnumero) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $row = $db->GetRow("SELECT sum(cobvalor) as saldototal FROM " . TABELA_COBRANCA . " WHERE pvnumero='$pvnumero' ");

        if (!$row) {
            $msg = $row . "NAO FOI POSSIVEL SOMAR A Quantidade do estoque.";

            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        } else {

            $msg = "Quantidade Total em Estoque " . $row['saldototal'];

            $retorno->retorno = true;
            $retorno->mensagem = $msg;
            $retorno = $row['saldototal'];
        }
        return $retorno;
    }

    /**
     * Metodo para efetuar pesquisa dos pedidos no banco.
     * Executa select na tabela pvenda ver config.php lista de tabelas.
     *
     * @access public
     * @param string $tipo Nome do campo para pesquisar.
     * @param string $pesquisa Texto para pesquisa.
     * @return object Retorna objetos do tipo json;
     */
    public function pesquisar($tipoPesquisa, $txtpesquisa, $exata) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        switch ($exata) {
            case 1:
                $where = "$tipoPesquisa LIKE '$txtpesquisa%'";
                break;

            case 2:
                $where = "$tipoPesquisa LIKE '%$txtpesquisa%'";
                break;

            case 3:
                $where = "$tipoPesquisa = '$txtpesquisa'";
                break;
        }


        $sql = "select cobcodigo,
					cobnumero,
					to_char(cobemissao,'DD/MM/YYYY') as cobemissao,
					to_char(cobvecto,'DD/MM/YYYY') as cobvecto,
					cobvalor,
					to_char(cobrecebto,'DD/MM/YYYY') as cobrecebto,
					cobtipo,
					clicodigo,
					cobbanco,
					cobagencia,
					cobcheque,
					cobconta,
					cobpago,
					cobjuros,
					cobmulta,
					cobdesconto,
					cobsituacao,
					to_char(cobdeposito,'DD/MM/YYYY') as cobdeposito,
					to_char(cobcompensacao,'DD/MM/YYYY') as cobcompensacao,
					to_char(cobdevolucao,'DD/MM/YYYY') as cobdevolucao,
					to_char(cobcancelamento,'DD/MM/YYYY') as cobcancelamento,
					analise,
					pvnumero
					from cobranca  where $where ORDER BY cobcodigo";

        $result = $db->Execute($sql);

        $retorno = new stdClass();

        if (!$result) {
            $msg = "FALHA NA CONEXAO COM BANCO DE DADOS " . $db->ErrorMsg();

            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        }
        while (!$result->EOF) {
            $cobranca = new CobrancaVO();
            $cobranca->cobcodigo = $result->fields[0];
            $cobranca->cobnumero = $result->fields[1];
            $cobranca->cobemissao = $result->fields[2];
            $cobranca->cobvecto = $result->fields[3];
            $cobranca->cobvalor = $result->fields[4];
            $cobranca->cobrecebto = $result->fields[5];
            $cobranca->cobtipo = $result->fields[6];
            $cobranca->clicodigo = $result->fields[7];
            $cobranca->cobbanco = $result->fields[8];
            $cobranca->cobagencia = $result->fields[9];
            $cobranca->cobcheque = $result->fields[10];
            $cobranca->cobconta = $result->fields[11];
            $cobranca->cobpago = $result->fields[12];
            $cobranca->cobjuros = $result->fields[13];
            $cobranca->cobmulta = $result->fields[14];
            $cobranca->cobdesconto = $result->fields[15];
            $cobranca->cobsituacao = $result->fields[16];
            $cobranca->cobdeposito = $result->fields[17];
            $cobranca->cobcompensacao = $result->fields[18];
            $cobranca->cobdevolucao = $result->fields[19];
            $cobranca->cobcancelamento = $result->fields[20];
            $cobranca->analise = $result->fields[21];
            $cobranca->pvnumero = $result->fields[22];

            $cobranca->cliente = new ClienteVO($cobranca->clicodigo);
            $cobranca->fechamento = new FechamentoVO($cobranca > pvnumero);
            $cobranca->TotalItensPedidos = $this->saldoTotalItensPedidos($cobranca->pvnumero);
            $cobranca->TotalItensEstoque = $this->saldoTotalItensEstoque($cobranca->pvnumero);
            $cobranca->TotalParcelaCobranca = $this->saldoTotalParcelaCobranca($cobranca->pvnumero);
            $cobranca->TotalValorPreFechamento = $this->valorTotalPreFechamento($cobranca->pvnumero);

            $cobrancas{$cobranca->cobcodigo} = $cobranca;

            $result->MoveNext();
        }


        if (count($cobrancas)) {
            $msg = "LOCALIZADO(S) " . count($cobrancas) . " PEDIDO(S). ";

            $retorno->retorno = true;
            $retorno->mensagem = $msg;
            $retorno->cobrancas = $cobrancas;
        } else {
            $msg = "NAO FOI POSSIVEL LOCALIZAR PEDIDO(S). ";

            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        }

        //$retorno->mensagem .= $retornoItensPedido->mensagem;

        return $retorno;
    }

    public function getCobranca($pvnumero) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $sql = "select a.cobcodigo,a.cobnumero,to_char(a.cobemissao,'DD/MM/YYYY') as cobemissao,to_char(a.cobvecto,'DD/MM/YYYY') as cobvecto,a.cobvalor,to_char(a.cobrecebto,'DD/MM/YYYY') as cobrecebto,a.cobtipo,a.clicodigo,a.cobbanco,a.cobagencia,
a.cobcheque,a.cobconta,a.cobpago,a.cobjuros,a.cobmulta,a.cobdesconto,a.cobsituacao,to_char(a.cobdeposito,'DD/MM/YYYY') as cobdeposito,
to_char(a.cobcompensacao,'DD/MM/YYYY') as cobcompensacao,
to_char(a.cobdevolucao,'DD/MM/YYYY') as cobdevolucao,
to_char(a.cobcancelamento,'DD/MM/YYYY') as cobcancelamento,
a.analise,a.pvnumero
from cobranca a  where a.pvnumero='$pvnumero' ORDER BY a.cobcodigo";

        $result = $db->Execute($sql);

        $retorno = new stdClass();

        if (!$result) {
            $msg = "FALHA NA CONEXAO COM BANCO DE DADOS " . $db->ErrorMsg();

            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        }
        while (!$result->EOF) {
            $cobranca = new CobrancaVO();
            $cobranca->cobcodigo = $result->fields[0];
            $cobranca->cobnumero = $result->fields[1];
            $cobranca->cobemissao = $result->fields[2];
            $cobranca->cobvecto = $result->fields[3];
            $cobranca->cobvalor = $result->fields[4];
            $cobranca->cobrecebto = $result->fields[5];
            $cobranca->cobtipo = $result->fields[6];
            $cobranca->clicodigo = $result->fields[7];
            $cobranca->cobbanco = $result->fields[8];
            $cobranca->cobagencia = $result->fields[9];
            $cobranca->cobcheque = $result->fields[10];
            $cobranca->cobconta = $result->fields[11];
            $cobranca->cobpago = $result->fields[12];
            $cobranca->cobjuros = $result->fields[13];
            $cobranca->cobmulta = $result->fields[14];
            $cobrancais->cobdesconto = $result->fields[15];
            $cobrancahis->cobsituacao = $result->fields[16];
            $cobranca->cobdeposito = $result->fields[17];
            $cobranca->cobcompensacao = $result->fields[18];
            $cobranca->cobdevolucao = $result->fields[19];
            $cobranca->cobcancelamento = $result->fields[20];
            $cobranca->analise = $result->fields[21];
            $cobranca->pvnumero = $result->fields[22];

            $cobrancas{$cobranca->cobcodigo} = $cobranca;

            $result->MoveNext();
        }

        if (count($cobrancas)) {
            $msg = "LOCALIZADO(S) " . count($cobrancas) . " PEDIDO(S). ";

            $retorno->retorno = true;
            $retorno->mensagem = $msg;
            $retorno->cobranca = $cobrancas;
        } else {
            $msg = "NAO FOI POSSIVEL LOCALIZAR PEDIDO(S). ";

            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        }

        //$retorno->mensagem .= $retornoItensPedido->mensagem;

        return $retorno;
    }

    public function cobranca(CobrancaVO $cobranca) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $record['fecdata'] = $cobranca->fecdata;
        $record['pvnumero'] = $cobranca->pvnumero;
        $record['fecforma'] = $cobranca->fecforma;
        $record['fecdocto'] = $cobranca->fecdocto;
        $record['fecbanco'] = $cobranca->fecbanco;
        $record['fecvalor'] = $cobranca->fecvalor;
        $record['fecvecto'] = $cobranca->fecvecto;
        $record['clicodigo'] = $cobranca->clicodigo;
        $record['vencodigo'] = $cobranca->vencodigo;
        $record['fectipo'] = $cobranca->fectipo;
        $record['fecagencia'] = $cobranca->fecagencia;
        $record['fecempresa'] = $cobranca->fecempresa;
        $record['feccaixa'] = $cobranca->feccaixa;
        $record['feccartao'] = $cobranca->feccartao;
        $record['fecconta'] = $cobranca->fecconta;
        $record['fecdia'] = $cobranca->fecdia;

        $resultinsert = $db->AutoExecute(TABELA_PREFECHAMENTO, $record, 'INSERT');
        $retorno = new stdClass();
        $retorno->itemFormaPagamento = $itemFormaPagamento;

        if (!$resultinsert) {
            $msg = "HOUVE FALHAS NO CADASTRO DE PREFECHAMENTO, NAO FOI POSSIVEL FAZER O PREFECHAMENTO. \n" . $db->ErrorMsg();
            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        } else {


            $msg = "PREFECHAMENTO REALIZADO COM SUCESSO ";
            $retorno->retorno = true;
            $retorno->mensagem = $msg;

            $retorno->itemFormaPagamento = $itemFormaPagamento;
        }
        $row = $db->GetRow("SELECT sum(fecvalor) as valortotal FROM " . TABELA_PREFECHAMENTO . " WHERE pvnumero='$itemFormaPagamento->pvnumero' ");
        $retorno->total += $row['valortotal'];
        return $retorno;
    }

    public function alteraCondicao($pvcondcon, $pvnumero) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $sql = "UPDATE " . TABELA_PEDIDOS . " SET pvcondcon='$pvcondcon' WHERE pvnumero='$pvnumero' ";

        $result = $db->Execute($sql);

        if (!$result) {
            $msg = $sql . "NAO FOI POSSIVEL EFETUAR ALTERACAO. " . $db->ErrorMsg();
            $retorno->mensagem = $msg;
            $retorno->retorno = false;
        } else {
            $sqllista = "SELECT  * FROM " . TABELA_PREFECHAMENTO . " WHERE	pvnumero = '$pvnumero'";
            $resultlista = $db->Execute($sqllista);
            if (count($resultlista) != 0) {
                $sqldel = "DELETE FROM " . TABELA_PREFECHAMENTO . " WHERE pvnumero = '$pvnumero'";
                $resultdel = $db->Execute($sqldel);
            }
            $msg = $sql . "ALTERADO O PEDIDO N. " . $result->pvnumero . ". ";
            $retorno->retorno = true;
            $retorno->mensagem = $msg;
        }

        return $retorno;
    }

}

?>
	