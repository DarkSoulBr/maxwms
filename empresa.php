<?php
$flagmenu = 2;
// Verificador de sessão
require("verifica.php");
?>
<!DOCTYPE html>
<html>
    <head>

        <!-- Required meta tags-->    
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Title Page-->
        <title>Parâmetros do Emitente</title> 

        <!-- maxnew CSS-->
        <link href="css/max.css" rel="stylesheet" media="all">        
    </head>

    <body onload="dadospesquisa(1);">
        <div id="retorno"></div>
        <div id="dialog" style="margin-left: 5px; margin-left: 5px;"></div>
        <div class="bg-gray p-t-10 font-lucida">
            <div class="wrapper wrapper--w780">
                <div class="card card-4">
                    <div class="card-header">
                        Parâmetros do Emitente
                    </div>
                    <div class="card-body">                    
                        <form name="formulario" id="formulario">
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group-small">
                                        <label class="label">Nome Guerra</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="fornguerra" type="text" name="fornguerra" size="40" onkeyup="javascrip :this.value = this.value.toUpperCase();" maxlength=25>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group-small">
                                        <label class="label">Razão Social</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="forrazao" type="text" name="forrazao" size="70" onkeyup="javascript:this.value = this.value.toUpperCase();" maxlength=40>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Pessoa</label>
                                        <div>
                                            <label class="radio-container m-r-15">Jurídica                                              
                                                <input name="radiobutton2" type="radio" id="radio11" value="radiobutton" onclick="verificapessoa(this.value);" checked>
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container m-r-15">Física
                                                <input type="radio" name="radiobutton2" id="radio12" value="radiobutton" onclick="verificapessoa(this.value);"> 
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-space">
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">CNPJ</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="forcnpj" type="text" name="forcnpj" size="22" maxlength="18" onKeyPress="return soNums(event);" onBlur="validar(this);">
                                        </div>
                                    </div>
                                </div>                                
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">I.E.</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="forie" type="text" name="forie" size="18" onkeyup="javascript:this.value = this.value.toUpperCase();">
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                            <div class="row row-space">
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">CPF</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="forcpf" type="text" name="forcpf" size="22" maxlength="14" onKeyPress="return soNums(event);" onBlur="validar2(this);" disabled>
                                        </div>
                                    </div>
                                </div>                                
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">R.G.</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="forrg" type="text" name="forrg" size="18" onkeyup="javascript:this.value = this.value.toUpperCase();" disabled>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                            <div class="row row-space">
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Insc.SUFRAMA</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="forsuframa" type="text" name="forsuframa" size="22" onKeyPress="return soNums(event);">
                                        </div>
                                    </div>
                                </div>                                                          
                            </div>
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group-small m-r-15">
                                        <label class="label">Observações</label>
                                        <div class="input-group-small-icon">
                                            <textarea class="textarea--style-4" name="forobs" id="forobs" cols="53" rows="2" onkeyup="javascript:this.value = this.value.toUpperCase();"></textarea>                                                             
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-space">
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Cep.</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="fnecep" type="text" name="fnecep" size="10" onkeyup="javascript:this.value = this.value.toUpperCase();" onBlur="pesquisacep(this.value);" onkeypress='return SomenteNumero(event)' maxlength=8>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group-small m-r-15">
                                        <label class="label">Endereço</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="fneendereco" type="text" name="fneendereco" size="70" onkeyup="javascript:this.value = this.value.toUpperCase();">
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                            <div class="row row-space">
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Número</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="fnenumero" type="text" name="fnenumero" size="10" maxlength=10>
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Bairro</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="fnebairro" type="text" name="fnebairro" size="70" onkeyup="javascript:this.value = this.value.toUpperCase();" maxlength="30">
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group-small m-r-15">
                                        <label class="label">Complemento</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="fnecomplemento" type="text" name="fnecomplemento" size="70" onkeyup="javascript:this.value = this.value.toUpperCase();">
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                            <div class="row row-space">
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Cidade</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="fnecidade" type="text" name="fnecidade" size="62" disabled onkeyup="javascript:this.value = this.value.toUpperCase();">
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">&nbsp;</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="fneuf" type="text" name="fneuf" size="3" disabled onkeyup="javascript:this.value = this.value.toUpperCase();">
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group-small">
                                        <label class="label">Cidade IBGE</label>                                        
                                        <div>                                          
                                            <span class="custom-dropdown">
                                                <select name="cidadeibge" id="cidadeibge" disabled>
                                                    <option id="cidcodigoibge" value="0">Faça a Pesquisa de Cidade IBGE</option>                                                
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
                                </div> 					
                            </div>
                            <div class="row row-space">
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Fone</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="fnefone" type="text" name="fnefone" size="18" onKeyPress="Mascara(this, Telefone);" onBlur="convertField(this);" maxlength=13>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group-small m-r-15">
                                        <label class="label">E-mail</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="fneemail" type="text" name="fneemail" size="70" maxlength=50>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <div class="row row-space">                                
                                <div class="col-2">
                                    <div class="p-t-15 centraliza">
                                        <button class="btn btn--radius-2 btn--blue" name="button2" type="button" id="botao" onClick=valida_form(1)><span id="botao-text" con>Incluir</span></button>
                                        <input name="hidden" type="hidden" id="acao" value="inserir">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="p-t-15 centraliza">                                        
                                        <button class="btn btn--radius-2 btn--green"  type="button" id="botao2" onClick=limpa_form(1)>Limpar</button>
                                    </div>
                                </div>
                            </div>
                            <div style="display:none;">
                                <tr style="display: none;">
                                    <td>&nbsp;</td>
                                    <td>Op&ccedil;&atilde;o:</td>
                                    <td colspan="3"><input name="radiobutton" id="radio1" type="radio" value="radiobutton" checked> C&oacute;digo <input type="radio" name="radiobutton" id="radio2" value="radiobutton"> N.Guerra <input type="radio" name="radiobutton" id="radio3" value="radiobutton">
                                        Raz&atilde;o <input type="radio" name="radiobutton" id="radio4" value="radiobutton"> CNPJ <input type="radio" name="radiobutton" id="radio5" value="radiobutton"> CPF</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr style="display: none;">
                                    <td width="0%">&nbsp;</td>
                                    <td width="14%">
                                        <div align="left">Pesquisar:</div>
                                    </td>
                                    <td colspan="3"><input id="pesquisa" type="text" name="pesquisa" size="70" onkeypress="maiusculo();" onblur="convertField(this);dadospesquisa(this.value);"></td>
                                    <td width="16%">
                                        <div align="center"><input name="button" type="button" id="button" onClick="dadospesquisa(pesquisa.value);" value="Pesquisar"></div>
                                    </td>
                                </tr>
                                <tr style="display: none;">
                                    <td>&nbsp;</td>
                                    <td>
                                        <div align="left">Campo:</div>
                                    </td>
                                    <td colspan="3"><select name="listDados" onChange="dadospesquisa2(this.value);">
                                            <option id="opcoes" value="0">__________________________________________</option>
                                        </select></td>
                                    <td>
                                        <div align="center"><input id="forcodigo" type="hidden" name="forcodigo" size="25"></div>
                                    </td>
                                </tr>
                                <tr style="display: none;">
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td colspan="3">&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr style="display: none;">
                                    <td>&nbsp;</td>
                                    <td>C&oacute;digo</td>
                                    <td colspan="3"><input id="forcod" type="text" name="forcod" size="10" onkeyup="javascript:this.value = this.value.toUpperCase();" disabled style="COLOR: #660000; FONT-WEIGHT: bold;"></td>
                                    <td>&nbsp;</td>
                                </tr>
                            </div>
                        </form>
                    </div>
                </div>                
            </div>
        </div> 
        <div class="wrapper wrapper--w960">
            <div class="result" id="MsgResultado"></div> 
        </div>  

        <input id="fnecodcidade" type="hidden" name="fnecodcidade" size="3" disabled onkeyup="javascript:this.value = this.value.toUpperCase();">
        <input name="hidden" type="hidden" id="acao" value="inserir">


        <script src="js/empresa.js"></script>
        <script src="js/geral.js"></script>

        <script language="JavaScript1.2">
            var tpfornecedor;
            tpfornecedor = 1;
        </script>


    </body>

</html>


