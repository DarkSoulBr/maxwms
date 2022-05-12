<?php 
$flagmenu = 2;

require("verifica.php");
//require_once("include/config.php");

include 'include/jquery.php';
include 'include/css.php';

$usuario = $_SESSION["id_usuario"];


if ( $_GET["flag"] != "" ) {$flag = $_GET["flag"];} else {
$flag = 0;}


$dataInicio = $_GET["dataInicio"];
$horaInicio = $_GET["horaInicio"];
$dataFim = $_GET["dataFim"];
$horaFim = $_GET["horaFim"];

$vetorx=$_GET["vetorx"];
$pagina=$_GET["pagina"];
$cancelados=$_GET["cancelados"];
 
?>


<script src="js/admcte.js"></script>

<!--script type="text/javascript" src="modulos/vendaAtacado/pedidos/adm/view/js/consultaPedidos.js"></script-->

<script type="text/javascript" src="js/validaAdm.js"></script>

<script type="text/javascript" src="js/verificaAdm.js"></script>

<!--script type="text/javascript" src="modulos/vendaAtacado/pedidos/adm/view/js/funcoes.js"></script-->


<!--script type="text/javascript" src="lib/jquery/max/populaComboxTipoPedidos.js"></script-->
<!--script type="text/javascript" src="lib/jquery/max/populaComboxEstoquesFisico.js"></script -->



<div align="center">
	<div id="retorno"></div>
	<div id="dialog" style="margin-left: 5px; margin-left: 5px;"></div>

<body onload="inicia('<?php echo $usuario ?>','<?php echo $flag ?>','<?php echo $dataInicio ?>','<?php echo $horaInicio ?>','<?php echo $dataFim ?>','<?php echo $horaFim ?>','<?php echo $vetorx ?>','<?php echo $pagina ?>','<?php echo $cancelados ?>');">

<table id="tblPrincipal" border="2" cellspacing="0" cellpadding="0" bordercolor="#999999">
	<tr>
		<td>
		<table width="100%" height="20" border="0" cellpadding="0"
			cellspacing="0" bgcolor="#3366CC">
			<tr>
				<td colspan="5">
				<div align="center"><font color="#FFFFFF"
					face="Verdana, Arial, Helvetica, sans-serif"><strong>Gerenciamento de CTe</strong></font></div>
				</td>
			</tr>
		</table>
		
		<div id="accordion">
		
		<h3><a href="#">Localizar</a></h3>

			<div style="background:#CCCCCC;">
				<table width="100%" border="0" cellpadding="0"
					cellspacing="0" bgcolor="#CCCCCC">
		
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
		
					<tr bgcolor="#CCCCCC">
		               	<td valign="middle" align="center" colspan="4">
							<table border="0" cellpadding="0" cellspacing="0" width="60%">
				            	
				            	<tr bgcolor="#CCCCCC">
				               		<td colspan="4" valign="middle">&nbsp;&nbsp;&nbsp;&nbsp;<b><i>Periodo Pesquisa:</i></b></td>
				            	</tr>
				            	
				            	<tr bgcolor="#CCCCCC">
				               		<td height="17" colspan="4">&nbsp;</td>
				            	</tr>
								
				            	<tr bgcolor="#CCCCCC">
				               		<td valign="middle" colspan="4">
				               			<form id="formPeriodo" name="formPeriodo" method="post" action="#">
											<table>
												<tr bgcolor="#CCCCCC">
													<td valign="middle" width="120">Data Inicial:</td>
													<td valign="middle">
														<input id="dataInicio" type="text" name="dataInicio" size="12">
													</td>
													<td valign="middle" width="120">Hora Inicial:</td>
													<td valign="middle">
														<input id="horaInicio" type="text" name="horaInicio" size="12">
													</td>
												</tr> 
												<tr bgcolor="#CCCCCC">
													<td valign="middle" width="120">Data Final:</td>
													<td valign="middle">
														<input id="dataFim" type="text" name="dataFim" size="12">
													</td>
													<td valign="middle" width="120">Hora Final:</td>
													<td valign="middle">
														<input id="horaFim" type="text" name="horaFim" size="12">
													</td>
												</tr>         
											</table>
				               			</form>
				               		</td>
				            	</tr>
				            </table>
						</td>
		            </tr>
		            
					
					
					<tr bgcolor="#CCCCCC" style="display: none;">
		               	<td valign="middle" align="center" colspan="4">
							<table border="0" cellpadding="0" cellspacing="0" width="60%">
				            	<tr bgcolor="#CCCCCC">
				               		<td height="10" colspan="4"><hr size="1"/></td>
				            	</tr>
				            	
				            	<tr bgcolor="#CCCCCC">
				               		<td colspan="4" valign="middle">&nbsp;&nbsp;&nbsp;&nbsp;<b><i>Escolha o Status:</i></b></td>
				            	</tr>
				            	
				            	<tr bgcolor="#CCCCCC">
				               		<td height="17" colspan="4">&nbsp;</td>
				            	</tr>					
								
				            	<tr bgcolor="#CCCCCC">
				               		<td valign="middle" colspan="4">
				               			<form id="formTipoPedido" name="formTipoPedido" method="post" action="#">
											<table>
												<tr bgcolor="#CCCCCC">
													<td valign="middle" width="120">Status:</td>
													<td valign="middle">
														<select name="listaTipoPedidos" id="listaTipoPedidos" class="populaTipoPedidos" multiple="multiple" size="10"></select>
													</td>
												</tr>
											</table>
				               			</form>
				               		</td>
				            	</tr>
								
				            </table>
						</td>
		            </tr>
	
					<tr>
						<td colspan="5" align="center">						
						<input type="checkbox" name="chkcanc" id="chkcanc" value="1" align="absmiddle">
						Cancelados / Inutilizados 
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
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					
		
					<tr>
						<td colspan="5" align="center">
						<input id="btnConsultaPedidos" type="button" name="btnConsultaPedidos" size="10" value="LOCALIZAR" onclick="imprimirconsulta();">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input id="btnExcel" type="button" name="btnExcel" size="10" value="Excel" onclick="excel();">
						
						</td>
		
					</tr>
					
					<tr>
						<td colspan="5" align="center">
						<div id="msg" style="visibility: hidden;">&nbsp;<font face="Verdana" size="2">Processando...</font></div>
					</tr>	

				</table>
			</div>

		<h3><a href="#">Gerenciamento de CTe</a></h3>
			<div id="divResultado" style="background:#CCCCCC;">
				<table id='tblResultado'>
				</table>				
				<center><input id="btnIncluir" type="button" name="btnIncluir" size="10" value="Incluir" onclick="javascript:novaJanela2('incluirctenovo.php','INCLUIR_CTE')">
				&nbsp;&nbsp;&nbsp;
				<input id="btnAtualizar" type="button" name="btnAtualizar" size="10" value="Atualizar" onclick="javascript:atualizargrid()">
				&nbsp;&nbsp;&nbsp;Página:&nbsp;
				<select id="listpaginas" name="listpaginas" size="1"><option value="0">_</option></select>
				</center>
			</div>		
			<input type="hidden" name="pagina" id="pagina" size="5" value="" readonly disabled>
		</div>
		</td>
	</tr>
</table>

<!--<div id="msg" style="visibility: hidden;">&nbsp;<font face="Verdana" size="2">Processando...</font></div>
<div id="resultado"></div>
-->

</div>
</body>
