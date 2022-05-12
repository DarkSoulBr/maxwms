<?php

//pega da pasta de istalacao
$arr = explode("/", $_SERVER['REQUEST_URI']);
$root = $arr[1];

//pega as configurações do servidor
require_once($_SERVER['DOCUMENT_ROOT'] . "/$root/include/config.php");

require_once(DIR_ROOT . '/include/classes/JSON/JSON.php');
require_once(DIR_ROOT . '/modulos/cadastros/diversos/transportadoras/manutencao/model/TransportadoraModel.php');

/**
 * Classe Value Object Transportadora.
 *
 * @access public
 * @name Transportadora
 * @package vo
 * @link vo/TransportadoraVO.php
 * @version 1.0
 * @since Criado 02/12/2009 Modificado 02/12/2009
 * @author wellington <wellington@centroatacadista.com.br>
 * @exemple vo/TransportadoraVO.php
 */
class TransportadoraVO {

    /**
     * Codigo da Transportadora.
     *
     * @access public
     * @var integer
     */
    public $tracodigo;

    /**
     * Nome de Guerra da Transportadora.
     *
     * @access public
     * @var string
     */
    public $tranguerra;

    /**
     * Razão Social do Transportador.
     *
     * @access public
     * @var string
     */
    public $trarazao;

    /**
     * Endereço do Transportador.
     *
     * @access public
     * @var string
     */
    public $traendereco;

    /**
     * Bairro do Transportador.
     *
     * @access public
     * @var string
     */
    public $trabairro;

    /**
     * Cidade Interna Transportadora.
     *
     * @access public
     * @var CidadeVO
     */
    public $cidade;

    /**
     * CEP do Transportador.
     *
     * @access public
     * @var string
     */
    public $tracep;

    /**
     * Telefone do Transportador.
     *
     * @access public
     * @var string
     */
    public $trafone;

    /**
     * Fax do Transportador.
     *
     * @access public
     * @var string
     */
    public $trafax;

    /**
     * Observação Relativa ao Transportador.
     *
     * @access public
     * @var string
     */
    public $traobs;

    /**
     * E-mail do transportador.
     *
     * @access public
     * @var string
     */
    public $traemail;

    /**
     * Usuário que está acessando o Registro.
     *
     * @access public
     * @var UsuarioVO
     */
    public $usuario;

    /**
     * Rota.
     *
     * @access public
     * @var RotaVO
     */
    public $rota;

    /**
     * CNPJ da Transportadora.
     *
     * @access public
     * @var string
     */
    public $tracnpj;

    /**
     * Versão do Conemb que essa transp. utiliza.
     *
     * @access public
     * @var double
     */
    public $conembvers;

    /**
     * Versão do Ocoren que essa transp. utiliza.
     *
     * @access public
     * @var double
     */
    public $ocorenvers;

    /**
     * Versão do Doccob que essa transp. utiliza.
     *
     * @access public
     * @var double
     */
    public $doccobvers;

    /**
     * Tipo Explicito da Classe.
     *
     * @access public
     * @var string
     */
    public $_explicitType = "vo.TransportadoraVO";

    /**
     * Metodo construtor para popular campos.
     * Utiliza Transportadoras modulo pesquisa.
     *
     * @access private
     * @param string $valor Codigo serial da tabela, não informado não popula VO.
     * @return void
     */
    function __construct($valor = 0, $campo = 'tracodigo') {
        if ($valor) {
            $conexao = new Conexao();
            $db = $conexao->connection();
            $result = $db->GetRow("SELECT * FROM " . TABELA_TRANSPORTADORAS . " WHERE $campo = '$valor'");

            $this->tracodigo = $result['tracodigo'];
            $this->tranguerra = trim($result['tranguerra']);
            $this->trarazao = trim($result['trarazao']);
            $this->traendereco = trim($result['traendereco']);
            $this->tracep = trim($result['tracep']);
            $this->trafone = trim($result['trafone']);
            $this->trafax = trim($result['trafax']);
            $this->traobs = trim($result['traobs']);
            $this->traemail = trim($result['traemail']);
            $this->tracnpj = trim($result['tracnpj']);
            $this->conembvers = trim($result['conembvers']);
            $this->ocorenvers = trim($result['ocorenvers']);
            $this->doccobvers = trim($result['doccobvers']);
        }
    }

}

?>