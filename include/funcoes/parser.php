<?php
require_once('removeCaracterEspecial.php');
/**
*
* @access public
* @param string $text Informe a string numerica onde deseja adicionar o ponto flutuante.
* @return string Retorna a string como float.
*/
//Converte string numerica em float
function converteEmFloat( $texto, $qtdCasaDecimal, $marcadorDecimal = ".") {
	$limite = strlen($texto) - $qtdCasaDecimal;
	if($limite <= 0) {
		return $texto;
	}	
	$float = substr($texto, 0, $limite) . $marcadorDecimal . substr($texto, -$qtdCasaDecimal,$qtdCasaDecimal);
	return $float;
}

//Se string é vazia, composto apenas de espaço ou que composto apenas de zero, contendo ponto flutuante ou não, e retorna null.
// Do contrario retorna a propria string
function verificaConverteEmNull( $texto ) {
	if($texto == 0 || strlen($texto) == 0 || preg_match("/^[0]+$/",$texto) || preg_match("/^[0]+\.?\,?[0]+$/",$texto) || preg_match("/^\s+$/",$texto) ) {
		return null;
	} else {
            return $texto;
        }
}

//Insere mascara ##.###.###/####-## no cnpj informado
function insereMascaraCNPJ( $cnpj ) {

   $cnpj = removeTodosCaracterNaoNumericos($cnpj);

    if($cnpj == 0 || strlen($cnpj) > 14){
       return $cnpj;
   } else {
       $cnpj = sprintf("%014s", $cnpj);
   }

   $cnpjComMascara = substr($cnpj, 0, 2) . "." . substr($cnpj, 2,3) . "." . substr($cnpj, 5,3) . "/" . substr($cnpj, 8,4)  . "-" . substr($cnpj, 12,2);

   return $cnpjComMascara;
}



?>