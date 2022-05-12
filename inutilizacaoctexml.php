<?php 
$flagmenu=2;
// Verificador de sessão
require("verifica.php");
 
$usuario 	= $_SESSION["id_usuario"]; 
 


?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Inutilização de Cte</title>

<script src="js/inutilizacaoctexml.js"></script>
<script src="js/geral.js"></script>

<noscript>
Habilite o Javascript para visualizar esta página corretamente...
</noscript>
<style>
.borda{border: 1px solid;}
div{font-family: Verdana; font-size: 12px;}
td{font-family: Verdana; font-size: 12px;}
input{font-family: Verdana; font-size: 12px;}
</style>

</head>
<body>
 
<div>
<Center>
<form name="formulario">
<table width="500" height="140" border="2" cellspacing="0" cellpadding="0" bordercolor="#999999">
  <tr>
	<td>
		<table width="100%"  height="20" border="0" cellpadding="0" cellspacing="0" bgcolor="#3366CC">
		  <tr>
			<td colspan="4" >
			<div align="center"><font color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif"><strong>Inutilização de CT-e (XML)</strong></font></div>
			</td>
		  </tr>
		</table>
		    <table width="100%" height="120" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">

			   <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>			  

			
			 <tr>
				<td>&nbsp;Op&ccedil;&atilde;o:&nbsp;</td>
				<td colspan="3">
				<input type="radio" name="radiobutton" id="radio1" value="radiobutton" checked> Número Controle
				<input type="radio" name="radiobutton" id="radio2" value="radiobutton"> Número
				<input type="radio" name="radiobutton" id="radio3" value="radiobutton"> Chave
				</td>
			 </tr>
			  
			 <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
             </tr>		 
			 
			 <tr>
                <td>&nbsp;Pesquisar:&nbsp;</td>
                <td colspan="3">
				<input id="pesquisa" type="text" name="pesquisa" size="37" maxlength="30" onKeyPress="maiusculo()" onBlur="convertField(this);">
				<input name="button" type="button" id="button" onClick=dadospesquisa(pesquisa.value) value="Pesquisar">
				</td>
                <td>&nbsp;</td>
             </tr>
			
			 <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
             </tr>		 
			 
			 
			  <tr>
                <td>&nbsp;Núm.Controle:&nbsp;</td>
                <td colspan="5">
				<input id="controle" type="text" name="controle" size="10" disabled>
				Número:
				<input id="numero" type="text" name="numero" size="10" disabled>
				
				
				<input id="ctecodigo" type="hidden" name="ctecodigo" size="10">
				
				</td>
             
             </tr>
			
			
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>			  

			
			
			  <tr>
                <td>&nbsp;Chave:&nbsp;</td>
                <td colspan="5">
				
				<input id="chave" type="text" name="chave" size="50" disabled>
				
				</td>
             
             </tr>
			
			
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>		
			
			
			
			  

			  <tr>
                <td>&nbsp;Motivo:&nbsp;</td>
                <td colspan="4">
				
                <input id="motivo" type="text" name="motivo" size="50" maxlength="50" onKeyPress="maiusculo()" onBlur="convertField(this);">
                </td>
                <td>&nbsp;</td>
              </tr>			  
			  
			  			  
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>

			  			  
			  
			  <tr>
                <td colspan="4">
                  <div align="center">
                  <input type="button" id="botao3" onClick=env("<? echo $usuario ?>") value="Confirma">
                  </div>
                  </td>
              </tr>
			  
			  <!--tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr-->
			  
			  <tr bgcolor="#CCCCCC">
				<td colspan="4">
					<div align="center"><p style='color:blue'><small><b>Atenção, essa opção ainda está em fase de testes!</b></small></p></div>           
				</td>
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
