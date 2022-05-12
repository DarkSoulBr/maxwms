<?php
/**
* Classe de conexão Banco de Dados Postgres.
*
* @access public
* @name Conexao
* @package vo
* @link include/classes/Conexao.php
* @version 1.0
* @since Criado 09/11/2009 Modificado 09/11/2009
* @author wellington <wellington@centroatacadista.com.br>
* @exemple include/classes/Conexao.php
*/

	//pega da pasta de istalacao
	$arr = explode("/", $_SERVER[REQUEST_URI]);
	$root = $arr[1];

	//pega as configurações do servidor
	require_once($_SERVER[DOCUMENT_ROOT]."/$root/include/config.php");
	
	require_once(DIR_ROOT.'/lib/adodb/adodb.inc.php');

class Conexao 
{
	
	/******************************************************************************************
		CONEXÃO DB
	*******************************************************************************************/
	
	public function connection()
	{
		$dbtype = "postgres";
		$dbhost = "192.168.1.1";
		//$dbname = "teste";
		$dbname = "centro";
		$dbuser = "centro";
		$dbpass = "1234";
		
		$db = NewADOConnection($dbtype);
		$db->PConnect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");
		return $db;
	}
	
	/******************************************************************************************
		CONEXÃO DB
	*******************************************************************************************/	
}
?>