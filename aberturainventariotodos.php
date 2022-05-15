<?php
$flagmenu = 5;
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
        <title>Abertura de Inventário - Todos</title>        

        <!-- maxnew CSS-->
        <link href="css/max.css" rel="stylesheet" media="all">        
    </head>

    <body onload="load_grupo();load_subgrupo();load_grid_estoque();datadiacampo('datainventario');">
        <div id="retorno"></div>
        <div id="dialog" style="margin-left: 5px; margin-left: 5px;"></div>
        <div class="bg-gray p-t-10 font-lucida">
            <div class="wrapper wrapper--w960">
                <div class="card card-4">
                    <div class="card-header">
						Abertura de Inventário - Todos
                    </div>
                    <div class="card-body">                    
                        <form method="POST"> 
                            <div class="row row-space ">                                
                                <div class="col-3">
                                    <div class="input-group m-r-45">
                                        <label class="label">Data Inventário</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" type="text" name="datainventario" id="datainventario" OnKeyPress="formatar('##/##/####', this)" onBlur="dataano(this, this.value)" maxlength="10" size="12">
                                        </div>
                                    </div>
                                </div>                                                               
							</div>
							<div class="row row-space">
								<div class="col-1">
									<div class="input-group m-r-45">
										<label class="label">Estoque Atual</label>
										<div>
										<label class="radio-container m-r-15">Repete Quantidade                                              
											<input type="radio" name="estoqueatual" id="estoqueatual01" value="1" checked>
											<span class="checkmark"></span>
										</label>
										<label class="radio-container">Zerado
											<input type="radio" name="estoqueatual" id="estoqueatual02" value="2">
											<span class="checkmark"></span>
										</label>
										</div>
									</div>
								</div>
							</div>
							<a href="javascript:addgrupo();" style="text-decoration:underline;color:#000000;"><label class="label">&curren; Adicionar Grupo</label></a>
							<div class="row row-space" id="lin1" style="display:none;">
                                <div class="col-3">
                                    <div class="input-group">
                                        <label class="label">Selecione o(s) Grupo(s)</label>
                                        <div id="resultado2">                                         
                                            <span class="custom-dropdown-multiple">                                                
                                                <select id="grupo" name="grupo" size="1">
                                                    <option value="0">-- Escolha um Grupo --</option>
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="input-group">
                                        <label class="label">&nbsp;</label>
                                        <div class="centraliza">
                                            <a class="btn-small btn--radius-2 btn--blue" href="javascript:insertBeforeSelected('grupo','13','grupo_selecionados');">
                                                Adicionar
                                            </a>
                                        </div>                                            
                                        <br>
                                        <br>
										<div class="centraliza">
                                            <a class="btn-small btn--radius-2 btn--blue" href="javascript:insertBeforeSelected2('grupo');">
                                                Todos
                                            </a>
                                        </div>  
                                        <br>
                                        <br>                                        
                                        <div class="centraliza">
                                            <a class="btn-small btn--radius-2 btn--blue" href="javascript:removeOption('46','grupo_selecionados');">
                                                Remover
                                            </a>
                                        </div>    
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="input-group">
                                        <label class="label">Grupos Selecionados</label>
                                        <div>                                         
                                            <span class="custom-dropdown-multiple">                                                
                                                <select id="grupo_selecionados" name="grupo_selecionados[]" multiple style="height:150px;width:300px;" onkeypress="removeOption(this, event, 'grupo_selecionados');">                                                    
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
							<a href="javascript:addsubgrupo();" style="text-decoration:underline;color:#000000;"><label class="label">&curren; Adicionar SubGrupo</label></a>
							<div class="row row-space" id="lin2" style="display:none;">
                                <div class="col-3">
                                    <div class="input-group">
                                        <label class="label">Selecione o(s) SubGrupo(s)</label>
                                        <div id="resultado3">                                         
                                            <span class="custom-dropdown-multiple">                                                
                                                <select id="subgrupo" name="subgrupo" size="1">
                                                    <option value="0">-- Escolha um SubGrupo --</option>
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="input-group">
                                        <label class="label">&nbsp;</label>
                                        <div class="centraliza">
                                            <a class="btn-small btn--radius-2 btn--blue" href="javascript:insertBeforeSelected('subgrupo','13','subgrupo_selecionados');">
                                                Adicionar
                                            </a>
                                        </div>                                            
                                        <br>
                                        <br>
										<div class="centraliza">
                                            <a class="btn-small btn--radius-2 btn--blue" href="javascript:insertBeforeSelected2b('subgrupo');">
                                                Todos
                                            </a>
                                        </div>                                          
                                        <br>
                                        <br>                                        
                                        <div class="centraliza">
                                            <a class="btn-small btn--radius-2 btn--blue" href="javascript:removeOption('46','subgrupo_selecionados');">
                                                Remover
                                            </a>
                                        </div>    
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="input-group">
                                        <label class="label">SubGrupos Selecionados</label>
                                        <div>                                         
                                            <span class="custom-dropdown-multiple">                                                
                                                <select id="subgrupo_selecionados" name="subgrupo_selecionados[]" multiple style="height:150px;width:280px;" onkeypress="removeOption(this, event, 'subgrupo_selecionados');">                                                    
                                                </select> 
                                            </span>
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
		<div class="wrapper wrapper--w960">
            <div class="result" id="resultado"></div> 
		</div>
			  
		<div id="msg" style="visibility: hidden;">&nbsp;<font face="Verdana" size="2">Processando...</font></div>


		<script src="js/aberturainventariotodos.js"></script>
        <script type="text/javascript">
            var $a = jQuery.noConflict()
        </script>
		
    </body>

</html>

