<?php 
$flagmenu=2;
// Verificador de sessão
require("verifica.php");

?>
<!DOCTYPE html>
<html>
    <head>
        <!-- Required meta tags-->    
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Title Page-->
        <title>Exportação Proceda</title>        

        <!-- maxnew CSS-->
        <link href="css/max.css" rel="stylesheet" media="all">        
    </head>

    <body onload="datadiacampo('datainiciox', 'datafinalx');">
        <div id="retorno"></div>
        <div id="dialog" style="margin-left: 5px; margin-left: 5px;"></div>
        <div class="bg-gray p-t-10 font-lucida">
            <div class="wrapper wrapper--w680">
                <div class="card card-4">
                    <div class="card-header">
						Exportação Proceda
                    </div>
                    <div class="card-body">                    
                        <form method="POST"> 
                            <div class="row row-space " style="display:true;" id="linx01">                                
                                <div class="col-2">
                                    <div class="input-group m-r-45">
                                        <label class="label">Data Inicio</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" type="text" name="datainiciox" id="datainiciox" OnKeyPress="formatar('##/##/####', this)" onBlur="formata_data2(this,this.value)" size="12" maxlength="10">
                                        </div>
                                    </div>
                                </div>                                             
                                <div class="col-2">
                                    <div class="input-group m-r-45">
                                        <label class="label">Data Final</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" type="text" name="datafinalx" id="datafinalx" OnKeyPress="formatar('##/##/####', this)" onBlur="formata_data2(this,this.value)" size="12" maxlength="10">
                                        </div>
                                    </div>
                                </div>                        
							</div>	
							<div class="p-t-15 centraliza">
								<button class="btn btn--radius-2 btn--blue" type="button" id="botao" onclick="imprimirconsulta();">Exporta</button>
							</div>								
                        </form>
                    </div>
                </div>                
            </div>
        </div>
		<div class="wrapper wrapper--w960">
            <div class="result" id="resultado"></div> 
		</div>
			  
		<div id="msg" style="visibility: hidden;">&nbsp;<font face="Verdana" size="2">Processando...</font></div>
		

		<script src="js/exportaprocedacte.js"></script>
		
    </body>

</html>

