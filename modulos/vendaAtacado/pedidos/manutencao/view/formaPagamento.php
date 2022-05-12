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
 * @since 09/02/2010
 * @author Douglas <douglas@centroatacadista.com.br>
 * @copyright MaxTrade
 */
$permAlterarSalto = preg_match("/ALTERAR SALTO PREFECHAMENTO/i", $_SESSION["usuario"], $match);
?>
<!-- incluindo script jquery para visualizar e atualizar Forma Pagamento -->
<script type="text/javascript" src="modulos/vendaAtacado/pedidos/manutencao/view/js/formaPagamento.js"></script>

<!-- incluindo script jquery para verificar Forma Pagamento -->
<script type="text/javascript" src="modulos/vendaAtacado/pedidos/manutencao/view/js/verificacaoFormaPagamento.js"></script>

<!-- incluindo script jquery para validação formulário forma de pagamento -->
<script type="text/javascript" src="modulos/vendaAtacado/pedidos/manutencao/view/js/validacaoFormaPagamento.js"></script>

<!-- incluindo script jquery - Popula Combox -->
<script type="text/javascript" src="lib/jquery/max/populaComboxFormasPagamento.js"></script>
<script type="text/javascript" src="lib/jquery/max/populaComboxBandeirasCartoes.js"></script>
<!-- incluindo script jquery - Popula Combox -->
<script type="text/javascript" src="lib/jquery/max/populaComboxCondicoesComerciais.js"></script>		

<script type="text/javascript" src="js/md.js"></script>

<div id="retorno"></div>
<div id="retornoLiberacao"></div>
<form id="formFormaPagamento" name="formFormaPagamento" method="post" action="#">


    <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#CCCCCC">
            <td height="20" colspan="4"><hr size="1"></td>
        </tr>

        <tr bgcolor="#CCCCCC">
            <td colspan="4" valign="middle">&nbsp;&nbsp;&nbsp;&nbsp;<b><i>Pagamento:</i></b></td>
        </tr>

        <tr bgcolor="#CCCCCC">
            <td height="17" colspan="4">&nbsp;</td>
        </tr>

        <tr>
            <td height="40">Vencimento:</td>
            <td colspan="3">
                <input name="opcaoVencimento" id="opcaoVencimento" type="radio" value="1" checked>Dias
                <input name="opcaoVencimento" id="opcaoVencimento" type="radio" value="2">Data
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id="divOpcaoVencimento"><input name="txtDiasVencimento" id="txtDiasVencimento" type="text" size="4" maxlength="3"></span>
            </td>
        </tr>

        <tr>
            <td width="170" height="40">Formas de Pagamento:</td>
            <td colspan="3"><select id="listaFormaPagamento" name="listaFormaPagamento" class="populaFormasPagamento"></select></td>
        </tr>

        <tr>
            <td width="170">Cond. Comerciais:</td>
            <td colspan="3">
                <input type="text" name="txtCondicoesComerciais" id="txtCondicoesComerciais" size="30" disabled="disabled">
                <select name="listaCondicoesComerciais" id="listaCondicoesComerciais" class="populaCondicoesComerciais"></select>
            </td>
        </tr>
        <tr>
            <td colspan="4">

                <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td >
                            <table border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="170" height="25">Numero do Documento:</td>
                                    <td ><input name="txtNumeroDocumento" id="txtNumeroDocumento" type="text" size="30"></td>
                                </tr>
                                <tr>
                                    <td>VALOR PEDIDO:</td>
                                    <td><input name="txtValorPedidoSemSt" id="txtValorPedidoSemSt" type="text" disabled></td>
                                </tr>
                                <tr>
                                    <td>VALOR S.T:</td>
                                    <td><input name="txtValorSt" id="txtValorSt" type="text" disabled></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>
                            <div id="detalhesFormaPagamento"></div>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>



        <tr>
            <td colspan="4" align="center" height="35" valign="middle">

                <div align="left">
                    <input name="btnAlterarFormaPreFechamentoPagamento" id="btnAlterarFormaPreFechamentoPagamento" type="button" value="Editar Condições Comerciais">
                    <br /><br />
                    <input name="btnRecalcularParcelas" id="btnRecalcularParcelas" type="button" value="Recalcular Parcelas" >
                    <br /><br />
                    <input name="btnIncluirFormaPagamento" id="btnIncluirFormaPagamento" type="button" size="10" value="Incluir">
                </div>
                <input name="alteraSalto" id="alteraSalto" type="hidden" size="10">
                <input type="hidden" name="permAlterarSalto" id="permAlterarSalto" size="10" value="<?php echo $permAlterarSalto ?>">
            </td>
        </tr>



        <tr>
            <td width="170" >Limite Disponível:</td>
            <td colspan="3">R&#36&nbsp;<label id="lblTotalLimiteDisponivel">0,00</label></td>
        </tr>
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
            <td width="170">Total a Pagar:</td>
            <td colspan="3">R&#36&nbsp;<label id="lblTotalPagar">0,00</label></td>
        </tr>
        <tr>
            <td width="170">Desconto de Vales:</td>
            <td colspan="3">R&#36&nbsp;<label id="lblTotalVales">0,00</label></td>
        </tr>
        <tr>
            <td width="170">Total Pago:</td>
            <td colspan="3">R&#36&nbsp;<label id="lblTotalPago">0,00</label></td>
        </tr>
        <tr>
            <td width="170"></td>
            <td colspan="3"><hr size="1" width="30%" align="left"></td>
        </tr>
        <tr>
            <td width="170">Diferenca a Pagar:</td>
            <td colspan="3">R&#36&nbsp;<label id="lblDiferencaPagar">0,00</label></td>
        </tr>
    </table>
</form>
</td>

</tr>
<!--
<tr bgcolor="#FFFFFF">
        <td><span id="tblFormaPagamento"></span></td>
</tr>
-->