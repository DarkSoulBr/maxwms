<?php

//pega da pasta de istalacao
$arr = explode("/", $_SERVER['REQUEST_URI']);
$root = $arr[1];

//pega as configura��es do servidor
require_once($_SERVER['DOCUMENT_ROOT'] . "/$root/include/config.php");

require_once(DIR_ROOT . '/include/classes/Conexao.php');
require_once(DIR_ROOT . '/include/funcoes/removeCaracterEspecial.php');

/**
 * Classe Value Object Cidade.
 *
 * @access public
 * @name Cidade
 * @package vo
 * @link vo/CidadeVO.php
 * @version 1.0
 * @since Criado 02/12/2009 Modificado 02/12/2009
 * @author wellington <wellington@centroatacadista.com.br>
 * @exemple vo/CidadeVO.php
 */
class CidadeVO {

    /**
     * C�digo Interno Autom�tico da Cidade.
     *
     * @access public
     * @var integer
     */
    public $cidcodigo;

    /**
     * Codigo.
     *
     * @access public
     * @var integer
     */
    public $codigo;

    /**
     * Descri��o da Cidade.
     *
     * @access public
     * @var string
     */
    public $descricao;

    /**
     * Descri��o da Cidade B.
     *
     * @access public
     * @var string
     */
    public $descricaoB;

    /**
     * CEP.
     *
     * @access public
     * @var string
     */
    public $cep;

    /**
     * UF.
     *
     * @access public
     * @var string
     */
    public $uf;

    /**
     * Situacao.
     *
     * @access public
     * @var integer
     */
    public $situacao;

    /**
     * Tipo de Localidade.
     *
     * @access public
     * @var string
     */
    public $tipoLocalidade;

    /**
     * Numero Senquencial da Localidade.
     *
     * @access public
     * @var integer
     */
    public $locNuSequencialSub;

    /**
     * Usu�rio que est� usando o Registro.
     *
     * @access public
     * @var integer
     */
    public $usuario;

    /**
     * Tipo Explicito da Classe.
     *
     * @access public
     * @var string
     */
    public $_explicitType = "vo.CidadeVO";

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
            $json = new Services_JSON();
            $conexao = new Conexao();
            $db = $conexao->connection();
            $result = $db->GetRow("SELECT * FROM " . TABELA_CIDADES . " WHERE cidcodigo='$valor'");

            $this->codigo = $result['codigo'];
            $this->descricao = trim($result['descricao']);
            $this->descricaoB = removeCaracterEspeciais(trim($result['Descricao_B']));
            $this->cep = trim($result['cep']);
            $this->uf = trim($result['uf']);
            $this->situacao = $result['SITUACAO'];
            $this->tipoLocalidade = trim($result['TIPO_LOCALIDADE']);
            $this->locNuSequencialSub = $result['LOC_NU_SEQUENCIAL_SUB'];
            $this->cidcodigo = $result['cidcodigo'];
        }
    }

}
?>
	
