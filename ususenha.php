<?php
$flagmenu = 2;
// Verificador de sessão
require("verifica.php");
require_once("include/conexao.inc.php");

$usuario = $_SESSION["id_usuario"];
?>

<!DOCTYPE html>
<html>
    <head>
        <!-- Required meta tags-->    
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Title Page-->
        <title>Alteração de Senha</title>        

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
                        Alteração de Senha
                    </div>
                    <div class="card-body">                    
                        <form method="POST"> 
                            <div class="row row-space">                                
                                <div class="col-2">
                                    <div class="input-group">
                                        <label class="label">Pesquisar Login</label>
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
                                        <label class="label">Login</label>                                        
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
                                            <input class="input--style-4" type="text" id="descricao2" name="descricao2" maxlength="30" onBlur="convertField(this)" onKeyPress="maiusculo()" disabled>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                            
                            <div class="row row-space">                                
                                <div class="col-3">
                                    <div class="input-group m-r-45">
                                        <label class="label">Login</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" type="text" id="descricao" name="descricao" maxlength="10" onBlur="convertField(this)" onKeyPress="maiusculo()" disabled>                                            
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
                                    <div class="p-t-15 centraliza">
                                        <button class="btn btn--radius-2 btn--blue" id="botao" type="button" onClick="valida_form();"><span id="botao-text" con>Alterar</span></button>
                                        <input name="hidden" type="hidden" id="acao" value="alterar">
                                        <input type="hidden" name="usuario" id="usuario" size="10"  value='<? echo $usuario; ?>'>
                                    </div>
                                </div>                                
                            </div>    
                        </form>
                    </div>
                </div>                
            </div>
        </div>

        <script src="js/ususenha.js"></script>        
        <script type="text/javascript">
            var $a = jQuery.noConflict()
        </script>

    </body>

</html> 

