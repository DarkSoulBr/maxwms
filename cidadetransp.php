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
        <title>Prazo de Entrega</title> 

        <!-- maxnew CSS-->
        <link href="css/max.css" rel="stylesheet" media="all">        
    </head>

    <body onLoad=dadospesquisaestado(0)>
        <div id="retorno"></div>
        <div id="dialog" style="margin-left: 5px; margin-left: 5px;"></div>
        <div class="bg-gray p-t-10 font-lucida">
            <div class="wrapper wrapper--w680">
                <div class="card card-4">
                    <div class="card-header">
                        Prazo de Entrega
                    </div>
                    <div class="card-body">                    
                        <form method="POST">
                            <div class="row row-space">                                
                                <div class="col-2">
                                    <div class="input-group-small">
                                        <label class="label">Pesquisar</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="pesquisa" type="text" name="pesquisa" size="35" onKeyPress="maiusculo()" onblur="convertField(this);" onkeyup="this.value=this.value.toUpperCase()">
                                        </div>
                                    </div>
                                </div>                                
                                <div class="col-3">
                                    <div class="input-group-small">
                                        <label class="label">&nbsp;</label>
                                        <div class="input-group-icon centraliza">
                                            <button class="btn-small btn--radius-2 btn--blue" name="button" type="button" id="button" onClick=pesquisa1(pesquisa.value)>Pesquisar</button>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>	
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group-small">
                                        <label class="label">Cidade</label>                                        
                                        <div>                                          
                                            <span class="custom-dropdown">
                                                <select name="listDados" onChange="dadospesquisa2(this.value);">
                                                    <option id="opcoes" value="0">Faça a Pesquisa de Cidade</option>                                                
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
                                </div> 
                                <input id="cidcodigo" type="hidden" name="cidcodigo" size="25">								
                            </div>
                            <div class="row row-space">
                                <div class="col-2">
                                    <div class="input-group-small">
                                        <label class="label">Cidade</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="cidnome" type="text" name="cidnome" size="35" onKeyPress="maiusculo()" onblur="convertField(this);" disabled>
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-3">
                                    <div class="input-group-small">
                                        <label class="label">UF</label>                                        
                                        <div>                                          
                                            <span class="custom-dropdown">
                                                <select name="listestados" disabled>
                                                    <option id="opcoes2" value="0">___</option>                                                
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group-small m-r-15">
                                        <label class="label">Transportadora</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" type="text" name="trans" id="trans" size="35" readonly disabled>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Opção</label>
                                        <div>
                                            <label class="radio-container m-r-15">Código                                              
                                                <input type="radio" name="opcao_transportadora" id="opcao_transportadora1" value="1" align="absmiddle" checked>
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container m-r-15">N. Guerra
                                                <input type="radio" name="opcao_transportadora" id="opcao_transportadora2" value="2" align="absmiddle"> 
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container">Razão
                                                <input type="radio" name="opcao_transportadora" id="opcao_transportadora3" value="3" align="absmiddle"> 
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-space">                                
                                <div class="col-2">
                                    <div class="input-group-small">
                                        <label class="label">Pesquisar</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" type="text" name="consulta_transportadora" id="consulta_transportadora" size="35" onkeyup="this.value = this.value.toUpperCase()" onBlur="vertransportadora();">
                                        </div>
                                    </div>
                                </div>                                
                                <div class="col-3">
                                    <div class="input-group-small">
                                        <label class="label">&nbsp;</label>
                                        <div class="input-group-icon centraliza">
                                            <button class="btn-small btn--radius-2 btn--blue" type="button" name="pesquisa_transportadora" id="pesquisa_transportadora" onclick="load_grid_transportadora();">Pesquisar</button>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>	
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group-small">
                                        <label class="label">Transportadora</label>                                        
                                        <div id="resultado_transportadora">                                          
                                            <span class="custom-dropdown">
                                                <select id="pesquisar_transportadora" name="pesquisar_transportadora" size="1" onchange="setar_transportadora(this);" disabled>
                                                    <option value="0">-- Escolha uma Transportadora --</option>                                                
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
                                </div> 
                                <input type="hidden" name="nome_transportadora" id="nome_transportadora" size="40" value="" readonly disabled>				
                            </div>
                            <div class="row row-space">
                                <div class="col-3">
                                    <div class="input-group-small">
                                        <label class="label">Prazo</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" name="prazo" type="text" id="prazo" onBlur="convertField3(this);" onkeypress="return SomenteNumero(event);" onkeyup="this.value = this.value.toUpperCase()" size="5">
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                            <div class="row row-space">                                
                                <div class="col-2">
                                    <div class="p-t-15 centraliza">
                                        <button class="btn btn--radius-2 btn--blue" type="button" id="botao" onClick=valida_form()><span id="botao-text" con>Incluir</span></button>
                                        <input name="hidden" type="hidden" id="acao" value="inserir">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="p-t-15 centraliza">                                        
                                        <button class="btn btn--radius-2 btn--green" type="button" id="botao2" onClick=limpa_form()>Limpar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>                
            </div>
        </div> 


        <div id="msg_transportadora" style="visibility: hidden;">&nbsp;<font face="Verdana" size="2">Processando...</font>

		<script src="js/cidadetransp.js"></script>
		<script src="js/geral.js"></script>


    </body>

</html>


