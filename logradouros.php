<?php
$flagmenu=2;
// Verificador de sessão
require("verifica.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Tabela</title>

<script src="js/logradouros.js"></script>

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
<table width="400" height="200" border="2" cellspacing="0" cellpadding="0" bordercolor="#999999">
  <tr>
	<td>
		<table width="100%"  height="20" border="0" cellpadding="0" cellspacing="0" bgcolor="#3366CC">
		  <tr>
			<td colspan="4" >
			<div align="center"><font color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif"><strong>Cadastro 
                    de Logradouros</strong></font></div>
			</td>
		  </tr>
		</table>
		    <table width="100%" height="180" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
              <tr>
                <td>&nbsp;</td>
                <td><div align="left">Pesquisar:</div></td>
                <td><input id="pesquisa" type="text" name="pesquisa" size="68" onKeyPress="maiusculo()"></td>
                <td><div align="center"> 
                    <input name="button" type="button" id="button" onClick=dadospesquisa(pesquisa.value) value="Pesquisar">
                  </div></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td> <div align="left">Logradouro:</div></td>
                <td><select name="listDados" onChange="dadospesquisa2(this.value);">
                    <option id="opcoes" value="0">_________________________________________________________</option>
                  </select></td>
                <td><div align="center">
                    <input id="codigo" type="hidden" name="codigo" size="10">
                  </div></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr> 
                <td>&nbsp;</td>
                <td><div align="left">Logradouro:</div></td>
                <td><input id="logradouro" type="text" name="logradouro" size="68" onKeyPress="maiusculo()"></td>
                <td>&nbsp;</td>
              </tr>
			  <tr> 
                <td>&nbsp;</td>
                <td><div align="left">Cidade:</div></td>
                <td><input id="cidade" type="text" name="cidade" size="53" onKeyPress="maiusculo()" onBlur="dadospesquisa3x(this.value);">
                UF:
                <input id="uf" type="text" name="uf" size="5" disabled onKeyPress="maiusculo()">
                </td>
                <td>&nbsp;</td>
              </tr>
			  <tr>
                <td>&nbsp;</td>
                <td>Pesquisa:</td>
                <td><select name="listcidades" onChange="dadospesquisa4(this.value);"  onBlur="dadospesquisa4(this.value);">
                    <option id="opcoes2" value="0">_________________________________________________________</option>
                  </select></td>
                <td><div align="center">
                    <input id="codigocidade" type="hidden" name="codigocidade" size="10">
                  </div></td>
              </tr>
			  <tr>
                <td>&nbsp;</td>
                <td><div align="left">Bairro:</div></td>
                <td><input id="bairro" type="text" name="bairro" size="68" onKeyPress="maiusculo()" onBlur="dadospesquisa5x(this.value);"></td>
                <td>&nbsp;</td>
              </tr>
			  <tr>
                <td>&nbsp;</td>
                <td>Pesquisa:</td>
                <td><select name="listbairros" onChange="dadospesquisa6(this.value);" onBlur="dadospesquisa6(this.value);">
                    <option id="opcoes3" value="0">_________________________________________________________</option>
                  </select></td>
                <td><div align="center">
                    <input id="codigobairro" type="hidden" name="codigobairro" size="10">
                </div></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>Cep:</td>
                <td><input id="cep" type="text" name="cep" size="10" onKeyPress="maiusculo()"></td>
                <td>&nbsp;</td>
              </tr>
			  <tr> 
                <td>&nbsp;</td>
                <td><div align="center"> 
                    <input name="button2" type="button" id="botao" onClick=valida_form() value="Incluir">
                  </div></td>
                <td><div align="center"> 
                    <input type="button" id="botao2" onClick=limpa_form() value="Limpar">
                  </div></td>
                <td><div align="center"> 
                    <input type="button" id="botao3" onClick=verifica() value="Excluir">
                  </div>
                  <input name="hidden" type="hidden" id="acao" value="inserir"> </td>
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
