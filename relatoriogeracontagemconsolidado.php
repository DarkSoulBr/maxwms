<?php
$flagmenu = 5;
// Verificador de sessão
require("verifica.php");

//Verifica se a opção existe no Cadastros de Opção   
$opcao = 'EXCEL CONSOLIDADO';
$pagina = 'relatoriogeracontagemconsolidado.php';
$modulo = 5;  //ESTOQUE
$sub = 24;  //COLETOR
$usuario = $_SESSION["id_usuario"];

$sql = "Select opccodigo from opcoes Where opcpagina = '$pagina'";
$sql = pg_query($sql);
$row = pg_num_rows($sql);
if ($row) {
    $codpag = pg_fetch_result($sql, 0, "opccodigo");
} else {
    $sql2 = "INSERT INTO OPCOES (opcnome,opcpagina,modcodigo,submcodigo) values ('$opcao','$pagina','$modulo','$sub')";

    pg_query($sql2);

    //Localiza a opcao
    $b = 0;
    while ($b < 1000) {
        $sql = "Select opccodigo from opcoes Where opcpagina = '$pagina'";
        $sql = pg_query($sql);
        $row = pg_num_rows($sql);
        if ($row) {
            $codpag = pg_fetch_result($sql, 0, "opccodigo");
            $b = 1000;
        } else {
            $b++;
        }
    }
}


//Grava na Tabela de Favoritos do Usuário
$sql = "Select favqtd from favoritosusuario Where usucodigo = '$usuario' and opccodigo='$codpag'";
$sql = pg_query($sql);
$row = pg_num_rows($sql);
if ($row) {
    $favqtd = pg_fetch_result($sql, 0, "favqtd");
} else {
    $sql2 = "INSERT INTO favoritosusuario (usucodigo,opccodigo,favqtd) values ('$usuario','$codpag','0')";
    pg_query($sql2);
    $favqtd = 0;
}

$favqtd++;

$sql3 = "UPDATE favoritosusuario SET favqtd='$favqtd' Where usucodigo='$usuario' and opccodigo='$codpag'";
pg_query($sql3);
?>
<!DOCTYPE html>
<html>
    <head>
        <!-- Required meta tags-->    
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Title Page-->
        <title>Relatório de Contagem de Estoque (Consolidado)</title>        

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
                        Relatório de Contagem de Estoque (Consolidado)
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
                                        <div id="resultado4">                                          
                                            <span class="custom-dropdown">
                                                <select id="estoque" name="estoque" size="1">
                                                    <option value="0">-- Escolha uma Contagem --</option>                                                
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group">
                                        <label class="label">Contagem 2</label>                                        
                                        <div id="resultado4x">                                          
                                            <span class="custom-dropdown">
                                                <select id="estoque2" name="estoque2" size="1">
                                                    <option value="0">-- Escolha uma Contagem --</option>                                                
                                                </select> 
                                            </span>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                            <div class="row row-space">
                                <div class="col-1">
                                    <div class="input-group">
                                        <label class="label">Contagem 3</label>                                        
                                        <div id="resultado4w">                                          
                                            <span class="custom-dropdown">
                                                <select id="estoque4" name="estoque4" size="1">
                                                    <option value="0">-- Escolha uma Contagem --</option>                                                
                                                </select> 
                                            </span>
                                        </div>
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


        <div id="msg" style="visibility: hidden;">&nbsp;<font face="Verdana" size="2">Processando...</font></div>
        <div id="resultado">


            <script src="js/relatoriogeracontagemconsolidado.js"></script>

    </body>

</html>

