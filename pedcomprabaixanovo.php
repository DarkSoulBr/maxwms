<?php
$flagmenu = 1;
require("verifica.php");
require_once("include/config.php");
include 'include/jquerymax.php';
include 'include/cssloja.php';

$usuario = $_SESSION["id_usuario"];

?>


<!DOCTYPE html>
<html>
    <head>
        <!-- Required meta tags-->    
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Title Page-->
        <title>Baixa de Pedidos de Compra</title>

        <!-- maxnew CSS-->
        <link href="css/max.css" rel="stylesheet" media="all">
        <style>
            .row-max .cell-max:nth-child(1) {
                width: 70px;
                text-align: center;
                padding-left: 5px;
            }

            .row-max .cell-max:nth-child(2) {
                width: 70px;
                text-align: center;
                padding-right: 5px;
            }

            .row-max .cell-max:nth-child(3) {
                width: 80px;
                text-align: center;
                padding-right: 5px;
            }

            .row-max .cell-max:nth-child(4) {
                width: 50px;
                text-align: center;
                padding-right: 5px;
            }

            .row-max .cell-max:nth-child(5) {
                width: 50px;
                text-align: center;
                padding-right: 5px;
            }

            .row-max .cell-max:nth-child(6) {
                width: 60px;
                text-align: center;
                padding-right: 5px;
            }

            .row-max .cell-max:nth-child(7) {
                width: 60px;
                text-align: center;
                padding-right: 5px;
            }

            .row-max .cell-max:nth-child(8) {
                width: 60px;
                text-align: center;
                padding-right: 5px;
            }

            .row-max .cell-max:nth-child(9) {
                width: 60px;
                text-align: center;
                padding-right: 5px;
            }

            .row-max .cell-max:nth-child(10) {
                width: 60px;
                text-align: center;
                padding-right: 5px;
            }

            .row-max .cell-max:nth-child(11) {
                width: 60px;
                text-align: center;
                padding-right: 5px;
            }

            .row-max .cell-max:nth-child(12) {
                width: 60px;
                text-align: center;
                padding-right: 5px;
            }
            
            .row-max .cell-max:nth-child(13) {
                width: 125px;
                text-align: center;
                padding-right: 5px;
            }
            
            .row-max .cell-max:nth-child(14) {
                width: 125px;
                text-align: center;
                padding-right: 5px;
            }
            
            .row-max .cell-max:nth-child(15) {
                width: 80px;
                text-align: center;
                padding-right: 5px;
            }
            
            .row-max .cell-max:nth-child(16) {
                width: 50px;
                text-align: center;  
                padding-right: 5px;
            }

            a:hover {
                cursor: pointer;
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
                        Baixa de Pedidos de Compra
                    </div>
                    <div class="card-body">                    
                        <form name="formulario" method="POST">

                            <div class="row row-space">
                                <div class="col-3">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Pedido:</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" name="pcnumero" type="text" id="pcnumero" onKeyPress="maiusculo()" onFocus="nextfield = 'button_pesquisa'" size="10"  style="BACKGROUND-COLOR: #b3c6ff; COLOR: #660000; FONT-WEIGHT: bold;">
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
                                        <label class="label">Data</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="data" type="text" name="data" size="10" OnKeyPress="formatar('##/##/####', this)" onBlur="dataano(this, this.value)"  onFocus="nextfield = 'datanota'" disabled="disabled">
                                        </div>
                                    </div>
                                </div>
                               
                            </div> 
                            
                            <div class="row row-space">
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Fornecedor</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="fornguerra" type="text" name="fornguerra" size="65" onKeyPress="maiusculo()" disabled="disabled">
                                            <input id="codigo2" type="hidden" name="codigo2" size="25">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Comprador</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="comprador" type="text" name="comprador" size="65" onKeyPress="maiusculo()" disabled="disabled">
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            
                            <div class="row row-space">  
                                <div class="col-3">
                                    <div class="input-group-small">
                                        <label class="label">ICMS / IPI</label>
                                        <div>
                                            <label class="radio-container m-r-15">Padrão
                                                <input type="radio" name="radioperc" id="radioperc1" value="radiobutton" onClick="verificaperc1();" checked>
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container m-r-15">Por Item
                                                <input type="radio" name="radioperc" id="radioperc2" value="radiobutton" onClick="verificaperc2();">
                                                <span class="checkmark"></span>
                                            </label>                                                                                  
                                        </div>
                                    </div>                                    
                                </div>   
                                
                                <div class="col-3">
                                    <div class="input-group-small">
                                        <label class="label">WMS</label>
                                        <div>
                                            <label class="radio-container m-r-15">Sim
                                                <input type="radio" name="radiowms" id="radiowms1" value="radiobutton" onClick="verificawms1();" checked>
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container m-r-15">Não
                                                <input type="radio" name="radiowms" id="radiowms2" value="radiobutton" onClick="verificawms2();">
                                                <span class="checkmark"></span>
                                            </label>                                                                                  
                                        </div>
                                    </div>                                    
                                </div> 
                                
                                <div class="col-3">
                                    <div class="input-group-small m-r-45" id="linhasenha" style="display: none;">
                                        <label class="label">Senha</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" name="adm" type="password" id="adm" onBlur="verificasenha(this.value);" size="10">
                                            <input type="hidden" name="usuario" id="usuario" size="10"  value='<? echo $usuario; ?>'>
                                        </div>
                                    </div>
                                </div>
                                
                            </div> 
                            
                            <div class="row row-space">
                                 <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Data Nota</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="datanota" type="text" name="datanota" size="10" OnKeyPress="formatar('##/##/####', this)" onBlur="dataano(this, this.value)" onFocus="nextfield = 'nota'">
                                        </div>
                                    </div>
                                </div>
                               
                                 <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Nota</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="nota" type="text" name="nota" size="5" onKeyPress="maiusculo()" onBlur="focoserie()" onFocus="nextfield = 'serie'">
                                        </div>
                                    </div>
                                </div>                         

                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Série</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="serie" type="text" name="serie" size="1" onKeyPress="maiusculo()" onBlur="verificaexistenf(nota.value, codigo2.value, this.value);" onFocus="nextfield = 'cfop'" value="1">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">CFOP</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="cfop" type="text" name="cfop" size="10" maxlength="4" onKeyPress="maiusculo()" onFocus="nextfield = 'produtos'">
                                        </div>
                                    </div>
                                </div>
                               
                            </div> 
                            
                            <div class="row row-space">
                                 <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Total Produtos</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="produtos" type="text" name="produtos" size="10" onKeyPress="maiusculo()" onBlur="formatprod(this.value, this.id);sugeretotal(this.value);" onFocus="nextfield = 'icm'">
                                        </div>
                                    </div>
                                </div>
                               
                                 <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">% ICMS</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="icm" type="text" name="icm" size="9" onKeyPress="maiusculo()" onBlur="format(this.value, this.id)" onFocus="nextfield = 'baseicm'">
                                        </div>
                                    </div>
                                </div>                         

                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Base ICMS</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="baseicm" type="text" name="baseicm" size="10" onKeyPress="maiusculo()" onBlur="formatbase(this.value, this.id, icm.value)" onFocus="nextfield = 'valoricm'">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Valor ICMS</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="valoricm" type="text" name="valoricm" size="10" onKeyPress="maiusculo()" onBlur="format(this.value, this.id)" onFocus="nextfield = 'isentas'">
                                        </div>
                                    </div>
                                </div>
                               
                            </div> 
                            
                            <div class="row row-space">
                                 <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Isentas</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="isentas" type="text" name="isentas" size="9" onKeyPress="maiusculo()" onBlur="format(this.value, this.id)" onFocus="nextfield = 'outras'">
                                        </div>
                                    </div>
                                </div>
                               
                                 <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Outras</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="outras" type="text" name="outras" size="10" onKeyPress="maiusculo()" onBlur="format(this.value, this.id)" onFocus="nextfield = 'baseipi'">
                                        </div>
                                    </div>
                                </div>                         

                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Base IPI</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="baseipi" type="text" name="baseipi" size="10" onKeyPress="maiusculo()" onBlur="format(this.value, this.id)" onFocus="nextfield = 'percipi'">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">% IPI</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="percipi" type="text" name="percipi" size="9" onKeyPress="maiusculo()" onBlur="formatipi(this.value, this.id, baseipi.value)" onFocus="nextfield = 'valoripi'">
                                        </div>
                                    </div>
                                </div>
                               
                            </div> 
                            
                            <div class="row row-space">
                                 <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Valor IPI</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="valoripi" type="text" name="valoripi" size="10" onKeyPress="maiusculo()" onBlur="format(this.value, this.id), total1();" onFocus="nextfield = 'totalnota'">
                                        </div>
                                    </div>
                                </div>
                               
                                 <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Total Nota</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="totalnota" type="text" name="totalnota" size="10" onKeyPress="maiusculo()" onBlur="format(this.value, this.id)" onFocus="nextfield = 'volumes'">
                                        </div>
                                    </div>
                                </div>                         

                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Volumes</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="volumes" type="text" name="volumes" size="9" onKeyPress="maiusculo()" onFocus="nextfield = 'outrasipi'">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Outras IPI</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="outrasipi" type="text" name="outrasipi" size="10" onKeyPress="maiusculo()" onBlur="format(this.value, this.id)" onFocus="nextfield = 'observacoes'">
                                        </div>
                                    </div>
                                </div>
                               
                            </div> 
                            
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group-small m-r-15">
                                        <label class="label">Observações</label>
                                        <div class="input-group-small-icon">                                            
                                            <textarea class="textarea--style-4" name="observacoes" id="observacoes" onkeyup="this.value = this.value.toUpperCase()" onBlur="convertField(this);" ></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row row-space">
                                <div class="col-2">
                                    <div class="input-group-small">
                                        <label class="label-no-bottom">Estoque</label>                                        
                                        <div>                                          
                                            <span class="custom-dropdown">
                                                <select name="deposito"><option id="deposito" value="0">______________________</option></select>                                                
                                            </span>
                                        </div>                                       
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="input-group-small">
                                        <label class="label-no-bottom">Tipo Baixa</label>                                        
                                        <div>                                          
                                            <span class="custom-dropdown">  
                                                <select name="tipobaixa"><option id="tipobaixa" value="0">______________________</option></select>
                                            </span>
                                        </div>                                       
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row row-space">  
                                <div class="col-3">
                                    <div class="input-group-small">
                                        <label class="label">Substituição Tributaria</label>
                                        <div>
                                            <label class="radio-container m-r-15">Sim
                                                <input type="radio" name="radiost" id="radiost1" value="radiobutton" onClick="verificast1();">
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container m-r-15">Não
                                                <input type="radio" name="radiost" id="radiost2" value="radiobutton" onClick="verificast2();" checked>
                                                <span class="checkmark"></span>
                                            </label>                                                                                  
                                        </div>
                                    </div>                                    
                                </div>                                
                            </div>
                            
                            <div class="row row-space">
                                 <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">CFOP</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="cfop2" type="text" name="cfop2" size="10" onKeyPress="maiusculo()" onFocus="nextfield = 'basesubst'" disabled>
                                        </div>
                                    </div>
                                </div>
                               
                                 <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Base</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="basesubst" type="text" name="basesubst" size="10" onKeyPress="maiusculo()" onBlur="format(this.value, this.id)" onFocus="nextfield = 'valorsubst'" disabled>
                                        </div>
                                    </div>
                                </div>                         

                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Valor</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="valorsubst" type="text" name="valorsubst" size="10" onKeyPress="maiusculo()" onBlur="format(this.value, this.id)" onFocus="nextfield = 'perciva'" disabled>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">% IVA</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="perciva" type="text" name="perciva" size="10" onKeyPress="maiusculo()" onBlur="format(this.value, this.id), alteraiva(this.value)" disabled>
                                        </div>
                                    </div>
                                </div>                               
                            </div> 
                            
                            <div class="row row-space m-b-25"></div>
                            
                            <div class="row row-space">
                                 <div class="col-4 centraliza">
                                    <button class="btn-medium btn--radius-2 btn--blue" type="button" id="button" onClick="baixa()" disabled>Confirma</button>
                                </div>
                                <div class="col-4 centraliza">
                                    <button class="btn-medium btn--radius-2 btn--green" name="button2" type="button" id="button2" onClick="todos()" disabled>Baixa Total</button>
                                </div>                                
                                <div class="col-4 centraliza">
                                    <button class="btn-medium btn--radius-2 btn--purple" type="button" name="button3" id="button3" onclick="nfe()" disabled>NF-e</button>
                                </div>
                                <div class="col-4 centraliza">
                                    <button class="btn-medium btn--radius-2 btn--red" type="button" name="button4" id="button4" onclick="cancelar()">Cancela</button>
                                </div>
                            </div>
                            
                            <div class="row row-space m-b-25"></div>
                            <hr>
                            <div class="row row-space m-b-25"></div>
                            
                            <div class="row row-space">
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Produto</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" name="localiza" type="text" id="localiza" size="9" OnKeyPress="formatar('####-#', this)">                                            
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="col-4 centraliza">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">&nbsp;</label>
                                        <button class="btn-small btn--radius-2 btn--blue" name="button_pesquisa_prod" type="button" id="button_pesquisa_prod" onClick="localizar(this.form.localiza.value)"; disabled>Pesquisar</button>
                                    </div>
                                </div>                              

                                <div class="col-4">
                                    <div class="input-group-small">
                                        <label class="label-no-bottom">Classificação Fiscal</label>                                        
                                        <div>                                          
                                            <span class="custom-dropdown">  
                                                <select name="listfiscais"><option id="listfiscais" value="0">_______</option></select>
                                            </span>
                                        </div>                                       
                                    </div>
                                </div>
                                
                                <div class="col-4 centraliza">
                                    <div class="input-group-small">
                                        <label class="label">&nbsp;</label>
                                        <button class="btn-small btn--radius-2 btn--blue" name="buttoncf" type="button" id="buttoncf" onClick="verificacf()"; disabled>Confirma</button>
                                    </div>
                                </div>
                               
                            </div> 
                            
                            <div style ="display:none">
                                <select name="palm"><option id="palm" value="0">______________________</option></select>
                                <input name="buttonpalm" type="button" id="buttonpalm" onClick="verificapalm()" value="Palm">
                                <div id="msg" style="visibility: hidden;">&nbsp;<font face="Verdana" size="2">Processando...</font></div>
                            </div>                         

                    </div>
                </div>

            </div>
            
            <div class="row row-space m-b-25"></div>
            
            <div class="wrapper wrapper--w1200">
                <div class="result" id="resultado"></div>
            </div>
        </div>

        <script src="js/pedcomprabaixanovo.js"></script>        
        <script type="text/javascript">
            var $a = jQuery.noConflict()
        </script>

    </body>

</html>

