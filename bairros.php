<?php
$flagmenu=2;
// Verificador de sessão
require("verifica.php");

//if($_SESSION["permissao"] !== "S")
//{
//   echo "Acesso Negado!";
//    exit;
//}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Tabela</title>

<script src="js/bairros.js"></script>

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
<body>

<div>
<Center>
<form name="formulario">
<table width="400" height="200" border="2" cellspacing="0"
	cellpadding="0" bordercolor="#999999">
	<tr>
		<td>
		<table width="100%" height="20" border="0" cellpadding="0"
			cellspacing="0" bgcolor="#3366CC">
			<tr>
				<td colspan="4">
				<div align="center"><font color="#FFFFFF"
					face="Verdana, Arial, Helvetica, sans-serif"><strong>Cadastro de
				Bairros</strong></font></div>
				</td>
			</tr>
		</table>
		<table width="100%" height="180" border="0" cellpadding="0"
			cellspacing="0" bgcolor="#CCCCCC">
			<tr>
				<td>&nbsp;</td>
				<td>
				<div align="left">Pesquisar:</div>
				</td>
				<td><input id="pesquisa" type="text" name="pesquisa" size="68"
					onKeyPress="maiusculo()"></td>
				<td>
				<div align="center"><input name="button" type="button" id="button"
					onClick=pesquisa1(pesquisa.value) value="Pesquisar"></div>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>
				<div align="left">Bairro:</div>
				</td>
				<td><select name="listDados" onChange="dadospesquisa2(this.value);">
					<option id="opcoes" value="0">_________________________________________________________</option>
				</select></td>
				<td>
				<div align="center"><input id="codigo" type="hidden" name="codigo"
					size="25"></div>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>
				<div align="left">Bairro:</div>
				</td>
				<td><input id="bairro" type="text" name="bairro" size="68"
					onKeyPress="maiusculo()"></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>Cidade:</td>
				<td><input id="cidade" type="text" name="cidade" size="54"
					onKeyPress="maiusculo()" onBlur="dadospesquisa3x(this.value);"> <input
					id="codigocidade" type="hidden" name="codigocidade" size="5"
					onKeyPress="maiusculo()"> UF: <input id="uf" type="text" name="uf"
					size="3" disabled onKeyPress="maiusculo()"></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>Pesquisa:</td>
				<td><select name="listcidades"
					onChange="dadospesquisa4(this.value);"
					onBlur="dadospesquisa4(this.value);">
					<option id="opcoes2" value="0">_________________________________________________________</option>
				</select>
				<td>&nbsp;</td>
			
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>
				<div align="center"><input type="button" id="botao"
					onClick=valida_form() value="Incluir"></div>
				</td>
				<td>
				<div align="center"><input type="button" id="botao2"
					onClick=limpa_form() value="Limpar"></div>
				</td>
				<td>
				<div align="center"><input type="button" id="botao3"
					onClick=verifica() value="Excluir"></div>
				<input name="hidden" type="hidden" id="acao" value="inserir"></td>
			</tr>
		</table>
		</td>
	</tr>
</table>





</form>
</Center>
</div>
<br>
</body>
</html>
