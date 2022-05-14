<?php
$flagmenu = 1;
require("verifica.php");

$usuario = $_SESSION["id_usuario"];

?>
<!DOCTYPE html>
<html>
    <head>
        <!-- Required meta tags-->    
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Title Page-->
        <title>Saldo de Pedidos de Compras por Grupos</title>        

        <!-- maxnew CSS-->
        <link href="css/max.css" rel="stylesheet" media="all">        
    </head>

    <body onload="datadiacampo('datainigru', 'datafimgru')">
        <div id="retorno"></div>
        <div id="dialog" style="margin-left: 5px; margin-left: 5px;"></div>
        <div class="bg-gray p-t-10 p-b-100 font-lucida">
            <div class="wrapper wrapper--w680">
                <div class="card card-4">
                    <div class="card-header">
                        Saldo de Pedidos de Compras por Grupos
                    </div>
                    <div class="card-body">                    
                        <form method="POST"> 
                            <div class="row row-space ">                                
                                <div class="col-2">
                                    <div class="input-group m-r-45">
                                        <label class="label">Data Inicio</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" type="text" name="datainigru" id="datainigru" onkeypress="javascript:formata_data(this);" onkeyup="javascript:pulacampo(this);" maxlength="10">
                                        </div>
                                    </div>
                                </div>                                             
                                <div class="col-2">
                                    <div class="input-group m-r-45">
                                        <label class="label">Data Fim</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" type="text" name="datafimgru" id="datafimgru" onkeypress="javascript:formata_data(this);" maxlength="10">
                                        </div>
                                    </div>
                                </div>                        
                            </div>
                            <div class="col-3">
                                <div class="input-group m-r-45">
                                    <label class="label">Todos os Grupos?</label>
                                    <div class="p-t-10">
                                        <label class="radio-container m-r-15">Sim
                                            <input type="radio" name="gru" id="gru0" value="0" align="absmiddle" onclick="desabilitargru('0');" checked>
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="radio-container">Não
                                            <input type="radio" name="gru" id="gru1" value="1" align="absmiddle" onclick="desabilitargru('1');">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-1">
                                <div class="input-group m-r-45">
                                    <label class="label">Opção</label>
                                    <div class="p-t-10">
                                        <label class="radio-container m-r-15">Código
                                            <input type="radio" name="opcao" id="opcao1" value="1" align="absmiddle" disabled checked>
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="radio-container">Nome
                                            <input type="radio" name="opcao" id="opcao2" value="2" align="absmiddle" disabled>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-space">                                
                                <div class="col-2">
                                    <div class="input-group m-r-45">
                                        <label class="label">Pesquisar</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" type="text" name="consultagrupo" id="consultagrupo" size="25" onkeyup="this.value = this.value.toUpperCase()" disabled>
                                        </div>
                                    </div>
                                </div>                                
                                <div class="col-3">
                                    <div class="input-group">
                                        <label class="label">&nbsp;</label>
                                        <div class="input-group-icon centraliza">
                                            <button class="btn-small btn--radius-2 btn--blue" type="button" name="pesquisar" id="pesquisar" onclick="load_gridgru();" disabled>Pesquisar</button>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                            <div class="row row-space">
                                <div class="col-2">
                                    <div class="input-group m-r-45">
                                        <label class="label">Pesquisa</label>                                        
                                        <div id="resultadogru">                                       
                                            <span class="custom-dropdown">
                                                <select id="pesquisagrupo" name="pesquisagrupo" size="1" onchange="setargrupo(this);" disabled>
                                                    <option id="opcoes2" value="0">-- Escolha um Grupo --</option>                                                
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
                                </div>  
                                <div class="col-2">
                                    <div class="input-group m-r-45">
                                        <label class="label">Grupo</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" type="text" name="grupo" id="grupo" size="40" readonly disabled>
                                        </div>
                                    </div>
                                </div>  
                            </div>                           
                            <div class="p-t-15 centraliza">
                                <button class="btn btn--radius-2 btn--blue" type="button" id="botao" onclick="imprimirconsultapedbaicomgrupo();">Imprimir</button>
                            </div>								
                        </form>
                    </div>
                </div>                
            </div>
        </div>
        <div id="msggru" style="visibility: hidden;"></div>


        <div id="msg" style="visibility: hidden;">&nbsp;<font face="Verdana" size="2">Processando...</font></div>
        <div id="resultado"></div>


        <script src="js/cadastrosalpedcomgrupos.js"></script>

    </body>

</html>

