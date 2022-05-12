<?php   
$flagmenu=2;
// Verificador de sessão
require("verifica.php");

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Tabela</title>

<script src="js/cteconsultapornota.js"></script>

<noscript>
Habilite o Javascript para visualizar esta página corretamente...
</noscript>
<style>
.borda{border: 1px solid;}
div{font-family: Verdana; font-size: 12px;}
td{font-family: Verdana; font-size: 12px;}
input{font-family: Verdana; font-size: 12px;}
.borda2{border: 1px solid; font-size: 12px;font-family: Courier New}
</style>

</head>

<body>

<Center>
<div id="msg" style="visibility: hidden;">&nbsp;<font face="Verdana" size="2">Processando...</font></div>
<div id="resultado">
<form name="formulario" method="POST">
<table width="480" height="130" border="2" cellspacing="0" cellpadding="0" bordercolor="#999999">
	<tr>
		<td>
			<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#3366CC">
		  		<tr>
					<td colspan="4" valign="middle" height="25">
						<div align="center"><font color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif"><strong>Consulda de CTe por NFe</strong></font></div>
					</td>
		  		</tr>
				
				<tr bgcolor="#CCCCCC">
               		<td>&nbsp;</td>
               		<td>&nbsp;</td>
					<td>&nbsp;</td>
               		<td>&nbsp;</td>
            	</tr>
				
            	<tr bgcolor="#CCCCCC">
					<td height="35" width="50">&nbsp;</td>
               		<td height="35"><b>NFe:</b></td>
               		<td valign="middle"><div align="left">
					<input type="text" name="nfe" id="nfe" onBlur="pesquisar(this.value)" maxlength="9" size="12">
					</div>
               		</td>
					<td>&nbsp;</td>
               		
            	</tr>
				
				<tr bgcolor="#CCCCCC">
					<td height="35" width="50">&nbsp;</td>
               		<td height="35""><b>Controle:</b></td>
               		<td valign="middle"><div align="left">
					<input type="text" name="ctenumero" id="ctenumero" maxlength="9" size="12" disabled>
					</div>
               		</td>
					<td>&nbsp;</td>
               		
            	</tr>
				
				<tr bgcolor="#CCCCCC">
					<td height="35" width="50">&nbsp;</td>
               		<td height="35" ><b>CTe:</b></td>
               		<td valign="middle"><div align="left">				
					
					<input type="text" name="cte" id="cte" maxlength="9" size="12" disabled>
					</div>
               		</td>
					<td>
					
					<div align="left"><b>Emissão:</b>
					<input type="text" name="emissao" id="emissao" maxlength="9" size="12" disabled>
					</td>
               		
            	</tr>
				
            	<tr bgcolor="#CCCCCC">
               		<td colspan="4" height="60" valign="middle" align="center"><input type="button" id="botao" value="Manutenção CTe" onclick="manutencao();"></td>
            	</tr>
            </table>
		</td>
  	</tr>
</table>

    </form>
</div>
</Center>
<br>
</body>
</html>
