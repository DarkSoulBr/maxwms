<?php
$flagmenu = 4;
// Verificador de sessão
require("verifica.php");

//Verifica se a opção existe no Cadastros de Opção
$opcao = 'MANUTENCAO TRANSPORTADORAS';
$pagina = 'transportador.php';
$modulo = 4;  //Cadastros
$sub = 19;  //Diversos
$usuario = $_SESSION["id_usuario"];


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title>Tabela</title>

        <script src="js/transportador.js"></script>
        <script type="text/javascript" src="lib/jquery/js/jquery-1.3.2.min.js"></script>
        <script type="text/javascript">
            //a linha abaixo cria um novo pseudonimo $a
            //que será utilizado no lugar de $ ou de jQuery()
            var $a = jQuery.noConflict();

        </script>

    <noscript> 
        Habilite o Javascript para visualizar esta página corretamente...
    </noscript> 
    <style>
        .borda{border: 1px solid;}
        div{font-family: Verdana; font-size: 12px;}
        td{font-family: Verdana; font-size: 12px;}
        input{font-family: Verdana; font-size: 12px;}
        #altpedi, #altpedispc, #altpediblk,#altpedipst, #msg { display: none; font-style:italic; color:#B80000 }

    </style>

</head>
<body onLoad="dadospesquisarota(0)";>

    <div>
        <Center>
            <form name="formulario">
                <table width="400" height="200" border="2" cellspacing="0" cellpadding="0" bordercolor="#999999">
                    <tr>
                        <td>
                            <table width="100%"  height="20" border="0" cellpadding="0" cellspacing="0" bgcolor="#0000FF">
                                <tr>
                                    <td colspan="4" bgcolor="#3366CC" > 
                                        <div align="center"><font color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif"><strong>Cadastro 
                                                    de Transportadoras</strong></font></div>
                                    </td>
                                </tr>
                            </table>
                            <table width="100%" height="349" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
                                <tr> 
                                    <td>&nbsp;</td>
                                    <td><div align="left">Pesquisar:</div></td>
                                    <td><input id="pesquisa" type="text" name="pesquisa" size="50" onKeyPress="maiusculo()" onBlur="convertField(this)" ></td>
                                    <td><div align="center"> 
                                            <input name="button" type="button" id="button" onClick=dadospesquisa(pesquisa.value) value="Pesquisar">
                                        </div></td>
                                </tr>
                                <tr> 
                                    <td>&nbsp;</td>
                                    <td>Op&ccedil;&atilde;o:</td>
                                    <td><input name="radiobutton" id="radio1" type="radio" value="radiobutton" checked>
                                        Nome 
                                        <input type="radio" id="radio2" name="radiobutton" value="radiobutton">
                                        Raz&atilde;o Social
                                        <input type="radio" id="radio3" name="radiobutton" value="radiobutton">
                                        Código </td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr> 
                                    <td>&nbsp;</td>
                                    <td> <div align="left">Campo:</div></td>
                                    <td><select name="listDados" onChange="dadospesquisa2(this.value);">
                                            <option id="opcoes" value="0">____________________________________</option>
                                        </select></td>
                                    <td><div align="center"> 
                                            <!--input id="tracodigo" type="hidden" name="tracodigo" size="25"-->
                                        </div></td>
                                </tr>
                                <tr> 
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr> 
                                    <td>&nbsp;</td>
                                    <td><div align="left">Codigo</div></td>
                                    <td><input id="tracodigo" type="text" name="tracodigo" size="10" maxlength="10" onKeyPress="maiusculo()" onBlur="convertField(this)" style="BACKGROUND-COLOR: #FFFF99" disabled></td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td><div align="left">Cod.Datasul:</div></td>
                                    <td><input id="tradatasul" type="text" name="tradatasul" size="10" maxlength="10" onKeyPress="return soNums(event);" onBlur="convertField(this)" style="BACKGROUND-COLOR: #FFFF99"></td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr> 
                                    <td>&nbsp;</td>
                                    <td><div align="left">N.Guerra:</div></td>
                                    <td><input id="tranguerra" type="text" name="tranguerra" size="30" maxlength="30" onKeyPress="maiusculo()" onBlur="convertField(this)" style="BACKGROUND-COLOR: #FFFF99"></td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr> 
                                    <td>&nbsp;</td>
                                    <td>R.Social:</td>
                                    <td><input id="trarazao" type="text" name="trarazao" size="50" maxlength="50" onBlur="convertField(this)" onKeyPress="maiusculo()"></td>
                                    <td>&nbsp;</td>
                                </tr>

                                <tr> 
                                    <td>&nbsp;</td>
                                    <td>CNPJ:</td>
                                    <td>
                                        <input id="tracnpj" type="text" name="tracnpj" maxlength="18" size="22" onKeyPress="return soNums(event);" onBlur="validar(this);convertField(this);">
                                        <span id="msg">&nbsp</span>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>			

                                <tr> 
                                    <td>&nbsp;</td>
                                    <td>I.E.:</td>
                                    <td>
                                        <input id="traie" type="text" name="traie" maxlength="20" size="22" onBlur="convertField(this);">
                                        <span id="msg">&nbsp</span>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>            
                                <tr> 
                                    <td>&nbsp;</td>
                                    <td>Ponto Retirada:</td>
                                    <td><input name="radios" type="radio" id="radios1" value="radiobutton"> Sim <input type="radio" name="radios" id="radios2" value="radiobutton" checked> Não</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>Tolerância:</td>
                                    <td><input id="tolera" type="text" name="tolera" size="10" onblur="format(this.value, this.id);" style="text-align:right;">&nbsp;&nbsp;
                                        <input id="radiotol1" name="radiotol" type="radio" value="radiotol" checked> Percentual &nbsp;&nbsp;
                                        <input id="radiotol2" name="radiotol" type="radio" value="radiotol"> Valor                        
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr> 
                                    <td>&nbsp;</td>
                                    <td>Cep:</td>
                                    <td><input id="tracep" type="text" name="tracep" size="10" onBlur="pesquisacep(this.value);" style="BACKGROUND-COLOR: #FFFF99"></td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr> 
                                    <td>&nbsp;</td>
                                    <td>Endere&ccedil;o:</td>
                                    <td><input id="traendereco" type="text" name="traendereco" size="50" maxlength="50" onBlur="convertField(this)" onKeyPress="maiusculo()"></td>
                                    <td><div align="center">
                                            <input name="button" type="button" id="buttonend" onClick=dadospesquisaend(traendereco.value) value="Pesquisar">
                                        </div></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td> <div align="left">Pesquisa:</div></td>
                                    <td><select name="listDadosend" disabled onChange="dadospesquisaend2(this.value);" onBlur="desativa()">
                                            <option id="opcoesend" value="0">____________________________________</option>
                                        </select></td>
                                    <td><div align="center">
                                            <input id="endcodigo" type="hidden" name="endcodigo" size="25">
                                        </div></td>
                                </tr>
                                <tr> 
                                    <td>&nbsp;</td>
                                    <td>Bairro:</td>
                                    <td><input id="trabairro" type="text" name="trabairro" size="50" maxlength="72" onBlur="convertField(this)" onKeyPress="maiusculo()"></td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr> 
                                    <td>&nbsp;</td>
                                    <td>Cidade:</td>
                                    <td> 
                                        <!--
                                        <select name="select2" onChange="dadospesquisa2(this.value);">
                                          <option id="opcoes" value="0">__________________________________________</option>
                                        </select>
                                        -->
                                        <input id="tracidade" type="text" name="tracidade" size="50" disabled onKeyPress="maiusculo()"> 
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr> 
                                    <td>&nbsp;</td>
                                    <td>Estado:</td>
                                    <td> 
                                        <!--
                                        <select name="select3" onChange="dadospesquisa2(this.value);">
                                          <option id="opcoes" value="0">____</option>
                                        </select>
                                        -->
                                        <input id="trauf" type="text" name="trauf" size="3" disabled onKeyPress="maiusculo()"> 
                                        <input id="tracodcidade" type="hidden" name="tracodcidade" size="3" disabled onKeyPress="maiusculo()"> 
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr> 
                                    <td height="21">&nbsp;</td>
                                    <td>Fone:</td>
                                    <td><input id="trafone" type="text" name="trafone" size="18" maxlength="12" onKeyPress="maiusculo()"></td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr> 
                                    <td>&nbsp;</td>
                                    <td>Fax:</td>
                                    <td><input id="trafax" type="text" name="trafax" size="18" maxlength="12" onKeyPress="maiusculo()"></td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr> 
                                    <td>&nbsp;</td>
                                    <td>E-mail:</td>
                                    <td><input id="traemail" type="text" name="traemail" size="50" maxlength="50" onKeyPress="maiusculo()"></td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>Rota</td>
                                    <td><select name="listrotas" >
                                            <option id="opcoes2" value="0">______________</option>
                                        </select></td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>Tipo Serviço</td>
                                    <td><select name="listservicos" >
                                            <option id="opcoes3" value="0">______________</option>
                                        </select></td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr> 
                                    <td>&nbsp;</td>
                                    <td>Observa&ccedil;&otilde;es: </td>
                                    <td><input id="traobs" type="text" name="traobs" size="50" maxlength="50" onBlur="convertField(this)" onKeyPress="maiusculo()"></td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td nowrap="nowrap">Versão CONEMB:&nbsp;</td>
                                    <td>
                                        &nbsp;3.0<input id="conemb1" type="radio" name="conemb"/>
                                        &nbsp;3.1<input id="conemb2" type="radio" name="conemb"/>
                                        &nbsp;5.0<input id="conemb3" type="radio" name="conemb"/>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td nowrap="nowrap">Versão OCOREN:&nbsp;</td>
                                    <td>
                                        &nbsp;3.0<input id="ocoren1" type="radio" name="ocoren"/>
                                        &nbsp;3.1<input id="ocoren2" type="radio" name="ocoren"/>
                                        &nbsp;5.0<input id="ocoren3" type="radio" name="ocoren"/>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>

                                <tr>
                                    <td>&nbsp;</td>
                                    <td nowrap="nowrap">Versão DOCCOB:&nbsp;</td>
                                    <td>
                                        &nbsp;3.0<input id="doccob1" type="radio" name="doccob"/>
                                        &nbsp;3.1<input id="doccob2" type="radio" name="doccob"/>
                                        &nbsp;5.0<input id="doccob3" type="radio" name="doccob"/>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>

                                <tr>
                                    <td>&nbsp;</td>
                                    <td nowrap="nowrap">Versão NOTAFIS:&nbsp;</td>
                                    <td>
                                        &nbsp;3.0<input id="notfis1" type="radio" name="notfis"/>
                                        &nbsp;3.1<input id="notfis2" type="radio" name="notfis"/>
                                        &nbsp;5.0<input id="notfis3" type="radio" name="notfis"/>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>

                                <tr id="altpedi">
                                    <td colspan="2">&nbsp;</td>
                                    <td>Necessário selecionar a versão CONEMB, OCOREN, DOCCOB e NOTAFIS</td>
                                </tr>

                                <!--tr> 
                      <td>&nbsp;</td>
                      <td>Localização EDI: </td>
                      <td><input id="tracaminho" type="text" name="tracaminho" size="50" maxlength="50" onBlur="convertField(this)" onKeyPress="maiusculo()"></td>
                      <td>&nbsp;</td>
                    </tr-->

                                <tr>                 
                                    <td><input id="tracaminho" type="hidden" name="tracaminho" size="50" maxlength="50" onBlur="convertField(this)" onKeyPress="maiusculo()"></td>                
                                </tr>

                                <tr id="altpediblk">
                                    <td colspan="2">&nbsp;</td>
                                    <td>Preenchimento Obrigatório.</td>
                                </tr>
                                <tr id="altpedispc">
                                    <td colspan="2">&nbsp;</td>
                                    <td>Não é permitido espaço.</td>
                                </tr>
                                <tr id="altpedipst">
                                    <td colspan="2">&nbsp;</td>
                                    <td>Pasta não existe. Favor contatar o administrador.</td>
                                </tr>

                                <tr> 
                                    <td>&nbsp;</td>
                                    <td><div align="center"> 
                                            <input name="button2" type="button" id="botao" onClick=valida_form() value="Incluir">
                                        </div></td>
                                    <td><div align="center"> 
                                            <input type="button" id="botao2" onClick=limpa_form() value="Limpar">
                                        </div></td>
                                    <td><div align="center"> 
                                            <input type="button" id="botao3" onClick=verifica() value="Excluir">
                                        </div>
                                        <input name="hidden" type="hidden" id="acao" value="inserir"> 
                                    </td>
                                </tr>

                                <tr> 
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>

                                <tr bgcolor="#CCCCCC"> 
                                    <td colspan="4" valign="middle">&nbsp;<b><i>Contatos</i></b></td>
                                </tr>
                                <tr> 
                                    <td>&nbsp;</td>
                                    <td>Nome:</td>
                                    <td><input id="tracontato" type="text" name="tracontato" size="50" maxlength="50" onBlur="convertField(this)" onKeyPress="maiusculo()"></td>
                                    <td>&nbsp;</td>
                                </tr>

                                <tr> 
                                    <td>&nbsp;</td>
                                    <td>E-mail:</td>
                                    <td><input id="traemailcon" type="text" name="traemailcon" size="50" maxlength="50" onKeyPress="maiusculo()"></td>
                                    <td>&nbsp;</td>
                                </tr>

                                <tr> 
                                    <td>&nbsp;</td>
                                    <td>Cargo:</td>
                                    <td><input id="tracargo" type="text" name="tracargo" size="30" maxlength="20" onBlur="convertField(this)" onKeyPress="maiusculo()">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" id="botaocontato" value="OK" onclick="incluicontato();"></td>
                                    <td>&nbsp;</td>
                                </tr>							

                                <tr> 
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>

                            </table>
                        </td>
                    </tr>
                </table>

                <table width="100%" height="50" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">							

                    <tr> 
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>

                    <tr bgcolor="#FFFFFF">				
                        <td height="25" colspan="6">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">							
                                <tr bgcolor="#FFFFFF">
                                    <td height="25" colspan="6" align="center" width="100%">
                                        <div id="gridprodutomsg2" style="width:880px;" align="center">Nenhum Contato adicionado</div>
                                        <div id="gridproduto2" style="width:880px;" align="center">&nbsp;</div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr> 
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>

                </table>



            </form>
        </Center>
    </div>
    <br>
</body>
</html>
