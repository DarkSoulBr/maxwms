
function clean(){

    $("#listaPesquisaPedidos").val('');
    $("#txtPesquisaPedidos").val('');
    $("#listaStatus").val('');

    if(typeof(pedido) != 'undefined') {
        delete pedido;
    }
    return false;
}
