function pesquisaFornecedor(){
    var pesquisa = $("pesquisaForn").value;
    var forma = "";
//radioforn1
     if ( document.getElementById("radioforn1").checked==true){
       forma=1;
    }
    else if ( document.getElementById("radioforn2").checked==true){
       forma=2;
    }
    else if ( document.getElementById("radioforn3").checked==true){
       forma=3;
    }
    else if ( document.getElementById("radioforn4").checked==true){
       forma=4;
    }
    else{
       forma=5;
    }

    var formaPesquisa = forma;
    var option = "";

    if(pesquisa){
    $a.post('consultafornecedorromaneio.php',
   				{
   				//variaveis a ser enviadas metodo POST
   				pesquisa:pesquisa,
   				forma:forma
   				},
   				function(data)
   				{

                                    if (data.fornecedores && data.fornecedores.length > 0)
   					{
                                            var fornecedores = data.fornecedores;
                                            $a.each(fornecedores, function (key, value) {
                                                  option += "<option value='"+value.forcod+"'>"+value.fornguerra+"</option>";
                                             });
//alert("option: "+option);
                                             $a("#opcoesForn").html(option);
                                        } else {
                                            alert("Fornecedor Não Localizado");
                                        }

                                }, "json");
        }
}