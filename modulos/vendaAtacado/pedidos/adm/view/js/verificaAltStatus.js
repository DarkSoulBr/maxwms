
$(function()
{

     if (usuario.codigo != 359 && !usuario.tipoAcessos[155] ){
            alert("request redirect");
            window.location = "acessos.php";
        }
    clean();
	$("#listaPesquisaPedidos").ajaxComplete(function()
			{
                            if(pedido.pvencer2 != null && $("#txtPesquisaPedidos").val()!=''){
                                $("#listaStatus").val(pedido.pvencer2);
                            }
                        });
});
