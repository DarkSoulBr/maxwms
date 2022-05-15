<?php
$flagmenu = 5;
// Verificador de sessão
require("verifica.php");

$usuario = $_SESSION["id_usuario"];

include 'include/css.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <!-- Required meta tags-->    
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Title Page-->
        <title>Cadastro de Contagem</title>        

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
                        Cadastro de Contagem
                    </div>
                    <div class="card-body">                    
                        <form method="POST">
                            <div class="row row-space">                                
                                <div class="col-2">
                                    <div class="input-group">
                                        <label class="label">Pesquisar</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="pesquisa" type="text" name="pesquisa" size="35" maxlength="30" onBlur="convertField(this)" onKeyPress="maiusculo()">
                                        </div>
                                    </div>
                                </div>                                
                                <div class="col-3">
                                    <div class="input-group">
                                        <label class="label">&nbsp;</label>
                                        <div class="input-group-icon centraliza">
                                            <button class="btn-small btn--radius-2 btn--blue" name="button" type="button" id="button" onClick=dadospesquisa(pesquisa.value)>Pesquisar</button>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group">
                                        <label class="label">Contagem</label>                                        
                                        <div class="p-t-10">                                          
                                            <span class="custom-dropdown">
                                                <select name="listDados" onChange="dadospesquisa2(this.value);">
                                                    <option id="opcoes" value="0">Faça a Pesquisa da Contagem</option>                                                
                                                </select> 
                                            </span>           
                                        </div>
                                        <input id="fpgcodigo" type="hidden" name="fpgcodigo" size="25">
                                    </div>
                                </div>                                
                            </div>								
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group">
                                        <label class="label">Contagem</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="fpgnome" type="text" name="fpgnome" size="35" maxlength="30" onBlur="convertField(this)" onKeyPress="maiusculo()">
                                        </div>
                                    </div>
                                </div>                                
                            </div>          
                            <div class="col-1">
                                <div class="input-group m-r-45">
                                    <label class="label">Opção</label>
                                    <div class="p-t-10">
                                        <label class="radio-container m-r-15">Normal                                                
                                            <input type="radio" id="radio1" name="radiobutton" value="radiobutton" checked>
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="radio-container">Inativa
                                            <input type="radio" id="radio2" name="radiobutton" value="radiobutton">
                                            <span class="checkmark"></span>
                                        </label>
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
        <div class="centraliza">
            <div id="resultado"></div>
        </div>
        <input type="hidden" name="erroincluir" id="erroincluir" value="0">
        <div id="msg" style="visibility: hidden;">&nbsp;<font face="Verdana" size="2">Processando...</font></div>

        <script src="js/contagem.js"></script>

    </body>

</html>




