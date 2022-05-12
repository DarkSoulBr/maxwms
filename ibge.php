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
        <title>Cadastro de Cidades - IBGE</title> 

        <!-- maxnew CSS-->
        <link href="css/max.css" rel="stylesheet" media="all">        
    </head>

    <body onLoad=dadospesquisaestado(0)> 
        <div id="retorno"></div>
        <div id="dialog" style="margin-left: 5px; margin-left: 5px;"></div>
        <div class="bg-gray p-t-10 p-b-100 font-lucida">
            <div class="wrapper wrapper--w680">
                <div class="card card-4">
                    <div class="card-header">
                        Cadastro de Cidades - IBGE
                    </div>
                    <div class="card-body">                    
                        <form method="POST">
                            <div class="row row-space">                                
                                <div class="col-2">
                                    <div class="input-group">
                                        <label class="label">Pesquisar</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="pesquisa" type="text" name="pesquisa" size="35" onKeyPress="maiusculo()" onblur="convertField(this);">
                                        </div>
                                    </div>
                                </div>                                
                                <div class="col-3">
                                    <div class="input-group">
                                        <label class="label">&nbsp;</label>
                                        <div class="input-group-icon centraliza">
                                            <button class="btn-small btn--radius-2 btn--blue" name="button" type="button" id="button" onClick=pesquisa1(pesquisa.value)>Pesquisar</button>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>						
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group">
                                        <label class="label">Cidade</label>                                        
                                        <div>                                          
                                            <span class="custom-dropdown">
                                                <select name="listDados" onChange="dadospesquisa2(this.value);">
                                                    <option id="opcoes" value="0">Faça a Pesquisa de Cidade</option>                                                
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
									<input id="cidcodigo" type="hidden" name="cidcodigo" size="25">
                                </div>                                
                            </div>
                            <div class="row row-space">
                                <div class="col-2">
                                    <div class="input-group">
                                        <label class="label">Cidade</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="cidnome" type="text" name="cidnome" size="35" onKeyPress="maiusculo()" onblur="convertField(this);">
                                        </div>
                                    </div>
                                </div>
								<div class="col-3">
                                    <div class="input-group">
                                        <label class="label">UF</label>                                        
                                        <div>                                          
                                            <span class="custom-dropdown">
                                                <select name="listestados">
                                                    <option id="opcoes2" value="0">__</option>                                                
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
                                </div> 
                            </div>
							<div class="row row-space">
                                <div class="col-2">
                                    <div class="input-group m-r-45">
                                        <label class="label">C.Cidade</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="cep" type="text" name="cep" size="8" onKeyPress="maiusculo()" maxlength="5">
                                        </div>
                                    </div>
                                </div> 
								<div class="col-2">
                                    <div class="input-group m-r-45">
                                        <label class="label">C.Estado</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="cep2" type="text" name="cep2" size="8" onKeyPress="maiusculo()" maxlength="2">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-space">                                
                                <div class="col-3">
                                    <div class="p-t-15 centraliza">
                                        <button class="btn btn--radius-2 btn--blue" type="button" id="botao" onClick=valida_form()><span id="botao-text" con>Incluir</span></button>
                                        <input name="hidden" type="hidden" id="acao" value="inserir">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="p-t-15 centraliza">                                        
                                        <button class="btn btn--radius-2 btn--green" type="button" id="botao2" onClick=limpa_form() >Limpar</button>
                                    </div>
                                </div>
								<div class="col-3">
                                    <div class="p-t-15 centraliza">                                        
                                        <button class="btn btn--radius-2 btn--red" type="button" id="botao3" onClick=verifica()>Excluir</button>
                                    </div>
                                </div>
                            </div>    
                        </form>
                    </div>
                </div>                
            </div>
        </div>

		<script src="js/ibge.js"></script>
		<script src="js/geral.js"></script>
		
    </body>

</html>


