<?  

//RECEBE PARÃMETRO                     

$codigo=trim($_POST["codigo"]);

$descricaox=trim($_POST["descricaox"]);
$descricaox=md5($descricaox);

$descricao3=trim($_POST["descricao3"]);
$descricao3=md5($descricao3);

require_once("include/conexao.inc.php");
require_once("include/usuario.php");

$cadastro = new banco($conn,$db);

$sql = "
       SELECT a.ussenha
       FROM  cadusuarios a
       WHERE a.uscodigo = '$codigo'";

//EXECUTA A QUERY
$sql = pg_query($sql);

$row = pg_num_rows($sql);

//VERIFICA SE VOLTOU ALGO
if($row) {
   //XML
   $xml  = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
   $xml .= "<dados>\n";

   
		$ususenha    = pg_result($sql, 0, "ussenha");
		if (trim($ususenha)!=trim($descricaox)){
			$codigox = "2";
		}
		else if (trim($ususenha)==trim($descricao3)){
			$codigox = "0";
		}
		else
		{
			$codigox = "1";
		}

		$xml .= "<dado>\n";
		$xml .= "<codigo>".$codigox."</codigo>\n";
		$xml .= "</dado>\n";
		  

   $xml.= "</dados>\n";

   //CABEÇALHO
   Header("Content-type: application/xml; charset=iso-8859-1");
}//FECHA IF (row)

//PRINTA O RESULTADO
echo $xml;
?>
