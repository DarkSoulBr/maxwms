<?php
	//pega da pasta de istalacao
	$arr = explode("/", $_SERVER[REQUEST_URI]);
	$root = $arr[1];

	//pega as configuraчѕes do servidor
	require_once($_SERVER[DOCUMENT_ROOT]."/$root/include/config.php");

	// inclui o model para acesso busca info no banco
	require_once(DIR_ROOT.'/modulos/login/model/LoginModel.php');

/**
* Classe de controle para verificaчуo de acessos ao sistema.
*
* Este arquivo aquivo segue os padroes estabelecidos no dTrade.
* 
* @access public
* @name Login Controller
* @package modulos/login/controller
* @link modulos/login/controller/Controller.php
* @version 1.0
* @since Criado 02/11/2009 Modificado 02/11/2009
* @author wellington <wellington@centroatacadista.com.br>
* @exemple modulos/login/controller/Controller.php
*/
Class Controller 
{
	var $usuario;
	/**
	* Metodo para regras de negocios para buscar usuario.
	* Instancia model para buscar no banco.
	*
	* @access public
	* @param string $login Login do usuario, string $senha Senha do usuario criptografada.
	* @return UsuarioVO Caso login valido retorna variavel tipada, caso login invalido retorna "false".
	*/ 	
   	public function verificarLogin ($login, $senha) 
    {		
   		$this->usuario = new LoginModel();
		$this->usuario = $this->usuario->buscarUsuario($login, $senha);
   	}
   	
}
?>