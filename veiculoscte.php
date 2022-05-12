<?php 
$flagmenu = 2;
// Verificador de sessão
require ( "verifica.php" );
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Tabela</title>
<script src="js/veiculoscte.js"></script>
<script src="js/geral.js"></script>

<script language="JavaScript1.2">
var tpfornecedor;
tpfornecedor = 1;
</script>
<noscript>Habilite o Javascript para visualizar esta página
corretamente...</noscript>
<style>
.borda {
	border: 1px solid;
}

div {
	font-family: Verdana;
	font-size: 12px;
}

td {
	font-family: Verdana;
	font-size: 12px;
}

input {
	font-family: Verdana;
	font-size: 12px;
}
</style>
</head>
<body onload="onLoad=dadospesquisaestado(0);">
<!--codigo_fornecedor(1);-->

<Center>
<form name="formulario" id="formulario">
<table width="640" height="200" border="2" cellspacing="0"
	cellpadding="0" bordercolor="#999999">
	<tr>
		<td>
		<table width="100%" height="20" border="0" cellpadding="0"
			cellspacing="0" bgcolor="#3366CC">
			<tr>
				<td colspan="4">
				<div align="center"><font color="#FFFFFF"
					face="Verdana, Arial, Helvetica, sans-serif"><strong>Cadastro de Veiculos</strong></font></div>
				</td>
			</tr>
		</table>
		<table width="100%" height="100" border="0" cellpadding="0"
			cellspacing="0" bgcolor="#CCCCCC">
			<tr>
				<td>&nbsp;</td>
				<td>Op&ccedil;&atilde;o:</td>
				<td colspan="3">
				<input name="radiobutton" id="radio1" type="radio" value="radiobutton" checked> C&oacute;digo Int. Veiculo
				<input type="radio" name="radiobutton" id="radio2" value="radiobutton"> RENAVAN 
				<input type="radio" name="radiobutton" id="radio3" value="radiobutton">	PLACA 
				</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td width="0%">&nbsp;</td>
				<td width="14%">
				<div align="left">Pesquisar:</div>
				</td>
				<td colspan="3"><input id="pesquisa" type="text" name="pesquisa" size="70" onkeypress="maiusculo();"></td>
				
				<!--onblur="convertField(this);dadospesquisa(this.value);"-->
				
				<td width="16%">
				<div align="center"><input name="button" type="button" id="button"
					onClick="dadospesquisa(pesquisa.value);" value="Pesquisar"></div>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>
				<div align="left">Campo:</div>
				</td>
				<td colspan="3"><select name="listDados"
					onChange="dadospesquisa2(this.value);">
					<option id="opcoes" value="0">__________________________________________</option>
				</select></td>
				<td>
				<div align="center"><input id="veicodigo" type="hidden"	name="veicodigo" size="25"></div>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan="3">&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			
		</table>
		<table width="100%" height="269" border="0" cellpadding="0"
			cellspacing="0" bgcolor="#CCCCCC">			
			
			<tr hidden >
				<td>&nbsp;</td>
				<td>C&oacute;digo</td>
				<td colspan="4"><input id="veicod" type="text" name="veicod"
					size="10" onkeyup="javascript:this.value=this.value.toUpperCase();"
					disabled
					style="COLOR: #660000; FONT-WEIGHT: bold;">
				</td>
				
			</tr>
			
			<tr>
				<td>&nbsp;</td>
				<td><div align="left">Cod. Int. Veiculo:</div></td>
				<td ><input id="veicodint" type="text" name="veicodint" size="20" onkeyup="javascrip :this.value=this.value.toUpperCase();" maxlength=10></td>
				<td>&nbsp;</td>
				<td>RENAVAM:</td>
				<td><input id="veirenavam" type="text" name="veirenavam" size="20" onkeyup="javascript:this.value=this.value.toUpperCase();" maxlength=25></td>
				<td>&nbsp;</td>
			</tr>	
			
			
			<tr>
				<td>&nbsp;</td>
				<td>Placa:</td>
				<td><input id="veiplaca" type="text" name="veiplaca" size="20" onkeyup="javascript:this.value=this.value.toUpperCase();" maxlength=25></td>
				<td>&nbsp;</td>
				<td>Tara(Kg):</td>
				<td><input id="veitara" type="text" name="veitara" size="20" onkeyup="javascript:this.value=this.value.toUpperCase();" onKeyPress="return soNums(event);" onBlur="convertField3(this);" maxlength=40></td>
				<td>&nbsp;</td>
								
			</tr>		
			
			
			<tr>
				<td>&nbsp;</td>
				<td>Capacidade(Kg):</td>
				<td>
				<input id="veicapacidadekg" type="text" name="veicapacidadekg" size="20" onkeyup="javascript:this.value=this.value.toUpperCase();" onKeyPress="return soNums(event);" onBlur="convertField3(this);" maxlength=40>
				</td>
				<td>&nbsp;</td>
				<td>Capacidade(M3):</td>
				<td>
				<input id="veicapacidademt" type="text" name="veicapacidademt" size="20" onkeyup="javascript:this.value=this.value.toUpperCase();" onKeyPress="return soNums(event);" onBlur="convertField3(this);" maxlength=40>
				</td>
				<td>&nbsp;</td>
			</tr>		
			
			
			<tr>
				<td>&nbsp;</td>
				<td>Tipo de Rodado:</td>
				<td ><select name="veitiporodado" id="veitiporodado">
					<option id="veicodtiporodado" value="0">________________</option>
				</select></td>
				<td>&nbsp;</td>
			
				<td>Tipo Carroceria:</td>
				<td ><select name="veitipocarroceria" id="veitipocarroceria">
					<option id="veicodtipocarroceria" value="0">_________________</option>
				</select></td>
				<td>&nbsp;</td>
			</tr>
			
			
			
			<tr>
				<td>&nbsp;</td>
				<td>Tipo de Veiculo:</td>
				<td ><select name="veitipoveiculo" id="veitipoveiculo">
					<option id="veicodtipoveiculo" value="0">________________</option>
				</select></td>
				<td>&nbsp;</td>
			
				<td>Prop. do Veiculo:</td>
				<td ><select name="veitipopropveiculo" id="veitipopropveiculo">
					<option id="veicodtipopropveiculo" value="0">_________________</option>
				</select></td>
				<td>
				
				UF:
				<select name="listestados" id="listestados">
					<option id="veicoduf" value="0">___</option>
				</select>
				
				</td>
			</tr>
			
			<tr>				
				<td colspan="6">&nbsp;</td>
			</tr>
			
			<tr>
				<td>&nbsp;</td>
				<td>Veiculo Empresa:</td>
				<td colspan="3">
				<input name="radiobutton3" type="radio" id="radio31" value="radiobutton" onclick="verificaveiculo(this.value);" checked> Sim
				<input type="radio" name="radiobutton3" id="radio32" value="radiobutton" onclick="verificaveiculo(this.value);"> Não
				</td>
				<td>&nbsp;</td>
			</tr>	
			
			<tr>
				<td>&nbsp;</td>
				<td>Pessoa:</td>
				<td colspan="3">
				<input name="radiobutton2" type="radio" id="radio11" value="radiobutton" onclick="verificapessoa(this.value);" checked disabled>	Jur&iacute;dica 
				<input type="radio" name="radiobutton2" id="radio12" value="radiobutton" onclick="verificapessoa(this.value);" disabled>	F&iacute;sica
				</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td height="21">&nbsp;</td>
				<td>CNPJ:</td>
				<td>
				<input id="veicnpj" type="text" name="veicnpj" size="20" maxlength="18" onKeyPress="return soNums(event);" onBlur="validar(this);" disabled>
				</td>
				<td>&nbsp;</td>
				<td>
				<div align="left">I.E.:</div>
				</td>
				<td>
				<input id="veiie" type="text" name="veiie" size="20" onkeyup="javascript:this.value=this.value.toUpperCase();" disabled>
				</td>
				<td>&nbsp;</td>
			</tr>


			
			<tr>
				<td>&nbsp;</td>
				<td>CPF:</td>
				<td>
				<input id="veicpf" type="text" name="veicpf" size="20" maxlength="14" onKeyPress="return soNums(event);" onBlur="validar2(this);" disabled>
				</td>
				<td>&nbsp;</td>
				<td>
				<div align="left">R.G.:</div>
				</td>
				<td>
				<input id="veirg" type="text" name="veirg" size="20" onkeyup="javascript:this.value=this.value.toUpperCase();" disabled>
				</td>
				<td>&nbsp;</td>
			</tr>	

			
			
			<tr>
				<td>&nbsp;</td>
				<td>RNTRC:</td>
				<td >
				<input id="veirntrc" type="text" name="veirntrc" size="20" maxlength="14" disabled>
				</td>
				<td>&nbsp;</td>
			
				<td>Tipo de Proprietario:</td>
				<td ><select name="veitipproprietario" id="veitipproprietario" disabled>
					<option id="veicodtipproprietario" value="0">_________________</option>
				</select></td>
				<td>
				
				UF:
				<select name="listestados2" id="listestados2" disabled>
					<option id="veicodufprop" value="0">___</option>
				</select>
				
				</td>
			</tr>			
			
			
			<tr>
				<td>&nbsp;</td>
				<td>Razão Social/Nome:</td>
				<td colspan="4" ><input id="veirazao" type="text" name="veirazao" size="61" onkeyup="javascript:this.value=this.value.toUpperCase();" maxlength="40" disabled></td>

				<td>&nbsp;</td>
								
			</tr>				
			
			<tr>				
				<td colspan="6">&nbsp;</td>
			</tr>
			
			<tr>
				<td colspan="6">
				<div align="center"><input name="button2" type="button" id="botao"
					onClick=valida_form(1) value="Incluir">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                   <input type="button" id="botao3" onClick=verificae() value="Excluir">                
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
					type="button" id="botao2" onClick=limpa_form(1) value="Limpar"></div>
				<input name="hidden" type="hidden" id="acao" value="inserir"></td>	            	
			</tr>
			
			<tr>				
				<td colspan="6">&nbsp;</td>
			</tr>		
			
		</table>
		</td>
	</tr>
</table>
</form>
<div id="MsgResultado"></div>
</Center>
<br>
</body>
</html>