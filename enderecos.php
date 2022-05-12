<?php
$flagmenu = 4;
// Verificador de sessão
require("verifica.php");

//Verifica se a opção existe no Cadastros de Opção
$opcao = 'MANUTENCAO ENDERECOS';
$pagina = 'vendedor.php';
$modulo = 4;  //Cadastros
$sub = 19;  //Diversos
$usuario = $_SESSION["id_usuario"];

?>
<!DOCTYPE html>
<html>
    <head>

        <!-- Required meta tags-->    
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Title Page-->
        <title>Cadastro de Endereços</title> 

        <!-- maxnew CSS-->
        <link href="css/max.css" rel="stylesheet" media="all">        
    </head>

    <body> 
        <div id="retorno"></div>
        <div id="dialog" style="margin-left: 5px; margin-left: 5px;"></div>
        <div class="bg-gray p-t-10 p-b-100 font-lucida">
            <div class="wrapper wrapper--w780">
                <div class="card card-4">
                    <div class="card-header">
                        Cadastro de Endereços
                    </div>
                    <div class="card-body">                    
                        <form method="POST">
                            <div class="row row-space">                                
                                <div class="col-2">
                                    <div class="input-group-small">
                                        <label class="label">Pesquisar</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="pesquisa" type="text" name="pesquisa" size="50" onkeyup="this.value = this.value.toUpperCase();" onBlur="convertField(this)">
                                        </div>
                                    </div>
                                </div>                                
                                <div class="col-3">
                                    <div class="input-group-small">
                                        <label class="label">&nbsp;</label>
                                        <div class="input-group-small-icon centraliza">
                                            <button class="btn-small btn--radius-2 btn--blue" name="button" type="button" id="button" onClick=dadospesquisa(pesquisa.value)>Pesquisar</button>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                            <div class="col-1">
                                <div class="input-group-small m-r-45">
                                    <label class="label">Opção</label>
                                    <div>
                                        <label class="radio-container m-r-15">ID                                                
                                            <input name="radiobutton" id="radio1" type="radio" value="radiobutton" checked>
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="radio-container m-r-15">UA
                                            <input name="radiobutton" id="radio2" type="radio" value="radiobutton">
                                            <span class="checkmark"></span>
                                        </label>                                       
                                    </div>
                                </div>
                            </div>							
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group-small">                                                                             
                                        <div class="p-t-10">                                          
                                            <span class="custom-dropdown">
                                                <select name="listDados" onChange="dadospesquisa2(this.value);">
                                                    <option id="opcoes" value="0">Faça a Pesquisa do Endereço</option>                                                
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                            <div class="row row-space">
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">ID</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="id" type="text" name="id" size="30" onKeyPress="maiusculo()" disabled readonly style="BACKGROUND-COLOR: #b3c6ff; COLOR: #660000; FONT-WEIGHT: bold;">
                                        </div>
                                    </div>
                                </div>                                
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">UA</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="ua" type="text" name="ua" size="30" onKeyPress="maiusculo()" onBlur="convertField(this)" style="BACKGROUND-COLOR: #b3c6ff; COLOR: #660000; FONT-WEIGHT: bold;">
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                            <div class="row row-space">
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Bloco</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="bloco" type="text" name="bloco" size="50" onKeyPress="maiusculo()" onBlur="convertField(this)">
                                        </div>
                                    </div>
                                </div>                                
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Rua</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="rua" type="text" name="rua" size="30" maxlength="30" onKeyPress="maiusculo()" onBlur="convertField(this)">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-space">
                                     
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Nivel</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="nivel" type="text" name="nivel" size="30" maxlength="30" onKeyPress="maiusculo()" onBlur="convertField(this)">
                                        </div>
                                    </div>
                                </div>                                                       
                                                                             
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Coluna</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="coluna" type="text" name="coluna" size="30" maxlength="30" onKeyPress="maiusculo()" onBlur="convertField(this)">
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Posição do Endereço:</label>
                                        <div>
                                            <label class="radio-container m-r-15">Direita
                                                <input name="radiobutton2" id="radio21" type="radio" value="radiobutton" checked>
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container m-r-15">Esquerda
                                                <input name="radiobutton2" id="radio22" type="radio" value="radiobutton">
                                                <span class="checkmark"></span>
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
                                        <button class="btn btn--radius-2 btn--red" type="button" id="botao3" onClick=verifica()>Excluir</button>
                                    </div>
                                </div>
                            </div>    
                        </form>
                    </div>
                </div>                
            </div>
        </div>

        <script src="js/enderecos.js"></script>

    </body>

</html>


