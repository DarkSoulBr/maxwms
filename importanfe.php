<?php
$flag = trim($_GET["flag"]);
$flagmenu=2;

require("verificax.php");
$usuario = $_SESSION["id_usuario"];

$origem = "arquivos/" . $usuario . "/";

$pasta = $origem;
if(is_dir($pasta))
{
	$diretorio = dir($pasta);
	
	$arquivos = '';

	while($arquivo = $diretorio->read())
	{
		if(($arquivo != '.') && ($arquivo != '..'))
		{							
			unlink($origem . $arquivo);
		}
	}
	
}

?>

<?php
// Quando a ação for para remover anexo
if ($_POST['acao'] == 'removeAnexo')
{
    // Recuperando nome do arquivo
    $arquivo = $_POST['arquivo'];
    // Caminho dos uploads
    $caminho = "arquivos/" . $usuario . "/";	
	
    // Verificando se o arquivo realmente existe
    if (file_exists($caminho . $arquivo) and !empty($arquivo))
        // Removendo arquivo
        unlink($caminho . $arquivo);
    // Finaliza a requisição
    exit;
}



// Se enviado o formulário
/*
if (isset($_POST['enviar']))
{
	
	$array = $_POST['anexos'];
	$arquivos = count($array);

	if ($arquivos==3){			
	
		?>
		<script type="text/javascript">
		
		window.open('importacontabil.php' , "_blank" );		
						
		</script>
		<?
		
		
	}
	else
	{
		?>
		<script type="text/javascript">
		
		alert( "Fazer o upload dos 3 arquivos !" );		
				
		</script>
		<?
		
		//Exclui se tiver algum arquivo
		
		$pasta = "arquivos/contabil/";
		if(is_dir($pasta))
		{
			$diretorio = dir($pasta);

			while($arquivo = $diretorio->read())
			{
				if(($arquivo != '.') && ($arquivo != '..'))
				{
					unlink($pasta.$arquivo);
					//echo 'Arquivo '.$arquivo.' foi apagado com sucesso. <br />';
				}
			}
			$diretorio->close();
		}
		
	
	}

	
}
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>AJAX Upload com PHP e jQuery</title>
<script type="text/javascript" src="js/jquery-1.6.1.min.js" ></script>
<script type="text/javascript" src="js/ajaxupload.3.5.js" ></script>
<!--<link rel="stylesheet" type="text/css" href="./styles.css" />-->

<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Upload dinâmico com jQuery/PHP</title>

<script type="text/javascript" src="js/jquery.js"></script>

<style type="text/css">
body {
    font-family: "Trebuchet MS";
    font-size: 14px;    
}

iframe {
    border: 0;
    overflow: hidden;
    margin: 0;
    height: 60px;
    width: 450px;
}

#anexos {
    list-style-image: url(images/file.png);
}

img.remover {
    cursor: pointer;
    vertical-align: bottom;
}
</style>


<script type="text/javascript">
$(function($) {
    // Quando enviado o formulário
    $("#upload").submit(function() {
        // Passando por cada anexo
        $("#anexos").find("li").each(function() {
            // Recuperando nome do arquivo
            var arquivo = $(this).attr('lang');
            // Criando campo oculto com o nome do arquivo
            $("#upload").prepend('<input type="hidden" name="anexos[]" value="' + arquivo + '" \/>');
        }); 
    });
});
    
// Função para remover um anexo
function removeAnexo(obj)
{
    // Recuperando nome do arquivo
    var arquivo = $(obj).parent('li').attr('lang');
    // Removendo arquivo do servidor
    $.post("importaexcel.php", {acao: 'removeAnexo', arquivo: arquivo}, function() {
        // Removendo elemento da página
        $(obj).parent('li').remove();
    });
}






</script>
    
</head>

<body>

<Center>
<div id="mainbody" >

		
		<h3>ADICIONAR ARQUIVOS XML</h3>
		
		<b>TAMANHO MAXIMO DO ARQUIVO DE 10MB.</b>		

		<ul id="anexos"></ul>
		<iframe src="uploadnfe.php" frameborder="0" scrolling="no"></iframe>

		<form id="upload" action="importanfe.php" method="post">

		<!--input type="submit" name="enviar" value="Processar" /-->
		

</form>

</div>
</Center>

</body>
</html>