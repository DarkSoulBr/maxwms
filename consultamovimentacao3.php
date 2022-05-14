<?php
$flagmenu = 5;
// Verificador de sessão
require("verifica.php");

include 'include/jquerymax.php';
include 'include/css.php';

$usuario = $_SESSION["id_usuario"];


?>
<!DOCTYPE html>
<html>
    <head>

        <!-- Required meta tags-->    
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Title Page-->
        <title>Consulta de Produtos - Simples</title> 

        <!-- maxnew CSS-->
        <link href="css/max.css" rel="stylesheet" media="all">
        <style>
            .row-max .cell-max:nth-child(1) {                
                text-align: center;
                padding-left: 10px;
                padding-right: 10px;
            }

            .row-max .cell-max:nth-child(2) {                
                text-align: center;
                padding-right: 10px;
            }

            .row-max .cell-max:nth-child(3) {                
                text-align: center;
                padding-right: 10px;
            }

            .row-max .cell-max:nth-child(4) {               
                text-align: center;
                padding-right: 10px;
            }

            .row-max .cell-max:nth-child(5) {                
                text-align: center;
                padding-right: 10px;
            }


        </style>
    </head>

    <body onload="datadiacampomes('dtinicio', 'dtfinal');dadospesquisadeposito(0, 0);">
        <div id="retorno"></div>
        <div id="dialog" style="margin-left: 5px; margin-left: 5px;"></div>
        <div class="bg-gray p-t-10 font-lucida">
            <div class="wrapper wrapper--w680">
                <div class="card card-4">
                    <div class="card-header">
                        Consulta Movimentação de Produtos - Sintético
                    </div>
                    <div class="card-body">                    
                        <form name="formulario" method="POST" action="javascript:;">
                            <div class="row row-space">                                
                                <div class="col-2">
                                    <div class="input-group-small m-r-150">
                                        <label class="label">Código</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="codigoproduto" type="text" name="codigoproduto" size="6" OnKeyPress="formatar('####-#', this)" onBlur="dadospesquisapertence(this.value)">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-space">                                
                                <div class="col-1">
                                    <div class="input-group-small">
                                        <label class="label">Produto</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="produto" type="text" name="produto" size="49" onKeyPress="maiusculo()" onBlur="convertField(this);pesquisaprodutos(this.value);">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group-small">
                                        <label class="label">Pesquisa</label>                                        
                                        <div id="resultado_produto">                                          
                                            <span class="custom-dropdown">
                                                <select name="pesquisaproduto" onBlur="pesquisacod(this.value)">
                                                    <option id="pesquisaproduto" value="0">__________________________________________________</option>
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
                                </div>                                                         
                            </div>
                            <div class="row row-space">
                                <div class="col-2">
                                    <div class="input-group-small m-r-150">
                                        <label class="label">Data Inicio</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" type="text" name="dtinicio" id="dtinicio" size="12" onkeypress="javascript:formata_data(this);" onBlur="dataano(this, this.value)" maxlength="10">                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="input-group-small m-r-150">
                                        <label class="label">Data Fim</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" type="text" name="dtfinal" id="dtfinal" size="12" onkeypress="javascript:formata_data(this);" onBlur="dataano(this, this.value)" maxlength="10">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group-small">
                                        <label class="label">Estoque</label>                                        
                                        <div id="resultado_produto">                                          
                                            <span class="custom-dropdown">
                                                <select name="deposito">
                                                    <option id="deposito" value="0">______________________</option>
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
                                </div>                                                         
                            </div>
                            <div class="row row-space m-b-25"></div>

                            <div class="row row-space">
                                <div class="col-2">
                                    <div class="input-group-small m-r-15">                                        
                                        <div class="input-group-icon centraliza">
                                            <button class="btn-small btn--radius-2 btn--blue" name="button3" type="button" id="botao3" onClick="consultar()">Consultar</button>                                            
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="col-2">
                                    <div class="input-group-small m-r-15">                                        
                                        <div class="input-group-icon centraliza">
                                            <button class="btn-small btn--radius-2 btn--blue" name="button" type="button" id="botao" onClick="imp()" >Imprimir</button>                                            
                                        </div>
                                    </div>                                    
                                </div>
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
        <input type="hidden" name="usuario" id="usuario" size="10"  value='<? echo $usuario; ?>'>

        <script src="js/consultamovimentacao3.js"></script>
        <script src="js/geral.js"></script>
        <script type="text/javascript">
                                                var $a = jQuery.noConflict()
        </script>

    </body>



</html>