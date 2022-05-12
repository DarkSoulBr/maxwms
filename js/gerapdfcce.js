function importarPedido()
{

    novaJanela("telauploadarquivocce.php", "UPLOAD DE ARQUIVOS")

}


function novaJanela(href, t)
{


    $a.GB_show(href,
            {
                //height: (document.body.scrollHeight - 80),
                //width: (document.body.scrollWidth - 30),

                height: (550),
                width: (720),

                animation: true,
                overlay_clickable: false,
                callback: callback,
                caption: t
            });

    //alert();
    $a('#dialog').dialog("open");


}

function  callback()
{

    //Chama  a importação
    importarPedidoOK();

}


function importarPedidoOK()
{

    var usuario = $("usuario").value;
    if (usuario == '') {
        usuario = 0
    }

    window.open('imprimepdfcce.php?usuario=' + usuario, 'Report', 'status=yes, scrollbars=yes, location=no, toolbar=no, directories=no, resizable=no, fullscreen=yes');

}
