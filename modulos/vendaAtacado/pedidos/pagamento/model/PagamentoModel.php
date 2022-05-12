<?php

//pega da pasta de istalacao
$arr = explode("/", $_SERVER['REQUEST_URI']);
$root = $arr[1];

//pega as configurações do servidor
require_once($_SERVER['DOCUMENT_ROOT'] . "/$root/include/config.php");
require_once(DIR_ROOT . '/include/classes/Conexao.php');
require_once(DIR_ROOT . '/vo/ItemFormaPagamentoVO.php');
require_once(DIR_ROOT . '/vo/ValeVO.php');
require_once(DIR_ROOT . '/vo/PreFechamentoVO.php');

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
Class PagamentoModel {

    /**
     * Metodo para efetuar inserção do pedido no banco.
     * Executa insert na tabela de pedido ver config.php lista de tabelas.
     *
     * @access public
     * @param PedidoVO $valor Recebe variavel do tipo Pedido Value Object.
     * @return object Retorna objeto com informações da resposta do banco;
     */
    public function preFechamento(ItemFormaPagamentoVO $itemFormaPagamento) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $record['fecdata'] = $itemFormaPagamento->fecdata;
        $record['pvnumero'] = $itemFormaPagamento->pvnumero;
        $record['fecforma'] = $itemFormaPagamento->fecforma;
        $record['fecdocto'] = $itemFormaPagamento->fecdocto;
        $record['fecbanco'] = $itemFormaPagamento->fecbanco;
        $record['fecvalor'] = $itemFormaPagamento->fecvalor;
        $record['fecvecto'] = $itemFormaPagamento->fecvecto;
        $record['clicodigo'] = $itemFormaPagamento->clicodigo;
        $record['vencodigo'] = $itemFormaPagamento->vencodigo;
        $record['fectipo'] = $itemFormaPagamento->fectipo;
        $record['fecagencia'] = $itemFormaPagamento->fecagencia;
        $record['fecempresa'] = $itemFormaPagamento->fecempresa;
        $record['feccaixa'] = $itemFormaPagamento->feccaixa;
        $record['feccartao'] = $itemFormaPagamento->feccartao;
        $record['fecconta'] = $itemFormaPagamento->fecconta;
        $record['fecdia'] = $itemFormaPagamento->fecdia;

        $resultinsert = $db->AutoExecute(TABELA_PREFECHAMENTO, $record, 'INSERT');

        if ($itemFormaPagamento->fecforma == '105') {
            $pvbaixa = date("Y-m-d H:i:s");
            print $sqlU = "UPDATE " . TABELA_DEVOLUCAO . " SET pvbaixa='$pvbaixa' WHERE pvvale=$itemFormaPagamento->fecdocto";
            $db->Execute($sqlU);
        }
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

    /**
     * Metodo para efetuar inserção do pedido no banco.
     * Executa insert na tabela de pedido ver config.php lista de tabelas.
     *
     * @access public
     * @param PedidoVO $valor Recebe variavel do tipo Pedido Value Object.
     * @return object Retorna objeto com informações da resposta do banco;
     */
    public function excluiPedido($pvnumero) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $sql = "DELETE FROM " . TABELA_PREFECHAMENTO . " WHERE pvnumero='$pvnumero'";
        $result = $db->Execute($sql);

        if (!$result) {
            $msg = "HOUVE FALHAS NA EXCLUSAO DAS PARCELAS. \n" . $db->ErrorMsg();
            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        } else {
            $msg = "PARCELAS EXCLUIDAS COM SUCESSO ";
            $retorno->retorno = true;
            $retorno->mensagem = $msg;
        }
        return $retorno;
    }

    public function exluiPreFechamentoAnterior($pvnumero) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $sql = "select * from prefechamento where pvnumero='$pvnumero'";
        $result = $db->Execute($sql);

        while (!$result->EOF) {
            $preFechamento = new PreFechamentoVO();
            $preFechamento->prefeccodigo = $result->fields[0];
            $preFechamento->fecdata = $result->fields[1];
            $preFechamento->pvnumero = $result->fields[2];
            $preFechamento->fecforma = $result->fields[3];
            $preFechamento->fecdocto = $result->fields[4];
            $preFechamento->fecbanco = $result->fields[5];
            $preFechamento->fecvalor = $result->fields[6];
            $preFechamento->fecvecto = $result->fields[7];
            $preFechamento->clicodigo = $result->fields[8];
            $preFechamento->vencodigo = $result->fields[9];
            $preFechamento->fectipo = $result->fields[10];
            $preFechamento->fecagencia = $result->fields[11];
            $preFechamento->fecempresa = $result->fields[12];
            $preFechamento->feccaixa = $result->fields[13];
            $preFechamento->feccartao = $result->fields[14];
            $preFechamento->fecconta = $result->fields[15];
            $preFechamento->fecdia = $result->fields[16];

            if ($result->fields[3] == '105') {
                $sqlU = "UPDATE " . TABELA_DEVOLUCAO . " SET pvbaixa=null WHERE pvvale=$preFechamento->fecdocto";
                $db->Execute($sqlU);
            }
            $result->MoveNext();
        }


        $sql = "DELETE FROM PREFECHAMENTO WHERE pvnumero=$pvnumero";
        $result = $db->Execute($sql);
        $retorno = new stdClass();

        if (!$result) {
            $msg = "ITENS NAO FORAM EXCLUIDOS COM SUCESSO. \n" . $db->ErrorMsg();
            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        } else {
            $msg = "ITENS EXCLUIDOS COM SUCESSO";
            $retorno->retorno = true;
            $retorno->mensagem = $msg;
        }
        return $retorno;
    }

    /**
     * Metodo para efetuar inserção do pedido no banco.
     * Executa insert na tabela de pedido ver config.php lista de tabelas.
     *
     * @access public
     * @param PedidoVO $valor Recebe variavel do tipo Pedido Value Object.
     * @return object Retorna objeto com informações da resposta do banco;
     */
    public function baixaVale($pvvale, $clicod, $pvnumero) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $sql = "UPDATE " . TABELA_DEVOLUCAO . " SET pvbaixa=null  WHERE pvvale='$pvvale'";
        $result = $db->Execute($sql);



        if (!$result) {
            $msg = "HOUVE FALHAS NA EXCLUSAO DO VALE. \n" . $db->ErrorMsg();
            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        } else {

            $sql3 = "DELETE FROM " . TABELA_PREFECHAMENTO . " WHERE fecdocto='$pvvale'";
            $result3 = $db->Execute($sql3);

            $sql2 = "SELECT devolucao.pvnumero as numero, devolucao.dvnumero, devolucao.pvbaixa, (select sum(pvipreco*pvidevol) 
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
			WHERE devolucao.pvbaixa isnull and clientes.clicod='$clicod'
			ORDER BY devolucao.pvnumero,devolucao.pvvale asc";

            $result2 = $db->Execute($sql2);

            $retorno = new stdClass();
            if (!$result2) {
                $msg = $sql . "Falha na conexao com banco de dados! " . $db->ErrorMsg();
                $retorno->retorno = false;
                $retorno->mensagem = $msg;
            }

            while (!$result2->EOF) {
                $vale = new ValeVO();
                $vale->numero = trim($result2->fields[0]);
                $vale->dvnumero = trim($result2->fields[1]);
                $vale->pvbaixa = trim($result2->fields[2]);
                $vale->valor = trim($result2->fields[3]);
                $vale->desconto = trim($result2->fields[4]);
                $vale->emissao = trim($result2->fields[5]);
                $vale->devolucao = trim($result2->fields[6]);
                $vale->vale = trim($result2->fields[7]);
                $vale->cliente = trim($result2->fields[8]);
                $vale->razao = trim($result2->fields[9]);
                $vale->vendedor = trim($result2->fields[10]);

                $vales{$vale->dvnumero} = $vale;

                $result2->MoveNext();
            }

            $sql4 = "select prefeccodigo,
				  to_char(fecdata, 'dd/mm/yyyy') as fecdata,
				  pvnumero,
				  fecforma,
				  fecdocto,
				  fecbanco,
				  fecvalor,
				  to_char(fecvecto, 'dd/mm/yyyy') as fecvecto,
				  clicodigo,
				  vencodigo,
				  fectipo,
				  fecagencia,
				  fecempresa,
				  feccaixa,
				  feccartao,
				  fecconta,
				  fecdia 
				from prefechamento where pvnumero='$pvnumero'";

            $result4 = $db->Execute($sql4);

            while (!$result4->EOF) {
                $preFechamento = new PreFechamentoVO();
                $preFechamento->prefeccodigo = $result4->fields[0];
                $preFechamento->fecdata = $result4->fields[1];
                $preFechamento->pvnumero = $result4->fields[2];
                $preFechamento->fecforma = $result4->fields[3];
                $preFechamento->fecdocto = $result4->fields[4];
                $preFechamento->fecbanco = $result4->fields[5];
                $preFechamento->fecvalor = $result4->fields[6];
                $preFechamento->fecvecto = $result4->fields[7];
                $preFechamento->clicodigo = $result4->fields[8];
                $preFechamento->vencodigo = $result4->fields[9];
                $preFechamento->fectipo = $result4->fields[10];
                $preFechamento->fecagencia = $result4->fields[11];
                $preFechamento->fecempresa = $result4->fields[12];
                $preFechamento->feccaixa = $result4->fields[13];
                $preFechamento->feccartao = $result4->fields[14];
                $preFechamento->fecconta = $result4->fields[15];
                $preFechamento->fecdia = $result4->fields[16];

                $preFechamentos{$preFechamento->prefeccodigo} = $preFechamento;

                $result4->MoveNext();
            }
            $retorno->preFechamentos = $preFechamentos;



            $msg = "VALE EXCLUIDO COM SUCESSO ";
            $retorno->retorno = true;
            $retorno->mensagem = $msg;
            $retorno->vales = $vales;
            $retorno->docto = $pvvale;
        }
        return $retorno;
    }

    /**
     * Metodo para efetuar inserção do pedido no banco.
     * Executa insert na tabela de pedido ver config.php lista de tabelas.
     *
     * @access public
     * @param PedidoVO $valor Recebe variavel do tipo Pedido Value Object.
     * @return object Retorna objeto com informações da resposta do banco;
     */
    public function upVale2($pvvaleUp, $clicodUp, $pvnumero, $fecvalor, $clicodigo, $vencodigo) {
        $conexao = new Conexao();
        $db = $conexao->connection();
        $pvbaixa = date("Y-m-d H:i:s");

        $sql = "UPDATE " . TABELA_DEVOLUCAO . " SET pvbaixa='$pvbaixa'  WHERE pvvale='$pvvaleUp'";
        $result = $db->Execute($sql);



        if (!$result) {
            $msg = "HOUVE FALHAS NA EXCLUSAO DO VALE. \n" . $db->ErrorMsg();
            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        } else {


            print $sql2 = "SELECT devolucao.pvnumero as numero, devolucao.dvnumero, devolucao.pvbaixa, (select sum(pvipreco*pvidevol) 
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
			WHERE devolucao.pvbaixa isnull and clientes.clicodigo='$clicodUp'
			ORDER BY devolucao.pvnumero,devolucao.pvvale asc";

            $result2 = $db->Execute($sql2);

            $retorno = new stdClass();
            if (!$result2) {
                $msg = $sql . "Falha na conexao com banco de dados! " . $db->ErrorMsg();
                $retorno->retorno = false;
                $retorno->mensagem = $msg;
            }

            while (!$result2->EOF) {
                $vale = new ValeVO();
                $vale->numero = trim($result2->fields[0]);
                $vale->dvnumero = trim($result2->fields[1]);
                $vale->pvbaixa = trim($result2->fields[2]);
                $vale->valor = trim($result2->fields[3]);
                $vale->desconto = trim($result2->fields[4]);
                $vale->emissao = trim($result2->fields[5]);
                $vale->devolucao = trim($result2->fields[6]);
                $vale->vale = trim($result2->fields[7]);
                $vale->cliente = trim($result2->fields[8]);
                $vale->razao = trim($result2->fields[9]);
                $vale->vendedor = trim($result2->fields[10]);

                $vales{$vale->dvnumero} = $vale;

                $result2->MoveNext();
            }

            $sql4 = "select prefeccodigo,
				  to_char(fecdata, 'dd/mm/yyyy') as fecdata,
				  pvnumero,
				  fecforma,
				  fecdocto,
				  fecbanco,
				  fecvalor,
				  to_char(fecvecto, 'dd/mm/yyyy') as fecvecto,
				  clicodigo,
				  vencodigo,
				  fectipo,
				  fecagencia,
				  fecempresa,
				  feccaixa,
				  feccartao,
				  fecconta,
				  fecdia 
				from prefechamento where pvnumero='$pvnumero'";

            $result4 = $db->Execute($sql4);

            while (!$result4->EOF) {
                $preFechamento = new PreFechamentoVO();
                $preFechamento->prefeccodigo = $result4->fields[0];
                $preFechamento->fecdata = $result4->fields[1];
                $preFechamento->pvnumero = $result4->fields[2];
                $preFechamento->fecforma = $result4->fields[3];
                $preFechamento->fecdocto = $result4->fields[4];
                $preFechamento->fecbanco = $result4->fields[5];
                $preFechamento->fecvalor = $result4->fields[6];
                $preFechamento->fecvecto = $result4->fields[7];
                $preFechamento->clicodigo = $result4->fields[8];
                $preFechamento->vencodigo = $result4->fields[9];
                $preFechamento->fectipo = $result4->fields[10];
                $preFechamento->fecagencia = $result4->fields[11];
                $preFechamento->fecempresa = $result4->fields[12];
                $preFechamento->feccaixa = $result4->fields[13];
                $preFechamento->feccartao = $result4->fields[14];
                $preFechamento->fecconta = $result4->fields[15];
                $preFechamento->fecdia = $result4->fields[16];

                $preFechamentos{$preFechamento->prefeccodigo} = $preFechamento;

                $result4->MoveNext();
            }
            $retorno->preFechamentos = $preFechamentos;



            $msg = "VALE EXCLUIDO COM SUCESSO ";
            $retorno->retorno = true;
            $retorno->mensagem = $msg;
            $retorno->vales = $vales;
            $retorno->docto = $pvvaleUp;
        }
        return $retorno;
    }

}

?>
