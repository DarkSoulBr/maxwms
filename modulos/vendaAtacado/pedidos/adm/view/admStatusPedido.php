<?php
//pega da pasta de istalacao
$arr = explode("/", $_SERVER['REQUEST_URI']);
$root = $arr[1];

//pega as configurações do servidor
require_once($_SERVER['DOCUMENT_ROOT'] . "/$root/include/config.php");
?>
<script type="text/javascript" src="modulos/vendaAtacado/pedidos/adm/view/js/verificaAltStatus.js"></script>

<script type="text/javascript" src="modulos/vendaAtacado/pedidos/adm/view/js/crudAltStatus.js"></script>

<script type="text/javascript" src="modulos/vendaAtacado/pedidos/adm/view/js/reset.js"></script>



<div align="center">
    <div id="retorno"></div>
    <div id="dialog"></div>

    <table width="550" height="170" border="2" cellspacing="0" cellpadding="0" bordercolor="#999999">
        <tr>
            <td width="100%" height="170">
                <table width="100%"  height="20" border="0" cellpadding="0" cellspacing="0" bgcolor="#3366CC">
                    <tr>
                        <td colspan="5" >

                            <div align="center">
                                <font color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif">
                                <strong>Alteração de Status de Pedidos</strong>
                                </font>
                            </div>
                        </td>
                    </tr>
                </table>
                <table width="100%" id="tblPesquisaPedido" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
                    <tr bgcolor="#CCCCCC">
                        <td colspan="4" valign="middle">&nbsp;&nbsp;&nbsp;&nbsp;<b><i>Escolha o Pedido:</i></b></td>
                    </tr>

                    <tr bgcolor="#CCCCCC">
                        <td height="10" colspan="4">
                            <!-- incluir componente de pesquisa de pedidos -->
                            <?php include_once(PESQUISA_PEDIDOS_SIMPLES); ?>
                        </td>
                    </tr>



                    <form name="formLiberacaoPedido" id="formLiberacaoPedido" method="POST" action="#">

                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr bgcolor="#CCCCCC">
                            <td colspan="4" valign="middle">&nbsp;&nbsp;&nbsp;&nbsp;<b><i>Escolha o Status do Pedido:</i></b></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Status : </td>
                            <td>&nbsp;</td>
                            <td colspan="3">
                                <select name="listaStatus" id="listaStatus" >
                                    <option value=""> ----------------------------------</option>

                                    <option value="1">1 - Status inicial do pedido</option>

                                    <option value="3">3 - Pedido liberado ao Financeiro</option>

                                    <option value="4">4 - Pedido pendente</option>

                                    <option value="5">5 - Pedido negado</option>

                                    <option value="6">6 - Pedido liberado</option>

                                </select>
                            <td>&nbsp;</td>
                        </tr>

                        <tr>
                            <td colspan="5">&nbsp;</td>
                        </tr>
                        <tr bgcolor="#CCCCCC">
                            <td colspan="5" height="40" valign="middle" align="center">
                                <input type="button" id="btnEditarPedido" value="Alterar">
                            </td>
                        </tr>
                    </form>

                </table>
            </td>
        </tr>
    </table>


</div>