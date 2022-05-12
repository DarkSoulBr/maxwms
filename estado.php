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
        <title>Cadastro de Estados</title> 

        <!-- maxnew CSS-->
        <link href="css/max.css" rel="stylesheet" media="all">        
    </head>

    <body onLoad=limpa_form()> 
        <div id="retorno"></div>
        <div id="dialog" style="margin-left: 5px; margin-left: 5px;"></div>
        <div class="bg-gray p-t-10 p-b-100 font-lucida">
            <div class="wrapper wrapper--w680">
                <div class="card card-4">
                    <div class="card-header">
                        Cadastro de Estados
                    </div>
                    <div class="card-body">                    
                        <form method="POST">
                            <div class="row row-space">                                
                                <div class="col-2">
                                    <div class="input-group">
                                        <label class="label">Pesquisar</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="pesquisa" type="text" name="pesquisa" size="25" onKeyPress="maiusculo()" onblur="convertField(this);">
                                        </div>
                                    </div>
                                </div>                                
                                <div class="col-3">
                                    <div class="input-group">
                                        <label class="label">&nbsp;</label>
                                        <div class="input-group-icon centraliza">
                                            <button class="btn-small btn--radius-2 btn--blue" type="button" id="botao3" onClick=dadospesquisa(pesquisa.value)>Pesquisar</button>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>						
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group">
                                        <label class="label">Estado</label>                                        
                                        <div>                                          
                                            <span class="custom-dropdown">
                                                <select name="listDados" onChange="dadospesquisa2(this.value);">
                                                    <option id="opcoes" value="0">Faça a Pesquisa de Estado</option>                                                
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
									<input name="estcodigo" type="hidden" id="estcodigo" size="25">
                                </div>                                
                            </div>
                            <div class="row row-space">
                                <div class="col-2">
                                    <div class="input-group m-r-45">
                                        <label class="label">Sigla</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" name="estsigla" type="text" id="estsigla" size="10" maxlength="2" onKeyPress="maiusculo()" onblur="convertField(this);">
                                        </div>
                                    </div>
                                </div>
								<div class="col-2">
                                    <div class="input-group m-r-45">
                                        <label class="label">Estado</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" name="estnome" type="text" id="estnome" size="25" maxlength="30" onKeyPress="maiusculo()" onblur="convertField(this);">
                                        </div>
                                    </div>
                                </div>
                            </div>
							<div class="row row-space">
                                <div class="col-4">
                                    <div class="input-group m-r-45">
                                        <label class="label">Al.Interestadual</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" name="esticms" type="text" id="esticms" size="10" maxlength="6" value="" onblur="format_val(this.value,this.id);">
                                        </div>
                                    </div>
                                </div> 
								<div class="col-4">
                                    <div class="input-group m-r-45">
                                        <label class="label">Al.Interna</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" name="esticms2" type="text" id="esticms2" size="10" maxlength="6" value="" onblur="format_val(this.value,this.id);">
                                        </div>
                                    </div>
                                </div>
								<div class="col-4">
                                    <div class="input-group m-r-45">
                                        <label class="label">% C.Pobreza</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" name="esticms3" type="text" id="esticms3" size="10" maxlength="6" value="" onblur="format_val(this.value,this.id);">
                                        </div>
                                    </div>
                                </div> 
								<div class="col-4">
                                    <div class="input-group m-r-45">
                                        <label class="label">Serv. % NFe</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" name="estnfe" type="text" id="estnfe" size="10" maxlength="6" value="" onblur="format_val(this.value,this.id);">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-space">                                
                                <div class="col-3">
                                    <div class="p-t-15 centraliza">
                                        <button class="btn btn--radius-2 btn--blue" type="button" id="botao" onClick=valida_form()><span id="botao-text" con>Incluir</span></button>
                                        <input type="hidden" id="acao" value="">
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

		<script src="js/estado.js"></script>
		
    </body>

</html>


