<?php   
$flagmenu=2;
// Verificador de sessão
require("verifica.php");
include 'include/css.php';
?>
<!DOCTYPE html>
<html>
    <head>

        <!-- Required meta tags-->    
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Title Page-->
        <title>Cadastro de CFOP</title> 

        <!-- maxnew CSS-->
        <link href="css/max.css" rel="stylesheet" media="all">        
    </head>

    <body> 
        <div id="retorno"></div>
        <div id="dialog" style="margin-left: 5px; margin-left: 5px;"></div>
        <div class="bg-gray p-t-10 p-b-100 font-lucida">
            <div class="wrapper wrapper--w680">
                <div class="card card-4">
                    <div class="card-header">
                        Cadastro de CFOP
                    </div>
                    <div class="card-body">                    
                        <form method="POST">
							<div class="row row-space">
								<div class="col-1">
									<div class="input-group m-r-45">
										<label class="label">Opção</label>
										<div>
										<label class="radio-container m-r-15">Código                                           
											<input name="radiobutton" id="radio1" type="radio" value="radiobutton" checked>
											<span class="checkmark"></span>
										</label>
										<label class="radio-container">Descrição
											<input name="radiobutton" id="radio2" type="radio" value="radiobutton">
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
                                            <input class="input--style-4" id="pesquisa" type="text" name="pesquisa" size="40" onBlur="convertField(this)">
                                        </div>
                                    </div>
                                </div>                                
                                <div class="col-3">
                                    <div class="input-group">
                                        <label class="label">&nbsp;</label>
                                        <div class="input-group-icon centraliza">
                                            <button class="btn-small btn--radius-2 btn--blue" name="button" type="button" id="button" onClick=dadospesquisa(pesquisa.value)>Pesquisar</button>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>						
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group">
                                        <label class="label">CFOP</label>                                        
                                        <div>                                          
                                            <span class="custom-dropdown">
                                                <select name="listDados" onChange="dadospesquisa2(this.value);">
                                                    <option id="opcoes" value="0">Faça a Pesquisa de CFOP</option>                                                
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
									<input id="cfocodigo" type="hidden" name="cfocodigo" size="25">
                                </div>                                
                            </div>
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group m-r-15">
                                        <label class="label">CFOP</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="cfocod" type="text" name="cfocod" size="10" maxlength="4" onBlur="convertField(this)">
                                        </div>
                                    </div>
                                </div>                                
                            </div>
							<div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group m-r-15">
                                        <label class="label">Descrição</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="cfonome" type="text" name="cfonome" size="60" maxlength="100" onBlur="convertField(this)">
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                            <div class="row row-space">                                
                                <div class="col-3">
                                    <div class="p-t-15 centraliza">
                                        <button class="btn btn--radius-2 btn--blue" type="button" id="botao" onClick=valida_form()><span id="botao-text" con>Incluir</span></button>
                                        <input name="hidden" type="hidden" id="acao" value="inserir">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="p-t-15 centraliza">                                        
                                        <button class="btn btn--radius-2 btn--green" type="button" id="botao2" onClick=limpa_form() >Limpar</button>
                                    </div>
                                </div>
								<div class="col-3">
                                    <div class="p-t-15 centraliza">                                        
                                        <button class="btn btn--radius-2 btn--red" type="button" id="botao3" onClick=verifica()>Excluir</button>
                                    </div>
                                </div>
                            </div>    
                        </form>
                    </div>
                </div>                
            </div>
        </div>

		<script src="js/cfop.js"></script>
		
    </body>

</html>


