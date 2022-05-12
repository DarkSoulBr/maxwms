<?php
//pega da pasta de istalacao
$arr = explode("/", $_SERVER['REQUEST_URI']);
$root = $arr[1];

//pega as configurações do servidor
require_once($_SERVER['DOCUMENT_ROOT'] . "/$root/include/config.php");


/**
 * Arquivo de Interface de Liberaçãode Pedidos.
 *
 * Entrada de dados do usuario para ter acesso ao sistema.
 * Este arquivo aquivo segue os padroes estabelecidos no dTrade. 
 * 
 * @name liberacaoPEdido
 * @category VendaAtacado/pedido/liberacao
 * @package modulos/VendaAtacado/pedido/liberacao/view
 * @link modulos/VendaAtacado/pedido/liberacao/view/liberacaoPedido.php
 * @version 1.0
 * @since 04/02/2010
 * @author Douglas <douglas@centroatacadista.com.br>
 * @copyright MaxTrade
 */
?>
<!-- incluindo script jquery para verificaçao da validação do pedido -->
<script type="text/javascript" src="modulos/vendaAtacado/pedidos/liberacao/view/js/validacaoLiberacaoPedido.js"></script>

<!-- incluindo script jquery para verificaçao da liberação do pedido -->
<script type="text/javascript" src="modulos/vendaAtacado/pedidos/liberacao/view/js/verificacaoLiberacaoPedido.js"></script>

<!-- incluindo script jquery para popular variavel global pedidos e pedido -->
<script type="text/javascript" src="modulos/vendaAtacado/pedidos/liberacao/view/js/liberaPedido.js" charset="utf-8"></script>


<div align="center">
    <div id="retorno"></div>
    <div id="dialog"></div>

    <table width="600" height="170" border="2" cellspacing="0" cellpadding="0" bordercolor="#999999">
        <tr>
            <td width="100%" height="170">
                <table width="100%"  height="20" border="0" cellpadding="0" cellspacing="0" bgcolor="#3366CC">
                    <tr>
                        <td colspan="5" >
                            <?php if ($popup && $clicod) { ?>
                                <div style="position:inherit; vertical-align:top; float: right;">
                                    <a href="clientescons.php?popup=1&pvnumero=<?php echo $pvnumero; ?>&clicod=<?php echo $clicod; ?>" style="color: white">Consulta Cliente</a>
                                </div>
                            <?php } else if ($popup && !clicod) { ?>
                                <div style="position:inherit; vertical-align:top; float: right;">
                                    <a href="?flagmenu=9&pgcodigo=5&popup=1&pvnumero=<?php echo $pvnumero ?>" style="color: white">Manutenção Pedido</a>
                                </div>
                            <?php } ?>

                            <div align="center">
                                <font color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif">
                                <strong>Liberação de Pedidos</strong>
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
                            <?php include_once(PESQUISA_PEDIDOS); ?>
                        </td>
                    </tr>


                    <tr bgcolor="#CCCCCC" >
                        <td height="10" colspan="4">
                            <!-- incluir componente de forma de pagamento -->
                            <?php include_once(FORMA_PAGAMENTO); ?>

                            <?php echo "<select style='display:none' id='listaBandeirasCartoesBase' name='listaBandeirasCartoesBase'>"; ?>
                            <?php include_once(DIR_ROOT . "/lib/jquery/max/php/populaComboxBandeirasCartoes.php"); ?>
                            <?php echo "</select>" ?>

                        </td>
                    </tr>


                    <tr bgcolor="#CCCCCC" id="tblAlteraNumero">
                        <td height="10" colspan="4">
                            <!-- incluir componente de forma de pagamento -->  
                            <?php include_once(ALTERA_NUMERO); ?>   
                        </td>
                    </tr>


                    <form name="formLiberacaoPedido" id="formLiberacaoPedido" method="POST" action="#">

                        <tr>
                            <td>&nbsp;</td>
                            <td> <div align="left">Emissao :  </div></td>
                            <td colspan="2">	<input name="dataEmissaoPedido" type="text" id="dataEmissaoPedido" size="10"></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td> <div align="left">Tipo:</div></td>
                            <td colspan="2"><input id="tipoPedido" type="text" name="tipoPedido" size="58"></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td> <div align="left">Cliente:</div></td>
                            <td colspan="2"><input id="nomeGuerraCliente" type="text" name="nomeGuerraCliente" size="58"/></td>
                            <td>&nbsp;</td><td><input id="codigoCliente" type="hidden" name="codigoCliente" /></td>
                            <td>&nbsp;</td><td><input id="codigoEstoqueFisico" type="hidden" name="codigoEstoqueFisico" /></td>
                            <td>&nbsp;</td><td><input id="clifat" type="hidden" name="clifat" /></td>

                        </tr>

                        <tr>
                            <td colspan="5">&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td> <div align="left">Dt. Liberação:</div></td>
                            <td colspan="2"><input id="dataLiberacaoPedido" type="text" name="dataLiberacaoPedido" size="10" readonly></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td> <div align="left">Hora Liberação:</div></td>
                            <td colspan="2"><input id="horaLiberacaoPedido" type="text" name="horaLiberacaoPedido" size="7" readonly></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="5">&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td> <div align="left">Tipo:</div></td>
                            <td colspan="2"><input id="urgentePedido" type="radio" name="urgentePedido" checked="checked" value="0"> Normal &nbsp;&nbsp; <input id="urgentePedido" type="radio" name="urgentePedido" value="1"> Urgente</td>
                            <td>&nbsp;</td>
                        </tr>

                        <tr>
                            <td colspan="5">&nbsp;</td>
                        </tr>
                        <tr bgcolor="#CCCCCC">
                            <td colspan="5" height="40" valign="middle" align="center"><input type="button" id="btnLiberacaoPedido" value="Liberar"></td>
                        </tr>
                    </form>

                </table>
            </td>
        </tr>
    </table>


</div>