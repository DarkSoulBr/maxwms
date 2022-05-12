<?php

$flagmenu = 6;
$parametro = $_GET["parametro"];

require("verifica.php");

require_once("include/conexao.inc.php");

//Verifica se a opção existe no Cadastros de Opção
$opcao = 'EDI TRANSPORTADORA';
$pagina = 'importaedi.php';
$modulo = 6;  //Utilitarios
$sub = 27;  //Importacoes
$usuario = $_SESSION["id_usuario"];

$cod = $_SESSION["id_usuario"];

if ($parametro == 1) {
    echo "<center><strong> Processando EDI! </strong></center>";
    echo "<meta HTTP-EQUIV='Refresh' CONTENT='5;URL=editrans.php?usuario=$cod'>";
    echo "<center><strong><input type='button' id='botao' onClick=window.open('importaedi2.php','_self') value='VOLTAR'></strong></center>";
    exit;
} else {

    $cadastro = new banco($conn, $db);

    $sql = "SELECT usucodigoedi,datedi FROM parametros";

    $sql = pg_query($sql);
    $row = pg_num_rows($sql);

    if ($row) {
        $codigo = pg_fetch_result($sql, 0, "usucodigoedi");
        $datvtex = pg_fetch_result($sql, 0, "datedi");

        if ($datvtex != '') {
            $datvtex = substr($datvtex, 8, 2) . '/' . substr($datvtex, 5, 2) . '/' . substr($datvtex, 0, 4) . ' ' . substr($datvtex, 11, 8);
        }

        if ($codigo != 0) {

            $nome = '';

            $sql = "SELECT usdescricao FROM cadusuarios Where uscodigo = " . $codigo;       

            $sql = pg_query($sql);
            $row = pg_num_rows($sql);

            if ($row) {
                $nome = pg_fetch_result($sql, 0, "usdescricao");
            }

            echo "<center><strong> Registros sendo processados pelo usuário " . $nome . "</strong></center>";
            echo "<center><strong> Último processamento em " . $datvtex . "</strong></center>";
            echo "<center><strong><input type='button' id='botao' onClick=window.open('maxwms.php?flagmenu=6','_self') value='VOLTAR'></strong></center>";
            exit;
        } else {

            $auxdat = date("Y-m-d H:i:s");

            $sql = "Update parametros set datedi='$auxdat',usucodigoedi = " . $cod;
            $sql = pg_query($sql);

            echo "<center><strong> Processando EDI! </strong></center>";
            echo "<meta HTTP-EQUIV='Refresh' CONTENT='5;URL=editrans.php?usuario=$cod'>";
            echo "<center><strong><input type='button' id='botao' onClick=window.open('importaedi2.php','_self') value='VOLTAR'></strong></center>";
            exit;
        }
    }
}
?>
