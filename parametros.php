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
        <title>Parâmetros</title> 

        <!-- maxnew CSS-->
        <link href="css/max.css" rel="stylesheet" media="all">        
    </head>

    <body onload="dadospesquisa(1);">
        <div id="retorno"></div>
        <div id="dialog" style="margin-left: 5px; margin-left: 5px;"></div>
        <div class="bg-gray p-t-10 p-b-100 font-lucida">
            <div class="wrapper wrapper--w680">
                <div class="card card-4">
                    <div class="card-header">
                        Parâmetros
                    </div>
                    <div class="card-body">                    
                        <form method="POST">
							<div class="row row-space">
								<div class="col-1">
									<div class="input-group m-r-45">
										<label class="label">Ambiente</label>
										<div>
										<label class="radio-container m-r-15">Produção                                                
											<input type="radio" name="radiobutton2" id="radio1" value="radiobutton" checked>
											<span class="checkmark"></span>
										</label>
										<label class="radio-container">Homologação
											<input type="radio" name="radiobutton2" id="radio2" value="radiobutton">
											<span class="checkmark"></span>
										</label>
										</div>
									</div>
								</div>
							</div>	
                            <div class="row row-space">
                                <div class="col-2">
                                    <div class="input-group m-r-45">
                                        <label class="label">Versão do Aplicativo</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="versao" type="text" name="versao" size="18" maxlength="25">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="input-group m-r-45">
                                        <label class="label">Nome Seguradora</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="servico" type="text" name="servico" size="45" onKeyPress="maiusculo()" onBlur="convertField(this)" maxlength="50">
                                        </div>
                                    </div>
                                </div> 
                            </div>
							<div class="row row-space">
                                <div class="col-3">
                                    <div class="input-group m-r-45">
                                        <label class="label">Numero Apólice</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="apolice" type="text" name="apolice" size="45" onKeyPress="maiusculo()" onBlur="convertField(this)" maxlength="50">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="input-group m-r-45">
                                        <label class="label">RNTRC</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" type="text" name="gerrntrc" id="gerrntrc" maxlength="8" size="18" onkeyup="this.value=this.value.toUpperCase()" onBlur="convertField(this);">
                                        </div>
                                    </div>
                                </div> 
								<div class="col-3">
                                    <div class="input-group m-r-45">
                                        <label class="label">Serviço % NFe</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" type="text" name="perc" id="perc" maxlength="10" size="18" style="text-align:right;" value="" onblur="format_val(this.value,this.id);">
                                        </div>
                                    </div>
                                </div> 
                            </div>
							<div class="row row-space">
								<div class="col-1">
									<div class="input-group m-r-45">
										<label class="label">Valida/Assina CTe</label>
										<div>
										<label class="radio-container m-r-15">Sim                                         
											<input type="radio" name="radiobuttonx" id="radiox1" value="radiobutton" checked>
											<span class="checkmark"></span>
										</label>
										<label class="radio-container">Não
											<input type="radio" name="radiobuttonx" id="radiox2" value="radiobutton">
											<span class="checkmark"></span>
										</label>
										</div>
									</div>
								</div>
							</div>
							<div class="row row-space centraliza">
                                <div class="col-1">                               
                                    <div class="input-group subtitle centraliza">                                    
                                        <div class="p-t-10">
                                            <p style="color:red"><small><b>Atenção: Opção Sim deve ser usada apenas para Testes!</b></small></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-space">                                
                                <div class="col-2">
                                    <div class="p-t-15 centraliza">
                                        <button class="btn btn--radius-2 btn--blue" name="button2" type="button" id="botao" onClick=valida_form(1)>Alterar</button>
                                        <input name="hidden" type="hidden" id="acao" value="inserir">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="p-t-15 centraliza">                                        
                                        <button class="btn btn--radius-2 btn--green" type="button" id="botao2" onClick=limpa_form(1)>Limpar</button>
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
		
		<input id="parcod" type="hidden" name="parcod" size="10" maxlength="25" >
		
		<div style="display:none;">
			<tr bgcolor="#CCCCCC" style="display: none;">
				<td>&nbsp;</td>
				<td>Layout CTe:</td>
				<td colspan="3">
				<input type="radio" name="radiobutton3" id="radio01" value="radiobutton" checked>Versão 2.00
				<input type="radio" name="radiobutton3" id="radio02" value="radiobutton" >Versão 3.00
				</td>
				<td>&nbsp;</td>
			</tr>
		</div>

		<script src="js/parametros.js"></script>
		<script src="js/geral.js"></script>

		<script language="JavaScript1.2">
		var tpfornecedor;
		tpfornecedor = 1;
		</script>
		
    </body>

</html>


