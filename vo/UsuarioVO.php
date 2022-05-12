<?php

//pega da pasta de istalacao
$arr = explode("/", $_SERVER['REQUEST_URI']);
$root = $arr[1];

//pega as configura��es do servidor
require_once($_SERVER['DOCUMENT_ROOT'] . "/$root/include/config.php");
require_once(DIR_ROOT . '/include/classes/Conexao.php');

//inclui Values Object
require_once(DIR_ROOT . '/vo/UsuarioVO.php');

/**
 * Classe Value Object do Usuario.
 *
 * @access public
 * @name Usuario
 * @package vo
 * @link vo/UsuarioVO.php
 * @version 1.0
 * @since Criado 27/10/2009 Modificado 02/11/2009
 * @author wellington <wellington@centroatacadista.com.br>
 * @exemple vo/UsuarioVO.php
 */
class UsuarioVO {

    /**
     * Codigo de Identifica��o no Acesso no Banco.
     *
     * @access public
     * @var integer
     */
    public $codigo;

    /**
     * Login do usu�rio.
     *
     * @access public
     * @var string
     */
    public $login;

    /**
     * Nome do usu�rio.
     *
     * @access public
     * @var string
     */
    public $nome;

    /**
     * Senha do usu�rio criptografada.
     *
     * @access public
     * @var string
     */
    public $senha;

    /**
     * Email do usu�rio.
     *
     * @access public
     * @var string
     */
    public $email;

    /**
     * Empresa do grupo a qual o usu�rio faz parte.
     *
     * @access public
     * @var EmpresaVO
     */
    public $empresa;

    /**
     * N�vel (cargo) do usu�rio.
     *
     * @access public
     * @var NivelVO
     */
    public $nivel;

    /**
     * Caixa de fechamento a qual o usu�rio faz parte.
     *
     * @access public
     * @var string
     */
    public $caixa;

    /**
     * Verifica se o usuario ter� acesso externo ao sistema.
     * <i>"true"</i> ter� acesso de qualquer lugar (n�o verificar ip)
     *
     * @access public
     * @var boolean
     */
    public $acessoExterno;

    /**
     * Data do Cadastro.
     *
     * @access public
     * @var datetime
     */
    public $dataCadastro;

    /**
     * Situa��o do usuario no sistema.
     * ativo ou inativo
     *
     * @access public
     * @var boolean
     */
    public $situacao;

    /**
     * Permiss�es de acesso do usu�rio nas paginas.
     *
     * @access public
     * @var UsuarioAcessoVO
     */
    public $acesso;

    /**
     * Tipo de acesso do usu�rio nas paginas.
     *
     * @access public
     * @var array
     */
    public $tipoAcessos;

    /**
     * Cadastro para .
     *
     * @access public
     * @var object
     */
    public $link;

    /**
     * Este campo ser� excluido apos implanta��o do usuarioBeta.
     *
     * @access public
     * @var integer
     */
    public $local;

    /**
     * Tipo Explicito da Classe.
     *
     * @access public
     * @var string
     */
    public $_explicitType = "vo.UsuarioVO";

    /**
     * Metodo construtor para popular campos.
     * Utiliza Clientes modulo pesquisa.
     *
     * @access private
     * @param string $valor Codigo serial da tabela, n�o informado n�o popula VO.
     * @return void
     */
    function __construct($valor = 0) {
        if ($valor) {
            
            $conexao = new Conexao();
            $db = $conexao->connection();
            $result = $db->GetRow("SELECT * FROM cadusuarios WHERE usucodigo='$valor'");

            $this->codigo = $result['usucodigo'];
            $this->login = $result['usulogin'];
            $this->nome = $result['usunome'];
            $this->senha = $result['ususenha'];
            $this->nivel = $result['usunivel'];
            $this->empresa = $result['usuempresa'];
            $this->local = $result['usulocal'];
            $this->caixa = $result['usucaixa'];
            $this->email = $result['usuemail'];
            $this->infopedido = $result['infopedido'];
            $this->relatorio_interfix = $result['relatorio_interfix'];
        }
    }

}

