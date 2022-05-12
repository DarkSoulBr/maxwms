<?php
$flagmenu = 3;
require("verifica.php");

//Verifica se a opção existe no Cadastros de Opção
$opcao = 'CONFERENCIA MANUAL';
$pagina = 'conferencia.php';
$modulo = 3;  //Logistica
$sub = 12;  //Conferencia
$usuario = $_SESSION["id_usuario"];

if ($_GET["pvnumero"] != "") {
    $codigo = $_GET["pvnumero"];
} else {
    $codigo = 0;
}
if ($_GET["conferente"] != "") {
    $conferente = $_GET["conferente"];
} else {
    $conferente = 0;
}
if ($_GET["separador"] != "") {
    $separador = $_GET["separador"];
} else {
    $separador = 0;
}

if ($_GET["sepinicio"] != "") {
    $sepinicio = $_GET["sepinicio"];
} else {
    $sepinicio = '';
}
if ($_GET["sepfim"] != "") {
    $sepfim = $_GET["sepfim"];
} else {
    $sepfim = '';
}
if ($_GET["conini"] != "") {
    $conini = $_GET["conini"];
} else {
    $conini = '';
}

if ($sepinicio == 0) {
    $sepinicio = '';
}
if ($sepfim == 0) {
    $sepfim = '';
}
if ($conini == 0) {
    $conini = '';
}

$ac02 = $_SESSION["acesso02"];
?>
<!DOCTYPE html>
<html>
    <head>
        <!-- Required meta tags-->    
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Title Page-->
        <title>Conferência de Pedidos de Venda</title>        

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
        </style>        
    </head>

    <body onLoad="ver(vcodigo, vconferente, vseparador, vac02, vsepinicio, vsepfim)";>
        <div id="retorno"></div>
        <div id="dialog" style="margin-left: 5px; margin-left: 5px;"></div>
        <div class="bg-gray p-t-10 p-b-100 font-lucida">
            <div class="wrapper wrapper--w780">
                <div class="card card-4">
                    <div class="card-header">
                        Conferência de Pedidos de Venda
                    </div>
                    <div class="card-body">                    
                        <form name="formulario">
                            <div class="row row-space ">                                
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Pedido</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" name="pvnumero" type="text" id="pvnumero" onKeyPress="maiusculo()" onBlur="dadosverifica(this.value);" size="10">
                                        </div>
                                    </div>
                                </div>                                             
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Emissão</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" name="pvemissao" type="text" id="pvemissao" onKeyPress="maiusculo()" size="10" disabled="disabled">
                                        </div>
                                    </div>
                                </div>                        
                            </div>
                            <div class="row row-space ">                                
                                <div class="col-1">
                                    <div class="input-group-small m-r-15">
                                        <label class="label">Cliente</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="clinguerra" type="text" name="clinguerra" size="58" onKeyPress="maiusculo()" disabled="disabled">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-space ">
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Vendedor</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="vennguerra" type="text" name="vennguerra" size="58" onKeyPress="maiusculo()" disabled="disabled" >
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Cond. Con</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="pvcondcon" type="text" name="pvcondcon" size="58" onKeyPress="maiusculo()" disabled="disabled" >
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <div class="row row-space" style="display: none">
                                <div class="col-1">
                                    <div class="input-group-small m-r-15">
                                        <label class="label">Obs.</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="pvobserva" type="text" name="pvobserva" size="58" onKeyPress="maiusculo()" disabled="disabled" >
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <div class="row row-space">
                                <div class="col-2">
                                    <div class="input-group-small">
                                        <label class="label">Conferente</label>                                        
                                        <div>                                          
                                            <span class="custom-dropdown">
                                                <select name="conferente" >
                                                    <option id="conferente" value="0">____</option>                                                
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
                                </div>                                

                                <div class="col-2">
                                    <div class="input-group-small">
                                        <label class="label">Separador</label>                                        
                                        <div>                                          
                                            <span class="custom-dropdown">
                                                <select name="separador">
                                                    <option id="separador" value="0">____</option>                                                
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                            <div class="row row-space ">                                
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Inicio Sep.</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" name="sepinicio" type="text" id="sepinicio" maxlength="5" OnKeyPress="formatar('##:##', this)" size="6">
                                        </div>
                                    </div>
                                </div>                                             
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Fim Sep.</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" name="sepfim" type="text" id="sepfim" maxlength="5" OnKeyPress="formatar('##:##', this)" size="6">
                                        </div>
                                    </div>
                                </div>                                                                    
                            </div>
                            <div class="row row-space ">                                
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Item</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="item" type="text" name="item" size="25" value="1" onKeyPress="maiusculo()" disabled="disabled">
                                        </div>
                                    </div>
                                </div>                                             
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Digita QTD</label>
                                        <div>
                                            <label class="radio-container m-r-15">Sim                                            
                                                <input id="radio1" name="radiobutton" type="radio" value="radiobutton">
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container">Não
                                                <input id="radio2" name="radiobutton" type="radio" value="radiobutton" checked>
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>                                   
                            </div>
                            <div class="row row-space ">                                
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">C. Barra</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="cbarra" type="text" name="cbarra" size="58"  onKeyPress="entertab('codigoproduto')"  onBlur="dadospesquisacbarras(this.value);">
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Código</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="codigoproduto" type="text" name="codigoproduto" size="5" onfocus="funcaopress()" OnKeyPress="formatar('####-#', this)" onBlur="dadospesquisapertence(this.value)">
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <div class="row row-space ">
                                <div class="col-1">
                                    <div class="input-group-small m-r-15">
                                        <label class="label">Produto</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="produto" type="text" name="produto" size="39" onKeyPress="maiusculo()" onBlur="convertField(this);pesquisaprodutos(this.value);">
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group-small">
                                        <label class="label">Pesquisa</label>                                        
                                        <div>                                          
                                            <span class="custom-dropdown">
                                                <select name="pesquisaproduto" onBlur="pesquisacod(this.value)">
                                                    <option  id="pesquisaproduto2" value="0">Faça a Pesquisa</option>                                                
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                            <div class="row row-space">                                
                                <div class="col-2">
                                    <div class="input-group-small">
                                        <label class="label">Quant.</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="quant" type="text" name="quant" size="5" onKeyPress="maiusculo()">
                                        </div>
                                    </div>
                                </div>                                
                                <div class="col-3">
                                    <div class="input-group-small">
                                        <label class="label">&nbsp;</label>
                                        <div class="input-group-icon centraliza">
                                            <button class="btn-small btn--radius-2 btn--blue" name="button" type="button" id="button" onBlur="funcaopress()" onClick="dadospesquisaconfirma()" onKeyDown="enterclik(event, this)">Incluir</button>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                            <div class="row row-space ">    
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Desconto</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="pvperdesc" type="text" name="pvperdesc" size="15" onKeyPress="maiusculo()" disabled="disabled">
                                        </div>
                                    </div>
                                </div>                                             
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Total Pedido</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" name="pvvalor" type="text" id="pvvalor" size="15" onKeyPress="maiusculo()" disabled="disabled">
                                        </div>
                                    </div>
                                </div>  
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Valor Desconto</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" name="pvvaldesc" type="text" id="pvvaldesc" size="15" onKeyPress="maiusculo()" disabled="disabled">
                                        </div>
                                    </div>
                                </div>                                             
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Total c/ Desc.</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" name="totalcomdesconto" type="text" id="totalcomdesconto" size="15" onKeyPress="maiusculo()"  disabled="disabled">
                                        </div>
                                    </div>
                                </div>                                                                   
                            </div>
                            <div class="row row-space ">
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Tipo Pedido</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="pvtipoped" type="text" name="pvtipoped" size="38" onKeyPress="maiusculo()" disabled="disabled">
                                        </div>
                                    </div>
                                </div>                                             
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Volumes</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="pvvolumes" type="text" name="pvvolumes" size="4" onKeyPress="return numbersOnly(this, event)" onBlur="finaliza()" disabled="disabled">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-space">                                
                                <div class="col-4">
                                    <div class="p-t-15 centraliza">
                                        <button class="btn btn--radius-2 btn--blue" type="button" id="botao" onClick=dadosverifica3(pvnumero.value) onKeydown="enterclik(event, this)">Verifica</button>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="p-t-15 centraliza">                                        
                                        <button class="btn btn--radius-2 btn--green" type="button" id="botao2" onClick=dadosverifica2(pvnumero.value) onKeydown="enterclik(event, this)">Confirma</button>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="p-t-15 centraliza">                                        
                                        <button class="btn btn--radius-2 btn--red" type="button" id="botao3" onClick=dadosverifica4(pvnumero.value) onKeydown="enterclik(event, this)" disabled>Confere</button>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Adm.</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" name="adm" type="password" id="adm" onBlur="verificasenha(this.value);" size="10">
                                        </div>
                                    </div>
                                </div>
                            </div>  								
                        </form>
                    </div>
                </div>
            </div>    
        </div>

        <input id="codigo" type="hidden" name="codigo" size="25">

        <script src="js/conferencia.js"></script>

        <script language="JavaScript1.2">
                                                //window.onload=dadospesquisaconferente;
                                                confere = 0;
                                                codigoproduto = 0;
                                                estoque = 0;
                                                pvcconfere = 0;

                                                vcodigo =<?= $codigo ?>;
                                                vconferente =<?= $conferente ?>;
                                                vseparador =<?= $separador ?>;

                                                vsepinicio = "<?= $sepinicio ?>";
                                                vsepfim = "<?= $sepfim ?>";
                                                conini = "<?= $conini ?>";

                                                vac02 = "<?= $ac02 ?>";

        </script>

    </body>

</html>