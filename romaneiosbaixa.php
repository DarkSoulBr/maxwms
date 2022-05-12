<?php
$flagmenu = 3;
// Verificador de sessão
require("verifica.php");

//Verifica se a opção existe no Cadastros de Opção
$opcao = 'ROMANEIOS BAIXA (CD-SP)';
$pagina = 'romaneiosbaixa.php';
$modulo = 3;  //Logistica
$sub = 14;  //Romaneios
$usuario = $_SESSION["id_usuario"];


?>
<!DOCTYPE html>
<html>
    <head>
        <!-- Required meta tags-->    
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Title Page-->
        <title>Baixa de Romaneios</title>        

        <!-- maxnew CSS-->
        <link href="css/max.css" rel="stylesheet" media="all">     

        <style>
            .row-max .cell-max:nth-child(1) {
                text-align: center;
                padding-left: 5px;
            }

            .row-max .cell-max:nth-child(2) {
                text-align: center;
                padding-right: 5px;
            }

            .row-max .cell-max:nth-child(3) {
                text-align: center;
                padding-left: 5px;
            }

            .row-max .cell-max:nth-child(4) {
                text-align: center;
                padding-right: 5px;
            }

            .row-max .cell-max:nth-child(5) {
                text-align: center;
                padding-left: 5px;
            }

            .row-max .cell-max:nth-child(6) {
                text-align: center;
                padding-right: 5px;
            }

            .row-max .cell-max:nth-child(7) {
                text-align: center;
                padding-left: 5px;
            }

            .row-max .cell-max:nth-child(8) {
                text-align: center;
                padding-right: 5px;
            }
        </style>
    </head>
    <body onload="sugere()">
        <div id="retorno"></div>
        <div id="dialog" style="margin-left: 5px; margin-left: 5px;"></div>
        <div class="bg-gray p-t-10 font-lucida">
            <div class="wrapper wrapper--w680">
                <div class="card card-4">
                    <div class="card-header">
                        Baixa de Romaneios
                    </div>
                    <div class="card-body">                    
                        <form name="formulario">
                            <div class="row row-space ">                                
                                <div class="col-3">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Número</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="pvnumero1" type="text" name="pvnumero1" size="8" onKeyPress="maiusculo()">
                                        </div>
                                    </div>
                                </div>                                             
                                <div class="col-3">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">&nbsp;</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="pvnumero2" type="text" name="pvnumero2" size="8" onKeyPress="maiusculo()" onBlur="X(this.value)">
                                        </div>
                                    </div>
                                </div>  
                                <div class="col-3">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Data</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="data" type="text" name="data" size="15" OnKeyPress="formatar('##/##/####', this)" onBlur="dataano(this, this.value)" maxlength="10"  disabled="disabled">
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <div class="row row-space ">                                
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Baixa</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="baixa" type="text" name="baixa" size="12" OnKeyPress="formatar('##/##/####', this)" onBlur="dataano(this, this.value)" maxlength="10">
                                        </div>
                                    </div>
                                </div>                                             
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">KM. Final</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="final" type="text" name="final" size="12" onKeyPress="maiusculo()" maxlength="10">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-space">
                                <div class="col-1 centraliza">
                                    <div class="input-group">
                                        <label class="label">&nbsp;</label>
                                        <div>
                                            <label class="radio-container m-r-15">Todos                                              
                                                <input id="radio1" input name="radio" type="radio" value="radiobutton" onClick="verificaconf(this.value);" checked>
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container">Parcial
                                                <input id="radio2" input name="radio" type="radio" value="radiobutton" onClick="parcf();">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-space ">                                
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Pedido</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="pedido" type="text" name="pedido" size="20" maxlength="20" onKeyPress="maiusculo()" onBlur="convertField(this)" disabled>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <div class="row row-space ">                                
                                <div class="col-1">
                                    <div class="input-group-small m-r-15">
                                        <label class="label">Observação</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="observacao" type="text" name="observacao" size="50" maxlength="100" onKeyPress="maiusculo()" onBlur="convertField(this)">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-space ">     
                                
                                <div class="col-1">
                                    <div class="input-group-small m-r-15">
                                        <label class="label">Nome do Recebedor</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="recebedor" type="text" name="recebedor" size="50" maxlength="100" onKeyPress="maiusculo()" onBlur="convertField(this)">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-space ">     
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Data da Entrega</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="datae" type="text" name="datae" size="12" OnKeyPress="formatar('##/##/####', this)" onBlur="dataano(this, this.value)" maxlength="10">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="input-group-small m-r-45"> 
                                        <label class="label">&nbsp;</label>
                                        <div centraliza">
                                            <button class="btn-small btn--radius-2 btn--blue" name="confobs" type="button" id="confobs" onClick="gravaobs()">Confirma</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-space ">   
                                <div class="col-0">
                                    <div class="p-t-15 centraliza">
                                        <button class="btn btn--radius-2 btn--blue" name="enviarped" type="button" id="enviarped" onClick="verificapedido()">Finaliza</button>
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

        <input id="pvnumero" type="hidden" name="pvnumero" size="10" onKeyPress="maiusculo()">
        <input id="romcodigo" type="hidden" name="romcodigo" size="2" value="0" >

        <div id="msg" style="visibility: hidden;">&nbsp;<font face="Verdana" size="2">Processando...</font></div>


        <script src="js/romaneiosbaixa.js"></script>

    </body>

</html>