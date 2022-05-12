<?php

$usuario	= trim($_GET["usuario"]);

$uploaddir = 'arquivos/'.$usuario.'/';

$file=$uploaddir . "pedidos_romaneio.xls";

$arq1 = "?download=" . $file;

if (isset($_GET['download']) && $_GET['download'] != "") {
    $file = $_GET['download'];
 
    if (file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/xls');
        header('Content-Disposition: attachment; filename=' . basename($file));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        ob_clean();
        flush();
        readfile($file);
        exit;
    }else {
        echo "Arquivo não existe: ".$file;
    }
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title></title>
    
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
            alert( "Arquivo gerado com sucesso !" );						 
			document.getElementById('status').style.display="none";	
			document.getElementById('download').style.display="";				
			
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

<form id="upload" method="post" enctype="multipart/form-data">
    
	<Center>
	<span id="download" style="display:'';">	
	<a href="<?=$arq1; ?>">Download arquivo de Pedidos por Romaneio</a>	
	</span>
	</Center>
	
	
</form>

</body>
</html>