<?php
$flagmenu = 3;
// Verificador de sessão
require("verifica.php");
include 'include/jquerymax.php';
include 'include/css.php';

//Verifica se a opção existe no Cadastros de Opção
$opcao = 'ROMANEIOS INCLUSAO (CD-SP)';
$pagina = 'romaneiosinc.php';
$modulo = 3;  //Logistica
$sub = 14;  //Romaneios
$usuario = $_SESSION["id_usuario"];

$usuario = $_SESSION["id_usuario"];
$nomeUsuario = $_SESSION["nome_usuario"];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>      
        <title>Tabela</title>

        <script src="js/romaneiosinc.js"></script>
        <script src="js/pesquisaFornecedor.js"></script>
        <script type="text/javascript">
            //a linha abaixo cria um novo pseudonimo $a
            //que será utilizado no lugar de $ ou de jQuery()
            var $a = jQuery.noConflict()
        </script>

    <noscript>
        Habilite o Javascript para visualizar esta página corretamente...
    </noscript>
    <style>
        .borda{border: 1px solid;}
        div{font-family: Verdana; font-size: 12px;}
        td{font-family: Verdana; font-size: 12px;}
        input{font-family: Verdana; font-size: 12px;}
        .borda2{border: 0px solid; font-size: 0px; color: white;}
    </style>
</head>
<div id="retorno"></div>
<div id="dialog" style="margin-left: 5px; margin-left: 5px; background:white;"></div>
<body onload="numero_romaneio('0');verificarAcesso(<? echo $usuario; ?>);verificarAcessoConferencia(<? echo $usuario; ?>)">

    <Center>
        <form name="formulario">
            <table width="640" height="200" border="2" cellspacing="0" cellpadding="0" bordercolor="#999999">
                <tr>
                    <td>
                        <table width="100%"  height="20" border="0" cellpadding="0" cellspacing="0" bgcolor="#3366CC">
                            <tr>
                                <td colspan="5" >
                                    <div align="center"><font color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif"><strong>Inclusão de Romaneios</strong></font></div>
                                </td>
                            </tr>
                        </table>

                        <table width="100%" height="180" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">

                            <tr>
                                <td>&nbsp;<input type="hidden" name="usuario" id="usuario" size="10"  value='<? echo $usuario; ?>'></td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>Numero:</td>
                                <td><input id="pvnumero1" type="text" name="pvnumero1" size="10" onKeyPress="maiusculo()" onBlur="Z()" disabled>/
                                    <input id="pvnumero2" type="text" name="pvnumero2" size="10" onKeyPress="maiusculo()" onBlur="numero_romaneioX(this.value)" disabled>
                                    <input id="pvnumero" type="hidden" name="pvnumero" size="10" onKeyPress="maiusculo()">
                                    <input id="romcodigo" type="hidden" name="romcodigo" size="2" value="0" >
                                </td>
                                <td>Data:</td>
                                <td align="left">
                                    <input id="data" type="text" name="data" size="20" OnKeyPress="formatar('##/##/####', this)" onBlur="dataano(this, this.value)" maxlength="10" disabled ></td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>Veiculo:</td>
                                <td>
                                    <select name="listveiculos" onChange="dadospesquisaveiculo2(this.value, 0);"  onBlur="dadospesquisaveiculovalidar(this.value);">
                                        <option id="opcoesveiculos" value="0">______________</option>
                                    </select>
                                </td>
                                <td>Saida:</td>
                                <td align="left">
                                    <input id="saida" type="text" name="saida" size="20" OnKeyPress="formatar('##:##', this)" maxlength="5"></td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>Motorista:</td>
                                <td><input id="motorista" type="text" name="motorista" size="20" onKeyPress="maiusculo()"  onBlur="convertField(this)" maxlength="30" ></td>
                                <td>Ajudante:</td>
                                <td><input id="ajudante" type="text" name="ajudante" size="20" onKeyPress="maiusculo()"  onBlur="convertField(this)" maxlength="30" ></td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr> 
                                <td>Placa:</td>
                                <td align="left">
                                    <input id="inicial" type="text" name="inicial" size="20" onKeyPress="maiusculo()" onBlur="convertField(this)" maxlength="25" >
                                </td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>

                            <tr style="display: none;">
                                <td>KM Inicial:</td>
                                <td><input id="placa" type="text" name="placa" size="20" disabled></td>
                                <td>KM Final:</td>
                                <td align="left">
                                    <input id="final" type="text" name="final" size="20" onKeyPress="maiusculo()" maxlength="10"></td>
                                <td>&nbsp;<input id="radiolog0" input name="radiolog" type="radio" value="radiobutton" checked>
                                    Novo 
                                    <input id="radiolog1" input name="radiolog" type="radio" value="radiobutton">
                                    S/Logo 
                                    <input id="radiolog2" input name="radiolog" type="radio" value="radiobutton">
                                    C/Logo</td>
                            </tr>
                            <tr>
                                <td>Tipo Frete:</td>
                                <td align="center">
                                    <input name="radio" type="radio" id="radio1" onClick="opcao(1)" checked>
                                    Valor
                                </td>
                                <td>
                                    <input name="radio" type="radio" id="radio2" onClick="opcao(2)" >
                                    Percentual
                                </td>
                                <td>
                                    <input name="radio" type="radio" id="radio3" onClick="opcao(3)" >
                                    Proprio
                                </td>
                            </tr>
                            <tr>
                                <td>Valor :</td>
                                <td><input id="valor" type="text" name="valor" size="10" onKeyPress="return Tecla(event);" onBlur="convertField2(this), ver1()" ></td>
                                <td align="left">Percentual :</td>
                                <td align="left"><input id="percentual" type="text" name="percentual" size="5" onKeyPress="maiusculo()" value="0" onBlur="ver1()" disabled></td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>Observações:</td>
                                <td colspan='3'>
                                    <textarea name="observacoes" id="observacoes" cols="55" rows="3" onKeyPress="maiusculo()"  onBlur="convertField(this)" ></textarea>
                                </td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>Emitido por:</td>
                                <td colspan='3' align="left"><input id="emissor" type="text" name="emissor" size="50" value='<? echo $nomeUsuario; ?>' onKeyPress="maiusculo()" onBlur="convertField(this)" maxlength="50" disabled>
                                </td>                                
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>

                            <tr>
                                <td width="14%"><div align="left">Transportadora:</div></td>
                                <td colspan="3"><input id="txtPesquisaTransp" type="text" name="txtPesquisaTransp" size="50"  onKeyPress="maiusculo()" onBlur="convertField(this);">
                                    &nbsp;&nbsp;<input name="consulta_transportadora" type="button" id="consulta_transportadora" onClick="pesquisaTransportadora()" value="Pesquisar">
                                </td>
                            </tr>
                            <tr>
                                <td>Op&ccedil;&atilde;o:</td>
                                <td colspan="3">
                                    <input type="radio" name="opcoesTipoPesquisaTransp" id="opcoesTipoPesquisaTransp1" value="1" align="middle" checked>Codigo
                                    <input type="radio" name="opcoesTipoPesquisaTransp" id="opcoesTipoPesquisaTransp2" value="2" align="middle">Nome
                                    <input type="radio" name="opcoesTipoPesquisaTransp" id="opcoesTipoPesquisaTransp3" value="3" align="middle" >Razão
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>
                                    <div align="left">Transportadora:</div>
                                </td>
                                <td colspan="3">
                                    <div id="resultado_transportadora"> 
                                        <select name="listaPesquisaTransp" id="listaPesquisaTransp">
                                            <option  value="0">_</option>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div align="center">
                                        <input id="forcodigo" type="hidden" name="forcodigo" size="25">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>

                           
                        </table>
                        <table width="100%"  height="20" border="0" cellpadding="0" cellspacing="0" bgcolor="#3366CC">
                            <tr>
                                <td colspan="5" >
                                    <div align="center"><font color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif"><strong>Pedidos / Embarques</strong></font></div>
                                </td>
                            </tr>
                        </table>
                        <table width="100%" height="80" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td><div align="left">Número:</div></td>
                                <td><input id="pesquisapedido" type="text" name="pesquisapedido" size="10" onKeyPress="maiusculo()" onBlur=dadospesquisapedido(pesquisapedido.value) >
                                    &nbsp;&nbsp;&nbsp;<input id="radioped0" input name="radioped" type="radio" value="radiobutton" checked>
                                    Pedido&nbsp;&nbsp;&nbsp;
                                    <input id="radioped1" input name="radioped" type="radio" value="radiobutton">
                                    Embarque
                                    <input id="codigopedido" type="hidden" name="codigopedido" size="10"  >
                                    <input id="emissao" type="hidden" name="emissao" size="10"  >

                                    <input id="valpedido" type="hidden" name="valpedido" size="10"  >
                                    <input id="pedidoexpedido" type="hidden" name="pedidoexpedido" size="10">
                                    <input id="pedidoconferido" type="hidden" name="pedidoconferido" size="10">

                                </td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td><div align="left">Cliente:</div></td>
                                <td><input id="cliente" type="text" name="cliente" size="75" disabled></td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>


                            <tr>
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
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>

                        </table>

                        <table width="100%"  height="20" border="0" cellpadding="0" cellspacing="0" bgcolor="#3366CC" style="display: none;">
                            <tr>
                                <td colspan="5" >
                                    <div align="center"><font color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif"><strong>Pedidos Conferidos</strong></font></div>
                                </td>
                            </tr>
                        </table>
                        <table width="100%" height="60" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC" style="display: none;">
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>

                            <tr>
                                <td>Data Inicio:</td>
                                <td><input id="dtinicio" type="text" name="dtinicio" size="12" onKeyPress="formatar('##/##/####', this)" onBlur="dataano(this, this.value)" maxlength="30" ></td>
                                <td>Data Final:</td>
                                <td><input id="dtfinal" type="text" name="dtfinal" size="12" onKeyPress="formatar('##/##/####', this)" onBlur="dataano(this, this.value)" maxlength="30" ></td>
                                <td>&nbsp;</td>
                            </tr>

                            <tr>
                                <td>Opção:</td>
                                <td><input id="radiocon0" input name="radiocon" type="radio" value="radiobutton" checked>
                                    Conferidos&nbsp;&nbsp;&nbsp;
                                    <input id="radiocon1" input name="radiocon" type="radio" value="radiobutton">
                                    Coletor</td>
                                <td>Coletor:</td>
                                <td><select name="palm">
                                        <option id="palm" value="0">_____</option>
                                    </select></td>
                                <td>&nbsp;</td>
                            </tr>                

                            <tr> 
                                <td colspan='5'> <div align="center">                            
                                        <input name="buttonconfere" type="button" id="buttonconfere" onClick="pesquisaconferidos()" value="Processar">
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>

                        </table>		 

                        <table width="100%"  height="20" border="0" cellpadding="0" cellspacing="0" bgcolor="#3366CC">
                            <tr>
                                <td colspan="5" >
                                    <div align="center"><font color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif"><strong></strong></font></div>
                                </td>
                            </tr>
                        </table>

                        <table width="100%" height="50" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">

                            <tr> 
                                <td colspan='2'> <CENTER>
                                        <input name="button" type="button" id="button" onClick=dadospesquisaveiculovalidar2(listveiculos.value) value="Salva">
                                        &nbsp;&nbsp;
                                        <input name="buttonnovo" type="button" id="buttonnovo" onClick="limpa_form()" value="Novo">
                                        &nbsp;&nbsp;
                                        <input name="buttonexcluir" type="button" id="buttonexcluir" onClick="verifica1(romcodigo.value)" value="Exclui">
                                        &nbsp;&nbsp;
                                        <input name="buttonpalm" type="button" id="buttonpalm" onClick="verificanot(romcodigo.value)" value="Exporta">
                                        &nbsp;&nbsp;
                                        <input name="buttonimprimir" type="button" id="buttonimprimir" onClick="verificaimp(romcodigo.value)" value="Imprime">
                                    </CENTER></td>
                            </tr>
                        </table>


                    </td>
                </tr>

            </table>


            </div>

            <div id="msg" style="visibility: hidden;">&nbsp;<font face="Verdana" size="2">Processando...</font></div><Center>
                <div id="resultado">
            </Center>
            </div>


        </form>

    </Center>
</div>
<br>


</body>
</html>
