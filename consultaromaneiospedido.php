<?php
$flagmenu = 3;
// Verificador de sessão
require("verifica.php");

//Verifica se a opção existe no Cadastros de Opção
$opcao = 'ROMANEIOS CONS. PED. (CD-SP)';
$pagina = 'consultaromaneiospedido.php';
$modulo = 3;  //Logistica
$sub = 14;  //Romaneios
$usuario = $_SESSION["id_usuario"];


?>
<!DOCTYPE html>
<html>
    <head>

        <!-- Required meta tags-->    
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Title Page-->
        <title>Consulta de Romaneios por Pedido</title> 

        <!-- maxnew CSS-->
        <link href="css/max.css" rel="stylesheet" media="all">        
    </head>

    <body> 
        <div id="retorno"></div>
        <div id="dialog" style="margin-left: 5px; margin-left: 5px;"></div>
        <div class="bg-gray p-t-10 font-lucida">
            <div class="wrapper wrapper--w680">
                <div class="card card-4">
                    <div class="card-header">
                        Consulta de Romaneios por Pedido
                    </div>
                    <div class="card-body">                    
                        <form name="formulario">
                            <div class="row row-space">
                                <div class="col-2">
                                    <div class="input-group m-r-45">
                                        <label class="label">Pedido</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" name="pvnumero" type="text" id="pvnumero" onKeyPress="maiusculo()" onBlur="dadospesquisa(this.value);" size="10">
                                        </div>
                                    </div>
                                </div>                                
                                <div class="col-2">
                                    <div class="input-group m-r-45">
                                        <label class="label">Emissão</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" name="pvemissao" type="text" id="pvemissao" onKeyPress="maiusculo()" size="14" disabled="disabled">
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group m-r-15">
                                        <label class="label">Cliente</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="clinguerra" type="text" name="clinguerra" size="58" onKeyPress="maiusculo()" disabled="disabled">
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                            <div class="row row-space">
                                <div class="col-3">
                                    <div class="input-group m-r-45">
                                        <label class="label">Romaneio</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" name="romnumero" type="text" id="romnumero" onKeyPress="maiusculo()" size="10" disabled="disabled">
                                        </div>
                                    </div>
                                </div>                                
                                <div class="col-3">
                                    <div class="input-group m-r-45">
                                        <label class="label">Emissão</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" name="romdata" type="text" id="romdata" onKeyPress="maiusculo()" size="10" disabled="disabled">
                                        </div>
                                    </div>
                                </div>                                
                                <div class="col-3">
                                    <div class="input-group m-r-45">
                                        <label class="label">Baixa</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" name="rombaixa" type="text" id="rombaixa" onKeyPress="maiusculo()" size="10" disabled="disabled">
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                            <div class="row row-space">
                                <div class="col-2">
                                    <div class="input-group m-r-45">
                                        <label class="label">Veiculo</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" name="veimodelo" type="text" id="veimodelo" onKeyPress="maiusculo()" size="35" disabled="disabled">
                                        </div>
                                    </div>
                                </div>                                
                                <div class="col-3">
                                    <div class="input-group m-r-45">
                                        <label class="label">Placa</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" name="veiplaca" type="text" id="veiplaca" onKeyPress="maiusculo()" size="10" disabled="disabled">
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                        </form>
                    </div>
                </div>                
            </div>
        </div>

        <script src="js/consultaromaneiospedido.js"></script>

        <input id="codigo" type="hidden" name="codigo" size="25">

    </body>

</html>


