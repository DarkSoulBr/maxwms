<?php
$flag = trim($_GET["flag"]);

$flagmenu = 2;

require("verificasession.php");
$usuario = $_SESSION["id_usuario"];
?>

<?php
// Quando a ação for para remover anexo
if ($_POST['acao'] == 'removeAnexo') {
    // Recuperando nome do arquivo
    $arquivo = $_POST['arquivo'];
    // Caminho dos uploads
    $caminho = 'uploads/';
    // Verificando se o arquivo realmente existe
    if (file_exists($caminho . $arquivo) and!empty($arquivo))
    // Removendo arquivo
        unlink($caminho . $arquivo);
    // Finaliza a requisição
    exit;
}

// Se enviado o formulário
if (isset($_POST['enviar'])) {
    echo 'Arquivos Enviados: ';
    echo '<pre>';
    print_r($_POST['anexos']);
    echo '</pre>';
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
    <head profile="http://gmpg.org/xfn/11">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>AJAX Upload com PHP e jQuery</title>
        <script type="text/javascript" src="js/jquery-1.6.1.min.js" ></script>
        <script type="text/javascript" src="js/ajaxupload.3.5.js" ></script>
        <link rel="stylesheet" type="text/css" href="./styles.css" />




        <script type="text/javascript" src="js/jquery.js"></script>

        <style type="text/css">
            body {
                font-family: "Trebuchet MS";
                font-size: 14px;    
            }

            iframe {
                border: 0;
                overflow: hidden;
                margin: 0;
                height: 60px;
                width: 450px;
            }

            #anexos {
                list-style-image: url(image/file.png);
            }

            img.remover {
                cursor: pointer;
                vertical-align: bottom;
            }




        </style>


        <script type="text/javascript">
            $(function ($) {
                // Quando enviado o formulário
                $("#upload").submit(function () {
                    // Passando por cada anexo
                    $("#anexos").find("li").each(function () {
                        // Recuperando nome do arquivo
                        var arquivo = $(this).attr('lang');
                        // Criando campo oculto com o nome do arquivo
                        $("#upload").prepend('<input type="hidden" name="anexos[]" value="' + arquivo + '" \/>');
                    });
                });
            });


        </script>

    </head>

    <body>


        <Center>
            <div id="mainbody" >
                <h3>IMPORTAR ARQUIVO DE CCE</h3>

                <b>PERMITIDO ENVIAR 1 ARQUIVO XML, TAMANHO MAXIMO DO ARQUIVO DE 20MB.</b>

                <!--
                <div id="upload" ><span>Upload File<span></div><span id="status" ></span>
                <ul id="files" ></ul>
                -->
                <Center>
                    <ul id="anexos"></ul>

                    <iframe src="uploadccexml.php" frameborder="0" scrolling="no"></iframe>
                </Center>


                </p>

            </div>
        </Center>

    </body>
</html>