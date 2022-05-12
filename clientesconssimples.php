<?php
$flagmenu = 4;

require_once("verifica.php");
include 'include/jquerymax.php';
include 'include/cssloja.php';

$arr = explode("/", $_SERVER['REQUEST_URI']);
$root = $arr[1];

$clicod = $_GET['c'];
if (!isset($clicod)) {
    $clicod = 0;
}

$opcao = 'CONSULTA CLIENTES SIMPLES';
$pagina = 'clientesconssimples.php';
$modulo = 4;  //Cadastros
$sub = 16;  //Clientes
$usuario = $_SESSION["id_usuario"];

?>

<!DOCTYPE html>
<html>
    <head>
        <!-- Required meta tags-->    
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Title Page-->
        <title>Consulta de Clientes</title>

        <!-- maxnew CSS-->
        <link href="css/max.css" rel="stylesheet" media="all">
        <style>
            .row-max .cell-max:nth-child(1) {
                width: 100px;
                text-align: center;
                padding-left: 10px;
            }

            .row-max .cell-max:nth-child(2) {
                width: 100px;
                text-align: center;
                padding-right: 10px;
            }

            .row-max .cell-max:nth-child(3) {
                width: 100px;
                text-align: center;
                padding-right: 10px;
            }

            .row-max .cell-max:nth-child(4) {
                width: 100px;
                text-align: center;
                padding-right: 10px;
            }

            .row-max .cell-max:nth-child(5) {
                width: 100px;
                text-align: center;
                padding-right: 10px;
            }
            
            .row-max .cell-max:nth-child(6) {
                width: 100px;
                text-align: center;
                padding-right: 10px;
            }
            
            .row-max .cell-max:nth-child(7) {
                width: 100px;
                text-align: center;
                padding-right: 10px;
            }

            a:hover {
                cursor: pointer;
            }            
            
        </style>
    </head>

    <body onLoad="dadospesquisacategoria(0,<?php echo $clicod; ?>)">
        <div class="bg-gray p-t-10 p-b-100 font-lucida">
            <div class="wrapper wrapper--w960">
                <div class="card card-4">
                    <div class="card-header">
                        Consulta de Clientes
                    </div>
                    <div class="card-body">                    
                        <form method="POST">                            
                            <div class="row row-space">  
                                <div class="col-1">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Opção</label>
                                        <div>
                                            <label class="radio-container m-r-15">Código                                           
                                                <input id="radio1" type="radio" name="radiobutton"  value="0" onFocus="nextfield = 'listDados'" checked>
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container m-r-15">Nome
                                                <input id="radio2" type="radio" name="radiobutton" value="1" onFocus="nextfield = 'listDados'">
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container m-r-15">Raz&atilde;o Social
                                                <input id="radio3" type="radio" name="radiobutton" value="2" onFocus="nextfield = 'listDados'">
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container m-r-15">CNPJ
                                                <input id="radio4" type="radio" name="radiobutton" value="3" onFocus="nextfield = 'listDados'"> 
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container m-r-15">CPF
                                                <input id="radio5" type="radio" name="radiobutton" value="4" onFocus="nextfield = 'listDados'">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div> 
                                
                            </div>
                       
                            
                            <div class="row row-space">  
                                              
                                <div class="col-3">
                                    <div class="input-group-small">
                                        <label class="label">Pesquisar</label>
                                        <div>
                                            <label class="radio-container m-r-5">Igual                                          
                                                <input id="opcoesFormaPesquisaClientes2" type="radio" name="opcoesFormaPesquisaClientes" value="radiobutton" onFocus="nextfield = 'listDados'" checked>
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container m-r-5">Inicia
                                                <input id="opcoesFormaPesquisaClientes0" type="radio" name="opcoesFormaPesquisaClientes" value="radiobutton" onFocus="nextfield = 'listDados'"> 
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container m-r-5">Qualquer
                                                <input id="opcoesFormaPesquisaClientes1" type="radio" name="opcoesFormaPesquisaClientes" value="radiobutton" onFocus="nextfield = 'listDados'">
                                                <span class="checkmark"></span>
                                            </label>                                            
                                        </div>
                                    </div>
                                </div>  
                                <div class="col-3">
                                    <div class="input-group-small">
                                        <label class="label">&nbsp;</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="pesquisa" type="text"
                                                                           name="pesquisa" size="25" onKeyPress="maiusculo()"
                                                                           onFocus="nextfield = 'radio'" onBlur="convertField(this);"
                                                                           value="<?php echo $clicod; ?>">
                                        </div>
                                    </div>
                                </div>    
                                <div class="col-3">
                                    <div class="input-group-small">
                                        <label class="label">&nbsp;</label>
                                        <div class="input-group-icon centraliza">
                                            <button class="btn-small btn--radius-2 btn--blue" name="button" id="button" type="button" onClick="dadospesquisa(pesquisa.value)">Pesquisar</button>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                            
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group-small">
                                        <label class="label-no-bottom">Cliente</label>                                        
                                        <div>                                          
                                            <span class="custom-dropdown">  
                                                <select name="listDados"
                                                            onChange="dadospesquisa2(this.value);"
                                                            onFocus="nextfield = 'clinguerra'">
                                                            <option id="opcoes" value="0">_</option>
                                                </select>
                                                <input id="clicodigo" type="hidden" name="clicodigo" size="25">
                                                <input id="us" type="hidden" value="<?php echo $_SESSION['id_usuario']; ?>" >
                                            </span>
                                        </div>
                                    </div>
                                </div> 


                            </div>  
                           
                           

                            <div class="row row-space">
                                <div class="col-5">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">C&oacute;digo</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="clicod" type="text" name="clicod"
                                                   onFocus="nextfield = 'clinguerra'" onKeyPress="maiusculo()"
                                                   onBlur="pesquisaexiste(this.value);convertField(this);" disabled
                                                   style="BACKGROUND-COLOR: #b3c6ff; COLOR: #660000; FONT-WEIGHT: bold;">                                            
                                        </div>
                                    </div>
                                </div>

                            </div>                          

                            <div class="row row-space">                                
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Cliente</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="clinguerra" type="text" name="clinguerra"
                                                   size="30" maxlength="25" onFocus="nextfield = 'clirazao'"
                                                   onKeyPress="maiusculo()" onBlur="convertField(this);">                                            
                                        </div>
                                    </div>
                                </div>                                
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Razão Social</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="clirazao" type="text" name="clirazao"
                                                   size="50" maxlength="40" onFocus="nextfield = 'clipais'"
                                                   onKeyPress="maiusculo()" onBlur="convertField(this);">                                                                                       
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row row-space">  
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Pessoa</label>
                                        <div>
                                            <label class="radio-container m-r-15">Jur&iacute;dica                                                
                                                <input id="radiob1" name="radiob" type="radio" value="radiobutton" onFocus="nextfield = 'pessoa'" onClick="verificapessoa(this.value);" checked>
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container">F&iacute;sica
                                                <input id="radiob2" type="radio" name="radiob" value="radiobutton" onFocus="nextfield = 'pessoa'" onClick="verificapessoa(this.value);">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div> 


                                <div class="col-2">
                                    <div class="input-group-small">
                                        <label class="label-no-bottom">Tipo</label>                                        
                                        <div>                                          
                                            <span class="custom-dropdown">                                                
                                                <select name="listcategoria"
                                                        onFocus="nextfield = 'clicnpj'">
                                                    <option id="opcoes2" value="0" disabled>________________________</option>
                                                </select>
                                            </span>
                                        </div>
                                    </div>
                                </div>    

                            </div>

                            <div class="row row-space">

                                <div class="col-4">
                                    <div class="input-group m-r-45">
                                        <label class="label">CNPJ</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="clicnpj" type="text" name="clicnpj"
                                                   maxlength="18" size="22" onFocus="nextfield = 'cliie'"
                                                   onKeyPress="return soNums(event);"
                                                   onBlur="validar(this);
                                                   convertField(this);"                                                               
                                                   onKeyDown="BloqueiaComando(event)" style="BACKGROUND-COLOR: #b3c6ff; COLOR: #660000;">                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="input-group m-r-45">
                                        <label class="label">Insc. Estadual</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="cliie" type="text" name="cliie" size="16"
                                                   onFocus="nextfield = 'listcategoria'" onKeyPress="maiusculo()"
                                                   onKeyPress="return soNums(event);"                                                               
                                                   onKeyDown="BloqueiaComando(event)" style="BACKGROUND-COLOR: #b3c6ff; COLOR: #660000;">                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="input-group m-r-45">
                                        <label class="label">CPF</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="clicpf" type="text" name="clicpf" size="18"
                                                   maxlength="14" onFocus="nextfield = 'clirg'"
                                                   onKeyPress="return soNums(event);"
                                                   onBlur="validar2(this);
                                                           convertField(this);" disabled                                                   
                                                   onKeyDown="BloqueiaComando(event)">                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="input-group m-r-45">
                                        <label class="label">RG</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="clirg" type="text" name="clirg" size="16"
                                                   onFocus="nextfield = 'listcategoria'" onKeyPress="maiusculo()"
                                                   disabled                                                   
                                                   onKeyDown="BloqueiaComando(event)">                                            
                                        </div>
                                    </div>
                                </div>
                            </div>    
                            <label class="subtitle">Endereço de Entrega</label>
                            <div class="row row-space">
                                <div class="col-5">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">CEP</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="clecep" type="text" name="clecep"
                                                   maxlength="8" size="10" onKeyPress="maiusculo()"
                                                   onFocus="nextfield = 'cleendereco'"
                                                   onBlur="pesquisacep(this.value);
                                                                       convertField(this);" value="">                                            
                                        </div>
                                    </div>
                                </div>
                            </div>   

                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Endereço</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="cleendereco" type="text"
                                                   name="cleendereco" size="50" maxlength="80"
                                                   onKeyPress="maiusculo()" onFocus="nextfield = 'clebairro'"
                                                   onBlur="convertField(this);" value="">
                                        </div>
                                    </div>
                                </div>

                            </div>   
                            <div class="row row-space">
                                <div class="col-5">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Número</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="clenumero" type="text" name="clenumero"
                                                   size="4" onKeyPress="maiusculo()" onBlur="format(this.value, this.id)"
                                                   maxlength="5">
                                        </div>
                                    </div>
                                </div>

                            </div>   
                            <div class="row row-space">
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Complemento</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="clecomplemento" type="text"
                                                   name="clecomplemento" maxlength="19" size="24"
                                                   onKeyPress="maiusculo()" onBlur="convertField(this);">                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Bairro</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="clebairro" type="text" name="clebairro"
                                                   size="30" maxlength="30" onFocus="nextfield = 'clefone'"
                                                   onKeyPress="maiusculo()" onBlur="convertField(this);">                                            
                                        </div>
                                    </div>
                                </div>

                            </div>  

                            <div class="row row-space">
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Cidade</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="clecidade" type="text" name="clecidade"
                                                   size="50" disabled onKeyPress="maiusculo()"
                                                   onBlur="convertField(this);">                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Estado</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="cleuf" type="text" name="cleuf" size="3"
                                                   disabled onKeyPress="maiusculo()" onBlur="convertField(this);">
                                            <input id="clecodcidade" type="hidden" name="clecodcidade" size="3"
                                                   disabled onKeyPress="maiusculo()" onBlur="convertField(this);">                                            
                                        </div>
                                    </div>
                                </div>

                            </div>  

                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group-small">
                                        <label class="label-no-bottom">Cidade IBGE</label>                                        
                                        <div>                                          
                                            <span class="custom-dropdown">                                                
                                                <select name="cidadeibge" id="cidadeibge" onChange="dadospesquisaregiao(this.value);" disabled>
                                                    <option id="cidcodigoibge" value="0">____________________________________</option>
                                                </select>
                                            </span>
                                        </div>
                                    </div>
                                </div> 


                            </div>  

                            <div class="row row-space">

                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Telefone</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="clefone" type="text" name="clefone"
                                                   size="18" onFocus="nextfield = 'clefone2'"
                                                   onKeyPress="Mascara(this, Telefone);" onBlur="convertField(this);"
                                                   maxlength=15                                                               
                                                   onKeyDown="BloqueiaComando(event);">                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Telefone 2</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="clefone2"
                                                   type="text" name="clefone2" size="18"
                                                   onFocus="nextfield = 'clefone3'"
                                                   onKeyPress="Mascara(this, Telefone);" onBlur="convertField(this);"
                                                   maxlength=15 onKeyDown="BloqueiaComando(event)">                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Telefone 3</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="clefone3" type="text" name="clefone3" size="18"
                                                   onFocus="nextfield = 'clefax'" onKeyPress="Mascara(this, Telefone);"
                                                   onBlur="convertField(this);" maxlength=15
                                                   onKeyDown="BloqueiaComando(event)">                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Fax</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="clefax" type="text" name="clefax"
                                                   size="18" maxlength=15
                                                   onKeyPress="Mascara(this, Telefone);maiusculo()"
                                                   onFocus="nextfield = 'cleemail'" onBlur="convertField(this);"
                                                   onKeyDown="BloqueiaComando(event)">                                            
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group m-r-15">
                                        <label class="label">E-mail</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="cleemail" type="text"
                                                   name="cleemail" onFocus="nextfield = 'ccfnome0'" size="50"
                                                   maxlength="50">
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                            
                            <div class="row row-space">
                                <div class="col-2 centraliza">
                                    <button class="btn btn--radius-2 btn--blue" type="button" id="botao2" onClick="cancelar()">Limpar</button>                                   
                                </div> 
                                <div class="col-2 centraliza">
                                    <button class="btn btn--radius-2 btn--blue" type="button" id="botaopedidos" onClick="load_pedidos();">Pedidos</button>
                                </div>
                            </div>                           
                 
                            
                            <div style ="display:none">
                                <select name="listfpagto"><option id="opcoes4" value="0">________________________</option></select>
                                <select name="listcanal"></select>                                
                                <select name="listlocal"></select>
                                <select name="pesquisavendedor" onBlur="pesquisacodvend(this.value)"><option id="pesquisavendedor2" value="0">__________________________________________________</option></select>
                                <select name="listDadosend" disabled onChange="dadospesquisaend2(this.value);" onBlur="desativa();"><option id="opcoesend" value="0">____________________________________</option></select>
                                <select name="cidadeibgecob" id="cidadeibgecob" disabled><option id="cidcodigoibgecob" value="0">____________________________________</option></select>
                                <select name="cidadeibgecee" id="cidadeibgecee" disabled><option id="cidcodigoibgecee" value="0">____________________________________</option></select>
                                <button class="btn btn--radius-2 btn--blue" type="button" id="botao" onClick="valida_form()">Alterar</button>
                                <button class="btn btn--radius-2 btn--azul" type="button" id="btnAlteraCep" onClick="alteracep()">Altera CEP</button>
                                <input name="hidden" type="hidden" id="acao" value="alterar">
                                <button class="btn btn--radius-2 btn--blue" type="button" id="botaoocorrencias" onClick="load_ocorrencias();">Ocorrências</button>                                    
                            </div>


                        </form>
                    </div>
                </div>
                <div class="result" id="resultado"></div>
                <div class="result" id="MsgResultado"></div>
                <div class="result" id="resultadox"></div>
            </div>
        </div>
        
        

        <table style ="display:none">


            <tr style ="display:none">

                <td>&nbsp;</td>
                <td><i>Status Cadastro: </i></td>
                <td colspan="3"><input class="input--style-4" id="regiao" type="text" name="regiao" size="5" disabled><div id="valDados"></div></td>

            </tr>



            <tr style ="display:none">
                <td>&nbsp;</td>
                <td><a href='<?php echo "/" . $root . "/vinculo.php" ?>'
                       onclick="MM_openBrWindow('<?php echo "/" . $root . "/vinculo.php" ?>', '', 'width=500,height=500');
                               return false">V&iacute;nculos</a>
                </td>
                <td colspan="3">&nbsp;</td>
                <td>&nbsp;</td>
            </tr>

            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>

            <tr style ="display:none">
                <td>&nbsp;</td>
                <td>Codigo Datasul:</td>
                <td colspan="3"><input id="clidat" type="text" name="clidat"
                                       size="10" onFocus="nextfield = 'clinguerra'"
                                       onkeypress='return SomenteNumero(event)'
                                       onBlur="convertField(this);"										
                                       style="BACKGROUND-COLOR: #FFFF99; COLOR: #660000; FONT-WEIGHT: bold;">
                </td>
                <td>&nbsp;</td>
            </tr>


            <tr style ="display:none">
                <td>&nbsp;</td>
                <td>Dt. Inclus&atilde;o Cliente:</td>
                <td colspan="3"><input id="cliinc" type="text" name="cliinc"
                                       size="16" maxlength="10" onFocus="nextfield = 'serasaalt'"
                                       OnKeyPress="formatar('##/##/####', this)"
                                       onBlur="dataano(this, this.value)" disabled
                                       style="COLOR: #660000; FONT-WEIGHT: bold;"> (dd/mm/aaaa)</td>
                <td>&nbsp;</td>
            </tr>
            <tr style ="display:none">
                <td>&nbsp;</td>
                <td>Tipo:</td>
                <td colspan="3"><input id="radiotipo1" name="radiotipo"
                                       type="radio" value="radiobutton" onFocus="nextfield = 'clipais'"
                                       checked> 1. Atacado <input id="radiotipo2" type="radio"
                                       name="radiotipo" value="radiobutton"
                                       onFocus="nextfield = 'clipais'" disabled></td>
                <td>&nbsp;</td>
            </tr>
            <tr style ="display:none">
                <td>&nbsp;</td>
                <td>Pa&iacute;s:</td>
                <td colspan="3"><input id="clipais" type="text" name="clipais"
                                       size="16" onFocus="nextfield = 'radiob'"
                                       onKeyPress="maiusculo()" onBlur="convertField(this);" READONLY>
                </td>
                <td>&nbsp;</td>
            </tr>



            <tr style ="display:none">
                <td>&nbsp;</td>
                <td>Categoria:</td>
                <td colspan="3"></td>
                <td>&nbsp; <input id="vencodigo" type="hidden" name="vencodigo"
                                  size="16" 
                                  onKeyPress="maiusculo()" disabled> <input id="cliult"
                                  type="hidden" name="cliult" size="16" onKeyPress="maiusculo()"
                                  disabled>
                </td>
            </tr>
            <tr style ="display:none">
                <td>&nbsp;</td>
                <td>Forma de Pagamento:</td>
                <td colspan="4"> &nbsp; Canal de Venda:  Portador: <input id="portador" type="text"
                                               name="portador" size="5" disabled /></td>
            </tr>
            <tr style ="display:none">
                <td>&nbsp;</td>
                <td>Tipo Cliente:</td>
                <td colspan="4"><input id="radiotc1" name="radiotc"
                                       type="radio" value="radiotc" 
                                       checked> Normal <input id="radiotc2" type="radio"
                                       name="radiotc" value="radiotc">
                    Fidelidade &nbsp; Local de Venda: 
                </td>

            </tr>
            <tr style ="display:none">
                <td>&nbsp;</td>
                <td>Limite Cr&eacute;dito:</td>
                <td colspan="4"><input id="limitec" type="text" name="limitec"
                                       size="20" maxlength="11"
                                       onKeyup='SaltaCampo("limitec", event)'
                                       onKeyDown='FormataValor("limitec", event)'
                                       style="text-align: right;" onFocus="nextfield = 'radioautfat'"
                                       disabled> <span id="alteracaoLimite"></span> <input
                                       id="limitec1" type="hidden" name="limitec1" value="0" /></td>
            </tr>
            <tr style ="display:none">
                <td>&nbsp;</td>
                <td>Aut.Faturamento:</td>
                <td colspan="4"><input id="radioautfat1" name="radioautfat"
                                       type="radio" value="radiobutton" onFocus="nextfield = 'opcaost'"
                                       disabled>&Agrave; Vista <input id="radioautfat2"
                                       name="radioautfat" type="radio" value="radiobutton"
                                       onFocus="nextfield = 'opcaost'" disabled> Liberado <input
                                       id="radioautfat3" name="radioautfat" type="radio"
                                       value="radiobutton" onFocus="nextfield = 'opcaost'" disabled>
                    Proibido <input id="radioautfat4" name="radioautfat"
                                    type="radio" value="radiobutton" onFocus="nextfield = 'opcaost'"
                                    disabled> Proibido Mattel<input id="radioautfat5" name="radioautfat"
                                    type="radio" value="radiobutton" onFocus="nextfield = 'opcaost'"
                                    disabled> Cheque <input id="radioautfat6" name="radioautfat"
                                    type="radio" value="radiobutton" onFocus="nextfield = 'opcaost'"
                                    disabled> Pendente</td>
            </tr>


            <tr style ="display:none">
                <td>&nbsp;</td>
                <td valign="middle">
                    <div align="left">Substituição Tributária:</div></td>
                <td valign="middle">
                    <input type="radio" name="opcaost" id="opcaost1" value="1" onFocus="nextfield = 'pesquisavend'" align="absmiddle" checked>Sim &nbsp; 
                    <input type="radio" name="opcaost" id="opcaost2" value="2" onFocus="nextfield = 'pesquisavend'" align="absmiddle">Não &nbsp;</td>
                <td>&nbsp;</td>
            </tr>


            <tr style ="display:none">
                <td colspan="6">&nbsp;</td>
            </tr>
            <tr style ="display:none">
                <td>&nbsp;</td>
                <td valign="middle">
                    <div align="left">Op&ccedil;&atilde;o:</div>
                </td>
                <td valign="middle"><input type="radio" name="opcao"
                                           id="opcao1" value="1" onFocus="nextfield = 'pesquisavend'"
                                           align="absmiddle" checked> C&oacute;digo &nbsp; <input
                                           type="radio" name="opcao" id="opcao2" value="2"
                                           onFocus="nextfield = 'pesquisavend'" align="absmiddle">Vendedor
                    &nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr style ="display:none">
                <td>&nbsp;</td>
                <td>
                    <div align="left">Pesquisar:</div>
                </td>
                <td><input type="text" name="pesquisavend" id="pesquisavend"
                           size="58" onFocus="nextfield = 'pesquisavendedor'"
                           onKeyPress="maiusculo()"
                           onBlur="convertField(this);pesquisav(this.value);">&nbsp; <input
                           id="vendedor" type="hidden" name="vendedor" size="5"
                           onKeyPress="maiusculo()"></td>
                <td>&nbsp;</td>



            </tr>


            <tr style ="display:none">
                <td colspan="6">&nbsp;</td>
            </tr>
            <tr style ="display:none">
                <td>&nbsp;</td>
                <td valign="middle">
                    <div align="left">Optante pelo simples:</div>				</td>

                <td valign="middle">
                    <input type="radio" name="opcaosimples" id="opcaosimples1" value="1" onFocus="nextfield = 'serasa'" align="absmiddle">Sim &nbsp; 
                    <input type="radio" name="opcaosimples" id="opcaosimples2" value="2" onFocus="nextfield = 'serasa'" align="absmiddle">Não &nbsp;
                </td>

                <td>&nbsp;</td>
            </tr>

            <tr style ="display:none">
                <td height="35">&nbsp;</td>
                <td valign="middle"><div align="left">Data da Consulta:</div></td>
                <td valign="middle"><input type="text" name="dataconsimples" id="dataconsimples" onkeypress="javascript:formata_data(this);" onkeyup="javascript:pulacampo(this);" onBlur="dataano(this, this.value)" maxlength="10"></td>
                <td>&nbsp;</td>
            </tr>		

            <tr style ="display:none">
                <td>&nbsp;</td>
                <td valign="middle">
                    <div align="left">SUFRAMA:</div></td>				
                <td colspan="4">
                    <input type="radio" name="opcaosuframa" id="opcaosuframa1" value="1" align="absmiddle" onClick="verificasuframa(this.value);">Sim
                    <input type="radio" name="opcaosuframa" id="opcaosuframa2" value="2" align="absmiddle" checked onClick="verificasuframa(this.value);">Não&nbsp; 
                    <input type="text" name="numerosuframa" id="numerosuframa" maxlength="20" size="16" disabled onBlur="convertField(this);">&nbsp;&nbsp; Regime:
                    <input id="radiosuframa1" name="radiosuframa" type="radio" value="radiobutton" disabled> Lucro Real 
                    <input id="radiosuframa2" name="radiosuframa" type="radio" value="radiobutton" disabled> Lucro Presumido 
                    <input id="radiosuframa3" name="radiosuframa" type="radio" value="radiobutton" disabled> Optante pelo Simples 
                </td>				
            </tr>	

            <tr style ="display:none">
                <td>&nbsp;</td>
                <td valign="middle">
                    <div align="left">Compra Consignação:</div></td>
                <td valign="middle">
                    <input type="radio" name="opcaocons" id="opcaocons1" value="1" align="absmiddle" >Sim
                    <input type="radio" name="opcaocons" id="opcaocons2" value="2" align="absmiddle" checked>Não &nbsp;</td>
                <td>&nbsp;</td>
            </tr>		

            <tr style ="display:none">
                <td>&nbsp;</td>
                <td valign="middle">
                    <div align="left">Inativo:</div>				</td>

                <td valign="middle">
                    <input type="radio" name="opcaoinativo" id="opcaoinativo1" value="1" align="absmiddle">Não
                    <input type="radio" name="opcaoinativo" id="opcaoinativo2" value="2"  align="absmiddle">Sim&nbsp;
                    <input type="text" name="datainativo" id="datainativo" maxlength="10" size="16" disabled>									
                </td>

                <td>&nbsp;</td>
            </tr>								




            <tr style ="display:none">
                <td colspan="6">&nbsp;</td>
            </tr>
            <tr style ="display:none">
                <td bgcolor="#3366CC">&nbsp;</td>
                <td colspan="5" bgcolor="#3366CC">
                    <div align="center">
                        <font color="#FFFFFF">VINCULOS</font>
                    </div>
                </td>
            </tr>

            <tr style ="display:none">
                <td>&nbsp;</td>
                <td>Vinculado ao grupo:</td>
                <td></td>
                <td>&nbsp;</td>
            </tr>
            <tr style ="display:none">
                <td>&nbsp;</td>
                <td id="grupoVinculado" nowrap="nowrap"></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>

            <tr style ="display:none">
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td nowrap><div id="resultado" align="center">&nbsp;</div></td>
                <td nowrap colspan="3"><div align="right">&nbsp;</div></td>
            </tr>


            <tr style ="display:none">
                <td>&nbsp;</td>
                <td nowrap><a href='<?php echo "/" . $root . "/vinculo.php" ?>'
                              onclick="MM_openBrWindow('<?php echo "/" . $root . "/vinculo.php" ?>', '', 'width=600,height=500');
                                      return false">Criar
                        Grupo de Vinculos</a></td>
                <td colspan="3">&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr style ="display:none">
                <td>&nbsp;</td>
                <td nowrap><a href='<?php echo "/" . $root . "/clievinc.php" ?>'
                              onclick="MM_openBrWindow('<?php echo "/" . $root . "/clievinc.php" ?>', '', 'width=600,height=500');
                                      return false">Incluir
                        Cliente no Grupo</a></td>
                <td colspan="3">&nbsp;</td>
                <td>&nbsp;</td>
            </tr>


            <tr style ="display:none">
                <td>&nbsp;</td>
                <td>Endere&ccedil;o:</td>
                <td colspan="3">
                </td>
                <td>
                    <div align="center">

                        <a
                            href="http://www.buscacep.correios.com.br/servicos/dnec/index.do"
                            target="_blank"><img src="imagens/correios.gif" /> </a>

                    </div>
                </td>
            </tr>

            <tr style ="display:none">
                <td>&nbsp;</td>
                <td>
                    <div align="left">Pesquisa:</div>
                </td>
                <td><</td>
                <td>
                    <div align="center">											
                        <input id="endcodigo" type="hidden" name="endcodigo"
                               size="25">
                    </div>
                </td>
            </tr>


            <tr style ="display:none">
                <td>&nbsp;</td>
                <td>E-mail XML:</td>
                <td colspan="3"><input onKeyPress="maiusculo()"
                                       onBlur="convertField(this);" id="cleemailxml" type="text"
                                       name="cleemailxml" onFocus="nextfield = 'ccfnome0'" size="50"
                                       maxlength="50"
                                       style="BACKGROUND-COLOR: #FFFF99; COLOR: #660000; FONT-WEIGHT: bold;">
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
            <tr style ="display:none">
                <td bgcolor="#3366CC">&nbsp;</td>
                <td colspan="5" bgcolor="#3366CC">
                    <div align="center">
                        <font color="#FFFFFF">Contatos do Endere&ccedil;o de
                            Faturamento (Nome / Telefone / E-mail) </font>
                    </div>
                </td>
            </tr>
            <tr style ="display:none">
                <td bgcolor="#CCCCCC">&nbsp;</td>
                <td>Contato 1:</td>
                <td colspan="4"><input id="ccfnome0" type="text"
                                       name="ccfnome0" maxlength="13" size="20"
                                       onKeyPress="maiusculo()" onFocus="nextfield = 'ccffone0'"
                                       onBlur="convertField(this);" style="FONT-WEIGHT: bold;"> <font
                                       color="#FFFFFF">&nbsp; </font> <input id="ccffone0"
                                                          type="text" name="ccffone0"
                                                          onKeyPress="Mascara(this, Telefone);
                                                                  maiusculo();" maxlength=15
                                                          size="18" onFocus="nextfield = 'ccfemail0'"
                                                          onBlur="convertField(this);"
                                                          style="FONT-WEIGHT: bold; width: 126PX;"
                                                          onKeyDown="BloqueiaComando(event)"> <font color="#FFFFFF">&nbsp;
                    </font> <input id="ccfemail0" type="text" name="ccfemail0"
                                   size="46" maxlength="50" onFocus="nextfield = 'ccfnome1'"
                                   style="FONT-WEIGHT: bold;" onBlur="convertField(this);"></td>
            </tr>
            <tr style ="display:none">
                <td bgcolor="#CCCCCC">&nbsp;</td>
                <td>Contato 2:</td>
                <td colspan="4"><input id="ccfnome1" type="text"
                                       name="ccfnome1" maxlength=14 size="20"
                                       onKeyPress="maiusculo()" onFocus="nextfield = 'ccffone1'"
                                       onBlur="convertField(this);" style="FONT-WEIGHT: bold;"> <font
                                       color="#FFFFFF">&nbsp; </font> <input id="ccffone1"
                                                          type="text" name="ccffone1" maxlength=15 size="18"
                                                          onKeyPress="Mascara(this, Telefone);maiusculo()"
                                                          onFocus="nextfield = 'ccfemail1'" onBlur="convertField(this);"
                                                          style="FONT-WEIGHT: bold; width: 126PX;"
                                                          onKeyDown="BloqueiaComando(event)"> <font color="#FFFFFF">&nbsp;
                    </font> <input id="ccfemail1" type="text" name="ccfemail1"
                                   size="46" maxlength="50" onFocus="nextfield = 'ccfnome2'"
                                   style="FONT-WEIGHT: bold;" onKeyPress="maiusculo()"
                                   onBlur="convertField(this);"></td>
            </tr>
            <tr style ="display:none">
                <td bgcolor="#CCCCCC">&nbsp;</td>
                <td>Contato 3:</td>
                <td colspan="4"><input id="ccfnome2" type="text"
                                       name="ccfnome2" size="20" maxlength=14
                                       onKeyPress="maiusculo()" onFocus="nextfield = 'ccffone2'"
                                       onBlur="convertField(this);" style="FONT-WEIGHT: bold;"> <font
                                       color="#FFFFFF">&nbsp; </font> <input id="ccffone2"
                                                          type="text" name="ccffone2" maxlength=15 size="18"
                                                          onKeyPress="Mascara(this, Telefone); maiusculo()"
                                                          onFocus="nextfield = 'ccfemail2'" onBlur="convertField(this);"
                                                          style="FONT-WEIGHT: bold; width: 126PX;"
                                                          onKeyDown="BloqueiaComando(event)"> <font color="#FFFFFF">&nbsp;
                    </font> <input id="ccfemail2" type="text" name="ccfemail2"
                                   size="46" maxlength="50" onFocus="nextfield = 'ccfnome3'"
                                   style="FONT-WEIGHT: bold;" onKeyPress="maiusculo()"
                                   onBlur="convertField(this);"></td>
            </tr>

            <tr style ="display:none">
                <td bgcolor="#3366CC">&nbsp;</td>
                <td colspan="5" bgcolor="#3366CC">
                    <div align="center">
                        <font color="#FFFFFF">Dados Complementares </font>
                    </div>
                </td>
            </tr>
            <tr style ="display:none">
                <td>&nbsp;</td>
                <td>
                    <div align="left">Nome do S&oacute;cio:</div>
                </td>
                <td colspan="3"><input id="clinsocio" type="text"
                                       name="clinsocio" size="30" maxlength="25"
                                       onKeyPress="maiusculo()" onFocus="nextfield = 'clicpfsocio'"
                                       onBlur="convertField(this);"
                                       style="BACKGROUND-COLOR: #FFFF99; COLOR: #660000; FONT-WEIGHT: bold;">
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr style ="display:none">
                <td>&nbsp;</td>
                <td>CPF:</td>
                <td colspan="4"><input id="clicpfsocio" type="text"
                                       name="clicpfsocio" size="18" maxlength="14"
                                       onKeyPress="return soNums(event);"
                                       onFocus="nextfield = 'radiosex'"
                                       onBlur="validar2(this);
                                               convertField(this);"
                                       onKeyDown="BloqueiaComando(event)">
                    &nbsp;&nbsp;&nbsp;&nbsp;Sexo <input id="radiosex1"
                                                        name="radiosex" type="radio" value="radiobutton"
                                                        onFocus="nextfield = 'radioip'" checked> Masc. <input
                                                        id="radiosex2" name="radiosex" type="radio"
                                                        value="radiobutton" onFocus="nextfield = 'radioip'"> Fem.
                    &nbsp;&nbsp;&nbsp;&nbsp;Imovel Pr&oacute;prio<input
                        id="radioip1" name="radioip" type="radio" value="radiobutton"
                        onFocus="nextfield = 'comcep'" checked> Sim <input id="radioip2"
                        name="radioip" type="radio" value="radiobutton"
                        onFocus="nextfield = 'comcep'"> N&atilde;o</td>
            </tr>

            <tr style ="display:none">
                <td bgcolor="#3366CC">&nbsp;</td>
                <td colspan="5" bgcolor="#3366CC">
                    <div align="center" style="font-weight: bolder; color: #FFF">
                        Endere&ccedil;o de cobran&ccedil;a &eacute; diferente do
                        endere&ccedil;o de faturamento? <input id="radioc1"
                                                               name="radioc" type="radio" value="radiobutton"
                                                               onFocus="nextfield = 'clccep'"
                                                               onClick="verificacobranca(this.value);"> Sim <input
                                                               id="radioc2" name="radioc" type="radio" value="radiobutton"
                                                               onFocus="nextfield = 'radiod'"
                                                               onClick="verificacobranca(this.value);" checked> N&atilde;o
                        <input type="button" name="excluirend1" id="excluirend1"
                               value="Excluir" onClick="excluirEnd1()" disabled> </font>
                    </div>
                </td>
            </tr>
            <tr style ="display:none">
                <td>&nbsp;</td>
                <td>Cep:</td>
                <td colspan="3"><input id="clccep" type="text" name="clccep"
                                       size="10" onFocus="nextfield = 'clcendereco'"
                                       onKeyPress="maiusculo()" onBlur="pesquisacep2(this.value);"
                                       disabled></td>
                <td>&nbsp;</td>
            </tr>
            <tr style ="display:none">
                <td>&nbsp;</td>
                <td>Endere&ccedil;o:</td>
                <td colspan="3"><input id="clcendereco" type="text"
                                       name="clcendereco" size="50" onFocus="nextfield = 'clcnumero'"
                                       onKeyPress="maiusculo()" onBlur="convertField(this);" disabled>
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr style ="display:none">
                <td>&nbsp;</td>
                <td>Numero:</td>
                <td colspan="3"><input type="text" id="clcnumero"
                                       name="clcnumero" maxlength="5" size="4"
                                       onFocus="nextfield = 'clccomplemento'" onKeyPress="maiusculo()"
                                       onBlur="format(this.value, this.id)"
                                       style="BACKGROUND-COLOR: #FFFF99; COLOR: #660000; FONT-WEIGHT: bold;">&nbsp;&nbsp;&nbsp;
                    Complemento: <input id="clccomplemento" name="clccomplemento"
                                        type="text" size="24" onFocus="nextfield = 'combairro'"
                                        onKeyPress="maiusculo()" maxlength="19"
                                        onBlur="convertField(this);"></td>
                <td>&nbsp;</td>
            </tr>

            <tr style ="display:none">
                <td>&nbsp;</td>
                <td>Bairro:</td>
                <td colspan="3"><input disabled id="clcbairro" type="text"
                                       name="clcbairro" maxlength="38" size="50"
                                       onFocus="nextfield = 'clcfone'" onKeyPress="maiusculo()"
                                       onBlur="convertField(this);"></td>
                <td>&nbsp;</td>
            </tr>
            <tr style ="display:none">
                <td>&nbsp;</td>
                <td>Cidade:</td>
                <td colspan="3"><input disabled id="clccidade" type="text"
                                       name="clccidade" size="50" onKeyPress="maiusculo()"
                                       onBlur="convertField(this);"
                                       style="COLOR: #660000; FONT-WEIGHT: bold;"></td>
                <td>&nbsp;</td>
            </tr>
            <tr style ="display:none">
                <td>&nbsp;</td>
                <td>Estado:</td>
                <td colspan="3"><input id="clcuf" type="text" name="clcuf"
                                       size="3" disabled onKeyPress="maiusculo()"
                                       onBlur="convertField(this);"
                                       style="COLOR: #660000; FONT-WEIGHT: bold;"> <input
                                       id="clccodcidade" type="hidden" name="clccodcidade" size="3"
                                       onKeyPress="maiusculo()" onBlur="convertField(this);"></td>
                <td>&nbsp;</td>
            </tr>
            <tr style ="display:none">
                <td>&nbsp;</td>
                <td>Cidade IBGE:</td>
                <td colspan="3"></td>
                <td>&nbsp;</td>
            </tr>
            <tr style ="display:none">
                <td>&nbsp;</td>
                <td>Fone:</td>
                <td colspan="3"><input disabled id="clcfone" type="text"
                                       maxlength=15 name="clcfone" size="18"
                                       onFocus="nextfield = 'clcfone2'"
                                       onKeyPress="Mascara(this, Telefone);
                                               maiusculo()"
                                       onBlur="convertField(this);"
                                       style="BACKGROUND-COLOR: #FFFF99; COLOR: #660000; FONT-WEIGHT: bold;"
                                       onKeyDown="BloqueiaComando(event)"> <input id="clcfone2"
                                       disabled type="text" name="clcfone2"
                                       onKeyPress="Mascara(this, Telefone);
                                               maiusculo();" maxlength=15
                                       size="18" onFocus="nextfield = 'clcfone3'"
                                       onBlur="convertField(this);"
                                       onKeyDown="BloqueiaComando(event)"> <input id="clcfone3"
                                       disabled type="text" name="clcfone3"
                                       onKeyPress="Mascara(this, Telefone);
                                               maiusculo();" maxlength=15
                                       size="18" onFocus="nextfield = 'clcfax'"
                                       onBlur="convertField(this);"
                                       onKeyDown="BloqueiaComando(event)"></td>
                <td>&nbsp;</td>
            </tr>
            <tr style ="display:none">
                <td>&nbsp;</td>
                <td>Fax:</td>
                <td colspan="3"><input disabled id="clcfax" type="text"
                                       maxlength=15 name="clcfax" size="18"
                                       onFocus="nextfield = 'clcemail'"
                                       onKeyPress="Mascara(this, Telefone);
                                               maiusculo();"
                                       onBlur="convertField(this);"
                                       onKeyDown="BloqueiaComando(event)"></td>
                <td>&nbsp;</td>
            </tr>
            <tr style ="display:none">
                <td>&nbsp;</td>
                <td>E-mail:</td>
                <td colspan="3"><input disabled id="clcemail"
                                       onKeyPress="maiusculo()" onBlur="convertField(this);"
                                       maxlength="50" type="text" name="clcemail" size="50"
                                       onFocus="nextfield = 'cccnome0'"></td>
                <td>&nbsp;</td>
            </tr>
            <tr style ="display:none">
                <td bgcolor="#3366CC">&nbsp;</td>
                <td colspan="5" bgcolor="#3366CC">
                    <div align="center">
                        <font color="#FFFFFF">Contatos do Endere&ccedil;o de
                            Cobran&ccedil;a (Nome / Telefone / E-mail) </font>
                    </div>
                </td>
            </tr>
            <tr style ="display:none">
                <td bgcolor="#CCCCCC">&nbsp;</td>
                <td>Contato 1:</td>
                <td colspan="4"><input disabled id="cccnome0" type="text"
                                       name="cccnome0" maxlength="16" size="20"
                                       onKeyPress="maiusculo()" onBlur="convertField(this);"
                                       onFocus="nextfield = 'cccfone0'"> <input id="cccfone0" disabled
                                       type="text" name="cccfone0"
                                       onKeyPress="Mascara(this, Telefone);
                                               maiusculo();" maxlength=15
                                       size="18" onBlur="convertField(this);"
                                       onFocus="nextfield = 'cccemail0'"
                                       onKeyDown="BloqueiaComando(event)"> <font color="#FFFFFF">&nbsp;
                    </font> <input id="cccemail0" maxlength="50" disabled
                                   type="text" name="cccemail0" size="46"
                                   onFocus="nextfield = 'cccnome1'" onKeyPress="maiusculo()"
                                   onBlur="convertField(this);"></td>
            </tr>
            <tr style ="display:none">
                <td>&nbsp;</td>
                <td>Contato 2:</td>
                <td colspan="4"><input disabled id="cccnome1" type="text"
                                       name="cccnome1" size="20" onKeyPress="maiusculo()"
                                       onBlur="convertField(this);" onFocus="nextfield = 'cccfone1'"
                                       maxlength="16"> <input id="cccfone1" disabled type="text"
                                       name="cccfone1"
                                       onKeyPress="Mascara(this, Telefone);
                                               maiusculo();" maxlength=15
                                       size="18" onBlur="convertField(this);"
                                       onFocus="nextfield = 'cccemail1'"
                                       onKeyDown="BloqueiaComando(event)"> <font color="#FFFFFF">&nbsp;
                    </font> <input id="cccemail1" disabled type="text"
                                   name="cccemail1" size="46" onFocus="nextfield = 'cccnome2'"
                                   maxlength="50" onKeyPress="maiusculo()"
                                   onBlur="convertField(this);"></td>
            </tr>

            <tr style ="display:none">
                <td bgcolor="#3366CC">&nbsp;</td>
                <td colspan="5" bgcolor="#3366CC">
                    <div align="center" style="font-weight: bolder; color: #FFF">
                        Endere&ccedil;o de entrega &eacute; diferente do
                        endere&ccedil;o de faturamento? <input id="radiod1"
                                                               name="radiod" type="radio" value="radiobutton"
                                                               onClick="verificaentrega(this.value);"
                                                               onFocus="nextfield = 'ceecep'"> Sim <input id="radiod2"
                                                               name="radiod" type="radio" value="radiobutton"
                                                               onClick="verificaentrega(this.value);"
                                                               onFocus="nextfield = 'button2'" checked> N&atilde;o <input
                                                               type="button" name="excluirend2" id="excluirend2"
                                                               value="Excluir" onClick="excluirEnd2()" disabled> </font>
                    </div>
                </td>
            </tr>
            <tr style ="display:none">
                <td>&nbsp;</td>
                <td>Cep:</td>
                <td colspan="3"><input id="ceecep" disabled type="text"
                                       name="ceecep" maxlength="8" size="10" onKeyPress="maiusculo()"
                                       onFocus="nextfield = 'ceeendereco'"
                                       onBlur="pesquisacep3(this.value);"></td>
                <td>&nbsp;</td>
            </tr>
            <tr style ="display:none">
                <td>&nbsp;</td>
                <td>Endere&ccedil;o:</td>
                <td colspan="3"><input id="ceeendereco" disabled type="text"
                                       name="ceeendereco" size="50" onKeyPress="maiusculo()"
                                       onFocus="nextfield = 'ceebairro'" onBlur="convertField(this);">
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr style ="display:none">
                <td>&nbsp;</td>
                <td>Numero:</td>
                <td colspan="3"><input id="ceenumero" disabled type="text"
                                       name="ceenumero" maxlength="5" size="4"
                                       onFocus="nextfield = 'ceecomplemento'" onKeyPress="maiusculo()"
                                       onBlur="format(this.value, this.id)"
                                       style="BACKGROUND-COLOR: #FFFF99; COLOR: #660000; FONT-WEIGHT: bold;">&nbsp;&nbsp;&nbsp;
                    Complemento: <input id="ceecomplemento" type="text" disabled
                                        name="ceecomplemento" size="24"
                                        onFocus="nextfield = 'ceebairro'" onKeyPress="maiusculo()"
                                        onBlur="convertField(this);"
                                        style="COLOR: #660000; FONT-WEIGHT: bold;" maxlength="20"></td>
                <td>&nbsp;</td>
            </tr>
            <tr style ="display:none">
                <td>&nbsp;</td>
                <td>Bairro:</td>
                <td colspan="3"><input id="ceebairro" disabled type="text"
                                       name="ceebairro" maxlength="40" size="50"
                                       onKeyPress="maiusculo()" onFocus="nextfield = 'ceefone'"
                                       onBlur="convertField(this);"></td>
                <td>&nbsp;</td>
            </tr>
            <tr style ="display:none">
                <td>&nbsp;</td>
                <td>Cidade:</td>
                <td colspan="3"><input id="ceecidade" type="text"
                                       name="ceecidade" size="50" disabled onKeyPress="maiusculo()">
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr style ="display:none">
                <td>&nbsp;</td>
                <td>Estado:</td>
                <td colspan="3"><input id="ceeuf" disabled type="text"
                                       name="ceeuf" size="3" onKeyPress="maiusculo()"> <input
                                       id="ceecodcidade" type="hidden" name="cecodcidade" size="3"
                                       disabled onKeyPress="maiusculo()"> </td>
                <td>&nbsp;</td>
            </tr>
            <tr style ="display:none">
                <td>&nbsp;</td>
                <td>Cidade IBGE:</td>
                <td colspan="3"><</td>
                <td>&nbsp;</td>
            </tr>
            <tr style ="display:none">
                <td>&nbsp;</td>
                <td>Fone:</td>
                <td colspan="3"><input id="ceefone" disabled type="text"
                                       maxlength=15 name="ceefone" size="18"
                                       onKeyPress="Mascara(this, Telefone);maiusculo();"
                                       onFocus="nextfield = 'ceefone2'" onBlur="convertField(this);"
                                       style="BACKGROUND-COLOR: #FFFF99; COLOR: #660000; FONT-WEIGHT: bold;"
                                       onKeyDown="BloqueiaComando(event)"> <input id="ceefone2"
                                       type="text" disabled name="ceefone2" maxlength=15 size="18"
                                       onKeyPress="Mascara(this, Telefone);
                                               maiusculo();"
                                       onFocus="nextfield = 'ceefone3'" onBlur="convertField(this);"
                                       onKeyDown="BloqueiaComando(event)"> <input id="ceefone3"
                                       type="text" disabled name="ceefone3" maxlength=15 size="18"
                                       onKeyPress="Mascara(this, Telefone);
                                               maiusculo();"
                                       onFocus="nextfield = 'ceefax'" onBlur="convertField(this);"
                                       onKeyDown="BloqueiaComando(event)"></td>
                <td>&nbsp;</td>
            </tr>
            <tr style ="display:none">
                <td>&nbsp;</td>
                <td>Fax:</td>
                <td colspan="3"><input id="ceefax" type="text" disabled
                                       maxlength=15 name="ceefax" size="18"
                                       onKeyPress="Mascara(this, Telefone);
                                               maiusculo();"
                                       onFocus="nextfield = 'ceeemail'" onBlur="convertField(this);"
                                       onKeyDown="BloqueiaComando(event)"></td>
                <td>&nbsp;</td>
            </tr>
            <tr style ="display:none">
                <td>&nbsp;</td>
                <td>E-mail:</td>
                <td colspan="3"><input id="ceeemail" type="text" disabled
                                       name="ceeemail" maxlength="50" size="50"
                                       onFocus="nextfield = 'ccenome0'" onKeyPress="maiusculo()"
                                       onBlur="convertField(this);"></td>
                <td>&nbsp;</td>
            </tr>
            <tr style ="display:none">
                <td bgcolor="#3366CC">&nbsp;</td>
                <td colspan="5" bgcolor="#3366CC">
                    <div align="center">
                        <font color="#FFFFFF">Refer&ecirc;ncias Comerciais (Nome /
                            Telefone / E-mail) </font>
                    </div>
                </td>
            </tr>
            <tr style ="display:none">
                <td>&nbsp;</td>
                <td>Refer&ecirc;ncia 1:</td>

                <td colspan="4"><input id="ccenome0" type="text"
                                       name="ccenome0" size="20" maxlength="14"
                                       onKeyPress="maiusculo()" onBlur="convertField(this);"
                                       onFocus="nextfield = 'ccefone0'"
                                       style="BACKGROUND-COLOR: #FFFFFF; COLOR: #660000; FONT-WEIGHT: bold; width: 138PX;">
                    <input id="ccefone0" type="text" name="ccefone0" maxlength=15
                           size="18" onKeyPress="Mascara(this, Telefone);maiusculo();"
                           onBlur="convertField(this);" onFocus="nextfield = 'cceemail0'"
                           style="BACKGROUND-COLOR: #FFFFFF; COLOR: #660000; FONT-WEIGHT: bold; width: 126PX;"
                           onKeyDown="BloqueiaComando(event)"> <font color="#FFFFFF">&nbsp;
                    </font> <input id="cceemail0" type="text"
                                   onKeyPress="maiusculo()" onBlur="convertField(this);"
                                   name="cceemail0" size="46" maxlength="50"
                                   onFocus="nextfield = 'ccenome1'"
                                   style="BACKGROUND-COLOR: #FFFFFF; COLOR: #660000; FONT-WEIGHT: bold; width: 325PX;">
                </td>
            </tr>
            <tr style ="display:none">
                <td>&nbsp;</td>
                <td>Refer&ecirc;ncia 2:</td>

                <td colspan="4"><input id="ccenome1" type="text"
                                       name="ccenome1" size="20" maxlength="14"
                                       onKeyPress="maiusculo()" onBlur="convertField(this);"
                                       onFocus="nextfield = 'ccefone1'"
                                       style="BACKGROUND-COLOR: #FFFFFF; COLOR: #660000; FONT-WEIGHT: bold; width: 138PX;">
                    <input id="ccefone1" type="text" name="ccefone1" maxlength=15
                           size="18" onKeyPress="Mascara(this, Telefone);maiusculo();"
                           onBlur="convertField(this);" onFocus="nextfield = 'cceemail1'"
                           style="BACKGROUND-COLOR: #FFFFFF; COLOR: #660000; FONT-WEIGHT: bold; width: 126PX;"
                           onKeyDown="BloqueiaComando(event)"> <font color="#FFFFFF">&nbsp;
                    </font> <input id="cceemail1" onKeyPress="maiusculo()"
                                   onBlur="convertField(this);" type="text" name="cceemail1"
                                   size="46" maxlength="50" onFocus="nextfield = 'ccenome2'"
                                   style="BACKGROUND-COLOR: #FFFFFF; COLOR: #660000; FONT-WEIGHT: bold; width: 325PX;">
                </td>
            </tr>
            <tr style ="display:none">
                <td>&nbsp;</td>
                <td>Refer&ecirc;ncia 3:</td>

                <td colspan="4"><input id="ccenome2" type="text"
                                       name="ccenome2" size="20" maxlength="14"
                                       onKeyPress="maiusculo()" onBlur="convertField(this);"
                                       onFocus="nextfield = 'ccefone2'"
                                       style="BACKGROUND-COLOR: #FFFFFF; COLOR: #660000; FONT-WEIGHT: bold; width: 138PX;">
                    <input id="ccefone2" type="text" name="ccefone2" maxlength=15
                           size="18" onKeyPress="Mascara(this, Telefone);maiusculo();"
                           onBlur="convertField(this);" onFocus="nextfield = 'cceemail2'"
                           style="BACKGROUND-COLOR: #FFFFFF; COLOR: #660000; FONT-WEIGHT: bold; width: 126PX;"
                           onKeyDown="BloqueiaComando(event)"> <font color="#FFFFFF">&nbsp;
                    </font> <input id="cceemail2" type="text" name="cceemail2"
                                   size="46" maxlength="34" onKeyPress="maiusculo()"
                                   onBlur="convertField(this);"
                                   onFocus="nextfield = 'potencialdecompra'"
                                   style="BACKGROUND-COLOR: #FFFFFF; COLOR: #660000; FONT-WEIGHT: bold; width: 325PX;">
                </td>
            </tr>

            <tr style ="display:none">
                <td colspan="6">&nbsp;</td>
            </tr>
            <tr style ="display:none">
                <td bgcolor="#3366CC">&nbsp;</td>
                <td colspan="5" bgcolor="#3366CC">
                    <div align="center">
                        <font color="#FFFFFF">Observa&ccedil;&otilde;es</font>
                    </div>
                </td>
            </tr>
            <tr style ="display:none">
                <td>&nbsp;</td>
                <td colspan="5"><input type="hidden" name="cliobs" id="cliobs"
                                       cols="90" rows="3" onFocus="nextfield = 'clicomerc'"
                                       onBlur="convertField(this);" disabled=disabled> </textarea></td>
            </tr>
            <tr style ="display:none">
                <td>&nbsp;</td>
                <td colspan="5">&nbsp;</td>
            </tr>
            <tr style ="display:none">
                <td>&nbsp;</td>
                <td colspan="5">Potencial de Compra: <input
                        id="potencialdecompra" size="15" maxlength="11" value="1.00"
                        type="text" name="potencialdecompra"
                        onFocus="nextfield = 'limiteproposto'"
                        onKeyup='SaltaCampo("potencialdecompra", event)'
                        onKeyDown='FormataValor("potencialdecompra", event)'
                        style="BACKGROUND-COLOR: #FFFF99; COLOR: #660000; FONT-WEIGHT: bold;">&nbsp;&nbsp;&nbsp;&nbsp;Limite
                    Proposto: <input id="limiteproposto" size="15" maxlength="11"
                                     value="1.00" type="text" name="limiteproposto"
                                     onFocus="nextfield = 'clicomerc'"
                                     onKeyup='SaltaCampo("limiteproposto", event)'
                                     onKeyDown='FormataValor("limiteproposto", event)'
                                     style="BACKGROUND-COLOR: #FFFF99; COLOR: #660000; FONT-WEIGHT: bold;">
                </td>
            </tr>
            <tr style ="display:none">
                <td>&nbsp;</td>
                <td colspan="4">&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr style ="display:none">
                <td>&nbsp;</td>
                <td colspan="4">Observa&ccedil;&otilde;es Comerciais:</td>
                <td>&nbsp;</td>
            </tr>
            <tr style ="display:none">
                <td>&nbsp;</td>
                <td colspan="5"><textarea name="clicomerc" id="clicomerc"
                                          cols="90" rows="3" onFocus="nextfield = 'cliobsfin'"
                                          onBlur="convertField(this);"></textarea></td>
            </tr>



            <tr>                                    
                <td colspan="6">&nbsp;</td>                                    
            </tr>

        </table>
        
        <script src="js/clienteseditsimples.js"></script>
        <script type="text/javascript">
            var $a = jQuery.noConflict()
        </script>
        <script language="JavaScript1.2">
            var tpcliente;
            tpcliente = 1;

            function Mascara(o, f) {
                v_obj = o
                v_fun = f
                setTimeout("execmascara()", 1)
            }

            function execmascara() {
                v_obj.value = v_fun(v_obj.value)
            }

            function Telefone(v) {
                if (v.length > 14) {
                    v = v.replace(/\D/g, "")
                    v = v.replace(/^(\d\d)(\d)/g, "($1) $2")
                    v = v.replace(/(\d{5})(\d)/, "$1-$2")
                } else {
                    v = v.replace(/\D/g, "")
                    v = v.replace(/^(\d\d)(\d)/g, "($1) $2")
                    v = v.replace(/(\d{4})(\d)/, "$1-$2")
                }
                return v
            }


        </script>

    </body>

</html>


                  
               


