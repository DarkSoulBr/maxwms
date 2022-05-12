<?php
$flagmenu = 2;
// Verificador de sessão
require("verifica.php");

$usuario = $_SESSION["id_usuario"];
?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title>Cancelamento de Cte</title>

        <script src="js/cartacorrecaocte.js"></script>
        <script src="js/geral.js"></script>

    <noscript>
        Habilite o Javascript para visualizar esta página corretamente...
    </noscript>
    <style>
        .borda{border: 1px solid;}
        div{font-family: Verdana; font-size: 12px;}
        td{font-family: Verdana; font-size: 12px;}
        input{font-family: Verdana; font-size: 12px;}
    </style>

</head>

<div id="dialog" style="margin-left: 5px; margin-left: 5px; background:white;"></div>
<body onLoad="dadospesquisatipo(0);">

    <Center>
        <form name="formulario" method="POST">
            <table width="700" height="230" border="2" cellspacing="0" cellpadding="0" bordercolor="#999999">
                <tr>
                    <td width="100%">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#4f5963">
                            <tr>
                                <td valign="middle" height="25"><div align="center"><font color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif"><strong>Carta de Correção Eletrônica CC-e</strong></font></div></td>
                            </tr>
                            <tr bgcolor="#CCCCCC">
                                <td valign="top" width="100%">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tr bgcolor="#CCCCCC">
                                            <td height="10" colspan="6">&nbsp;</td>
                                        </tr>



                                        <tr bgcolor="#CCCCCC">
                                            <td height="10" colspan="6">&nbsp;</td>
                                        </tr>

                                        <tr>
                                            
                                            <td width="17">&nbsp;</td>
                                            <td valign="middle" width="105">Opção:</td>                                            
                                            <td colspan="4">
                                                <input type="radio" name="radiobutton" id="radio1" value="radiobutton" checked> Nº Controle
                                                <input type="radio" name="radiobutton" id="radio2" value="radiobutton"> Nº CT-e
                                                <input type="radio" name="radiobutton" id="radio3" value="radiobutton"> Chave
                                            </td>                                            
                                           
                                        </tr>

                                        <tr bgcolor="#CCCCCC">
                                            <td height="10" colspan="6">&nbsp;</td>
                                        </tr>

                                        <tr bgcolor="#CCCCCC">
                                            <td width="17">&nbsp;</td>
                                            <td valign="middle">Pesquisar:</td>
                                            <td colspan="4">
                                                <input id="pesquisa" type="text" name="pesquisa" size="37" maxlength="30" onKeyPress="maiusculo()" onBlur="convertField(this);">
                                                &nbsp;
                                                <input name="button" type="button" id="button" onClick=dadospesquisa(pesquisa.value) value="Pesquisar">
                                            </td>
                                        </tr>
                                        
                                        <tr bgcolor="#CCCCCC">
                                            <td height="10" colspan="6">&nbsp;</td>
                                        </tr>
                                        
                                        <tr>
                                            <td width="17">&nbsp;</td>
                                            <td valign="middle">Nº Controle:</td>                                            
                                            <td colspan="4">
                                                <input id="controle" type="text" name="controle" size="10" disabled>                                                
                                                <input id="ctecodigo" type="hidden" name="ctecodigo" size="10">
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <td width="17">&nbsp;</td>
                                            <td valign="middle">Nº CT-e:</td>                                            
                                            <td colspan="4">                                                
                                                <input id="numero" type="text" name="numero" size="10" disabled>                                                
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <td width="17">&nbsp;</td>
                                            <td valign="middle">Chave:</td>                                            
                                            <td colspan="4">
                                                <input id="chave" type="text" name="chave" size="60" disabled>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td width="17">&nbsp;</td>
                                            <td valign="middle">Protocolo:</td>                                            
                                            <td colspan="4">
                                                <input id="protocolo" type="text" name="protocolo" size="60" disabled>
                                            </td>
                                        </tr>  

                                        <tr bgcolor="#CCCCCC">
                                            <td height="17" colspan="6">
                                                <input type="hidden" name="usuario" id="usuario" size="10"  value='<? echo $usuario; ?>'>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td height="17">&nbsp;</td>
                                            <td valign="middle" colspan="4">Detalhamento da Carta de Correção:</td>			            		
                                            <td>&nbsp;</td>
                                        </tr>		

                                        <tr bgcolor="#CCCCCC">
                                            <td height="10" colspan="6">&nbsp;</td>
                                        </tr>
                                        
                                        <tr bgcolor="#CCCCCC" >
                                            <td height="17">&nbsp;</td>
                                            <td valign="middle">Tipo:</td>
                                            <td valign="middle" colspan="4" >			               		
                                                <select name="listtipos" onChange="dadostipos(this.value);">
                                                    <option id="opcoes11" value="0">___________________________________________</option>
                                                </select>											
                                            </td>
			            	</tr>

                                        <tr>							
                                            <td width="17">&nbsp;</td>
                                            <td valign="middle">Grupo:</td>
                                            <td valign="middle" colspan="5">
                                                <input type="text" name="grupo" id="grupo" size="12">&nbsp;
                                            </td>
                                        </tr>		

                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>Campo:</td>
                                            <td colspan="2">
                                                <input id="campo" type="text" name="campo" size="12" maxlength="10">
                                            </td>	
                                            <td>&nbsp;</td>
                                        </tr>
                                        
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>Item:</td>
                                            <td colspan="2">
                                                <input id="item" type="text" name="item" size="12" maxlength="10">
                                            </td>	
                                            <td>&nbsp;</td>
                                        </tr>
                                        
                                        <tr>
                                            <td height="17">&nbsp;</td>
                                            <td valign="middle">Valor:</td>
                                            <td valign="middle" colspan="3">								
                                                <textarea id="observacoes" name="observacoes" cols="72" rows="3" onBlur="convertField(this);"></textarea>								
                                            </td>
                                            <td>&nbsp;</td>
			            	</tr>
                                        
                                        <tr bgcolor="#CCCCCC">
                                            <td colspan="6"> <Center>
                                                    <input type="button" id="botaocli" value="Incluir" onclick="incluinotacli();">
                                                </Center></td>                
                                        </tr>

                                        <tr bgcolor="#CCCCCC">
                                            <td height="20" colspan="6">&nbsp;</td>
                                        </tr>

                                    </table>
                                </td>
                            </tr>


                            <tr>				
                                <td height="25" colspan="6">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">														
                                        <tr bgcolor="#CCCCCC">
                                            <td height="25" colspan="6" align="center" width="100%">
                                                <div id="gridprodutomsg2" style="width:693px;" align="center">Nenhum Evento Adicionado!</div>
                                                <div id="gridproduto2" style="width:693px;" align="center">&nbsp;</div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                            <tr bgcolor="#CCCCCC"> 
                                <td height="17" colspan="4">&nbsp;</td>
                            </tr>	

                            <tr bgcolor="#CCCCCC">
                                <td colspan="6"> <Center>
                                        <input type="button" id="botao3" onClick=env("<? echo $usuario ?>") value="Confirma">
                                        &nbsp;&nbsp;&nbsp;                                        
                                        <input type="button" id="cancelaPedido" onclick="cancelarPedido()" value="Cancela">
                                    </Center></td>                
                            </tr>

                            <tr bgcolor="#CCCCCC">
                                <td height="20" colspan="6">&nbsp;</td>
                            </tr>

                        </table>
                    </td>
                </tr>
            </table>
        </form>
        <div id="msg" style="visibility: hidden;">&nbsp;<font face="Verdana" size="2">Processando...</font></div>
        <div id="resultado"></div>
    </Center>
    <br>
</body>


</html>
