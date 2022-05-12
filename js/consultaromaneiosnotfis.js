function imprimirrelatorioexcel()
{
    var dataini = document.getElementById("dataini").value;
    var datafim = document.getElementById("datafim").value;
    var usuario = document.getElementById("usuario").value;

    var erro = 0;
    if (dataini.length <= 9)
    {
        alert("Preencha o campo data corretamente!\nEx: 01/01/2020");
        document.getElementById('dataini').focus();
        erro = 1;
    } else if (datafim.length <= 9)
    {
        alert("Preencha o campo data corretamente!\nEx: 01/01/2020");
        document.getElementById('datafim').focus();
        erro = 1;
    }

    if (erro == '0')
        window.open('geranotfisdatas.php?dataini=' + dataini + '&datafim=' + datafim + '&usuario=' + usuario, '_blank');
}


function formata_data(obj)
{
    obj.value = obj.value.replace("//", "/");
    tam = obj.value;

    if (tam.length == 2 || tam.length == 5)
        obj.value = obj.value + "/";
}
