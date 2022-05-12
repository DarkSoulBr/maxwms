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

<script src="js/infocoleta.js"></script>
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
<table width="500" height="140" border="2" cellspacing="0" cellpadding="0" bordercolor="#999999">
  <tr>
	<td>
		<table width="100%"  height="20" border="0" cellpadding="0" cellspacing="0" bgcolor="#3366CC">
		  <tr>
			<td colspan="4" >
			<div align="center"><font color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif"><strong>Ordem de Coleta Associada</strong></font></div>
			</td>
		  </tr>
		</table>
		    
          <table width="100%" height="120" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">            
		  		
			
			<tr>
				<td width="23">&nbsp;</td>
				<td width="150">Série da OCC</td>
				<td width="150">Número da OCC</td>
				<td width="150">Data de Emissão</td>				
				<td width="10">&nbsp;</td>
			</tr>
			
			<tr>
				<td width="23">&nbsp;</td>				
				<td width="150"><input type="text" name="serie" id="serie" maxlength="3" size="19" onkeyup="this.value=this.value.toUpperCase()" onBlur="convertField(this);"></td>
				<td width="150"><input type="text" name="numero" id="numero" maxlength="6" size="19" onkeypress='return SomenteNumero(event)'></td>
				<td width="150"><input type="text" name="emissao" id="emissao" maxlength="10" size="19" OnKeyPress="formatar('##/##/####', this)" onBlur="dataano(this,this.value)" ></td>
				<td width="10">&nbsp;</td>
				<input name="hidden" type="hidden" id="codcoleta" value="">
			</tr>
			
			<tr>
				<td width="23">&nbsp;</td>
				<td width="150">CNPJ</td>
				<td width="150">I.E.</td>
				<td width="150">UF</td>				
				<td width="10">&nbsp;</td>
			</tr>
			
			<tr>
				<td width="23">&nbsp;</td>				
				<td width="150"><input id="forcnpj" type="text" name="forcnpj"
					size="19" maxlength="18" onKeyPress="return soNums(event);"
					onBlur="validar(this);"></td>
				<td width="150"><input id="forie" type="text" name="forie" size="19"
					onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
				<td width="150"><select name="estado"><option id="estado" value="0">_____</option></select></td>
				<td width="10">&nbsp;</td>
			</tr>
			
			<tr>
				<td width="23">&nbsp;</td>
				<td width="150">Telefone</td>
				<td width="150">Código Interno</td>
				<td width="150"></td>				
				<td width="10">&nbsp;</td>
			</tr>
			
			<tr>
				<td width="23">&nbsp;</td>				
				<td width="150"><input id="fnefone" type="text" name="fnefone" size="19"
					onKeyPress="Mascara(this,Telefone);" onBlur="convertField(this);"
					 maxlength="13"></td>
				<td width="150"><input type="text" name="interno" id="interno" maxlength="10" size="19" onkeyup="this.value=this.value.toUpperCase()" onBlur="convertField(this);"></td>
				<td width="150"><input type="button" name="incluir" id="incluir" value="Incluir" onclick="enviar();"></td>
				<td width="10">&nbsp;</td>
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
