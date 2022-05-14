<?php
$flagmenu = 1;
require("verifica.php");
require_once("include/config.php");

$usuario = $_SESSION["id_usuario"];

?>
<!DOCTYPE html>
<html>
    <head>

        <!-- Required meta tags-->    
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Title Page-->
        <title>Impressao de Baixa Física</title> 

        <!-- maxnew CSS-->
        <link href="css/max.css" rel="stylesheet" media="all">        
    </head>

    <body > 
        <div id="retorno"></div>
        <div id="dialog" style="margin-left: 5px; margin-left: 5px;"></div>
        <div class="bg-gray p-t-10 p-b-100 font-lucida">
            <div class="wrapper wrapper--w680">
                <div class="card card-4">
                    <div class="card-header">
                        Impressao de Baixa Física
                    </div>
                    <div class="card-body">                    
                        <form method="POST">
                            <div class="row row-space">
                                <div class="col-2">
                                    <div class="input-group m-r-45">
                                        <label class="label">Pedido</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" name="pcnumero" type="text" id="pcnumero" onKeyPress="maiusculo()" onBlur="ver2()" size="10" >
                                        </div>
                                    </div>
                                </div>                                
                                <div class="col-2">
                                    <div class="input-group">
                                        <label class="label">Seq.</label>                                        
                                        <div>                                          
                                            <span class="custom-dropdown">
                                                <select name="listsec">
                                                    <option id="opcoes" value="0">___</option>                                                
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                            <div class="row row-space">                                
                                <div class="col-1">
                                    <div class="p-t-15 centraliza">
                                        <button class="btn btn--radius-2 btn--blue" name="button" type="button" id="button" onClick=ver() >Imprimir</button>
                                        <input name="hidden" type="hidden" id="acao" value="inserir">
                                    </div>
                                </div>
                            </div>    
                        </form>
                    </div>
                </div>                
            </div>
        </div>
        <div style="display: none;">
        <button class="btn btn--radius-2 btn--green" name="button3" type="button" id="button3" onClick=excel() >Excel</button>
		</div>

		<div id="msg" style="visibility: hidden;">&nbsp;<font face="Verdana" size="2">Processando...</font></div>
		<div id="resultado">
		
		<input id="codigo" type="hidden" name="codigo" size="25">

		<script src="js/pedcompraimpressao.js"></script>

        <script language="JavaScript1.2">
            //window.onload=dadospesquisaconferente;

        </script>
		
    </body>

</html>


