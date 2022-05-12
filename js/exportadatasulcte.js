function imprimirconsulta()
{

    var datainicio = '0';
    var datafinal = '0';
    var modelo = '0';

    if (document.getElementById("radiox1").checked == true)
    {
        modelo = 1;
    } else
    {
        modelo = 2;
    }
    
    var chk0 = 0;
    if (document.getElementById("chkaut").checked == true) {
        chk0 = 1;
    }

    var chk1 = 0;
    if (document.getElementById("chkcanc").checked == true) {
        chk1 = 1;
    }
    
    var chk2 = 0;
    if (document.getElementById("chkinut").checked == true) {
        chk2 = 1;
    }

    var erro = 0;

    datainicio = document.getElementById("datainiciox").value;
    datafinal = document.getElementById("datafinalx").value;

    if (datainicio.length <= 9)
    {
        alert("Preencha o campo data corretamente!\nEx: 01/01/2017");
        document.getElementById('datainicio').focus();
        erro = 1;
    }
    else if (datafinal.length <= 9)
    {
        alert("Preencha o campo data corretamente!\nEx: 01/01/2017");
        document.getElementById('datafinal').focus();
        erro = 1;
    }
    else if (chk0 == 0 && chk1 == 0 && chk2 == 0)
    {
        alert("Escolha pelo menos um tipo de CT-e");        
        erro = 1;
    }
    

    if (erro == '0')
    {
        window.open('exportageradatasulcte.php?dataini=' + datainicio + '&datafim=' + datafinal + '&modelo=' + modelo + '&autorizados=' + chk0 + '&cancelados=' + chk1 + '&inutilizados=' + chk2, '_self');
    }
}

function formata_data(obj)
{
    obj.value = obj.value.replace("//", "/");
    tam = obj.value;

    if (tam.length == 2 || tam.length == 5)
        obj.value = obj.value + "/";
}


function formata_data2(documento, data)
{
    var ano = parseInt(data.substring(6, 10), 10);
    var mydate = new Date();
    var year = mydate.getFullYear();

    if (validar_data(data.substring(0, 5) + '/' + year))
    {
        if (isNaN(ano) == false)
        {
            if (ano < 2000)
            {
                if (ano > 1899)
                {
                    documento.value = data.substring(0, 5) + '/' + ano;
                } else
                {
                    ano = ano + 2000;
                    documento.value = data.substring(0, 6) + ano;
                }
            }
        } else
        {
            documento.value = data.substring(0, 5) + '/' + year;
        }
    }
}