<?php
//pega da pasta de istalacao
$arr = explode("/", $_SERVER['REQUEST_URI']);
$root = $arr[1];

//pega as configurações do servidor
require_once($_SERVER['DOCUMENT_ROOT'] . "/$root/include/config.php");

/**
 * Arquivo de Interface de Administração de Pedidos.
 *
 * Entrada de dados para fazer lista dos pedidos no estacionamento.
 * Este arquivo aquivo segue os padroes estabelecidos no dTrade. 
 * 
 * @name admPedido
 * @category vendaAtacado/pedido/adm
 * @package modulos/vendaAtacado/pedido/adm/view
 * @link modulos/vendaAtacado/pedido/adm/view/liberacaoPedido.php
 * @version 1.0
 * @since 14/05/2010
 * @author wellington <wellington@centroatacadista.com.br>
 * @copyright MaxTrade
 */
?>

<!-- incluindo script jquery para consulta pedido para adm-->
<script type="text/javascript" src="modulos/vendaAtacado/pedidos/adm/view/js/consultaPedidos.js"></script>

<!-- incluindo script jquery para validação administracao pedido -->
<script type="text/javascript" src="modulos/vendaAtacado/pedidos/adm/view/js/validaAdm.js"></script>

<!-- incluindo script jquery para verificacao administracao pedido -->
<script type="text/javascript" src="modulos/vendaAtacado/pedidos/adm/view/js/verificaAdm.js"></script>

<!-- incluindo script jquery para funcoes administracao pedido -->
<script type="text/javascript" src="modulos/vendaAtacado/pedidos/adm/view/js/funcoes.js"></script>

<!-- incluindo script jquery - Popula Combox -->
<script type="text/javascript" src="lib/jquery/max/populaComboxTipoPedidos.js"></script>
<script type="text/javascript" src="lib/jquery/max/populaComboxEstoquesFisico.js"></script>



<script type="text/javascript" >

    usValue = $('#usuario').val();

    token = usValue.split(",");

    $.each(token, function (key, value) {

        /*
         if ( value.match(/\"nivel\":\"2\"/)){
         location.href = "admpedido.php"; 
         } 
         */


    });

</script>

<div align="center">
    <div id="retorno"></div>
    <div id="dialog" style="margin-left: 5px; margin-left: 5px;"></div>

    <table id="tblPrincipal" border="2" cellspacing="0" cellpadding="0" bordercolor="#999999">
        <tr>
            <td>
                <table width="100%" height="20" border="0" cellpadding="0"
                       cellspacing="0" bgcolor="#3366CC">
                    <tr>
                        <td colspan="5">
                            <div align="center"><font color="#FFFFFF"
                                                      face="Verdana, Arial, Helvetica, sans-serif"><strong>Administração de Pedido</strong></font></div>
                        </td>
                    </tr>
                </table>

                <div id="accordion">

                    <h3><a href="#">Localizar</a></h3>
                    <div style="background:#CCCCCC;">
                        <table width="100%" border="0" cellpadding="0"
                               cellspacing="0" bgcolor="#CCCCCC">

                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>

                            <tr bgcolor="#CCCCCC">
                                <td valign="middle" align="center" colspan="4">
                                    <table border="0" cellpadding="0" cellspacing="0" width="60%">

                                        <tr bgcolor="#CCCCCC">
                                            <td colspan="4" valign="middle">&nbsp;&nbsp;&nbsp;&nbsp;<b><i>Periodo Pesquisa:</i></b></td>
                                        </tr>

                                        <tr bgcolor="#CCCCCC">
                                            <td height="17" colspan="4">&nbsp;</td>
                                        </tr>

                                        <tr bgcolor="#CCCCCC">
                                            <td valign="middle" colspan="4">
                                                <form id="formPeriodo" name="formPeriodo" method="post" action="#">
                                                    <table>
                                                        <tr bgcolor="#CCCCCC">
                                                            <td valign="middle" width="120">Data Inicial:</td>
                                                            <td valign="middle">
                                                                <input id="dataInicio" type="text" name="dataInicio" size="12">
                                                            </td>
                                                            <td valign="middle" width="120">Hora Inicial:</td>
                                                            <td valign="middle">
                                                                <input id="horaInicio" type="text" name="horaInicio" size="12">
                                                            </td>
                                                        </tr> 
                                                        <tr bgcolor="#CCCCCC">
                                                            <td valign="middle" width="120">Data Final:</td>
                                                            <td valign="middle">
                                                                <input id="dataFim" type="text" name="dataFim" size="12">
                                                            </td>
                                                            <td valign="middle" width="120">Hora Final:</td>
                                                            <td valign="middle">
                                                                <input id="horaFim" type="text" name="horaFim" size="12">
                                                            </td>
                                                        </tr>         
                                                    </table>
                                                </form>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>


                            <tr bgcolor="#CCCCCC">
                                <td valign="middle" align="center" colspan="4">
                                    <table border="0" cellpadding="0" cellspacing="0" width="60%">
                                        <tr bgcolor="#CCCCCC">
                                            <td height="10" colspan="4"><hr size="1"/></td>
                                        </tr>

                                        <tr bgcolor="#CCCCCC">
                                            <td colspan="4" valign="middle">&nbsp;&nbsp;&nbsp;&nbsp;<b><i>Escolha Tipo de Pedido:</i></b></td>
                                        </tr>

                                        <tr bgcolor="#CCCCCC">
                                            <td height="17" colspan="4">&nbsp;</td>
                                        </tr>					

                                        <tr bgcolor="#CCCCCC">
                                            <td valign="middle" colspan="4">
                                                <form id="formTipoPedido" name="formTipoPedido" method="post" action="#">
                                                    <table>
                                                        <tr bgcolor="#CCCCCC">
                                                            <td valign="middle" width="120">Tipo de Pedido:</td>
                                                            <td valign="middle">
                                                                <select name="listaTipoPedidos" id="listaTipoPedidos" class="populaTipoPedidos" multiple="multiple" size="10"></select>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </form>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                            <tr bgcolor="#CCCCCC">
                                <td valign="middle" align="center" colspan="4">
                                    <table border="0" cellpadding="0" cellspacing="0" width="60%">
                                        <tr bgcolor="#CCCCCC">
                                            <td height="10" colspan="4"><hr size="1"/></td>
                                        </tr>

                                        <tr bgcolor="#CCCCCC">
                                            <td colspan="4" valign="middle">&nbsp;&nbsp;&nbsp;&nbsp;<b><i>Escolha Estoque:</i></b></td>
                                        </tr>

                                        <tr bgcolor="#CCCCCC">
                                            <td height="17" colspan="4">&nbsp;</td>
                                        </tr>					

                                        <tr bgcolor="#CCCCCC">
                                            <td valign="middle" colspan="4">
                                                <form id="formEstoqueFisico" name="formEstoqueFisico" method="post" action="#">
                                                    <table>
                                                        <tr bgcolor="#CCCCCC">
                                                            <td valign="middle" width="120">Estoque Fisico:</td>
                                                            <td valign="middle">
                                                                <select name="listaEstoqueFisico" id="listaEstoqueFisico" class="populaEstoquesFisico" multiple="multiple" size="5"></select>
                                                            </td>
                                                        </tr>        
                                                    </table>
                                                </form>
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

                            <tr>
                                <td colspan="5" align="center">
                                    <input id="btnConsultaPedidos" type="button" name="btnConsultaPedidos" size="10" value="LOCALIZAR">
                                    <input type="hidden" id ="dataAtual" name ="dataAtual" value="<? echo Date('Y-m-d H:i:s') ?>"/>
                                    <input type="hidden" id ="horaAtual" name ="horaAtual" value="<? echo Date('H:i') ?>"/>
                                </td>

                            </tr>
                        </table>
                    </div>

                    <h3><a href="#">Estacionamento de Pedidos</a></h3>
                    <div id="divResultado" style="background:#CCCCCC;">
                        <table id='tblResultado'></table>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</div>

