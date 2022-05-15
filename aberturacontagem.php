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
        <title>Abertura de Contagem</title>        

        <!-- maxnew CSS-->
        <link href="css/max.css" rel="stylesheet" media="all">        
    </head>

    <body onload="datadiacampo('datainventario', '')">
        <div id="retorno"></div>
        <div id="dialog" style="margin-left: 5px; margin-left: 5px;"></div>
        <div class="bg-gray p-t-10 p-b-100 font-lucida">
            <div class="wrapper wrapper--w680">
                <div class="card card-4">
                    <div class="card-header">
                        Abertura de Contagem
                    </div>
                    <div class="card-body">                    
                        <form method="POST"> 
                            <div class="row row-space centraliza">                                
                                <div class="col-2">
                                    <div class="input-group">
                                        <label class="label">Data</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" type="text" name="datainventario" id="datainventario" OnKeyPress="formatar('##/##/####', this)" onBlur="formata_data2(this, this.value)" maxlength="10" size="12">
                                        </div>
                                    </div>
                                </div>                                                             
                            </div>	               								
                            <div class="p-t-15 centraliza">
                                <button class="btn btn--radius-2 btn--blue" type="button" id="botao" onclick="imprimirconsulta();">Confirmar</button>
                            </div>								
                        </form>
                    </div>
                </div>                
            </div>
        </div>


        <div id="msg" style="visibility: hidden;">&nbsp;<font face="Verdana" size="2">Processando...</font></div>
        <div id="resultado">


            <script src="js/aberturacontagem.js"></script>

    </body>

</html>

