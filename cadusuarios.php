<?php 
$flagmenu=2;
// Verificador de sessão
require("verifica.php");
include 'include/css.php';

?>

<!DOCTYPE html>
<html>
    <head>
        <!-- Required meta tags-->    
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Title Page-->
        <title>Cadastro de Usuários</title>        

        <!-- maxnew CSS-->
        <link href="css/max.css" rel="stylesheet" media="all">        
    </head>

    <body>
        <div id="retorno"></div>
        <div id="dialog" style="margin-left: 5px; margin-left: 5px;"></div>
        <div class="bg-gray p-t-10 p-b-100 font-lucida">
            <div class="wrapper wrapper--w680">
                <div class="card card-4">
                    <div class="card-header">
                        Cadastro de Usuários
                    </div>
                    <div class="card-body">                    
                        <form method="POST"> 
                            <div class="row row-space">                                
                                <div class="col-2">
                                    <div class="input-group">
                                        <label class="label">Pesquisar</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" type="text" id="pesquisa" name="pesquisa" maxlength="30" onBlur="convertField(this)" onKeyPress="maiusculo()">
                                        </div>
                                    </div>
                                </div>                                
                                <div class="col-3">
                                    <div class="input-group">
                                        <label class="label">&nbsp;</label>
                                        <div class="input-group-icon centraliza">
                                            <button class="btn-small btn--radius-2 btn--blue" name="button" type="button" onClick="dadospesquisa(pesquisa.value)">Pesquisar</button>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>                            
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group">
                                        <label class="label">Usuário</label>                                        
                                        <div class="p-t-10">                                          
                                            <span class="custom-dropdown">
                                                <select id="listDados" name="listDados" size="1" onChange="dadospesquisa2(this.value);">
                                                    <option selected="selected" value="0">Faça a pesquisa do Usuário</option>                                                
                                                </select> 
                                            </span> 
                                            <input id="codigo" type="hidden" name="codigo" size="25">
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group">
                                        <label class="label">Usuário</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" type="text" id="descricao" name="descricao" maxlength="30" onBlur="convertField(this)" onKeyPress="maiusculo()">
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                            
                            <div class="row row-space">                                
                                <div class="col-3">
                                    <div class="input-group m-r-45">
                                        <label class="label">Login</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" type="text" id="descricao2" name="descricao2" maxlength="10" onBlur="convertField(this)" onKeyPress="maiusculo()">                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="input-group m-r-45">
                                        <label class="label">Senha</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="descricao3" type="password" name="descricao3" size="10" maxlength="8" onKeyPress="maiusculo()" onBlur="convertField(this);">
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-3">
                                    <div class="input-group m-r-45">
                                        <label class="label">Confirma</label>                                        
                                        <input class="input--style-4" id="descricao4" type="password" name="descricao4" size="10" maxlength="8" onKeyPress="maiusculo()" onBlur="convertField(this);">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group">
                                        <label class="label">Email</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-email" type="email" id="email" name="email" maxlength="50">
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                            
                            <div class="row row-space">                                
                                <div class="col-3">
                                    <div class="p-t-15 centraliza">
                                        <button class="btn btn--radius-2 btn--blue" id="botao" type="button" onClick="valida_form();"><span id="botao-text" con>Incluir</span></button>
                                        <input name="hidden" type="hidden" id="acao" value="inserir">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="p-t-15 centraliza">                                        
                                        <button class="btn btn--radius-2 btn--green" id="botao2" type="button" onClick="limpa_form();">Limpar</button>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="p-t-15 centraliza">                                        
                                        <button class="btn btn--radius-2 btn--red" id="botao3" type="button" onClick="verifica();">Excluir</button>
                                    </div>
                                </div>
                            </div>    
                        </form>
                    </div>
                </div>                
            </div>
        </div>

        <script src="js/cadusuarios.js"></script>        
        <script type="text/javascript">
            var $a = jQuery.noConflict()
        </script>

    </body>

</html>

