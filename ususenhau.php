<?php   
$flagmenu=2; 
// Verificador de sessão
require("verifica.php");
require_once("include/conexao.inc.php");

$usuario = $_SESSION["id_usuario"];

?>

<!DOCTYPE html>
<html>
    <head>
        <!-- Required meta tags-->    
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Title Page-->
        <title>Alteração de Senha</title>

        <!-- maxnew CSS-->
        <link href="css/max.css" rel="stylesheet" media="all">
    </head>

    <body onload="dadospesquisa2(<? echo $usuario ?>);" >
        <div class="bg-gray p-t-10 p-b-100 font-lucida">
            <div class="wrapper wrapper--w680">
                <div class="card card-4">
                    <div class="card-header">
                        Alteração de Senha
                    </div>
                    <div class="card-body">                    
                        <form method="POST">
                            
                            <div class="row row-space">
                                <div class="col-3">
                                    <div class="input-group m-r-45">
                                        <label class="label">Login</label>                                        
                                        <input class="input--style-4" id="descricao" type="text" name="descricao" size="15" maxlength="10" onKeyPress="maiusculo()" onBlur="convertField(this);" disabled>
                                        <input type="hidden" name="codigo" id="codigo" value="">
                                    </div>
                                </div>                                
                            </div>
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group">
                                        <label class="label">Usuário</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="descricao2" type="text" name="descricao2" size="45" maxlength="50" onKeyPress="maiusculo()" onBlur="convertField(this);" disabled>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                            
                            <div class="row row-space">                                
                                <div class="col-3">
                                    <div class="input-group m-r-45">
                                        <label class="label">Senha Atual</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="descricaox" type="password" name="descricaox" size="10" maxlength="8" onKeyPress="maiusculo()" onBlur="convertField(this);">                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="input-group m-r-45">
                                        <label class="label">Senha Nova</label>
                                        <div class="input-group-icon">
                                            <input class="input--style-4" id="descricao3" type="password" name="descricao3" size="10" maxlength="8" onKeyPress="maiusculo()" onBlur="convertField(this);">
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-3">
                                    <div class="input-group m-r-45">
                                        <label class="label">Confirma</label>                                        
                                        <input class="input--style-4" id="descricao4" type="password" name="descricao4" size="10" maxlength="8" onKeyPress="maiusculo()" onBlur="convertField(this);">
                                    </div>
                                </div>
                            </div>
                            
                            
                                                        
                            <div class="p-t-15 centraliza">
                                <button class="btn btn--radius-2 btn--blue m-r-45" type="button" onClick="valida_form();">Alterar</button>
                                <input name="hidden" type="hidden" id="acao" value="alterar">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="result" id="resultado"></div>
            </div>
        </div>

        <script src="js/ususenhau.js"></script>
        <script type="text/javascript">
            var $a = jQuery.noConflict()
        </script>

    </body>

</html>
