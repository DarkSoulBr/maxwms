<?php
/**
* Arquivo de Interface do Componente para Pesquisa de Pedidos.
*
* Componente para pesquisa.
* Este arquivo aquivo segue os padroes estabelecidos no dTrade. 
* 
* @name Pesquisa Pedidos View
* @category Pedidos
* @package modulos/vendaAtacado/pedidos/manutencao/view/
* @link modulos/vendaAtacado/pedidos/manutencao/view/pesquisaPedidos.php
* @version 1.0
* @since Criado 03/12/2009 Modificado 15/12/2009
* @author Wellington <wellington@centroatacadista.com.br>
* @copyright MaxTrade
*/
?>
<!-- incluindo funcoes para pesquisa de pedidos -->
<script type="text/javascript" src="modulos/vendaAtacado/pedidos/manutencao/view/js/funcoesPesquisa.js"></script> 

<!-- incluindo script jquery para popular variavel global pedidos e pedido -->
<script type="text/javascript" src="modulos/vendaAtacado/pedidos/manutencao/view/js/validacaoPesquisaPedido.js"></script>

<!-- incluindo script jquery para popular variavel global pedidos e pedido -->
<script type="text/javascript" src="modulos/vendaAtacado/pedidos/manutencao/view/js/verificacaoPesquisaPedido.js"></script>

<!-- incluindo script jquery para popular variavel global pedidos e pedido -->
<script type="text/javascript" src="modulos/vendaAtacado/pedidos/manutencao/view/js/getPedidos2.js"></script> 

<div id="divPesquisaPedido" style="height: 120; width: 100%;">
<?php 
$pvnumero = $_GET['pvnumero'];
if(!empty($pvnumero))
{
	$pvnumero = $pvnumero;
}
else
{
	$pvnumero = "";
}
?>
<form id="formPesquisaPedidos" name="formPesquisaPedidos" method="post" action="#">	
	<table>
		<tr bgcolor="#CCCCCC">
			<td valign="middle" width="120">Opção:</td>
			<td valign="middle">
				<input type="radio" name="opcoesTipoPesquisaPedidos" id="opcoesTipoPesquisaPedidos" value="pvnumero" align="middle" checked>Número do Pedido<br />
			</td>
		</tr>
		
		<tr bgcolor="#CCCCCC">
			<td valign="middle" width="120"></td>
			<td valign="middle">
				<hr size="1"></hr>
			</td>
		</tr>
		  
		<tr bgcolor="#CCCCCC">
			<td valign="middle" width="120">Pesquisar:</td>
			<td valign="middle">
				<input type="radio" name="opcoesFormaPesquisaPedidos" id="opcoesFormaPesquisaPedidos" value="2" align="middle" checked>Igual a
				<input type="radio" name="opcoesFormaPesquisaPedidos" id="opcoesFormaPesquisaPedidos" value="0" align="middle">Começa com 
				<input type="radio" name="opcoesFormaPesquisaPedidos" id="opcoesFormaPesquisaPedidos" value="1" align="middle">Qualquer Parte de 
				
			</td>
		</tr>
		
		<tr bgcolor="#CCCCCC">
			<td valign="middle"></td>
			<td valign="middle">
			
				<input type="text" name="txtPesquisaPedidos" value="<?=$pvnumero?>" id="txtPesquisaPedidos" size="25">
				<input type="button" name="btnPesquisaPedidos" id="btnPesquisaPedidos" value="Pesquisar">
			</td>
		</tr>
	</table>
</form>

<form id="formResultadoPedidos" name="formResultadoPedidos" method="post" action="#">	
	<table>         
		<tr bgcolor="#CCCCCC">
			<td valign="middle" width="120">Pedido:</td>
			<td valign="middle">
				<select id="listaPesquisaPedidos" name="listaPesquisaPedidos"></select>
			</td>
		</tr>
	</table>
</form>
</div>