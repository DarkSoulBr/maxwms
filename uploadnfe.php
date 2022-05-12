<?php

require("verifica2.php");
$usuario = $_SESSION["id_usuario"];

// Flag que indica se há erro ou não
$erro = null;

$destino = "arquivos/" . $usuario . "/";

if (!is_dir($destino)){ 
	mkdir($destino, 0755);
}

// Quando enviado o formulário
if (isset($_FILES['arquivo']))
{
	

    // Configurações
    $extensoes = array(".xml");
	
    $caminho = "arquivos/" . $usuario . "/";
	
    // Recuperando informações do arquivo
    $nome = $_FILES['arquivo']['name'];
    $temp = $_FILES['arquivo']['tmp_name'];
	
    // Verifica se a extensão é permitida
    if (!in_array(strtolower(strrchr($nome, ".")), $extensoes)) {
		$erro = 'Extensao invalida';
	}
    // Se não houver erro
	
    if (!$erro) {
        // Gerando um nome aleatório para a imagem
        //$nomeAleatorio = md5(uniqid(time())) . strrchr($nome, ".");
		
		$nomeAleatorio = $nome;
		
        // Movendo arquivo para servidor
        if (!move_uploaded_file($temp, $caminho . $nomeAleatorio)){
            $erro = 'Nao foi possivel anexar o arquivo';
		}
		else
		{
		

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
            alert('<?php echo $erro ?>');
            
        <?php elseif (isset($nome)): // Se não houver erro e o arquivo foi enviado ?>
        
            // Adicionamos um item na lista (ul) que tem ID igual a "anexos"
            $('#anexos', pai).append('<li lang="<?php echo $nomeAleatorio ?>"><?php echo $nome ?> <img src="images/remove.png" alt="Remover" class="remover" onclick="removeAnexo(this)" \/> </li>');
            
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

<form id="upload" action="uploadnfe.php" method="post" enctype="multipart/form-data">
    
    <label>Arquivo: </label> <span id="status" style="display: none;"><img src="images/loader.gif" alt="Enviando..." /></span> <br />
    <input type="file" name="arquivo" id="arquivo" />
        
</form>

</body>
</html>