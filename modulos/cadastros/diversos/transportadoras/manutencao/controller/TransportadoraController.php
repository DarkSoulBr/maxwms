<?php
	// inclui o model para acesso busca info no banco
	require_once('../model/TransportadoraModel.php');

/**
* Classe de controle para crud da Transportadora (regras de negocio).
* 
* CRUD - (Create, Result, Update, Delete)
* Este arquivo segue os padroes estabelecidos no dTrade.
*
* @access public
* @name Transportadora Controller
* @package modulos/cadastros/diversos/transportadoras/manutencao/controller
* @link modulos/cadastros/diversos/transportadoras/manutencao/controller/Controller.php
* @version 1.0
* @since Criado 02/12/2009 Modificado 02/12/2009
* @author wellington <wellington@centroatacadista.com.br>
* @exemple modulos/cadastros/diversos/transportadoras/manutencao/controller/Controller.php
*/
Class TransportadoraController 
{  	
	/**
	* Metodo para regras de negocios da inserчуo do vendedor no banco.
	* Instancia a classe model para inserir no banco.
	*
	* @access public
	* @param VendedorVO $valor Recebe variavel tipada Vendedor Value Object.
	* @return object Retorna objeto do tipo json;
	*/
	public function inserir(Transportadora $valor) 
    {	
	   	$model = new TransportadoraModel();
		return $model->inserir($valor);
   	}
	
   	/**
	* Metodo para regras de negocios da pesquisa do cliente no banco.
	* Instancia a classe model para pesquisar no banco.
	*
	* @access public
	* @param string $tipo Nome do campo para pesquisar.
	* @param string $pesquisa Texto para pesquisa.
	* @param boolean $exata Verifica se a pesquisa e exata, default nуo exata.
	* @return object Retorna objeto do tipo json;
	*/
	public function pesquisar($tipo, $pesquisa, $exata = 0) 
    {	
    	$model = new TransportadoraModel();
		return $model->getTransportadoras($tipo, $pesquisa, $exata);
   	}
   	
   	/**
	* Metodo para regras de negocios da alteraчуo do cliente no banco.
	* Instancia a classe model para alteraчуo no banco.
	*
	* @access public
	* @param ClienteVO $valor Recebe variavel tipada Cliente Value Object.
	* @return object Retorna objeto do tipo json;
	*/
	public function alterar(Transportadora $valor) 
    {	
		$model = new TransportadoraModel();
		return $model->alterar($valor);
   	}
   	
   	/**
	* Metodo para regras de negocios da exclusуo do cliente no banco.
	* Instancia a classe model para exclusуo no banco.
	*
	* @access public
	* @param ClienteVO $valor Recebe variavel tipada Cliente Value Object.
	* @return object Retorna objeto do tipo json;
	*/
	public function excluir(Transportadora $valor) 
    {	
		$model = new TransportadoraModel();
		return $model->excluir($valor);
   	}
}
?>