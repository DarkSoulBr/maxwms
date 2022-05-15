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
        <title>Relatório de Contagem de Estoque por Setor</title>        

        <!-- maxnew CSS-->
        <link href="css/max.css" rel="stylesheet" media="all">        
    </head>

    <body onload="dadospesquisadata(0);">
        <div id="retorno"></div>
        <div id="dialog" style="margin-left: 5px; margin-left: 5px;"></div>
        <div class="bg-gray p-t-10 p-b-100 font-lucida">
            <div class="wrapper wrapper--w680">
                <div class="card card-4">
                    <div class="card-header">
                        Relatório de Contagem de Estoque por Setor
                    </div>
                    <div class="card-body">                    
                        <form method="POST"> 
                            <div class="row row-space ">                                
                                <div class="col-2">
                                    <div class="input-group">
                                        <label class="label">Data</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" name="pvemissao" type="text" id="pvemissao" onKeyPress="maiusculo()" size="10" disabled="disabled">
                                        </div>
                                    </div>
                                </div>                                                           
                            </div>	               								
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group">
                                        <label class="label">Contagem</label>                                        
                                        <div id="resultado4">                                          
                                            <span class="custom-dropdown">
                                                <select id="estoque" name="estoque" size="1">
                                                    <option value="0">-- Escolha uma Contagem --</option>                                                
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group">
                                        <label class="label">Setor</label>                                        
                                        <div id="resultado4x">                                          
                                            <span class="custom-dropdown">
                                                <select id="estoque2" name="estoque2" size="1">
                                                    <option value="0">-- Escolha um Setor --</option>                                                
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                            <div class="col-1">
                                <div class="input-group m-r-45">
                                    <label class="label">Coletor</label>
                                    <div>
                                        <label class="radio-container m-r-15">Não                                                
                                            <input id="radio1" name="radiobutton" type="radio" value="radiobutton" onClick="verificaest();">
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="radio-container">Sim
                                            <input id="radio2" name="radiobutton" type="radio" value="radiobutton" checked onClick="verificaest();">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group">
                                        <label class="label">Coletor</label>                                        
                                        <div id="resultado4z">                                          
                                            <span class="custom-dropdown">
                                                <select id="estoque3" name="estoque3" size="1">
                                                    <option value="0">-- Escolha um Coletor --</option>                                                
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                            <div class="p-t-15 centraliza">
                                <button class="btn btn--radius-2 btn--blue" type="button" id="botao" onclick="imprelatorioexexcel();">Excel</button>
                            </div>								
                        </form>
                    </div>
                </div>                
            </div>
        </div>



        <div id="msg" style="visibility: hidden;">&nbsp;<font face="Verdana" size="2">Processando...</font></div>
        <div id="resultado">


            <script src="js/relatoriogeracontagemsetor.js"></script>

    </body>

</html>

