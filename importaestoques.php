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

        <script src="js/importaestoques.js"></script>
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
                <table width="380" height="130" border="2" cellspacing="0" cellpadding="0" bordercolor="#999999">
                    <tr>
                        <td>
                            <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#3366CC">
                                <tr>
                                    <td colspan="4" valign="middle" height="25">
                                        <div align="center"><font color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif"><strong>Importação de Estoques</strong></font></div>
                                    </td>
                                </tr>
                                

                                <tr bgcolor="#CCCCCC">
                                    <td height="40" colspan="5">&nbsp;</td>
                                </tr>				

                                <tr bgcolor="#CCCCCC">
                                    <td colspan="4"><div align="center"><input type="button" id="botao3" onclick="imprimirconsulta();" value="Importar"></div></td>
                                </tr>				

                                <tr bgcolor="#CCCCCC">
                                    <td height="40" colspan="5">&nbsp;</td>
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
