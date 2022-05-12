<?php
$flagmenu = 6;
// Verificador de sessão
require("verifica.php");
include 'include/jquery.php';
include 'include/css.php';

$usuario = $_SESSION["id_usuario"];

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"> 
<html>
    <head>
        <title>Tabela</title>

        <script src="js/exportanfe.js"></script>
        <script type="text/javascript">
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
        .borda2{border: 1px solid; font-size: 12px;font-family: Courier New}
    </style>

</head>

<body>

    <Center>
        <div id="msg" style="visibility: hidden;">&nbsp;<font face="Verdana" size="2">Processando...</font></div>
        <div id="resultado">
            <form name="formulario" method="POST">
                <table width="680" height="130" border="2" cellspacing="0" cellpadding="0" bordercolor="#999999">
                    <tr>
                        <td>
                            <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#3366CC">
                                <tr>
                                    <td colspan="4" valign="middle" height="25">
                                        <div align="center"><font color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif"><strong>Exportação de Notas de Entrada</strong></font></div>
                                    </td>
                                </tr>
                                <tr bgcolor="#CCCCCC">
                                    <td height="45">&nbsp;</td>
                                    <td valign="middle" width="30%"><div align="left"><b>Filtro:</b></div></td>
                                    <td valign="middle" width="70%"><input type="radio" name="todos" id="todoss" value="Sim" onkeypress="mostrartr();" onclick="mostrartr();" checked="checked">Todos &nbsp; <input type="radio" name="todos" id="todosn" value="Não" onkeypress="mostrartr();" onclick="mostrartr();">Data &nbsp;<input type="radio" name="todos" id="todosc" value="CSV" onkeypress="mostrartr();" onclick="mostrartr();">CSV&nbsp;<input type="radio" name="todos" id="todosp" value="Produtos" onkeypress="mostrartr();" onclick="mostrartr();">Nota&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr bgcolor="#CCCCCC" style="display:none;" id="lin1">
                                    <td height="35">&nbsp;</td>
                                    <td valign="middle"><div align="left"><b>Data:</b></div></td>
                                    <td valign="middle"><input type="text" name="dataini" id="dataini" OnKeyPress="formatar('##/##/####', this)" onBlur="formata_data2(this, this.value)" maxlength="10" size="12"></td>
                                    <td>&nbsp;</td>
                                </tr>
                              
                                <tr bgcolor="#CCCCCC" style="display:none;" id="lin7">
                                    <td height="35">&nbsp;</td>
                                    <td valign="middle"><div align="left"><b>Arquivo:</b></div></td>
                                    <td valign="middle"><div align="left"><b>/home/teltex/nfe.csv</b></div></td>
                                    <td>&nbsp;</td>
                                </tr> 


                            </table>
                            <table width="100%" height="100" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">

                                <tr bgcolor="#CCCCCC" style="display:none;" id="lin8">
                                    <td colspan="8">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">

                                            <tr bgcolor="#CCCCCC">
                                                <td valign="middle" colspan="8">&nbsp;</td>
                                            </tr>	

                                            <tr bgcolor="#CCCCCC">
                                                <td valign="middle" colspan="8">&nbsp;<b>Produtos:</b></td>
                                            </tr>

                                            <tr bgcolor="#CCCCCC">
                                                <td valign="middle" colspan="8">&nbsp;</td>
                                            </tr>

                                            <tr bgcolor="#CCCCCC">
                                                <td valign="middle" colspan="8">&nbsp;&nbsp;&nbsp;Opção:
                                                    <input type="radio" name="opcaop" id="opcaop1" value="1" align="absmiddle" checked> Número &nbsp;<input type="radio" name="opcaop" id="opcaop2" value="2" align="absmiddle"> Pedido </td>
                                            </tr>

                                            <tr bgcolor="#CCCCCC">
                                                <td valign="middle" colspan="8">&nbsp;</td>
                                            </tr>							

                                            <tr bgcolor="#CCCCCC">

                                                <td valign="middle" colspan="8">&nbsp;&nbsp;&nbsp;Pesquisa:
                                                    <input type="text" name="consultap" id="consultap" size="22" onkeyup="this.value = this.value.toUpperCase();">&nbsp;<input type="button" name="pesquisarp" id="pesquisarcp" value="Pesquisar" onclick="load_grid_produtos();" ></td>

                                            </tr>

                                        </table>
                                    </td>	


                                </tr>

                                <tr bgcolor="#CCCCCC" style="display:none;" id="lin9">
                                    <td>
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">					

                                            <tr bgcolor="#CCCCCC">
                                                <td valign="middle" colspan="4">&nbsp;</td>
                                            </tr>
                                            <tr bgcolor="#CCCCCC">
                                                <td height="50">&nbsp;</td>
                                                <td valign="middle" colspan="2" align="center"><b>Selecione a(s) Notas(s):</b>
                                                    <br><div id="resultado5x"><select id="pesquisap" name="pesquisap" multiple style="height:150px;width:300px;" onkeypress="javascript:insertBeforeSelected('pesquisap', '13', 'produtos_selecionados');"></select></div></td>
                                                <td>&nbsp;</td>
                                            </tr>

                                            <tr bgcolor="#CCCCCC">
                                                <td valign="middle" colspan="4">
                                                    <input type="hidden" name="produtoc" id="produtoc" size="40" readonly disabled>
                                                </td>
                                            </tr>





                                        </table>


                                    </td>
                                    <td valign="middle" align="center"><br><br><br><br><a href="javascript:insertBeforeSelected('pesquisap','13','produto_selecionados');"><img src="images/add.jpg" border="0"></a>&nbsp;
                                        <br><br><br><br><a href="javascript:removeOption('46','produto_selecionados');"><img src="images/remove.jpg" border="0"></a>&nbsp;</td>
                                    <td valign="bottom" align="center"><b>Nota(s) Selecionada(s):</b>
                                        <br><select id="produto_selecionados" name="produto_selecionados[]" multiple style="height:150px;width:290px;" onkeypress="removeOption(this, event, 'produto_selecionados');"></select></td>

                                    <td>&nbsp;</td>


                                </tr>

                                <tr bgcolor="#CCCCCC">
                                    <td height="17" colspan="5">&nbsp;</td>
                                </tr>				

                                <tr>
                                    <td colspan="4"><div align="center"><input type="button" id="botao3" onclick="imprimirconsulta();" value="Exportar"></div></td>
                                </tr>				

                                <tr bgcolor="#CCCCCC">
                                    <td height="17" colspan="5">&nbsp;</td>
                                </tr>

                            </table>

                        </td>
                    </tr>
                </table>

            </form>
        </div>
    </Center>
    <br>
</body>
</html>
