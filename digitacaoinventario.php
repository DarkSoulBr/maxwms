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
        <title>Digitação de Inventário</title>        

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
                padding-left: 5px;
            }

            .row-max .cell-max:nth-child(4) {
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
                        Digitação de Inventário
                    </div>
                    <div class="card-body">                    
                        <form name="formulario" method="POST">
                            <div class="row row-space">
                                <div class="col-2">
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
                                <div class="col-2">
                                    <div class="input-group m-r-45">
                                        <label class="label">Data</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" type="text" name="datainventario" id="datainventario" size="12" maxlength="10" readonly>
                                        </div>
                                    </div>
                                </div>    
                            </div>      
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group m-r-45">
                                        <label class="label">Opção</label>
                                        <div>
                                            <label class="radio-container m-r-15">Código de Barras                                                
                                                <input type="radio" name="opcao" id="opcao1" value="1" align="absmiddle" checked>
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container m-r-15">Código
                                                <input type="radio" name="opcao" id="opcao2" value="2" align="absmiddle">
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container">Nome
                                                <input type="radio" name="opcao" id="opcao3" value="3" align="absmiddle">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-space">                                
                                <div class="col-2">
                                    <div class="input-group">
                                        <label class="label">Pesquisar</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" type="text" name="consulta" id="consulta" size="25" onkeyup="this.value = this.value.toUpperCase()">
                                        </div>
                                    </div>
                                </div>                                
                                <div class="col-3">
                                    <div class="input-group">
                                        <label class="label">&nbsp;</label>
                                        <div class="input-group-icon centraliza">
                                            <button class="btn-small btn--radius-2 btn--blue" type="button" name="pesquisar" id="pesquisar" onclick="load_grid_prod();">Pesquisar</button>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>	
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group">
                                        <label class="label">Produto</label>                                        
                                        <div id="resultado2">                                          
                                            <span class="custom-dropdown">
                                                <select id="pesquisa" name="pesquisa" size="1" onchange="setar(this);" disabled>
                                                    <option id="opcoes" value="0">-- Escolha um Produto --</option>                                                
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
                                    <input type="hidden" name="nome" id="nome" size="40" readonly disabled>
                                </div>                                
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
        <div id="msg2" style="visibility: hidden;">&nbsp;<font face="Verdana" size="2">Processando...</font></div>


        <script src="js/digitacaoinventario.js"></script>

    </body>

</html>

