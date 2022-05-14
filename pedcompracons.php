<?php
$flagmenu = 1;
require("verifica.php");
include 'include/jquery.php';
include 'include/cssloja.php';

$usuario = $_SESSION["id_usuario"];
?>
<!DOCTYPE html>
<html>
    <head>
        <!-- Required meta tags-->    
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Title Page-->
        <title>Consulta de Pedidos de Compra</title>

        <!-- maxnew CSS-->
        <link href="css/max.css" rel="stylesheet" media="all">
        <style>
            .row-max .cell-max:nth-child(1) {
                width: 100px;
                text-align: center;
                padding-left: 5px;
            }

            .row-max .cell-max:nth-child(2) {
                width: 600px;
                text-align: center;
                padding-right: 5px;
            }

            .row-max .cell-max:nth-child(3) {
                width: 100px;
                text-align: center;
                padding-right: 5px;
            }

            .row-max .cell-max:nth-child(4) {
                width: 100px;
                text-align: center;
                padding-right: 5px;
            }

            .row-max .cell-max:nth-child(5) {
                width: 100px;
                text-align: center;
                padding-right: 5px;
            }

            .row-max .cell-max:nth-child(6) {
                width: 100px;
                text-align: center;
                padding-right: 5px;
            }

        </style>
    </head>

    <body onLoad="ver(0, 0, 0, 0)";>
        <div id="retorno"></div>
        <div id="dialog" style="margin-left: 5px; margin-left: 5px; background:white;"></div>
        <div class="bg-gray p-t-10 p-b-100 font-lucida">
            <div class="wrapper wrapper--w780">
                <div class="card card-4">
                    <div class="card-header">
                        Consulta de Pedidos de Compra
                    </div>
                    <div class="card-body">                    
                        <form name="formulario" method="POST">

                            <div class="row row-space">
                                <div class="col-3">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Pedido</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" name="pcnumero" type="text" id="pcnumero" onkeypress="return somenteNumeros(event)" onFocus="nextfield = 'button_pesquisa'" size="10"  style="BACKGROUND-COLOR: #b3c6ff; COLOR: #660000; FONT-WEIGHT: bold;">
                                            <input id="codigo" type="hidden" name="codigo" size="25">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-3 centraliza">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">&nbsp;</label>
                                        <button class="btn-small btn--radius-2 btn--blue" name="button_pesquisa" type="button" id="button_pesquisa" onClick="ver(this.form.pcnumero.value, 0, 0, 0)";>Pesquisar</button>
                                    </div>
                                </div>                              

                                <div class="col-3">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Emissão</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" name="pcemissao" type="text" id="pcemissao" onkeyup="this.value = this.value.toUpperCase()" size="10" disabled="disabled">
                                        </div>
                                    </div>
                                </div>

                            </div> 

                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group-small m-r-15">
                                        <label class="label">Fornecedor</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="fornguerra" type="text" name="fornguerra" size="65" onKeyPress="maiusculo()" disabled="disabled">                                            
                                        </div>
                                    </div>
                                </div>                                
                            </div> 

                            <div class="row row-space">                                
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Comprador</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="comprador" type="text" name="comprador" size="65" onKeyPress="maiusculo()" disabled="disabled">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Condições Pagamento</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="condicao" type="text" name="condicao" size="65" onKeyPress="maiusculo()" disabled="disabled">                                            
                                        </div>
                                    </div>
                                </div>
                            </div> 

                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group-small m-r-15">
                                        <label class="label">Observações</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="observacao1" type="text" name="observacao1" size="65" onKeyPress="maiusculo()" disabled="disabled">                                            
                                        </div>
                                    </div>
                                </div>                                
                            </div> 
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group-small m-r-15">                                        
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="observacao2" type="text" name="observacao2" size="65" onKeyPress="maiusculo()" disabled="disabled">                                            
                                        </div>
                                    </div>
                                </div>                                
                            </div> 
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group-small m-r-15">                                        
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="observacao3" type="text" name="observacao3" size="65" onKeyPress="maiusculo()" disabled="disabled">                                            
                                        </div>
                                    </div>
                                </div>                                
                            </div>

                            <div class="row row-space">
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Produtos</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4 direita" id="produtos" type="text" name="produtos" disabled="">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Desconto</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4 direita" name="desconto" type="text" id="desconto" disabled="">
                                        </div>
                                    </div>
                                </div>                         

                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">IPI</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4 direita" name="ipi" type="text" id="ipi" disabled="">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Total</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4 direita" name="total" type="text" id="total" disabled="">
                                        </div>
                                    </div>
                                </div>

                            </div> 

                            <div style ="display:none">
                                <input name="comissao" type="text" id="comissao" maxlength="5" size="6" disabled="disabled"  style="BACKGROUND-COLOR: White;COLOR : Black">
                                <div id="msg" style="visibility: hidden;">&nbsp;<font face="Verdana" size="2">Processando...</font></div>
                            </div>

                            <div class="row row-space m-b-25"></div>

                            <div class="row row-space">
                                <div class="col-4 centraliza">
                                    <button class="btn-medium btn--radius-2 btn--blue" name="buttonO" type="button" id="buttonO" onClick="ver(document.forms[0].pcnumero.value, 0, 0, 0)">Original</button>                                    
                                </div>
                                <div class="col-4 centraliza">
                                    <button class="btn-medium btn--radius-2 btn--blue" name="buttonA" type="button" id="buttonA" onClick="aberto()">Aberto</button>
                                </div>                                
                                <div class="col-4 centraliza">
                                    <button class="btn-medium btn--radius-2 btn--blue" name="buttonB" type="button" id="buttonB" onClick="faturados()">Faturado</button>
                                </div>
                                <div class="col-4 centraliza">
                                    <button class="btn-medium btn--radius-2 btn--blue" name="buttonC" type="button" id="buttonC" onClick="baixasparciais()">Baixas</button>
                                </div>
                            </div>

                            <div class="row row-space m-b-25"></div>
                            <hr>
                            <div class="row row-space m-b-25"></div>

                            <div class="row row-space">
                                <div class="col-3">
                                    <div class="input-group-small centraliza">
                                        <label class="label">&nbsp;</label>
                                        <div>
                                            <label class="radio-container m-r-15">Saldo
                                                <input id="radioa1" input name="radioa" type="radio" value="radiobutton" checked>
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container m-r-15">Original
                                                <input id="radioa2" input type="radio" name="radioa" value="radiobutton" >
                                                <span class="checkmark"></span>
                                            </label>                                                                                  
                                        </div>
                                    </div>                                    
                                </div>   

                                <div class="col-3">
                                    <div class="input-group-small centraliza">
                                        <label class="label">&nbsp;</label>
                                        <div>
                                            <label class="radio-container m-r-15">Tipo 1
                                                <input id="radiob1" input name="radiob" type="radio" value="radiobutton" checked>
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container m-r-15">Tipo 2
                                                <input id="radiob2" input type="radio" name="radiob" value="radiobutton" >
                                                <span class="checkmark"></span>
                                            </label>                                                                                  
                                        </div>
                                    </div>                                    
                                </div>   

                                <div class="col-3 centraliza">
                                    <div class="input-group-small centraliza">
                                        <label class="label">&nbsp;</label>
                                        <button class="btn-small btn--radius-2 btn--blue" name="button2" type="button" id="button22" onClick="impped()">Imprimir</button>
                                    </div>
                                </div>                              



                            </div> 

                        </form>


                    </div>
                </div>

            </div>

            <div class="row row-space m-b-25"></div>

            <div class="wrapper wrapper--w1200">
                <div class="result" id="resultado"></div>
            </div>
        </div>

        <script src="js/pedcompracons.js"></script>        
        <script type="text/javascript">
                                            var $a = jQuery.noConflict()
        </script>

    </body>

</html>