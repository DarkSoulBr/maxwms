<?php
// Inicia sessões
session_start();

echo "<link rel='icon' href='images/favicons.png'/>";
?>

<!DOCTYPE html>
<html>
    <head>
        <title>:: Max Trade ::</title>
        <META HTTP-EQUIV="CACHE-CONTROL" CONTENT= "NO-CACHE">
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <link rel="stylesheet" type="text/css" href="css/font-awesome.css">

        <!-- SmartMenus core CSS (required) -->
        <link href="./css/sm-core-css.css" rel="stylesheet" type="text/css" />

        <!-- "sm-clean" menu theme (optional, you can use your own CSS, too) -->
        <link href="./css/sm-clean/sm-clean.css" rel="stylesheet" type="text/css" />

        <script src="js/prototype.lite.js"></script>
        <script src="js/moo.ajax.js"></script>
        <script src="js/geral.js"></script>
        <script src="js/validaie.js"></script>
        <script src="js/validacnpj.js"></script>
        <script src="js/verifica.js"></script>


        <style>
            .borda{border: 1px solid;}
            div{font-family: Verdana; font-size: 12px;}
            td{font-family: Verdana; font-size: 12px;}
            input{font-family: Verdana; font-size: 12px;}
            select{font-family: Verdana; font-size: 12px;}
        </style>

    </head>
    <body>            
        <div style="background:#3366CC; font-size:22px; text-align:center; color:#FFF; font-weight:bold; height:36px; padding-top:8px;">Max WMS</div>

        <!-- jQuery -->
        <script type="text/javascript" src="./libs/jquery/jquery.js"></script>

        <!-- SmartMenus jQuery plugin -->
        <script type="text/javascript" src="./libs/jquery.smartmenus.js"></script>



        <script type="text/javascript">
            var $mn = jQuery.noConflict()
        </script>

        <!-- SmartMenus jQuery init -->
        <script type="text/javascript">
            $mn(function () {
                $mn('#main-menu').smartmenus({
                    subMenusSubOffsetX: 1,
                    subMenusSubOffsetY: -8
                });
            });
        </script>



    </body>
    <br>
    <br>
</html>                                            

