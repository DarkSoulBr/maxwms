<?php
/**
* Arquivo de Interface do Componente para Pesquisa de Transportadoras.
*
* Componente para pesquisa.
* Este arquivo aquivo segue os padroes estabelecidos no dTrade. 
* 
* @name Pesquisa Transportadoras View
* @category Transprtadoras
* @package modulos/cadastros/diversos/transportadoras/manutencao/view/
* @link modulos/cadastros/diversos/transportadoras/manutencao/view/pesquisaTransportadoras.php
* @version 1.0
* @since Criado 02/12/2009 Modificado 02/12/2009
* @author Wellington <wellington@centroatacadista.com.br>
* @copyright MaxTrade
*/
?>
<!-- funcoes do modulo de pesquisa -->
<script type="text/javascript" src="modulos/cadastros/diversos/transportadoras/manutencao/view/js/funcoesPesquisa.js"></script> 

<!-- incluindo script jquery para popular variavel global clientes -->
<script type="text/javascript" src="modulos/cadastros/diversos/transportadoras/manutencao/view/js/getTransportadoras.js"></script> 

<!-- incluindo script jquery validacao -->
<script type="text/javascript" src="modulos/cadastros/diversos/transportadoras/manutencao/view/js/validacaoPesquisa.js"></script>

<!-- incluindo script jquery verificação dos dados -->
<script type="text/javascript" src="modulos/cadastros/diversos/transportadoras/manutencao/view/js/verificacaoPesquisa.js"></script>  

<div id="divPesquisaTransportadora" style="height: 140; width: 100%;">

<form id="formPesquisaTransportadoras" name="formPesquisaTransportadoras" method="post" action="#">
	<table>
		<tr bgcolor="#CCCCCC">
			<td valign="middle" width="120">Opção:</td>
			<td valign="middle">
				<input type="radio" name="opcoesTipoPesquisaTransportadoras" id="opcoesTipoPesquisaTransportadoras" value="tracodigo" align="middle" checked>Código 
				<input type="radio" name="opcoesTipoPesquisaTransportadoras" id="opcoesTipoPesquisaTransportadoras" value="tranguerra" align="middle">Nome Guerra 
				<input type="radio" name="opcoesTipoPesquisaTransportadoras" id="opcoesTipoPesquisaTransportadoras" value="trarazao" align="middle">Razão Social
			</td>
		</tr>
		
		<tr bgcolor="#CCCCCC">
			<td valign="middle" width="120"></td>
			<td valign="middle">
				<hr size="1"></hr>
			</td>
		</tr>
		
		<tr bgcolor="#CCCCCC">
			<td valign="middle">Pesquisar:</td>
			<td valign="middle">
				<input type="radio" name="opcoesFormaPesquisaTransportadoras" id="opcoesFormaPesquisaTransportadoras" value="2" align="middle" checked>Igual a
				<input type="radio" name="opcoesFormaPesquisaTransportadoras" id="opcoesFormaPesquisaTransportadoras" value="0" align="middle">Começa com 
				<input type="radio" name="opcoesFormaPesquisaTransportadoras" id="opcoesFormaPesquisaTransportadoras" value="1" align="middle">Qualquer Parte de 
				
			</td>
		</tr>
		            
		<tr bgcolor="#CCCCCC">
			<td valign="middle"></td>
			<td valign="middle">
				<input type="text" name="txtPesquisaTransportadoras" id="txtPesquisaTransportadoras" size="25">
				<input type="button" name="btnPesquisaTransportadoras" id="btnPesquisaTransportadoras" value="Pesquisar">
				<input type="button" name="btnNovoTransportadora" id="btnNovoTransportadora" value="Cadastrar">
			</td>
		</tr>
	</table>
</form>

<form id="formResultadoTransportadoras" name="formResultadoTransportadoras" method="post" action="#">
	<table>         
		<tr bgcolor="#CCCCCC">
			<td valign="middle" width="120">Transportadora:</td>
			<td valign="middle">
				<select id="listaPesquisaTransportadoras" name="listaPesquisaTransportadoras" size="1"></select>
			</td>
		</tr>
		<tr> 
			<td valign="middle">Tipo Frete:</td>
			<td colspan="3">
				<input type="radio" name="opcoesTipoFrete" id="opcoesTipoFrete" value="1" align="middle" checked>1 - CIF
				<input type="radio" name="opcoesTipoFrete" id="opcoesTipoFrete" value="2" align="middle">2 - FOB
			</td>
		</tr>
	</table>
</form>
</div>