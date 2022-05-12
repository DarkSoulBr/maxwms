<?php 

require("verifica2.php");
require_once('include/conexao.inc.php');

$usuario = $_SESSION["id_usuario"];

$sql1 = "Delete from temporariopdf where usucodigo='$usuario'";
pg_query($sql1);

$uploaddir = 'arquivos/'.$usuario.'/';

if (!is_dir($uploaddir)){ 
	mkdir($uploaddir, 0755);
}	

// Flag que indica se há erro ou não
$erro = null;
// Quando enviado o formulário
if (isset($_FILES['arquivo']))
{
    // Configurações
    $extensoes = array(".xml");
    $caminho = "uploads/";
    // Recuperando informações do arquivo
    $nome = $_FILES['arquivo']['name'];
	
	$file = $uploaddir . $nome;
		
    $temp = $_FILES['arquivo']['tmp_name'];
    // Verifica se a extensão é permitida
    if (!in_array(strtolower(strrchr($nome, ".")), $extensoes)) {
		$erro = 'Extensão inválida';
	}
    // Se não houver erro
    if (!$erro) {

        // Movendo arquivo para servidor
        if (!move_uploaded_file($temp, $file)){
            $erro = 'Não foi possível anexar o arquivo';
		}
		else {			
					
			$sql2 = "INSERT INTO temporariopdf (usucodigo,pdfnome) values ('$usuario','$nome')";			
			pg_query($sql2);	
			
		}			
    }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Upload dinâmico com jQuery/PHP</title>
    
    <script type="text/javascript" src="js/jquery.js"></script>
    
    <script type="text/javascript">
    $(function($) {
        // Definindo página pai
        var pai = window.parent.document;
        
        <?php if (isset($erro)): // Se houver algum erro ?>
        
            // Exibimos o erro
            //alert('<?php echo $erro ?>');
			alert( "Erro no upload do arquivo !" );
            
        <?php elseif (isset($nome)): // Se não houver erro e o arquivo foi enviado ?>
        
            // Adicionamos um item na lista (ul) que tem ID igual a "anexos"
            //$('#anexos', pai).append('<li lang="<?php echo $nomeAleatorio ?>"><?php echo $nome ?> <img src="image/remove.png" alt="Remover" class="remover" onclick="removeAnexo(this)" \/> </li>');
            alert( "Upload realizado com sucesso !");
			 
			 document.getElementById('status').style.display="none";	
			
        <?php endif ?>
        
        // Quando enviado o arquivo
    	$("#arquivo").change(function() {	    
            // Se o arquivo foi selecionado
            if (this.value != "")
            {    
                // Exibimos o loder
                $("#status").show();
                // Enviamos o formulário
                $("#upload").submit();
            }
        });
    });
    </script>
</head>

<body>

<form id="upload" action="uploadctexml.php" method="post" enctype="multipart/form-data">
    
    <!--
	<label>Arquivo: </label> <span id="status" style="display: none;"><img src="image/loader.gif" alt="Enviando..." /></span> <br />
    -->
	
	<Center>
	<span id="status" style="display:'';">
	<input type="file" name="arquivo" id="arquivo" />
	</span>
    </Center>
    
</form>

</body>
</html>