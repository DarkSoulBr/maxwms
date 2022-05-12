<?

//RECEBE PARÃMETRO                     
$parametro = trim($_POST["parametro"]);           

require_once("include/conexao.inc.php");
require_once("include/banco.php");

$cadastro = new banco($conn,$db);

//QUERY  

if(($parametro)!=0){
	$sql = "
	SELECT a.uscodigo as codigo,a.usdepartamento as descricao
	,a.usgerente as descricao2
	
    FROM cadusuarios a 
	WHERE a.uscodigo = '$parametro'
	ORDER BY a.uscodigo";   

}

//EXECUTA A QUERY               
$sql = pg_query($sql);       

$row = pg_num_rows($sql);   

//VERIFICA SE VOLTOU ALGO 
if($row) {                
   //XML
   $xml  = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
   $xml .= "<dados>\n";               
   
   //PERCORRE ARRAY            
   for($i=0; $i<$row; $i++) {  
	$codigo    = pg_result($sql, $i, "codigo"); 
	$descricao = pg_result($sql, $i, "descricao");
	$descricao2 = pg_result($sql, $i, "descricao2");
	
	if (trim($codigo)==""){$codigo = "0";}
	if (trim($descricao)==""){$descricao = "0";}
	if (trim($descricao2)==""){$descricao2 = "2";}	
	
	
      $xml .= "<dado>\n";     
      $xml .= "<codigo>".$codigo."</codigo>\n";                  
      $xml .= "<descricao>".$descricao."</descricao>\n";  
	  $xml .= "<descricao2>".$descricao2."</descricao2>\n";  	  
      $xml .= "</dado>\n";    
   }//FECHA FOR                 
   
   $xml.= "</dados>\n";
   
   //CABEÇALHO
   Header("Content-type: application/xml; charset=iso-8859-1"); 
}//FECHA IF (row)        
else{

	$xml  = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
	$xml .= "<dados>\n";               
	//PERCORRE ARRAY            
	$codigo    = 0; 
	$descricao = 0;
	$descricao2 = 2;
	
	$xml .= "<dado>\n";     
	$xml .= "<codigo>".$codigo."</codigo>\n";                  
	$xml .= "<descricao>".$descricao."</descricao>\n";         
	$xml .= "<descricao2>".$descricao2."</descricao2>\n";  	  
	$xml .= "</dado>\n";    
	$xml.= "</dados>\n";
	//CABEÇALHO
	Header("Content-type: application/xml; charset=iso-8859-1");    

}                                       

//PRINTA O RESULTADO  
echo $xml;            
?>
