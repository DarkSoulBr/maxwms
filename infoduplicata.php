<?php
$flagmenu=2;
// Verificador de sess�o
require("verificax.php");
include 'include/jquery.php';
include 'include/css.php';

$usucodigo = $_GET['usucodigo'];

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Tabela</title>

<script src="js/infoduplicata.js"></script>
<script src="js/geral.js"></script>
<script type="text/javascript">
var $a = jQuery.noConflict()
</script>

<noscript>
Habilite o Javascript para visualizar esta p�gina corretamente...
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
<table width="400" height="100" border="2" cellspacing="0" cellpadding="0" bordercolor="#999999">
  <tr>
	<td>
		<table width="100%"  height="20" border="0" cellpadding="0" cellspacing="0" bgcolor="#3366CC">
		  <tr>
			<td colspan="4" >
			<div align="center"><font color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif"><strong>Duplicatas</strong></font></div>
			</td>
		  </tr>
		</table>
		    
          <table width="100%" height="80" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">            
		  
			<tr bgcolor="#CCCCCC">
				<td colspan="4">&nbsp;</td>				
			</tr>
									
			<tr bgcolor="#CCCCCC">
				<td>&nbsp;</td>
				<td valign="middle"><div align="left">Numero:</div></td>
				<td colspan="2" valign="middle"><input id="servico" type="text" name="servico" size="36" onKeyPress="maiusculo()" onBlur="convertField(this)" maxlength="50"></td>
				<input name="hidden" type="hidden" id="codservico" value="">
			</tr>
			
			<tr bgcolor="#CCCCCC">
				<td>&nbsp;</td>
				<td valign="middle"><div align="left">Vencimento:</div></td>
				<td colspan="2" valign="middle"><input name="vencimento" type="text" id="vencimento" OnKeyPress="formatar('##/##/####', this)" onBlur="dataano(this,this.value)" size="18"></td>				
			</tr>
			
			<tr bgcolor="#CCCCCC">
				<td>&nbsp;</td>
				<td valign="middle"><div align="left">Valor:</div></td>
				<td colspan="2" valign="middle"><input type="text" name="valor" id="valor" maxlength="10" size="18" style="text-align:right;" value="" onblur="format_val(this.value,this.id);">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="incluir" id="incluir" value="Incluir" onclick="enviar();"></td>				
			</tr>
			
              	
            <tr> 
              <td>&nbsp;</td>
              <td><div align="center">                   
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
