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
        <title>Saldo de Pedidos de Compras por Fornecedor</title>        

        <!-- maxnew CSS-->
        <link href="css/max.css" rel="stylesheet" media="all">        
    </head>

    <body onload="datadiacampo('datainiform', 'datafimform')">
        <div id="retorno"></div>
        <div id="dialog" style="margin-left: 5px; margin-left: 5px;"></div>
        <div class="bg-gray p-t-10 p-b-100 font-lucida">
            <div class="wrapper wrapper--w680">
                <div class="card card-4">
                    <div class="card-header">
                        Saldo de Pedidos de Compras por Fornecedor
                    </div>
                    <div class="card-body">                    
                        <form method="POST"> 
                            <div class="row row-space ">                                
                                <div class="col-2">
                                    <div class="input-group m-r-45">
                                        <label class="label">Data Inicio</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" type="text" name="datainiform" id="datainiform" onkeypress="javascript:formata_data(this);" onkeyup="javascript:pulacampo(this);" onBlur="dataano(this, this.value)" maxlength="10">
                                        </div>
                                    </div>
                                </div>                                             
                                <div class="col-2">
                                    <div class="input-group m-r-45">
                                        <label class="label">Data Fim</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" type="text" name="datafimform" id="datafimform" onkeypress="javascript:formata_data(this);" onBlur="dataano(this, this.value)" maxlength="10">
                                        </div>
                                    </div>
                                </div>                        
                            </div>
                            <div class="col-1">
                                <div class="input-group m-r-45">
                                    <label class="label">Todos os Fornecedores?</label>
                                    <div class="p-t-10">
                                        <label class="radio-container m-r-15">Sim
                                            <input type="radio" name="forn" id="forn0" value="0" align="absmiddle" onclick="desabilitarform('0');" checked>
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="radio-container">Não
                                            <input type="radio" name="forn" id="forn1" value="1" align="absmiddle" onclick="desabilitarform('1');">
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
                                        <label class="radio-container m-r-15">N. Guerra
                                            <input type="radio" name="opcao" id="opcao2" value="2" align="absmiddle" disabled>
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="radio-container m-r-15">Razão
                                            <input type="radio" name="opcao" id="opcao3" value="3" align="absmiddle" disabled>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-space">                                
                                <div class="col-2">
                                    <div class="input-group">
                                        <label class="label">Pesquisar</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" type="text" name="consultafornecedor" id="consultafornecedor" size="25" onkeyup="this.value = this.value.toUpperCase()" disabled>
                                        </div>
                                    </div>
                                </div>                                
                                <div class="col-3">
                                    <div class="input-group">
                                        <label class="label">&nbsp;</label>
                                        <div class="input-group-icon centraliza">
                                            <button class="btn-small btn--radius-2 btn--blue" type="button" name="pesquisar" id="pesquisar" onclick="load_gridfor();" disabled>Pesquisar</button>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group">
                                        <label class="label">Pesquisador</label>                                        
                                        <div class="p-t-10" id="resultadofor">                                          
                                            <span class="custom-dropdown">
                                                <select id="pesquisafornecedor" name="pesquisafornecedor" size="1" onchange="setarfornecedor(this);" disabled>
                                                    <option id="opcoes2" value="0">-- Escolha um Fornecedor --</option>                                                
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                            <div class="p-t-15 centraliza">
                                <button class="btn btn--radius-2 btn--blue" type="button" id="botao" onclick="imprimirrelatoriopedbaicomfornecedor();">Imprimir</button>
                            </div>								
                        </form>
                    </div>
                </div>                
            </div>
        </div>
        <input type="hidden" name="fornecedor" id="fornecedor" size="40" readonly disabled>


        <div id="msg" style="visibility: hidden;">&nbsp;<font face="Verdana" size="2">Processando...</font></div>
        <div id="resultado">

            <div id="msgfor" style="visibility: hidden;">


                <script src="js/consultasalpedcomfornecedor.js"></script>

                </body>

                </html>

