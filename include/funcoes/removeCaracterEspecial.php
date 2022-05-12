<?PHP
/**
* Metodo para remover caracter especial e caracter com acentuação.
* Por default todos os caracteres deverão ser UPPERCASE.
*
* @access public
* @param string $text Informe a string onde deseja remover uma ou mais caracter especial.
* @return string Retorna a string limpa de caracteres especiais.
*/
function removeCaracterEspeciais($text)
{
	$palavra = strtr($text, "ŠŒŽšœžŸ¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ", "SOZsozYYuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy");
	$palavranova = str_replace("_", " ", $palavra);
	
	$palavranova = str_replace("'", "", $palavranova);
	
	$text = strtoupper($palavranova);
	
	return $text;
}

function removeTodosCaracterEspeciais($text)
{
	 $palavra = $text;
	 if(version_compare(PHP_VERSION, '7.0.0', '<')){
		$palavra = ereg_replace("[^a-zA-Z0-9 _]", "", strtr($palavra, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ-", "aaaaeeiooouucAAAAEEIOOOUUC "));
	 }
	 else {
		$palavra = preg_replace("[^a-zA-Z0-9 _]", "", strtr($palavra, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ-", "aaaaeeiooouucAAAAEEIOOOUUC "));
	 }
	 
	return $palavra;
}

function removeTodosCaracterEspeciaisEspaco($text)
{
	 $palavra = $text;
	 if(version_compare(PHP_VERSION, '7.0.0', '<')){
		$palavra = ereg_replace("[^a-zA-Z0-9]", "", strtr($palavra, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ-", "aaaaeeiooouucAAAAEEIOOOUUC"));
	 }
	 else {
		$palavra = preg_replace("[^a-zA-Z0-9]", "", strtr($palavra, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ-", "aaaaeeiooouucAAAAEEIOOOUUC"));
     }	 
	return $palavra;
}

function removeTodosCaracterNaoNumericos($text)
{
	 $palavra = $text;
	 if(version_compare(PHP_VERSION, '7.0.0', '<')){
		$palavra = ereg_replace("[^0-9]", "",$palavra);
	 }	
	 else {
		$palavra = preg_replace("[^0-9]", "",$palavra);
     }	 
	return $palavra;
}
?>
