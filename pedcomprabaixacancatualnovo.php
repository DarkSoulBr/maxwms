<?php
$flagmenu = 1;
require("verifica.php");
require_once("include/config.php");
include 'include/jquerymax.php';
include 'include/cssloja.php';

$usuario = $_SESSION["id_usuario"];

?>

<!DOCTYPE html>
<html>
    <head>
        <!-- Required meta tags-->    
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Title Page-->
        <title>Cancelamento de Atualização de Estoque</title>

        <!-- maxnew CSS-->
        <link href="css/max.css" rel="stylesheet" media="all">
        <style>
            .row-max .cell-max:nth-child(1) {
                width: 100px;
                text-align: center;
                padding-left: 5px;
            }

            .row-max .cell-max:nth-child(2) {
                width: 600px;
                text-align: center;
                padding-right: 5px;
            }

            .row-max .cell-max:nth-child(3) {
                width: 100px;
                text-align: center;
                padding-right: 5px;
            }

            .row-max .cell-max:nth-child(4) {
                width: 100px;
                text-align: center;
                padding-right: 5px;
            }

            a:hover {
                cursor: pointer;
            }            

        </style>
    </head>

    <body onLoad="inicia(<?php echo $usuario ?>)";>
        <div id="retorno"></div>
        <div id="dialog" style="margin-left: 5px; margin-left: 5px; background:white;"></div>
        <div class="bg-gray p-t-10 p-b-100 font-lucida">
            <div class="wrapper wrapper--w780">
                <div class="card card-4">
                    <div class="card-header">
                        Cancelamento de Atualização de Estoque
                    </div>
                    <div class="card-body">                    
                        <form name="formulario" method="POST">

                            <div class="row row-space">
                                <div class="col-3">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Pedido:</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" name="pcnumero" type="text" id="pcnumero" onKeyPress="maiusculo()" onFocus="nextfield = 'pcseq'" size="10"  style="BACKGROUND-COLOR: #b3c6ff; COLOR: #660000; FONT-WEIGHT: bold;">
                                            <input id="codigo" type="hidden" name="codigo" size="25">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-3">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Sequencia</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" name="pcseq" type="text" id="pcseq" onKeyPress="maiusculo()" size="5" onFocus="botao()" onFocus="nextfield = 'button_pesquisa'" style="BACKGROUND-COLOR: #b3c6ff; COLOR: #660000; FONT-WEIGHT: bold;">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-3 centraliza">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">&nbsp;</label>
                                        <button class="btn-small btn--radius-2 btn--blue" name="button_pesquisa" type="button" id="button_pesquisa" onClick="ver()";>Pesquisar</button>
                                        <input type="hidden" name="usuario" id="usuario" size="10"  value='<? echo $usuario; ?>'>
                                    </div>
                                </div>                              



                            </div> 

                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group-small m-r-15">
                                        <label class="label">Fornecedor</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="fornguerra" type="text" name="fornguerra" size="65" onKeyPress="maiusculo()" disabled="disabled">
                                            <input id="codigo2" type="hidden" name="codigo2" size="25">
                                        </div>
                                    </div>
                                </div>

                            </div> 


                            <div class="row row-space">
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Comprador</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="comprador" type="text" name="comprador" size="65" onKeyPress="maiusculo()" disabled="disabled">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Data</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="data" type="text" name="data" size="10" OnKeyPress="formatar('##/##/####', this)" onBlur="dataano(this, this.value)" disabled="disabled">
                                        </div>
                                    </div>
                                </div>                         

                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Emissão</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="datanota" type="text" name="datanota" size="10" OnKeyPress="formatar('##/##/####', this)" onBlur="dataano(this, this.value)" disabled="disabled">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">CFOP</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="cfop" type="text" name="cfop" size="10" onKeyPress="maiusculo()" disabled="disabled">
                                        </div>
                                    </div>
                                </div>

                            </div> 

                            <div class="row row-space">
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Nota</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="nota" type="text" name="nota" size="6" onKeyPress="maiusculo()" disabled="disabled">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Série</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="notentserie" type="text" name="notentserie" size="1" onKeyPress="maiusculo()" disabled="disabled">
                                            <input id="notentcodigo" type="hidden" name="notentcodigo" size="25">
                                        </div>
                                    </div>
                                </div>                         

                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Produtos</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="produtos" type="text" name="produtos" size="10" onKeyPress="maiusculo()" disabled="disabled">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">ICMS %</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="icm" type="text" name="icm" size="9" onKeyPress="maiusculo()" disabled="disabled">
                                        </div>
                                    </div>
                                </div>

                            </div> 

                            <div class="row row-space">
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Base ICMS</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="baseicm" type="text" name="baseicm" size="10" onKeyPress="maiusculo()" disabled="disabled">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Valor ICMS</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="valoricm" type="text" name="valoricm" size="10" onKeyPress="maiusculo()" disabled="disabled">                                            
                                        </div>
                                    </div>
                                </div>                         

                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Isentas</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="isentas" type="text" name="isentas" size="9" onKeyPress="maiusculo()" disabled="disabled">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Outras</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="outras" type="text" name="outras" size="10" onKeyPress="maiusculo()" disabled="disabled">
                                        </div>
                                    </div>
                                </div>

                            </div> 

                            <div class="row row-space">
                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Base IPI</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="baseipi" type="text" name="baseipi" size="10" onKeyPress="maiusculo()" disabled="disabled">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">IPI %</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="percipi" type="text" name="percipi" size="9" onKeyPress="maiusculo()" disabled="disabled">                                            
                                        </div>
                                    </div>
                                </div>                         

                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Valor IPI</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="valoripi" type="text" name="valoripi" size="10" onKeyPress="maiusculo()" disabled="disabled">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="input-group-small m-r-45">
                                        <label class="label">Total Nota</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="totalnota" type="text" name="totalnota" size="10" onKeyPress="maiusculo()" disabled="disabled">
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group-small m-r-15">
                                        <label class="label">Observações</label>
                                        <div class="input-group-small-icon">
                                            <input class="input--style-4" id="observacoes" type="text" name="observacoes" size="65" onKeyPress="maiusculo()" disabled="disabled">                                            
                                        </div>
                                    </div>
                                </div>

                            </div> 

                            <div class="row row-space m-b-25"></div>

                            <div class="row row-space">
                                <div class="col-2 centraliza">
                                    <button class="btn-medium btn--radius-2 btn--blue" type="button" id="button" onClick="cancelar()" disabled>Cancelar Atualização</button>                                    
                                </div>
                                <div class="col-2 centraliza">
                                    <button class="btn-medium btn--radius-2 btn--green" name="button2" type="button" id="button2" onClick="limpar()">Limpar Tela</button>
                                </div>
                            </div>

                            <div style ="display:none">
                                <div id="msg" style="visibility: hidden;">&nbsp;<font face="Verdana" size="2">Processando...</font></div>
                            </div>

                        </form>    

                    </div>
                </div>

            </div>

            <div class="row row-space m-b-25"></div>

            <div class="wrapper wrapper--w960">
                <div class="result" id="resultado"></div>
            </div>
        </div>

        <script src="js/pedcomprabaixacancatualnovo.js"></script>        
        <script type="text/javascript">
                                        var $a = jQuery.noConflict()
        </script>

    </body>

</html>                            
