<?

//RECEBE PAR�METRO                     
$parametro = trim($_POST["parametro"]);           

require_once("include/conexao.inc.php");
require_once("include/banco.php");

$cadastro = new banco($conn,$db);

//QUERY  

if(($parametro)!=0){
	$sql = "
	SELECT a.uscodigo as codigo,a.usdescricao as descricao
        FROM cadusuarios a 
	WHERE a.uscodigo = '$parametro'
	ORDER BY a.uscodigo";   

}
else{
$sql = " 

	SELECT a.uscodigo as codigo,a.usdescricao as descricao
        FROM cadusuarios a 
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
      $xml .= "<dado>\n";     
      $xml .= "<codigo>".$codigo."</codigo>\n";                  
      $xml .= "<descricao>".$descricao."</descricao>\n";         
      $xml .= "</dado>\n";    
   }//FECHA FOR                 
   
   $xml.= "</dados>\n";
   
   //CABE�ALHO
   Header("Content-type: application/xml; charset=iso-8859-1"); 
}//FECHA IF (row)                                               

//PRINTA O RESULTADO  
echo $xml;            
?>
