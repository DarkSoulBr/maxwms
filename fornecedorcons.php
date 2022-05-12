<?php
$flagmenu = 4;
// Verificador de sessão
require("verifica.php");
include 'include/jquerymax.php';
include 'include/cssloja.php';

//Verifica se a opção existe no Cadastros de Opção
$opcao = 'CONSULTA';
$pagina = 'fornecedorcons.php';
$modulo = 4;  //Cadastros
$sub = 17;  //Fornecedores
$usuario = $_SESSION["id_usuario"];

?>
<!DOCTYPE html>
<html>
    <head>
        <!-- Required meta tags-->    
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Title Page-->
        <title>Consulta de Fornecedores</title>        

        <!-- maxnew CSS-->
        <link href="css/max.css" rel="stylesheet" media="all">        
    </head>

    <body onload="dadospesquisaprazo(0, 1);">
        <div id="retorno"></div>
        <div id="dialog" style="margin-left: 5px; margin-left: 5px;"></div>
        <div class="result" id="MsgResultado2" style="display: none"></div>
        <div class="bg-gray p-t-10 p-b-100 font-lucida">
            <div class="wrapper wrapper--w960">
                <div class="card card-4">
                    <div class="card-header">
                        Consulta de Fornecedores
                    </div>
                    <div class="card-body">                    
                        <form name="formulario" id="formulario">
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Opção</label>
                                        <div>
                                            <label class="radio-container m-r-15">Código                                                
                                                <input name="radiobutton" id="radio1" type="radio" value="radiobutton" checked>
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container m-r-15">N. Guerra                                                
                                                <input type="radio" name="radiobutton" id="radio2" value="radiobutton">
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container m-r-15">Razão                                                
                                                <input type="radio" name="radiobutton" id="radio3" value="radiobutton">
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container m-r-15">CNPJ                                                
                                                <input type="radio" name="radiobutton" id="radio4" value="radiobutton">
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
                                    <div class="input-group-small">
                                        <label class="label">Pesquisar</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="pesquisa" type="text" name="pesquisa" size="50" onkeypress="maiusculo();" onblur="convertField(this);dadospesquisa(this.value);">
                                        </div>
                                    </div>
                                </div>                                
                                <div class="col-3">
                                    <div class="input-group-small">
                                        <label class="label">&nbsp;</label>
                                        <div class="input-group-icon centraliza">
                                            <button class="btn-small btn--radius-2 btn--blue" name="button" type="button" id="button" onClick="dadospesquisa(pesquisa.value);">Pesquisar</button>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>	
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group-small">
                                        <label class="label">Campo</label>                                        
                                        <div>                                          
                                            <span class="custom-dropdown">
                                                <select name="listDados" onChange="dadospesquisa2(this.value);">
                                                    <option id="opcoes" value="0">Faça a Pesquisa do Campo</option>                                                
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <input id="forcodigo" type="hidden" name="forcodigo" size="25">
                            </div>
                            <div class="row row-space ">                                
                                <div class="col-3">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Código</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="forcod" type="text" name="forcod" size="10" onkeyup="javascript:this.value = this.value.toUpperCase();" onBlur="pesquisaexiste(this.value);" disabled >
                                        </div>
                                    </div>
                                </div>                                             
                                <div class="col-3">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Cód. Datasul</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="fordat" type="text" name="fordat" size="10" onkeypress='return SomenteNumero(event)' onBlur="convertField(this);" maxlength="9">
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-3">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Cód. Vtex</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="forvtex" type="text" name="forvtex" size="10" onkeypress='return SomenteNumero(event)' onBlur="convertField(this);" maxlength="9">
                                        </div>
                                    </div>
                                </div> 
                            </div>	      
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group-small m-r-15">
                                        <label class="label">N. Guerra</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="fornguerra" type="text" name="fornguerra" size="40" onkeyup="javascrip :this.value = this.value.toUpperCase();" maxlength="25">
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group-small m-r-15">
                                        <label class="label">R. Social</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="forrazao" type="text" name="forrazao" size="70" onkeyup="javascript:this.value = this.value.toUpperCase();" maxlength="40">
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                            <div class="row row-space">
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Tipo</label>
                                        <div>
                                            <label class="radio-container m-r-15">Produtos                                                
                                                <input id="radiotipo1" name="radiotipo" type="radio" value="radiobutton" checked>
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container m-r-15">Serviços                                              
                                                <input id="radiotipo2" type="radio" name="radiotipo" value="radiobutton">
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container">Consumo                                                
                                                <input id="radiotipo3" type="radio" name="radiotipo" value="radiobutton">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Tipo</label>
                                        <div>
                                            <label class="radio-container m-r-15">Fixo                                              
                                                <input name="radiobutton3" type="radio" id="radio21" value="radiobutton" checked disabled>
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container">Eventual
                                                <input name="radiobutton3" type="radio" id="radio22" value="radiobutton" disabled>
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-space">
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Opção</label>
                                        <div>
                                            <label class="radio-container m-r-15">Nacional                                             
                                                <input name="radiobutton4" type="radio" id="radioopcao1" value="radiobutton" onclick="verificaopcao(this.value);" checked>
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container">Estrangeiro
                                                <input type="radio" name="radiobutton4" id="radioopcao2" value="radiobutton" onclick="verificaopcao(this.value);">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Pessoa</label>
                                        <div>
                                            <label class="radio-container m-r-15">Jurídica                                             
                                                <input  name="radiobutton2" type="radio" id="radio11" value="radiobutton" onclick="verificapessoa(this.value);" checked>
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container">Física
                                                <input type="radio" name="radiobutton2" id="radio12" value="radiobutton" onclick="verificapessoa(this.value);">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-space ">                                
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">CNPJ</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="forcnpj" type="text" name="forcnpj" size="22" maxlength="18" onKeyPress="return soNums(event);" onBlur="validar(this);">
                                        </div>
                                    </div>
                                </div>                                             
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">I.E.</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="forie" type="text" name="forie" size="16" onkeyup="javascript:this.value = this.value.toUpperCase();">
                                        </div>
                                    </div>
                                </div>                        
                            </div>	      
                            <div class="row row-space ">                                
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">CPF</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="forcpf" type="text" name="forcpf" size="18" maxlength="14" onKeyPress="return soNums(event);" onBlur="validar2(this);" disabled>
                                        </div>
                                    </div>
                                </div>                                             
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">R.G.</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="forrg" type="text" name="forrg" size="16" onkeyup="javascript:this.value = this.value.toUpperCase();" disabled>
                                        </div>
                                    </div>
                                </div>                        
                            </div>	   
                            <div class="row row-space">
                                <div class="col-2">
                                    <div class="input-group-small">
                                        <label class="label">Prazo PG</label>                                        
                                        <div>                                          
                                            <span class="custom-dropdown">
                                                <select name="listprazos">
                                                    <option id="opcoes2" value="0">___</option>                                                
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
                                </div>       
                                <div class="col-2">
                                    <div class="input-group-small">
                                        <label class="label">Tipo Despesa</label>                                        
                                        <div>                                          
                                            <span class="custom-dropdown">
                                                <select name="listdespesas">
                                                    <option id="opcoes6" value="0">___</option>                                                
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
                                    <input type="hidden" name="criarTpDespesa" id="criarTpDespesa" value="Criar Nova Despesa" onClick="novaDespesa('<?php echo "fornecedornovadespesa.php" ?>', '', 'width=800,height=550');return false">
                                </div>     
                            </div>
                            <div class="row row-space">
                                <div class="col-2">
                                    <div class="input-group-small">
                                        <label class="label">Status</label>                                        
                                        <div>                                          
                                            <span class="custom-dropdown">
                                                <select name="liststatus">
                                                    <option id="opcoes3" value="0">___</option>                                                
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
                                </div>       
                                <div class="col-2">
                                    <div class="input-group-small">
                                        <label class="label">T. Serviço</label>                                        
                                        <div>                                          
                                            <span class="custom-dropdown">
                                                <select name="listservicos">
                                                    <option id="opcoes4" value="0">___</option>                                                
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
                                    <input type="hidden" name="criarTpDespesa" id="criarTpDespesa" value="Criar Nova Despesa" onClick="novaDespesa('<?php echo "fornecedornovadespesa.php" ?>', '', 'width=800,height=550');return false">
                                </div>     
                            </div>
                            <div class="row row-space">
                                <div class="col-2">
                                    <div class="input-group-small">
                                        <label class="label">Canal</label>                                        
                                        <div>                                          
                                            <span class="custom-dropdown">
                                                <select name="listcanais">
                                                    <option id="opcoes7" value="0">___</option>                                                
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
                                </div>    
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">ICMS</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="foricms" type="text" name="foricms" size="16" onKeyPress="return Tecla(event);">
                                        </div>
                                    </div>
                                </div>   
                            </div>
                            <div class="row row-space ">                                
                                                                          
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Sintegra (dd/mm/aaaa)</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="forsintegra" type="text" name="forsintegra" size="14" maxlength="10" OnKeyPress="formatar('##/##/####', this)" onBlur="dadospesquisasintegra(forsintegra.value)">
                                        </div>
                                    </div>
                                </div>   
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Sintegra</label>
                                        <div>
                                            <label class="radio-container m-r-15">Sim
                                                <input name="radios" type="radio" id="radios1" value="radiobutton">
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container">Não
                                                <input type="radio" name="radios" id="radios2" value="radiobutton" checked>
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>	   
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group-small m-r-15">
                                        <label class="label">Observações</label>
                                        <div class="input-group-small-icon">
                                            <textarea class="textarea--style-4" name="forobs" id="forobs" cols="80" rows="3" onkeyup="javascript:this.value = this.value.toUpperCase();" onBlur="convertField(this)"></textarea>                                                             
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <label class="label"><b>Dados Bancarios</b></label>
                            <div class="row row-space ">                                
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Banco</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="forbanco" type="text" name="forbanco" size="6 onkeyup=" javascript:this.value=this.value.toUpperCase();">
                                        </div>
                                    </div>
                                </div>                                             
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Agência</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="foragencia" type="text" name="foragencia" size="16" onkeyup="javascript:this.value = this.value.toUpperCase();">
                                        </div>
                                    </div>
                                </div>                        
                            </div>	
                            <div class="row row-space ">                                
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Conta</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="forconta" type="text" name="forconta" size="16" onkeyup="javascript:this.value = this.value.toUpperCase();">
                                        </div>
                                    </div>
                                </div>                                             
                                <div class="col-2">
                                    <div class="input-group-small">
                                        <label class="label">Forma Pagto</label>                                        
                                        <div>                                          
                                            <span class="custom-dropdown">
                                                <select name="listformas">
                                                    <option id="opcoes5" value="0">___</option>                                                
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
                                </div>                          
                            </div>	
                            <label class="label"><b>Percentual Padrão dos Produtos</b></label>
                            <div class="row row-space ">                                
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Preço B</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="formedio" type="text" name="formedio" size="16" onKeyPress="return Tecla(event);">
                                        </div>
                                    </div>
                                </div>                                             
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Preço A</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="formaior" type="text" name="formaior" size="16" onKeyPress="return Tecla(event);">
                                        </div>
                                    </div>
                                </div>                        
                            </div>	
                            <div class="row row-space ">                                
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Preço C</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="formenor" type="text" name="formenor" size="16" onKeyPress="return Tecla(event);">
                                        </div>
                                    </div>
                                </div>                                             
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Preço D</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="formenord" type="text" name="formenord" size="16" onKeyPress="return Tecla(event);">
                                        </div>
                                    </div>
                                </div>                        
                            </div>	
                            <div class="row row-space ">                                
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">P.Mínimo</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="forminimo" type="text" name="forminimo" size="16" onKeyPress="return Tecla(event);">
                                        </div>
                                    </div>
                                </div>  
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Cadastro Produtos</label>
                                        <div>
                                            <label class="radio-container m-r-15">Sim
                                                <input name="radioprod" type="radio" id="radioprod1" value="radiobutton">
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container">Não
                                                <input type="radio" name="radioprod" id="radioprod2" value="radiobutton" checked>
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>	
                            <label class="label"><b>Endereço do Representante</b></label>
                            <div class="row row-space ">                                
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">CEP</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="fnecep" type="text" name="fnecep" size="10" onkeyup="javascript:this.value = this.value.toUpperCase();" onBlur="pesquisacep(this.value);" onkeypress='return SomenteNumero(event)' maxlength="8">
                                        </div>
                                    </div>
                                </div>                                             
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Número</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="fnenumero" type="text" name="fnenumero" size="10" maxlength="10">
                                        </div>
                                    </div>
                                </div>                        
                            </div>	
                            <div class="row row-space ">                                
                                <div class="col-1">
                                    <div class="input-group-small m-r-15">
                                        <label class="label">Endereço</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="fneendereco" type="text" name="fneendereco" size="50" onkeyup="javascript:this.value = this.value.toUpperCase();">
                                        </div>
                                    </div>
                                </div>  
                            </div>
                            <div class="row row-space ">                                
                                <div class="col-1">
                                    <div class="input-group-small m-r-15">
                                        <label class="label">Bairro</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="fnebairro" type="text" name="fnebairro" size="50" onkeyup="javascript:this.value = this.value.toUpperCase();" maxlength="30">
                                        </div>
                                    </div>
                                </div>                                                          
                            </div>	
                            <div class="row row-space ">   
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Cidade</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="fnecidade" type="text" name="fnecidade" size="50" disabled onkeyup="javascript:this.value = this.value.toUpperCase();">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">&nbsp;</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="fneuf" type="text" name="fneuf" size="3" disabled onkeyup="javascript:this.value = this.value.toUpperCase();">
                                        </div>
                                    </div>
                                </div>
                                <input id="fnecodcidade" type="hidden" name="fnecodcidade" size="3" disabled onkeyup="javascript:this.value = this.value.toUpperCase();">
                            </div>
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group-small">
                                        <label class="label">Cidade IBGE</label>                                        
                                        <div>                                          
                                            <span class="custom-dropdown">
                                                <select name="cidadeibge" id="cidadeibge" disabled>
                                                    <option id="cidcodigoibge" value="0">___</option>                                                
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
                                </div>    
                            </div>
                            <div class="row row-space ">                                
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Fone</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="fnefone" type="text" name="fnefone" size="18" onKeyPress="Mascara(this, Telefone);" onBlur="convertField(this);" maxlength="13">
                                        </div>
                                    </div>
                                </div>                                             
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Fax</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="fnefax" type="text" name="fnefax" size="18" onKeyPress="Mascara(this, Telefone);" onBlur="convertField(this);" maxlength="13">
                                        </div>
                                    </div>
                                </div>                        
                            </div>	
                            <div class="row row-space ">                                
                                <div class="col-1">
                                    <div class="input-group-small m-r-15">
                                        <label class="label">E-mail</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="fneemail" type="text" name="fneemail" size="50" maxlength=50 onkeyup="javascript:this.value = this.value.toUpperCase();">
                                        </div>
                                    </div>
                                </div>                                                          
                            </div>	
                            <label class="label"><b>Pessoas de Contato do Endereço do Representante (Nome/Telefone/E-mail)</b></label>
                            <div class="row row-space ">                                
                                <div class="col-3">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Contato 1</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="fccnome1" type="text" name="fccnome1" size="20" onkeyup="javascript:this.value = this.value.toUpperCase();" maxlength=13>
                                        </div>
                                    </div>
                                </div>                                             
                                <div class="col-3">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">&nbsp;</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="fccfone1" type="text" name="fccfone1" size="18" onKeyPress="Mascara(this, Telefone);" onBlur="convertField(this);" maxlength=13>
                                        </div>
                                    </div>
                                </div>       
                                <div class="col-3">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">&nbsp;</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="fccemail1" type="text" name="fccemail1" size="40" maxlength=50 onkeyup="javascript:this.value = this.value.toUpperCase();">
                                        </div>
                                    </div>
                                </div>    
                            </div>	
                            <div class="row row-space ">                                
                                <div class="col-3">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Contato 2</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="fccnome2" type="text" name="fccnome2" size="20" onkeyup="javascript:this.value = this.value.toUpperCase();" maxlength=13>
                                        </div>
                                    </div>
                                </div>                                             
                                <div class="col-3">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">&nbsp;</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="fccfone2" type="text" name="fccfone2" size="18" onKeyPress="Mascara(this, Telefone);" onBlur="convertField(this);" maxlength=13>
                                        </div>
                                    </div>
                                </div>       
                                <div class="col-3">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">&nbsp;</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="fccemail2" type="text" name="fccemail2" size="40" maxlength=50 onkeyup="javascript:this.value = this.value.toUpperCase();">
                                        </div>
                                    </div>
                                </div>    
                            </div>	
                            <div class="row row-space ">                                
                                <div class="col-3">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Contato 3</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="fccnome3" type="text" name="fccnome3" size="20" onkeyup="javascript:this.value = this.value.toUpperCase();" maxlength=13>
                                        </div>
                                    </div>
                                </div>                                             
                                <div class="col-3">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">&nbsp;</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="fccfone3" type="text" name="fccfone3" size="18" onKeyPress="Mascara(this, Telefone);" onBlur="convertField(this);" maxlength=13>
                                        </div>
                                    </div>
                                </div>       
                                <div class="col-3">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">&nbsp;</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="fccemail3" type="text" name="fccemail3" size="40" maxlength=50 onkeyup="javascript:this.value = this.value.toUpperCase();">
                                        </div>
                                    </div>
                                </div>    
                            </div>	
                            <label class="label"><b>Endereço de Fábrica</b></label>
                            <div class="row row-space ">                                
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">CEP</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="fnfcep" type="text" name="fnfcep" size="10" onkeyup="javascript:this.value = this.value.toUpperCase();" onBlur="pesquisacep2(this.value);" onkeypress='return SomenteNumero(event)' maxlength="8">
                                        </div>
                                    </div>
                                </div>                                             
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Número</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="fnfnumero" type="text" name="fnfnumero" size="10" maxlength="10">
                                        </div>
                                    </div>
                                </div>                        
                            </div>	
                            <div class="row row-space ">                                
                                <div class="col-1">
                                    <div class="input-group-small m-r-15">
                                        <label class="label">Endereço</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="fnfendereco" type="text" name="fnfendereco" size="50" onkeyup="javascript:this.value = this.value.toUpperCase();">
                                        </div>
                                    </div>
                                </div>  
                            </div>
                            <div class="row row-space ">                                
                                <div class="col-1">
                                    <div class="input-group-small m-r-15">
                                        <label class="label">Bairro</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="fnfbairro" type="text" name="fnfbairro" size="50" onkeyup="javascript:this.value = this.value.toUpperCase();" maxlength="30">
                                        </div>
                                    </div>
                                </div>                                                          
                            </div>	
                            <div class="row row-space ">   
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Cidade</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="fnfcidade" type="text" name="fnfcidade" size="50" disabled onkeyup="javascript:this.value = this.value.toUpperCase();">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">&nbsp;</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="fnfuf" type="text" name="fnfuf" size="3" disabled onkeyup="javascript:this.value = this.value.toUpperCase();"> 
                                        </div>
                                    </div>
                                </div>
                                <input id="fnfcodcidade" type="hidden" name="fnfcodcidade" size="3" disabled onkeyup="javascript:this.value = this.value.toUpperCase();">
                            </div>
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group-small">
                                        <label class="label">Cidade IBGE</label>                                        
                                        <div>                                          
                                            <span class="custom-dropdown">
                                                <select name="cidadeibge2" id="cidadeibge2" disabled>
                                                    <option id="cidcodigoibge2" value="0">___</option>                                                
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
                                </div>    
                            </div>
                            <div class="row row-space ">                                
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Fone</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="fnffone" type="text" name="fnffone" size="18" onKeyPress="Mascara(this, Telefone);" onBlur="convertField(this);" maxlength="13">
                                        </div>
                                    </div>
                                </div>                                             
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Fax</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="fnffax" type="text" name="fnffax" size="18" onKeyPress="Mascara(this, Telefone);" onBlur="convertField(this);" maxlength="13">
                                        </div>
                                    </div>
                                </div>                        
                            </div>	
                            <div class="row row-space ">                                
                                <div class="col-1">
                                    <div class="input-group-small m-r-15">
                                        <label class="label">E-mail</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="fnfemail" type="text" name="fnfemail" size="50" maxlength=50 onkeyup="javascript:this.value = this.value.toUpperCase();">
                                        </div>
                                    </div>
                                </div>                                                          
                            </div>	
                            <label class="label"><b>Pessoas de Contato do Endereço de Fábrica (Nome/Telefone/E-mail)</b></label>
                            <div class="row row-space ">                                
                                <div class="col-3">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Contato 1</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="fcfnome1" type="text" name="fcfnome1" size="20" onkeyup="javascript:this.value = this.value.toUpperCase();" maxlength=13>
                                        </div>
                                    </div>
                                </div>                                             
                                <div class="col-3">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">&nbsp;</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="fcffone1" type="text" name="fcffone1" size="18" onKeyPress="Mascara(this, Telefone);" onBlur="convertField(this);" maxlength=13>
                                        </div>
                                    </div>
                                </div>       
                                <div class="col-3">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">&nbsp;</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="fcfemail1" type="text" name="fcfemail1" size="40" maxlength=50 onkeyup="javascript:this.value = this.value.toUpperCase();">
                                        </div>
                                    </div>
                                </div>    
                            </div>	
                            <div class="row row-space ">                                
                                <div class="col-3">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Contato 2</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="fcfnome2" type="text" name="fcfnone2" size="20" onkeyup="javascript:this.value = this.value.toUpperCase();" maxlength=13>
                                        </div>
                                    </div>
                                </div>                                             
                                <div class="col-3">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">&nbsp;</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="fcffone2" type="text" name="fcffone2" size="18" onKeyPress="Mascara(this, Telefone);" onBlur="convertField(this);" maxlength=13>
                                        </div>
                                    </div>
                                </div>       
                                <div class="col-3">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">&nbsp;</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="fcfemail2" type="text" name="fcfemail2" size="40" maxlength=50 onkeyup="javascript:this.value = this.value.toUpperCase();">
                                        </div>
                                    </div>
                                </div>    
                            </div>	
                            <div class="row row-space ">                                
                                <div class="col-3">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Contato 3</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="fcfnome3" type="text" name="fcfnome3" size="20" onkeyup="javascript:this.value = this.value.toUpperCase();" maxlength=13>
                                        </div>
                                    </div>
                                </div>                                             
                                <div class="col-3">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">&nbsp;</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="fcffone3" type="text" name="fcffone3" size="18" onKeyPress="Mascara(this, Telefone);" onBlur="convertField(this);" maxlength=13>
                                        </div>
                                    </div>
                                </div>       
                                <div class="col-3">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">&nbsp;</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="fcfemail3" type="text" name="fcfemail3" size="40" maxlength=50 onkeyup="javascript:this.value = this.value.toUpperCase();">
                                        </div>
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

        <div style="display: none;">
            <tr style="display: none;">
                <td colspan="6">
                    <div align="center"><input name="button2" type="button" id="botao" onClick=valida_form(1) value="Incluir">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="button" id="botao2" onClick=limpa_form(1) value="Limpar"></div>
                    <input name="hidden" type="hidden" id="acao" value="inserir">
                </td>

            </tr>
        </div>


        <script src="js/fornecedorconsulta.js"></script>
        <script type="text/javascript">
                            var $a = jQuery.noConflict()
        </script>
        <script src="js/geral.js"></script>

        <script language="JavaScript1.2">
                            var tpfornecedor;
                            tpfornecedor = 1;
        </script>

    </body>

</html>

