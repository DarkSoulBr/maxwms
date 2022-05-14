function load_grid() {

    var dtinicio = document.getElementById("dtinicio").value;
    var dtfinal = document.getElementById("dtfinal").value;


    if (dtinicio.length <= 9)
    {
        alert("Preencha o campo data corretamente!\nEx: 01/01/2018");
        document.getElementById('dtinicio').focus();
    } else if (dtfinal.length <= 9)
    {
        alert("Preencha o campo data corretamente!\nEx: 01/01/2018");
        document.getElementById('dtfinal').focus();
    } else {
        new ajax('consultapedabertodata.php?dtinicio=' + dtinicio + '&dtfinal=' + dtfinal, {onComplete: imprime});
        //window.open('consultapedabertodata.php?dtinicio=' + dtinicio + '&dtfinal=' + dtfinal , '_blank');
    }

}

function imprime(request)
{

    $("resultado").innerHTML = "";
    var xmldoc = request.responseXML;

    var dados = xmldoc.getElementsByTagName('dados')[0];

    var registros = xmldoc.getElementsByTagName('registro');

    let resultado = "<div class='limiter'>"
    resultado += "<div class='container-table100'>"
    resultado += "<div class='wrap-table100'>"
    resultado += "<div class='table-max'>"
    resultado += "<div class='row-max header'>"
    resultado += "<div class='cell-max'>Número</div>"
    resultado += "<div class='cell-max'>Emissão</div>"
    resultado += "<div class='cell-max'>Código</div>"
    resultado += "<div class='cell-max'>Fornecedor</div>"
    resultado += "<div class='cell-max'>Comprador</div>"
    resultado += "<div class='cell-max'>Entrega</div>"
    resultado += "<div class='cell-max'>Valor</div>"
    resultado += "</div>"
    if (dados != null)
    {
        var registros = xmldoc.getElementsByTagName('registro');
        for (i = 0; i < registros.length; i++)
        {
            var itens = registros[i].getElementsByTagName('item');

            resultado += "<div class='row-max'>"
            resultado += "<div class='cell-max' data-title='Pedido'>" + itens[0].firstChild.data + "</div>"
            resultado += "<div class='cell-max' data-title='Emissão'>" + itens[1].firstChild.data + "</div>"
            resultado += "<div class='cell-max' data-title='Código'>" + itens[2].firstChild.data + "</div>"
            resultado += "<div class='cell-max' data-title='Fornecedor'>" + itens[3].firstChild.data + "</div>"
            resultado += "<div class='cell-max' data-title='Comprador'>" + itens[4].firstChild.data + "</div>"
            resultado += "<div class='cell-max' data-title='Entrega'>" + itens[5].firstChild.data + "</div>"
            resultado += "<div class='cell-max' data-title='Entrega'>" + itens[6].firstChild.data + "</div>"
            resultado += "</div>"

        }
    }
    resultado += "</div>"
    resultado += "</div>"
    resultado += "</div>"
    resultado += "</div>"

    $("resultado").innerHTML = resultado;

}

