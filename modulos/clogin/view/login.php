<?php
/**
* Arquivo de Interface de Usuario para login.
*
* Entrada de dados de login e senha para autenticao no sistema.
* Este arquivo aquivo segue os padroes estabelecidos no dTrade.

*/
?>
	<!-- incluindo script jquery para validação formulário -->
	<script type="text/javascript" src="modulos/clogin/view/js/validacao.js"></script>
	<script type="text/javascript" src="modulos/clogin/view/js/getLogin.js"></script>


<div align="left">
	<div id="retorno"></div>
	<table border="0" width="100%" height="100%" align="left">
		<tr>
			<td width="100%" height="100%" align="left" valign="top">
				<form id="formLogin" name="formLogin" action="#" method="post">
					<input type="hidden" id="action" name="action" />
					<table border="0" cellpadding="0" cellspacing="0" width="490">
					
					<tr>
						<td colspan="4"><div align="left">Maxtrade - Coletor</div></td>
					</tr>	
										
					<tr>
						<td colspan="4"><center>&nbsp;</center></td>
					</tr>		
					
					<tr>						
						<td><div align="left">Login:</div></td>
						<td><input type="text" id="login" name="login" style="width:150px;"></td>
						<td>&nbsp;</td>
					</tr>
					<tr>						
						<td><div align="left">Senha:</div></td>
						<td><input type="password" id="senha" name="senha" style="width:150px;"></td>
						<td>&nbsp;</td>
					</tr>	
					
					<tr>
						<td colspan="4"><center>&nbsp;</center></td>
					</tr>	
					
					<tr> 
						<td>&nbsp;</td>
						<td><div align="left">
							<input type="button" name="button" id="btnLogin" value="Acessar"/>
						  </div></td>						
					</tr>
					
  						
  						<tr>
   							<td colspan="4"><center>&nbsp;</center></td>
						</tr>	

					</table>
				</form>
			</td>
		</tr>
	</table>
</div>
