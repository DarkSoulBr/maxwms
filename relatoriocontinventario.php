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
        <title>Relatório de Contagem para Inventário</title>        

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
                        Relatório de Contagem para Inventário
                    </div>
                    <div class="card-body">                    
                        <form name="formulario" method="POST">
                            <div class="row row-space ">                                
                                <div class="col-2">
                                    <div class="input-group m-r-45">
                                        <label class="label">Data Inventário</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" type="text" name="datainventario" id="datainventario" onkeypress="javascript:formata_data(this);" onBlur="dataano(this, this.value)" maxlength="10">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-space">
                                <div class="col-1">
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
                            </div> 
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group m-r-45">
                                        <label class="label">Estoque Atual Impresso?</label>
                                        <div>
                                            <label class="radio-container m-r-15">Sim            
                                                <input type="radio" name="estoqueimpresso" id="estoqueimpresso1" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container m-r-15">Não
                                                <input type="radio" name="estoqueimpresso" id="estoqueimpresso2" value="1" checked="">
                                                <span class="checkmark"></span>
                                            </label>								
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div><a href="javascript:addgrupo();" style="text-decoration:underline;color:#000000;"><label class="label">&curren; Adicionar Grupo</label></a></div>
                            <div class="row row-space" id="lin1" style="display:none;">
                                <div class="col-2">
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
                                <div class="col-2">
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

                            <div><a href="javascript:addsubgrupo();" style="text-decoration:underline;color:#000000;"><label class="label">&curren; Adicionar SubGrupo</label></a></div>
                            <div class="row row-space" id="lin2" style="display:none;">
                                <div class="col-2">
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
                                <div class="col-2">
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
                            <div><a href="javascript:addfornecedor();" style="text-decoration:underline;color:#000000;"><label class="label">&curren; Adicionar Fornecedor</label></a></div>
                            <div id="lin3" style="display:none;">
                                <div class="row row-space">
                                    <div class="col-1">
                                        <div class="input-group m-r-45">
                                            <label class="label">Opções</label>
                                            <div>
                                                <label class="radio-container m-r-15">Código                           
                                                    <input type="radio" name="opcao" id="opcao1" value="1" align="absmiddle" checked>
                                                    <span class="checkmark"></span>
                                                </label>
                                                <label class="radio-container m-r-15">N. Guerra
                                                    <input type="radio" name="opcao" id="opcao2" value="2" align="absmiddle">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <label class="radio-container">Razão
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
                                                <button class="btn-small btn--radius-2 btn--blue" type="button" name="pesquisar" id="pesquisar" onclick="load_grid_fornecedor();">Pesquisar</button>
                                            </div>
                                        </div>                                    
                                    </div>
                                </div>		
                                <div class="row row-space">
                                    <div class="col-1">
                                        <div class="input-group">
                                            <label class="label">Pesquisar Fornecedor</label>                                        
                                            <div id="resultado5">                                          
                                                <span class="custom-dropdown">
                                                    <select id="pesquisa" name="pesquisa" size="1" onchange="setar(this);" disabled>
                                                        <option  value="0">-- Escolha um Fornecedor --</option>                                                
                                                    </select> 
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="nome" id="nome" size="40" readonly disabled>
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
        <div id="msg5" style="visibility: hidden;">&nbsp;<font face="Verdana" size="2">Processando...</font></div>



        <script src="js/relatoriocontinventario.js"></script>

    </body>

</html>