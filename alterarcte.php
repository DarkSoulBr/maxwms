<?php      
$flagmenu=2;  
// Verificador de sessão
require("verifica.php");

include 'include/jquerymax.php';
include 'include/css.php';
$usuario = $_SESSION["id_usuario"];
$numcte = trim($_GET["numcte"]);
 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">  
<html>
<head>
<title>Tabela</title>

	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />	
	<style type="text/css" media="screen">
		@import url("aba.css");
	</style>

<script src="js/alterarcte.js"></script>
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
.borda2{border: 1px solid; font-size: 12px;font-family: Courier New}
</style>

</head>
<div id="dialog" style="margin-left: 5px; margin-left: 5px; background:white;"></div>
<body onload="load_pedido('<?php echo $usuario ?>','<?php echo $numcte ?>');">

<Center>
<form name="formulario" method="POST">
<!--<table width="938" height="230" border="2" cellspacing="0" cellpadding="0" bordercolor="#999999"> alterado para border 0  -->
<table width="1000" height="230" border="0" cellspacing="0" cellpadding="0" bordercolor="#999999">
	<tr>
		<td width="100%">
		
		
	<div class="tabs-container">
    
    <!-- ABA 1 -->
    <input type="radio" name="tabs" class="tabs" id="tab1" checked>
    <label for="tab1">CTe</label>
    <div>
	
	 
		
			<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#3366CC">
		  		<tr>
					<td valign="middle" height="25"><div align="center"><font color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif"><strong>Conhecimento de Transporte Eletrônico - Alteração</strong></font></div></td>
		  		</tr>
		  		<tr bgcolor="#CCCCCC">
		  			<td valign="top" width="100%">
		  				<table border="0" cellpadding="0" cellspacing="0" width="100%">
		  					<tr bgcolor="#CCCCCC">
			               		<td height="10" colspan="11">&nbsp;</td>
			            	</tr>																						
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="100">Controle</td>
			               		<td width="100">Modelo</td>
            			   		<td width="100">Série</td>
            			   		<td width="100">Número</td>
            			   		<td width="100">Emisssão</td>
               					<td width="100">Horario</td>
								<td width="300" colspan="3">Chave</td>								
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="100"><input type="text" name="orcnumero" id="orcnumero" maxlength="10" size="10" onBlur="load_pedidopesq0(this.value,'<?php echo $usuario ?>')"></td>
			               		<td width="100"><input type="text" name="modelo" id="modelo" maxlength="10" size="10" ></td>
            			   		<td width="100"><input type="text" name="serie" id="serie" maxlength="10" size="10" ></td>
            			   		<td width="100"><input type="text" name="numero" id="numero" maxlength="10" size="10" ></td>
            			   		<td width="100"><input type="text" name="orcemissao" id="orcemissao" maxlength="10" size="10" readonly></td>
               					<td width="100"><input type="text" name="orchora" id="orchora" maxlength="10" size="10" readonly></td>
								<td width="300" colspan="3"><input type="text" name="orcchave" id="orcchave" maxlength="45" size="50" readonly style="font-size:9px;"></td>								
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr bgcolor="#CCCCCC">
			               		<td height="10" colspan="11">&nbsp;</td>
			            	</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="100">CFOP</td>
               					<td width="500" colspan="5">Natureza da Operação</td>
								<td width="300" colspan="3">Finalidade de Emissao</td>
								<td width="10">&nbsp;</td>
            				</tr>
							 
							<tr>
								<td width="23">&nbsp;</td>
								<td width="100"><input type="text" name="cfop" id="cfop" maxlength="4" size="10" onkeypress='return SomenteNumero(event)' onBlur="verificacfop(this.value)"></td>
               					<td width="500" colspan="5"><input type="text" name="natureza" id="natureza" maxlength="60" size="67" onkeyup="this.value=this.value.toUpperCase()" onBlur="convertField(this);"></td>
								<td width="300" colspan="3"><select name="finalidade"  onChange="verificaFinalidade(this.value);"><option id="finalidade" value="0">________________________________</option></select></td>            			   		
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr bgcolor="#CCCCCC">
			               		<td height="10" colspan="11">&nbsp;</td>
			            	</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="100">Forma Pagto</td>
               					<td width="200" colspan="2">Modal</td>								
			               		<td width="300" colspan="3">Tipo de Servico</td>
            			   		<td width="300" colspan="3">Chave de Acesso</td>            			   		
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="100"><select name="pagto"><option id="pagto" value="0">________________</option></select></td>
               					<td width="200" colspan="2"><select name="modal"><option id="modal" value="0">________________</option></select></td>								
			               		<td width="300" colspan="3"><select name="servico"><option id="servico" value="0">________________________________</option></select></td>
            			   		<td width="300" colspan="3"><input type="text" name="chavefin" id="chavefin" maxlength="50" size="50" onkeypress='return SomenteNumero(event)' disabled style="font-size:9px;"></td>
								<td width="10">&nbsp;</td>
            				</tr>							
							
							<tr bgcolor="#CCCCCC">
			               		<td height="10" colspan="11">&nbsp;</td>
			            	</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="300" colspan="3">Forma de Emissao</td>
			               		<td width="300" colspan="3">Chave Acesso CTe Referenciado</td>
            			   		<td width="300" colspan="3">Data Emissão Declaração Tomador</td>            			   		
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>               					
			               		<td width="300" colspan="3"><select name="forma"><option id="forma" value="0">________________________________</option></select></td>
            			   		<td width="300" colspan="3"><input type="text" name="chave" id="chave" maxlength="50" size="45" onkeypress='return SomenteNumero(event)' style="font-size:9px;"></td>            			   										
								<td width="300" colspan="3"><input type="text" name="datatomador" id="datatomador" maxlength="10" size="10" OnKeyPress="formatar('##/##/####', this)" onBlur="dataano(this,this.value)" disabled></td>
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr bgcolor="#CCCCCC">
			               		<td height="10" colspan="11">&nbsp;</td>
			            	</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="300" colspan="3">Local de Emissão do CTe</td>
			               		<td width="300" colspan="3">Local de Início da Prestação</td>
            			   		<td width="300" colspan="3">Local de Término da Prestação</td>            			   		
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="300" colspan="3"><select name="estado" onChange="dadospesquisacidade(this.value,0)"><option id="estado" value="0">_____</option></select></td>
			               		<td width="300" colspan="3"><select name="estadoini" onChange="dadospesquisacidadeini(this.value,0)"><option id="estadoini" value="0">_____</option></select></td>
            			   		<td width="300" colspan="3"><select name="estadofim" onChange="dadospesquisacidadefim(this.value,0)"><option id="estadofim" value="0">_____</option></select></td>            			   		
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="300" colspan="3"><select name="cidade">&nbsp;<option id="cidade" value="0">________________________________</option></select></td>
			               		<td width="300" colspan="3"><select name="cidadeini">&nbsp;<option id="cidadeini" value="0">________________________________</option></select></td>
            			   		<td width="300" colspan="3"><select name="cidadefim">&nbsp;<option id="cidadefim" value="0">________________________________</option></select></td>            			   		
								<td width="10">&nbsp;</td>
            				</tr>
							
			            </table>
					</td>
				</tr>
            	 
				  
				<tr bgcolor="#CCCCCC"> 
					<td height="17" colspan="4">&nbsp;</td>
				</tr>	
				 
			  <tr bgcolor="#CCCCCC">
                <td colspan="6"> <Center>
                	<input type="button" id="botaoinc" value="Alterar" onclick="incluirorcamento(1);"> 
					&nbsp;&nbsp;&nbsp;	
					
					<input type="hidden" id="botaoimp" value="Imprimir" onclick="Imprimir(orcnumero.value,<?php echo $usuario ?>);"> 
										
					<input type="button" id="botaoxml" value="XML" onclick="Imprimirxml(orcnumero.value,<?php echo $usuario ?>);"> 
					&nbsp;&nbsp;&nbsp;	
					
					<input type="button" id="botaoproceda" value="Proceda" onclick="Imprimirproceda(orcnumero.value,<?php echo $usuario ?>);"> 
					&nbsp;&nbsp;&nbsp;

					<input type="button" id="botaodatasul" value="Datasul" onclick="Imprimirdatasul(orcnumero.value,<?php echo $usuario ?>);"> 
					&nbsp;&nbsp;&nbsp;	
					
					<input type="button" id="botaoexc" value="Excluir" onclick="excluirorcamento(orcnumero.value,<?php echo $usuario ?>);"> 
					&nbsp;&nbsp;&nbsp;						
					<input type="button" id="cancelaPedido" onclick="cancelarPedido()" value="Cancelar">	

					&nbsp;&nbsp;&nbsp;	
					<input type="button" id="fechar" onclick="fechar1()" value="Fechar">	
					
                  </Center></td>                
              </tr>
			  
			  <tr bgcolor="#CCCCCC">
			  <td height="20" colspan="6">&nbsp;</td>
			  </tr>
				
            </table>
	
    </div>
    
    <!-- ABA 2 -->
    <input type="radio" name="tabs" class="tabs" id="tab2">
    <label for="tab2">Empresas</label>
    <div>	
	
			<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#3366CC">
		  		<tr>
					<td valign="middle" height="25"><div align="center"><font color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif"><strong>Conhecimento de Transporte Eletrônico					
					<input name="radiobuttonempresa" id="radioempresa1" type="radio" value="radiobutton" checked onclick="verificaempresa(this.value);"> Emitente 
					<input type="radio"	name="radiobuttonempresa" id="radioempresa2" value="radiobutton" onclick="verificaempresa(this.value);"> Tomador
					<input type="radio" name="radiobuttonempresa" id="radioempresa3" value="radiobutton" onclick="verificaempresa(this.value);"> Remetente
					<input type="radio" name="radiobuttonempresa" id="radioempresa4" value="radiobutton" onclick="verificaempresa(this.value);"> Expedidor 
					<input type="radio" name="radiobuttonempresa" id="radioempresa5" value="radiobutton" onclick="verificaempresa(this.value);"> Recebedor 
					<input type="radio" name="radiobuttonempresa" id="radioempresa6" value="radiobutton" onclick="verificaempresa(this.value);"> Destinatário					
					</strong></font></div></td>
		  		</tr>
				
		  		<tr bgcolor="#CCCCCC" id="linhaemitente">
		  			<td valign="top" width="100%">
		  				<table border="0" cellpadding="0" cellspacing="0" width="100%">
		  					<tr bgcolor="#CCCCCC">
			               		<td height="10" colspan="8">&nbsp;</td>
			            	</tr>																						
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="260" colspan="2">Tipo de Emitente</td>
			               		<td width="160">C.N.P.J.</td>
            			   		<td width="160">I.E.</td>
            			   		<td width="160">C.P.F.</td>
            			   		<td width="160">R.G.</td>               					
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="260" colspan="2"><input name="radiobutton2" type="radio" id="radio11" value="radiobutton" onclick="verificapessoa(this.value);" checked>
												Pessoa Jur&iacute;dica&nbsp;&nbsp;&nbsp;<input type="radio" name="radiobutton2" id="radio12" value="radiobutton" onclick="verificapessoa(this.value);">
													Pessoa F&iacute;sica</td>			               							
            			   		<td width="160"><input id="forcnpj" type="text" name="forcnpj" size="17" maxlength="18" onKeyPress="return soNums(event);" onBlur="validar(this);"></td>
            			   		<td width="160"><input id="forie" type="text" name="forie" size="17"
													onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
            			   		<td width="160"><input id="forcpf" type="text" name="forcpf" size="17"
													maxlength="14" onKeyPress="return soNums(event);"
														onBlur="validar2(this);" disabled></td>
               					<td width="160"><input id="forrg" type="text" name="forrg" size="17"
													onkeyup="javascript:this.value=this.value.toUpperCase();" disabled></td>
								<td width="10">&nbsp;</td>
            				</tr>	
								
							<tr bgcolor="#CCCCCC">
			               		<td height="10" colspan="8">&nbsp;</td>
			            	</tr>	
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="300" colspan="2">Nome Guerra</td>
               					<td width="600" colspan="4">Razao</td>
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="300" colspan="2"><input id="fornguerra" type="text" name="fornguerra"
																size="35" onkeyup="javascrip :this.value=this.value.toUpperCase();"
																	maxlength=25></td>
               					<td width="600" colspan="4"><input id="forrazao" type="text" name="forrazao"
																size="88" onkeyup="javascript:this.value=this.value.toUpperCase();" maxlength=40></td>
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr bgcolor="#CCCCCC">
			               		<td height="10" colspan="8">&nbsp;</td>
			            	</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="300" colspan="2">CEP</td>
               					<td width="450" colspan="3">Endereço</td>
								<td width="150">Número</td>
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="300" colspan="2"><input id="fnecep" type="text" name="fnecep"
													size="12" onkeyup="javascript:this.value=this.value.toUpperCase();"
														onBlur="pesquisacep(this.value);" onkeypress='return SomenteNumero(event)' maxlength=8></td>
               					<td width="450" colspan="3"><input id="fneendereco" type="text"
													name="fneendereco" size="62"
														onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
								<td width="150"><input id="fnenumero" type="text" name="fnenumero"
													size="18" maxlength=10></td>						
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr bgcolor="#CCCCCC">
			               		<td height="10" colspan="8">&nbsp;</td>
			            	</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="300" colspan="2">Bairro</td>
               					<td width="450" colspan="3">Complemento</td>
								<td width="150">Telefone</td>
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="300" colspan="2"><input id="fnebairro" type="text" name="fnebairro"
																size="35" onkeyup="javascript:this.value=this.value.toUpperCase();" maxlength="30"></td>
               					<td width="450" colspan="3"><input id="fnecomplemento" type="text"
																name="fnecomplemento" size="62"
																	onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
								<td width="150"><input id="fnefone" type="text" name="fnefone" size="18"
													onKeyPress="Mascara(this,Telefone);" onBlur="convertField(this);"
														maxlength=13></td>									
								<td width="10">&nbsp;</td>
            				</tr>	

							<tr bgcolor="#CCCCCC">
			               		<td height="10" colspan="8">&nbsp;</td>
			            	</tr>	
													
							<tr>
								<td width="23">&nbsp;</td>
								<td width="150">Pais</td>
								<td width="150">Estado</td>
               					<td width="300" colspan="2">Cidade</td>
								<td width="300" colspan="2">Cidade IBGE</td>
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="150"><input id="fnepais" type="text" name="fnepais" size="18"
													onBlur="convertField(this);"
														maxlength=50 disabled></td>
								<td width="150"><input id="fneuf" type="text" name="fneuf" size="10"
													disabled onkeyup="javascript:this.value=this.value.toUpperCase();">
														<input id="fnecodcidade" type="hidden" name="fnecodcidade" size="3"
															disabled onkeyup="javascript:this.value=this.value.toUpperCase();"></td>								
               					<td width="300" colspan="2"><input id="fnecidade" type="text" name="fnecidade"
																size="42" disabled
																	onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
								<td width="300" colspan="2"><select name="cidadeibge" id="cidadeibge" disabled>
										<option id="cidcodigoibge" value="0">__________________________________</option>
											</select></td>									
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr bgcolor="#CCCCCC"> 
								<td height="35" colspan="4">&nbsp;</td>
							</tr>	
																					
			            </table>
					</td>
				</tr>
				
				<tr bgcolor="#CCCCCC" id="linhatomador" style="display: none;">
		  			<td valign="top" width="100%">
		  				<table border="0" cellpadding="0" cellspacing="0" width="100%">
							
							<tr bgcolor="#CCCCCC">
			               		<td height="10" colspan="8">&nbsp;</td>
			            	</tr>		
						
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="300" colspan="2">Tomador do Servico</td>
			               		<td width="450" colspan="3">Pesquisar</td>
            			   		<td width="150"></td>            			   		
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="300" colspan="2"><select name="tomador" onChange="dadospesquisavertomador(this.value);">&nbsp;<option id="tomador" value="0">________________________________</option></select></td>
			               		<td width="450" colspan="3"><input id="pesquisatomador" type="text" name="pesquisatomador"
																size="62" onkeypress="maiusculo();"
																	onblur="convertField(this);dadospesquisatomador(this.value);" disabled></td>
            			   		<td width="150"><input name="buttontomador" type="button" id="buttontomador"
													onClick="dadospesquisatomador(pesquisatomador.value);" value="Pesquisar" disabled></td>            			   		
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="300" colspan="2">Empresa</td>
			               		<td width="450" colspan="3">Opções da Pesquisa</td>
            			   		<td width="150"></td>            			   		
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="300" colspan="2"><select name="listDadosTomador" onChange="dadospesquisatomador2(this.value);" disabled>&nbsp;<option id="opcaoDadosTomador" value="0">______________________________</option></select></td>
			               		<td width="600" colspan="4"><input name="radiobutton" id="radio1" type="radio"
															value="radiobutton" checked disabled> C&oacute;digo <input type="radio"
															name="radiobutton" id="radio2" value="radiobutton" disabled> Nome de Guerra <input
															type="radio" name="radiobutton" id="radio3" value="radiobutton" disabled>
															Raz&atilde;o Social<input type="radio" name="radiobutton" id="radio4"
															value="radiobutton" disabled> CNPJ <input type="radio" name="radiobutton"
															id="radio5" value="radiobutton" disabled> CPF</td>            			   		
								<td width="10">&nbsp;</td>
            				</tr>

							
						
		  					<tr bgcolor="#CCCCCC">
			               		<td height="10" colspan="8">&nbsp;</td>
			            	</tr>																						
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="260" colspan="2">Tipo</td>
			               		<td width="160">C.N.P.J.</td>
            			   		<td width="160">I.E.</td>
            			   		<td width="160">C.P.F.</td>
            			   		<td width="160">R.G.</td>               					
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="260" colspan="2"><input name="radiobuttontom2" type="radio" id="radiotom11" value="radiobuttontom" onclick="verificapessoatom(this.value);" checked disabled>
												Pessoa Jur&iacute;dica&nbsp;&nbsp;&nbsp;<input type="radio" name="radiobuttontom2" id="radiotom12" value="radiobuttontom" onclick="verificapessoatom(this.value);" disabled>
													Pessoa F&iacute;sica</td>			               							
            			   		<td width="160"><input id="tomcnpj" type="text" name="tomcnpj" size="17" maxlength="18" onKeyPress="return soNums(event);" onBlur="validar(this);" disabled></td>
            			   		<td width="160"><input id="tomie" type="text" name="tomie" size="17"
													onkeyup="javascript:this.value=this.value.toUpperCase();" disabled></td>
            			   		<td width="160"><input id="tomcpf" type="text" name="tomcpf" size="17"
													maxlength="14" onKeyPress="return soNums(event);"
														onBlur="validar2(this);" disabled></td>
               					<td width="160"><input id="tomrg" type="text" name="tomrg" size="17"
													onkeyup="javascript:this.value=this.value.toUpperCase();" disabled></td>
								<td width="10">&nbsp;</td>
            				</tr>	
													
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="300" colspan="2">Nome Guerra</td>
               					<td width="600" colspan="4">Razao</td>
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="300" colspan="2"><input id="tomnguerra" type="text" name="tomnguerra"
																size="35" onkeyup="javascrip :this.value=this.value.toUpperCase();"
																	maxlength=25 disabled></td>
               					<td width="600" colspan="4"><input id="tomrazao" type="text" name="tomrazao"
																size="87" onkeyup="javascript:this.value=this.value.toUpperCase();" maxlength=40 disabled></td>
								<td width="10">&nbsp;</td>
            				</tr>
							
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="300" colspan="2">CEP</td>
               					<td width="450" colspan="3">Endereço</td>
								<td width="150">Número</td>
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="300" colspan="2"><input id="tomcep" type="text" name="tomcep"
													size="12" onkeyup="javascript:this.value=this.value.toUpperCase();"
														onBlur="pesquisaceptom(this.value);" onkeypress='return SomenteNumero(event)' maxlength=8 disabled></td>
               					<td width="450" colspan="3"><input id="tomendereco" type="text"
													name="tomendereco" size="62"
														onkeyup="javascript:this.value=this.value.toUpperCase();" disabled></td>
								<td width="150"><input id="tomnumero" type="text" name="tomnumero"
													size="17" maxlength=10 disabled></td>						
								<td width="10">&nbsp;</td>
            				</tr>
							
							
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="300" colspan="2">Bairro</td>
               					<td width="450" colspan="3">Complemento</td>
								<td width="150">Telefone</td>
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="300" colspan="2"><input id="tombairro" type="text" name="tombairro"
																size="35" onkeyup="javascript:this.value=this.value.toUpperCase();" maxlength="30" disabled></td>
               					<td width="450" colspan="3"><input id="tomcomplemento" type="text"
																name="tomcomplemento" size="62"
																	onkeyup="javascript:this.value=this.value.toUpperCase();" disabled></td>
								<td width="150"><input id="tomfone" type="text" name="tomfone" size="17"
													onKeyPress="Mascara(this,Telefone);" onBlur="convertField(this);"
														maxlength="13" disabled></td>									
								<td width="10">&nbsp;</td>
            				</tr>	

							
													
							<tr>
								<td width="23">&nbsp;</td>
								<td width="150">Pais</td>
								<td width="150">Estado</td>
               					<td width="300" colspan="2">Cidade</td>
								<td width="300" colspan="2">Cidade IBGE</td>
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="150"><input id="tompais" type="text" name="tompais" size="18" value="BRASIL"
													onBlur="convertField(this);"
														maxlength=50 disabled></td>
								<td width="150"><input id="tomuf" type="text" name="tomuf" size="10"
													disabled onkeyup="javascript:this.value=this.value.toUpperCase();">
														<input id="tomcodcidade" type="hidden" name="tomcodcidade" size="3"
															disabled onkeyup="javascript:this.value=this.value.toUpperCase();"></td>								
               					<td width="300" colspan="2"><input id="tomcidade" type="text" name="tomcidade"
																size="42" disabled
																	onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
								<td width="300" colspan="2"><select name="tomcidadeibge" id="tomcidadeibge" disabled>
										<option id="tomcidcodigoibge" value="0">__________________________________</option>
											</select></td>									
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr bgcolor="#CCCCCC"> 
								<td height="5" colspan="4">&nbsp;</td>
							</tr>	

			            </table>
					</td>
				</tr>
				
				<tr bgcolor="#CCCCCC" id="linharemetente" style="display: none;">
		  			<td valign="top" width="100%">
		  				<table border="0" cellpadding="0" cellspacing="0" width="100%">
							
							<tr bgcolor="#CCCCCC">
			               		<td height="10" colspan="8">&nbsp;</td>
			            	</tr>		
						
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="300" colspan="2">Remetente</td>
			               		<td width="450" colspan="3">Pesquisar</td>
            			   		<td width="150"></td>            			   		
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="300" colspan="2"><select name="remetente" onChange="dadospesquisaverremetente(this.value);">&nbsp;<option id="remetente" value="0">________________________________</option></select></td>
			               		<td width="450" colspan="3"><input id="pesquisaremetente" type="text" name="pesquisaremetente"
																size="62" onkeypress="maiusculo();"
																	onblur="convertField(this);dadospesquisaremetente(this.value);" ></td>
            			   		<td width="150"><input name="buttonremetente" type="button" id="buttonremetente"
													onClick="dadospesquisaremetente(pesquisaremetente.value);" value="Pesquisar" ></td>            			   		
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="300" colspan="2">Empresa</td>
			               		<td width="450" colspan="3">Opções da Pesquisa</td>
            			   		<td width="150"></td>            			   		
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="300" colspan="2"><select name="listDadosRemetente" onChange="dadospesquisaremetente2(this.value);" >&nbsp;<option id="opcaoDadosRemetente" value="0">______________________________</option></select></td>
			               		<td width="600" colspan="4"><input name="radiobuttonrem" id="radiorem1" type="radio"
															value="radiobutton" checked > C&oacute;digo <input type="radio"
															name="radiobuttonrem" id="radiorem2" value="radiobutton" > Nome de Guerra <input
															type="radio" name="radiobuttonrem" id="radiorem3" value="radiobutton" >
															Raz&atilde;o Social<input type="radio" name="radiobuttonrem" id="radiorem4"
															value="radiobutton" > CNPJ <input type="radio" name="radiobuttonrem"
															id="radiorem5" value="radiobutton" > CPF</td>            			   		
								<td width="10">&nbsp;</td>
            				</tr>

							
						
		  					<tr bgcolor="#CCCCCC">
			               		<td height="10" colspan="8">&nbsp;</td>
			            	</tr>																						
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="260" colspan="2">Tipo</td>
			               		<td width="160">C.N.P.J.</td>
            			   		<td width="160">I.E.</td>
            			   		<td width="160">C.P.F.</td>
            			   		<td width="160">R.G.</td>               					
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="260" colspan="2"><input name="radiobuttonrem2" type="radio" id="radiorem11" value="radiobuttonrem" onclick="verificapessoarem(this.value);" checked >
												Pessoa Jur&iacute;dica&nbsp;&nbsp;&nbsp;<input type="radio" name="radiobuttonrem2" id="radiorem12" value="radiobuttonrem" onclick="verificapessoarem(this.value);" >
													Pessoa F&iacute;sica</td>			               							
            			   		<td width="160"><input id="remcnpj" type="text" name="remcnpj" size="17" maxlength="18" onKeyPress="return soNums(event);" onBlur="validar(this);" ></td>
            			   		<td width="160"><input id="remie" type="text" name="remie" size="17"
													onkeyup="javascript:this.value=this.value.toUpperCase();" ></td>
            			   		<td width="160"><input id="remcpf" type="text" name="remcpf" size="17"
													maxlength="14" onKeyPress="return soNums(event);"
														onBlur="validar2(this);" disabled></td>
               					<td width="160"><input id="remrg" type="text" name="remrg" size="17"
													onkeyup="javascript:this.value=this.value.toUpperCase();" disabled></td>
								<td width="10">&nbsp;</td>
            				</tr>	
													
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="300" colspan="2">Nome Guerra</td>
               					<td width="600" colspan="4">Razao</td>
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="300" colspan="2"><input id="remnguerra" type="text" name="remnguerra"
																size="35" onkeyup="javascrip :this.value=this.value.toUpperCase();"
																	maxlength=25 ></td>
               					<td width="600" colspan="4"><input id="remrazao" type="text" name="remrazao"
																size="87" onkeyup="javascript:this.value=this.value.toUpperCase();" maxlength=40 ></td>
								<td width="10">&nbsp;</td>
            				</tr>
							
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="300" colspan="2">CEP</td>
               					<td width="450" colspan="3">Endereço</td>
								<td width="150">Número</td>
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="300" colspan="2"><input id="remcep" type="text" name="remcep"
													size="12" onkeyup="javascript:this.value=this.value.toUpperCase();"
														onBlur="pesquisaceprem(this.value);" onkeypress='return SomenteNumero(event)' maxlength=8 ></td>
               					<td width="450" colspan="3"><input id="remendereco" type="text"
													name="remendereco" size="62"
														onkeyup="javascript:this.value=this.value.toUpperCase();" ></td>
								<td width="150"><input id="remnumero" type="text" name="remnumero"
													size="17" maxlength=10 ></td>						
								<td width="10">&nbsp;</td>
            				</tr>
							
							
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="300" colspan="2">Bairro</td>
               					<td width="450" colspan="3">Complemento</td>
								<td width="150">Telefone</td>
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="300" colspan="2"><input id="rembairro" type="text" name="rembairro"
																size="35" onkeyup="javascript:this.value=this.value.toUpperCase();" maxlength="30" ></td>
               					<td width="450" colspan="3"><input id="remcomplemento" type="text"
																name="remcomplemento" size="62"
																	onkeyup="javascript:this.value=this.value.toUpperCase();" ></td>
								<td width="150"><input id="remfone" type="text" name="remfone" size="17"
													onKeyPress="Mascara(this,Telefone);" onBlur="convertField(this);"
														maxlength="13" ></td>									
								<td width="10">&nbsp;</td>
            				</tr>	

							
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="150">Pais</td>
								<td width="150">Estado</td>
               					<td width="300" colspan="2">Cidade</td>
								<td width="300" colspan="2">Cidade IBGE</td>
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="150"><input id="rempais" type="text" name="rempais" size="18" value="BRASIL"
													onBlur="convertField(this);"
														maxlength=50 disabled></td>
								<td width="150"><input id="remuf" type="text" name="remuf" size="10"
													disabled onkeyup="javascript:this.value=this.value.toUpperCase();">
														<input id="remcodcidade" type="hidden" name="remcodcidade" size="3"
															disabled onkeyup="javascript:this.value=this.value.toUpperCase();"></td>								
               					<td width="300" colspan="2"><input id="remcidade" type="text" name="remcidade"
																size="42" disabled
																	onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
								<td width="300" colspan="2"><select name="remcidadeibge" id="remcidadeibge" disabled>
										<option id="remcidcodigoibge" value="0">__________________________________</option>
											</select></td>									
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr bgcolor="#CCCCCC"> 
								<td height="5" colspan="4">&nbsp;</td>
							</tr>	
																					
			            </table>
					</td>
				</tr>
				
				<tr bgcolor="#CCCCCC" id="linhaexpedidor" style="display: none;">
		  			<td valign="top" width="100%">
		  				<table border="0" cellpadding="0" cellspacing="0" width="100%">
							
							<tr bgcolor="#CCCCCC">
			               		<td height="10" colspan="8">&nbsp;</td>
			            	</tr>		
						
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="300" colspan="2">Expedidor</td>
			               		<td width="450" colspan="3">Pesquisar</td>
            			   		<td width="150"></td>            			   		
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="300" colspan="2"><select name="expedidor" onChange="dadospesquisaverexpedidor(this.value);">&nbsp;<option id="expedidor" value="0">________________________________</option></select></td>
			               		<td width="450" colspan="3"><input id="pesquisaexpedidor" type="text" name="pesquisaexpedidor"
																size="62" onkeypress="maiusculo();"
																	onblur="convertField(this);dadospesquisaexpedidor(this.value);" ></td>
            			   		<td width="150"><input name="buttonexpedidor" type="button" id="buttonexpedidor"
													onClick="dadospesquisaexpedidor(pesquisaexpedidor.value);" value="Pesquisar" ></td>            			   		
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="300" colspan="2">Empresa</td>
			               		<td width="450" colspan="3">Opções da Pesquisa</td>
            			   		<td width="150"></td>            			   		
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="300" colspan="2"><select name="listDadosExpedidor" onChange="dadospesquisaexpedidor2(this.value);" >&nbsp;<option id="opcaoDadosExpedidor" value="0">______________________________</option></select></td>
			               		<td width="600" colspan="4"><input name="radiobuttonexp" id="radioexp1" type="radio"
															value="radiobutton" checked > C&oacute;digo <input type="radio"
															name="radiobuttonexp" id="radioexp2" value="radiobutton" > Nome de Guerra <input
															type="radio" name="radiobuttonexp" id="radioexp3" value="radiobutton" >
															Raz&atilde;o Social<input type="radio" name="radiobuttonexp" id="radioexp4"
															value="radiobutton" > CNPJ <input type="radio" name="radiobuttonexp"
															id="radioexp5" value="radiobutton" > CPF</td>            			   		
								<td width="10">&nbsp;</td>
            				</tr>

							
						
		  					<tr bgcolor="#CCCCCC">
			               		<td height="10" colspan="8">&nbsp;</td>
			            	</tr>																						
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="260" colspan="2">Tipo</td>
			               		<td width="160">C.N.P.J.</td>
            			   		<td width="160">I.E.</td>
            			   		<td width="160">C.P.F.</td>
            			   		<td width="160">R.G.</td>               					
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="260" colspan="2"><input name="radiobuttonexp2" type="radio" id="radioexp11" value="radiobuttonexp" onclick="verificapessoaexp(this.value);" checked >
												Pessoa Jur&iacute;dica&nbsp;&nbsp;&nbsp;<input type="radio" name="radiobuttonexp2" id="radioexp12" value="radiobuttonexp" onclick="verificapessoaexp(this.value);" >
													Pessoa F&iacute;sica</td>			               							
            			   		<td width="160"><input id="expcnpj" type="text" name="expcnpj" size="17" maxlength="18" onKeyPress="return soNums(event);" onBlur="validar(this);" ></td>
            			   		<td width="160"><input id="expie" type="text" name="expie" size="17"
													onkeyup="javascript:this.value=this.value.toUpperCase();" ></td>
            			   		<td width="160"><input id="expcpf" type="text" name="expcpf" size="17"
													maxlength="14" onKeyPress="return soNums(event);"
														onBlur="validar2(this);" disabled></td>
               					<td width="160"><input id="exprg" type="text" name="exprg" size="17"
													onkeyup="javascript:this.value=this.value.toUpperCase();" disabled></td>
								<td width="10">&nbsp;</td>
            				</tr>	
													
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="300" colspan="2">Nome Guerra</td>
               					<td width="600" colspan="4">Razao</td>
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="300" colspan="2"><input id="expnguerra" type="text" name="expnguerra"
																size="35" onkeyup="javascrip :this.value=this.value.toUpperCase();"
																	maxlength=25 ></td>
               					<td width="600" colspan="4"><input id="exprazao" type="text" name="exprazao"
																size="87" onkeyup="javascript:this.value=this.value.toUpperCase();" maxlength=40 ></td>
								<td width="10">&nbsp;</td>
            				</tr>
							
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="300" colspan="2">CEP</td>
               					<td width="450" colspan="3">Endereço</td>
								<td width="150">Número</td>
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="300" colspan="2"><input id="expcep" type="text" name="expcep"
													size="12" onkeyup="javascript:this.value=this.value.toUpperCase();"
														onBlur="pesquisacepexp(this.value);" onkeypress='return SomenteNumero(event)' maxlength=8 ></td>
               					<td width="450" colspan="3"><input id="expendereco" type="text"
													name="expendereco" size="62"
														onkeyup="javascript:this.value=this.value.toUpperCase();" ></td>
								<td width="150"><input id="expnumero" type="text" name="expnumero"
													size="17" maxlength=10 ></td>						
								<td width="10">&nbsp;</td>
            				</tr>
							
							
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="300" colspan="2">Bairro</td>
               					<td width="450" colspan="3">Complemento</td>
								<td width="150">Telefone</td>
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="300" colspan="2"><input id="expbairro" type="text" name="expbairro"
																size="35" onkeyup="javascript:this.value=this.value.toUpperCase();" maxlength="30" ></td>
               					<td width="450" colspan="3"><input id="expcomplemento" type="text"
																name="expcomplemento" size="62"
																	onkeyup="javascript:this.value=this.value.toUpperCase();" ></td>
								<td width="150"><input id="expfone" type="text" name="expfone" size="17"
													onKeyPress="Mascara(this,Telefone);" onBlur="convertField(this);"
														maxlength="13" ></td>									
								<td width="10">&nbsp;</td>
            				</tr>	

							
													
							<tr>
								<td width="23">&nbsp;</td>
								<td width="150">Pais</td>
								<td width="150">Estado</td>
               					<td width="300" colspan="2">Cidade</td>
								<td width="300" colspan="2">Cidade IBGE</td>
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="150"><input id="exppais" type="text" name="exppais" size="18" value="BRASIL"
													onBlur="convertField(this);"
														maxlength=50 disabled></td>
								<td width="150"><input id="expuf" type="text" name="expuf" size="10"
													disabled onkeyup="javascript:this.value=this.value.toUpperCase();">
														<input id="expcodcidade" type="hidden" name="expcodcidade" size="3"
															disabled onkeyup="javascript:this.value=this.value.toUpperCase();"></td>								
               					<td width="300" colspan="2"><input id="expcidade" type="text" name="expcidade"
																size="42" disabled
																	onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
								<td width="300" colspan="2"><select name="expcidadeibge" id="expcidadeibge" disabled>
										<option id="expcidcodigoibge" value="0">__________________________________</option>
											</select></td>									
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr bgcolor="#CCCCCC"> 
								<td height="5" colspan="4">&nbsp;</td>
							</tr>	
																					
			            </table>
					</td>
				</tr>
				
				<tr bgcolor="#CCCCCC" id="linharecebedor" style="display: none;">
		  			<td valign="top" width="100%">
		  				<table border="0" cellpadding="0" cellspacing="0" width="100%">
							
							<tr bgcolor="#CCCCCC">
			               		<td height="10" colspan="8">&nbsp;</td>
			            	</tr>		
						
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="300" colspan="2">Recebedor</td>
			               		<td width="450" colspan="3">Pesquisar</td>
            			   		<td width="150"></td>            			   		
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="300" colspan="2"><select name="recebedor" onChange="dadospesquisaverrecebedor(this.value);">&nbsp;<option id="recebedor" value="0">________________________________</option></select></td>
			               		<td width="450" colspan="3"><input id="pesquisarecebedor" type="text" name="pesquisarecebedor"
																size="62" onkeypress="maiusculo();"
																	onblur="convertField(this);dadospesquisarecebedor(this.value);" ></td>
            			   		<td width="150"><input name="buttonrecebedor" type="button" id="buttonrecebedor"
													onClick="dadospesquisarecebedor(pesquisarecebedor.value);" value="Pesquisar" ></td>            			   		
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="300" colspan="2">Empresa</td>
			               		<td width="450" colspan="3">Opções da Pesquisa</td>
            			   		<td width="150"></td>            			   		
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="300" colspan="2"><select name="listDadosRecebedor" onChange="dadospesquisarecebedor2(this.value);" >&nbsp;<option id="opcaoDadosRecebedor" value="0">______________________________</option></select></td>
			               		<td width="600" colspan="4"><input name="radiobuttonrec" id="radiorec1" type="radio"
															value="radiobutton" checked > C&oacute;digo <input type="radio"
															name="radiobuttonrec" id="radiorec2" value="radiobutton" > Nome de Guerra <input
															type="radio" name="radiobuttonrec" id="radiorec3" value="radiobutton" >
															Raz&atilde;o Social<input type="radio" name="radiobuttonrec" id="radiorec4"
															value="radiobutton" > CNPJ <input type="radio" name="radiobuttonrec"
															id="radiorec5" value="radiobutton" > CPF</td>            			   		
								<td width="10">&nbsp;</td>
            				</tr>

							
						
		  					<tr bgcolor="#CCCCCC">
			               		<td height="10" colspan="8">&nbsp;</td>
			            	</tr>																						
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="260" colspan="2">Tipo</td>
			               		<td width="160">C.N.P.J.</td>
            			   		<td width="160">I.E.</td>
            			   		<td width="160">C.P.F.</td>
            			   		<td width="160">R.G.</td>               					
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="260" colspan="2"><input name="radiobuttonrec2" type="radio" id="radiorec11" value="radiobuttonrec" onclick="verificapessoarec(this.value);" checked >
												Pessoa Jur&iacute;dica&nbsp;&nbsp;&nbsp;<input type="radio" name="radiobuttonrec2" id="radiorec12" value="radiobuttonrec" onclick="verificapessoarec(this.value);" >
													Pessoa F&iacute;sica</td>			               							
            			   		<td width="160"><input id="reccnpj" type="text" name="reccnpj" size="17" maxlength="18" onKeyPress="return soNums(event);" onBlur="validar(this);" ></td>
            			   		<td width="160"><input id="recie" type="text" name="recie" size="17"
													onkeyup="javascript:this.value=this.value.toUpperCase();" ></td>
            			   		<td width="160"><input id="reccpf" type="text" name="reccpf" size="17"
													maxlength="14" onKeyPress="return soNums(event);"
														onBlur="validar2(this);" disabled></td>
               					<td width="160"><input id="recrg" type="text" name="recrg" size="17"
													onkeyup="javascript:this.value=this.value.toUpperCase();" disabled></td>
								<td width="10">&nbsp;</td>
            				</tr>	
													
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="300" colspan="2">Nome Guerra</td>
               					<td width="600" colspan="4">Razao</td>
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="300" colspan="2"><input id="recnguerra" type="text" name="recnguerra"
																size="35" onkeyup="javascrip :this.value=this.value.toUpperCase();"
																	maxlength=25 ></td>
               					<td width="600" colspan="4"><input id="recrazao" type="text" name="recrazao"
																size="87" onkeyup="javascript:this.value=this.value.toUpperCase();" maxlength=40 ></td>
								<td width="10">&nbsp;</td>
            				</tr>
							
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="300" colspan="2">CEP</td>
               					<td width="450" colspan="3">Endereço</td>
								<td width="150">Número</td>
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="300" colspan="2"><input id="reccep" type="text" name="reccep"
													size="12" onkeyup="javascript:this.value=this.value.toUpperCase();"
														onBlur="pesquisaceprec(this.value);" onkeypress='return SomenteNumero(event)' maxlength=8 ></td>
               					<td width="450" colspan="3"><input id="recendereco" type="text"
													name="recendereco" size="62"
														onkeyup="javascript:this.value=this.value.toUpperCase();" ></td>
								<td width="150"><input id="recnumero" type="text" name="recnumero"
													size="17" maxlength=10 ></td>						
								<td width="10">&nbsp;</td>
            				</tr>
							
							
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="300" colspan="2">Bairro</td>
               					<td width="450" colspan="3">Complemento</td>
								<td width="150">Telefone</td>
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="300" colspan="2"><input id="recbairro" type="text" name="recbairro"
																size="35" onkeyup="javascript:this.value=this.value.toUpperCase();" maxlength="30" ></td>
               					<td width="450" colspan="3"><input id="reccomplemento" type="text"
																name="reccomplemento" size="62"
																	onkeyup="javascript:this.value=this.value.toUpperCase();" ></td>
								<td width="150"><input id="recfone" type="text" name="recfone" size="17"
													onKeyPress="Mascara(this,Telefone);" onBlur="convertField(this);"
														maxlength="13" ></td>									
								<td width="10">&nbsp;</td>
            				</tr>	

							
													
							<tr>
								<td width="23">&nbsp;</td>
								<td width="150">Pais</td>
								<td width="150">Estado</td>
               					<td width="300" colspan="2">Cidade</td>
								<td width="300" colspan="2">Cidade IBGE</td>
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="150"><input id="recpais" type="text" name="recpais" size="18" value="BRASIL"
													onBlur="convertField(this);"
														maxlength=50 disabled></td>
								<td width="150"><input id="recuf" type="text" name="recuf" size="10"
													disabled onkeyup="javascript:this.value=this.value.toUpperCase();">
														<input id="reccodcidade" type="hidden" name="reccodcidade" size="3"
															disabled onkeyup="javascript:this.value=this.value.toUpperCase();"></td>								
               					<td width="300" colspan="2"><input id="reccidade" type="text" name="reccidade"
																size="42" disabled
																	onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
								<td width="300" colspan="2"><select name="reccidadeibge" id="reccidadeibge" disabled>
										<option id="reccidcodigoibge" value="0">__________________________________</option>
											</select></td>									
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr bgcolor="#CCCCCC"> 
								<td height="5" colspan="4">&nbsp;</td>
							</tr>	
																					
			            </table>
					</td>
				</tr>
				
				<tr bgcolor="#CCCCCC" id="linhadestinatario" style="display: none;">
		  			<td valign="top" width="100%">
		  				<table border="0" cellpadding="0" cellspacing="0" width="100%">
							
							<tr bgcolor="#CCCCCC">
			               		<td height="10" colspan="8">&nbsp;</td>
			            	</tr>		
						
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="300" colspan="2">Destinatario</td>
			               		<td width="450" colspan="3">Pesquisar</td>
            			   		<td width="150"></td>            			   		
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="300" colspan="2"><select name="destinatario" onChange="dadospesquisaverdestinatario(this.value);">&nbsp;<option id="destinatario" value="0">________________________________</option></select></td>
			               		<td width="450" colspan="3"><input id="pesquisadestinatario" type="text" name="pesquisadestinatario"
																size="62" onkeypress="maiusculo();"
																	onblur="convertField(this);dadospesquisadestinatario(this.value);" ></td>
            			   		<td width="150"><input name="buttondestinatario" type="button" id="buttondestinatario"
													onClick="dadospesquisadestinatario(pesquisadestinatario.value);" value="Pesquisar" ></td>            			   		
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="300" colspan="2">Empresa</td>
			               		<td width="450" colspan="3">Opções da Pesquisa</td>
            			   		<td width="150"></td>            			   		
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="300" colspan="2"><select name="listDadosDestinatario" onChange="dadospesquisadestinatario2(this.value);" >&nbsp;<option id="opcaoDadosDestinatario" value="0">______________________________</option></select></td>
			               		<td width="600" colspan="4"><input name="radiobuttondes" id="radiodes1" type="radio"
															value="radiobutton" checked > C&oacute;digo <input type="radio"
															name="radiobuttondes" id="radiodes2" value="radiobutton" > Nome de Guerra <input
															type="radio" name="radiobuttondes" id="radiodes3" value="radiobutton" >
															Raz&atilde;o Social<input type="radio" name="radiobuttondes" id="radiodes4"
															value="radiobutton" > CNPJ <input type="radio" name="radiobuttondes"
															id="radiodes5" value="radiobutton" > CPF</td>            			   		
								<td width="10">&nbsp;</td>
            				</tr>

							
						
		  					<tr bgcolor="#CCCCCC">
			               		<td height="10" colspan="8">&nbsp;</td>
			            	</tr>																						
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="260" colspan="2">Tipo</td>
			               		<td width="160">C.N.P.J.</td>
            			   		<td width="160">I.E.</td>
            			   		<td width="160">C.P.F.</td>
            			   		<td width="160">R.G.</td>               					
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="260" colspan="2"><input name="radiobuttondes2" type="radio" id="radiodes11" value="radiobuttondes" onclick="verificapessoades(this.value);" checked >
												Pessoa Jur&iacute;dica&nbsp;&nbsp;&nbsp;<input type="radio" name="radiobuttondes2" id="radiodes12" value="radiobuttondes" onclick="verificapessoades(this.value);" >
													Pessoa F&iacute;sica</td>			               							
            			   		<td width="160"><input id="descnpj" type="text" name="descnpj" size="17" maxlength="18" onKeyPress="return soNums(event);" onBlur="validar(this);" ></td>
            			   		<td width="160"><input id="desie" type="text" name="desie" size="17"
													onkeyup="javascript:this.value=this.value.toUpperCase();" ></td>
            			   		<td width="160"><input id="descpf" type="text" name="descpf" size="17"
													maxlength="14" onKeyPress="return soNums(event);"
														onBlur="validar2(this);" disabled></td>
               					<td width="160"><input id="desrg" type="text" name="desrg" size="17"
													onkeyup="javascript:this.value=this.value.toUpperCase();" disabled></td>
								<td width="10">&nbsp;</td>
            				</tr>	
													
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="300" colspan="2">Nome Guerra</td>
               					<td width="600" colspan="4">Razao</td>
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="300" colspan="2"><input id="desnguerra" type="text" name="desnguerra"
																size="35" onkeyup="javascrip :this.value=this.value.toUpperCase();"
																	maxlength=25 ></td>
               					<td width="600" colspan="4"><input id="desrazao" type="text" name="desrazao"
																size="87" onkeyup="javascript:this.value=this.value.toUpperCase();" maxlength=40 ></td>
								<td width="10">&nbsp;</td>
            				</tr>
							
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="150">CEP</td>
								<td width="150">SUFRAMA</td>
               					<td width="450" colspan="3">Endereço</td>
								<td width="150">Número</td>
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="150"><input id="descep" type="text" name="descep"
													size="12" onkeyup="javascript:this.value=this.value.toUpperCase();"
														onBlur="pesquisacepdes(this.value);" onkeypress='return SomenteNumero(event)' maxlength=8 ></td>
								<td width="150"><input id="dessuframa" type="text" name="dessuframa"
													size="10" onkeyup="javascript:this.value=this.value.toUpperCase();"
														onkeypress='return SomenteNumero(event)' maxlength="9" ></td>									
               					<td width="450" colspan="3"><input id="desendereco" type="text"
													name="desendereco" size="62"
														onkeyup="javascript:this.value=this.value.toUpperCase();" ></td>
								<td width="150"><input id="desnumero" type="text" name="desnumero"
													size="17" maxlength=10 ></td>						
								<td width="10">&nbsp;</td>
            				</tr>
							
							
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="300" colspan="2">Bairro</td>
               					<td width="450" colspan="3">Complemento</td>
								<td width="150">Telefone</td>
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="300" colspan="2"><input id="desbairro" type="text" name="desbairro"
																size="35" onkeyup="javascript:this.value=this.value.toUpperCase();" maxlength="30" ></td>
               					<td width="450" colspan="3"><input id="descomplemento" type="text"
																name="descomplemento" size="62"
																	onkeyup="javascript:this.value=this.value.toUpperCase();" ></td>
								<td width="150"><input id="desfone" type="text" name="desfone" size="17"
													onKeyPress="Mascara(this,Telefone);" onBlur="convertField(this);"
														maxlength="13" ></td>									
								<td width="10">&nbsp;</td>
            				</tr>	

							
													
							<tr>
								<td width="23">&nbsp;</td>
								<td width="150">Pais</td>
								<td width="150">Estado</td>
               					<td width="300" colspan="2">Cidade</td>
								<td width="300" colspan="2">Cidade IBGE</td>
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="150"><input id="despais" type="text" name="despais" size="18" value="BRASIL"
													onBlur="convertField(this);"
														maxlength=50 disabled></td>
								<td width="150"><input id="desuf" type="text" name="desuf" size="10"
													disabled onkeyup="javascript:this.value=this.value.toUpperCase();">
														<input id="descodcidade" type="hidden" name="descodcidade" size="3"
															disabled onkeyup="javascript:this.value=this.value.toUpperCase();"></td>								
               					<td width="300" colspan="2"><input id="descidade" type="text" name="descidade"
																size="42" disabled
																	onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
								<td width="300" colspan="2"><select name="descidadeibge" id="descidadeibge" disabled>
										<option id="descidcodigoibge" value="0">__________________________________</option>
											</select></td>									
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr bgcolor="#CCCCCC"> 
								<td height="5" colspan="4">&nbsp;</td>
							</tr>	
								
			            </table>
					</td>
				</tr>
            	
			  <tr bgcolor="#CCCCCC">
                <td colspan="6"> <Center>
                	<input type="button" id="botaoinc" value="Alterar" onclick="incluirorcamento(2);"> 
					&nbsp;&nbsp;&nbsp;			

					<input type="hidden" id="botaoimp" value="Imprimir" onclick="Imprimir(orcnumero.value,<?php echo $usuario ?>);"> 
										
					<input type="button" id="botaoxml" value="XML" onclick="Imprimirxml(orcnumero.value,<?php echo $usuario ?>);"> 
					&nbsp;&nbsp;&nbsp;	

					<input type="button" id="botaoproceda" value="Proceda" onclick="Imprimirproceda(orcnumero.value,<?php echo $usuario ?>);"> 
					&nbsp;&nbsp;&nbsp;	

					<input type="button" id="botaodatasul" value="Datasul" onclick="Imprimirdatasul(orcnumero.value,<?php echo $usuario ?>);"> 
					&nbsp;&nbsp;&nbsp;	
					
					<input type="button" id="botaoexc" value="Excluir" onclick="excluirorcamento(orcnumero.value,<?php echo $usuario ?>);"> 
					&nbsp;&nbsp;&nbsp;	
					<input type="button" id="cancelaPedido" onclick="cancelarPedido()" value="Cancelar">		

					&nbsp;&nbsp;&nbsp;	
					<input type="button" id="fechar" onclick="fechar1()" value="Fechar">	
					
                  </Center></td>                
              </tr>
			  
			  <tr bgcolor="#CCCCCC">
			  <td height="20" colspan="6">&nbsp;</td>
			  </tr>
				
            </table>
			
	</div>
	
	<input type="radio" name="tabs" class="tabs" id="tab3">
    <label for="tab3">Impostos</label>
    <div>
			<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#3366CC">
		  		<tr>
					<td valign="middle" height="25"><div align="center"><font color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif"><strong>Conhecimento de Transporte Eletrônico - Serviços e Impostos</strong></font></div></td>
		  		</tr>
		  		<tr bgcolor="#CCCCCC">
		  			<td valign="top" width="100%">
		  				<table border="0" cellpadding="0" cellspacing="0" width="100%">
							
							<tr bgcolor="#CCCCCC">
			               		<td height="10" colspan="8">&nbsp;</td>
			            	</tr>

							<tr>
								<td width="23">&nbsp;</td>
               					<td width="450" colspan="3"><b>Valores da Prestação de Serviços / ICMS</b></td>
            			   		<td width="450" colspan="3"><b>Cobrança do ICMS na Operação Interestadual</b></td>
								<td width="10">&nbsp;</td>
            				</tr>	
						
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="300" colspan="2">Valor Prestação de Serviços&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="buttonservicos" type="button" id="buttonservicos"
													onClick="digitaservicos();" value="Detalhar" tabIndex='0'></td>
			               		<td width="150"><input type="text" name="valorservico" id="valorservico" maxlength="10" size="18" style="text-align:right;" value="" onblur="format_val(this.value,this.id);" disabled></td>
            			   		<td width="450" colspan="3"><input type="checkbox" name="opcao_icms1" id="opcao_icms1" value="1" align="absmiddle" tabIndex='10' onclick="verificatipoicms(this.value);">Preencher o ICMS devido para UF de término do serviço de Transporte</td>
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="300" colspan="2">Valor a Receber</td>
			               		<td width="150"><input type="text" name="valorreceber" id="valorreceber" maxlength="10" size="18" style="text-align:right;" value="" onblur="format_val(this.value,this.id);" tabIndex='1'></td>
            			   		<td width="300" colspan="2">Valor da Base de Cálculo do ICMS</td>            			   		
								<td width="150"><input type="text" name="interbase" id="interbase" maxlength="10" size="18" style="text-align:right;" value="" onblur="format_val(this.value,this.id);" tabIndex='11' disabled></td>
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="300" colspan="2">Valor Total dos Tributos</td>
			               		<td width="150"><input type="text" name="valortributos" id="valortributos" maxlength="10" size="18" style="text-align:right;" value="" onblur="format_val(this.value,this.id);" tabIndex='2'></td>
            			   		<td width="300" colspan="2">Aliquota Interna da UF de Termino</td>            			   		
								<td width="150"><input type="text" name="interpercterm" id="interpercterm" maxlength="10" size="18" style="text-align:right;" value="" onblur="format_val(this.value,this.id);" tabIndex='12' disabled></td>
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="150">Situação Tributária</td>
               					<td width="300" colspan="2"><select name="situacao" onChange="dadospesquisaversituacao(this.value);" tabIndex='3'>&nbsp;<option id="situacao" value="0">________________________________</option></select></td>
            			   		<td width="300" colspan="2">Aliquota Interestadual</td>            			   		
								<td width="150"><input type="text" name="interpercinter" id="interpercinter" maxlength="10" size="18" style="text-align:right;" value="" onblur="format_val(this.value,this.id);" tabIndex='13' disabled></td>
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="300" colspan="2">Percentual de Redução da BC</td>
			               		<td width="150"><input type="text" name="reducao" id="reducao" maxlength="10" size="18" style="text-align:right;" value="" onblur="format_val(this.value,this.id);" disabled tabIndex='4'></td>
			               		<td width="300" colspan="2">% Partilha para UF de Término</td>            			   		
								<td width="150"><select name="partilha" tabindex='14' disabled>&nbsp;<option id="partilha" value="0">_____________</option></select></td>
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="300" colspan="2">Valor da Base de Calculo ICMS</td>
			               		<td width="150"><input type="text" name="baseicms" id="baseicms" maxlength="10" size="18" style="text-align:right;" value="" onblur="format_val(this.value,this.id);" tabIndex='5'></td>
            			   		<td width="300" colspan="2">Valor do ICMS de Partilha para a UF de Início</td>            			   		
								<td width="150"><input type="text" name="intervalini" id="intervalini" maxlength="10" size="18" style="text-align:right;" value="" onblur="format_val(this.value,this.id);" tabIndex='15' disabled></td>
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="300" colspan="2">Alíquota ICMS</td>
			               		<td width="150"><input type="text" name="percicms" id="percicms" maxlength="10" size="18" style="text-align:right;" value="" onblur="format_val(this.value,this.id);" tabIndex='6'></td>
            			   		<td width="300" colspan="2">Valor do ICMS de Partilha para a UF de Término</td>            			   		
								<td width="150"><input type="text" name="intervalfim" id="intervalfim" maxlength="10" size="18" style="text-align:right;" value="" onblur="format_val(this.value,this.id);" tabIndex='16' disabled></td>
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="300" colspan="2">Valor ICMS</td>
			               		<td width="150"><input type="text" name="valoricms" id="valoricms" maxlength="10" size="18" style="text-align:right;" value="" onblur="format_val(this.value,this.id);" tabIndex='7'></td>
            			   		<td width="300" colspan="2">% ICMS ao Fundo de Combate a Pobreza</td>            			   		
								<td width="150"><input type="text" name="interpercpobr" id="interpercpobr" maxlength="10" size="18" style="text-align:right;" value="" onblur="format_val(this.value,this.id);" tabIndex='17' disabled></td>
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="300" colspan="2">Valor do Crédito Outorgado/Presumido</td>
			               		<td width="150"><input type="text" name="valorcredito" id="valorcredito" maxlength="10" size="18" style="text-align:right;" value="" onblur="format_val(this.value,this.id);" disabled tabIndex='8'></td>
            			   		<td width="300" colspan="2">Valor ICMS ao Fundo de Combate a Pobreza</td>            			   		
								<td width="150"><input type="text" name="intervalpobr" id="intervalpobr" maxlength="10" size="18" style="text-align:right;" value="" onblur="format_val(this.value,this.id);" tabIndex='18' disabled></td>
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="300" colspan="2"><b>Informações Adicionais de Interesse do Fisco</b></td>
			               		<td width="600" colspan="4"><textarea name="adcfisco" id="adcfisco" cols="89" rows="3" onkeyup="this.value=this.value.toUpperCase()" onBlur="convertField(this);" tabIndex='9'></textarea></td>            			   		
								<td width="10">&nbsp;</td>
            				</tr>
																					
			            </table>
					</td>
				</tr>
            	
				
				<tr bgcolor="#CCCCCC"> 
					<td height="5" colspan="4">&nbsp;</td>
				</tr>	
				
			  <tr bgcolor="#CCCCCC">
                <td colspan="6"> <Center>
                	<input type="button" id="botaoinc" value="Alterar" onclick="incluirorcamento(3);"> 
					&nbsp;&nbsp;&nbsp;		

					<input type="hidden" id="botaoimp" value="Imprimir" onclick="Imprimir(orcnumero.value,<?php echo $usuario ?>);"> 
										
					<input type="button" id="botaoxml" value="XML" onclick="Imprimirxml(orcnumero.value,<?php echo $usuario ?>);"> 
					&nbsp;&nbsp;&nbsp;	

					<input type="button" id="botaoproceda" value="Proceda" onclick="Imprimirproceda(orcnumero.value,<?php echo $usuario ?>);"> 
					&nbsp;&nbsp;&nbsp;	

					<input type="button" id="botaodatasul" value="Datasul" onclick="Imprimirdatasul(orcnumero.value,<?php echo $usuario ?>);"> 
					&nbsp;&nbsp;&nbsp;	
					
					<input type="button" id="botaoexc" value="Excluir" onclick="excluirorcamento(orcnumero.value,<?php echo $usuario ?>);"> 
					&nbsp;&nbsp;&nbsp;						
					<input type="button" id="cancelaPedido" onclick="cancelarPedido()" value="Cancelar">	

					&nbsp;&nbsp;&nbsp;	
					<input type="button" id="fechar" onclick="fechar1()" value="Fechar">						
					
                  </Center></td>                
              </tr>
			  
			  <tr bgcolor="#CCCCCC">
			  <td height="20" colspan="6">&nbsp;</td>
			  </tr>
				
            </table>	
	
	</div>
	
	
	<!-- ABA 4 -->
    <input type="radio" name="tabs" class="tabs" id="tab4">
    <label for="tab4">Cte Normal</label>
    <div>		
		
			<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#3366CC">
		  		<tr>
					<td valign="middle" height="25"><div align="center"><font color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif"><strong>Conhecimento de Transporte Eletrônico - CTe Normal</strong></font></div></td>
		  		</tr>
		  		<tr bgcolor="#CCCCCC">
		  			<td valign="top" width="100%">
		  				<table border="0" cellpadding="0" cellspacing="0" width="100%">
		  					<tr bgcolor="#CCCCCC">
			               		<td height="10" colspan="8">&nbsp;</td>
			            	</tr>																						
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="150">Informações Carga</td>
			               		<td width="150">Valor</td>
            			   		<td width="300" colspan="2">Produto Predominate</td>
            			   		<td width="300" colspan="2">Outras Características</td>            			   		
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="150"><input type="button" id="botaocarga" value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Carga&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" onclick="carregacarga();"></td>
			               		<td width="150"><input type="text" name="valorcarga" id="valorcarga" maxlength="10" size="18" style="text-align:right;" value="" onblur="format_val(this.value,this.id);" ></td>								
            			   		<td width="300" colspan="2"><input type="text" name="produtopre" id="produtopre" maxlength="50" size="41" onkeyup="javascript:this.value=this.value.toUpperCase();" onblur="convertField(this);"></td>								
            			   		<td width="300" colspan="2"><input type="text" name="produtoout" id="produtoout" maxlength="50" size="41" onkeyup="javascript:this.value=this.value.toUpperCase();" onblur="convertField(this);"></td>            			   		
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr bgcolor="#CCCCCC">
			               		<td height="10" colspan="8">&nbsp;</td>
			            	</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="150">Seguros</td>
			               		<td width="150">Responsável</td>
            			   		<td width="150">Seguradora</td>
            			   		<td width="150">Apólice</td>
            			   		<td width="150">Averbação</td>
               					<td width="150">Valor</td>
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="150"><input type="button" id="botaoseguro" value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Seguro&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" onclick="carregaseguro();"></td>
			               		<td width="150"><input type="text" name="segresp" id="segresp" maxlength="10" size="18" disabled></td>
            			   		<td width="150"><input type="text" name="segnome" id="segnome" maxlength="10" size="18" disabled></td>
            			   		<td width="150"><input type="text" name="segapolice" id="segapolice" maxlength="10" size="18" disabled></td>
            			   		<td width="150"><input type="text" name="segaverba" id="segaverba" maxlength="10" size="18" disabled></td>
               					<td width="150"><input type="text" name="segvalor" id="segvalor" maxlength="10" size="18" style="text-align:right;" disabled></td>
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr bgcolor="#CCCCCC">
			               		<td height="10" colspan="8">&nbsp;</td>
			            	</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="150">Documentos</td>			               		
								<td width="150">NFe</td>			               		
            			   		<td width="450" colspan="3">Chave NFe</td>
            			   		<td width="150">PIN NFe</td>            			   		
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="150"><input type="button" id="botaonfe" value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NFe&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" onclick="carreganota();"></td>			               		
								<td width="150"><input type="button" id="botaonfeup" value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Upload&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" onclick="uploadnfe();"></td>
            			   		<td width="450" colspan="3"><input type="text" name="nfechave" id="nfechave" maxlength="10" size="68" disabled></td>
            			   		<td width="150"><input type="text" name="nfepin" id="nfepin" maxlength="10" size="18" disabled></td>            			   		
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr bgcolor="#CCCCCC">
			               		<td height="10" colspan="8">&nbsp;</td>
			            	</tr>
							
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="150">Cobrança</td>
			               		<td width="300" colspan="2">Numero</td>            			   		            			   		
            			   		<td width="150">Valor</td>
            			   		<td width="150">Desconto</td>
               					<td width="150">Valor Liquido</td>
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="150"><input type="button" id="botaocobranca" value="&nbsp;&nbsp;&nbsp;&nbsp;Duplicatas&nbsp;&nbsp;&nbsp;&nbsp;" onclick="carregaduplicata();"></td>
			               		<td width="300" colspan="2"><input type="text" name="cobnumero" id="cobnumero" maxlength="30" size="41" onkeyup="javascript:this.value=this.value.toUpperCase();" onblur="convertField(this);"></td>
            			   		<td width="150"><input type="text" name="cobvalor" id="cobvalor" maxlength="10" size="18" style="text-align:right;" value="" onblur="format_val(this.value,this.id);"></td>
            			   		<td width="150"><input type="text" name="cobdesconto" id="cobdesconto" maxlength="10" size="18" style="text-align:right;" value="" onblur="format_val(this.value,this.id);"></td>
               					<td width="150"><input type="text" name="cobliquido" id="cobliquido" maxlength="10" size="18" style="text-align:right;" value="" onblur="format_val(this.value,this.id);"></td>
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr bgcolor="#CCCCCC">
			               		<td height="10" colspan="8">&nbsp;</td>
			            	</tr>							
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="150"  colspan="3" >Cte Substituição</td>
			               		<td width="300" colspan="3">Chave de Acesso</td>            			   		            			   		
            			   		<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="150"  colspan="3">
								
								<input name="radiobutton11" type="radio" id="radio111" value="radiobutton" checked disabled>
								Contribuinte (CTE)
								<input type="radio" name="radiobutton11" id="radio112" value="radiobutton" disabled>
								Contribuinte (NFE)
								<input type="radio" name="radiobutton11" id="radio113" value="radiobutton" disabled>
								Não Contribuinte
								
								</td>

			               		<td width="300" colspan="3">
								
								<input name="chaveacesso" type="text" id="chaveacesso" maxlength="50" size="66" disabled>
								
								
								</td>
            			   		
               					
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr bgcolor="#CCCCCC">
			               		<td height="10" colspan="8">&nbsp;</td>
			            	</tr>
							
							
							
							
			            </table>
					</td>
				</tr>
            	
				
				<tr bgcolor="#CCCCCC"> 
					<td height="17" colspan="4">&nbsp;</td>
				</tr>	
				
			  <tr bgcolor="#CCCCCC">
                <td colspan="6"> <Center>
                	<input type="button" id="botaoinc" value="Alterar" onclick="incluirorcamento(4);"> 
					&nbsp;&nbsp;&nbsp;		
					
					<input type="hidden" id="botaoimp" value="Imprimir" onclick="Imprimir(orcnumero.value,<?php echo $usuario ?>);"> 
					
					<input type="button" id="botaoxml" value="XML" onclick="Imprimirxml(orcnumero.value,<?php echo $usuario ?>);"> 
					&nbsp;&nbsp;&nbsp;	

					<input type="button" id="botaoproceda" value="Proceda" onclick="Imprimirproceda(orcnumero.value,<?php echo $usuario ?>);"> 
					&nbsp;&nbsp;&nbsp;	

					<input type="button" id="botaodatasul" value="Datasul" onclick="Imprimirdatasul(orcnumero.value,<?php echo $usuario ?>);"> 
					&nbsp;&nbsp;&nbsp;	
					
					<input type="button" id="botaoexc" value="Excluir" onclick="excluirorcamento(orcnumero.value,<?php echo $usuario ?>);"> 
					&nbsp;&nbsp;&nbsp;						
					<input type="button" id="cancelaPedido" onclick="cancelarPedido()" value="Cancelar">					
					
					&nbsp;&nbsp;&nbsp;	
					<input type="button" id="fechar" onclick="fechar1()" value="Fechar">						
					
                  </Center></td>                
              </tr>
			  
			  <tr bgcolor="#CCCCCC">
			  <td height="20" colspan="6">&nbsp;</td>
			  </tr>
				
            </table>
	
    </div>
	
	<!-- ABA 5 -->
    <input type="radio" name="tabs" class="tabs" id="tab5">
    <label for="tab5">Rodoviário</label>
    <div>		
		
			<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#3366CC">
		  		<tr>
					<td valign="middle" height="25"><div align="center"><font color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif"><strong>Conhecimento de Transporte Eletrônico - CTe Normal</strong></font></div></td>
		  		</tr>
				
		  		<tr bgcolor="#CCCCCC">
		  			<td valign="top" width="100%">
		  				<table border="0" cellpadding="0" cellspacing="0" width="100%">
		  					<tr bgcolor="#CCCCCC">
			               		<td height="10" colspan="8">&nbsp;</td>
			            	</tr>																						
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="150">Ordem Coleta</td>
			               		<td width="150">Lacres</td>
								<td width="150">RNTRC</td>
								<td width="150">Entrega</td>
								<td width="150">Ind.Lotação</td>
								<td width="150">CIOT</td>            			   		
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="150"><input type="button" id="botaocoleta" value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Detalhar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" onclick="carregacoleta();"></td>
			               		<td width="150"><input type="button" id="botaolacre" value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Detalhar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" onclick="carregalacres();"></td>
            			   		<td width="150"><input type="text" name="gerrntrc" id="gerrntrc" maxlength="8" size="19" onkeyup="this.value=this.value.toUpperCase()" onBlur="convertField(this);"></td>
            			   		<td width="150"><input type="text" name="gerentrega" id="gerentrega" maxlength="10" size="19" OnKeyPress="formatar('##/##/####', this)" onBlur="dataano(this,this.value)"></td>
            			   		<td width="150"><select name="lotacao">&nbsp;<option id="lotacao" value="0">_____________</option></select></td>
               					<td width="150"><input type="text" name="gerciot" id="gerciot" maxlength="12" size="19" onkeyup="this.value=this.value.toUpperCase()" onBlur="convertField(this);" ></td>
								<td width="10">&nbsp;</td>
            				</tr>
							
							
							<tr bgcolor="#CCCCCC">
			               		<td height="10" colspan="8">&nbsp;</td>
			            	</tr>													
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="150">Pedagio</td>
			               		<td width="150">CNPJ Fornecedor</td>
            			   		<td width="300" colspan="2">Comprovante</td>            			   		
            			   		<td width="150">CNPJ Resp. Pagto</td>
               					<td width="150">Valor</td>
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="150"><input type="button" id="botaopedagio" value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Detalhar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" onclick="carregapedagio();"></td>			               		
            			   		<td width="150"><input type="text" name="pedcnpj" id="pedcnpj" maxlength="10" size="19" disabled></td>
            			   		<td width="300"  colspan="2"><input type="text" name="pedcomprova" id="pedcomprova" maxlength="10" size="36" disabled></td>
            			   		<td width="150"><input type="text" name="pedcnpj2" id="pedcnpj2" maxlength="10" size="19" disabled></td>
               					<td width="150"><input type="text" name="pedvalor" id="pedvalor" maxlength="10" size="19" style="text-align:right;" disabled></td>
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr bgcolor="#CCCCCC">
			               		<td height="10" colspan="8">&nbsp;</td>
			            	</tr>
												
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="150">Veículos</td>
			               		<td width="150">Placa</td>
								<td width="150">Renavan</td>
								<td width="150">UF</td>
								<td width="150">Codigo</td>
								<td width="150">Propriedade</td>            			   		
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="150"><input type="button" id="botaoveiculo" value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Detalhar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" onclick="carregaveiculo();"></td>
			               		<td width="150"><input type="text" name="veiplaca" id="veiplaca" maxlength="10" size="19" disabled></td>
            			   		<td width="150"><input type="text" name="veirenavan" id="veirenavan" maxlength="10" size="19" disabled></td>
            			   		<td width="150"><input type="text" name="veiuf" id="veiuf" maxlength="10" size="19" disabled></td>
            			   		<td width="150"><input type="text" name="veicodigo" id="veicodigo" maxlength="10" size="19" disabled></td>
               					<td width="150"><input type="text" name="veiprop" id="veiprop" maxlength="10" size="19" disabled></td>
								<td width="10">&nbsp;</td>
            				</tr>
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="150">&nbsp;</td>
			               		<td width="150"><input type="text" name="veiplaca2" id="veiplaca2" maxlength="10" size="19" disabled></td>
            			   		<td width="150"><input type="text" name="veirenavan2" id="veirenavan2" maxlength="10" size="19" disabled></td>
            			   		<td width="150"><input type="text" name="veiuf2" id="veiuf2" maxlength="10" size="19" disabled></td>
            			   		<td width="150"><input type="text" name="veicodigo2" id="veicodigo2" maxlength="10" size="19" disabled></td>
               					<td width="150"><input type="text" name="veiprop2" id="veiprop2" maxlength="10" size="19" disabled></td>
								<td width="10">&nbsp;</td>
            				</tr>
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="150">&nbsp;</td>
			               		<td width="150"><input type="text" name="veiplaca3" id="veiplaca3" maxlength="10" size="19" disabled></td>
            			   		<td width="150"><input type="text" name="veirenavan3" id="veirenavan3" maxlength="10" size="19" disabled></td>
            			   		<td width="150"><input type="text" name="veiuf3" id="veiuf3" maxlength="10" size="19" disabled></td>
            			   		<td width="150"><input type="text" name="veicodigo3" id="veicodigo3" maxlength="10" size="19" disabled></td>
               					<td width="150"><input type="text" name="veiprop3" id="veiprop3" maxlength="10" size="19" disabled></td>
								<td width="10">&nbsp;</td>
            				</tr>
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="150">&nbsp;</td>
			               		<td width="150"><input type="text" name="veiplaca4" id="veiplaca4" maxlength="10" size="19" disabled></td>
            			   		<td width="150"><input type="text" name="veirenavan4" id="veirenavan4" maxlength="10" size="19" disabled></td>
            			   		<td width="150"><input type="text" name="veiuf4" id="veiuf4" maxlength="10" size="19" disabled></td>
            			   		<td width="150"><input type="text" name="veicodigo4" id="veicodigo4" maxlength="10" size="19" disabled></td>
               					<td width="150"><input type="text" name="veiprop4" id="veiprop4" maxlength="10" size="19" disabled></td>
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr bgcolor="#CCCCCC">
			               		<td height="10" colspan="8">&nbsp;</td>
			            	</tr>
							
							
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="150">Motoristas</td>
			               		<td width="150">CPF</td>
								<td width="600" colspan="4">Nome</td>								
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="150"><input type="button" id="botaomotorista" value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Detalhar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" onclick="carregamotorista();"></td>			               		
            			   		<td width="150"><input type="text" name="motcpf" id="motcpf" maxlength="10" size="19" disabled></td>
            			   		<td width="600"  colspan="4"><input type="text" name="motnome" id="motnome" maxlength="10" size="90" disabled></td>            			   		
								<td width="10">&nbsp;</td>
            				</tr>
														
							<tr bgcolor="#CCCCCC">
			               		<td height="10" colspan="8">&nbsp;</td>
			            	</tr>
							
			            </table>
					</td>
				</tr>
            	
				
				<tr bgcolor="#CCCCCC"> 
					<td height="17" colspan="4">&nbsp;</td>
				</tr>	
				
			  <tr bgcolor="#CCCCCC">
                <td colspan="6"> <Center>
                	<input type="button" id="botaoinc" value="Alterar" onclick="incluirorcamento(5);"> 
					&nbsp;&nbsp;&nbsp;		
					
					<input type="hidden" id="botaoimp" value="Imprimir" onclick="Imprimir(orcnumero.value,<?php echo $usuario ?>);"> 
					
					<input type="button" id="botaoxml" value="XML" onclick="Imprimirxml(orcnumero.value,<?php echo $usuario ?>);"> 
					&nbsp;&nbsp;&nbsp;	

					<input type="button" id="botaoproceda" value="Proceda" onclick="Imprimirproceda(orcnumero.value,<?php echo $usuario ?>);"> 
					&nbsp;&nbsp;&nbsp;		
					
					<input type="button" id="botaodatasul" value="Datasul" onclick="Imprimirdatasul(orcnumero.value,<?php echo $usuario ?>);"> 
					&nbsp;&nbsp;&nbsp;
					
					<input type="button" id="botaoexc" value="Excluir" onclick="excluirorcamento(orcnumero.value,<?php echo $usuario ?>);"> 
					&nbsp;&nbsp;&nbsp;						
					<input type="button" id="cancelaPedido" onclick="cancelarPedido()" value="Cancelar">	

					&nbsp;&nbsp;&nbsp;	
					<input type="button" id="fechar" onclick="fechar1()" value="Fechar">	
					
                  </Center></td>                
              </tr>
			  
			  <tr bgcolor="#CCCCCC">
			  <td height="20" colspan="6">&nbsp;</td>
			  </tr>
				
            </table>
	
    </div>
	
	<!-- ABA 6 -->
    <input type="radio" name="tabs" class="tabs" id="tab6">
    <label for="tab6">Observação</label>
    <div>		
		
			<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#3366CC">
		  		<tr>
					<td valign="middle" height="25"><div align="center"><font color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif"><strong>Conhecimento de Transporte Eletrônico - Observações</strong></font></div></td>
		  		</tr>
		  		<tr bgcolor="#CCCCCC">
		  			<td valign="top" width="100%">
		  				<table border="0" cellpadding="0" cellspacing="0" width="100%">					
						
		  					<tr bgcolor="#CCCCCC">
			               		<td height="10" colspan="8">&nbsp;</td>
			            	</tr>																						
							
							<tr>
								<td width="23">&nbsp;</td>               					
            			   		<td width="900" colspan="6">Observações Gerais</td>            			   		
								<td width="10">&nbsp;</td>
            				</tr>										
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="900" colspan="6"><textarea name="obsgeral" id="obsgeral" cols="130" rows="2" onkeyup="this.value=this.value.toUpperCase()" onBlur="convertField(this);" ></textarea></td>            			   		
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr bgcolor="#CCCCCC">
			               		<td height="10" colspan="8">&nbsp;</td>
			            	</tr>
							
							<tr>
								<td width="23">&nbsp;</td>               					
            			   		<td width="900" colspan="6">Observações de Interesse do Contribuinte&nbsp;&nbsp;&nbsp;<input type="button" id="botaocontribuinte" value="Observações" onclick="carregacontribuinte();"></td>            			   		
								<td width="10">&nbsp;</td>
            				</tr>										
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="900" colspan="6"><textarea name="obscontribuinte" id="obscontribuinte" cols="130" rows="2" onkeyup="this.value=this.value.toUpperCase()" onBlur="convertField(this);" disabled></textarea></td>            			   		
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr bgcolor="#CCCCCC">
			               		<td height="10" colspan="8">&nbsp;</td>
			            	</tr>
							
							<tr>
								<td width="23">&nbsp;</td>               					
            			   		<td width="900" colspan="6">Observações de Interesse do Fisco&nbsp;&nbsp;&nbsp;<input type="button" id="botaofisco" value="Observações" onclick="carregafisco();"></td>            			   		
								<td width="10">&nbsp;</td>
            				</tr>										
							
							<tr>
								<td width="23">&nbsp;</td>
               					<td width="900" colspan="6"><textarea name="obsfisco" id="obsfisco" cols="130" rows="2" onkeyup="this.value=this.value.toUpperCase()" onBlur="convertField(this);" disabled></textarea></td>            			   		
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr bgcolor="#CCCCCC">
			               		<td height="10" colspan="8">&nbsp;</td>
			            	</tr>
														
			            </table>
					</td>
				</tr>
            	
				
				<tr bgcolor="#CCCCCC"> 
					<td height="17" colspan="4">&nbsp;</td>
				</tr>	
				
			  <tr bgcolor="#CCCCCC">
                <td colspan="6"> <Center>
                	<input type="button" id="botaoinc" value="Alterar" onclick="incluirorcamento(6);"> 
					&nbsp;&nbsp;&nbsp;	
					
					<input type="hidden" id="botaoimp" value="Imprimir" onclick="Imprimir(orcnumero.value,<?php echo $usuario ?>);"> 
					
					<input type="button" id="botaoxml" value="XML" onclick="Imprimirxml(orcnumero.value,<?php echo $usuario ?>);"> 
					&nbsp;&nbsp;&nbsp;	

					<input type="button" id="botaoproceda" value="Proceda" onclick="Imprimirproceda(orcnumero.value,<?php echo $usuario ?>);"> 
					&nbsp;&nbsp;&nbsp;		
					
					<input type="button" id="botaodatasul" value="Datasul" onclick="Imprimirdatasul(orcnumero.value,<?php echo $usuario ?>);"> 
					&nbsp;&nbsp;&nbsp;
					
					<input type="button" id="botaoexc" value="Excluir" onclick="excluirorcamento(orcnumero.value,<?php echo $usuario ?>);"> 
					&nbsp;&nbsp;&nbsp;						
					<input type="button" id="cancelaPedido" onclick="cancelarPedido()" value="Cancelar">	

					&nbsp;&nbsp;&nbsp;	
					<input type="button" id="fechar" onclick="fechar1()" value="Fechar">	
					
                  </Center></td>                
              </tr>
			  
			  <tr bgcolor="#CCCCCC">
			  <td height="20" colspan="6">&nbsp;</td>
			  </tr>
				
            </table>
	
    </div>
	
	
	<!-- ABA 7 -->
    <input type="radio" name="tabs" class="tabs" id="tab7">
    <label for="tab7">SEFAZ</label>
    <div>		
		
			<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#3366CC">
		  		<tr>
					<td valign="middle" height="25"><div align="center"><font color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif"><strong>Conhecimento de Transporte Eletrônico - SEFAZ</strong></font></div></td>
		  		</tr>
		  		<tr bgcolor="#CCCCCC">
		  			<td valign="top" width="100%">
		  				<table border="0" cellpadding="0" cellspacing="0" width="100%">					
						
		  					<tr bgcolor="#CCCCCC">
			               		<td height="10" colspan="11">&nbsp;</td>
			            	</tr>		

							<tr>
								<td width="23">&nbsp;</td>               					
            			   		<td width="900" colspan="6"><b>CTe</b></td>            			   		
								<td width="10">&nbsp;</td>
            				</tr>				
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="500" colspan="5">Chave</td>               					
            			   		<td width="200" colspan="2">Emissão</td>
            			   		<td width="200" colspan="2">Recebimento</td>            			   		
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="500" colspan="5"><input type="text" name="sefazchave" id="sefazchave" size="65" readonly></td>
               					<td width="200" colspan="2"><input type="text" name="sefazemissao" id="sefazemissao" size="20" readonly></td>
								<td width="200" colspan="2"><input type="text" name="sefazrecebto" id="sefazrecebto" size="20" readonly></td>            						
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="500" colspan="5">Status</td>               					
            			   		<td width="400" colspan="4">Protocolo</td>            			   															
								<td width="10">&nbsp;</td>
            				</tr>														
							
							<tr>
								<td width="23">&nbsp;</td>		
								<td width="500" colspan="5"><input type="text" name="sefazstatus" id="sefazstatus" size="65" readonly></td>		
               					<td width="400" colspan="4"><input type="text" name="sefazprotocolo" id="sefazprotocolo" size="51" readonly></td>												
								<td width="10">&nbsp;</td>
            				</tr>
													
							
							<tr bgcolor="#CCCCCC">
			               		<td height="10" colspan="11">&nbsp;</td>
			            	</tr>
							
							<tr>
								<td width="23">&nbsp;</td>               					
            			   		<td width="900" colspan="6"><b>Cancelamento</b></td>            			   		
								<td width="10">&nbsp;</td>
            				</tr>				
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="500" colspan="5">Chave</td>               					
            			   		<td width="200" colspan="2">Data</td>
            			   		<td width="200" colspan="2">Recebimento</td>            			   		
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="500" colspan="5"><input type="text" name="sefazcancchave" id="sefazcancchave" size="65" readonly></td>
               					<td width="200" colspan="2"><input type="text" name="sefazcancemissao" id="sefazcancemissao" size="20" readonly></td>
								<td width="200" colspan="2"><input type="text" name="sefazcancrecebto" id="sefazcancrecebto" size="20" readonly></td>            						
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="500" colspan="5">Status</td>               					
            			   		<td width="400" colspan="4">Protocolo</td>            			   															
								<td width="10">&nbsp;</td>
            				</tr>														
							
							<tr>
								<td width="23">&nbsp;</td>		
								<td width="500" colspan="5"><input type="text" name="sefazcancstatus" id="sefazcancstatus" size="65" readonly></td>		
               					<td width="400" colspan="4"><input type="text" name="sefazcancprotocolo" id="sefazcancprotocolo" size="51" readonly></td>												
								<td width="10">&nbsp;</td>
            				</tr>
							
							<tr bgcolor="#CCCCCC">
			               		<td height="10" colspan="11">&nbsp;</td>
			            	</tr>
							
							<tr>
								<td width="23">&nbsp;</td>               					
            			   		<td width="900" colspan="6"><b>Inutilização</b></td>            			   		
								<td width="10">&nbsp;</td>
            				</tr>				
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="500" colspan="5">Motivo</td>               					
            			   		<td width="200" colspan="2">Data</td>
            			   		<td width="200" colspan="2"></td>            			   		
            				</tr>
							
							<tr>
								<td width="23">&nbsp;</td>
								<td width="500" colspan="5"><input type="text" name="inutmotivo" id="inutmotivo" size="65" readonly></td>
               					<td width="200" colspan="2"><input type="text" name="inutdata" id="inutdata" size="20" readonly></td>
								<td width="200" colspan="2"></td>            						
								<td width="10">&nbsp;</td>
            				</tr>
														
			            </table>
					</td>
				</tr>
            	
				
				<tr bgcolor="#CCCCCC"> 
					<td height="17" colspan="4">&nbsp;</td>
				</tr>	
				
			  <tr bgcolor="#CCCCCC">
                <td colspan="6"> <Center>
                	<input type="button" id="botaoinc" value="Alterar" onclick="incluirorcamento(6);"> 
					&nbsp;&nbsp;&nbsp;	
					
					<input type="hidden" id="botaoimp" value="Imprimir" onclick="Imprimir(orcnumero.value,<?php echo $usuario ?>);"> 
					
					<input type="button" id="botaoxml" value="XML" onclick="Imprimirxml(orcnumero.value,<?php echo $usuario ?>);"> 
					&nbsp;&nbsp;&nbsp;	

					<input type="button" id="botaoproceda" value="Proceda" onclick="Imprimirproceda(orcnumero.value,<?php echo $usuario ?>);"> 
					&nbsp;&nbsp;&nbsp;		
					
					<input type="button" id="botaodatasul" value="Datasul" onclick="Imprimirdatasul(orcnumero.value,<?php echo $usuario ?>);"> 
					&nbsp;&nbsp;&nbsp;
					
					<input type="button" id="botaoexc" value="Excluir" onclick="excluirorcamento(orcnumero.value,<?php echo $usuario ?>);"> 
					&nbsp;&nbsp;&nbsp;						
					<input type="button" id="cancelaPedido" onclick="cancelarPedido()" value="Cancelar">	

					&nbsp;&nbsp;&nbsp;	
					<input type="button" id="fechar" onclick="fechar1()" value="Fechar">	
					
                  </Center></td>                
              </tr>
			  
			  <tr bgcolor="#CCCCCC">
			  <td height="20" colspan="6">&nbsp;</td>
			  </tr>
				
            </table>
	
    </div>
	
	
	
	
			
		</td>
  	</tr>
</table>
</form>
<div id="msg" style="visibility: hidden;">&nbsp;<font face="Verdana" size="2">Processando...</font></div>
<div id="resultado"></div>
</Center>
<br>
</body>
</html>
