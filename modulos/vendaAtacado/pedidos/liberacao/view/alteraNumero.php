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
<script type="text/javascript" src="modulos/vendaAtacado/pedidos/liberacao/view/js/validacaoAlteracaoEndereco.js"></script>

<!-- incluindo script jquery para verificaçao da liberação do pedido -->
<script type="text/javascript" src="modulos/vendaAtacado/pedidos/liberacao/view/js/verificacaoAlteracaoEndereco.js"></script>

<!-- incluindo script jquery para popular variavel global pedidos e pedido -->
<script type="text/javascript" src="modulos/vendaAtacado/pedidos/liberacao/view/js/alteraNumero.js"></script>


<div align="center">
    <div id="retorno"></div>
    <div id="dialog"></div>

    <table width="600" height="170" border="0" cellspacing="0" cellpadding="0" bordercolor="#999999">
        <tr>
        <form name="formAlteraNumero" id="formAlteraNumero" method="POST" action="#">
            <input id="codigoEnderecoCliente" type="hidden" name="codigoEnderecoCliente" size="40">

            <tr>
                <td>&nbsp;</td>
                <td> <div align="left">Endereco:  </div></td>
                <td colspan="2">	
                    <input name="enderecoCliente" type="text" id="enderecoCliente" size="40"></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td> <div align="left">Numero:</div></td>
                <td colspan="2"><input id="numeroEnderecoCliente" type="text" name="numeroEnderecoCliente" size="4"></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td> <div align="left">Complemento:</div></td>
                <td colspan="2"><input id="complementoEnderecoCliente" type="text" name="complementoEnderecoCliente" size="27"></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td> <div align="left">Bairro:</div></td>
                <td colspan="2"><input id="bairroEnderecoCliente" type="text" name="bairroEnderecoCliente" size="40"></td>
                <td>&nbsp;</td>
            </tr>

            <tr>
                <td>&nbsp;</td>
                <td> <div align="left">Cep:</div></td>
                <td colspan="2"><input id="cepEnderecoCliente" type="text" name="cepEnderecoCliente" size="40"></td>
                <td>&nbsp;</td>
            </tr>



            <tr>
                <td colspan="5">&nbsp;</td>
            </tr>
            <tr bgcolor="#CCCCCC">
                <td colspan="5" height="40" valign="middle" align="center"><input type="button" id="btnAlteraNumero" name="btnAlteraNumero" value="Alterar"></td>
            </tr>
        </form>
    </table>

</div>