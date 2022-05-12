<?php

//pega da pasta de istalacao
$arr = explode("/", $_SERVER['REQUEST_URI']);
$root = $arr[1];

//pega as configurações do servidor
require_once($_SERVER['DOCUMENT_ROOT'] . "/$root/include/config.php");

require_once(DIR_ROOT . '/include/classes/Conexao.php');
require_once(DIR_ROOT . '/vo/TransportadoraVO.php');
require_once(DIR_ROOT . '/vo/CidadeVO.php');
require_once(DIR_ROOT . '/vo/UsuarioVO.php');
require_once(DIR_ROOT . '/vo/RotaVO.php');

/**
 * Classe modelo para comunicação com banco de dados.
 * 
 * Comunicação e Manutenção da tabela transportador.
 * Este arquivo segue os padroes estabelecidos no dTrade.
 *
 * @access public
 * @name Transportadora Model
 * @package modulos/cadastros/diversos/transportadoras/manutencao/model
 * @link modulos/cadastros/diversos/transportadoras/manutencao/model/TransportadoraModel.php
 * @version 1.0
 * @since Criado 30/11/2009 Modificado 30/11/2009
 * @author wellington <wellington@centroatacadista.com.br>
 * @exemple modulos/cadastros/diversos/transportadoras/manutencao/model/TransportadoraModel.php
 */
Class TransportadoraModel {

    /**
     * Metodo para efetuar inserção do cliente no banco.
     * Executa insert na tabela vendedores ver config.php lista de tabelas.
     *
     * @access public
     * @param VendedorVO $valor Recebe variavel do tipo Vendedor Value Object.
     * @return object Retorna objeto do tipo json;
     */
    public function inserir(TransportadoraVO $valor) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $sql = "INSERT INTO " . TABELA_CLIENTES . " 
			(
				
			) 
			VALUES 
			(
				
			)";
        $result = $db->Execute($sql);

        if (!$result) {
            $msg = "N&atilde;o foi possiv&eacute;l efetuar cadastro! " . $db->ErrorMsg();
            print json_encode(array("retorno" => false, "mensagem" => $msg));
        } else {
            $msg = "Insers&atilde;o efetuado com sucesso!";
            print json_encode(array("retorno" => true, "mensagem" => $msg));
        }
    }

    /**
     * Metodo para efetuar pesquisa dos transportadoras no banco.
     * Executa select na tabela transportador ver config.php lista de tabelas.
     *
     * @access public
     * @param string $tipo Nome do campo para pesquisar.
     * @param string $pesquisa Texto para pesquisa.
     * @param boolean $exata Verifica se a pesquisa e exata, default não exata.
     * @return object Retorna objetos do tipo json;
     */
    public function pesquisar($tipo, $pesquisa, $exata = 0) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        switch ($exata) {
            case 0:
                $where = "$tipo LIKE '$pesquisa%'";
                break;

            case 1:
                $where = "$tipo LIKE '%$pesquisa%'";
                break;

            case 2:
                $where = "$tipo = '$pesquisa'";
                break;
        }

        $sql = "SELECT 
					* 
				FROM 
					" . TABELA_TRANSPORTADORAS . "
				WHERE
					$where";

        $result = $db->Execute($sql);

        $retorno = new stdClass();

        if (!$result) {
            $msg = "Falha na conexao com banco de dados! " . $db->ErrorMsg();

            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        }

        while (!$result->EOF) {
            $transportadora = new TransportadoraVO();
            $transportadora->tranguerra = $result->fields[0];
            $transportadora->trarazao = $result->fields[1];
            $transportadora->traendereco = $result->fields[2];
            $transportadora->trabairro = $result->fields[3];

            $transportadora->cidade = new CidadeVO();
            $transportadora->cidade->cidcodigo = $result->fields[4];

            $transportadora->tracep = $result->fields[5];
            $transportadora->trafone = $result->fields[6];
            $transportadora->trafax = $result->fields[7];
            $transportadora->traobs = $result->fields[8];
            $transportadora->traemail = $result->fields[9];

            $transportadora->usuario = new UsuarioVO();
            $transportadora->usuario->codigo = $result->fields[10];

            $transportadora->tracodigo = $result->fields[11];

            $transportadora->rota = new RotaVO();
            $transportadora->rota->rotcodigo = $result->fields[12];

            $transportadora->tracnpj = $result->fields[13];


            $transportadoras[$transportadora->tracodigo] = $transportadora;

            $result->MoveNext();
        }

        if (count($transportadoras)) {
            $msg = "Transportadora(s) localizada(s) com sucesso!";

            $retorno->retorno = true;
            $retorno->mensagem = $msg;
            $retorno->transportadoras = $transportadoras;
        } else {
            $msg = "N&atilde;o foi possivel localizar transportadora(s)! " . $db->ErrorMsg();

            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        }

        return $retorno;
    }

    /**
     * Metodo para efetuar pesquisa dos transportadoras no banco.
     * Executa select na tabela transportador ver config.php lista de tabelas.
     *
     * @access public
     * @param string $tipo Nome do campo para pesquisar.
     * @param string $pesquisa Texto para pesquisa.
     * @param boolean $exata Verifica se a pesquisa e exata, default não exata.
     * @return object Retorna objetos do tipo json;
     */
    public function getTransportadoras($tipo, $pesquisa, $exata = 0) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        switch ($exata) {
            case 0:
                $where = "$tipo LIKE '$pesquisa%'";
                break;

            case 1:
                $where = "$tipo LIKE '%$pesquisa%'";
                break;

            case 2:
                $where = "$tipo = '$pesquisa'";
                break;
        }

        $sql = "SELECT 
					* 
				FROM 
					" . TABELA_TRANSPORTADORAS . "
				WHERE
					$where";

        $result = $db->GetAll($sql);

        $retorno = new stdClass();
        $transportadoras = array();

        if (!$result) {
            $msg = "[" . date('d.m.Y H:i:s') . "] ATENCAO: NAO FOI POSSIVEL LOCALIZAR TRANSPORTADORA(S) [$tipo $pesquisa]. " . $db->ErrorMsg();
            ;
            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        } else {
            $msg = "[" . date('d.m.Y H:i:s') . "] OK: LOCALIZADO(S) " . count($result) . " TRANSPORTADORA(S) [$tipo $pesquisa].";
            $retorno->retorno = true;
            $retorno->mensagem = $msg;

            foreach ($result as $value) {
                $transportadora = new TransportadoraVO();
                $transportadora->tranguerra = $value['tranguerra'];
                $transportadora->trarazao = $value['trarazao'];
                $transportadora->traendereco = $value['traendereco'];
                $transportadora->trabairro = $value['trabairro'];
                $transportadora->cidade = new CidadeVO();
                $transportadora->cidade->cidcodigo = $value['cidcodigo'];
                $transportadora->tracep = $value['tracep'];
                $transportadora->trafone = $value['trafone'];
                $transportadora->trafax = $value['trafax'];
                $transportadora->traobs = $value['traobs'];
                $transportadora->traemail = $value['traemail'];
                $transportadora->usuario = new UsuarioVO();
                $transportadora->usuario->codigo = $value['usucodigo'];
                $transportadora->tracodigo = $value['tracodigo'];
                $transportadora->rota = new RotaVO();
                $transportadora->rota->rotcodigo = $value['rotcodigo'];
                $transportadora->tracnpj = $value['tracnpj'];

                $transportadoras[] = $transportadora;
            }
        }
        $retorno->transportadoras = $transportadoras;

        return $retorno;
    }

    /**
     * Metodo para efetuar alteração do vendedor no banco.
     * Executa update na tabela usuariosbeta ver config.php lista de tabelas.
     *
     * @access public
     * @param UsuarioVO $valor Recebe variavel tipada.
     * @return object Retorna objeto do tipo json;
     */
    public function alterar(TransportadoraVO $valor) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $sql = "UPDATE " . TABELA_CLIENTES . "
				SET 
					usulogin = '$valor->login',
					usunome = '$valor->nome', 
					ususenha = '$valor->senha', 
					usuemail = '$valor->email', 
					empcodigo = $valor->empresa, 
					nvcodigo = $valor->nivel, 
					usucaixa = '$valor->caixa', 
					usuacessoexterno = $valor->acesso
				WHERE
					usucodigo = '$valor->codigo'";

        $result = $db->Execute($sql);

        if (!$result) {
            $msg = "N&atilde;o foi possiv&eacute;l efetuar altera&ccedil;&atilde;o! " . $db->ErrorMsg();
            print json_encode(array("retorno" => false, "mensagem" => $msg));
        } else {
            $msg = "Altera&ccedil;&atilde;o efetuado com sucesso!";
            print json_encode(array("retorno" => true, "mensagem" => $msg, "usuario" => $valor));
        }
    }

    /**
     * Metodo para efetuar excluisão do usuario no banco.
     * Executa delete na tabela usuariosbeta ver config.php lista de tabelas.
     *
     * @access public
     * @param UsuarioVO $valor Recebe variavel tipada.
     * @return object Retorna objeto do tipo json;
     */
    public function excluir(TransportadoraVO $valor) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $sql = "DELETE 
				FROM " . TABELA_CLIENTES . "
				WHERE
					usucodigo = '$valor->codigo'";

        $result = $db->Execute($sql);

        if (!$result) {
            $msg = "N&atilde;o foi possiv&eacute;l efetuar exclus&atilde;o! " . $db->ErrorMsg();
            print json_encode(array("retorno" => false, "mensagem" => $msg));
        } else {
            $msg = "Exclus&atilde;o efetuado com sucesso!";
            print json_encode(array("retorno" => true, "mensagem" => $msg));
        }
    }

}

?>
