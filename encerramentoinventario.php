<?php
$flagmenu = 5;
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
        <title>Encerramento de Inventário</title>        

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
		</style>	
		
    </head>

    <body onload="load_grid_estoque();">
        <div id="retorno"></div>
        <div id="dialog" style="margin-left: 5px; margin-left: 5px;"></div>
        <div class="bg-gray p-t-10 font-lucida">
            <div class="wrapper wrapper--w680">
                <div class="card card-4">
                    <div class="card-header">
						Encerramento de Inventário
                    </div>
                    <div class="card-body">                    
                        <form name="formulario" method="POST">
                             <div class="row row-space">
								<div class="col-1 centraliza">
									<div class="input-group">
										<label class="label">Atualiza Estoque</label>
										<div>
										<label class="radio-container m-r-15">Sim                                         
											<input id="radioa1" name="radioa" type="radio" value="radiobutton" checked>
											<span class="checkmark"></span>
										</label>
										<label class="radio-container">Não
											<input id="radioa2" type="radio" name="radioa" value="radiobutton">
											<span class="checkmark"></span>
										</label>
										</div>
									</div>
								</div>
							</div>       
							<div class="p-t-15 centraliza">
								<button class="btn btn--radius-2 btn--blue" type="button" id="botao" onclick="encerrar();">Encerrar</button>
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
		


		<script src="js/encerramentoinventario.js"></script>
        <script type="text/javascript">
            var $a = jQuery.noConflict()
        </script>
		
    </body>

</html>