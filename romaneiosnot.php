<?php
$flagmenu = 3;
// Verificador de sessão
require("verifica.php");
include 'include/jquerymax.php';
include 'include/css.php';

//Verifica se a opção existe no Cadastros de Opção
$opcao = 'ROMANEIOS GERA NOTAFIS';
$pagina = 'romaneiosnot.php';
$modulo = 3;  //Logistica
$sub = 14;  //Romaneios
$usuario = $_SESSION["id_usuario"];

$valor = trim($_GET["valor"]);
if ($valor == '') {
    $valor = 0;
}

$usuario = $_SESSION["id_usuario"];
?>
<!DOCTYPE html>
<html>
    <head>

        <!-- Required meta tags-->    
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Title Page-->
        <title>Romaneios - Geração de Arquivo de Integração</title> 

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
        </style>
    </head>

    <body onload="numero_romaneio('<?php echo $valor ?>')">
        <div id="retorno"></div>
        <div id="dialog" style="margin-left: 5px; margin-left: 5px;"></div>
        <div class="bg-gray p-t-10 font-lucida">
            <div class="wrapper wrapper--w780">
                <div class="card card-4">
                    <div class="card-header">
                        Romaneios - Geração de Arquivo de Integração
                    </div>
                    <div class="card-body">                    
                        <form name="formulario">
                            <div class="row row-space ">                                
                                <div class="col-3">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Número</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="pvnumero1" type="text" name="pvnumero1" size="10" onKeyPress="maiusculo()" onBlur="Z()">
                                        </div>
                                    </div>
                                </div>                                             
                                <div class="col-3">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">&nbsp;</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="pvnumero2" type="text" name="pvnumero2" size="10" onKeyPress="maiusculo()" onBlur="numero_romaneioX(this.value)">
                                        </div>
                                    </div>
                                </div>  
                                <div class="col-3">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Data</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="data" type="text" name="data" size="20" OnKeyPress="formatar('##/##/####', this)" onBlur="dataano(this, this.value)" maxlength="10" disabled readonly>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <div class="row row-space">
                                <div class="col-2">
                                    <div class="input-group-small">
                                        <label class="label">Veiculo</label>                                        
                                        <div>                                          
                                            <span class="custom-dropdown">
                                                <select name="listveiculos" onChange="dadospesquisaveiculo2(this.value, 0);"  onBlur="dadospesquisaveiculovalidar(this.value);" disabled>
                                                    <option id="opcoesveiculos" value="0">-- Escolha um Veiculo--</option>                                                
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Saida</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="saida" type="text" name="saida" size="20" OnKeyPress="formatar('##:##', this)" maxlength="5" readonly>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <div class="row row-space ">                                
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Motorista</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="motorista" type="text" name="motorista" size="20" onKeyPress="maiusculo()"  onBlur="convertField(this)" maxlength="30" readonly>
                                        </div>
                                    </div>
                                </div>                                             
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Ajudante</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="ajudante" type="text" name="ajudante" size="20" onKeyPress="maiusculo()"  onBlur="convertField(this)" maxlength="30" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-space ">                                
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Placa</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="placa" type="text" name="placa" size="20" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-space ">                                
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">KM Inicial</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="inicial" type="text" name="inicial" size="20" onKeyPress="maiusculo()" maxlength="10" readonly>
                                        </div>
                                    </div>
                                </div>                                             
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">KM Final</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="final" type="text" name="final" size="20" onKeyPress="maiusculo()" maxlength="10" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Tipo Frete</label>
                                        <div>
                                            <label class="radio-container m-r-15">Valor                                            
                                                <input name="radio" type="radio" id="radio1" onClick="opcao(1)" checked disabled>
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container m-r-15">Percentual                                            
                                                <input name="radio" type="radio" id="radio2" onClick="opcao(2)" disabled>
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container">Proprio
                                                <input name="radio" type="radio" id="radio3" onClick="opcao(3)" disabled>
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-space ">                                
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Valor</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="valor" type="text" name="valor" size="10" onKeyPress="return Tecla(event);" onBlur="convertField2(this), ver1()" disabled>
                                        </div>
                                    </div>
                                </div>                                             
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Percentual</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="percentual" type="text" name="percentual" size="5" onKeyPress="maiusculo()" value="0" onBlur="ver1()" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group-small m-r-15">
                                        <label class="label">Observações</label>
                                        <div class="input-group-small-icon">
                                            <textarea class="textarea--style-4" name="observacoes" id="observacoes" cols="55" rows="3" onKeyPress="maiusculo()"  onBlur="convertField(this)" readonly></textarea>                                                             
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-space" style="display: none">                                
                                <div class="col-2">
                                    <div class="input-group-small">
                                        <label class="label">Transportadora</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="txtPesquisaTransp" type="text" name="txtPesquisaTransp" size="50"  onKeyPress="maiusculo()" onBlur="convertField(this);" readonly>
                                        </div>
                                    </div>
                                </div>                                
                                <div class="col-3">
                                    <div class="input-group-small">
                                        <label class="label">&nbsp;</label>
                                        <div class="input-group-icon centraliza">
                                            <button class="btn-small btn--radius-2 btn--blue" name="consulta_transportadora" type="button" id="consulta_transportadora" onClick="pesquisaTransportadora()" disabled>Pesquisar</button>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>	
                            <div class="row row-space" style="display: none">
                                <div class="col-1">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Opção</label>
                                        <div>
                                            <label class="radio-container m-r-15">Cód.                                           
                                                <input type="radio" name="opcoesTipoPesquisaTransp" id="opcoesTipoPesquisaTransp1" value="1" align="middle" checked disabled>
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container m-r-15">Nome                                       
                                                <input type="radio" name="opcoesTipoPesquisaTransp" id="opcoesTipoPesquisaTransp2" value="2" align="middle" disabled>
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container">Razão
                                                <input type="radio" name="opcoesTipoPesquisaTransp" id="opcoesTipoPesquisaTransp3" value="3" align="middle" disabled>
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group-small">
                                        <label class="label">Transportadora</label>                                        
                                        <div id="resultado_transportadora">                                          
                                            <span class="custom-dropdown">
                                                <select name="listaPesquisaTransp" id="listaPesquisaTransp" disabled>
                                                    <option value="0">-- Escolha uma Transportadora --</option>                                                
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
                                </div> 
                            </div>

                            <div class="row row-space">                                
                                <div class="col-2">
                                    <div class="p-t-15 centraliza">
                                        <button class="btn btn--radius-2 btn--blue" name="buttonnovo" type="button" id="buttonnovo" onClick="limpa_form()">Cancela</button>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="p-t-15 centraliza">                                        
                                        <button class="btn btn--radius-2 btn--green" name="buttonimprimir" type="button" id="buttonimprimir" onClick="verificaimp(romcodigo.value)">Confirma</button>
                                    </div>
                                </div>
                            </div> 
                            <div style="display: none;">
                                <tr style="display: none;">
                                    <td width="18%"><div align="left">Palm:</div></td>
                                    <td width="82%"><select name="palm">
                                            <option id="palm" value="0">________________________________________</option>
                                        </select></td>
                                </tr>   
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
        <input type="hidden" name="usuario" id="usuario" size="10"  value='<? echo $usuario; ?>'>
        <input id="forcodigo" type="hidden" name="forcodigo" size="25">

        <div style="display: none;">
            <tr style="display: none;">
                <td>&nbsp;</td>
                <td><div align="left">Pedido:</div></td>
                <td><input id="pesquisapedido" type="text" name="pesquisapedido" size="10" onKeyPress="maiusculo()" onBlur=dadospesquisapedido(pesquisapedido.value) >
                    <input id="codigopedido" type="hidden" name="codigopedido" size="10"  >
                    <input id="emissao" type="hidden" name="emissao" size="10"  >

                    <input id="valpedido" type="hidden" name="valpedido" size="10"  >

                </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr style="display: none;">
                <td>&nbsp;</td>
                <td><div align="left">Cliente:</div></td>
                <td><input id="cliente" type="text" name="cliente" size="75" disabled></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>


            <tr style="display: none;">
                <td>&nbsp;</td>
                <td>Volumes:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
                <td><input id="volumespedido" type="text" name="volumespedido" size="10" onKeyPress="maiusculo()">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input name="enviarped" type="button" id="enviarped" onClick="verificaacesso()" value="Incluir">
                    <input name="acao" type="hidden" id="acao" value="Incluir">
                </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>

            <tr style="display: none;">
                <td width="18%"><div align="left">Palm:</div></td>
                <td width="82%"><select name="palm">
                        <option id="palm" value="0">________________________________________</option>
                    </select></td>
            </tr>
            <tr style="display: none;">
                <td colspan='2'> <CENTER>
                <input name="button" type="button" id="button" onClick=dadospesquisaveiculovalidar2(listveiculos.value) value="Salvar">
                &nbsp;&nbsp;                  
                <input name="buttonexcluir" type="button" id="buttonexcluir" onClick="verifica1(romcodigo.value)" value="Excluir">
                &nbsp;&nbsp;
                <input name="buttonpalm" type="button" id="buttonpalm" onClick="verificapalm(romcodigo.value)" value="Palm">
                &nbsp;&nbsp;                  
                <input id="radiolog0" input name="radiolog" type="radio" value="radiobutton" checked>
                Novo 
                <input id="radiolog1" input name="radiolog" type="radio" value="radiobutton">
                S/Logo 
                <input id="radiolog2" input name="radiolog" type="radio" value="radiobutton">
                C/Logo
                &nbsp;&nbsp;Envia E-mail:<input name="radioemail" type="radio" id="radioemail1" checked>Sim&nbsp;<input name="radioemail" type="radio" id="radioemail2">Não </CENTER></td>
    </tr>
</div>

<div id="msg" style="visibility: hidden;">&nbsp;<font face="Verdana" size="2">Processando...</font></div>

<script src="js/romaneiosnot.js"></script>
<script src="js/pesquisaFornecedor.js"></script>

<script type="text/javascript">
                    //a linha abaixo cria um novo pseudonimo $a
                    //que será utilizado no lugar de $ ou de jQuery()
                    var $a = jQuery.noConflict()
</script>

</body>

</html>