<?php
$flagmenu = 5;
// Verificador de sessão
require("verifica.php");

$usuario = $_SESSION["id_usuario"];

?>
<!DOCTYPE html>
<html>
    <head>
        <!-- Required meta tags-->    
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Title Page-->
        <title>Relatório Gerencial de Contagem de Estoque</title>        

        <!-- maxnew CSS-->
        <link href="css/max.css" rel="stylesheet" media="all">        
    </head>

    <body onload="dadospesquisadata(0);">
        <div id="retorno"></div>
        <div id="dialog" style="margin-left: 5px; margin-left: 5px;"></div>
        <div class="bg-gray p-t-10 p-b-100 font-lucida">
            <div class="wrapper wrapper--w680">
                <div class="card card-4">
                    <div class="card-header">
                        Relatório Gerencial de Contagem de Estoque
                    </div>
                    <div class="card-body">                    
                        <form method="POST"> 
                            <div class="row row-space ">                                
                                <div class="col-2">
                                    <div class="input-group">
                                        <label class="label">Data</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" name="pvemissao" type="text" id="pvemissao" onKeyPress="maiusculo()" size="10" disabled="disabled">
                                        </div>
                                    </div>
                                </div>                                                           
                            </div>	               								
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group">
                                        <label class="label">Contagem</label>                                        
                                        <div  id="resultado4">                                          
                                            <span class="custom-dropdown">
                                                <select id="estoque" name="estoque" size="1">
                                                    <option value="0">-- Escolha uma Contagem --</option>                                                
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                            <div class="col-1">
                                <div class="input-group m-r-45">
                                    <label class="label">Setor</label>
                                    <div>
                                        <label class="radio-container m-r-15">Sim                                                
                                            <input id="radio1" name="radiobutton" type="radio" value="radiobutton">
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="radio-container">Não
                                            <input id="radio2" name="radiobutton" type="radio" value="radiobutton" checked>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="p-t-15 centraliza">
                                <button class="btn btn--radius-2 btn--blue" type="button" id="botao" onclick="imprelatorioexexcel();">Excel</button>
                            </div>								
                        </form>
                    </div>
                </div>                
            </div>
        </div>

        <div style="display:none;">
            <tr bgcolor="#CCCCCC" style="display:none;">
                <td height="25" width="5">&nbsp;</td>
                <td valign="middle" align="left" width="600" colspan="3">&nbsp;<a href="javascript:addgrupo();" style="text-decoration:underline;color:#000000;"><b>&curren; Adicionar Grupo</b></a></td>
            </tr>
            <tr id="lin1" style="display:none;" bgcolor="#CCCCCC">
                <td height="45" width="5">&nbsp;</td>
                <td valign="middle" align="center" width="280"><b>Selecione o(s) Grupo(s):</b>
                    <br><div id="resultado2"><select id="grupo" name="grupo" size="1"><option value="0">-- Escolha um Grupo --</option></select></div></td>
                <td valign="middle" align="center"><a href="javascript:insertBeforeSelected('grupo','13','grupo_selecionados');"><img src="images/add.jpg" border="0"></a>
                    <br><br><br><a href="javascript:removeOption('46','grupo_selecionados');"><img src="images/remove.jpg" border="0"></a></td>
                <td valign="middle" align="center" width="300"><b>Grupos Selecionados:</b>
                    <br><select id="grupo_selecionados" name="grupo_selecionados[]" multiple style="height:150px;width:300px;" onkeypress="removeOption(this, event, 'grupo_selecionados');"></select></td>
            </tr>
            <tr bgcolor="#CCCCCC" style="display:none;">
                <td height="25">&nbsp;</td>
                <td valign="middle" align="left">&nbsp;<a href="javascript:addsubgrupo();" style="text-decoration:underline;color:#000000;"><b>&curren; Adicionar SubGrupo</b></a></td>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr id="lin2" style="display:none;" bgcolor="#CCCCCC">
                <td height="45">&nbsp;</td>
                <td valign="middle" align="center"><b>Selecione o(s) SubGrupo(s):</b>
                    <br><div id="resultado3"><select id="subgrupo" name="subgrupo" size="1"><option value="0">-- Escolha um SubGrupo --</option></select></div></td>
                <td valign="middle" align="center"><a href="javascript:insertBeforeSelected('subgrupo','13','subgrupo_selecionados');"><img src="images/add.jpg" border="0"></a>
                    <br><br><br><a href="javascript:removeOption('46','subgrupo_selecionados');"><img src="images/remove.jpg" border="0"></a></td>
                <td valign="middle" align="center"><b>SubGrupos Selecionados:</b>
                    <br><select id="subgrupo_selecionados" name="subgrupo_selecionados[]" multiple style="height:150px;width:280px;" onkeypress="removeOption(this, event, 'subgrupo_selecionados');"></select></td>
            </tr>
            <tr bgcolor="#CCCCCC" style="display:none;">
                <td height="25">&nbsp;</td>
                <td valign="middle" align="left">&nbsp;<a href="javascript:addfornecedor();" style="text-decoration:underline;color:#000000;"><b>&curren; Adicionar Fornecedor</b></a></td>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr id="lin3" style="display:none;" bgcolor="#CCCCCC">
                <td colspan="2" width="440">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr bgcolor="#CCCCCC">
                            <td>&nbsp;</td>
                            <td valign="middle"><div align="left"><b>Opção:</b></div></td>
                            <td valign="middle"><input type="radio" name="opcao" id="opcao1" value="1" align="absmiddle" checked> Código &nbsp;<input type="radio" name="opcao" id="opcao2" value="2" align="absmiddle"> N. Guerra &nbsp;<input type="radio" name="opcao" id="opcao3" value="3" align="absmiddle"> Razão</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr bgcolor="#CCCCCC">
                            <td height="30">&nbsp;</td>
                            <td valign="middle"><div align="left"><b>Pesquisa:</b></div></td>
                            <td valign="middle"><input type="text" name="consulta" id="consulta" size="23" onkeyup="this.value = this.value.toUpperCase()">&nbsp;<input type="button" name="pesquisar" id="pesquisar" value="Pesquisa" onclick="load_grid_fornecedor();"></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr bgcolor="#CCCCCC">
                            <td height="50">&nbsp;</td>
                            <td valign="middle" colspan="2" align="center"><b>Selecione o(s) Fornecedor(es):</b>
                                <br><div id="resultado5"><select id="pesquisa" name="pesquisa" multiple style="height:150px;width:300px;" onchange="setar(this);"></select></div></td>
                            <td>&nbsp;</td>
                        </tr><input type="hidden" name="nome" id="nome" size="40" readonly disabled>
                    </table>
                </td>
                <td valign="middle" align="center"><br><br><br><a href="javascript:insertBeforeSelected('pesquisa','13','fornecedor_selecionados');"><img src="images/add.jpg" border="0"></a>
                    <br><br><br><a href="javascript:removeOption('46','fornecedor_selecionados');"><img src="images/remove.jpg" border="0"></a></td>
                <td valign="bottom" align="center"><b>Fornecedores Selecionados:</b>
                    <br><select id="fornecedor_selecionados" name="fornecedor_selecionados[]" multiple style="height:150px;width:290px;" onkeypress="removeOption(this, event, 'fornecedor_selecionados');"></select></td>
            </tr>
        </div>


        <div id="msg" style="visibility: hidden;">&nbsp;<font face="Verdana" size="2">Processando...</font></div>
        <div id="resultado">


            <script src="js/relatoriogeracontagem.js"></script>

    </body>

</html>

