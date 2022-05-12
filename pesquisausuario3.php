<?

//RECEBE PARÃMETRO                     
$parametro = trim($_POST["parametro"]);           

require_once("include/conexao.inc.php");
require_once("include/banco.php");

$cadastro = new banco($conn,$db);

//QUERY  

if(($parametro)!=0){
	$sql = "
	SELECT a.usucodigo as codigo,a.usunome as descricao,a.usulogin as login
        FROM usuarios a 
	WHERE a.usucodigo = '$parametro'
	ORDER BY a.usucodigo";   

}
else{
$sql = " 

	SELECT a.usucodigo as codigo,a.usunome as descricao,a.usulogin as login
        FROM usuarios a 
	ORDER BY a.usulogin";   
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
	$login = pg_result($sql, $i, "login");
      $xml .= "<dado>\n";     
      $xml .= "<codigo>".$codigo."</codigo>\n";                  
      //$xml .= "<descricao>".$login."-".$descricao."</descricao>\n";         
	  $xml .= "<descricao>".$login."</descricao>\n";         
      $xml .= "</dado>\n";    
   }//FECHA FOR                 
   
   $xml.= "</dados>\n";
   
   //CABEÇALHO
   Header("Content-type: application/xml; charset=iso-8859-1"); 
}//FECHA IF (row)                                               

//PRINTA O RESULTADO  
echo $xml;            
?>
