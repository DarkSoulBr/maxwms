<?php
$flagmenu = 1;
require("verifica.php");
require_once("include/config.php");
include 'include/jquerymax.php';
include 'include/cssloja.php';

$usuario = $_SESSION["id_usuario"];

if (isset($_GET["pcnumero"]) && $_GET["pcnumero"] != "") {
    $pcnumero = $_GET["pcnumero"];
} else {
    $pcnumero = 0;
}

if (isset($_GET["valor2"]) && $_GET["valor2"] != "") {
    $valor2 = $_GET["valor2"];
} else {
    $valor2 = 0;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <!-- Required meta tags-->    
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Title Page-->
        <title>Alteração de Pedidos de Compra</title>

        <!-- maxnew CSS-->
        <link href="css/max.css" rel="stylesheet" media="all">
        <style>
            .row-max .cell-max:nth-child(1) {
                width: 100px;
                text-align: center;
                padding-left: 5px;
            }

            .row-max .cell-max:nth-child(2) {
                width: 100px;
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

            .row-max .cell-max:nth-child(7) {
                width: 100px;
                text-align: center;
                padding-right: 5px;
            }

            .row-max .cell-max:nth-child(8) {
                width: 100px;
                text-align: center;
                padding-right: 5px;
            }

            .row-max .cell-max:nth-child(9) {
                width: 100px;
                text-align: center;
                padding-right: 5px;
            }

            .row-max .cell-max:nth-child(10) {
                width: 100px;
                text-align: center;
                padding-right: 5px;
            }

            .row-max .cell-max:nth-child(11) {
                width: 100px;
                text-align: center;
                padding-right: 5px;
            }

            .row-max .cell-max:nth-child(12) {
                width: 50px;
                text-align: center;
                padding-right: 5px;
            }

            a:hover {
                cursor: pointer;
            }            

        </style>
    </head>

    <body onLoad="limpa_form(<?php echo $pcnumero ?>,<?php echo $valor2 ?>,<?php echo MAX_NOVO ?>)">
        <div id="retorno"></div>
        <div id="dialog" style="margin-left: 5px; margin-left: 5px; background:white;"></div>
        <div class="bg-gray p-t-10 p-b-100 font-lucida">
            <div class="wrapper wrapper--w960">
                <div class="card card-4">
                    <div class="card-header">
                        Alteração de Pedidos de Compra
                    </div>
                    <div class="card-body">                    
                        <form name="formulario" method="POST">

                            <div class="row row-space">
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Pedido:</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" name="pcnumero" type="text" id="pcnumero" onkeypress='return SomenteNumero(event)' onFocus="nextfield = 'button_pesquisa'" size="10" style="BACKGROUND-COLOR: #b3c6ff; COLOR: #660000; FONT-WEIGHT: bold;">
                                            <input id="codigo" type="hidden" name="codigo" size="25">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4 centraliza">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">&nbsp;</label>
                                        <button class="btn-small btn--radius-2 btn--blue" name="button_pesquisa" type="button" id="button_pesquisa" onClick="ver()">Pesquisar</button>
                                    </div>
                                </div>                              

                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Emissão</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" name="pcemissao" type="text" id="pcemissao" OnKeyPress="formatar('##/##/####', this)" onFocus="nextfield = 'pcentrega'" onBlur="dataano(this, this.value)" size="10">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Entrega</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" name="pcentrega" type="text" id="pcentrega" OnKeyPress="formatar('##/##/####', this)" onFocus="nextfield = 'opcao'" onBlur="dataano(this, this.value)" size="10">
                                        </div>
                                    </div>
                                </div>

                            </div>  

                            <div class="row row-space">  
                                <div class="col-1">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Opção Fornecedor</label>
                                        <div>
                                            <label class="radio-container m-r-15">Código
                                                <input type="radio" name="opcao" id="opcao1" value="1"  align="absmiddle" onFocus="nextfield = 'codigofornecedor'" checked>
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container m-r-15">Nome
                                                <input type="radio" name="opcao" id="opcao2" value="2"  align="absmiddle" onFocus="nextfield = 'codigofornecedor'" >
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container m-r-15">Razão
                                                <input type="radio" name="opcao" id="opcao3" value="3"  align="absmiddle" onFocus="nextfield = 'codigofornecedor'" >
                                                <span class="checkmark"></span>
                                            </label>                                            
                                        </div>
                                    </div>                                    
                                </div>   


                            </div>    

                            <div class="row row-space">  
                                <div class="col-1">
                                    <div class="input-group-small m-r-15">                                        
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" type="text" name="codigofornecedor" id="codigofornecedor" size="58"  onKeyPress="maiusculo()" onFocus="nextfield = 'pesquisafornecedor'" onBlur="convertField(this);pesquisaf(this.value);">
                                            <input id="fornecedor" type="hidden" name="fornecedor" size="5"  onKeyPress="maiusculo()" onBlur="convertField(this);pesquisafornecedores(this.value);" >
                                        </div>
                                    </div>
                                </div>                                
                            </div>    

                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group-small">
                                        <label class="label-no-bottom">Fornecedor</label>                                        
                                        <div id="resultado_cliente">                                          
                                            <span class="custom-dropdown">  
                                                <select id="pesquisafornecedor" name="pesquisafornecedor" onFocus="nextfield = 'pcprocesso'" onBlur="pesquisacodfor(this.value)"><option id="pesquisafornecedor2" value="0">-- Escolha um Fornecedor --</option></select>                                                
                                            </span>
                                        </div>                                       
                                    </div>
                                </div>
                            </div>  

                            <div class="row row-space">
                                <div class="col-3">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Processo</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" name="pcprocesso" type="text" id="pcprocesso" onKeyPress="maiusculo()" onFocus="nextfield = 'pcchegada'"  onBlur="convertField(this);" size="15" maxlength="30">                                           
                                        </div>
                                    </div>
                                </div>

                                <div class="col-3">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Chegada</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" name="pcchegada" type="text" id="pcchegada" OnKeyPress="formatar('##/##/####', this)" onFocus="nextfield = 'pccontainer'" onBlur="dataano(this, this.value)" size="10">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-3">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Containers</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" name="pccontainer" type="text" id="pccontainer" onkeypress='return SomenteNumero(event)' onFocus="nextfield = 'radio'" size="5">
                                        </div>
                                    </div>
                                </div>

                            </div>  

                            <div class="row row-space">  
                                <div class="col-3">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Tipo de Valor</label>
                                        <div>
                                            <label class="radio-container m-r-15">1 - FOB                                          
                                                <input id="radio1" input type="radio" name="radio" value="radiobutton" onFocus="nextfield = 'comprador'" checked>
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container m-r-15">2 - CIF
                                                <input id="radio2" input type="radio" name="radio" value="radiobutton" onFocus="nextfield = 'comprador'" >
                                                <span class="checkmark"></span>
                                            </label>                                            
                                        </div>
                                    </div>
                                </div> 

                                <div class="col-3">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Comprador</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="comprador" type="text" name="comprador" size="30"  onKeyPress="maiusculo()" onFocus="nextfield = 'comissao'" onBlur="convertField(this);">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-3">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Comissão</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="comissao" type="text" name="comissao" size="5" onBlur="convertField3(this);calc();" onFocus="nextfield = 'condicao'" onKeyPress="maiusculo()">
                                        </div>
                                    </div>
                                </div>
                            </div> 

                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group-small m-r-15">
                                        <label class="label">Condições de Pagamento</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="condicao" type="text" name="condicao" size="58" onKeyPress="maiusculo()" onFocus="nextfield = 'radioa'" onBlur="convertField(this);">
                                        </div>
                                    </div>
                                </div>                              
                            </div> 

                            <div class="row row-space">  
                                <div class="col-1">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Local</label>
                                        <div>
                                            <label class="radio-container m-r-15">1 Filial
                                                <input id="radioa1" input type="radio" name="radioa" value="radiobutton" onFocus="nextfield = 'radiob'">
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container m-r-15">2 Matriz
                                                <input id="radioa2" input type="radio" name="radioa" value="radiobutton" onFocus="nextfield = 'radiob'">
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container m-r-15">3 CD-RE
                                                <input id="radioa3" input type="radio" name="radioa" value="radiobutton" onFocus="nextfield = 'radiob'">
                                                <span class="checkmark"></span>
                                            </label> 
                                            <label class="radio-container m-r-15">4 CD-VIX
                                                <input id="radioa4" input type="radio" name="radioa" value="radiobutton" onFocus="nextfield = 'radiob'">
                                                <span class="checkmark"></span>
                                            </label> 
                                            <label class="radio-container m-r-15">5 CD-SP
                                                <input id="radioa5" input type="radio" name="radioa" value="radiobutton" onFocus="nextfield = 'radiob'" checked>
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container m-r-15">6 FUN
                                                <input id="radioa6" input type="radio" name="radioa" value="radiobutton" onFocus="nextfield = 'radiob'" disabled>
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>                                    
                                </div> 
                            </div>

                            <div class="row row-space">  
                                <div class="col-1">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Tipo de Pedido</label>
                                        <div>
                                            <label class="radio-container m-r-15">1 - Compra
                                                <input id="radiob1" input type="radio" name="radiob" value="radiobutton" onClick="pvenda(1)" onFocus="nextfield = 'vendax'" checked>
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container m-r-15">2 - Retorno de Conserto
                                                <input id="radiob2" input type="radio" name="radiob" value="radiobutton" onClick="pvenda(2)" onFocus="nextfield = 'vendax'">
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container m-r-15">3 - Bonificação
                                                <input id="radiob3" input type="radio" name="radiob" value="radiobutton" onClick="pvenda(3)" onFocus="nextfield = 'vendax'">
                                                <span class="checkmark"></span>
                                            </label>                                           
                                        </div>
                                    </div>                                    
                                </div> 
                            </div>                            

                            <div class="row row-space">
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Pedido de Venda</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="venda" type="text" name="venda" size="10" onKeyPress="maiusculo()"  onFocus="nextfield = 'observacao1'" onBlur="convertField3(this);vervenda();">
                                        </div>
                                    </div>
                                </div>   

                                <div class="col-2">
                                    <div class="input-group-small m-r-45">  
                                        <label class="label">Desconto Padrão:</label>
                                        <div>
                                            <label class="radio-container m-r-15">Sim
                                                <input id="radiodp1" input type="radio" name="radiodp" value="radiobutton" onFocus="nextfield = 'observacao1'" >
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container m-r-15">Não
                                                <input id="radiodp2" input type="radio" name="radiodp" value="radiobutton" onFocus="nextfield = 'observacao1'" checked>
                                                <span class="checkmark"></span>
                                            </label>                                                                                   
                                        </div>
                                    </div>                                  
                                </div> 
                            </div>             

                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group-small m-r-15">
                                        <label class="label">Observações</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="observacao1" type="text" name="observacao1" size="58" onKeyPress="maiusculo()" onFocus="nextfield = 'observacao2'" onBlur="convertField(this);" maxlength="70">
                                        </div>
                                    </div>
                                </div>                              
                            </div>             

                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group-small m-r-15">                                        
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="observacao2" type="text" name="observacao2" size="58" onKeyPress="maiusculo()" onFocus="nextfield = 'observacao3'" onBlur="convertField(this);" maxlength="70">
                                        </div>
                                    </div>
                                </div>                              
                            </div>

                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group-small m-r-15">                                        
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="observacao3" type="text" name="observacao3" size="58" onKeyPress="maiusculo()" onFocus="nextfield = 'observacao4'" onBlur="convertField(this);" maxlength="70">
                                        </div>
                                    </div>
                                </div>                              
                            </div>

                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group-small m-r-15">                                        
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="observacao4" type="text" name="observacao4" size="58" onKeyPress="maiusculo()" onFocus="nextfield = 'observacao5'" onBlur="convertField(this);" maxlength="70">
                                        </div>
                                    </div>
                                </div>                              
                            </div>

                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group-small m-r-15">                                        
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="observacao5" type="text" name="observacao5" size="58" onKeyPress="maiusculo()" onFocus="nextfield = 'codigoproduto'" onBlur="convertField(this);" maxlength="70">
                                        </div>
                                    </div>
                                </div>                              
                            </div>

                            <div class="row row-space m-b-25"></div>
                            <hr>
                            <div class="row row-space m-b-25"></div>

                            <div class="row row-space">  
                                <div class="col-2">
                                    <div class="input-group-small m-r-45"> 
                                        <label class="label">Código</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="codigoproduto" type="text" name="codigoproduto" size="5" OnKeyPress="formatar('####-#', this)" onFocus="nextfield = 'produto'" onBlur="pesquisacodigo(this.value)">
                                            <input id="profinal" type="hidden" name="profinal" size="10">
                                            <input id="proipi" type="hidden" name="proipi" size="10">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">  
                                        <label class="label">Produto</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="produto" type="text" name="produto" size="39" onKeyPress="maiusculo()" onFocus="nextfield = 'pesquisaproduto'" onBlur="convertField(this);pesquisaprodutos(this.value);">
                                        </div>
                                    </div>                                  
                                </div> 
                            </div>

                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group-small">
                                        <label class="label-no-bottom">Pesquisa</label>                                        
                                        <div id="resultado_cliente">                                          
                                            <span class="custom-dropdown">  
                                                <select id="pesquisaproduto" name="pesquisaproduto" onFocus="nextfield = 'quantidade'" onBlur="pesquisacod(this.value)"><option id="pesquisaproduto2" value="0">-- Escolha um Produto --</option></select>                                                
                                            </span>
                                        </div>                                       
                                    </div>
                                </div>
                            </div>  

                            <div class="row row-space">  
                                <div class="col-5">
                                    <div class="input-group-small m-r-45"> 
                                        <label class="label">Quantidade</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="quantidade" onFocus="nextfield = 'buttonx'"  type="text" name="quantidade" size="5">                                            
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row row-space m-b-25"></div>
                            <div class="row row-space">
                                <div class="col-2 centraliza">
                                    <button class="btn-small btn--radius-2 btn--blue" name="button" type="button" id="buttonx" onClick="incluir()" disabled>Incluir</button>
                                </div> 
                                <div class="col-2 centraliza">
                                    <button class="btn-small btn--radius-2 btn--green" name="button2" type="button" id="button2" onClick="entrega()" disabled>Entrega</button>
                                </div>
                            </div>   

                            <div class="row row-space m-b-25"></div>

                            <div class="result" id="resultado"></div>

                            <div class="row row-space m-b-25"></div>
                            <hr>
                            <div class="row row-space m-b-25"></div>

                            <div class="row row-space">  
                                <div class="col-5">
                                    <div class="input-group-small m-r-45"> 
                                        <label class="label">IPI</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" name="ipi" type="text" id="ipi" size="9" disabled>                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="col-5">
                                    <div class="input-group-small m-r-45"> 
                                        <label class="label">Desconto %</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" name="percdesc" type="text" id="percdesc" onBlur="convertField3(this);calc2();"  size="9">                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="col-5">
                                    <div class="input-group-small m-r-45"> 
                                        <label class="label">Desconto</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" name="pcdesconto" type="text" onBlur="convertField3(this);calc3();" id="pcdesconto"  size="9">                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="col-5">
                                    <div class="input-group-small m-r-45"> 
                                        <label class="label">Sub-Total</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" name="pctotal" type="text" id="pctotal"  size="9" disabled="disabled">                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="col-5">
                                    <div class="input-group-small m-r-45"> 
                                        <label class="label">Total</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" name="pctotal2" type="text" id="pctotal2"  size="9" disabled="disabled">                                            
                                        </div>
                                    </div>
                                </div>

                            </div>


                            <div class="row row-space">  
                                <div class="col-5">
                                    <div class="input-group-smal"> 
                                        <label class="label">Opção</label>
                                        <div>
                                            <label class="radio-container m-r-15">Dia
                                                <input name="pvtipo" id="pvtipo1" type="radio" value="1" onClick="tipodata(this.value)" checked>
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container m-r-15">Data
                                                <input name="pvtipo" id="pvtipo2" type="radio" value="2" onClick="tipodata(this.value)">
                                                <span class="checkmark"></span>
                                            </label>                                                                                   
                                        </div>
                                    </div>
                                </div>

                                <div class="col-5">
                                    <div class="input-group-small m-r-45"> 
                                        <label class="label">Parcelas</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" name="pvparcelas" type="text" id="pvparcelas"  onKeyPress="maiusculo()" onBlur="parcelas(this.value)" size="10">                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="col-5">
                                    <div class="input-group-small m-r-45"> 
                                        <label class="label">Dias</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" name="dia1" type="text" id="dia1" onKeyPress="maiusculo()" onBlur="convertField3(this);" size="2" disabled>                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="col-5">
                                    <div class="input-group-small m-r-45"> 
                                        <label class="label">Datas</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" name="pvdata1" type="text" id="pvdata1" OnKeyPress="formatar('##/##/####', this)" onBlur="dataano(this, this.value)" size="10" disabled>                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="col-5">
                                    <div class="input-group-small m-r-45"> 
                                        <label class="label">Valores</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" name="parc1" type="text" id="parc1" size="10" onBlur="convertField3(this);" onKeyPress="return Tecla(event);" disabled >                                            
                                        </div>
                                    </div>
                                </div>

                            </div>                            

                            <div class="row row-space">  
                                <div class="col-5">                                    
                                </div>

                                <div class="col-5">                                    
                                </div>

                                <div class="col-5">
                                    <div class="input-group-small m-r-45">                                        
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" name="dia2" type="text" id="dia2" onKeyPress="maiusculo()" onBlur="convertField3(this);" size="2" disabled>                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="col-5">
                                    <div class="input-group-small m-r-45">
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" name="pvdata2" type="text" id="pvdata2" OnKeyPress="formatar('##/##/####', this)" onBlur="dataano(this, this.value)" size="10" disabled>                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="col-5">
                                    <div class="input-group-small m-r-45">                                        
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" name="parc2" type="text" id="parc2" size="10" onBlur="convertField3(this);" onKeyPress="return Tecla(event);" disabled >                                            
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row row-space">  
                                <div class="col-5">                                    
                                </div>

                                <div class="col-5">                                    
                                </div>

                                <div class="col-5">
                                    <div class="input-group-small m-r-45">                                        
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" name="dia3" type="text" id="dia3" onKeyPress="maiusculo()" onBlur="convertField3(this);" size="2" disabled>                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="col-5">
                                    <div class="input-group-small m-r-45">
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" name="pvdata3" type="text" id="pvdata3" OnKeyPress="formatar('##/##/####', this)" onBlur="dataano(this, this.value)" size="10" disabled>                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="col-5">
                                    <div class="input-group-small m-r-45">                                        
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" name="parc3" type="text" id="parc3" size="10" onBlur="convertField3(this);" onKeyPress="return Tecla(event);" disabled >                                            
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row row-space">  
                                <div class="col-5">                                    
                                </div>

                                <div class="col-5">                                    
                                </div>

                                <div class="col-5">
                                    <div class="input-group-small m-r-45">                                        
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" name="dia4" type="text" id="dia4" onKeyPress="maiusculo()" onBlur="convertField3(this);" size="2" disabled>                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="col-5">
                                    <div class="input-group-small m-r-45">
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" name="pvdata4" type="text" id="pvdata4" OnKeyPress="formatar('##/##/####', this)" onBlur="dataano(this, this.value)" size="10" disabled>                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="col-5">
                                    <div class="input-group-small m-r-45">                                        
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" name="parc4" type="text" id="parc4" size="10" onBlur="convertField3(this);" onKeyPress="return Tecla(event);" disabled >                                            
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row row-space">  
                                <div class="col-5">                                    
                                </div>

                                <div class="col-5">                                    
                                </div>

                                <div class="col-5">
                                    <div class="input-group-small m-r-45">                                        
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" name="dia5" type="text" id="dia5" onKeyPress="maiusculo()" onBlur="convertField3(this);" size="2" disabled>                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="col-5">
                                    <div class="input-group-small m-r-45">
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" name="pvdata5" type="text" id="pvdata5" OnKeyPress="formatar('##/##/####', this)" onBlur="dataano(this, this.value)" size="10" disabled>                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="col-5">
                                    <div class="input-group-small m-r-45">                                        
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" name="parc5" type="text" id="parc5" size="10" onBlur="convertField3(this);" onKeyPress="return Tecla(event);" disabled >                                            
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row row-space">  
                                <div class="col-5">                                    
                                </div>

                                <div class="col-5">                                    
                                </div>

                                <div class="col-5">
                                    <div class="input-group-small m-r-45">                                        
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" name="dia6" type="text" id="dia6" onKeyPress="maiusculo()" onBlur="convertField3(this);" size="2" disabled>                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="col-5">
                                    <div class="input-group-small m-r-45">
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" name="pvdata6" type="text" id="pvdata6" OnKeyPress="formatar('##/##/####', this)" onBlur="dataano(this, this.value)" size="10" disabled>                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="col-5">
                                    <div class="input-group-small m-r-45">                                        
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" name="parc6" type="text" id="parc6" size="10" onBlur="convertField3(this);" onKeyPress="return Tecla(event);" disabled >                                            
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row row-space m-b-25"></div>

                            <div class="row row-space">
                                <div class="col-3 centraliza">
                                    <button class="btn btn--radius-2 btn--blue" name="button2" type="button" id="botao" onClick="valida_form()" disabled>Incluir</button>
                                </div> 
                                <div class="col-3 centraliza">
                                    <button class="btn btn--radius-2 btn--green" type="button" id="botao2" onClick="limpa_form(0)">Limpar</button>
                                </div>
                                <div class="col-3 centraliza">
                                    <button class="btn btn--radius-2 btn--red" type="button" name="botao3" id="botao3" onclick="verifica()" disabled>Excluir</button>
                                </div>                                
                            </div>    

                            <div style ="display:none">
                                <div id="msg" style="visibility: hidden;">&nbsp;<font face="Verdana" size="2">Processando...</font></div>
                                <input type="hidden" name="usuario" id="usuario" size="10"  value='<? echo $usuario; ?>'>                                
                                <input name="hidden" type="hidden" id="acao" value="inserir">
                                <button class="btn btn--radius-2 btn--green" type="button" name="importaPedido" id="importaPedido" onclick="importarPedido()">Importar</button>
                            </div>

                    </div>
                </div>

            </div>
        </div>

        <script src="js/alterarpedcompra.js"></script>
        <script src="js/geral.js"></script>
        <script type="text/javascript">
                                    var $a = jQuery.noConflict()
        </script>

    </body>

</html>