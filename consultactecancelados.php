<?php
$flagmenu = 2;
// Verificador de sessão
require("verifica.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <!-- Required meta tags-->    
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Title Page-->
        <title>Consulta Cancelamento de CTe</title>        

        <!-- maxnew CSS-->
        <link href="css/max.css" rel="stylesheet" media="all">   
        
        <style>
            .row-max .cell-max:nth-child(1) {
                text-align: center;
                padding-left: 5px;
            }

            .row-max .cell-max:nth-child(2) {
                text-align: center;
                padding-right: 5px;
            }

            .row-max .cell-max:nth-child(3) {
                text-align: center;
                padding-right: 5px;
            }

            .row-max .cell-max:nth-child(4) {
                text-align: center;
                padding-left: 5px;
            }

            .row-max .cell-max:nth-child(5) {
                text-align: center;
                padding-right: 5px;
            }

            .row-max .cell-max:nth-child(6) {
                text-align: center;
                padding-right: 5px;
            }

            .row-max .cell-max:nth-child(7) {
                text-align: center;
                padding-right: 5px;
            }
        </style>
        
    </head>

    <body onload="datadiacampo('dataini', 'datafim')">
        <div id="retorno"></div>
        <div id="dialog" style="margin-left: 5px; margin-left: 5px;"></div>
        <div class="bg-gray p-t-10 font-lucida">
            <div class="wrapper wrapper--w680">
                <div class="card card-4">
                    <div class="card-header">
						Consulta Cancelamento de CTe
                    </div>
                    <div class="card-body">                    
                        <form method="POST"> 
                            <div class="row row-space ">                                
                                <div class="col-2">
                                    <div class="input-group m-r-45">
                                        <label class="label">Data Inicio</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" type="text" name="dataini" id="dataini" onkeypress="javascript:formata_data(this);" onkeyup="javascript:pulacampo(this);" onBlur="dataano(this, this.value)" maxlength="10">
                                        </div>
                                    </div>
                                </div>                                             
                                <div class="col-2">
                                    <div class="input-group m-r-45">
                                        <label class="label">Data Final</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" type="text" name="datafim" id="datafim" onkeypress="javascript:formata_data(this);" onBlur="dataano(this, this.value)" maxlength="10">
                                        </div>
                                    </div>
                                </div>                        
							</div>	           
							<div class="p-t-15 centraliza">
								<button class="btn btn--radius-2 btn--blue" type="button" id="botao" onclick="imprimirconsulta();">Consultar</button>
							</div>								
                        </form>
                    </div>
                </div>                
            </div>
        </div>
		<div class="wrapper wrapper--w1200">
            <div class="result" id="resultado"></div> 
		</div> 
			  
		<div id="msg" style="visibility: hidden;">&nbsp;<font face="Verdana" size="2">Processando...</font></div>
		

		<script src="js/consultactecancelados.js"></script>
		
    </body>

</html>

