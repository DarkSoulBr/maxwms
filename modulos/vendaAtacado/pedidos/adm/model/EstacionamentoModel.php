<?php

//pega da pasta de istalacao
$arr = explode("/", $_SERVER['REQUEST_URI']);
$root = $arr[1];

//pega as configura??es do servidor
require_once($_SERVER['DOCUMENT_ROOT'] . "/$root/include/config.php");
require_once(DIR_ROOT . '/include/classes/Conexao.php');

require_once(DIR_ROOT . '/vo/EstacionamentoVO.php');
require_once(DIR_ROOT . '/vo/TipoPedidoVO.php');
require_once(DIR_ROOT . '/vo/VendedorVO.php');
require_once(DIR_ROOT . '/vo/ClienteVO.php');
require_once(DIR_ROOT . '/vo/CondicaoComercialVO.php');
require_once(DIR_ROOT . '/vo/TransportadoraVO.php');
require_once(DIR_ROOT . '/vo/PreFechamentoVO.php');
require_once(DIR_ROOT . '/vo/UsuariosVO.php');
require_once(DIR_ROOT . '/vo/PedidoVO.php');

/**
 * Classe modelo para comunica??o com banco de dados.
 *
 * Comunica??o para estacionamento de pedidos.
 * Este arquivo segue os padroes estabelecidos no dTrade.
 *
 * @access public
 * @name Adm Model
 * @package modulos/vendaAtacado/pedidos/adm/model
 * @link modulos/vendaAtacado/pedidos/adm/model/EstacionamentoModel.php
 * @version 1.0.0
 * @since Criado 19/05/2010
 * @author wellington <wellington@centroatacadista.com.br>
 * @exemple modulos/vendaAtacado/pedidos/adm/model/EstacionamentoModel.php
 */
Class EstacionamentoModel {

    /**
     * Metodo para localizar todos pedidos do estacionamento no banco.
     * ver config.php lista de tabelas.
     *
     * @access public
     * @param PedidoVO $valor Recebe variavel do tipo Pedido Value Object.
     * @return object Retorna objeto com informa??es da resposta do banco;
     */
    public function verificaPreFechamento2($pvnumero) {

        $sql = "SELECT * FROM prefechamento WHERE pvnumero='$pvnumero'";
        $query = pg_query($sql);

        $rows = pg_num_rows($query);

        return $rows;
    }

    /**
     * Metodo para efetuar a libera??o de pedido no banco.
     * Executa update na tabela pvenda ver config.php lista de tabelas.
     *
     * @access public
     * @param PedidoVO $valor Recebe variavel tipada.
     * @return object Retorna objeto do tipo json;
     */
    public function liberacaoPedido($id, $usuario) {
        $conexao = new Conexao();
        $db = $conexao->connection();


        $record['pvlibera'] = date("Y-m-d H:i:s");
        $record['pvhora'] = date("H:i");
        $record['pvencer2'] = '6';

        $result = $db->AutoExecute(TABELA_PEDIDOS, $record, 'UPDATE', 'pvnumero=' . $id);

        $retorno = new stdClass();

        if (!$result) {
            $msg = "NAO FOI POSSIVEL LIBERAR O PEDIDO. ENTRE EM CONTATO COM O ADMINISTRADOR! ";
            $retorno->mensagem = $msg;
        } else {

            $sql = "SELECT * FROM " . TABELA_PEDIDOS . " WHERE pvnumero='$id' ";
            $row = $db->GetRow($sql);

            $record2['lgldata'] = date("Y-m-d H:i:s");
            $record2['lglhora'] = date("H:i");
            $record2['usucodigo'] = $usuario;
            $record2['clicodigo'] = $row['clicodigo'];
            $record2['lglpedido'] = $id;
            $record2['lgltipo'] = $row['pvtipoped'];

            $resultlog = $db->AutoExecute(TABELA_LOGLIBERACAO, $record2, 'INSERT');
            $msg = "PEDIDO LIBERADO COM SUCESSO!";
            $retorno->mensagem = $msg;
            $retorno->id = $id;
            $retorno->resultlog = $resultlog;
        }
        return $retorno;
    }

    /**
     * Metodo para localizar todos pedidos do estacionamento no banco.
     * ver config.php lista de tabelas.
     *
     * @access public
     * @param PedidoVO $valor Recebe variavel do tipo Pedido Value Object.
     * @return object Retorna objeto com informa??es da resposta do banco;
     */
    public function verificaPreFechamento($pvnumero) {

        $sql = "SELECT * FROM prefechamento WHERE pvnumero='$pvnumero'";
        $query = pg_query($sql);

        $rows = pg_num_rows($query);

        return $rows;
    }

    /**
     * Metodo para localizar todos pedidos do estacionamento no banco.
     * ver config.php lista de tabelas.
     *
     * @access public
     * @param PedidoVO $valor Recebe variavel do tipo Pedido Value Object.
     * @return object Retorna objeto com informa??es da resposta do banco;
     */
    public function getEstacionamento($dataInicio, $dataFim, $aTipo, $aEstoque, $nivelUsuario) {
        $conexao = new Conexao();
        $db = $conexao->connection();
        $retorno = new stdClass();

        $where = "";
        if (count($aTipo)) {
            $where .= " AND (";
            foreach ($aTipo as $key => $value) {
                if ($key != 0) {
                    $where .= " OR ";
                }
                $where .= "pv.pvtipoped = '$value'";
            }
            $where .= ") ";
        }

        $isCd = false;
        $isVix = false;
        if (count($aEstoque)) {
            $where .= " AND (pv.etqfcodigo is null OR pv.etqfcodigo = 0 ";
            foreach ($aEstoque as $key => $value) {
                /* if ($key != 0)
                  {
                  if($value!="" OR $value!="0" OR $value!="null")
                  {
                  $where .= " OR ";
                  }
                  } */

                if ($value == ESTOQUE_FISICO_CD || $value == ESTOQUE_FISICO_MAT || $value == ESTOQUE_FISICO_FIL) {
                    $isCd = true;
                } else if ($value == ESTOQUE_FISICO_VIX) {
                    $isVix = true;
                }

                if ($value != "" OR $value != "0" OR $value != "null") {
                    $where .= " OR pv.etqfcodigo = '$value'";
                }
            }
            $where .= ") ";
        }

        if ($isCd && !$isVix) {
            $where .= " AND (pv.tipolocal = " . LOCAL_SP . ") ";
        } else if (!$isCd && $isVix) {
            $where .= " AND (pv.tipolocal = " . LOCAL_VIX . ") ";
        }

        if ($nivelUsuario == '1') {
            $where .= " AND pv.pvemissao BETWEEN '$dataInicio' AND '$dataFim' AND (pvencer2='1' OR pvencer2='5') ORDER BY pv.pvemissao ASC";
        } else if ($nivelUsuario == '2') {
            $where .= " AND pv.pvliberafinanceiro BETWEEN '$dataInicio' AND '$dataFim' AND (pvencer2='3' OR pvencer2='4')ORDER BY pv.pvliberafinanceiro ASC";
        }

        $sql = "SELECT
					pv.pvtipoped,
					pv.tipolocal,
					pv.pvnumero,
					pv.clicodigo,
					pv.vencodigo,
					pv.pvemissao,
					(SELECT SUM(pvisaldo * pvipreco) FROM pvitem LEFT JOIN produto USING (procodigo) WHERE pvnumero = pv.pvnumero AND forcodigo = " . MATTEL . ")  AS totalmattel,
					(SELECT SUM(pvisaldo * pvipreco) FROM pvitem LEFT JOIN produto USING (procodigo) WHERE pvnumero = pv.pvnumero AND forcodigo = " . BARAO . ")  AS totalbarao,
					pv.pvvalor,
					pv.pvvaldesc,
					pv.pvcondcon,
					pv.pvobserva,
					pv.pvtipofrete,
					pv.tracodigo,
					pv.pvlibera,
					pv.pvhora,
					pv.pvencer,
					pv.pvencer2,
					pv.pvfinanceiro,
					pv.pvliberafinanceiro,
					pv.obsfinanceiro,
					pv.usuario,
					(SELECT SUM(fecvalor) FROM prefechamento where pvnumero = pv.pvnumero) AS valorprefec
				FROM " . TABELA_PEDIDOS . " AS pv
                                INNER JOIN " . TABELA_CLIENTES . " cli ON pv.clicodigo = cli.clicodigo
				WHERE (pv.pvlibera is null AND pv.pvhora is null) AND cli.clipessoa = '1' $where
				";

        $result = $db->GetAll($sql);

        if (!$result) {
            $msg = "[" . date('d.m.Y H:i:s') . "] ERRO: NAO FOI POSSIVEL GERAR ESTACIONAMENTO DE PEDIDOS. " . $db->ErrorMsg();
            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        } else {
            $msg = "[" . date('d.m.Y H:i:s') . "] OK: ESTACIONAMENTO DE PEDIDOS. ";
            $retorno->retorno = true;
            $retorno->mensagem = $msg;
            $retorno->rows = pg_num_rows(pg_query($sql));

            foreach ($result as $key => $value) {
                $estacionamento = new EstacionamentoVO();
                $estacionamento->tipoPedido = new TipoPedidoVO($value['pvtipoped']);
                $estacionamento->tipolocal = $value['tipolocal'] ? $value['tipolocal'] : "";
                $estacionamento->vendedor = new VendedorVO($value['vencodigo']);
                $estacionamento->pvnumero = $value['pvnumero'];
                $estacionamento->cliente = new ClienteVO($value['clicodigo']);

                /* 		
                  if(!$isCd && $isVix){
                  echo "<pre>";
                  print_r($estacionamento->cliente);
                  echo "</pre>";
                  }
                 */
                $estacionamento->pvemissao = $value['pvemissao'];
                $estacionamento->pvliberafinanceiro = $value['pvliberafinanceiro'];
                $estacionamento->totalMattel = $value['totalmattel'] ? $value['totalmattel'] : 0;
                $estacionamento->totalBarao = $value['totalbarao'] ? $value['totalbarao'] : 0;
                $estacionamento->pvvalor = $value['pvvalor'] ? $value['pvvalor'] : 0;
                $estacionamento->pvvaldesc = $value['pvvaldesc'];
                $estacionamento->condicaoComercial = new CondicaoComercialVO($value['pvcondcon']);
                $estacionamento->pvobserva = $value['pvobserva'];
                $estacionamento->pvtipofrete = $value['pvtipofrete'] ? $value['pvtipofrete'] : "";
                $estacionamento->transportadora = new TransportadoraVO($value['tracodigo']);
                $estacionamento->pvlibera = $value['pvlibera'] ? $value['pvlibera'] : "";
                $estacionamento->pvhora = $value['pvhora'] ? $value['pvhora'] : "";
                $estacionamento->pvencer = $value['pvencer'];
                $estacionamento->pvencer2 = $value['pvencer2'];
                $estacionamento->pvfinanceiro = $value['pvfinanceiro'];
                $estacionamento->valorPreFechamento = $value['valorprefec'];
                $estacionamento->usuario = new UsuariosVO($value['usuario']);
                $estacionamento->preFechamento = new PreFechamentoVO($value['pvnumero']);
                $estacionamento->obsfinanceiro = $value['obsfinanceiro'];
                $estacionamento->formaPagto = array();

                $sqlFPgto = "SELECT distinct fp.pagdescricao
                                FROM " . TABELA_PREFECHAMENTO . " pref
                                inner join " . TABELA_FORMAS_PAGAMENTO . " fp on fp.pagcodigo = pref.fecforma
                                 WHERE pref.pvnumero =" . $value['pvnumero'];

                $resultFPgto = $db->GetAll($sqlFPgto);

                if ($resultFPgto) {

                    foreach ($resultFPgto as $valueFPgto) {
                        array_push($estacionamento->formaPagto, $valueFPgto['pagdescricao']);
                    }
                }






                $retorno->aEstacionamento[] = $estacionamento;
            }
        }

        return $retorno;
    }

    public function getPedidoEstacionamento2($pvnumero) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $retorno = new stdClass();

        $sql = "SELECT
					pv.pvtipoped,
					pv.tipolocal,
					pv.pvnumero,
					pv.clicodigo,
					pv.vencodigo,
					pv.pvemissao,
					(SELECT SUM(pvisaldo * pvipreco) FROM pvitem LEFT JOIN produto USING (procodigo) WHERE pvnumero = pv.pvnumero AND forcodigo = " . MATTEL . ")  AS totalmattel,
					(SELECT SUM(pvisaldo * pvipreco) FROM pvitem LEFT JOIN produto USING (procodigo) WHERE pvnumero = pv.pvnumero AND forcodigo = " . BARAO . ")  AS totalbarao,
					pv.pvvalor,
					pv.pvvaldesc,
					pv.pvcondcon,
					pv.pvobserva,
					pv.pvtipofrete,
					pv.tracodigo,
					pv.pvlibera,
					pv.pvhora,
					pv.pvencer,
					pv.pvencer2,
					pv.pvfinanceiro,
					pv.pvliberafinanceiro,
					pv.obsfinanceiro,
					pv.pvemissao,
                                        pv.pvtipoped,
                                        pv.pvlibdep,
                                        pv.pvlibfil,
                                        pv.pvlibmat,
                                        pv.pvlibvit,
					(SELECT SUM(fecvalor) FROM prefechamento where pvnumero = pv.pvnumero) AS valorprefec
				FROM " . TABELA_PEDIDOS . " AS pv
				WHERE pv.pvnumero = $pvnumero;";

        $result = $db->GetRow($sql);

        if (!$result) {
            $msg = "[" . date('d.m.Y H:i:s') . "] ERRO: NAO FOI POSSIVEL RECUPERAR PEDIDO $pvnumero. " . $db->ErrorMsg();
            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        } else {
            $msg = "[" . date('d.m.Y H:i:s') . "] OK: PEDIDO $pvnumero RECUPERADO.";
            $retorno->retorno = true;
            $retorno->mensagem = $msg;


            $estacionamento = new EstacionamentoVO();

            $estacionamento->pvnumero = $result['pvnumero'];
            $estacionamento->valorPreFechamento = $result['valorprefec'];
            $estacionamento->tipoPedido = $result['pvtipoped'];
            $estacionamento->cliente = new ClienteVO($result['clicodigo']);

            //DEPOIS PEGAR USU?RIO
            $retorno->estacionamento = $estacionamento;

            $pedido = new PedidoVO();

            $pedido->pvnumero = $result['pvnumero'];
            $pedido->pvemissao = $result['pvemissao'];
            $pedido->pvlibdep = $result['pvlibdep'];
            $pedido->pvlibfil = $result['pvlibfil'];
            $pedido->pvlibmat = $result['pvlibmat'];
            $pedido->pvlibvit = $result['pvlibvit'];

            $retorno->pedido = $pedido;
        }

        return $retorno;
    }

    /**
     * Metodo para localizar todos pedidos do estacionamento no banco.
     * ver config.php lista de tabelas.
     *
     * @access public
     * @param PedidoVO $valor Recebe variavel do tipo Pedido Value Object.
     * @return object Retorna objeto com informa??es da resposta do banco;
     */
    public function getPedidoEstacionamento($pvnumero) {
        $conexao = new Conexao();
        $db = $conexao->connection();
        $retorno = new stdClass();

        $sql = "SELECT
					pv.pvtipoped,
					pv.tipolocal,
					pv.pvnumero,
					pv.clicodigo,
					pv.vencodigo,
					pv.pvemissao,
					(SELECT SUM(pvisaldo * pvipreco) FROM pvitem LEFT JOIN produto USING (procodigo) WHERE pvnumero = pv.pvnumero AND forcodigo = " . MATTEL . ")  AS totalmattel,
					(SELECT SUM(pvisaldo * pvipreco) FROM pvitem LEFT JOIN produto USING (procodigo) WHERE pvnumero = pv.pvnumero AND forcodigo = " . BARAO . ")  AS totalbarao,
					pv.pvvalor,
					pv.pvvaldesc,
					pv.pvcondcon,
					pv.pvobserva,
					pv.pvtipofrete,
					pv.tracodigo,
					pv.pvlibera,
					pv.pvhora,
					pv.pvencer,
					pv.pvencer2,
					pv.pvfinanceiro,
					pv.pvliberafinanceiro,
					pv.obsfinanceiro,
					(SELECT SUM(fecvalor) FROM prefechamento where pvnumero = pv.pvnumero) AS valorprefec
				FROM " . TABELA_PEDIDOS . " AS pv
				WHERE pv.pvnumero = $pvnumero;";

        $result = $db->GetRow($sql);

        if (!$result) {
            $msg = "[" . date('d.m.Y H:i:s') . "] ERRO: NAO FOI POSSIVEL RECUPERAR PEDIDO $pvnumero. " . $db->ErrorMsg();
            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        } else {
            $msg = "[" . date('d.m.Y H:i:s') . "] OK: PEDIDO $pvnumero RECUPERADO.";
            $retorno->retorno = true;
            $retorno->mensagem = $msg;
            $retorno->rows = pg_num_rows(pg_query($sql));

            $estacionamento = new EstacionamentoVO();
            $estacionamento->tipoPedido = new TipoPedidoVO($result['pvtipoped']);
            $estacionamento->tipolocal = $result['tipolocal'] ? $result['tipolocal'] : "";
            $estacionamento->vendedor = new VendedorVO($result['vencodigo']);
            $estacionamento->pvnumero = $result['pvnumero'];
            $estacionamento->cliente = new ClienteVO($result['clicodigo']);
            $estacionamento->pvemissao = $result['pvemissao'];
            $estacionamento->pvliberafinanceiro = $result['pvliberafinanceiro'];
            $estacionamento->totalMattel = $result['totalmattel'] ? $result['totalmattel'] : 0;
            $estacionamento->totalBarao = $result['totalbarao'] ? $result['totalbarao'] : 0;
            $estacionamento->pvvalor = $result['pvvalor'] ? $result['pvvalor'] : 0;
            $estacionamento->pvvaldesc = $result['pvvaldesc'];
            $estacionamento->condicaoComercial = new CondicaoComercialVO($result['pvcondcon']);
            $estacionamento->pvobserva = $result['pvobserva'];
            $estacionamento->pvtipofrete = $result['pvtipofrete'] ? $result['pvtipofrete'] : "";
            $estacionamento->transportadora = new TransportadoraVO($result['tracodigo']);
            $estacionamento->pvlibera = $result['pvlibera'] ? $result['pvlibera'] : "";
            $estacionamento->pvhora = $result['pvhora'] ? $result['pvhora'] : "";
            $estacionamento->pvencer = $result['pvencer'];
            $estacionamento->pvencer2 = $result['pvencer2'];
            $estacionamento->pvfinanceiro = $result['pvfinanceiro'];
            $estacionamento->valorPreFechamento = $result['valorprefec'];
            $estacionamento->prefechamento = $this->verificaPreFechamento($result['pvnumero']);
            $estacionamento->obsfinanceiro = $result['obsfinanceiro'];



            $retorno->estacionamento = $estacionamento;
        }

        return $retorno;
    }

    /**
     * Metodo para localizar verificar a senha digitada para liberar pedido bloqueado devido a valida??o cidade IBGE divergente da cidade Faturamento
     * ver config.php lista de tabelas.
     *
     * @access public
     * @param PedidoVO $valor Recebe variavel do tipo Pedido Value Object.
     * @return object Retorna objeto com informa??es da resposta do banco;
     */
    public function getPass($usuario, $pw, $clicodigo) {
        $conexao = new Conexao();
        $db = $conexao->connection();

        $sql = "SELECT * FROM " . TABELA_USUARIOS . " WHERE usucodigo='$usuario' AND ususenha = '$pw'";
        $query = pg_query($sql);

        $rows = pg_num_rows($query);

        if ($rows) {


            $record['clilibibgediferente'] = date("Y-m-d H:i:s");
            $record['clilibibgediferenteusuario'] = $usuario;

            $result = $db->AutoExecute(TABELA_CLIENTES, $record, 'UPDATE', 'clicodigo=' . $clicodigo);
        }


        return $rows;
    }

    /**
     * Metodo para localizar todos pedidos do estacionamento no banco.
     * ver config.php lista de tabelas.
     *
     * @access public
     * @param PedidoVO $valor Recebe variavel do tipo Pedido Value Object.
     * @return object Retorna objeto com informa??es da resposta do banco;
     */
    public function alteraSituacaoPedido($pvnumero, $situacao = "1", $observacao) {
        $conexao = new Conexao();
        $db = $conexao->connection();
        $retorno = new stdClass();

        $record['obsfinanceiro'] = $observacao;
        if ($situacao == '22') {
            $record['pvfinanceiro'] = '1';
        } else {
            $record['pvencer2'] = $situacao;
        }

        $data = date("Y-m-d H:i:s");
        if ($situacao == '3') {
            $record['pvliberafinanceiro'] = $data;
        } elseif ($situacao == '4') {
            $record['pvliberapendente'] = $data;
        } elseif ($situacao == '5') {
            $record['pvliberanegado'] = $data;
        }


        $result = $db->AutoExecute(TABELA_PEDIDOS, $record, 'UPDATE', 'pvnumero=' . $pvnumero);

        if (!$result) {
            $msg = "[" . date('d.m.Y H:i:s') . "] ERRO: NAO FOI ATUALIZAR SITUACAO DO PEDIDO $pvnumero. " . $db->ErrorMsg();
            $retorno->retorno = false;
            $retorno->mensagem = $msg;
        } else {
            $msg = "[" . date('d.m.Y H:i:s') . "] OK: SITUACAO DO PEDIDO $pvnumero ALTERADO PARA $situacao.";
            $retorno->retorno = true;
            $retorno->mensagem = $msg;
        }

        return $retorno;
    }

}

?>