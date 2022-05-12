<?php
$flagmenu = 3;
// Verificador de sessão
require("verifica.php");

//Verifica se a opção existe no Cadastros de Opção
$opcao = 'NOTFIS POR DATAS';
$pagina = 'consultaromaneiosnotfis.php';
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
        <title>Geração de Arquivo NotFis por Datas</title>        

        <!-- maxnew CSS-->
        <link href="css/max.css" rel="stylesheet" media="all">        
    </head>

    <body onload="datadiacampo('dataini', 'datafim');">
        <div id="retorno"></div>
        <div id="dialog" style="margin-left: 5px; margin-left: 5px;"></div>
        <div class="bg-gray p-t-10 font-lucida">
            <div class="wrapper wrapper--w680">
                <div class="card card-4">
                    <div class="card-header">
                        Geração de Arquivo NotFis por Datas
                    </div>
                    <div class="card-body">                    
                        <form name="formulario" method="POST">
                            <div class="row row-space ">                                
                                <div class="col-2">
                                    <div class="input-group m-r-45">
                                        <label class="label">Data Inicio</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" type="text" name="dataini" id="dataini" onkeypress="javascript:formata_data(this);" onkeyup="javascript:pulacampo(this);" onBlur="dataano(this, this.value)" maxlength="10" size="12">
                                        </div>
                                    </div>
                                </div>                                             
                                <div class="col-2">
                                    <div class="input-group m-r-45">
                                        <label class="label">Data Fim</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" type="text" name="datafim" id="datafim" onkeypress="javascript:formata_data(this);" onBlur="dataano(this, this.value)" maxlength="10" size="12">
                                        </div>
                                    </div>
                                </div>                        
                            </div>	                                     
                            <div class="p-t-15 centraliza">                                        
                                <button class="btn btn--radius-2 btn--blue" type="button" id="botao" onclick="imprimirrelatorioexcel();">Confirma</button>
                            </div>						
                        </form>
                    </div>
                </div>                
            </div>
        </div>
        <div class="wrapper wrapper--w960">
            <div class="result" id="resultado"></div> 
        </div>

        <div id="msg" style="visibility: hidden;">&nbsp;<font face="Verdana" size="2">Processando...</font></div>

        <input type='hidden' name='usuario' id='usuario' value='<? echo $_SESSION['id_usuario']; ?>'/>
        <input type="hidden" name="usuario" id="usuario" size="10"  value='<? echo $usuario; ?>'>

        <script src="js/consultaromaneiosnotfis.js"></script>

    </body>

</html>

