<?php
/**
* Classe que converte um objeto em um XML.
*
* @access public
* @name Empresa do Grupo
* @package vo
* @link vo/EmpresaGrupoVO.php
* @version 1.0
* @since Criado 05/09/2007 Modificado 09/11/2009
* @author Wellington Carvaho <wellington@centroatacadista.com.br>
* @exemple vo/EmpresaGrupoVO.php
*/
Class XmlUtils
{

	/**
	* Cria um XML baseado na estrutura de um Objeto.
	*
	* @access public
	* @param object $obj Objeto a ser convertido.
	* @param boolean $attrDefault Propriedades do Objeto como TextNode ou Attribute.
	* @return string;
	*/
	public static function toXml($obj, $attrDefault = true) 
	{
		$dom = new DOMDocument('1.0', 'utf-8');
		//print_r($obj);
	
		if (is_object($obj)) 
		{
			$dom->appendChild(XmlUtils::object2Xml($obj, $dom, $attrDefault));
		}
	
		if (is_array($obj)) 
		{
			XmlUtils::array2Xml($obj, $dom, $dom, $attrDefault);
		}
	$out = $dom->saveXML();
	
	return $out;
	}

	/**
	* Cria um XML baseado na estrutura de um Objeto.
	*
	* @access private
	* @param array $array de objetos e/ou arrays.
	* @param DOMElement $elem Objeto DOMElement onde serão adicionados os nós.
	* @param DOMDocument $dom Documento pai do XML.
	* @param boolean $attrDefault Propriedades do Objeto como TextNode ou Attribute.
	* @return string;
	*/
	private static function array2Xml($array, &$elem, &$dom, $attrDefault = null) 
	{
		$i = 0;
		for ($i = 0; $i < count($array); $i++) 
		{
			$value = $array[$i];
			if (is_object($value)) 
			{	
				$elem->appendChild(XmlUtils::object2Xml($value, $dom, $attrDefault));
			}
			elseif (is_array($value)) 
			{
				$novoElem = $dom->createElement("object");
				XmlUtils::array2Xml($value, $novoElem, $dom, $attrDefault);
				$elem->appendChild($novoElem);
			}
			else 
			{
				$elem->setAttribute("val$i", $value);
			}
		}
	}

	/**
	* Retorna um DOMElement baseado na estrutura do Objeto.
	*
	* @access private
	* @param object $obj Objeto a ser convertido.
	* @param DOMDocument $dom Documento pai do XML.
	* @return DOMElement;
	*/
	private static function object2Xml($obj, &$dom, $attrDefault = null) 
	{
		
		$vars = get_object_vars($obj);
		if (get_class($obj) != "stdClass")
		{
			$elem = $dom->createElement(get_class($obj));
		} 
		else 
		{
			$elem = $dom->createElement("objeto");
		}
		
		$i = 0;
		
		foreach ($vars as $chave => $valor) 
		{
			if (is_object($valor)) 
			{
				$elem->appendChild(XmlUtils::object2Xml($valor, $dom, $attrDefault));
			} 
			elseif (is_array($valor)) 
			{
				XmlUtils::array2Xml($valor, $elem, $dom, $attrDefault);
			} 
			else 
			{
				if($attrDefault)
				{
					$elem->setAttribute($chave, $valor);
				} 
				else 
				{
					$elem2 = $dom->createElement($chave);
					$elemText = $dom->createTextNode($valor);
					$elem2->appendChild($elemText);
					$elem->appendChild($elem2);
				}
			}
		}
		
		return $elem;
	}
}
?>

