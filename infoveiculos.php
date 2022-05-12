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

<script src="js/infoveiculos.js"></script>
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
<table width="920" height="200" border="2" cellspacing="0" cellpadding="0" bordercolor="#999999">
  <tr>
	<td>
		<table width="100%"  height="20" border="0" cellpadding="0" cellspacing="0" bgcolor="#3366CC">
		  <tr>
			<td colspan="4" >
			<div align="center"><font color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif"><strong>Veiculos</strong></font></div>
			</td>
		  </tr>
		</table>
		    
          <table width="100%" height="180" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">            
           
            <tr bgcolor="#CCCCCC">
				<td height="10" colspan="8">&nbsp;</td>
			</tr>	
			
			<tr>
				<td width="23">&nbsp;</td>
				<td width="900" colspan="6">Opção:&nbsp;<input name="radiobutton" id="radio1" type="radio" value="radiobutton" checked> C.Interno
				<input type="radio" name="radiobutton" id="radio2" value="radiobutton"> Renavan
				<input type="radio" name="radiobutton" id="radio3" value="radiobutton">	Placa &nbsp;&nbsp;&nbsp;<input id="pesquisa" type="text" name="pesquisa" size="30" onkeypress="maiusculo();">&nbsp;&nbsp;&nbsp;<input type="button" name="pesquisar" id="pesquisar" value="Pesquisar" onClick="dadospesquisa(pesquisa.value);">&nbsp;&nbsp;&nbsp;<select name="listDados"
					onChange="dadospesquisa2(this.value);">
					<option id="opcoes" value="0">____________________________</option>
				</select></td>				
				<td width="10">&nbsp;</td>
				<input id="veicodigo" type="hidden"	name="veicodigo" size="25"><input id="veicod" type="hidden" name="veicod"	size="10" >
			</tr>
			
			<tr bgcolor="#CCCCCC">
				<td height="10" colspan="8">&nbsp;</td>
			</tr>	
			

			<tr>
				<td width="23">&nbsp;</td>
				<td width="170">C.Interno</td>
				<td width="150">Renavan</td>
				<td width="150">Placa</td>
				<td width="150">Tara (Kg)</td>
				<td width="150">Capacidade (Kg)</td>
				<td width="130">Capacidade (M3)</td>
				<td width="10">&nbsp;</td>
			</tr>
			
			<tr>
				<td width="23">&nbsp;</td>
				<td width="170"><input id="veicodint" type="text" name="veicodint" size="16" onkeyup="javascrip :this.value=this.value.toUpperCase();" maxlength="10"></td>
				<td width="150"><input id="veirenavam" type="text" name="veirenavam" size="16" onkeyup="javascript:this.value=this.value.toUpperCase();" maxlength="25"></td>
				<td width="150"><input id="veiplaca" type="text" name="veiplaca" size="16" onkeyup="javascript:this.value=this.value.toUpperCase();" maxlength="25"></td>
				<td width="150"><input id="veitara" type="text" name="veitara" size="16" onkeyup="javascript:this.value=this.value.toUpperCase();" onKeyPress="return soNums(event);" onBlur="convertField3(this);" maxlength="40"></td>
				<td width="150"><input id="veicapacidadekg" type="text" name="veicapacidadekg" size="16" onkeyup="javascript:this.value=this.value.toUpperCase();" onKeyPress="return soNums(event);" onBlur="convertField3(this);" maxlength="40"></td>
				<td width="130"><input id="veicapacidademt" type="text" name="veicapacidademt" size="16" onkeyup="javascript:this.value=this.value.toUpperCase();" onKeyPress="return soNums(event);" onBlur="convertField3(this);" maxlength="40"></td>
				<td width="10">&nbsp;</td>
			</tr>
			
			<tr bgcolor="#CCCCCC">
				<td height="10" colspan="8">&nbsp;</td>
			</tr>
			
			<tr>
				<td width="23">&nbsp;</td>
				<td width="170">Tipo Rodado</td>
				<td width="150">Tipo Carroceria</td>
				<td width="150">Tipo Veiculo</td>
				<td width="150">Proprietario</td>
				<td width="150">UF</td>
				<td width="130">Veiculo Emitente</td>
				<td width="10">&nbsp;</td>
			</tr>
			
			<tr>
				<td width="23">&nbsp;</td>
				<td width="170" ><select name="veitiporodado"><option id="veicodtiporodado" value="0">______________</option></select></td>
				<td width="150" ><select name="veitipocarroceria"><option id="veicodtipocarroceria" value="0">______________</option></select></td>
				<td width="150" ><select name="veitipoveiculo"><option id="veicodtipoveiculo" value="0">______________</option></select></td>            			   		
				<td width="150" ><select name="veitipopropveiculo"><option id="veicodtipopropveiculo" value="0">______________</option></select></td>
				<td width="150" ><select name="listestados"><option id="veicoduf" value="0">______________</option></select></td>
				<td width="130" ><input name="radiobutton3" type="radio" id="radio31" value="radiobutton" onclick="verificaveiculo(this.value);" checked> Sim
				<input type="radio" name="radiobutton3" id="radio32" value="radiobutton" onclick="verificaveiculo(this.value);"> Não</td>            			   		
				<td width="10">&nbsp;</td>
			</tr>
			
			<tr bgcolor="#CCCCCC">
				<td height="10" colspan="8">&nbsp;</td>
			</tr>
			
			<tr>
				<td width="23">&nbsp;</td>
				<td width="170">Pessoa</td>
				<td width="150">C.N.P.J.</td>
				<td width="150">I.E.</td>
				<td width="150">C.P.F.</td>
				<td width="150">RNTRC</td>               					
				<td width="130">Estado</td>               					
				<td width="10">&nbsp;</td>
			</tr>
			
			<tr>
				<td width="23">&nbsp;</td>
				<td width="170"><input name="radiobutton2" type="radio" id="radio11" value="radiobutton" onclick="verificapessoa(this.value);" checked disabled>
								Jur&iacute;dica<input type="radio" name="radiobutton2" id="radio12" value="radiobutton" onclick="verificapessoa(this.value);" disabled>
									F&iacute;sica</td>			               							
				<td width="150"><input id="veicnpj" type="text" name="veicnpj" size="17" maxlength="18" onKeyPress="return soNums(event);" onBlur="validar(this);" disabled></td>
				<td width="150"><input id="veiie" type="text" name="veiie" size="17" onkeyup="javascript:this.value=this.value.toUpperCase();" disabled></td>
				<td width="150"><input id="veicpf" type="text" name="veicpf" size="17" maxlength="14" onKeyPress="return soNums(event);" onBlur="validar2(this);" disabled></td>
				<td width="150"><input id="veirntrc" type="text" name="veirntrc" size="17" maxlength="14" disabled></td>
				<td width="130" ><select name="listestados2" disabled><option id="veicodufprop" value="0">______________</option></select></td>            			   							
				<td width="10">&nbsp;</td>
			</tr>	
			
			<tr bgcolor="#CCCCCC">
				<td height="10" colspan="8">&nbsp;</td>
			</tr>
			
			<tr>
				<td width="23">&nbsp;</td>
				<td width="170">Tipo</td>
				<td width="730" colspan="5">Razao</td>				
				<td width="10">&nbsp;</td>
			</tr>
			
			<tr>
				<td width="23">&nbsp;</td>
				<td width="170"><select name="veitipproprietario" disabled><option id="veicodtipproprietario" value="0">______________</option></select></td>
				<td width="600" colspan="4"><input id="veirazao" type="text" name="veirazao" size="90" onkeyup="javascript:this.value=this.value.toUpperCase();" maxlength="40" disabled></td>
				<td width="130"><input type="button" name="incluir" id="incluir" value="Incluir" onclick="valida_form();"></td>				
				<td width="10">&nbsp;</td>
			</tr>
			
			<tr bgcolor="#CCCCCC">
				<td height="10" colspan="8">&nbsp;</td>
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
