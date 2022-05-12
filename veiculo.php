<?php
$flagmenu = 4;
// Verificador de sessão
require("verifica.php");
include 'include/css.php';

//Verifica se a opção existe no Cadastros de Opção
$opcao = 'MANUTENCAO VEICULO';
$pagina = 'veiculo.php';
$modulo = 4;   //Cadastros
$sub = 19;   //Diversos
$usuario = $_SESSION["id_usuario"];

?>
<!DOCTYPE html>
<html>

    <head>

        <!-- Required meta tags-->
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Title Page-->
        <title>Cadastro de Veiculos</title>

        <!-- maxnew CSS-->
        <link href="css/max.css" rel="stylesheet" media="all">
    </head>

    <body onLoad=dadospesquisaestado(0)>
        <div id="retorno"></div>
        <div id="dialog" style="margin-left: 5px; margin-left: 5px;"></div>
        <div class="bg-gray p-t-10 p-b-100 font-lucida">
            <div class="wrapper wrapper--w680">
                <div class="card card-4">
                    <div class="card-header">
                        Cadastro de Veiculos
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="row row-space">
                                <div class="col-2">
                                    <div class="input-group">
                                        <label class="label">Pesquisar</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="pesquisa" type="text" name="pesquisa" size="35" onKeyPress="maiusculo()" onBlur="convertField(this)">
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
                                        <label class="label">Placa</label>
                                        <div class="p-t-10">
                                            <span class="custom-dropdown">
                                                <select name="listDados" onChange="dadospesquisa2(this.value);">
                                                    <option id="opcoes" value="0">Faça a Pesquisa da Placa</option>
                                                </select>
                                            </span>
                                            <input id="veicodigo" type="hidden" name="veicodigo" size="25" disabled readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-space">
                                <div class="col-2">
                                    <div class="input-group m-r-45">
                                        <label class="label">Placa</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="veiplaca" type="text" name="veiplaca" size="12" maxlength="8" onKeyPress="maiusculo()" onBlur="convertField(this)">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="input-group m-r-45">
                                        <label class="label">Ano</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="veiano" type="text" name="veiano" size="10" maxlength="5" onKeyPress="formatar('##/##', this)">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-space">
                                <div class="col-2">
                                    <div class="input-group m-r-45">
                                        <label class="label">Modelo</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="veimodelo" type="text" name="veimodelo" size="35" maxlength="20" onKeyPress="maiusculo()" onBlur="convertField(this)">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="input-group m-r-45">
                                        <label class="label">Cor</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="veicor" type="text" name="veicor" size="35" maxlength="20" onKeyPress="maiusculo()" onBlur="convertField(this)">
                                        </div>
                                    </div>
                                </div>
                            </div>                            
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group m-r-15">
                                        <label class="label">Chassis</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="veichassis" type="text" name="veichassis" size="35" maxlength="20" onKeyPress="maiusculo()" onBlur="convertField(this)">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-space">
                                <div class="col-2">
                                    <div class="input-group">
                                        <label class="label">Tipo</label>
                                        <div class="p-t-10">
                                            <label class="radio-container m-r-15">1 - Proprio
                                                <input type="radio" name="radio" id="radio1" value="radiobutton" checked style="background:#FFFFFF;">
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container">2 - Terceiros
                                                <input type="radio" name="radio" id="radio2" value="radiobutton" style="background:#FFFFFF;">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="input-group">
                                        <label class="label">Validação</label>
                                        <div class="p-t-10">
                                            <label class="radio-container m-r-15">Sim
                                                <input type="radio" name="radiov" id="radiov1" value="radiobuttonv" style="background:#FFFFFF;">
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-container">Não
                                                <input type="radio" name="radiov" id="radiov2" value="radiobuttonv" checked style="background:#FFFFFF;">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-space">
                                <div class="col-3">
                                    <div class="p-t-15 centraliza">
                                        <button class="btn btn--radius-2 btn--blue" id="botao" type="button" onClick="valida_form();"><span id="botao-text" con>Incluir</span></button>
                                        <input name="hidden" type="hidden" id="acao" value="inserir">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="p-t-15 centraliza">
                                        <button class="btn btn--radius-2 btn--green" id="botao2" type="button" onClick="limpa_form();">Limpar</button>
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

        <script src="js/veiculo.js"></script>

    </body>

</html>