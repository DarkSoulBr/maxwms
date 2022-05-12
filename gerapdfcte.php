<?php 
$flag = trim($_GET["flag"]);

$flagmenu = 2;

require("verifica.php");

$usuario = $_SESSION["id_usuario"];

include 'include/jquery.php';
include 'include/css.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <!-- Required meta tags-->    
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Title Page-->
        <title>Geração de Dacte</title>        

        <!-- maxnew CSS-->
        <link href="css/max.css" rel="stylesheet" media="all">        
    </head>

    <body>
        <div id="retorno"></div>
        <div id="dialog" style="margin-left: 5px; margin-left: 5px;"></div>
        <div class="bg-gray p-t-10 font-lucida">
            <div class="wrapper wrapper--w680">
                <div class="card card-4">
                    <div class="card-header">
						Geração de Dacte
                    </div>
                    <div class="card-body">                    
                        <form method="POST"> 
                            <div class="row row-space centraliza">
                                <div class="col-1">                               
                                    <div class="input-group subtitle centraliza">                                    
                                        <div class="p-t-10">
                                            <p>Atenção, para gerar o Dacte favor fazer o upload do Xml do CTe!</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
							<div class="p-t-15 centraliza">
								<button class="btn btn--radius-2 btn--blue" type="button"  name="importaPedido2" id="importaPedido2" onclick="importarPedido()">Upload</button>
							</div>								
                        </form>
                    </div>
                </div>                
            </div>
        </div>
		<div class="wrapper wrapper--w960">
            <div class="result" id="resultado"></div> 
		</div>
		
		<input type="hidden" name="usuario" id="usuario" size="10"  value='<? echo $usuario; ?>'>
			  
		<div id="msg" style="visibility: hidden;">&nbsp;<font face="Verdana" size="2">Processando...</font></div>
		

		<script type='text/javascript'>
			  var navegador = window.navigator.appName;

			  switch(navegador)
			  {
			  case "Netscape":
					break;
			  default:
					alert("Para o correto funcionamento utilize Mozilla Firefox!");
					location.href = "dtrade.php?flagmenu=9";
					break;
			  }
		</script>

		<script src="js/gerapdfcte.js"></script>
		<script src="js/geral.js"></script>
		<script type="text/javascript">
		//a linha abaixo cria um novo pseudonimo $a
		//que será utilizado no lugar de $ ou de jQuery()
		var $a = jQuery.noConflict()
		</script>
		
    </body>

</html>

