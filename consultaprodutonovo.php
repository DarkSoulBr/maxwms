<?php
$flagmenu = 4;
if ($_GET["procod"] != "") {
    $procod = $_GET["procod"];
} else {
    $procod = '';
}
// Verificador de sessão
require("verifica.php");
$usuario = $_SESSION["id_usuario"];

//Verifica se a opção existe no Cadastros de Opção
$opcao = 'CONSULTA';
$pagina = 'consultaProduto.php';
$modulo = 4;  //Cadastros
$sub = 18;  //Produtos
$usuario = $_SESSION["id_usuario"];

include 'include/jquerymax.php';
include 'include/css.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <!-- Required meta tags-->    
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Title Page-->
        <title>Cadastro de Produtos - Consulta</title>        

        <!-- maxnew CSS-->
        <link href="css/max.css" rel="stylesheet" media="all">        
    </head>

    <body onLoad="ver('<?= $procod; ?>');">
        <div id="retorno"></div>
        <div id="dialog" style="margin-left: 5px; margin-left: 5px;"></div>
        <div class="result" id="MsgResultado2"></div>
        <div class="bg-gray p-t-10 p-b-100 font-lucida">
            <div class="wrapper wrapper--w960">
                <div class="card card-4">
                    <div class="card-header">
                        Cadastro de Produtos - Consulta
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
                                            <label class="radio-container m-r-15">Produto
                                                <input type="radio" id="radio2" name="radiobutton" value="radiobutton">
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container">Referência
                                                <input type="radio" id="radio3" name="radiobutton" value="radiobutton">
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
                                            <input class="input--style-4" id="pesquisa" type="text" name="pesquisa" size="50" onBlur="convertField(this);dadospesquisa(pesquisa.value);" OnKeyPress="formatar2('####-#', this);maiusculo();">
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
                                                    <option id="opcoes" value="0">Faça a Pesquisa de Campo</option>                                                
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                            <div class="row row-space ">                                
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Código</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="procod" type="text" name="procod" size="10" onKeyPress="maiusculo()" disabled>
                                        </div>
                                    </div>
                                </div>                                             
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">C.VTEX</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="procodigo" type="text" name="procodigo" size="10" onKeyPress="maiusculo()" disabled>
                                        </div>
                                    </div>
                                </div>                        
                            </div>	     
                            <div class="row row-space ">                                
                                <div class="col-1">
                                    <div class="input-group-small m-r-15">
                                        <label class="label">Produto</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="prnome" type="text" name="prnome" size="60" onKeyPress="maiusculo()" onBlur="convertField(this)" maxlength="60">
                                        </div>
                                    </div>
                                </div>     
                            </div>
                            <div class="row row-space ">                                
                                <div class="col-1">
                                    <div class="input-group-small m-r-15">
                                        <label class="label">Descrição</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="prnome2" type="text" name="prnome2" size="60" onKeyPress="maiusculo()" onBlur="convertField(this)" maxlength="120">
                                        </div>
                                    </div>
                                </div>     
                            </div>
                            <div class="row row-space ">                                
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Ref.Forn.Vtex</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="proref" type="text" name="proref" size="40" maxlength="20" onKeyPress="maiusculo()" onBlur="convertField(this)">
                                        </div>
                                    </div>
                                </div>                                                        
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Ref.Fornecedor</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="prodesc2" type="text" name="prodesc2" size="40" maxlength="20" onKeyPress="maiusculo()" onBlur="convertField(this)">
                                        </div>
                                    </div>
                                </div>     
                            </div>
                            <div class="row row-space">
                                <div class="col-2">
                                    <div class="input-group-small">
                                        <label class="label">Grupo (Cat.1)</label>                                        
                                        <div>                                          
                                            <span class="custom-dropdown">
                                                <select name="listgrupos" onChange="dadospesquisasubgrupo(this.value, 0)">
                                                    <option id="opcoes2" value="0">Faça a Pesquisa de Grupo</option>                                                
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
                                </div>           
                                <div class="col-2">
                                    <div class="input-group-small">
                                        <label class="label">Subgr. (Cat.2)</label>                                        
                                        <div>                                          
                                            <span class="custom-dropdown">
                                                <select name="listsubgrupos" onChange="dadospesquisalinha(this.value, 0)">
                                                    <option id="opcoes3" value="0">Faça a Pesquisa de Subgrupo</option>                                                
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
                                </div>         
                            </div>
                            <div class="row row-space">
                                <div class="col-2">
                                    <div class="input-group-small">
                                        <label class="label">Linha (Cat.3)</label>                                        
                                        <div>                                          
                                            <span class="custom-dropdown">
                                                <select name="listlinhas">
                                                    <option id="opcoes6" value="0">Faça a Pesquisa de Linha</option>                                                
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
                                </div>           
                                <div class="col-2">
                                    <div class="input-group-small">
                                        <label class="label">Marca</label>                                        
                                        <div>                                          
                                            <span class="custom-dropdown">
                                                <select name="listmarcas">
                                                    <option id="opcoes4" value="0">Faça a Pesquisa de Marca</option>                                                
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
                                </div>         
                            </div>
                            <div class="row row-space">
                                <div class="col-2">
                                    <div class="input-group-small">
                                        <label class="label">Fornecedor</label>                                        
                                        <div>                                          
                                            <span class="custom-dropdown">
                                                <select name="listfornecedores" onChange="dadosfor(this.value);">
                                                    <option id="opcoes12" value="0">Faça a Pesquisa de Fornecedor</option>                                                
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
                                </div>       
                                <div class="col-2">
                                    <div class="input-group-small">
                                        <label class="label">Licença</label>                                        
                                        <div>                                          
                                            <span class="custom-dropdown">
                                                <select name="listsubmarcas">
                                                    <option id="opcoes5" value="0">Faça a Pesquisa de Licença</option>                                                
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
                                </div>    
                            </div>
                            <div class="row row-space">
                                <div class="col-2">
                                    <div class="input-group-small">
                                        <label class="label">Status</label>                                        
                                        <div>                                          
                                            <span class="custom-dropdown">
                                                <select name="liststatus">
                                                    <option id="opcoes7" value="0">Faça a Pesquisa de Status</option>                                                
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
                                </div>       
                                <div class="col-2">
                                    <div class="input-group-small">
                                        <label class="label">Faixa Etária</label>                                        
                                        <div>                                          
                                            <span class="custom-dropdown">
                                                <select name="listfaixas">
                                                    <option id="opcoes8" value="0">Faça a Pesquisa de F. Etária</option>                                                
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
                                </div>    
                            </div>
                            <div class="row row-space">
                                <div class="col-2">
                                    <div class="input-group-small">
                                        <label class="label">Cor</label>                                        
                                        <div>                                          
                                            <span class="custom-dropdown">
                                                <select name="listcores">
                                                    <option id="opcoes13" value="0">Faça a Pesquisa de Cor</option>                                                
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
                                </div>       
                                <div class="col-2">
                                    <div class="input-group-small">
                                        <label class="label">Un.Medida</label>                                        
                                        <div>                                          
                                            <span class="custom-dropdown">
                                                <select name="listmedidas" id="listmedidas">
                                                    <option id="opcoes9" value="0">Faça a Pesquisa de Un.Medida</option>                                                
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
                                </div>    
                            </div>
                            <div class="row row-space ">                                
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Embalagem</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="proemb" type="text" name="proemb" size="18" onKeyPress="return soNums(event);">
                                        </div>
                                    </div>
                                </div>   
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Sexo</label>
                                        <div>
                                            <label class="radio-container m-r-15">Unisex                                               
                                                <input name="radiobutton2" id="radio21" type="radio" value="radiobutton" checked>
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container m-r-15">Masculino
                                                <input type="radio" name="radiobutton2" id="radio22" value="radiobutton">
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container">Feminino
                                                <input type="radio" name="radiobutton2" id="radio23" value="radiobutton">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-space ">                                
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Ult. Entrega</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="cidnome222" type="text" name="cidnome22" size="18" disabled>
                                        </div>
                                    </div>
                                </div>   
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Validade</label>
                                        <div>
                                            <label class="radio-container m-r-15">Sim                                              
                                                <input name="radiobutton3" id="radio31" type="radio" value="radiobutton" checked>
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container">Não
                                                <input type="radio" id="radio32" name="radiobutton3" value="radiobutton">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group-small">
                                        <label class="label">Sit.Tributária</label>                                        
                                        <div>                                          
                                            <span class="custom-dropdown">
                                                <select name="listtributos">
                                                    <option id="opcoes10" value="0">Faça a Pesquisa de Sit.</option>                                                
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
                                </div>  
                            </div>
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group-small">
                                        <label class="label">&nbsp;</label>                                        
                                        <div>                                          
                                            <span class="custom-dropdown">
                                                <select name="listtributos2">
                                                    <option id="opcoes12" value="0">Faça a Pesquisa</option>                                                
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
                                </div>    
                            </div>
                            <div class="row row-space">
                                <div class="col-2">
                                    <div class="input-group-small">
                                        <label class="label">Procedência</label>                                        
                                        <div>                                          
                                            <span class="custom-dropdown">
                                                <select name="listprocedencia">
                                                    <option id="opcoesproc" value="0">Faça a Pesquisa de Sit.</option> (4-5 Destaca IPI)                                               
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
                                </div>       
                                <div class="col-2">
                                    <div class="input-group-small">
                                        <label class="label">Cl. Fiscal</label>                                        
                                        <div>                                          
                                            <span class="custom-dropdown">
                                                <select name="listfiscais" onChange="dadosfiscal(this.value);">
                                                    <option id="opcoes11" value="0">Faça a Pesquisa de Cl. Fiscal</option>                                                
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
                                </div>    
                            </div>
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">ICMS</label>
                                        <div>
                                            <label class="radio-container m-r-15">Sim                                                
                                                <input name="radiobuttonicms" id="radioicmss" type="radio" value="radiobutton" checked>
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container m-r-15">Não                                                
                                                <input name="radiobuttonicms" id="radioicmsn" type="radio" value="radiobutton">
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container">Especial (12% Sul-Sud 7% Out)
                                                <input name="radiobuttonicms" id="radioicmse" type="radio" value="radiobutton">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-space ">                                
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">IPI Venda</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="proipiven" type="text" name="proipiven" size="18" disabled>
                                        </div>
                                    </div>
                                </div>                                             
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">IPI Compra</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="proipi" type="text" name="proipi" size="18" onKeyPress="return soNums(event);">
                                        </div>
                                    </div>
                                </div>                        
                            </div>	  
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Tipo Compra</label>
                                        <div>
                                            <label class="radio-container m-r-15">Normal                                              
                                                <input name="radiobuttoncompra" id="radiocompran" type="radio" value="radiobutton" checked>
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container m-r-15">Pré-Venda                                               
                                                <input name="radiobuttoncompra" id="radiocomprap" type="radio" value="radiobutton">
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container">Cross Docking
                                                <input name="radiobuttoncompra" id="radiocomprac" type="radio" value="radiobutton">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <label class="label"><b>Sortimentos</b></label>
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Tipo</label>
                                        <div>
                                            <label class="radio-container m-r-15">Normal                                              
                                                <input name="radiobuttonsort" id="radiosorts" type="radio" value="radiobuttonsort" checked onClick="verificasort(this.value);">
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container m-r-15">Master                                            
                                                <input name="radiobuttonsort" id="radiosortn" type="radio" value="radiobuttonsort" onClick="verificasort(this.value);">
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container">Sortimento
                                                <input name="radiobuttonsort" id="radiosorte" type="radio" value="radiobuttonsort" onClick="verificasort(this.value);">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-space" style="display: none">
                                <div class="col-1">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Opção</label>
                                        <div>
                                            <label class="radio-container m-r-15">Código                                             
                                                <input name="sortradiobutton" id="sortradio1" type="radio" value="sortradiobutton" checked disabled>
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container m-r-15">Produto                                         
                                                <input type="radio" id="sortradio2" name="sortradiobutton" value="sortradiobutton" disabled>
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container">Referência
                                                <input type="radio" id="sortradio3" name="sortradiobutton" value="sortradiobutton" disabled>
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-space" style="display: none">                                
                                <div class="col-2">
                                    <div class="input-group-small">
                                        <label class="label">Pesquisar</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="sortpesquisa" type="text" name="sortpesquisa" size="50" onBlur="convertField(this);sortdadospesquisa(sortpesquisa.value);" OnKeyPress="sortformatar2('####-#', this);maiusculo();" disabled>
                                        </div>
                                    </div>
                                </div>                                
                                <div class="col-3">
                                    <div class="input-group-small">
                                        <label class="label">&nbsp;</label>
                                        <div class="input-group-icon centraliza">
                                            <button class="btn-small btn--radius-2 btn--blue" name="sortbutton" type="button" id="sortbutton" onClick="sortdadospesquisa(sortpesquisa.value);" disabled>Pesquisar</button>
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
                                                <select name="sortlistDados" id="sortlistDados" onChange="sortdadospesquisa2(this.value);" disabled>
                                                    <option id="sortopcoes" value="0">Faça a Pesquisa de Campo</option>                                                
                                                </select> 
                                            </span>
                                            <input id="sortprocodigo" type="hidden" name="sortprocodigo" size="25">
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                            <div class="row row-space ">                                
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">C.Master</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="sortprocod" type="text" name="sortprocod" size="10" onKeyPress="maiusculo()" disabled>
                                        </div>
                                    </div>
                                </div>                                                              
                            </div>	  
                            <div class="row row-space ">                                
                                <div class="col-1">
                                    <div class="input-group-small m-r-15">
                                        <label class="label">Produto</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="sortprnome" type="text" name="sortprnome" size="60" onKeyPress="maiusculo()" onBlur="convertField(this)" maxlength="60" disabled>
                                        </div>
                                    </div>
                                </div>                                                              
                            </div>	  
                            <label class="label"><b>Condição de Venda</b></label>
                            <div class="row row-space ">                                
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Preço de %</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="promedio" type="text" name="promedio" size="16" onKeyPress="return soNums(event);">
                                        </div>
                                    </div>
                                </div>        
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Preço por %</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="promenor" type="text" name="promenor" size="16" onKeyPress="return soNums(event);">
                                        </div>
                                    </div>
                                </div>                                                         
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Data Inicio</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="datainicio" type="text" name="datainicio" size="16" maxlength="10" OnKeyPress="formatar('##/##/####', this)" onBlur="dataano(this, this.value)">
                                        </div>
                                    </div>
                                </div>        
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Data Final</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="datafinal" type="text" name="datafinal" size="16" maxlength="10" OnKeyPress="formatar('##/##/####', this)" onBlur="dataano(this, this.value)">
                                        </div>
                                    </div>
                                </div>     
                            </div>	  
                            <div class="row row-space ">                                
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Pr. Mínimo%</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="prominimo" type="text" name="prominimo" size="16" onKeyPress="return soNums(event);">
                                        </div>
                                    </div>
                                </div>        
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Varejo %</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="promenord" type="text" name="promenord" size="16" onKeyPress="return soNums(event);">
                                        </div>
                                    </div>
                                </div>                                                     
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Custo Real</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="proreal" type="text" name="proreal" size="16" onKeyPress="return soNums(event);" onBlur="calculapreco(this.value, promedio.value, promaior.value, promenor.value, prominimo.value, promenord.value);">
                                        </div>
                                    </div>
                                </div>        
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">C.Final</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="profinal" type="text" name="profinal" size="16" onKeyPress="return soNums(event);">
                                        </div>
                                    </div>
                                </div>     
                            </div>	  
                            <label class="label"><b>Preço de Venda</b></label>
                            <div class="row row-space ">                                    
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Preço De</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="precob" type="text" name="precob" size="16" onKeyPress="return soNums(event);" onBlur="calculafator(this.value, proreal.value);">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Preço Por</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="precoc" type="text" name="precoc" size="16" onKeyPress="return soNums(event);" onBlur="calculapercc(this.value, precob.value);">
                                        </div>
                                    </div>
                                </div>                                                                
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">P. Mínimo</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="precominimo" type="text" name="precominimo" size="16" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Varejo</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="precod" type="text" name="precod" size="16" disabled>
                                        </div>
                                    </div>
                                </div>    
                            </div>	  
                            <label class="label"><b>Custos Reais Anteriores</b></label>
                            <div class="row row-space ">                                    
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Anterior</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="custoa1" type="text" name="custoa1" size="8" onKeyPress="return soNums(event);" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Custo</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="custo1" type="text" name="custo1" size="8" onKeyPress="return soNums(event);" disabled>
                                        </div>
                                    </div>
                                </div>    
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Usuário</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="usuario1" type="text" name="usuario1" size="10" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Data</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="data1" type="text" name="data1" size="21" disabled>
                                        </div>
                                    </div>
                                </div>    
                            </div>	  
                            <div class="row row-space ">                                    
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">                                        
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="custoa2" type="text" name="custoa2" size="8" onKeyPress="return soNums(event);" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">                                        
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="custo2" type="text" name="custo2" size="8" onKeyPress="return soNums(event);" disabled>
                                        </div>
                                    </div>
                                </div>    
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">                                        
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="usuario2" type="text" name="usuario2" size="10" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">                                        
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="data2" type="text" name="data2" size="21" disabled>
                                        </div>
                                    </div>
                                </div>    
                            </div>	  
                            <div class="row row-space ">                                    
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">                                        
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="custoa3" type="text" name="custoa3" size="8" onKeyPress="return soNums(event);" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">                                        
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="custo3" type="text" name="custo3" size="8" onKeyPress="return soNums(event);" disabled>
                                        </div>
                                    </div>
                                </div>    
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">                                        
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="usuario3" type="text" name="usuario3" size="10" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">                                        
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="data3" type="text" name="data3" size="21" disabled>
                                        </div>
                                    </div>
                                </div>    
                            </div>	  
                            <label class="label"><b>Código de Barras</b></label>
                            <div class="row row-space ">                                    
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Unidade</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="barunidade" type="text" name="barunidade" size="16" maxlength="13">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Caixa</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="barcaixa" type="text" name="barcaixa" size="16" maxlength="14">
                                        </div>
                                    </div>
                                </div>    
                            </div>	
                            <label class="label"><b>Cubagem</b></label>
                            <label class="label"><b>Cubagem Produto</b></label>
                            <label class="label"><b>Caixa Unitária</b></label>
                            <div class="row row-space ">                                    
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Altura (Metro)</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="proaltura" type="text" name="proaltura" size="12" onKeyPress="return soNums(event);" style="BACKGROUND-COLOR: #f71963; COLOR: #660000; FONT-WEIGHT: bold;">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Largura (Metro)</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="prolargura" type="text" name="prolargura" size="12" onKeyPress="return soNums(event);" style="BACKGROUND-COLOR: #f71963; COLOR: #660000; FONT-WEIGHT: bold;"> 
                                        </div>
                                    </div>
                                </div>                                                          
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Comprimento (Metro)</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="procompr" type="text" name="procompr" size="12" onKeyPress="return soNums(event);" style="BACKGROUND-COLOR: #f71963; COLOR: #660000; FONT-WEIGHT: bold;"> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Peso (Quilo)</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="propeso" type="text" name="propeso" size="12" onKeyPress="return soNums(event);" style="BACKGROUND-COLOR: #f71963; COLOR: #660000; FONT-WEIGHT: bold;"> 
                                        </div>
                                    </div>
                                </div>    
                            </div>	
                            <label class="label"><b>Cubagem Produto (Fora da Caixa)</b></label>
                            <label class="label"><b>Site TM / MP</b></label>
                            <div class="row row-space ">                                    
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Altura (Metro)</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="proaltcx" type="text" name="proaltcx" size="12" onKeyPress="return soNums(event);" style="BACKGROUND-COLOR: #9900cf; COLOR: #660000; FONT-WEIGHT: bold;">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Largura (Metro)</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="prolarcx" type="text" name="prolarcx" size="12" onKeyPress="return soNums(event);" style="BACKGROUND-COLOR: #9900cf; COLOR: #660000; FONT-WEIGHT: bold;"> 
                                        </div>
                                    </div>
                                </div>                                                               
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Comprimento (Metro)</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="procomcx" type="text" name="procomcx" size="12" onKeyPress="return soNums(event);" style="BACKGROUND-COLOR: #9900cf; COLOR: #660000; FONT-WEIGHT: bold;"> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Peso (Quilo)</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="propescx" type="text" name="propescx" size="12" onKeyPress="return soNums(event);" style="BACKGROUND-COLOR: #9900cf; COLOR: #660000; FONT-WEIGHT: bold;"> 
                                        </div>
                                    </div>
                                </div>    
                            </div>	
                            <label class="label"><b>Dados para Internet</b></label>
                            <div class="row row-space ">                                    
                                <div class="col-1">
                                    <div class="input-group-small m-r-15">
                                        <label class="label">Descrição</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="prodesc1" type="text" name="prodesc1" size="60" onKeyPress="maiusculo()" onBlur="convertField(this)"> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-space ">                                    
                                <div class="col-1">
                                    <div class="input-group-small m-r-15">
                                        <label class="label">URL Imagem</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="prodesc3" type="text" name="prodesc3" size="60" onBlur="atualizaimagem(this.value)"> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-space ">                                    
                                <div class="col-1">
                                    <div align="center" id="produtos">
                                        <a id="linkUrl">
                                            <img src="./produtos/figura0.jpg" id="imagem" width="300" height="300" alt="" />
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-space ">                                    
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Promoção%</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="properc" type="text" name="properc" size="16" onKeyPress="return soNums(event);"> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Pr. Valor</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="proval" type="text" name="proval" size="16" onKeyPress="return soNums(event);"> 
                                        </div>
                                    </div>
                                </div>    
                            
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Internet</label>
                                        <div>
                                            <label class="radio-container m-r-15">Sim                                               
                                                <input name="radiobutton4" id="radio41" type="radio" value="radiobutton" checked>
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container">Não 
                                                <input type="radio" id="radio42" name="radiobutton4" value="radiobutton">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Ativo</label>
                                        <div>
                                            <label class="radio-container m-r-15">Sim                                                
                                                <input name="radiobutton5" id="radio51" type="radio" value="radiobutton" checked>
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container">Não 
                                                <input type="radio" id="radio52" name="radiobutton5" value="radiobutton">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-space">
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Sob Consulta</label>
                                        <div>
                                            <label class="radio-container m-r-15">Sim                                                
                                                <input name="radiobutton6" id="radio61" type="radio" value="radiobutton" checked>
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container">Não 
                                                <input type="radio" id="radio62" name="radiobutton6" value="radiobutton">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Esgotado</label>
                                        <div>
                                            <label class="radio-container m-r-15">Sim                                               
                                                <input name="radiobutton7" id="radio71" type="radio" value="radiobutton" checked>
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container">Não 
                                                <input type="radio" id="radio72" name="radiobutton7" value="radiobutton">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Presente</label>
                                        <div>
                                            <label class="radio-container m-r-15">Sim                                                
                                                <input name="radiobutton8" id="radio81" type="radio" value="radiobutton" checked>
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container">Não 
                                                <input type="radio" id="radio82" name="radiobutton8" value="radiobutton">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Acréscimo</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="proacres" type="text" name="proacres" size="16" onKeyPress="return soNums(event);"> 
                                        </div>
                                    </div>
                                </div>   
                            </div>
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Midia</label>
                                        <div>
                                            <label class="radio-container m-r-15">Sim                                                
                                                <input name="radiobutton9" id="radio91" type="radio" value="radiobutton" checked>
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container">Não 
                                                <input type="radio" id="radio92" name="radiobutton9" value="radiobutton">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group-small m-r-15">
                                        <div class="input-group-small-icon">
                                            <textarea class="textarea--style-4" name="prodescs" id="prodescs" cols="70"></textarea>                                                             
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group-small m-r-15">
                                        <label class="label">Descrição VTEX</label>
                                        <div class="input-group-small-icon">
                                            <textarea class="textarea--style-4" name="procarac" id="procarac" cols="70"></textarea>                                                             
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-space">                                
                                <div class="col-0">
                                    <div class="p-t-15 centraliza">
                                        <button class="btn btn--radius-2 btn--blue" name="button_limpa" type="button" id="botao_limpa" onClick="limpar_produto()">Cancelar</button>
                                    </div>
                                </div>
                                
                            </div> 								
                        </form>
                    </div>
                </div>                
            </div>
        </div>
        <div class="result" id="MsgResultado"></div>


        <div style="display:none">
            <div class="col-3">
                                    <div class="p-t-15 centraliza">                                        
                                        <button class="btn btn--radius-2 btn--green" name="button_vtex" type="button" id="botao_vtex" onClick="vtex_produto()">Dados Vtex</button>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="p-t-15 centraliza">                                        
                                        <button class="btn btn--radius-2 btn--red" name="button_img" type="button" id="botao_img" onClick="vtex_imagens()">Imagens Vtex</button>
                                    </div>
                                </div>
            <tr> 
                <td>&nbsp;</td>                
                <td>
                    <div id="h2" hidden >
                        Cobrar S.T.:
                    </div>
                </td>				
                <td>
                    <div id="h2" hidden >
                        <input name="radiobuttonst" id="radiosts" type="radio" value="radiobutton">
                        Sim 
                        <input name="radiobuttonst" id="radiostn" type="radio" value="radiobutton" checked>
                        N&atilde;o
                    </div>
                </td>
                <td>&nbsp;</td>
            </tr>

            <tr style="display: none;">
                <td>&nbsp;</td>
                <td>
                    <div align="center">
                        <input name="button2" type="button" id="botao" onClick=valida_form() value="Incluir" disabled>
                    </div>
                </td>
                <td colspan="3">
                    <div align="center">
                        <input name="button" type="button" id="botao2" onClick=limpa_form() value="Limpar" disabled>
                    </div>
                </td>
                <td>
                    <div align="center">
                        <input name="button" type="button" id="botao3" onClick=verifica() value="Excluir" disabled>
                    </div>
                    <input name="hidden" type="hidden" id="acao" value="inserir">
                </td>
            </tr>

            <tr style="display: none;">
                <td bgcolor="#CCCCCC">&nbsp;</td>
                <td>Cubagem Cx:</td>
                <td><input id="procubcx" type="text" name="procubcx" size="16" onKeyPress="return soNums(event);"></td>
                <td>&nbsp;</td>
            </tr>

            <tr style="display: none;">
                <td>&nbsp;</td>
                <td>Pre&ccedil;o A:</td>
                <td><input id="precoa" type="text" name="precoa" size="16" disabled></td>
                <td>
                    <div align="right"></div>
                </td>
                <td></td>
                <td>&nbsp;</td>
            </tr>

            <tr style="display: none;">
                <td bgcolor="#CCCCCC">&nbsp;</td>
                <td>Pre&ccedil;o A %:</td>
                <td><input id="promaior" type="text" name="promaior" size="16" onKeyPress="return soNums(event);"></td>
                <td>
                    <div align="right"></div>
                </td>
                <td></td>
                <td>&nbsp;</td>
            </tr>

            <tr style="display: none;">
                <td>&nbsp;</td>
                <td>Custo Real (V):</td>
                <td><input id="prorealv" type="text" name="prorealv" size="16" onKeyPress="return soNums(event);"></td>
                <td>
                    <div align="right">C.Final (V):</div>
                </td>
                <td><input id="profinalv" type="text" name="profinalv" size="16" onKeyPress="return soNums(event);"></td>
                <td>&nbsp;</td>
            </tr>
            <tr style="display: none;">
                <td>&nbsp;</td>
                <td>Custo Real (L):</td>
                <td><input id="proreall" type="text" name="proreall" size="16" onKeyPress="return soNums(event);"></td>
                <td>
                    <div align="right">C.Final (L):</div>
                </td>
                <td><input id="profinall" type="text" name="profinall" size="16" onKeyPress="return soNums(event);"></td>
                <td>&nbsp;</td>
            </tr>


            <tr style="display: none;">
                <td>&nbsp;</td>
                <td>Custo Real (G):</td>
                <td><input id="prorealg" type="text" name="prorealg" size="16" onKeyPress="return soNums(event);"></td>
                <td>
                    <div align="right">C.Final (G):</div>
                </td>
                <td><input id="profinalg" type="text" name="profinalg" size="16" onKeyPress="return soNums(event);"></td>
                <td>&nbsp;</td>
            </tr>

            <tr style="display: none;">
                <td bgcolor="#3366CC">&nbsp;</td>
                <td colspan="5" bgcolor="#3366CC">
                    <div align="center">
                        <font color="#FFFFFF">Custos Reais (V) Anteriores</font>
                    </div>
                </td>
            </tr>

            <tr style="display: none;">
                <td>&nbsp;</td>
                <td colspan="5">Anterior:
                    <input id="vcustoa1" type="text" name="vcustoa1" size="8" onKeyPress="return soNums(event);" disabled>
                    Custo:
                    <input id="vcusto1" type="text" name="vcusto1" size="8" onKeyPress="return soNums(event);" disabled>
                    Usuario:
                    <input id="vusuario1" type="text" name="vusuario1" size="10" disabled>
                    Data:
                    <input id="vdata1" type="text" name="vdata1" size="21" disabled>
                </td>

            </tr>

            <tr style="display: none;">
                <td>&nbsp;</td>
                <td colspan="5">Anterior:
                    <input id="vcustoa2" type="text" name="vcustoa2" size="8" onKeyPress="return soNums(event);" disabled>
                    Custo:
                    <input id="vcusto2" type="text" name="vcusto2" size="8" onKeyPress="return soNums(event);" disabled>
                    Usuario:
                    <input id="vusuario2" type="text" name="vusuario2" size="10" disabled>
                    Data:
                    <input id="vdata2" type="text" name="vdata2" size="21" disabled>
                </td>

            </tr>

            <tr style="display: none;">
                <td>&nbsp;</td>
                <td colspan="5">Anterior:
                    <input id="vcustoa3" type="text" name="vcustoa3" size="8" onKeyPress="return soNums(event);" disabled>
                    Custo:
                    <input id="vcusto3" type="text" name="vcusto3" size="8" onKeyPress="return soNums(event);" disabled>
                    Usuario:
                    <input id="vusuario3" type="text" name="vusuario3" size="10" disabled>
                    Data:
                    <input id="vdata3" type="text" name="vdata3" size="21" disabled>
                </td>

            </tr>


            <tr style="display: none;">
                <td bgcolor="#3366CC">&nbsp;</td>
                <td colspan="5" bgcolor="#3366CC">
                    <div align="center">
                        <font color="#FFFFFF">Custos Reais (L) Anteriores</font>
                    </div>
                </td>
            </tr>

            <tr style="display: none;">
                <td>&nbsp;</td>
                <td colspan="5">Anterior:
                    <input id="lcustoa1" type="text" name="lcustoa1" size="8" onKeyPress="return soNums(event);" disabled>
                    Custo:
                    <input id="lcusto1" type="text" name="lcusto1" size="8" onKeyPress="return soNums(event);" disabled>
                    Usuario:
                    <input id="lusuario1" type="text" name="lusuario1" size="10" disabled>
                    Data:
                    <input id="ldata1" type="text" name="ldata1" size="21" disabled>
                </td>

            </tr>

            <tr style="display: none;">
                <td>&nbsp;</td>
                <td colspan="5">Anterior:
                    <input id="lcustoa2" type="text" name="lcustoa2" size="8" onKeyPress="return soNums(event);" disabled>
                    Custo:
                    <input id="lcusto2" type="text" name="lcusto2" size="8" onKeyPress="return soNums(event);" disabled>
                    Usuario:
                    <input id="lusuario2" type="text" name="lusuario2" size="10" disabled>
                    Data:
                    <input id="ldata2" type="text" name="ldata2" size="21" disabled>
                </td>

            </tr>

            <tr style="display: none;">
                <td>&nbsp;</td>
                <td colspan="5">Anterior:
                    <input id="lcustoa3" type="text" name="lcustoa3" size="8" onKeyPress="return soNums(event);" disabled>
                    Custo:
                    <input id="lcusto3" type="text" name="lcusto3" size="8" onKeyPress="return soNums(event);" disabled>
                    Usuario:
                    <input id="lusuario3" type="text" name="lusuario3" size="10" disabled>
                    Data:
                    <input id="ldata3" type="text" name="ldata3" size="21" disabled>
                </td>

            </tr>




            <tr style="display: none;">
                <td bgcolor="#3366CC">&nbsp;</td>
                <td colspan="5" bgcolor="#3366CC">
                    <div align="center">
                        <font color="#FFFFFF">Custos Reais (G) Anteriores</font>
                    </div>
                </td>
            </tr>

            <tr style="display: none;">
                <td>&nbsp;</td>
                <td colspan="5">Anterior:
                    <input id="gcustoa1" type="text" name="gcustoa1" size="8" onKeyPress="return soNums(event);" disabled>
                    Custo:
                    <input id="gcusto1" type="text" name="gcusto1" size="8" onKeyPress="return soNums(event);" disabled>
                    Usuario:
                    <input id="gusuario1" type="text" name="gusuario1" size="10" disabled>
                    Data:
                    <input id="gdata1" type="text" name="gdata1" size="21" disabled>
                </td>

            </tr>

            <tr style="display: none;">
                <td>&nbsp;</td>
                <td colspan="5">Anterior:
                    <input id="gcustoa2" type="text" name="gcustoa2" size="8" onKeyPress="return soNums(event);" disabled>
                    Custo:
                    <input id="gcusto2" type="text" name="gcusto2" size="8" onKeyPress="return soNums(event);" disabled>
                    Usuario:
                    <input id="gusuario2" type="text" name="gusuario2" size="10" disabled>
                    Data:
                    <input id="gdata2" type="text" name="gdata2" size="21" disabled>
                </td>

            </tr>

            <tr style="display: none;">
                <td>&nbsp;</td>
                <td colspan="5">Anterior:
                    <input id="gcustoa3" type="text" name="gcustoa3" size="8" onKeyPress="return soNums(event);" disabled>
                    Custo:
                    <input id="gcusto3" type="text" name="gcusto3" size="8" onKeyPress="return soNums(event);" disabled>
                    Usuario:
                    <input id="gusuario3" type="text" name="gusuario3" size="10" disabled>
                    Data:
                    <input id="gdata3" type="text" name="gdata3" size="21" disabled>
                </td>

            </tr>
        </div>

        <script src="js/produto.js"></script>
        <script type="text/javascript">
                        var $a = jQuery.noConflict()
        </script>

        <script type='text/javascript'>
            var usuario = <?php echo $usuario ?>;
        </script>

    </body>

</html>

