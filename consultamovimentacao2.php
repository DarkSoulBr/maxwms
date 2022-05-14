<?php
$flagmenu = 5;
// Verificador de sessão
require("verifica.php");

$usuario = $_SESSION["id_usuario"];

include 'include/jquery.php';
include 'include/css.php';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title>Tabela</title>

        <script src="js/consultamovimentacao2.js"></script>
        <script type="text/javascript" src="modulos/vendaAtacado/pedidos/adm/view/js/verificaAdm.js"></script>

    <noscript>
        Habilite o Javascript para visualizar esta página corretamente...
    </noscript>
    <style>
        .borda{border: 1px solid;}
        div{font-family: Verdana; font-size: 12px;}
        td{font-family: Verdana; font-size: 12px;}
        input{font-family: Verdana; font-size: 12px;}
        select{font-family: Verdana; font-size: 12px;}
    </style>

</head>
<div id="retorno"></div>
<body onLoad="dadospesquisadeposito(0, 0)";>

    <div>
        <Center>
            <!--form action="consultamovimentacaoimp2.php" method="post"-->
            <form name="formulario" method="POST">
                <table width="700" height="220" border="2" cellspacing="0" cellpadding="0" bordercolor="#999999">
                    <tr>
                        <td>
                            <table width="100%"  height="20" border="0" cellpadding="0" cellspacing="0" bgcolor="#3366CC">
                                <tr>
                                    <td colspan="4" >
                                        <div align="center"><font color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif"><strong>Consulta Movimentação de Produtos - Analítico</strong></font></div>
                                    </td>
                                </tr>
                            </table>
                            <table width="100%" height="200" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">

                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>

                                <tr>
                                    <td><span class="style3"></span></td>
                                    <td><span class="style3">Codigo</span></td>
                                    <td colspan="3"><span class="style3">
                                            <input id="codigoproduto" type="text" name="codigoproduto" size="6" OnKeyPress="formatar_fun(this)" onBlur="convertField(this);dadospesquisapertence(this.value)">
                                            Produto
                                            <input id="produto" type="text" name="produto" size="59" onKeyPress="maiusculo()" onBlur="convertField(this);pesquisaprodutos(this.value);" >
                                        </span></td>
                                    <td><span class="style3"></span></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>Pesquisa</td>
                                    <td colspan="3"> <select name="pesquisaproduto" onBlur="pesquisacod(this.value)">
                                            <option id="pesquisaproduto" value="0">_________________________________________________________</option>
                                        </select> </td>
                                    <td>&nbsp;</td>
                                </tr>


                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td>Inicio:</td>
                                    <td colspan="3" ><input type="text" name="dataini" id="dataini" onBlur="dataano(this, this.value)" maxlength="10" size="12"></td>
                                    <td>&nbsp;</td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td>Final:</td>
                                    <td colspan="3" ><input type="text" name="datafim" id="datafim" onBlur="dataano(this, this.value)" maxlength="10" size="12"></td>
                                    <td>&nbsp;</td>
                                </tr>	

                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td>Estoque:</td>
                                    <td colspan="3" > 	
                                        <select name="deposito">
                                            <option id="deposito" value="0">______________________</option>
                                        </select>			
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>			  

                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="6"><div align="center">
                                            <input name="button3" type="button" id="botao3" onClick="consultar()" value="Consultar">

                                            &nbsp;&nbsp;
                                            <input name="button" type="button" id="botao" onClick=imp() value="Imprimir">

                                            &nbsp;&nbsp;
                                            <input name="button2" type="button" id="botao2" onClick=excel() value="Excel">

                                            <!--input name="button" type="button" id="botao" onClick=cons() value="Consultar (Antigo)"-->


                                        </div></td>
                                </tr>
                            </table>

                        </td>
                    </tr>
                </table>
            </form>
            <div id="resultado"></div>
        </Center>
    </div>
    <br>
</body>
</html>
