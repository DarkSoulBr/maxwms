<?php
$flagmenu = 2;
// Verificador de sessão
require("verifica.php");
?>
<!DOCTYPE html>
<html>
    <head>

        <!-- Required meta tags-->    
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Title Page-->
        <title>Cadastro de Motoristas</title> 

        <!-- maxnew CSS-->
        <link href="css/max.css" rel="stylesheet" media="all">        
    </head>

    <body onload="codigo_fornecedor(1);">
        <div id="retorno"></div>
        <div id="dialog" style="margin-left: 5px; margin-left: 5px;"></div>
        <div class="bg-gray p-t-10 font-lucida">
            <div class="wrapper wrapper--w680">
                <div class="card card-4">
                    <div class="card-header">
                        Cadastro de Motoristas
                    </div>
                    <div class="card-body">                    
                        <form name="formulario" id="formulario">
							<div class="row row-space">
								<div class="col-1">
									<div class="input-group m-r-45">
										<label class="label">Opção</label>
										<div>
										<label class="radio-container m-r-15">Código                                              
											<input name="radiobutton" id="radio1" type="radio" value="radiobutton" checked>
											<span class="checkmark"></span>
										</label>
										<label class="radio-container m-r-15">Nome
											<input type="radio" name="radiobutton" id="radio3" value="radiobutton">
											<span class="checkmark"></span>
										</label>
										<label class="radio-container">CPF
											<input type="radio" name="radiobutton" id="radio5" value="radiobutton">
											<span class="checkmark"></span>
										</label>
										</div>
									</div>
								</div>
							</div>	
                            <div class="row row-space">                                
                                <div class="col-2">
                                    <div class="input-group">
                                        <label class="label">Pesquisar</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="pesquisa" type="text" name="pesquisa" size="70" onkeypress="maiusculo();" onblur="convertField(this);dadospesquisa(this.value);">
                                        </div>
                                    </div>
                                </div>                                
                                <div class="col-3">
                                    <div class="input-group">
                                        <label class="label">&nbsp;</label>
                                        <div class="input-group-icon centraliza">
                                            <button class="btn-small btn--radius-2 btn--blue" name="button" type="button" id="button" onClick="dadospesquisa(pesquisa.value);">Pesquisar</button>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>						
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group">
                                        <label class="label">Campo</label>                                        
                                        <div>                                          
                                            <span class="custom-dropdown">
                                                <select name="listDados" onChange="dadospesquisa2(this.value);">
                                                    <option id="opcoes" value="0">Faça a Pesquisa de Campo</option>                                                
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
									<input id="forcodigo" type="hidden" name="forcodigo" size="25">
                                </div>                                
                            </div>
                            <div class="row row-space">
                                <div class="col-2">
                                    <div class="input-group m-r-45">
                                        <label class="label">Código</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="forcod" type="text" name="forcod" size="10" onkeyup="javascript:this.value=this.value.toUpperCase();" disabled>
                                        </div>
                                    </div>
                                </div>
								<div class="col-2">
                                    <div class="input-group m-r-45">
                                        <label class="label">CPF</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="forcpf" type="text" name="forcpf" size="22" maxlength="14" onKeyPress="return soNums(event);" onBlur="validar2(this);">
                                        </div>
                                    </div>
                                </div> 
                            </div>
							<div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group m-r-15">
                                        <label class="label">Nome</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="forrazao" type="text" name="forrazao" size="70" onkeyup="javascript:this.value=this.value.toUpperCase();" maxlength=40>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <div class="row row-space">                                
                                <div class="col-3">
                                    <div class="p-t-15 centraliza">
                                        <button class="btn btn--radius-2 btn--blue" name="button2" type="button" id="botao" onClick=valida_form(1)><span id="botao-text" con>Incluir</span></button>
                                        <input name="hidden" type="hidden" id="acao" value="inserir">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="p-t-15 centraliza">                                        
                                        <button class="btn btn--radius-2 btn--green" type="button" id="botao2" onClick=limpa_form(1)>Limpar</button>
                                    </div>
                                </div>
								<div class="col-3">
                                    <div class="p-t-15 centraliza">                                        
                                        <button class="btn btn--radius-2 btn--red" name="button3" type="button" id="botao3" onClick=verifica()>Excluir</button>
                                    </div>
                                </div>
                            </div>    
                        </form>
                    </div>
                </div>                
            </div>
        </div>
		<div class="wrapper wrapper--w960">
            <div class="result" id="MsgResultado"></div> 
		</div>      
		
		<input id="forrg" type="hidden" name="forrg" size="18" onkeyup="javascript:this.value=this.value.toUpperCase();" disabled>
		
		<div style="display:none;">
			<tr style="display: none;">
				<td>&nbsp;</td>
				<td>Pessoa:</td>
				<td colspan="3"><input name="radiobutton2" type="radio" id="radio11" value="radiobutton" onclick="verificapessoa(this.value);">
					Jur&iacute;dica <input type="radio" name="radiobutton2" id="radio12" value="radiobutton" onclick="verificapessoa(this.value);" checked>
					F&iacute;sica</td>
				<td>&nbsp;</td>
			</tr>
			<tr style="display: none;">
				<td height="21">&nbsp;</td>
				<td>CNPJ:</td>
				<td width="20%"><input id="forcnpj" type="text" name="forcnpj" size="22" maxlength="18" onKeyPress="return soNums(event);" onBlur="validar(this);" disabled></td>
				<td width="22%">
					<div align="right">I.E.:</div>
				</td>
				<td width="28%"><input id="forie" type="text" name="forie" size="18" onkeyup="javascript:this.value=this.value.toUpperCase();" disabled></td>
				<td>&nbsp;</td>
			</tr>
		</div>

		<script src="js/motoristas.js"></script>
		<script src="js/geral.js"></script>

		<script language="JavaScript1.2">
		var tpfornecedor;
		tpfornecedor = 1;
		</script>
		
    </body>

</html>


