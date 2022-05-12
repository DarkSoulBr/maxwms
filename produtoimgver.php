<? 

	$parametro = trim($_POST["parametro"]);
	$parametro2 = trim($_POST["parametro2"]);
	
	if($parametro2=='_' || $parametro2==''){
	
	}
	else {
		$destino = 'produtos/' . $parametro . '.jpg';
		copy($parametro2, $destino);
	}
	
	if(file_exists("produtos/$parametro.jpg")) 
	{ 
		$codigo=1; 
	}
	else { 
		$codigo=2; 
	}

	//XML
	$xml  = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
	$xml .= "<dados>\n";
	$xml .= "<dado>\n";
	$xml .= "<codigo>".$codigo."</codigo>\n";
	$xml .= "<descricao>".$parametro."</descricao>\n";
	$xml .= "</dado>\n";
    $xml.= "</dados>\n";
  
    Header("Content-type: application/xml; charset=iso-8859-1");

	echo $xml;
	
?>
