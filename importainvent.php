<?php
$flagmenu = 5;
// Verificador de sessão
require("verifica.php");

$usuario = $_SESSION["id_usuario"];

?>
<!DOCTYPE html>
<html>
    <head>
        <!-- Required meta tags-->    
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Title Page-->
        <title>Importação de Estoque</title>        

        <!-- maxnew CSS-->
        <link href="css/max.css" rel="stylesheet" media="all">        
    </head>

    <body onload="load_grid_estoque();datadiacampo('dataini');">
        <div id="retorno"></div>
        <div id="dialog" style="margin-left: 5px; margin-left: 5px;"></div>
        <div class="bg-gray p-t-10 font-lucida">
            <div class="wrapper wrapper--w680">
                <div class="card card-4">
                    <div class="card-header">
						Importação de Estoque
                    </div>
                    <div class="card-body">                    
                        <form method="POST"> 
                            <div class="row row-space ">                                
                                <div class="col-2">
                                    <div class="input-group m-r-45">
                                        <label class="label">Data</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" type="text" name="dataini" id="dataini" onkeypress="javascript:formata_data(this);" onBlur="dataano(this, this.value)" maxlength="10">
                                        </div>
                                    </div>
                                </div>                                                          
							</div>	
							<div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group">
                                        <label class="label">Estoque</label>                                        
                                        <div id="resultado4">                                          
                                            <span class="custom-dropdown">
                                                <select id="estoque" name="estoque" size="1">
                                                    <option value="0">-- Escolha um Estoque --</option>                                                
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
							<div class="p-t-15 centraliza">
								<button class="btn btn--radius-2 btn--blue" type="button" id="botao" onclick="if (confirm('Confirma a importação?')) imprimirconsulta();">Confirma</button>
							</div>								
                        </form>
                    </div>
                </div>                
            </div>
        </div>
			  
		<div id="msg" style="visibility: hidden;">&nbsp;<font face="Verdana" size="2">Processando...</font></div>
		<div id="resultado"></div>
		


		<script src="js/importainvent.js"></script>
		
    </body>

</html>

