<?php
$flagmenu=3;
require("cverifica.php");

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Contagem</title>

<script src="js/digitacontagem.js"></script>

<script language="JavaScript1.2">

</script>

<noscript>
Habilite o Javascript para visualizar esta p?gina corretamente...
</noscript>
<style>
.borda{border: 1px solid;}
div{font-family: Verdana; font-size: 12px;}
td{font-family:Verdana ; font-size: 12px;}
.style3 {color: #000000}
</style>

</head>
<body onLoad="ver()";>

<div>

<form name="formulario">
<table width="215" height="274" border="2" cellspacing="0" cellpadding="0" bordercolor="#999999">
  <tr>
	<td width="214" height="270">
		<table width="100%"  height="20" border="0" cellpadding="0" cellspacing="0" bgcolor="#3366CC">
		  <tr>
			<td colspan="4" >
			<div align="center"><font color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif"><strong>Contagem Invent?rio</strong></font></div>
			</td>
		  </tr>
		</table>
		    <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">    
			  <tr> 
                <td height="8">&nbsp;</td>
                <td><!--DWLayoutEmptyCell-->&nbsp;</td>
                <td colspan="3">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>	
			  <tr> 
                <td>&nbsp;</td>
                <td> <div align="left">Data:</div></td>
                <td colspan="3"><input name="pvemissao" type="text" id="pvemissao" onKeyPress="maiusculo()" size="10" disabled="disabled" style="BACKGROUND-COLOR: White;COLOR : Black"></td>
                <td>&nbsp;</td>
              </tr>              
              <tr> 
                <td>&nbsp;</td>
                <td>Contagem:</td>
                <td colspan="2"> <select name="conferente">
                    <option id="conferente" value="0">____________________</option>
                  </select> </td>
                <td width="95" align="right">&nbsp;&nbsp;</td>
                <td width="1"><div align="center"> </div></td>
              </tr>
              <tr> 
                <td>&nbsp;</td>
                <td>Setor:</td>
                <td colspan="2"> <select name="separador">
                    <option id="separador" value="0">____________________</option>
                  </select> </td>
                <td width="95" align="right">&nbsp;&nbsp;</td>
                <td width="1"><div align="center"> </div></td>
              </tr>
			  <tr> 
                <td height="8">&nbsp;</td>
                <td><!--DWLayoutEmptyCell-->&nbsp;</td>
                <td colspan="3">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>	
              <tr> 
                <td height="18" colspan="6"><div align="center"> 
                    <input type="button" id="botao" onClick=dadosverifica1() value="Inicia" disabled>                    
                    <input type="button" id="botao2" onClick=dadosverifica2() value="Fim" disabled>					                   
                  </div></td>
              </tr>			
              <tr> 
                <td>&nbsp;</td>
                <td><!--DWLayoutEmptyCell-->&nbsp;</td>
                <td colspan="3">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr> 
                <td><span class="style3"></span></td>
                <td><span class="style3">Qtd:</span></td>
                <td colspan="3"><span class="style3"><input id="radio1" name="radiobutton" type="radio" value="radiobutton" disabled>Sim 
				 <input id="radio2" name="radiobutton" type="radio" value="radiobutton" checked disabled>N?o  
                  <input id="item" type="hidden" name="item" size="3" value="1" onKeyPress="maiusculo()" disabled="disabled"  style="BACKGROUND-COLOR: White;COLOR : Black">
				  				  
                  </span></td>
                <td><span class="style3"></span></td>
              </tr>
              <tr> 
                <td><span class="style3"></span></td>
                <td><span class="style3">C.Barra</span></td>
                <td colspan="3"><span class="style3"> 
                  <!--input id="cbarra" type="text" name="cbarra" size="20"  onKeyPress="entertabx('codigoproduto')"  onBlur="dadospesquisacbarras(this.value);"-->
				  <input id="cbarra" type="text" name="cbarra" size="20" onkeyup="if (this.value.length>11) {entertabx('codigoproduto');}" onBlur="dadospesquisacbarras(this.value);" disabled>
                  </span></td>
                <td><span class="style3"></span></td>	
				<span id=dummyspan></span>
              </tr>
              <tr> 
                <td><span class="style3"></span></td>
                <td><span class="style3">Codigo</span></td>
                <td colspan="3"><span class="style3"> 
                  <input id="codigoproduto" type="text" name="codigoproduto" size="6" onfocus="funcaopress()" OnKeyPress="formatar('####-#', this)" onBlur="dadospesquisapertence(this.value)" onkeyup="entertab('produto');" disabled>                  
                  </span></td>
                <td><span class="style3"></span></td>
              </tr>
			  <tr> 
                <td><span class="style3"></span></td>
                <td><span class="style3">Produto</span></td>
                <td colspan="3"><span class="style3">                   
                  <input id="produto" type="text" name="produto" size="20" onKeyPress="maiusculo()" onBlur="convertField(this);pesquisaprodutos(this.value);" disabled>
                  </span></td>
                <td><span class="style3"></span></td>
              </tr>
              <tr> 
                <td>&nbsp;</td>
                <td>Pesquisa</td>
                <td colspan="3"> <select name="pesquisaproduto" onBlur="pesquisacod(this.value)" disabled>
                    <option id="pesquisaproduto2" value="0">_________________</option>
                  </select> </td>
                <td>&nbsp;</td>
              </tr>
              <tr> 
                <td>&nbsp;</td>
                <td>Quant.</td>
                <td colspan="2"><input id="quant" type="text" name="quant" size="5" onKeyPress="maiusculo()" disabled>
                  <input name="button" type="button" id="button" onBlur="funcaopress()" onClick="dadospesquisaconfirma()" onKeyDown="enterclik(event,this)" value="Incluir" disabled>  
                </td>
                <td  align="left"><!--DWLayoutEmptyCell-->&nbsp; </td>
                <td>&nbsp;</td>
              </tr>
              <tr> 
                <td>&nbsp;</td>
                <td><!--DWLayoutEmptyCell-->&nbsp;</td>
                <td colspan="3">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>	
			  <tr> 
                <td height="18" colspan="6"><div align="center"> 
                    <input type="button" id="botao4" onClick=dadosverifica4() value="Ver" disabled>                    
                    <input type="button" id="botao3" onClick=dadosverifica3() value="Encerra" disabled>	
                  </div></td>
              </tr>		
			  <tr> 
                <td>&nbsp;</td>
                <td><!--DWLayoutEmptyCell-->&nbsp;</td>
                <td colspan="3">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>		
            </table>
	</td>
  </tr>
</table>

<div id="msg" style="visibility: hidden;">&nbsp;<font face="Verdana" size="2">Processando...</font></div>
<div id="resultado"></div>
<div id="resultado2"></div>

    </form>

</div>
<br>
</body>
</html>

