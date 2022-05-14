// JavaScript Document   
function load_grid()
{
    new ajax('geratabelasmovimentacao.php?flag=1', {onLoading: carregando_grid, onComplete: imprime_grid});    
}

function carregando_grid() {
    $("msg1").style.visibility = "visible";
    $("msg1").innerHTML = "Processando...";
}

function imprime_grid(request)
{
    $("msg1").style.visibility = "hidden";

    var xmldoc = request.responseXML;
    var dados = xmldoc.getElementsByTagName('dadosc')[0];
    var registros = xmldoc.getElementsByTagName('registroc');
    var itens = registros[0].getElementsByTagName('itemc');

    document.getElementById('chcodigo').value = itens[0].firstChild.data;
    document.getElementById('saopaulo').value = itens[1].firstChild.data;


}

//------ Teste de formulário ----------//
function imprimirconsulta()
{
    //$("resultado").innerHTML="Processando...";
    var ano = document.getElementById("chcodigo").value;
        
    $a('#dialog').attr('title', 'PROCESSAR : ' + ano);

    var mensagem = "Confirma criação de tabelas de movimentação de estoque de " + ano + "?";

    var html = '<p>' +
            mensagem +
            '</p><form id="formSituacao" name="formSituacao" method="post" action="#">';



    html += '</form>';



    $a('#dialog').html(html);

    $a('#dialog').dialog({
        autoOpen: true,
        width: 500,
        modal: true,
        overlay: {
            background: "white"
        },
        buttons:
                {

                    "Sim": function ()
                    {


                        $a('#dialog').dialog("close");

                        processar(ano);


                    },
                    "Não": function ()
                    {
                        $a(this).dialog("close");
                    }

                },
        close: function (ev, ui)
        {
            $a(this).dialog("destroy");



        }


    });

    $a('#dialog').dialog("open");


    

}

function processar(ano) {    
    $("botao").disabled = true;
    new ajax('geratabelasmovimentacao.php?flag=2&ano=' + ano, {onLoading: carregandolista, onComplete: imprimelista});
}

function carregandolista() {
    $("msg").style.visibility = "visible";
    $("msg").innerHTML = "Processando...";
    $("resultado").innerHTML = "";
}

function imprimelista(request)
{
    var xmldoc = request.responseXML;

    //var dados = xmldoc.getElementsByTagName('dados')[0];
    var registros = xmldoc.getElementsByTagName('registroc');
    var itens = registros[0].getElementsByTagName('itemc');

    if (itens[0].firstChild.data != "Erro")
    {
        alert("Tabelas criadas com sucesso!");
        $("msg").innerHTML = "<br>";
        $("resultado").innerHTML = "Tabelas criadas com sucesso!";

    } else
    {
        alert("Houve um problema, Tabelas Não Criadas!");
        $("msg").innerHTML = "<br>";
        $("resultado").innerHTML = "Houve um problema, Tabelas Não Criadas!";
    }
    
    window.open('tabelasmovimentacao.php', '_self');
    
}

function format(rnum, id)
{

    if (rnum == '') {
        rnum = 0;
    }

    if (isNaN(rnum) == true) {
        rnum = 0;
    }

    rnum = parseInt(rnum);

    $(id).value = rnum;

}