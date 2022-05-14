<?php
$flagmenu = 6;
// Verificador de sessão
require("verifica.php");
include 'include/jquerymax.php';
include 'include/cssloja.php';

$usuario = $_SESSION["id_usuario"];

?>
<!DOCTYPE html>
<html>
    <head>
        <!-- Required meta tags-->    
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Title Page-->
        <title>Criação de Tabelas de Movimentação de Estoque</title>        

        <!-- maxnew CSS-->
        <link href="css/max.css" rel="stylesheet" media="all">        
    </head>

    <body onload="load_grid();">
        <div id="retorno"></div>
        <div id="dialog" style="margin-left: 5px; margin-left: 5px;"></div>
        <div class="bg-gray p-t-10 p-b-100 font-lucida">
            <div class="wrapper wrapper--w680">
                <div class="card card-4">
                    <div class="card-header">
                        Criação de Tabelas de Movimentação de Estoque
                    </div>
                    <div class="card-body">                    
                        <form method="POST"> 
                            <div class="row row-space centraliza">                                
                                <div class="col-2">
                                    <div class="input-group m-r-45">
                                        <label class="label">Base atual termina em</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" type="text" name="saopaulo" id="saopaulo" value="" size="12" maxlength="12" style="text-align:right;" onblur="format(this.value, this.id);" readonly>
                                        </div>
                                    </div>
                                </div>                        
                            </div>	               								
                            <div class="p-t-15 centraliza">
                                <button class="btn btn--radius-2 btn--blue" type="button" id="botao" onclick="imprimirconsulta();">Processar</button>
                            </div>								
                        </form>
                    </div>
                </div>                
            </div>
        </div>
        <input type="hidden" name="chcodigo" id="chcodigo" value="">


        <div id="msg1" style="visibility: hidden;">&nbsp;<font face="Verdana" size="2">Processando...</font></div>
        <div id="msg" style="visibility: hidden;">&nbsp;<font face="Verdana" size="2">Processando...</font></div>
        <div id="resultado"></div>
        <div id="retorno"></div>


        <script src="js/tabelasmovimentacao.js"></script>
        <script type="text/javascript">
                                    //a linha abaixo cria um novo pseudonimo $a
                                    //que será utilizado no lugar de $ ou de jQuery()
                                    var $a = jQuery.noConflict()
        </script>

    </body>

</html>

