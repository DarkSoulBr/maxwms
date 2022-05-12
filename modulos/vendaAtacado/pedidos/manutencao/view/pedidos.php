<?php
//pega da pasta de istalacao
$arr = explode("/", $_SERVER['REQUEST_URI']);
$root = $arr[1];

//pega as configurações do servidor
require_once($_SERVER['DOCUMENT_ROOT'] . "/$root/include/config.php");

/**
 * Arquivo de Interface de Pedidos para vendas em Atacado.
 *
 * Entrada de dados do usuario para ter acesso ao sistema.
 * Este arquivo aquivo segue os padroes estabelecidos no dTrade. 
 * 
 * @name Pedido View
 * @category Pedidos Atacado
 * @package modulos/vendaAtacado/pedidos/manutencao/view
 * @link modulos/vendaAtacado/pedidos/manutencao/view/usuarios.php
 * @version 1.0
 * @since 20/11/2009
 * @author Wellington <wellington@centroatacadista.com.br>
 * @copyright MaxTrade
 */
?>

<!-- incluindo funcoes para pesquisa de pedidos -->
<script type="text/javascript" src="modulos/vendaAtacado/pedidos/manutencao/view/js/funcoesPesquisa.js"></script> 


<!-- incluindo funções para utilização da view -->
<script type="text/javascript" src="modulos/vendaAtacado/pedidos/manutencao/view/js/funcoes.js"></script>

<!-- incluindo script jquery para validação formulário -->
<script type="text/javascript" src="modulos/vendaAtacado/pedidos/manutencao/view/js/validacao.js"></script> 

<!-- incluindo script jquery para verificação dos dados -->
<script type="text/javascript" src="modulos/vendaAtacado/pedidos/manutencao/view/js/verificacao.js"></script>

<!-- incluindo script jquery para crud (Create, Resutl, Update, Delete) -->
<script type="text/javascript" src="modulos/vendaAtacado/pedidos/manutencao/view/js/crud.js"></script>

<!-- incluindo script jquery para visualizar e atualizar Estoques do item -->
<script type="text/javascript" src="modulos/vendaAtacado/pedidos/manutencao/view/js/estoquesItem.js"></script>

<!-- incluindo script jquery para verificar Estoque Item -->
<script type="text/javascript" src="modulos/vendaAtacado/pedidos/manutencao/view/js/verificacaoEstoquesItem.js"></script>

<!-- incluindo script jquery - Popula Combox -->
<script type="text/javascript" src="lib/jquery/max/populaComboxCondicoesComerciais.js"></script>
<script type="text/javascript" src="lib/jquery/max/populaComboxTipoPedidos.js"></script>
<script type="text/javascript" src="lib/jquery/max/populaComboxEstoques.js"></script>

<div align="center">
    <div id="retorno"></div>
    <div id="dialog" style="margin-left: 5px; margin-left: 5px;"></div>
    <div id="estoquesItem"></div>

    <?php
    $flagmenu = $_GET['flagmenu'];
    $pgcodigo = $_GET['$pgcodigo'];

    if ($flagmenu == '9' AND $pgcodigo = '5') {
        $tituloTabela = "Pedidos de Venda Atacado";
    } else {
        $tituloTabela = "Pedidos de Venda Varejo";
    }
    ?>

    <table width="900" height="130" border="2" cellspacing="0" cellpadding="0" bordercolor="#999999">
        <tr>
            <td width="100%">
                <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#3366CC">
                    <tr>
                        <td valign="middle" height="25">
<?php if ($popup) { ?>
                                <div style="position:inherit; vertical-align:top; float: right;">
                                    <a href="?flagmenu=9&pgcodigo=11&popup=1&pvnumero=<?php echo $pvnumero ?>" style="color: white">Ir para Lib/PreFechamento</a>
                                </div>
<?php }; ?>
                            <div align="center">
                                <font color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif">
                                <strong><?= $tituloTabela ?></strong>
                                </font>
                            </div>

                        </td>
                    </tr>

                    <tr bgcolor="#CCCCCC">
                        <td valign="top" width="100%">

                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr bgcolor="#CCCCCC">
                                    <td height="10" colspan="4"></td>
                                </tr>

                                <tr>
                                    <td valign="middle">
                                        <table border="0" cellpadding="5" cellspacing="0" bgcolor="#CCCCCC">
                                            <tr> 
                                                <td align="center" width="75"><input type="button" name="botao" id="btn4s"></td>
                                                <td align="center" width="75"><input type="button" name="botao" id="btn3s"></td>
                                            </tr>	
                                        </table>
                                    </td>
                                    <td valign="middle">
                                        <table border="0" cellpadding="5" cellspacing="0" bgcolor="#CCCCCC">
                                            <tr>
                                                <td align="center" width="75"><input type="button" name="botao" id="btn2s"></td>
                                                <td align="center" width="75"><input type="button" name="botao" id="btn1s"></td>
                                                <!-- <td align="center" width="75"><input type="button" value="Destrava Pedido" name="destravarPedido" id="destravarPedido"></td>
                                                <td align="center" width="75"><input type="button" value="Edição Simples" name="edicaoSimples" id="edicaoSimples"></td>-->

                                            </tr>	
                                        </table>
                                    </td>  
                                    <td valign="middle" width="100"><b>Data de Emissão:</b></td>
                                    <td width="100"><input type="text" name="dataEmissaoPedido" id="dataEmissaoPedido" maxlength="10" size="12" readonly="readonly"></td>
                                </tr>
                                <!-- 
                                <tr bgcolor="#CCCCCC">
                                        <td height="10" colspan="4"><hr size="1"/></td>
                                </tr>-->
                            </table>

<!-- <table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr bgcolor="#CCCCCC">
<td colspan="4" valign="middle">&nbsp;&nbsp;&nbsp;&nbsp;<b><i>Escolha o Pedido:</i></b></td>
</tr>

<tr bgcolor="#CCCCCC">
<td height="10" colspan="4">
incluir componente de pesquisa de pedidos 
<? //php// include_once(PEDIDOS_PESQUISAR);  ?>
</td>
</tr>
</table>-->

                            <div id="divPedido">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr bgcolor="#CCCCCC">
                                        <td height="10" colspan="4"><hr size="1"/></td>
                                    </tr>

                                    <tr bgcolor="#CCCCCC">
                                        <td colspan="4" valign="middle">&nbsp;&nbsp;&nbsp;&nbsp;<b><i>Escolha o Tipo de Pedido:</i></b></td>
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
                                                            <select name="listaTipoPedidos" id="listaTipoPedidos" class="populaTipoPedidos"></select>
                                                        </td>
                                                    </tr>        
                                                </table>
                                            </form>
                                        </td>
                                    </tr>

                                    <tr bgcolor="#CCCCCC">
                                        <td height="20" colspan="4"><hr size="1"/></td>
                                    </tr>
                                </table>

                                <table id="tblCliente" border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr bgcolor="#CCCCCC">
                                        <td colspan="4" valign="middle">&nbsp;&nbsp;&nbsp;&nbsp;<b><i>Escolha o Cliente:</i></b></td>
                                    </tr>

                                    <tr bgcolor="#CCCCCC">
                                        <td height="17" colspan="4">&nbsp;</td>
                                    </tr>

                                    <tr bgcolor="#CCCCCC">
                                        <td height="17" colspan="4">

                                            <!-- incluir componente de pesquisa de clientes -->
<?php include_once(CLIENTES_PESQUISAR); ?>

                                        </td>
                                    </tr>

                                    <tr bgcolor="#CCCCCC">
                                        <td height="20" colspan="4"><hr size="1"/></td>
                                    </tr>
                                </table>

                                <table id="tblFornecedor" border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr bgcolor="#CCCCCC">
                                        <td colspan="4" valign="middle">&nbsp;&nbsp;&nbsp;&nbsp;<b><i>Escolha o Fornecedor:</i></b></td>
                                    </tr>

                                    <tr bgcolor="#CCCCCC">
                                        <td height="17" colspan="4">&nbsp;</td>
                                    </tr>

                                    <tr bgcolor="#CCCCCC">
                                        <td height="17" colspan="4">

                                            <!-- incluir componente de pesquisa de clientes -->
<?php include_once(PESQUISA_FORNECEDORES); ?>

                                        </td>
                                    </tr>

                                    <tr bgcolor="#CCCCCC">
                                        <td height="20" colspan="4"><hr size="1"/></td>
                                    </tr>
                                </table>

                                <table border="0" id="tblVendedor" cellpadding="0" cellspacing="0" width="100%">
                                    <tr bgcolor="#CCCCCC">
                                        <td colspan="4" valign="middle">&nbsp;&nbsp;&nbsp;&nbsp;<b><i>Escolha o Vendedor:</i></b></td>
                                    </tr>

                                    <tr bgcolor="#CCCCCC">
                                        <td height="17" colspan="4">&nbsp;</td>
                                    </tr>

                                    <tr bgcolor="#CCCCCC">
                                        <td height="17" colspan="4">

                                            <!-- incluir componente de pesquisa de vendedores -->
<?php include_once(PESQUISA_VENDEDORES); ?>

                                        </td>
                                    </tr>

                                    <tr bgcolor="#CCCCCC">
                                        <td height="20" colspan="4"><hr size="1"/></td>
                                    </tr>
                                </table>

                                <table border="0" id="tblMaisInformacao" cellpadding="0" cellspacing="0" width="100%">
                                    <tr bgcolor="#CCCCCC">
                                        <td colspan="4" valign="middle">&nbsp;&nbsp;&nbsp;&nbsp;<b><i>Mais Informações:</i></b></td>
                                    </tr>

                                    <tr bgcolor="#CCCCCC">
                                        <td height="17" colspan="4">&nbsp;</td>
                                    </tr>

                                    <tr bgcolor="#CCCCCC">
                                        <td valign="middle" colspan="4">
                                            <form id="formCondicoesComerciais" name="formCondicoesComerciais" method="post" action="#">
                                                <table>
                                                    <tr bgcolor="#CCCCCC">
                                                        <td valign="middle" width="120">Cond. Comerciais:</td>
                                                        <td valign="middle">
                                                            <select name="listaCondicoesComerciais" id="listaCondicoesComerciais" class="populaCondicoesComerciais"></select>
                                                        </td>
                                                    </tr>
                                                    <tr bgcolor="#CCCCCC">
                                                        <td valign="middle">Local de Entrega:</td>
                                                        <td valign="middle" colspan="3"><input type="text" name="txtLocalEntrega" id="txtLocalEntrega" size="80" maxlength="70"></td>
                                                    </tr>
                                                    <tr bgcolor="#CCCCCC">
                                                        <td valign="middle">Exceçoes:</td>
                                                        <td valign="middle" colspan="3">							
                                                            <input type="text" name="excecoes" id="txtExcecoes" size="80" maxlength="50">
                                                        </td>
                                                    </tr>        
                                                </table>
                                            </form>
                                        </td>
                                    </tr>

                                    <tr bgcolor="#CCCCCC">
                                        <td height="20" colspan="4"><hr size="1"/></td>
                                    </tr>
                                </table>

                                <table id="tblEstoqueOrigem" border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr bgcolor="#CCCCCC">
                                        <td colspan="4" valign="middle">&nbsp;&nbsp;&nbsp;&nbsp;<b><i>Escolha o Estoque de Origem:</i></b></td>
                                    </tr>

                                    <tr bgcolor="#CCCCCC">
                                        <td height="17" colspan="4">&nbsp;</td>
                                    </tr>					

                                    <tr bgcolor="#CCCCCC">
                                        <td valign="middle" colspan="4">
                                            <form id="formEstoqueOrigem" name="formEstoqueOrigem" method="post" action="#">
                                                <table>
                                                    <tr bgcolor="#CCCCCC">
                                                        <td valign="middle" width="120">Estoque de Origem:</td>
                                                        <td valign="middle">
                                                            <select name="listaEstoqueOrigem" id="listaEstoqueOrigem" class="populaEstoques"></select>
                                                        </td>
                                                    </tr>        
                                                </table>
                                            </form>
                                        </td>
                                    </tr>

                                    <tr bgcolor="#CCCCCC">
                                        <td height="20" colspan="4"><hr size="1"/></td>
                                    </tr>
                                </table>

                                <table id="tblEstoqueDestino" border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr bgcolor="#CCCCCC">
                                        <td colspan="4" valign="middle">&nbsp;&nbsp;&nbsp;&nbsp;<b><i>Escolha o Estoque de Destino:</i></b></td>
                                    </tr>

                                    <tr bgcolor="#CCCCCC">
                                        <td height="17" colspan="4">&nbsp;</td>
                                    </tr>					

                                    <tr bgcolor="#CCCCCC">
                                        <td valign="middle" colspan="4">
                                            <form id="formEstoqueDestino" name="formEstoqueDestino" method="post" action="#">
                                                <table>
                                                    <tr bgcolor="#CCCCCC">
                                                        <td valign="middle" width="120">Estoque de Destino:</td>
                                                        <td valign="middle">
                                                            <select name="listaEstoqueDestino" id="listaEstoqueDestino" class="populaEstoques"></select>
                                                        </td>
                                                    </tr>        
                                                </table>
                                            </form>
                                        </td>
                                    </tr>

                                    <tr bgcolor="#CCCCCC">
                                        <td height="20" colspan="4"><hr size="1"/></td>
                                    </tr>
                                </table>
                                <table border="0" id="tblProdutos" cellpadding="0" cellspacing="0" width="100%">
                                    <tr bgcolor="#CCCCCC">
                                        <td colspan="4" valign="middle">&nbsp;&nbsp;&nbsp;&nbsp;<b><i>Escolha o Produto:</i></b></td>
                                    </tr>

                                    <tr bgcolor="#CCCCCC">
                                        <td height="17" colspan="4">&nbsp;</td>
                                    </tr>

                                    <tr bgcolor="#CCCCCC">
                                        <td height="20" colspan="4">
                                            <!-- incluir componente de pesquisa de produtos -->
<?php include_once(PESQUISA_PRODUTOS); ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td valign="middle" width="120" height="20">Tabela Padrão:</td>
                                        <td valign="middle" colspan="3"> 
                                            <input type="radio" name="opcoesTabelaPadrao" id="opcoesTabelaPadrao" value="A" align="middle"> A
                                            <input type="radio" name="opcoesTabelaPadrao" id="opcoesTabelaPadrao" value="B" align="middle"> B
                                            <input type="radio" name="opcoesTabelaPadrao" id="opcoesTabelaPadrao" value="C" align="middle" checked> C
                                        </td>
                                    </tr>

                                    <tr bgcolor="#CCCCCC">
                                        <td height="20" colspan="4">&nbsp;</td>
                                    </tr>

                                    <tr>
                                        <td valign="middle" align="center" colspan="4"> 
                                            <input type="button" name="btnEstoquesItem" id="incluirProduto" value="Incluir Produto">
                                            &nbsp;
                                            <input type="button" name="btnImportarPedido" id="importarPedido" value="Importar Pedido">
                                        </td>
                                    </tr>

                                    <tr bgcolor="#CCCCCC">
                                        <td height="20" colspan="4"><hr size="1"></td>
                                    </tr>
                                </table>

                                <table border="0" id="tblMostraProduto" cellpadding="0" cellspacing="0" width="100%">	
                                    <tr bgcolor="#FFFFFF">
                                        <td height="25" colspan="6">
                                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                <tr bgcolor="#FFFFFF">
                                                    <td height="25" width="100%">&nbsp;&nbsp;&nbsp;&nbsp;<b><i>Produto(s) Incluido(s):</i></b></td>
                                                </tr>
                                            </table>

                                            <div id="itensPedido">
                                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                    <tr bgcolor="#FFFFFF">
                                                        <td height="25" width="100%" align="center">
                                                            Nenhum produto foi incluido ao pedido!
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr bgcolor="#FFFFFF">
                                        <td height="20" colspan="6">&nbsp;</td>
                                    </tr>

                                    <tr bgcolor="#FFFFFF">
                                        <td height="20" colspan="6">&nbsp;</td>
                                    </tr>

                                    <tr bgcolor="#CCCCCC"> 
                                        <td height="20" colspan="6"><hr size="1"></td>
                                    </tr>
                                </table>
                                <table width="100%" id="tblDesconto" border="0" cellpadding="0" cellspacing="0">
                                    <tr bgcolor="#CCCCCC"> 
                                        <td colspan="4" valign="middle">&nbsp;&nbsp;&nbsp;&nbsp;<b><i>Escolha o Desconto:</i></b></td>
                                    </tr>

                                    <tr bgcolor="#CCCCCC"> 
                                        <td height="17" colspan="4">&nbsp;</td>
                                    </tr>

                                    <tr>
                                        <td width="136">Valor Desconto:</td>
                                        <td>(R$)&nbsp;<input type="text" name="txtValorDesconto" id="txtValorDesconto" disabled="disabled"></td>
                                        <td>&nbsp;Percentual:</td>
                                        <td>(%)&nbsp;<input type="text" name="txtPercentualDesconto" id="txtPercentualDesconto" disabled="disabled"></td>
                                    </tr>

                                    <tr bgcolor="#CCCCCC"> 
                                        <td height="20" colspan="4"><hr size="1"></td>
                                    </tr>
                                </table>

                                <table border="0" id="tblTransporte" cellpadding="0" cellspacing="0" width="100%">
                                    <tr bgcolor="#CCCCCC">
                                        <td colspan="4" valign="middle">&nbsp;&nbsp;&nbsp;&nbsp;<b><i>Escolha a Transportadora:</i></b></td>
                                    </tr>

                                    <tr bgcolor="#CCCCCC">
                                        <td height="17" colspan="4">&nbsp;</td>
                                    </tr>

                                    <tr bgcolor="#CCCCCC">
                                        <td height="17" colspan="4">
                                            <!-- incluir componente de pesquisa de transportadoras -->
<?php include_once(PESQUISA_TRANSPORTADORAS); ?>
                                        </td>
                                    </tr>

                                    <tr bgcolor="#CCCCCC">
                                        <td height="20" colspan="4">&nbsp;</td>
                                    </tr>

                                    <tr>
                                        <td width="120">&nbsp;Data Entrega:</td>
                                        <td colspan="3"><input id="dataEntrega" type="text" name="dataEntrega" size="12"></td>
                                    </tr>

                                    <tr bgcolor="#CCCCCC">
                                        <td height="20" colspan="4"><hr size="1"></td>
                                    </tr>
                                </table>

                                <table border="0" id="tblObservacao" cellpadding="0" cellspacing="0" width="100%">
                                    <tr bgcolor="#CCCCCC">
                                        <td colspan="4" valign="middle">&nbsp;&nbsp;&nbsp;&nbsp;<b><i>Observação:</i></b></td>
                                    </tr>

                                    <tr bgcolor="#CCCCCC">
                                        <td height="20" colspan="4">&nbsp;</td>
                                    </tr>

                                    <tr>
                                        <td colspan="4">Observações:</td>
                                    </tr>

                                    <tr>
                                        <td colspan="4">&nbsp;<textarea name="txtObservacao" id="txtObservacao" cols="83" rows="3"></textarea></td>
                                    </tr>

                                    <tr bgcolor="#CCCCCC"> 
                                        <td colspan="4">&nbsp;</td>
                                    </tr>

                                    <tr bgcolor="#CCCCCC">
                                        <td colspan="4" valign="middle">&nbsp;&nbsp;&nbsp;&nbsp;<b><i>Histórico</i></b></td>
                                    </tr>

                                    <tr bgcolor="#CCCCCC"> 
                                        <td colspan="4">&nbsp;</td>
                                    </tr>

                                    <tr>
                                        <td width="60">&nbsp;</td>
                                        <td valign="middle" width="400"><b>Incluido por: <label id="nomeUsuario"></label></b></td>
                                        <td>[ <a href="javascript:;" id="linkHistorico">Histórico</a> ]</td>
                                        <td>&nbsp;</td>
                                    </tr>

                                    <tr bgcolor="#CCCCCC"> 
                                        <td colspan="4">&nbsp;</td>
                                    </tr>

                                    <tr>
                                        <td width="60">&nbsp;</td>
                                        <td valign="middle" width="400"><b>Última Alteração: <label id="usuarioUltimaAlteracao"></label></b></td>
                                        <td><b>Data: <label id="dataUltimaAlteracao"></label></b></td>
                                        <td>&nbsp;</td>
                                    </tr>

                                    <tr bgcolor="#CCCCCC"> 
                                        <td colspan="4">&nbsp;</td>
                                    </tr>

                                    <tr>
                                        <td width="60">&nbsp;</td>
                                        <td valign="middle" width="400"><b><font color="#FF0000"><label id="statusAlteracaoLiberado"></label></font></b></td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>

                                    <tr bgcolor="#CCCCCC"> 
                                        <td colspan="4">&nbsp;</td>
                                    </tr>

                                    <tr bgcolor="#CCCCCC">
                                        <td height="20" colspan="4"><hr size="1"></td>
                                    </tr>
                                </table>

                                <table border="0" id="tblDescontoTotal" cellpadding="0" cellspacing="0" width="100%">
                                    <tr bgcolor="#CCCCCC">
                                        <td colspan="4" valign="middle">&nbsp;&nbsp;&nbsp;&nbsp;<b><i>Desconto e Total:</i></b></td>
                                    </tr>

                                    <tr bgcolor="#CCCCCC">
                                        <td height="17" colspan="4">&nbsp;</td>
                                    </tr>

                                    <tr>
                                        <td width="120">&nbsp;</td>
                                        <td valign="middle" width="150">Subtotal:</td>
                                        <td valign="middle">R&#36&nbsp;<label id="lblSubtotal"></label></td>
                                        <td>&nbsp;</td>
                                    </tr>

                                    <tr>
                                        <td>&nbsp;</td>
                                        <td valign="middle">Valor Desc.:</td>
                                        <td valign="middle">R&#36&nbsp;<label id="lblValorDesconto"></label></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td valign="middle">Total Mattel:</td>
                                        <td valign="middle">R&#36&nbsp;<label id="lblTotalMattel"></label></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td valign="middle">Total:</td>
                                        <td valign="middle">R&#36&nbsp;<label id="lblTotal"></label></td>
                                        <td>&nbsp;</td>
                                    </tr>



                                    <tr bgcolor="#CCCCCC">
                                        <td height="20" colspan="4">&nbsp;</td>
                                    </tr>

                                    <tr bgcolor="#CCCCCC">
                                        <td height="20" colspan="4"><hr size="1"></td>
                                    </tr>
                                </table>

                                <table border="0" id="tblLimites" cellpadding="0" cellspacing="0" width="100%">
                                    <tr bgcolor="#CCCCCC">
                                        <td colspan="4" valign="middle">&nbsp;&nbsp;&nbsp;&nbsp;<b><i>Limites:</i></b></td>
                                    </tr>

                                    <tr bgcolor="#CCCCCC">
                                        <td height="17" colspan="4">&nbsp;</td>
                                    </tr>

                                    <tr>
                                        <td width="120">&nbsp;</td>
                                        <td valign="middle" width="150">Limite Disponivel:</td>
                                        <td valign="middle">R&#36&nbsp;<label id="lblLimiteDisponivel"></label></td>
                                        <td>&nbsp;</td>
                                    </tr>

                                    <tr>
                                        <td>&nbsp;</td>
                                        <td valign="middle">Limite Total:</td>
                                        <td valign="middle">R&#36&nbsp;<label id="lblLimiteTotal"></label></td>
                                        <td>&nbsp;</td>
                                    </tr>

                                    <tr>
                                        <td>&nbsp;</td>
                                        <td valign="middle">Data Ultima Compra:</td>
                                        <td valign="middle"><label id="lblDataUltimaCompra"></label></td>
                                        <td>&nbsp;</td>
                                    </tr>

                                    <tr>
                                        <td>&nbsp;</td>
                                        <td valign="middle">Serasa:</td>
                                        <td valign="middle"><label id="lblSerasa"></label></td>
                                        <td>&nbsp;</td>
                                    </tr>

                                    <tr bgcolor="#CCCCCC">
                                        <td height="20" colspan="4">&nbsp;</td>
                                    </tr>

                                    <tr bgcolor="#CCCCCC">
                                        <td height="20" colspan="4"><hr size="1"></td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                </table>

                <table width="100%" border="0" id="tblBotoes" cellpadding="0" cellspacing="0" bgcolor="#3366CC">	
                    <tr bgcolor="#CCCCCC">
                        <td height="60" width="50%" valign="middle" align="center">
                            <table align="left" border="0" cellpadding="5" cellspacing="0" bgcolor="#CCCCCC">
                                <tr>
                                    <td align="center" width="75"><input type="button" name="botao" id="btn1"></td>
                                    <td align="center" width="75"><input type="button" name="botao" id="btn2"></td>
                                </tr>
                            </table>
                        </td>
                        <td height="60" width="50%" valign="middle" align="center">
                            <table align="right" border="0" cellpadding="5" cellspacing="0" bgcolor="#CCCCCC">
                                <tr>
                                    <td align="center" width="75"><input type="button" name="botao" id="btn3"></td>
                                    <td align="center" width="75"><input type="button" name="botao" id="btn4"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>


            </td>
        </tr>
    </table>
</div>