<?php
/**
* Classe que chamada no codigo para gerar arquivos.
* 
*
* @access public
* @name GeraArquivos
* @package include/classes
* @link include/classes/GeraArquivos.php
* @version 1.0
* @since Criado 29/11/2010 Modificado 24/11/2009
* @author Douglas <douglas@centroatacadista.com.br>
* @exemple include/classes/GeraArquivos.php
*/


class  GeraArquivo
{
	public $fp;
	
	public function __construct($filename, $method = "a")
	{
		$this->fp = fopen ($filename, $method);
	}
	
	public function addContent($content)
	{
		fputs($this->fp, $content);
	}
	
	public function __destruct()
	{
		fclose($this->fp);
	}
}
?>