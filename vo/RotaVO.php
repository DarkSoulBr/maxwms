<?php
/**
* Classe Value Object Rota.
*
* @access public
* @name Tributo
* @package vo
* @link vo/RotaVO.php
* @version 1.0
* @since Criado 02/12/2009 Modificado 02/12/2009
* @author wellington <wellington@centroatacadista.com.br>
* @exemple vo/RotaVO.php
*/

class RotaVO
{
	/**
	* C�digo da Rota.
	*
	* @access public
	* @var integer
	*/
	public $rotcodigo;
  
	/**
	* Nome da Rota.
	*
	* @access public
	* @var string
	*/
	public $rotnome;
  
	/**
	* Usu�rio que est� acessando o Registro.
	*
	* @access public
	* @var UsuarioVO
	*/
	public $usuario;

	/**
	* Tipo Explicito da Classe.
	*
	* @access public
	* @var string
	*/
	public $_explicitType = "vo.RotaVO";	
}

?>