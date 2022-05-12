<?php
$flagmenu = 4;
// Verificador de sessão
require("verifica.php");
include 'include/jquerymax.php';
include 'include/cssloja.php';

//Verifica se a opção existe no Cadastros de Opção
$opcao = 'MANUTENCAO ESTOQUE';
$pagina = 'estoque.php';
$modulo = 4;  //Cadastros
$sub = 18;  //Produtos
$usuario = $_SESSION["id_usuario"];

?>

<!DOCTYPE html>
<html>
    <head>
        <!-- Required meta tags-->    
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Title Page-->
        <title>Cadastro de Estoques</title>        

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
                        Cadastro de Estoques
                    </div>
                    <div class="card-body">                    
                        <form method="POST">
                            <div class="row row-space">                                
                                <div class="col-2">
                                    <div class="input-group">
                                        <label class="label">Pesquisar</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" type="text" id="pesquisa" name="pesquisa" maxlength="40" onBlur="convertField(this)" onKeyPress="maiusculo()">
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
                                        <label class="label">Estoque</label>                                        
                                        <div class="p-t-10">                                          
                                            <span class="custom-dropdown">
                                                <select id="listDados" name="listDados" size="1" onChange="dadospesquisa2(this.value);">
                                                    <option selected="selected" value="0">Faça a pesquisa do Estoque</option>                                                
                                                </select> 
                                            </span> 
                                            <input id="codigo" type="hidden" name="codigo" size="25">
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                            <div class="row row-space">
                                <div class="col-2">
                                    <div class="input-group m-r-45">
                                        <label class="label">Estoque</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" type="text" id="nome" name="nome" maxlength="20" onBlur="convertField(this)" onKeyPress="maiusculo()">
                                        </div>
                                    </div>
                                </div>    
                                <div class="col-2">
                                    <div class="input-group m-r-45">
                                        <label class="label">Sigla</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" type="text" id="sigla" name="sigla" maxlength="5" onBlur="convertField(this)" onKeyPress="maiusculo()">                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row row-space" style="display: none;">
                                
                                <div class="col-2">
                                    <div class="input-group m-r-45">
                                        <label class="label">Reserva</label>
                                        <div>
                                            <label class="radio-container m-r-15">Sim                                            
                                                <input type="radio" id="radio1" name="radiobutton" value="radiobutton" >
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container">Não
                                                <input type="radio" id="radio2" name="radiobutton" value="radiobutton" checked>
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div> 
                                
                                <div class="col-2">
                                    <div class="input-group m-r-45">
                                        <label class="label">Aviso Zerou Estoque</label>
                                        <div>
                                            <label class="radio-container m-r-15">Sim                                            
                                                <input type="radio" id="radiozero1" name="radiobuttonzero" value="radiobutton" >
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container">Não
                                                <input type="radio" id="radiozero2" name="radiobuttonzero" value="radiobutton" checked>
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row row-space" style="display: none;">                              
                                
                                <div class="col-2">
                                    <div class="input-group m-r-45">
                                        <label class="label">Consultas</label>
                                        <div>
                                            <label class="radio-container m-r-15">Sim                                            
                                                <input type="radio" id="radiocons1" name="radiobuttoncons" value="radiobutton" checked>
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container">Não
                                                <input type="radio" id="radiocons2" name="radiobuttoncons" value="radiobutton" >
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-2">
                                    <div class="input-group m-r-25">
                                        <label class="label">Empresa</label>
                                        <div>
                                            <label class="check-container m-r-15">CAB
                                                <input type="checkbox" name="checkbox1" id="checkbox1" checked>
                                                <span class="check-checkmark"></span>
                                            </label>
                                            <label class="check-container">FUN
                                                <input type="checkbox" name="checkbox2" id="checkbox2">
                                                <span class="check-checkmark"></span>
                                            </label>
                                           
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

        <script src="js/estoque.js"></script>        
        <script type="text/javascript">
            var $a = jQuery.noConflict()
        </script>

    </body>

</html>

