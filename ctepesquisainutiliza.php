<?php  
  
require_once("include/conexao.inc.php");

//RECEBE PARÃMETRO

$parametro = trim($_POST["parametro"]);
$parametro2 = trim($_POST["parametro2"]);

//
//QUERY
$sql = "SELECT a.ctenumero,a.ctenum,a.ctechave,a.ctemotivoinutiliza,a.ctedatainutiliza FROM cte a";
	
if ($parametro2==1){
	$sql.= " WHERE a.ctenumero = '$parametro'";
}
else if ($parametro2==2){

	$parametro = str_pad($parametro, 9, '0', STR_PAD_LEFT);

	$sql.= " WHERE a.ctenum = '$parametro'";
}
else{
	$sql.= " WHERE a.ctechave = '$parametro'";
}
	
$sql.= " ORDER BY a.ctenumero";


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
      $ctenumero = pg_fetch_result($sql, $i, "ctenumero");
      $ctenum = pg_fetch_result($sql, $i, "ctenum");
	  $ctechaveref = pg_fetch_result($sql, $i, "ctechave");
	  
	  $ctemotivoinutiliza = pg_fetch_result($sql, $i, "ctemotivoinutiliza");
	  $ctedatainutiliza = pg_fetch_result($sql, $i, "ctedatainutiliza");
	  	  
      if (trim($codigo)==""){
          $codigo = "0";
      }
      if (trim($ctenum)==""){
          $ctenum = "0";
      }
	  if (trim($ctechaveref)==""){
          $ctechaveref = "0";
      }
	  
	  if (trim($ctemotivoinutiliza)==""){
          $ctemotivoinutiliza = "X";
      }
	  if (trim($ctedatainutiliza)==""){
          $ctedatainutiliza = "X";
      }
	  
	  	  
      $xml .= "<dado>\n";
      $xml .= "<codigo>".$ctenumero."</codigo>\n";
      $xml .= "<descricao>".$ctenum."</descricao>\n";
	  $xml .= "<descricao2>".$ctechaveref."</descricao2>\n";	  
	  $xml .= "<descricao3>".$ctedatainutiliza."</descricao3>\n";
	  $xml .= "<descricao4>".$ctemotivoinutiliza."</descricao4>\n";
	  	  
      $xml .= "</dado>\n";    
   }//FECHA FOR                 
   
   $xml.= "</dados>\n";
   
   //CABEÇALHO
   
   Header("Content-type: application/xml; charset=iso-8859-1"); 

}//FECHA IF (row)                                               

//PRINTA O RESULTADO  
echo $xml;            
?>
