// JavaScript Document 
function load_grid(di, df, forn) {
    var opcaosetada = 0;

    if (document.getElementById('opcao1').checked == true)
        opcaosetada = 1;

    if (document.getElementById('opcao2').checked == true)
        opcaosetada = 2;

    if (document.getElementById('opcao3').checked == true)
        opcaosetada = 3;

    var forn0 = document.getElementById("forn0").checked;

    if (forn0 == true)
        opcaosetada = "";

    //alert('consultagerapedbaicomfornecedor.php?opcao=' + opcaosetada + '&forn=' + forn + '&datainicio=' + di + '&datafim='+ df);
    new ajax('consultagerapedbaicomfornecedor.php?opcao=' + opcaosetada + '&forn=' + forn + '&datainicio=' + di + '&datafim=' + df, {onLoading: carregando, onComplete: imprime});
}

function carregando() {
    $("msg").style.visibility = "visible";
    $("msg").innerHTML = "Processando...";
}

function imprime(request)
{
    
    $("resultado").innerHTML = "";
    var xmldoc = request.responseXML;

    var dados = xmldoc.getElementsByTagName('dadosforn')[0];

    var registros = xmldoc.getElementsByTagName('registroforn'); 
    
    let resultado = "<div class='limiter'>" 
    resultado += "<div class='container-table100'>"
    resultado += "<div class='wrap-table100'>"
    resultado += "<div class='table-max'>"
    resultado += "<div class='row-max header'>"
    resultado += "<div class='cell-max'>Pedido</div>"        
    resultado += "<div class='cell-max'>Seq.</div>"        
    resultado += "<div class='cell-max'>Emiss?o</div>"        
    resultado += "<div class='cell-max'>Baixa</div>" 
	resultado += "<div class='cell-max'>N? da Nota</div>"        
    resultado += "<div class='cell-max'>Fornecedor</div>"    	
    resultado += "</div>"  
    if (dados != null)
    {
        var registros = xmldoc.getElementsByTagName('registroforn');        
        for (i = 0; i < registros.length; i++)
        {            
            var itens = registros[i].getElementsByTagName('itemforn');
        
            resultado += "<div class='row-max'>"
            resultado += "<div class='cell-max' data-title='Pedido'>" + itens[0].firstChild.data + "</div>"
            resultado += "<div class='cell-max' data-title='Seq.'>" + itens[1].firstChild.data + "</div>"
            resultado += "<div class='cell-max' data-title='Emiss?o'>" + itens[2].firstChild.data + "</div>"
            resultado += "<div class='cell-max' data-title='Baixa'>" + itens[3].firstChild.data + "</div>"
			resultado += "<div class='cell-max' data-title='N? da Nota'>" + itens[4].firstChild.data + "</div>"
            resultado += "<div class='cell-max' data-title='Fornecedor'>" + itens[5].firstChild.data + "</div>"
            resultado += "</div>"
            
        }
    }
    resultado += "</div>"        
    resultado += "</div>"        
    resultado += "</div>"        
    resultado += "</div>"        
   
    $("resultado").innerHTML = resultado;
   
}

function load_gridfor() {
    var opcaosetada = 0;

    if (document.getElementById('opcao1').checked == true)
        opcaosetada = 1;

    if (document.getElementById('opcao2').checked == true)
        opcaosetada = 2;

    if (document.getElementById('opcao3').checked == true)
        opcaosetada = 3;

    var strfornecedor = document.getElementById('consultafornecedor').value;

    document.getElementById('pesquisafornecedor').disabled = false;
    document.getElementById('fornecedor').disabled = false;

    new ajax('cadastroconsultafornecedor.php?opcao=' + opcaosetada + '&consultafornecedor=' + strfornecedor, {onLoading: carregandofor, onComplete: imprimefor});
}

function carregandofor() {
    $("msgfor").style.visibility = "visible";
    $("msgfor").innerHTML = "Processando...";
}

function imprimefor(request) {

    $("msgfor").style.visibility = "hidden";
    var xmldoc = request.responseXML;

    var dados = xmldoc.getElementsByTagName('dados')[0];

    var contador = '0';
    var tabela = '<span class="custom-dropdown"><select id="pesquisafornecedor" name="pesquisafornecedor" size="1" onchange="setarfornecedor(this);">';
    tabela += "<option value=\"0\">-- Escolha um Fornecedor --</option>";

    if (dados != null)
    {
        //corpo da tabela
        var registros = xmldoc.getElementsByTagName('registro');
        //alert(registros.length);
        for (i = 0; i < registros.length; i++)
        {

            var itens = registros[i].getElementsByTagName('item');

            if (itens[2].firstChild.data == '.') {
                var opcao = itens[1].firstChild.data;
            } else {
                var opcao = itens[1].firstChild.data + ' ' + itens[2].firstChild.data;
            }


            tabela += '<option value="' + itens[0].firstChild.data + '">' + opcao + '</option>\n"';
        }

    }
    tabela += "</select></span>"
    $("resultadofor").innerHTML = tabela;
    //alert(tabela);
}

function imprimirconsultapedbaicomfornecedor() {

    var dataini = document.getElementById('datainiform').value;
    var datafim = document.getElementById('datafimform').value;
    var forn0 = document.getElementById("forn0").checked;
    var forn1 = document.getElementById("forn1").checked;
    var consultafornecedor = document.getElementById("consultafornecedor").value;
    var fornecedor = document.getElementById("fornecedor").value;

    var erro = 0;
    if (dataini.length <= 9)
    {
        alert("Preencha o campo data corretamente!\nEx: 01/01/2001");
        document.getElementById('datainiform').focus();
        erro = 1;
    } else if (datafim.length <= 9)
    {
        alert("Preencha o campo data corretamente!\nEx: 01/01/2001");
        document.getElementById('datafimform').focus();
        erro = 1;
    }


    if (forn1 == true)
    {
        if (consultafornecedor == "")
        {
            alert("Escolha um Fornecedor!!");
            document.getElementById('consultafornecedor').focus();
            erro = 1;
        }
    }


    if (forn0 == true)
        fornecedor = "";

    if (erro == '0')
        load_grid(dataini, datafim, fornecedor);
}

function formata_data(obj)
{
    obj.value = obj.value.replace("//", "/");
    tam = obj.value;

    if (tam.length == 2 || tam.length == 5)
        obj.value = obj.value + "/";
}

function pulacampo(obj)
{
    var tam = obj.value;
    if (tam.length == 10)
        document.getElementById('datafimform').focus();
}

function desabilitarform(campo)
{
    if (campo == '0')
    {
        document.getElementById("opcao1").disabled = true;
        document.getElementById("opcao2").disabled = true;
        document.getElementById("opcao3").disabled = true;
        document.getElementById('consultafornecedor').disabled = true;
        document.getElementById('pesquisar').disabled = true;
        document.getElementById('pesquisafornecedor').disabled = true;
        document.getElementById('fornecedor').disabled = true;
    } else
    {
        document.getElementById("opcao1").disabled = false;
        document.getElementById("opcao2").disabled = false;
        document.getElementById("opcao3").disabled = false;
        document.getElementById('consultafornecedor').disabled = false;
        document.getElementById('pesquisar').disabled = false;
    }
}

function setarfornecedor(objfornecedor)
{
    document.getElementById('fornecedor').value = objfornecedor.value;
}