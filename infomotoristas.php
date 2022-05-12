<?php
$flagmenu=2;
// Verificador de sessão
require("verificax.php");
include 'include/jquery.php';
include 'include/css.php';

$usucodigo = $_GET['usucodigo'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Tabela</title>

<script src="js/infomotoristas.js"></script>
<script src="js/geral.js"></script>
<script type="text/javascript">
var $a = jQuery.noConflict()
</script>

<noscript>
Habilite o Javascript para visualizar esta página corretamente...
</noscript>
<style>
.borda{border: 1px solid;}
div{font-family: Verdana; font-size: 12px;}
td{font-family: Verdana; font-size: 12px;}
input{font-family: Verdana; font-size: 12px;}
.borda2{border: 0px solid; font-size: 0px; color: white;}
</style>

</head>
<body onload="inicia('<?php echo $usucodigo ?>');">

<Center>
<form name="formulario">
<table width="420" height="200" border="2" cellspacing="0" cellpadding="0" bordercolor="#999999">
  <tr>
	<td>
		<table width="100%"  height="20" border="0" cellpadding="0" cellspacing="0" bgcolor="#3366CC">
		  <tr>
			<td colspan="4" >
			<div align="center"><font color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif"><strong>Motoristas</strong></font></div>
			</td>
		  </tr>
		</table>
		    
          <table width="100%" height="180" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">            
            
            <tr bgcolor="#CCCCCC">
				<td>&nbsp;</td>
				<td valign="middle"><div align="left">Opção:</div></td>
				<td valign="middle"><input type="radio" name="opcao" id="opcao1" value="1" align="absmiddle" checked>Código&nbsp;<input type="radio" name="opcao" id="opcao2" value="2" align="absmiddle">Nome&nbsp;<input type="radio" name="opcao" id="opcao3" value="3" align="absmiddle">CPF&nbsp;</td>				
				<td valign="middle"><div align="center"><input type="button" name="pesquisar" id="pesquisar" value="Pesquisar" onclick="load_grid();"></div></td>
			</tr>
			<tr bgcolor="#CCCCCC">
				<td>&nbsp;</td>
				<td valign="middle"><div align="left">Motorista:</div></td>
				<td colspan="2" valign="middle"><input type="text" name="consulta" id="consulta" size="50" onKeyPress="maiusculo()" onBlur="convertField(this)" onkeyup="this.value=this.value.toUpperCase()"></td>				
			</tr>
			<tr bgcolor="#CCCCCC">
				<td>&nbsp;</td>
				<td valign="middle"><div align="left">Pesquisa:</div></td>
				<td colspan="2" valign="middle"><div id="resultado1"><select id="pesquisap" name="pesquisap" size="1" onchange="setar(this);" disabled><option value=\"0\">-- Escolha um Motorista --</option></select></div></td>				
			</tr>
			<input type="hidden" name="nome" id="nome" size="40" readonly disabled>						
			<tr bgcolor="#CCCCCC">
				<td>&nbsp;</td>
				<td valign="middle"><div align="left">Motorista:</div></td>
				<td colspan="2" valign="middle"><input id="motorista" type="text" name="motorista" size="50" onKeyPress="maiusculo()" onBlur="convertField(this)" maxlength="50"></td>
				<input name="hidden" type="hidden" id="codmotorista" value="">
			</tr>
			<tr bgcolor="#CCCCCC">
				<td>&nbsp;</td>
				<td valign="middle"><div align="left">CPF:</div></td>
				<td valign="middle"><input name="cpf" type="text" id="cpf" size="20" onKeyPress="return soNums(event);" onBlur="validar2(this);" maxlength="50"></td>
				<td valign="middle"><div align="center"><input type="button" name="incluir" id="incluir" value="Incluir" onclick="enviar();"></div></td>
			</tr>
			
              	
            <tr> 
              <td>&nbsp;</td>
              <td><div align="center"> 
                  <input type="hidden" id="botao" onClick=valida_form() value="Incluir">
                </div></td>
              <td><div align="center"> </div>
                <input name="hidden" type="hidden" id="acao" value=""> </td>
            </tr>
          </table>
	</td>
  </tr>
</table>

</div>

<div id="msg" style="visibility: hidden;">&nbsp;<font face="Verdana" size="2">Processando...</font></div><Center>
<div id="resultado">
</Center>
</div>


</form>

</Center>
</div>
<br>


</body>
</html>
