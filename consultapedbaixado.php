<?php
$flagmenu = 1;
// Verificador de sessão
require("verifica.php");
include 'include/jquery.php';
include 'include/cssloja.php';

$usuario = $_SESSION["id_usuario"];

?>
<!DOCTYPE html>
<html>
    <head>
        <!-- Required meta tags-->    
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Title Page-->
        <title>Consulta de Pedidos Baixados</title>        

        <!-- maxnew CSS-->
        <link href="css/max.css" rel="stylesheet" media="all">
        
        <style>
            .row-max .cell-max:nth-child(1) {
                width: 100px;                
              }

              .row-max .cell-max:nth-child(2) {
                width: 50px;                
              }

              .row-max .cell-max:nth-child(3) {
                width: 120px;
              }

              .row-max .cell-max:nth-child(4) {
                width: 120px;
              }

              .row-max .cell-max:nth-child(5) {
                width: 100px;
              }

              .row-max .cell-max:nth-child(6) {
                width: 200px;
              }

              .row-max .cell-max:nth-child(7) {
                width: 100px;
              }

              .row-max .cell-max:nth-child(8) {
                width: 50px;
              }

              .row-max .cell-max:nth-child(9) {
                width: 50px;
              }

              .row-max .cell-max:nth-child(10) {
                width: 120px;
              }

              .row-max .cell-max:nth-child(11) {
                width: 75px;
              }

              
        </style>        

    </head>

    <body onload="datadiacampo('dtinicio', 'dtfinal');">
        <div id="retorno"></div>
        <div id="dialog" style="margin-left: 5px; margin-left: 5px;"></div>
        <div class="bg-gray p-t-10 p-b-100 font-lucida">
            <div class="wrapper wrapper--w680">
                <div class="card card-4">
                    <div class="card-header">
						Consulta de Pedidos Baixados
                    </div>
                    <div class="card-body">                    
                        <form method="POST"> 
                            <div class="row row-space">                                
                                <div class="col-2">
                                    <div class="input-group m-r-45">
                                        <label class="label">Inicio</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="dtinicio" type="text" name="dtinicio" size="11" OnKeyPress="formatar('##/##/####', this)" onBlur="dataano(this, this.value)">
                                        </div>
                                    </div>
                                </div>                                             
                                <div class="col-2">
                                    <div class="input-group m-r-45">
                                        <label class="label">Final</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="dtfinal" type="text" name="dtfinal" size="11" OnKeyPress="formatar('##/##/####', this)"  onBlur="dataano(this, this.value)">
                                        </div>
                                    </div>
                                </div>                        
							</div> 
							<div class="row row-space">                                
                                <div class="col-2">
                                    <div class="p-t-15 centraliza">
                                        <button class="btn btn--radius-2 btn--blue" type="button" id="botao" onclick="load_grid();">Consultar</button>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="p-t-15 centraliza">                                        
                                        <button class="btn btn--radius-2 btn--green" type="button" id="botao3" onClick="imprimepdf()">Imprimir</button>
                                    </div>
                                </div>
                            </div>    							
                        </form>
                    </div>
                </div>                
            </div>
			<div class="wrapper wrapper--w1200">
                <div class="result" id="resultado"></div>
                <div style="display: none;" id="resultado2"></div> 
            </div>      
        </div>
		

		<div id="msg" style="visibility: hidden;">&nbsp;<font face="Verdana" size="2">Processando...</font></div>


		<script src="js/consultapedbaixado.js"></script>
        <script type="text/javascript">
            var $a = jQuery.noConflict()
        </script>
		
    </body>

</html>


